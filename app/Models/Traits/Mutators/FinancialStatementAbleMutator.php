<?php

namespace App\Models\Traits\Mutators;

use App\Models\IncomeStatement;
use App\Models\IncomeStatementItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Iterator;

trait FinancialStatementAbleMutator
{

	public function storeMainSection(Request $request)
	{
		return (new static)::create(array_merge($request->except(['_token']), ['type' => getLastSegmentFromString(get_class(new static))]));
	}
	public function storeMainItems(Request $request)
	{
		foreach (($this->getMainItemTableClassName())::get() as $financialStatementAbleItem) {
			$financialStatementAbleItemId = $financialStatementAbleItem->id;
			$this->withMainItemsFor($financialStatementAbleItemId)->attach($financialStatementAbleItemId, [
				'company_id' => getCurrentCompanyId(),
				'creator_id' => Auth()->user()->id,
				'created_at' => now()
			]);

			if ($financialStatementAbleItemId == IncomeStatementItem::CORPORATE_TAXES_ID) {
				foreach (getAllFinancialAbleTypes() as $subItemType) {
					$this->withSubItemsFor($financialStatementAbleItemId, $subItemType, 'Corporate Taxes')->attach($financialStatementAbleItemId, $this->getFinancialStatementAbleData($subItemType, 'forecast', [
						'percentage_or_fixed' => 'percentage',
						'can_be_percentage_or_fixed' => 1,
						'name' => 'Corporate Taxes',
						'percentage_value' => 0,
						'is_percentage_of' => ['Earning Before Taxes - EBT']
					]));
				}
			}
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
				'sub_item_type' => 'adjusted'
			], false);


			$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->detach($financialStatementAbleItemId);
			$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->attach($financialStatementAbleItemId, [
				'payload' => json_encode(json_encode($pivotForModified)),
				'company_id' => \getCurrentCompanyId(),
				'creator_id' => Auth::id(),
				'sub_item_type' => 'modified'

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
				'sub_item_type' => 'adjusted'
			], false);


			$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->detach($financialStatementAbleItemId);
			$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->attach($financialStatementAbleItemId, [
				'payload' => json_encode($pivotForModified),
				'company_id' => \getCurrentCompanyId(),
				'creator_id' => Auth::id(),
				'sub_item_type' => 'modified'
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
		$actualDates = [];
		$pivotForModified = combineNoneZeroValuesBasedOnComingDates($pivotForForecast, $pivotForActual, $actualDates);

		$this->withSubItemsFor($financialStatementAbleItemId, 'adjusted', $sub_item_origin_name)->updateExistingPivot($financialStatementAbleItemId, [
			'payload' => json_encode($pivotForModified),
			'actual_dates' => json_encode($actualDates)
		]);
		// for modified also ?? 
		$this->withSubItemsFor($financialStatementAbleItemId, 'modified', $sub_item_origin_name)->updateExistingPivot($financialStatementAbleItemId, [
			'payload' => json_encode($pivotForModified),
			'actual_dates' => json_encode($actualDates)
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
	public function getFinancialStatementAbleData(string $subType, string $subItemType, array $options, bool $isQuantityRepeating = false): array
	{
		$percentageOrFixed = isset($options['percentage_or_fixed']) && $options['percentage_or_fixed'] ? $options['percentage_or_fixed'] : 'non_repeating_fixed';
		if ($subType == 'actual') {
			$percentageOrFixed = 'non_repeating_fixed';
		}
		return [
			'company_id' => \getCurrentCompanyId(),
			'creator_id' => Auth::id(),
			'sub_item_type' => $subType,
			'sub_item_name' => $isQuantityRepeating ?  $options['name'] . __(' ( Quantity )') : $options['name'],
			'created_from' => $subItemType,
			'is_depreciation_or_amortization' => $options['is_depreciation_or_amortization'] ?? false,
			'is_quantity' => $isQuantityRepeating,
			'can_be_quantity' => $options['can_be_quantity'] ?? false,
			'percentage_or_fixed' => $percentageOrFixed,
			'can_be_percentage_or_fixed' => $options['can_be_percentage_or_fixed'] ?? false,
			'is_percentage_of' => $percentageOrFixed == 'percentage' ? json_encode((array)$options['is_percentage_of']) : null,
			'repeating_fixed_value' => $percentageOrFixed == 'repeating_fixed' ? $options['repeating_fixed_value'] : null,
			'percentage_value' => $percentageOrFixed == 'percentage' ? $options['percentage_value'] : null,
			'created_at' => now()
		];
	}
	public function storeReport(Request $request)
	{
		if (count((array)$request->sub_items) && !$request->has('new_sub_item_name')) {
			$validator = $request->validate([
				'sub_items.*.name' => 'required'
			], [
				'sub_items.*.name.required' => __('Please Enter SubItem Name')
			]);
			if (is_object($validator) && $validator->fails()) {
				return response()->json([
					'message' => $validator->errors()->first,
					'status' => false
				]);
			}
		}

		$financialStatementAble = (new static)::find($request->input('financial_statement_able_id'));
		$financialStatementAbleItemId = $request->input('financial_statement_able_item_id');
		$subItemType = $request->get('sub_item_type');
		if (!$request->has('new_sub_item_name')) {
			foreach ((array)$request->sub_items as $index => $options) {
				if ($options['name']  && !$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $options['name'])->exists()) {
					$insertSubItems = $this->getInsertToSubItemFields($subItemType);
					foreach ($insertSubItems as $subType) {
						if (isset($options['is_quantity']) && $options['is_quantity']) {
							foreach ([true, false] as $isQuantityRepeating) {
								$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $options['name'])->attach($financialStatementAbleItemId, $this->getFinancialStatementAbleData($subType, $subItemType, $options, $isQuantityRepeating));
							}
						} else {
							$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $options['name'])->attach($financialStatementAbleItemId, $this->getFinancialStatementAbleData($subType, $subItemType, $options));
						}
					}
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
							'payload' => json_encode($payload),
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
					'sub_item_type' => $subItemType,
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
					'sub_item_type' => $subItemType
				], false);
				$financialStatementAble->updateTotalRowsWithoutSubItemsForAdjusted($financialStatementAbleItemId, $subItemType);
			}
		}
	}
	public function getInsertToSubItemFields(string $subItemType): array
	{
		if ($subItemType == 'forecast') {
			return getAllFinancialAbleTypes();
		}
		if ($subItemType == 'actual') {
			return getAllFinancialAbleTypes(['forecast']);
		}
		return [$subItemType];
	}
}
