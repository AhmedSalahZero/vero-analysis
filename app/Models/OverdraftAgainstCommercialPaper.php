<?php

namespace App\Models;

use App\Traits\HasOutstandingBreakdown;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OverdraftAgainstCommercialPaper extends Model
{
    protected $guarded = ['id'];
	use HasOutstandingBreakdown ;
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
		$contractEndDate = $this->getContractStartDate() ;
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
	public function getInterestRate()
	{
		return $this->interest_rate?:0;
	}
	public function getMaxLendingLimitPerCustomer()
	{
		return $this->max_lending_limit_per_customer?:0;
	}
	/**
	 * * هو عدد الايام اللي اجباري تسدد السحبات فيها 
	 * * وليكن مثلا لو سحبت النهاردا الف جنية فا مفروض اسددها بعد كام يوم 
	 */
	public function getMaxSettlementDays()
	{
		return $this->to_be_setteled_max_within_days?:0;
	}
	 /**
	 * * هي فايدة بيحددها البنك بالبنك المركزي
	 */
	public function getBorrowingRate()
	{
		return $this->borrowing_rate ?: 0;
	}
	/**
	 * * هي فايدة خاصة بالبنك بناء علي العميل (طبقا للقدرة المالية زي امتلاكك للمصانع)
	 */
	public function getMarginRate()
	{
		return $this->bank_margin_rate ?: 0 ;
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
	
	public static function getAllAccountNumberForCurrency($companyId , $currencyName,$financialInstitutionId):array
	{
		return self::where('company_id',$companyId)
		->where('financial_institution_id',$financialInstitutionId)
		->where('currency',$currencyName)->pluck('account_number','account_number')->toArray();		
	}
	public function generateForeignKeyFormModelName()
	{
		return 'overdraft_against_commercial_paper_id';
	}	
	
	
	
}
