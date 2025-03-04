<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  MicrofinanceBreakdown extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy ;
	protected $connection= 'non_banking_service';

	protected $guarded = ['id'];
	protected $casts =[
		'contribution_percentages'=>'array',
		'decreasing_rates'=>'array',
		'flat_rates'=>'array',
		'loan_amounts'=>'array',
	];
	public function getContributionPercentageAtYearIndex(int $yearIndex)
	{
		return $this->contribution_percentages[$yearIndex] ?? 0  ; 
	}
	public function getMicrofinanceProductId()
	{
		return $this->microfinance_product_id;
	}
	public function getFlatRateAtYearIndex(int $yearIndex)
	{
		return $this->flat_rates[$yearIndex] ?? 0  ; 
	}
	public function getDecreasingRateAtYearIndex(int $yearIndex)
	{
		return $this->decreasing_rates[$yearIndex] ?? 0  ; 
	}
	public function getLoanAmountPayloadAtYearIndex(int $yearIndex)
	{
		return $this->loan_amounts[$yearIndex] ?? 0  ; 
	}
	public function getInstallmentInterval()
	{
		return $this->installment_interval;
	}
	public function getMarginRate()
	{
		return $this->margin_rate?:0;
	}
	public function getSensitivityMarginRate():float
	{
		return $this->sensitivity_margin_rate;
	}
	public function getReviewForTable()
	{
		return '-';
	}
	public function getTenor()
	{
		return $this->tenor?:0;
	}
	public function getGracePeriod()
	{
		return $this->grace_period?:0;
	}
	public function getStepUp()
	{
		return 0;
	}
	public function getStepDown()
	{
		return 0;
	}
	public function getStepInterval()
	{
		return 'annually';
	}
	public function getLoanType()
	{
		return 'normal';
	}
	
	public function getLoanNature()
	{
		return 'fixed-at-end';
	}
	public function isOda():bool
	{
		return !(bool)$this->is_funding_by_mtl  ;
	}
	public function isMtl():bool
	{
		return (bool)$this->is_funding_by_mtl  ;
	}
	
		
}
