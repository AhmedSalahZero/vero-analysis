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
 * App\Models\ActiveJob
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $status
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
 * @property string $name
 * @property string $duration
 * @property string|null $type
 * @property string $duration_type
 * @property string $start_from
 * @property int $company_id
 * @property int|null $creator_id
 * @property int|null $financial_statement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereDurationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereFinancialStatementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereStartFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheet withAllRelations(?int $companyId = null)
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
 * @property string $financial_statement_able_type
 * @property int $is_main_for_all_calculations
 * @property int $is_sales_rate
 * @property int $for_interval_comparing
 * @property mixed|null $depends_on auto-calculated
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
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereDependsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereFinancialStatementAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereForIntervalComparing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereHasDepreciationOrAmortization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereHasSubItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereIsMainForAllCalculations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereIsSalesRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceSheetItem whereUpdatedAt($value)
 */
	class BalanceSheetItem extends \Eloquent implements \App\Interfaces\Models\Interfaces\IFinancialStatementAbleItem {}
}

namespace App\Models{
/**
 * App\Models\CachingCompany
 *
 * @property int $id
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
 */
	class CachingCompany extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CashFlowStatement
 *
 * @property int $id
 * @property string $name
 * @property string $duration
 * @property string|null $type
 * @property string $duration_type
 * @property string $start_from
 * @property int $company_id
 * @property int|null $creator_id
 * @property int|null $financial_statement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FinancialStatement|null $FinancialStatement
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CashFlowStatementItem[] $mainItems
 * @property-read int|null $main_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CashFlowStatementItem[] $mainRows
 * @property-read int|null $main_rows_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CashFlowStatementItem[] $subItems
 * @property-read int|null $sub_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement onlyCurrentCompany(?int $companyId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereDurationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereFinancialStatementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereStartFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatement withAllRelations(?int $companyId = null)
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
 * @property string $financial_statement_able_type
 * @property int $is_main_for_all_calculations
 * @property int $is_sales_rate
 * @property int $for_interval_comparing
 * @property mixed|null $depends_on auto-calculated
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
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereDependsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereFinancialStatementAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereForIntervalComparing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereHasDepreciationOrAmortization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereHasSubItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereIsMainForAllCalculations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereIsSalesRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowStatementItem whereUpdatedAt($value)
 */
	class CashFlowStatementItem extends \Eloquent implements \App\Interfaces\Models\Interfaces\IFinancialStatementAbleItem {}
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
 * @property array $name
 * @property string $sub_of
 * @property int|null $updated_by
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $branches_with_sections
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSubOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedBy($value)
 */
	class Company extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
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
 * @property int $id
 * @property string $name
 * @property int $has_sub_items
 * @property int $has_depreciation_or_amortization
 * @property int $is_main_for_all_calculations
 * @property int $is_sales_rate
 * @property int $for_interval_comparing
 * @property mixed|null $depends_on auto-calculated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialStatement[] $financialStatements
 * @property-read int|null $financial_statements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialStatement[] $mainRowsPivot
 * @property-read int|null $main_rows_pivot_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FinancialStatement[] $subItems
 * @property-read int|null $sub_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem whereDependsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem whereForIntervalComparing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem whereHasDepreciationOrAmortization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem whereHasSubItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem whereIsMainForAllCalculations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem whereIsSalesRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialStatementItem whereUpdatedAt($value)
 */
	class FinancialStatementItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IncomeStatement
 *
 * @property int $id
 * @property string $name
 * @property string $duration
 * @property string|null $type
 * @property string $duration_type
 * @property string $start_from
 * @property int $company_id
 * @property int|null $creator_id
 * @property int|null $financial_statement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereDurationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereFinancialStatementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatement whereId($value)
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
 * @property string $financial_statement_able_type
 * @property int $is_main_for_all_calculations
 * @property int $is_sales_rate
 * @property int $for_interval_comparing
 * @property mixed|null $depends_on auto-calculated
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
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereDependsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereFinancialStatementAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereForIntervalComparing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereHasDepreciationOrAmortization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereHasSubItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereIsMainForAllCalculations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereIsSalesRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeStatementItem whereUpdatedAt($value)
 */
	class IncomeStatementItem extends \Eloquent implements \App\Interfaces\Models\Interfaces\IFinancialStatementAbleItem {}
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
 * @property-read \App\Models\Category|null $category
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
 * @property-read \App\Models\Category|null $category
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
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCashDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesGathering whereCustomerCode($value)
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
 * @property-read string $route_name
 * @property-read Section|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|Section[] $subSections
 * @property-read int|null $sub_sections_count
 * @method static \Illuminate\Database\Eloquent\Builder|Section mainClientSideSections()
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
 * App\Models\SharingLink
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SharingLink query()
 */
	class SharingLink extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TablesField
 *
 * @property int $id
 * @property string|null $model_name
 * @property string|null $field_name
 * @property string|null $view_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TablesField query()
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
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $subscription
 * @property string|null $expiration_date
 * @property int|null $acceptance_of_privacy_policy
 * @property string|null $remember_token
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Company[] $companies
 * @property-read int|null $companies_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSubscription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedBy($value)
 */
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

