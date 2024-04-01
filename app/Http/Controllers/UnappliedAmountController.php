<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreMoneyReceivedRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Cheque;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\MoneyReceived;
use App\Models\Partner;
use App\Models\UnappliedAmount;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UnappliedAmountController
{
    use GeneralFunctions;
    protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName = 'settlement_date'; 
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($settlement) use ($value,$searchFieldName){
				$currentValue = $settlement->{$searchFieldName} ;
				$moneyReceivedRelationName = 'unappliedAmount' ;
				$relationRecord = $settlement->$moneyReceivedRelationName ;
				/**
				 * * بمعني لو مالقناش القيمة في جدول ال
				 * * moneyReceived
				 * * هندور عليها في العلاقه 
				 */
				$currentValue = is_null($currentValue) && $relationRecord ? $relationRecord->{$searchFieldName}  :$currentValue ;
				return false !== stristr($currentValue , $value);
			});
		})
		->when($request->get('from') , function($collection) use($dateFieldName,$from){
			return $collection->where($dateFieldName,'>=',$from);
		})
		->when($request->get('to') , function($collection) use($dateFieldName,$to){
			return $collection->where($dateFieldName,'<=',$to);
		})
		->sortByDesc('settlement_date');
		
		return $collection;
	}
	public function index(Company $company,Request $request,int $partnerId)
	{
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$startDate = $request->has('startDate') ? $request->input('startDate') : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
		$endDate = $request->has('endDate') ? $request->input('endDate') : now()->format('Y-m-d');
		$customer = Partner::find($partnerId);
		$unappliedAmountSettlements = $customer->getSettlementForUnappliedAmounts($startDate ,$endDate) ;
		$unappliedAmountSettlements =$this->applyFilter($request,$unappliedAmountSettlements);
		$searchFields = [
			'invoice_number'=>__('Invoice Number'),
			'settlement_date'=>__('Settlement Date'),
		];
		
        return view('unapplied-amounts.index', [
			'company'=>$company ,
			'filterStartDate'=>$startDate,
			'filterEndDate'=>$endDate ,
			'searchFields'=>$searchFields,
			'models'=>$unappliedAmountSettlements,
			'partnerId'=>$partnerId
		]);
    }
	
	public function create(Company $company,$customerInvoiceId)
	{
		$customerInvoices =  CustomerInvoice::where('id',$customerInvoiceId)->pluck('customer_name','id') ; 
		$invoiceNumber =CustomerInvoice::where('id',$customerInvoiceId)->first()->getInvoiceNumber();
        return view('unapplied-amounts.form',[
			'customerInvoices'=>$customerInvoices ,
			'invoiceNumber'=>$invoiceNumber,
		]);
    }
	
	public function result(Company $company , Request $request){
		
		return view('reports.moneyReceived.form',[
		]);
	}
	
	protected function formatInvoices(array $invoices,int $inEditMode){
		$result = [];
		foreach($invoices as $index=>$invoiceArr){
			$result[$index]['invoice_number'] = $invoiceArr['invoice_number'];
			$result[$index]['currency'] = $invoiceArr['currency'];
			$result[$index]['net_invoice_amount'] = $invoiceArr['net_invoice_amount'];
			$result[$index]['collected_amount'] = $inEditMode 	?  (double)$invoiceArr['collected_amount'] - (double) $invoiceArr['settlement_amount']  : (double)$invoiceArr['collected_amount'];
			$result[$index]['net_balance'] = $inEditMode ? $invoiceArr['net_balance'] +  $invoiceArr['settlement_amount']  + (double) $invoiceArr['withhold_amount'] : $invoiceArr['net_balance']  ;
			$result[$index]['settlement_amount'] = $inEditMode ? $invoiceArr['settlement_amount'] : 0;
			$result[$index]['withhold_amount'] = $inEditMode ? $invoiceArr['withhold_amount'] : 0;
			$result[$index]['invoice_date'] = Carbon::make($invoiceArr['invoice_date'])->format('d-m-Y');
		}
		return $result;
	}
	
	public function store(Company $company , Request $request){
		$customerInvoiceId = $request->get('customer_id');
		$customerInvoice = CustomerInvoice::find($customerInvoiceId);
		$invoiceNumber = $customerInvoice->getInvoiceNumber();
		$customerName = $customerInvoice->getName();
		$totalWithholdAmount= 0 ;
		$unappliedAmount = UnappliedAmount::create([
			'company_id'=>$company->id ,
			'partner_id'=>$customerInvoice->customer_id ,
			'settlement_date'=>now()->format('Y-m-d'),
			'amount'=>$request->input('settlements.'.$invoiceNumber.'.settlement_amount') * -1 ,
			'net_balance_until_date'=>0 ,
		]);
		foreach($request->get('settlements',[]) as $settlementArr)
		{
				$settlementArr['company_id'] = $company->id ;
				$settlementArr['customer_name'] = $customerName ;
				$totalWithholdAmount += $settlementArr['withhold_amount']  ;
				$unappliedAmount->settlements()->create($settlementArr);
		}
		dd('good');
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}
	protected function getActiveTab(string $moneyType)
	{
		return $moneyType ;

	}
	public function edit(Company $company , Request $request , moneyReceived $moneyReceived ,$singleModel = null){
		$banks = Bank::pluck('view_name','id');
		$selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$customerInvoices = CustomerInvoice::where('company_id',$company->id)->pluck('customer_name','id')->unique()->toArray(); 
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
		if($moneyReceived->isChequeUnderCollection()){
			return view('reports.moneyReceived.edit-cheque-under-collection',[
				'banks'=>$banks,
				'customerInvoices'=>$customerInvoices ,
				'selectedBranches'=>$selectedBranches,
				'selectedBanks'=>$selectedBanks,
				'model'=>$moneyReceived,
				'singleModel'=>$singleModel,
				'accountTypes'=>$accountTypes,
				'financialInstitutionBanks'=>$financialInstitutionBanks
			]); 
		}
        return view('reports.moneyReceived.form',[
			'banks'=>$banks,
			'customerInvoices'=>$customerInvoices ,
			'selectedBranches'=>$selectedBranches,
			'accountTypes'=>$accountTypes,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'selectedBanks'=>$selectedBanks,
			'model'=>$moneyReceived,
			'singleModel'=>$singleModel
		]);
		
	}
	
	public function update(Company $company , StoreMoneyReceivedRequest $request , moneyReceived $moneyReceived){
		$oldType = $moneyReceived->getType();
		$newType = $request->get('type');
		$oldTypeRelationName = dashesToCamelCase($oldType);
		$moneyReceived->$oldTypeRelationName ? $moneyReceived->$oldTypeRelationName->delete() : null;
		$moneyReceived->delete();
		$this->store($company,$request);
		 $activeTab = $newType;
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Money Received Has Been Updated Successfully'));
	}
	
	public function destroy(Company $company , MoneyReceived $moneyReceived)
	{
		$moneyReceived->settlements->each(function($settlement){
			$settlement->delete();
		});
		$activeTab = $moneyReceived->getType();
		$moneyReceived->delete();
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Money Received Has Been Updated Successfully'));
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
		$moneyReceivedIds = $request->get('cheques') ;
		$moneyReceivedIds = is_array($moneyReceivedIds) ? $moneyReceivedIds :  explode(',',$moneyReceivedIds);
		$data = $request->only(['deposit_date','drawl_bank_id','account_type','account_number','account_balance','clearance_days']);
		
		$data['status'] = Cheque::UNDER_COLLECTION;
		foreach($moneyReceivedIds as $moneyReceivedId){
			$moneyReceived = MoneyReceived::find($moneyReceivedId) ;
			$data['expected_collection_date'] = $moneyReceived->cheque->calculateChequeExpectedCollectionDate($data['deposit_date'],$data['clearance_days']);
			$moneyReceived->cheque->update($data);
		}
		if($request->ajax()){
			return response()->json([
				'status'=>true ,
				'msg'=>__('Good'),
				'pageLink'=>route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_UNDER_COLLECTION])
			]);	
		}
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_UNDER_COLLECTION]);
		
	}
	/**
	 * * تحديد ان الشيك دا تم بالفعل صرفة من البنك ونزل في حسابك
	 */
	public function applyCollection(Company $company,Request $request,MoneyReceived $moneyReceived)
	{
		$moneyReceived->cheque->update([
			'status'=>Cheque::COLLECTED,
			'collection_fees'=>$request->get('collection_fees'),
			'actual_collection_date'=>$request->get('actual_collection_date') 
		]);
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_COLLECTED])->with('success',__('Cheque Is Returned To Safe'));
	}
	
	public function sendToSafe(Company $company,Request $request,MoneyReceived $moneyReceived)
	{
		$moneyReceived->cheque->update([
			'status'=>Cheque::IN_SAFE,
			'deposit_date'=>null ,
			'drawl_bank_id'=>null ,
			'account_type'=>null ,
			'account_number'=>null ,
			'account_balance'=>null ,
			'expected_collection_date'=>null ,
			'clearance_days'=>null
		]);
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE])->with('success',__('Cheque Is Returned To Safe'));
	}
	public function sendToSafeAsRejected(Company $company,Request $request,MoneyReceived $moneyReceived)
	{
		
		$moneyReceived->cheque->update([
			'status'=>Cheque::REJECTED,
			'deposit_date'=>null ,
			'drawl_bank_id'=>null ,
			'account_type'=>null ,
			'account_number'=>null ,
			'account_balance'=>null ,
			'expected_collection_date'=>null ,
			'clearance_days'=>null
		]);
		return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_REJECTED])->with('success',__('Cheque Is Returned To Safe'));
		
	}

	public function getAccountNumbersForAccountType(Company $company ,  Request $request ,  string $accountType,?string $selectedCurrency=null , ?int $financialInstitutionId = 0){
		$accountType = AccountType::find($accountType);
		$accountNumberModel =  ('\App\Models\\'.$accountType->getModelName())::getAllAccountNumberForCurrency($company->id , $selectedCurrency,$financialInstitutionId);
		return response()->json([
			'status'=>true , 
			'data'=>$accountNumberModel
		]);
	}
}
