<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * * هو نوع من انواع حسابات التسهيل البنكية (زي القرض يعني بس فية فرق بينهم ) وبيسمى حد جاري مدين بدون ضمان
 * * بدون ضمان يعني مش بياخدوا مقابل قصادة يعني مثلا مش بياخدوا منك شيكات مثلا او بيت .. الخ علشان كدا اسمه كلين
 * * والفرق بينه وبين القرض ان هنا انت مش ملتزم تسدد مبلغ معين في فتره معين اي لا  يوجد اقساط للدفع
 * * وبناء عليه كل اما قللت التسديد كل اما هينزل عليك فايدة اكبر الشهر الجاي
 * * وعموما في حالة انك مدان للبنك وليكن مثلا لو انت سالف من البنك عشر الالف وسحبت تسعه ونزل عليك فايدة خمس مئة جنية
 * * وقتها ال خمس مئة جنية دول بينسحبوا من حسابك علطول وبالتالي انت ما عتش فاضلك غير خمس مئة مثلا
 */
class CleanOverdraft extends Model
{
    protected $guarded = ['id'];
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
	public static function getAllAccountNumberForCurrency($companyId , $currencyName,$financialInstitutionId):array
	{
		return self::where('company_id',$companyId)->where('currency',$currencyName)
		->where('financial_institution_id',$financialInstitutionId)
		->pluck('account_number','account_number')->toArray();		
	}

	
	
	
}
