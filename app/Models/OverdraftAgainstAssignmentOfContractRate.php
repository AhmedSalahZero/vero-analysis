<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * * Rate هنا المقصود بيها
 * * margin rate and so on
 */
class OverdraftAgainstAssignmentOfContractRate extends Model  
{
    protected $guarded = [
        'id'
    ];
	
	/**
	 * * ال 
	 * * global scope 
	 * * دا خاص بس بجزئيه ال
	 * * commission 
	 * * ما عدا ذالك ملهوش اي لزمة هو والكولوم اللي اسمة
	 * * is_active
	 */
	protected static function boot()
    {
        parent::boot();

    }
	public function OverdraftAgainstAssignmentOfContract()
	{
		return $this->belongsTo(OverdraftAgainstAssignmentOfContract::class,'overdraft_against_assignment_of_contract_id','id');
	}
	public function overdraftModal()
	{
		return $this->OverdraftAgainstAssignmentOfContract(); 
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
	public function getBorrowingRate()
	{
		return $this->borrowing_rate?:0;
	}
	public function getBorrowingRateFormatted()
	{
		return number_format($this->getBorrowingRate(),1) . ' %';
	}
	public function getMarginRate()
	{
		return $this->margin_rate?:0;
	}
	public function getMarginRateFormatted()
	{
		return number_format($this->getMarginRate(),1) . ' %';
	}
	public function getMinInterestRate()
	{
		return $this->min_interest_rate?:0;
	}
	public function getInterestRate()
	{
		return $this->interest_rate?:0;
	}
	public function getInterestRateFormatted()
	{
		return number_format($this->getInterestRate(),1) . ' %';
	}
	
}
