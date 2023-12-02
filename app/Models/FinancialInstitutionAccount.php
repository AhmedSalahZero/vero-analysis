<?php

namespace App\Models;

use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FinancialInstitutionAccount extends Model
{
    protected $guarded = ['id'];
	public function financialInstitution()
	{
		return $this->belongsTo(FinancialInstitution::class,'financial_institution_id','id');
	}
	public function getAccountNumber()
	{
		return $this->account_number ; 
	}
	public function getSwiftCode()
	{
		return $this->swift_code ; 
	}
	public function getIbanCode()
	{
		return $this->iban_code ; 
	}
	public function getCurrentAccountNumber()
	{
		return $this->current_account_number ;
	}
	public function getMainCurrency()
	{
		return $this->main_currency ;
	}
	public function getBalanceAmount()
	{
		return $this->balance_amount ?: 0 ;
	}
	public function getBalanceDate()
	{
		return $this->balance_date ;
	}
	public function getId()
	{
		return $this->id ;
	}
	public function getCurrency()
	{
		return $this->currency;
	}
	// public function getBankId()
    // {
    //     return $this->bank_id ;
    // }
	// public function bank()
	// {
	// 	return $this->belongsTo(Bank::class ,'bank_id','id');
	// }
	// public function getBankName()
	// {
	// 	 return $this->bank ? $this->bank->getViewName() : __('N/A');
	// }	
	// public function getBankNameIn(string $lang)
	// {
	// 	 return $this->bank ? $this->bank['name_'.$lang] : __('N/A');
	// }
	
	
}
