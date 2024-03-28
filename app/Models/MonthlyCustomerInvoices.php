<?php

namespace App\Models;

use App\Traits\StaticBoot;
use Carbon\Carbon;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MonthlyCustomerInvoices extends Model
{
    use StaticBoot;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    
    protected $dates = [
    
    ];

    protected $guarded = [];


    //  protected $connection= 'mysql2';
    // protected $table = 'sales_gathering';
    // protected $primaryKey  = 'user_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
	
	 protected static function booted()
	 {
		 static::addGlobalScope('delete', function (Builder $builder) {
			 $builder->where('company_id', getCurrentCompanyId());
		 });
	 }
	 
    public function scopeCompany($query)
    {
        return $query->where('company_id', request()->company->id?? Request('company_id'));
    }
	public function customerInvoice()
	{
		return $this->belongsTo(CustomerInvoice::class,'customer_name','customer_name');
	}
	public function getBeginningBalance()
	{
		return $this->beginning_balance;
	}
	public function getMonthlyDebit()
	{
		return $this->monthly_debit;
	}
	public function getMonthlyCredit()
	{
		return $this->monthly_credit;
	}
	public function getEndBalance()
	{
		return $this->end_balance;
	}
	
	
	
}
