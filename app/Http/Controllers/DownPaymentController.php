<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreDownPaymentRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Cheque;
use App\Models\CleanOverdraft;
use App\Models\Company;
use App\Models\Contract;
use App\Models\CustomerInvoice;
use App\Models\DownPayment;
use App\Models\FinancialInstitution;
use App\Models\MoneyReceived;
use App\Models\SalesOrder;
use App\Models\User;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DownPaymentController
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
			return $collection->filter(function($downPayment) use ($value,$searchFieldName){
				$currentValue = $downPayment->{$searchFieldName} ;
				// $downPaymentRelationName cash-in-safe -> cashInSafe relation ship name
				$downPaymentRelationName = dashesToCamelCase(Request('active')) ;
				$relationRecord = $downPayment->$downPaymentRelationName ;
				/**
				 * * بمعني لو مالقناش القيمة في جدول ال
				 * * downPayment
				 * * هندور عليها في العلاقه 
				 */
				$currentValue = is_null($currentValue) && $relationRecord ? $relationRecord->{$searchFieldName}  :$currentValue ;
				if($searchFieldName == 'receiving_branch_id'){
					$currentValue = $downPayment->getCashInSafeBranchName() ;  
				}
				if($searchFieldName == 'receiving_bank_id'){
					$currentValue = $downPayment->getReceivingBankName() ;  
				}
				if($searchFieldName == 'drawee_bank_id'){
					$currentValue = $downPayment->getDraweeBankName() ;  
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
		$moneyType = $request->get('active',DownPayment::CHEQUE) ;
		$filterDates = [];
		foreach(DownPayment::getAllTypes() as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		// cash in safe
		$receivedCashesInSafeStartDate = $filterDates[DownPayment::CASH_IN_SAFE]['startDate'] ?? null ;
		$receivedCashesInSafeEndDate = $filterDates[DownPayment::CASH_IN_SAFE]['endDate'] ?? null ;
		
		// cashes in Bank
		$cashesInBankStartDate = $filterDates[DownPayment::CASH_IN_BANK]['startDate'] ?? null ;
		$cashesInBankEndDate = $filterDates[DownPayment::CASH_IN_BANK]['endDate'] ?? null ;
			// incoming transfer
			$incomingTransferStartDate = $filterDates[DownPayment::INCOMING_TRANSFER]['startDate'] ?? null ;
			$incomingTransferEndDate = $filterDates[DownPayment::INCOMING_TRANSFER]['endDate'] ?? null ;
			
		/**
		 * * cheques in safe
		 */
		$chequesInSafeStartDate = $filterDates[DownPayment::CHEQUE]['startDate'] ?? null ;
		$chequesInSafeEndDate = $filterDates[DownPayment::CHEQUE]['endDate'] ?? null ;
		
		/**
		 * * rejected cheques
		 */
		$chequesRejectedStartDate = $filterDates[DownPayment::CHEQUE_REJECTED]['startDate'] ?? null ;
		$chequesRejectedEndDate = $filterDates[DownPayment::CHEQUE_REJECTED]['endDate'] ?? null ;
		
		
		/**
		 * *  cheques under collection
		 */
		$chequesUnderCollectionStartDate = $filterDates[DownPayment::CHEQUE_UNDER_COLLECTION]['startDate'] ?? null ;
		$chequesUnderCollectionEndDate = $filterDates[DownPayment::CHEQUE_UNDER_COLLECTION]['endDate'] ?? null ;
			/**
		 * *  cheques collection
		 */
		$chequesCollectedStartDate = $filterDates[DownPayment::CHEQUE_COLLECTED]['startDate'] ?? null ;
		$chequesCollectedEndDate = $filterDates[DownPayment::CHEQUE_COLLECTED]['endDate'] ?? null ;
		
		
		
	
		$user = $request->user()->load('downPayments') ;
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
		$receivedCashesInSafe = $moneyType == DownPayment::CASH_IN_SAFE ? $this->applyFilter($request,$receivedCashesInSafe) :$receivedCashesInSafe  ;
		$receivedCashesInBanks = $moneyType == DownPayment::CASH_IN_BANK ? $this->applyFilter($request,$receivedCashesInBanks) :$receivedCashesInBanks  ;
		$receivedTransfer = $moneyType === DownPayment::INCOMING_TRANSFER ? $this->applyFilter($request,$receivedTransfer) : $receivedTransfer  ;
		
	
		$receivedChequesInSafe = $moneyType == DownPayment::CHEQUE ? $this->applyFilter($request,$receivedChequesInSafe) : $receivedChequesInSafe;
		
		
		$receivedRejectedChequesInSafe = $moneyType == DownPayment::CHEQUE_REJECTED ? $this->applyFilter($request,$receivedRejectedChequesInSafe) : $receivedRejectedChequesInSafe;
		
		$receivedChequesUnderCollection=  $moneyType == DownPayment::CHEQUE_UNDER_COLLECTION ? $this->applyFilter($request,$receivedChequesUnderCollection) : $receivedChequesUnderCollection ;
		
		$collectedCheques=  $moneyType == DownPayment::CHEQUE_COLLECTED ? $this->applyFilter($request,$collectedCheques) : $collectedCheques ;
		
		
		$selectedBanks = DownPayment::getDrawlBanksForCurrentCompany($company->id) ;
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
        return view('reports.down_payments.index', [
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
        return view('reports.downPayment.index', compact('financialInstitutionBanks','accountTypes'));
    }
	
	public function create(Company $company,$singleModel = null)
	{
		$banks = Bank::pluck('view_name','id');
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$selectedBanks = DownPayment::getDrawlBanksForCurrentCompany($company->id) ;
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$customers =  $singleModel ?  CustomerInvoice::where('id',$singleModel)->pluck('customer_name','customer_id') :CustomerInvoice::where('company_id',$company->id)->pluck('customer_name','customer_id')->unique()->toArray(); 
		$invoiceNumber = $singleModel ? CustomerInvoice::where('id',$singleModel)->first()->getInvoiceNumber():null;
		$contract = Contract::where('company_id',$company->id)->get();
        return view('reports.down_payments.form',[
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'customers'=>$customers ,
			'selectedBranches'=>$selectedBranches,
			'selectedBanks'=>$selectedBanks,
			'singleModel'=>$singleModel,
			'invoiceNumber'=>$invoiceNumber,
			'banks'=>$banks,
			'accountTypes'=>$accountTypes,
			'contracts'=>$contract
		]);
    }
	
	public function result(Company $company , Request $request){
		
		return view('reports.down_payments.form',[
		]);
	}
	
	// protected function formatSalesOrders(array $formattedSalesOrders,int $inEditMode){
	// 	$result = [];
	// 	foreach($formattedSalesOrders as $index=>$salesOrderArr){
	// 		$result[$index]['invoice_number'] = $salesOrderArr['invoice_number'];
	// 		$result[$index]['amount'] = $salesOrderArr['amount'];
	// 		$result[$index]['received_amount'] = $inEditMode ? $salesOrderArr['amount'] : 0;
	// 	}
	// 	return $result;
	// }
	
	public function store(Company $company , StoreDownPaymentRequest $request){
		$moneyType = $request->get('type');
		$customerId = $request->get('customer_id');
		$contractId = $request->get('contract_id');
		// $customerInvoice = CustomerInvoice::find($customerInvoiceId);
		// $customer = $customerInvoice->customer ;
		// $customerName = $customerInvoice->getCustomerName();
		$receivedBankName = $request->get('receiving_branch_id') ;
		$data = $request->only(['type','receiving_date','currency']);
		$data['customer_id'] = $customerId;
		$data['user_id'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		
		$relationData = [];
		$relationName = null ;
		$receivedAmount = 0 ;
		$exchangeRate = $request->input('exchange_rate.'.$moneyType,1) ;
		$receivedAmount = $request->input('received_amount.'.$moneyType ,0) ;
		if($moneyType == DownPayment::CASH_IN_SAFE){
			$relationData = $request->only(['receipt_number']) ;
			$relationData['receiving_branch_id'] = $this->generateBranchId($receivedBankName,$company->id) ;
			$relationName = 'cashInSafe';
		}
		elseif($moneyType ==DownPayment::INCOMING_TRANSFER ){
			$relationName = 'incomingTransfer';
			$relationData = [
				'receiving_bank_id'=>$request->input('receiving_bank_id.'.DownPayment::INCOMING_TRANSFER),
				'account_number'=>$request->input('account_number.'.DownPayment::INCOMING_TRANSFER),
				'account_type'=>$request->input('account_type.'.DownPayment::INCOMING_TRANSFER)
			];
		}
		elseif($moneyType ==DownPayment::CASH_IN_BANK ){
			$relationName = 'cashInBank';
			$relationData = [
				'receiving_bank_id'=>$request->input('receiving_bank_id.'.DownPayment::CASH_IN_BANK),
				'account_number'=>$request->input('account_number.'.DownPayment::CASH_IN_BANK),
				'account_type'=>$request->input('account_type.'.DownPayment::CASH_IN_BANK)
			];
		}
		elseif($moneyType ==DownPayment::CHEQUE ){
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
		 * @var DownPayment $downPayment ;
		 */
		$downPayment = DownPayment::create($data);
		
		$accountType = AccountType::find($request->input('account_type.'.$moneyType));
		
		if($accountType && $accountType->getSlug() == AccountType::CLEAN_OVERDRAFT){
			$cleanOverdraft  = CleanOverdraft::findByAccountNumber($request->input('account_number.'.$moneyType));
			$downPayment->storeCleanOverdraftBankStatement($moneyType,$cleanOverdraft,$data['receiving_date'],$receivedAmount);
		}
		$relationData['company_id'] = $company->id ;  
		$downPayment->$relationName()->create($relationData);
		foreach($request->get('sales_orders_amounts',[]) as $salesOrderReceivedAmountArr)
		{
			if(isset($salesOrderReceivedAmountArr['received_amount'])&&$salesOrderReceivedAmountArr['received_amount'] > 0){
				$salesOrderReceivedAmountArr['company_id'] = $company->id ;
				$downPayment->settlements()->create(array_merge(
					$salesOrderReceivedAmountArr ,
					[
						'contract_id'=>$contractId,
						'customer_id'=>$customerId
					]
				));
			}
		}

		$activeTab = $moneyType;
		return redirect()->route('view.down.payment',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}
	protected function getActiveTab(string $moneyType)
	{
		return $moneyType ;

	}
	public function edit(Company $company , Request $request , downPayment $downPayment ,$singleModel = null){
		$banks = Bank::pluck('view_name','id');
		$selectedBanks = DownPayment::getDrawlBanksForCurrentCompany($company->id) ;
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$customerInvoices = CustomerInvoice::where('company_id',$company->id)->pluck('customer_name','id')->unique()->toArray(); 
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$selectedBanks = DownPayment::getDrawlBanksForCurrentCompany($company->id) ;
		if($downPayment->isChequeUnderCollection()){
			return view('reports.downPayment.edit-cheque-under-collection',[
				'banks'=>$banks,
				'customerInvoices'=>$customerInvoices ,
				'selectedBranches'=>$selectedBranches,
				'selectedBanks'=>$selectedBanks,
				'model'=>$downPayment,
				'singleModel'=>$singleModel,
				'accountTypes'=>$accountTypes,
				'financialInstitutionBanks'=>$financialInstitutionBanks
			]); 
		}
        return view('reports.downPayment.form',[
			'banks'=>$banks,
			'customerInvoices'=>$customerInvoices ,
			'selectedBranches'=>$selectedBranches,
			'accountTypes'=>$accountTypes,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'selectedBanks'=>$selectedBanks,
			'model'=>$downPayment,
			'singleModel'=>$singleModel
		]);
		
	}
	
	public function update(Company $company , StoreDownPaymentRequest $request , downPayment $downPayment){
		$oldType = $downPayment->getType();
		$newType = $request->get('type');
		$oldTypeRelationName = dashesToCamelCase($oldType);
		$downPayment->$oldTypeRelationName ? $downPayment->$oldTypeRelationName->delete() : null;
		$downPayment->delete();
		$this->store($company,$request);
		 $activeTab = $newType;
		return redirect()->route('view.down.payment',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Down Payment Has Been Updated Successfully'));
	}
	
	public function destroy(Company $company , DownPayment $downPayment)
	{
		$downPayment->settlements->each(function($settlement){
			$settlement->delete();
		});
		$activeTab = $downPayment->getType();
		$downPayment->delete();
		return redirect()->route('view.down.payment',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Down Payment Has Been Updated Successfully'));
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
		$downPaymentIds = $request->get('cheques') ;
		$downPaymentIds = is_array($downPaymentIds) ? $downPaymentIds :  explode(',',$downPaymentIds);
		$data = $request->only(['deposit_date','drawl_bank_id','account_type','account_number','account_balance','clearance_days']);
		$data['status'] = Cheque::UNDER_COLLECTION;
		foreach($downPaymentIds as $downPaymentId){
			$downPayment = DownPayment::find($downPaymentId) ;
			$data['expected_collection_date'] = $downPayment->cheque->calculateChequeExpectedCollectionDate($data['deposit_date'],$data['clearance_days']);
			
			
			
			$downPayment->cheque->update($data);
		}
		if($request->ajax()){
			return response()->json([
				'status'=>true ,
				'msg'=>__('Good'),
				'pageLink'=>route('view.down.payment',['company'=>$company->id,'active'=>DownPayment::CHEQUE_UNDER_COLLECTION])
			]);	
		}
		return redirect()->route('view.down.payment',['company'=>$company->id,'active'=>DownPayment::CHEQUE_UNDER_COLLECTION]);
		
	}
	/**
	 * * تحديد ان الشيك دا تم بالفعل صرفة من البنك ونزل في حسابك
	 */
	public function applyCollection(Company $company,Request $request,DownPayment $downPayment)
	{
		$downPayment->cheque->update([
			'status'=>Cheque::COLLECTED,
			'collection_fees'=>$request->get('collection_fees'),
			'actual_collection_date'=>$request->get('actual_collection_date') 
		]);
		$accountType = AccountType::find($downPayment->cheque->account_type) ;
		$receivedAmount = $downPayment->getReceivedAmount();
		$receivingDate = $downPayment->getReceivingDate();
		$moneyType = DownPayment::CHEQUE;
		/**
		 * @var AccountType $accountType ;
		 */
		if($accountType && $accountType->getSlug() == AccountType::CLEAN_OVERDRAFT){
			$cleanOverdraft  = CleanOverdraft::findByAccountNumber($downPayment->cheque->account_number);
			$downPayment->storeCleanOverdraftBankStatement($moneyType,$cleanOverdraft,$receivingDate,$receivedAmount);
		}
		
		return redirect()->route('view.down.payment',['company'=>$company->id,'active'=>DownPayment::CHEQUE_COLLECTED])->with('success',__('Cheque Is Returned To Safe'));
	}
	
	public function sendToSafe(Company $company,Request $request,DownPayment $downPayment)
	{
		$downPayment->cheque->update([
			'status'=>Cheque::IN_SAFE,
			'deposit_date'=>null ,
			'drawl_bank_id'=>null ,
			'account_type'=>null ,
			'account_number'=>null ,
			'account_balance'=>null ,
			'expected_collection_date'=>null ,
			'clearance_days'=>null
		]);
		return redirect()->route('view.down.payment',['company'=>$company->id,'active'=>DownPayment::CHEQUE])->with('success',__('Cheque Is Returned To Safe'));
	}
	public function sendToSafeAsRejected(Company $company,Request $request,DownPayment $downPayment)
	{
		
		$downPayment->cheque->update([
			'status'=>Cheque::REJECTED,
			'deposit_date'=>null ,
			'drawl_bank_id'=>null ,
			'account_type'=>null ,
			'account_number'=>null ,
			'account_balance'=>null ,
			'expected_collection_date'=>null ,
			'clearance_days'=>null
		]);
		return redirect()->route('view.down.payment',['company'=>$company->id,'active'=>DownPayment::CHEQUE_REJECTED])->with('success',__('Cheque Is Returned To Safe'));
		
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
