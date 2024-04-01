<?php

namespace App\Models;

use App\Helpers\HHelpers;
use App\Models\OpeningBalance;
use App\Traits\Models\IsMoney;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MoneyReceived extends Model
{
	use IsMoney ;
	const CASH_IN_SAFE  = 'cash-in-safe';
	const CASH_IN_BANK  = 'cash-in-bank';
	const INCOMING_TRANSFER  = 'incoming-transfer';
	const CHEQUE  = 'cheque';
	const CHEQUE_UNDER_COLLECTION  = 'cheque-under-collection';
	const CHEQUE_REJECTED  = 'cheque-rejected';
	const CHEQUE_COLLECTED = 'cheque-collected';
	
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
	public function cleanOverdraftBankStatement()
	{
		return $this->hasOne(CleanOverdraftBankStatement::class,'money_received_id','id');
	}
	public function cashInSafeStatement()
	{
		return $this->hasOne(CashInSafeStatement::class,'money_received_id','id');
	}
	public function storeCleanOverdraftBankStatement(string $moneyType , CleanOverdraft $cleanOverdraft , string $date , $receivedAmount )
	{
		return $this->cleanOverdraftBankStatement()->create([
			'type'=>$moneyType ,
			'clean_overdraft_id'=>$cleanOverdraft->id ,
			'company_id'=>$this->company_id ,
			'date'=>$date,
			'limit'=>$cleanOverdraft->getLimit(),
			'beginning_balance'=>0 ,
			'debit'=>$receivedAmount,
			'credit'=>0 
		]) ;
	}
	public function storeCashInSafeStatement(string $date , $receivedAmount )
	{
		return $this->cashInSafeStatement()->create([
			'company_id'=>$this->company_id ,
			'debit'=>$receivedAmount,
			'date'=>$date
		]);
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
		$this->cleanOverdraftBankStatement ? $this->cleanOverdraftBankStatement->delete() : null ;
		$this->cashInSafeStatement ? $this->cashInSafeStatement->delete() : null ;
	}
}
