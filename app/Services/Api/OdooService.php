<?php
namespace App\Services\Api;

use App\Http\Controllers\MoneyReceivedController;
use App\Http\Requests\StoreMoneyReceivedRequest;
use App\Models\CashVeroBranch;
use App\Models\Contract;
use App\Models\Currency;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitutionAccount;
use App\Models\MoneyReceived;
use App\Models\Partner;
use App\Models\SalesOrder;
use App\Models\SupplierInvoice;
use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\CommonHelper;
use App\Services\Api\Traits\HasUnlink;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OdooService
{
	use AuthTrait , CommonHelper,HasUnlink;
	/**
	 * * import project or contracts
	 */
	public function startImportContracts(string $startDate, string $endDate,int $companyId)
	{
		if(is_null($this->uid)){
			return ;
		}
		$this->getContracts($startDate,$endDate,$companyId);
	}
	/**
	 * * 
	 */
	public function createPaymentFromOdooToInvoice(int $odooInvoiceId,int $invoiceId,int $partnerId,$invoiceCurrencyName,$newMoneyClass )
	{
		/**
		 * @var MoneyReceived|MoneyPayment $newMoneyClass [new MoneyReceived empty class]
		 */
		$isMoneyReceived = $newMoneyClass instanceof MoneyReceived;
		$settlementTableName = $isMoneyReceived ? 'settlements' : 'payment_settlements';
		$inboundOrOutbound = $isMoneyReceived ? 'inbound' : 'outbound';
		$isCustomerOrSupplier = $isMoneyReceived ? 'customer' : 'supplier';
		$partnerType = $isMoneyReceived ? 'is_customer' : 'is_supplier';
		$customerOrSupplierId = $isMoneyReceived ? 'customer_id' : 'supplier_id';
		$moneyModel = $isMoneyReceived ? 'App\Models\MoneyReceived': 'App\Models\MoneyPayment';
		$receivingDate = $isMoneyReceived ? 'receiving_date' : 'delivery_date';
		$branchIdColumnName = $isMoneyReceived ? 'receiving_branch_id' : 'delivery_branch_id';
		$amountColumnName = $isMoneyReceived ? 'received_amount' : 'paid_amount';
		$bankColumnName = $isMoneyReceived ? 'receiving_bank_id' : 'delivery_bank_id';
		$receivingOrDeliveryCurrencyName = $isMoneyReceived ? 'receiving_currency' : 'payment_currency';
		$moneyModel = new $moneyModel;
		$dataFormatted = [];
		// foreach(['EGP','USD'] as $currencyName){
			
		$currencyOdooId = Currency::getOdooId($invoiceCurrencyName);
		$payments = $this->fetchData('account.payment',[],[[['invoice_ids','=',$odooInvoiceId],['currency_id','=',$currencyOdooId],['payment_type','=',$inboundOrOutbound],['partner_type','=',$isCustomerOrSupplier]]]);
		
				
				foreach($payments as $paymentArr){
					$paymentOdooId = $paymentArr['id'];
					$isExist = DB::table($settlementTableName)->where('company_id',$this->company_id)->where('odoo_id',$paymentOdooId)->first();
					if($isExist){
						continue ;
					}
					$journalId = $paymentArr['journal_id'][0];
					$date =$paymentArr['date'] ;
					$currentJournal = $newMoneyClass::getMoneyTypeFromJournalId($journalId,$this->company_id);
					$moneyType = $currentJournal['type'];
					$branchId = $currentJournal['branch_id']??null;
					$financialInstitutionId = $currentJournal['financial_institution_id']??null;
					$amount  = $paymentArr['amount'];
					$receiptNumber = generateReceiptNumber('receipt_number_');
					$dataFormatted[$moneyType][$date]=[
						'stop-sync-with-odoo'=> true ,
						'partner_type'=>$partnerType,
						'currency'=>$invoiceCurrencyName,
						$receivingOrDeliveryCurrencyName=>$invoiceCurrencyName,
						$customerOrSupplierId=>$partnerId,
						'type'=>$moneyType,
						$receivingDate=>$date,
						$branchIdColumnName=>$branchId,
						$amountColumnName => [
							$moneyType=>$amount
						],
						'receipt_number'=>$receiptNumber,
						'exchange_rate'=>[$moneyType=>1] , // not found in the model dd
						'amount_in_invoice_currency'=>[
							$moneyType=>$amount 
						],
						$bankColumnName=>[
							$moneyType=>$financialInstitutionId 
						],
						'account_type'=>[
							$moneyType => $currentJournal['account_type_id']??null 
						],
						'account_number'=>[
							$moneyType=>$currentJournal['account_number']??null
						],
						'drawee_bank_id'=>null, // in case of cheque we have to fill it 
						'due_date'=>null, // in case of cheque we have to fill it  
						'cheque_number'=>null, // in case of cheque we have to fill it  
						'settlements'=>[
							$invoiceId => [
								'odoo_id'=>$paymentOdooId,
								'invoice_id'=>$invoiceId,
								'settlement_amount'=>$amount ,
								'withhold_amount'=>0 
							]
						]
					];
					
					
				}
				// }		
				foreach($dataFormatted as $moneyType => $date){
					foreach($date as $receivingDate => $moneyArr){
						(new MoneyReceivedController)->store($this->company,(new StoreMoneyReceivedRequest())->merge($moneyArr));
					}
				}
	
	}
	/**
	 * * import invoices
	 */
	public function startImportInvoices($startDate , $endDate,$companyId)
	{
	
			if(is_null($this->uid)  ){
			return ;
		}
		$this->getPartners($startDate,$endDate,$companyId);
		$this->getContracts($startDate,$endDate,$companyId);
		$invoices = $this->getInvoices($startDate,$endDate);
		$this->syncDeletedInvoices($companyId);
		foreach($invoices as $invoice){
		
			$odooInvoiceId = $invoice['id'];
			$invoiceDate = $invoice['invoice_date'];
			$invoiceDueDate = $invoice['invoice_date_due'];
			$soNumber = $invoice['invoice_origin']??null;
			$exchangeRate = 1/$invoice['invoice_currency_rate'];
			$vatAmount = $invoice['amount_tax'];
			$invoiceAmount = abs($invoice['amount_untaxed_in_currency_signed']);
			$collectedAmount =$invoiceAmount + $vatAmount  - $invoice['amount_residual'] ;
			$withholdAmount = 0 ;
			$invoiceNumber = $invoice['name'];
			$odooPartnerId = $invoice['partner_id'][0];
			$odooPartnerName = $invoice['partner_id'][1];
			$invoiceCurrency = $invoice['currency_id'][1];
			$isSupplier = $invoice['move_type'] == 'in_invoice';
			$isCustomer = $invoice['move_type'] == 'out_invoice';
			$partnerId = Partner::handlePartnerForOdoo($odooPartnerId ,$odooPartnerName,$isSupplier ,$isCustomer,false,$companyId  );
			// if($invoice['id'] == 9736){
			// 	dd($isCustomer,$isSupplier);
			// }
			if($isCustomer){
				$invoiceId =  CustomerInvoice::createForOdoo($odooInvoiceId,$partnerId,$odooPartnerName,$invoiceDate,$invoiceDueDate,$invoiceNumber,$invoiceCurrency,$invoiceAmount,$vatAmount,$withholdAmount,$collectedAmount,$exchangeRate,$soNumber,$companyId);
				$this->createPaymentFromOdooToInvoice($odooInvoiceId,$invoiceId,$partnerId,$invoiceCurrency,new MoneyReceived());
			}elseif($isSupplier){
				$invoiceId= SupplierInvoice::createForOdoo($odooInvoiceId,$partnerId,$odooPartnerName,$invoiceDate,$invoiceDueDate,$invoiceNumber,$invoiceCurrency,$invoiceAmount,$vatAmount,$withholdAmount,$collectedAmount,$exchangeRate,$soNumber,$companyId);
			}
			
	
		}
		
		
		
	}
	public function getContracts(string $startDate ,string $endDate,int $companyId)
	{
		$contractFilters = array(array(
			array('id', '>=', 0),
			array('write_date', '>=', $startDate),
			array('write_date', '<=', $endDate)
		));
		$contractIds=$this->models->execute_kw($this->db, $this->uid, $this->password, 'project.project', 'search',$contractFilters);
		$projects = $this->models->execute_kw($this->db, $this->uid, $this->password, 'project.project', 'read', array($contractIds),[
			'fields'=>[
				'id',
				'x_plan2_id',
				'name',
				'partner_id',
				'date_start', // start date
				'date', //end date
			]
		]);
		foreach($projects as $projectArr){
			$projectAmount = 0 ;
			$modelType = 'Customer';
			$currentProjectStartDate = isset($projectArr['date_start']) && $projectArr['date_start'] ? $projectArr['date_start'] :  now()->format('Y-m-d') ;
			$currentProjectEndDate = isset($projectArr['date']) && $projectArr['date'] ? $projectArr['date'] : now()->format('Y-m-d') ;
			$currentOdooProjectId = $projectArr['id'];
			$currentOdooCustomerId = $projectArr['partner_id'][0]??null ;
			if(is_null($currentOdooCustomerId)){
				continue;
			}
			$currentOdooCustomerName = $projectArr['partner_id'][1] ;
			$code = Contract::generateRandomContract($companyId,$currentOdooCustomerName,$startDate,$modelType);
			$partnerId = Partner::handlePartnerForOdoo($currentOdooCustomerId ,$currentOdooCustomerName,0, 1,false,$companyId  );
			$oldProject = Contract::where('odoo_id',$currentOdooProjectId)->first();
			$projectFormatted = [
				'odoo_id'=>$currentOdooProjectId,
				'code'=>$code,
				'x_plan2_id'=>$projectArr['x_plan2_id'][0]??null,
				'name'=>$projectArr['name'],
				'model_type'=>$modelType,
				'partner_id'=>$partnerId,
				'start_date'=>$currentProjectStartDate,
				'end_date'=>$currentProjectEndDate,
				'company_id'=>$companyId,
				'duration'=>Carbon::make($currentProjectEndDate)->diffInMonths($currentProjectStartDate)
			];
			if($oldProject){
				$projectFormatted['id'] = $oldProject->id;
			}
			$salesOrderFilters = array(array(
				['project_id','=',$currentOdooProjectId]
			));
				$salesOrderIds=$this->models->execute_kw($this->db, $this->uid, $this->password, 'sale.order', 'search',$salesOrderFilters
				// , array('limit' => 10)
			);
				$salesOrders = $this->models->execute_kw($this->db, $this->uid, $this->password, 'sale.order', 'read', array($salesOrderIds),[
					'fields'=>[
						'id',
						'display_name', // so_number
						'currency_id',
						'amount_total',
						'project_id'
					]
				]);
				$salesOrderFormatted = [];
				foreach($salesOrders as $orderIndex => $salesOrderArr){
					$projectFormatted['currency']=$salesOrderArr['currency_id'][1];
					$currentOrderIndex =$orderIndex+1;
					$currentSalesOrderId = $salesOrderArr['id'];
					$currentSalesOrderAmount = $salesOrderArr['amount_total'];
					$projectAmount += $currentSalesOrderAmount;
					
					$currentSalesOrderArr = [
						'odoo_id'=>$currentSalesOrderId,
						'so_number'=>$salesOrderArr['display_name'],
						// 'id'=>$currentSalesOrderId,
						'amount'=>$currentSalesOrderAmount,
						'execution_percentage_'.$currentOrderIndex=>100,
						'start_date_'.$currentOrderIndex=>$currentProjectStartDate,
						'end_date_'.$currentOrderIndex=>$currentProjectEndDate,
						'execution_days_'.$currentOrderIndex=>Carbon::make($currentProjectEndDate)->diffInMonths($currentProjectStartDate),
						'collection_days_'.$currentOrderIndex=>0,
						'company_id'=>$companyId
						
					] ;
					$oldSalesOrder = SalesOrder::where('odoo_id',$currentSalesOrderId)->first();
					if($oldSalesOrder){
						$currentSalesOrderArr['id'] = $oldSalesOrder->id;
					}
					$salesOrderFormatted[]=$currentSalesOrderArr;
				}
				$projectFormatted['amount'] = $projectAmount ;
				if(count($salesOrderFormatted)){
					$projectFormatted['salesOrders']=$salesOrderFormatted;
					$contract = $oldProject ? $oldProject : new Contract ;
					$request = (new Request())->merge($projectFormatted);
					$contract->storeBasicForm($request);
					
				}
				
		}

		
		
	}
	protected function getInvoices(string $startDate,string $endDate)
	{
		$fields= [
			'partner_id',
			'id',
			'invoice_date',
			'name',
			'move_type',
			'currency_id',
			'amount_residual',
			'amount_untaxed_in_currency_signed',
			'amount_tax',
			'invoice_date_due',
			'date',
			'invoice_currency_rate',//exchange rate
			'invoice_origin' ,// so_number
			'write_date',
			'state',
			'invoice_line_ids' // product ids 
		];
		$filters = array(array(array('move_type', 'in', ['in_invoice','out_invoice'])
		,array('state', '=', 'posted'),
			array('write_date', '>=', $startDate),
			array('write_date', '<=', $endDate)
			// ,['name','=','INV/2025/00004']
		));
		$invoices = $this->fetchData('account.move',$fields,$filters);
		return $invoices;
		// /**
		//  * * الكود اللي تحت دا بيجيب المنتجات
		//  */
		// $productIds = array_unique(Arr::flatten(array_column($invoices,'invoice_line_ids'))) ;
		// $filters = [[
		// 	['id','in',$productIds]
		// ]];
		// $fields = [
		// 	'name','display_name','product_id','quantity','price_unit','price_subtotal'
		// ];
		// return $invoices ;
		
		
	}
	protected function getUser(array $ids){
		 $user = $this->models->execute_kw($this->db, $this->uid, $this->password, 'res.partner', 'read', array($ids));
		 return $user;
	}
	
	
	// public function payInvoice(int $invoiceId, float $invoiceAmount , string $paymentDate , string $userComment  ,int $odooPartnerId)
	// {
	
	// 	$userId = $this->uid;
	// 	if(is_null($this->uid)){
	// 		return ;
	// 	}
		
	// 	$paymentData = [
	// 		'payment_type' => 'inbound',
	// 		'partner_type' => 'customer',
	// 		'partner_id' => $odooPartnerId, 
	// 		'journal_id' => (int) 7,
	// 		'amount' => (float) $invoiceAmount,
	// 		'date' => $paymentDate,
	// 		'payment_method_code' => "manual",
	// 		'payment_method_id' => (int) 1,
	// 		'payment_method_line_id' => (int) 4,
	// 		'memo' => $userComment ?: __('N/A'),
	// 		'invoice_ids' => [[6, 0, [(int) $invoiceId]]],
	// 	];


	// 	$response = Http::post("$this->url/jsonrpc", [
	// 		'jsonrpc' => '2.0',
	// 		'method' => 'call',
	// 		'params' => [
	// 			'service' => 'object',
	// 			'method' => 'execute_kw',
	// 			'args' => [
	// 				$this->db,
	// 				$userId,
	// 				$this->password,
	// 				'account.payment',
	// 				'create',
	// 				[$paymentData]
	// 			]
	// 		]
	// 	]);
	// 	$paymentId = json_decode($response->body())->result ;
	// 	$this->models->execute_kw(
	// 		$this->db,
	// 		$this->uid,
	// 		$this->password,
	// 		'account.payment',
	// 		'action_post', // Method to confirm payment
	// 		[[$paymentId]] // Array of payment IDs
	// 	);
		
	// 	$updatedInvoice = $this->models->execute_kw(
	// 		$this->db,
	// 		$this->uid,
	// 		$this->password,
	// 		'account.move',
	// 		'read',
	// 		[[$invoiceId]],
	// 		['fields' => ['payment_state']]
	// 	);
		
	// 	// Step 5: Fetch payment move lines to reconcile
		
	// 	$filter = array(array(
	// 			['payment_id', '=', $paymentId],
	// 			['account_id.type', '=', 'receivable']
	// 		));
	// 		$paymentIds=$this->models->execute_kw($this->db, $this->uid, $this->password, 'account.move.line', 'search',$filter );
	// 		$paymentLines = $this->models->execute_kw($this->db, $this->uid, $this->password, 'account.move.line', 'read', array($paymentIds),[
	// 			// 'fields'=>$fields
	// 		]);
		
	// 	$paymentLineId = $paymentLines[0]['id'];

	// 	// Step 6: Fetch invoice move lines to reconcile
	// 	$invoiceLines = $this->models->execute_kw(
	// 		$this->db,
	// 		$this->uid,
	// 		$this->password,
	// 		'account.move.line',
	// 		'search_read',
	// 		[['move_id', '=', $invoiceId], ['account_id.type', '=', 'receivable']],
	// 		['fields' => ['id']]
	// 	);

	// 	if (!$invoiceLines || empty($invoiceLines)) {
	// 		return response()->json(['error' => 'No receivable lines found for invoice'], 500);
	// 	}
	// 	$invoiceLineId = $invoiceLines[0]['id'];

	// 	// Step 7: Reconcile payment and invoice lines
	// 	$this->models->execute_kw(
	// 		$this->db,
	// 		$this->uid,
	// 		$this->password,
	// 		'account.move.line',
	// 		'reconcile',
	// 		[[$paymentLineId, $invoiceLineId]]
	// 	);

	// 	// Step 8: Verify invoice is paid
	// 	$updatedInvoice = $this->models->execute_kw(
	// 		$this->db,
	// 		$this->uid,
	// 		$this->password,
	// 		'account.move',
	// 		'read',
	// 		[[$invoiceId]],
	// 		['fields' => ['payment_state']]
	// 	);
		
		
	// 	if ($response->failed()) {
	// 		Log::error('Odoo request failed (payment create)', [
	// 			'status' => $response->status(),
	// 			'body' => $response->body(),
	// 		]);
	// 		return response()->json(['error' => 'Failed to create payment'], 500);
	// 	}

	// 	$paymentId = $response->json()['result'] ?? null;

	// 	if (!$paymentId) {
	// 		return response()->json(['error' => 'Failed to create payment'], 500);
	// 	}

	// 	$postPayment = Http::post("$this->odooUrl/jsonrpc", [
	// 		'jsonrpc' => '2.0',
	// 		'method' => 'call',
	// 		'params' => [
	// 			'service' => 'object',
	// 			'method' => 'execute_kw',
	// 			'args' => [
	// 				$this->odooDb,
	// 				$userId,
	// 				$this->odooPassword,
	// 				'account.payment',
	// 				'action_post',
	// 				[[$paymentId]] 
	// 			]
	// 		]
	// 	]);



	// 	if ($postPayment->failed()) {
	// 		return response()->json(['error' => 'Failed to post payment'], 500);
	// 	}
	// 	return response()->json([
	// 		'message' => 'Payment successful',
	// 		'payment_id' => $paymentId,
	// 	]);    
	// }


	public function syncDeletedInvoices(int $companyId)
	{
		$customerInvoices  = CustomerInvoice::where('company_id',$companyId)->where('odoo_id','>',0)->get();
		$supplierInvoices  = SupplierInvoice::where('company_id',$companyId)->where('odoo_id','>',0)->get();
		
		$startDate = now()->subDays(360)->format('Y-m-d');
		$endDate = now()->format('Y-m-d');
		$deletedIds= [];
		$odooInvoicesIds = array_column($this->getInvoices($startDate,$endDate),'id');
		foreach([$customerInvoices,$supplierInvoices] as $invoices){
			foreach($invoices as $invoice){
				$invoiceOdooId = $invoice->getOdooId();
				if(!in_array($invoiceOdooId,$odooInvoicesIds)){
					$deletedIds[] = [
						'id'=>$invoiceOdooId,
						'type'=>getModelNameWithoutNamespace($invoice)
					];
					$invoice->delete();
				}
			}
			
		}
	}
	public function chartOfAccount(string $chartOfAccountCode) 
	{
		$filters = [
				[
					['code','=',$chartOfAccountCode],
				]
		];
		return $this->fetchData('account.account',[],$filters)[0]??null;
	}
	public function syncChartOfAccountNumbers(string $chartOfAccountCode,int $companyId)
	{
			$fields = [
				// 'id'
			];
			
			$filters = [
				[
					// ['account_type','=','expense'],
					['code','=',$chartOfAccountCode],
				]
		];
		$odooExpenseItem = $this->fetchData('account.account',$fields,$filters)[0]??null;
		if($odooExpenseItem){
			DB::table('cash_expense_category_names')->where('company_id',$companyId)->where('odoo_chart_of_account_number',$chartOfAccountCode)->update([
				'odoo_id'=>$odooExpenseItem['id']
			]);
		}
		return $odooExpenseItem ;
	}
	public function syncFinancialInstitutions()
	{
		$odooSetting = $this->company->odooSetting;
	
			$fields = [
				'id',
				'code'
			];
			$filters = [
				[
					// ['type','=','bank'],
				]
		];
		$chartOfAccounts = $this->fetchData('account.account',$fields,$filters);
		
		$chartOfAccounts = collect($chartOfAccounts)->keyBy('code')->toArray();
			$financialInstitutionAccounts = FinancialInstitutionAccount::where('company_id',$this->company_id)->whereNotNull('odoo_code')->get();

			foreach($financialInstitutionAccounts as $financialInstitutionAccount){
				$codeCode = $financialInstitutionAccount->getOdooCode();
				if($codeCode){
					$currentJournal = $chartOfAccounts[$codeCode]??null;
					$chartOfAccountId = $currentJournal ? $currentJournal['id'] : null;
					if($chartOfAccountId){
						$journalId = $this->getJournalIdFromChartOfAccountId($chartOfAccountId) ;
						$odooInboundTransferPaymentMethodId = $this->getPaymentMethodId($journalId,$chartOfAccountId,'inbound');
						$odooOutboundTransferPaymentMethodId = $this->getPaymentMethodId($journalId,$chartOfAccountId,'outbound');
						$chequeReceivableId=$odooSetting ? $odooSetting->getChequesReceivableId() : null;
						$chequePayableId=$odooSetting ? $odooSetting->getChequesPayableId() : null;
						if($chequeReceivableId){
							$odooInboundChequePaymentMethodId = $this->getPaymentMethodId($journalId,$chequeReceivableId,'inbound');
						}
						if($chequePayableId){
							$odooOutboundChequePaymentMethodId = $this->getPaymentMethodId($journalId,$chequePayableId,'outbound');
						}
						
						
						$financialInstitutionAccount->update([
							'odoo_id'=>$chartOfAccountId,
							'journal_id'=>$journalId ,
							'odoo_inbound_transfer_payment_method_id'=>$odooInboundTransferPaymentMethodId??null ,
							'odoo_outbound_transfer_payment_method_id'=>$odooOutboundTransferPaymentMethodId??null,
							'odoo_inbound_cheque_payment_method_id'=>$odooInboundChequePaymentMethodId??null ,
							'odoo_outbound_cheque_payment_method_id'=>$odooOutboundChequePaymentMethodId??null,
						]);
					}
					
				}
			}
			
			
	
		
	}
	public function syncBranchSafe(string $odooCode,int $companyId)
	{
			$fields = [
				'id',
				'code'
			];
			$filters = [
				[
					// ['type','=','cash'],
					['code','=',$odooCode]
				]
		];
			$odooSetting = $this->company->odooSetting;
		$odooBranch = $this->fetchData('account.account',$fields,$filters)[0]??null;
		$chartOfAccountId= $odooBranch['id'];
		$journalId = $this->getJournalIdFromChartOfAccountId($chartOfAccountId);
		if($odooBranch){
			$odooInboundTransferPaymentMethodId = $this->getPaymentMethodId($journalId,$chartOfAccountId,'inbound');
						$odooOutboundTransferPaymentMethodId = $this->getPaymentMethodId($journalId,$chartOfAccountId,'outbound');
						$chequeReceivableId=$odooSetting ? $odooSetting->getChequesReceivableId() : null;
						$chequePayableId=$odooSetting ? $odooSetting->getChequesPayableId() : null;
						if($chequeReceivableId){
							$odooInboundChequePaymentMethodId = $this->getPaymentMethodId($journalId,$chequeReceivableId,'inbound');
						}
						if($chequePayableId){
							$odooOutboundChequePaymentMethodId = $this->getPaymentMethodId($journalId,$chequePayableId,'outbound');
						}
						
					DB::table('branch')->where('company_id',$companyId)->where('odoo_code',$odooCode)->update([
						'odoo_id'=>$chartOfAccountId,
						'journal_id'=>$journalId,
						'odoo_inbound_transfer_payment_method_id'=>$odooInboundTransferPaymentMethodId??null ,
						'odoo_outbound_transfer_payment_method_id'=>$odooOutboundTransferPaymentMethodId??null,
						'odoo_inbound_cheque_payment_method_id'=>$odooInboundChequePaymentMethodId??null ,
						'odoo_outbound_cheque_payment_method_id'=>$odooOutboundChequePaymentMethodId??null,
					]);
		}
		
	}
	public function syncBanks()
	{
			$fields = [
				'id',
				'code'
			];
			$filters = [
				[
					['type','=','cash'
				],
				]
		];
		$banks = $this->fetchData('account.account',$fields,$filters);
	
		$chartOfAccounts = collect($banks)->keyBy('code')->toArray();
		$banks = CashVeroBranch::where('company_id',$this->company_id)->whereNotNull('odoo_code')->get();

			foreach($banks as $bank){
				$codeCode = $bank->getOdooCode();
				if($codeCode){
					$currentJournal = $chartOfAccounts[$codeCode]??null;
					$chartOfAccountId = $currentJournal ? $currentJournal['id'] : null;
					if($chartOfAccountId){
						$bank->update([
							'odoo_id'=>$chartOfAccountId,
							'journal_id'=>$this->getJournalIdFromChartOfAccountId($chartOfAccountId)
						]);
					}
					
				}
			}
	}
	public function execute($model, $method, $args, $kwargs = [])
    {
        return $this->models->execute_kw($this->db, $this->uid, $this->password, $model, $method, $args, $kwargs);
    }
	// private function validateJournal($journalId)
    // {
    //     $journal = $this->execute('account.journal', 'read', [[$journalId], ['type', 'default_account_id']])[0];
    //     if (!in_array($journal['type'], ['bank', 'cash'])) {
    //         throw new \Exception('Journal must be of type bank or cash');
    //     }
    //     if (!$journal['default_account_id']) {
    //         throw new \Exception('Journal has no default account configured');
    //     }
    //     return $journal['default_account_id'][0]; // Return account ID
    // }
	public function getFieldSelection($model, $field)
    {
            $fields = $this->models->execute_kw($this->db, $this->uid, $this->password,$model, 'fields_get', [[$field]]);
            return $fields[$field]['selection'] ?? [];
      
    }
	
	
 public function getPartners(string $startDate,string $endDate,int $companyId):array
    {
     		 $fields = ['name', 'email', 'phone', 'customer_rank', 'supplier_rank'];
            // Search all partners
            $partnerIds = $this->execute('res.partner', 'search', [[]]);
            if (empty($partnerIds)) {
                return [];
            }

            // Read partner details with role-related fields
			$filters = [
				[
					array('write_date', '>=', $startDate),
					array('write_date', '<=', $endDate)
				]
			];
			$partners = $this->fetchData('res.partner',$fields,$filters);
            $partners = $this->execute('res.partner', 'read', [$partnerIds, $fields]);
			unset($partners[0]); // هنشيل اول واحد لانه بيكون الادمن
            // Check for employee role by searching hr.employee
          //  $employeeData = $this->execute('hr.employee', 'search_read', [[['address_id', 'in', $partnerIds]]], ['fields' => ['address_id']]);
          //  $employeePartnerIds = array_column($employeeData, 'address_id');
			$test = [];
            // Add role information to each partner
		
            foreach ($partners as &$partner) {
                $isCustomer = $partner['customer_rank'] > 0;
                $isSupplier = $partner['supplier_rank'] > 0;
				$currentOdooCustomerName =$partner['name']; 
				$currentOdooCustomerId =$partner['id']; 
                $isEmployee = !$isCustomer && !$isSupplier ;
				if($isCustomer){
					$test[]=$partner;
				}
				Partner::handlePartnerForOdoo($currentOdooCustomerId ,$currentOdooCustomerName,$isCustomer,$isSupplier,$isEmployee,$companyId  );
            }
            return $partners;
			
        
    }
		
	
	public function getPaymentMethodId(int $journalId , int $accountId , string $inboundOrOutbound )
	{
		try {
            $filters = [
              [
				  ['journal_id', '=', $journalId],
                ['payment_account_id', '=', $accountId],
                ['payment_type', '=', $inboundOrOutbound]
			  ]
            ];

            // Log::info("Odoo: Fetching outgoing payment method", [
            //     'journal_id' => $journalId,
            //     'account_id' => $accountId,
            //     'filters' => $filters,
            //     'fields' => $fields
            // ]);
			$fields = [];
            $records = $this->fetchData('account.payment.method.line', $fields,$filters);
            if (empty($records)) {
     //           Log::info("Odoo: No outgoing payment methods found for journal {$journalId} and account {$accountId}");
                return [];
            }

         //   Log::info("Odoo: Fetched " . count($records) . " outgoing payment methods", ['records' => $records]);
            return $records[0]['id']??null;
        } catch (\Exception $e) {
            // Log::error("Odoo Fetch Outgoing Payment Method Error: " . $e->getMessage(), [
            //     'journal_id' => $journalId,
            //     'account_id' => $accountId,
            //     'filters' => $filters,
            //     'trace' => $e->getTraceAsString()
            // ]);
            throw $e;
        }
	}
	
	 
	

}
