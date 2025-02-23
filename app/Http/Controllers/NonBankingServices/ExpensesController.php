<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Equations\ExpenseAsPercentageEquation;
use App\Equations\MonthlyFixedRepeatingAmountEquation;
use App\Equations\OneTimeExpenseEquation;
use App\Helpers\HHelpers;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Expense;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
	use NonBankingService ;
	public function create(Company $company , Request $request,Study $study){
		return view('non_banking_services.expenses.form', $this->getViewVars($company,$study));
	}
	protected function getViewVars(Company $company, Study $study){
		return [
			'company'=>$company ,
			'type'=>'create',
			'study'=>$study,
			'model'=>$study ,
			'expenseType'=>HHelpers::getClassNameWithoutNameSpace((new Expense())),
			'title'=>__('Expenses'),
			'storeRoute'=>route('store.expenses',['company'=>$company->id , 'study'=>$study->id]),
			'yearsWithItsMonths' => $study->getOperationDurationPerYearFromIndexes(),
			'revenueStreamTypes'=>$study->getCheckedRevenueStreamTypesForSelect()
		];
	}
	
	public function store(Company $company , Request $request,Study $study,MonthlyFixedRepeatingAmountEquation $monthlyFixedRepeatingAmountEquation,
	ExpenseAsPercentageEquation $expenseAsPercentageEquation,
	OneTimeExpenseEquation $oneTimeExpenseEquation
	)
	{
		
		$modelId = $request->get('model_id');
		$modelName = $request->get('model_name');
		$expenseType = $request->get('expense_type');
		$studyId = $study->id;
		$datesAsStringDateIndex = $study->getDatesAsStringAndIndex();
		$operationStartDateAsIndex = $datesAsStringDateIndex[$study->getOperationStartDate()];
		$model = ('\App\Models\\NonBankingService\\'.$modelName)::find($modelId);
		foreach((array)$request->get('tableIds') as $tableId){
			#::delete all
			$model->generateRelationDynamically($tableId,$expenseType)->delete();
			foreach((array)$request->get($tableId) as  $tableDataArr){
				$tableDataArr['expense_type'] = $expenseType;
					$name = $tableDataArr['name'];
					if(isset($tableDataArr['start_date'])){
						$tableDataArr['start_date'] = $datesAsStringDateIndex[$tableDataArr['start_date']];
					}else{
						$tableDataArr['start_date'] = $operationStartDateAsIndex;
					}
					if(isset($tableDataArr['end_date'])){
						$tableDataArr['end_date'] = $datesAsStringDateIndex[$tableDataArr['end_date']];
					}else{
						$tableDataArr['end_date'] = $operationStartDateAsIndex;
					}
					$tableDataArr['relation_name']  = $tableId ;
					/**
					 * * Fixed Repeating
					 */
					$vatRate = $tableDataArr['vat_rate']??0;
					$isDeductible = $tableDataArr['is_deductible'] ?? false;
						
					if(isset($tableDataArr['amount']) && $tableId == 'fixed_monthly_repeating_amount' ){
						
						$tableDataArr['monthly_repeating_amounts']  = $monthlyFixedRepeatingAmountEquation->calculate($tableDataArr['amount'],$tableDataArr['start_date'],$tableDataArr['end_date'],$tableDataArr['increase_interval'],$tableDataArr['increase_rate'],$isDeductible,$vatRate) ;
					}
					/**
					 * * Expense As Percentage 
					 */
					if($tableId =='percentage_of_sales'){
						$tableDataArr['expense_as_percentages']  = $expenseAsPercentageEquation->calculate($studyId,$tableDataArr['percentage_of'],$tableDataArr['revenue_stream_type']??[],$tableDataArr['stream_category_ids']??[],$tableDataArr['start_date'],$tableDataArr['end_date'],$tableDataArr['monthly_percentage'],$tableDataArr['payment_terms'],$vatRate,$isDeductible,$tableDataArr['withhold_tax_rate']) ;
					}
					/**
					 * * One Time Expense 
					 */
					if($tableId == 'one_time_expense'){
						$tableDataArr['payload']  = $oneTimeExpenseEquation->calculate($tableDataArr['amount'],$tableDataArr['start_date'],$isDeductible,$vatRate) ;
					}
					$tableDataArr['company_id']  = $company->id ;
					$tableDataArr['model_id']   = $modelId ;
					$tableDataArr['model_name']   = $modelName ;
					if($tableDataArr['payment_terms'] == 'customize'){
						$tableDataArr['custom_collection_policy'] = sumDueDayWithPayment($tableDataArr['payment_rate '],$tableDataArr['due_days']);
					}
					if($name){
						$model->generateRelationDynamically($tableId,$expenseType)->create($tableDataArr);
					}
					
				
			}
		}
		return response()->json([
			'redirectTo'=>route('view.results.dashboard',['company'=>$company->id,'study'=>$study->id])
		]);
	}
}
