<?php

namespace App\Models;

use App\Models\FinancialInstitutionAccount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
	 * * توفر شهادات الإيداع ) (CDsللمدخر ين طر يقة لكسب معدل فائدة أعلى على مدخراتك مقابل الموافقة على حجز
	**    أموالك لفترة زمنية محددة - مع الحفاظ على أموالك آمنة بفضل حمايتها من البنك المركزي 	
	 */
class CertificatesOfDeposit extends Model
{
	
    protected $guarded = ['id'];
	public function getStartDate()
	{
		return $this->start_date;
	}
	public function getStartDateFormatted()
	{
		$startDate = $this->start_date ;
		return $startDate ? Carbon::make($startDate)->format('d-m-Y'):null ;
	}
	/**
	 * * تاريخ استحقاق الايداع بس مش شرط يكون هو دا الفعلي لو التاريخ دا كان يوم جمعه مثلا فاهيكون اجازة 
	 */
	public function getEndDate()
	{
		return $this->end_date;
	}
	/**
	 * * لما يتم تاكيد العمليه وقتها الفلوس الخاصة بالوديعه دي هتنزل علي انهي حساب ؟
	 */
	public function getMaturityAmountAddedToAccountId():int
	{
		return $this->maturity_amount_added_to_account_id ; 
	}
	public function getMaturityAmountAddedToAccount():BelongsTo
	{
		return $this->belongsTo(FinancialInstitutionAccount::class,'maturity_amount_added_to_account_id','id');
	}
	
	public function getEndDateFormatted()
	{
		$endDate = $this->getStartDate() ;
		return $endDate ? Carbon::make($endDate)->format('d-m-Y'):null ;
	}
	public function getAccountNumber()
	{
		return $this->account_number ;
	}
	
	public function getAmount()
	{
		return $this->amount ;
	}
	public function getAmountFormatted()
	{
		$amount = $this->getAmount();
		return number_format($amount) ;
	}
	
	public function getInterestRate()
	{
		return $this->interest_rate?:0;
	}
	
	public function getInterestRateFormatted()
	{
		return $this->getInterestRate() .' %';
	}
	
		
	public function getInterestAmount()
	{
		return $this->interest_amount?:0;
	}
	
	public function getInterestAmountFormatted()
	{
		$interestAmount = $this->getInterestAmount();
		return number_format($interestAmount,0); 
	}
	
	public function getCurrency()
	{
		return $this->currency ;
	}
	public function financialInstitution()
	{
		return $this->belongsTo(FinancialInstitution::class , 'financial_institution_id','id');
	}
}
