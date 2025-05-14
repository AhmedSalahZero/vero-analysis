<?php
namespace App\Services\Api;


use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use ripcord;

class OddoPayment
{
	protected string $url ;
	protected String $db;
	protected string $username;
	protected string $password ; 
	protected \Ripcord_Client $models;
	protected ?int $uid;
	protected int $company_id;

    public function __construct($url , $db , $userName , $password,$companyId)
    {
		$this->url = $url;
		$this->db = $db;
		$this->username =$userName;
		$this->password = $password;
		$this->company_id = $companyId ;
		require_once(public_path('apis/ripcord.php'));
		$common = ripcord::client("$this->url/xmlrpc/2/common");
		$uid = null ;
		try{
			$uid = $common->authenticate($this->db, $this->username, $this->password, array());
		}
		catch(\Exception $e){
			$uid = null;
		}
		$models = ripcord::client("$this->url/xmlrpc/2/object");
		$this->models = $models;
		$this->uid = $uid;
    }
	public function getJournalId($moneyModel):int 
	{
		$isCashInSafe = $moneyModel->isCashInSafe();
		return $isCashInSafe  ? $moneyModel->getCashInSafeBranchOddoId() : $moneyModel->getBankAccountOdooId();
	}

	public function createDownPayment($moneyModel )
    {
			$journalId = $this->getJournalId($moneyModel);
			/**
			 * * $bankOrSafeId
			 */
			$paymentAmount = $moneyModel->isInvoiceSettlementWithDownPayment() ? $moneyModel->downPaymentSettlements->sum('down_payment_amount') : $moneyModel->getAmount()  ;
			$currencyName = $moneyModel->getReceivingOrPaymentCurrency();
			$odooCurrencyId = DB::table('currencies')->where('name',$currencyName)->first()->oddo_id;
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
	public function cancelDownPayment(int $downPaymentOdooId)
	{
		return $this->cancelPayments($downPaymentOdooId);
	}
    public function createPayment($customerInvoiceSettlement )
    {
			$invoice = $customerInvoiceSettlement->invoice;
			$moneyModel = $customerInvoiceSettlement->getMoney;
			$journalId = $this->getJournalId($moneyModel);
			/**
			 * * $bankOrSafeId
			 */
			$invoiceId = $invoice->getOdooId();
			$settlementAmountInInvoiceCurrency = $customerInvoiceSettlement->getAmount();
			$amountInInReceivingCurrency = $customerInvoiceSettlement->getAmountInReceivingCurrency();
			$currencyName = $moneyModel->getInvoiceCurrency();
			$odooCurrencyId = DB::table('currencies')->where('name',$currencyName)->first()->oddo_id;
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
                    'amount' => $settlementAmountInInvoiceCurrency,
					'source_amount_currency'=>$amountInInReceivingCurrency,
                    'journal_id' => $journalId,
                    'payment_date' => $paymentDate,
                    'communication' => $invoiceNumber,
					'currency_id'=>$odooCurrencyId,
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
			// dd($paymentResult);
			if(!isset($paymentResult['res_id'])){
				dd($paymentResult);
			}
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
			$this->models->execute_kw(
				$this->db,
				$this->uid,
				$this->password,
				'account.payment',
				'action_cancel',
				[[$existingPayment['id']]]
			);
			
			$this->models->execute_kw(
				$this->db,
				$this->uid,
				$this->password,
				'account.payment',
				'unlink',
				[[$existingPayment['id']]]
			);
			
		}
	}
	
}
