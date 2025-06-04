<?php
namespace App\Services\Api;

use App\Models\Currency;
use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasJournal;
use App\Services\Api\Traits\HasPayment;

class OdooPayment
{
	use AuthTrait,HasPayment,HasJournal ;
	
	
	public function createDownPayment($moneyModel )
    {
		try{
			
		//	$chartOfAccountId = $this->getChartOfAccountId($moneyModel);
			$journalId = $this->getJournalId($moneyModel) ;
			/**
			 * * $bankOrSafeId
			 */
			$paymentAmount = $moneyModel->isInvoiceSettlementWithDownPayment() ? $moneyModel->downPaymentSettlements->sum('down_payment_amount') : $moneyModel->getAmount()  ;
			$currencyName = $moneyModel->getReceivingOrPaymentCurrency();
			$odooCurrencyId = Currency::getOdooId($currencyName);
			$paymentDate = $moneyModel->getReceivingOrPaymentMoneyDate();
			$odooPartnerId = $moneyModel->partner->getOdooId();
			$inBoundOrOutBound =$moneyModel->getInboundOrOutbound();
			$customerOrSupplier = $moneyModel->getCustomerOrSupplier();
	
       
            // Step 2: Register payment using account.payment.register
            $context = [
                'active_model' => 'account.move',
           		'active_ids' => [],
            ];

            $paymentId = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'create',
                [[
                    'amount' => $paymentAmount,
                    'journal_id' => $journalId,
                    'date' => $paymentDate,
					'currency_id'=>$odooCurrencyId,
                    'partner_id' => $odooPartnerId,
                    'payment_type' => $inBoundOrOutBound,
                    'partner_type' => $customerOrSupplier ,
					'payment_method_id'=>1 
                ]],
               ['context' => $context]
            );

			
             $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'action_post',
               	[[$paymentId]],
            );
		
			$moneyModel->update([
				'odoo_id'=>$paymentId,
				'synced_with_odoo'=>true ,
				'odoo_error_message'=>null
			]);
		}
		catch(\Exception $e){
			session()->put('fail',__('Error While Connecting With Odoo : ' . $e->getMessage()));
			$moneyModel->update([
				'synced_with_odoo'=>false ,
				'odoo_error_message'=>$e->getMessage() 
			]);
		}
		

         
    }
    
	 public function createPayment($customerInvoiceSettlement )
    {
		try{
			$invoice = $customerInvoiceSettlement->invoice;
			$moneyModel = $customerInvoiceSettlement->getMoney();
			$journalId = $this->getJournalId($moneyModel) ;
			/**
			 * * $bankOrSafeId
			 */
			$invoiceId = $invoice->getOdooId();
			$amountInInReceivingCurrency = $customerInvoiceSettlement->getAmountInReceivingCurrency();
			$receivingCurrencyName = $moneyModel->getReceivingOrPaymentCurrency();
			$odooReceivingCurrencyId =  Currency::getOdooId($receivingCurrencyName) ;
			$paymentDate = $moneyModel->getReceivingOrPaymentMoneyDate();
			$odooPartnerId = $moneyModel->partner->getOdooId();
			$invoiceNumber = $invoice->getInvoiceNumber();
			$inBoundOrOutBound =$moneyModel->getInboundOrOutbound();
			$customerOrSupplier = $moneyModel->getCustomerOrSupplier();
	
       
            // Step 2: Register payment using account.payment.register
            $context = [
                'active_model' => 'account.move',
                'active_ids' => [$invoiceId],
            ];

            $paymentWizardId = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment.register',
                'create',
                [[
                    'amount' => $amountInInReceivingCurrency,
		   			 'currency_id'=>$odooReceivingCurrencyId,
                    'journal_id' => $journalId,
                    'payment_date' => $paymentDate,
                    'communication' => $invoiceNumber,
                    'partner_id' => $odooPartnerId,
                    'payment_type' => $inBoundOrOutBound,
                    'partner_type' => $customerOrSupplier ,
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
			$resId = $paymentResult['res_id'];
			if(is_numeric($resId)){
				$moneyModel->update([
				'synced_with_odoo'=>true ,
				'odoo_error_message'=>null
			]);
			return [
				'odoo_id'=>$resId
			];
			
			}
			
			
		}
		catch(\Exception $e){
			session()->put('fail',__('Error While Connecting With Odoo : ' . $e->getMessage()));
			$moneyModel->update([
				'synced_with_odoo'=>false ,
				'odoo_error_message'=>$e->getMessage() 
			]);
		}
			

       
    }
	
	public function reCreatePayment($customerInvoiceSettlement)
    {
		if($customerInvoiceSettlement->odoo_id){
			$this->cancelPayments($customerInvoiceSettlement->odoo_id);
		}
		$this->createPayment($customerInvoiceSettlement);

    }
	
	public function reCreateDownPayment($moneyModel)
    {
		if($moneyModel->odoo_id){
			$this->cancelPayments($moneyModel->odoo_id);
		}
		$this->createDownPayment($moneyModel);

    }
}
