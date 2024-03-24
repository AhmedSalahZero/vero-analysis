<?php

namespace App\Models;

use App\Models\Company;
use App\Models\MoneyReceived;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OpeningBalance extends Model
{
    protected $guarded = ['id'];
	
	public function getId()
	{
		return $this->id;
	}
	public function getDate()
	{
		return $this->date; 
	}
	
	public function company()
	{
		return $this->belongsTo(Company::class , 'company_id','id');
	}
	public function moneyReceived()
	{
		return $this->hasMany(MoneyReceived::class,'opening_balance_id');
	}
	public function cashInSafe()
	{
		return $this->hasMany(MoneyReceived::class,'opening_balance_id','id')->where('type',MoneyReceived::CASH_IN_SAFE);
	}
	
	public function chequeInSafe()
	{
		return $this->hasMany(MoneyReceived::class,'opening_balance_id','id')->where('type',MoneyReceived::CHEQUE)->whereHas('cheque',function(Builder $builder){
			$builder->where('status',Cheque::IN_SAFE);
		});
		
	}
	
	public function chequeUnderCollections()
	{
		return $this->hasMany(MoneyReceived::class,'opening_balance_id','id')->where('type',MoneyReceived::CHEQUE)->whereHas('cheque',function(Builder $builder){
			$builder->where('status',Cheque::UNDER_COLLECTION);
		});
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


	
	
	
}
