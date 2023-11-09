<?php
use App\Http\Controllers\ExportTable;
namespace App\Http\Controllers;
use App\Http\Requests\StoreMoneyReceivedRequest;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\MoneyReceived;
use App\Models\SalesGathering;
use App\Models\Settlement;
use App\ReadyFunctions\InvoiceAgingService;
use App\Services\Caching\CustomerDashboardCashing;
use App\Traits\GeneralFunctions;
use App\Traits\Intervals;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoneyReceivedController
{
    use GeneralFunctions;
    public function index(Company $company,Request $request)
	{
		$user = $request->user()->load('moneyReceived') ;
		$receivedCashes = $user->getReceivedCashes();
		$receivedTransfer = $user->getReceivedTransfer();
		$receivedChequesInSave = $user->getReceivedCheques()->whereIn('cheque_status',['in safe','rejected']);
		$receivedChequesUnderCollection= $user->getReceivedCheques()->where('cheque_status','under_collection');
		$selectedBanks = MoneyReceived::getBanksForCurrentCompany($company->id) ;
		$banks = Bank::pluck('view_name','id');
		
        return view('reports.moneyReceived.index', compact('company','receivedChequesInSave','receivedCashes','receivedTransfer','selectedBanks','banks','receivedChequesUnderCollection'));
    }
	
	public function create(Company $company,$singleModel = null)
	{
		$banks = Bank::pluck('view_name','id');
		
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;

		$selectedBanks = MoneyReceived::getBanksForCurrentCompany($company->id) ;
		
		
		$customerInvoices =  $singleModel ?  CustomerInvoice::where('id',$singleModel)->pluck('customer_name','id') :CustomerInvoice::where('company_id',$company->id)->pluck('customer_name','id')->unique()->toArray(); 
		$invoiceNumber = $singleModel ? CustomerInvoice::where('id',$singleModel)->first()->getInvoiceNumber():null;
		// dd($invoiceNumber);
        return view('reports.moneyReceived.form',[
			'banks'=>$banks,
			'customerInvoices'=>$customerInvoices ,
			'selectedBranches'=>$selectedBranches,
			'selectedBanks'=>$selectedBanks,
			'singleModel'=>$singleModel,
			'invoiceNumber'=>$invoiceNumber
		]);
    }
	
	public function result(Company $company , Request $request){
		
		return view('reports.moneyReceived.form',[
		]);
	}
	public function getInvoiceNumber(Company $company ,  Request $request , int $customerInvoiceId)
	{
		$companyId = $company->id ; 
		$inEditMode = $request->get('inEditMode');
		$moneyReceivedId = $request->get('money_received_id');
		$moneyReceived = MoneyReceived::find($moneyReceivedId);
		$customer = CustomerInvoice::find($customerInvoiceId);
		
		$customerName = $customer->customer_name ;
		$invoices = CustomerInvoice::where('customer_name',$customerName)->where('company_id',$company->id)
		->where('net_invoice_amount','>',0);
		if(!$inEditMode){
			$invoices->where('net_balance','>',0);
		}
		$invoices = $invoices
		->orderBy('invoice_date','asc')
		->get(['invoice_number','invoice_date','net_invoice_amount','collected_amount','net_balance'])
		->toArray();
		// $maxChequeAmount = array_sum(array_column($invoices,'net_balance'));
		// $totalInstallments = 0 ;
		foreach($invoices as $index=>$invoiceArr){
			$invoices[$index]['settlement_amount'] = $moneyReceived ? $moneyReceived->getSettlementsForInvoiceNumberAmount($invoiceArr['invoice_number'],$customerName) : 0;
			// $totalInstallments += $invoices[$index]['settlement_amount'] ;
			// $invoices[$index]['settlement_amount'] = Settlement::getSettlementAmountByInvoiceNumber($invoiceArr['invoice_number'],$companyId);
		}
		// $maxChequeAmount = $maxChequeAmount + $totalInstallments ; // in add mode $totalInstallments = 0 ;
		$invoices = $this->formatInvoices($invoices,$inEditMode);
			return response()->json([
				'status'=>true , 
				'invoices'=>$invoices,
				// 'max_cheque_amount'=>$maxChequeAmount
			]);
		
	}
	protected function formatInvoices(array $invoices,int $inEditMode){
		$result = [];
		foreach($invoices as $index=>$invoiceArr){
			$result[$index]['invoice_number'] = $invoiceArr['invoice_number'];
			$result[$index]['net_invoice_amount'] = $invoiceArr['net_invoice_amount'];
			$result[$index]['collected_amount'] = $inEditMode ?  $invoiceArr['collected_amount'] - $invoiceArr['settlement_amount'] : $invoiceArr['collected_amount'];
			$result[$index]['net_balance'] = $inEditMode ? $invoiceArr['net_balance'] +  $invoiceArr['settlement_amount']  : $invoiceArr['net_balance']  ;
			$result[$index]['settlement_amount'] = $inEditMode ? $invoiceArr['settlement_amount'] : 0;
			$result[$index]['invoice_date'] = Carbon::make($invoiceArr['invoice_date'])->format('d-m-Y');
		}
		return $result;
	}
	
	public function store(Company $company , StoreMoneyReceivedRequest $request){
		$moneyType = $request->get('money_type');
		$customerInvoiceId = $request->get('customer_id');
		$customerInvoice = CustomerInvoice::find($customerInvoiceId);
		$customerName = $customerInvoice->getCustomerName();
		$receivedBankName = $request->get('receiving_branch_id') ;
		$data = $request->only(['money_type','receiving_date']);
		
		$data['customer_name'] = $customerName;
		$data['user_id'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		
		$additionalData = [];

		
		if($moneyType =='cash'){
			$additionalData = ['receiving_branch','cash_received_amount','cash_currency','receipt_number'] ;
		}
		elseif($moneyType =='cheque'){
			$additionalData = ['drawee_bank_id','cheque_amount','cheque_due_date','cheque_number'] ;
		}
		elseif($moneyType =='incoming_transfer'){
			$additionalData = ['receiving_bank_id','incoming_transfer_amount','income_transfer_currency','main_account_number','sub_account_number','receiving_branch_id'] ;
		}
		foreach($additionalData as $name){
			$data[$name] = $request->get($name);
		}
		if($moneyType =='cash' ){
			$data['receiving_branch_id'] = $this->generateBranchId($receivedBankName,$company->id) ;
		}
		$moneyReceived = MoneyReceived::create($data);
		foreach($request->get('settlements',[]) as $settlementArr)
		{
			$settlementArr['company_id'] = $company->id ;
			$settlementArr['customer_name'] = $customerName ;
			$moneyReceived->settlements()->create($settlementArr);
		}
		$customerInvoice->syncNetBalance();
		$activeTab = $this->getActiveTab($moneyType);
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}
	protected function getActiveTab(string $moneyType)
	{
		return [
			'cheque'=>'cheques-in-safe',
			'cash'=>'cash',
			'incoming_transfer'=>'money-transfer'
		][$moneyType];
	}
	public function edit(Company $company , Request $request , moneyReceived $moneyReceived ){
		$banks = Bank::pluck('view_name','id');
		$selectedBanks = MoneyReceived::getBanksForCurrentCompany($company->id) ;
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$customerInvoices = CustomerInvoice::where('company_id',$company->id)->pluck('customer_name','id')->unique()->toArray(); 
		if($moneyReceived->isChequeUnderCollection()){
			return view('reports.moneyReceived.edit-cheque-under-collection',[
				'banks'=>$banks,
				'customerInvoices'=>$customerInvoices ,
				'selectedBranches'=>$selectedBranches,
				'selectedBanks'=>$selectedBanks,
				'model'=>$moneyReceived
			]); 
		}
        return view('reports.moneyReceived.form',[
			'banks'=>$banks,
			'customerInvoices'=>$customerInvoices ,
			'selectedBranches'=>$selectedBranches,
			'selectedBanks'=>$selectedBanks,
			'model'=>$moneyReceived
		]);
		
	}
	
	public function update(Company $company , Request $request , moneyReceived $moneyReceived){
		$customerInvoiceId = $request->get('customer_id');
		$receivedBankName = $request->get('receiving_branch_id') ;
		$moneyType = $request->get('money_type');
		$customerInvoiceId = $request->get('customer_id');
		$customerInvoice = CustomerInvoice::find($customerInvoiceId);
		$customerName = $customerInvoice->getCustomerName();
		$data = $request->only(['money_type','receiving_date']);
		$data['customer_name'] = $customerName;
		$data['user_id'] = auth()->user()->id ;
		
		$additionalData = [];

		
		if($moneyType =='cash'){
			$additionalData = ['receiving_branch','cash_received_amount','cash_currency','receipt_number'] ;
		}
		elseif($moneyType =='cheque'){
			$additionalData = ['drawee_bank_id','cheque_amount','cheque_due_date','cheque_number'] ;
		}
		elseif($moneyType =='incoming_transfer'){
			$additionalData = ['receiving_bank_id','incoming_transfer_amount','income_transfer_currency','main_account_number','sub_account_number'] ;
		}
		foreach($additionalData as $name){
			$data[$name] = $request->get($name);
		}
		if($moneyType =='cash' ){
			$data['receiving_branch_id'] = $this->generateBranchId($receivedBankName,$company->id) ;
		}
		$moneyReceived->update($data);
		
		$customerInvoice = CustomerInvoice::find($customerInvoiceId);
		$moneyReceived->settlements->each(function($settlement){
			$settlement->delete();
		});
		
		foreach($request->get('settlements',[]) as $settlementArr)
		{
			$settlementArr['company_id'] = $company->id ;
			$settlementArr['customer_name'] = $customerName ;
			$moneyReceived->settlements()->create($settlementArr);
		}
		 $moneyReceived->customerInvoice->syncNetBalance() ;
		 $activeTab = $this->getActiveTab($moneyType);
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Money Received Has Been Updated Successfully'));
		
		
	}
	
	public function destroy(Company $company , MoneyReceived $moneyReceived)
	{
		$moneyReceived->settlements->each(function($settlement){
			$settlement->delete();
		});
		$moneyReceived->customerInvoice->syncNetBalance();
		$moneyReceived->delete();
		return redirect()->back()->with('success',__('Money Received Has Been Delete Successfully'));
	}
	protected function generateBranchId($nameOrId,$companyId){
		$branch = Branch::where('id',$nameOrId)->first();
			if(!$branch){
				$branch = Branch::create([
					'name'=>$nameOrId,
					'company_id'=>$companyId ,
					'created_by'=>auth()->user()->id
				]);
			}
			return $branch->id ;
	}
	public function sendToCollection(Company $company,Request $request)
	{
		$cheques = $request->get('cheques') ;
		$chequeIds = is_array($cheques) ? $cheques :  explode(',',$cheques);
		$data = $request->only(['cheque_deposit_date','cheque_drawl_bank_id','cheque_main_account_number','cheque_sub_account_number','cheque_account_balance','cheque_clearance_days']);
		
		$data['cheque_status'] = 'under_collection';
		foreach($chequeIds as $chequesId){
			$cheque = MoneyReceived::find($chequesId) ;
			$data['cheque_expected_collection_date'] = $cheque->calculateChequeExpectedCollectionDate($data['cheque_deposit_date'],$data['cheque_clearance_days']);
			$cheque->update($data);
		}
		if($request->ajax()){
			return response()->json([
				'status'=>true ,
				'msg'=>__('Good')
			]);	
		}
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>'cheques-under-collection']);
		
	}
	
	public function sendToSafe(Company $company,Request $request,MoneyReceived $moneyReceived)
	{
		$moneyReceived->update([
			'cheque_status'=>'in safe',
			'cheque_deposit_date'=>null ,
			'cheque_drawl_bank_id'=>null ,
			'cheque_main_account_number'=>null ,
			'cheque_sub_account_number'=>null ,
			'cheque_account_balance'=>null ,
			'cheque_expected_collection_date'=>null ,
			'cheque_clearance_days'=>null
		]);
		
		return redirect()->back()->with('success'  , __('Cheque Is Returned To Safe'));
		
	}
	public function sendToSafeAsRejected(Company $company,Request $request,MoneyReceived $moneyReceived)
	{
		$moneyReceived->update([
			'cheque_status'=>'rejected',
			'cheque_deposit_date'=>null ,
			'cheque_drawl_bank_id'=>null ,
			'cheque_main_account_number'=>null ,
			'cheque_sub_account_number'=>null ,
			'cheque_account_balance'=>null ,
			'cheque_expected_collection_date'=>null ,
			'cheque_clearance_days'=>null
		]);
		
		return redirect()->back()->with('success'  , __('Cheque Is Returned To Safe'));
		
	}
	
}
