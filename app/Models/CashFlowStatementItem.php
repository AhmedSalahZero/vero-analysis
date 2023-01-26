<?php

namespace App\Models;

use App\Interfaces\Models\Interfaces\IFinancialStatementAbleItem;
use App\Models\Traits\Accessors\CashFlowStatementItemAccessor;
use App\Models\Traits\Relations\CashFlowStatementItemRelation;
use App\Models\Traits\Scopes\FinancialStatementAbleItemScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class  CashFlowStatementItem extends Model implements IFinancialStatementAbleItem
{
	protected $table = 'financial_statement_able_items';

	use  CashFlowStatementItemRelation, CashFlowStatementItemAccessor;
	const PERCENTAGE_OF_SALES = '[ % Of Sales ]';
	// must start from 1  not zero
	//  Net Profit 
	const NET_PROFIT_ID = 1;
	// const SALES_GROWTH_RATE_ID = 2;
	//  Depreciation Amount 
	const DEPRECIATION_AMOUNT = 3;
	// const COST_OF_GOODS_PERCENTAGE_OF_SALES_ID = 4;
	//  Cash Flow before Change In Working Capital 

	protected $guarded = [
		'id'
	];

	// public static function rateFieldsIds():array 
	// {
	//     return [
	//         self::SALES_GROWTH_RATE_ID,
	//         self::COST_OF_GOODS_PERCENTAGE_OF_SALES_ID,
	//         self::GROSS_PROFIT_PERCENTAGE_OF_SALES_ID,
	//         self::MARKET_EXPENSES_PERCENTAGE_OF_SALES_ID,
	//         self::SALES_AND_DISTRIBUTION_EXPENSES_PERCENTAGE_OF_SALES_ID,
	//         self::GENERAL_EXPENSES_PERCENTAGE_OF_SALES_ID,
	//         self::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_PERCENTAGE_OF_SALES_ID,
	//         self::EARNING_BEFORE_INTEREST_TAXES_PERCENTAGE_OF_SALES_ID,
	//         self::FINANCIAL_INCOME_OR_EXPENSE_PERCENTAGE_OF_SALES_ID,
	//         self::EARNING_BEFORE_TAXES_PERCENTAGE_OF_SALES_ID,
	//         self::CORPORATE_TAXES_PERCENTAGE_OF_SALES_ID,
	//         self::NEXT_PROFIT_PERCENTAGE_OF_SALES_ID,
	//     ];
	// }

	// public static function salesRateMap(): array
	// {
	//     return [
	//         self::COST_OF_GOODS_ID => self::COST_OF_GOODS_PERCENTAGE_OF_SALES_ID,
	//         self::GROSS_PROFIT_ID => self::GROSS_PROFIT_PERCENTAGE_OF_SALES_ID,
	//         self::MARKET_EXPENSES_ID => self::MARKET_EXPENSES_PERCENTAGE_OF_SALES_ID,
	//         self::SALES_AND_DISTRIBUTION_EXPENSES_ID => self::SALES_AND_DISTRIBUTION_EXPENSES_PERCENTAGE_OF_SALES_ID,
	//         self::GENERAL_EXPENSES_ID => self::GENERAL_EXPENSES_PERCENTAGE_OF_SALES_ID,
	//         self::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_ID => self::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_PERCENTAGE_OF_SALES_ID,
	//         self::EARNING_BEFORE_INTEREST_TAXES_ID => self::EARNING_BEFORE_INTEREST_TAXES_PERCENTAGE_OF_SALES_ID,
	//         self::FINANCIAL_INCOME_OR_EXPENSE_ID => self::FINANCIAL_INCOME_OR_EXPENSE_PERCENTAGE_OF_SALES_ID,
	//         self::EARNING_BEFORE_TAXES_ID => self::EARNING_BEFORE_TAXES_PERCENTAGE_OF_SALES_ID,
	//         self::CORPORATE_TAXES_ID => self::CORPORATE_TAXES_PERCENTAGE_OF_SALES_ID,
	//         self::NEXT_PROFIT_ID => self::NEXT_PROFIT_PERCENTAGE_OF_SALES_ID,
	//     ];
	// }

	// // for database usage 
	// public static function getMainItems()
	// {
	//     return [
	//         'Sales Revenue' => [
	//             'id' => $salesRevenueId = self::SALES_REVENUE_ID,
	//             'hasSubItems' => true,
	//             'has_depreciation_or_amortization' => false,
	//             'is_main_for_all_calculations' => true // when it change , all remains rows in tables will also changes,
	//             , 'is_sales_rate' => false
	//         ], 'Sales Growth Rate %' => [
	//             'id' => self::SALES_GROWTH_RATE_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes,
	//             , 'is_sales_rate' => false,
	//             'depends_on' => [$salesRevenueId]
	//         ],
	//         'Cost Of Goods / Service Sold' => [
	//             'id' => $costOfGoodsId = self::COST_OF_GOODS_ID,
	//             'hasSubItems' => true,
	//             'has_depreciation_or_amortization' => true,
	//             'is_main_for_all_calculations' => true // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false
	//         ],
	//         'Cost Of Goods / Service Sold ' . self::PERCENTAGE_OF_SALES => [
	//             'id' => $costOfGoodsId = self::COST_OF_GOODS_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'has_depreciation_or_amortization' => false,
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],
	//         'Gross Profit' => [
	//             'id' => $grossProfitId = self::GROSS_PROFIT_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId, $costOfGoodsId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false
	//         ],
	//         'Gross Profit ' . self::PERCENTAGE_OF_SALES => [
	//             'id' => self::GROSS_PROFIT_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],
	//         'Marketing Expenses' => [
	//             'id' => $marketExpensesId = self::MARKET_EXPENSES_ID,
	//             'hasSubItems' => true,
	//             'has_depreciation_or_amortization' => true,
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false

	//         ],
	//         'Marketing Expenses ' . self::PERCENTAGE_OF_SALES => [
	//             'id' => self::MARKET_EXPENSES_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],
	//         'Sales & Distribution Expenses' => [
	//             'id' => $salesAndDistributionExpensesId = self::SALES_AND_DISTRIBUTION_EXPENSES_ID,
	//             'hasSubItems' => true,
	//             'has_depreciation_or_amortization' => true,
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false

	//         ],
	//         'Sales & Distribution Expenses ' . self::PERCENTAGE_OF_SALES => [
	//             'id' => self::SALES_AND_DISTRIBUTION_EXPENSES_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],
	//         'General Expenses' => [
	//             'id' => $generalExpensesID = self::GENERAL_EXPENSES_ID,
	//             'hasSubItems' => true,
	//             'has_depreciation_or_amortization' => true,
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false

	//         ],
	//         'General Expenses ' . self::PERCENTAGE_OF_SALES => [
	//             'id' =>  self::GENERAL_EXPENSES_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],
	//         'Earning Before Interest Taxes Depreciation Amortization - EBITDA' => [
	//             'id' => $earningBeforeInterestTaxesDepreciationAmortizationId = self::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$grossProfitId, $marketExpensesId, $salesAndDistributionExpensesId, $generalExpensesID],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false

	//         ],
	//         'EBITDA ' . self::PERCENTAGE_OF_SALES => [
	//             'id' =>  self::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],
	//         'Earning Before Interest Taxes - EBIT' => [
	//             'id' => $earningBeforeInterestTaxesId = self::EARNING_BEFORE_INTEREST_TAXES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$earningBeforeInterestTaxesDepreciationAmortizationId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false

	//         ],
	//         'EBIT ' . self::PERCENTAGE_OF_SALES => [
	//             'id' =>  self::EARNING_BEFORE_INTEREST_TAXES_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],

	//         'Finance Income / (Expenses)' => [
	//             'id' => $financialIncomeOrExpense = self::FINANCIAL_INCOME_OR_EXPENSE_ID,
	//             'hasSubItems' => true,
	//             'has_depreciation_or_amortization' => false,
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false

	//         ],
	//         'Finance Income / (Expenses) ' . self::PERCENTAGE_OF_SALES => [
	//             'id' =>  self::FINANCIAL_INCOME_OR_EXPENSE_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],
	//         'Earning Before Taxes - EBT' => [
	//             'id' =>   $earningBeforeTaxesId = self::EARNING_BEFORE_TAXES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$financialIncomeOrExpense, $earningBeforeInterestTaxesId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false

	//         ],
	//         'EBT ' . self::PERCENTAGE_OF_SALES => [
	//             'id' =>  self::EARNING_BEFORE_TAXES_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],
	//         'Corporate Taxes' => [
	//             'id' => $corporateTaxesID = self::CORPORATE_TAXES_ID,
	//             'hasSubItems' => true,
	//             'has_depreciation_or_amortization' => false,
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false

	//         ],
	//         'Corporate Taxes ' . self::PERCENTAGE_OF_SALES => [
	//             'id' =>  self::CORPORATE_TAXES_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],
	//         'Net Profit' => [
	//             'id' => self::NEXT_PROFIT_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$corporateTaxesID, $earningBeforeTaxesId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => false
	//         ],
	//         'Net Profit ' . self::PERCENTAGE_OF_SALES => [
	//             'id' =>  self::NEXT_PROFIT_PERCENTAGE_OF_SALES_ID,
	//             'hasSubItems' => false,
	//             'has_depreciation_or_amortization' => false,
	//             'depends_on' => [$salesRevenueId],
	//             'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
	//             , 'is_sales_rate' => true
	//         ],
	//     ];
	// }

	public static function formattedViewForDashboard(): array
	{
		return CashFlowStatementItem::where('for_interval_comparing', 1)->pluck('name', 'id')->toArray();
	}

	public static function compareBetweenTowItems(Collection $firstItems, array $firstIntervalOfDates, string $firstCashFlowStatementDurationType, Collection $secondItems, array $secondIntervalOfDates, string $secondCashFlowStatementDurationType): array
	{

		$firstItems = self::getItemsForInterval($firstItems, $firstIntervalOfDates, $firstCashFlowStatementDurationType);
		$secondItems = self::getItemsForInterval($secondItems, $secondIntervalOfDates, $secondCashFlowStatementDurationType);
		$firstIntervalDate  = $firstIntervalOfDates[0] . '/' . $firstIntervalOfDates[count($firstIntervalOfDates) - 1];
		$secondIntervalDate  = $secondIntervalOfDates[0] . '/' . $secondIntervalOfDates[count($secondIntervalOfDates) - 1];
		// dd($firstIntervalDate);
		if (secondIntervalGreaterThanFirst($firstIntervalDate, $secondIntervalDate)) {
			return [
				'second-interval#' . $secondIntervalDate => sum_each_key($secondItems),
				'first-interval#' . $firstIntervalDate => sum_each_key($firstItems),
			];
		} else {
			return [
				'first-interval#' . $firstIntervalDate => sum_each_key($firstItems),
				'second-interval#' . $secondIntervalDate => sum_each_key($secondItems)
			];
		}
	}
	public static function getItemsForInterval(Collection $items, array $dates, $intervalName): array
	{
		// $items must be a collection 
		// dd($dates);

		$firstDate = Carbon::make($dates[\array_key_first($dates)]);
		$lastDate = Carbon::make($dates[\array_key_last($dates)]);

		$filteredItems = [];

		foreach ($items as $item) {
			$payload = json_decode($item->payload);
			foreach ($payload as $payloadDate => $payloadItem) {
				$payloadDateFormatted = Carbon::make($payloadDate);
				if ($intervalName == 'annually' && yearInArray($payloadDate, $dates)) {
					$filteredItems[$item->sub_item_name][$payloadDate] = $payloadItem;
				} elseif (
					dateIsBetweenTwoDates($payloadDateFormatted, $firstDate, $lastDate)
				) {
					$filteredItems[$item->sub_item_name][$payloadDate] = $payloadItem;
				}
			}
		}
		return $filteredItems;
	}
	protected static function booted()
	{
		static::addGlobalScope(function (Builder $builder) {
			$builder->where('financial_statement_able_type', 'CashFlowStatement');
		});
	}
}