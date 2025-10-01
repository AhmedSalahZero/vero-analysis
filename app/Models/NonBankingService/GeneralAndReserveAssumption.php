<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  GeneralAndReserveAssumption extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy;
	protected $connection= 'non_banking_service';
	protected $guarded = ['id'];
	protected $casts = [
		'employee_profit_share_rates'=>'array',
		'border_of_directors_profit_share_rates'=>'array',
		'shareholders_first_dividend_portions'=>'array',
		'shareholders_dividend_payout_ratios'=>'array',
		'shareholders_dividend_in_cash_or_shares'=>'array',
		'salaries_annual_increase_rates'=>'array',
		// 'expense_annual_increase_rates'=>'array',
		'cbe_lending_corridor_rates'=>'array',
		'bank_lending_margin_rates'=>'array',
		'credit_interest_rate_for_surplus_cash'=>'array',
		];
		
		
		public static function boot()
		{
			parent::boot();
			
			static::updated(function(self $generalAndReserveAssumption){
				$study = $generalAndReserveAssumption->study ;
				/**
				 * @var Study $study 
				 */
				if($generalAndReserveAssumption->isDirty('cbe_lending_corridor_rates') || $generalAndReserveAssumption->isDirty('bank_lending_margin_rates')){
					
					$study->storeFixedLoans(Study::LEASING,'leasingRevenueStreamBreakdown');
					$study->storeFixedLoans(Study::IJARA,'ijaraMortgageBreakdowns');
					$study->storeVariableLoans(Study::REVERSE_FACTORING,'reverseFactoringBreakdowns');
					$study->refreshDirectFactoringLoans();
					$study->updateExpensesPercentagesOfSales();
				}
				if($study->isDirty('salaries_annual_increase_rates')){
					$study->recalculateManpower();
				 } 
			});
		}
		
	public function getEmployeeProfitShareRatesAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->employee_profit_share_rates[$yearOrMonthIndex] ?? 0  ; 
	}
	public function getBorderOfDirectorsProfitShareRateAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->border_of_directors_profit_share_rates[$yearOrMonthIndex] ?? 0  ; 
	}
	public function getShareholderFirstDividendPortionAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->shareholders_first_dividend_portions[$yearOrMonthIndex] ?? 0  ; 
	}
	public function getShareholderDividendPayoutRatioAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->shareholders_dividend_payout_ratios[$yearOrMonthIndex] ?? 0  ; 
	}
	public function getShareholderDividendInCashOrSharesAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->shareholders_dividend_in_cash_or_shares[$yearOrMonthIndex] ?? 0  ; 
	}
	public function getSalariesAnnualIncreaseRateAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->salaries_annual_increase_rates[$yearOrMonthIndex] ?? 0  ; 
	}
	// public function getExpenseAnnualIncreaseRateAtYearOrMonthIndex(int $yearOrMonthIndex)
	// {
	// 	return $this->expense_annual_increase_rates[$yearOrMonthIndex] ?? 0  ; 
	// }
	
	public function getCbeLendingCorridorRatesAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->cbe_lending_corridor_rates[$yearOrMonthIndex] ?? 0  ; 
	}
	public function getCbeLendingCorridorRates():array 
	{
		return $this->cbe_lending_corridor_rates ;
	}
	public function getBankLendingMarginRates():array 
	{
		return (array) $this->bank_lending_margin_rates ; 
	}
	public function getBankLendingMarginRatesAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->getBankLendingMarginRates()[$yearOrMonthIndex] ?? 0  ; 
	}
	public function getCreditInterestRateForSurplusCashAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->credit_interest_rate_for_surplus_cash[$yearOrMonthIndex] ?? 0  ; 
	}
	
	
	public function getLegalReserveRate()
	{
		return $this->legal_reserve_rate ?: 0;
	}
	public function getLegalReserveRateFormatted():string 
	{
		return number_format($this->getLegalReserveRate(),2);
	}
	public function getMaxLegalReserveRate()
	{
		return $this->max_legal_reserve_rate ?: 0;
	}
	public function getMaxLegalReserveRateFormatted():string 
	{
		return number_format($this->getMaxLegalReserveRate(),2);
	}
	public function getFinancialRegulatoryAuthorityRate()
	{
		return $this->financial_regulatory_authority_rate ?: 0;
	}
	public function getFinancialRegulatoryAuthorityRateFormatted():string 
	{
		return number_format($this->getFinancialRegulatoryAuthorityRate(),2);
	}
	public function getMaxFinancialRegulatoryAuthorityRate()
	{
		return $this->max_financial_regulatory_authority_rate ?: 0;
	}
	public function getMaxFinancialRegulatoryAuthorityRateFormatted():string 
	{
		return number_format($this->getMaxFinancialRegulatoryAuthorityRate(),2);
	}
	
		
}
