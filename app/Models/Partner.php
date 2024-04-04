<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $dates = [
    ];
	public function contracts()
	{
		return $this->hasMany(Contract::class,'partner_id','id');
	}

    protected $guarded = [];


    /**
     * The table associated with the model.
     *
     * @var string
     */
	public function getId(){
		return $this->id ;
	}
	public function getName()
	{
		return $this->name ;
	}
	public function getCustomerName()
	{
		return $this->getName();
	}
	public function scopeOnlyCompany(Builder $query,$companyId){
		return $query->where('company_id',$companyId);
	}
	public function scopeOnlyForCompany(Builder $query,$companyId){
		return $query->where('company_id',$companyId);
	}
	public function scopeOnlyCustomers(Builder $query){
		return $query->where(function($q){
			$q->where('is_customer',1);
		});
	}
	public function scopeOnlySuppliers(Builder $query){
		return $query->where(function($q){
			$q->where('is_supplier',1);
		});
	}
	public function unappliedAmounts()
	{
		return $this->hasMany(UnappliedAmount::class ,'partner_id','id');	
	}
	public function getUnappliedAmountsWithSettlements(string $startDate , string $endDate):Collection
	{
		return $this->unappliedAmounts->load('settlements')->has('settlements')->whereBetween('settlement_date',[$startDate,$endDate]);
	}
	public function isCustomer()
	{
		return $this->is_customer == 1 ;
	}
	
	public function isSupplier()
	{
		return $this->is_supplier == 1 ;
	}
	
	public function settlementForUnappliedAmounts()
	{
		if($this->isCustomer()){
			return $this->hasMany(Settlement::class,'customer_name','name')->whereNotNull('unapplied_amount_id');
		}
		if($this->isSupplier()){
			return $this->hasMany(PaymentSettlement::class,'supplier_name','name')->whereNotNull('unapplied_amount_id');
		}
	}
	public function getSettlementForUnappliedAmounts(string $startDate , string $endDate)
	{
		return $this->settlementForUnappliedAmounts()
		->whereHas('unappliedAmount',function(Builder $q) use ($startDate,$endDate){
			$q->where('settlement_date','>=',$startDate)->where('settlement_date','<=',$endDate);
		})
		->get();
	}
	
}
