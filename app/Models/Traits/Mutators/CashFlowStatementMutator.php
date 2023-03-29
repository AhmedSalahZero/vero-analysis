<?php

namespace App\Models\Traits\Mutators;

use App\Models\CashFlowStatement;
use App\Models\CashFlowStatementItem;
use App\Models\IncomeStatement;
use App\Models\IncomeStatementItem;
use Illuminate\Http\Request;

trait CashFlowStatementMutator
{
	use FinancialStatementAbleMutator;
	public function getCashFlowStatementItemIdFromIncomeStatementItemId(int $incomeStatementItemId)
	{
		if ($incomeStatementItemId === IncomeStatementItem::SALES_REVENUE_ID) {
			return CashFlowStatementItem::CASH_IN_ID;
		}
		return CashFlowStatementItem::CASH_OUT_ID;
	}
	public function subItemCollectionPolicy(int $incomeStatementId, int $incomeStatementItemId, string $subItemType, string $subItemName): array
	{
		$incomeStatement = IncomeStatement::find($incomeStatementId);
		$subItem =  $incomeStatement->withSubItemsFor($incomeStatementItemId, $subItemType, $subItemName)->first();
		$collection_policy_value = $subItem->pivot->collection_policy_value;
		return [
			'has_collection_policy' => $subItem->pivot->has_collection_policy,
			'collection_policy_type' => $collection_policy_type = $subItem->pivot->collection_policy_type,
			'collection_policy_value' => $collection_policy_type == 'customize' ? (array)json_decode($collection_policy_value) : $collection_policy_value
		];
	}
	public function formatSubItems(Request $request)
	{
		$values = [];
		$subItems = (array)$request->sub_items; // when in add or edit modal (mode)
		foreach ($subItems as $index => $subItemOptions) {
			$incomeStatementId = $request->get('financial_statement_able_id');
			$cashFlowStatementId = $request->get('cash_flow_statement_id');
			$incomeStatementItemId = $request->get('financial_statement_able_item_id');
			$cashFlowStatementItemId = $this->getCashFlowStatementItemIdFromIncomeStatementItemId($incomeStatementItemId);
			$subItemName = $subItemOptions['name'];
			if (isset($subItemOptions['collection_policy']['has_collection_policy'])) {
				$values[$cashFlowStatementId][$cashFlowStatementItemId][$subItemName] = applyCollectionPolicy($subItemOptions['collection_policy']['type']['name'], $subItemOptions['collection_policy']['type']['value'], $request->value[$incomeStatementId][$incomeStatementItemId][$subItemName]);
			}
		}
		if (!count($subItems)) // in submit form 
		{
			$cashFlowStatementId = $request->get('cash_flow_statement_id');
			$subItemType = $request->get('sub_item_type');
			foreach ((array)$request->value as $incomeStatementId => $incomeStatementItemIdAndSubItems) {
				foreach ($incomeStatementItemIdAndSubItems as $incomeStatementItemId => $subItemsNamesAndValues) {
					$cashFlowStatementItemId = $this->getCashFlowStatementItemIdFromIncomeStatementItemId($incomeStatementItemId);
					foreach ($subItemsNamesAndValues as $subItemName => $dateValue) {
						$collection_policy = $this->subItemCollectionPolicy($incomeStatementId, $incomeStatementItemId, $subItemType, $subItemName);
						if ($collection_policy['has_collection_policy']) {
							$values[$cashFlowStatementId][$cashFlowStatementItemId][$subItemName] = applyCollectionPolicy($collection_policy['collection_policy_type'], $collection_policy['collection_policy_value'], $dateValue);
						}
					}
				}
			}
		}
		return $values;
	}
	public function formatTotalForMainItem(array $array): array
	{
		$result  = [
			'main_rows' => [],
			'total' => []
		];
		foreach ($array as $cashFlowStatementId => $items) {
			foreach ($items as $cashFlowStatementItemId => $subItemsWithDateValues) {
				foreach ($subItemsWithDateValues as $subItemName => $dateValues) {
					foreach ($dateValues as $date => $value) {
						$oldValue = $result['main_rows'][$cashFlowStatementId][$cashFlowStatementItemId][$date] ?? 0;
						$result['main_rows'][$cashFlowStatementId][$cashFlowStatementItemId][$date] = $oldValue + $value;
					}
					$result['total'][$cashFlowStatementId][$cashFlowStatementItemId] = array_sum($result['main_rows'][$cashFlowStatementId][$cashFlowStatementItemId] ?? []);
				}
			}
		}
		return $result;
	}
	public function replaceIncomeStatementItemIdWithCashFlowStatementId(array $items): array
	{
		$formatted = [];
		foreach ($items as $incomeStatementItemId => $oldSubItemsWithNewSubItemName) {
			$cashFlowStatementItemId = $this->getCashFlowStatementItemIdFromIncomeStatementItemId($incomeStatementItemId);
			$formatted[$cashFlowStatementItemId] =  $oldSubItemsWithNewSubItemName;
		}
		return $formatted;
	}
	public function formatDataFromIncomeStatement(Request $request): array
	{
		$cashFlowStatementId = $request->get('cash_flow_statement_id');
		$incomeStatementId = $request->get('income_statement_id');
		$values = $this->formatSubItems($request);
		$mainRowValuesWithTotal = $this->formatTotalForMainItem($values);

		$financialStatementAbleItemName[$cashFlowStatementId] = $this->replaceIncomeStatementItemIdWithCashFlowStatementId($request->financialStatementAbleItemName[$incomeStatementId]);

		return [
			'value' => $values,
			'valueMainRowThatHasSubItems' => $mainRowValuesWithTotal['main_rows'],
			'totals' => $mainRowValuesWithTotal['total'],
			'financialStatementAbleItemName' => $financialStatementAbleItemName
		];
	}
}
