<?php
namespace App\Http\Controllers;

use App\Enums\LcTypes;
use App\Models\AccountType;
use App\Models\CertificatesOfDeposit;
use App\Models\Company;
use App\Models\Contract;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Models\LcIssuanceExpense;
use App\Models\LetterOfCreditFacility;
use App\Models\LetterOfCreditIssuance;
use App\Models\LetterOfCreditStatement;
use App\Models\Partner;
use App\Models\PurchaseOrder;
use App\Models\SupplierInvoice;
use App\Models\TimeOfDeposit;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LetterOfCreditIssuanceController
{
    use GeneralFunctions ;
    protected function applyFilter(Request $request,Collection $collection,string $filterStartDate = null, string $filterEndDate = null ):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName =  'issuance_date' ; // change it
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($letterOfCreditIssuance) use ($value,$searchFieldName){
				$currentValue = $letterOfCreditIssuance->{$searchFieldName} ;
				return false !== stristr($currentValue , $value);
			});
		})
		->when($request->get('from') , function($collection) use($dateFieldName,$from){
			return $collection->where($dateFieldName,'>=',$from);
		})
		->when($request->get('to') , function($collection) use($dateFieldName,$to){
			return $collection->where($dateFieldName,'<=',$to);
		})
		->when($filterStartDate , function($collection) use ($filterStartDate,$filterEndDate){
			return $collection->filterByIssuanceDate($filterStartDate,$filterEndDate);
		})
		->sortByDesc('id')->values();

		return $collection;
	}
	public function index(Company $company,Request $request)
	{
		$clientsWithContracts = Partner::onlyCompany($company->id)	->onlyCustomers()->onlyThatHaveContracts()->get();

		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$activeLcType = $request->get('active',LcTypes::SIGHT_LC) ;
		$filterDates = [];
		$searchFields = [];
		$models = [];
		foreach(getLcTypes() as $type=>$typeNameFormatted){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
			$models[$type]   = $company->letterOfCreditIssuances->where('lc_type',$type) ;

			if($type == $activeLcType ){
				$models[$type]   = $this->applyFilter($request,$models[$type],$filterDates[$type]['startDate'] , $filterDates[$type]['endDate']) ;
			}
			$searchFields[$type] =  [
				'transaction_name'=>__('Transaction Name'),
				'lc_code'=>__('LC Code'),
				'purchase_order_date'=>__('Purchase Order Date'),
				'issuance_date'=>__('Issuance Date')
			];

		}


        return view('reports.LetterOfCreditIssuance.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'models'=>$models,
			'filterDates'=>$filterDates,
			'currentActiveTab'=>$activeLcType,
			'clientsWithContracts'=>$clientsWithContracts
		]);
    }
	public function commonViewVars(Company $company,string $source,?LetterOfCreditIssuance $letterOfCreditIssuance = null):array
	{
		
		$cdOrTdAccountTypes = [];
		$tdOrCdCurrencyName = null ;
		if($source == LetterOfCreditIssuance::AGAINST_CD){
			$cdOrTdAccountTypes = AccountType::onlyCdAccounts()->get();
			if($letterOfCreditIssuance){
				$currentCertificateOfDeposit = CertificatesOfDeposit::findByAccountNumber($letterOfCreditIssuance->cd_or_td_account_number,$company->id);
				$tdOrCdCurrencyName = $currentCertificateOfDeposit->getCurrency();
			}
		}
		elseif($source == LetterOfCreditIssuance::AGAINST_TD){
			$cdOrTdAccountTypes = AccountType::onlyTdAccounts()->get();
			if($letterOfCreditIssuance){
				$currentTimeOfDeposit = TimeOfDeposit::findByAccountNumber($letterOfCreditIssuance->cd_or_td_account_number,$company->id);
				$tdOrCdCurrencyName = $currentTimeOfDeposit->getCurrency();
				
			}
		}
		return [
			'financialInstitutionBanks'=> FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->onlyForSource($source)->get(),
			'beneficiaries'=>Partner::onlySuppliers()->onlyForCompany($company->id)->get(),
			'contracts'=>Contract::onlyForCompany($company->id)->get(),
			'purchaseOrders'=>PurchaseOrder::onlyForCompany($company->id)->get(),
			'accountTypes'=> AccountType::onlyCurrentAccount()->get(),
			'source'=>$source,
			'cdOrTdAccountTypes'=>$cdOrTdAccountTypes,
			'tdOrCdCurrencyName'=>$tdOrCdCurrencyName,
		];

	}
	public function create(Company $company,string $source)

	{
		$formName = $source.'-form';
        return view('reports.LetterOfCreditIssuance.'.$formName,array_merge(
			$this->commonViewVars($company,$source) ,
			[

			]
		));
    }
	// public function getCommonDataArr():array
	// {
	// 	return ['contract_start_date','contract_end_date','currency','limit'];
	// }
	public function store(Company $company  , Request $request , string $source){

		$financialInstitutionId = $request->get('financial_institution_id') ;
		$letterOfCreditFacility = $source == LetterOfCreditIssuance::LC_FACILITY  ? FinancialInstitution::find($financialInstitutionId)->getCurrentAvailableLetterOfCreditFacility() : null;
		$letterOfCreditFacilityId =  0 ; 
		if($source == LetterOfCreditIssuance::LC_FACILITY && is_null($letterOfCreditFacility)){
			return redirect()->back()->with('fail',__('No Available Letter Of Credit Facility Found !'));
		}
		if($letterOfCreditFacility instanceof LetterOfCreditFacility){
			$letterOfCreditFacilityId = $letterOfCreditFacility->id ;
		}
		$model = new LetterOfCreditIssuance();
		$lcCommissionAmount = $request->get('lc_commission_amount',0);
		$minLcCommissionAmount = $request->get('min_lc_commission_fees',0);
		$model->storeBasicForm($request);
		$transactionName = $request->get('transaction_name');
		$lcType = $request->get('lc_type');
		$issuanceDate = $request->get('issuance_date');
		$lcAmount = $request->get('lc_amount',0);
		$currency = $request->get('lc_currency',0);
		$cdOrTdAccountNumber = $request->get('cd_or_td_account_number');
		$cdOrTdAccountTypeId = $request->get('cd_or_td_account_type_id');
		$accountType = AccountType::find($cdOrTdAccountTypeId);
		$cdOrTdId = 0 ;
		$cdOrTdAccount = null ;
		if($accountType && $accountType->isCertificateOfDeposit()){
			$cdOrTdAccount = CertificatesOfDeposit::findByAccountNumber($cdOrTdAccountNumber , $company->id ) ;
			$cdOrTdId = $cdOrTdAccount->id;
		}
		elseif($accountType && $accountType->isTimeOfDeposit()){
			$cdOrTdAccount = TimeOfDeposit::findByAccountNumber($cdOrTdAccountNumber,$company->id ) ;
			$cdOrTdId = $cdOrTdAccount->id;
		}
		$lcCashCoverOrCdOrTdCurrency = $model->getLcCashCoverCurrency() ?: $cdOrTdAccount->getCurrency();

		$cashCoverAmount = $request->get('cash_cover_amount',0);
		$issuanceFees = $request->get('issuance_fees',0);
		$lcAmountInMainCurrency = $model->getLcAmountInMainCurrency();
		$maxLcCommissionAmount = max($minLcCommissionAmount ,$lcCommissionAmount );
		$financialInstitutionAccountId = FinancialInstitutionAccount::findByAccountNumber($request->get('cash_cover_deducted_from_account_number'),$company->id , $financialInstitutionId)->id;
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$cashCoverAmount , $financialInstitutionAccountId,0,1,__('Cash Cover [ :lcType ] Transaction Name [ :transactionName ]'  ,['lcType'=>__($lcType,[],'en'),'transactionName'=>$transactionName],'en') , __('Cash Cover [ :lcType ] Transaction Name [ :transactionName ]'  ,['lcType'=>__($lcType,[],'ar'),'transactionName'=>$transactionName],'ar'));
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$issuanceFees , $financialInstitutionAccountId,0,1,__('Issuance Fees [ :lcType ] Transaction Name [ :transactionName ]'  ,['lcType'=>__($lcType,[],'en'),'transactionName'=>$transactionName],'en') , __('Issuance Fees [ :lcType ] Transaction Name [ :transactionName ]'  ,['lcType'=>__($lcType,[],'ar'),'transactionName'=>$transactionName],'ar'));
		$model->handleLetterOfCreditStatement($financialInstitutionId,$source,$letterOfCreditFacilityId , $lcType,$company->id , $issuanceDate ,0 ,0,$lcAmountInMainCurrency,$lcCashCoverOrCdOrTdCurrency,0,$cdOrTdId,'credit-lc-amount');
		$model->handleLetterOfCreditCashCoverStatement($financialInstitutionId,$source,$letterOfCreditFacilityId , $lcType,$company->id , $issuanceDate ,0 ,$cashCoverAmount,0,$currency,0,'credit-lc-amount');
		
		// $lcDurationMonths = $request->get('lc_duration_months',1);
		// $numberOfIterationsForQuarter = ceil($lcDurationMonths / 3); 
		// $lcCommissionInterval = $request->get('lc_commission_interval');
		// if($lcCommissionInterval == 'quarterly'){
		// 	for($i = 0 ; $i< (int)$numberOfIterationsForQuarter ; $i++ ){
		// 		$currentDate = Carbon::make($issuanceDate)->addMonth($i * 3)->format('Y-m-d');
		// 		$isActive = now()->greaterThanOrEqualTo($currentDate);
		// 		$model->storeCurrentAccountCreditBankStatement($currentDate,$maxLcCommissionAmount , $financialInstitutionAccountId,0,$isActive);
		// 	}
		// }else{
		// }
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$maxLcCommissionAmount , $financialInstitutionAccountId,0,1,__('Commission Fees [ :lcType ] Transaction Name [ :transactionName ]'  ,['lcType'=>__($lcType,[],'en'),'transactionName'=>$transactionName],'en') , __('Commission Fees [ :lcType ] Transaction Name [ :transactionName ]'  ,['lcType'=>__($lcType,[],'ar'),'transactionName'=>$transactionName],'ar'));
		return redirect()->route('view.letter.of.credit.issuance',['company'=>$company->id,'active'=>$request->get('lc_type')])->with('success',__('Data Store Successfully'));

	}

	public function edit(Company $company , Request $request , LetterOfCreditIssuance $letterOfCreditIssuance,string $source){
		$formName = $source.'-form';

        return view('reports.LetterOfCreditIssuance.'.$formName,array_merge(
			$this->commonViewVars($company,$source,$letterOfCreditIssuance) ,
			[
				'model'=>$letterOfCreditIssuance
			]
		));

	}

	public function update(Company $company , Request $request , LetterOfCreditIssuance $letterOfCreditIssuance,string $source){
		$letterOfCreditIssuance->deleteAllRelations();
		$letterOfCreditIssuance->delete();
		$this->store($company,$request,$source);
		return redirect()->route('view.letter.of.credit.issuance',['company'=>$company->id,'active'=>$request->get('lc_type')])->with('success',__('Data Store Successfully'));
	}

	


		/**
		 * * هنرجعه تاني لل
		 * * running
		 * * اكنه كان عامله انه اتلغى بالغلط
	 */
	public function bankToRunningStatus(Company $company,Request $request,LetterOfCreditIssuance $letterOfCreditIssuance,string $source)
	{
		$letterOfCreditIssuanceStatus = LetterOfCreditIssuance::RUNNING ;
		/**
		 * * هنشيل قيم ال
		 * * letter of credit statement
		 */

		 $letterOfCreditIssuance->update([
			'status' => $letterOfCreditIssuanceStatus,
			'payment_date'=>null
		]);
	
		LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditIssuance->settlements);
		LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditIssuance->letterOfCreditStatements->where('type',LetterOfCreditIssuance::FOR_PAID));
		LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditIssuance->letterOfCreditCashCoverStatements->where('type',LetterOfCreditIssuance::FOR_PAID));
		LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditIssuance->lcOverdraftBankStatements->where('source',$source));
		
		return redirect()->route('view.letter.of.credit.issuance',['company'=>$company->id,'active'=>$request->get('lc_type')])->with('success',__('Data Store Successfully'));
	}
	
	
		/**
	* * هنا هو بيحدد ان الخطاب الاعتماد دا انتهى وبالتالي هنبعت للبائع مثلا او للموريد اللي في امريكا مثلا الفلوس علي حسابة
	 * * letter of credit statements
	 */
	public function markAsPaid(Company $company,Request $request,LetterOfCreditIssuance $letterOfCreditIssuance,string $source)
	{

		
		$letterOfCreditIssuanceStatus = LetterOfCreditIssuance::PAID ;
		$lcType = $request->get('lc_type') ;
		/**
		 * * هنشيل قيم ال
		 * * letter of credit statement
		 */
		$financialInstitutionId = $letterOfCreditIssuance->financial_institution_id ;
	
		$paymentDate = $request->get('payment_date',now()->format('Y-m-d')) ;

		 $letterOfCreditIssuance->update([
			'status' => $letterOfCreditIssuanceStatus,
			'payment_date'=>$paymentDate
		]);
		$letterOfCreditFacility = FinancialInstitution::find($financialInstitutionId)->getCurrentAvailableLetterOfCreditFacility();
		$lcType = $letterOfCreditIssuance->getLcType();
		$lcAmount = $letterOfCreditIssuance->getLcAmount();
		$lcAmountInMainCurrency = $letterOfCreditIssuance->getLcAmountInMainCurrency();
	
		$cashCoverAmount = $letterOfCreditIssuance->getCashCoverAmount();
		
		$diffBetweenLcAmountAndCashCover = ($lcAmountInMainCurrency - $cashCoverAmount) *  $letterOfCreditFacility->getBorrowingRate() / 100 ;
		LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditIssuance->letterOfCreditStatements->where('type',LetterOfCreditIssuance::FOR_PAID));
		LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditIssuance->letterOfCreditCashCoverStatements->where('type',LetterOfCreditIssuance::FOR_PAID));
		LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditIssuance->lcOverdraftBankStatements->where('source',$source));
		$letterOfCreditFacilityId = $letterOfCreditFacility ? $letterOfCreditFacility->id : 0 ;
		$letterOfCreditCurrency = $source == LetterOfCreditIssuance::AGAINST_TD || $source == LetterOfCreditIssuance::AGAINST_CD ? $letterOfCreditIssuance->getTdOrCdCurrency($source,$company->id) : $letterOfCreditIssuance->getLcCashCoverCurrency() ;
		$letterOfCreditIssuance->handleLetterOfCreditStatement($financialInstitutionId,$source,$letterOfCreditFacilityId,$lcType,$company->id,$paymentDate,0,$lcAmountInMainCurrency , 0,$letterOfCreditCurrency,0,$letterOfCreditIssuance->getCdOrTdId(),LetterOfCreditIssuance::FOR_PAID);
		$letterOfCreditIssuance->handleLetterOfCreditCashCoverStatement($financialInstitutionId,$source,$letterOfCreditFacilityId,$lcType,$company->id,$paymentDate,0,0 , $cashCoverAmount ,$letterOfCreditIssuance->getLcCurrency(),0,LetterOfCreditIssuance::FOR_PAID);
		// $financialInstitutionAccountId = FinancialInstitutionAccount::findByAccountNumber($letterOfCreditIssuance->getCashCoverDeductedFromAccountNumber(),$company->id , $financialInstitutionId)->id;
		if($source != LetterOfCreditIssuance::HUNDRED_PERCENTAGE_CASH_COVER){
			$letterOfCreditIssuance->handleLcCreditBankStatement('credit',$paymentDate,$diffBetweenLcAmountAndCashCover,$source);
		}
		// lc_overdraft 
		// credit 
		// وهنزود الحساب دا في ال
		// internal money transfer 
		
		// Money Payment 
		// $supplierId = $request->get('supplier_id');
		$supplierInvoiceId = $request->get('supplier_invoice_id');
		$supplierInvoice = SupplierInvoice::find($supplierInvoiceId);
		$letterOfCreditIssuance->storeNewSettlementAfterDeleteOldOne($supplierInvoice,$company);
		$letterOfCreditIssuance->storeNewAllocationAfterDeleteOldOne($request->get('allocations',[]));
		return redirect()->route('view.letter.of.credit.issuance',['company'=>$company->id,'active'=>$lcType])->with('success',__('Data Store Successfully'));
	}
	
	
	
	


	public function destroy(Company $company ,  LetterOfCreditIssuance $letterOfCreditIssuance)
	{
		
		
		$letterOfCreditIssuance->deleteAllRelations();
		
		$lcType = $letterOfCreditIssuance->getLcType();

		$letterOfCreditIssuance->delete();
		return redirect()->route('view.letter.of.credit.issuance',['company'=>$company->id,'active'=>$lcType]);
	}
	public function getLcIssuanceExpenseData(Request $request,Company $company,$type):array
	{
		/**
		 * *  $type create or update
		 */
		return 
		[
			'expense_name'=>$request->input('expense_name.'.$type),
			'date'=>Carbon::make($request->input('date.'.$type))->format('Y-m-d'),
			'amount'=>$request->input('amount.'.$type),
			'exchange_rate'=>$request->input('exchange_rate.'.$type),
			'currency'=>$request->input('currency.'.$type),
			'amount_in_main_currency'=>$request->input('amount_in_main_currency.'.$type),
			'company_id'=>$company->id 
		];
	}
	public function applyExpense(Company $company,Request $request,LetterOfCreditIssuance $letterOfCreditIssuance , $type='create')
	{
		/**
		 * @var LcIssuanceExpense $lcIssuanceExpense
		 */
		$date = Carbon::make($request->input('date.'.$type))->format('Y-m-d') ;
		$amount = $request->input('amount.'.$type,0);
		$accountNumber = $letterOfCreditIssuance->getCashCoverDeductedFromAccountNumber();
		$financialInstitutionId = $letterOfCreditIssuance->getFinancialInstitutionId() ;
		$financialInstitutionAccount = FinancialInstitutionAccount::findByAccountNumber($accountNumber , $company->id , $financialInstitutionId);
		$financialInstitutionAccountId =$financialInstitutionAccount->id ; 
		
		$lcIssuanceExpense = $letterOfCreditIssuance->expenses()->create($this->getLcIssuanceExpenseData($request,$company,$type));
		$lcIssuanceExpense->storeCurrentAccountCreditBankStatement($date,$amount , $financialInstitutionAccountId);
		return redirect()->route('view.letter.of.credit.issuance',['company'=>$company->id])->with('success',__('Expense Credit Successfully'));
		// return redirect()->back()->with('success',__('Expense Credit Successfully'));
	}
	public function updateExpense(Company $company,Request $request,LcIssuanceExpense $expense)
	{
		$expense->delete();
		$letterOfCreditIssuance = $expense->letterOfCreditIssuance ;
		$this->applyExpense($company,$request,$letterOfCreditIssuance,'update');
		return response()->json([
			'reloadCurrentPage'=>true
		]);
	}
	public function deleteExpense(Company $company,Request $request,LcIssuanceExpense $expense)
	{

		
		// protected static function boot() 
		// $expense->deleteAllRelations();
		$expense->delete();
		return redirect()->back()->with('success',__('Expense Deleted Successfully'));
	}
	public function getRemainingBalance(Company $company , Request $request){
		$letterOfCreditIssuance = LetterOfCreditIssuance::find($request->get('letterOfCreditIssuanceId'));
		$remainingBalance = $letterOfCreditIssuance->getRemainingBalance();
		return response()->json([
			'status'=>true ,
			'remaining_balance'=> $remainingBalance
		]);
	}

}
