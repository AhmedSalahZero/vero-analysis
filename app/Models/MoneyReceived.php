<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MoneyReceived extends Model
{
	const CASH_IN_SAFE  = 'cash-in-safe';
	const CASH_IN_BANK  = 'cash-in-bank';
	const INCOMING_TRANSFER  = 'incoming-transfer';
	const CHEQUE_IN_SAFE  = 'cheque-is-safe';
	const CHEQUE_IN_UNDER_COLLECTION  = 'cheque-under-collection';
	 
    protected $guarded = ['id'];
    protected $table = 'money_received';
    
	public function getType():string 
	{
		return $this->money_type ;
	}
    public function isCashInSafe()
    {
        return $this->getType() ==self::CASH_IN_SAFE;
    }
	public function isCashInBank()
    {
        return $this->getType() ==self::CASH_IN_BANK;
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
    public function getReceivingBranchId()
    {
        return $this->receiving_branch_id;
    }
    public function getReceivedAmount()
    {
        return  $this->received_amount?:0 ;
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


    public function getReceiptNumber()
    {
        return $this->receipt_number ;
    }

    public function getChequeDueDate()
    {
        return $this->cheque_due_date;
    }
    public function getChequeNumber()
    {
        return $this->cheque_number ;
    }
	public function getNumber()
	{
		if($this->isCheque()){
			return $this->getChequeNumber();
		}
		if($this->isCashInSafe()){
			return $this->getReceiptNumber();
		}
		if($this->isIncomingTransfer()){
			return $this->getMainAccountNumber();
		}
	}
	
	/**
	 * * drawee_bank
		**					هو البنك اللي بنسحب منه الشيك وليكن مثلا شخص اداني شيك معين وقتها بروح اسحبه من هذا 
		**					البنك فا مش شرط يكون من البنوك بتاعتي لانه مش شيك انا اللي مطلعه
                                
	 */
	public function DraweeBank()
	{
		return $this->belongsTo(Bank::class ,'drawee_bank_id','id');
	}
	public function getDraweeBankId()
	{
		return $this->drawee_bank_id ;
	}
	
	public function getDraweeBankName()
	{
		 return $this->draweeBank ? $this->draweeBank->getViewName() : __('N/A');
	}	
	public function getDraweeBankNameIn(string $lang)
	{
		 return $this->draweeBank ? $this->draweeBank['name_'.$lang] : __('N/A');
	}
	
	public function getBankName()
	{
		if($this->isCashInSafe()){
			return $this->getCashBranchName();
		}
		if($this->isCheque()){
			return $this->getDraweeBankNameIn(app()->getLocale());
		}
		if($this->isIncomingTransfer()){
			return $this->getReceivingBankNameIn(app()->getLocale());
		}
	}
	
	
	
    public function getReceivingBankId()
    {
        return $this->receiving_bank_id;
    }
	public function receivingBank()
	{
		return $this->belongsTo(Bank::class , 'receiving_bank_id','id');
	}
	public function getReceivingBankName()
	{
		 return $this->receivingBank ? $this->receivingBank->getName() : __('N/A');
	}
	// public function getReceivingBankNameIn(string $lang)
	// {
	// 	 return $this->receivingBank ? $this->receivingBank['name_'.$lang] : __('N/A');
	// }
    public function getAccountNumber()
    {
		// if statement here for type
        return $this->account_number;
    }
    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'money_received_id', 'id');
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
    

	public function getChequeDueDateFormatted()
	{
		$chequeDueDate = $this->getChequeDueDate();
		return $chequeDueDate ? Carbon::make($chequeDueDate)->format('d-m-Y') : null;
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
	public function setChequeDueDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['cheque_due_date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		
		$this->attributes['cheque_due_date'] = $year.'-'.$month.'-'.$day;
	}
	public static function getUniqueBanks(Collection $banks):array{
		$uniqueBanksIds = [];
		foreach($banks as $bank){
			if($bank->drawee_bank_id){
				$uniqueBanksIds[$bank->drawee_bank_id] = $bank->drawee_bank_id;
			}
			if($bank->receiving_bank_id){
				$uniqueBanksIds[$bank->receiving_bank_id] = $bank->receiving_bank_id;
			}
			if($bank->cheque_drawl_bank_id){
				$uniqueBanksIds[$bank->cheque_drawl_bank_id] = $bank->cheque_drawl_bank_id;
			}
			
		}
		return $uniqueBanksIds; 
	}
	public static function getBanksForCurrentCompany(int $companyId){
		$banks = self::where('company_id',$companyId)->get(['drawee_bank_id','cheque_drawl_bank_id']);
		$banks = self::getUniqueBanks($banks);
		$banksFormatted = [];
		foreach($banks as $bankId){
			$bank = Bank::find($bankId) ;
			if($bank){
				$banksFormatted[$bankId] = $bank->getViewName() ;
			}
		}
		
		return $banksFormatted; 
	}
	
	
	
	public function getChequeDueAfterDays()
	{
		$firstDate = Carbon::make($this->getChequeDueDate());
		$secondDate = Carbon::make($this->getReceivingDate());
		return getDiffBetweenTwoDatesInDays($firstDate , $secondDate);
	}
	public function getTransferMoneyStatus()
	{
		return 'Not Received Yet';
	}
	public function getTransferMoneyDueAfterDays()
	{
		return '-';
		// $firstDate = Carbon::make($this->getDueDate());
		// $secondDate = Carbon::make($this->getReceivingDate());
		// return getDiffBetweenTwoDatesInDays($firstDate , $secondDate);
	}
	public function getChequeStatus()
	{
		return $this->cheque_status;
	}
	public function getChequeStatusFormatted()
	{
		return snakeToCamel($this->getChequeStatus());
	}
	
	public function receivingBranch()
	{
		return $this->belongsTo(Branch::class , 'receiving_branch_id','id');
	}
	public function getCashBranchName()
	{
		return $this->receivingBranch ? $this->receivingBranch->getName() : __('N/A') ;
	}
	
	public function getChequeDepositDate()
	{
		return $this->cheque_deposit_date;
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
	public function setChequeDepositDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['cheque_deposit_date'] = $value;
			return  ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$this->attributes['cheque_deposit_date'] = $year.'-'.$month.'-'.$day;
		
	}
	public function chequeDrawlBank()
	{
		return $this->belongsTo(Bank::class,'cheque_drawl_bank_id','id') ;
	}
	public function chequeDrawlBankName()
	{
		return $this->chequeDrawlBank ? $this->chequeDrawlBank->getName() : __('N/A') ;
	}
	public function chequeDrawlBankId()
	{
		return $this->cheque_drawl_bank_id ;
	}
	
	public function chequeAccountType()
	{
		return $this->cheque_account_type ;
	}
	
	
	/**
	 * * هو عباره عن رقم الحساب اللي هينزل فيه مبلغ الشيك بعد التحصيل من البنك
	 */
	public function getAccountNumberForChequesCollection()
	{
		return $this->account_number_for_cheques_collection ;
	}
	
	public function chequeAccountBalance()
	{
		return $this->cheque_account_balance?:0 ;
	}
	public function chequeExpectedCollectionDate()
	{
		return $this->cheque_expected_collection_date ;
	}
	public function chequeExpectedCollectionDateFormatted()
	{
		$date  = $this->cheque_expected_collection_date ;
		return $date ? Carbon::make($date)->format('d-m-Y') : null ;
	}
	public function chequeClearanceDays()
	{
		return $this->cheque_clearance_days ?: 0;
	}
	public function calculateChequeExpectedCollectionDate(string $chequeDepositDate , int $chequeClearanceDays):string 
	{
		$chequeDueDate = $this->getChequeDueDate();
		$chequeDueDate = Carbon::make($chequeDueDate);
		$chequeDepositDate = Carbon::make($chequeDepositDate);
		if($chequeDepositDate->lessThan($chequeDueDate)){
			$diffInDays = $chequeDueDate->diffInDays($chequeDepositDate) + $chequeClearanceDays ;
			return $chequeDepositDate->addDays($diffInDays)->format('Y-m-d');
		}
		else{
			return $chequeDepositDate->addDays($chequeClearanceDays)->format('Y-m-d');	
		}
	}	
	public function isChequeUnderCollection()
	{
		return $this->getChequeStatus() == 'under_collection';
	}
	public function getTotalWithholdAmount():float 
	{
		return $this->total_withhold_amount ?: 0 ;
	}
}
