<?php

namespace App\Models\Traits\Mutators;

use App\Models\FinancialStatement;
use App\Models\FinancialStatementItem;
use App\Models\IncomeStatement;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

trait FinancialStatementMutator
{

	public function storeMainSection(Request $request)
	{
		return FinancialStatement::create($request->except(['_token']));
	}
	public function storeMainItems(Request $request)
	{
		// foreach (FinancialStatementItem::get() as $financialStatementItem) {

		// 	$this->withMainItemsFor($financialStatementItem->id)->attach($financialStatementItem->id, [
		// 		'company_id' => \getCurrentCompanyId(),
		// 		'creator_id' => Auth()->user()->id,
		// 		'created_at' => now()
		// 	]);
		// }
		return $this;
	}
	public function storeReport(Request $request)
	{
		// $financialStatement = FinancialStatement::find($request->input('financial_statement_id'));
		// $financialStatementItemId = $request->input('financial_statement_item_id');

		// foreach ((array)$request->sub_items as $index => $options) {
		// 	if ($options['name']  && !$financialStatement->withSubItemsFor($financialStatementItemId, $options['sub_item_type'], $options['name'])
		// 		->exists()) {
		// 		$financialStatement->withSubItemsFor($financialStatementItemId, $options['name'])->attach($financialStatementItemId, [
		// 			'company_id' => \getCurrentCompanyId(),
		// 			'creator_id' => Auth::id(),
		// 			'sub_item_name' => $options['name'],
		// 			'is_depreciation_or_amortization' => $options['is_depreciation_or_amortization'] ?? false,
		// 			'created_at' => now()
		// 		]);
		// 	}
		// }
		foreach ((array)$request->get('value') as $financialStatementId => $financialStatementItems) {
			$financialStatement = FinancialStatement::find($financialStatementId)->load('subItems');

			foreach ($financialStatementItems as $financialStatementItemId => $values) {
				foreach ($values as $sub_item_origin_name => $payload) {
					if ($financialStatement->subItems()->wherePivot('sub_item_name', $sub_item_origin_name)->where('financial_statement_items.id', $financialStatementItemId)->exists()) {
						$financialStatement->withSubItemsFor($financialStatementItemId, $sub_item_origin_name)
							// ->where('financial_statement_items.id', $financialStatementItemId)
							->wherePivot('sub_item_name', $sub_item_origin_name)
							->updateExistingPivot($financialStatementItemId, [
								'payload' => json_encode($payload)
							]);
					}
				}
			}
		}

		foreach ((array)$request->get('financialStatementItemName') as $financialStatementId => $financialStatementItems) {

			foreach ($values as $sub_item_origin_name => $payload) {
				$financialStatement = FinancialStatement::find($financialStatementId)->load('subItems');

				foreach ($financialStatementItems as $financialStatementItemId => $names) {
					$financialStatement->withSubItemsFor($financialStatementItemId, array_keys($names)[0])
						->updateExistingPivot($financialStatementItemId, [
							'sub_item_name' => array_values($names)[0]
						]);
				}
			}
		}
		// store autocaulated values
		foreach ((array)$request->valueMainRowThatHasSubItems as $financialStatementId => $financialStatementItems) {
			$financialStatement = FinancialStatement::find($financialStatementId)->load('mainRows');
			foreach ($financialStatementItems as $financialStatementItemId => $payload) {
				$financialStatement->withMainRowsFor($financialStatementItemId)->detach($financialStatementItemId);
				$financialStatement->withMainRowsFor($financialStatementItemId)->attach($financialStatementItemId, [
					'payload' => json_encode($payload),
					'company_id' => \getCurrentCompanyId(),
					'creator_id' => Auth::id(),
				], false);
			}
		}

		foreach ((array)$request->valueMainRowWithoutSubItems as $financialStatementId => $financialStatementItems) {
			$financialStatement = FinancialStatement::find($financialStatementId)->load('mainRows');
			foreach ($financialStatementItems as $financialStatementItemId => $payload) {
				$financialStatement->withMainRowsFor($financialStatementItemId)->detach($financialStatementItemId);
				$financialStatement->withMainRowsFor($financialStatementItemId)->attach($financialStatementItemId, [
					'payload' => json_encode($payload),
					'company_id' => \getCurrentCompanyId(),
					'creator_id' => Auth::id(),
				], false);
			}
		}
	}
}
