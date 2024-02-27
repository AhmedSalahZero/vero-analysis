<?php
namespace App\Http\Controllers;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\CleanOverdraft;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NotificationSettingsController
{
    use GeneralFunctions;
	public function index(Company $company,Request $request)
	{
        return view('notifications.form', [
			'company'=>$company,
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
	
		$customers = $this->getCustomers($company);
        return view('reports.clean-overdraft.form',[
			'banks'=>$banks,
			'selectedBranches'=>$selectedBranches,
			'financialInstitution'=>$financialInstitution,
			'customers'=>$customers
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
		$data['created_by'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		/**
		 * @var CleanOverDraft $cleanOverdraft 
		 */
		$cleanOverdraft = $financialInstitution->cleanOverdrafts()->create($data);
		// dd($cleanOverdraft);
		$type = $request->get('type','clean-over-draft');
		$activeTab = $type ; 
		$cleanOverdraft->storeOutstandingBreakdown($request,$company);
		return redirect()->route('view.clean.overdraft',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}

	public function edit(Company $company , Request $request , FinancialInstitution $financialInstitution , CleanOverdraft $cleanOverdraft){
		$banks = Bank::pluck('view_name','id');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$customers = $this->getCustomers($company);
		
        return view('reports.clean-overdraft.form',[
			'banks'=>$banks,
			'selectedBranches'=>$selectedBranches,
			'financialInstitution'=>$financialInstitution,
			'customers'=>$customers,
			'model'=>$cleanOverdraft
		]);
		
	}
	
	public function update(Company $company , Request $request , FinancialInstitution $financialInstitution,CleanOverdraft $cleanOverdraft){
		// $infos =  $request->get('infos',[]) ;
		
		$data['updated_by'] = auth()->user()->id ;
		$data = $request->only($this->getCommonDataArr());
		foreach(['contract_start_date','contract_end_date','balance_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		
		$cleanOverdraft->update($data);
		$cleanOverdraft->storeOutstandingBreakdown($request,$company);
		$type = $request->get('type','clean-over-draft');
		$activeTab = $type ;
		return redirect()->route('view.clean.overdraft',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));
		
		
	}
	
	public function destroy(Company $company , FinancialInstitution $financialInstitution , CleanOverdraft $cleanOverdraft)
	{
	
		$cleanOverdraft->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}

	
	
}
