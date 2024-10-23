<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreMoneyPaymentRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Contract;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\MoneyPayment;
use App\Models\OutgoingTransfer;
use App\Models\Partner;
use App\Models\PayableCheque;
use App\Models\PurchaseOrder;
use App\Models\SupplierInvoice;
use App\Models\User;
use App\Traits\GeneralFunctions;
use App\Traits\Models\HasCreditStatements;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MoneyPaymentController
{
    use GeneralFunctions , HasCreditStatements;
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
				/**
				 * @var MoneyPayment $moneyPayment
				 */
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
					$currentValue = $moneyPayment->payableCheque ? $moneyPayment->payableCheque->getDeliveryBankName() :0 ;
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
		->sortByDesc('delivery_date')->values();

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


	
		$cashPayments = $company->getMoneyPaymentCashPayments($cashPaymentsStartDate ,$cashPaymentsEndDate ) ;
		$outgoingTransfer = $company->getMoneyPaymentOutgoingTransfer($outgoingTransferStartDate,$outgoingTransferEndDate) ;
	
		$payableCheques = $company->getMoneyPaymentPayableCheques($payableChequesStartDate,$payableChequesEndDate);

		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();

		$accountTypes = AccountType::onlyCashAccounts()->get();
		$cashPayments = $moneyType == MoneyPayment::CASH_PAYMENT ? $this->applyFilter($request,$cashPayments) :$cashPayments  ;

		$outgoingTransfer = $moneyType === MoneyPayment::OUTGOING_TRANSFER ? $this->applyFilter($request,$outgoingTransfer) : $outgoingTransfer  ;

		$payableCheques = $moneyType == MoneyPayment::PAYABLE_CHEQUE ? $this->applyFilter($request,$payableCheques) : $payableCheques;


		$payableChequesTableSearchFields = [
			'supplier_name'=>__('Supplier Name'),
			'delivery_date'=>__('Payment Date'),
			'cheque_number'=>__('Cheque Number'),
			'currency'=>__('Currency'),
			'delivery_bank_id'=>__('Payment Bank'),
			'due_date'=>__('Due Date'),
			'cheque_status'=>__('Status')
		];


		

		$outgoingTransferTableSearchFields = [
			'supplier_name'=>__('Supplier Name'),
			'delivery_date'=>__('Payment Date'),
			'delivery_bank_id'=>__('Payment Bank'),
			'paid_amount'=>__('Transfer Amount'),
			'currency'=>__('Currency'),
			'account_number'=>__('Account Number')
		];

		$payableCashTableSearchFields = [
			'supplier_name'=>__('Supplier Name'),
			'delivery_date'=>__('Payment Date'),
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
			'payableCashTableSearchFields'=>$payableCashTableSearchFields,
			'outgoingTransferTableSearchFields'=>$outgoingTransferTableSearchFields,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'accountTypes'=>$accountTypes,
			'filterDates'=>$filterDates,
		]);
        return view('reports.moneyPayments.index', compact('financialInstitutionBanks','accountTypes'));
    }

	public function create(Company $company,$supplierInvoiceId = null)
	{
		$clientsWithContracts = Partner::onlyCompany($company->id)	->onlyCustomers()->onlyThatHaveContracts()->get();
		
		
		$currencies = SupplierInvoice::getCurrencies($supplierInvoiceId);
		$isDownPayment = Request()->has('type');
		$viewName = $isDownPayment  ?  'reports.moneyPayments.down-payments-form' : 'reports.moneyPayments.form';
		
		$accountTypes = AccountType::onlyCashAccounts()->get();
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$selectedCurrency = $supplierInvoiceId ? SupplierInvoice::where('id',$supplierInvoiceId)->first()->getCurrency() : null;

		// $supplierInvoices =  $singleModel ?  SupplierInvoice::where('id',$singleModel)->pluck('supplier_name','id') :SupplierInvoice::where('company_id',$company->id)->pluck('supplier_name','id')->unique()->toArray();
		$invoiceNumber = $supplierInvoiceId ? SupplierInvoice::where('id',$supplierInvoiceId)->first()->getInvoiceNumber():null;
		/**
		 * * for contracts
		 */
		$suppliers =  $supplierInvoiceId ?  Partner::where('id',SupplierInvoice::find($supplierInvoiceId)->supplier_id )
		->when($isDownPayment,function(Builder $q){
			$q->has('contracts');
		})
		->where('company_id',$company->id)->pluck('name','id')->toArray() :Partner::where('is_supplier',1)->where('company_id',$company->id)
		->when($isDownPayment,function(Builder $q){
			$q->has('contracts');
		})
		->pluck('name','id')->toArray();
	
		$contracts = [];

		
        return view($viewName,[
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'selectedBranches'=>$selectedBranches,
			'singleModel'=>$supplierInvoiceId,
			'invoiceNumber'=>$invoiceNumber,
			'currencies'=>$currencies,
			'accountTypes'=>$accountTypes,
			'suppliers'=>$suppliers,
			'contracts'=>$contracts,
			'clientsWithContracts'=>$clientsWithContracts,
			'selectedCurrency'=>$selectedCurrency
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
	public function getSalesOrdersForContract(Company $company ,  Request $request , int $contractId  = 0,?string $selectedCurrency=null)
	{
		$downPaymentId = $request->get('down_payment_id');
		$moneyPayment = MoneyPayment::find($downPaymentId);
		$purchaseOrders = PurchaseOrder::where('contract_id',$contractId)->get();
		$formattedSalesOrders = [];
		foreach($purchaseOrders as $index=>$purchaseOrder){
			$paidAmount = $moneyPayment ? $moneyPayment->downPaymentSettlements->where('purchases_order_id',$purchaseOrder->id)->first() : null ;
			$formattedSalesOrders[$index]['paid_amount'] = $paidAmount && $paidAmount->down_payment_amount ? $paidAmount->down_payment_amount : 0;
			$formattedSalesOrders[$index]['po_number'] = $purchaseOrder->po_number;
			$formattedSalesOrders[$index]['amount'] = $purchaseOrder->getAmount();
			$formattedSalesOrders[$index]['id'] = $purchaseOrder->id;
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
		$partner = Partner::find($supplierInvoiceId);
		$supplierName = $partner->getName() ;
		$invoices = SupplierInvoice::where('supplier_name',$supplierName)->where('company_id',$company->id)
		->where('net_invoice_amount','>',0);

		if(!$inEditMode){
			$invoices->where('net_balance','>',0);
		}

		$allCurrencies =$invoices->where('company_id',$company->id)->pluck('currency','currency')->mapWithKeys(function($value,$key){
			return [
				$key=>$value
			];
		});
		if($selectedCurrency){
			$invoices = $invoices->where('currency','=',$selectedCurrency);
		}
		$invoices = $invoices->orderBy('invoice_date','asc')
		->get(['invoice_number','invoice_date','invoice_due_date','net_invoice_amount','paid_amount','net_balance','currency'])
		->toArray();


		foreach($invoices as $index=>$invoiceArr){
			$invoices[$index]['settlement_amount'] = $moneyPayment ? $moneyPayment->getSettlementsForInvoiceNumberAmount($invoiceArr['invoice_number'],$supplierName,0) : 0;
			$invoices[$index]['withhold_amount'] = $moneyPayment ? $moneyPayment->getWithholdForInvoiceNumberAmount($invoiceArr['invoice_number'],$supplierName,0) : 0;
		}

		$invoices = $this->formatInvoices($invoices,$inEditMode,$moneyPayment);
		$clientsWithContracts = Partner::onlyCompany($company->id)	->onlyCustomers()->onlyThatHaveContracts()->pluck('name','id')->toArray();
		
			return response()->json([
				'status'=>true ,
				'invoices'=>$invoices,
				'currencies'=>$allCurrencies,
				'selectedCurrency'=>$selectedCurrency,
				'clientsWithContracts'=>$clientsWithContracts
			]);

	}
	protected function formatInvoices(array $invoices,int $inEditMode, $moneyPayment){
		return SupplierInvoice::formatInvoices($invoices,$inEditMode,$moneyPayment);
	}

	public function store(Company $company , StoreMoneyPaymentRequest $request , $moneyPaymentId = null){
		$hasUnappliedAmount = (bool)$request->get('unapplied_amount');
		$partnerType = $request->get('partner_type');
		$moneyType = $request->get('type');
		
		$financialInstitutionId = null;
		$contractId = $request->get('contract_id');
		$partnerId = $request->get('supplier_id');
		$supplier = Partner::find($partnerId);
		$supplierName = $supplier->getName();
		$supplierId = $supplier->id;
		$paymentBranchName = $request->get('delivery_branch_id') ;
		$data = $request->only(['type','delivery_date','currency','payment_currency','partner_type']);
		$currencyName = $data['currency'];
		$paymentCurrency = $data['payment_currency'];
		
		$data['supplier_name'] = $supplierName;
		$data['user_id'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		$isDownPayment =  $request->get('is_down_payment') && $request->has('purchases_orders_amounts');
		$isDownPaymentFromMoneyPayment = $request->get('unapplied_amount',0) > 0 ;
		$data['money_type'] =  !$isDownPayment ? 'money-payment' : 'down-payment';
		$data['money_type'] = $isDownPaymentFromMoneyPayment ? MoneyPayment::INVOICE_SETTLEMENT_WITH_DOWN_PAYMENT : $data['money_type'];


		$relationData = [];
		$relationName = null ;
		$exchangeRate = $currencyName == $paymentCurrency ? 1 : $request->input('exchange_rate.'.$moneyType,1) ;
		
		$paidAmount = $request->input('paid_amount.'.$moneyType ,0) ;
		$paidAmount = unformat_number($paidAmount);
		

		$paidAmountInPayingCurrency = $paidAmount * $exchangeRate ;
		
		if($moneyType == MoneyPayment::CASH_PAYMENT){
			$relationData = $request->only(['receipt_number']) ;
			$relationData['delivery_branch_id'] = $this->generateBranchId($paymentBranchName,$company->id) ;
			$relationData['company_id'] = $company->id ;
			$relationName = 'cashPayment';
		}
		elseif($moneyType ==MoneyPayment::OUTGOING_TRANSFER ){
			$relationName = 'outgoingTransfer';
			$financialInstitutionId = $request->input('delivery_bank_id.'.MoneyPayment::OUTGOING_TRANSFER) ;
			$relationData = [
				'delivery_bank_id'=>$financialInstitutionId,
				'actual_payment_date'=>$data['delivery_date'],
				'account_number'=>$request->input('account_number.'.MoneyPayment::OUTGOING_TRANSFER),
				'account_type'=>$request->input('account_type.'.MoneyPayment::OUTGOING_TRANSFER)
			];
		}

		elseif($moneyType ==MoneyPayment::PAYABLE_CHEQUE ){
			$relationName = 'payableCheque';
			$financialInstitutionId = $request->input('delivery_bank_id.'.MoneyPayment::PAYABLE_CHEQUE) ;
			$dueDate = $request->input('due_date') ;
			$relationData = [
				'due_date'=>$dueDate ,
				'actual_payment_date'=>$dueDate,
				'cheque_number'=>$request->input('cheque_number'),
				'delivery_bank_id'=>$financialInstitutionId,
				'account_number'=>$request->input('account_number.'.MoneyPayment::PAYABLE_CHEQUE),
				'account_type'=>$request->input('account_type.'.MoneyPayment::PAYABLE_CHEQUE),
				'company_id'=>$company->id,
			];
		}
	
		// $data['paid_amount'] = $paidAmount ;
		$data['paid_amount'] = $isDownPayment || ! $request->has('settlements') ?  $paidAmount  : array_sum(array_column($request->get('settlements'),'settlement_amount')); 
		if($partnerType && $partnerType != 'is_supplier'){
			$data['paid_amount'] = $request->input('paid_amount.'.$moneyType ,0);
		}
		$deliveryBank = FinancialInstitution::find($financialInstitutionId);
		$deliveryBankName = $deliveryBank ? $deliveryBank->getName() : null;
		$bankNameOrBranchName =  $moneyType == MoneyPayment::CASH_PAYMENT ? Branch::find($relationData['delivery_branch_id'])->getName() : $deliveryBankName ;
		
		$data['amount_in_paying_currency'] = $paidAmountInPayingCurrency ;
		$data['exchange_rate'] =$exchangeRate ;
		$data['money_type'] = $isDownPayment ? 'down-payment' : 'money-payment' ;
		$data['contract_id'] = $contractId ;
		$data['money_payment_id'] = $moneyPaymentId;

		/**
		 * @var MoneyPayment $moneyPayment ;
		 */
		if(!$isDownPayment){
			unset($data['contract_id']);
		}
		/**
		 * @var MoneyPayment $moneyPayment
		 */
		 $moneyPayment = MoneyPayment::create($data);

		 $relationData['company_id'] = $company->id ;
		 $moneyPayment->$relationName()->create($relationData);
		 $moneyPayment = $moneyPayment->refresh();
		 
		$statementDate = $moneyPayment->getStatementDate();
		$accountType = AccountType::find($request->input('account_type.'.$moneyType));
		$accountNumber = $request->input('account_number.'.$moneyType) ;
		$deliveryBranchId = $relationData['delivery_branch_id'] ?? null ;
		$moneyPayment->handleCreditStatement($company->id , $financialInstitutionId,$accountType,$accountNumber,$moneyType,$statementDate,$paidAmountInPayingCurrency,$deliveryBranchId,$paymentCurrency);
		
		if($partnerType != 'is_supplier'){
			$moneyPayment->handlePartnerDebitStatement($partnerType,$partnerId, $moneyPayment->id,$company->id,$statementDate,$paidAmountInPayingCurrency,$paymentCurrency,$bankNameOrBranchName , $accountType , $accountNumber);
		}
		/**
		 * * For Money Received Only
		 */
		$totalWithholdAmount= 0 ;
		$moneyPayment->storeNewSettlement($request->get('settlements',[]),$supplierName,$company->id);
		$moneyPayment->update([
			'total_withhold_amount'=>$totalWithholdAmount
		]);
		/**
		 * * For Contract Only
		 */
		$moneyPayment->storeNewAllocation($request->get('allocations',[]));
		
		
		// if(!$isDownPayment&&$request->get('unapplied_amount',0) > 0 && $partnerType == 'is_supplier' ){
		// 	// start store unapplied amount as new down payment
		// 	return $this->store($company,$request->replace(array_merge($request->all(),['is_down_payment'=>true],['received_amount'=>[$moneyType=>$request->get('unapplied_amount')]],['settlements'=>[]],['allocations'=>[]])),$moneyPayment->id);
			
		// }
		if($hasUnappliedAmount || $isDownPayment){
			$moneyPayment->storeNewPurchaseOrders($request->get('purchases_orders_amounts',[]),$company->id,$contractId,$supplierId);
		}
		/**
		 * @var SupplierInvoice $supplierInvoice
		 */
		$activeTab = $moneyType;
		if($request->ajax()){
			return response()->json([
				'redirectTo'=>route('view.money.payment',['company'=>$company->id,'active'=>$activeTab])
			]);
		}
		return redirect()->route('view.money.payment',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));

	}
	protected function getActiveTab(string $moneyType)
	{
		return $moneyType ;

	}
	public function edit(Company $company , Request $request , moneyPayment $moneyPayment ,$supplierInvoiceId = null){
		$clientsWithContracts = Partner::onlyCompany($company->id)	->onlyCustomers()->onlyThatHaveContracts()->get();
		$currencies = SupplierInvoice::getCurrencies($supplierInvoiceId);
		$selectedCurrency = $supplierInvoiceId ? SupplierInvoice::where('id',$supplierInvoiceId)->first()->getCurrency() : null;
		$isDownPayment = $moneyPayment->isDownPayment(); 
		$viewName = $isDownPayment  ?  'reports.moneyPayments.down-payments-form' : 'reports.moneyPayments.form';
		$banks = Bank::pluck('view_name','id');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		// $supplierInvoices = SupplierInvoice::where('company_id',$company->id)->pluck('supplier_name','id')->unique()->toArray();
		$accountTypes = AccountType::onlyCashAccounts()->get();
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$suppliers =  $supplierInvoiceId ?  Partner::where('id',CustomerInvoice::find($supplierInvoiceId)->supplier_id )->where('company_id',$company->id)->has('contracts')->pluck('name','id')->toArray() :Partner::where('is_supplier',1)->where('company_id',$company->id)->has('contracts')->pluck('name','id')->toArray();
		/**
		 * * for contracts
		 */
		$suppliers =  $supplierInvoiceId ?  Partner::where('id',SupplierInvoice::find($supplierInvoiceId)->supplier_id )
		->when($isDownPayment,function(Builder $q){
			$q->has('contracts');
		})
		->where('company_id',$company->id)->pluck('name','id')->toArray() :Partner::where('is_supplier',1)->where('company_id',$company->id)
		->when($isDownPayment,function(Builder $q){
			$q->has('contracts');
		})
		->pluck('name','id')->toArray();
		
		$contracts = Contract::where('company_id',$company->id)->get();
		
        return view($viewName,[
			'banks'=>$banks,
			'suppliers'=>$suppliers,
			'contracts'=>$contracts,
			// 'supplierInvoices'=>$supplierInvoices ,
			'selectedBranches'=>$selectedBranches,
			'accountTypes'=>$accountTypes,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'model'=>$moneyPayment,
			'singleModel'=>$supplierInvoiceId,
			'currencies'=>$currencies,
			'clientsWithContracts'=>$clientsWithContracts ,
			'selectedCurrency'=>$selectedCurrency
		]);

	}

	public function update(Company $company , StoreMoneyPaymentRequest $request , moneyPayment $moneyPayment){

		$newType = $request->get('type');
		$moneyPayment->deleteRelations();
		$moneyPayment->delete();
		$this->store($company,$request);
		 $activeTab = $newType;
		 if($request->ajax()){
			return response()->json([
				'redirectTo'=>route('view.money.payment',['company'=>$company->id,'active'=>$activeTab])
			]);
		}
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
	public function markChequesAsPaid(Company $company,Request $request)
	{
		$moneyPaymentIds = $request->get('cheques') ;
		$moneyPaymentIds = is_array($moneyPaymentIds) ? $moneyPaymentIds :  explode(',',$moneyPaymentIds);
		$data = $request->only(['actual_payment_date']);
		$actualPaymentDate = $request->get('actual_payment_date');
		$data['status'] = PayableCheque::PAID;
		foreach($moneyPaymentIds as $moneyPaymentId){
			/**
			 * @var MoneyPayment $moneyPayment
			 */
			$moneyPayment = MoneyPayment::find($moneyPaymentId) ;
			$currentPaidAmount = $moneyPayment->getAmount();
			$balancesResultJsonResponse = ((new MoneyReceivedController())->updateNetBalanceBasedOnAccountNumber($request,$company,$moneyPayment->getPayableChequeAccountType(),$moneyPayment->getPayableChequeAccountNumber(),$moneyPayment->getPayableChequePaymentBankId(),$actualPaymentDate));
			$netBalance = $balancesResultJsonResponse->getData()->net_balance;
			$errMessage = __('Net Balance Less Than Paid Amount');
			// if(true){
			if($netBalance < $currentPaidAmount){
				if($request->ajax()){
			
					return response()->json([
						'status'=>false ,
						'msg'=>$errMessage = __('Net Balance Less Than Paid Amount'),
						'pageLink'=>route('view.money.payment',['company'=>$company->id,'active'=>MoneyPayment::PAYABLE_CHEQUE])
					]);
				}
			
				return redirect()->back()->with('fail',$errMessage);
			}
			// $chequeDueDate = $moneyPayment->payableCheque->due_date;
			$moneyPayment->payableCheque->update($data);
			if($moneyPayment->getCurrentStatement()){
				$time = now()->format('H:i:s');
				$moneyPayment->getCurrentStatement()->update([
					'date'=>$actualPaymentDate = $data['actual_payment_date'],
					'full_date' =>date('Y-m-d H:i:s', strtotime("$actualPaymentDate $time")),
					'updated_at'=>now()
				]);

			}

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
	public function markOutgoingTransfersAsPaid(Company $company,Request $request)
	{
		$moneyPaymentIds = $request->get('cheques') ;
		$moneyPaymentIds = is_array($moneyPaymentIds) ? $moneyPaymentIds :  explode(',',$moneyPaymentIds);
		$data = $request->only(['actual_payment_date']);
		$data['status'] = OutgoingTransfer::PAID;
		foreach($moneyPaymentIds as $moneyPaymentId){
			$moneyPayment = MoneyPayment::find($moneyPaymentId) ;
			// $chequeDueDate = $moneyPayment->outgoingTransfer->due_date;
			$moneyPayment->outgoingTransfer->update($data);
			if($moneyPayment->getCurrentStatement()){
				$time = now()->format('H:i:s');
				$moneyPayment->getCurrentStatement()->update([
					'date'=>$actualPaymentDate = $data['actual_payment_date'],
					'full_date' =>date('Y-m-d H:i:s', strtotime("$actualPaymentDate $time")),
					'updated_at'=>now()
				]);

			}

		}
		if($request->ajax()){
			return response()->json([
				'status'=>true ,
				'msg'=>__('Good'),
				'pageLink'=>route('view.money.payment',['company'=>$company->id,'active'=>MoneyPayment::OUTGOING_TRANSFER])
			]);
		}
		return redirect()->route('view.money.payment',['company'=>$company->id,'active'=>MoneyPayment::OUTGOING_TRANSFER]);

	}

	public function getAccountNumbersForAccountType(Company $company ,  Request $request ,  string $accountType,?string $selectedCurrency=null , ?int $financialInstitutionId = 0){
		$accountType = AccountType::find($accountType);
		$accountNumberModel =  ('\App\Models\\'.$accountType->getModelName())::getAllAccountNumberForCurrency($company->id , $selectedCurrency,$financialInstitutionId);
		return response()->json([
			'status'=>true ,
			'data'=>$accountNumberModel
		]);
	}
	
	public function getSuppliersBasedOnCurrency(Request $request , Company $company , string $currencyName){
		return response()->json([
			'supplierInvoices'=>SupplierInvoice::where('currency',$currencyName)->where('company_id',$company->id)->pluck('supplier_name','supplier_id')
		]);
	}
	public function getCurrentAccountEndBalance(Request $request , Company $company){
		$branchId = $request->get('branchId');
		$currencyName = $request->get('currencyName');
		/**
		 * @var Branch $branch
		 */
		$branch = Branch::find($branchId);
		$endBalance = $branch->getCurrentEndBalance($company->id,$currencyName);
		return response()->json([
			'end_balance'=>$endBalance
		]);
		
	}
	
}
