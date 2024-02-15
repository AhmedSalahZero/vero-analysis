<?php
namespace App\Http\Controllers;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\CertificatesOfDeposit;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Models\MoneyReceived;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CertificatesOfDepositsController
{
    use GeneralFunctions;
    protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName =  'start_date' ; // change it 
		if($request->get('field') == 'end_date'){
			$dateFieldName = 'end_date';
		}
		
		
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
		
		return $collection->values();
	}
	public function index(Company $company,Request $request,FinancialInstitution $financialInstitution)
	{

		$filterEndDate = $request->has('filter_end_date') ? $request->get('filter_end_date'):  now()->format('Y-m-d');
		$filterStartDate = $request->has('filter_start_date') ? $request->get('filter_start_date'):now()->subMonths(3)->format('Y-m-d');
		
		$user = $request->user()->load('certificatesOfDeposits') ;
		/**
		 * @var Collection $certificatesOfDeposits 
		 */
		$certificatesOfDeposits = $user->certificatesOfDeposits ;
		$certificatesOfDeposits = $certificatesOfDeposits->where('start_date','>=',$filterStartDate)->where('start_date','<=',$filterEndDate) ;
		$certificatesOfDeposits =   $this->applyFilter($request,$certificatesOfDeposits) ;
		
		$searchFields = [
			'start_date'=>__('Start Date'),
			'end_date'=>__('End Date'),
			'account_number'=>__('Account Number'),
			'currency'=>__('Currency'),
		];
        return view('reports.certificates-of-deposit.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'financialInstitution'=>$financialInstitution,
			'certificatesOfDeposits'=>$certificatesOfDeposits,
			'filterEndDate'=>$filterEndDate,
			'filterStartDate'=>$filterStartDate
		]);
    }
	public function getCustomers(Company $company):array 
	{
		return CustomerInvoice::where('company_id',$company->id)
		->get()->pluck('customer_name','customer_name')->toArray();
	}
	public function create(Company $company,FinancialInstitution $financialInstitution)
	{
		$banks = Bank::pluck('view_name','id');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$selectedBanks = MoneyReceived::getBanksForCurrentCompany($company->id) ;
		$customers = $this->getCustomers($company);
		$accounts = $financialInstitution->accounts ;
        return view('reports.certificates-of-deposit.form',[
			'banks'=>$banks,
			'selectedBranches'=>$selectedBranches,
			'selectedBanks'=>$selectedBanks,
			'financialInstitution'=>$financialInstitution,
			'customers'=>$customers,
			'accounts'=>$accounts
		]);
    }
	public function getCommonDataArr():array 
	{
		return ['start_date','account_number','amount','end_date','currency','interest_rate','interest_amount','maturity_amount_added_to_account_id'];
	}
	public function store(Company $company  ,FinancialInstitution $financialInstitution, Request $request){
		
		$data = $request->only( $this->getCommonDataArr());
		foreach(['start_date','end_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		$data['created_by'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		$data['interest_amount'] = number_unformat($request->get('interest_amount')) ;
		$financialInstitution->certificatesOfDeposits()->create($data);
		$type = $request->get('type','certificates-of-deposit');
		$activeTab = $type ; 
		
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}
	
	public function edit(Company $company , Request $request , FinancialInstitution $financialInstitution , CertificatesOfDeposit $certificatesOfDeposit){
		$accounts = $financialInstitution->accounts ;
        return view('reports.certificates-of-deposit.form',[
			'financialInstitution'=>$financialInstitution,
			'model'=>$certificatesOfDeposit,
			'accounts'=>$accounts
		]);
		
	}
	
	public function update(Company $company , Request $request , FinancialInstitution $financialInstitution,CertificatesOfDeposit $certificatesOfDeposit){
		// $type = $request->get('type');
		$infos =  $request->get('infos',[]) ;
		
		$data['updated_by'] = auth()->user()->id ;
		$data = $request->only($this->getCommonDataArr());
		foreach(['start_date','end_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		$data['interest_amount'] = number_unformat($request->get('interest_amount')) ;
		$certificatesOfDeposit->update($data);
		
		$type = $request->get('type','certificates-of-deposit');
		$activeTab = $type ;
		//  $activeTab = $this->getActiveTab($type);
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));
	}
	public function destroy(Company $company , FinancialInstitution $financialInstitution , CertificatesOFDeposit $certificatesOfDeposit)
	{
		$certificatesOfDeposit->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}
}
