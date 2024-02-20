<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CleanOverdraft extends Model
{
    protected $guarded = ['id'];
	public function getContractStartDate()
	{
		return $this->contract_start_date;
	}
	public function getContractStartDateFormatted()
	{
		$contractStartDate = $this->contract_start_date ;
		return $contractStartDate ? Carbon::make($contractStartDate)->format('d-m-Y'):null ;
	}
	public function getContractEndDate()
	{
		return $this->contract_end_date;
	}
	public function getContractEndDateFormatted()
	{
		$contractEndDate = $this->getContractEndDate() ;
		return $contractEndDate ? Carbon::make($contractEndDate)->format('d-m-Y'):null ;
	}
	public function getAccountNumber()
	{
		return $this->account_number ;
	}
	public function getLimit()
	{
		return $this->limit ?: 0 ;
	}
	public function getMarginRate()
	{
		return $this->bank_margin_rate ?: 0 ;
	}
	public function getInterestRate()
	{
		return $this->interest_rate?:0;
	}
	public function getMaxLendingLimitPerCustomer()
	{
		return $this->max_lending_limit_per_customer?:0;
	}
	public function getMaxSettlementDays()
	{
		return $this->to_be_setteled_max_within_days?:0;
	}
	public function getBorrowingRate()
	{
		return $this->borrowing_rate ?: 0;
	}
	public function getCurrency()
	{
		return $this->currency ;
	}
	public function financialInstitution()
	{
		return $this->belongsTo(FinancialInstitution::class , 'financial_institution_id','id');
	}
	public function lendingInformation()
	{
		return $this->hasMany(LendingInformation::class , 'overdraft_against_commercial_paper_id','id');
	}
	public static function getAllAccountNumberForCurrency($companyId , $currencyName):array
	{
		return self::where('company_id',$companyId)->where('currency',$currencyName)->pluck('account_number','account_number')->toArray();		
	}

	
	
	
}
