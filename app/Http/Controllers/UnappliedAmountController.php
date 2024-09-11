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
use App\Models\Settlement;
use App\Models\UnappliedAmount;
use App\Traits\GeneralFunctions;
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
	public function index(Company $company,Request $request,int $partnerId,string $modelType)
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
			'partnerId'=>$partnerId,
			'modelType'=>$modelType
		]);
    }
	
	public function create(Company $company,$customerInvoiceId,$modelType)
	{
		// 
		$availableUnappliedAmount = UnappliedAmount::getFirstAvailableModel();
		dd($availableUnappliedAmount);
		$customerInvoice = CustomerInvoice::find($customerInvoiceId);
        return view('unapplied-amounts.form',$this->getCommonVars($modelType,$company,$customerInvoice));
    }
	
	

	
	
	public function store(Company $company , Request $request,string $modelType){
		
		$fullClassName = ('\App\Models\\' . $modelType) ;
        $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        $clientNameColumnName = $fullClassName::CLIENT_NAME_COLUMN_NAME ;
        $unappliedSettlementTable = $fullClassName::UNAPPLIED_SETTLEMENT_TABLE ;
        $moneyModelName = $fullClassName::MONEY_MODEL_NAME ;
		$partnerId = $request->get($clientIdColumnName);
		
		/**
		 * @var CustomerInvoice $customerInvoice
		 */
		
		$customerInvoice = $fullClassName::find($request->get('invoiceId'));
		$invoiceNumber = $customerInvoice->getInvoiceNumber();
		$customerName = $customerInvoice->getName();
		$currency = $customerInvoice->getCurrency();
		// $unappliedAmount = UnappliedAmount::create([
		// 	'company_id'=>$company->id ,
		// 	'partner_id'=>$partnerId ,
		// 	'settlement_date'=>now()->format('Y-m-d'),
		// 	'amount'=>$request->input('settlements.'.$invoiceNumber.'.settlement_amount') * -1 ,
		// 	'net_balance_until_date'=>0 ,
		// 	'model_type'=>$moneyModelName , 
		// 	'currency' => $currency  
		// ]);
		/**
		 * @var UnappliedAmount $unappliedAmount
		 */
		
		$unappliedAmount->storeNewSettlement($request->get('settlements',[]),$company->id,$clientNameColumnName,$customerName,$unappliedSettlementTable);
		
		
		return redirect()->route('view.settlement.by.unapplied.amounts',['company'=>$company->id,'partnerId'=>$partnerId,'modelType'=>$modelType]);
		
	}
	protected function getActiveTab(string $moneyType)
	{
		return $moneyType ;

	}
	
	public function edit(Company $company , Request $request ,  string $invoiceNumber , int $settlementId , string $modelType  ){
		
		$fullClassName = ('\App\Models\\' . $modelType) ;
        $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        $clientNameColumnName = $fullClassName::CLIENT_NAME_COLUMN_NAME ;
        $unappliedSettlementTable = $fullClassName::UNAPPLIED_SETTLEMENT_TABLE ;
        $moneyModelName = $fullClassName::MONEY_MODEL_NAME ;
		$settlement = Settlement::find($settlementId);
		$model = $settlement->unappliedAmount;

		$invoiceModel=$fullClassName::findByInvoiceNumber($company->id,$invoiceNumber);
	
		return view('unapplied-amounts.form',$this->getCommonVars($modelType,$company,$invoiceModel,$model,$invoiceModel,$settlement));
	}
	
	public function getCommonVars($modelType ,$company  , $customerInvoice , $model = null , $invoiceModel = null ,$settlement = null )
	{
		$invoiceId = $customerInvoice->id ;
		$fullClassName = ('\App\Models\\' . $modelType) ;
        $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        $clientNameColumnName = $fullClassName::CLIENT_NAME_COLUMN_NAME ;
		$customerNameText = (new $fullClassName)->getClientNameText();
        $jsFile = $fullClassName::JS_FILE ;
		$currencies = $fullClassName::getCurrencies();
		$customerInvoices =  $fullClassName::where('id',$invoiceId)->pluck($clientNameColumnName,$clientIdColumnName) ; 
		$invoiceNumber =$fullClassName::where('id',$invoiceId)->first()->getInvoiceNumber();
		
		return [
			'customerInvoices'=>$customerInvoices ,
			'invoiceNumber'=>$invoiceNumber,
			'currencies'=>$currencies,
			'model'=>$model,
			'company'=>$company,
			'jsFile'=>$jsFile,
			'modelType'=>$modelType,
			'customerNameText'=>$customerNameText,
			'customerNameColumnName'=>$clientNameColumnName,
			'customerIdColumnName'=>$clientIdColumnName,
			'invoiceId'=>$invoiceId,
			'invoice'=>$customerInvoice,
			'dueDateFormatted'=>$invoiceModel ? $invoiceModel->getDueDateFormatted() : null,
			'invoiceDueDateFormatted'=>$invoiceModel ? $invoiceModel->getInvoiceDueDateFormatted() : null,
			'invoiceCurrency'=>$invoiceModel ? $invoiceModel->getCurrency() : null,
			'netInvoiceAmountFormatted'=>$invoiceModel ? $invoiceModel->getNetInvoiceAmountFormatted() : null,
			'collectedAmountFormatted'=>$invoiceModel ? number_format($invoiceModel->collected_amount?:0):0,
			'netBalanceFormatted'=>$invoiceModel ? $invoiceModel->getNetBalanceFormatted() : 0,
			'settlementAmount'=>$settlement ? $settlement->getAmount() : 0,
			'withholdAmount'=>$settlement ? $settlement->getWithholdAmount():0,
			'settlement'=>$settlement ? $settlement : null,
			'settlementDate'=>$model ? formatDateForDatePicker($model->getSettlementDate()) :formatDateForDatePicker(now()->format('Y-m-d'))
		] ;
	}
	
	public function update(Company $company , Request $request,string $modelType ,$unappliedAmountId , $settlementId)
	{
		$fullClassName = ('\App\Models\\' . $modelType) ;
        $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        $clientNameColumnName = $fullClassName::CLIENT_NAME_COLUMN_NAME ;
        $unappliedSettlementTable = $fullClassName::UNAPPLIED_SETTLEMENT_TABLE ;
        $moneyModelName = $fullClassName::MONEY_MODEL_NAME ;
		$partnerId = $request->get($clientIdColumnName);
		
		$settlement = Settlement::find($settlementId);
		$unappliedAmount = UnappliedAmount::find($unappliedAmountId);
		$customerInvoice = $fullClassName::find($request->get('invoiceId'));
		// $invoiceNumber = $customerInvoice->getInvoiceNumber();
		$customerName = $customerInvoice->getName();
		// $currency = $customerInvoice->getCurrency();

		$settlement->delete();
		$unappliedAmount->update([
			'settlement_date'=>$request->get('settlement_date')
		]);
		
		$unappliedAmount->storeNewSettlement($request->get('settlements',[]),$company->id,$clientNameColumnName,$customerName,$unappliedSettlementTable);
		return redirect()->route('view.settlement.by.unapplied.amounts',['company'=>$company->id,'partnerId'=>$partnerId,'modelType'=>$modelType]);
		
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
	// protected function generateBranchId($nameOrId,$companyId){
	// 	$branch = Branch::where('id',$nameOrId)->first();
	// 		if(!$branch){
	// 			$branch = Branch::create([
	// 				'name'=>$nameOrId,
	// 				'company_id'=>$companyId ,
	// 				'created_by'=>auth()->user()->id
	// 			]);
	// 		}
	// 		return $branch->id ;
	// }
	// public function sendToCollection(Company $company,Request $request)
	// {
	// 	$moneyReceivedIds = $request->get('cheques') ;
	// 	$moneyReceivedIds = is_array($moneyReceivedIds) ? $moneyReceivedIds :  explode(',',$moneyReceivedIds);
	// 	$data = $request->only(['deposit_date','drawl_bank_id','account_type','account_number','account_balance','clearance_days']);
		
	// 	$data['status'] = Cheque::UNDER_COLLECTION;
	// 	foreach($moneyReceivedIds as $moneyReceivedId){
	// 		$moneyReceived = MoneyReceived::find($moneyReceivedId) ;
	// 		$data['expected_collection_date'] = $moneyReceived->cheque->calculateChequeExpectedCollectionDate($data['deposit_date'],$data['clearance_days']);
	// 		$moneyReceived->cheque->update($data);
	// 	}
	// 	if($request->ajax()){
	// 		return response()->json([
	// 			'status'=>true ,
	// 			'msg'=>__('Good'),
	// 			'pageLink'=>route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_UNDER_COLLECTION])
	// 		]);	
	// 	}
	// 	return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_UNDER_COLLECTION]);
		
	// }
	/**
	 * * تحديد ان الشيك دا تم بالفعل صرفة من البنك ونزل في حسابك
	 */
	// public function applyCollection(Company $company,Request $request,MoneyReceived $moneyReceived)
	// {
	// 	$moneyReceived->cheque->update([
	// 		'status'=>Cheque::COLLECTED,
	// 		'collection_fees'=>$request->get('collection_fees'),
	// 		'actual_collection_date'=>$request->get('actual_collection_date') 
	// 	]);
	// 	return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_COLLECTED])->with('success',__('Cheque Is Returned To Safe'));
	// }
	
	// public function sendToSafe(Company $company,Request $request,MoneyReceived $moneyReceived)
	// {
	// 	$moneyReceived->cheque->update([
	// 		'status'=>Cheque::IN_SAFE,
	// 		'deposit_date'=>null ,
	// 		'drawl_bank_id'=>null ,
	// 		'account_type'=>null ,
	// 		'account_number'=>null ,
	// 		'account_balance'=>null ,
	// 		'expected_collection_date'=>null ,
	// 		'clearance_days'=>null
	// 	]);
	// 	return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE])->with('success',__('Cheque Is Returned To Safe'));
	// }
	// public function sendToSafeAsRejected(Company $company,Request $request,MoneyReceived $moneyReceived)
	// {
		
	// 	$moneyReceived->cheque->update([
	// 		'status'=>Cheque::REJECTED,
	// 		'deposit_date'=>null ,
	// 		'drawl_bank_id'=>null ,
	// 		'account_type'=>null ,
	// 		'account_number'=>null ,
	// 		'account_balance'=>null ,
	// 		'expected_collection_date'=>null ,
	// 		'clearance_days'=>null
	// 	]);
	// 	return redirect()->route('view.money.receive',['company'=>$company->id,'active'=>MoneyReceived::CHEQUE_REJECTED])->with('success',__('Cheque Is Returned To Safe'));
		
	// }

	// public function getAccountNumbersForAccountType(Company $company ,  Request $request ,  string $accountType,?string $selectedCurrency=null , ?int $financialInstitutionId = 0){
	// 	$accountType = AccountType::find($accountType);
	// 	$accountNumberModel =  ('\App\Models\\'.$accountType->getModelName())::getAllAccountNumberForCurrency($company->id , $selectedCurrency,$financialInstitutionId);
	// 	return response()->json([
	// 		'status'=>true , 
	// 		'data'=>$accountNumberModel
	// 	]);
	// }
}
