<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  EclAndNewPortfolioFundingRate extends Model
{
	use HasBasicStoreRequest,CompanyScope,BelongsToStudy ;
	protected $connection= 'non_banking_service';
	protected $table = 'ecl_and_new_portfolio_funding_rates';
	protected $guarded = ['id'];
	protected $casts = [
		'admin_fees_rates'=>'array',
		'monthly_admin_fees_amounts'=>'array',
		'ecl_rates'=>'array',
		'equity_funding_rates'=>'array',
		'equity_funding_values'=>'array',
		'new_loans_funding_rates'=>'array',
		'new_loans_funding_values'=>'array',
	];
	public function getRevenueStreamType():string 
	{
		return $this->revenue_stream_type;
	}
	public function getAdminFeesRatesAtYearIndex(int $yearIndex)
	{
		return $this->admin_fees_rates[$yearIndex]??0;
	}
	public function getMonthlyAdminFeesAmountsAtMonthIndex(int $monthIndex)
	{
		return $this->monthly_admin_fees_amounts[$monthIndex] ?? 0  ; 
	}
	public function getEclRatesAtYearIndex(int $yearIndex)
	{
		return $this->ecl_rates[$yearIndex]??0;
	}
	public function getEquityFundingRatesAtYearIndex(int $yearIndex)
	{
		return $this->equity_funding_rates[$yearIndex]??0;
	}
	public function getEquityFundingValuesAtYearIndex(int $yearIndex)
	{
		return $this->equity_funding_values[$yearIndex]??0;
	}
	public function getNewLoansFundingRatesAtYearIndex(int $yearIndex)
	{
		return $this->new_loans_funding_rates[$yearIndex]??0;
	}
	public function getNewLoansFundingValuesAtYearIndex(int $yearIndex)
	{
		return $this->new_loans_funding_values[$yearIndex]??0;
	}
}
