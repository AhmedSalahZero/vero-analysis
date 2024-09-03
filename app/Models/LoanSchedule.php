<?php

namespace App\Models;

use App\Traits\StaticBoot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoanSchedule extends Model
{
    use StaticBoot;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */

    protected $guarded = [];


    //  protected $connection= 'mysql2';
    // protected $table = 'sales_gathering';
    // protected $primaryKey  = 'user_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'loan_schedules';
	
    public function scopeCompany($query)
    {
        return $query->where('company_id', request()->company->id?? Request('company_id') );
    }
	private static function generateSubTabArr()
	{
		return [];
	}
	public function getMediumTermLoanName()
	{
		return $this->mediumTermLoan->getName();
	}
	public function getDate()
	{
		return $this->date ;
	}
	public function getDateFormatted()
	{
		$date = $this->getDate();
		return $date ? Carbon::make($date)->format('d-m-Y') : __('N/A'); 
	}
	public function getCurrency()
	{
		return $this->mediumTermLoan->currency ;
	}
	public function getBeginningBalance()
	{
		return $this->beginning_balance ?: 0 ;
	}
	public function getBeginningBalanceFormatted()
	{
		return number_format($this->getBeginningBalance())  ;
	}
	public function getSchedulePayment()
	{
		return $this->schedule_payment ?: 0 ;
	}
	public function getSchedulePaymentFormatted()
	{
		return number_format($this->getSchedulePayment())  ;
	}
	public function getInterestAmount()
	{
		return $this->interest_amount ?: 0 ;
	}
	public function getInterestAmountFormatted()
	{
		return number_format($this->getInterestAmount())  ;
	}
	public function getPrincipleAmount()
	{
		return $this->principle_amount ?: 0 ;
	}
	public function getPrincipleAmountFormatted()
	{
		return number_format($this->getPrincipleAmount())  ;
	}
	public function getEndBalance()
	{
		return $this->end_balance ?: 0 ;
	}
	public function getFinancialInstitutionId()
	{
		return $this->mediumTermLoan->financial_institution_id;
	}
	public function settlements():HasMany
	{
		return $this->hasMany(LoanScheduleSettlement::class,'loan_schedule_id');
	}
	public function getEndBalanceFormatted()
	{
		return number_format($this->getEndBalance())  ;
	}
	public function mediumTermLoan()
	{
		return $this->belongsTo(MediumTermLoan::class , 'medium_term_loan_id','id');
	}
	public static function getExportableFields():array 
	{
		return [
			'date'=>__('Date'),
			'beginning_balance'=>__('Beginning Balance'),
			'schedule_payment'=>__('Schedule Payment'),
			'interest_amount'=>__('Interest Amount'),
			'principle_amount'=>__('Principle Amount'),
			'end_balance'=>__('End Balance')
		];
	}
}
