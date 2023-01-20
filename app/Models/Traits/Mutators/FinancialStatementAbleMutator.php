<?php

namespace App\Models\Traits\Mutators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait FinancialStatementAbleMutator
{

	public function storeMainSection(Request $request): static
	{
		return (new static)::create(array_merge($request->except(['_token']), ['type' => getLastSegmentFromString(get_class(new static))]));
	}
	public function storeMainItems(Request $request)
	{
		foreach (($this->getMainItemTableClassName())::get() as $financialStatementAbleItem) {
			$this->withMainItemsFor($financialStatementAbleItem->id)->attach($financialStatementAbleItem->id, [
				'company_id' => getCurrentCompanyId(),
				'creator_id' => Auth()->user()->id,
				'created_at' => now()
			]);
		}
		return $this;
	}
	public function storeReport(Request $request)
	{
		$financialStatementAble = (new static)::find($request->input('financial_statement_able_id'));
		$financialStatementAbleItemId = $request->input('financial_statement_able_item_id');
		$subItemType = $request->get('sub_item_type');
		foreach ((array)$request->sub_items as $index => $options) {
			if ($options['name']  && !$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $options['name'])->exists()) {
				$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $options['name'])->attach($financialStatementAbleItemId, [
					'company_id' => \getCurrentCompanyId(),
					'creator_id' => Auth::id(),
					'sub_item_name' => $options['name'],
					'is_depreciation_or_amortization' => $options['is_depreciation_or_amortization'] ?? false,
					'created_at' => now()
				]);
			}
		}
		foreach ((array)$request->get('value') as $financialStatementAbleId => $financialStatementAbleItems) {
			$financialStatementAble = (new static)::find($financialStatementAbleId);
			foreach ($financialStatementAbleItems as $financialStatementAbleItemId => $values) {
				foreach ($values as $sub_item_origin_name => $payload) {
					if ($financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $sub_item_origin_name)->exists()) {
						$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $sub_item_origin_name)->updateExistingPivot($financialStatementAbleItemId, [
							'payload' => json_encode($payload)
						]);
					}
				}
			}
		}

		foreach ((array)$request->get('financialStatementAbleItemName') as $financialStatementAbleId => $financialStatementAbleItems) {

			foreach ($values as $sub_item_origin_name => $payload) {
				$financialStatementAble = (new static)::find($financialStatementAbleId);
				foreach ($financialStatementAbleItems as $financialStatementAbleItemId => $names) {
					$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, array_keys($names)[0])->where('financial_statement_able_items.id', $financialStatementAbleItemId)->updateExistingPivot($financialStatementAbleItemId, [
						'sub_item_name' => array_values($names)[0]
					]);
				}
			}
		}
		// store autocaulated values
		foreach ((array)$request->valueMainRowThatHasSubItems as $financialStatementAbleId => $financialStatementAbleItems) {
			$financialStatementAble = (new static)::find($financialStatementAbleId)->load('mainRows');
			foreach ($financialStatementAbleItems as $financialStatementAbleItemId => $payload) {
				$financialStatementAble->withMainRowsFor($financialStatementAbleItemId)->detach($financialStatementAbleItemId);
				$financialStatementAble->withMainRowsFor($financialStatementAbleItemId)->attach($financialStatementAbleItemId, [
					'payload' => json_encode($payload),
					'company_id' => \getCurrentCompanyId(),
					'creator_id' => Auth::id(),
				], false);
			}
		}

		foreach ((array)$request->valueMainRowWithoutSubItems as $financialStatementAbleId => $financialStatementAbleItems) {
			$financialStatementAble = (new static)::find($financialStatementAbleId)->load('mainRows');
			foreach ($financialStatementAbleItems as $financialStatementAbleItemId => $payload) {
				$financialStatementAble->withMainRowsFor($financialStatementAbleItemId)->detach($financialStatementAbleItemId);
				$financialStatementAble->withMainRowsFor($financialStatementAbleItemId)->attach($financialStatementAbleItemId, [
					'payload' => json_encode($payload),
					'company_id' => \getCurrentCompanyId(),
					'creator_id' => Auth::id(),
				], false);
			}
		}
	}
}
