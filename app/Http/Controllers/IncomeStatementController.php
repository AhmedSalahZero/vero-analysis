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

        //   dd($request->all());
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
        $incomeStatementId = $request->get('income_statement_id');
        $incomeStatementItemId = $request->get('income_statement_item_id');
        $incomeStatement = IncomeStatement::find($incomeStatementId);
        $incomeStatementItem = $incomeStatement->mainItems()->wherePivot('income_statement_item_id', $incomeStatementItemId)->first();
        // dd($request->get('sub_item_name'));
        $incomeStatementItem->subItems()->wherePivot('sub_item_name', $request->get('sub_item_name'))
            ->wherePivot('income_statement_id', $incomeStatementId)
            ->updateExistingPivot($incomeStatementId, [
                'sub_item_name' => $request->get('new_sub_item_name'),
                'income_statement_item_id' => $request->get('sub_of_id'),
                'is_depreciation_or_amortization' => $request->get('is_depreciation_or_amortization')
            ]);
        return response()->json([
            'status' => true,
            'message' => __('Item Has Been Updated Successfully')
        ]);
    }

    public function deleteReport(Company $company, Request $request)
    {

        $incomeStatementId = $request->get('income_statement_id');
        $incomeStatementItemId = $request->get('income_statement_item_id');
        $incomeStatement = IncomeStatement::find($incomeStatementId);
        $incomeStatementItem = $incomeStatement->mainItems()->wherePivot('income_statement_item_id', $incomeStatementItemId)->first();
        // dd($request->get('sub_item_name'));
        $incomeStatementItem->subItems($incomeStatementId)->wherePivot('sub_item_name', $request->get('sub_item_name'))->detach($incomeStatementId);
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
        $incomeStatementId = array_key_first($request->get('value'));
        $incomeStatement = IncomeStatement::find($incomeStatementId);
        
        return (new IncomeStatementExport(collect($formattedData), $request , $incomeStatement))->download();
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
        // dd($request->all());
        // $income
        $formattedData = [];
        $totals = $request->get('totals');
        $subTotals = $request->get('subTotals');
        $rateIncomeStatementItemsIds = IncomeStatementItem::rateFieldsIds();
        $combineMainValuesWithItsPercentageRows = $this->combineMainValuesWithItsPercentageRows($request->get('valueMainRowThatHasSubItems'), $request->get('valueMainRowWithoutSubItems'));
        foreach ($combineMainValuesWithItsPercentageRows as $incomeStatementId => $incomeStatementValues) {
            foreach ($incomeStatementValues as $incomeStatementItemId => $incomeStatementItemsValues) {
                $incomeStatementItem = IncomeStatementItem::find($incomeStatementItemId);
                $formattedData[$incomeStatementItem->name]['Name'] = $incomeStatementItem->name ;
                foreach ($incomeStatementItemsValues as $date => $value) {
                    $formattedData[$incomeStatementItem->name][$date] = in_array($incomeStatementItemId, $rateIncomeStatementItemsIds) ? number_format($value, 2) . ' %' : number_format($value);
                }
                $total = $totals[$incomeStatementId][$incomeStatementItemId];
                $formattedData[$incomeStatementItem->name]['Total'] = in_array($incomeStatementItemId, $rateIncomeStatementItemsIds) ? number_format($total, 2) . ' %' : number_format($total);
                if (isset($request->get('value')[$incomeStatementId][$incomeStatementItemId])) {
                    foreach ($incomeStatementItemSubItems = $request->get('value')[$incomeStatementId][$incomeStatementItemId] as $incomeStatementItemSubItemName => $incomeStatementItemSubItemValues) {
                        $formattedData[$incomeStatementItemSubItemName]['Name'] = $incomeStatementItemSubItemName ; 
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
