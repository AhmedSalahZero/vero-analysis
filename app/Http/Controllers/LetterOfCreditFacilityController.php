<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreMoneyReceivedRequest;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\LetterOfCreditFacility;
use App\Models\MoneyReceived;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
		->sortByDesc('id');
		
		return $collection;
	}
	public function index(Company $company,Request $request,FinancialInstitution $financialInstitution)
	{
		
		$user = $request->user()->load('letterOfCreditFacilities') ;
		
		$letterOfCreditFacilities = $user->letterOfCreditFacilities ;
		// dd($letterOfCreditFacilities);
		$letterOfCreditFacilities =   $this->applyFilter($request,$letterOfCreditFacilities) ;
		
		$searchFields = [
			'contract_start_date'=>__('Contract Start Date'),
			'contract_end_date'=>__('Contract End Date'),
			'currency'=>__('Currency'),
			'limit'=>__('Limit'),
			'financial_duration'=>__('Financial Duration')
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
		return ['contract_start_date','contract_end_date','currency','limit','financial_duration','borrowing_rate','bank_margin_rate','interest_rate','min_interest_rate','highest_debt_balance_rate','admin_fees_rate'];
	}
	public function store(Company $company  ,FinancialInstitution $financialInstitution, Request $request){
		
		$data = $request->only( $this->getCommonDataArr());
		foreach(['contract_start_date','contract_end_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		$termAndConditions = $request->get('termAndConditions',[]) ; 
		$data['created_by'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
					$letterOfCreditFacility = $financialInstitution->LetterOfCreditFacilities()->create($data);
		foreach($termAndConditions as $termAndConditionArr){
			$termAndConditionArr['company_id'] = $company->id ;
			if(isset($termAndConditionArr['outstanding_balance'])){
				$letterOfCreditFacility->termAndConditions()->create(array_merge($termAndConditionArr , [
				]));
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
		// $type = $request->get('type');
		$termAndConditions =  $request->get('termAndConditions',[]) ;
		
		$data['updated_by'] = auth()->user()->id ;
		$data = $request->only($this->getCommonDataArr());
		foreach(['contract_start_date','contract_end_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		// $additionalData = [];
		// if($type =='bank'){
		// 	$additionalData = ['bank_id','company_account_number','swift_code','iban_code','current_account_number','main_currency','balance_amount'] ;
		// }
		// else{
		// 	$additionalData = ['name'] ;
		// }
		
		// foreach($additionalData as $name){
		// 	$data[$name] = $request->get($name);
		// }
		// $data['balance_date'] = $request->get('balance_date') ? Carbon::make($request->get('balance_date'))->format('Y-m-d'):null;
	
		
		$letterOfCreditFacility->update($data);
		$letterOfCreditFacility->termAndConditions->each(function($termAndCondition){
			$termAndCondition->delete();
		});
		
		foreach($termAndConditions as $termAndConditionArr){
			$letterOfCreditFacility->termAndConditions()->create(array_merge($termAndConditionArr , [
				// 'balance_date'=>$balanceDate  ? Carbon::make($balanceDate)->format('Y-m-d') : null 
			]));
		}
		$type = $request->get('type','letter-of-credit-facilities');
		$activeTab = $type ;
		//  $activeTab = $this->getActiveTab($type);
		return redirect()->route('view.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));
		
		
	}
	
	public function destroy(Company $company , FinancialInstitution $financialInstitution , LetterOfCreditFacility $letterOfCreditFacility)
	{
		$letterOfCreditFacility->termAndConditions->each(function($termAndCondition){
			$termAndCondition->delete();
		});
		$letterOfCreditFacility->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}

	
	
}
