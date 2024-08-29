<?php
namespace App\Http\Controllers;
use App\Models\Bank;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\MediumTermLoan;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MediumTermLoanController
{
    use GeneralFunctions;
    protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName =  'created_at' ; // change it 
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($moneyReceived) use ($value,$searchFieldName){
				$currentValue = $moneyReceived->{$searchFieldName} ;
				// if($searchFieldName == 'bank_id'){
				// 	$currentValue = $moneyReceived->getBankName() ;  
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
		->sortByDesc('id');
		return $collection;
	}
	public function index(Company $company,Request $request,FinancialInstitution $financialInstitution)
	{
		
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$currentType = $request->get('active',MediumTermLoan::RUNNING);
		
		$filterDates = [];
		foreach(MediumTermLoan::getAllTypes() as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		
		
		 
		  /**
		 * * start of bank to safe internal money transfer 
		 */
		
		$runningStartDate = $filterDates[MediumTermLoan::RUNNING]['startDate'] ?? null ;
		$runningEndDate = $filterDates[MediumTermLoan::RUNNING]['endDate'] ?? null ;
		$mediumTermLoans = $company->mediumTermLoans ;
		$mediumTermLoans =  $mediumTermLoans->filterByStartDate($runningStartDate,$runningEndDate) ;
		$mediumTermLoans =  $currentType == MediumTermLoan::RUNNING ? $this->applyFilter($request,$mediumTermLoans):$mediumTermLoans ;

		/**
		 * * end of bank to safe internal money transfer 
		 */
		 
		
		 $searchFields = [
			MediumTermLoan::RUNNING=>[
				'name'=>__('Name'),
				'start_date'=>__('Start Date'),
				'end_Date'=>__('End Date'),
			],
		];
	
		$models = [
			MediumTermLoan::RUNNING =>$mediumTermLoans ,
		];

        return view('loans.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'models'=>$models,
			'financialInstitution'=>$financialInstitution,
			'filterDates'=>$filterDates
		]);
    }
	public function create(Company $company,FinancialInstitution $financialInstitution)
	{
        return view('loans.form',$this->getCommonViewVars($company,$financialInstitution));
    }
	public function getCommonViewVars(Company $company,$financialInstitution,$model = null)
	{
		$banks = Bank::pluck('view_name','id');
		// $selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		// $financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		// $accountTypes = AccountType::onlyCurrentAccount()->get();
		return [
			'banks'=>$banks,
			'financialInstitution'=>$financialInstitution,
			// 'selectedBranches'=>$selectedBranches,
			// 'financialInstitutionBanks'=>$financialInstitutionBanks,
			// 'accountTypes'=>$accountTypes,
			'model'=>$model
		];
	}
	
	public function store(Company $company   , Request $request , FinancialInstitution $financialInstitution){
		$type = MediumTermLoan::RUNNING;
		$internalMoneyTransfer = new MediumTermLoan ;
		$internalMoneyTransfer->status = MediumTermLoan::RUNNING;
		$internalMoneyTransfer->storeBasicForm($request);
		$activeTab = $type ; 
		return redirect()->route('loans.index',['company'=>$company->id,'active'=>$activeTab,'financialInstitution'=>$financialInstitution->id])->with('success',__('Data Store Successfully'));
		
	}

	public function edit(Company $company,FinancialInstitution $financialInstitution,MediumTermLoan $mediumTermLoan)
	{

        return view('loans.form' ,$this->getCommonViewVars($company,$financialInstitution,$mediumTermLoan));
    }
	
	public function update(Company $company, Request $request , FinancialInstitution $financialInstitution , MediumTermLoan $mediumTermLoan){
		
		$mediumTermLoan->deleteRelations();
		$mediumTermLoan->delete();
		$type = MediumTermLoan::RUNNING;
		$this->store($company,$request,$financialInstitution);
		$activeTab = $type ;
		return redirect()->route('loans.index',['company'=>$company->id,'active'=>$activeTab,'financialInstitution'=>$financialInstitution->id])->with('success',__('Item Has Been Updated Successfully'));
	}
	
	public function destroy(Company $company ,FinancialInstitution $financialInstitution, MediumTermLoan $mediumTermLoan)
	{
		$mediumTermLoan->deleteRelations();
		$mediumTermLoan->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}
	public function viewUploadLoanSchedule()
	{
		return view('loans.upload');
	}
	
}
