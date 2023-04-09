<?php

namespace App\Http\Controllers;

use App\Exports\FinancialStatementExport;
use App\Http\Requests\FinancialStatementRequest;
use App\Models\Company;
use App\Models\FinancialStatement;
use App\Models\FinancialStatementItem;
use App\Models\Repositories\FinancialStatementRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FinancialStatementController extends Controller
{
	private FinancialStatementRepository $financialStatementRepository;

	public function __construct(FinancialStatementRepository $financialStatementRepository)
	{
		// $this->middleware('permission:view branches')->only(['index']);
		// $this->middleware('permission:create branches')->only(['store']);
		// $this->middleware('permission:update branches')->only(['update']);
		$this->financialStatementRepository = $financialStatementRepository;
	}

	public function view()
	{
		return view('admin.financial-statement.view', FinancialStatement::getViewVars());
	}
	public function create()
	{
		return view('admin.financial-statement.create', FinancialStatement::getViewVars());
	}

	public function createReport(Company $company, FinancialStatement $financialStatement)
	{
		return view('admin.financial-statement.report.view', FinancialStatement::getReportViewVars([
			'financial_statement_id' => $financialStatement->id, 'financialStatement' => $financialStatement,
			// ''
		]));
	}

	public function paginate(Request $request)
	{
		return $this->financialStatementRepository->paginate($request);
	}
	public function paginateReport(Request $request, Company $company, FinancialStatement $financialStatement)
	{
		return $this->financialStatementRepository->paginateReport($request, $financialStatement);
	}


	public function store(FinancialStatementRequest $request)
	{

		$financialStatement = $this->financialStatementRepository->store($request);
		return response()->json([
			'status' => true,
			'message' => __('Financial Statement Has Been Stored Successfully'),
			'redirectTo' => route('admin.view.financial.statement', getCurrentCompanyId())
		]);
	}

	public function storeReport(Request $request)
	{

		$this->financialStatementRepository->storeReport($request);

		return response()->json([
			'status' => true,
			'message' => __('Financial Statement Has Been Stored Successfully')
		]);
	}

	public function edit(Company $company, Request $request, FinancialStatement $financialStatement)
	{
		return view(FinancialStatement::getCrudViewName(), array_merge(FinancialStatement::getViewVars(), [
			'type' => 'edit',
			'model' => $financialStatement
		]));
	}

	public function updateDate(Company $company, Request $request)
	{
		$financialStatement = FinancialStatement::find($request->get('financial_statement_id'));
		$dateString = str_replace(['-', '_'], '/', $request->get('date'));
		$financialStatement->update([
			'start_from' => $dateString
		]);
		return response()->json([
			'status' => true
		]);
	}

	public function updateDurationType(Company $company, Request $request)
	{
		$financialStatement = FinancialStatement::find($request->get('financialStatementId'));
		if ($durationType = Str::slug($request->get('durationType'))) {
			$financialStatement->update([
				'duration_type' => $durationType
			]);
		}

		return response()->json([
			'status' => true
		]);
	}

	public function update(Company $company, Request $request, FinancialStatement $financialStatement)
	{
		$this->financialStatementRepository->update($financialStatement, $request);
		return response()->json([
			'status' => true,
			'message' => __('Financial Statement Has Been Updated Successfully')
		]);
	}

	public function updateReport(Company $company, Request $request)
	{
		$financialStatementId = $request->get('financial_statement_id');
		$financialStatementItemId = $request->get('financial_statement_item_id');
		$financialStatement = FinancialStatement::find($financialStatementId);
		$financialStatementItem = $financialStatement->withMainItemsFor($financialStatementItemId)->first();
		$financialStatementItem->withSubItemsFor($financialStatementId, $request->get('sub_item_type'), $request->get('sub_item_name'))
			->updateExistingPivot($financialStatementId, [
				'sub_item_name' => html_entity_decode($request->get('new_sub_item_name')),
				'financial_statement_item_id' => $request->get('sub_of_id'),
				'is_depreciation_or_amortization' => $request->get('is_depreciation_or_amortization')
			]);





		return response()->json([
			'status' => true,
			'message' => __('Item Has Been Updated Successfully')
		]);
	}

	public function deleteReport(Company $company, Request $request)
	{

		$financialStatementId = $request->get('financial_statement_id');
		$financialStatementItemId = $request->get('financial_statement_item_id');
		$financialStatement = FinancialStatement::find($financialStatementId);
		$financialStatementItem = $financialStatement->withMainItemsFor($financialStatementItemId)->first();
		$financialStatementItem->withSubItemsFor($financialStatementId, $request->get('sub_item_type'), $request->get('sub_item_name'))->detach($financialStatementId);
		return response()->json([
			'status' => true,
			'message' => __('Item Has Been Deleted Successfully')
		]);
	}


	public function export(Request $request)
	{
		return (new FinancialStatementExport($this->financialStatementRepository->export($request), $request))->download();
	}
	public function exportReport(Request $request)
	{
		$formattedData = $this->formatReportDataForExport($request);
		$financialStatementId = array_key_first($request->get('valueMainRowThatHasSubItems'));
		$financialStatement = FinancialStatement::find($financialStatementId);
		return (new FinancialStatementExport(collect($formattedData), $request, $financialStatement))->download();
	}
	protected function combineMainValuesWithItsPercentageRows(array $firstItems, array $secondItems): array
	{
		$mergeArray = [];
		foreach ($firstItems as $financialStatementId => $financialStatementValues) {
			foreach ($financialStatementValues as $financialStatementItemId => $financialStatementItemsValues) {
				foreach ($financialStatementItemsValues as $date => $value) {
					$mergeArray[$financialStatementId][$financialStatementItemId][$date] = $value;
				}
			}
		}
		foreach ($secondItems as $financialStatementId => $financialStatementValues) {
			foreach ($financialStatementValues as $financialStatementItemId => $financialStatementItemsValues) {
				foreach ($financialStatementItemsValues as $date => $value) {
					$mergeArray[$financialStatementId][$financialStatementItemId][$date] = $value;
				}
			}
		}

		$mergeArray[$financialStatementId] = orderArrayByItemsKeys($mergeArray[$financialStatementId]);

		return $mergeArray;
	}
	public function formatReportDataForExport(Request $request)
	{
		// $financial
		$formattedData = [];
		$totals = $request->get('totals');
		$subTotals = $request->get('subTotals');
		$rateFinancialStatementItemsIds = FinancialStatementItem::rateFieldsIds();
		$combineMainValuesWithItsPercentageRows = $this->combineMainValuesWithItsPercentageRows($request->get('valueMainRowThatHasSubItems'), $request->get('valueMainRowWithoutSubItems'));
		foreach ($combineMainValuesWithItsPercentageRows as $financialStatementId => $financialStatementValues) {
			foreach ($financialStatementValues as $financialStatementItemId => $financialStatementItemsValues) {
				$financialStatementItem = FinancialStatementItem::find($financialStatementItemId);
				$formattedData[$financialStatementItem->name]['Name'] = $financialStatementItem->name;
				foreach ($financialStatementItemsValues as $date => $value) {
					$formattedData[$financialStatementItem->name][$date] = in_array($financialStatementItemId, $rateFinancialStatementItemsIds) ? number_format($value, 2) . ' %' : number_format($value);
				}
				$total = $totals[$financialStatementId][$financialStatementItemId];
				$formattedData[$financialStatementItem->name]['Total'] = in_array($financialStatementItemId, $rateFinancialStatementItemsIds) ? number_format($total, 2) . ' %' : number_format($total);
				if (isset($request->get('value')[$financialStatementId][$financialStatementItemId])) {
					foreach ($financialStatementItemSubItems = $request->get('value')[$financialStatementId][$financialStatementItemId] as $financialStatementItemSubItemName => $financialStatementItemSubItemValues) {
						$formattedData[$financialStatementItemSubItemName]['Name'] = $financialStatementItemSubItemName;
						foreach ($financialStatementItemSubItemValues as $financialStatementItemSubItemDate => $financialStatementItemSubItemValue) {
							$formattedData[$financialStatementItemSubItemName][$financialStatementItemSubItemDate] = in_array($financialStatementItemId, $rateFinancialStatementItemsIds) ? number_format($financialStatementItemSubItemValue, 2) . ' %' : number_format($financialStatementItemSubItemValue);
						}
						$total = $subTotals[$financialStatementId][$financialStatementItemId][$financialStatementItemSubItemName];
						$formattedData[$financialStatementItemSubItemName]['Total'] = in_array($financialStatementItemId, $rateFinancialStatementItemsIds) ? number_format($total, 2) . ' %' : number_format($total);
					}
				}
			}
		}
		return $formattedData;
	}
}
