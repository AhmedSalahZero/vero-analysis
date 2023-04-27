<?php

namespace App\Http\Controllers;

use App\Exports\IncomeStatementExport;
use App\Http\Controllers\CashFlowStatementController;
use App\Http\Requests\IncomeStatementRequest;
use App\Models\CashFlowStatement;
use App\Models\Company;
use App\Models\IncomeStatement;
use App\Models\IncomeStatementItem;
use App\Models\Repositories\CashFlowStatementRepository;
use App\Models\Repositories\IncomeStatementRepository;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeStatementController extends Controller
{

	private IncomeStatementRepository $incomeStatementRepository;

	public function __construct(IncomeStatementRepository $incomeStatementRepository)
	{
		// $this->middleware('permission:view branches')->only(['index']);
		// $this->middleware('permission:create branches')->only(['store']);
		// $this->middleware('permission:update branches')->only(['update']);
		$this->incomeStatementRepository = $incomeStatementRepository;
	}

	public function view()
	{
		return view('admin.income-statement.view', IncomeStatement::getViewVars());
	}
	public function create()
	{
		return view('admin.income-statement.create', IncomeStatement::getViewVars());
	}

	public function createReport(Company $company, IncomeStatement $incomeStatement)
	{
		$cashFlowStatement = $incomeStatement->financialStatement->cashFlowStatement;
		return view('admin.income-statement.report.view', IncomeStatement::getReportViewVars([
			'financial_statement_able_id' => $incomeStatement->id,
			'incomeStatement' => $incomeStatement,
			'cashFlowStatement' => $cashFlowStatement,
			'reportType' => getReportNameFromRouteName(Request()->route()->getName())
		]));
	}

	public function paginate(Request $request)
	{
		return $this->incomeStatementRepository->paginate($request);
	}
	public function paginateReport(Request $request, Company $company, IncomeStatement $incomeStatement)
	{
		return $this->incomeStatementRepository->paginateReport($request, $incomeStatement);
	}


	public function store(IncomeStatementRequest $request)
	{
		$incomeStatement = $this->incomeStatementRepository->store($request);
		return response()->json([
			'status' => true,
			'message' => __('Income Statement Has Been Stored Successfully'),
			'redirectTo' => route('admin.create.income.statement.report', ['company' => getCurrentCompanyId(), 'incomeStatement' => $incomeStatement->id])
		]);
	}

	public function storeReport(Request $request)
	{
		// dd($request->all());

		$this->incomeStatementRepository->storeReport($request);
		return response()->json([
			'status' => true,
			'message' => __('Income Statement Has Been Stored Successfully')
		]);
	}

	public function edit(Company $company, Request $request, IncomeStatement $incomeStatement)
	{
		return view(IncomeStatement::getCrudViewName(), array_merge(IncomeStatement::getViewVars(), [
			'type' => 'edit',
			'model' => $incomeStatement
		]));
	}

	public function update(Company $company, Request $request, IncomeStatement $incomeStatement)
	{
		$this->incomeStatementRepository->update($incomeStatement, $request);
		return response()->json([
			'status' => true,
			'message' => __('Income Statement Has Been Updated Successfully')
		]);
	}

	public function updateReport(Company $company, Request $request)
	{
		$incomeStatementId = $request->get('financial_statement_able_id');
		$incomeStatementItemId = $request->get('financial_statement_able_item_id');
		$incomeStatement = IncomeStatement::find($incomeStatementId);
		$incomeStatement->storeReport($request);
		$incomeStatementItem = $incomeStatement->withMainItemsFor($incomeStatementItemId)->first();
		$subItemTypesToDetach = getIndexesLargerThanOrEqualIndex(getAllFinancialAbleTypes(), $request->get('sub_item_type'));
		$collection_value = '';
		$collection_value_arr = $request->input('sub_items.0.collection_policy.type.value');
		if (isset($collection_value_arr) && is_array($collection_value_arr)) {
			$collection_value = json_encode($collection_value_arr);
		} elseif (isset($collection_value_arr)) {
			$collection_value = $collection_value_arr;
		}
		foreach ($subItemTypesToDetach as $subItemType) {
			$percentageOrFixed = $subItemType == 'actual' ? 'non_repeating_fixed' :  $request->input('sub_items.0.percentage_or_fixed');

			$incomeStatementItem
				->withSubItemsFor($incomeStatementId, $subItemType, $request->get('sub_item_name'))
				->updateExistingPivot($incomeStatementId, [
					'sub_item_name' => html_entity_decode($request->get('new_sub_item_name')),
					'financial_statement_able_item_id' => $request->get('sub_of_id') ?: $request->get('financial_statement_able_item_id'),
					'is_depreciation_or_amortization' => $request->get('is_depreciation_or_amortization'),
					'has_collection_policy' => $request->input('sub_items.0.collection_policy.has_collection_policy'),
					'collection_policy_type' => $request->input('sub_items.0.collection_policy.type.name'),
					'collection_policy_value' => $collection_value,
					'percentage_or_fixed' => $percentageOrFixed,
					'repeating_fixed_value' => $percentageOrFixed == 'repeating_fixed' ?  $request->input('sub_items.0.repeating_fixed_value') : null,
					'percentage_value' => $percentageOrFixed == 'percentage' ?  $request->input('sub_items.0.percentage_value') : null,
					'cost_of_unit_value' => $percentageOrFixed == 'cost_of_unit' ?  $request->input('sub_items.0.cost_of_unit_value') : null,
					'is_financial_expense' => $request->input('sub_items.0.is_financial_expense'),
					'is_financial_income' => $request->input('sub_items.0.is_financial_income'),
					'is_percentage_of' => $percentageOrFixed == 'percentage' ? json_encode($request->input('sub_items.0.is_percentage_of')) : null,
					'is_cost_of_unit_of' => $percentageOrFixed == 'cost_of_unit' ? json_encode($request->input('sub_items.0.is_cost_of_unit_of')) : null,

				]);
		}


		$cashFlowStatement = $incomeStatement->financialStatement->cashFlowStatement;
		$dates = array_keys($incomeStatement->getIntervalFormatted());
		$request['dates'] = $dates;
		$request['cash_flow_statement_id'] = $cashFlowStatement->id;
		$request['income_statement_id'] = $incomeStatement->id;
		$cashFlowStatementDataFormatted = $cashFlowStatement->formatDataFromIncomeStatement($request);
		//dd($cashFlowStatementDataFormatted);
		//$request['financial_statement_able_id'] = $cashFlowStatement->id;
		//$request['financial_statement_able_item_id'] = $request->financial_statement_able_item_id ? $cashFlowStatement->getCashFlowStatementItemIdFromIncomeStatementItemId($request->financial_statement_able_item_id) : 0;
		$request['value'] = $cashFlowStatementDataFormatted['value'];
		$request['valueMainRowThatHasSubItems'] = $cashFlowStatementDataFormatted['valueMainRowThatHasSubItems'];
		$request['totals'] = $cashFlowStatementDataFormatted['totals'];
		$request['financialStatementAbleItemName'] = $cashFlowStatementDataFormatted['financialStatementAbleItemName'];
		$request['valueMainRowWithoutSubItems'] = [];
		(new CashFlowStatementController(new CashFlowStatementRepository))->updateReport($company, $request);
		return response()->json([
			'status' => true,
			'message' => __('Item Has Been Updated Successfully')
		]);
	}

	public function deleteReport(Company $company, Request $request)
	{
		$incomeStatementId = $request->get('financial_statement_able_id');
		$incomeStatementItemId = $request->get('financial_statement_able_item_id');
		$incomeStatement = IncomeStatement::find($incomeStatementId);
		$subItemsNames = formatSubItemsNamesForQuantity($request->get('sub_item_name'));
		$isFinancialIncome = (bool)$request->get('is_financial_income');
		$incomeStatement->storeReport($request);
		$incomeStatementItem = $incomeStatement->withMainItemsFor($incomeStatementItemId)->first();

		$subItemTypesToDetach = getIndexesLargerThanOrEqualIndex(getAllFinancialAbleTypes(), $request->get('sub_item_type'));
		foreach ($subItemTypesToDetach as $subItemType) {
			foreach ($subItemsNames as $subItemName) {
				$incomeStatementItem->withSubItemsFor($incomeStatementId, $subItemType, $subItemName)->detach($incomeStatementId);
			}
			if ($subItemType != $request->get('sub_item_type')) {
				$incomeStatement->refreshCalculationFor($subItemType);
			}
		}


		$cashFlowStatement = $incomeStatement->financialStatement->cashFlowStatement;
		$dates = array_keys($incomeStatement->getIntervalFormatted());
		$request['dates'] = $dates;
		$request['cash_flow_statement_id'] = $cashFlowStatement->id;
		$request['income_statement_id'] = $incomeStatement->id;
		$cashFlowStatementDataFormatted = $cashFlowStatement->formatDataFromIncomeStatement($request);

		$request['financial_statement_able_id'] = $cashFlowStatement->id;
		$request['financial_statement_able_item_id'] = $request->financial_statement_able_item_id ? $cashFlowStatement->getCashFlowStatementItemIdFromIncomeStatementItemId($request->financial_statement_able_item_id, $isFinancialIncome) : 0;
		$request['value'] = $cashFlowStatementDataFormatted['value'];
		$request['valueMainRowThatHasSubItems'] = $cashFlowStatementDataFormatted['valueMainRowThatHasSubItems'];
		$request['totals'] = $cashFlowStatementDataFormatted['totals'];
		$request['financialStatementAbleItemName'] = $cashFlowStatementDataFormatted['financialStatementAbleItemName'];
		$request['valueMainRowWithoutSubItems'] = [];
		(new CashFlowStatementController(new CashFlowStatementRepository))->deleteReport($company, $request);


		return response()->json([
			'status' => true,
			'message' => __('Item Has Been Deleted Successfully')
		]);
	}
	public function export(Request $request)
	{
		return (new IncomeStatementExport($this->incomeStatementRepository->export($request), $request))->download();
	}
	public function exportReport(Request $request)
	{
		$formattedData = $this->formatReportDataForExport($request);
		$incomeStatementId = array_key_first($request->get('valueMainRowThatHasSubItems'));
		$incomeStatement = IncomeStatement::find($incomeStatementId);

		return (new IncomeStatementExport(collect($formattedData), $request, $incomeStatement))->download();
	}
	protected function combineMainValuesWithItsPercentageRows(array $firstItems, array $secondItems): array
	{
		$mergeArray = [];
		foreach ($firstItems as $incomeStatementId => $incomeStatementValues) {
			foreach ($incomeStatementValues as $incomeStatementItemId => $incomeStatementItemsValues) {
				foreach ($incomeStatementItemsValues as $date => $value) {
					$mergeArray[$incomeStatementId][$incomeStatementItemId][$date] = $value;
				}
			}
		}
		foreach ($secondItems as $incomeStatementId => $incomeStatementValues) {
			foreach ($incomeStatementValues as $incomeStatementItemId => $incomeStatementItemsValues) {
				foreach ($incomeStatementItemsValues as $date => $value) {
					$mergeArray[$incomeStatementId][$incomeStatementItemId][$date] = $value;
				}
			}
		}

		$mergeArray[$incomeStatementId] = orderArrayByItemsKeys($mergeArray[$incomeStatementId]);

		return $mergeArray;
	}
	public function formatReportDataForExport(Request $request)
	{
		$formattedData = [];
		$totals = $request->get('totals');
		$subTotals = $request->get('subTotals');
		$rateIncomeStatementItemsIds = IncomeStatementItem::rateFieldsIds();
		$combineMainValuesWithItsPercentageRows = $this->combineMainValuesWithItsPercentageRows($request->get('valueMainRowThatHasSubItems'), $request->get('valueMainRowWithoutSubItems'));
		foreach ($combineMainValuesWithItsPercentageRows as $incomeStatementId => $incomeStatementValues) {
			foreach ($incomeStatementValues as $incomeStatementItemId => $incomeStatementItemsValues) {
				$incomeStatementItem = IncomeStatementItem::find($incomeStatementItemId);
				$formattedData[$incomeStatementItem->name]['Name'] = $incomeStatementItem->name;
				foreach ($incomeStatementItemsValues as $date => $value) {
					$formattedData[$incomeStatementItem->name][$date] = in_array($incomeStatementItemId, $rateIncomeStatementItemsIds) ? number_format($value, 2) . ' %' : number_format($value);
				}
				$total = $totals[$incomeStatementId][$incomeStatementItemId];
				$formattedData[$incomeStatementItem->name]['Total'] = in_array($incomeStatementItemId, $rateIncomeStatementItemsIds) ? number_format($total, 2) . ' %' : number_format($total);
				if (isset($request->get('value')[$incomeStatementId][$incomeStatementItemId])) {
					foreach ($incomeStatementItemSubItems = $request->get('value')[$incomeStatementId][$incomeStatementItemId] as $incomeStatementItemSubItemName => $incomeStatementItemSubItemValues) {
						$formattedData[$incomeStatementItemSubItemName]['Name'] = $incomeStatementItemSubItemName;
						foreach ($incomeStatementItemSubItemValues as $incomeStatementItemSubItemDate => $incomeStatementItemSubItemValue) {
							$formattedData[$incomeStatementItemSubItemName][$incomeStatementItemSubItemDate] = in_array($incomeStatementItemId, $rateIncomeStatementItemsIds) ? number_format($incomeStatementItemSubItemValue, 2) . ' %' : number_format($incomeStatementItemSubItemValue);
						}
						$total = $subTotals[$incomeStatementId][$incomeStatementItemId][$incomeStatementItemSubItemName];
						$formattedData[$incomeStatementItemSubItemName]['Total'] = in_array($incomeStatementItemId, $rateIncomeStatementItemsIds) ? number_format($total, 2) . ' %' : number_format($total);
					}
				}
			}
		}
		return $formattedData;
	}
}
