<?php

namespace App\Models\Traits\Mutators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait FinancialStatementAbleMutator
{

	public function storeMainSection(Request $request)
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
	public function updateTotalRowsWithoutSubItemsForAdjusted(int $financialStatementAbleItemId, string $subItemType)
	{

		if ($subItemType == 'forecast' || $subItemType == 'actual') {
			$pivotForForecast = $this->withMainRowsFor($financialStatementAbleItemId, 'forecast')->get()->pluck('pivot.payload')->toArray()[0] ?? [];
			$pivotForActual = $this->withMainRowsFor($financialStatementAbleItemId, 'actual')->get()->pluck('pivot.payload')->toArray()[0] ?? [];
			$pivotForForecast = is_array($pivotForForecast) ? $pivotForForecast : (array)(json_decode($pivotForForecast));
			$pivotForActual = is_array($pivotForActual) ? $pivotForActual : (array)json_decode($pivotForActual);
			$pivotForModified = array_merge($pivotForForecast, $pivotForActual);

			$this->withMainRowsFor($financialStatementAbleItemId, 'adjusted')->detach($financialStatementAbleItemId);
			$this->withMainRowsFor($financialStatementAbleItemId, 'adjusted')->attach($financialStatementAbleItemId, [
				'payload' => json_encode(json_encode($pivotForModified)),
				'company_id' => \getCurrentCompanyId(),
				'creator_id' => Auth::id(),
			], false);


			$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->detach($financialStatementAbleItemId);
			$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->attach($financialStatementAbleItemId, [
				'payload' => json_encode(json_encode($pivotForModified)),
				'company_id' => \getCurrentCompanyId(),
				'creator_id' => Auth::id(),
			], false);
		}
	}
	public function updateTotalRowsForAdjusted(int $financialStatementAbleItemId, $subItemType): void
	{

		if ($subItemType == 'forecast' || $subItemType == 'actual') {
			$pivotForForecast = $this->withMainRowsFor($financialStatementAbleItemId, 'forecast')->get()->pluck('pivot.payload')->toArray()[0] ?? [];
			$pivotForActual = $this->withMainRowsFor($financialStatementAbleItemId, 'actual')->get()->pluck('pivot.payload')->toArray()[0] ?? [];
			$pivotForForecast = is_array($pivotForForecast) ? $pivotForForecast : (array)(json_decode($pivotForForecast));
			$pivotForActual = is_array($pivotForActual) ? $pivotForActual : (array)json_decode($pivotForActual);
			$pivotForModified = array_merge($pivotForForecast, $pivotForActual);

			$this->withMainRowsFor($financialStatementAbleItemId, 'adjusted')->detach($financialStatementAbleItemId);
			$this->withMainRowsFor($financialStatementAbleItemId, 'adjusted')->attach($financialStatementAbleItemId, [
				'payload' => json_encode($pivotForModified),
				'company_id' => \getCurrentCompanyId(),
				'creator_id' => Auth::id(),
			], false);


			$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->detach($financialStatementAbleItemId);
			$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->attach($financialStatementAbleItemId, [
				'payload' => json_encode($pivotForModified),
				'company_id' => \getCurrentCompanyId(),
				'creator_id' => Auth::id(),
			], false);
		}
	}

	public function updatePivotForAdjustedSubItems(int $financialStatementAbleItemId, string $sub_item_origin_name): void
	{
		$pivotForForecast = $this->withSubItemsFor($financialStatementAbleItemId, 'forecast', $sub_item_origin_name)->get()->pluck('pivot.payload')->toArray()[0] ?? [];
		$pivotForActual = $this->withSubItemsFor($financialStatementAbleItemId, 'actual', $sub_item_origin_name)->get()->pluck('pivot.payload')->toArray()[0] ?? [];
		$pivotForForecast = is_array($pivotForForecast) ? $pivotForForecast : (array)(json_decode($pivotForForecast));
		$pivotForActual = is_array($pivotForActual) ? $pivotForActual : (array)json_decode($pivotForActual);
		// $pivotForModified = array_merge($pivotForForecast, $pivotForActual);
		$pivotForModified = combineNoneZeroValues($pivotForForecast, $pivotForActual);
		$this->withSubItemsFor($financialStatementAbleItemId, 'adjusted', $sub_item_origin_name)->updateExistingPivot($financialStatementAbleItemId, [
			'payload' => json_encode($pivotForModified)
		]);
		// for modified also ?? 
		$this->withSubItemsFor($financialStatementAbleItemId, 'modified', $sub_item_origin_name)->updateExistingPivot($financialStatementAbleItemId, [
			'payload' => json_encode($pivotForModified)
		]);
	}
	public function syncPivotFor(int $financialStatementAbleItemId, string $sub_item_type, string $sub_item_origin_name)
	{
		if ($sub_item_type == 'forecast' || $sub_item_type == 'actual') {
			// for adjusted and modified for now 
			$this->updatePivotForAdjustedSubItems($financialStatementAbleItemId, $sub_item_origin_name);
		}
	}
	public function syncSubItemName($financialStatementAbleItemId, $subItemType, $oldName, $newName)
	{

		$this->withSubItemsFor($financialStatementAbleItemId, $subItemType, $oldName)->updateExistingPivot($financialStatementAbleItemId, [
			'sub_item_name' =>  $newName
		]);
	}
	public function syncSubItemNameForPivot(int $financialStatementAbleItemId, string $subItemType, string $oldSubItemName, string $newSubItemName)
	{
		if ($subItemType == 'forecast') {

			$this->syncSubItemName($financialStatementAbleItemId, 'actual', $oldSubItemName, $newSubItemName);
			$this->syncSubItemName($financialStatementAbleItemId, 'adjusted', $oldSubItemName, $newSubItemName);
			$this->syncSubItemName($financialStatementAbleItemId, 'modified', $oldSubItemName, $newSubItemName);
		}
		if ($subItemType == 'actual') {
			$this->syncSubItemName($financialStatementAbleItemId, 'adjusted', $oldSubItemName, $newSubItemName);
			$this->syncSubItemName($financialStatementAbleItemId, 'modified', $oldSubItemName, $newSubItemName);
		}
		if ($subItemType == 'adjusted') {
			$this->syncSubItemName($financialStatementAbleItemId, 'modified', $oldSubItemName, $newSubItemName);
		}
	}
	public function storeReport(Request $request)
	{
		$financialStatementAble = (new static)::find($request->input('financial_statement_able_id'));
		$financialStatementAbleItemId = $request->input('financial_statement_able_item_id');
		$subItemType = $request->get('sub_item_type');
		foreach ((array)$request->sub_items as $index => $options) {
			if ($options['name']  && !$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $options['name'])->exists()) {
				$insertSubItems = $subItemType == 'forecast' ? getAllFinancialAbleTypes() : [$subItemType];
				foreach ($insertSubItems as $subType) {
					$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $options['name'])->attach($financialStatementAbleItemId, [
						'company_id' => \getCurrentCompanyId(),
						'creator_id' => Auth::id(),
						'sub_item_type' => $subType,
						'sub_item_name' => $options['name'],
						'created_from' => $subItemType,
						'is_depreciation_or_amortization' => $options['is_depreciation_or_amortization'] ?? false,
						'created_at' => now()
					]);
				}
			}
		}
		foreach ((array)$request->get('value') as $financialStatementAbleId => $financialStatementAbleItems) {
			$financialStatementAble = (new static)::find($financialStatementAbleId);
			foreach ($financialStatementAbleItems as $financialStatementAbleItemId => $values) {
				foreach ($values as $sub_item_origin_name => $payload) {
					//update pivot foreach item
					if ($financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $sub_item_origin_name)->exists()) {
						$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $sub_item_origin_name)->updateExistingPivot($financialStatementAbleItemId, [
							'payload' => json_encode($payload)
						]);
					}
					$financialStatementAble->syncPivotFor($financialStatementAbleItemId, $subItemType, $sub_item_origin_name);
				}
			}
		}

		foreach ((array)$request->get('financialStatementAbleItemName') as $financialStatementAbleId => $financialStatementAbleItems) {

			foreach ($values as $sub_item_origin_name => $payload) {
				$financialStatementAble = (new static)::find($financialStatementAbleId);
				foreach ($financialStatementAbleItems as $financialStatementAbleItemId => $names) {
					foreach ($names as $oldName => $newName) {
						$financialStatementAble->syncSubItemName($financialStatementAbleItemId, $subItemType, $oldName, $newName);
						$financialStatementAble->syncSubItemNameForPivot($financialStatementAbleItemId, $subItemType, $oldName, $newName);
					}
				}
			}
		}
		// store auto Calculated values
		foreach ((array)$request->valueMainRowThatHasSubItems as $financialStatementAbleId => $financialStatementAbleItems) {
			$financialStatementAble = (new static)::find($financialStatementAbleId)->load('mainRows');
			foreach ($financialStatementAbleItems as $financialStatementAbleItemId => $payload) {
				$financialStatementAble->withMainRowsFor($financialStatementAbleItemId, $subItemType)->detach($financialStatementAbleItemId);
				$financialStatementAble->withMainRowsFor($financialStatementAbleItemId, $subItemType)->attach($financialStatementAbleItemId, [
					'payload' => json_encode($payload),
					'company_id' => \getCurrentCompanyId(),
					'creator_id' => Auth::id(),
				], false);
				$financialStatementAble->updateTotalRowsForAdjusted($financialStatementAbleItemId, $subItemType);
			}
		}

		foreach ((array)$request->valueMainRowWithoutSubItems as $financialStatementAbleId => $financialStatementAbleItems) {
			$financialStatementAble = (new static)::find($financialStatementAbleId)->load('mainRows');
			foreach ($financialStatementAbleItems as $financialStatementAbleItemId => $payload) {
				$financialStatementAble->withMainRowsFor($financialStatementAbleItemId, $subItemType)->detach($financialStatementAbleItemId);
				$financialStatementAble->withMainRowsFor($financialStatementAbleItemId, $subItemType)->attach($financialStatementAbleItemId, [
					'payload' => json_encode($payload),
					'company_id' => \getCurrentCompanyId(),
					'creator_id' => Auth::id(),
				], false);
				$financialStatementAble->updateTotalRowsWithoutSubItemsForAdjusted($financialStatementAbleItemId, $subItemType);
			}
		}
	}
}
