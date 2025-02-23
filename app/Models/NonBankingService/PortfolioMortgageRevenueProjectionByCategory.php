<?php
namespace App\Models\NonBankingService;

use App\Models\Company;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Models\Traits\Scopes\CompanyScope;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  PortfolioMortgageRevenueProjectionByCategory extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy ;
	protected $connection= 'non_banking_service';

	protected $guarded = ['id'];
	protected $casts =[
		'growth_rates'=>'array',
		'portfolio_mortgage_transactions_projections'=>'array',
		'monthly_due_cheques_percentages'=>'array',
		'quarterly_due_cheques_percentages'=>'array',
		'annually_due_cheques_percentages'=>'array',
	];
	public function getViewVars(Company $company, Study $study):array{
		$portfolioMortgageEclAndNewPortfolioFundingRate = $study?  $study->portfolioMortgageEclAndNewPortfolioFundingRate : null;
		return [
			'company'=>$company ,
			'study'=>$study,
			'model'=>$study ,
			'portfolioMortgageEclAndNewPortfolioFundingRate'=>$portfolioMortgageEclAndNewPortfolioFundingRate,
			'title'=>__('Portfolio Mortgage Revenue Stream Breakdown'),
			'storeRoute'=>route('store.portfolio.mortgage.revenue.stream.breakdown',['company'=>$company->id , 'study'=>$study->id]),
			'yearsWithItsMonths' => $study->getOperationDurationPerYearFromIndexes(),
		];
	}
	public function getFormName():string
	{
		return 'non_banking_services.portfolio-mortgage-revenue-stream-breakdown.form';
	}
	
	public function getPortfolioMortgageTransactionProjectionAtYearIndex(int $yearIndex)
	{
		return $this->portfolio_mortgage_transactions_projections[$yearIndex] ?? 0  ; 
	}
	public function getGrowthRateAtYearIndex(int $yearIndex)
	{
		return $this->growth_rates[$yearIndex] ?? 0  ; 
	}
	public function getMonthlyMarginRate()
	{
		return $this->monthly_margin_rate ?: 0;
	}
	public function getQuarterlyMarginRate()
	{
		return $this->quarterly_margin_rate ?: 0;
	}
	public function getAnnuallyMarginRate()
	{
		return $this->annually_margin_rate ?: 0;
	}
	public function getMonthlyDueChequesPercentagesAtYearIndex(int $yearIndex)
	{
		return $this->monthly_due_cheques_percentages[$yearIndex] ?? 0  ; 
	}
	public function getQuarterlyDueChequesPercentagesAtYearIndex(int $yearIndex)
	{
		return $this->quarterly_due_cheques_percentages[$yearIndex] ?? 0  ; 
	}
	public function getAnnuallyDueChequesPercentagesAtYearIndex(int $yearIndex)
	{
		return $this->annually_due_cheques_percentages[$yearIndex] ?? 0  ; 
	}	
}
