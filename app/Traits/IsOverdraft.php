<?php
namespace App\Traits;

use App\Models\FinancialInstitution;
use App\Models\LendingInformation;
use Carbon\Carbon;





trait IsOverdraft
{
	/**
	 * * هو تاريخ بداية التعاقد مع البنك علي هذا التسهيل (القرض)
	 */
	public function getContractStartDate()
	{
		return $this->contract_start_date;
	}
	public function getContractStartDateFormatted()
	{
		$contractStartDate = $this->contract_start_date ;
		return $contractStartDate ? Carbon::make($contractStartDate)->format('d-m-Y'):null ;
	}
	/**
	 * * هو تاريخ نهاية التعاقد مع البنك علي هذا التسهيل (القرض)
	 * * ولكن عند نهاية هذا التاريخ يظل 
	 */
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
	/**
	 * * هو الحد الاقصى للسحب (اللي هو قيمة التسهيل) وبالتالي ما تقدرتش عموما تتخطى هذا الرقم
	 */
	public function getLimit()
	{
		return $this->limit ?: 0 ;
	}
	/**
	 * * هو قيمة المسحوب من هذا التسهيل لحظه فتح الحساب علي السيستم (كاش فيرو)
	 * * وهو بالتالي يعتبر ال
	 * * beginning balance 
	 * * اللي بتبدا بيه
	 */
	public function getOutstandingBalance()
	{
		return $this->outstanding_balance ?: 0 ;
	}
	
	public function getInterestRate()
	{
		return $this->interest_rate?:0;
	}
	public function getInterestRateFormatted()
	{
		return number_format($this->getInterestRate(),2);
	}
	public function getMaxLendingLimitPerCustomer()
	{
		return $this->max_lending_limit_per_customer?:0;
	}
	public static function findByFinancialInstitutionIds(array $cleanOverdraftIds):array
	{
		return self::where('financial_institution_id',$cleanOverdraftIds)->pluck('id')->toArray();
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
	public function getBorrowingRateFormatted()
	{
		return number_format($this->getBorrowingRate(),2);
	}
		/**
	 * * هي فايدة خاصة بالبنك بناء علي العميل (طبقا للقدرة المالية زي امتلاكك للمصانع)
	 */
	public function getMarginRate()
	{
		return $this->bank_margin_rate ?: 0 ;
	}
	public function getMarginRateFormatted()
	{
		return number_format($this->getMarginRate(),2);
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
		return self::where('company_id',$companyId)->where('currency',$currencyName)
		->where('financial_institution_id',$financialInstitutionId)
		->pluck('account_number','account_number')->toArray();		
	}
	
	public static function findByAccountNumber($accountNumber,int $companyId,int $financialInstitutionId)
	{
		return self::where('company_id',$companyId)
		->where('account_number',$accountNumber)
		->where('financial_institution_id',$financialInstitutionId)
		->first();
	}
}
