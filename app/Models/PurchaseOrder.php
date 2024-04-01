<?php

namespace App\Models;

use App\Traits\Models\IsOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
	protected $guarded = ['id'];
	
	use IsOrder ;
	
	
	public function getName()
	{
		return $this->name ;
	}
	public function letterOfGuaranteeIssuances()
	{
		return $this->hasMany(LetterOfGuaranteeIssuance::class , 'purchase_order_id','id');
	}
	public function scopeOnlyForCompany(Builder $builder , int $companyId)
	{
		return $builder->where('company_id',$companyId);
	}	
	
	
	
}
