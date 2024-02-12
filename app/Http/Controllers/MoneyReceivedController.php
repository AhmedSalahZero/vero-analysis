<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreMoneyReceivedRequest;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\MoneyReceived;
use App\Traits\GeneralFunctions;
use Arr;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MoneyReceivedController
{
    use GeneralFunctions;
    protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName = $searchFieldName === 'due_date' ? 'due_date' : 'receiving_date'; 
		if($searchFieldName =='cheque_deposit_date'){
			$dateFieldName = 'cheque_deposit_date';
		}
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($moneyReceived) use ($value,$searchFieldName){
				$currentValue = $moneyReceived->{$searchFieldName} ;
				
				if($searchFieldName == 'receiving_branch_id'){
					$currentValue = $moneyReceived->getCashBranchName() ;  
				}
				if($searchFieldName == 'receiving_bank_id'){
					$currentValue = $moneyReceived->getReceivingBankName() ;  
				}
				if($searchFieldName == 'drawee_bank_id'){
					$currentValue = $moneyReceived->getDraweeBankName() ;  
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
		->sortByDesc('receiving_date');
		
		return $collection;
	}
	public function index(Company $company,Request $request)
	{
		
		$moneyType = $request->get('active') ;
		$user = $request->user()->load('moneyReceived') ;
		$receivedCashes = $user->getReceivedCashes() ;
		$financialInstitutionBanks = FinancialInstitution::onlyBanks()->get()->keyBy('id')->map(function($item){
			return $item->getName();
		})->toArray();
		// dd(($financialInstitutionBanks));
		
		$receivedCashes = $moneyType == 'cash' ? $this->applyFilter($request,$receivedCashes) :$receivedCashes  ;
		$receivedTransfer = $user->getReceivedTransfer() ;
		$receivedTransfer = $moneyType === 'money-transfer' ? $this->applyFilter($request,$receivedTransfer) : $receivedTransfer  ;
		$receivedChequesInSave = $user->getReceivedCheques()->whereIn('cheque_status',['in safe','rejected']);
		$receivedChequesInSave = $moneyType == 'cheques-in-safe' ? $this->applyFilter($request,$receivedChequesInSave) : $receivedChequesInSave;
		$receivedChequesUnderCollection=  $user->getReceivedCheques()->where('cheque_status','under_collection') ;
		$receivedChequesUnderCollection=  $moneyType == 'cheques-under-collection' ? $this->applyFilter($request,$receivedChequesUnderCollection) : $receivedChequesUnderCollection ;
		
		$selectedBanks = MoneyReceived::getBanksForCurrentCompany($company->id) ;
		$chequesReceivedTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'cheque_number'=>__('Cheque Number'),
			'currency'=>__('Currency'),
			'drawee_bank_id'=>__('Drawee Bank'),
			'due_date'=>__('Due Date'),
			'cheque_status'=>__('Status')
		];
		
		$chequesUnderCollectionTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'cheque_number'=>__('Cheque Number'),
			'received_amount'=>__('Cheque Amount'),
			'cheque_deposit_date'=>__('Deposit Date'),
			'cheque_drawl_bank_id'=>__('Drawal Bank'),
			'cheque_sub_account_number'=>__('Sub Account Number'),
			'cheque_clearance_days'=>'Clearance Days'
		];
		$incomingTransferTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'receiving_bank_id'=>__('Receiving Bank'),
			'received_amount'=>__('Transfer Amount'),
			'currency'=>__('Currency'),
			'sub_account_number'=>__('Sub Account Number')
		];
		$cashReceivedTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'receiving_branch_id'=>__('Branch'),
			'received_amount'=>__('Received Amount'),
			'currency'=>__('Currency'),
			'receipt_number'=>__('Receipt Number')
		];
		
		
		
		$banks = Bank::pluck('view_name','id');
		
        return view('reports.moneyReceived.index', compact('company','receivedChequesInSave','receivedCashes','chequesReceivedTableSearchFields','receivedTransfer','selectedBanks','banks','receivedChequesUnderCollection','chequesUnderCollectionTableSearchFields','cashReceivedTableSearchFields','incomingTransferTableSearchFields','financialInstitutionBanks'));
    }
	
	public function create(Company $company,$singleModel = null)
	{
		$banks = Bank::pluck('view_name','id');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$selectedBanks = MoneyReceived::getBanksForCurrentCompany($company->id) ;
		$customerInvoices =  $singleModel ?  CustomerInvoice::where('id',$singleModel)->pluck('customer_name','id') :CustomerInvoice::where('company_id',$company->id)->pluck('customer_name','id')->unique()->toArray(); 
		$invoiceNumber = $singleModel ? CustomerInvoice::where('id',$singleModel)->first()->getInvoiceNumber():null;
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
	public function getInvoiceNumber(Company $company ,  Request $request , int $customerInvoiceId,?string $selectedCurrency=null)
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
		
		$allCurrencies = $invoices->pluck('currency','currency')->mapWithKeys(function($value,$key){
			return [
				strtolower($key)=>strtolower($value) 
			];
		});		
		if($selectedCurrency){
			$invoices = $invoices->where('currency','=',$selectedCurrency);	
		}
		$invoices = $invoices->orderBy('invoice_date','asc')
		->get(['invoice_number','invoice_date','net_invoice_amount','collected_amount','net_balance','currency'])
		->toArray();
		
		foreach($invoices as $index=>$invoiceArr){
			$invoices[$index]['settlement_amount'] = $moneyReceived ? $moneyReceived->getSettlementsForInvoiceNumberAmount($invoiceArr['invoice_number'],$customerName) : 0;
			$invoices[$index]['withhold_amount'] = $moneyReceived ? $moneyReceived->getWithholdForInvoiceNumberAmount($invoiceArr['invoice_number'],$customerName) : 0;
		}
		
		$invoices = $this->formatInvoices($invoices,$inEditMode);
			return response()->json([
				'status'=>true , 
				'invoices'=>$invoices,
				'currencies'=>$allCurrencies,
				'selectedCurrency'=>$selectedCurrency
				// 'max_cheque_amount'=>$maxChequeAmount
			]);
		
	}
	protected function formatInvoices(array $invoices,int $inEditMode){
		$result = [];
		foreach($invoices as $index=>$invoiceArr){
			$result[$index]['invoice_number'] = $invoiceArr['invoice_number'];
			$result[$index]['currency'] = $invoiceArr['currency'];
			$result[$index]['net_invoice_amount'] = $invoiceArr['net_invoice_amount'];
			$result[$index]['collected_amount'] = $inEditMode 	?  $invoiceArr['collected_amount'] - $invoiceArr['settlement_amount'] : $invoiceArr['collected_amount'];
			$result[$index]['net_balance'] = $inEditMode ? $invoiceArr['net_balance'] +  $invoiceArr['settlement_amount']  : $invoiceArr['net_balance']  ;
			$result[$index]['settlement_amount'] = $inEditMode ? $invoiceArr['settlement_amount'] : 0;
			$result[$index]['withhold_amount'] = $inEditMode ? $invoiceArr['withhold_amount'] : 0;
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
		$data = $request->only(['money_type','receiving_date','currency']);
		$data['customer_name'] = $customerName;
		$data['user_id'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		
		$additionalData = [];

		$receivedAmount = 0 ;
		$exchangeRate = 1 ;
		if($moneyType =='cash'){
			$additionalData = ['receiving_branch','receipt_number'] ;
			$receivedAmount = $request->get('cash_received_amount',0) ;
			$exchangeRate = $request->get('cash_exchange_rate') ;
		}
		elseif($moneyType =='cheque'){
			$additionalData = ['drawee_bank_id','cheque_due_date','cheque_number'] ;
			$receivedAmount = $request->get('cheque_amount',0) ;
			$exchangeRate = $request->get('cheque_exchange_rate') ;
		}
		elseif($moneyType =='incoming_transfer'){
			$additionalData = ['receiving_bank_id','main_account_number','sub_account_number','receiving_branch_id'] ;
			$receivedAmount = $request->get('incoming_transfer_amount',0) ;
			$exchangeRate = $request->get('incoming_transfer_exchange_rate') ;
		}
		foreach($additionalData as $name){
			$data[$name] = $request->get($name);
		}
		if($moneyType =='cash' ){
			$data['receiving_branch_id'] = $this->generateBranchId($receivedBankName,$company->id) ;
		}
		$data['received_amount'] = $receivedAmount ;
		// $data['currency'] =$currency ;
		$data['exchange_rate'] =$exchangeRate ;
		$moneyReceived = MoneyReceived::create($data);
		$totalWithholdAmount= 0 ;
		foreach($request->get('settlements',[]) as $settlementArr)
		{
			$settlementArr['company_id'] = $company->id ;
			$settlementArr['customer_name'] = $customerName ;
			$totalWithholdAmount += $settlementArr['withhold_amount']  ;
			$moneyReceived->settlements()->create($settlementArr);
		}
		
		$moneyReceived->update([
			'total_withhold_amount'=>$totalWithholdAmount
		]);
		/**
		 * @var CustomerInvoice $customerInvoice
		 */
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
	public function edit(Company $company , Request $request , moneyReceived $moneyReceived ,$singleModel = null){
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
				'model'=>$moneyReceived,
				'singleModel'=>$singleModel
			]); 
		}
        return view('reports.moneyReceived.form',[
			'banks'=>$banks,
			'customerInvoices'=>$customerInvoices ,
			'selectedBranches'=>$selectedBranches,
			'selectedBanks'=>$selectedBanks,
			'model'=>$moneyReceived,
			'singleModel'=>$singleModel
			
		]);
		
	}
	
	public function update(Company $company , Request $request , moneyReceived $moneyReceived){
		$customerInvoiceId = $request->get('customer_id');
		$receivedBankName = $request->get('receiving_branch_id') ;
		$moneyType = $request->get('money_type');
		$customerInvoiceId = $request->get('customer_id');
		$customerInvoice = CustomerInvoice::find($customerInvoiceId);
		$customerName = $customerInvoice->getCustomerName();
		$data = $request->only(['money_type','receiving_date','currency']);
		$data['customer_name'] = $customerName;
		$data['user_id'] = auth()->user()->id ;
		
		
		
		$additionalData = [];
		
		$receivedAmount = 0 ;
		$currency= null  ;
		
		if($moneyType =='cash'){
			$additionalData = ['receiving_branch','receipt_number'] ;
			$receivedAmount = $request->get('cash_received_amount',0);
			$currency = $request->get('cash_currency');
		}
		elseif($moneyType =='cheque'){
			$additionalData = ['drawee_bank_id','cheque_due_date','cheque_number','cheque_exchange_rate'] ;
			$receivedAmount = $request->get('cheque_amount',0);
			$currency = $request->get('cheque_currency');
		}
		elseif($moneyType =='incoming_transfer'){
			$additionalData = ['receiving_bank_id','main_account_number','sub_account_number'] ;
			$receivedAmount = $request->get('incoming_transfer_amount',0);
			$currency = $request->get('cheque_currency');
		}
		foreach($additionalData as $name){
			$data[$name] = $request->get($name);
		}
		if($moneyType =='cash' ){
			$data['receiving_branch_id'] = $this->generateBranchId($receivedBankName,$company->id) ;
		}
		$data['received_amount'] = $receivedAmount ;
		$data['currency'] = $currency?:Arr::get($data,'currency') ;
		$data['currency'] = strtolower($data['currency']);
		$moneyReceived->update($data);
		$customerInvoice = CustomerInvoice::find($customerInvoiceId);
		$moneyReceived->settlements->each(function($settlement){
			$settlement->delete();
		});
		
		$totalWithholdAmount = 0 ;
		foreach($request->get('settlements',[]) as $settlementArr)
		{
			$settlementArr['company_id'] = $company->id ;
			$settlementArr['customer_name'] = $customerName ;
			$totalWithholdAmount += $settlementArr['withhold_amount'];
			
			$moneyReceived->settlements()->create($settlementArr);
		}
		$moneyReceived->update([
			'total_withhold_amount'=>$totalWithholdAmount 
		]);
		
		 $moneyReceived->customerInvoice->syncNetBalance() ;
		 $activeTab = $this->getActiveTab($moneyType);
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Money Received Has Been Updated Successfully'));
		
		
	}
	
	public function destroy(Company $company , MoneyReceived $moneyReceived)
	{
		$moneyReceived->settlements->each(function($settlement){
			$settlement->delete();
		});
		// $moneyReceived->customerInvoice->syncNetBalance();
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
