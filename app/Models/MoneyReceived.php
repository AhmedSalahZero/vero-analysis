<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MoneyReceived extends Model
{
    protected $guarded = ['id'];
    protected $table = 'money_received';
    
    public function isCash()
    {
        return $this->money_type =='cash';
    }
    public function isCheque()
    {
        return $this->money_type =='cheque';
    }
    public function isIncomingTransfer()
    {
        return $this->money_type =='money_transfer';
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
    public function getCashReceivedAmount()
    {
        return $this->cash_received_amount?:0 ;
    }
	public function getCashReceivedAmountFormatted()
    {
        return number_format($this->getCashReceivedAmount()) ;
    }
    public function getBankCurrency()
    {
        return $this->cash_currency;
    }
	public function getCashCurrency()
	{
		return $this->cash_currency;
	}
    public function getIncomeTransferCurrency()
    {
        return $this->income_transfer_currency;
    }
	public function getPaymentBankName()
	{
		return '-';
	}
	public function getIncomingTransferAmount()
	{
		return $this->incoming_transfer_amount ?: 0 ;
	}
	public function getIncomingTransferAmountFormatted()
	{
		return number_format($this->getIncomingTransferAmount()) ;
	}
    public function getReceiptNumber()
    {
        return $this->receipt_number ;
    }
    public function getChequeAmount()
    {
        return $this->cheque_amount ;
    }
    public function getChequeDueDate()
    {
        return $this->cheque_due_date;
    }
    public function getChequeNumber()
    {
        return $this->cheque_number ;
    }
    public function getDraweeBankId()
    {
        return $this->drawee_bank_id ;
    }
	public function DraweeBank()
	{
		return $this->belongsTo(Bank::class ,'drawee_bank_id','id');
	}
	
	public function getDraweeBankName()
	{
		 return $this->draweeBank ? $this->draweeBank->getViewName() : __('N/A');
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
		 return $this->receivingBank ? $this->receivingBank->getViewName() : __('N/A');
	}
    public function getMainAccountNumber()
    {
        return $this->main_account_number ;
    }
    public function getSubAccountNumber()
    {
        return $this->sub_account_number;
    }
    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'money_received_id', 'id');
    }
    public function customerInvoice()
    {
        return $this->belongsTo(CustomerInvoice::class, 'customer_name', 'customer_name');
    }
    
    public function getSettlementsForInvoiceNumber($invoiceNumber, string $customerName):Collection
    {
        return $this->settlements->where('invoice_number', $invoiceNumber)->where('customer_name', $customerName) ;
    }
	public function getSettlementsForInvoiceNumberAmount($invoiceNumber, string $customerName):float{
		return $this->getSettlementsForInvoiceNumber($invoiceNumber,$customerName)->sum('settlement_amount');
	}
    public function getReceivingDateFormatted()
    {
        $receivingDate = $this->getReceivingDate() ;
        if($receivingDate) {
            return Carbon::make($receivingDate)->format('d-m-Y');
        }
    }
    
	public function getAmountFormatted()
	{
		return number_format($this->getChequeAmount(),1) ;
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
	public static function getBanksForCurrentCompany(int $companyId){
		$banks = self::where('company_id',$companyId)->pluck('drawee_bank_id')->unique()->toArray();
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
		return $date ? Carbon::make($date)->format('m-d-Y') : null;
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
	
	public function chequeMainAccountNumber()
	{
		return $this->cheque_main_account_number ;
	}
	
	
	public function chequeSubAccountNumber()
	{
		return $this->cheque_sub_account_number ;
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
}
