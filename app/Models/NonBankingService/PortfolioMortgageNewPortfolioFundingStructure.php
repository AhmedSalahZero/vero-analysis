<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  PortfolioMortgageNewPortfolioFundingStructure extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy ;
	protected $connection= 'non_banking_service';
	protected $table='portfolio_mortgage_new_portfolio_funding_structures';
	protected $guarded = ['id'];
	protected $casts =[
		'equity_funding_rates'=>'array',
		'equity_funding_values'=>'array',
		'new_loans_funding_rates'=>'array',
		'new_loans_funding_values'=>'array',
	];
	public function getEquityFundingRatesAtYearOrMonthIndex(int $yearOrMonthAsIndex)
	{
		return $this->equity_funding_rates[$yearOrMonthAsIndex] ?? 0  ; 
	}
	public function getEquityFundingValuesAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->equity_funding_values[$yearOrMonthIndex] ?? 0  ; 
	}
	public function getNewLoansFundingRatesAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->new_loans_funding_rates[$yearOrMonthIndex] ?? 0  ; 
	}
	public function getNewLoansFundingValuesAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->new_loans_funding_values[$yearOrMonthIndex] ?? 0  ; 
	}
}
