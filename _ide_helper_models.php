<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * * اسعار الفايده المخصصة لهذا الحساب
 * * لانه في حاله تغيرت لابد من تتبعها لان النهاردا ممكن يكون علي الحساب دا سعر فايده معينه وممكن الشهر الجي يتغير وهكذا
 *
 * @property int $id
 * @property int $financial_institution_account_id
 * @property string|null $start_date
 * @property string|null $interest_rate
 * @property string|null $min_balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FinancialInstitutionAccount $financialInstitutionAccount
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInterest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInterest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInterest query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInterest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInterest whereFinancialInstitutionAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInterest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInterest whereInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInterest whereMinBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInterest whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInterest whereUpdatedAt($value)
 */
	class AccountInterest extends \Eloquent {}
}

namespace App\Models{
/**
 * * هي عباره عن انواع الحسابات البنكية وليكن مثلا ال
 * * debit  (فلوس ليا عند البنك)-> current , time deposit , certificate of deposit الحساب الجاري الحساب الودايع حساب الشهادات
 * * credit التسهيلات البنكية (فلوس عليا) ->
 *
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $model_name
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType onlyCashAccounts()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType onlySlugs(array $slugs)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereUpdatedAt($value)
 */
	class AccountType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActiveJob
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $status
 * @property string $model
 * @property string $model_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob company()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveJob whereUpdatedAt($value)
 */
	class ActiveJob extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AllocationSetting
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property string|null $breakdown
 * @property int $add_new_items
 * @property int $number_of_items
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting company()
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereAddNewItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereBreakdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereNumberOfItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllocationSetting whereUpdatedBy($value)
 */
	class AllocationSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BalanceSheet
 *
 * @property int $id
 * @property int $can_view_actual_report
 * @property int|null $is_caching_modified
 * @property int|null $is_caching_adjusted
 * @property int|null $is_caching_actual
 * @property int|null $is_caching_forecast
 * @property string $name
 * @property string $duration
 * @property string|null $type
 * @property string $duration_type
 * @property string $start_from
 * @property int $company_id
 * @property int|null $creator_id
 * @property int|null $financial_statement_id
 * @property string|null $cash_and_banks_beginning_balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $entered_receivables_and_payments_table
 * @property-read \App\Models\FinancialStatement|null $FinancialStatement
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BalanceSheetItem[] $mainItems
 * @property-read int|null $main_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BalanceSheetItem[] $mainRows
 * @property-read int|null $main_rows_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BalanceSheetItem[] $subItems
 * @property-read int|null $sub_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet query()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereCanViewActualReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereCashAndBanksBeginningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereDurationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereEnteredReceivablesAndPaymentsTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereFinancialStatementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereIsCachingActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereIsCachingAdjusted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereIsCachingForecast($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereIsCachingModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereStartFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereUpdatedAt($value)
 */
	class BalanceSheet extends \Eloquent implements \App\Interfaces\Models\IBaseModel, \App\Interfaces\Models\IHaveAllRelations, \App\Interfaces\Models\IExportable, \App\Interfaces\Models\IShareable, \App\Interfaces\Models\Interfaces\IFinancialStatementAble {}
}

namespace App\Models{
/**
 * App\Models\BalanceSheetItem
 *
 * @property int $id
 * @property string $name
 * @property int $has_sub_items
 * @property int $has_depreciation_or_amortization
 * @property int $has_percentage_or_fixed_sub_items
 * @property string $financial_statement_able_type
 * @property int $is_main_for_all_calculations
 * @property int $is_sales_rate
 * @property int $for_interval_comparing
 * @property mixed|null $depends_on auto-calculated
 * @property string|null $equation
 * @property int $has_auto_depreciation
 * @property int $is_auto_depreciation_for
 * @property int|null $is_accumulated
 * @property int|null $has_vat_rate
 * @property int|null $can_be_dedictiable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BalanceSheet[] $financialStatementAbles
 * @property-read int|null $financial_statement_ables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BalanceSheet[] $mainRowsPivot
 * @property-read int|null $main_rows_pivot_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BalanceSheet[] $subItems
 * @property-read int|null $sub_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereCanBeDedictiable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereDependsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereEquation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereFinancialStatementAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereForIntervalComparing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereHasAutoDepreciation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereHasDepreciationOrAmortization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereHasPercentageOrFixedSubItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereHasSubItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereHasVatRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereIsAccumulated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereIsAutoDepreciationFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereIsMainForAllCalculations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereIsSalesRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereUpdatedAt($value)
 */
	class BalanceSheetItem extends \Eloquent implements \App\Interfaces\Models\Interfaces\IFinancialStatementAbleItem {}
}

namespace App\Models{
/**
 * App\Models\Bank
 *
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $view_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereViewName($value)
 */
	class Bank extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Branch
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $company_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch query()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUpdatedBy($value)
 */
	class Branch extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BusinessSector
 *
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSector newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSector newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSector onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSector query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSector whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSector whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSector whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSector whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSector whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSector whereUpdatedAt($value)
 */
	class BusinessSector extends \Eloquent implements \App\Interfaces\Models\IBaseModel {}
}

namespace App\Models{
/**
 * App\Models\CachingCompany
 *
 * @property int $id
 * @property string $model
 * @property int $company_id
 * @property int $job_id
 * @property string $key_name
 * @method static \Illuminate\Database\Eloquent\Builder|CachingCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CachingCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CachingCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|CachingCompany whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CachingCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CachingCompany whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CachingCompany whereKeyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CachingCompany whereModel($value)
 */
	class CachingCompany extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CashFlowStatement
 *
 * @property int $id
 * @property int $can_view_actual_report
 * @property int|null $is_caching_modified
 * @property int|null $is_caching_adjusted
 * @property int|null $is_caching_actual
 * @property int|null $is_caching_forecast
 * @property string $name
 * @property string $duration
 * @property string|null $type
 * @property string $duration_type
 * @property string $start_from
 * @property int $company_id
 * @property int|null $creator_id
 * @property int|null $financial_statement_id
 * @property string|null $cash_and_banks_beginning_balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $entered_receivables_and_payments_table
 * @property-read \App\Models\FinancialStatement|null $FinancialStatement
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CashFlowStatementItem[] $mainItems
 * @property-read int|null $main_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CashFlowStatementItem[] $mainRows
 * @property-read int|null $main_rows_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReceivableAndPayment[] $receivables_and_payments
 * @property-read int|null $receivables_and_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CashFlowStatementItem[] $subItems
 * @property-read int|null $sub_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereCanViewActualReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereCashAndBanksBeginningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereDurationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereEnteredReceivablesAndPaymentsTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereFinancialStatementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereIsCachingActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereIsCachingAdjusted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereIsCachingForecast($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereIsCachingModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereStartFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereUpdatedAt($value)
 */
	class CashFlowStatement extends \Eloquent implements \App\Interfaces\Models\IBaseModel, \App\Interfaces\Models\IHaveAllRelations, \App\Interfaces\Models\IExportable, \App\Interfaces\Models\IShareable, \App\Interfaces\Models\Interfaces\IFinancialStatementAble {}
}

namespace App\Models{
/**
 * App\Models\CashFlowStatementItem
 *
 * @property int $id
 * @property string $name
 * @property int $has_sub_items
 * @property int $has_depreciation_or_amortization
 * @property int $has_percentage_or_fixed_sub_items
 * @property string $financial_statement_able_type
 * @property int $is_main_for_all_calculations
 * @property int $is_sales_rate
 * @property int $for_interval_comparing
 * @property mixed|null $depends_on auto-calculated
 * @property string|null $equation
 * @property int $has_auto_depreciation
 * @property int $is_auto_depreciation_for
 * @property int|null $is_accumulated
 * @property int|null $has_vat_rate
 * @property int|null $can_be_dedictiable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CashFlowStatement[] $financialStatementAbles
 * @property-read int|null $financial_statement_ables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CashFlowStatement[] $mainRowsPivot
 * @property-read int|null $main_rows_pivot_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CashFlowStatement[] $subItems
 * @property-read int|null $sub_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereCanBeDedictiable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereDependsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereEquation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereFinancialStatementAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereForIntervalComparing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereHasAutoDepreciation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereHasDepreciationOrAmortization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereHasPercentageOrFixedSubItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereHasSubItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereHasVatRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereIsAccumulated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereIsAutoDepreciationFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereIsMainForAllCalculations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereIsSalesRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereUpdatedAt($value)
 */
	class CashFlowStatementItem extends \Eloquent implements \App\Interfaces\Models\Interfaces\IFinancialStatementAbleItem {}
}

namespace App\Models{
/**
 * App\Models\CashInBank
 *
 * @property int $id
 * @property int $money_received_id
 * @property int|null $receiving_bank_id
 * @property string|null $account_type
 * @property int|null $account_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\AccountType|null $accountType
 * @property-read \App\Models\MoneyReceived $moneyReceived
 * @property-read \App\Models\FinancialInstitution|null $receivingBank
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank whereMoneyReceivedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank whereReceivingBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInBank whereUpdatedAt($value)
 */
	class CashInBank extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CashInSafeStatement
 *
 * @property int $id
 * @property int $is_debit
 * @property int $is_credit
 * @property int $company_id
 * @property int $money_received_id
 * @property int|null $money_payment_id
 * @property string|null $date
 * @property string $beginning_balance
 * @property string $debit
 * @property string $credit
 * @property string $end_balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MoneyReceived $moneyReceived
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereBeginningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereEndBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereIsCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereIsDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereMoneyPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereMoneyReceivedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashInSafeStatement whereUpdatedAt($value)
 */
	class CashInSafeStatement extends \Eloquent {}
}

namespace App\Models{
/**
 * * هو عباره عن الكاش اللي بدفعه للمورد
 *
 * @property int $id
 * @property int $money_payment_id
 * @property int|null $delivery_branch_id
 * @property string|null $receipt_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $deliveryBranch
 * @property-read \App\Models\MoneyPayment $moneyPayment
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereDeliveryBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereMoneyPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereReceiptNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereUpdatedAt($value)
 */
	class CashPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $name
 * @property string $type
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category company()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedBy($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * * توفر شهادات الإيداع ) (CDsللمدخر ين طر يقة لكسب معدل فائدة أعلى على مدخراتك مقابل الموافقة على حجز
 * *    أموالك لفترة زمنية محددة - مع الحفاظ على أموالك آمنة بفضل حمايتها من البنك المركزي
 *
 * @property int $id
 * @property int $financial_institution_id
 * @property string|null $account_number
 * @property string|null $amount
 * @property string|null $currency
 * @property string $interest_rate
 * @property string $interest_amount
 * @property int $maturity_amount_added_to_account_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $company_id
 * @property int|null $created_by
 * @property int|null $update_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FinancialInstitution $financialInstitution
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereFinancialInstitutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereInterestAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereMaturityAmountAddedToAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereUpdateBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificatesOfDeposit whereUpdatedAt($value)
 */
	class CertificatesOfDeposit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cheque
 *
 * @property int $id
 * @property string|null $cheque_number
 * @property string $status
 * @property int $money_received_id
 * @property int|null $drawee_bank_id هو البنك اللي جالي منة الشيك من العميل فا مش شرط يكون من بنوكي
 * @property int|null $drawl_bank_id هو البنك اللي انا باخد الشيك واسحبة منة وبالتالي لازم يكون من بنوكي
 * @property string $account_type نوع الحساب اللي هينزلك عليه فلوس الشيك بعد اما تودية البنك
 * @property string $account_number رقم الحساب اللي هينزلك عليه فلوس الشيك بعد اما تودية البنك
 * @property string|null $due_date هو تاريخ استحقاق الشيك .. يعني اقدر اسحبة امتة
 * @property string|null $deposit_date هو تاريخ ايداع الشيك في البنك.. يعني ممكن يكون تاريخ الاستحقاق بكرا بس هطيته في البنك النهاردا
 * @property string|null $expected_collection_date هو تاريخ اللي متوقع ان البنك يحطلي فيه قيمة الشيك في حسابي
 * @property string|null $actual_collection_date هو تاريخ اللي البنك حطلي فيه قيمة الشيك في حسابي بشكل فعلي لاني ممكن اتوقع في يوم بس فعليا البنك حطة في يوم تاني بس وجود اجازة مثلا في اليوم اللي انا توقعته
 * @property int|null $clearance_days
 * @property string $account_balance دي اجمالي اللي معايا في الحساب بعد اما الشيك مثلا انسحب ودي احنا اللي بنجسبها افتراضيا
 * @property string $collection_fees الرسوم اللي البنك بياخدها منك لتحصيل الشيك
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\Bank|null $draweeBank
 * @property-read \App\Models\FinancialInstitution|null $drawlBank
 * @property-read \App\Models\MoneyReceived $moneyReceived
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereAccountBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereActualCollectionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereChequeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereClearanceDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereCollectionFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereDepositDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereDraweeBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereDrawlBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereExpectedCollectionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereMoneyReceivedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereUpdatedAt($value)
 */
	class Cheque extends \Eloquent {}
}

namespace App\Models{
/**
 * * هو نوع من انواع حسابات التسهيل البنكية (زي القرض يعني بس فية فرق بينهم ) وبيسمى حد جاري مدين بدون ضمان
 * * بدون ضمان يعني مش بياخدوا مقابل قصادة يعني مثلا مش بياخدوا منك شيكات مثلا او بيت .
 * 
 * . الخ علشان كدا اسمه كلين
 * * والفرق بينه وبين القرض ان هنا انت مش ملتزم تسدد مبلغ معين في فتره معين اي لا  يوجد اقساط للدفع
 * * وبناء عليه كل اما قللت التسديد كل اما هينزل عليك فايدة اكبر الشهر الجاي
 * * وعموما في حالة انك مدان للبنك وليكن مثلا لو انت سالف من البنك عشر الالف وسحبت تسعه ونزل عليك فايدة خمس مئة جنية
 * * وقتها ال خمس مئة جنية دول بينسحبوا من حسابك علطول وبالتالي انت ما عتش فاضلك غير خمس مئة مثلا
 *
 * @property int $id
 * @property int|null $financial_institution_id
 * @property int $company_id
 * @property string|null $contract_start_date
 * @property string|null $contract_end_date
 * @property string|null $account_number
 * @property string|null $currency
 * @property string|null $limit
 * @property string|null $outstanding_balance
 * @property string|null $balance_date
 * @property string|null $borrowing_rate
 * @property float|null $bank_margin_rate
 * @property float|null $interest_rate
 * @property float|null $min_interest_rate
 * @property float|null $highest_debt_balance_rate
 * @property float|null $admin_fees_rate
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $to_be_setteled_max_within_days الصفر يمثل غير محدود
 * @property int|null $start_settlement_from_bank_statement_id هو عباره عن الكولوم اللي هنبدا نعمل سيتلمنت من عنده تاني
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CleanOverdraftBankStatement[] $bankStatements
 * @property-read int|null $bank_statements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CleanOverdraftBankStatement[] $cleanOverdraftBankStatements
 * @property-read int|null $clean_overdraft_bank_statements_count
 * @property-read \App\Models\FinancialInstitution|null $financialInstitution
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LendingInformation[] $lendingInformation
 * @property-read int|null $lending_information_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OutstandingBreakdown[] $outstandingBreakdowns
 * @property-read int|null $outstanding_breakdowns_count
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft query()
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereAdminFeesRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereBalanceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereBankMarginRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereBorrowingRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereContractEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereContractStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereFinancialInstitutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereHighestDebtBalanceRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereMinInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereOutstandingBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereStartSettlementFromBankStatementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereToBeSetteledMaxWithinDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraft whereUpdatedBy($value)
 */
	class CleanOverdraft extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CleanOverdraftBankStatement
 *
 * @property int $id
 * @property string $type وليكن مثلا beginning_balance,incoming_transfer,cheque_payment  , etc
 * @property int $is_debit
 * @property int $is_credit
 * @property int $priority عباره عن اولويه التسديد بمعني لما يحين وقت التسديد مين هيتسدد الاول لان الفؤائد بتسدد الاول
 * @property int $clean_overdraft_id
 * @property int $money_received_id
 * @property int|null $money_payment_id
 * @property int|null $internal_money_transfer_id
 * @property int $company_id
 * @property string $date
 * @property string $limit
 * @property string $beginning_balance
 * @property string $debit
 * @property string $credit
 * @property string $end_balance
 * @property string $room
 * @property string $interest_type الفايدة اما بتنزل بعد كل سحبة او ايداع او بتنزل بشكل اوتوماتك اخر كل شهر
 * @property string $interest_rate_annually
 * @property string $interest_rate_daily
 * @property int $days_count
 * @property string $interest_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CleanOverdraft $cleanOverDraft
 * @property-read \App\Models\MoneyPayment|null $moneyPayment
 * @property-read \App\Models\MoneyReceived $moneyReceived
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CleanOverdraftWithdrawal[] $withdrawals
 * @property-read int|null $withdrawals_count
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement query()
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereBeginningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereCleanOverdraftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereDaysCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereEndBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereInterestAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereInterestRateAnnually($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereInterestRateDaily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereInterestType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereInternalMoneyTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereIsCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereIsDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereMoneyPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereMoneyReceivedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftBankStatement whereUpdatedAt($value)
 */
	class CleanOverdraftBankStatement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CleanOverdraftWithdrawal
 *
 * @property int $id
 * @property int $clean_overdraft_bank_statement_id
 * @property int $clean_overdraft_id
 * @property int $company_id
 * @property int $max_settlement_days
 * @property string $due_date تاريخ الاستحقاق وهو عباره عن جدول التاريخ 
 * 			date
 * 			من جدول ال 
 * 			bank statement
 * 			زائد ال
 * 			max_settlement_days
 * @property string $settlement_amount
 * @property string $net_balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CleanOverdraftBankStatement $bankStatement
 * @property-read \App\Models\CleanOverdraft $cleanOverDraft
 * @property-write mixed $withdrawal_date
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal query()
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal whereCleanOverdraftBankStatementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal whereCleanOverdraftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal whereMaxSettlementDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal whereNetBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal whereSettlementAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CleanOverdraftWithdrawal whereUpdatedAt($value)
 */
	class CleanOverdraftWithdrawal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CollectionSetting
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $collection_base
 * @property array|null $general_collection
 * @property array|null $first_allocation_collection
 * @property array|null $second_allocation_collection
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting company()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting whereCollectionBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting whereFirstAllocationCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting whereGeneralCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting whereSecondAllocationCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionSetting whereUpdatedAt($value)
 */
	class CollectionSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Company
 *
 * @property int $id
 * @property string|null $labeling_report_title
 * @property string|null $labeling_stamp
 * @property string|null $labeling_logo_3
 * @property string|null $labeling_logo_2
 * @property string|null $labeling_logo_1
 * @property array|null $labeling_print_headers
 * @property string|null $no_rows_for_each_page_labeling
 * @property string|null $print_labeling_type
 * @property array|null $generate_labeling_code_fields
 * @property int|null $labeling_use_client_logo
 * @property string|null $labeling_client_logo
 * @property string|null $labeling_pagination_per_page
 * @property string|null $labeling_type
 * @property string|null $qrcode_height
 * @property string|null $qrcode_width
 * @property string|null $label_height
 * @property string|null $label_width
 * @property string|null $logo_width
 * @property string|null $labeling_paper_size
 * @property array $name
 * @property string $sub_of
 * @property int $is_caching_now
 * @property string|null $main_functional_currency
 * @property int|null $updated_by
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contract[] $contracts
 * @property-read int|null $contracts_count
 * @property-read mixed $branches_with_sections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LetterOfGuaranteeIssuance[] $letterOfGuaranteeIssuances
 * @property-read int|null $letter_of_guarantee_issuances_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Log[] $logs
 * @property-read int|null $logs_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InternalMoneyTransfer[] $moneyTransfers
 * @property-read int|null $money_transfers_count
 * @property-read \App\NotificationSetting|null $notificationSetting
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\OpeningBalance|null $openingBalance
 * @property-read \Illuminate\Database\Eloquent\Collection|Company[] $subCompanies
 * @property-read int|null $sub_companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereGenerateLabelingCodeFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIsCachingNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingClientLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingLogo1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingLogo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingLogo3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingPaginationPerPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingPaperSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingPrintHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingReportTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingStamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLabelingUseClientLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogoWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereMainFunctionalCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereNoRowsForEachPageLabeling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePrintLabelingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereQrcodeHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereQrcodeWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSubOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedBy($value)
 */
	class Company extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Contract
 *
 * @property int $id
 * @property string|null $model_type اما Customer or Supplier
 * @property int|null $partner_id
 * @property string|null $name
 * @property string|null $code
 * @property int $company_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $start_date
 * @property int $duration
 * @property string|null $end_date
 * @property string $amount
 * @property string|null $currency
 * @property string|null $exchange_rate
 * @property-read \App\Models\Partner|null $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LetterOfGuaranteeIssuance[] $letterOfGuaranteeIssuances
 * @property-read int|null $letter_of_guarantee_issuances_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseOrder[] $purchasesOrders
 * @property-read int|null $purchases_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalesOrder[] $salesOrders
 * @property-read int|null $sales_orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract onlyForCompany(int $companyId)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereUpdatedBy($value)
 */
	class Contract extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\State[] $states
 * @property-read int|null $states_count
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 */
	class Country extends \Eloquent implements \App\Interfaces\Models\IBaseModel {}
}

namespace App\Models{
/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculators
 * @property-read int|null $quick_pricing_calculators_count
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CustomerInvoice
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $customer_code
 * @property string|null $sales_person
 * @property string|null $business_unit
 * @property int $customer_id
 * @property string|null $customer_name
 * @property string|null $business_sector
 * @property string|null $project_name
 * @property string|null $site_name
 * @property \Illuminate\Support\Carbon|null $invoice_date
 * @property string|null $invoice_month
 * @property int|null $invoice_year
 * @property string|null $invoice_number
 * @property string|null $invoice_amount
 * @property string $currency
 * @property string $exchange_rate
 * @property float|null $invoice_amount_in_main_currency
 * @property string|null $vat_amount
 * @property float|null $vat_amount_in_main_currency
 * @property string|null $withhold_amount
 * @property float|null $withhold_amount_in_main_currency
 * @property string|null $net_invoice_amount
 * @property float|null $net_invoice_amount_in_main_currency
 * @property string|null $contracted_collection_days
 * @property string|null $expected_collection_days
 * @property string|null $invoice_due_date
 * @property string|null $invoice_status
 * @property string|null $collected_amount
 * @property float|null $collected_amount_in_main_currency
 * @property string|null $net_balance
 * @property float|null $net_balance_in_main_currency
 * @property int|null $is_period_closed
 * @property int|null $is_canceled
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $discount_amount
 * @property string|null $discount_amount_in_main_currency
 * @property-read \App\Models\Partner $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DueDateHistory[] $dueDateHistories
 * @property-read int|null $due_date_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MoneyReceived[] $moneyReceived
 * @property-read int|null $money_received_count
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice company()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice onlyCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereBusinessSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereBusinessUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereCollectedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereCollectedAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereContractedCollectionDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereCustomerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereDiscountAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereExpectedCollectionDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereInvoiceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereInvoiceAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereInvoiceDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereInvoiceMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereInvoiceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereInvoiceYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereIsCanceled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereIsPeriodClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereNetBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereNetBalanceInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereNetInvoiceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereNetInvoiceAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereProjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereSalesPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereSiteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereVatAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereWithholdAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInvoice whereWithholdAmountInMainCurrency($value)
 */
	class CustomerInvoice extends \Eloquent implements \App\Interfaces\Models\IInvoice {}
}

namespace App\Models{
/**
 * App\Models\CustomersInvoice
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CustomersInvoice company()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomersInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomersInvoice newQuery()
 * @method static \Illuminate\Database\Query\Builder|CustomersInvoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomersInvoice query()
 * @method static \Illuminate\Database\Query\Builder|CustomersInvoice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CustomersInvoice withoutTrashed()
 */
	class CustomersInvoice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CustomizedFieldsExportation
 *
 * @property int $id
 * @property array $fields
 * @property string $model_name
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CustomizedFieldsExportation company()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomizedFieldsExportation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomizedFieldsExportation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomizedFieldsExportation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomizedFieldsExportation whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomizedFieldsExportation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomizedFieldsExportation whereFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomizedFieldsExportation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomizedFieldsExportation whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomizedFieldsExportation whereUpdatedAt($value)
 */
	class CustomizedFieldsExportation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DirectManpowerExpense
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Position[] $directManpowerExpensePositions
 * @property-read int|null $direct_manpower_expense_positions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculators
 * @property-read int|null $quick_pricing_calculators_count
 * @method static \Illuminate\Database\Eloquent\Builder|DirectManpowerExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DirectManpowerExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DirectManpowerExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder|DirectManpowerExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DirectManpowerExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DirectManpowerExpense whereUpdatedAt($value)
 */
	class DirectManpowerExpense extends \Eloquent {}
}

namespace App\Models{
/**
 * * هي عباره عن ال
 * * down payment  Settlements
 * * الخاصة بال money Payment
 *
 * @property-read \App\Models\MoneyPayment $moneyPayment
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentMoneyPaymentSettlement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentMoneyPaymentSettlement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentMoneyPaymentSettlement query()
 */
	class DownPaymentMoneyPaymentSettlement extends \Eloquent {}
}

namespace App\Models{
/**
 * * هي عباره عن ال
 * * down payment  Settlements
 * * الخاصة بال money received
 *
 * @property int $id
 * @property int|null $contract_id
 * @property int|null $sales_order_id
 * @property int|null $customer_id
 * @property string|null $down_payment_amount
 * @property int|null $money_received_id
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MoneyReceived|null $moneyReceived
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement query()
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement whereDownPaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement whereMoneyReceivedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement whereSalesOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownPaymentSettlement whereUpdatedAt($value)
 */
	class DownPaymentSettlement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DueDateHistory
 *
 * @property int $id
 * @property int $model_id
 * @property string $model_type وليكن مثلا CustomerInvoice , SupplierInvoice
 * @property string $mode_type وليكن مثلا CustomerInvoice , SupplierInvoice
 * @property string $due_date التاريخ اللي تم تاجيل الدفع ليه
 * @property string $amount هي عباره عن القيمة المتبقه من الفاتورة خلال تاريخ هذا التاجيل بمعني انك لما اجلت الفاتورة كان متبقي عليك الف جنية مثلا تاني مره اجلتها كان باقي عليك500 مثلا
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\CustomerInvoice $customerInvoice
 * @property-read \App\Models\SupplierInvoice $supplierInvoice
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory whereModeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DueDateHistory whereUpdatedAt($value)
 */
	class DueDateHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExistingProductAllocationBase
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property array|null $existing_products_target
 * @property string|null $total_existing_target
 * @property int $use_modified_targets
 * @property array $allocation_base_percentages
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase company()
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereAllocationBasePercentages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereExistingProductsTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereTotalExistingTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExistingProductAllocationBase whereUseModifiedTargets($value)
 */
	class ExistingProductAllocationBase extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Expense
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $category_name
 * @property string|null $start_date
 * @property string|null $interval
 * @property string|null $monthly_cost_of_unit
 * @property string|null $revenue_stream_type
 * @property string|null $monthly_amount
 * @property string|null $month_percentage
 * @property string|null $payment_terms
 * @property string|null $vat_rate
 * @property int $is_deductible
 * @property string|null $withhold_tax_rate
 * @property string|null $increase_rate
 * @property string|null $increase_interval
 * @property array|null $payload
 * @property int $model_id
 * @property string|null $model_name
 * @property string|null $relation_name
 * @property string|null $allocation_base_1
 * @property string|null $allocation_base_2
 * @property string|null $allocation_base_3
 * @property string|null $conditional_to
 * @property string|null $conditional_value_a
 * @property string|null $conditional_value_b
 * @property array|null $custom_collection_policy
 * @property int $company_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereAllocationBase1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereAllocationBase2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereAllocationBase3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereConditionalTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereConditionalValueA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereConditionalValueB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCustomCollectionPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereIncreaseInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereIncreaseRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereIsDeductible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereMonthPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereMonthlyAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereMonthlyCostOfUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense wherePaymentTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereRelationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereRevenueStreamType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereVatRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereWithholdTaxRate($value)
 */
	class Expense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExportAnalysis
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $revenue_stream
 * @property string|null $purchase_order_number
 * @property string|null $purchase_order_date
 * @property string|null $business_unit
 * @property string|null $customer_name
 * @property string|null $consignee
 * @property string|null $loading_country
 * @property string|null $destination_country
 * @property string|null $broker
 * @property string|null $category
 * @property string|null $sub_category
 * @property string|null $product_item
 * @property string|null $origin
 * @property string|null $packing_unit_of_measurement
 * @property string|null $packing_quantity
 * @property string|null $packing_type
 * @property string|null $full_container_load_count
 * @property string|null $full_container_load_type
 * @property string|null $quantity_unit_of_measurement
 * @property string|null $quantity
 * @property string|null $incoterm
 * @property string|null $currency
 * @property string|null $price_per_unit
 * @property string|null $purchase_order_value
 * @property string|null $freight_value
 * @property string|null $purchase_order_net_value
 * @property string|null $payment_terms
 * @property string|null $shipping_line
 * @property string|null $booking_number
 * @property string|null $port_of_loading
 * @property string|null $port_of_destination
 * @property string|null $cut_off_date
 * @property string|null $estimated_time_of_sailing
 * @property string|null $estimated_time_of_arrival
 * @property string|null $inspection_company
 * @property string|null $clearance_agent
 * @property string|null $export_bank
 * @property string|null $documents_sending_type
 * @property string|null $purchase_order_status
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis company()
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereBookingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereBroker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereBusinessUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereClearanceAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereConsignee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereCutOffDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereDestinationCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereDocumentsSendingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereEstimatedTimeOfArrival($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereEstimatedTimeOfSailing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereExportBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereFreightValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereFullContainerLoadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereFullContainerLoadType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereIncoterm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereInspectionCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereLoadingCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePackingQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePackingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePackingUnitOfMeasurement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePaymentTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePortOfDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePortOfLoading($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePricePerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereProductItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePurchaseOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePurchaseOrderNetValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePurchaseOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePurchaseOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis wherePurchaseOrderValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereQuantityUnitOfMeasurement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereRevenueStream($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereShippingLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereSubCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExportAnalysis whereUpdatedAt($value)
 */
	class ExportAnalysis extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FinancialInstitution
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $branch_name
 * @property int|null $bank_id
 * @property string|null $name
 * @property string|null $company_account_number
 * @property string|null $balance_date
 * @property int|null $company_id
 * @property int|null $created_by
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LetterOfCreditFacility[] $LetterOfCreditFacilities
 * @property-read int|null $letter_of_credit_facilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LetterOfGuaranteeFacility[] $LetterOfGuaranteeFacilities
 * @property-read int|null $letter_of_guarantee_facilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialInstitutionAccount[] $accounts
 * @property-read int|null $accounts_count
 * @property-read \App\Models\Bank|null $bank
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CertificatesOfDeposit[] $certificatesOfDeposits
 * @property-read int|null $certificates_of_deposits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CleanOverdraft[] $cleanOverdrafts
 * @property-read int|null $clean_overdrafts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OverdraftAgainstCommercialPaper[] $overdraftAgainstCommercialPapers
 * @property-read int|null $overdraft_against_commercial_papers_count
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution onlyBanks()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution onlyForCompany(int $companyId)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereBalanceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereBranchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereCompanyAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitution whereUpdatedBy($value)
 */
	class FinancialInstitution extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FinancialInstitutionAccount
 *
 * @property int $id
 * @property int|null $financial_institution_id
 * @property int|null $account_type_id
 * @property int|null $account_number
 * @property string|null $currency
 * @property float|null $balance_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $iban
 * @property int|null $is_main_account
 * @property string|null $exchange_rate
 * @property int|null $company_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AccountInterest[] $accountInterests
 * @property-read int|null $account_interests_count
 * @property-read \App\Models\FinancialInstitution|null $financialInstitution
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereBalanceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereFinancialInstitutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereIsMainAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialInstitutionAccount whereUpdatedAt($value)
 */
	class FinancialInstitutionAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FinancialStatement
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $duration
 * @property string $duration_type
 * @property string $start_from
 * @property int $company_id
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BalanceSheet|null $balanceSheet
 * @property-read \App\Models\CashFlowStatement|null $cashFlowStatement
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\IncomeStatement|null $incomeStatement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialStatementItem[] $mainItems
 * @property-read int|null $main_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialStatementItem[] $mainRows
 * @property-read int|null $main_rows_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SharingLink[] $sharingLinks
 * @property-read int|null $sharing_links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialStatementItem[] $subItems
 * @property-read int|null $sub_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereDurationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereStartFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatement withAllRelations(?int $companyId = null)
 */
	class FinancialStatement extends \Eloquent implements \App\Interfaces\Models\IBaseModel, \App\Interfaces\Models\IHaveAllRelations, \App\Interfaces\Models\IExportable, \App\Interfaces\Models\IShareable {}
}

namespace App\Models{
/**
 * App\Models\FinancialStatementItem
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialStatement[] $financialStatements
 * @property-read int|null $financial_statements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialStatement[] $mainRowsPivot
 * @property-read int|null $main_rows_pivot_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialStatement[] $subItems
 * @property-read int|null $sub_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem query()
 */
	class FinancialStatementItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FreelancerExpense
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Position[] $freelancerPositions
 * @property-read int|null $freelancer_positions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculators
 * @property-read int|null $quick_pricing_calculators_count
 * @method static \Illuminate\Database\Eloquent\Builder|FreelancerExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FreelancerExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FreelancerExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder|FreelancerExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreelancerExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreelancerExpense whereUpdatedAt($value)
 */
	class FreelancerExpense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GeneralExpense
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $expense_id
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PricingExpense|null $expense
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculators
 * @property-read int|null $quick_pricing_calculators_count
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralExpense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralExpense whereExpenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralExpense whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralExpense whereUpdatedAt($value)
 */
	class GeneralExpense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IncomeStatement
 *
 * @property int $id
 * @property int $can_view_actual_report
 * @property int|null $is_caching_modified
 * @property int|null $is_caching_adjusted
 * @property int|null $is_caching_actual
 * @property int|null $is_caching_forecast
 * @property string $name
 * @property string $duration
 * @property string|null $type
 * @property string $duration_type
 * @property string $start_from
 * @property int $company_id
 * @property int|null $creator_id
 * @property int|null $financial_statement_id
 * @property string|null $cash_and_banks_beginning_balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $entered_receivables_and_payments_table
 * @property-read \App\Models\FinancialStatement|null $FinancialStatement
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IncomeStatementItem[] $mainItems
 * @property-read int|null $main_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IncomeStatementItem[] $mainRows
 * @property-read int|null $main_rows_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IncomeStatementItem[] $subItems
 * @property-read int|null $sub_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement query()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereCanViewActualReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereCashAndBanksBeginningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereDurationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereEnteredReceivablesAndPaymentsTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereFinancialStatementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereIsCachingActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereIsCachingAdjusted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereIsCachingForecast($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereIsCachingModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereStartFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereUpdatedAt($value)
 */
	class IncomeStatement extends \Eloquent implements \App\Interfaces\Models\IBaseModel, \App\Interfaces\Models\IHaveAllRelations, \App\Interfaces\Models\IExportable, \App\Interfaces\Models\IShareable, \App\Interfaces\Models\Interfaces\IFinancialStatementAble {}
}

namespace App\Models{
/**
 * App\Models\IncomeStatementItem
 *
 * @property int $id
 * @property string $name
 * @property int $has_sub_items
 * @property int $has_depreciation_or_amortization
 * @property int $has_percentage_or_fixed_sub_items
 * @property string $financial_statement_able_type
 * @property int $is_main_for_all_calculations
 * @property int $is_sales_rate
 * @property int $for_interval_comparing
 * @property mixed|null $depends_on auto-calculated
 * @property string|null $equation
 * @property int $has_auto_depreciation
 * @property int $is_auto_depreciation_for
 * @property int|null $is_accumulated
 * @property int|null $has_vat_rate
 * @property int|null $can_be_dedictiable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IncomeStatement[] $financialStatementAbles
 * @property-read int|null $financial_statement_ables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IncomeStatement[] $mainRowsPivot
 * @property-read int|null $main_rows_pivot_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IncomeStatement[] $subItems
 * @property-read int|null $sub_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereCanBeDedictiable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereDependsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereEquation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereFinancialStatementAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereForIntervalComparing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereHasAutoDepreciation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereHasDepreciationOrAmortization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereHasPercentageOrFixedSubItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereHasSubItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereHasVatRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereIsAccumulated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereIsAutoDepreciationFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereIsMainForAllCalculations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereIsSalesRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereUpdatedAt($value)
 */
	class IncomeStatementItem extends \Eloquent implements \App\Interfaces\Models\Interfaces\IFinancialStatementAbleItem {}
}

namespace App\Models{
/**
 * App\Models\IncomeStatementSubItem
 *
 * @property int $id
 * @property string|null $vat_rate
 * @property int|null $is_deductible
 * @property string|null $is_value_quantity_price
 * @property int $financial_statement_able_id
 * @property int $financial_statement_able_item_id
 * @property string|null $sub_item_name when null it stores the main row data that has no sub rows
 * @property string $sub_item_type
 * @property string|null $receivable_or_payment
 * @property int $ordered
 * @property string $created_from
 * @property mixed|null $payload
 * @property mixed|null $actual_dates
 * @property int|null $is_depreciation_or_amortization
 * @property int $has_collection_policy
 * @property string|null $collection_policy_type
 * @property string|null $collection_policy_value
 * @property int|null $is_quantity
 * @property int $can_be_quantity
 * @property int $can_be_percentage_or_fixed
 * @property int $company_id
 * @property string $percentage_or_fixed
 * @property mixed|null $is_percentage_of
 * @property string|null $repeating_fixed_value
 * @property int|null $creator_id
 * @property string|null $percentage_value
 * @property mixed|null $is_cost_of_unit_of
 * @property string|null $cost_of_unit_value
 * @property int|null $is_financial_expense
 * @property string|null $is_financial_income
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereActualDates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereCanBePercentageOrFixed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereCanBeQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereCollectionPolicyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereCollectionPolicyValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereCostOfUnitValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereCreatedFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereFinancialStatementAbleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereFinancialStatementAbleItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereHasCollectionPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereIsCostOfUnitOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereIsDeductible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereIsDepreciationOrAmortization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereIsFinancialExpense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereIsFinancialIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereIsPercentageOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereIsQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereIsValueQuantityPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereOrdered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem wherePercentageOrFixed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem wherePercentageValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereReceivableOrPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereRepeatingFixedValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereSubItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereSubItemType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementSubItem whereVatRate($value)
 */
	class IncomeStatementSubItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IncomingTransfer
 *
 * @property int $id
 * @property int $money_received_id
 * @property int|null $receiving_bank_id
 * @property string|null $account_type
 * @property int|null $account_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\AccountType|null $accountType
 * @property-read \App\Models\MoneyReceived $moneyReceived
 * @property-read \App\Models\FinancialInstitution|null $receivingBank
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer whereMoneyReceivedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer whereReceivingBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingTransfer whereUpdatedAt($value)
 */
	class IncomingTransfer extends \Eloquent {}
}

namespace App\Models{
/**
 * * هنا عميلة تحويل الاموال من حساب بنك الي حساب بنكي اخر
 * * عن طريق بسحب كريدت من حساب احطة دبت في حساب تاني
 *
 * @property int $id
 * @property string|null $transfer_date هو التاريخ اللي اللي هيتم فيه العميله
 * @property int $transfer_days عدد الايام المتوقع فيها اتمام هذه العمليه
 * @property int|null $from_bank_id
 * @property int|null $to_bank_id
 * @property string $amount مقدار مبلغ التحويل
 * @property int|null $from_account_type_id
 * @property string|null $from_account_number
 * @property string|null $currency
 * @property int|null $to_account_type_id
 * @property string|null $to_account_number
 * @property int $company_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CleanOverdraftBankStatement[] $cleanOverdraftBankStatements
 * @property-read int|null $clean_overdraft_bank_statements_count
 * @property-read \App\Models\AccountType|null $fromAccountType
 * @property-read \App\Models\FinancialInstitution|null $fromBank
 * @property-read \App\Models\AccountType|null $toAccountType
 * @property-read \App\Models\FinancialInstitution|null $toBank
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereFromAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereFromAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereFromBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereToAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereToAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereToBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereTransferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereTransferDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalMoneyTransfer whereUpdatedBy($value)
 */
	class InternalMoneyTransfer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InventoryStatement
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $type
 * @property string|null $date
 * @property string|null $document_num
 * @property string|null $name
 * @property string|null $category
 * @property string|null $local_or_imported
 * @property string|null $sub_category
 * @property string|null $product
 * @property string|null $product_sku
 * @property string|null $measurment_unit
 * @property string|null $beginning_balance
 * @property string|null $volume_in
 * @property string|null $volume_out
 * @property string|null $end_balance
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement company()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereBeginningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereDocumentNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereEndBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereLocalOrImported($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereMeasurmentUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereProductSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereSubCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereVolumeIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatement whereVolumeOut($value)
 */
	class InventoryStatement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InventoryStatementTest
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $type
 * @property string|null $date
 * @property string|null $document_num
 * @property string|null $name
 * @property string|null $category
 * @property string|null $local_or_imported
 * @property string|null $sub_category
 * @property string|null $product
 * @property string|null $product_sku
 * @property string|null $measurment_unit
 * @property string|null $beginning_balance
 * @property string|null $volume_in
 * @property string|null $volume_out
 * @property string|null $end_balance
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property array|null $validation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest company()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereBeginningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereDocumentNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereEndBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereLocalOrImported($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereMeasurmentUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereProductSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereSubCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereVolumeIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryStatementTest whereVolumeOut($value)
 */
	class InventoryStatementTest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LabelingItem
 *
 * @property int $id
 * @property int $company_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property string|null $update_at
 * @property string|null $building_name
 * @property string|null $c1
 * @property string|null $sub_2
 * @property string|null $c2
 * @property string|null $location
 * @property string|null $c3
 * @property string|null $sub_3
 * @property string|null $c4
 * @property string|null $classification
 * @property string|null $c5
 * @property string|null $sub_22
 * @property string|null $c6
 * @property string|null $sub_32
 * @property string|null $c7
 * @property string|null $qty
 * @property string|null $code
 * @property string|null $item
 * @property string|null $17
 * @property string|null $ahmed_salah
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem company()
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem where17($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereAhmedSalah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereBuildingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereC1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereC2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereC3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereC4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereC5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereC6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereC7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereSub2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereSub22($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereSub3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereSub32($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LabelingItem whereUpdateAt($value)
 */
	class LabelingItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int|null $updated_by
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Query\Builder|Language onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|Language withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Language withoutTrashed()
 */
	class Language extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LendingInformation
 *
 * @property int $id
 * @property int|null $overdraft_against_commercial_paper_id
 * @property string|null $max_lending_limit_per_customer
 * @property string|null $customer_name
 * @property int|null $to_be_setteled_max_within_days
 * @property float|null $lending_rate
 * @property int|null $for_commercial_papers_due_within_days
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\OverdraftAgainstCommercialPaper|null $overdraftAgainstCommercialPaper
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation whereForCommercialPapersDueWithinDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation whereLendingRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation whereMaxLendingLimitPerCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation whereOverdraftAgainstCommercialPaperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation whereToBeSetteledMaxWithinDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LendingInformation whereUpdatedAt($value)
 */
	class LendingInformation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LetterOfCreditFacility
 *
 * @property int $id
 * @property int|null $financial_institution_id
 * @property int $company_id
 * @property string|null $contract_start_date
 * @property string|null $contract_end_date
 * @property string|null $currency
 * @property string|null $limit
 * @property string|null $financial_duration
 * @property string|null $borrowing_rate
 * @property string|null $bank_margin_rate
 * @property string|null $interest_rate
 * @property string|null $min_interest_rate
 * @property string|null $highest_debt_balance_rate
 * @property string|null $admin_fees_rate
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FinancialInstitution|null $financialInstitution
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LetterOfCreditFacilityTermAndCondition[] $termAndConditions
 * @property-read int|null $term_and_conditions_count
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility query()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereAdminFeesRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereBankMarginRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereBorrowingRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereContractEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereContractStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereFinancialDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereFinancialInstitutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereHighestDebtBalanceRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereMinInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacility whereUpdatedBy($value)
 */
	class LetterOfCreditFacility extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LetterOfCreditFacilityTermAndCondition
 *
 * @property int $id
 * @property int|null $letter_of_credit_facility_id
 * @property int $company_id
 * @property string|null $outstanding_date
 * @property string|null $lg_type
 * @property string|null $outstanding_balance
 * @property string|null $cash_cover_rate
 * @property string|null $commission_rate
 * @property string|null $commission_interval
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LetterOfCreditFacility|null $letterOfCreditFacility
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereCashCoverRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereCommissionInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereCommissionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereLetterOfCreditFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereLgType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereOutstandingBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereOutstandingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfCreditFacilityTermAndCondition whereUpdatedBy($value)
 */
	class LetterOfCreditFacilityTermAndCondition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LetterOfGuaranteeFacility
 *
 * @property int $id
 * @property int|null $financial_institution_id
 * @property int $company_id
 * @property string|null $contract_start_date
 * @property string|null $contract_end_date
 * @property string|null $currency
 * @property string|null $limit
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FinancialInstitution|null $financialInstitution
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LetterOfGuaranteeFacilityTermAndCondition[] $termAndConditions
 * @property-read int|null $term_and_conditions_count
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility query()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereContractEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereContractStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereFinancialInstitutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacility whereUpdatedBy($value)
 */
	class LetterOfGuaranteeFacility extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LetterOfGuaranteeFacilityTermAndCondition
 *
 * @property int $id
 * @property int|null $letter_of_guarantee_facility_id
 * @property int $company_id
 * @property string|null $outstanding_date
 * @property string|null $lg_type
 * @property string|null $outstanding_balance
 * @property string|null $cash_cover_rate
 * @property string|null $commission_rate
 * @property string|null $commission_interval
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LetterOfGuaranteeFacility|null $letterOfGuaranteeFacility
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereCashCoverRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereCommissionInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereCommissionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereLetterOfGuaranteeFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereLgType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereOutstandingBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereOutstandingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeFacilityTermAndCondition whereUpdatedBy($value)
 */
	class LetterOfGuaranteeFacilityTermAndCondition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LetterOfGuaranteeIssuance
 *
 * @property int $id
 * @property string|null $transaction_name
 * @property string|null $transaction_reference
 * @property string|null $transaction_date
 * @property int|null $financial_institution_id
 * @property string $total_lg_outstanding_balance
 * @property string|null $lg_type
 * @property string $lg_type_outstanding_balance
 * @property string|null $lg_code
 * @property int|null $partner_id
 * @property int|null $contract_id
 * @property int|null $purchase_order_id
 * @property string|null $purchase_order_date
 * @property string|null $issuance_date
 * @property int|null $lg_duration_months
 * @property string|null $renewal_date
 * @property string $lg_amount
 * @property string|null $lg_currency
 * @property string $cash_cover_rate
 * @property string $cash_cover_amount
 * @property string|null $cash_cover_deducted_from_account_type
 * @property string|null $cash_cover_deducted_from_account_number
 * @property string $lg_commission_rate
 * @property string $lg_commission_amount
 * @property string|null $lg_commission_interval
 * @property string|null $cash_cover_account_number
 * @property int $company_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Partner|null $beneficiary
 * @property-read \App\Models\Contract|null $contract
 * @property-read \App\Models\FinancialInstitution|null $financialInstitutionBank
 * @property-read \App\Models\PurchaseOrder|null $purchaseOrder
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance query()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereCashCoverAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereCashCoverAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereCashCoverDeductedFromAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereCashCoverDeductedFromAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereCashCoverRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereFinancialInstitutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereIssuanceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereLgAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereLgCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereLgCommissionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereLgCommissionInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereLgCommissionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereLgCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereLgDurationMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereLgType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereLgTypeOutstandingBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance wherePurchaseOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereRenewalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereTotalLgOutstandingBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereTransactionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereTransactionReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterOfGuaranteeIssuance whereUpdatedBy($value)
 */
	class LetterOfGuaranteeIssuance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Log
 *
 * @property int $id
 * @property string $activity
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $user_id
 * @property string|null $company_id
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUserId($value)
 */
	class Log extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ModifiedSeasonality
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $number_of_products
 * @property int $use_modified_seasonality
 * @property array|null $original_seasonality
 * @property array|null $modified_seasonality
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality company()
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality whereModifiedSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality whereNumberOfProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality whereOriginalSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedSeasonality whereUseModifiedSeasonality($value)
 */
	class ModifiedSeasonality extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ModifiedTarget
 *
 * @property int $id
 * @property int|null $company_id
 * @property array $sales_targets_percentages
 * @property int $use_modified_targets
 * @property array|null $others_target
 * @property array|null $products_modified_targets
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget company()
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget whereOthersTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget whereProductsModifiedTargets($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget whereSalesTargetsPercentages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModifiedTarget whereUseModifiedTargets($value)
 */
	class ModifiedTarget extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Money
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Money newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Money newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Money query()
 */
	class Money extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MoneyPayment
 *
 * @property int $id
 * @property string $money_type
 * @property int|null $contract_id
 * @property int|null $opening_balance_id
 * @property string|null $type
 * @property string|null $supplier_name
 * @property string|null $delivery_date
 * @property string|null $paid_amount
 * @property float $total_withhold_amount
 * @property float|null $total_withhold_amount_in_main_currency
 * @property float|null $paid_amount_in_main_currency
 * @property string|null $currency
 * @property float|null $exchange_rate
 * @property int|null $user_id
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CashPayment|null $cashPayment
 * @property-read \App\Models\CashInSafeStatement|null $cashPaymentStatement
 * @property-read \App\Models\CleanOverdraftBankStatement|null $cleanOverdraftBankStatement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DownPaymentMoneyPaymentSettlement[] $downPaymentSettlements
 * @property-read int|null $down_payment_settlements_count
 * @property-read \App\Models\OpeningBalance|null $openingBalance
 * @property-read \App\Models\OutgoingTransfer|null $outgoingTransfer
 * @property-read \App\Models\PayableCheque|null $payableCheque
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentSettlement[] $settlements
 * @property-read int|null $settlements_count
 * @property-read \App\Models\SupplierInvoice|null $supplierInvoice
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UnappliedAmount[] $unappliedAmounts
 * @property-read int|null $unapplied_amounts_count
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereMoneyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereOpeningBalanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment wherePaidAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereSupplierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereTotalWithholdAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereTotalWithholdAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyPayment whereUserId($value)
 */
	class MoneyPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MoneyReceived
 *
 * @property int $id
 * @property string $money_type
 * @property int|null $contract_id
 * @property int|null $opening_balance_id
 * @property string|null $type
 * @property string|null $customer_name
 * @property string|null $receiving_date
 * @property string|null $received_amount
 * @property float $total_withhold_amount
 * @property float|null $total_withhold_amount_in_main_currency
 * @property float|null $received_amount_in_main_currency
 * @property string|null $currency
 * @property float|null $exchange_rate
 * @property int|null $user_id
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CashInBank|null $cashInBank
 * @property-read \App\Models\CashInSafeStatement|null $cashInSafeStatement
 * @property-read \App\Models\Cheque|null $cheque
 * @property-read \App\Models\Bank $chequeDrawlBank
 * @property-read \App\Models\CleanOverdraftBankStatement|null $cleanOverdraftBankStatement
 * @property-read \App\Models\CustomerInvoice|null $customerInvoice
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DownPaymentSettlement[] $downPaymentSettlements
 * @property-read int|null $down_payment_settlements_count
 * @property-read \App\Models\IncomingTransfer|null $incomingTransfer
 * @property-read \App\Models\OpeningBalance|null $openingBalance
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Settlement[] $settlements
 * @property-read int|null $settlements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UnappliedAmount[] $unappliedAmounts
 * @property-read int|null $unapplied_amounts_count
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived query()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereMoneyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereOpeningBalanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereReceivedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereReceivedAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereReceivingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereTotalWithholdAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereTotalWithholdAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyReceived whereUserId($value)
 */
	class MoneyReceived extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MoneyTwo
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTwo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTwo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyTwo query()
 */
	class MoneyTwo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NewProductAllocationBase
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property array|null $new_allocation_bases_names
 * @property array|null $allocation_base_data
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase company()
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase query()
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase whereAllocationBaseData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase whereNewAllocationBasesNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewProductAllocationBase whereUpdatedBy($value)
 */
	class NewProductAllocationBase extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OpeningBalance
 *
 * @property int $id
 * @property string|null $date
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MoneyReceived[] $cashInSafe
 * @property-read int|null $cash_in_safe_count
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MoneyPayment[] $moneyPayments
 * @property-read int|null $money_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MoneyReceived[] $moneyReceived
 * @property-read int|null $money_received_count
 * @method static \Illuminate\Database\Eloquent\Builder|OpeningBalance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpeningBalance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpeningBalance query()
 * @method static \Illuminate\Database\Eloquent\Builder|OpeningBalance whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpeningBalance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpeningBalance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpeningBalance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpeningBalance whereUpdatedAt($value)
 */
	class OpeningBalance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Other
 *
 * @property-write mixed $guest_capture_cover_percentage
 * @property-write mixed $percentage_from_rooms_revenues
 * @method static \Illuminate\Database\Eloquent\Builder|Other newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Other newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Other query()
 */
	class Other extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OtherDirectOperationExpense
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $expense_id
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PricingExpense|null $expense
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculators
 * @property-read int|null $quick_pricing_calculators_count
 * @method static \Illuminate\Database\Eloquent\Builder|OtherDirectOperationExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherDirectOperationExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherDirectOperationExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherDirectOperationExpense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherDirectOperationExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherDirectOperationExpense whereExpenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherDirectOperationExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherDirectOperationExpense whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherDirectOperationExpense whereUpdatedAt($value)
 */
	class OtherDirectOperationExpense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OtherVariableManpowerExpense
 *
 * @property int $id
 * @property string|null $expense_id
 * @property string $otherVariableManpowerExpenseAble_type
 * @property int $otherVariableManpowerExpenseAble_id
 * @property float $percentage_of_price
 * @property float $cost_per_unit
 * @property float $unit_cost
 * @property float $total_cost
 * @property int $company_id
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PricingExpense|null $expense
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $otherVariableManpowerExpenseAble
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereCostPerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereExpenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereOtherVariableManpowerExpenseAbleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereOtherVariableManpowerExpenseAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense wherePercentageOfPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereUnitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherVariableManpowerExpense whereUpdatedAt($value)
 */
	class OtherVariableManpowerExpense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OutgoingTransfer
 *
 * @property int $id
 * @property int $money_payment_id
 * @property int|null $delivery_bank_id
 * @property string|null $account_type
 * @property int|null $account_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AccountType|null $accountType
 * @property-read \App\Models\FinancialInstitution|null $deliveryBank
 * @property-read \App\Models\MoneyPayment $moneyPayment
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingTransfer whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingTransfer whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingTransfer whereDeliveryBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingTransfer whereMoneyPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingTransfer whereUpdatedAt($value)
 */
	class OutgoingTransfer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OverdraftAgainstCommercialPaper
 *
 * @property int $id
 * @property int|null $financial_institution_id
 * @property int $company_id
 * @property string|null $contract_start_date
 * @property string|null $contract_end_date
 * @property string|null $account_number
 * @property string|null $currency
 * @property string|null $limit
 * @property string|null $outstanding_balance
 * @property string|null $balance_date
 * @property string|null $borrowing_rate
 * @property float|null $bank_margin_rate
 * @property float|null $interest_rate
 * @property float|null $min_interest_rate
 * @property float|null $highest_debt_balance_rate
 * @property float|null $admin_fees_rate
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FinancialInstitution|null $financialInstitution
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LendingInformation[] $lendingInformation
 * @property-read int|null $lending_information_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OutstandingBreakdown[] $outstandingBreakdowns
 * @property-read int|null $outstanding_breakdowns_count
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper query()
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereAdminFeesRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereBalanceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereBankMarginRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereBorrowingRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereContractEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereContractStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereFinancialInstitutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereHighestDebtBalanceRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereMinInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereOutstandingBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OverdraftAgainstCommercialPaper whereUpdatedBy($value)
 */
	class OverdraftAgainstCommercialPaper extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Partner
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property int $is_customer
 * @property int $is_supplier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contract[] $contracts
 * @property-read int|null $contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Settlement[] $settlementForUnappliedAmounts
 * @property-read int|null $settlement_for_unapplied_amounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UnappliedAmount[] $unappliedAmounts
 * @property-read int|null $unapplied_amounts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner onlyCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner onlyCustomers()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner onlyForCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner onlySuppliers()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereIsCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereIsSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereUpdatedAt($value)
 */
	class Partner extends \Eloquent {}
}

namespace App\Models{
/**
 * * دا الشيك اللي بدفعه للموردين
 *
 * @property int $id
 * @property string|null $cheque_number
 * @property string $status
 * @property int $money_payment_id
 * @property int|null $delivery_bank_id هو البنك اللي انا طلعت منة الشيك للمورد وبالتالي لازم يكون من بنوكي
 * @property string $account_type نوع الحساب اللي هسحب منة الشيك علشان ادية للمورد
 * @property string $account_number رقم الحساب اللي هسحب منة الشيك علشان ادية للمورد
 * @property string|null $due_date هو تاريخ استحقاق الشيك .. يعني اقدر اسحبة امتة
 * @property string|null $delivery_date هو تاريخ الي اديت فيه الشيك للمورد
 * @property string|null $actual_payment_date هو تاريخ التسليم الفعلي لان لازم ياكد
 * @property string $account_balance دي اجمالي اللي معايا في الحساب بعد اما الشيك مثلا انسحب ودي احنا اللي بنجسبها افتراضيا
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AccountType $accountType
 * @property-read \App\Models\FinancialInstitution|null $deliveryBank
 * @property-read \App\Models\MoneyPayment $moneyPayment
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereAccountBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereActualPaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereChequeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereDeliveryBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereMoneyPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayableCheque whereUpdatedAt($value)
 */
	class PayableCheque extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentSettlement
 *
 * @property int $id
 * @property string|null $invoice_number
 * @property string|null $supplier_name
 * @property string|null $withhold_amount
 * @property string|null $settlement_amount
 * @property int|null $unapplied_amount_id
 * @property int|null $money_payment_id
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MoneyReceived|null $moneyPayment
 * @property-read \App\Models\MoneyPayment|null $supplierInvoice
 * @property-read \App\Models\UnappliedAmount|null $unappliedAmount
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement whereMoneyPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement whereSettlementAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement whereSupplierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement whereUnappliedAmountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSettlement whereWithholdAmount($value)
 */
	class PaymentSettlement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Position
 *
 * @property int $id
 * @property string $name
 * @property string|null $position_type
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $directManpowerExpenseAble
 * @property-read int|null $direct_manpower_expense_able_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $freelancerExpenseAble
 * @property-read int|null $freelancer_expense_able_count
 * @method static \Illuminate\Database\Eloquent\Builder|Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Position query()
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position wherePositionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereUpdatedAt($value)
 */
	class Position extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PricingExpense
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $expense_type
 * @property int|null $company_id
 * @property int|null $created_by
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense whereExpenseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingExpense whereUpdatedBy($value)
 */
	class PricingExpense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PricingPlan
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculators
 * @property-read int|null $quick_pricing_calculators_count
 * @method static \Illuminate\Database\Eloquent\Builder|PricingPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PricingPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PricingPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|PricingPlan whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingPlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PricingPlan whereUpdatedAt($value)
 */
	class PricingPlan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $name
 * @property string $type
 * @property int $category_id
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|Product company()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedBy($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductSeasonality
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $name
 * @property int|null $product_id
 * @property int $category_id
 * @property string|null $sales_target_value
 * @property string|null $sales_target_percentage
 * @property string|null $seasonality
 * @property array|null $seasonality_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality company()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereSalesTargetPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereSalesTargetValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereSeasonalityData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSeasonality whereUpdatedAt($value)
 */
	class ProductSeasonality extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Profitability
 *
 * @property int $id
 * @property string $profitabilityAble_type
 * @property int $profitabilityAble_id
 * @property float $percentage
 * @property float $net_profit_after_taxes
 * @property float $vat
 * @property int $company_id
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculators
 * @property-read int|null $quick_pricing_calculators_count
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability whereNetProfitAfterTaxes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability whereProfitabilityAbleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability whereProfitabilityAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profitability whereVat($value)
 */
	class Profitability extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PurchaseOrder
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 * @property int $company_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $contract_id
 * @property string|null $po_number purchase order number
 * @property string|null $amount
 * @property string|null $start_date_1
 * @property string|null $end_date_1
 * @property string|null $execution_percentage_1
 * @property int|null $execution_days_1
 * @property int|null $collection_days_1
 * @property string|null $start_date_2
 * @property string|null $end_date_2
 * @property string|null $execution_percentage_2
 * @property int|null $execution_days_2
 * @property int|null $collection_days_2
 * @property string|null $start_date_3
 * @property string|null $end_date_3
 * @property string|null $execution_percentage_3
 * @property int|null $execution_days_3
 * @property int|null $collection_days_3
 * @property string|null $start_date_4
 * @property string|null $end_date_4
 * @property string|null $execution_percentage_4
 * @property int|null $execution_days_4
 * @property int|null $collection_days_4
 * @property string|null $start_date_5
 * @property string|null $end_date_5
 * @property string|null $execution_percentage_5
 * @property int|null $execution_days_5
 * @property int|null $collection_days_5
 * @property-read \App\Models\Contract|null $contract
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LetterOfGuaranteeIssuance[] $letterOfGuaranteeIssuances
 * @property-read int|null $letter_of_guarantee_issuances_count
 * @property-write mixed $end_date1
 * @property-write mixed $end_date2
 * @property-write mixed $end_date3
 * @property-write mixed $end_date4
 * @property-write mixed $end_date5
 * @property-write mixed $start_date1
 * @property-write mixed $start_date2
 * @property-write mixed $start_date3
 * @property-write mixed $start_date4
 * @property-write mixed $start_date5
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder onlyForCompany(int $companyId)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCollectionDays1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCollectionDays2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCollectionDays3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCollectionDays4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCollectionDays5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereEndDate1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereEndDate2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereEndDate3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereEndDate4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereEndDate5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereExecutionDays1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereExecutionDays2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereExecutionDays3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereExecutionDays4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereExecutionDays5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereExecutionPercentage1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereExecutionPercentage2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereExecutionPercentage3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereExecutionPercentage4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereExecutionPercentage5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder wherePoNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereStartDate1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereStartDate2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereStartDate3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereStartDate4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereStartDate5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereUpdatedBy($value)
 */
	class PurchaseOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantityAllocationSetting
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property string|null $breakdown
 * @property int $add_new_items
 * @property int $number_of_items
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereAddNewItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereBreakdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereNumberOfItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityAllocationSetting whereUpdatedBy($value)
 */
	class QuantityAllocationSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantityCategory
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $name
 * @property string $type
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuantityProduct[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCategory whereUpdatedBy($value)
 */
	class QuantityCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantityCollectionSetting
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $collection_base
 * @property array|null $general_collection
 * @property array|null $first_allocation_collection
 * @property array|null $second_allocation_collection
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting whereCollectionBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting whereFirstAllocationCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting whereGeneralCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting whereSecondAllocationCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityCollectionSetting whereUpdatedAt($value)
 */
	class QuantityCollectionSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantityExistingProductAllocationBase
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property array|null $existing_products_target
 * @property string|null $total_existing_target
 * @property int $use_modified_targets
 * @property array $allocation_base_percentages
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereAllocationBasePercentages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereExistingProductsTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereTotalExistingTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityExistingProductAllocationBase whereUseModifiedTargets($value)
 */
	class QuantityExistingProductAllocationBase extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantityModifiedSeasonality
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $number_of_products
 * @property int $use_modified_seasonality
 * @property array|null $original_seasonality
 * @property array|null $modified_seasonality
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality whereModifiedSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality whereNumberOfProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality whereOriginalSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedSeasonality whereUseModifiedSeasonality($value)
 */
	class QuantityModifiedSeasonality extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantityModifiedTarget
 *
 * @property int $id
 * @property int|null $company_id
 * @property array $sales_targets_percentages
 * @property int $use_modified_targets
 * @property array|null $others_target
 * @property array|null $products_modified_targets
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget whereOthersTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget whereProductsModifiedTargets($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget whereSalesTargetsPercentages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityModifiedTarget whereUseModifiedTargets($value)
 */
	class QuantityModifiedTarget extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantityNewProductAllocationBase
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property array|null $new_allocation_bases_names
 * @property array|null $allocation_base_data
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase whereAllocationBaseData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase whereNewAllocationBasesNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityNewProductAllocationBase whereUpdatedBy($value)
 */
	class QuantityNewProductAllocationBase extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantityProduct
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $name
 * @property string $type
 * @property int $category_id
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\QuantityCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProduct whereUpdatedBy($value)
 */
	class QuantityProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantityProductSeasonality
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $name
 * @property int|null $product_id
 * @property int $category_id
 * @property string|null $sales_target_value
 * @property string|null $sales_target_quantity
 * @property string|null $seasonality
 * @property array|null $seasonality_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\QuantityCategory $category
 * @property-read \App\Models\QuantityProduct|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereSalesTargetQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereSalesTargetValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereSeasonalityData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantityProductSeasonality whereUpdatedAt($value)
 */
	class QuantityProductSeasonality extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantitySalesForecast
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $previous_year
 * @property string|null $previous_1_year_sales
 * @property string|null $previous_year_gr
 * @property string|null $average_last_3_years
 * @property array|null $others_products_previous_year
 * @property array|null $others_products_previous_3_year
 * @property array|null $previous_year_seasonality
 * @property array|null $last_3_years_seasonality
 * @property array|null $forecasted_sales
 * @property string|null $target_base
 * @property string|null $prices_increase_rate
 * @property string|null $other_products_growth_rate
 * @property string|null $quantity_growth_rate
 * @property int $add_new_products
 * @property int|null $number_of_products
 * @property string|null $seasonality
 * @property mixed|null $new_seasonality
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereAddNewProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereAverageLast3Years($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereForecastedSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereLast3YearsSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereNewSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereNumberOfProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereOtherProductsGrowthRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereOthersProductsPrevious3Year($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereOthersProductsPreviousYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast wherePrevious1YearSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast wherePreviousYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast wherePreviousYearGr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast wherePreviousYearSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast wherePricesIncreaseRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereQuantityGrowthRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereTargetBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySalesForecast whereUpdatedBy($value)
 */
	class QuantitySalesForecast extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantitySecondAllocationSetting
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property string|null $breakdown
 * @property int $add_new_items
 * @property int $number_of_items
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereAddNewItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereBreakdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereNumberOfItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondAllocationSetting whereUpdatedBy($value)
 */
	class QuantitySecondAllocationSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantitySecondExistingProductAllocationBase
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property array|null $existing_products_target
 * @property string|null $total_existing_target
 * @property int $use_modified_targets
 * @property array $allocation_base_percentages
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereAllocationBasePercentages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereExistingProductsTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereTotalExistingTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondExistingProductAllocationBase whereUseModifiedTargets($value)
 */
	class QuantitySecondExistingProductAllocationBase extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuantitySecondNewProductAllocationBase
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property array|null $new_allocation_bases_names
 * @property array|null $allocation_base_data
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase company()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase whereAllocationBaseData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase whereNewAllocationBasesNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuantitySecondNewProductAllocationBase whereUpdatedBy($value)
 */
	class QuantitySecondNewProductAllocationBase extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QuickPricingCalculator
 *
 * @property int $id
 * @property int|null $pricing_plan_id
 * @property int $revenue_business_line_id
 * @property int $service_category_id
 * @property int $service_item_id
 * @property int $service_nature_id
 * @property float $delivery_days
 * @property string|null $name
 * @property string $date
 * @property int|null $country_id
 * @property int|null $state_id
 * @property int|null $currency_id
 * @property float $price_sensitivity
 * @property int $use_freelancer
 * @property string $total_recommend_price_without_vat
 * @property string $total_recommend_price_with_vat
 * @property string $price_per_day_without_vat
 * @property string $price_per_day_with_vat
 * @property string $total_net_profit_after_taxes
 * @property string $net_profit_after_taxes_per_day
 * @property string $total_sensitive_price_without_vat
 * @property string $total_sensitive_price_with_vat
 * @property string $sensitive_price_per_day_without_vat
 * @property string $sensitive_price_per_day_with_vat
 * @property string $sensitive_total_net_profit_after_taxes
 * @property string $sensitive_net_profit_after_taxes_per_day
 * @property string $sensitive_net_profit_after_taxes_percentage
 * @property int $company_id
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\Currency|null $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Position[] $directManpowerExpensePositions
 * @property-read int|null $direct_manpower_expense_positions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DirectManpowerExpense[] $directManpowerExpenses
 * @property-read int|null $direct_manpower_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Position[] $freelancerExpensePositions
 * @property-read int|null $freelancer_expense_positions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FreelancerExpense[] $freelancerExpenses
 * @property-read int|null $freelancer_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GeneralExpense[] $generalExpenses
 * @property-read int|null $general_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OtherDirectOperationExpense[] $otherDirectOperationExpenses
 * @property-read int|null $other_direct_operation_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OtherVariableManpowerExpense[] $otherVariableManpowerExpenses
 * @property-read int|null $other_variable_manpower_expenses_count
 * @property-read \App\Models\PricingPlan|null $pricingPlan
 * @property-read \App\Models\Profitability|null $profitability
 * @property-read \App\Models\RevenueBusinessLine $revenueBusinessLine
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalesAndMarketingExpense[] $salesAndMarketingExpenses
 * @property-read int|null $sales_and_marketing_expenses_count
 * @property-read \App\Models\ServiceCategory $serviceCategory
 * @property-read \App\Models\ServiceItem $serviceItem
 * @property-read \App\Models\ServiceNature $serviceNature
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SharingLink[] $sharingLinks
 * @property-read int|null $sharing_links_count
 * @property-read \App\Models\State|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereDeliveryDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereNetProfitAfterTaxesPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator wherePricePerDayWithVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator wherePricePerDayWithoutVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator wherePriceSensitivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator wherePricingPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereRevenueBusinessLineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereSensitiveNetProfitAfterTaxesPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereSensitiveNetProfitAfterTaxesPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereSensitivePricePerDayWithVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereSensitivePricePerDayWithoutVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereSensitiveTotalNetProfitAfterTaxes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereServiceCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereServiceItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereServiceNatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereTotalNetProfitAfterTaxes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereTotalRecommendPriceWithVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereTotalRecommendPriceWithoutVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereTotalSensitivePriceWithVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereTotalSensitivePriceWithoutVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator whereUseFreelancer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickPricingCalculator withAllRelations(?int $companyId = null)
 */
	class QuickPricingCalculator extends \Eloquent implements \App\Interfaces\Models\IBaseModel, \App\Interfaces\Models\IHaveAllRelations, \App\Interfaces\Models\IExportable, \App\Interfaces\Models\IShareable {}
}

namespace App\Models{
/**
 * App\Models\QuotationPricingCalculator
 *
 * @property int $id
 * @property int|null $customer_id
 * @property int|null $business_sector_id
 * @property string|null $name
 * @property string $date
 * @property int|null $country_id
 * @property int|null $state_id
 * @property int|null $currency_id
 * @property float $price_sensitivity
 * @property int $use_freelancer
 * @property string $total_recommend_price_without_vat
 * @property string $total_recommend_price_with_vat
 * @property string $price_per_day_without_vat
 * @property string $price_per_day_with_vat
 * @property string $total_net_profit_after_taxes
 * @property string $net_profit_after_taxes_per_day
 * @property string $total_sensitive_price_without_vat
 * @property string $total_sensitive_price_with_vat
 * @property string $sensitive_price_per_day_without_vat
 * @property string $sensitive_price_per_day_with_vat
 * @property string $sensitive_total_net_profit_after_taxes
 * @property string $sensitive_net_profit_after_taxes_per_day
 * @property string $sensitive_net_profit_after_taxes_percentage
 * @property int $company_id
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\Currency|null $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Position[] $directManpowerExpensePositions
 * @property-read int|null $direct_manpower_expense_positions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceItem[] $directManpowerExpenseServiceItems
 * @property-read int|null $direct_manpower_expense_service_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DirectManpowerExpense[] $directManpowerExpenses
 * @property-read int|null $direct_manpower_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Position[] $freelancerExpensePositions
 * @property-read int|null $freelancer_expense_positions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FreelancerExpense[] $freelancerExpenses
 * @property-read int|null $freelancer_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GeneralExpense[] $generalExpenses
 * @property-read int|null $general_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OtherDirectOperationExpense[] $otherDirectOperationExpenses
 * @property-read int|null $other_direct_operation_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OtherVariableManpowerExpense[] $otherVariableManpowerExpenses
 * @property-read int|null $other_variable_manpower_expenses_count
 * @property-read \App\Models\Profitability|null $profitability
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RevenueBusinessLine[] $revenueBusinessLines
 * @property-read int|null $revenue_business_lines_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalesAndMarketingExpense[] $salesAndMarketingExpenses
 * @property-read int|null $sales_and_marketing_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceCategory[] $serviceCategories
 * @property-read int|null $service_categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceItem[] $serviceItems
 * @property-read int|null $service_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceNature[] $serviceNatures
 * @property-read int|null $service_natures_count
 * @property-read \App\Models\State|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereBusinessSectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereNetProfitAfterTaxesPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator wherePricePerDayWithVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator wherePricePerDayWithoutVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator wherePriceSensitivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereSensitiveNetProfitAfterTaxesPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereSensitiveNetProfitAfterTaxesPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereSensitivePricePerDayWithVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereSensitivePricePerDayWithoutVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereSensitiveTotalNetProfitAfterTaxes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereTotalNetProfitAfterTaxes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereTotalRecommendPriceWithVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereTotalRecommendPriceWithoutVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereTotalSensitivePriceWithVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereTotalSensitivePriceWithoutVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator whereUseFreelancer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuotationPricingCalculator withAllRelations(?int $companyId = null)
 */
	class QuotationPricingCalculator extends \Eloquent implements \App\Interfaces\Models\IBaseModel, \App\Interfaces\Models\IHaveAllRelations, \App\Interfaces\Models\IExportable, \App\Interfaces\Models\IShareable {}
}

namespace App\Models{
/**
 * App\Models\ReceivableAndPayment
 *
 * @property int $id
 * @property string|null $name
 * @property string $balance_amount
 * @property array|null $payload
 * @property int $cash_flow_statement_id
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CashFlowStatement $cashFlowStatement
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment whereBalanceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment whereCashFlowStatementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivableAndPayment whereUpdatedAt($value)
 */
	class ReceivableAndPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RevenueBusinessLine
 *
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuotationPricingCalculator[] $QuotationPricingCalculators
 * @property-read int|null $quotation_pricing_calculators_count
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculators
 * @property-read int|null $quick_pricing_calculators_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceCategory[] $serviceCategories
 * @property-read int|null $service_categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceItem[] $serviceItems
 * @property-read int|null $service_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine forCurrentCompany()
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine query()
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RevenueBusinessLine whereUpdatedAt($value)
 */
	class RevenueBusinessLine extends \Eloquent implements \App\Interfaces\Models\IHaveView, \App\Interfaces\Models\IHaveCompany, \App\Interfaces\Models\IHaveCreator, \App\Interfaces\Models\IBaseModel, \App\Interfaces\Models\IExportable {}
}

namespace App\Models{
/**
 * App\Models\SalesAndMarketingExpense
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $expense_id
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PricingExpense|null $expense
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculators
 * @property-read int|null $quick_pricing_calculators_count
 * @method static \Illuminate\Database\Eloquent\Builder|SalesAndMarketingExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesAndMarketingExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesAndMarketingExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesAndMarketingExpense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesAndMarketingExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesAndMarketingExpense whereExpenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesAndMarketingExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesAndMarketingExpense whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesAndMarketingExpense whereUpdatedAt($value)
 */
	class SalesAndMarketingExpense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SalesForecast
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $previous_year
 * @property string|null $previous_1_year_sales
 * @property string|null $previous_year_gr
 * @property string|null $average_last_3_years
 * @property array|null $previous_year_seasonality
 * @property array|null $last_3_years_seasonality
 * @property string|null $target_base
 * @property string|null $sales_target
 * @property string|null $new_start
 * @property string|null $growth_rate
 * @property int $add_new_products
 * @property int|null $number_of_products
 * @property string|null $seasonality
 * @property array|null $new_seasonality
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast company()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereAddNewProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereAverageLast3Years($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereGrowthRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereLast3YearsSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereNewSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereNewStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereNumberOfProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast wherePrevious1YearSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast wherePreviousYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast wherePreviousYearGr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast wherePreviousYearSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereSalesTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereSeasonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereTargetBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesForecast whereUpdatedBy($value)
 */
	class SalesForecast extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SalesGathering
 *
 * @property int $id
 * @property string $type
 * @property int|null $company_id
 * @property string|null $date
 * @property string|null $country
 * @property string|null $local_or_export
 * @property string|null $branch
 * @property string|null $document_type
 * @property string|null $document_number
 * @property string|null $sales_person
 * @property string|null $business_unit
 * @property string|null $customer_name
 * @property string|null $business_sector
 * @property string|null $zone
 * @property string|null $sales_channel
 * @property string|null $service_provider_type
 * @property string|null $service_provider_name
 * @property int|null $service_provider_birth_year
 * @property string|null $principle
 * @property string|null $category
 * @property string|null $sub_category
 * @property string|null $product_or_service
 * @property string|null $product_item
 * @property string|null $measurment_unit
 * @property string|null $return_reason
 * @property string|null $quantity
 * @property string|null $quantity_status
 * @property string|null $quantity_bonus
 * @property string|null $price_per_unit
 * @property string|null $sales_value
 * @property string|null $quantity_discount
 * @property string|null $cash_discount
 * @property string|null $special_discount
 * @property string|null $other_discounts
 * @property string|null $net_sales_value
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $Day
 * @property string $Month
 * @property string $Year
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering company()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereBusinessSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereBusinessUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCashDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereLocalOrExport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereMeasurmentUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereNetSalesValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereOtherDiscounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering wherePricePerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering wherePrinciple($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereProductItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereProductOrService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereQuantityBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereQuantityDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereQuantityStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereReturnReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereSalesChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereSalesPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereSalesValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereServiceProviderBirthYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereServiceProviderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereServiceProviderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereSpecialDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereSubCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereZone($value)
 */
	class SalesGathering extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SalesGatheringTest
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $date
 * @property string|null $country
 * @property string|null $local_or_export
 * @property string|null $branch
 * @property string|null $document_type
 * @property string|null $document_number
 * @property string|null $sales_person
 * @property string|null $customer_code
 * @property string|null $customer_name
 * @property string|null $business_sector
 * @property string|null $zone
 * @property string|null $sales_channel
 * @property string|null $service_provider_type
 * @property string|null $service_provider_name
 * @property int|null $service_provider_birth_year
 * @property string|null $principle
 * @property string|null $category
 * @property string|null $sub_category
 * @property string|null $product_or_service
 * @property string|null $product_item
 * @property string|null $measurment_unit
 * @property string|null $return_reason
 * @property string|null $quantity
 * @property string|null $quantity_status
 * @property string|null $quantity_bonus
 * @property string|null $price_per_unit
 * @property string|null $sales_value
 * @property string|null $quantity_discount
 * @property string|null $cash_discount
 * @property string|null $special_discount
 * @property string|null $other_discounts
 * @property string|null $net_sales_value
 * @property array|null $validation
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest company()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereBusinessSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereCashDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereCustomerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereLocalOrExport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereMeasurmentUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereNetSalesValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereOtherDiscounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest wherePricePerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest wherePrinciple($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereProductItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereProductOrService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereQuantityBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereQuantityDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereQuantityStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereReturnReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereSalesChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereSalesPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereSalesValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereServiceProviderBirthYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereServiceProviderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereServiceProviderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereSpecialDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereSubCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGatheringTest whereZone($value)
 */
	class SalesGatheringTest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SalesOrder
 *
 * @property int $id
 * @property int $company_id
 * @property int $contract_id
 * @property string|null $so_number
 * @property string|null $amount
 * @property string|null $start_date_1
 * @property string|null $end_date_1
 * @property string|null $execution_percentage_1
 * @property int|null $execution_days_1
 * @property int|null $collection_days_1
 * @property string|null $start_date_2
 * @property string|null $end_date_2
 * @property string|null $execution_percentage_2
 * @property int|null $execution_days_2
 * @property int|null $collection_days_2
 * @property string|null $start_date_3
 * @property string|null $end_date_3
 * @property string|null $execution_percentage_3
 * @property int|null $execution_days_3
 * @property int|null $collection_days_3
 * @property string|null $start_date_4
 * @property string|null $end_date_4
 * @property string|null $execution_percentage_4
 * @property int|null $execution_days_4
 * @property int|null $collection_days_4
 * @property string|null $start_date_5
 * @property string|null $end_date_5
 * @property string|null $execution_percentage_5
 * @property int|null $execution_days_5
 * @property int|null $collection_days_5
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contract $contract
 * @property-write mixed $end_date1
 * @property-write mixed $end_date2
 * @property-write mixed $end_date3
 * @property-write mixed $end_date4
 * @property-write mixed $end_date5
 * @property-write mixed $start_date1
 * @property-write mixed $start_date2
 * @property-write mixed $start_date3
 * @property-write mixed $start_date4
 * @property-write mixed $start_date5
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder onlyForCompany(int $companyId)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereCollectionDays1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereCollectionDays2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereCollectionDays3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereCollectionDays4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereCollectionDays5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereEndDate1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereEndDate2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereEndDate3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereEndDate4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereEndDate5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereExecutionDays1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereExecutionDays2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereExecutionDays3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereExecutionDays4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereExecutionDays5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereExecutionPercentage1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereExecutionPercentage2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereExecutionPercentage3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereExecutionPercentage4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereExecutionPercentage5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereSoNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereStartDate1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereStartDate2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereStartDate3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereStartDate4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereStartDate5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesOrder whereUpdatedAt($value)
 */
	class SalesOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SecondAllocationSetting
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property string|null $breakdown
 * @property int $add_new_items
 * @property int $number_of_items
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting company()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereAddNewItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereBreakdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereNumberOfItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondAllocationSetting whereUpdatedBy($value)
 */
	class SecondAllocationSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SecondExistingProductAllocationBase
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property array|null $existing_products_target
 * @property string|null $total_existing_target
 * @property int $use_modified_targets
 * @property array $allocation_base_percentages
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase company()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase query()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereAllocationBasePercentages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereExistingProductsTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereTotalExistingTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondExistingProductAllocationBase whereUseModifiedTargets($value)
 */
	class SecondExistingProductAllocationBase extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SecondNewProductAllocationBase
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $allocation_base
 * @property array|null $new_allocation_bases_names
 * @property array|null $allocation_base_data
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase company()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase query()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase whereAllocationBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase whereAllocationBaseData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase whereNewAllocationBasesNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondNewProductAllocationBase whereUpdatedBy($value)
 */
	class SecondNewProductAllocationBase extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Section
 *
 * @property int $id
 * @property array $name
 * @property string $sub_of
 * @property string $icon
 * @property string|null $route
 * @property int $order
 * @property int $trash
 * @property string $section_side
 * @property int|null $updated_by
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Branch[] $branches
 * @property-read int|null $branches_count
 * @property-read string $route_name
 * @property-read Section $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|Section[] $subSections
 * @property-read int|null $sub_sections_count
 * @method static \Illuminate\Database\Eloquent\Builder|Section mainClientSideSections()
 * @method static \Illuminate\Database\Eloquent\Builder|Section mainCompanyAdminSections()
 * @method static \Illuminate\Database\Eloquent\Builder|Section mainSections()
 * @method static \Illuminate\Database\Eloquent\Builder|Section mainSuperAdminSections()
 * @method static \Illuminate\Database\Eloquent\Builder|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section newQuery()
 * @method static \Illuminate\Database\Query\Builder|Section onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereSectionSide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereSubOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereTrash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|Section withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Section withoutTrashed()
 */
	class Section extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ServiceCategory
 *
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $revenue_business_line_id
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RevenueBusinessLine $RevenueBusinessLine
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculator
 * @property-read int|null $quick_pricing_calculator_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceItem[] $serviceItems
 * @property-read int|null $service_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereRevenueBusinessLineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuotationPricingCalculator[] $QuotationPricingCalculators
 * @property-read int|null $quotation_pricing_calculators_count
 */
	class ServiceCategory extends \Eloquent implements \App\Interfaces\Models\IHaveCompany, \App\Interfaces\Models\IHaveCreator, \App\Interfaces\Models\IBaseModel {}
}

namespace App\Models{
/**
 * App\Models\ServiceItem
 *
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $service_category_id
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\ServiceCategory $serviceCategory
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem whereServiceCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceItem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuotationPricingCalculator[] $QuotationPricingCalculators
 * @property-read int|null $quotation_pricing_calculators_count
 */
	class ServiceItem extends \Eloquent implements \App\Interfaces\Models\IHaveCompany, \App\Interfaces\Models\IHaveCreator, \App\Interfaces\Models\IBaseModel {}
}

namespace App\Models{
/**
 * App\Models\ServiceNature
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuotationPricingCalculator[] $QuotationPricingCalculators
 * @property-read int|null $quotation_pricing_calculators_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuickPricingCalculator[] $quickPricingCalculator
 * @property-read int|null $quick_pricing_calculator_count
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNature query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNature whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceNature whereUpdatedAt($value)
 */
	class ServiceNature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Settlement
 *
 * @property int $id
 * @property string|null $invoice_number
 * @property string|null $customer_name
 * @property string|null $withhold_amount
 * @property string|null $settlement_amount
 * @property int|null $unapplied_amount_id
 * @property int|null $money_received_id
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MoneyReceived|null $customerInvoice
 * @property-read \App\Models\MoneyReceived|null $moneyReceived
 * @property-read \App\Models\UnappliedAmount|null $unappliedAmount
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereMoneyReceivedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereSettlementAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereUnappliedAmountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereWithholdAmount($value)
 */
	class Settlement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SharingLink
 *
 * @property int $id
 * @property string $link
 * @property string $identifier
 * @property string|null $user_name
 * @property string $shareable_type
 * @property int $shareable_id
 * @property int $is_active
 * @property float $number_of_views
 * @property int $company_id
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereNumberOfViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereShareableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereShareableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink whereUserName($value)
 */
	class SharingLink extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\State
 *
 * @property int $id
 * @property int $country_id
 * @property string $name_ar
 * @property string $name_en
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country $country
 * @property-read State $state
 * @method static \Illuminate\Database\Eloquent\Builder|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State query()
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereUpdatedAt($value)
 */
	class State extends \Eloquent implements \App\Interfaces\Models\IBaseModel {}
}

namespace App\Models{
/**
 * App\Models\SubItem
 *
 * @property int $id
 * @property string|null $vat_rate
 * @property int|null $is_deductible
 * @property string|null $is_value_quantity_price
 * @property int $financial_statement_able_id
 * @property int $financial_statement_able_item_id
 * @property string|null $sub_item_name when null it stores the main row data that has no sub rows
 * @property string $sub_item_type
 * @property string|null $receivable_or_payment
 * @property int $ordered
 * @property string $created_from
 * @property mixed|null $payload
 * @property mixed|null $actual_dates
 * @property int|null $is_depreciation_or_amortization
 * @property int $has_collection_policy
 * @property string|null $collection_policy_type
 * @property string|null $collection_policy_value
 * @property int|null $is_quantity
 * @property int $can_be_quantity
 * @property int $can_be_percentage_or_fixed
 * @property int $company_id
 * @property string $percentage_or_fixed
 * @property mixed|null $is_percentage_of
 * @property string|null $repeating_fixed_value
 * @property int|null $creator_id
 * @property string|null $percentage_value
 * @property mixed|null $is_cost_of_unit_of
 * @property string|null $cost_of_unit_value
 * @property int|null $is_financial_expense
 * @property string|null $is_financial_income
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereActualDates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereCanBePercentageOrFixed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereCanBeQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereCollectionPolicyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereCollectionPolicyValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereCostOfUnitValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereCreatedFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereFinancialStatementAbleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereFinancialStatementAbleItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereHasCollectionPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereIsCostOfUnitOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereIsDeductible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereIsDepreciationOrAmortization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereIsFinancialExpense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereIsFinancialIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereIsPercentageOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereIsQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereIsValueQuantityPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereOrdered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem wherePercentageOrFixed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem wherePercentageValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereReceivableOrPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereRepeatingFixedValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereSubItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereSubItemType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubItem whereVatRate($value)
 */
	class SubItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SupplierInvoice
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $supplier_code
 * @property string|null $sales_person
 * @property int $supplier_id
 * @property string|null $supplier_name
 * @property string|null $business_sector
 * @property string|null $project_name
 * @property string|null $site_name
 * @property \Illuminate\Support\Carbon|null $invoice_date
 * @property string|null $invoice_month
 * @property int|null $invoice_year
 * @property string|null $invoice_number
 * @property string|null $invoice_amount
 * @property string $currency
 * @property string $exchange_rate
 * @property float|null $invoice_amount_in_main_currency
 * @property string|null $vat_amount
 * @property float|null $vat_amount_in_main_currency
 * @property string|null $withhold_amount
 * @property float|null $withhold_amount_in_main_currency
 * @property string|null $net_invoice_amount
 * @property float|null $net_invoice_amount_in_main_currency
 * @property string|null $contracted_payment_days
 * @property string|null $invoice_due_date
 * @property string|null $invoice_status
 * @property string|null $paid_amount
 * @property float|null $paid_amount_in_main_currency
 * @property string|null $net_balance
 * @property float|null $net_balance_in_main_currency
 * @property int|null $is_period_closed
 * @property int|null $is_canceled
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $discount_amount
 * @property string|null $discount_amount_in_main_currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DueDateHistory[] $dueDateHistories
 * @property-read int|null $due_date_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MoneyPayment[] $moneyPayment
 * @property-read int|null $money_payment_count
 * @property-read \App\Models\Partner $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice company()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice onlyCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereBusinessSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereContractedPaymentDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereDiscountAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereInvoiceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereInvoiceAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereInvoiceDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereInvoiceMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereInvoiceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereInvoiceYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereIsCanceled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereIsPeriodClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereNetBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereNetBalanceInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereNetInvoiceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereNetInvoiceAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice wherePaidAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereProjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereSalesPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereSiteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereSupplierCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereSupplierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereVatAmountInMainCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereWithholdAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierInvoice whereWithholdAmountInMainCurrency($value)
 */
	class SupplierInvoice extends \Eloquent implements \App\Interfaces\Models\IInvoice {}
}

namespace App\Models{
/**
 * App\Models\TablesField
 *
 * @property int $id
 * @property string|null $model_name
 * @property string|null $field_name
 * @property string|null $view_name
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField query()
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField whereFieldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField whereViewName($value)
 */
	class TablesField extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Test
 *
 * @property int $id
 * @property string $debit
 * @property string $credit
 * @property string $net_balance
 * @property string $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereNetBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereUpdatedAt($value)
 */
	class Test extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ToolTipData
 *
 * @property int $id
 * @property string $model_name
 * @property string $section_name
 * @property string|null $field
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ToolTipData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ToolTipData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ToolTipData query()
 * @method static \Illuminate\Database\Eloquent\Builder|ToolTipData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToolTipData whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToolTipData whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToolTipData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToolTipData whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToolTipData whereSectionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToolTipData whereUpdatedAt($value)
 */
	class ToolTipData extends \Eloquent {}
}

namespace App\Models{
/**
 * * هو عباره عن الفلوس الزيادة المتبقيه من ال
 * * money received
 * * بعد اما عملت settlements
 * * وليكن مثلا استلمت مليون جنيه وستلت نص مليون كدا فاضل
 * * unapplied
 * * عباره عن نص مليون
 *
 * @property int $id
 * @property int $company_id
 * @property int $partner_id
 * @property int|null $model_id
 * @property string $model_type وليكن مثلا MoneyReceived , MoneyPayment
 * @property string $settlement_date
 * @property string $amount هي القيمة ال unapplied الحالية
 * @property string $net_balance_until_date هي صافي الرصيد لحد التاريخ الحالي
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MoneyReceived $moneyReceived
 * @property-read \App\Models\Partner $partner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Settlement[] $settlements
 * @property-read int|null $settlements_count
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount onlyCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount whereNetBalanceUntilDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount whereSettlementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnappliedAmount whereUpdatedAt($value)
 */
	class UnappliedAmount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $subscription
 * @property string|null $expiration_date
 * @property string|null $max_users
 * @property int|null $acceptance_of_privacy_policy
 * @property string|null $remember_token
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CertificatesOfDeposit[] $certificatesOfDeposits
 * @property-read int|null $certificates_of_deposits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CleanOverdraft[] $cleanOverdraft
 * @property-read int|null $clean_overdraft_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Company[] $companies
 * @property-read int|null $companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialInstitution[] $financialInstitutions
 * @property-read int|null $financial_institutions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LetterOfCreditFacility[] $letterOfCreditFacilities
 * @property-read int|null $letter_of_credit_facilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LetterOfGuaranteeFacility[] $letterOfGuaranteeFacilities
 * @property-read int|null $letter_of_guarantee_facilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Log[] $logs
 * @property-read int|null $logs_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MoneyPayment[] $moneyPayments
 * @property-read int|null $money_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MoneyReceived[] $moneyReceived
 * @property-read int|null $money_received_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OverdraftAgainstCommercialPaper[] $overdraftAgainstCommercialPaper
 * @property-read int|null $overdraft_against_commercial_paper_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $usersCreatedBy
 * @property-read int|null $users_created_by_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAcceptanceOfPrivacyPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMaxUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSubscription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedBy($value)
 */
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App{
/**
 * App\NotificationSetting
 *
 * @property int $id
 * @property int $customer_coming_dues_invoices_notifications_days
 * @property int $customer_past_dues_invoices_notifications_days
 * @property int $cheques_in_safe_notifications_days
 * @property int $cheques_under_collection_notifications_days
 * @property int $supplier_coming_dues_invoices_notifications_days
 * @property int $supplier_past_dues_invoices_notifications_days
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereChequesInSafeNotificationsDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereChequesUnderCollectionNotificationsDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereCustomerComingDuesInvoicesNotificationsDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereCustomerPastDuesInvoicesNotificationsDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereSupplierComingDuesInvoicesNotificationsDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereSupplierPastDuesInvoicesNotificationsDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereUpdatedAt($value)
 */
	class NotificationSetting extends \Eloquent {}
}

namespace App{
/**
 * * هو عباره عن التقسيمة الخاصة بال
 * *clean overdraft
 * * outstanding balance
 * * او اي نوع تاني خاص بالتسهيلات
 * * بمعني انك لما بتحط ال
 * * الفلوس اللي انت سحبتها من الحساب لحد لحظه فتح حسابك علي كاش فيرو .
 * 
 * .سحبت قديه يوم قديه وقديه يوم قديه وهكذا
 * * بمعني ان مجموع القيم لازم يساوي ال
 * * outstanding balance in clean overdraft
 *
 * @property int $id
 * @property string $settlement_date
 * @property string $amount
 * @property int $model_id وليكن مثلا clean_overdraft_id
 * @property string $model_type
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CleanOverdraft $cleanOverDraft
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown query()
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown whereSettlementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutstandingBreakdown whereUpdatedAt($value)
 */
	class OutstandingBreakdown extends \Eloquent {}
}

namespace App{
/**
 * App\VerificationCode
 *
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode query()
 */
	class VerificationCode extends \Eloquent {}
}

