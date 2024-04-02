<?php

namespace App\Models;

use App\Models\Partner;
use App\Traits\HasBasicStoreRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
	use HasBasicStoreRequest;
	
	public static function boot()
    {
        parent::boot();
        self::saving(function($model){
			$model->end_date = $model->start_date && $model->duration ? Carbon::make($model->start_date)->addMonths($model->duration)->format('Y-m-d') : null;  
        });

    }
	protected $guarded = ['id'];
	public function getId()
	{
		return $this->id ;
	}
	public function client()
	{
		return $this->belongsTo(Partner::class,'partner_id','id');
	}
	public function getClientName()
	{
		return $this->client ? $this->client->getName() :__('N/A');
	}
	public function getName()
	{
		return $this->name ;
	}
	public function getCode()
	{
		return $this->code ;
	}
	public function getStartDate()
	{
		return $this->start_date; 
	}
	public function getStartDateFormatted()
	{
		$date = $this->getStartDate() ;
		return $date ? Carbon::make($date)->format('d-m-Y'):null ;
	}
	public function setStartDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['start_date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		
		$this->attributes['start_date'] = $year.'-'.$month.'-'.$day;
	}
	public function getDuration()
	{
		return $this->duration ;
	}
	
	public function getEndDate()
	{
		return $this->end_date ;
	}
	public function getEndDateFormatted()
	{
		$date = $this->getEndDate() ;
		return $date ? Carbon::make($date)->format('d-m-Y'):null ;
	}
	
	public function getAmount()
	{
		return $this->amount?:0 ;
	}
	public function getAmountFormatted()
	{
		return number_format($this->getAmount(),0);
	}
	public function getCurrency()
	{
		return $this->currency;
	}
	public function salesOrders()
	{
		return $this->hasMany(SalesOrder::class,'contract_id','id');
	}
	public function purchasesOrders()
	{
		return $this->hasMany(PurchaseOrder::class,'contract_id','id');
	}
	public function forCustomer()
	{
		return $this->model_type === 'Customer';
	}
	public function forSupplier()
	{
		return $this->model_type === 'Supplier';
	}
	/**
	 * * اما 
	 * *sales order or purchase order
	 */
	public function getOrders()
	{
		return $this->forSupplier() ? $this->purchasesOrders() : $this->salesOrders() ;
	}
	
	public function letterOfGuaranteeIssuances()
	{
		return $this->hasMany(LetterOfGuaranteeIssuance::class , 'contract_id','id');
	}
	public function scopeOnlyForCompany(Builder $builder , int $companyId)
	{
		return $builder->where('company_id',$companyId);
	}	
	public function getExchangeRate()
	{
		return $this->exchange_rate ?: 1 ;
	}
	
	
}
