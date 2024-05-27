<?php
namespace App\Http\Controllers;

use App\Enums\LgTypes;
use App\Models\AccountType;
use App\Models\Company;
use App\Models\Contract;
use App\Models\CurrentAccountBankStatement;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Models\LetterOfGuaranteeIssuance;
use App\Models\LetterOfGuaranteeStatement;
use App\Models\Partner;
use App\Models\PurchaseOrder;
use App\Traits\GeneralFunctions;
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
				// if($searchFieldName == 'bank_id'){
				// 	$currentValue = $letterOfGuaranteeIssuance->getBankName() ;
				// }
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
		return [
			'financialInstitutionBanks'=> FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->onlyForSource($source)->get(),
			'beneficiaries'=>Partner::onlyCustomers()->onlyForCompany($company->id)->get(),
			'contracts'=>Contract::onlyForCompany($company->id)->get(),
			'purchaseOrders'=>PurchaseOrder::onlyForCompany($company->id)->get(),
			'accountTypes'=> AccountType::onlyCurrentAccount()->get(),
			'source'=>$source,
		];

	}
	public function create(Company $company,string $source)

	{
		// dd();
        return view('reports.LetterOfGuaranteeIssuance.form',array_merge(
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
		$letterOfGuaranteeFacility = FinancialInstitution::find($financialInstitutionId)->getCurrentAvailableLetterOfGuaranteeFacility();
		$model = new LetterOfGuaranteeIssuance();
		$model->storeBasicForm($request);
		$lgType = $request->get('lg_type');
		$issuanceDate = $request->get('issuance_date');
		$lgAmount = $request->get('lg_amount',0);
		$currency = $request->get('lg_currency',0);
		$cashCoverAmount = $request->get('cash_cover_amount',0);
		$issuanceFees = $request->get('issuance_fees',0);
		$lgCommissionAmount = $request->get('lg_commission_amount',0);
		$minLgCommissionAmount = $request->get('min_lg_commission_fees',0);
		$maxLgCommissionAmount = max($minLgCommissionAmount ,$lgCommissionAmount );
		$financialInstitutionAccountId = FinancialInstitutionAccount::findByAccountNumber($request->get('cash_cover_deducted_from_account_number'),$company->id , $financialInstitutionId)->id;
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$cashCoverAmount , $financialInstitutionAccountId);
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$issuanceFees , $financialInstitutionAccountId);
		$model->storeCurrentAccountCreditBankStatement($issuanceDate,$maxLgCommissionAmount , $financialInstitutionAccountId);
		$model->handleLetterOfGuaranteeStatement($financialInstitutionId,$source,$letterOfGuaranteeFacility->id , $lgType,$company->id , $issuanceDate ,0 ,0,$lgAmount,$currency,'credit-lg-amount');
		$model->handleLetterOfGuaranteeCashCoverStatement($financialInstitutionId,$source,$letterOfGuaranteeFacility->id , $lgType,$company->id , $issuanceDate ,0 ,$cashCoverAmount,0,$currency,'credit-lg-amount');
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$request->get('lg_type')])->with('success',__('Data Store Successfully'));

	}

	public function edit(Company $company , Request $request , LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance,string $source){
        return view('reports.LetterOfGuaranteeIssuance.form',array_merge(
			$this->commonViewVars($company,$source) ,
			[
				'model'=>$letterOfGuaranteeIssuance
			]
		));

	}

	public function update(Company $company , Request $request , LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance,string $source){
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->letterOfGuaranteeStatements);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->letterOfGuaranteeCashCoverStatements);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->currentAccountBankStatements);
		$letterOfGuaranteeIssuance->delete();
		$this->store($company,$request,$source);
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
		$letterOfGuaranteeIssuance->handleLetterOfGuaranteeStatement($financialInstitutionId,$source,$letterOfGuaranteeFacility->id,$lgType,$company->id,$cancellationDate,0,$amount , 0,$letterOfGuaranteeIssuance->getLgCurrency(),LetterOfGuaranteeIssuance::FOR_CANCELLATION);
		$letterOfGuaranteeIssuance->handleLetterOfGuaranteeCashCoverStatement($financialInstitutionId,$source,$letterOfGuaranteeFacility->id,$lgType,$company->id,$cancellationDate,0,0 , $cashCoverAmount ,$letterOfGuaranteeIssuance->getLgCurrency(),LetterOfGuaranteeIssuance::FOR_CANCELLATION);
		$financialInstitutionAccountId = FinancialInstitutionAccount::findByAccountNumber($letterOfGuaranteeIssuance->getCashCoverDeductedFromAccountNumber(),$company->id , $financialInstitutionId)->id;
		$letterOfGuaranteeIssuance->storeCurrentAccountDebitBankStatement($cancellationDate,$cashCoverAmount , $financialInstitutionAccountId);
		
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
		// $letterOfGuaranteeFacility = FinancialInstitution::find($financialInstitutionId)->getCurrentAvailableLetterOfGuaranteeFacility();
		// $lgType = $letterOfGuaranteeIssuance->getLgType();
		// $amount = $letterOfGuaranteeIssuance->getLgAmount();
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->letterOfGuaranteeStatements->where('status',LetterOfGuaranteeIssuance::FOR_CANCELLATION));
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->letterOfGuaranteeCashCoverStatements->where('status',LetterOfGuaranteeIssuance::FOR_CANCELLATION));
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->currentAccountBankStatements);
		
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$request->get('lg_type')])->with('success',__('Data Store Successfully'));
	}



	public function destroy(Company $company ,  LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance)
	{
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->currentAccountBankStatements);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->letterOfGuaranteeStatements);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeIssuance->letterOfGuaranteeCashCoverStatements);
		$lgType = $letterOfGuaranteeIssuance->getLgType();
		$letterOfGuaranteeIssuance->delete();
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$lgType]);
	}



}
