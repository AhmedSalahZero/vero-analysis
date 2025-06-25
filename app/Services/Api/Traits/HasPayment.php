<?php 
namespace App\Services\Api\Traits;

use App\OdooSetting;
use Exception;

trait HasPayment 
{

	/**
	 * * $inBoundOrOutBound [inbound , outbound]
	 */
	 public function createPayment(string $inBoundOrOutBound,int $inOrOutJournalId,string $date,float $amount,int $odooCurrencyId)
    {
        
            // Create payment in draft state
            $context = [
                'active_model' => 'account.move',
                'active_ids' => [],
            ];

            $paymentId = $this->execute(
                'account.payment',
                'create',
                [[
                    'amount' => abs($amount), // Ensure positive amount
                    'journal_id' => $inOrOutJournalId,
                    'date' => $date,
                    'currency_id' => $odooCurrencyId,
                    'destination_account_id' => OdooSetting::getSuspenseAccountId() ,
                    'payment_type' => $inBoundOrOutBound,
                    'payment_method_id' => 1
                ]],
                ['context' => $context]
            );
            return $paymentId;

      
    }
	 protected function postPayment($paymentId):void
    {
            $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'action_post',
                [[$paymentId]],
            );
       
    }
		


	 protected function updatePayment($paymentId, $updateData)
    {
            $this->execute(
                'account.payment',
                'write',
                [[$paymentId], $updateData]
            );
            return true;
     
    }
	public function cancelPayments(int $paymentOdooId)
	{
		$filters = [
				['id','=',$paymentOdooId]
		];
		$payments = $this->models->execute_kw(
			$this->db,
			$this->uid,
			$this->password,
			'account.payment',
			'search_read',
			[$filters],
		);
		/**
		 * * مش بكون عارف هي انهي مدفوعه بالظبط .. فا بلغيهم كلهم
		 */
		foreach($payments as $existingPayment){
			$odooPaymentId = $existingPayment['id'] ;
			$this->setPaymentToDraft($odooPaymentId);
			// $this->models->execute_kw(
			// 	$this->db,
			// 	$this->uid,
			// 	$this->password,
			// 	'account.payment',
			// 	'action_cancel',
			// 	[[$odooPaymentId]]
			// );
			   $this->execute(
                'account.payment',
                'unlink',
                [[$odooPaymentId]]
            );
			
			// $this->models->execute_kw(
			// 	$this->db,
			// 	$this->uid,
			// 	$this->password,
			// 	'account.payment',
			// 	'unlink',
			// 	[[$odooPaymentId]]
			// );
			
		}
	}
	
	public function cancelDownPayment(int $downPaymentOdooId)
	{
		return $this->cancelPayments($downPaymentOdooId);
	}
	
	

	public function setPaymentToDraft(int $paymentId)
    { 
        // Check if the payment exists
        $entry = $this->execute(
            'account.payment',
            'read',
            [[$paymentId], ['id', 'state']]
        );

        if (empty($entry)) {
            throw new Exception("Payment not found: " . $paymentId);
        }
        if ($entry[0]['state'] === 'draft') {
    //        Log::info("Payment $paymentId is already in draft state");
            return true;
        }
        
        // Set the account.payment to draft
         $this->execute(
            'account.payment',
            'action_draft',
            [[$paymentId]]
        );
    }
	
	public function updateMoneyReceiveOrMoneyPayment(bool $isCustomer , int $odooPaymentId,int $odooInvoiceId,string $paymentDate,string $invoiceNumber,int $journalId,int $odooPartnerId,int $paymentMethodLineId , float $amountInInReceivingCurrency , int $odooReceivingCurrencyId )
    {
		$paymentId = $odooPaymentId;
        // $paymentId = 156;
        // $journalId = 243;
        // $paymentMethodLineId = 363;
        // $odooInvoiceId = 9734;
        // $amountInInReceivingCurrency = 80080;
        // $odooReceivingCurrencyId = 74;
        // $paymentDate = '2025-06-11';
        // $odooPartnerId = 27;
        // $invoiceNumber = 'INV/2025/00001';
        $inBoundOrOutBound = $isCustomer ? 'inbound' : 'outbound' ;
        $customerOrSupplier = $isCustomer ? 'customer' : 'supplier';


     // Step 1: Set the payment to draft, this unlink payment to invoice id, where invoice state is 'not paid'
  
    $this->setPaymentToDraft($paymentId);

 

   // Step 2: Delete the payment - In This case the serial of the payment is not deleted it is preserved
        try {
            $postResult = $this->execute(
                'account.payment',
                'unlink',
                [[$paymentId]]
            );

            if ($postResult !== true) {
                throw new Exception("Failed to delete  payment: " . json_encode($postResult));
            }
        } catch (\Exception $e) {
 //           Log::error("Failed to delete payment", ['paymentId' => $paymentId, 'error' => $e->getMessage()]);
            throw $e;
        }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////


      
    // Step 3: create payment again this will generate new payment id

         $context = [
                'active_model' => 'account.move',
                'active_ids' => [$odooInvoiceId],
            ];

         $paymentWizardId = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment.register',
                'create',
                [[
                    'journal_id' => $journalId,
                    'amount' => $amountInInReceivingCurrency,
                    'currency_id'=>$odooReceivingCurrencyId,
                    'payment_date' => $paymentDate,
                    'communication' => $invoiceNumber,
                    'partner_id' => $odooPartnerId,
                    'payment_type' => $inBoundOrOutBound,
                    'partner_type' => $customerOrSupplier ,
                    'payment_method_line_id' => $paymentMethodLineId

                ]],
                ['context' => $context]
            );
            
           

            $paymentResult = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment.register',
                'action_create_payments',
                [[$paymentWizardId]],
                ['context' => $context]
            );
           
       
            return [
            'odoo_id'=>$paymentResult['res_id'],
            
             ];


}

	
	
}
