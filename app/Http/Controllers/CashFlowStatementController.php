<?php

namespace App\Http\Controllers;

use App\Exports\CashFlowStatementExport;
use App\Http\Requests\CashFlowStatementRequest;
use App\Models\CashFlowStatement;
use App\Models\CashFlowStatementItem;
use App\Models\Company;
use App\Models\Repositories\CashFlowStatementRepository;
use Illuminate\Http\Request;

class CashFlowStatementController extends Controller
{
	private CashFlowStatementRepository $cashFlowStatementRepository;

	public function __construct(CashFlowStatementRepository $cashFlowStatementRepository)
	{
		// $this->middleware('permission:view branches')->only(['index']);
		// $this->middleware('permission:create branches')->only(['store']);
		// $this->middleware('permission:update branches')->only(['update']);
		$this->cashFlowStatementRepository = $cashFlowStatementRepository;
	}

	public function view()
	{
		return view('admin.cash-flow-statement.view', CashFlowStatement::getViewVars());
	}
	public function create()
	{
		return view('admin.cash-flow-statement.create', CashFlowStatement::getViewVars());
	}

	public function createReport(Company $company, CashFlowStatement $cashFlowStatement)
	{
		// dd($cashFlowStatement);
		return view('admin.cash-flow-statement.report.view', CashFlowStatement::getReportViewVars([
			'financial_statement_able_id' => $cashFlowStatement->id, 'cashFlowStatement' => $cashFlowStatement
		]));
	}

	public function paginate(Request $request)
	{
		return $this->cashFlowStatementRepository->paginate($request);
	}
	public function paginateReport(Request $request, Company $company, CashFlowStatement $cashFlowStatement)
	{
		return $this->cashFlowStatementRepository->paginateReport($request, $cashFlowStatement);
	}


	public function store(CashFlowStatementRequest $request)
	{

		$cashFlowStatement = $this->cashFlowStatementRepository->store($request);
		return response()->json([
			'status' => true,
			'message' => __('Cash Flow Statement Has Been Stored Successfully'),
			'redirectTo' => route('admin.create.cash.flow.statement.report', ['company' => getCurrentCompanyId(), 'cashFlowStatement' => $cashFlowStatement->id])
		]);
	}

	public function storeReport(Request $request)
	{

		//   dd($request->all());
		$this->cashFlowStatementRepository->storeReport($request);

		return response()->json([
			'status' => true,
			'message' => __('Cash Flow Statement Has Been Stored Successfully')
		]);
	}

	public function edit(Company $company, Request $request, CashFlowStatement $cashFlowStatement)
	{
		return view(CashFlowStatement::getCrudViewName(), array_merge(CashFlowStatement::getViewVars(), [
			'type' => 'edit',
			'model' => $cashFlowStatement
		]));
	}

	public function update(Company $company, Request $request, CashFlowStatement $cashFlowStatement)
	{
		$this->cashFlowStatementRepository->update($cashFlowStatement, $request);
		return response()->json([
			'status' => true,
			'message' => __('Cash Flow Statement Has Been Updated Successfully')
		]);
	}

	public function updateReport(Company $company, Request $request)
	{
		$cashFlowStatementId = $request->get('financial_statement_able_id');
		$cashFlowStatementItemId = $request->get('financial_statement_able_item_id');
		$cashFlowStatement = CashFlowStatement::find($cashFlowStatementId);
		$cashFlowStatementItem = $cashFlowStatement->withMainItemsFor($cashFlowStatementItemId)->first();
		// dd($request->get('sub_item_name'));
		$cashFlowStatementItem->withSubItemsFor($cashFlowStatementId, $request->get('sub_item_type'), $request->get('sub_item_name'))
			->updateExistingPivot($cashFlowStatementId, [
				'sub_item_name' => $request->get('new_sub_item_name'),
				'financial_statement_able_item_id' => $request->get('sub_of_id'),
				'is_depreciation_or_amortization' => $request->get('is_depreciation_or_amortization')
			]);
		return response()->json([
			'status' => true,
			'message' => __('Item Has Been Updated Successfully')
		]);
	}

	public function deleteReport(Company $company, Request $request)
	{

		$cashFlowStatementId = $request->get('financial_statement_able_id');
		$cashFlowStatementItemId = $request->get('financial_statement_able_item_id');
		$cashFlowStatement = CashFlowStatement::find($cashFlowStatementId);
		$cashFlowStatementItem = $cashFlowStatement->withMainItemsFor($cashFlowStatementItemId)->first();
		// dd($request->get('sub_item_name'));
		$cashFlowStatementItem->withSubItemsFor($cashFlowStatementId, $request->get('sub_item_type'), $request->get('sub_item_name'))->detach($cashFlowStatementId);
		return response()->json([
			'status' => true,
			'message' => __('Item Has Been Deleted Successfully')
		]);
	}


	public function export(Request $request)
	{
		return (new CashFlowStatementExport($this->cashFlowStatementRepository->export($request), $request))->download();
	}
	public function exportReport(Request $request)
	{
		$formattedData = $this->formatReportDataForExport($request);
		$cashFlowStatementId = array_key_first($request->get('value'));
		$cashFlowStatement = CashFlowStatement::find($cashFlowStatementId);

		return (new CashFlowStatementExport(collect($formattedData), $request, $cashFlowStatement))->download();
	}
	protected function combineMainValuesWithItsPercentageRows(array $firstItems, array $secondItems): array
	{
		$mergeArray = [];
		foreach ($firstItems as $cashFlowStatementId => $cashFlowStatementValues) {
			foreach ($cashFlowStatementValues as $cashFlowStatementItemId => $cashFlowStatementItemsValues) {
				foreach ($cashFlowStatementItemsValues as $date => $value) {
					$mergeArray[$cashFlowStatementId][$cashFlowStatementItemId][$date] = $value;
				}
			}
		}
		foreach ($secondItems as $cashFlowStatementId => $cashFlowStatementValues) {
			foreach ($cashFlowStatementValues as $cashFlowStatementItemId => $cashFlowStatementItemsValues) {
				foreach ($cashFlowStatementItemsValues as $date => $value) {
					$mergeArray[$cashFlowStatementId][$cashFlowStatementItemId][$date] = $value;
				}
			}
		}

		$mergeArray[$cashFlowStatementId] = orderArrayByItemsKeys($mergeArray[$cashFlowStatementId]);

		return $mergeArray;
	}
	public function formatReportDataForExport(Request $request)
	{
		$formattedData = [];
		$totals = $request->get('totals');
		$subTotals = $request->get('subTotals');
		$rateCashFlowStatementItemsIds = CashFlowStatementItem::rateFieldsIds();
		$combineMainValuesWithItsPercentageRows = $this->combineMainValuesWithItsPercentageRows($request->get('valueMainRowThatHasSubItems'), $request->get('valueMainRowWithoutSubItems'));
		foreach ($combineMainValuesWithItsPercentageRows as $cashFlowStatementId => $cashFlowStatementValues) {
			foreach ($cashFlowStatementValues as $cashFlowStatementItemId => $cashFlowStatementItemsValues) {
				$cashFlowStatementItem = CashFlowStatementItem::find($cashFlowStatementItemId);
				$formattedData[$cashFlowStatementItem->name]['Name'] = $cashFlowStatementItem->name;
				foreach ($cashFlowStatementItemsValues as $date => $value) {
					$formattedData[$cashFlowStatementItem->name][$date] = in_array($cashFlowStatementItemId, $rateCashFlowStatementItemsIds) ? number_format($value, 2) . ' %' : number_format($value);
				}
				$total = $totals[$cashFlowStatementId][$cashFlowStatementItemId];
				$formattedData[$cashFlowStatementItem->name]['Total'] = in_array($cashFlowStatementItemId, $rateCashFlowStatementItemsIds) ? number_format($total, 2) . ' %' : number_format($total);
				if (isset($request->get('value')[$cashFlowStatementId][$cashFlowStatementItemId])) {
					foreach ($cashFlowStatementItemSubItems = $request->get('value')[$cashFlowStatementId][$cashFlowStatementItemId] as $cashFlowStatementItemSubItemName => $cashFlowStatementItemSubItemValues) {
						$formattedData[$cashFlowStatementItemSubItemName]['Name'] = $cashFlowStatementItemSubItemName;
						foreach ($cashFlowStatementItemSubItemValues as $cashFlowStatementItemSubItemDate => $cashFlowStatementItemSubItemValue) {
							$formattedData[$cashFlowStatementItemSubItemName][$cashFlowStatementItemSubItemDate] = in_array($cashFlowStatementItemId, $rateCashFlowStatementItemsIds) ? number_format($cashFlowStatementItemSubItemValue, 2) . ' %' : number_format($cashFlowStatementItemSubItemValue);
						}
						$total = $subTotals[$cashFlowStatementId][$cashFlowStatementItemId][$cashFlowStatementItemSubItemName];
						$formattedData[$cashFlowStatementItemSubItemName]['Total'] = in_array($cashFlowStatementItemId, $rateCashFlowStatementItemsIds) ? number_format($total, 2) . ' %' : number_format($total);
					}
				}
			}
		}
		return $formattedData;
	}
}
