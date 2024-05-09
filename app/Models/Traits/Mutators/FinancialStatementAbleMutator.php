<?php

namespace App\Models\Traits\Mutators;

use App\Jobs\RecalculateIncomeStatementCalculationForTypesJob;
use App\Models\CashFlowStatement;
use App\Models\CashFlowStatementItem;
use App\Models\IncomeStatement;
use App\Models\IncomeStatementItem;
use App\Rules\MustBeUniqueToIncomeStatement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


trait FinancialStatementAbleMutator
{
	public function storeMainSection(Request $request):self
	{
		$financialStatementAble = (new static)::create(array_merge($request->except(['_token']), ['can_view_actual_report'=>0,'type' => getLastSegmentFromString(get_class(new static))]));

		return $financialStatementAble;
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
			$payloadForMainRow = $this->withMainRowsFor($financialStatementAbleItemId, 'modified')->first() ;
			$payloadForMainRow =  $payloadForMainRow && $payloadForMainRow->pivot ? (array) json_decode($payloadForMainRow->pivot->payload) : null;
			
			if($payloadForMainRow){
				$pivotForForecast = $this->withMainRowsFor($financialStatementAbleItemId, 'modified')->get()->pluck('pivot.payload')->toArray()[0] ?? [];
			}
			$pivotForActual = $this->withMainRowsFor($financialStatementAbleItemId, 'actual')->get()->pluck('pivot.payload')->toArray()[0] ?? [];
			$pivotForForecast = is_array($pivotForForecast) ? $pivotForForecast : (array)(json_decode($pivotForForecast));
			$pivotForActual = is_array($pivotForActual) ? $pivotForActual : (array)json_decode($pivotForActual);
			$actualDates = [];
			$pivotForModified = combineNoneZeroValuesBasedOnComingDates($pivotForForecast, $pivotForActual, $actualDates);
			
			
			// and here
			$this->withMainRowsFor($financialStatementAbleItemId, 'adjusted')->detach($financialStatementAbleItemId);
			$this->withMainRowsFor($financialStatementAbleItemId, 'adjusted')->attach($financialStatementAbleItemId, [
				'payload' => json_encode($pivotForModified),
				'company_id' => \getCurrentCompanyId(),
				'creator_id' => Auth::id(),
				'total' => in_array($financialStatementAbleItemId, ($this->getMainItemTableClassName())::percentageOfSalesRows()) ? getTotalOfSalesRevenueFor($this->id, 'adjusted', $financialStatementAbleItemId) : array_sum($pivotForModified),
				'sub_item_type' => 'adjusted'
			], false);



		
	
			
				$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->detach($financialStatementAbleItemId);
				$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->attach($financialStatementAbleItemId, [
					'payload' => json_encode($pivotForModified),
					'total' => in_array($financialStatementAbleItemId, ($this->getMainItemTableClassName())::percentageOfSalesRows()) ? getTotalOfSalesRevenueFor($this->id, 'adjusted', $financialStatementAbleItemId) : array_sum($pivotForModified),
					'company_id' => \getCurrentCompanyId(),
					'creator_id' => Auth::id(),
					'sub_item_type' => 'modified'

				], false);
			
			// }
			
		}
	}

	public function updateTotalRowsForAdjusted(int $financialStatementAbleItemId, $subItemType): void
	{
		if ($subItemType == 'forecast' || $subItemType == 'actual') {
			$pivotForForecast = $this->withMainRowsFor($financialStatementAbleItemId, 'forecast')->get()->pluck('pivot.payload')->toArray()[0] ?? [];
			$payloadForMainRow = $this->withMainRowsFor($financialStatementAbleItemId, 'modified')->first() ;
			$payloadForMainRow =  $payloadForMainRow && $payloadForMainRow->pivot ? (array) json_decode($payloadForMainRow->pivot->payload) : null;
			if($payloadForMainRow){
				$pivotForForecast = $this->withMainRowsFor($financialStatementAbleItemId, 'modified')->get()->pluck('pivot.payload')->toArray()[0] ?? [];
			}
			$pivotForActual = $this->withMainRowsFor($financialStatementAbleItemId, 'actual')->get()->pluck('pivot.payload')->toArray()[0] ?? [];
			$pivotForForecast = is_array($pivotForForecast) ? $pivotForForecast : (array)(json_decode($pivotForForecast));
			$pivotForActual = is_array($pivotForActual) ? $pivotForActual : (array)json_decode($pivotForActual);
			$actualDates = [];
			
			$pivotForModified = combineNoneZeroValuesBasedOnComingDates($pivotForForecast, $pivotForActual, $actualDates);
			// and here
			
			$this->withMainRowsFor($financialStatementAbleItemId, 'adjusted')->detach($financialStatementAbleItemId);
			$this->withMainRowsFor($financialStatementAbleItemId, 'adjusted')->attach($financialStatementAbleItemId, [
				'payload' => json_encode($pivotForModified),
				'company_id' => \getCurrentCompanyId(),
				'creator_id' => Auth::id(),
				'total' => array_sum($pivotForModified),
				'sub_item_type' => 'adjusted'
			], false);
				
			
				$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->detach($financialStatementAbleItemId);
				$this->withMainRowsFor($financialStatementAbleItemId, 'modified')->attach($financialStatementAbleItemId, [
					'payload' => json_encode($pivotForModified),
					'company_id' => \getCurrentCompanyId(),
					'creator_id' => Auth::id(),
					'total' => array_sum($pivotForModified),
					'sub_item_type' => 'modified'
				], false);
		}
	}

	public function updatePivotForAdjustedSubItems(int $financialStatementAbleItemId, string $sub_item_origin_name,?string $isValueQuantityPrice ): void
	{
		$pivotForForecast = $this->withSubItemsFor($financialStatementAbleItemId, 'forecast', $sub_item_origin_name)->get()->pluck('pivot.payload')->toArray()[0] ?? [];
		// $payloadForSubRow = $this->withSubItemsFor($financialStatementAbleItemId, 'modified', $sub_item_origin_name)->first() ;
		// $payloadForSubRow =  $payloadForSubRow && $payloadForSubRow->pivot ? (array) json_decode($payloadForSubRow->pivot->payload) : null;
		// if($payloadForSubRow){
		// 	$pivotForForecast = $this->withSubItemsFor($financialStatementAbleItemId, 'modified', $sub_item_origin_name)->get()->pluck('pivot.payload')->toArray()[0] ?? [];
		// }
		$pivotForActual = $this->withSubItemsFor($financialStatementAbleItemId, 'actual', $sub_item_origin_name)->get()->pluck('pivot.payload')->toArray()[0] ?? [];
		
		$pivotForForecast = is_array($pivotForForecast) ? $pivotForForecast : (array)(json_decode($pivotForForecast));
		$pivotForActual = is_array($pivotForActual) ? $pivotForActual : (array)json_decode($pivotForActual);
		$actualDates = [];
		$pivotForModified = combineNoneZeroValuesBasedOnComingDates($pivotForForecast, $pivotForActual, $actualDates);
	
		$dataArr =  [
			'payload' => json_encode($pivotForModified),
			'actual_dates' => json_encode($actualDates),
		];
	
		if($isValueQuantityPrice){
			$dataArr['is_value_quantity_price'] = $isValueQuantityPrice ; 
		}
		$this->withSubItemsFor($financialStatementAbleItemId, 'adjusted', $sub_item_origin_name)->updateExistingPivot($financialStatementAbleItemId,$dataArr);
			
			$dataArr = [
				'payload' => json_encode($pivotForModified),
				'actual_dates' => json_encode($actualDates),
			];
			if($isValueQuantityPrice){
				$dataArr['is_value_quantity_price'] = $isValueQuantityPrice;
			}
			$this->withSubItemsFor($financialStatementAbleItemId, 'modified', $sub_item_origin_name)->updateExistingPivot($financialStatementAbleItemId, $dataArr);
	}

	public function syncPivotFor(int $financialStatementAbleItemId, string $sub_item_type, string $sub_item_origin_name,?string $isValueQuantityPrice )
	{
		if ($sub_item_type == 'forecast' || $sub_item_type == 'actual') {
			// for adjusted and modified for now
			$this->updatePivotForAdjustedSubItems($financialStatementAbleItemId, $sub_item_origin_name,$isValueQuantityPrice );
		}
	}

	public function syncSubItemName($financialStatementAbleItemId, $subItemType, $oldName, $newName)
	{
		$this->withSubItemsFor($financialStatementAbleItemId, $subItemType, $oldName)->updateExistingPivot($financialStatementAbleItemId, [
			// not this
			'sub_item_name' =>  html_entity_decode($newName),
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
		$collectionPolicyType = $options['collection_policy']['type']['name'] ?? null;

		$collection_value = null;
		if (isset($options['collection_policy']['type'][$collectionPolicyType]['value']) && is_array($options['collection_policy']['type'][$collectionPolicyType]['value'])) {
			$collection_value = json_encode($options['collection_policy']['type'][$collectionPolicyType]['value']);
		} elseif (isset($options['collection_policy']['type'][$collectionPolicyType]['value'])) {
			$collection_value = $options['collection_policy']['type'][$collectionPolicyType]['value'];
		}
		$adjustedOrModified = $subType == 'adjusted' || $subType == 'modified' ;
		$subItemName = $isQuantityRepeating ? html_entity_decode($options['name'] . __(quantityIdentifier)) : html_entity_decode($options['name']);
		$percentageOf= $percentageOrFixed == 'percentage' ? json_encode((array)$options['is_percentage_of']) : null;
		$percentageOf = $adjustedOrModified  ? json_encode(getMappingFromForecastToAdjustedOrModified($percentageOf,$subType)) : $percentageOf;
		$costOfUnitOf = $percentageOrFixed == 'cost_of_unit' ? json_encode((array)$options['is_cost_of_unit_of']) : null;
		$costOfUnitOf = $adjustedOrModified  ? json_encode(getMappingFromForecastToAdjustedOrModified($costOfUnitOf,$subType)) : $costOfUnitOf;
		
		return [
			'company_id' => \getCurrentCompanyId(),
			'creator_id' => Auth::id(),
			'sub_item_type' => $subType,
			'sub_item_name' => $subItemName,
			'created_from' => $subItemType,
			'is_depreciation_or_amortization' => $options['is_depreciation_or_amortization'] ?? 0,
			'has_collection_policy' => $options['collection_policy']['has_collection_policy'] ?? false,
			'collection_policy_type' => $collectionPolicyType,
			'collection_policy_value' => $collection_value,
			'is_quantity' => $isQuantityRepeating,
			'can_be_quantity' => $options['can_be_quantity'] ?? false,
			'is_value_quantity_price' => $options['is_value_quantity_price'] ?? 'value',
			'percentage_or_fixed' => $percentageOrFixed,
			'can_be_percentage_or_fixed' => $options['can_be_percentage_or_fixed'] ?? false,
			'is_percentage_of' =>$percentageOf ,
			'is_cost_of_unit_of' => $costOfUnitOf,
			'repeating_fixed_value' => $percentageOrFixed == 'repeating_fixed' ? $options['repeating_fixed_value'] : null,
			'percentage_value' => $percentageOrFixed == 'percentage' ? $options['percentage_value'] : null,
			'cost_of_unit_value' => $percentageOrFixed == 'cost_of_unit' ? $options['cost_of_unit_value'] : null,
			'is_financial_expense' => isset($options['is_financial_expense']) && $options['is_financial_expense'],
			'is_financial_income' => isset($options['is_financial_income']) && $options['is_financial_income'],
			'vat_rate' => $subType =='forecast'&& isset($options['vat_rate'])  ? $options['vat_rate'] : 0,
			'is_deductible' => $subType =='forecast' && isset($options['is_deductible'])  ? $options['is_deductible'] : 0,
			'created_at' => now()
		];
	}

	public function storeReport(Request $request)
	{
		// names of new added element in add popup
		$newAddedElements = $request->get('new_added_elements',[]) ;
		$newAddedElements = is_array($newAddedElements) ? $newAddedElements: explode(',',$newAddedElements);
		// NOTE:if you want to edit (update single item in popup ) search for the following text [NOTE:We update Single Item From Popup Here]
			$salesRevenuesForVat = [];
			$expensesForVat = [];
		if ($request->get('in_add_or_edit_modal') && count((array)$request->sub_items) && !$request->has('new_sub_item_name')) {
			$validator = $request->validate([
				'sub_items.*.name' =>['required',new MustBeUniqueToIncomeStatement(getCurrentCompanyId(),$request->input('financial_statement_able_id'),)],
				'sub_items.*.collection_policy'=>'sometimes|required|array',
				'sub_items.*.collection_policy.type'=>'sometimes|required|array',
				'sub_items.*.collection_policy.type.name'=>'sometimes|required'
			], [
				'sub_items.*.name.required' => __('Please Enter SubItem Name'),
				'sub_items.*.collection_policy.required'=>__('Please Enter Collection / Payment Policy'),
				'sub_items.*.collection_policy.type.required'=>__('Please Enter Collection / Payment Policy'),
				'sub_items.*.collection_policy.type.name.required'=>__('Please Enter Collection / Payment Policy'),
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
		$cashFlowStatement = new CashFlowStatement();
		$subItemsValues = (array)$request->get('value');
		$subItemType = $request->get('sub_item_type');
		$insertSubItems = $this->getInsertToSubItemFields($subItemType);
		$vats = [];
		
		if (!$request->has('new_sub_item_name')) {
			foreach ((array)$request->sub_items as $index => $options) {
				if (isset($options['name']) && $options['name']  && !$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $options['name'])->exists()) {
					foreach ($insertSubItems as $subType) {
						$isQuantity = isQuantity($options) ;
						$isValue = isset($options['val']);
						if (($isQuantity || $isValue) && get_class($this) != CashFlowStatement::class) {
							foreach ([true, false] as $isQuantityRepeating) {
								if(!$isQuantity && $isValue && $isQuantityRepeating){
									continue;
								}
								$quantityVal = $options['quantity'] ?? 0;
								$val = $options['val'] ?? 0;
								$payload = $isQuantityRepeating ? $quantityVal : $val;
								$name = $isQuantityRepeating ? $options['name'] . quantityIdentifier : $options['name'];
								$subItemsValues[$financialStatementAble->id][$financialStatementAbleItemId][$name] = $payload;
								$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $options['name'])->attach($financialStatementAbleItemId, $this->getFinancialStatementAbleData($subType, $subItemType, $options, $isQuantityRepeating));
							}
						} else {
							$financialStatementAbleItemOrCashFlowStatementItemId = get_class($this) != CashFlowStatement::class ? $financialStatementAbleItemId : $cashFlowStatement->getCashFlowStatementItemIdFromIncomeStatementItemId($financialStatementAbleItemId, isset($options['is_financial_income']) && $options['is_financial_income']);
							$financialStatementAble->withSubItemsFor($financialStatementAbleItemOrCashFlowStatementItemId, $subItemType, $options['name'])->attach($financialStatementAbleItemOrCashFlowStatementItemId, $this->getFinancialStatementAbleData($subType, $subItemType, $options));
						}
					}
				}
			}
		}

		foreach ($subItemsValues as $financialStatementAbleId => $financialStatementAbleItems) {
			$financialStatementAble = (new static)::find($financialStatementAbleId);
			foreach ($financialStatementAbleItems as $financialStatementAbleItemId => $values) {
				foreach ($values as $sub_item_origin_name => $payload) {
					$firstElement = $financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $sub_item_origin_name)->first() ;
					$pivotForElement =$firstElement ? $firstElement->pivot : null;
					
						// run vat method to calculate vat payment for cash flow statement 
						$vatRate = $pivotForElement ? $pivotForElement->vat_rate : 0  ;
						$isDeductible = $pivotForElement ? $pivotForElement->is_deductible : 0 ;
						$vats[$financialStatementAbleId][$sub_item_origin_name]=['vat_rate'=>$vatRate,'isDeductible'=>$isDeductible] ;
						$payloadForSalesRevenue = $pivotForElement ? (array) json_decode($pivotForElement->payload):[] ;
						if($financialStatementAbleItemId == IncomeStatementItem::SALES_REVENUE_ID){
							$salesRevenuesForVat[] = ['vat_rate'=>$vatRate , 'is_deductible'=>$isDeductible , 'values'=>changeDateFormatOfArrTo($payloadForSalesRevenue,'d-m-Y') ];
						}
						elseif($isDeductible){
							$expensesForVat[] = ['vat_rate'=>$vatRate , 'is_deductible'=>$isDeductible , 'values' =>changeDateFormatOfArrTo($payloadForSalesRevenue,'d-m-Y') ];
						}
						
					
					
						
					$subItemAlreadyExist = $financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $sub_item_origin_name)->exists();
					

					if ($financialStatementAbleItemId == IncomeStatementItem::SALES_REVENUE_ID && $request->get('in_add_or_edit_modal')) {
						$subItemsNames = formatSubItemsNamesForQuantity($sub_item_origin_name);
						$payloadForValue = $request->sub_items[0]['val'] ?? [];
						$payloadForQuantity = $request->sub_items[0]['quantity'] ?? [];
						$isValueQuantityPrice = $request->sub_items[0]['is_value_quantity_price'] ?? 'value';
						if ($request->sub_item_name == $sub_item_origin_name ) {
							$hadQuantityRow = $financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $subItemsNames['quantity'])->count();
							$isCheckedAsQuantity = isQuantity((array)$request->sub_items[0]);
							// if no quantity row then it is checked to be quantity row
							$payload = $payloadForValue;
							$subItemsValues[$financialStatementAbleId][$financialStatementAbleItemId][$sub_item_origin_name] = $payloadForValue;
							if ($isCheckedAsQuantity) {
								$subItemsValues[$financialStatementAbleId][$financialStatementAbleItemId][$subItemsNames['quantity']] = $payloadForQuantity;
							}
							if (!$hadQuantityRow && $isCheckedAsQuantity) {
								foreach (getAllFinancialAbleTypes() as $currentSubItemType) {
									$pivotForNewQuantity = $financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $subItemsNames['value'])->first() ?  $financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $subItemsNames['value'])->first()->pivot->toArray() :[];
								
									$pivotForNewQuantity = array_merge($pivotForNewQuantity, [
										'is_quantity' => 1,
										'can_be_quantity' => 1,
										'is_value_quantity_price' => $isValueQuantityPrice ,
										'sub_item_type' => $currentSubItemType,
										'created_from' => $subItemType,
										'payload' => json_encode($payloadForQuantity),
										// not this
										'sub_item_name' => $subItemsNames['quantity'],
										'company_id' => getCurrentCompanyId()
									]);
									
									unset($pivotForNewQuantity['id']);
									
									$subItemsValues[$financialStatementAbleId][$financialStatementAbleItemId][$subItemsNames['quantity']] = $payloadForQuantity;
									$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $subItemsNames['quantity'])->attach(
										$financialStatementAbleItemId,
										$pivotForNewQuantity
									);
								}
							}
							if ($hadQuantityRow && !$isCheckedAsQuantity || !$isCheckedAsQuantity) {
								foreach (getAllFinancialAbleTypes() as $currentSubItemType) {
									$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $currentSubItemType, $subItemsNames['quantity'])->detach();
								}
							} else {
								$payloadData = [
									'payload' => json_encode($payloadForQuantity),
									'is_value_quantity_price'=>$isValueQuantityPrice
								];
								
								$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $subItemsNames['quantity'])->updateExistingPivot($financialStatementAbleItemId, $payloadData);
							}
						}
					}

					if ($subItemAlreadyExist) {
						$inPopup = isset($request->sub_items[0]) && isset($request->sub_items[0]['vat_rate']) && is_numeric($request->sub_items[0]['vat_rate']) && $request->get('sub_item_name') == $sub_item_origin_name ;
						$isDeductible = $inPopup ? ($request->sub_items[0]['is_deductible']??0) : $pivotForElement->is_deductible;
						$vatRate = $inPopup ? $request->sub_items[0]['vat_rate'] : $pivotForElement->vat_rate;
						$vatArr = $request->get('sub_item_name') == $sub_item_origin_name  ? [
							'is_deductible'=>$isDeductible,
							// not this
							'vat_rate'=>$vatRate 
							] : [];
							
							$vatRate = ($request->has('in_edit_mode') && $request->get('sub_item_name') == $sub_item_origin_name )  || in_array($sub_item_origin_name , $newAddedElements )  ?  $vatRate     : 0    ;
							
						
						$financialStatementAble->withSubItemsFor($financialStatementAbleItemId, $subItemType, $sub_item_origin_name)->updateExistingPivot($financialStatementAbleItemId,array_merge(
							[
								'payload' => json_encode($this->calculatePayloadWithVat($payload ,$subItemType,$isDeductible , $vatRate,$financialStatementAbleItemId )),
							],
							$vatArr
						));
					}
					// sync pivot here
					$financialStatementAble->syncPivotFor($financialStatementAbleItemId, $subItemType, $sub_item_origin_name,null);
				}
			}
		}
		
		$start = microtime(true);

		foreach ((array)$request->get('financialStatementAbleItemName') as $financialStatementAbleId => $financialStatementAbleItems) {
			$financialStatementAble = (new static)::find($financialStatementAbleId);
			foreach ($financialStatementAbleItems as $financialStatementAbleItemId => $names) {
				foreach ($names as $oldName => $newName) {
					$financialStatementAble->syncSubItemName($financialStatementAbleItemId, $subItemType, $oldName, $newName);
					$financialStatementAble->syncSubItemNameForPivot($financialStatementAbleItemId, $subItemType, $oldName, $newName);
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
					'total' => $request->totals[$financialStatementAbleId][$financialStatementAbleItemId],
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
					'total' => $request->totals[$financialStatementAbleId][$financialStatementAbleItemId],
					'sub_item_type' => $subItemType
				], false);
				$financialStatementAble->updateTotalRowsWithoutSubItemsForAdjusted($financialStatementAbleItemId, $subItemType);
			}
		}
		if (get_class($this) == IncomeStatement::class || ($request->get('in_add_or_edit_modal') && $request->get('financial_statement_able_item_id') == IncomeStatementItem::SALES_REVENUE_ID)) {
			foreach ($insertSubItems as $index=>$insertSubItem) {
				if($index ==0 ) // current type
				{
					$financialStatementAble->refreshCalculationFor($insertSubItem);
				}else{
					if(env('APP_ENV') =='local'){
						$financialStatementAble->refreshCalculationFor($insertSubItem);
					}
					else{
						$financialStatementAble['is_caching_'.$insertSubItem] = 1 ;
						$financialStatementAble->save();
						$job = (new RecalculateIncomeStatementCalculationForTypesJob($financialStatementAble,$insertSubItem));
						dispatch($job)	;
					}
				}
			}
		}
	
		$financialStatementAble->can_view_actual_report = 1 ;
		$financialStatementAble->save();
		

		return $financialStatementAble;
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
	
	public function calculateVat($vat){
		#FIXME:REMOVE THIS
		// return 1 ;
		
		
		return (1+$vat/100) ;
	}

	public function updateCostOfUnitAndPercentagesOfSubItems(Collection $subItemsForCurrentIncomeStatementItem, array $dates, string $subItemType,bool $debug): void
	{
		$salesRevenueId = IncomeStatementItem::SALES_REVENUE_ID;
		$salesRevenuesSubItemsArray = $this->withSubItemsFor($salesRevenueId, $subItemType)->get()->keyBy(function ($salesRevenueSubItem) {
			return $salesRevenueSubItem->pivot->id;
		})->map(function ($salesRevenuePivotSubItem) {
			return (array)json_decode($salesRevenuePivotSubItem->pivot->payload);
		})->toArray();
		
		foreach ($subItemsForCurrentIncomeStatementItem as $subItem) {
			$financialStatementAbleItemId = $subItem->pivot->financial_statement_able_item_id;
			$subItemName = $subItem->pivot->sub_item_name;
			$values = [];
			$payload = json_decode($subItem->pivot->payload);
			$subItemPivotType = $subItem->pivot->percentage_or_fixed;
			$isPercentage = $subItemPivotType == 'percentage';
			$isCostOfUnit = $subItemPivotType == 'cost_of_unit';
			$isFinancialExpense = $subItem->pivot->is_financial_expense;
			
			if ($isPercentage && $subItemName == 'Corporate Taxes') {
				// will update it in another place while updating main row for earning before tax
				// search for the following comment to find it
				// update sub items of corporate taxes [needs to be here]
			} elseif ($isPercentage) {
				$percentageValue  = $subItem->pivot->percentage_value ?: 0;
				
				if ($isFinancialExpense && $percentageValue >0) {
					$percentageValue = $percentageValue * -1;
				}
				$percentageValue = $percentageValue / 100;
				$percentagesOf = stringArrayToArray($subItem->pivot->is_percentage_of);
				
				foreach ($dates as $date => $formattedDate) {
					$totalPercentageOfValue = 0;
					foreach ($percentagesOf as $percentageOf) {
						$loopPercentageValueOfSalesRevenue = $salesRevenuesSubItemsArray[$percentageOf][$date] ?? 0;
						$totalPercentageOfValue += $loopPercentageValueOfSalesRevenue;
					}
					if (isActualDateInModifiedOrAdjusted($date, $subItemType)) {
						$values[$financialStatementAbleItemId][$subItemName][$date] = isset($payload->{$date}) ? $payload->{$date} : 0;
					} else {
						$percentageVal = $percentageValue * $totalPercentageOfValue ;
						if($subItemType == 'forecast' && !$subItem->pivot->is_deductible){
							$vatValue =  1 ;
							if($financialStatementAbleItemId != IncomeStatementItem::SALES_REVENUE_ID){
								$vatValue = $this->calculateVat($subItem->pivot->vat_rate) ;
							}
							$percentageVal = $percentageVal* $vatValue;
						}
						$values[$financialStatementAbleItemId][$subItemName][$date] = $percentageVal ;
					}
				}
				
				$this->withSubItemsFor($financialStatementAbleItemId, $subItemType, $subItemName)->updateExistingPivot($financialStatementAbleItemId, [
					'payload' => json_encode($values[$financialStatementAbleItemId][$subItemName]),
					'is_deductible'=>$subItem->pivot->is_deductible,
					'vat_rate'=>$subItem->pivot->vat_rate
				]);
			} elseif ($isCostOfUnit) {
				$costOfUnitsOf = stringArrayToArray($subItem->pivot->is_cost_of_unit_of);
				$costOfUnitValue = $subItem->pivot->cost_of_unit_value ?: 0;
				if ($isFinancialExpense && $costOfUnitValue >0) {
					$costOfUnitValue = $costOfUnitValue * -1;
				}
				foreach ($dates as $date => $formattedDate) {
					$totalCostOfUnitValue = 0;
					foreach ($costOfUnitsOf as $costOfUnitOf) {
						$totalCostOfUnitValue += $salesRevenuesSubItemsArray[$costOfUnitOf][$date] ?? 0;
					}
					if (isActualDateInModifiedOrAdjusted($date, $subItemType)) {
						$values[$financialStatementAbleItemId][$subItemName][$date] = $payload->{$date} ?: 0;
					} else {
						$vatValue = 1 ;
						
						if( $subItemType == 'forecast' && !$subItem->pivot->is_deductible && $financialStatementAbleItemId != IncomeStatementItem::SALES_REVENUE_ID){
								$vatValue = $this->calculateVat($subItem->pivot->vat_rate) ;
						}
						$values[$financialStatementAbleItemId][$subItemName][$date] = $costOfUnitValue * $totalCostOfUnitValue * $vatValue;
					}
				}
				$this->withSubItemsFor($financialStatementAbleItemId, $subItemType, $subItemName)->updateExistingPivot($financialStatementAbleItemId, [
					'payload' => json_encode($values[$financialStatementAbleItemId][$subItemName]),
					'is_deductible'=>$subItem->pivot->is_deductible,
					'vat_rate'=>$subItem->pivot->vat_rate
				]);
			}
		}
	}

	public function refreshCalculationFor(string $subItemType)
	{
		$dates = $this->getIntervalFormatted();
		$allMainItems = $this->mainItems()->get();
		$totals = [];
		$debug = false ;
		foreach ($allMainItems as $mainItem) {
			$incomeStatementItemId = $mainItem->id;
			$oldSubItemsForCurrentMainItem = $this->withSubItemsFor($incomeStatementItemId, $subItemType)->get();
			if($subItemType == 'adjusted' && $mainItem->id == 7){
				$debug = true ;
			}
			$this->updateCostOfUnitAndPercentagesOfSubItems($oldSubItemsForCurrentMainItem, $dates, $subItemType,$debug);

			$subItems = $this->withSubItemsFor($incomeStatementItemId, $subItemType)->get()->keyBy(function ($subItem) {
				return $subItem->pivot->sub_item_name;
			})->map(function ($subItem) {
				$pivot = $subItem->pivot;
				// cache::fore
				return [
					'options' => [
						'name' => $pivot->sub_item_name,
						'sub_item_type' => $pivot->sub_item_type,
						'payload' => $pivot->payload ? (array)json_decode($pivot->payload) : [],
						'sub_item_type' => $pivot->sub_item_type,
						'has_collection_policy' => $pivot->has_collection_policy,
						'collection_policy_type' => $pivot->collection_policy_type,
						'collection_policy_value' => $pivot->collection_policy_value,
						'is_quantity' => $pivot->is_quantity,
						'can_be_quantity' => $pivot->can_be_quantity,
						'is_value_quantity_price'=>$pivot->is_value_quantity_price,
						'actual_dates' => $pivot->actual_dates,
						'is_depreciation_or_amortization' => $pivot->is_depreciation_or_amortization ?: 0,
						'percentage_or_fixed' => $pivot->percentage_or_fixed,
						'can_be_percentage_or_fixed' => $pivot->can_be_percentage_or_fixed,
						'repeating_fixed_value' => $pivot->repeating_fixed_value,
						'percentage_value' => $pivot->percentage_value ?: 0,
						'cost_of_unit_value' => $pivot->cost_of_unit_value ?: 0,
						'is_financial_expense' => $pivot->is_financial_expense ?: 0,
						'is_financial_income' => $pivot->is_financial_income ?: 0,
						'is_deductible'=>$pivot->is_deductible,
						'vat_rate'=>$pivot->vat_rate,
						'parent' => [
							'name' => $subItem->name,
							'has_sub_items' => $subItem->has_sub_items,
							'has_depreciation_or_amortization' => $subItem->has_depreciation_or_amortization,
							'has_percentage_or_fixed_sub_items' => $subItem->has_percentage_or_fixed_sub_items,
							'financial_statement_able_type' => $subItem->financial_statement_able_type,
							'is_main_for_all_calculations' => $subItem->is_main_for_all_calculations,
							'is_sales_rate' => $subItem->is_sales_rate,
							'for_interval_comparing' => $subItem->for_interval_comparing,
							'depends_on' => $subItem->depends_on,
							'equation' => $subItem->equation,
							'has_auto_depreciation' => $subItem->has_auto_depreciation,
							'is_auto_depreciation_for' => $subItem->is_auto_depreciation_for,
							'is_accumulated' => $subItem->is_accumulated,
						]
					],
					'values' => $subItem->pivot ? (array)json_decode($subItem->pivot->payload) : []

				];
			})->toArray();
			// 1- recalculate sub items [because modified ] (percentage and cost of units)

			// 2- recalculate totals

			$totals[$incomeStatementItemId] = $this->recalculateTotalForRow($dates, $allMainItems, $incomeStatementItemId, $subItems, $subItemType, $totals);
		}

		return $totals;
	}

	protected function recalculateTotalForRow(array $dates, Collection $allMainItems, int $incomeStatementItemId, array $subItemNameWithDateValues, string $subItemType, array &$allItemsTotals)
	{
		$currentItemTotal = [];
		$isPercentageOfSalesRevenue = IncomeStatementItem::isPercentageOfSalesRevenue($incomeStatementItemId);
		$corporateTaxesID = IncomeStatementItem::CORPORATE_TAXES_ID;
		if (IncomeStatementItem::isMainWithSubItems($allMainItems, $incomeStatementItemId) && $incomeStatementItemId != IncomeStatementItem::CORPORATE_TAXES_ID) {
			$totalOfAllRows = 0;
			$totalAtDates = [];
			$totalDepreciationAtDates = [];
			
			if(!count($subItemNameWithDateValues)){
				$this->withMainRowsFor($incomeStatementItemId, $subItemType)->updateExistingPivot($incomeStatementItemId, [
					'total' => 0,
					'payload' => json_encode([])
				]);	
			}
			foreach ($subItemNameWithDateValues as $subItemName => $optionsAndValues) {
				$dateValues = $optionsAndValues['values'];
				$options = $optionsAndValues['options'];
				// 1 - total of each sub item
				if ($subItemName == 'Corporate Taxes') {
					$currentItemTotal['total']['sub_items'][$subItemName] = $allItemsTotals[$corporateTaxesID]['total']['total'] ?? 0;
				} else {
					$currentItemTotal['total']['sub_items'][$subItemName] = array_sum($dateValues);
				}

				// 2 - parent total for each total of sub items
				if ($incomeStatementItemId == IncomeStatementItem::SALES_REVENUE_ID) {
					if (!$options['is_quantity']) {
						$totalOfAllRows += $currentItemTotal['total']['sub_items'][$subItemName];
					}
				} else {
					$totalOfAllRows += $currentItemTotal['total']['sub_items'][$subItemName];
				}
				// 3-parent total for each total


				foreach ($dateValues as $date => $value) {
					if ($incomeStatementItemId == IncomeStatementItem::SALES_REVENUE_ID) {
						if (!$options['is_quantity']) {
							$totalAtDates[$date]  = isset($totalAtDates[$date]) ? $totalAtDates[$date] + $value : $value;
						}
					} else {
						$totalAtDates[$date]  = isset($totalAtDates[$date]) ? $totalAtDates[$date] + $value : $value;
					}

					if ($options['is_depreciation_or_amortization']) {
						$totalDepreciationAtDates[$date] = isset($totalDepreciationAtDates[$date]) ? $totalDepreciationAtDates[$date] + $value : $value;
					}
				}
				$this->withMainRowsFor($incomeStatementItemId, $subItemType)->updateExistingPivot($incomeStatementItemId, [
					'total' => $totalOfAllRows,
					'payload' => json_encode($totalAtDates)
				]);
			}

			$currentItemTotal['total']['dates'] = $totalAtDates;
			$currentItemTotal['total']['total'] = $totalOfAllRows ?: 0;
			$currentItemTotal['total']['totalDepreciationAtDates'] = $totalDepreciationAtDates;
		} elseif (IncomeStatementItem::isMainWithoutSubItems($allMainItems, $incomeStatementItemId, $isPercentageOfSalesRevenue)) {
			$currentItemTotal = $this->calculateTotalForMainRowWithoutSubItems($incomeStatementItemId, $allItemsTotals, $dates, $subItemType);
		} elseif ($isPercentageOfSalesRevenue) {
			$currentItemTotal = $this->calculateTotalPercentageOfSalesRevenueFor($incomeStatementItemId, $allItemsTotals, $dates, $subItemType);
		} elseif (IncomeStatementItem::CORPORATE_TAXES_ID == $incomeStatementItemId) {
			$corporateTaxesRow = $this->withSubItemsFor($incomeStatementItemId, $subItemType, 'Corporate Taxes')->first() ;
			$percentageOfCorporateTaxes = $corporateTaxesRow && $corporateTaxesRow->pivot ? $corporateTaxesRow->pivot->percentage_value : 0;
			$percentageOfCorporateTaxes = $percentageOfCorporateTaxes / 100;
			$totalOfEarningBeforeTaxes = $allItemsTotals[IncomeStatementItem::EARNING_BEFORE_TAXES_ID]['total']['total'] ?? 0;
			$currentItemTotal['total']['total'] = $totalOfEarningBeforeTaxes < 0 ? 0 : $totalOfEarningBeforeTaxes * $percentageOfCorporateTaxes;
			$this->withMainRowsFor($incomeStatementItemId, $subItemType)->updateExistingPivot($incomeStatementItemId, [
				'total' => $currentItemTotal['total']['total'] ?? 0,
				// update sub items of corporate taxes [needs to be here]
				// main row will be zero allows
				'payload' => json_encode([]),
			]);
		}


		return $currentItemTotal;
	}

	protected function calculateTotalPercentageOfSalesRevenueFor(int $incomeStatementItemId, array &$allItemsTotals, array $dates, string $subItemType): array
	{
		$values = [];
		$mapParentId  = array_flip(IncomeStatementItem::salesRateMap())[$incomeStatementItemId];
		$salesRevenueId = IncomeStatementItem::SALES_REVENUE_ID;
		$totalOfSalesRevenue = $allItemsTotals[$salesRevenueId]['total']['total'] ?? 0;
		$totalOfCurrentIncomeStatementItem = $allItemsTotals[$mapParentId]['total']['total'] ?? 0;
		$values['total']['total'] = $totalOfSalesRevenue ? $totalOfCurrentIncomeStatementItem / $totalOfSalesRevenue * 100 : 0;
		foreach ($dates as $date => $formattedDate) {
			$totalOfSalesRevenueAtDate = $allItemsTotals[$salesRevenueId]['total']['dates'][$date] ?? 0;
			$totalOfCurrentIncomeStatementItemAtDate = $allItemsTotals[$mapParentId]['total']['dates'][$date] ?? 0;
			$values['total']['dates'][$date] = $totalOfSalesRevenueAtDate ? $totalOfCurrentIncomeStatementItemAtDate / $totalOfSalesRevenueAtDate * 100 : 0;
		}
		$this->withMainRowsFor($incomeStatementItemId, $subItemType)->updateExistingPivot($incomeStatementItemId, [
			'total' => $values['total']['total'] ?? 0,
			'payload' => json_encode($values['total']['dates'] ?? [])
		]);

		return $values;
	}

	protected function calculateTotalForMainRowWithoutSubItems(int $incomeStatementItemId, array $totalOfMainRows, array $dates, string $subItemType)
	{
		$salesRevenueId = IncomeStatementItem::SALES_REVENUE_ID;
		$salesGrowthRateId = IncomeStatementItem::SALES_GROWTH_RATE_ID;
		$costOfGodsId = IncomeStatementItem::COST_OF_GOODS_ID;
		$grossProfitId = IncomeStatementItem::GROSS_PROFIT_ID;
		$marketExpenseId = IncomeStatementItem::MARKET_EXPENSES_ID;
		$salesExpenseId = IncomeStatementItem::SALES_AND_DISTRIBUTION_EXPENSES_ID;
		$generalExpensesId = IncomeStatementItem::GENERAL_EXPENSES_ID;
		$earningBeforeTaxesId = IncomeStatementItem::EARNING_BEFORE_TAXES_ID;
		$corporateTaxesID = IncomeStatementItem::CORPORATE_TAXES_ID;
		$netProfitId = IncomeStatementItem::NET_PROFIT_ID;
		$values = [];
		$valuesForCorporateTaxesAtDate = [];

		$equation = IncomeStatementItem::getEquationFor($this, $incomeStatementItemId);
		$corporateTaxesPercentage = $this->withSubItemsFor($corporateTaxesID, $subItemType, 'Corporate Taxes')->first()->pivot->percentage_value ?? 0;
		$corporateTaxesPercentage = $corporateTaxesPercentage / 100;

		if ($incomeStatementItemId === $salesGrowthRateId) {
			$values['total']['total'] = 0;
			foreach ($dates as $date => $formattedDate) {
				$values['total']['dates'][$date] = 0;
				$previousDate  = getPreviousDate($dates, $date);
				if ($previousDate) {
					$totalOfSalesRevenueAtDate = $totalOfMainRows[$salesRevenueId]['total']['dates'][$date] ?? 0;
					$totalOfSalesRevenueAtPreviousDate = $totalOfMainRows[$salesRevenueId]['total']['dates'][$previousDate] ?? 0;
					$growthRateDiff = $totalOfSalesRevenueAtDate - $totalOfSalesRevenueAtPreviousDate;
					$growthRate = $totalOfSalesRevenueAtPreviousDate ? $growthRateDiff / $totalOfSalesRevenueAtPreviousDate * 100 : 0;
					$values['total']['dates'][$date] = $growthRate;
				}
			}
		} elseif ($incomeStatementItemId === IncomeStatementItem::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_ID) {
			$values['total']['total'] = 0;
			foreach ($dates as $date => $formattedDate) {
				$totalOfGrossProfitAtDate = $totalOfMainRows[$grossProfitId]['total']['dates'][$date] ?? 0;
				$totalOfMarketExpenseAtDate = $totalOfMainRows[$marketExpenseId]['total']['dates'][$date] ?? 0;
				$totalOfSalesExpenseAtDate = $totalOfMainRows[$salesExpenseId]['total']['dates'][$date] ?? 0;
				$totalOfGeneralExpenseAtDate = $totalOfMainRows[$generalExpensesId]['total']['dates'][$date] ?? 0;
				$totalDepreciationOfCostOfGoodsAtDate = $totalOfMainRows[$costOfGodsId]['total']['totalDepreciationAtDates'][$date] ?? 0;
				$totalDepreciationOfMarketExpenseAtDate = $totalOfMainRows[$marketExpenseId]['total']['totalDepreciationAtDates'][$date] ?? 0;
				$totalDepreciationOfSalesExpenseAtDate = $totalOfMainRows[$salesExpenseId]['total']['totalDepreciationAtDates'][$date] ?? 0;
				$totalDepreciationOfGeneralExpenseAtDate = $totalOfMainRows[$generalExpensesId]['total']['totalDepreciationAtDates'][$date] ?? 0;
				$totalDepreciationsAtDate = $totalDepreciationOfCostOfGoodsAtDate + $totalDepreciationOfMarketExpenseAtDate + $totalDepreciationOfSalesExpenseAtDate + $totalDepreciationOfGeneralExpenseAtDate;
				$earningBeforeInterestTaxesAtDate = $totalOfGrossProfitAtDate - $totalOfMarketExpenseAtDate - $totalOfSalesExpenseAtDate - $totalOfGeneralExpenseAtDate;
				$earningBeforeInterstTaxesDepreciationAmortizationAtDate = $earningBeforeInterestTaxesAtDate + $totalDepreciationsAtDate;
				$values['total']['dates'][$date] = $earningBeforeInterstTaxesDepreciationAmortizationAtDate;
				$values['total']['total'] += $earningBeforeInterstTaxesDepreciationAmortizationAtDate;
			}
		} elseif ($incomeStatementItemId === IncomeStatementItem::EARNING_BEFORE_INTEREST_TAXES_ID) {
			$values['total']['total'] = 0;
			foreach ($dates as $date => $formattedDate) {
				$totalOfGrossProfitAtDate = $totalOfMainRows[$grossProfitId]['total']['dates'][$date] ?? 0;
				$totalOfMarketExpenseAtDate = $totalOfMainRows[$marketExpenseId]['total']['dates'][$date] ?? 0;
				$totalOfSalesExpenseAtDate = $totalOfMainRows[$salesExpenseId]['total']['dates'][$date] ?? 0;
				$totalOfGeneralExpenseAtDate = $totalOfMainRows[$generalExpensesId]['total']['dates'][$date] ?? 0;
				$totalDepreciationOfCostOfGoodsAtDate = $totalOfMainRows[$costOfGodsId]['totalDepreciationAtDates']['dates'][$date] ?? 0;
				$totalDepreciationOfMarketExpenseAtDate = $totalOfMainRows[$marketExpenseId]['totalDepreciationAtDates']['dates'][$date] ?? 0;
				$totalDepreciationOfSalesExpenseAtDate = $totalOfMainRows[$salesExpenseId]['totalDepreciationAtDates']['dates'][$date] ?? 0;
				$totalDepreciationOfGeneralExpenseAtDate = $totalOfMainRows[$generalExpensesId]['totalDepreciationAtDates']['dates'][$date] ?? 0;
				$totalDepreciationsAtDate = $totalDepreciationOfCostOfGoodsAtDate + $totalDepreciationOfMarketExpenseAtDate + $totalDepreciationOfSalesExpenseAtDate + $totalDepreciationOfGeneralExpenseAtDate;
				$earningBeforeInterestTaxesAtDate = $totalOfGrossProfitAtDate - $totalOfMarketExpenseAtDate - $totalOfSalesExpenseAtDate - $totalOfGeneralExpenseAtDate;
				$values['total']['dates'][$date] = $earningBeforeInterestTaxesAtDate;
				$values['total']['total'] += $earningBeforeInterestTaxesAtDate;

				// for corporate taxes sub items
				// update sub items of corporate taxes [needs to be here]
				$valueForCurrentCorporateTaxesSubItem = $earningBeforeInterestTaxesAtDate * $corporateTaxesPercentage;
				if (isActualDateInModifiedOrAdjusted($date, $subItemType) || $subItemType == 'actual') {
					$pivotForCorporateTaxes = $this->withSubItemsFor($corporateTaxesID, $subItemType, 'Corporate Taxes')->first();
					$pivotForCorporateTaxes = $pivotForCorporateTaxes ? $pivotForCorporateTaxes->pivot : null;
					if (!$pivotForCorporateTaxes) {
						$valuesForCorporateTaxesAtDate[$date] = 0;
					} else {
						$valuesForCorporateTaxesAtDate[$date] = 0;
					}
				} else {
					$valuesForCorporateTaxesAtDate[$date] = 0;
				}
			}
		}
	
		elseif ($incomeStatementItemId === IncomeStatementItem::NET_PROFIT_ID) {
			$totalOfCorporateTaxes = $totalOfMainRows[$corporateTaxesID]['total']['total'] ?? 0;
			$totalOfEarningBeforeTaxes = $totalOfMainRows[$earningBeforeTaxesId]['total']['total'] ?? 0;
			$values['total']['total'] = $totalOfEarningBeforeTaxes - $totalOfCorporateTaxes;
			foreach ($dates as $date => $formattedDate) {
				$totalOfCorporateTaxesAtDate = $totalOfMainRows[$corporateTaxesID]['total']['dates'][$date] ?? 0;
				$totalOfEarningBeforeTaxesAtDate = $totalOfMainRows[$earningBeforeTaxesId]['total']['dates'][$date] ?? 0;
				$values['total']['dates'][$date] =  $totalOfEarningBeforeTaxesAtDate - $totalOfCorporateTaxesAtDate;
			}
		} elseif ($equation) {
			$equationsIds = preg_split("/[-\+\/\*]/", $equation);
			$values['total']['total'] = 0;
			foreach ($dates as $date => $formattedDate) {
				$mainIdsWithItsValues = $this->replaceEquationIdsWithItsValues($equationsIds, $date, $totalOfMainRows);
				$formattedEquation = replaceArr($mainIdsWithItsValues, $equation);
				$values['total']['dates'][$date] = eval('return ' . $formattedEquation . ';');
				$values['total']['total'] += $values['total']['dates'][$date];
			}
		}

		$this->withMainRowsFor($incomeStatementItemId, $subItemType)->updateExistingPivot($incomeStatementItemId, [
			'total' => $values['total']['total'] ?? 0,
			'payload' =>   json_encode($values['total']['dates'] ?? [])
		]);

		if ($incomeStatementItemId === IncomeStatementItem::EARNING_BEFORE_INTEREST_TAXES_ID) {
			// update sub items of corporate taxes [needs to be here]
			$subItemName = 'Corporate Taxes';
			$this->withSubItemsFor($corporateTaxesID, $subItemType, $subItemName)->updateExistingPivot($corporateTaxesID, [
				'payload' => json_encode($valuesForCorporateTaxesAtDate ?? [])
			]);
		}


		return $values;
	}

	protected function replaceEquationIdsWithItsValues(array $equationIds, string $date, array $totalOfMainRows): array
	{
		$values = [];
		foreach ($equationIds as  $mainItemId) {
			$totalOfMainRowAtDate = $totalOfMainRows[$mainItemId]['total']['dates'][$date] ?? 0;
			$values[$mainItemId] = $totalOfMainRowAtDate;
		}

		return $values;
	}
	public function calculatePayloadWithVat(array $payload , string $subItemType ,bool $isDeductible , float $vatRate , int $financialStatementItemAbleId):array 
	{
		
		if($subItemType != 'forecast'){
			return $payload ;
		}
		if($financialStatementItemAbleId == IncomeStatementItem::SALES_REVENUE_ID){
			return $payload ;
		}
		$newPayload = [];
		foreach($payload as $date=>$value){
			#NOTE:calculate vat for sub item not percentage or cost
			
			$vatable = $this instanceof IncomeStatement && !$isDeductible || $this instanceof CashFlowStatement  && CashFlowStatementItem::CASH_IN_ID == $financialStatementItemAbleId || $this instanceof CashFlowStatement  && $isDeductible    ;
			// $newPayload[$date] = 999;
			$newPayload[$date] = $vatable ?  $value   * $this->calculateVat($vatRate)  : $value ;
			if($vatable){
				// logger('old vat ' . $oldVatRate . ' vat rate ' .  $vatRate );
				
			}
			
		}
		return $newPayload;
	}
}
