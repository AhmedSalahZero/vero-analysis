<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreMoneyReceivedRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Cheque;
use App\Models\CleanOverdraft;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\MoneyReceived;
use App\Models\User;
use App\Traits\GeneralFunctions;
use Arr;
use Carbon\Carbon;
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
		if($searchFieldName =='deposit_date'){
			$dateFieldName = 'deposit_date';
		}
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($moneyReceived) use ($value,$searchFieldName){
				$currentValue = $moneyReceived->{$searchFieldName} ;
				// $moneyReceivedRelationName cash-in-safe -> cashInSafe relation ship name
				$moneyReceivedRelationName = dashesToCamelCase(Request('active')) ;
				$relationRecord = $moneyReceived->$moneyReceivedRelationName ;
				/**
				 * * بمعني لو مالقناش القيمة في جدول ال
				 * * moneyReceived
				 * * هندور عليها في العلاقه 
				 */
				$currentValue = is_null($currentValue) && $relationRecord ? $relationRecord->{$searchFieldName}  :$currentValue ;
				if($searchFieldName == 'receiving_branch_id'){
					$currentValue = $moneyReceived->getCashInSafeBranchName() ;  
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
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$moneyType = $request->get('active',MoneyReceived::CHEQUE) ;
		$filterDates = [];
		foreach(MoneyReceived::getAllTypes() as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		// cash in safe
		$receivedCashesInSafeStartDate = $filterDates[MoneyReceived::CASH_IN_SAFE]['startDate'] ?? null ;
		$receivedCashesInSafeEndDate = $filterDates[MoneyReceived::CASH_IN_SAFE]['endDate'] ?? null ;
		
		// cashes in Bank
		$cashesInBankStartDate = $filterDates[MoneyReceived::CASH_IN_BANK]['startDate'] ?? null ;
		$cashesInBankEndDate = $filterDates[MoneyReceived::CASH_IN_BANK]['endDate'] ?? null ;
			// incoming transfer
			$incomingTransferStartDate = $filterDates[MoneyReceived::INCOMING_TRANSFER]['startDate'] ?? null ;
			$incomingTransferEndDate = $filterDates[MoneyReceived::INCOMING_TRANSFER]['endDate'] ?? null ;
			
		/**
		 * * cheques in safe
		 */
		$chequesInSafeStartDate = $filterDates[MoneyReceived::CHEQUE]['startDate'] ?? null ;
		$chequesInSafeEndDate = $filterDates[MoneyReceived::CHEQUE]['endDate'] ?? null ;
		
		/**
		 * * rejected cheques
		 */
		$chequesRejectedStartDate = $filterDates[MoneyReceived::CHEQUE_REJECTED]['startDate'] ?? null ;
		$chequesRejectedEndDate = $filterDates[MoneyReceived::CHEQUE_REJECTED]['endDate'] ?? null ;
		
		
		/**
		 * *  cheques under collection
		 */
		$chequesUnderCollectionStartDate = $filterDates[MoneyReceived::CHEQUE_UNDER_COLLECTION]['startDate'] ?? null ;
		$chequesUnderCollectionEndDate = $filterDates[MoneyReceived::CHEQUE_UNDER_COLLECTION]['endDate'] ?? null ;
			/**
		 * *  cheques collection
		 */
		$chequesCollectedStartDate = $filterDates[MoneyReceived::CHEQUE_COLLECTED]['startDate'] ?? null ;
		$chequesCollectedEndDate = $filterDates[MoneyReceived::CHEQUE_COLLECTED]['endDate'] ?? null ;
		
		
		
	
		$user = $request->user()->load('moneyReceived') ;
		/** 
		* @var User $user
		*/
		$receivedCashesInSafe = $user->getReceivedCashesInSafe($receivedCashesInSafeStartDate ,$receivedCashesInSafeEndDate ) ;
		$receivedCashesInBanks = $user->getReceivedCashesInBank($cashesInBankStartDate,$cashesInBankEndDate) ;
		$receivedTransfer = $user->getReceivedTransfer($incomingTransferStartDate,$incomingTransferEndDate) ;
		$receivedChequesInSafe = $user->getReceivedChequesInSafe($chequesInSafeStartDate,$chequesInSafeEndDate);
		$receivedRejectedChequesInSafe = $user->getReceivedRejectedChequesInSafe($chequesRejectedStartDate,$chequesRejectedEndDate);
		$receivedChequesUnderCollection=  $user->getReceivedChequesUnderCollection($chequesUnderCollectionStartDate,$chequesUnderCollectionEndDate);
		$collectedCheques=  $user->getCollectedCheques($chequesCollectedStartDate,$chequesCollectedEndDate);
		
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$receivedCashesInSafe = $moneyType == MoneyReceived::CASH_IN_SAFE ? $this->applyFilter($request,$receivedCashesInSafe) :$receivedCashesInSafe  ;
		$receivedCashesInBanks = $moneyType == MoneyReceived::CASH_IN_BANK ? $this->applyFilter($request,$receivedCashesInBanks) :$receivedCashesInBanks  ;
		$receivedTransfer = $moneyType === MoneyReceived::INCOMING_TRANSFER ? $this->applyFilter($request,$receivedTransfer) : $receivedTransfer  ;
		
	
		$receivedChequesInSafe = $moneyType == MoneyReceived::CHEQUE ? $this->applyFilter($request,$receivedChequesInSafe) : $receivedChequesInSafe;
		
		
		$receivedRejectedChequesInSafe = $moneyType == MoneyReceived::CHEQUE_REJECTED ? $this->applyFilter($request,$receivedRejectedChequesInSafe) : $receivedRejectedChequesInSafe;
		
		$receivedChequesUnderCollection=  $moneyType == MoneyReceived::CHEQUE_UNDER_COLLECTION ? $this->applyFilter($request,$receivedChequesUnderCollection) : $receivedChequesUnderCollection ;
		
		$collectedCheques=  $moneyType == MoneyReceived::CHEQUE_COLLECTED ? $this->applyFilter($request,$collectedCheques) : $collectedCheques ;
		
		
		$selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
		$chequesReceivedTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'cheque_number'=>__('Cheque Number'),
			'currency'=>__('Currency'),
			'drawee_bank_id'=>__('Drawee Bank'),
			'due_date'=>__('Due Date'),
			'cheque_status'=>__('Status')
		];
		
		
		$chequesRejectedTableSearchFields = [
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
			'deposit_date'=>__('Deposit Date'),
			'drawl_bank_id'=>__('Drawl Bank'),
			// 'account_type'=>__('Account Number'),
			'clearance_days'=>'Clearance Days'
		];
		
		$collectedChequesTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'cheque_number'=>__('Cheque Number'),
			'received_amount'=>__('Cheque Amount'),
			'deposit_date'=>__('Deposit Date'),
			'drawl_bank_id'=>__('Drawl Bank'),
			'clearance_days'=>'Clearance Days'
		];
		
		$incomingTransferTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'receiving_bank_id'=>__('Receiving Bank'),
			'received_amount'=>__('Transfer Amount'),
			'currency'=>__('Currency'),
			'account_number'=>__('Account Number')
		];
		
		$cashInBankTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'receiving_bank_id'=>__('Receiving Bank'),
			'received_amount'=>__('Deposit Amount'),
			'currency'=>__('Currency'),
			'account_number'=>__('Account Number')
		];
		
		$cashInSafeReceivedTableSearchFields = [
			'customer_name'=>__('Customer Name'),
			'receiving_date'=>__('Receiving Date'),
			'receiving_branch_id'=>__('Branch'),
			'received_amount'=>__('Received Amount'),
			'currency'=>__('Currency'),
			'receipt_number'=>__('Receipt Number')
		];
		
		
		
		
		$banks = Bank::pluck('view_name','id');
		$accountTypes = AccountType::onlyCashAccounts()->get();		
        return view('reports.moneyReceived.index', [
			'company'=>$company ,
			'selectedBanks'=>$selectedBanks,
			'receivedChequesInSafe'=>$receivedChequesInSafe,
			'receivedCashesInSafe'=>$receivedCashesInSafe,
			'chequesReceivedTableSearchFields'=>$chequesReceivedTableSearchFields,
			'receivedTransfer'=>$receivedTransfer,
			'receivedCashesInBanks'=>$receivedCashesInBanks,
			'banks'=>$banks,
			'receivedChequesUnderCollection'=>$receivedChequesUnderCollection,
			'chequesUnderCollectionTableSearchFields'=>$chequesUnderCollectionTableSearchFields ,
			'cashInSafeReceivedTableSearchFields'=>$cashInSafeReceivedTableSearchFields,
			'incomingTransferTableSearchFields'=>$incomingTransferTableSearchFields,
			'cashInBankTableSearchFields'=>$cashInBankTableSearchFields,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'accountTypes'=>$accountTypes,
			'chequesRejectedTableSearchFields'=>$chequesRejectedTableSearchFields,
			'receivedRejectedChequesInSafe'=>$receivedRejectedChequesInSafe,
			'collectedCheques'=>$collectedCheques,
			'collectedChequesTableSearchFields'=>$collectedChequesTableSearchFields,
			'filterDates'=>$filterDates,
			
		]);
        return view('reports.moneyReceived.index', compact('financialInstitutionBanks','accountTypes'));
    }
	
	public function create(Company $company,$singleModel = null)
	{
		$banks = Bank::pluck('view_name','id');
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$customerInvoices =  $singleModel ?  CustomerInvoice::where('id',$singleModel)->pluck('customer_name','id') :CustomerInvoice::where('company_id',$company->id)->pluck('customer_name','id')->unique()->toArray(); 
		$invoiceNumber = $singleModel ? CustomerInvoice::where('id',$singleModel)->first()->getInvoiceNumber():null;
        return view('reports.moneyReceived.form',[
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'customerInvoices'=>$customerInvoices ,
			'selectedBranches'=>$selectedBranches,
			'selectedBanks'=>$selectedBanks,
			'singleModel'=>$singleModel,
			'invoiceNumber'=>$invoiceNumber,
			'banks'=>$banks,
			'accountTypes'=>$accountTypes
		]);
    }
	
	public function result(Company $company , Request $request){
		
		return view('reports.moneyReceived.form',[
		]);
	}
	public function getInvoiceNumber(Company $company ,  Request $request , int $customerInvoiceId,?string $selectedCurrency=null)
	{
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
	
	public function store(Company $company , StoreMoneyReceivedRequest $request){
		$moneyType = $request->get('type');
		$customerInvoiceId = $request->get('customer_id');
		$customerInvoice = CustomerInvoice::find($customerInvoiceId);
		$customer = $customerInvoice->customer ;
		$customerName = $customerInvoice->getCustomerName();
		$receivedBankName = $request->get('receiving_branch_id') ;
		$data = $request->only(['type','receiving_date','currency']);
		$data['customer_name'] = $customerName;
		$data['user_id'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		
		$relationData = [];
		$relationName = null ;
		$receivedAmount = 0 ;
		$exchangeRate = $request->input('exchange_rate.'.$moneyType,1) ;
		$receivedAmount = $request->input('received_amount.'.$moneyType ,0) ;
		if($moneyType == MoneyReceived::CASH_IN_SAFE){
			$relationData = $request->only(['receipt_number']) ;
			$relationData['receiving_branch_id'] = $this->generateBranchId($receivedBankName,$company->id) ;
			$relationName = 'cashInSafe';
		}
		elseif($moneyType ==MoneyReceived::INCOMING_TRANSFER ){
			$relationName = 'incomingTransfer';
			$relationData = [
				'receiving_bank_id'=>$request->input('receiving_bank_id.'.MoneyReceived::INCOMING_TRANSFER),
				'account_number'=>$request->input('account_number.'.MoneyReceived::INCOMING_TRANSFER),
				'account_type'=>$request->input('account_type.'.MoneyReceived::INCOMING_TRANSFER)
			];
		}
		elseif($moneyType ==MoneyReceived::CASH_IN_BANK ){
			$relationName = 'cashInBank';
			$relationData = [
				'receiving_bank_id'=>$request->input('receiving_bank_id.'.MoneyReceived::CASH_IN_BANK),
				'account_number'=>$request->input('account_number.'.MoneyReceived::CASH_IN_BANK),
				'account_type'=>$request->input('account_type.'.MoneyReceived::CASH_IN_BANK)
			];
		}
		elseif($moneyType ==MoneyReceived::CHEQUE ){
			$relationName = 'cheque';
			$relationData = [
				'due_date'=>$request->input('due_date'),
				'cheque_number'=>$request->input('cheque_number'),
				'drawee_bank_id'=>$request->input('drawee_bank_id')
			];
		}
		$data['received_amount'] = $receivedAmount ;
		$data['exchange_rate'] =$exchangeRate ;
		/**
		 * @var MoneyReceived $moneyReceived ;
		 */
		$moneyReceived = MoneyReceived::create($data);
		
		$accountType = AccountType::find($request->input('account_type.'.$moneyType));
		
		if($accountType && $accountType->getSlug() == AccountType::CLEAN_OVERDRAFT){
			$cleanOverdraft  = CleanOverdraft::findByAccountNumber($request->input('account_number.'.$moneyType));
			$moneyReceived->storeCleanOverdraftBankStatement($moneyType,$cleanOverdraft,$data['receiving_date'],$receivedAmount);
		}
		$relationData['company_id'] = $company->id ;  
		$moneyReceived->$relationName()->create($relationData);
		if($request->get('unapplied_amount') > 0 ){
			$moneyReceived->unappliedAmounts()->create([
				'amount'=>$request->get('unapplied_amount'),
				'partner_id'=>$customer->id,
				'settlement_date'=>$request->get('receiving_date'),
				'company_id'=>$company->id,
				'net_balance_until_date'=>0
			]);
		}
		$totalWithholdAmount= 0 ;
		foreach($request->get('settlements',[]) as $settlementArr)
		{
			if(isset($settlementArr['settlement_amount'])&&$settlementArr['settlement_amount'] > 0){
				$settlementArr['company_id'] = $company->id ;
				$settlementArr['customer_name'] = $customerName ;
				$totalWithholdAmount += $settlementArr['withhold_amount']  ;
				$moneyReceived->settlements()->create($settlementArr);
			}
		}
		
		$moneyReceived->update([
			'total_withhold_amount'=>$totalWithholdAmount
		]);
		/**
		 * @var CustomerInvoice $customerInvoice
		 */

		$activeTab = $moneyType;
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
		$accountType = AccountType::find($moneyReceived->cheque->account_type) ;
		$receivedAmount = $moneyReceived->getReceivedAmount();
		$receivingDate = $moneyReceived->getReceivingDate();
		$moneyType = MoneyReceived::CHEQUE;
		/**
		 * @var AccountType $accountType ;
		 */
		if($accountType && $accountType->getSlug() == AccountType::CLEAN_OVERDRAFT){
			$cleanOverdraft  = CleanOverdraft::findByAccountNumber($moneyReceived->cheque->account_number);
			$moneyReceived->storeCleanOverdraftBankStatement($moneyType,$cleanOverdraft,$receivingDate,$receivedAmount);
		}
		
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
