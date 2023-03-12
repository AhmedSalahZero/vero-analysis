<?php

namespace App\Models\Traits\Relations;

use App\Models\FinancialStatement;
use App\Models\Traits\Relations\Commons\CommonRelations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait FinancialStatementAbleRelation
{
	use CommonRelations;

	public function FinancialStatement(): BelongsTo
	{
		return $this->belongsTo(FinancialStatement::class, 'financial_statement_id', 'id');
	}
	// use withMainItemsFor instead 
	public function mainItems(): BelongsToMany
	{
		return $this->belongsToMany(
			$this->getMainItemTableClassName(),
			// IncomeStatementItem::class,
			'financial_statement_able_item_main_item',
			'financial_statement_able_id',
			'financial_statement_able_item_id'
		);
	}
	public function withMainItemsFor(int $financialStatementAbleItemId)
	{
		return $this->mainItems()->wherePivot('financial_statement_able_item_id', $financialStatementAbleItemId);
	}
	// use scopeWithSubItems instead 
	public function subItems(): BelongsToMany
	{

		return $this->belongsToMany(
			$this->getMainItemTableClassName(),
			'financial_statement_able_main_item_sub_items',
			'financial_statement_able_id',
			'financial_statement_able_item_id'
		)
			// ->wherePivot('financial_statement_able_item_id', $financialStatementAbleItemId)
			// ->wherePivot('sub_item_type', $subItemType)
			->withPivot(['sub_item_name', 'sub_item_type', 'created_from', 'payload', 'is_depreciation_or_amortization', 'is_quantity', 'can_be_quantity', 'actual_dates', 'percentage_or_fixed', 'can_be_percentage_or_fixed', 'repeating_fixed_value', 'percentage_value', 'is_percentage_of']);
	}
	public function withSubItemsFor(int $financialStatementAbleItemId, string $subItemType = '', string $subItemName = ''): BelongsToMany
	{
		$subItemNameOperator = $subItemName ? '=' : '!=';
		$subItemTypeOperator = $subItemType ? '=' : '!=';
		$financialStatementAbleItemOperator = $financialStatementAbleItemId ? '=' : '!=';
		return $this->subItems()
			->wherePivot('financial_statement_able_item_id', $financialStatementAbleItemOperator, $financialStatementAbleItemId)
			->wherePivot('sub_item_type', $subItemTypeOperator, $subItemType)
			->wherePivot('sub_item_name', $subItemNameOperator, $subItemName);
	}
	// use  withMainRowsFor instead 
	public function mainRows(): BelongsToMany
	{
		return $this->belongsToMany(
			$this->getMainItemTableClassName(),
			'financial_statement_able_main_item_calculations',
			'financial_statement_able_id',
			'financial_statement_able_item_id'
		)
			->withPivot(['payload', 'sub_item_type', 'total', 'company_id', 'creator_id']);
	}
	public function withMainRowsFor(int $financialStatementAbleItemId, string $subItemType = '')
	{
		$operator = $subItemType ? '=' : '!=';
		return $this->mainRows()->wherePivot('financial_statement_able_item_id', $financialStatementAbleItemId)
			->wherePivot('sub_item_type', $operator, $subItemType);
	}
}
