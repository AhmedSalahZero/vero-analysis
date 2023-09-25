<?php

namespace App\Http\Controllers;

use App\Exports\CashFlowStatementExport;
use App\Http\Requests\CashFlowStatementRequest;
use App\Models\CashFlowStatement;
use App\Models\CashFlowStatementItem;
use App\Models\Company;
use App\Models\ReceivableAndPayment;
use App\Models\Repositories\CashFlowStatementRepository;
use App\Models\User;
use Carbon\Carbon;
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

	public function createReport(Company $company, CashFlowStatement $cashFlowStatement, $reportType = 'forecast')
	{
		// if first time
		$dates = array_keys($cashFlowStatement->getIntervalFormatted());
		// dd();
		// $cashFlowStatement->receivables_and_payments->count()
		if (env('APP_ENV') == 'local'
			&& !$cashFlowStatement->entered_receivables_and_payments_table
			||
			Request()->route()->getName() == 'admin.show-cash-and-banks'
		) {
			$subItemType ='forecast';
			$receivables_and_payments = $cashFlowStatement
			->withSubItemsFor(CashFlowStatementItem::CASH_OUT_ID, $subItemType)
			->wherePivot('receivable_or_payment', '!=', null)->get();
			$receivables = $receivables_and_payments;
			$payments = $cashFlowStatement
			->withSubItemsFor(CashFlowStatementItem::CASH_IN_ID, $subItemType)
			->wherePivot('receivable_or_payment', '!=', null)->get();

			$receivables_and_payments = $payments->concat($receivables);
			$model = $cashFlowStatement;
			if (!count($receivables_and_payments)) {
				$model = null;
			}
			$cashFlowStatement->update([
				'entered_receivables_and_payments_table'=>1
			]);

			return view('admin.cash-flow-statement.cash-opening-balance.create', ['dates'=>$dates, 'company'=>$company, 'cashFlowStatementId'=>$cashFlowStatement->id, 'receivables_and_payments'=>$receivables_and_payments, 'model'=>$model, 'subItemType'=>$subItemType]);
		}

		$cashFlowStatement = $cashFlowStatement->financialStatement->cashFlowStatement;

		return view('admin.cash-flow-statement.report.view', CashFlowStatement::getReportViewVars([
			'financial_statement_able_id' => $cashFlowStatement->id,
			'cashFlowStatement' => $cashFlowStatement,
			'cashFlowStatement' => $cashFlowStatement,
			'reportType' => getReportNameFromRouteName(Request()->route()->getName())
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
			'message' => __('Income Statement Has Been Stored Successfully'),
			'redirectTo' => route('admin.create.income.statement.report', ['company' => getCurrentCompanyId(), 'cashFlowStatement' => $cashFlowStatement->id])
		]);
	}

	public function storeReport(Request $request)
	{
		$this->cashFlowStatementRepository->storeReport($request);

		return response()->json([
			'status' => true,
			'message' => __('Income Statement Has Been Stored Successfully')
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
			'message' => __('Income Statement Has Been Updated Successfully')
		]);
	}

	public function updateReport(Company $company, Request $request)
	{
		$cashFlowStatementId = $request->get('cash_flow_statement_id');
		$incomeStatementId = $request->get('income_statement_id');
		// $subItemName = $request->get('sub_item_name');
		$incomeStatementItemId = $request->get('financial_statement_able_item_id');
		$isFinancialIncome = (bool)$request->input('sub_items.0.is_financial_income');
		$cashFlowStatement = CashFlowStatement::find($cashFlowStatementId);
		$cashFlowStatementItemId = $cashFlowStatement->getCashFlowStatementItemIdFromIncomeStatementItemId($incomeStatementItemId, $isFinancialIncome);
		$request['financial_statement_able_item_id']  = $incomeStatementItemId;
		$cashFlowStatement->storeReport($request);
		;
		$request['financial_statement_able_item_id']  = $cashFlowStatementItemId;
		$oldCashFlowStatementItemId = $cashFlowStatement->getCashFlowStatementItemIdFromIncomeStatementItemId($incomeStatementId, (bool)$request->get('was_financial_income'));
		$oldCashFlowStatementItem = $cashFlowStatement->withMainItemsFor($oldCashFlowStatementItemId)->first();
		$subItemTypesToDetach = getIndexesLargerThanOrEqualIndex(getAllFinancialAbleTypes(), $request->get('sub_item_type'));
		$collection_value = '';
		$collection_value_arr = $request->input('sub_items.0.collection_policy.type.value');
		if (isset($collection_value_arr) && is_array($collection_value_arr)) {
			$collection_value = json_encode($collection_value_arr);
		} elseif (isset($collection_value_arr)) {
			$collection_value = $collection_value_arr;
		}

		foreach ($subItemTypesToDetach as $subItemType) {
			$percentageOrFixed = $subItemType == 'actual' ? 'non_repeating_fixed' : $request->input('sub_items.0.percentage_or_fixed');
			$pivotArr = [
				'sub_item_name' => html_entity_decode($request->get('new_sub_item_name')),
				'financial_statement_able_item_id' =>  $request->get('financial_statement_able_item_id'),
				'is_depreciation_or_amortization' => $request->get('is_depreciation_or_amortization'),
				'has_collection_policy' => $request->input('sub_items.0.collection_policy.has_collection_policy'),
				'collection_policy_type' => $request->input('sub_items.0.collection_policy.type.name'),
				'collection_policy_value' => $collection_value,
				'percentage_or_fixed' => $percentageOrFixed,
				'repeating_fixed_value' => $percentageOrFixed == 'repeating_fixed' ? $request->input('sub_items.0.repeating_fixed_value') : null,
				'percentage_value' => $percentageOrFixed == 'percentage' ? $request->input('sub_items.0.percentage_value') : null,
				'cost_of_unit_value' => $percentageOrFixed == 'cost_of_unit' ? $request->input('sub_items.0.cost_of_unit_value') : null,
				'is_percentage_of' => $percentageOrFixed == 'percentage' ? json_encode($request->input('sub_items.0.is_percentage_of')) : null,
				'is_cost_of_unit_of' => $percentageOrFixed == 'cost_of_unit' ? json_encode($request->input('sub_items.0.is_cost_of_unit_of')) : null,
				'is_financial_expense' => $request->input('sub_items.0.is_financial_expense'),
				'is_financial_income' => $request->input('sub_items.0.is_financial_income'),
				'company_id' => $company->id,
				// 'financial_statement_able_item_id' => $cashFlowStatementItem->id,
				// 'financial_statement_able_id' => $cashFlowStatementId,
				// 'sub_item_type' => $subItemType

			];
			if ($oldCashFlowStatementItem) {
				$oldCashFlowStatementItem
					->withSubItemsFor($cashFlowStatementId, $subItemType, $request->get('sub_item_name'))
					->updateExistingPivot(
						$cashFlowStatementId,
						$pivotArr
					);
			} else {
				//dd($oldCashFlowStatementItem);
			}
		}


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
		$subItemsNames = formatSubItemsNamesForQuantity($request->get('sub_item_name'));
		$cashFlowStatement->storeReport($request);
		$cashFlowStatementItem = $cashFlowStatement->withMainItemsFor($cashFlowStatementItemId)->first();

		$subItemTypesToDetach = getIndexesLargerThanOrEqualIndex(getAllFinancialAbleTypes(), $request->get('sub_item_type'));
		foreach ($subItemTypesToDetach as $subItemType) {
			foreach ($subItemsNames as $subItemName) {
				if ($cashFlowStatementItem) {
					$cashFlowStatementItem->withSubItemsFor($cashFlowStatementId, $subItemType, $subItemName)->detach($cashFlowStatementId);
				}
			}
		}

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
		$cashFlowStatementId = array_key_first($request->get('valueMainRowThatHasSubItems'));
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

	public function storeCashAndBanks($company, Request $request)
	{
		$company = Company::find($company);
		$cashFlowStatementId = $request->get('cash_flow_statement_id');
		$subItemType  = $request->get('subItemType');
		$cashFlowStatement = CashFlowStatement::find($cashFlowStatementId);
		// dd();

		$cashFlowStatement->update([
			'cash_and_banks_beginning_balance'=>$request->get('cash_and_banks_beginning_balance')
		]);
		// dd($cashFlowStatement);
		$dates = (array)$request->get('dates');
		// dd('dates',$dates);


		$cashItemId = CashFlowStatementItem::CASH_IN_ID;
		$cashAndBanksName = 'Cash & Banks Beginning Balance';
		$lastIndex = count((array)$request->get('opening_receivable')) - 1;
		// dd($lastIndex);

		$cashFlowStatement->withSubItemsFor(CashFlowStatementItem::CASH_IN_ID, $subItemType)->wherePivot('receivable_or_payment', '!=', null)->detach();
		$cashFlowStatement->withSubItemsFor(CashFlowStatementItem::CASH_OUT_ID, $subItemType)->wherePivot('receivable_or_payment', '!=', null)->detach();


		foreach ((array)$request->get('opening_receivable') as $index => $arr) {
			$payload = [];
			foreach ($dates as $date) {
				$payload[$date]=$arr[$date] ?? 0;
			}
			$data = [
				'sub_item_name'=> $name = $arr['receivable_name'],
				'sub_item_type'=> $subItemType,
				'created_from'=>$subItemType,
				'payload'=>json_encode($payload),
				'is_depreciation_or_amortization'=>0,
				'has_collection_policy'=>0,
				'is_quantity'=>0,
				'can_be_quantity'=>0,
				'can_be_percentage_or_fixed'=>0,
				'company_id'=>$company->id,
				'percentage_or_fixed'=>'non_repeating_fixed',
				'creator_id'=>auth()->user()->id,
				'ordered'=>3 ,
				// 'balance_amount'=>$arr['balance_amount'],
				// 'payload'=>$payload,
				// 'cash_flow_statement_id'=>$cashFlowStatementId,
				'receivable_or_payment'=>'receivable',
				'created_at'=>now()
			];
			// $data = [
			// 	'name'=> $name = $arr['receivable_name'] ,
			// 	'balance_amount'=>$arr['balance_amount'],
			// 	'payload'=>$payload,
			// 	'cash_flow_statement_id'=>$cashFlowStatementId,
			// 	'type'=>'payment',
			// 	'created_at'=>now()
			// ];
			// if ($arr['id']) {

				
				$cashFlowStatement->withSubItemsFor($cashItemId, $subItemType, $name)->attach($cashItemId, $data);

				if ($index == $lastIndex) {
					$cashFlowStatement->withSubItemsFor($cashItemId, $subItemType, $cashAndBanksName)->attach(
						$cashItemId,
						array_merge($data, [
							'sub_item_name'=>$cashAndBanksName,
							'payload'=>json_encode([$dates[0]=>$request->get('cash_and_banks_beginning_balance')]),
							'receivable_or_payment'=>'cash_and_banks_beginning_balance',
							'ordered'=>1 
						])
					);
				}

				
			// if (false) {
			// 	if ($index == $lastIndex) {

			// 		$cashFlowStatement->withSubItemsFor($cashItemId, $subItemType, $cashAndBanksName)->where('receivable_or_payment', '!=', null)->updateExistingPivot($cashItemId, [
			// 			'payload'=>json_encode([$dates[0]=>$request->get('cash_and_banks_beginning_balance')]),
			// 			'sub_item_name'=>$cashAndBanksName
			// 		]);
			// 	}
			// 	$cashFlowStatement->withSubItemsFor($cashItemId, $subItemType, $arr['old_receivable_name'])->where('receivable_or_payment', '!=', null)->updateExistingPivot($cashItemId, [
			// 		'payload'=>$payload,
			// 		'sub_item_name'=>$name,
			// 		'sub_item_type'=>$subItemType,
			// 	]);
			// 	// ReceivableAndPayment::where('id',$arr['id'])->update($data);
			// } 
			// else {
			// 	// create

			// 	// ReceivableAndPayment::create($data);
			// }
		}

		$cashItemId  = CashFlowStatementItem::CASH_OUT_ID;

		foreach ((array)$request->get('opening_payment') as $index => $arr) {
			$payload = [];
			// dd($dates);
			foreach ($dates as $date) {
				$payload[$date]=$arr[$date] ?? 0;
			}
			// dd($payload,json_encode($payload));

			$data = [
				'sub_item_name'=> $name = $arr['receivable_name'],
				'sub_item_type'=> $subItemType,
				'created_from'=>$subItemType,
				'payload'=>json_encode($payload),
				'is_depreciation_or_amortization'=>0,
				'has_collection_policy'=>0,
				'is_quantity'=>0,
				'can_be_quantity'=>0,
				'ordered'=>4 ,
				'can_be_percentage_or_fixed'=>0,
				'company_id'=>$company->id,
				'percentage_or_fixed'=>'non_repeating_fixed',
				'creator_id'=>auth()->user()->id,
				// 'balance_amount'=>$arr['balance_amount'],
				// 'payload'=>$payload,
				// 'cash_flow_statement_id'=>$cashFlowStatementId,
				'receivable_or_payment'=>'payment',
				'created_at'=>now()
			];
			
			$cashFlowStatement->withSubItemsFor($cashItemId, $subItemType, $name)->attach($cashItemId, $data);
			
			
			// $data = [
			// 	'name'=> $name = $arr['receivable_name'] ,
			// 	'balance_amount'=>$arr['balance_amount'],
			// 	'payload'=>$payload,
			// 	'cash_flow_statement_id'=>$cashFlowStatementId,
			// 	'type'=>'payment',
			// 	'created_at'=>now()
			// ];
			// if (false) {
			// 	// if ($arr['id']) {
			// 	// dd($cashFlowStatement->withSubItemsFor($cashItemId, $subItemType, $name)->where('receivable_or_payment','!=',null)->first());
			// 	$cashFlowStatement->withSubItemsFor($cashItemId, $subItemType, $arr['old_receivable_name'])->where('receivable_or_payment', '!=', null)->updateExistingPivot($cashItemId, [
			// 		'payload'=>$payload,
			// 		'sub_item_name'=>$name,
			// 		'sub_item_type'=>$subItemType,
			// 	]);
			// 	// ReceivableAndPayment::where('id',$arr['id'])->update($data);
			// }
			//  else {
			// 	// ReceivableAndPayment::create($data);
			// }
		}

		return redirect()->route('admin.create.cash.flow.statement.forecast.report', ['cashFlowStatement'=>$cashFlowStatementId, 'company'=>$company->id]);
	}
}
