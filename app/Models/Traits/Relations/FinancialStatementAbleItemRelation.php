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
	// use WithSubItems Instead
	public function subItems(): BelongsToMany
	{

		return $this->belongsToMany(
			$this->getParentTableClassName(),
			'financial_statement_able_main_item_sub_items',
			'financial_statement_able_item_id',
			'financial_statement_able_id'
		)
			->withPivot(['sub_item_name', 'sub_item_type', 'payload', 'is_depreciation_or_amortization']);
	}
	public function withSubItemsFor(int $financialStatementAbleId, string $subItemType = '', string $subItemName = ''): BelongsToMany
	{
		$subItemNameOperator = $subItemName ? '=' : '!=';
		$subItemTypeOperator = $subItemType ? '=' : '!=';

		return $this
			->subItems()
			->wherePivot('financial_statement_able_id', $financialStatementAbleId)
			->wherePivot('sub_item_name', $subItemNameOperator, $subItemName)
			->wherePivot('sub_item_type', $subItemTypeOperator, $subItemType);
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
			->withPivot(['payload', 'company_id', 'creator_id']);
	}
	public function withMainRowsPivotFor(int $financialStatementAbleId): BelongsToMany
	{
		return $this->mainRowsPivot()->wherePivot('financial_statement_able_id', $financialStatementAbleId);
	}
}
