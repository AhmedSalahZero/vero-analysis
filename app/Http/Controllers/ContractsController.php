<?php
namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Partner;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
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
		$contractStatues = [
			Contract::RUNNING ,
			Contract::RUNNING_AND_AGAINST ,
			Contract::FINISHED 
		];
		
		$runningContracts = Contract::where('company_id',$company->id)->where('status',Contract::RUNNING )->where('model_type',$type)->get();
		$runningAndAgainstContracts = Contract::where('company_id',$company->id)->where('status',Contract::RUNNING_AND_AGAINST )->where('model_type',$type)->get();
		$finishedContracts = Contract::where('company_id',$company->id)->where('status',Contract::FINISHED )->where('model_type',$type)->get();
		$contracts = [
			Contract::RUNNING=>$runningContracts ,
			Contract::RUNNING_AND_AGAINST=>$runningAndAgainstContracts,
			Contract::FINISHED=>$finishedContracts
		];
		$customerOrSupplierContractsText = $type == 'Supplier' ? __('Supplier Contracts') : __('Customer Contracts');
		$items = [];
		foreach($contractStatues as $contractStatus){
			foreach($contracts[$contractStatus] as $index=>$contract){
				$contractId = $contract->id ;
				$items[$contractStatus][$contractId]['parent'] = [
					'name'=>$contract->getName() ,
					'client_name'=>$contract->getClientName(),
					'start_date'=>$contract->getStartDateFormatted(),
					'end_date'=>$contract->getEndDateFormatted(),
					'amount'=>$contract->getAmountFormatted()
				];
				foreach($contract->getOrders() as $order){
					$items[$contractStatus][$contractId]['sub_items'][$order->id][$order->getOrderColumnName()] =$order->getNumber() ;
					$items[$contractStatus][$contractId]['sub_items'][$order->id]['amount'] =$order->getAmountFormatted() ;
					$items[$contractStatus][$contractId]['sub_items'][$order->id]['id'] =$order->id ;
				}
		}
		}
		

        return view('contracts.index',compact('company','items','type','customerOrSupplierContractsText','contractStatues'));
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
	public function markAsFinished(Company $company , Request $request , Contract $contract,string $type){
		$contract->update([
			'status'=>Contract::FINISHED ,
		]);
		return redirect()->route('contracts.index',['company'=>$company->id,'type'=>$type]);  
	}
	public function markAsRunningAndAgainst(Company $company , Request $request , Contract $contract,string $type){
		$contract->update([
			'status'=>Contract::RUNNING_AND_AGAINST ,
		]);
		return redirect()->route('contracts.index',['company'=>$company->id,'type'=>$type]);  
	}
	public function updateContractsBasedOnCustomer(Request $request , Company $company ){
		$customer = Partner::find($request->get('customerId'));
		$contracts = $customer->contracts->pluck('name','id')->toArray();
		return response()->json([
			'contracts'=>$contracts
		]);
	}
	public function updatePurchaseOrdersBasedOnContract(Request $request , Company $company ){
		$contract = Contract::find($request->get('contractId'));
		$purchaseOrders = $contract->salesOrders->pluck('so_number','id')->toArray();

		return response()->json([
			'purchase_orders'=>$purchaseOrders
		]);
	}
	
}
