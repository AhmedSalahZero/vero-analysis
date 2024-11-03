<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InvoiceDeduction extends Model
{
	protected $guarded = [
		'id'
	];
	public function company()
	{
		return $this->belongsTo(Company::class , 'company_id','id');
	}
	public function customerInvoice()
	{
		return $this->belongsTo(CustomerInvoice::class,'model_id','id')->where('model_type','CustomerInvoice');
	}
	public function supplierInvoice()
	{
		return $this->belongsTo(SupplierInvoice::class,'customer_invoice_id','id')->where('model_type','SupplierInvoice');
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
	public function getDueDateFormattedForDatePicker()
	{
		$date = $this->getDate();
		return $date ? Carbon::make($date)->format('m/d/Y') : null;
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
	
}
