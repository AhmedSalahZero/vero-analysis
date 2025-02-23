<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Models\Traits\Scopes\CompanyScope;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  IjaraMortgageNewPortfolioFundingStructure extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy ;
	protected $connection= 'non_banking_service';
	protected $table='ijara_mortgage_new_portfolio_funding_structures';
	protected $guarded = ['id'];
	protected $casts =[
		'equity_funding_rates'=>'array',
		'equity_funding_values'=>'array',
		'new_loans_funding_rates'=>'array',
		'new_loans_funding_values'=>'array',
	];
	public function getEquityFundingRatesAtYearIndex(int $yearIndex)
	{
		return $this->equity_funding_rates[$yearIndex] ?? 0  ; 
	}
	public function getEquityFundingValuesAtYearIndex(int $yearIndex)
	{
		return $this->equity_funding_values[$yearIndex] ?? 0  ; 
	}
	public function getNewLoansFundingRatesAtYearIndex(int $yearIndex)
	{
		return $this->new_loans_funding_rates[$yearIndex] ?? 0  ; 
	}
	public function getNewLoansFundingValuesAtYearIndex(int $yearIndex)
	{
		return $this->new_loans_funding_values[$yearIndex] ?? 0  ; 
	}
}
