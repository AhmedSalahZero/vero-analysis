<?php
namespace App\Http\Controllers;

use App\Enums\LgTypes;
use App\Models\AccountType;
use App\Models\Company;
use App\Models\Contract;
use App\Models\FinancialInstitution;
use App\Models\LetterOfGuaranteeIssuance;
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
		// dd();
	// dd();
		
		// $letterOfGuaranteeIssuances =   $this->applyFilter($request,$letterOfGuaranteeIssuances) ;
		
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
	public function commonViewVars(Company $company):array
	{
		return [
			'financialInstitutionBanks'=> FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get(),
			'beneficiaries'=>Partner::onlyCustomers()->onlyForCompany($company->id)->get(),
			'contracts'=>Contract::onlyForCompany($company->id)->get(),
			'purchaseOrders'=>PurchaseOrder::onlyForCompany($company->id)->get(),
			'accountTypes'=> AccountType::onlyCurrentAccount()->get()
		];
		
	}
	public function create(Company $company)
	{
        return view('reports.LetterOfGuaranteeIssuance.form',array_merge(
			$this->commonViewVars($company) ,
			[
				
			]
		));
    }
	public function getCommonDataArr():array 
	{
		return ['contract_start_date','contract_end_date','currency','limit'];
	}
	public function store(Company $company  , Request $request){

		$model = new LetterOfGuaranteeIssuance();
		$model->storeBasicForm($request);
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$request->get('lg_type')])->with('success',__('Data Store Successfully'));
		
	}
	
	public function edit(Company $company , Request $request , LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance){
        return view('reports.LetterOfGuaranteeIssuance.form',array_merge(
			$this->commonViewVars($company) ,
			[
				'model'=>$letterOfGuaranteeIssuance
			]
		));
		
	}
	
	public function update(Company $company , Request $request , LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance){
		$letterOfGuaranteeIssuance->storeBasicForm($request);
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$request->get('lg_type')])->with('success',__('Data Store Successfully'));
	}
	
	public function destroy(Company $company ,  LetterOfGuaranteeIssuance $letterOfGuaranteeIssuance)
	{
		$lgType = $letterOfGuaranteeIssuance->getLgType();
		$letterOfGuaranteeIssuance->delete();
		return redirect()->route('view.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$lgType]);
	}

	
	
}
