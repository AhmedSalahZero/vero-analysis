<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCashExpenseRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\CashExpense;
use App\Models\CashExpenseCategory;
use App\Models\Company;
use App\Models\Contract;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\OutgoingTransfer;
use App\Models\Partner;
use App\Models\PayableCheque;
use App\Models\SupplierInvoice;
use App\Models\User;
use App\Traits\GeneralFunctions;
use App\Traits\Models\HasCreditStatements;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CashExpenseController
{
    use GeneralFunctions , HasCreditStatements;
    protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName = $searchFieldName === 'due_date' ? 'due_date' : 'payment_date';
		if($searchFieldName =='payment_date'){
			$dateFieldName = 'payment_date';
		}
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($cashExpense) use ($value,$searchFieldName){
				/**
				 * @var CashExpense $cashExpense
				 */
				$currentValue = $cashExpense->{$searchFieldName} ;
				// $cashExpenseRelationName cash-in-safe -> cashInSafe relation ship name
				$cashExpenseRelationName = dashesToCamelCase(Request('active')) ;
				$relationRecord = $cashExpense->$cashExpenseRelationName ;
				/**
				 * * بمعني لو مالقناش القيمة في جدول ال
				 * * cashExpense
				 * * هندور عليها في العلاقه
				 */
				$currentValue = is_null($currentValue) && $relationRecord ? $relationRecord->{$searchFieldName}  :$currentValue ;
				if($searchFieldName == 'delivery_branch_id'){
					$currentValue = $cashExpense->getCashPaymentBranchName() ;
				}
				if($searchFieldName == 'delivery_bank_id'){
					$currentValue = $cashExpense->payableCheque ? $cashExpense->payableCheque->getDeliveryBankName() :0 ;
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
		->sortByDesc('payment_date')->values();

		return $collection;
	}
	public function index(Company $company,Request $request)
	{
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$moneyType = $request->get('active',CashExpense::CASH_PAYMENT) ;
		$filterDates = [];
		foreach(CashExpense::getAllTypes() as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');

			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		// cash
		$cashPaymentsStartDate = $filterDates[CashExpense::CASH_PAYMENT]['startDate'] ?? null ;
		$cashPaymentsEndDate = $filterDates[CashExpense::CASH_PAYMENT]['endDate'] ?? null ;


			// outgoing transfer
			$outgoingTransferStartDate = $filterDates[CashExpense::OUTGOING_TRANSFER]['startDate'] ?? null ;
			$outgoingTransferEndDate = $filterDates[CashExpense::OUTGOING_TRANSFER]['endDate'] ?? null ;

		/**
		 * * cheques in safe
		 */
		$payableChequesStartDate = $filterDates[CashExpense::PAYABLE_CHEQUE]['startDate'] ?? null ;
		$payableChequesEndDate = $filterDates[CashExpense::PAYABLE_CHEQUE]['endDate'] ?? null ;

		/**
		 * * rejected cheques
		 */
		// $chequesRejectedStartDate = $filterDates[CashExpense::CHEQUE_REJECTED]['startDate'] ?? null ;
		// $chequesRejectedEndDate = $filterDates[CashExpense::CHEQUE_REJECTED]['endDate'] ?? null ;






	
		
		$cashPayments = $company->getCashExpenseCashPayments($cashPaymentsStartDate ,$cashPaymentsEndDate ) ;

		$outgoingTransfer = $company->getCashExpenseOutgoingTransfer($outgoingTransferStartDate,$outgoingTransferEndDate) ;
		$payableCheques = $company->getCashExpensePayableCheques($payableChequesStartDate,$payableChequesEndDate);
		// $receivedRejectedChequesInSafe = $user->getReceivedRejectedChequesInSafe($chequesRejectedStartDate,$chequesRejectedEndDate);
		// $receivedChequesUnderCollection=  $user->getReceivedChequesUnderCollection($chequesUnderCollectionStartDate,$chequesUnderCollectionEndDate);
		// $collectedCheques=  $user->getCollectedCheques($chequesCollectedStartDate,$chequesCollectedEndDate);
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();

		$accountTypes = AccountType::onlyCashAccounts()->get();
		$cashPayments = $moneyType == CashExpense::CASH_PAYMENT ? $this->applyFilter($request,$cashPayments) :$cashPayments  ;
		$outgoingTransfer = $moneyType === CashExpense::OUTGOING_TRANSFER ? $this->applyFilter($request,$outgoingTransfer) : $outgoingTransfer  ;


		$payableCheques = $moneyType == CashExpense::PAYABLE_CHEQUE ? $this->applyFilter($request,$payableCheques) : $payableCheques;


		// $receivedRejectedChequesInSafe = $moneyType == CashExpense::CHEQUE_REJECTED ? $this->applyFilter($request,$receivedRejectedChequesInSafe) : $receivedRejectedChequesInSafe;

		// $receivedChequesUnderCollection=  $moneyType == CashExpense::CHEQUE_UNDER_COLLECTION ? $this->applyFilter($request,$receivedChequesUnderCollection) : $receivedChequesUnderCollection ;

		// $collectedCheques=  $moneyType == CashExpense::CHEQUE_COLLECTED ? $this->applyFilter($request,$collectedCheques) : $collectedCheques ;


		$payableChequesTableSearchFields = [
			// 'supplier_name'=>__('Supplier Name'),
			'payment_date'=>__('Payment Date'),
			'cheque_number'=>__('Cheque Number'),
			'currency'=>__('Currency'),
			'delivery_bank_id'=>__('Payment Bank'),
			'due_date'=>__('Due Date'),
			'cheque_status'=>__('Status')
		];


		// $chequesRejectedTableSearchFields = [
		// 	'supplier_name'=>__('Supplier Name'),
		// 	'payment_date'=>__('Delivery Date'),
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
		// 	'payment_date'=>__('Deposit Date'),
		// 	'delivery_bank_id'=>__('Delivery Bank'),
		// 	'clearance_days'=>'Clearance Days'
		// ];

		// $collectedChequesTableSearchFields = [
		// 	'supplier_name'=>__('Supplier Name'),
		// 	'cheque_number'=>__('Cheque Number'),
		// 	'paid_amount'=>__('Cheque Amount'),
		// 	'payment_date'=>__('Deposit Date'),
		// 	'delivery_bank_id'=>__('Delivery Bank'),
		// 	'clearance_days'=>'Clearance Days'
		// ];

		$outgoingTransferTableSearchFields = [
			// 'supplier_name'=>__('Supplier Name'),
			'payment_date'=>__('Payment Date'),
			'delivery_bank_id'=>__('Payment Bank'),
			'paid_amount'=>__('Transfer Amount'),
			'currency'=>__('Currency'),
			'account_number'=>__('Account Number')
		];



		$payableCashTableSearchFields = [
			// 'supplier_name'=>__('Supplier Name'),
			'payment_date'=>__('Payment Date'),
			'delivery_branch_id'=>__('Branch'),
			'paid_amount'=>__('Paid Amount'),
			'currency'=>__('Currency'),
			'receipt_number'=>__('Receipt Number')
		];





		$accountTypes = AccountType::onlyCashAccounts()->get();
        return view('reports.cashExpenses.index', [
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
        return view('reports.cashExpenses.index', compact('financialInstitutionBanks','accountTypes'));
    }

	public function create(Company $company,$supplierInvoiceId = null)
	{
		$contractsRelationName = 'contracts' ;
		
		$currencies = getCurrencies();
		$viewName =  'reports.cashExpenses.form';
		$clientsWithContracts = Partner::onlyCompany($company->id)	->onlyCustomers()->onlyThatHaveContracts()->get();
		$accountTypes = AccountType::onlyCashAccounts()->get();
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
	
		$cashExpenseCategories = CashExpenseCategory::where('company_id',$company->id)->get()->formattedForSelect(true,'getId','getName');
        return view($viewName,[
			'clientsWithContracts'=>$clientsWithContracts,
			'contractsRelationName'=>$contractsRelationName,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'cashExpenseCategories'=>$cashExpenseCategories,
			'selectedBranches'=>$selectedBranches,
			'singleModel'=>$supplierInvoiceId,
			'currencies'=>$currencies,
			'accountTypes'=>$accountTypes,
		]);
    }

	public function result(Company $company , Request $request){

		return view('reports.cashExpenses.form',[
		]);
	}

	public function store(Company $company , StoreCashExpenseRequest $request){
		$moneyType = $request->get('type');
		$bankId = null;
		$paymentBranchName = $request->get('delivery_branch_id') ;
		$data = $request->only(['type','payment_date','currency','cash_expense_category_name_id']);
		$currencyName = $data['currency'];
		$data['user_id'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;

		$relationData = [];
		$relationName = null ;
		$exchangeRate =  $request->input('exchange_rate.'.$moneyType,1) ;
		
		$paidAmount = $request->input('paid_amount.'.$moneyType ,0) ;
		$paidAmount = unformat_number($paidAmount);
		

		$paidAmountInPayingCurrency = $paidAmount * $exchangeRate ;
		
		if($moneyType == CashExpense::CASH_PAYMENT){
			$relationData = $request->only(['receipt_number']) ;
			$relationData['delivery_branch_id'] = $this->generateBranchId($paymentBranchName,$company->id) ;
			$relationName = 'cashPayment';
		}
		elseif($moneyType ==CashExpense::OUTGOING_TRANSFER ){
			$relationName = 'outgoingTransfer';
			$bankId = $request->input('delivery_bank_id.'.CashExpense::OUTGOING_TRANSFER) ;
			$relationData = [
				'delivery_bank_id'=>$bankId,
				'actual_payment_date'=>$data['payment_date'],
				'account_number'=>$request->input('account_number.'.CashExpense::OUTGOING_TRANSFER),
				'account_type'=>$request->input('account_type.'.CashExpense::OUTGOING_TRANSFER)
			];
		}

		elseif($moneyType ==CashExpense::PAYABLE_CHEQUE ){
			$relationName = 'payableCheque';
			$bankId = $request->input('delivery_bank_id.'.CashExpense::PAYABLE_CHEQUE) ;
			$dueDate = $request->input('due_date') ;
			$relationData = [
				'due_date'=>$dueDate ,
				'actual_payment_date'=>$dueDate,
				'cheque_number'=>$request->input('cheque_number'),
				'delivery_bank_id'=>$bankId,
				'account_number'=>$request->input('account_number.'.CashExpense::PAYABLE_CHEQUE),
				'account_type'=>$request->input('account_type.'.CashExpense::PAYABLE_CHEQUE),
				'company_id'=>$company->id,
			];
		}
		$data['paid_amount'] = $paidAmount ;
		$data['amount_in_paying_currency'] = $paidAmountInPayingCurrency ;
		$data['exchange_rate'] =$exchangeRate ;
		/**
		 * @var CashExpense $cashExpense ;
		 */


	
		$cashExpense = CashExpense::create($data);


		 $relationData['company_id'] = $company->id ;
		 $cashExpense->$relationName()->create($relationData);
		 $cashExpense = $cashExpense->refresh();
		 
		$statementDate = $cashExpense->getStatementDate();
		$accountType = AccountType::find($request->input('account_type.'.$moneyType));
		$accountNumber = $request->input('account_number.'.$moneyType) ;
		$deliveryBranchId = $relationData['delivery_branch_id'] ?? null ;
		$cashExpense->handleCreditStatement($company->id , $bankId,$accountType,$accountNumber,$moneyType,$statementDate,$paidAmountInPayingCurrency,$deliveryBranchId,$currencyName);
		$contracts = $request->get('contracts',[]) ;
		if(count($contracts)){
			foreach($contracts as $contractArr){
				$currentContractId = $contractArr['contract_id'];
				$currentAmount = $contractArr['amount'] ?? 0 ;
				$cashExpense->contracts()->attach(
					$currentContractId,
					['amount'=>$currentAmount],
				);
			} 
			
		}
		/**
		 * * For Money Received Only
		 */
		// if($request->get('unapplied_amount',0) > 0 ){
		// 	$cashExpense->unappliedAmounts()->create([
		// 		'amount'=>$request->get('unapplied_amount'),
		// 		'partner_id'=>$supplier->id,
		// 		'settlement_date'=>$request->get('payment_date'),
		// 		'company_id'=>$company->id,
		// 		'net_balance_until_date'=>0,
		// 		'model_id'=>$cashExpense->id,
		// 		'model_type'=>HHelpers::getClassNameWithoutNameSpace($cashExpense),
		// 		'currency'=>$currencyName
		// 	]);
		// }
		/**
		 * * For Money Received Only
		 */
		// $totalWithholdAmount= 0 ;
		// foreach($request->get('settlements',[]) as $settlementArr)
		// {
		// 	$settlementArr['settlement_amount']  = isset($settlementArr['settlement_amount']) ? unformat_number($settlementArr['settlement_amount']) : 0 ;
		// 	if($settlementArr['settlement_amount'] > 0){
		// 		$settlementArr['company_id'] = $company->id ;
		// 		$settlementArr['supplier_name'] = $supplierName ;
		// 		$withholdAmount = isset($settlementArr['withhold_amount']) ? unformat_number($settlementArr['withhold_amount']) : 0;
		// 		$settlementArr['withhold_amount'] = $withholdAmount ;
		// 		$totalWithholdAmount +=   $withholdAmount;
		// 		unset($settlementArr['net_balance']);
		// 		$cashExpense->settlements()->create($settlementArr);
		// 	}
		// }
		/**
		 * * For Contract Only
		 */
		// foreach($request->get('purchases_orders_amounts',[]) as $salesOrderReceivedAmountArr)
		// {
		// 	if(isset($salesOrderReceivedAmountArr['paid_amount'])&&$salesOrderReceivedAmountArr['paid_amount'] > 0){
		// 		$salesOrderReceivedAmountArr['company_id'] = $company->id ;
		// 		$cashExpense->downPaymentSettlements()->create(array_merge(
		// 			$salesOrderReceivedAmountArr ,
		// 			[
		// 				'contract_id'=>$contractId,
		// 				'supplier_id'=>$supplierId,
		// 				'down_payment_amount'=>$salesOrderReceivedAmountArr['paid_amount']
		// 				]
		// 			));
		// 	}
		// }


		// $cashExpense->update([
		// 	'total_withhold_amount'=>$totalWithholdAmount
		// ]);
		/**
		 * @var SupplierInvoice $supplierInvoice
		 */
		$activeTab = $moneyType;
		return response()->json([
			'redirectTo'=>route('view.cash.expense',['company'=>$company->id,'active'=>$activeTab])
		]);

	}
	protected function getActiveTab(string $moneyType)
	{
		return $moneyType ;

	}
	public function edit(Company $company , Request $request , cashExpense $cashExpense ,$supplierInvoiceId = null){
		$currencies = getCurrencies();
		$contractsRelationName = 'contracts' ;
		$clientsWithContracts = Partner::onlyCompany($company->id)	->onlyCustomers()->onlyThatHaveContracts()->get();
		
		// $currencies = DB::table('customer_invoices')
		// ->select('currency')
		// ->where('company_id',$company->id)
		// ->where('currency','!=','')
		// ->get()
		// ->unique('currency')->pluck('currency','currency');
		
		
		$cashExpenseCategories = CashExpenseCategory::where('company_id',$company->id)->get()->formattedForSelect(true,'getId','getName');
		
		// $isDownPayment = false; 
		$viewName =  'reports.cashExpenses.form';
		$viewName =  'reports.cashExpenses.form';
		$banks = Bank::pluck('view_name','id');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		// $supplierInvoices = SupplierInvoice::where('company_id',$company->id)->pluck('supplier_name','id')->unique()->toArray();
		$accountTypes = AccountType::onlyCashAccounts()->get();
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		// $suppliers =  $supplierInvoiceId ?  Partner::where('id',CustomerInvoice::find($supplierInvoiceId)->supplier_id )->where('company_id',$company->id)->has('contracts')->pluck('name','id')->toArray() :Partner::where('is_supplier',1)->where('company_id',$company->id)->has('contracts')->pluck('name','id')->toArray();
		/**
		 * * for contracts
		 */
		// $suppliers =  $supplierInvoiceId ?  Partner::where('id',SupplierInvoice::find($supplierInvoiceId)->supplier_id )
		// ->when($isDownPayment,function(Builder $q){
		// 	$q->has('contracts');
		// })
		// ->where('company_id',$company->id)->pluck('name','id')->toArray() :Partner::where('is_supplier',1)->where('company_id',$company->id)
		// ->when($isDownPayment,function(Builder $q){
		// 	$q->has('contracts');
		// })
		// ->pluck('name','id')->toArray();
		
		// $contracts = Contract::where('company_id',$company->id)->get();
		// if($cashExpense->isChequeUnderCollection()){
		// 	return view('reports.cashExpenses.edit-cheque-under-collection',[
		// 		'banks'=>$banks,
		// 		'supplierInvoices'=>$supplierInvoices ,
		// 		'selectedBranches'=>$selectedBranches,
		// 		'model'=>$cashExpense,
		// 		'singleModel'=>$singleModel,
		// 		'accountTypes'=>$accountTypes,
		// 		'financialInstitutionBanks'=>$financialInstitutionBanks
		// 	]);
		// }
        return view($viewName,[
			'banks'=>$banks,
			'clientsWithContracts'=>$clientsWithContracts,
			'contractsRelationName'=>$contractsRelationName,
			'cashExpenseCategories'=>$cashExpenseCategories,
			// 'suppliers'=>$suppliers,
			// 'contracts'=>$contracts,
			// 'supplierInvoices'=>$supplierInvoices ,
			'selectedBranches'=>$selectedBranches,
			'accountTypes'=>$accountTypes,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'model'=>$cashExpense,
			'singleModel'=>$supplierInvoiceId,
			'currencies'=>$currencies
		]);

	}

	public function update(Company $company , StoreCashExpenseRequest $request , cashExpense $cashExpense){

		$newType = $request->get('type');
		$cashExpense->deleteRelations();
		$cashExpense->delete();
		$this->store($company,$request);
		 $activeTab = $newType;
		 return response()->json([
			'redirectTo'=>route('view.cash.expense',['company'=>$company->id,'active'=>$activeTab])
		]);
	}

	public function destroy(Company $company , CashExpense $cashExpense)
	{
		$cashExpense->deleteRelations();
		$activeTab = $cashExpense->getType();
		$cashExpense->delete();
		return redirect()->route('view.cash.expense',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Money Received Has Been Updated Successfully'));
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
		$cashExpenseIds = $request->get('cheques') ;
		$cashExpenseIds = is_array($cashExpenseIds) ? $cashExpenseIds :  explode(',',$cashExpenseIds);
		$data = $request->only(['actual_payment_date']);
		$data['status'] = PayableCheque::PAID;
		foreach($cashExpenseIds as $cashExpenseId){
			$cashExpense = CashExpense::find($cashExpenseId) ;
			$chequeDueDate = $cashExpense->payableCheque->due_date;
			$cashExpense->payableCheque->update($data);
			if($cashExpense->getCurrentStatement()){
				$time = now()->format('H:i:s');
				$cashExpense->getCurrentStatement()->update([
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
				'pageLink'=>route('view.cash.expense',['company'=>$company->id,'active'=>CashExpense::PAYABLE_CHEQUE])
			]);
		}
		return redirect()->route('view.cash.expense',['company'=>$company->id,'active'=>CashExpense::PAYABLE_CHEQUE]);

	}
	public function markOutgoingTransfersAsPaid(Company $company,Request $request)
	{
		$cashExpenseIds = $request->get('cheques') ;
		$cashExpenseIds = is_array($cashExpenseIds) ? $cashExpenseIds :  explode(',',$cashExpenseIds);
		$data = $request->only(['actual_payment_date']);
		$data['status'] = OutgoingTransfer::PAID;
		foreach($cashExpenseIds as $cashExpenseId){
			$cashExpense = CashExpense::find($cashExpenseId) ;
			// $chequeDueDate = $cashExpense->outgoingTransfer->due_date;
			$cashExpense->outgoingTransfer->update($data);
			if($cashExpense->getCurrentStatement()){
				$time = now()->format('H:i:s');
				$cashExpense->getCurrentStatement()->update([
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
				'pageLink'=>route('view.cash.expense',['company'=>$company->id,'active'=>CashExpense::OUTGOING_TRANSFER])
			]);
		}
		return redirect()->route('view.cash.expense',['company'=>$company->id,'active'=>CashExpense::OUTGOING_TRANSFER]);

	}

	public function getAccountNumbersForAccountType(Company $company ,  Request $request ,  string $accountType,?string $selectedCurrency=null , ?int $financialInstitutionId = 0){
		$accountType = AccountType::find($accountType);
		$accountNumberModel =  ('\App\Models\\'.$accountType->getModelName())::getAllAccountNumberForCurrency($company->id , $selectedCurrency,$financialInstitutionId);
		return response()->json([
			'status'=>true ,
			'data'=>$accountNumberModel
		]);
	}
}
