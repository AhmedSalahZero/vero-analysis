<?php

namespace App\Models;

use App\Models\OpeningBalance;
use App\Models\OutgoingTransfer;
use App\Traits\Models\HasCreditStatements;
use App\Traits\Models\IsMoney;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class CashExpense extends Model
{
	use IsMoney ,HasCreditStatements;
	const CASH_PAYMENT  = 'cash_payment';
	const PAYABLE_CHEQUE  = 'payable_cheque';
	const OUTGOING_TRANSFER  = 'outgoing-transfer';
	
	public static function generateComment(self $cashExpense,string $lang)
	{
		// $supplierName = $cashExpense->getSupplierName();
		// $paidInvoiceNumbers = getKeysWithSettlementAmount(Request()->get('settlements',[]),'settlement_amount');
		
		if($cashExpense->isPayableCheque()){
			return __('Payable Cheque To Pay :expenseName [ :chequeNumber ]',['expenseName'=>$cashExpense->getExpenseCategoryName(),'chequeNumber'=>Request('cheque_number')],$lang) ;
		}
		if($cashExpense->isCashPayment()){
			return __('Cash Payment To Pay :expenseName',['expenseName'=>$cashExpense->getExpenseCategoryName()],$lang) ;
		}
		if($cashExpense->isOutgoingTransfer()){
			return __('Outgoing Transfer To Pay :expenseName',['expenseName'=>$cashExpense->getExpenseCategoryName()],$lang) ;
		}
	}
	protected static function booted()
	{
		self::creating(function (self $cashExpense): void {
			$cashExpense->comment_en = self::generateComment($cashExpense,'en');
			$cashExpense->comment_ar = self::generateComment($cashExpense,'ar');
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
    // public function getSupplierName()
    // {
    //     return $this->supplier_name;
    // }
	// public function supplier()
	// {
	// 	return $this->belongsTo(Partner::class,'supplier_name','name')->where('is_supplier',1)->where('company_id',getCurrentCompanyId());
	// }
	// public function getSupplierId()
	// {
	// 	return $this->supplier ? $this->supplier->id : 0 ;
	// }
	// public function getName()
	// {
	// 	return $this->getSupplierName();
	// }
    public function getPaymentDate()
    {
        return $this->payment_date;
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

	public function getExpenseCategoryName():string
	{
	
		return $this->cashExpenseCategoryName && $this->cashExpenseCategoryName->cashExpenseCategory ? $this->cashExpenseCategoryName->cashExpenseCategory->getName() : __('N/A') ;
	}
	public function getExpenseName()
	{
		return  $this->cashExpenseCategoryName ? $this->cashExpenseCategoryName->getName() : __('N/A');
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
		return $this->hasOne(OutgoingTransfer::class,'cash_expense_id','id');
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
        return $this->hasMany(PaymentSettlement::class, 'cash_expense_id', 'id');
    }
	/**
	 * * For Down Payment Only
	 */
    public function downPaymentSettlements()
    {
        return $this->hasMany(DownPaymentMoneyPaymentSettlement::class, 'cash_expense_id', 'id');
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
    public function getPaymentDateFormatted()
    {
        $date = $this->getPaymentDate() ;
        if($date) {
            return Carbon::make($date)->format('d-m-Y');
        }
    }
	public function setPaymentDateAttribute($value)
	{
		if(is_object($value)){
			return $value ;
		}
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['payment_date'] = $value;
			return  ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$this->attributes['payment_date'] = $year.'-'.$month.'-'.$day;
		
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
		return $payable ? $payable->getPaymentDate() : null;
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
		return $this->hasOne(CashPayment::class,'cash_expense_id','id');
	}
	
	public function payableCheque()
	{
		return $this->hasOne(PayableCheque::class,'cash_expense_id','id');
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
	
	
	
	// public function unappliedAmounts()
	// {
	// 	return $this->hasMany(UnappliedAmount::class ,'model_id','id')->where('model_type',HHelpers::getClassNameWithoutNameSpace($this));	
	// }
	public function cleanOverdraftCreditBankStatement()
	{
		return $this->hasOne(CleanOverdraftBankStatement::class,'cash_expense_id','id');
	}
	public function fullySecuredOverdraftCreditBankStatement()
	{
		return $this->hasOne(FullySecuredOverdraftBankStatement::class,'cash_expense_id','id');
	}
	public function overdraftAgainstCommercialPaperCreditBankStatement()
	{
		return $this->hasOne(OverdraftAgainstCommercialPaperBankStatement::class,'cash_expense_id','id');
	}
	public function overdraftAgainstAssignmentOfContractCreditBankStatement()
	{
		return $this->hasOne(OverdraftAgainstAssignmentOfContractBankStatement::class,'cash_expense_id','id');
	}
	public function cashInSafeCreditStatement()
	{
		return $this->hasOne(CashInSafeStatement::class,'cash_expense_id','id');
	}
	public function currentAccountCreditBankStatement()
	{
		return $this->hasOne(CurrentAccountBankStatement::class,'cash_expense_id','id');
	}
	
	public function openingBalance()
	{
		return $this->belongsTo(OpeningBalance::class,'opening_balance_id');
	}
	public function isOpenBalance()
	{
		return $this->opening_balance_id !== null ;
	}
	
	// public function isDownPayment()
	// {
	// 	return $this->getMoneyType() == 'down-payment';
	// }
	// public function getMoneyType()
	// {
	// 	return $this->money_type; 
	// }
	public function getMoneyTypeFormatted()
	{
		$moneyType = $this->getMoneyType();
		if($moneyType == 'money-payment'){
			$moneyType = 'invoice-settlement';
		}
		return camelizeWithSpace($moneyType) ;
	}
	// public function getContractId()
	// {
	// 	return $this->contract_id;
	// }
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
		$this->contracts()->detach();
		// $this->settlements->each(function($settlement){
		// 	$settlement->delete();
		// });
		// $this->unappliedAmounts()->delete();
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
		return $this->getPaymentDate();
	}
		
	public function cashExpenseCategoryName():BelongsTo
	{
		return $this->belongsTo(CashExpenseCategoryName::class,'cash_expense_category_name_id','id');
	}	
	public function getExpenseCategoryId():int
	{
		return $this->cashExpenseCategoryName && $this->cashExpenseCategoryName->cashExpenseCategory ? $this->cashExpenseCategoryName->cashExpenseCategory->id : 0;
	}
	public function getCashExpenseCategoryNameId()
	{
		return $this->cash_expense_category_name_id ;
	}
	public function contracts()
	{
		return $this->belongsToMany(Contract::class ,'cash_expense_contract','cash_expense_id','contract_id')
		->withTimestamps()
		->withPivot(['amount'])
		;
	}
}
