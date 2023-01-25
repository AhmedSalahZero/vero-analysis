<?php

namespace App\Http\Controllers;

use App\Exports\IncomeStatementExport;
use App\Http\Requests\IncomeStatementRequest;
use App\Models\Company;
use App\Models\IncomeStatement;
use App\Models\IncomeStatementItem;
use App\Models\Repositories\IncomeStatementRepository;
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
		// dd($incomeStatement);
		return view('admin.income-statement.report.view', IncomeStatement::getReportViewVars([
			'income_statement_id' => $incomeStatement->id, 'incomeStatement' => $incomeStatement
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

		$this->incomeStatementRepository->storeReport($request);

		return response()->json([
			'status' => true,
			'message' => __('Income Statement Has Been Stored Successfully'),
			'redirectTo' => $request->get('redirectTo')
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
		$incomeStatementItem = $incomeStatement->withMainItemsFor($incomeStatementItemId)->first();
		// dd($request->get('sub_item_name'));
		$incomeStatementItem->withSubItemsFor($incomeStatementId, $request->get('sub_item_type'), $request->get('sub_item_name'))
			->updateExistingPivot($incomeStatementId, [
				'sub_item_name' => $request->get('new_sub_item_name'),
				'financial_statement_able_item_id' => $request->get('sub_of_id'),
				'is_depreciation_or_amortization' => $request->get('is_depreciation_or_amortization'),
				'is_quantity' => $request->boolean('is_quantity'),
			]);
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
		$incomeStatementItem = $incomeStatement->mainItems($incomeStatementItemId)->first();
		$deleteSubItemsType = getDeleteSubItemsFor($request->get('sub_item_type'));
		foreach ($deleteSubItemsType as $subItemType) {
			$incomeStatementItem->withSubItemsFor($incomeStatementId, $subItemType, $request->get('sub_item_name'))->detach($incomeStatementId);
		}
		return response()->json([
			'status' => true,
			'message' => __('Item Has Been Deleted Successfully')
		]);
	}


	public function export(Request $request)
	{

		return (new IncomeStatementExport($this->incomeStatementRepository->export($request), $request))->download();
	}
}
