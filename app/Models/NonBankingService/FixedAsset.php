<?php

namespace App\Models\NonBankingService;

use App\Models\Company;
use App\Models\Traits\Scopes\BelongsToCompany;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use Illuminate\Database\Eloquent\Model;

class FixedAsset extends Model
{
	use BelongsToStudy,BelongsToCompany;
	protected $guarded = ['id'];
	protected $connection ='non_banking_service';
	protected $casts = [
		'ffe_counts'=>'array',
	];
		
	public function company()
	{
		return $this->belongsTo(Company::class , 'company_id','id');
	}
	public function model()
	{
		$modelName = '\App\Models\\'.$this->model_name ;
		return $this->belongsTo($modelName , 'model_id','id');
		
	}
	public function getName()
	{
		return $this->name ;
	}
	public function getFfeItemCost()
	{
		return $this->ffe_item_cost;
	}
	public function getVatRate()
	{
		return $this->vat_rate ?: 0;
	}
	
	public function getWithholdTaxRate()
	{
		return $this->withhold_tax_rate?:0;
	}	
	public function getDepreciationDuration()
	{
		return $this->depreciation_duration ;
	}
	public function getPaymentTerm()
	{
		return $this->payment_terms ;
	}
	public function getReplacementInterval()
	{
		return $this->replacement_terms ;
	}
	public function getFfeCountsAtDateIndex(int $dateIndex)
	{
		return $this->ffe_counts[$dateIndex]??0;
	}
	public function getReplacementCostRate()
	{
		return $this->replacement_cost_rate ;
	}
	public function getCostAnnualIncreaseRate()
	{
		return $this->cost_annual_increase_rate ?: 0;
	}
	public function getPaymentRate(int $rateIndex){
		return array_values($this->custom_collection_policy ?? [])[$rateIndex] ?? 0 ;
	}
	public function getPaymentRateAtDueInDays($rateIndex)
	{
		return array_keys($this->custom_collection_policy ?? [])[$rateIndex] ?? 0 ; 
	}
}
