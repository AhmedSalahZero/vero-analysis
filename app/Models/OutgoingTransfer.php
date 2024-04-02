<?php

namespace App\Models;

use App\Traits\Models\IsIncomingTransfer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutgoingTransfer extends Model
{
	 
    protected $guarded = ['id'];
	
	public function moneyPayment()
	{
		return $this->belongsTo(MoneyPayment::class,'money_payment_id');
	}
	/**
	 * * البنك اللي طلعنا منه التحويلة
	 */
	public function deliveryBank():?BelongsTo{
		return $this->belongsTo(FinancialInstitution::class,'delivery_bank_id','id');
	}
	
	public function getDeliveryBankId()
	{
		$bank = $this->deliveryBank;
		return $bank ? $bank->id : 0 ;
	}
	public function getDeliveryBankName()
	{
		$bank = $this->deliveryBank;
		return $bank ? $bank->getName() : __('N/A') ;
	}
	public function getReceiptNumber()
	{
		return $this->receipt_number ;
	}
	public function accountType()
	{
		return $this->belongsTo(AccountType::class,'account_type','id');
	}
	public function getAccountTypeId()
	{
		$accountType = $this->accountType; 
		return $accountType ? $accountType->id : 0 ; 
	}
	public function getAccountTypeName()
	{
		$accountType = $this->accountType; 
		return $accountType ? $accountType->getName() : __('N/A') ; 
	}
	public function getAccountNumber()
	{
		return $this->account_number;
	}
	
	
}