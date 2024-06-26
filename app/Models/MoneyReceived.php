<?php

namespace App\Models;

use App\Helpers\HHelpers;
use App\Models\OpeningBalance;
use App\Traits\Models\HasDebitStatements;
use App\Traits\Models\IsMoney;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MoneyReceived extends Model
{
	use IsMoney ,HasDebitStatements;
	const CASH_IN_SAFE  = 'cash-in-safe';
	const CASH_IN_BANK  = 'cash-in-bank';
	const INCOMING_TRANSFER  = 'incoming-transfer';
	const CHEQUE  = 'cheque';
	const CHEQUE_UNDER_COLLECTION  = 'cheque-under-collection';
	const CHEQUE_REJECTED  = 'cheque-rejected';
	const CHEQUE_COLLECTED = 'cheque-collected';
	public static function generateComment(self $moneyReceived,string $lang)
	{
		$settledInvoiceNumbers = getKeysWithSettlementAmount(Request()->get('settlements',[]),'settlement_amount');
		
		$customerName = $moneyReceived->getCustomerName();
		if($moneyReceived->isCheque()){
			return __('Cheque From :name With Number #:number Settled Invoices [ :numbers ]',['name'=>$customerName,'number'=>$moneyReceived->getChequeNumber(),'numbers'=>$settledInvoiceNumbers],$lang) ;
		}
		if($moneyReceived->isCashInSafe()){
			return __('Cash In Safe From :name Settled Invoices [ :numbers ]',['name'=>$customerName,'numbers'=>$settledInvoiceNumbers],$lang) ;
		}
		if($moneyReceived->isCashInBank()){
			return __('Cash In Bank From :name Settled Invoices [ :numbers ]',['name'=>$customerName,'numbers'=>$settledInvoiceNumbers],$lang) ;
		}
		if($moneyReceived->isIncomingTransfer()){
			return __('Incoming Transfer From :name Settled Invoices [ :numbers ]',['name'=>$customerName,'numbers'=>$settledInvoiceNumbers],$lang) ;
		}
	}
	protected static function booted()
	{
		self::creating(function (self $moneyReceived): void {
			$moneyReceived->comment_en = self::generateComment($moneyReceived,'en');
			$moneyReceived->comment_ar = self::generateComment($moneyReceived,'ar');
		});
		
	}
	public static function getAllTypes()
	{
		return [
			self::CASH_IN_SAFE,
			self::CASH_IN_BANK,
			self::INCOMING_TRANSFER,
			self::CHEQUE,
			self::CHEQUE_UNDER_COLLECTION,
			self::CHEQUE_REJECTED,
			self::CHEQUE_COLLECTED,
			
		];
	}
	
    protected $guarded = ['id'];
    protected $table = 'money_received';
    
	public function getType():string 
	{
		return $this->type ;
	}
    public function isCashInSafe()
    {
        return $this->getType() ==self::CASH_IN_SAFE;
    }
	public function isCashInBank()
    {
        return $this->getType() ==self::CASH_IN_BANK;
    }
	public function isCheque()
    {
        return $this->getType() ==self::CHEQUE;
    }
  
    public function isIncomingTransfer()
    {
        return $this->getType() ==self::INCOMING_TRANSFER;
    }
    
	
    public function getCustomerName()
    {
        return $this->customer_name;
    }
	public function customer()
	{
		return $this->belongsTo(Partner::class,'customer_name','name')->where('is_customer',1)->where('company_id',getCurrentCompanyId());
	}
	public function getCustomerId()
	{
		return $this->customer ? $this->customer->id : 0 ;
	}
    public function getName()
    {
    	return $this->getCustomerName();
    }
    public function getReceivingDate()
    {
        return $this->receiving_date;
    }
    public function getCashInSafeReceivingBranchId()
    {
		$cashInSafe = $this->cashInSafe ;
        return  $cashInSafe ? $cashInSafe->getReceivingBranchId() :0;
    }
    public function getReceivedAmount()
    {
        return  $this->received_amount?:0 ;
    }
	public function getAmount()
	{
		return $this->getReceivedAmount();
	}
	public function getChequeDueDate(){
		return $this->cheque ? $this->cheque->getDueDate(): null;
	}
	public function getChequeNumber()
	{
		return $this->cheque ? $this->cheque->getChequeNumber():null;
	}
	public function getReceivedAmountFormatted()
    {
        return number_format($this->getReceivedAmount()) ;
    }
   
	public function getCurrency()
	{
		return $this->currency;
	}
	
	public function getCurrencyFormatted()
	{
		return strtoupper($this->currency);
	}

	public function getExchangeRate()
	{
		
		return $this->exchange_rate?:1;
	}
	public function getPaymentBankName()
	{
		return '-';
	}


    public function getCashInSafeReceiptNumber()
    {
		$cashInSafe = $this->cashInSafe;
        return $cashInSafe ? $cashInSafe->getReceiptNumber() :  null ;
    }

  
	public function getNumber()
	{
		if($this->isCheque()){
			return $this->cheque->getChequeNumber();
		}
		if($this->isCashInSafe()){
			return $this->getCashInSafeReceiptNumber();
		}
		if($this->isIncomingTransfer()){
			return $this->getIncomingTransferAccountNumber();
		}
		if($this->isCashInBank()){
			return $this->getCashInBankAccountNumber();
		}
	}
	

	
	public function getBankName()
	{
		if($this->isCashInSafe()){
			return $this->getCashInSafeBranchName();
		}
		if($this->isCheque()){
			return $this->cheque->getDraweeBankName();
		}
		if($this->isIncomingTransfer()){
			return $this->getIncomingTransferReceivingBankName(app()->getLocale());
		}
		if($this->isCashInBank()){
			return $this->getCashInBankReceivingBankName(app()->getLocale());
		}
	}
	
	public function incomingTransfer()
	{
		return $this->hasOne(IncomingTransfer::class,'money_received_id','id');
	}

    public function getIncomingTransferReceivingBankId()
    {
		$incomingTransfer = $this->incomingTransfer ;
        return $incomingTransfer ? $incomingTransfer->getReceivingBankId() : 0 ;
    }
	public function incomingTransferReceivingBank():?FinancialInstitution
	{
		$incomingTransfer = $this->incomingTransfer ;
		return $incomingTransfer ? $incomingTransfer->receivingBank() : null ;
	}
	public function getIncomingTransferReceivingBankName()
	{
		$incomingTransfer = $this->incomingTransfer ;
        return $incomingTransfer ? $incomingTransfer->getReceivingBankName() : __('N/A') ;
	}
	
	public function cashInBank()
	{
		return $this->hasOne(CashInBank::class,'money_received_id','id');
	}
	public function getCashInBankReceivingBankName()
    {
		$cashInBank = $this->cashInBank ;
        return $cashInBank ? $cashInBank->getReceivingBankName() : 0 ;
    }

    public function getCashInBankReceivingBankId()
    {
		$cashInBank = $this->cashInBank ;
        return $cashInBank ? $cashInBank->getReceivingBankId() : 0 ;
    }
	public function cashInBankReceivingBank():?FinancialInstitution
	{
		$cashInBank = $this->cashInBank ;
		return $cashInBank ? $cashInBank->receivingBank() : null ;
	}
	public function getFinancialInstitutionId()
	{
		if($this->isCashInBank()){
			return $this->getCashInBankReceivingBankId();
		}
		if($this->isIncomingTransfer()){
			return $this->getIncomingTransferReceivingBankId();
		}
		if($this->isCheque()){
			return $this->cheque ? $this->cheque->getDrawlBankId() : 0;
		}
	}
	
	/**
	 * * For Money Received Only
	 */
    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'money_received_id', 'id');
    }
	/**
	 * * For Down Payment Only
	 */
    public function downPaymentSettlements()
    {
        return $this->hasMany(DownPaymentSettlement::class, 'money_received_id', 'id');
    }
    public function customerInvoice()
    {
        return $this->belongsTo(CustomerInvoice::class, 'customer_name', 'customer_name');
    }
   

	public function getSettlementsForCustomerName( string $customerName):Collection
    {
        return $this->settlements->where('customer_name', $customerName) ;
    }
    public function getSettlementsForInvoiceNumber($invoiceNumber, string $customerName):Collection
    {
        return $this->settlements->where('invoice_number', $invoiceNumber)->where('customer_name', $customerName) ;
    }
	public function getSettlementsForInvoiceNumberAmount($invoiceNumber, string $customerName):float{
		return $this->getSettlementsForInvoiceNumber($invoiceNumber,$customerName)->sum('settlement_amount');
	}
	public function getWithholdForInvoiceNumberAmount($invoiceNumber, string $customerName):float{
		return $this->getSettlementsForInvoiceNumber($invoiceNumber,$customerName)->sum('withhold_amount');
	}
    public function getReceivingDateFormatted()
    {
        $receivingDate = $this->getReceivingDate() ;
        if($receivingDate) {
            return Carbon::make($receivingDate)->format('d-m-Y');
        }
    }
	public function setReceivingDateAttribute($value)
	{
		if(is_object($value)){
			return $value ;
		}
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['receiving_date'] = $value;
			return  ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$this->attributes['receiving_date'] = $year.'-'.$month.'-'.$day;
		
	}
	
	public static function getUniqueBanks( $banks):array{
		$uniqueBanksIds = [];
		foreach($banks as $bankId){
				$uniqueBanksIds[$bankId] = $bankId;
		}
		return $uniqueBanksIds; 
	}
	
	public static function getDrawlBanksForCurrentCompany(int $companyId){

		$cheques = self::where('company_id',$companyId)->has('cheque')->with('cheque')->get()->pluck('cheque.drawee_bank_id')->toArray();
		$banks = self::getUniqueBanks($cheques);
		$banksFormatted = [];
		foreach($banks as $bankId){
			$bank = Bank::find($bankId) ;
			if($bank){
				$banksFormatted[$bankId] = $bank->getViewName() ;
			}
		}
		return $banksFormatted; 
	}
	
	
	


	
	public function cashInSafeReceivingBranch()
	{
		$cashInSafe = $this->cashInSafe;
		return $cashInSafe ? $cashInSafe->receivingBranch : null ;
	}
	public function getCashInSafeBranchName()
	{
		$cashInSafe = $this->cashInSafe;

		return $cashInSafe ? $cashInSafe->getReceivingBranchName() : null ;
	}
	
	public function getChequeDepositDate()
	{
		$cheque = $this->cheque;
		return $cheque ? $cheque->getDepositDate() : null;
	}
	public function getChequeDepositDateFormattedForDatePicker()
	{
		$date = $this->getChequeDepositDate();
		return $date ? Carbon::make($date)->format('m/d/Y') : null;
	}
	public function getChequeDepositDateFormatted()
	{
		$date = $this->getChequeDepositDate();
		return $date ? Carbon::make($date)->format('d-m-Y') : null;
	}
	
	
	
	/** drawl_bank_id
	**	هو البنك اللي بنسحب منه الشيك وليكن مثلا شخص اداني شيك معين وقتها بروح اسحبه من هذا 
	**	البنك فا شرط يكون من البنوك بتاعتي علشان البنك بتاعي يتواصل مع بنك ال
	**	drawee بعدين يحطلي الفلوس بتاعته في حسابي
	*/		 
	public function chequeDrawlBank()
	{
		return $this->belongsTo(Bank::class,'drawl_bank_id','id') ;
	}
	public function chequeDrawlBankName()
	{
		return $this->chequeDrawlBank ? $this->chequeDrawlBank->getName() : __('N/A') ;
	}
	public function chequeDrawlBankId()
	{
		return $this->drawl_bank_id ;
	}
	
	public function getChequeAccountType()
	{
		$cheque = $this->cheque ;
		return $cheque ? $cheque->getAccountType() : null ;
	}
	
	public function getChequeAccountNumber()
	{
		$cheque = $this->cheque ;
		return $cheque ? $cheque->getAccountNumber() : null ;
	}
	
	public function cashInSafe()
	{
		return $this->hasOne(CashInSafe::class,'money_received_id','id');
	}
	
	public function cheque()
	{
		return $this->hasOne(Cheque::class,'money_received_id','id');
	}
		
	public function isChequeUnderCollection()
	{
		return $this->cheque && $this->cheque->getStatus() == Cheque::UNDER_COLLECTION;
	}
	public function getTotalWithholdAmount():float 
	{
		return $this->total_withhold_amount ?: 0 ;
	}
	public function getIncomingTransferAccountTypeId(){
		$incomingTransfer = $this->incomingTransfer;
		return $incomingTransfer ? $incomingTransfer->getAccountTypeId() : 0 ;
	}
	public function getIncomingTransferAccountTypeName(){
		$incomingTransfer = $this->incomingTransfer;
		return $incomingTransfer ? $incomingTransfer->getAccountTypeName() : 0 ;
	}
	public function getIncomingTransferAccountNumber(){
		$incomingTransfer = $this->incomingTransfer;
		return $incomingTransfer ? $incomingTransfer->getAccountNumber() : 0 ;
	}
	public function getCashInBankAccountTypeId(){
		$cashInBank = $this->cashInBank;
		return $cashInBank ? $cashInBank->getAccountTypeId() : 0 ;
	}
	public function getCashInBankAccountTypeName(){
		$cashInBank = $this->cashInBank;
		return $cashInBank ? $cashInBank->getAccountTypeName() : 0 ;
	}
	public function getCashInBankAccountNumber(){
		$cashInBank = $this->cashInBank;
		return $cashInBank ? $cashInBank->getAccountNumber() : 0 ;
	}
	public function unappliedAmounts()
	{
		return $this->hasMany(UnappliedAmount::class ,'model_id','id')->where('model_type',HHelpers::getClassNameWithoutNameSpace($this));	
	}
	public function cleanOverdraftDebitBankStatement()
	{
		return $this->hasOne(CleanOverdraftBankStatement::class,'money_received_id','id');
	}
	public function fullySecuredOverdraftDebitBankStatement()
	{
		return $this->hasOne(FullySecuredOverdraftBankStatement::class,'money_received_id','id');
	}
	public function overdraftAgainstCommercialPaperDebitBankStatement()
	{
		return $this->hasOne(OverdraftAgainstCommercialPaperBankStatement::class,'money_received_id','id');
	}
	public function overdraftAgainstAssignmentOfContractDebitBankStatement()
	{
		return $this->hasOne(OverdraftAgainstAssignmentOfContractBankStatement::class,'money_received_id','id');
	}
	public function cashInSafeDebitStatement()
	{
		return $this->hasOne(CashInSafeStatement::class,'money_received_id','id');
	}
	public function currentAccountDebitBankStatement()
	{
		return $this->hasOne(CurrentAccountBankStatement::class,'money_received_id','id');
	}
		
	public function openingBalance()
	{
		return $this->belongsTo(OpeningBalance::class,'opening_balance_id');
	}
	public function isOpenBalance()
	{
		return $this->opening_balance_id !== null ;
	}
	public function getChequeClearanceDays()
	{
		return $this->cheque ? $this->cheque->clearance_days : 0 ;
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
		return camelizeWithSpace($this->getMoneyType()) ;
	}
	public function getContractId()
	{
		return $this->contract_id;
	}
	public function deleteRelations()
	{
		$oldType = $this->getType();

		
		$oldTypeRelationName = dashesToCamelCase($oldType);
		$this->$oldTypeRelationName ? $this->$oldTypeRelationName->delete() : null;
		$this->settlements->each(function($settlement){
			$settlement->delete();
		});
		$this->unappliedAmounts()->delete();
		
		$currentStatement = $this->getCurrentStatement() ;
		if($currentStatement){
			$currentStatement->delete();
		}

	}
	public function getCurrentStatement()
	{
		if($this->cleanOverdraftDebitBankStatement){
			return $this->cleanOverdraftDebitBankStatement ;
		}
		if($this->overdraftDebitBankStatement){
			return $this->overdraftDebitBankStatement ;
		}
		if($this->fullySecuredOverdraftDebitBankStatement){
			return $this->fullySecuredOverdraftDebitBankStatement;
		}
		if($this->overdraftAgainstCommercialPaperDebitBankStatement){
			return $this->overdraftAgainstCommercialPaperDebitBankStatement;
		}	
		if($this->overdraftAgainstAssignmentOfContractDebitBankStatement){
			return $this->overdraftAgainstAssignmentOfContractDebitBankStatement;
		}	
		if($this->cashInSafeDebitStatement){
			return $this->cashInSafeDebitStatement;
		}
		if($this->currentAccountDebitBankStatement){
			return $this->currentAccountDebitBankStatement ;
		}
		
		
	}

	
	/**
	 * * دا عباره عن التاريخ اللي هنستخدمة في ال
	 * * statements 
	 * * سواء بانك او كاش الخ
	 */
	public function getStatementDate()
	{
		if($this->isCheque()){
			return $this->getChequeDueDate();
		}
		return $this->getReceivingDate();
	}
}
