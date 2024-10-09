<?php
namespace App\Http\Controllers;
use App\Enums\LcTypes;
use App\Models\AccountType;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\LetterOfCreditFacility;
use App\Models\LetterOfCreditIssuance;
use App\Models\LetterOfCreditStatement;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LetterOfCreditFacilityController
{
    use GeneralFunctions;
    protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName =  'created_at' ; // change it
		// $dateFieldName = $searchFieldName === 'balance_date' ? 'balance_date' : 'created_at';
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($moneyReceived) use ($value,$searchFieldName){
				$currentValue = $moneyReceived->{$searchFieldName} ;
				if($searchFieldName == 'bank_id'){
					$currentValue = $moneyReceived->getBankName() ;
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
		->sortByDesc('id')->values();

		return $collection;
	}
	public function index(Company $company,Request $request,FinancialInstitution $financialInstitution)
	{


		$letterOfCreditFacilities = $financialInstitution->letterOfCreditFacilities ;

		$letterOfCreditFacilities =   $this->applyFilter($request,$letterOfCreditFacilities) ;

		$searchFields = [
			'contract_start_date'=>__('Contract Start Date'),
			'contract_end_date'=>__('Contract End Date'),
			'currency'=>__('Currency'),
			'limit'=>__('Limit'),

		];
        return view('reports.LetterOfCreditFacility.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'financialInstitution'=>$financialInstitution,
			'letterOfCreditFacilities'=>$letterOfCreditFacilities
		]);
    }

	public function create(Company $company,FinancialInstitution $financialInstitution)
	{
        return view('reports.LetterOfCreditFacility.form',[
			'financialInstitution'=>$financialInstitution,
		]);
    }
	public function getCommonDataArr():array 
	{
		return ['contract_start_date','contract_end_date','currency','limit','borrowing_rate','bank_margin_rate','interest_rate','min_interest_rate','highest_debt_balance_rate','admin_fees_rate','outstanding_amount'];
	}
	public function store(Company $company  ,FinancialInstitution $financialInstitution, Request $request){
		$data = $request->only( $this->getCommonDataArr());
		foreach(['contract_start_date','contract_end_date','outstanding_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		$termAndConditions = $request->get('termAndConditions',[]) ;
		$data['created_by'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		$data['outstanding_amount'] = $data['outstanding_amount'] ? $data['outstanding_amount']: 0; 
		/**
		 * @var LetterOfCreditFacility $letterOfCreditFacility
		 */
		$letterOfCreditFacility = $financialInstitution->LetterOfCreditFacilities()->create($data);
		$currencyName = $letterOfCreditFacility->getCurrency();
		$source = LetterOfCreditIssuance::LC_FACILITY;

		foreach($termAndConditions as $termAndConditionArr){
			$termAndConditionArr['company_id'] = $company->id ;
			$termAndConditionArr['outstanding_date'] = $request->get('outstanding_date');
			$currentOutstandingBalance = $termAndConditionArr['outstanding_balance'] ;
			$currentCashCover = $termAndConditionArr['cash_cover_rate'];
			
			$currentLcType = $termAndConditionArr['lc_type'] ;
			// if($currentOutstandingBalance){
				$letterOfCreditFacility->termAndConditions()->create(array_merge($termAndConditionArr , [
				]));
			// }
			if($currentOutstandingBalance > 0){
				$letterOfCreditFacility->handleLetterOfCreditStatement($financialInstitution->id,$source,$letterOfCreditFacility->id,$currentLcType,$company->id,$termAndConditionArr['outstanding_date'],0,0,$currentOutstandingBalance,$currencyName,0,0,LetterOfCreditIssuance::LC_FACILITY_BEGINNING_BALANCE);
				
			}
			$cashCoverOpeningBalance = $currentCashCover / 100 * $currentOutstandingBalance ;
			if( $cashCoverOpeningBalance > 0 ){
				$letterOfCreditFacility->handleLetterOfCreditCashCoverStatement($financialInstitution->id,$source,$letterOfCreditFacility->id,$currentLcType,$company->id,$termAndConditionArr['outstanding_date'],0,$cashCoverOpeningBalance,0,$currencyName,0,LetterOfCreditIssuance::LC_FACILITY_BEGINNING_BALANCE);
			}

		}
		$type = $request->get('type','letter-of-credit-facilities');
		$activeTab = $type ;

		return redirect()->route('view.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));

	}

	public function edit(Company $company , Request $request , FinancialInstitution $financialInstitution , LetterOfCreditFacility $letterOfCreditFacility){

        return view('reports.LetterOfCreditFacility.form',[
			'financialInstitution'=>$financialInstitution,
			'model'=>$letterOfCreditFacility
		]);

	}

	public function update(Company $company , Request $request , FinancialInstitution $financialInstitution,LetterOfCreditFacility $letterOfCreditFacility){
		$termAndConditions =  $request->get('termAndConditions',[]) ;
        $source = LetterOfCreditIssuance::LC_FACILITY;
		$data['updated_by'] = auth()->user()->id ;
		$data = $request->only($this->getCommonDataArr());
		foreach(['contract_start_date','contract_end_date','outstanding_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}

     $letterOfCreditFacility->update($data);
     $currencyName = $letterOfCreditFacility->getCurrency();
     LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditFacility->letterOfCreditStatements->where('type',LetterOfCreditIssuance::LC_FACILITY_BEGINNING_BALANCE));
     LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditFacility->letterOfCreditCashCoverStatements->where('type',LetterOfCreditIssuance::LC_FACILITY_BEGINNING_BALANCE));
		$letterOfCreditFacility->termAndConditions->each(function($termAndCondition){
			$termAndCondition->delete();
		});

		foreach($termAndConditions as $termAndConditionArr){
			$letterOfCreditFacility->termAndConditions()->create(array_merge($termAndConditionArr , [
			]));
            $termAndConditionArr['outstanding_date'] = $request->get('outstanding_date');
			$currentOutstandingBalance = $termAndConditionArr['outstanding_balance'] ;
			$currentCashCoverRate = $termAndConditionArr['cash_cover_rate'] / 100  ;
			$currentCashCoverBeginningBalance  = $currentOutstandingBalance * $currentCashCoverRate ; 
			$currentLcType = $termAndConditionArr['lc_type'] ;
			if($currentOutstandingBalance > 0 ){
				$letterOfCreditFacility->handleLetterOfCreditStatement($financialInstitution->id,$source,$letterOfCreditFacility->id,$currentLcType,$company->id,$termAndConditionArr['outstanding_date'],0,0,$currentOutstandingBalance,$currencyName,0,0,LetterOfCreditIssuance::LC_FACILITY_BEGINNING_BALANCE);
			}
			if($currentCashCoverBeginningBalance > 0){
				$letterOfCreditFacility->handleLetterOfCreditCashCoverStatement($financialInstitution->id,$source,$letterOfCreditFacility->id,$currentLcType,$company->id,$termAndConditionArr['outstanding_date'],0,$currentCashCoverBeginningBalance,0,$currencyName,0,LetterOfCreditIssuance::LC_FACILITY_BEGINNING_BALANCE);
			}
			

		}
		$type = $request->get('type','letter-of-credit-facilities');
		$activeTab = $type ;
		return redirect()->route('view.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));


	}

	public function destroy(Company $company , FinancialInstitution $financialInstitution , LetterOfCreditFacility $letterOfCreditFacility)
	{

         LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditFacility->letterOfCreditStatements->where('type',LetterOfCreditIssuance::LC_FACILITY_BEGINNING_BALANCE));
         LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($letterOfCreditFacility->letterOfCreditCashCoverStatements->where('type',LetterOfCreditIssuance::LC_FACILITY_BEGINNING_BALANCE));

		$letterOfCreditFacility->termAndConditions->each(function($termAndCondition){
            $termAndCondition->delete();

		});
		$letterOfCreditFacility->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}
	public function updateOutstandingBalanceAndLimits(Request $request , Company $company  ){
	
		$financialInstitutionId = $request->get('financialInstitutionId') ;
		if(!$financialInstitutionId){
			return ;
		}
		$selectedLcType = $request->get('lcType');
		
		$currentLcOutstanding = 0 ;
		$financialInstitution = FinancialInstitution::find($financialInstitutionId);
        $letterOfCreditFacility = $financialInstitution->getCurrentAvailableLetterOfCreditFacility();
        $minLcCommissionRateForCurrentLcType  = $letterOfCreditFacility  && $letterOfCreditFacility->termAndConditionForLcType($selectedLcType)  ? $letterOfCreditFacility->termAndConditionForLcType($selectedLcType)->min_commission_fees : 0;
        $lcCommissionRate  = $letterOfCreditFacility  && $letterOfCreditFacility->termAndConditionForLcType($selectedLcType) ? $letterOfCreditFacility->termAndConditionForLcType($selectedLcType)->commission_rate : 0;
        $minLcCashCoverRateForCurrentLcType  = $letterOfCreditFacility && $letterOfCreditFacility->termAndConditionForLcType($selectedLcType)  ? $letterOfCreditFacility->termAndConditionForLcType($selectedLcType)->cash_cover_rate : 0;
        $minLcIssuanceFeesForCurrentLcType  = $letterOfCreditFacility  && $letterOfCreditFacility->termAndConditionForLcType($selectedLcType) ? $letterOfCreditFacility->termAndConditionForLcType($selectedLcType)->issuance_fees : 0;

		$source = $request->get('source');
		/**
		 * @var LetterOfCreditFacility $letterOfCreditFacility
		 */
		$letterOfCreditFacility = $financialInstitution->getCurrentAvailableLetterOfCreditFacility();
		$totalLastOutstandingBalanceOfFourTypes = 0 ;
		foreach(LcTypes::getAll() as $lcTypeId => $lcTypeNameFormatted){
			$accountTypeId = $request->get('accountTypeId');
			$letterOfCreditStatement = DB::table('letter_of_credit_statements')
			->where('company_id',$company->id)
			->where('financial_institution_id',$financialInstitutionId)
			->where('lc_type',$lcTypeId)
			->when (! $request->has('accountTypeId'),function(Builder $builder) use($source) {
				$builder->where('source',$source);
			})
			->when($request->has('accountTypeId'),function(Builder $builder) use ($request,$accountTypeId){
				$accountType = AccountType::find($accountTypeId);
				$currentSource = LetterOfCreditIssuance::AGAINST_TD;
				if($accountType->isCertificateOfDeposit()){
					$currentSource = LetterOfCreditIssuance::AGAINST_CD;
				}
				$builder->where('source',$currentSource);
			})
			->orderByRaw('full_date desc')
			->first();
			$letterOfCreditStatementEndBalance = $letterOfCreditStatement ? $letterOfCreditStatement->end_balance : 0 ;
			// dd($lcTypeId , $selectedLcType);
			if($lcTypeId == $selectedLcType ){
				$currentLcOutstanding = $letterOfCreditStatementEndBalance;
			}
			$totalLastOutstandingBalanceOfFourTypes += $letterOfCreditStatementEndBalance;
		}
		$limit = $letterOfCreditFacility ? $letterOfCreditFacility->getLimit() : 0;
		return response()->json([
			'limit'=>number_format($limit) ,
			'total_lc_outstanding_balance'=>number_format(abs($totalLastOutstandingBalanceOfFourTypes)),
			'total_room'=>number_format($limit - abs($totalLastOutstandingBalanceOfFourTypes)),
			'current_lc_type_outstanding_balance'=>number_format(abs($currentLcOutstanding)),
            'min_lc_commission_rate'=>$minLcCommissionRateForCurrentLcType,
			'lc_commission_rate'=>$lcCommissionRate , 
            'min_lc_cash_cover_rate_for_current_lc_type'=>$minLcCashCoverRateForCurrentLcType ,
            'min_lc_issuance_fees_for_current_lc_type'=>$minLcIssuanceFeesForCurrentLcType
		]);
	}

	

}
