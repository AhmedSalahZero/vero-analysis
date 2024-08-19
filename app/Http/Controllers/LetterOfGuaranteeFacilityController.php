<?php
namespace App\Http\Controllers;
use App\Enums\LgTypes;
use App\Models\AccountType;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\LetterOfGuaranteeFacility;
use App\Models\LetterOfGuaranteeIssuance;
use App\Models\LetterOfGuaranteeStatement;
use App\Models\Partner;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LetterOfGuaranteeFacilityController
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
		->sortByDesc('id');

		return $collection;
	}
	public function index(Company $company,Request $request,FinancialInstitution $financialInstitution)
	{


		$letterOfGuaranteeFacilities = $financialInstitution->letterOfGuaranteeFacilities ;

		$letterOfGuaranteeFacilities =   $this->applyFilter($request,$letterOfGuaranteeFacilities) ;

		$searchFields = [
			'contract_start_date'=>__('Contract Start Date'),
			'contract_end_date'=>__('Contract End Date'),
			'currency'=>__('Currency'),
			'limit'=>__('Limit'),

		];
        return view('reports.LetterOfGuaranteeFacility.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'financialInstitution'=>$financialInstitution,
			'letterOfGuaranteeFacilities'=>$letterOfGuaranteeFacilities
		]);
    }

	public function create(Company $company,FinancialInstitution $financialInstitution)
	{
        return view('reports.LetterOfGuaranteeFacility.form',[
			'financialInstitution'=>$financialInstitution,
		]);
    }
	public function getCommonDataArr():array
	{
		return ['contract_start_date','contract_end_date','outstanding_date','currency','limit','outstanding_amount'];
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
		 * @var LetterOfGuaranteeFacility $letterOfGuaranteeFacility
		 */
		$letterOfGuaranteeFacility = $financialInstitution->LetterOfGuaranteeFacilities()->create($data);
		$currencyName = $letterOfGuaranteeFacility->getCurrency();
		$source = LetterOfGuaranteeIssuance::LG_FACILITY;

		foreach($termAndConditions as $termAndConditionArr){
			$termAndConditionArr['company_id'] = $company->id ;
			$termAndConditionArr['outstanding_date'] = $request->get('outstanding_date');
			$currentOutstandingBalance = $termAndConditionArr['outstanding_balance'] ;
			$currentCashCover = $termAndConditionArr['cash_cover_rate'];
			
			$currentLgType = $termAndConditionArr['lg_type'] ;
			if($currentOutstandingBalance){
				$letterOfGuaranteeFacility->termAndConditions()->create(array_merge($termAndConditionArr , [
				]));
			}
			if($currentOutstandingBalance > 0){
				$letterOfGuaranteeFacility->handleLetterOfGuaranteeStatement($financialInstitution->id,$source,$letterOfGuaranteeFacility->id,$currentLgType,$company->id,$termAndConditionArr['outstanding_date'],0,0,$currentOutstandingBalance,$currencyName,0,0,LetterOfGuaranteeIssuance::LG_FACILITY_BEGINNING_BALANCE);
				
			}
			$cashCoverOpeningBalance = $currentCashCover / 100 * $currentOutstandingBalance ;
			if( $cashCoverOpeningBalance > 0 ){
				$letterOfGuaranteeFacility->handleLetterOfGuaranteeCashCoverStatement($financialInstitution->id,$source,$letterOfGuaranteeFacility->id,$currentLgType,$company->id,$termAndConditionArr['outstanding_date'],0,$cashCoverOpeningBalance,0,$currencyName,0,LetterOfGuaranteeIssuance::LG_FACILITY_BEGINNING_BALANCE);
			}

		}
		$type = $request->get('type','letter-of-guarantee-facilities');
		$activeTab = $type ;

		return redirect()->route('view.letter.of.guarantee.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));

	}

	public function edit(Company $company , Request $request , FinancialInstitution $financialInstitution , LetterOfGuaranteeFacility $letterOfGuaranteeFacility){

        return view('reports.LetterOfGuaranteeFacility.form',[
			'financialInstitution'=>$financialInstitution,
			'model'=>$letterOfGuaranteeFacility
		]);

	}

	public function update(Company $company , Request $request , FinancialInstitution $financialInstitution,LetterOfGuaranteeFacility $letterOfGuaranteeFacility){
		$termAndConditions =  $request->get('termAndConditions',[]) ;
        $source = LetterOfGuaranteeIssuance::LG_FACILITY;
		$data['updated_by'] = auth()->user()->id ;
		$data = $request->only($this->getCommonDataArr());
		foreach(['contract_start_date','contract_end_date','outstanding_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}

     $letterOfGuaranteeFacility->update($data);
     $currencyName = $letterOfGuaranteeFacility->getCurrency();
     LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeFacility->letterOfGuaranteeStatements->where('type',LetterOfGuaranteeIssuance::LG_FACILITY_BEGINNING_BALANCE));
     LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeFacility->letterOfGuaranteeCashCoverStatements->where('type',LetterOfGuaranteeIssuance::LG_FACILITY_BEGINNING_BALANCE));
		$letterOfGuaranteeFacility->termAndConditions->each(function($termAndCondition){
			$termAndCondition->delete();
		});

		foreach($termAndConditions as $termAndConditionArr){
			$letterOfGuaranteeFacility->termAndConditions()->create(array_merge($termAndConditionArr , [
			]));
            $termAndConditionArr['outstanding_date'] = $request->get('outstanding_date');
			$currentOutstandingBalance = $termAndConditionArr['outstanding_balance'] ;
			$currentCashCoverRate = $termAndConditionArr['cash_cover_rate'] / 100  ;
			$currentCashCoverBeginningBalance  = $currentOutstandingBalance * $currentCashCoverRate ; 
			$currentLgType = $termAndConditionArr['lg_type'] ;
			if($currentOutstandingBalance > 0 ){
				$letterOfGuaranteeFacility->handleLetterOfGuaranteeStatement($financialInstitution->id,$source,$letterOfGuaranteeFacility->id,$currentLgType,$company->id,$termAndConditionArr['outstanding_date'],0,0,$currentOutstandingBalance,$currencyName,0,0,LetterOfGuaranteeIssuance::LG_FACILITY_BEGINNING_BALANCE);
			}
			if($currentCashCoverBeginningBalance > 0){
				$letterOfGuaranteeFacility->handleLetterOfGuaranteeCashCoverStatement($financialInstitution->id,$source,$letterOfGuaranteeFacility->id,$currentLgType,$company->id,$termAndConditionArr['outstanding_date'],0,$currentCashCoverBeginningBalance,0,$currencyName,0,LetterOfGuaranteeIssuance::LG_FACILITY_BEGINNING_BALANCE);
			}
			

		}
		$type = $request->get('type','letter-of-guarantee-facilities');
		$activeTab = $type ;
		return redirect()->route('view.letter.of.guarantee.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));


	}

	public function destroy(Company $company , FinancialInstitution $financialInstitution , LetterOfGuaranteeFacility $letterOfGuaranteeFacility)
	{

         LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeFacility->letterOfGuaranteeStatements->where('type',LetterOfGuaranteeIssuance::LG_FACILITY_BEGINNING_BALANCE));
         LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($letterOfGuaranteeFacility->letterOfGuaranteeCashCoverStatements->where('type',LetterOfGuaranteeIssuance::LG_FACILITY_BEGINNING_BALANCE));

		$letterOfGuaranteeFacility->termAndConditions->each(function($termAndCondition){
            $termAndCondition->delete();

		});
		$letterOfGuaranteeFacility->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}
	public function updateOutstandingBalanceAndLimits(Request $request , Company $company ){
		$financialInstitutionId = $request->get('financialInstitutionId') ;
		$selectedLgType = $request->get('lgType');
		$isBidBond = $selectedLgType == 'bid-bond'  ;
		$customersArr =   Partner::onlyCustomers()->onlyForCompany($company->id)
		->when(!$isBidBond,function(Builder $builder){
			$builder->onlyThatHaveContracts();
		})
		->pluck('name','id')
		->toArray();
		// dd($request->all());
		$currentSource = $request->get('source');
		
		$currentLgOutstanding = 0 ;
		$financialInstitution = FinancialInstitution::find($financialInstitutionId);
		if(!$financialInstitution){
			return ;
		}
        $letterOfGuaranteeFacility = $financialInstitution->getCurrentAvailableLetterOfGuaranteeFacility();
		
        $minLgCommissionRateForCurrentLgType  = $letterOfGuaranteeFacility  && $letterOfGuaranteeFacility->termAndConditionForLgType($selectedLgType) ? $letterOfGuaranteeFacility->termAndConditionForLgType($selectedLgType)->min_commission_fees : 0;
        $lgCommissionRate  = $letterOfGuaranteeFacility  && $letterOfGuaranteeFacility->termAndConditionForLgType($selectedLgType) ? $letterOfGuaranteeFacility->termAndConditionForLgType($selectedLgType)->commission_rate : 0;
        $minLgCashCoverRateForCurrentLgType  = $letterOfGuaranteeFacility  && $letterOfGuaranteeFacility->termAndConditionForLgType($selectedLgType) ? $letterOfGuaranteeFacility->termAndConditionForLgType($selectedLgType)->cash_cover_rate : 0;
        $minLgIssuanceFeesForCurrentLgType  = $letterOfGuaranteeFacility  && $letterOfGuaranteeFacility->termAndConditionForLgType($selectedLgType) ? $letterOfGuaranteeFacility->termAndConditionForLgType($selectedLgType)->issuance_fees : 0;


		/**
		 * @var LetterOfGuaranteeFacility $letterOfGuaranteeFacility
		 */
		$letterOfGuaranteeFacility = $financialInstitution->getCurrentAvailableLetterOfGuaranteeFacility();
		$totalLastOutstandingBalanceOfFourTypes = 0 ;
		foreach(LgTypes::getAll() as $lgTypeId => $lgTypeNameFormatted){
			$accountTypeId = $request->get('accountTypeId');
			$letterOfGuaranteeStatement = DB::table('letter_of_guarantee_statements')
			->where('company_id',$company->id)
			->where('currency',getCurrentCompany()->getMainFunctionalCurrency())
			->where('financial_institution_id',$financialInstitutionId)
			->where('lg_type',$lgTypeId)
			->when($request->has('accountTypeId'),function(Builder $builder) use ($request,$accountTypeId){
				$accountType = AccountType::find($accountTypeId);
				$currentSource = LetterOfGuaranteeIssuance::AGAINST_TD;
				if($accountType->isCertificateOfDeposit()){
					$currentSource = LetterOfGuaranteeIssuance::AGAINST_CD;
				}
				
			})
			->where('source',$currentSource)
			->orderByRaw('full_date desc')
			->first();
			$letterOfGuaranteeStatementEndBalance = $letterOfGuaranteeStatement ? $letterOfGuaranteeStatement->end_balance : 0 ;
			if($lgTypeId == $selectedLgType ){
				$currentLgOutstanding = $letterOfGuaranteeStatementEndBalance;
			}
			$totalLastOutstandingBalanceOfFourTypes += $letterOfGuaranteeStatementEndBalance;
		}
		$limit = $letterOfGuaranteeFacility ? $letterOfGuaranteeFacility->getLimit() : 0;

		return response()->json([
			'limit'=>number_format($limit) ,
			'total_lg_outstanding_balance'=>number_format(abs($totalLastOutstandingBalanceOfFourTypes)),
			'total_room'=>number_format($limit - abs($totalLastOutstandingBalanceOfFourTypes)),
			'current_lg_type_outstanding_balance'=>number_format(abs($currentLgOutstanding)),
            'min_lg_commission_rate'=>$minLgCommissionRateForCurrentLgType,
			'lg_commission_rate'=>$lgCommissionRate , 
            'min_lg_cash_cover_rate_for_current_lg_type'=>$minLgCashCoverRateForCurrentLgType ,
            'min_lg_issuance_fees_for_current_lg_type'=>$minLgIssuanceFeesForCurrentLgType,
			'customers'=>$customersArr

		]);
	}



}
