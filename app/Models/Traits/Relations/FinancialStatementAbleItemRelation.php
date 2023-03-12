<?php

namespace App\Models\Traits\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait FinancialStatementAbleItemRelation
{
	public function financialStatementAbles(): BelongsToMany
	{
		return $this->belongsToMany(
			$this->getParentTableClassName(),
			'financial_statement_able_item_main_item',
			'financial_statement_able_item_id',
			'financial_statement_able_id'
		);
	}
	public function withFinancialStatementAblesFor(int $incomeStatementId): BelongsToMany
	{
		return $this->financialStatementAbles()
			->wherePivot('financial_statement_able_id', $incomeStatementId);
	}
	// use WithSubItems Instead
	public function subItems(): BelongsToMany
	{

		return $this->belongsToMany(
			$this->getParentTableClassName(),
			'financial_statement_able_main_item_sub_items',
			'financial_statement_able_item_id',
			'financial_statement_able_id'
		)
			->withPivot(['sub_item_name', 'sub_item_type', 'created_from', 'payload', 'is_depreciation_or_amortization', 'is_quantity', 'can_be_quantity', 'actual_dates', 'percentage_or_fixed', 'can_be_percentage_or_fixed', 'is_percentage_of', 'repeating_fixed_value', 'percentage_value']);
	}
	public function withSubItemsFor(int $financialStatementAbleId, string $subItemType = '', string $subItemName = ''): BelongsToMany
	{
		$subItemNameOperator = $subItemName ? '=' : '!=';
		$subItemTypeOperator = $subItemType ? '=' : '!=';
		return $this
			->subItems()
			->wherePivot('financial_statement_able_id', $financialStatementAbleId)
			->wherePivot('sub_item_type', $subItemTypeOperator, $subItemType)
			->wherePivot('sub_item_name', $subItemNameOperator, $subItemName);
	}
	// use withMainRowsPivot Instead
	public function mainRowsPivot(): BelongsToMany
	{

		return $this->belongsToMany(
			$this->getParentTableClassName(),
			'financial_statement_able_main_item_calculations',
			'financial_statement_able_item_id',
			'financial_statement_able_id'
		)
			// ->wherePivot('financial_statement_able_id', $financialStatementAbleId)
			->withPivot(['payload', 'sub_item_type', 'total', 'company_id', 'creator_id']);
	}
	public function withMainRowsPivotFor(int $financialStatementAbleId, string $subItemType = ''): BelongsToMany
	{
		$subItemTypeOperator = $subItemType ? '=' : '!=';
		return $this->mainRowsPivot()->wherePivot('financial_statement_able_id', $financialStatementAbleId)
			->wherePivot('sub_item_type', $subItemTypeOperator, $subItemType);
	}
}
