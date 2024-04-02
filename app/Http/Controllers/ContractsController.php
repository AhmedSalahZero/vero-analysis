<?php
namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Partner;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\ReadyFunctions\PurchaseInventory\PurchaseInventoryValueBase;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;

/**
 *  * 
 * * type = Customer or Supplier
 */
class ContractsController
{
    use GeneralFunctions;
	public function index(Company  $company ,$type)
    {
		$contracts = Contract::where('company_id',$company->id)->where('model_type',$type)->get();
		$customerOrSupplierContractsText = $type == 'Supplier' ? __('Supplier Contracts') : __('Customer Contracts');
		$items = [];
		foreach($contracts as $index=>$contract){
				$contractId = $contract->id ;
				$items[$contractId]['parent'] = [
					'name'=>$contract->getName() ,
					'client_name'=>$contract->getClientName(),
					'start_date'=>$contract->getStartDateFormatted(),
					'end_date'=>$contract->getEndDateFormatted(),
					'amount'=>$contract->getAmountFormatted()
				];
				foreach($contract->getOrders() as $order){
					$items[$contractId]['sub_items'][$order->id][$order->getOrderColumnName()] =$order->getNumber() ;
					$items[$contractId]['sub_items'][$order->id]['amount'] =$order->getAmountFormatted() ;
					$items[$contractId]['sub_items'][$order->id]['id'] =$order->id ;
				}
		}
        return view('contracts.index',compact('company','items','type','customerOrSupplierContractsText'));
    }
	public function create(Request $request,Company $company,string $type)
	{
		return view('contracts.form',$this->getCommonVars($company,$type));
	}
	public function getCommonVars(Company $company,string $type,$model = null):array 
	{
		$salesOrderOrPurchaseOrderInformationText = __('Sales Order Information');
		$salesOrderOrPurchaseNumberText =  $type == 'Supplier' ? __('PO Number') : __('SO Number'); 
		$salesOrderOrPurchaseNoText =  $type == 'Supplier' ? 'po_number' : 'so_number'; 
		$salesOrderOrPurchaseOrderRelationName = $type == 'Supplier' ? 'purchasesOrders' : 'salesOrders'; ;
		$salesOrderOrPurchaseOrderObject =  $type == 'Supplier' ? new PurchaseOrder() : new SalesOrder(); 
		$clients = Partner::onlyCompany($company->id);
		if($type == 'Supplier'){
			$clients =$clients->onlySuppliers();
			$salesOrderOrPurchaseOrderInformationText = __('Purchases Order Information');
		}else{
			$clients =$clients->onlyCustomers();
		}
		$clients = $clients->get();
		
		return [
			'company'=>$company,
			'clients'=>$clients,
			'type'=>$type,
			'salesOrderOrPurchaseOrderInformationText'=>$salesOrderOrPurchaseOrderInformationText,
			'salesOrderOrPurchaseNumberText'=>$salesOrderOrPurchaseNumberText,
			'salesOrderOrPurchaseNoText'=>$salesOrderOrPurchaseNoText,
			'salesOrderOrPurchaseOrderObject'=>$salesOrderOrPurchaseOrderObject,
			'salesOrderOrPurchaseOrderRelationName'=>$salesOrderOrPurchaseOrderRelationName,
			'model'=>$model
		]
		;
	}
	public function store(Request $request, Company $company,string $type){
			$contract = new Contract ;
			$contract->storeBasicForm($request);
			return redirect()->route('contracts.index',['company'=>$company->id,'type'=>$type]);
	}
	public function edit(Request $request,Company $company,Contract $contract,string $type)
	{
	
		
		return view('contracts.form',$this->getCommonVars($company,$type,$contract));
	}
	public function update(Company $company , Request $request , Contract $contract,string $type){
		
			$contract->storeBasicForm($request);
			return redirect()->route('contracts.index',['company'=>$company->id,'type'=>$type]);
	}
	public function destroy(Company $company , Request $request , Contract $contract,string $type){
		$contract->delete();
		return redirect()->route('contracts.index',['company'=>$company->id,'type'=>$type]);  
	}
}
