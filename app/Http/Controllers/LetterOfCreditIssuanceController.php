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
use App\Models\TimeOfDeposit;
use App\Traits\GeneralFunctions;
use App\Traits\Models\HasCreditStatements;
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
		// $dateFieldName = $searchFieldName === 'balance_date' ? 'balance_date' : 'created_at';
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
		->sortByDesc('id');

		return $collection;
	}
	public function index(Company $company,Request $request)
	{

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
			'currentActiveTab'=>$activeLcType
		]);
    }
	public function commonViewVars(Company $company,string $source):array
	{
		$cdOrTdAccountTypes = [];
		if($source == LetterOfCreditIssuance::AGAINST_CD){
			$cdOrTdAccountTypes = AccountType::onlyCdAccounts()->get();
		}
		elseif($source == LetterOfCreditIssuance::AGAINST_TD){
			$cdOrTdAccountTypes = AccountType::onlyTdAccounts()->get();
		}
		
		return [
			'financialInstitutionBanks'=> FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->onlyForSource($source)->get(),
			'beneficiaries'=>Partner::onlyCustomers()->onlyForCompany($company->id)->get(),
			'contracts'=>Contract::onlyForCompany($company->id)->get(),
			'purchaseOrders'=>PurchaseOrder::onlyForCompany($company->id)->get(),
			'accountTypes'=> AccountType::onlyCurrentAccount()->get(),
			'source'=>$source,
			'cdOrTdAccountTypes'=>$cdOrTdAccountTypes
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
		$lcType = $request->get('lc_type');
		$issuanceDate = $request->get('issuance_date');
		$lcAmount = $request->get('lc_amount',0);
		$currency = $request->get('lc_currency',0);
		$cdOrTdAccountNumber = $request->get('cd_or_td_account_number');
		$cdOrTdAccountTypeId = $request->get('cd_or_td_account_type_id');
	
		$accountType = AccountType::find($cdOrTdAccountTypeId);
		$cdOrTdId = 0 ;
		if($accountType && $accountType->isCertificateOfDeposit()){
			$cdOrTdId = CertificatesOfDeposit::findByAccountNumber($cdOrTdAccountNumber , $company->id )->id;
		}
		elseif($accountType && $accountType->isTimeOfDeposit()){
			$cdOrTdId = TimeOfDeposit::findByAccountNumber($cdOrTdAccountNumber,$company->id )->id;
		}
		$cashCoverAmount = $request->get('cash_cover_amount',0);
		$issuanceFees = $request->get('issuance_fees',0);
	
		$maxLcCommissionAmount = max($minLcCommissionAmount ,$lcCommissionAmount );
		$financialInstitutionAccountId = FinancialInstitutionAccount::findByAccountNumber($request->get('cash_cover_deducted_from_account_number'),$company->id , $financialInstitutionId)->id;
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$cashCoverAmount , $financialInstitutionAccountId);
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$issuanceFees , $financialInstitutionAccountId);
		$model->handleLetterOfCreditStatement($financialInstitutionId,$source,$letterOfCreditFacilityId , $lcType,$company->id , $issuanceDate ,0 ,0,$lcAmount,$currency,0,$cdOrTdId,'credit-lc-amount');
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
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$maxLcCommissionAmount , $financialInstitutionAccountId);
		return redirect()->route('view.letter.of.credit.issuance',['company'=>$company->id,'active'=>$request->get('lc_type')])->with('success',__('Data Store Successfully'));

	}

	public function edit(Company $company , Request $request , LetterOfCreditIssuance $letterOfCreditIssuance,string $source){
		$formName = $source.'-form';
        return view('reports.LetterOfCreditIssuance.'.$formName,array_merge(
			$this->commonViewVars($company,$source) ,
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
		// $financialInstitutionId = $letterOfCreditIssuance->financial_institution_id ;

		 $letterOfCreditIssuance->update([
			'status' => $letterOfCreditIssuanceStatus,
			'payment_date'=>null
		]);
	
		LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditIssuance->letterOfCreditStatements->where('status',LetterOfCreditIssuance::FOR_PAID));
		LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditIssuance->letterOfCreditCashCoverStatements->where('status',LetterOfCreditIssuance::FOR_PAID));
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
		$cashCoverAmount = $letterOfCreditIssuance->getCashCoverAmount();
		$diffBetweenLcAmountAndCashCover = $lcAmount - $cashCoverAmount ;
		$letterOfCreditFacilityId = $letterOfCreditFacility ? $letterOfCreditFacility->id : 0 ;
		$letterOfCreditIssuance->handleLetterOfCreditStatement($financialInstitutionId,$source,$letterOfCreditFacilityId,$lcType,$company->id,$paymentDate,0,$lcAmount , 0,$letterOfCreditIssuance->getLcCurrency(),0,$letterOfCreditIssuance->getCdOrTdId(),LetterOfCreditIssuance::FOR_PAID);
		$letterOfCreditIssuance->handleLetterOfCreditCashCoverStatement($financialInstitutionId,$source,$letterOfCreditFacilityId,$lcType,$company->id,$paymentDate,0,0 , $cashCoverAmount ,$letterOfCreditIssuance->getLcCurrency(),0,LetterOfCreditIssuance::FOR_PAID);
		// $financialInstitutionAccountId = FinancialInstitutionAccount::findByAccountNumber($letterOfCreditIssuance->getCashCoverDeductedFromAccountNumber(),$company->id , $financialInstitutionId)->id;
		$letterOfCreditIssuance->handleLcCreditBankStatement('credit',$paymentDate,$diffBetweenLcAmountAndCashCover,$source);
		// lc_overdraft 
		// credit 
		// وهنزود الحساب دا في ال
		// internal money transfer 
		
		// $letterOfCreditIssuance->storeCurrentAccountDebitBankStatement($paymentDate,$cashCoverAmount , $financialInstitutionAccountId,0,$letterOfCreditIssuance->id);
		return redirect()->route('view.letter.of.credit.issuance',['company'=>$company->id,'active'=>$request->get('lc_type')])->with('success',__('Data Store Successfully'));
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

}
