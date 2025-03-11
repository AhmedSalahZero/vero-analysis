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
		'monthly_amounts'=>'array',
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
	public function getItemCost()
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
	public function getContingencyRate()
	{
		return $this->contingency_rate?:0;
	}
	public function getDepreciationDuration():int
	{
		return $this->depreciation_duration ;
	}
	public function getDepreciationDurationInMonths():int 
	{
		return $this->getDepreciationDuration() * 12 ;
	}
	public function getPaymentTerm()
	{
		return $this->payment_terms ;
	}
	public function getReplacementInterval()
	{
		return $this->replacement_interval ;
	}
	public function getReplacementIntervalInMonths()
	{
		return $this->getReplacementInterval() * 12 ;
	}
	public function getTotalCost()
	{
		return (1+($this->getContingencyRate()/100))*$this->getItemCost();
	}
	
	public function getMonthlyAmounts():array 
	{
		return (array)$this->monthly_amounts;
	}
	public function getPurchaseDates(array $dateIndexWithDate):array 
	{
		// $dateAsIndexString = app('dateIndexWithDate');
		// dd($dateIndexWithDate);
		
		$dates= [];
		$ffeCounts = $this->getFfeCounts();
		foreach($ffeCounts as $dateAsIndex => $ffeCount){
			if($ffeCount > 0){
				$dates[$dateAsIndex] = $dateIndexWithDate[$dateAsIndex]  ;
			}
		}
		return $dates ; 
	}
	public function getMonthlyAmountAtMonthIndex(int $dateAsIndex)
	{
		return $this->getMonthlyAmounts()[$dateAsIndex] ?? 0 ;  
	}
	public function getFfeCountsAtDateIndex(int $dateIndex)
	{
		return $this->getFfeCounts()[$dateIndex]??0;
	}
	public function getFfeCounts():array 
	{
		logger('salah');
		return (array)$this->ffe_counts;  
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
