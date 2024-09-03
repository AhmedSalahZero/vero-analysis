<?php

namespace App\Models;

use App\Helpers\HHelpers;
use App\Models\OpeningBalance;
use App\Models\OutgoingTransfer;
use App\Traits\Models\HasCreditStatements;
use App\Traits\Models\IsMoney;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MoneyPayment extends Model
{
	use IsMoney ,HasCreditStatements;
	const CASH_PAYMENT  = 'cash_payment';
	const PAYABLE_CHEQUE  = 'payable_cheque';
	const OUTGOING_TRANSFER  = 'outgoing-transfer';
	
	
	public static function generateComment(self $moneyPayment,string $lang)
	{
		$supplierName = $moneyPayment->getSupplierName();
		$paidInvoiceNumbers = getKeysWithSettlementAmount(Request()->get('settlements',[]),'settlement_amount');
		
		if($moneyPayment->isPayableCheque()){
			return __('Payable Cheque To :name With Number [:number ] Paid Invoices [ :numbers ]',['name'=>$supplierName,'number'=>$moneyPayment->getPayableChequeNumber()?:Request('cheque_number'),'numbers'=>$paidInvoiceNumbers],$lang) ;
		}
		if($moneyPayment->isCashPayment()){
			return __('Cash Payment To :name Paid Invoices [ :numbers ]',['name'=>$supplierName,'numbers'=>$paidInvoiceNumbers],$lang) ;
		}
		if($moneyPayment->isOutgoingTransfer()){
			return __('Outgoing Transfer To :name Paid Invoices [ :numbers ]',['name'=>$supplierName,'numbers'=>$paidInvoiceNumbers],$lang) ;
		}
	}
	protected static function booted()
	{
		self::creating(function (self $moneyPayment): void {
			$moneyPayment->comment_en = self::generateComment($moneyPayment,'en');
			$moneyPayment->comment_ar = self::generateComment($moneyPayment,'ar');
		});
		
	}
	
	
	public static function getAllTypes()
	{
		return [
			self::CASH_PAYMENT,
			self::PAYABLE_CHEQUE,
			self::OUTGOING_TRANSFER,
		];
	}
	
    protected $guarded = ['id'];
    protected $table = 'money_payments';
    
	
    public function isCashPayment()
    {
        return $this->getType() ==self::CASH_PAYMENT;
    }
	public function isPayableCheque()
    {
        return $this->getType() ==self::PAYABLE_CHEQUE;
    }
  
    public function isOutgoingTransfer()
    {
        return $this->getType() ==self::OUTGOING_TRANSFER;
    }
    public function getSupplierName()
    {
        return $this->supplier_name;
    }
	public function supplier()
	{
		return $this->belongsTo(Partner::class,'supplier_name','name')->where('is_supplier',1)->where('company_id',getCurrentCompanyId());
	}
	public function getSupplierId()
	{
		return $this->supplier ? $this->supplier->id : 0 ;
	}
	public function getName()
	{
		return $this->getSupplierName();
	}
    public function getDeliveryDate()
    {
        return $this->delivery_date;
    }
    public function getCashPaymentBranchId()
    {
		$cashPayment = $this->cashPayment ;
        return  $cashPayment ? $cashPayment->getDeliveryBranchId() :0;
    }
    public function getPaidAmount()
    {
        return  $this->paid_amount?:0 ;
    }
	public function getAmount()
	{
		return $this->getPaidAmount();
	}
	
	public function getPayableChequeDueDate(){
		return $this->payableCheque ? $this->payableCheque->getDueDate(): null;
	}
	public function getOutgoingTransferDueDate(){
		return $this->outgoingTransfer ? $this->outgoingTransfer->actualPaymentDate(): null;
	}
	public function getPayableChequeNumber()
	{
		return $this->payableCheque ? $this->payableCheque->getChequeNumber():null;
	}
	public function getPaidAmountFormatted()
    {
        return number_format($this->getPaidAmount()) ;
    }
   
	public function getCurrency()
	{
		return $this->currency;
	}
	
	public function getCurrencyFormatted()
	{
		return strtoupper($this->currency);
	}

	public function getPaymentCurrency()
	{
		return $this->payment_currency;
	}
	
	public function getPaymentCurrencyFormatted()
	{
		return strtoupper($this->getPaymentCurrency());
	}
	
	public function getExchangeRate()
	{
		
		return $this->exchange_rate?:1;
	}
	public function getPaymentBankName()
	{
		return '-';
	}


    public function getCashPaymentReceiptNumber()
    {
		$cashPayment = $this->cashPayment;
        return $cashPayment ? $cashPayment->getReceiptNumber() :  null ;
    }

  
	public function getNumber()
	{
		if($this->isPayableCheque()){
			return $this->payableCheque->getChequeNumber();
		}
		if($this->isCashPayment()){
			return $this->getCashPaymentReceiptNumber();
		}
		if($this->isOutgoingTransfer()){
			return $this->getOutgoingTransferAccountNumber();
		}
		
	}
	

	
	public function getBankName()
	{
		if($this->isCashPayment()){
			return $this->getCashPaymentBranchName();
		}
		if($this->isPayableCheque()){
			return $this->payableCheque->getDeliveryBankName();
		}
		if($this->isOutgoingTransfer()){
			return $this->getOutgoingTransferDeliveryBankName(app()->getLocale());
		}
		
	}
	
	public function outgoingTransfer()
	{
		return $this->hasOne(OutgoingTransfer::class,'money_payment_id','id');
	}

    public function getOutgoingTransferDeliveryBankId()
    {
		$outgoingTransfer = $this->outgoingTransfer ;
        return $outgoingTransfer ? $outgoingTransfer->getDeliveryBankId() : 0 ;
    }
	public function outgoingTransferDeliveryBank():?FinancialInstitution
	{
		/**
		 * @var OutgoingTransfer $outgoingTransfer 
		 */
		$outgoingTransfer = $this->outgoingTransfer ;
		
		return $outgoingTransfer ? $outgoingTransfer->deliveryBank() : null ;
	}
	public function getOutgoingTransferDeliveryBankName()
	{
		/**
		 * @var OutgoingTransfer $outgoingTransfer 
		 */
		$outgoingTransfer = $this->outgoingTransfer ;
        return $outgoingTransfer ? $outgoingTransfer->getDeliveryBankName() : __('N/A') ;
	}
	
	
	/**
	 * * For Supplier Payment Only
	 */
    public function settlements()
    {
        return $this->hasMany(PaymentSettlement::class, 'money_payment_id', 'id');
    }
	/**
	 * * For Down Payment Only
	 */
    public function downPaymentSettlements()
    {
        return $this->hasMany(DownPaymentMoneyPaymentSettlement::class, 'money_payment_id', 'id');
    }
    public function supplierInvoice()
    {
        return $this->belongsTo(SupplierInvoice::class, 'supplier_name', 'supplier_name');
    }

	public function getSettlementsForCustomerName( string $supplierName):Collection
    {
        return $this->settlements->where('supplier_name', $supplierName) ;
    }
    public function getSettlementsForInvoiceNumber($invoiceNumber, string $supplierName):Collection
    {
        return $this->settlements->where('invoice_number', $invoiceNumber)->where('supplier_name', $supplierName) ;
    }
	public function getSettlementsForInvoiceNumberAmount($invoiceNumber, string $supplierName):float{
		return $this->getSettlementsForInvoiceNumber($invoiceNumber,$supplierName)->sum('settlement_amount');
	}
	public function getWithholdForInvoiceNumberAmount($invoiceNumber, string $supplierName):float{
		return $this->getSettlementsForInvoiceNumber($invoiceNumber,$supplierName)->sum('withhold_amount');
	}
    public function getDeliveryDateFormatted()
    {
        $date = $this->getDeliveryDate() ;
        if($date) {
            return Carbon::make($date)->format('d-m-Y');
        }
    }
	public function setDeliveryDateAttribute($value)
	{
		if(is_object($value)){
			return $value ;
		}
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['delivery_date'] = $value;
			return  ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$this->attributes['delivery_date'] = $year.'-'.$month.'-'.$day;
		
	}
	
	public static function getUniqueBanks( $banks):array{
		$uniqueBanksIds = [];
		foreach($banks as $bankId){
				$uniqueBanksIds[$bankId] = $bankId;
		}
		return $uniqueBanksIds; 
	}
	
	public function cashPaymentDeliveryBranch()
	{
		/**
		 * @var CashPayment $cashPayment
		 */
		$cashPayment = $this->cashPayment;
		return $cashPayment ? $cashPayment->deliveryBranch : null ;
	}
	public function getCashPaymentBranchName()
	{
		$cashPayment = $this->cashPayment;

		return $cashPayment ? $cashPayment->getDeliveryBranchName() : null ;
	}
	
	public function getPayableChequeDeliveryDate()
	{
		$payable = $this->payableCheque;
		return $payable ? $payable->getDeliveryDate() : null;
	}
	public function getPayableChequeDeliveryDateFormattedForDatePicker()
	{
		$date = $this->getPayableChequeDeliveryDate();
		return $date ? Carbon::make($date)->format('m/d/Y') : null;
	}
	public function getChequeDeliveryDateFormatted()
	{
		$date = $this->getPayableChequeDeliveryDate();
		return $date ? Carbon::make($date)->format('d-m-Y') : null;
	}

	
	public function getPayableChequePaymentBankId()
	{
		$payableCheque = $this->payableCheque ;
		return $payableCheque ? $payableCheque->getDeliveryBankId() : null ;
	}
	public function getPayableChequeAccountType()
	{
		$payableCheque = $this->payableCheque ;
		return $payableCheque ? $payableCheque->getAccountType() : null ;
	}
	
	// public function getPayableChequeAccountNumber()
	// {
	// 	$payableCheque = $this->payableCheque ;
	// 	return $payableCheque ? $payableCheque->getAccountNumber() : null ;
	// }
	
	public function cashPayment()
	{
		return $this->hasOne(CashPayment::class,'money_payment_id','id');
	}
	
	public function payableCheque()
	{
		return $this->hasOne(PayableCheque::class,'money_payment_id','id');
	}

	public function getTotalWithholdAmount():float 
	{
		return $this->total_withhold_amount ?: 0 ;
	}
	public function getOutgoingTransferAccountTypeId(){
		$outgoingTransfer = $this->outgoingTransfer;
		return $outgoingTransfer ? $outgoingTransfer->getAccountTypeId() : 0 ;
	}
	public function getOutgoingTransferAccountTypeName(){
		$outgoingTransfer = $this->outgoingTransfer;
		return $outgoingTransfer ? $outgoingTransfer->getAccountTypeName() : 0 ;
	}
	public function getOutgoingTransferAccountNumber(){
		$outgoingTransfer = $this->outgoingTransfer;
		return $outgoingTransfer ? $outgoingTransfer->getAccountNumber() : 0 ;
	}
	
	public function getPayableChequeAccountTypeId(){
		$payableCheque = $this->payableCheque;

		return $payableCheque ? $payableCheque->getAccountTypeId() : 0 ;
	}
	public function getPayableChequeAccountTypeName(){
		$payableCheque = $this->payableCheque;
		return $payableCheque ? $payableCheque->getAccountTypeName() : 0 ;
	}
	public function getPayableChequeAccountNumber(){
		$payableCheque = $this->payableCheque;
		return $payableCheque ? $payableCheque->getAccountNumber() : 0 ;
	}
	
	
	
	public function unappliedAmounts()
	{
		return $this->hasMany(UnappliedAmount::class ,'model_id','id')->where('model_type',HHelpers::getClassNameWithoutNameSpace($this));	
	}
	public function cleanOverdraftCreditBankStatement()
	{
		return $this->hasOne(CleanOverdraftBankStatement::class,'money_payment_id','id');
	}
	public function fullySecuredOverdraftCreditBankStatement()
	{
		return $this->hasOne(FullySecuredOverdraftBankStatement::class,'money_payment_id','id');
	}
	public function overdraftAgainstCommercialPaperCreditBankStatement()
	{
		return $this->hasOne(OverdraftAgainstCommercialPaperBankStatement::class,'money_payment_id','id');
	}
	public function overdraftAgainstAssignmentOfContractCreditBankStatement()
	{
		return $this->hasOne(OverdraftAgainstAssignmentOfContractBankStatement::class,'money_payment_id','id');
	}
	public function cashInSafeCreditStatement()
	{
		return $this->hasOne(CashInSafeStatement::class,'money_payment_id','id');
	}
	public function currentAccountCreditBankStatement()
	{
		return $this->hasOne(CurrentAccountBankStatement::class,'money_payment_id','id');
	}
	
	public function openingBalance()
	{
		return $this->belongsTo(OpeningBalance::class,'opening_balance_id');
	}
	public function isOpenBalance()
	{
		return $this->opening_balance_id !== null ;
	}
	
	public function isDownPayment()
	{
		return $this->getMoneyType() == 'down-payment';
	}
	public function getMoneyType()
	{
		return $this->money_type; 
	}
	public function getMoneyTypeFormatted()
	{
		$moneyType = $this->getMoneyType();
		if($moneyType == 'money-payment'){
			$moneyType = 'invoice-settlement';
		}
		return camelizeWithSpace($moneyType) ;
	}
	public function getContractId()
	{
		return $this->contract_id;
	}
	public function getCurrentStatement()
	{
		if($this->cleanOverdraftCreditBankStatement){
			return $this->cleanOverdraftCreditBankStatement;
		}	
		if($this->fullySecuredOverdraftCreditBankStatement){
			return $this->fullySecuredOverdraftCreditBankStatement;
		}
		if($this->overdraftAgainstCommercialPaperCreditBankStatement){
			return $this->overdraftAgainstCommercialPaperCreditBankStatement;
		}	
		if($this->overdraftAgainstAssignmentOfContractCreditBankStatement){
			return $this->overdraftAgainstAssignmentOfContractCreditBankStatement;
		}
		if($this->cashInSafeCreditStatement){
			return $this->cashInSafeCreditStatement ;
		}
		if($this->currentAccountCreditBankStatement){
			return $this->currentAccountCreditBankStatement ;
		}
	}
	public function deleteRelations()
	{
		$oldType = $this->getType();
		$oldTypeRelationName = dashesToCamelCase($oldType);
		$this->$oldTypeRelationName ? $this->$oldTypeRelationName->delete() : null;
		$this->settlements->each(function($settlement){
			$settlement->delete();
		});
		$this->settlementAllocations()->delete();
		$this->unappliedAmounts()->delete();
		$currentStatement = $this->getCurrentStatement() ;
		if($currentStatement){
			$currentStatement->delete();
		}
	}
	/**
	 * * دا عباره عن التاريخ اللي هنستخدمة في ال
	 * * statements 
	 * * سواء بانك او كاش الخ
	 */
	public function getStatementDate()
	{
		if($this->isPayableCheque()){
			return $this->getPayableChequeDueDate();
		}
		if($this->isOutgoingTransfer()){
			return $this->getOutgoingTransferDueDate();
		}
		return $this->getDeliveryDate();
	}
	public function settlementAllocations()
	{
		return $this->hasMany(SettlementAllocation::class,'money_payment_id','id');
	}
	// public static function getSupplierPayableChequesAtDates(int $companyId , string $startDate , string $endDate,string $currency,$chequeStatus , $dateFieldName,?int $customerId = null , ? int $contractId = null , $supplierName = null) 
	// {
	// 	$mainTableName = 'payable_cheques';
	// 	$isContract = $contractId && $customerId ;
	// 	$sumColumnName = $isContract ? 'allocation_amount' : 'paid_amount'; 
	// 	$query =  DB::table($mainTableName)->where('status',$chequeStatus)
	// 	->where('currency',$currency)
	// 	->where('type',MoneyPayment::PAYABLE_CHEQUE)
	// 	->where($mainTableName.'.company_id',$companyId)
	// 	->whereBetween($dateFieldName,[$startDate,$endDate])
	// 	->join('money_payments',$mainTableName.'.money_payment_id','money_payments.id')
	// 	->when($isContract , function(Builder $builder) use ($supplierName ,$contractId,$customerId,$mainTableName ){
	// 		$builder->join('settlement_allocations','settlement_allocations.money_payment_id','=','money_payments.id')
	// 		->where('settlement_allocations.contract_id',$contractId)->where('settlement_allocations.partner_id',$customerId)
	// 		->where('supplier_name',$supplierName);
	// 	});
		
	// 	$sum = $query->sum($sumColumnName) ;
	// 	if($isContract){
	// 		return [
	// 			'sum'=>$sum ,
	// 			'invoice_number'=>$query->first() ? $query->first()->invoice_number  : null 
	// 		];
	// 	}
	// 	return $sum  ;
		
	// }
	
	// public static function getCashPaymentsAtDates(int $companyId , string $startDate , string $endDate,string $currency,?int $customerId = null , ? int $contractId = null , $supplierName = null) 
	// {
	// 	$mainTableName = 'cash_payments';
	// 	$isContract = $contractId && $customerId ;
	// 	$sumColumnName =  $isContract ? 'allocation_amount' : 'paid_amount'; 
	// 	$query =  DB::table($mainTableName)
	// 	->where('currency',$currency)
	// 	->where('type',MoneyPayment::CASH_PAYMENT)
	// 	->where('money_payments.company_id',$companyId)
	// 	->whereBetween('delivery_date',[$startDate,$endDate])
	// 	->join('money_payments',$mainTableName.'.money_payment_id','money_payments.id')
	// 	->when($isContract , function(Builder $builder) use ($supplierName ,$contractId,$customerId,$mainTableName ){
	// 		$builder->join('settlement_allocations','settlement_allocations.money_payment_id','=','money_payments.id')
	// 		->where('settlement_allocations.contract_id',$contractId)->where('settlement_allocations.partner_id',$customerId)
	// 		->where('supplier_name',$supplierName);
	// 	});
	// 	$sum = $query->sum($sumColumnName) ;
	// 	if($isContract){
	// 		return [
	// 			'sum'=>$sum ,
	// 			'invoice_number'=>$query->first() ? $query->first()->invoice_number  : null 
	// 		];
	// 	}
	// 	return $sum  ;
	// }
		
	public static function getCashOutForMoneyTypeAtDates(array &$result , array &$totalCashOutFlowArray  , string $moneyType,string $dateFieldName,string $currency , int $companyId, string $startDate , string $endDate , string $currentWeekYear , ?string $chequeStatus = null) 
	{
		$subTableName = (new self)->getTable(); // money_payments
		$keyNameForCurrentType = [
			MoneyPayment::OUTGOING_TRANSFER => __('Outgoing Transfers'),
			MoneyPayment::CASH_PAYMENT =>__('Cash Payments'),
			MoneyPayment::PAYABLE_CHEQUE => $chequeStatus == PayableCheque::PAID ? __('Paid Payable Cheques') : __('Under Payment Payable Cheques')
		][$moneyType];
		
		$mainTableName = [
			MoneyPayment::OUTGOING_TRANSFER => (new OutgoingTransfer())->getTable(),
			MoneyPayment::CASH_PAYMENT =>(new CashPayment())->getTable(),
			MoneyPayment::PAYABLE_CHEQUE => (new PayableCheque())->getTable()
		][$moneyType];
		

		$supplierNamesWithPaidAmount = DB::table($mainTableName)
						->where($subTableName.'.currency',$currency)
						->where('type',$moneyType)
						->where($subTableName.'.company_id',$companyId)
						->whereBetween($dateFieldName,[$startDate,$endDate])
						->join($subTableName,$subTableName.'.id','=','money_payment_id')
						->when($chequeStatus , function(Builder $builder) use ($chequeStatus){
							$builder->where('payable_cheques.status',$chequeStatus);
						})
						->groupBy('supplier_name')
						->selectRaw('supplier_name,sum(paid_amount) as paid_amount')->get();
		foreach($supplierNamesWithPaidAmount as $supplierNameAndPaidAmount){
			$supplierName = $supplierNameAndPaidAmount->supplier_name;
			$currentPaidAmount = $supplierNameAndPaidAmount->paid_amount ;
			$result['suppliers'][$supplierName][$keyNameForCurrentType]['weeks'][$currentWeekYear] = isset($result['suppliers'][$supplierName][$keyNameForCurrentType]['weeks'][$currentWeekYear]) ? $result['suppliers'][$supplierName][$keyNameForCurrentType]['weeks'][$currentWeekYear] + $currentPaidAmount :  $currentPaidAmount;
			$result['suppliers'][$supplierName][$keyNameForCurrentType]['total'] = isset($result['suppliers'][$supplierName][$keyNameForCurrentType]['total']) ? $result['suppliers'][$supplierName][$keyNameForCurrentType]['total']  + $currentPaidAmount : $currentPaidAmount;
			$currentTotal = $currentPaidAmount;
			$result['suppliers'][$supplierName]['total'][$currentWeekYear] = isset($result['suppliers'][$supplierName]['total'][$currentWeekYear]) ? $result['suppliers'][$supplierName]['total'][$currentWeekYear] +  $currentTotal : $currentTotal ;
			$result['suppliers'][$supplierName]['total']['total_of_total'] = isset($result['suppliers'][$supplierName]['total']['total_of_total']) ? $result['suppliers'][$supplierName]['total']['total_of_total'] + $result['suppliers'][$supplierName]['total'][$currentWeekYear] : $result['suppliers'][$supplierName]['total'][$currentWeekYear];
			$totalCashOutFlowArray[$currentWeekYear] = isset($totalCashOutFlowArray[$currentWeekYear]) ? $totalCashOutFlowArray[$currentWeekYear] +   $currentTotal : $currentTotal ;
			
		}
		// dd($supplierNames);
		// $query  =  DB::table($mainTableName)
		// ->where('currency',$currency)
		// ->where('type',MoneyPayment::OUTGOING_TRANSFER)
		// ->where('money_payments.company_id',$companyId)
		// ->whereBetween('delivery_date',[$startDate,$endDate])
		// ->join('money_payments',$mainTableName.'.money_payment_id','money_payments.id');
		// $sum = $query->sum('paid_amount') ;
		
	
	
	}
	
	// public static function getSupplierInvoicesUnderCollectionAtDates(int $companyId , string $startDate , string $endDate,string $currency,? string  $contractCode = null , $supplierId = null) 
	// {
	// 	$items = SupplierInvoice::where('company_id',$companyId)->where('currency',$currency)->whereBetween('invoice_due_date',[$startDate,$endDate])
	// 	->when($supplierId && $contractCode ,function($builder) use ($supplierId,$contractCode){
	// 		$builder->where('supplier_id',$supplierId)->where('contract_code',$contractCode);
	// 	})
	// 	->get();
	// 	return $items->sum('net_invoice_amount');
	// }
	
}
