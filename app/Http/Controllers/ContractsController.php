<?php
namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Partner;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;

class ContractsController
{
    use GeneralFunctions;
	public function index(Company  $company )
    {
		$contracts = Contract::where('company_id',$company->id)->get();
		$items = [];
		foreach($contracts as $index=>$contract){
				$contractId = $contract->id ;
				$items[$contractId]['parent'] = [
					'name'=>$contract->getName() ,
					'customer_name'=>$contract->getCustomerName(),
					'start_date'=>$contract->getStartDateFormatted(),
					'end_date'=>$contract->getEndDateFormatted(),
					'amount'=>$contract->getAmountFormatted()
				];
				foreach($contract->salesOrders as $salesOrder){
					// $items[$contractId]['sub_items'][$salesOrder->id]['start_date'] =$salesOrder->getStartDateFormatted() ;
					// $items[$contractId]['sub_items'][$salesOrder->id]['end_date'] =$salesOrder->getEndDateFormatted() ;
					$items[$contractId]['sub_items'][$salesOrder->id]['so_number'] =$salesOrder->getNumber() ;
					$items[$contractId]['sub_items'][$salesOrder->id]['amount'] =$salesOrder->getAmountFormatted() ;
					$items[$contractId]['sub_items'][$salesOrder->id]['id'] =$salesOrder->id ;
				}
		}
        return view('contracts.index',compact('company','items'));
    }
	public function create(Request $request,Company $company)
	{
		$customers = Partner::onlyCompany($company->id)->onlyCustomers()->get();
		
		return view('contracts.form',[
			'company'=>$company,
			'customers'=>$customers
		]);
	}
	public function store(Request $request, Company $company){
			$contract = new Contract ;
			$contract->storeBasicForm($request);
			return redirect()->route('contracts.index',['company'=>$company->id]);
	}
	public function edit(Request $request,Company $company,Contract $contract)
	{
		$customers = Partner::onlyCompany($company->id)->onlyCustomers()->get();
		
		return view('contracts.form',[
			'company'=>$company,
			'customers'=>$customers,
			'model'=>$contract
		]);
	}
	public function update(Company $company , Request $request , Contract $contract){
		
			$contract->storeBasicForm($request);
			return redirect()->route('contracts.index',['company'=>$company->id]);
	}
	public function destroy(Company $company , Request $request , Contract $contract){
		$contract->delete();
		return redirect()->route('contracts.index',['company'=>$company->id]);  
	}
}
