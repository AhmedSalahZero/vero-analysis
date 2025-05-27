<?php
namespace App\Services\Api;

use App\Models\Currency;
use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasPayment;

class OdooPayment
{
	use AuthTrait,HasPayment ;
	public function getChartOfAccountId($moneyModel):int 
	{
		$isCashInSafeOrCashPayment = $moneyModel->isCash();
		return $isCashInSafeOrCashPayment  ? $moneyModel->getCashBranchOdooId() : $moneyModel->getBankAccountOdooId();
	}
	public function getJournalId($moneyModel):int 
	{
		$isCashInSafeOrCashPayment = $moneyModel->isCash();
		return $isCashInSafeOrCashPayment  ? $moneyModel->getCashBranchJournalId() : $moneyModel->getBankAccountJournalId();
	}
	public function createDownPayment($moneyModel )
    {
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
				'odoo_id'=>$paymentId
			]);

            return response()->json(['success' => 'Payment registered and reconciled successfully']);
       
    }
    
	 public function createPayment($customerInvoiceSettlement )
    {
			$invoice = $customerInvoiceSettlement->invoice;
			$moneyModel = $customerInvoiceSettlement->getMoney();
	//		$chartOfAccountId = $this->getChartOfAccountId($moneyModel);
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
			
			$customerInvoiceSettlement->update([
				'odoo_id'=>$paymentResult['res_id']
			]);

            return response()->json(['success' => 'Payment registered and reconciled successfully']);

       
    }
	
	public function reCreatePayment($customerInvoiceSettlement)
    {
		if($customerInvoiceSettlement->odoo_id){
			$this->cancelPayments($customerInvoiceSettlement->odoo_id);
		}
		$this->createPayment($customerInvoiceSettlement);

    }
	
	
}
