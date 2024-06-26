<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * * هو عباره عن الفلوس الزيادة المتبقيه من ال 
 * * money received
 * * بعد اما عملت settlements 
 * * وليكن مثلا استلمت مليون جنيه وستلت نص مليون كدا فاضل 
 * * unapplied
 * * عباره عن نص مليون
 */
class UnappliedAmount extends Model
{
    protected $dates = [
    ];
	
    protected $guarded = [];


    /**
     * The table associated with the model.
     *
     * @var string
     */
	public function getId(){
		return $this->id ;
	}
	public function scopeOnlyCompany(Builder $query,$companyId){
		return $query->where('company_id',$companyId);
	}
	public function partner()
	{
		return $this->belongsTo(Partner::class,'partner_id','id');
	}
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class , 'money_received_id','id');
	}
	public function setSettlementDateAttribute($value)
	{
		if(is_object($value)){
			return $value ;
		}
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['settlement_date'] = $value;
			return  ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$this->attributes['settlement_date'] = $year.'-'.$month.'-'.$day;
		
	}
	public function settlements()
	{
		return $this->hasMany(Settlement::class,'unapplied_amount_id','id');
	}
	public function paymentSettlements()
    {
        return $this->hasMany(PaymentSettlement::class, 'unapplied_amount_id', 'id');
    }
	
	
}
