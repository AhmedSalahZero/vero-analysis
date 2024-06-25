<?php
namespace App\Http\Controllers;

use App\Enums\LgTypes;
use App\Models\AccountType;
use App\Models\CertificatesOfDeposit;
use App\Models\Company;
use App\Models\Contract;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Models\LetterOfGuaranteeFacility;
use App\Models\LetterOfGuaranteeIssuance;
use App\Models\LetterOfGuaranteeIssuanceAdvancedPaymentHistory;
use App\Models\LetterOfGuaranteeStatement;
use App\Models\Partner;
use App\Models\PurchaseOrder;
use App\Models\TimeOfDeposit;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LetterOfGuaranteeIssuanceController
{
    use GeneralFunctions;
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
			return $collection->filter(function($letterOfGuaranteeIssuance) use ($value,$searchFieldName){
				$currentValue = $letterOfGuaranteeIssuance->{$searchFieldName} ;
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
		$activeLgType = $request->get('active',LgTypes::BID_BOND) ;
		$filterDates = [];
		$searchFields = [];
		$models = [];
		foreach(getLgTypes() as $type=>$typeNameFormatted){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
			$models[$type]   = $company->letterOfGuaranteeIssuances->where('lg_type',$type) ;

			if($type == $activeLgType ){
				$models[$type]   = $this->applyFilter($request,$models[$type],$filterDates[$type]['startDate'] , $filterDates[$type]['endDate']) ;
			}
			$searchFields[$type] =  [
				'transaction_name'=>__('Transaction Name'),
				'lg_code'=>__('LG Code'),
				'purchase_order_date'=>__('Purchase Order Date'),
				'issuance_date'=>__('Issuance Date')
			];

		}


        return view('reports.LetterOfGuaranteeIssuance.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'models'=>$models,
			'filterDates'=>$filterDates,
			'currentActiveTab'=>$activeLgType
		]);
    }
	public function commonViewVars(Company $company,string $source):array
	{
		$cdOrTdAccountTypes = [];
		if($source == LetterOfGuaranteeIssuance::AGAINST_CD){
			$cdOrTdAccountTypes = AccountType::onlyCdAccounts()->get();
		}
		elseif($source == LetterOfGuaranteeIssuance::AGAINST_TD){
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
        return view('reports.LetterOfGuaranteeIssuance.'.$formName,array_merge(
			$this->commonViewVars($company,$source) ,
			[

			]
		));
    }
	public function getCommonDataArr():array
	{
		return ['contract_start_date','contract_end_date','currency','limit'];
	}
	public function store(Company $company  , Request $request , string $source){

		$financialInstitutionId = $request->get('financial_institution_id') ;
		$letterOfGuaranteeFacility = $source == LetterOfGuaranteeIssuance::LG_FACILITY  ? FinancialInstitution::find($financialInstitutionId)->getCurrentAvailableLetterOfGuaranteeFacility() : null;
		$letterOfGuaranteeFacilityId =  null ; 
		if($source == LetterOfGuaranteeIssuance::LG_FACILITY && is_null($letterOfGuaranteeFacility)){
			return redirect()->back()->with('fail',__('No Available Letter Of Guarantee Facility Found !'));
		}
		if($letterOfGuaranteeFacility instanceof LetterOfGuaranteeFacility){
			$letterOfGuaranteeFacilityId = $letterOfGuaranteeFacility->id ;
		}
		$model = new LetterOfGuaranteeIssuance();
		$lgCommissionAmount = $request->get('lg_commission_amount',0);
		$minLgCommissionAmount = $request->get('min_lg_commission_fees',0);
		$model->storeBasicForm($request);
		$lgType = $request->get('lg_type');
		$issuanceDate = $request->get('issuance_date');
		$lgAmount = $request->get('lg_amount',0);
		$currency = $request->get('lg_currency',0);
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
	
		$maxLgCommissionAmount = max($minLgCommissionAmount ,$lgCommissionAmount );
		$financialInstitutionAccountId = FinancialInstitutionAccount::findByAccountNumber($request->get('cash_cover_deducted_from_account_number'),$company->id , $financialInstitutionId)->id;
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$cashCoverAmount , $financialInstitutionAccountId);
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$issuanceFees , $financialInstitutionAccountId);
		$model->handleLetterOfGuaranteeStatement($financialInstitutionId,$source,$letterOfGuaranteeFacilityId , $lgType,$company->id , $issuanceDate ,0 ,0,$lgAmount,$currency,0,$cdOrTdId,'credit-lg-amount');
		$model->handleLetterOfGuaranteeCashCoverStatement($financialInstitutionId,$source,$letterOfGuaranteeFacilityId , $lgType,$company->id , $issuanceDate ,0 ,$cashCoverAmount,0,$currency,0,'credit-lg-amount');
		
		$lgDurationMonths = $request->get('lg_duration_months',1);
		$numberOfIterationsForQuarter = ceil($lgDurationMonths / 3); 
		$lgCommissionInterval = $request->get('lg_commission_interval');
		if($lgCommissionInterval == 'quarterly'){
			for($i = 0 ; $i< (int)$numberOfIterationsForQuarter ; $i++ ){
				$currentDate = Carbon::make($issuanceDate)->addMonth($i * 3)->format('Y-m-d');
				$isActive = now()->greaterThanOrEqualTo($currentDate);
				$model->storeCurrentAccountCreditBankStatement($currentDate,$maxLgCommissionAmount , $financialInstitutionAccountId,0,$isActive);
			}
		}else{
			$model->storeCurrentAccountCreditBankStatement($issuanceDate,$maxLgCommissionAmount , $financialInstitutionAccountId);
		}
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$request->get('lg_type')])->with('success',__('Data Store Successfully'));

	}

	public function edit(Company $company , Request $request , LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance,string $source){
		$formName = $source.'-form';
        return view('reports.LetterOfGuaranteeIssuance.'.$formName,array_merge(
			$this->commonViewVars($company,$source) ,
			[
				'model'=>$letterOfGuaranteeIssuance
			]
		));

	}

	public function update(Company $company , Request $request , LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance,string $source){
		$letterOfGuaranteeIssuance->deleteAllRelations();
		$letterOfGuaranteeIssuance->delete();
		$this->store($company,$request,$source);
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$request->get('lg_type')])->with('success',__('Data Store Successfully'));
	}

	


		/**
		 * * هنرجعه تاني لل
		 * * running
		 * * اكنه كان عامله انه اتلغى بالغلط
	 */
	public function bankToRunningStatus(Company $company,Request $request,LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance,string $source)
	{
		$letterOfGuaranteeIssuanceStatus = LetterOfGuaranteeIssuance::RUNNING ;
		/**
		 * * هنشيل قيم ال
		 * * letter of guarantee statement
		 */
		// $financialInstitutionId = $letterOfGuaranteeIssuance->financial_institution_id ;

		 $letterOfGuaranteeIssuance->update([
			'status' => $letterOfGuaranteeIssuanceStatus,
			'cancellation_date'=>null
		]);
	
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->letterOfGuaranteeStatements->where('status',LetterOfGuaranteeIssuance::FOR_CANCELLATION));
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->letterOfGuaranteeCashCoverStatements->where('status',LetterOfGuaranteeIssuance::FOR_CANCELLATION));
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->currentAccountBankStatements);
		
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$request->get('lg_type')])->with('success',__('Data Store Successfully'));
	}
	
	
		/**
	 * * هنا اليوزر هيعكس عملية الكسر اللي كان اكدها اكنه عملها بالغلط فا هنرجع كل حاجه زي ما كانت ونحذف القيم اللي في جدول ال
	 * * letter of guarantee statements
	 */
	public function cancel(Company $company,Request $request,LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance,string $source)
	{
		$letterOfGuaranteeIssuanceStatus = LetterOfGuaranteeIssuance::CANCELLED ;

		/**
		 * * هنشيل قيم ال
		 * * letter of guarantee statement
		 */
		$financialInstitutionId = $letterOfGuaranteeIssuance->financial_institution_id ;

		$cancellationDate = $request->get('cancellation_date',now()->format('Y-m-d')) ;
		 $letterOfGuaranteeIssuance->update([
			'status' => $letterOfGuaranteeIssuanceStatus,
			'cancellation_date'=>$cancellationDate
		]);
		$letterOfGuaranteeFacility = FinancialInstitution::find($financialInstitutionId)->getCurrentAvailableLetterOfGuaranteeFacility();
		$lgType = $letterOfGuaranteeIssuance->getLgType();
		$amount = $letterOfGuaranteeIssuance->getLgAmount();
		$cashCoverAmount = $letterOfGuaranteeIssuance->getCashCoverAmount();
		$letterOfGuaranteeFacilityId = $letterOfGuaranteeFacility ? $letterOfGuaranteeFacility->id : null ;
		$letterOfGuaranteeIssuance->handleLetterOfGuaranteeStatement($financialInstitutionId,$source,$letterOfGuaranteeFacilityId,$lgType,$company->id,$cancellationDate,0,$amount , 0,$letterOfGuaranteeIssuance->getLgCurrency(),0,$letterOfGuaranteeIssuance->getCdOrTdId(),LetterOfGuaranteeIssuance::FOR_CANCELLATION);
		$letterOfGuaranteeIssuance->handleLetterOfGuaranteeCashCoverStatement($financialInstitutionId,$source,$letterOfGuaranteeFacilityId,$lgType,$company->id,$cancellationDate,0,0 , $cashCoverAmount ,$letterOfGuaranteeIssuance->getLgCurrency(),0,LetterOfGuaranteeIssuance::FOR_CANCELLATION);
		$financialInstitutionAccountId = FinancialInstitutionAccount::findByAccountNumber($letterOfGuaranteeIssuance->getCashCoverDeductedFromAccountNumber(),$company->id , $financialInstitutionId)->id;
		$letterOfGuaranteeIssuance->storeCurrentAccountDebitBankStatement($cancellationDate,$cashCoverAmount , $financialInstitutionAccountId,0,$letterOfGuaranteeIssuance->id);
			
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$request->get('lg_type')])->with('success',__('Data Store Successfully'));
	}
	
	
	/**
	 * * دلوقت دا خطاب ضمان .. فا اليوزر بيدخول يقول انا سددت جزء فلاني من قيمة ال
	 * * lg amount
	 * * وبالتالي بنقص القيمة دي من اللي الفلوس من قيمة ال
	 * * lg amount
	 * * بس في نفس الوقت بنحتفظ بقيمة ال
	 * * lg amount 
	 * * الاصليه علشان التقارير
	 * * letter of guarantee statements
	 */
	public function applyAmountToBeDecreased(Company $company,Request $request,LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance,string $source)
	{
		
		$financialInstitutionId = $letterOfGuaranteeIssuance->financial_institution_id ;
		/**
		 * @var LetterOfGuaranteeIssuanceAdvancedPaymentHistory $letterOfGuaranteeIssuanceAdvancedPaymentHistory
		 */
		$letterOfGuaranteeIssuanceAdvancedPaymentHistory = new LetterOfGuaranteeIssuanceAdvancedPaymentHistory();
		$decreaseDate = $request->get('date',now()->format('Y-m-d')) ;
		$decreaseDate = Carbon::make($decreaseDate)->format('Y-m-d');
		$decreaseAmount = $request->get('amount',0);
		
		$cashCoverAmount = $letterOfGuaranteeIssuance->getCasCoverRate() /100  * $decreaseAmount ;
		$letterOfGuaranteeFacility = $source == LetterOfGuaranteeIssuance::LG_FACILITY  ? FinancialInstitution::find($financialInstitutionId)->getCurrentAvailableLetterOfGuaranteeFacility() : null;
		$letterOfGuaranteeFacilityId =  null ; 
		$lgType =$letterOfGuaranteeIssuance->getLgType();
		$currency = $letterOfGuaranteeIssuance->getLgCurrency();
		$cdOrTdId = $letterOfGuaranteeIssuance->getCdOrTdId() ;
		$financialInstitutionAccountId = FinancialInstitutionAccount::findByAccountNumber($letterOfGuaranteeIssuance->getCashCoverDeductedFromAccountNumber(),$company->id , $financialInstitutionId)->id;
		
		if($source == LetterOfGuaranteeIssuance::LG_FACILITY && is_null($letterOfGuaranteeFacility)){
			return redirect()->back()->with('fail',__('No Available Letter Of Guarantee Facility Found !'));
		}
		if($letterOfGuaranteeFacility instanceof LetterOfGuaranteeFacility){
			$letterOfGuaranteeFacilityId = $letterOfGuaranteeFacility->id ;
		}
		
		$letterOfGuaranteeIssuanceAdvancedPaymentHistory = $letterOfGuaranteeIssuance->advancedPaymentHistories()->create([
			'date'=>$decreaseDate,
			'amount'=>$decreaseAmount,
			'company_id'=>$company->id 
		]);
		
		$letterOfGuaranteeIssuanceAdvancedPaymentHistory->handleLetterOfGuaranteeStatement($financialInstitutionId,$source,$letterOfGuaranteeFacilityId , $lgType,$company->id , $decreaseDate ,0 ,$decreaseAmount,0,$currency,$letterOfGuaranteeIssuanceAdvancedPaymentHistory->id,$cdOrTdId,LetterOfGuaranteeIssuance::AMOUNT_TO_BE_DECREASED);
		$letterOfGuaranteeIssuanceAdvancedPaymentHistory->handleLetterOfGuaranteeCashCoverStatement($financialInstitutionId,$source,$letterOfGuaranteeFacilityId,$lgType,$company->id,$decreaseDate,0,0 , $cashCoverAmount ,$currency,$letterOfGuaranteeIssuanceAdvancedPaymentHistory->id,LetterOfGuaranteeIssuance::AMOUNT_TO_BE_DECREASED);
		$letterOfGuaranteeIssuanceAdvancedPaymentHistory->storeCurrentAccountDebitBankStatement($decreaseDate,$cashCoverAmount , $financialInstitutionAccountId,$letterOfGuaranteeIssuanceAdvancedPaymentHistory->id,$letterOfGuaranteeIssuance->id);
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$letterOfGuaranteeIssuance->getLgType()])->with('success',__('Data Store Successfully'));
	}
	
	public function editAmountToBeDecreased(Company $company,Request $request,LetterOfGuaranteeIssuanceAdvancedPaymentHistory $lgAdvancedPaymentHistory,string $source)
	{
		$decreaseDate = Carbon::make($request->get('decrease_date',now()->format('Y-m-d')));
		$decreaseAmount = $request->get('amount_to_be_decreased',0);
		$lgAdvancedPaymentHistory->update([
			'amount'=>$decreaseAmount , 
			'date'=>$decreaseDate
		]);
		$letterOfGuaranteeIssuance = $lgAdvancedPaymentHistory->letterOfGuaranteeIssuance;
		$financialInstitutionId = $letterOfGuaranteeIssuance->financial_institution_id ;
		/**
		 * @var LetterOfGuaranteeIssuanceAdvancedPaymentHistory $lgAdvancedPaymentHistory
		 */

		$cashCoverAmount = $letterOfGuaranteeIssuance->getCasCoverRate() /100  * $decreaseAmount ;
	
		$letterOfGuaranteeFacility = $source == LetterOfGuaranteeIssuance::LG_FACILITY  ? FinancialInstitution::find($financialInstitutionId)->getCurrentAvailableLetterOfGuaranteeFacility() : null;

		if($source == LetterOfGuaranteeIssuance::LG_FACILITY && is_null($letterOfGuaranteeFacility)){
			return redirect()->back()->with('fail',__('No Available Letter Of Guarantee Facility Found !'));
		}
		
		
		
		$lgAdvancedPaymentHistory->letterOfGuaranteeStatements->where('type',LetterOfGuaranteeIssuance::AMOUNT_TO_BE_DECREASED)->first()->update([
			'date'=>$decreaseDate,
			'debit'=>$decreaseAmount
		]);
		$lgAdvancedPaymentHistory->letterOfGuaranteeCashCoverStatements->where('type',LetterOfGuaranteeIssuance::AMOUNT_TO_BE_DECREASED)->first()->update([
			'credit'=>$cashCoverAmount,
			'date'=>$decreaseDate 
		]);
		$lgAdvancedPaymentHistory->currentAccountDebitBankStatement->update([
			'debit'=>$cashCoverAmount,
			'date'=>$decreaseDate
		]);

		return response()->json([
			'status'=>true ,
			'reloadCurrentPage'=>true 
		]);
		// return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$letterOfGuaranteeIssuance->getLgType()])->with('success',__('Data Store Successfully'));
	}
	
	/**
	 * * هنا اليوزر هيعكس عملية الكسر اللي كان اكدها اكنه عملها بالغلط فا هنرجع كل حاجه زي ما كانت ونحذف القيم اللي في جدول ال
	 * * letter of guarantee statements
	 */
	public function deleteAdvancedPayment(Company $company,Request $request,LetterOfGuaranteeIssuanceAdvancedPaymentHistory $lgAdvancedPaymentHistory)
	{
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($lgAdvancedPaymentHistory->letterOfGuaranteeStatements);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($lgAdvancedPaymentHistory->letterOfGuaranteeCashCoverStatements);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($lgAdvancedPaymentHistory->currentAccountBankStatements);
		$lgAdvancedPaymentHistory->delete();
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$lgAdvancedPaymentHistory->letterOfGuaranteeIssuance->getLgType()])->with('success',__('Data Store Successfully'));
	
		
	}
	


	public function destroy(Company $company ,  LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance)
	{
		
		
		$letterOfGuaranteeIssuance->deleteAllRelations();
		
		$lgType = $letterOfGuaranteeIssuance->getLgType();

		$letterOfGuaranteeIssuance->delete();
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$lgType]);
	}
	


}
