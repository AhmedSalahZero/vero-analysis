<?php
namespace App\Http\Controllers;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\OverdraftAgainstCommercialPaper;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OverdraftAgainstCommercialPaperController
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
		
		$overdraftAgainstCommercialPapers = $company->overdraftAgainstCommercialPapers->where('financial_institution_id',$financialInstitution->id) ;
		dd($overdraftAgainstCommercialPapers);
		$overdraftAgainstCommercialPapers =   $this->applyFilter($request,$overdraftAgainstCommercialPapers) ;
		$searchFields = [
			'contract_start_date'=>__('Contract Start Date'),
			'contract_end_date'=>__('Contract End Date'),
			'account_number'=>__('Contract Number'),
			'currency'=>__('Currency'),
			'limit'=>__('Limit'),
			'outstanding_balance'=>__('Outstanding Balance'),
			'balance_date'=>__('Balance Date'),
			
		];

        return view('reports.overdraft-against-commercial-paper.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'financialInstitution'=>$financialInstitution,
			'overdraftAgainstCommercialPapers'=>$overdraftAgainstCommercialPapers
		]);
    }
	public function create(Company $company,FinancialInstitution $financialInstitution)
	{
		$banks = Bank::pluck('view_name','id');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
        return view('reports.overdraft-against-commercial-paper.form',[
			'banks'=>$banks,
			'selectedBranches'=>$selectedBranches,
			'financialInstitution'=>$financialInstitution,
		]);
    }
	public function getCommonDataArr():array 
	{
		return ['contract_start_date','account_number','contract_end_date','currency','limit','outstanding_balance','balance_date','borrowing_rate','bank_margin_rate','interest_rate','min_interest_rate','highest_debt_balance_rate','admin_fees_rate','to_be_setteled_max_within_days'];
	}
	public function store(Company $company  ,FinancialInstitution $financialInstitution, Request $request){
		
		$data = $request->only( $this->getCommonDataArr());
		foreach(['contract_start_date','contract_end_date','balance_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		$lendingInformation = $request->get('infos',[]) ; 
		$data['created_by'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		/**
		 * @var OverdraftAgainstCommercialPaper $overdraftAgainstCommercialPaper 
		 */
		$overdraftAgainstCommercialPaper = $financialInstitution->overdraftAgainstCommercialPapers()->create($data);
		$type = $request->get('type','overdraft-against-commercial-paper');
		$activeTab = $type ; 
		
		$overdraftAgainstCommercialPaper->storeOutstandingBreakdown($request,$company);
		foreach($lendingInformation as $lendingInformationArr){
			$overdraftAgainstCommercialPaper->lendingInformation()->create(array_merge($lendingInformationArr , [
			]));
		}
		return redirect()->route('view.overdraft.against.commercial.paper',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}

	public function edit(Company $company , Request $request , FinancialInstitution $financialInstitution , OverdraftAgainstCommercialPaper $overdraftAgainstCommercialPaper){
		$banks = Bank::pluck('view_name','id');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
        return view('reports.overdraft-against-commercial-paper.form',[
			'banks'=>$banks,
			'selectedBranches'=>$selectedBranches,
			'financialInstitution'=>$financialInstitution,
			// 'customers'=>$customers,
			'model'=>$overdraftAgainstCommercialPaper
		]);
		
	}
	
	public function update(Company $company , Request $request , FinancialInstitution $financialInstitution,OverdraftAgainstCommercialPaper $overdraftAgainstCommercialPaper){
		// $infos =  $request->get('infos',[]) ;
		$infos =  $request->get('infos',[]) ;
		$data['updated_by'] = auth()->user()->id ;
		$data = $request->only($this->getCommonDataArr());
		foreach(['contract_start_date','contract_end_date','balance_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		
		$overdraftAgainstCommercialPaper->update($data);
		$overdraftAgainstCommercialPaper->storeOutstandingBreakdown($request,$company);
		foreach($infos as $lendingInformationArr){
			$overdraftAgainstCommercialPaper->lendingInformation()->create(array_merge($lendingInformationArr , [
				// 'balance_date'=>$balanceDate  ? Carbon::make($balanceDate)->format('Y-m-d') : null 
			]));
		}
		$type = $request->get('type','overdraft-against-commercial-paper');
		$activeTab = $type ;
		return redirect()->route('view.overdraft.against.commercial.paper',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));
		
		
	}
	
	public function destroy(Company $company , FinancialInstitution $financialInstitution , OverdraftAgainstCommercialPaper $overdraftAgainstCommercialPaper)
	{
		$overdraftAgainstCommercialPaper->lendingInformation->each(function($lendingInformation){
			$lendingInformation->delete();
		});
		$overdraftAgainstCommercialPaper->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}

	
	
}
