<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  MicrofinanceProductMixBranchAllocation extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy;
	protected $connection= 'non_banking_service';
	protected $guarded = ['id'];
	protected $casts = [
		'existing_allocations'=>'array',
		'new_allocations'=>'array',
		'existing_names'=>'array',
		'new_names'=>'array',
		];
	
	// public function getBankLendingMarginRatesAtYearOrMonthIndex(int $yearOrMonthIndex)
	// {
	// 	return $this->getBankLendingMarginRates()[$yearOrMonthIndex] ?? 0  ; 
	// }
	// public function getCreditInterestRateForSurplusCashAtYearOrMonthIndex(int $yearOrMonthIndex)
	// {
	// 	return $this->credit_interest_rate_for_surplus_cash[$yearOrMonthIndex] ?? 0  ; 
	// }
	
		
}
