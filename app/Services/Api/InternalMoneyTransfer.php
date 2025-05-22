<?php 
namespace App\Services\Api;

use App\Services\Api\Traits\AuthTrait;

class InternalMoneyTransfer
{
	
	use AuthTrait;
	public const ODOO_SUSPENSE_ACCOUNT_ID = 101;
	
	 public function processOutboundPayment(string $date,int $outJournalId,float $amount,int $odooCurrencyId)
    {
        // try {
            // Create payment
            $paymentId = $this->createOutboundPayment($date, $outJournalId, $amount, $odooCurrencyId);

            // Example: Update payment if needed
            $updateData = [
                // Add any fields that need updating, e.g.:
                // 'amount' => 2500,
                // 'date' => '2025-05-22',
            ];

            if (!empty($updateData)) {
                $this->setPaymentToDraft($paymentId);
                $this->updatePayment($paymentId, $updateData);
            }

            // Post payment
            $this->postPayment($paymentId);

            // Assuming MoneyModel is your Laravel model
            // MoneyModel::update(['odoo_id' => $paymentId]);
			return $paymentId;
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Payment registered and posted successfully',
            //     'payment_id' => $paymentId
            // ]);
        // } catch (Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Payment processing failed: ' . $e->getMessage()
        //     ], 500);
        // }
    }
	
	public function processInboundPayment(string $date , int $inboundJournalId , float $amount ,int $odooCurrencyId)
    {
            // Create payment
            $paymentId = $this->createInboundPayment($date , $inboundJournalId , $amount , $odooCurrencyId);

            // Example: Update payment if needed
            $updateData = [
                // Add any fields that need updating, e.g.:
                // 'amount' => 2500,
                // 'date' => '2025-05-22',
            ];

            if (!empty($updateData)) {
                $this->setPaymentToDraft($paymentId);
                $this->updatePayment($paymentId, $updateData);
            }

            // Post payment
            $this->postPayment($paymentId);

            // Assuming MoneyModel is your Laravel model
            // MoneyModel::update(['odoo_id' => $paymentId]);
			return $paymentId;
            
        
    }
	public function cancelMoneyTransferPayment(int $paymentId)
    {
        return $this->cancelPayment($paymentId);
    }
	
     protected function createOutboundPayment(string $date,int $outJournalId,float $amount,int $odooCurrencyId)
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
                    'journal_id' => $outJournalId,
                    'date' => $date,
                    'currency_id' => $odooCurrencyId,
                    'destination_account_id' => SELF::ODOO_SUSPENSE_ACCOUNT_ID,
                    'payment_type' => 'outbound',
                    'payment_method_id' => 1
                ]],
                ['context' => $context]
            );
            return $paymentId;

      
    }

    protected function setPaymentToDraft($paymentId)
    {
           $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'action_post',
                [[$paymentId]],
            );
        
            return true;
      
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

    protected function cancelPayment(int $paymentId):void
    {
            $this->execute(
                'account.payment',
                'action_cancel',
                [[$paymentId]]
            );
         
    }

    
	protected function createInboundPayment(string $date,int $inJournalId ,float $amount,int $odooCurrencyId)
    {
		// suspense account id from odoo 
	

  
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
                    'journal_id' =>$inJournalId,
                    'date' => $date,
                    'currency_id' => $odooCurrencyId,
                    'destination_account_id' => self::ODOO_SUSPENSE_ACCOUNT_ID,
                    'payment_type' => 'inbound',
                    'payment_method_id' => 1
                ]],
                ['context' => $context]
            );



            return $paymentId;

        
    }

   



    
	
}
?>
