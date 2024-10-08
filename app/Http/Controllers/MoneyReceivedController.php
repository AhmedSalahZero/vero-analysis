<?php
namespace App\Http\Controllers;

use App\Http\Requests\ApplyCollectionToChequeRequest;
use App\Http\Requests\SendToUnderCollectionChequeRequest;
use App\Http\Requests\StoreMoneyReceivedRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Cheque;
use App\Models\Company;
use App\Models\Contract;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\MoneyReceived;
use App\Models\Partner;
use App\Models\SalesOrder;
use App\Models\User;
use App\Traits\GeneralFunctions;
use App\Traits\Models\HasBasicFilter;
use App\Traits\Models\HasDebitStatements;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoneyReceivedController
{
    use GeneralFunctions,HasDebitStatements,HasBasicFilter;
   
	public function index(Company $company,Request $request)
	{
		
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$moneyType = $request->get('active',MoneyReceived::CHEQUE) ;
		$filterDates = [];
		foreach(MoneyReceived::getAllTypes() as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		// cash in safe
		$receivedCashesInSafeStartDate = $filterDates[MoneyReceived::CASH_IN_SAFE]['startDate'] ?? null ;
		$receivedCashesInSafeEndDate = $filterDates[MoneyReceived::CASH_IN_SAFE]['endDate'] ?? null ;
		
		// cashes in Bank
		$cashesInBankStartDate = $filterDates[MoneyReceived::CASH_IN_BANK]['startDate'] ?? null ;
		$cashesInBankEndDate = $filterDates[MoneyReceived::CASH_IN_BANK]['endDate'] ?? null ;
			// incoming transfer
			$incomingTransferStartDate = $filterDates[MoneyReceived::INCOMING_TRANSFER]['startDate'] ?? null ;
			$incomingTransferEndDate = $filterDates[MoneyReceived::INCOMING_TRANSFER]['endDate'] ?? null ;
			
		/**
		 * * cheques in safe
		 */
		$chequesInSafeStartDate = $filterDates[MoneyReceived::CHEQUE]['startDate'] ?? null ;
		$chequesInSafeEndDate = $filterDates[MoneyReceived::CHEQUE]['endDate'] ?? null ;
		
		/**
		 * * rejected cheques
		 */
		$chequesRejectedStartDate = $filterDates[MoneyReceived::CHEQUE_REJECTED]['startDate'] ?? null ;
		$chequesRejectedEndDate = $filterDates[MoneyReceived::CHEQUE_REJECTED]['endDate'] ?? null ;
		
		
		/**
		 * *  cheques under collection
		 */
		$chequesUnderCollectionStartDate = $filterDates[MoneyReceived::CHEQUE_UNDER_COLLECTION]['startDate'] ?? null ;
		$chequesUnderCollectionEndDate = $filterDates[MoneyReceived::CHEQUE_UNDER_COLLECTION]['endDate'] ?? null ;
			/**
		 * *  cheques collection
		 */
		$chequesCollectedStartDate = $filterDates[MoneyReceived::CHEQUE_COLLECTED]['startDate'] ?? null ;
		$chequesCollectedEndDate = $filterDates[MoneyReceived::CHEQUE_COLLECTED]['endDate'] ?? null ;
		
		
		
	
		$user = $request->user()->load('moneyReceived') ;
		/** 
		* @var User $user
		*/
		$receivedCashesInSafe = $user->getReceivedCashesInSafe($receivedCashesInSafeStartDate ,$receivedCashesInSafeEndDate ) ;
		$receivedCashesInBanks = $user->getReceivedCashesInBank($cashesInBankStartDate,$cashesInBankEndDate) ;
		$receivedTransfer = $user->getReceivedTransfer($incomingTransferStartDate,$incomingTransferEndDate) ;
		$receivedChequesInSafe = $user->getReceivedChequesInSafe($chequesInSafeStartDate,$chequesInSafeEndDate);
		$receivedRejectedChequesInSafe = $user->getReceivedRejectedChequesInSafe($chequesRejectedStartDate,$chequesRejectedEndDate);
		$receivedChequesUnderCollection=  $user->getReceivedChequesUnderCollection($chequesUnderCollectionStartDate,$chequesUnderCollectionEndDate);
		$collectedCheques=  $user->getCollectedCheques($chequesCollectedStartDate,$chequesCollectedEndDate);
		
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$receivedCashesInSafe = $moneyType == MoneyReceived::CASH_IN_SAFE ? $this->applyFilter($request,$receivedCashesInSafe) :$receivedCashesInSafe  ;
		$receivedCashesInBanks = $moneyType == MoneyReceived::CASH_IN_BANK ? $this->applyFilter($request,$receivedCashesInBanks) :$receivedCashesInBanks  ;
		$receivedTransfer = $moneyType === MoneyReceived::INCOMING_TRANSFER ? $this->applyFilter($request,$receivedTransfer) : $receivedTransfer  ;
		
	
		$receivedChequesInSafe = $moneyType == MoneyReceived::CHEQUE ? $this->applyFilter($request,$receivedChequesInSafe) : $receivedChequesInSafe;
		
		
		$receivedRejectedChequesInSafe = $moneyType == MoneyReceived::CHEQUE_REJECTED ? $this->applyFilter($request,$receivedRejectedChequesInSafe) : $receivedRejectedChequesInSafe;
		
		$receivedChequesUnderCollection=  $moneyType == MoneyReceived::CHEQUE_UNDER_COLLECTION ? $this->applyFilter($request,$receivedChequesUnderCollection) : $receivedChequesUnderCollection ;
		
		$collectedCheques=  $moneyType == MoneyReceived::CHEQUE_COLLECTED ? $this->applyFilter($request,$collectedCheques) : $collectedCheques ;
		
		
		$selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
		$chequesReceivedTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'cheque_number'=>__('Cheque Number'),
			'currency'=>__('Currency'),
			'drawee_bank_id'=>__('Drawee Bank'),
			'due_date'=>__('Due Date'),
			'cheque_status'=>__('Status')
		];
		
		
		$chequesRejectedTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'cheque_number'=>__('Cheque Number'),
			'currency'=>__('Currency'),
			'drawee_bank_id'=>__('Drawee Bank'),
			'due_date'=>__('Due Date'),
			'cheque_status'=>__('Status')
		];
		
		$chequesUnderCollectionTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'cheque_number'=>__('Cheque Number'),
			'received_amount'=>__('Cheque Amount'),
			'deposit_date'=>__('Deposit Date'),
			'drawl_bank_id'=>__('Drawl Bank'),
			// 'account_type'=>__('Account Number'),
			'clearance_days'=>'Clearance Days'
		];
		
		$collectedChequesTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'cheque_number'=>__('Cheque Number'),
			'received_amount'=>__('Cheque Amount'),
			'deposit_date'=>__('Deposit Date'),
			'drawl_bank_id'=>__('Drawl Bank'),
			'clearance_days'=>'Clearance Days'
		];
		
		$incomingTransferTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'receiving_bank_id'=>__('Receiving Bank'),
			'received_amount'=>__('Transfer Amount'),
			'currency'=>__('Currency'),
			'account_number'=>__('Account Number')
		];
		
		$cashInBankTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'receiving_bank_id'=>__('Receiving Bank'),
			'received_amount'=>__('Deposit Amount'),
			'currency'=>__('Currency'),
			'account_number'=>__('Account Number')
		];
		
		$cashInSafeReceivedTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'receiving_branch_id'=>__('Branch'),
			'received_amount'=>__('Received Amount'),
			'currency'=>__('Currency'),
			'receipt_number'=>__('Receipt Number')
		];
		
		
		
		
		$banks = Bank::pluck('view_name','id');
		$accountTypes = AccountType::onlyCashAccounts()->get();		
        return view('reports.moneyReceived.index', [
			'company'=>$company ,
			'selectedBanks'=>$selectedBanks,
			'receivedChequesInSafe'=>$receivedChequesInSafe,
			'receivedCashesInSafe'=>$receivedCashesInSafe,
			'chequesReceivedTableSearchFields'=>$chequesReceivedTableSearchFields,
			'receivedTransfer'=>$receivedTransfer,
			'receivedCashesInBanks'=>$receivedCashesInBanks,
			'banks'=>$banks,
			'receivedChequesUnderCollection'=>$receivedChequesUnderCollection,
			'chequesUnderCollectionTableSearchFields'=>$chequesUnderCollectionTableSearchFields ,
			'cashInSafeReceivedTableSearchFields'=>$cashInSafeReceivedTableSearchFields,
			'incomingTransferTableSearchFields'=>$incomingTransferTableSearchFields,
			'cashInBankTableSearchFields'=>$cashInBankTableSearchFields,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'accountTypes'=>$accountTypes,
			'chequesRejectedTableSearchFields'=>$chequesRejectedTableSearchFields,
			'receivedRejectedChequesInSafe'=>$receivedRejectedChequesInSafe,
			'collectedCheques'=>$collectedCheques,
			'collectedChequesTableSearchFields'=>$collectedChequesTableSearchFields,
			'filterDates'=>$filterDates,
			
		]);
        return view('reports.moneyReceived.index', compact('financialInstitutionBanks','accountTypes'));
    }
	
	public function create(Company $company,$customerInvoiceId = null)
	{
		$isDownPayment = Request()->has('type');
		$customerInvoiceCurrencies = CustomerInvoice::getCurrencies($customerInvoiceId);
		
		$viewName = $isDownPayment  ?  'reports.moneyReceived.down-payments-form' : 'reports.moneyReceived.form';
		$banks = Bank::pluck('view_name','id');
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$invoiceNumber = $customerInvoiceId ? CustomerInvoice::where('id',$customerInvoiceId)->first()->getInvoiceNumber():null;
		/**
		 * * for contracts
		 */
		$customers =  $customerInvoiceId ?  Partner::where('id',CustomerInvoice::find($customerInvoiceId)->customer_id)->where('company_id',$company->id)
		->when($isDownPayment,function(Builder $q){
			$q->has('contracts');
		})
		->pluck('name','id')->toArray() : Partner::where('is_customer',1)->where('company_id',$company->id)->when($isDownPayment,function(Builder $q){
			$q->has('contracts');
		})->pluck('name','id')->toArray(); 
		$contracts = [];
        return view($viewName,[
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'customers'=>$customers ,
			'selectedBranches'=>$selectedBranches,
			'selectedBanks'=>$selectedBanks,
			'singleModel'=>$customerInvoiceId,
			'invoiceNumber'=>$invoiceNumber,
			'banks'=>$banks,
			'accountTypes'=>$accountTypes,
			'customers'=>$customers,
			'contracts'=>$contracts,
			'currencies'=>$customerInvoiceCurrencies
		]);
    }
	
	public function result(Company $company , Request $request){
		
		return view('reports.moneyReceived.form',[
		]);
	}
	public function getContractsForCustomer(Company $company , Request $request ){
		$contracts = Contract::where('partner_id',$request->get('customerId'))->where('currency',$request->get('currency'))->pluck('name','id')->toArray();
		return response()->json([
			'status'=>true ,
			'contracts'=>$contracts
		]);
	}
	public function getContractsForCustomerWithStartAndEndDate(Company $company , Request $request ){

		$contracts = Contract::where('partner_id',$request->get('customerId'))
		->whereDoesntHave('lendingInformationForAgainstAssignmentContract')
		->where('currency',$request->get('currency'))->get();
		return response()->json([
			'status'=>true ,
			'contracts'=>$contracts
		]);
	}
	public function getSalesOrdersForContract(Company $company ,  Request $request , int $contractId = 0,?string $selectedCurrency=null)
	{
		$downPaymentId = $request->get('down_payment_id');
		$moneyReceived = MoneyReceived::find($downPaymentId);
		$salesOrders = SalesOrder::where('contract_id',$contractId)->get();
		$formattedSalesOrders = [];
		foreach($salesOrders as $index=>$salesOrder){
			$receivedAmount = $moneyReceived ? $moneyReceived->downPaymentSettlements->where('sales_order_id',$salesOrder->id)->first() : null ;
		//	dd($moneyReceived , $moneyReceived->downPaymentSettlements ,$salesOrder);
			$formattedSalesOrders[$index]['received_amount'] = $receivedAmount && $receivedAmount->down_payment_amount ? $receivedAmount->down_payment_amount : 0;
			$formattedSalesOrders[$index]['so_number'] = $salesOrder->so_number;
			$formattedSalesOrders[$index]['amount'] = $salesOrder->getAmount();
			$formattedSalesOrders[$index]['id'] = $salesOrder->id;
		}
			return response()->json([
				'status'=>true , 
				'sales_orders'=>$formattedSalesOrders,
				'selectedCurrency'=>$selectedCurrency
			]);
		
	}
	public function getInvoiceNumber(Company $company ,  Request $request , int $customerId,?string $selectedCurrency=null)
	{
		$inEditMode = $request->get('inEditMode');
		$moneyReceivedId = $request->get('money_received_id');
		$moneyReceived = MoneyReceived::find($moneyReceivedId);
		$partner = Partner::find($customerId);

		$customerName = $partner->getName() ;
		$invoices = CustomerInvoice::where('customer_name',$customerName)
		->where('company_id',$company->id)
		->where('net_invoice_amount','>',0);
	
		if(!$inEditMode){
			$invoices->where('net_balance','>',0);
		}
		
		$contractsWithDownPaymentsCurrencies =$invoices->pluck('currency','currency')->mapWithKeys(function($value,$key){
			return [
				$key=>$value 
			];
		});	
	
		if($selectedCurrency){
			$invoices = $invoices->where('currency','=',$selectedCurrency);	
		}
		$invoices = $invoices->orderBy('invoice_date','asc')
		->get(['invoice_number','invoice_date','invoice_due_date','net_invoice_amount','collected_amount','net_balance','currency'])
		->toArray();
		
		
		foreach($invoices as $index=>$invoiceArr){
			$invoices[$index]['settlement_amount'] = $moneyReceived ? $moneyReceived->getSettlementsForInvoiceNumberAmount($invoiceArr['invoice_number'],$customerName) : 0;
			$invoices[$index]['withhold_amount'] = $moneyReceived ? $moneyReceived->getWithholdForInvoiceNumberAmount($invoiceArr['invoice_number'],$customerName) : 0;
		}
	
		$invoices = $this->formatInvoices($invoices,$inEditMode);
			return response()->json([
				'status'=>true , 
				'invoices'=>$invoices,
				'currencies'=>$contractsWithDownPaymentsCurrencies,
				'selectedCurrency'=>$selectedCurrency
			]);
		
	}
	protected function formatInvoices(array $invoices,int $inEditMode){
		return CustomerInvoice::formatInvoices($invoices , $inEditMode);
	}
	
	public function store(Company $company , StoreMoneyReceivedRequest $request , $moneyReceivedId = null){
		
		$moneyType = $request->get('type');
		$contractId = $request->get('contract_id');
		$financialInstitutionId = null;
		$partnerId = $request->get('customer_id');
		$customer = Partner::find($partnerId);
		$customerName = $customer->getName();
		$customerId = $customer->id;
		$receivedBankName = $request->get('receiving_branch_id') ;
		$data = $request->only(['type','receiving_date','currency','receiving_currency']);
		$currency = $data['currency'] ;
		$receivingCurrency = $data['receiving_currency'] ; 
		$isDownPayment = $request->get('is_down_payment') && $request->has('sales_orders_amounts');

		$data['money_type'] =  !$isDownPayment ? 'money-received' : 'down-payment';
		$data['customer_name'] = $customerName;
		$data['customer_name'] = $customerName;
		$data['user_id'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		
		$relationData = [];
		$relationName = null ;
		$exchangeRate = $currency == $receivingCurrency ? 1 : $request->input('exchange_rate.'.$moneyType,1) ;
	
		$receivedAmount = $request->input('received_amount.'.$moneyType ,0) ;
		$receivedAmount = unformat_number($receivedAmount);
		
		$amountInReceivingCurrency = $receivedAmount *  $exchangeRate ;

		
		if($moneyType == MoneyReceived::CASH_IN_SAFE){
			$relationData = $request->only(['receipt_number']) ;
			$relationData['receiving_branch_id'] = $this->generateBranchId($receivedBankName,$company->id) ;
			$relationName = 'cashInSafe';
		}
		elseif($moneyType ==MoneyReceived::INCOMING_TRANSFER ){
			$relationName = 'incomingTransfer';
			$financialInstitutionId = $request->input('receiving_bank_id.'.MoneyReceived::INCOMING_TRANSFER);
			$relationData = [
				'receiving_bank_id'=>$financialInstitutionId,
				'account_number'=>$request->input('account_number.'.MoneyReceived::INCOMING_TRANSFER),
				'account_type'=>$request->input('account_type.'.MoneyReceived::INCOMING_TRANSFER)
			];
		}
		elseif($moneyType ==MoneyReceived::CASH_IN_BANK ){
			$relationName = 'cashInBank';
			$financialInstitutionId = $request->input('receiving_bank_id.'.MoneyReceived::CASH_IN_BANK) ;
			$relationData = [
				'receiving_bank_id'=>$financialInstitutionId,
				'account_number'=>$request->input('account_number.'.MoneyReceived::CASH_IN_BANK),
				'account_type'=>$request->input('account_type.'.MoneyReceived::CASH_IN_BANK)
			];
		}
		elseif($moneyType ==MoneyReceived::CHEQUE ){
			$relationName = 'cheque';
			$relationData = [
				'due_date'=>$request->input('due_date'),
				'cheque_number'=>$request->input('cheque_number'),
				'drawee_bank_id'=>$request->input('drawee_bank_id')
			];
		}
		
		$data['received_amount'] = $receivedAmount ;
		$data['amount_in_receiving_currency'] = $amountInReceivingCurrency ;
		$data['exchange_rate'] =$exchangeRate ;
	
		$data['money_type'] = $isDownPayment ? 'down-payment' : 'money-received' ;
		$data['contract_id'] = $contractId ;
		$data['money_received_id'] = $moneyReceivedId;
		/**
		 * @var MoneyReceived $moneyReceived ;
		 */
		$accountType = AccountType::find($request->input('account_type.'.$moneyType));
		$accountNumber = $request->input('account_number.'.$moneyType) ;
		/**
		 * @var MoneyReceived $moneyReceived
		 */
		if(!$isDownPayment){
			unset($data['contract_id']);
		}
		// if($isDown){
		// 	dd($isDownPayment,$request->all());
		// }
		
		$moneyReceived = MoneyReceived::create($data);
		
		// $receivingDate = $data['receiving_date'] ?? null ; 
		
		$statementDate = $moneyReceived->getStatementDate(); 
		
		$currency = $data['currency'] ?? null ; 
		$receivingBranchId = $relationData['receiving_branch_id'] ?? null ;
		$relationData['company_id'] = $company->id ;  
		$moneyReceived->$relationName()->create($relationData);
		$moneyReceived = $moneyReceived->refresh();
		$moneyReceived->handleDebitStatement($financialInstitutionId,$accountType,$accountNumber,$moneyType,$statementDate,$amountInReceivingCurrency,$receivingCurrency,$receivingBranchId);
		
		
		

		/**
		 * * For Money Received Only
		 */
		$totalWithholdAmount = $moneyReceived->storeNewSettlement($request->get('settlements',[]),$customerName,$company->id);
		
		$moneyReceived->update([
			'total_withhold_amount'=>$totalWithholdAmount
		]);
		
		/**
		 * * For Contract Only
		 */
		
		 if(!$isDownPayment&&$request->get('unapplied_amount',0) > 0 ){
			// start store unapplied amount as new down payment
			return $this->store($company,$request->replace(array_merge($request->all(),['is_down_payment'=>true],['received_amount'=>[$moneyType=>$request->get('unapplied_amount')]],['settlements'=>[]])),$moneyReceived->id);
		}
		
		foreach($request->get('sales_orders_amounts',[]) as $salesOrderReceivedAmountArr)
		{
			if(isset($salesOrderReceivedAmountArr['received_amount'])&&$salesOrderReceivedAmountArr['received_amount'] > 0){
				$salesOrderReceivedAmountArr['company_id'] = $company->id ;
				$moneyReceived->downPaymentSettlements()->create(array_merge(
					$salesOrderReceivedAmountArr ,
					[
						'contract_id'=>$contractId,
						'customer_id'=>$customerId,
						'down_payment_amount'=>$salesOrderReceivedAmountArr['received_amount']
					]
				));
			}
		}
		
		
		
		/**
		 * @var CustomerInvoice $customerInvoice
		 */

		$activeTab = $moneyType;
		

			return response()->json([
				'redirectTo'=>route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])
			]);

		// return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}
	protected function getActiveTab(string $moneyType)
	{
		return $moneyType ;

	}
	public function edit(Company $company , Request $request ,  MoneyReceived $moneyReceived ,$customerInvoiceId = null){
		
		$isDownPayment = $moneyReceived->isDownPayment();
		$currencies = DB::table('customer_invoices')
		->select('currency')
		->where('company_id',$company->id)
		->where('currency','!=','')
		->get()
		->unique('currency')->pluck('currency','currency');
		$viewName = $isDownPayment  ?  'reports.moneyReceived.down-payments-form' : 'reports.moneyReceived.form';
		$banks = Bank::pluck('view_name','id');
		$selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		// $customerInvoices = CustomerInvoice::where('company_id',$company->id)->pluck('customer_name','id')->unique()->toArray(); 
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
		/**
		 * * for contracts
		 */
		$customers =  $customerInvoiceId ?  Partner::where('id',CustomerInvoice::find($customerInvoiceId)->customer_id)->where('company_id',$company->id)
		->when($isDownPayment,function(Builder $q){
			$q->has('contracts');
		})
		->pluck('name','id')->toArray() : Partner::where('is_customer',1)->where('company_id',$company->id)->when($isDownPayment,function(Builder $q){
			$q->has('contracts');
		})->pluck('name','id')->toArray(); 
		
		$contracts = Contract::where('company_id',$company->id)->get();
		if($moneyReceived->isChequeUnderCollection()){
			return view('reports.moneyReceived.edit-cheque-under-collection',[
				'banks'=>$banks,
				// 'customerInvoices'=>$customerInvoices ,
				'selectedBranches'=>$selectedBranches,
				'selectedBanks'=>$selectedBanks,
				'model'=>$moneyReceived,
				'singleModel'=>$customerInvoiceId,
				'accountTypes'=>$accountTypes,
				'financialInstitutionBanks'=>$financialInstitutionBanks,
				'currencies'=>$currencies,
				
			]); 
		}
        return view($viewName,[
			'banks'=>$banks,
			'customers'=>$customers,
			'contracts'=>$contracts,
			// 'customerInvoices'=>$customerInvoices ,
			'selectedBranches'=>$selectedBranches,
			'accountTypes'=>$accountTypes,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'selectedBanks'=>$selectedBanks,
			'model'=>$moneyReceived,
			'singleModel'=>$customerInvoiceId,
			'currencies'=>$currencies
		]);
		
	}
	
	public function update(Company $company , StoreMoneyReceivedRequest $request , moneyReceived $moneyReceived){
		$newType = $request->get('type');
		$moneyReceived->deleteRelations();
		$moneyReceived->delete();
		$this->store($company,$request);
		 $activeTab = $newType;

		 return response()->json([
			'redirectTo'=>route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])
		]);
		// return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Money Received Has Been Updated Successfully'));
	}
	
	public function destroy(Company $company , MoneyReceived $moneyReceived)
	{
		$moneyReceived->deleteRelations();
		$activeTab = $moneyReceived->getType();
		$moneyReceived->delete();
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Money Received Has Been Updated Successfully'));
	}
	protected function generateBranchId($nameOrId,$companyId){
		$branch = Branch::where('id',$nameOrId)->first();
			if(!$branch){
				$branch = Branch::create([
					'name'=>$nameOrId,
					'company_id'=>$companyId ,
					'created_by'=>auth()->user()->id
				]);
			}
			return $branch->id ;
	}
	public function sendToCollection(Company $company,SendToUnderCollectionChequeRequest $request)
	{
		$moneyReceivedIds = $request->get('cheques') ;
		$moneyReceivedIds = is_array($moneyReceivedIds) ? $moneyReceivedIds :  explode(',',$moneyReceivedIds);
		$data = $request->only(['deposit_date','drawl_bank_id','account_type','account_number','account_balance','clearance_days']);
		$data['account_type'] =  $request->input('account_type.'.MoneyReceived::CHEQUE_UNDER_COLLECTION);
		$data['account_number'] = $request->input('account_number.'.MoneyReceived::CHEQUE_UNDER_COLLECTION);
		$data['account_type'] = is_null($data['account_type']) ? $request->get('account_type') : $data['account_type'] ;
		$data['drawl_bank_id'] = $request->input('receiving_bank_id.'.MoneyReceived::CHEQUE_UNDER_COLLECTION,$request->get('drawl_bank_id'));
		// $data['drawl_bank_id'] = is_null($data['drawl_bank_id'])  ? 
		// $accountType = AccountType::find($data['account_type']);
	
		$data['account_number'] = is_null($data['account_number']) ? $request->get('account_number') : $data['account_number'] ;
		$data['status'] = Cheque::UNDER_COLLECTION;
		
		foreach($moneyReceivedIds as $moneyReceivedId){
			/**
			 * @var MoneyReceived $moneyReceived 
			 */
			$moneyReceived = MoneyReceived::find($moneyReceivedId) ;
			$data['expected_collection_date'] = $moneyReceived->cheque->calculateChequeExpectedCollectionDate($data['deposit_date'],$data['clearance_days']);
			$moneyReceived->cheque->update(array_merge($data,['updated_at'=>now()]));
			
		
			
		}
		if($request->ajax()){
			return response()->json([
				'status'=>true ,
				'msg'=>__('Good'),
				'pageLink'=>route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_UNDER_COLLECTION])
			]);	
		}
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_UNDER_COLLECTION]);
		
	}
	/**
	 * * تحديد ان الشيك دا تم بالفعل صرفة من البنك ونزل في حسابك
	 */
	public function applyCollection(Company $company,ApplyCollectionToChequeRequest $request,MoneyReceived $moneyReceived)
	{
		/**
		 * 
		 * @var MoneyReceived $moneyReceived
		 */
		$collectionFeesAmount = $request->get('collection_fees',0) ;
		$actualCollectionDate = $request->get('actual_collection_date')  ;
		$moneyReceived->cheque->update([
			'status'=>Cheque::COLLECTED,
			'collection_fees'=>$collectionFeesAmount,
			'actual_collection_date'=>$actualCollectionDate
		]);
		$chequeNumber = $moneyReceived->cheque->getChequeNumber();
		$accountType = AccountType::find($moneyReceived->cheque->account_type) ;
		$currency = $moneyReceived->getCurrency();
		$receivedAmount = $moneyReceived->getReceivedAmount();
		// $receivingDate = $moneyReceived->getReceivingDate();
		$moneyType = MoneyReceived::CHEQUE;
		$accountNumber = $moneyReceived->cheque->account_number ;
		$financialInstitutionId = $moneyReceived->cheque->getDrawlBankId();
		/**
		 * @var AccountType $accountType ;
		 */
		
		$moneyReceived->handleDebitStatement($financialInstitutionId,$accountType,$accountNumber,$moneyType,$actualCollectionDate,$receivedAmount,$currency,null);
		$moneyReceived->handleCreditStatement($company->id , $financialInstitutionId , $accountType,$accountNumber,'fees',$actualCollectionDate,$collectionFeesAmount,null,$currency,__('Cheque Collection Fees - Cheque [ :number ]' ,['number'=>$chequeNumber],'en' ),__('Cheque Collection Fees - Cheque [ :number ]' ,['number'=>$chequeNumber],'ar' ));
		if($request->ajax()){
			return response()->json([
				'status'=>true ,
				'redirectTo'=>route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_COLLECTED])
			]);
		}
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_COLLECTED])->with('success',__('Cheque Is Returned To Safe'));
	}
	
	public function sendToUnderCollection(Company $company,Request $request,MoneyReceived $moneyReceived)
	{
		$moneyReceived->cheque->update([
			'status'=>Cheque::UNDER_COLLECTION,
			'collection_fees'=>null,
			'actual_collection_date'=>null
		]);

		while($currentStatement = $moneyReceived->getCurrentStatement()){
			$currentStatement->delete();
			$moneyReceived = $moneyReceived->refresh();
		}
		// $moneyReceived->

		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_UNDER_COLLECTION])->with('success',__('Cheque Is Under Collection'));
		
	}
	public function sendToSafe(Company $company,Request $request,MoneyReceived $moneyReceived)
	{
		$moneyReceived->cheque->update([
			'status'=>Cheque::IN_SAFE,
			'deposit_date'=>null ,
			'drawl_bank_id'=>null ,
			'account_type'=>null ,
			'account_number'=>null ,
			'account_balance'=>null ,
			'expected_collection_date'=>null ,
			'clearance_days'=>null
		]);

		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE])->with('success',__('Cheque Is Returned To Safe'));
	}
	public function sendToSafeAsRejected(Company $company,Request $request,MoneyReceived $moneyReceived)
	{
		
		$moneyReceived->cheque->update([
			'status'=>Cheque::REJECTED,
			'deposit_date'=>null ,
			'drawl_bank_id'=>null ,
			'account_type'=>null ,
			'account_number'=>null ,
			'account_balance'=>null ,
			'expected_collection_date'=>null ,
			'clearance_days'=>null
		]);
		
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_REJECTED])->with('success',__('Cheque Is Returned To Safe'));
		
	}

	public function getAccountNumbersForAccountType(Company $company ,  Request $request ,  string $accountType,?string $selectedCurrency=null , ?int $financialInstitutionId = 0){
		$accountType = AccountType::find($accountType);
		$modelName = $accountType->getModelName() ;
		$accountNumberModel =  ('\App\Models\\'.$modelName)::getAllAccountNumberForCurrency($company->id , $selectedCurrency,$financialInstitutionId);
		return response()->json([
			'status'=>true , 
			'data'=>$accountNumberModel
			
		]);
	}
	public function getAccountAmountForAccountNumber(Company $company ,  Request $request ,  string $accountTypeId , string $accountNumber  , int $financialInstitutionId ){
	
		
	
		$accountType = AccountType::find($accountTypeId);
		$accountNumberModel =  ('\App\Models\\'.$accountType->getModelName())::findByAccountNumber($accountNumber,$company->id,$financialInstitutionId);
		$currencyName = $accountNumberModel ? $accountNumberModel->currency : '';
	
		return response()->json([
			'status'=>true , 
			'amount'=>$accountNumberModel ? $accountNumberModel->getAmount($currencyName,$accountNumber,$financialInstitutionId,$company->id) : 0 ,
			'interest_rate'=>$accountNumberModel ? $accountNumberModel->getInterestRate() : 0,
			'currencyName'=>$currencyName
		]);
	}
	public function updateNetBalanceBasedOnAccountNumber(Request $request , Company $company )
	{
		$netBalanceDate = '' ;
		$accountTypeId = $request->get('accountType');
		$accountType = AccountType::find($accountTypeId);
		$accountNumber = $request->get('accountNumber');
		$financialInstitutionId = $request->get('financialInstitutionId');
	
		if(!$accountType){
			return response()->json([
				[
					'status'=>true ,
					'balance'=>0,
					'net_balance'=>0 ,
				]
			]);
		}
	
		$accountNumberModel =  ('\App\Models\\'.$accountType->getModelName())::findByAccountNumber($accountNumber,$company->id,$financialInstitutionId);
		if(!$accountNumberModel){
			if(!$accountType || !$accountNumberModel){
				return response()->json(
					[
						'status'=>true ,
						'balance'=>0,
						'net_balance'=>0 ,
					]
				);
			}
		}
		$statementTableName = (get_class($accountNumberModel)::getStatementTableName()) ;
		$foreignKeyName = get_class($accountNumberModel)::getForeignKeyInStatementTable();
		
		$balanceRow = DB::table($statementTableName)->where($foreignKeyName,$accountNumberModel->id)->where('full_date','<=' , now())->orderByRaw('full_date desc')->first();
		$NetBalanceRow = DB::table($statementTableName)->where($foreignKeyName,$accountNumberModel->id)->orderByRaw('full_date desc')->first();
		$balance = 0;
		$balanceDate = '';
		
		$netBalance = 0;
		if($balanceRow){
			$balance = $balanceRow->end_balance ; 
			$balanceDate = Carbon::make($balanceRow->date)->format('d-m-Y') ;
		}
		if($NetBalanceRow){
			$netBalance =$NetBalanceRow->end_balance ; 
			$netBalanceDate =Carbon::make($NetBalanceRow->date)->format('d-m-Y') ; 
		}
		
		return response()->json([
			'status'=>true ,
			'balance'=>$balance,
			'balance_date'=>$balanceDate,
			'net_balance'=>$netBalance ,
			'net_balance_date'=>$netBalanceDate ,
			
		]);

	}
	
	public function updateNetBalanceBasedOnAccountNumberByAjax(Request $request , Company $company , $accountType , $accountNumber , $financialInstitutionId )
	{

		return $this->updateNetBalanceBasedOnAccountNumber((new Request())->replace([
			'accountType'=>$accountType,
			'accountNumber'=>$accountNumber , 
			'financialInstitutionId'=>$financialInstitutionId
		]),$company);
	}
	
	
	
	
	
	
	public function getCustomersBasedOnCurrency(Request $request , Company $company , string $currencyName){
		return response()->json([
			'customerInvoices'=>CustomerInvoice::where('currency',$currencyName)->where('company_id',$company->id)->pluck('customer_name','customer_id')
		]);
	}
	public function markAsConfirmed(Company $company,Request $request,int $modelId)
	{
		$tableName = $request->get('table_name');
		DB::table($tableName)->where('id',$modelId)->update([
			'is_reviewed'=>1,
			'reviewed_by'=>auth()->user()->id 
		]);
		return redirect()->back();
	}
}
