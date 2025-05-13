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

    public function createPayment($customerInvoiceSettlement )
    {
		
			//		$settlementId = $customerInvoiceSettlement->id;
	//		$paymentType='customer';
	$invoice = $customerInvoiceSettlement->invoice;
	$moneyModel = $customerInvoiceSettlement->getMoney;
//		$isBankMoney = $moneyModel->isIncomingTransfer() || $moneyModel->isCashInBank() ;
	$isCashInSafe = $moneyModel->isCashInSafe();
// if(){
	$bankOrSafeId = $isCashInSafe  ? $moneyModel->getCashInSafeBranchOddoId() : $moneyModel->getBankAccountOdooId();
	$invoiceId = $invoice->getOdooId();
	$paymentAmount = $customerInvoiceSettlement->getAmount();
	$currencyName = $moneyModel->getReceivingOrPaymentCurrency();
	$odooCurrencyId = DB::table('currencies')->where('name',$currencyName)->first()->oddo_id;
	$paymentDate = $moneyModel->getReceivingOrPaymentMoneyDate();
	$odooPartnerId = $moneyModel->partner->getOdooId();
	$invoiceNumber = $invoice->getInvoiceNumber();
	// $moneyType = $moneyModel->getType();
	$journalId = $bankOrSafeId;
	$inBoundOrOutBound ='inbound';
	
       
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
                    'amount' => $paymentAmount,
                    'journal_id' => $journalId,
                    'payment_date' => $paymentDate,
                    'communication' => $invoiceNumber,
					'currency_id'=>$odooCurrencyId,
                    'partner_id' => $odooPartnerId,
                    'payment_type' => $inBoundOrOutBound,
                    'partner_type' => $inBoundOrOutBound=='inbound'?'customer':'supplier' ,
                ]],
                ['context' => $context]
            );
			
			
            // if (!$paymentWizardId) {
            //     Log::error("Failed to create payment wizard for invoice {$invoiceNumber}");
            //     return response()->json(['error' => 'Failed to create payment wizard'], 500);
            // }
			
			// $paymentStatus = $this->models->execute_kw(
			// 	$this->db,
			// 	$this->uid,
			// 	$this->password,
			// 	'account.move',
			// 	'read',
			// 	[[$invoiceId]],
			// 	['fields' => ['amount_residual', 'payment_state', 'state']]
			// );
			// dd();
			// if(!isset($paymentResult['res_id'])){
			// 	dd($paymentStatus);
			// }
			
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


            // Step 4: Find the created payment (optional, for logging)
            // $payments = $this->models->execute_kw(
            //     $this->db,
            //     $this->uid,
            //     $this->password,
            //     'account.payment',
            //     'search_read',
            //     [[
            //         ['ref', '=', "Payment for invoice {$invoiceNumber}"],
            //         ['partner_id', '=', $odooPartnerId],
            //         ['state', '=', 'posted'],
            //     ]],
            //     ['fields' => ['id', 'amount', 'journal_id']]
            // );
			// dd($payments);
		// dd($payments);
        //     if (!empty($payments)) {
        //         Log::info("Payment found", ['payment' => $payments[0]]);
        //     } else {
        //         Log::warning("Payment not found after creation, checking invoice state anyway");
        //     }

            // Step 5: Verify reconciliation
            // $invoiceAfter = $this->models->execute_kw(
            //     $this->db,
            //     $this->uid,
            //     $this->password,
            //     'account.move',
            //     'read',
            //     [[$invoiceId]],
            //     ['fields' => ['payment_state', 'amount_residual', 'line_ids']]
            // );
			
            // if ($invoiceAfter[0]['payment_state'] !== 'paid' || $invoiceAfter[0]['amount_residual'] != 0) {
                // Log::error("Reconciliation failed", [
                //     'invoice_id' => $invoiceId,
                //     'payment_state' => $invoiceAfter[0]['payment_state'],
                //     'amount_residual' => $invoiceAfter[0]['amount_residual'],
                // ]);

                // Debug journal items
                // $journalItems = $this->models->execute_kw(
                //     $this->db,
                //     $this->uid,
                //     $this->password,
                //     'account.move.line',
                //     'search_read',
                //     [[['move_id', '=', $invoiceId]]],
                //     ['fields' => ['id', 'account_id', 'balance', 'reconciled', 'partner_id']]
                // );

                // Log::info("Invoice journal items", ['items' => $journalItems]);

                // if (!empty($payments)) {
                //     $paymentItems = $this->models->execute_kw(
                //         $this->db,
                //         $this->uid,
                //         $this->password,
                //         'account.move.line',
                //         'search_read',
                //         [[['payment_id', '=', $payments[0]['id']]]],
                //         ['fields' => ['id', 'account_id', 'balance', 'reconciled', 'partner_id']]
                //     );
                //     Log::info("Payment journal items", ['items' => $paymentItems]);
                // }

                // return response()->json(['error' => 'Reconciliation failed, invoice not marked as paid'], 500);
            // }

            // Log::info("Payment registered and reconciled successfully for invoice {$invoiceNumber}");

            return response()->json(['success' => 'Payment registered and reconciled successfully']);

       
    }
	public function reCreatePayment($customerInvoiceSettlement)
    {
	
	
		
		if($customerInvoiceSettlement->odoo_id){
			$this->cancelPayments($customerInvoiceSettlement->odoo_id);
		}
		$this->createPayment($customerInvoiceSettlement,$invoiceId, $paymentAmount, $odooCurrencyId,$paymentDate, $odooPartnerId, $invoiceNumber, $journalId, $inBoundOrOutBound);

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
