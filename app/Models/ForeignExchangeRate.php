<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ForeignExchangeRate extends Model
{
	protected $guarded = [
		'id'
	];
	public function company()
	{
		return $this->belongsTo(Company::class , 'company_id','id');
	}
	
	public function getDate()
    {
        return $this->date ;
    }
	public function getDateFormatted()
    {
		$date = $this->getDate() ;
        return $date ? Carbon::make($date)->format('d-m-Y') : null   ;
    }
	public function setDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		
		$this->attributes['date'] = $year.'-'.$month.'-'.$day;
	}
	public function getDateFormattedForDatePicker()
	{
		$date = $this->getDate();
		return $date ? Carbon::make($date)->format('m/d/Y') : null;
	}
	public function getExchangeRate()
	{
		return $this->exchange_rate?:1 ;
	}
	public function getExchangeRateFormatted()
	{
		return number_format($this->getExchangeRate()) ;
	}
	public function getFromCurrency()
	{
		return $this->from_currency; 
	}
	public function getToCurrency()
	{
		return $this->to_currency; 
	}
	
	
}
