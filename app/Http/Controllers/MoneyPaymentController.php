<?php
namespace App\Http\Controllers;

use App\Helpers\HHelpers;
use App\Http\Requests\StoreMoneyPaymentRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Cheque;
use App\Models\CleanOverdraft;
use App\Models\Company;
use App\Models\Contract;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Models\MoneyPayment;
use App\Models\Partner;
use App\Models\PayableCheque;
use App\Models\SalesOrder;
use App\Models\SupplierInvoice;
use App\Models\User;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MoneyPaymentController
{
    use GeneralFunctions;
    protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName = $searchFieldName === 'due_date' ? 'due_date' : 'delivery_date'; 
		if($searchFieldName =='delivery_date'){
			$dateFieldName = 'delivery_date';
		}
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($moneyPayment) use ($value,$searchFieldName){
				$currentValue = $moneyPayment->{$searchFieldName} ;
				// $moneyPaymentRelationName cash-in-safe -> cashInSafe relation ship name
				$moneyPaymentRelationName = dashesToCamelCase(Request('active')) ;
				$relationRecord = $moneyPayment->$moneyPaymentRelationName ;
				/**
				 * * بمعني لو مالقناش القيمة في جدول ال
				 * * moneyPayment
				 * * هندور عليها في العلاقه 
				 */
				$currentValue = is_null($currentValue) && $relationRecord ? $relationRecord->{$searchFieldName}  :$currentValue ;
				if($searchFieldName == 'delivery_branch_id'){
					$currentValue = $moneyPayment->getCashPaymentBranchName() ;  
				}
				if($searchFieldName == 'delivery_bank_id'){
					$currentValue = $moneyPayment->getDeliveryBankName() ;  
				}
				return false !== stristr($currentValue , $value);
			});
		})
		->when($request->get('from') , function($collection) use($dateFieldName,$from){
			return $collection->where($dateFieldName,'>=',$from);
		})
		->when($request->get('to') , function($collection) use($dateFieldName,$to){
			return $collection->where($dateFieldName,'<=',$to);
		})
		->sortByDesc('delivery_date');
	
		return $collection;
	}
	public function index(Company $company,Request $request)
	{
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$moneyType = $request->get('active',MoneyPayment::CASH_PAYMENT) ;
		$filterDates = [];
		foreach(MoneyPayment::getAllTypes() as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		// cash 
		$cashPaymentsStartDate = $filterDates[MoneyPayment::CASH_PAYMENT]['startDate'] ?? null ;
		$cashPaymentsEndDate = $filterDates[MoneyPayment::CASH_PAYMENT]['endDate'] ?? null ;
		

			// outgoing transfer
			$outgoingTransferStartDate = $filterDates[MoneyPayment::OUTGOING_TRANSFER]['startDate'] ?? null ;
			$outgoingTransferEndDate = $filterDates[MoneyPayment::OUTGOING_TRANSFER]['endDate'] ?? null ;
			
		/**
		 * * cheques in safe
		 */
		$payableChequesStartDate = $filterDates[MoneyPayment::PAYABLE_CHEQUE]['startDate'] ?? null ;
		$payableChequesEndDate = $filterDates[MoneyPayment::PAYABLE_CHEQUE]['endDate'] ?? null ;
		
		/**
		 * * rejected cheques
		 */
		// $chequesRejectedStartDate = $filterDates[MoneyPayment::CHEQUE_REJECTED]['startDate'] ?? null ;
		// $chequesRejectedEndDate = $filterDates[MoneyPayment::CHEQUE_REJECTED]['endDate'] ?? null ;
		
		
	
		
		
	
		$user = $request->user()->load('moneyPayments') ;
		/** 
		* @var User $user
		*/
		$cashPayments = $user->getCashPayments($cashPaymentsStartDate ,$cashPaymentsEndDate ) ;
	
		$outgoingTransfer = $user->getOutgoingTransfer($outgoingTransferStartDate,$outgoingTransferEndDate) ;
		$payableCheques = $user->getPayableCheques($payableChequesStartDate,$payableChequesEndDate);
		// $receivedRejectedChequesInSafe = $user->getReceivedRejectedChequesInSafe($chequesRejectedStartDate,$chequesRejectedEndDate);
		// $receivedChequesUnderCollection=  $user->getReceivedChequesUnderCollection($chequesUnderCollectionStartDate,$chequesUnderCollectionEndDate);
		// $collectedCheques=  $user->getCollectedCheques($chequesCollectedStartDate,$chequesCollectedEndDate);
		
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$cashPayments = $moneyType == MoneyPayment::CASH_PAYMENT ? $this->applyFilter($request,$cashPayments) :$cashPayments  ;
		$outgoingTransfer = $moneyType === MoneyPayment::OUTGOING_TRANSFER ? $this->applyFilter($request,$outgoingTransfer) : $outgoingTransfer  ;
		
	
		$payableCheques = $moneyType == MoneyPayment::PAYABLE_CHEQUE ? $this->applyFilter($request,$payableCheques) : $payableCheques;
		
		
		// $receivedRejectedChequesInSafe = $moneyType == MoneyPayment::CHEQUE_REJECTED ? $this->applyFilter($request,$receivedRejectedChequesInSafe) : $receivedRejectedChequesInSafe;
		
		// $receivedChequesUnderCollection=  $moneyType == MoneyPayment::CHEQUE_UNDER_COLLECTION ? $this->applyFilter($request,$receivedChequesUnderCollection) : $receivedChequesUnderCollection ;
		
		// $collectedCheques=  $moneyType == MoneyPayment::CHEQUE_COLLECTED ? $this->applyFilter($request,$collectedCheques) : $collectedCheques ;
		
		
		$payableChequesTableSearchFields = [
			'supplier_name'=>__('Supplier Name'),
			'delivery_date'=>__('Delivery Date'),
			'cheque_number'=>__('Cheque Number'),
			'currency'=>__('Currency'),
			'delivery_bank_id'=>__('Delivery Bank'),
			'due_date'=>__('Due Date'),
			'cheque_status'=>__('Status')
		];
		
		
		// $chequesRejectedTableSearchFields = [
		// 	'supplier_name'=>__('Supplier Name'),
		// 	'delivery_date'=>__('Delivery Date'),
		// 	'cheque_number'=>__('Cheque Number'),
		// 	'currency'=>__('Currency'),
		// 	'delivery_bank_id'=>__('Delivery Bank'),
		// 	'due_date'=>__('Due Date'),
		// 	'cheque_status'=>__('Status')
		// ];
		
		// $chequesUnderCollectionTableSearchFields = [
		// 	'supplier_name'=>__('Supplier Name'),
		// 	'cheque_number'=>__('Cheque Number'),
		// 	'paid_amount'=>__('Cheque Amount'),
		// 	'delivery_date'=>__('Deposit Date'),
		// 	'delivery_bank_id'=>__('Delivery Bank'),
		// 	'clearance_days'=>'Clearance Days'
		// ];
		
		// $collectedChequesTableSearchFields = [
		// 	'supplier_name'=>__('Supplier Name'),
		// 	'cheque_number'=>__('Cheque Number'),
		// 	'paid_amount'=>__('Cheque Amount'),
		// 	'delivery_date'=>__('Deposit Date'),
		// 	'delivery_bank_id'=>__('Delivery Bank'),
		// 	'clearance_days'=>'Clearance Days'
		// ];
		
		$outgoingTransferTableSearchFields = [
			'supplier_name'=>__('Supplier Name'),
			'delivery_date'=>__('Delivery Date'),
			'delivery_bank_id'=>__('Delivery Bank'),
			'paid_amount'=>__('Transfer Amount'),
			'currency'=>__('Currency'),
			'account_number'=>__('Account Number')
		];
		
		
		
		$payableCashTableSearchFields = [
			'supplier_name'=>__('Supplier Name'),
			'delivery_date'=>__('Delivery Date'),
			'delivery_branch_id'=>__('Branch'),
			'paid_amount'=>__('Paid Amount'),
			'currency'=>__('Currency'),
			'receipt_number'=>__('Receipt Number')
		];
		
		
		
		

		$accountTypes = AccountType::onlyCashAccounts()->get();		
        return view('reports.moneyPayments.index', [
			'company'=>$company ,
			'payableCheques'=>$payableCheques,
			'cashPayments'=>$cashPayments,
			'payableChequesTableSearchFields'=>$payableChequesTableSearchFields,
			'outgoingTransfer'=>$outgoingTransfer,
			// 'receivedChequesUnderCollection'=>$receivedChequesUnderCollection,
			// 'chequesUnderCollectionTableSearchFields'=>$chequesUnderCollectionTableSearchFields ,
			'payableCashTableSearchFields'=>$payableCashTableSearchFields,
			'outgoingTransferTableSearchFields'=>$outgoingTransferTableSearchFields,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'accountTypes'=>$accountTypes,
			// 'chequesRejectedTableSearchFields'=>$chequesRejectedTableSearchFields,
			// 'receivedRejectedChequesInSafe'=>$receivedRejectedChequesInSafe,
			// 'collectedCheques'=>$collectedCheques,
			// 'collectedChequesTableSearchFields'=>$collectedChequesTableSearchFields,
			'filterDates'=>$filterDates,
			
		]);
        return view('reports.moneyPayments.index', compact('financialInstitutionBanks','accountTypes'));
    }
	
	public function create(Company $company,$singleModel = null)
	{
		$isDownPayment = Request()->has('type');
		$viewName = $isDownPayment  ?  'reports.moneyPayments.down-payments-form' : 'reports.moneyPayments.form';

		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$supplierInvoices =  $singleModel ?  SupplierInvoice::where('id',$singleModel)->pluck('supplier_name','id') :SupplierInvoice::where('company_id',$company->id)->pluck('supplier_name','id')->unique()->toArray(); 
		$invoiceNumber = $singleModel ? SupplierInvoice::where('id',$singleModel)->first()->getInvoiceNumber():null;
		/**
		 * * for contracts
		 */
		$suppliers =  $singleModel ?  Partner::where('id',$singleModel)->has('contracts')->pluck('name','id')->toArray() :Partner::where('is_supplier',1)->has('contracts')->pluck('name','id')->toArray(); 
		$contracts = [];

        return view($viewName,[
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'supplierInvoices'=>$supplierInvoices ,
			'selectedBranches'=>$selectedBranches,
			'singleModel'=>$singleModel,
			'invoiceNumber'=>$invoiceNumber,
			
			'accountTypes'=>$accountTypes,
			'suppliers'=>$suppliers,
			'contracts'=>$contracts
		]);
    }
	
	public function result(Company $company , Request $request){
		
		return view('reports.moneyPayments.form',[
		]);
	}
	public function getContractsForSupplier(Company $company , Request $request ){
		$contracts = Contract::where('partner_id',$request->get('supplierId'))->where('currency',$request->get('currency'))->pluck('name','id')->toArray();
		return response()->json([
			'status'=>true ,
			'contracts'=>$contracts
		]);
	}
	public function getSalesOrdersForContract(Company $company ,  Request $request , int $contractId,?string $selectedCurrency=null)
	{
		$downPaymentId = $request->get('down_payment_id');
		$moneyPayment = MoneyPayment::find($downPaymentId);
		$salesOrders = SalesOrder::where('contract_id',$contractId)->get();
		$formattedSalesOrders = [];
		foreach($salesOrders as $index=>$salesOrder){
			$paidAmount = $moneyPayment->downPaymentSettlements->where('purchases_order_id',$salesOrder->id)->first() ;
			$formattedSalesOrders[$index]['paid_amount'] = $paidAmount && $paidAmount->down_payment_amount ? $paidAmount->down_payment_amount : 0;
			$formattedSalesOrders[$index]['amount'] = $salesOrder->getAmount();
			$formattedSalesOrders[$index]['id'] = $salesOrder->id;
		}
			return response()->json([
				'status'=>true , 
				'purchases_orders'=>$formattedSalesOrders,
				'selectedCurrency'=>$selectedCurrency
			]);
		
	}
	public function getInvoiceNumber(Company $company ,  Request $request , int $supplierInvoiceId,?string $selectedCurrency=null)
	{
		$inEditMode = $request->get('inEditMode');
		$moneyPaymentId = $request->get('money_payment_id');
		$moneyPayment = MoneyPayment::find($moneyPaymentId);
		$supplier = SupplierInvoice::find($supplierInvoiceId);

		$supplierName = $supplier->supplier_name ;
		$invoices = SupplierInvoice::where('supplier_name',$supplierName)->where('company_id',$company->id)
		->where('net_invoice_amount','>',0);
		
		if(!$inEditMode){
			$invoices->where('net_balance','>',0);
		}
		
		$allCurrencies = $invoices->pluck('currency','currency')->mapWithKeys(function($value,$key){
			return [
				strtolower($key)=>strtolower($value) 
			];
		});		
		if($selectedCurrency){
			$invoices = $invoices->where('currency','=',$selectedCurrency);	
		}
		$invoices = $invoices->orderBy('invoice_date','asc')
		->get(['invoice_number','invoice_date','net_invoice_amount','paid_amount','net_balance','currency'])
		->toArray();
		
		
		foreach($invoices as $index=>$invoiceArr){
			$invoices[$index]['settlement_amount'] = $moneyPayment ? $moneyPayment->getSettlementsForInvoiceNumberAmount($invoiceArr['invoice_number'],$supplierName) : 0;
			$invoices[$index]['withhold_amount'] = $moneyPayment ? $moneyPayment->getWithholdForInvoiceNumberAmount($invoiceArr['invoice_number'],$supplierName) : 0;
		}
		
		$invoices = $this->formatInvoices($invoices,$inEditMode);
			return response()->json([
				'status'=>true , 
				'invoices'=>$invoices,
				'currencies'=>$allCurrencies,
				'selectedCurrency'=>$selectedCurrency
			]);
		
	}
	protected function formatInvoices(array $invoices,int $inEditMode){
		$result = [];
		foreach($invoices as $index=>$invoiceArr){
			$result[$index]['invoice_number'] = $invoiceArr['invoice_number'];
			$result[$index]['currency'] = $invoiceArr['currency'];
			$result[$index]['net_invoice_amount'] = $invoiceArr['net_invoice_amount'];

			$result[$index]['paid_amount'] = $inEditMode 	?  (double)$invoiceArr['paid_amount'] - (double) $invoiceArr['settlement_amount']  : (double)$invoiceArr['paid_amount'];
			$result[$index]['net_balance'] = $inEditMode ? $invoiceArr['net_balance'] +  $invoiceArr['settlement_amount']  + (double) $invoiceArr['withhold_amount'] : $invoiceArr['net_balance']  ;
			$result[$index]['settlement_amount'] = $inEditMode ? $invoiceArr['settlement_amount'] : 0;
			$result[$index]['withhold_amount'] = $inEditMode ? $invoiceArr['withhold_amount'] : 0;
			$result[$index]['invoice_date'] = Carbon::make($invoiceArr['invoice_date'])->format('d-m-Y');
		}
		return $result;
	}
	
	public function store(Company $company , StoreMoneyPaymentRequest $request){
		$moneyType = $request->get('type');
		$contractId = $request->get('contract_id');
		$supplierInvoiceId = $request->get('supplier_id');
		$supplierInvoice = SupplierInvoice::find($supplierInvoiceId);
	
		$supplier = $supplierInvoice->supplier ;

		$supplierName = $supplierInvoice->getSupplierName();
		$supplierId = $supplierInvoice->getSupplierId();

		$paymentBranchName = $request->get('delivery_branch_id') ;
		$data = $request->only(['type','delivery_date','currency']);
		$data['supplier_name'] = $supplierName;
		$data['user_id'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		$isDownPayment = $request->has('purchases_orders_amounts');
		$data['money_type'] =  !$isDownPayment ? 'money-payment' : 'down-payment';
		
		
		$relationData = [];
		$relationName = null ;
		$paidAmount = 0 ;
		$exchangeRate = $request->input('exchange_rate.'.$moneyType,1) ;
		$paidAmount = $request->input('paid_amount.'.$moneyType ,0) ;
		if($moneyType == MoneyPayment::CASH_PAYMENT){
			$relationData = $request->only(['receipt_number']) ;
			$relationData['delivery_branch_id'] = $this->generateBranchId($paymentBranchName,$company->id) ;
			$relationName = 'cashPayment';
		}
		elseif($moneyType ==MoneyPayment::OUTGOING_TRANSFER ){
			$relationName = 'outgoingTransfer';
			$relationData = [
				'delivery_bank_id'=>$request->input('delivery_bank_id.'.MoneyPayment::OUTGOING_TRANSFER),
				'account_number'=>$request->input('account_number.'.MoneyPayment::OUTGOING_TRANSFER),
				'account_type'=>$request->input('account_type.'.MoneyPayment::OUTGOING_TRANSFER)
			];
		}
		
		elseif($moneyType ==MoneyPayment::PAYABLE_CHEQUE ){
			$relationName = 'payableCheque';
			$relationData = [
				'due_date'=>$request->input('due_date'),
				'cheque_number'=>$request->input('cheque_number'),
				'delivery_bank_id'=>$request->input('delivery_bank_id.'.MoneyPayment::PAYABLE_CHEQUE),
				'account_number'=>$request->input('account_number.'.MoneyPayment::PAYABLE_CHEQUE),
				'account_type'=>$request->input('account_type.'.MoneyPayment::PAYABLE_CHEQUE)
			];
		}
		$isDownPayment = $request->has('purchases_orders_amounts') ;
		$data['paid_amount'] = $paidAmount ;
		$data['exchange_rate'] =$exchangeRate ;
		$data['money_type'] = $isDownPayment ? 'down-payment' : 'money-payment' ;
		$data['contract_id'] = $contractId ;
		/**
		 * @var MoneyPayment $moneyPayment ;
		 */
		$moneyPayment = MoneyPayment::create($data);
		
		$accountType = AccountType::find($request->input('account_type.'.$moneyType));
		
		if($accountType && $accountType->getSlug() == AccountType::CLEAN_OVERDRAFT){
			$cleanOverdraft  = CleanOverdraft::findByAccountNumber($request->input('account_number.'.$moneyType));
			$moneyPayment->storeCleanOverdraftBankStatement($moneyType,$cleanOverdraft,$data['delivery_date'],$paidAmount);
		}
		if($accountType && $accountType->getSlug() == AccountType::CURRENT_ACCOUNT){
			$financialInstitutionAccount = FinancialInstitutionAccount::findByAccountNumber($request->input('account_number.'.$moneyType));
			$moneyPayment->storeCurrentAccountBankStatement($data['delivery_date'],$paidAmount,$financialInstitutionAccount->id);
		}
		if($moneyPayment->isCashPayment()){
			$moneyPayment->storeCashInSafeStatement($data['delivery_date'],$paidAmount,$data['currency'],$relationData['delivery_branch_id']);
		}
		$relationData['company_id'] = $company->id ;  
		$moneyPayment->$relationName()->create($relationData);
		/**
		 * * For Money Received Only
		 */
		if($request->get('unapplied_amount',0) > 0 ){
			$moneyPayment->unappliedAmounts()->create([
				'amount'=>$request->get('unapplied_amount'),
				'partner_id'=>$supplier->id,
				'settlement_date'=>$request->get('delivery_date'),
				'company_id'=>$company->id,
				'net_balance_until_date'=>0,
				'model_id'=>$moneyPayment->id,
				'model_type'=>HHelpers::getClassNameWithoutNameSpace($moneyPayment)
			]);
		}
		/**
		 * * For Money Received Only
		 */
		$totalWithholdAmount= 0 ;
		foreach($request->get('settlements',[]) as $settlementArr)
		{
			if(isset($settlementArr['settlement_amount'])&&$settlementArr['settlement_amount'] > 0){
				$settlementArr['company_id'] = $company->id ;
				$settlementArr['supplier_name'] = $supplierName ;
				$totalWithholdAmount += $settlementArr['withhold_amount']  ;
				$moneyPayment->settlements()->create($settlementArr);
			}
		}
		/**
		 * * For Contract Only
		 */
		foreach($request->get('purchases_orders_amounts',[]) as $salesOrderReceivedAmountArr)
		{
			if(isset($salesOrderReceivedAmountArr['paid_amount'])&&$salesOrderReceivedAmountArr['paid_amount'] > 0){
				$salesOrderReceivedAmountArr['company_id'] = $company->id ;
				$moneyPayment->downPaymentSettlements()->create(array_merge(
					$salesOrderReceivedAmountArr ,
					[
						'contract_id'=>$contractId,
						'supplier_id'=>$supplierId,
						'down_payment_amount'=>$salesOrderReceivedAmountArr['paid_amount']
						]
					));
			}
		}
		
		
		$moneyPayment->update([
			'total_withhold_amount'=>$totalWithholdAmount
		]);
		/**
		 * @var SupplierInvoice $supplierInvoice
		 */
		
		$activeTab = $moneyType;
		
		return redirect()->route('view.money.payment',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}
	protected function getActiveTab(string $moneyType)
	{
		return $moneyType ;

	}
	public function edit(Company $company , Request $request , moneyPayment $moneyPayment ,$singleModel = null){
		$viewName = $moneyPayment->isDownPayment()  ?  'reports.moneyPayments.down-payments-form' : 'reports.moneyPayments.form';
		$banks = Bank::pluck('view_name','id');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$supplierInvoices = SupplierInvoice::where('company_id',$company->id)->pluck('supplier_name','id')->unique()->toArray(); 
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$suppliers =  $singleModel ?  SupplierInvoice::where('id',$singleModel)->pluck('supplier_name','supplier_id') :SupplierInvoice::where('company_id',$company->id)->pluck('supplier_name','supplier_id')->unique()->toArray(); 
		$contracts = Contract::where('company_id',$company->id)->get();
		// if($moneyPayment->isChequeUnderCollection()){
		// 	return view('reports.moneyPayments.edit-cheque-under-collection',[
		// 		'banks'=>$banks,
		// 		'supplierInvoices'=>$supplierInvoices ,
		// 		'selectedBranches'=>$selectedBranches,
		// 		'model'=>$moneyPayment,
		// 		'singleModel'=>$singleModel,
		// 		'accountTypes'=>$accountTypes,
		// 		'financialInstitutionBanks'=>$financialInstitutionBanks
		// 	]); 
		// }
        return view($viewName,[
			'banks'=>$banks,
			'suppliers'=>$suppliers,
			'contracts'=>$contracts,
			'supplierInvoices'=>$supplierInvoices ,
			'selectedBranches'=>$selectedBranches,
			'accountTypes'=>$accountTypes,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'model'=>$moneyPayment,
			'singleModel'=>$singleModel
		]);
		
	}
	
	public function update(Company $company , StoreMoneyPaymentRequest $request , moneyPayment $moneyPayment){
		
		$newType = $request->get('type');
		$moneyPayment->deleteRelations();
		$moneyPayment->delete();
		$this->store($company,$request);
		 $activeTab = $newType;
		return redirect()->route('view.money.payment',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Money Received Has Been Updated Successfully'));
	}
	
	public function destroy(Company $company , MoneyPayment $moneyPayment)
	{
		$moneyPayment->deleteRelations();
		$activeTab = $moneyPayment->getType();
		$moneyPayment->delete();
		return redirect()->route('view.money.payment',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Money Received Has Been Updated Successfully'));
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
	public function markAsPaid(Company $company,Request $request)
	{
		$moneyPaymentIds = $request->get('cheques') ;
		$moneyPaymentIds = is_array($moneyPaymentIds) ? $moneyPaymentIds :  explode(',',$moneyPaymentIds);
		$data = $request->only(['delivery_date']);
		$data['status'] = PayableCheque::PAID;
		foreach($moneyPaymentIds as $moneyPaymentId){
			$moneyPayment = MoneyPayment::find($moneyPaymentId) ;
			$moneyPayment->payableCheque->update($data);
		}
		if($request->ajax()){
			return response()->json([
				'status'=>true ,
				'msg'=>__('Good'),
				'pageLink'=>route('view.money.payment',['company'=>$company->id,'active'=>MoneyPayment::PAYABLE_CHEQUE])
			]);	
		}
		return redirect()->route('view.money.payment',['company'=>$company->id,'active'=>MoneyPayment::PAYABLE_CHEQUE]);
		
	}
	/**
	 * * تحديد ان الشيك دا تم بالفعل صرفة من البنك ونزل في حسابك
	 */
	// public function applyCollection(Company $company,Request $request,MoneyPayment $moneyPayment)
	// {
	// 	$moneyPayment->cheque->update([
	// 		'status'=>Cheque::COLLECTED,
	// 		'collection_fees'=>$request->get('collection_fees'),
	// 		'actual_collection_date'=>$request->get('actual_collection_date') 
	// 	]);
	// 	$accountType = AccountType::find($moneyPayment->cheque->account_type) ;
	// 	$paidAmount = $moneyPayment->getReceivedAmount();
	// 	$receivingDate = $moneyPayment->getReceivingDate();
	// 	$moneyType = MoneyPayment::CHEQUE;
	// 	/**
	// 	 * @var AccountType $accountType ;
	// 	 */
	// 	if($accountType && $accountType->getSlug() == AccountType::CLEAN_OVERDRAFT){
	// 		$cleanOverdraft  = CleanOverdraft::findByAccountNumber($moneyPayment->cheque->account_number);
	// 		$moneyPayment->storeCleanOverdraftBankStatement($moneyType,$cleanOverdraft,$receivingDate,$paidAmount);
	// 	}
		
	// 	return redirect()->route('view.money.payment',['company'=>$company->id,'active'=>MoneyPayment::CHEQUE_COLLECTED])->with('success',__('Cheque Is Returned To Safe'));
	// }
	
	// public function sendToSafe(Company $company,Request $request,MoneyPayment $moneyPayment)
	// {
	// 	$moneyPayment->cheque->update([
	// 		'status'=>Cheque::IN_SAFE,
	// 		'delivery_date'=>null ,
	// 		'delivery_bank_id'=>null ,
	// 		'account_type'=>null ,
	// 		'account_number'=>null ,
	// 		'account_balance'=>null ,
	// 		'expected_collection_date'=>null ,
	// 		'clearance_days'=>null
	// 	]);
	// 	return redirect()->route('view.money.payment',['company'=>$company->id,'active'=>MoneyPayment::CHEQUE])->with('success',__('Cheque Is Returned To Safe'));
	// }
	// public function sendToSafeAsRejected(Company $company,Request $request,MoneyPayment $moneyPayment)
	// {
		
	// 	$moneyPayment->cheque->update([
	// 		'status'=>Cheque::REJECTED,
	// 		'delivery_date'=>null ,
	// 		'delivery_bank_id'=>null ,
	// 		'account_type'=>null ,
	// 		'account_number'=>null ,
	// 		'account_balance'=>null ,
	// 		'expected_collection_date'=>null ,
	// 		'clearance_days'=>null
	// 	]);
	// 	return redirect()->route('view.money.payment',['company'=>$company->id,'active'=>MoneyPayment::CHEQUE_REJECTED])->with('success',__('Cheque Is Returned To Safe'));
		
	// }

	public function getAccountNumbersForAccountType(Company $company ,  Request $request ,  string $accountType,?string $selectedCurrency=null , ?int $financialInstitutionId = 0){
		$accountType = AccountType::find($accountType);
		$accountNumberModel =  ('\App\Models\\'.$accountType->getModelName())::getAllAccountNumberForCurrency($company->id , $selectedCurrency,$financialInstitutionId);
		return response()->json([
			'status'=>true , 
			'data'=>$accountNumberModel
		]);
	}
}
