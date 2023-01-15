<?php

namespace App\Models;

use App\Models\Traits\Accessors\BalanceSheetItemAccessor;
use App\Models\Traits\Relations\BalanceSheetItemRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class  BalanceSheetItem extends Model
{
    // Intangible Assets Gross Amount
    use  BalanceSheetItemRelation, BalanceSheetItemAccessor;
    const PERCENTAGE_OF_SALES = '[ % Of Sales ]';
    // must start from 1  not zero
    // Fixed Assets Gross Amount
    const FIXED_ASSETS_GROSS_AMOUNT_ID = 1;
    // const SALES_GROWTH_RATE_ID = 2;
    const NET_FIXED_ASSETS  = 3;
    // const COST_OF_GOODS_PERCENTAGE_OF_SALES_ID = 4;
    const INTANGIBLE_ASSETS_GROSS_AMOUNT = 5;
    // Intangible Assets Accumulated Depreciation Amount
    // const GROSS_PROFIT_PERCENTAGE_OF_SALES_ID = 6;
    const INTANGIBLE_ASSETS_ACCUMULATED_DEPRECIATION_AMOUNT = 7;
    // const MARKET_EXPENSES_PERCENTAGE_OF_SALES_ID = 8;
    // Net Intangible Assets
    const NET_INTANGIBLE_ASSETS = 9;
    // const SALES_AND_DISTRIBUTION_EXPENSES_PERCENTAGE_OF_SALES_ID = 10;
    // Other Long Term Assets
    const OTHER_LONG_TERM_ASSETS = 11;
    // const GENERAL_EXPENSES_PERCENTAGE_OF_SALES_ID = 12;
    const  CASH_AND_BANKS_ID = 13;
    // const EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_PERCENTAGE_OF_SALES_ID = 14;
    // Customers Receivables And Checks
    const CUSTOMERS_RECEIVABLES_AND_CHECKS = 15;
    // const EARNING_BEFORE_INTEREST_TAXES_PERCENTAGE_OF_SALES_ID = 16;
    const INVENTORY = 17;
    // const FINANCIAL_INCOME_OR_EXPENSE_PERCENTAGE_OF_SALES_ID = 18;
    // Other Debtors
    const OTHER_DEBTORS = 19;
    // const EARNING_BEFORE_TAXES_PERCENTAGE_OF_SALES_ID = 20;
    // Suppliers Payables And Checks
    const SUPPLIERS_PAYABLES_AND_CHECKS = 21;
    // const CORPORATE_TAXES_PERCENTAGE_OF_SALES_ID = 22;
    // Short Term Banking Facilities
    const SHORT_TERM_BANKING_FACULTIES = 23;
    // const NEXT_PROFIT_PERCENTAGE_OF_SALES_ID = 24;
// Current Portion Of Long Terms Banking Facilities
    const CURRENT_PORTION_OF_LONG_TERMS_BANKING_FACILITIES= 25;
    // Taxes And Social Insurance
    const TAXES_AND_SOCIAL_INSURANCE= 27;

    // Other Creditors
    const OTHER_CREDITORS= 29;
    // Long Terms Banking Facilities
    const LONG_TERMS_BANKING_FACILITIES = 31;
    // Other Long Terms Liabilities
    const OTHER_LONG_TERMS_LIABILITIES = 33;

    //  Total Long Terms Liabilities 
    const TOTAL_LONG_TERMS_LIABILITIES = 35;

   //  Shareholders Equity 
    const SHAREHOLDERS_EQUITY = 37;
    
    protected $guarded = [
        'id'
    ];

    public static function rateFieldsIds():array 
    {
        return [
            self::SALES_GROWTH_RATE_ID,
            self::COST_OF_GOODS_PERCENTAGE_OF_SALES_ID,
            self::GROSS_PROFIT_PERCENTAGE_OF_SALES_ID,
            self::MARKET_EXPENSES_PERCENTAGE_OF_SALES_ID,
            self::SALES_AND_DISTRIBUTION_EXPENSES_PERCENTAGE_OF_SALES_ID,
            self::GENERAL_EXPENSES_PERCENTAGE_OF_SALES_ID,
            self::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_PERCENTAGE_OF_SALES_ID,
            self::EARNING_BEFORE_INTEREST_TAXES_PERCENTAGE_OF_SALES_ID,
            self::FINANCIAL_INCOME_OR_EXPENSE_PERCENTAGE_OF_SALES_ID,
            self::EARNING_BEFORE_TAXES_PERCENTAGE_OF_SALES_ID,
            self::CORPORATE_TAXES_PERCENTAGE_OF_SALES_ID,
            self::NEXT_PROFIT_PERCENTAGE_OF_SALES_ID,
        ];
    }

    public static function salesRateMap(): array
    {
        return [
            self::COST_OF_GOODS_ID => self::COST_OF_GOODS_PERCENTAGE_OF_SALES_ID,
            self::GROSS_PROFIT_ID => self::GROSS_PROFIT_PERCENTAGE_OF_SALES_ID,
            self::MARKET_EXPENSES_ID => self::MARKET_EXPENSES_PERCENTAGE_OF_SALES_ID,
            self::SALES_AND_DISTRIBUTION_EXPENSES_ID => self::SALES_AND_DISTRIBUTION_EXPENSES_PERCENTAGE_OF_SALES_ID,
            self::GENERAL_EXPENSES_ID => self::GENERAL_EXPENSES_PERCENTAGE_OF_SALES_ID,
            self::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_ID => self::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_PERCENTAGE_OF_SALES_ID,
            self::EARNING_BEFORE_INTEREST_TAXES_ID => self::EARNING_BEFORE_INTEREST_TAXES_PERCENTAGE_OF_SALES_ID,
            self::FINANCIAL_INCOME_OR_EXPENSE_ID => self::FINANCIAL_INCOME_OR_EXPENSE_PERCENTAGE_OF_SALES_ID,
            self::EARNING_BEFORE_TAXES_ID => self::EARNING_BEFORE_TAXES_PERCENTAGE_OF_SALES_ID,
            self::CORPORATE_TAXES_ID => self::CORPORATE_TAXES_PERCENTAGE_OF_SALES_ID,
            self::NEXT_PROFIT_ID => self::NEXT_PROFIT_PERCENTAGE_OF_SALES_ID,
        ];
    }
    // for database usage 
    public static function getMainItems()
    {
        return [
            'Sales Revenue' => [
                'id' => $salesRevenueId = self::SALES_REVENUE_ID,
                'hasSubItems' => true,
                'has_depreciation_or_amortization' => false,
                'is_main_for_all_calculations' => true // when it change , all remains rows in tables will also changes,
                , 'is_sales_rate' => false
            ], 'Sales Growth Rate %' => [
                'id' => self::SALES_GROWTH_RATE_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes,
                , 'is_sales_rate' => false,
                'depends_on' => [$salesRevenueId]
            ],
            'Cost Of Goods / Service Sold' => [
                'id' => $costOfGoodsId = self::COST_OF_GOODS_ID,
                'hasSubItems' => true,
                'has_depreciation_or_amortization' => true,
                'is_main_for_all_calculations' => true // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false
            ],
            'Cost Of Goods / Service Sold ' . self::PERCENTAGE_OF_SALES => [
                'id' => $costOfGoodsId = self::COST_OF_GOODS_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'depends_on' => [$salesRevenueId],
                'has_depreciation_or_amortization' => false,
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],
            'Gross Profit' => [
                'id' => $grossProfitId = self::GROSS_PROFIT_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId, $costOfGoodsId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false
            ],
            'Gross Profit ' . self::PERCENTAGE_OF_SALES => [
                'id' => self::GROSS_PROFIT_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],
            'Marketing Expenses' => [
                'id' => $marketExpensesId = self::MARKET_EXPENSES_ID,
                'hasSubItems' => true,
                'has_depreciation_or_amortization' => true,
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false

            ],
            'Marketing Expenses ' . self::PERCENTAGE_OF_SALES => [
                'id' => self::MARKET_EXPENSES_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],
            'Sales & Distribution Expenses' => [
                'id' => $salesAndDistributionExpensesId = self::SALES_AND_DISTRIBUTION_EXPENSES_ID,
                'hasSubItems' => true,
                'has_depreciation_or_amortization' => true,
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false

            ],
            'Sales & Distribution Expenses ' . self::PERCENTAGE_OF_SALES => [
                'id' => self::SALES_AND_DISTRIBUTION_EXPENSES_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],
            'General Expenses' => [
                'id' => $generalExpensesID = self::GENERAL_EXPENSES_ID,
                'hasSubItems' => true,
                'has_depreciation_or_amortization' => true,
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false

            ],
            'General Expenses ' . self::PERCENTAGE_OF_SALES => [
                'id' =>  self::GENERAL_EXPENSES_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],
            'Earning Before Interest Taxes Depreciation Amortization - EBITDA' => [
                'id' => $earningBeforeInterestTaxesDepreciationAmortizationId = self::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$grossProfitId, $marketExpensesId, $salesAndDistributionExpensesId, $generalExpensesID],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false

            ],
            'EBITDA ' . self::PERCENTAGE_OF_SALES => [
                'id' =>  self::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],
            'Earning Before Interest Taxes - EBIT' => [
                'id' => $earningBeforeInterestTaxesId = self::EARNING_BEFORE_INTEREST_TAXES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$earningBeforeInterestTaxesDepreciationAmortizationId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false

            ],
            'EBIT ' . self::PERCENTAGE_OF_SALES => [
                'id' =>  self::EARNING_BEFORE_INTEREST_TAXES_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],

            'Finance Income / (Expenses)' => [
                'id' => $financialIncomeOrExpense = self::FINANCIAL_INCOME_OR_EXPENSE_ID,
                'hasSubItems' => true,
                'has_depreciation_or_amortization' => false,
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false

            ],
            'Finance Income / (Expenses) ' . self::PERCENTAGE_OF_SALES => [
                'id' =>  self::FINANCIAL_INCOME_OR_EXPENSE_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],
            'Earning Before Taxes - EBT' => [
                'id' =>   $earningBeforeTaxesId = self::EARNING_BEFORE_TAXES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$financialIncomeOrExpense, $earningBeforeInterestTaxesId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false

            ],
            'EBT ' . self::PERCENTAGE_OF_SALES => [
                'id' =>  self::EARNING_BEFORE_TAXES_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],
            'Corporate Taxes' => [
                'id' => $corporateTaxesID = self::CORPORATE_TAXES_ID,
                'hasSubItems' => true,
                'has_depreciation_or_amortization' => false,
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false

            ],
            'Corporate Taxes ' . self::PERCENTAGE_OF_SALES => [
                'id' =>  self::CORPORATE_TAXES_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],
            'Net Profit' => [
                'id' => self::NEXT_PROFIT_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$corporateTaxesID, $earningBeforeTaxesId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => false
            ],
            'Net Profit ' . self::PERCENTAGE_OF_SALES => [
                'id' =>  self::NEXT_PROFIT_PERCENTAGE_OF_SALES_ID,
                'hasSubItems' => false,
                'has_depreciation_or_amortization' => false,
                'depends_on' => [$salesRevenueId],
                'is_main_for_all_calculations' => false // when it change , all remains rows in tables will also changes
                , 'is_sales_rate' => true
            ],
        ];
    }

    public static function formattedViewForDashboard(): array
    {
        return BalanceSheetItem::where('for_interval_comparing', 1)->pluck('name', 'id')->toArray();
    }

    public static function compareBetweenTowItems(Collection $firstItems, array $firstIntervalOfDates, string $firstBalanceSheetDurationType, Collection $secondItems, array $secondIntervalOfDates, string $secondBalanceSheetDurationType): array
    {

        $firstItems = self::getItemsForInterval($firstItems, $firstIntervalOfDates, $firstBalanceSheetDurationType);
        $secondItems = self::getItemsForInterval($secondItems, $secondIntervalOfDates, $secondBalanceSheetDurationType);
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
}
