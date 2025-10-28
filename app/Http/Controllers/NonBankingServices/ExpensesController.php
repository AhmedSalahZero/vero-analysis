<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Equations\ExpenseAsPercentageEquation;
use App\Equations\MonthlyFixedRepeatingAmountEquation;
use App\Equations\OneTimeExpenseEquation;
use App\Helpers\HArr;
use App\Helpers\HHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpensesRequest;
use App\Models\Company;
use App\Models\NonBankingService\Expense;
use App\Models\NonBankingService\ExpenseName;
use App\Models\NonBankingService\Manpower;
use App\Models\NonBankingService\Position;
use App\Models\NonBankingService\Study;
use App\ReadyFunctions\CollectionPolicyService;
use App\Traits\NonBankingService;
use Arr;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    use NonBankingService ;
    public function create(Company $company, Request $request, Study $study)
    {
        return view('non_banking_services.expenses.form', $this->getViewVars($company, $study));
    }
    //   protected function getViewVars(Company $company, Study $study)
    // {
    //     return $study->getExpensesViewVars();
    // }
    
    protected function getViewVars(Company $company, Study $study)
    {
        $selectedRevenueStreams = $study->getSelectedRevenueStreamTypesFormatted();
        // $revenueStreams = $study->getSelectedRevenueStreamWithCategories($selectedRevenueStreams);
        return [
            'selectedRevenueStreams'=>$selectedRevenueStreams,
            'company'=>$company ,
            'type'=>'create',
            // 'revenueStreams'=>$revenueStreams,
            'study'=>$study,
            'model'=>$study ,
            'expenseType'=>HHelpers::getClassNameWithoutNameSpace((new Expense())),
            'title'=>__('Expenses'),
            'storeRoute'=>route('store.expenses', ['company'=>$company->id , 'study'=>$study->id]),
            'yearsWithItsMonths' => $study->getOperationDurationPerYearFromIndexes(),
            'revenueStreamTypes'=>$study->getCheckedRevenueStreamTypesForSelect()
        ];
    }
  
    
    public function store(
        Company $company,
        StoreExpensesRequest $request,
        Study $study,
        MonthlyFixedRepeatingAmountEquation $monthlyFixedRepeatingAmountEquation,
        ExpenseAsPercentageEquation $expenseAsPercentageEquation,
        OneTimeExpenseEquation $oneTimeExpenseEquation
    ) {
        
        $modelId = $request->get('model_id');
  
        $modelName = $request->get('model_name');
        $expenseType = $request->get('expense_type');

        $studyId = $study->id;
        $datesAsStringDateIndex = $study->getDatesAsStringAndIndex();
        $datesAsIndexAndString = array_flip($datesAsStringDateIndex);
        $operationStartDateAsIndex = $datesAsStringDateIndex[$study->getOperationStartDate()];
        $studyExtendedEndDateAsIndex = Arr::last($datesAsStringDateIndex);
        $studyEndDateAsIndex = $study->getStudyEndDateAsIndex($datesAsStringDateIndex, $study->getStudyEndDate());
        $dateIndexWithDate = $study->getDateIndexWithDate();
        $model = ('\App\Models\\NonBankingService\\'.$modelName)::find($modelId);
        foreach ((array)$request->get('tableIds') as $tableId) {
            #::delete all
            $model->generateRelationDynamically($tableId, $expenseType)->delete();
            foreach ((array)$request->get($tableId) as $tableDataArr) {
                $tableDataArr['study_id'] = $study->id;
				$dateWithDateIndex = $study->getDateWithDateIndex();
				
                $withholdRate = $tableDataArr['withhold_tax_rate']??0;
            
                if (isset($tableDataArr['start_date']) && count(explode('-', $tableDataArr['start_date'])) == 2) {
                    $tableDataArr['start_date'] = $tableDataArr['start_date'].'-01';
                    
                }if (isset($tableDataArr['end_date']) && count(explode('-', $tableDataArr['end_date'])) == 2) {
                    $tableDataArr['end_date'] = $tableDataArr['end_date'].'-01';
                    
                }
                $tableDataArr['expense_type'] = $expenseType;
                $name = $tableDataArr['expense_name_id']??null;
                    
                if (isset($tableDataArr['start_date'])) {
                    $tableDataArr['start_date'] = $datesAsStringDateIndex[$tableDataArr['start_date']];
                } else {
                    $tableDataArr['start_date'] = $operationStartDateAsIndex;
                }
                if (isset($tableDataArr['end_date'])) {
                    $tableDataArr['end_date'] = $datesAsStringDateIndex[$tableDataArr['end_date']];
                } else {
                    $tableDataArr['end_date'] = $operationStartDateAsIndex;
                }
                /**
                 * * to repeat 2 years inside json
                 */
                $loopEndDate = $tableDataArr['end_date'] >=  $studyEndDateAsIndex ? $studyExtendedEndDateAsIndex : $tableDataArr['end_date'];
                $loopEndDate = $loopEndDate ==  0 ? $studyEndDateAsIndex : $loopEndDate ;

                $monthsAsIndexes = range(0, $studyEndDateAsIndex) ;
                $tableDataArr['relation_name']  = $tableId ;
                /**
                 * * Fixed Repeating
                 */
                $vatRate = $tableDataArr['vat_rate']??0;
                $isDeductible = $tableDataArr['is_deductible'] ?? false;
                if ($tableDataArr['payment_terms'] == 'customize') {
                    $tableDataArr['custom_collection_policy'] = sumDueDayWithPayment($tableDataArr['payment_rate'], $tableDataArr['due_days']);
                }
                $customCollectionPolicy = $tableDataArr['custom_collection_policy']??[];
                if (is_array($isDeductible)) {
                    $tableDataArr['is_deductible'] = $isDeductible[0];
                    $isDeductible= $isDeductible[0];
                }
                $isFixedRepeating = isset($tableDataArr['amount']) && $tableId == 'fixed_monthly_repeating_amount';
                $isExpensePerEmployee = (isset($tableDataArr['monthly_cost_of_unit']) && $tableId == 'expense_per_employee') ;
                $isCostPerUnit = (isset($tableDataArr['monthly_cost_of_unit']) && $tableId == 'cost_per_unit') ;
                $revenueStreamTypes = $tableDataArr['revenue_stream_type']??[] ;
                $categoryIds = $tableDataArr['stream_category_ids']??[] ;
                
                if ($isFixedRepeating || $isExpensePerEmployee || $isCostPerUnit) {
                    
                    $amount = $tableDataArr['amount']??0 ;
                    $accumulatedManpowerPowersForAllSelectedPositions = [ ];
                    if ($isExpensePerEmployee) {
                        $positionIds = (array) $tableDataArr['position_ids'] ;
                        $manpowers = Manpower::whereIn('position_id', $positionIds)->where('study_id',$study->id)->where('monthly_net_salary','>',0)->pluck('accumulated_manpower_counts')->toArray();
                        $accumulatedManpowerPowersForAllSelectedPositions = HArr::sumAtDates($manpowers, $monthsAsIndexes);
                        $amount = $tableDataArr['monthly_cost_of_unit'];
                    } elseif ($isCostPerUnit) {
                        $amount = $tableDataArr['monthly_cost_of_unit'];
                    }
                
                    // $isDeductible = false;
                    $dateIndexWithYearIndex = $study->getDatesIndexWithYearIndex();
                    $monthlyFixedRepeatingResults = [];
                    if ($isCostPerUnit) {
                        $contractResult = Expense::getExpensePerContract($revenueStreamTypes, $categoryIds, $studyId, 'contract_counts',true);
                        $contractCount = $contractResult['result'];
                        $sumKeys = $study->getOperationDatesAsDateAndDateAsIndexToStudyEndDate();
                        $contractCount = HArr::sumAtDates($contractCount, $sumKeys);
                        $monthlyFixedRepeatingResults = $monthlyFixedRepeatingAmountEquation->calculate($amount, $tableDataArr['start_date'], $loopEndDate, $tableDataArr['increase_interval']??'annually', $tableDataArr['increase_rates']??0, $isDeductible, $vatRate, $withholdRate, $dateIndexWithYearIndex, $contractCount);
                    }elseif($isExpensePerEmployee){
                        // $old = $monthlyFixedRepeatingAmountEquation->calculate($amount, $tableDataArr['start_date'], $loopEndDate, $tableDataArr['increase_interval']??'annually', $tableDataArr['increase_rates']??0, $isDeductible, $vatRate, $withholdRate, $dateIndexWithYearIndex,[]);
                        $monthlyFixedRepeatingResults = $monthlyFixedRepeatingAmountEquation->calculate($amount, $tableDataArr['start_date'], $loopEndDate, $tableDataArr['increase_interval']??'annually', $tableDataArr['increase_rates']??0, $isDeductible, $vatRate, $withholdRate, $dateIndexWithYearIndex,$accumulatedManpowerPowersForAllSelectedPositions);
						// dd($old,$monthlyFixedRepeatingResults);
					} else {
                        $monthlyFixedRepeatingResults = $monthlyFixedRepeatingAmountEquation->calculate($amount, $tableDataArr['start_date'], $loopEndDate, $tableDataArr['increase_interval']??'annually', $tableDataArr['increase_rates']??0, $isDeductible, $vatRate, $withholdRate, $dateIndexWithYearIndex);
						// if($isExpensePerEmployee){
						// 	dd('e',$monthlyFixedRepeatingResults,$accumulatedManpowerPowersForAllSelectedPositions);
						// }
                    }
                    /**
                     * * دي القيمة اللي هتدخل في الاكسبنس
                     */
                    $repeatingExpenseValues = [];
                    $collectionValues = [];
                    if ($isFixedRepeating) {
                        $repeatingExpenseValues = $isDeductible ? $monthlyFixedRepeatingResults['total_before_vat'] : $monthlyFixedRepeatingResults['total_after_vat'];
                        $collectionValues = $monthlyFixedRepeatingResults['total_before_vat'];
                    }
                    
                    if ($isCostPerUnit) {
                        $fixedRepeatingExpenseArr = $isDeductible ? $monthlyFixedRepeatingResults['total_before_vat'] : $monthlyFixedRepeatingResults['total_after_vat'];
                        $repeatingExpenseValues = $fixedRepeatingExpenseArr;
                        $collectionValues =$monthlyFixedRepeatingResults['total_before_vat'];
                    }
					if ($isExpensePerEmployee) {
                        // $totalAfterVats = $monthlyFixedRepeatingResults['total_after_vat'];
                        $totalBeforeVats = $monthlyFixedRepeatingResults['total_before_vat'];
                        // $monthlyFixedRepeatingResults['total_after_vat'] = $totalAfterVats HArr::multipleTwoArrAtSameIndex(, $accumulatedManpowerPowersForAllSelectedPositions);
                        $repeatingExpenseValues = $monthlyFixedRepeatingResults['total_after_vat'] ;
                        $collectionValues = $totalBeforeVats ;
                    }
					
                    // if ($isExpensePerEmployee) {
                    //     $totalAfterVats = $monthlyFixedRepeatingResults['total_after_vat'];
                    //     $totalBeforeVats = $monthlyFixedRepeatingResults['total_before_vat'];
                    //     $monthlyFixedRepeatingResults['total_after_vat'] = HArr::multipleTwoArrAtSameIndex($totalAfterVats, $accumulatedManpowerPowersForAllSelectedPositions);
                    //     $repeatingExpenseValues = $monthlyFixedRepeatingResults['total_after_vat'] ;
                    //     $collectionValues = HArr::multipleTwoArrAtSameIndex($totalBeforeVats, $accumulatedManpowerPowersForAllSelectedPositions) ;
                    // }
                    $withholdAmounts  = $monthlyFixedRepeatingResults['withhold_amounts'];
					// if($isExpensePerEmployee){
					// 	dd($withholdAmounts);
					// }
                    $tableDataArr['monthly_repeating_amounts']  = $repeatingExpenseValues;
                    $tableDataArr['total_vat']  = $monthlyFixedRepeatingResults['total_vat'];
                    $tableDataArr['total_after_vat']  = $monthlyFixedRepeatingResults['total_after_vat'];
                    
                    $payments = $study->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $tableDataArr['total_after_vat'], $datesAsIndexAndString, $customCollectionPolicy) ;
                    $withholdPayments = $study->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $withholdAmounts, $datesAsIndexAndString, $customCollectionPolicy) ;
                    $netPaymentsAfterWithhold = HArr::subtractAtDates([$payments,$withholdPayments], $dateWithDateIndex);
			
                    $tableDataArr['withhold_amounts'] = $withholdAmounts ;
                    $tableDataArr['withhold_payments']=$withholdPayments;
					
                    $tableDataArr['payment_amounts'] = $payments;
                    $tableDataArr['net_payments_after_withhold']=$netPaymentsAfterWithhold;
					
                    $tableDataArr['withhold_statements']=$study->calculateWithholdStatement($withholdPayments , 0 , $dateIndexWithDate);
                    $tableDataArr['collection_statements']   =$this->calculateStatement($collectionValues, $tableDataArr['total_vat'], $netPaymentsAfterWithhold, $withholdPayments, $dateIndexWithDate, $study);
					// dd($tableDataArr['collection_statements']);
					
        
                }
                /**
                 * * Expense As Percentage
                 */
                /**
                 * 	$beginning = 0 ;
                 * $expense
                 * $vat
                 * $total due = $begiining + $expense + $vat
                 * $collection
                 * $withhold
                 * $endBalance = $totalDie - $collection - $withhold
                 * $begiinign = $endBalance

                 */
        
                if ($tableId =='percentage_of_sales' || $tableId =='expense_as_percentage') {
                    $expenseAsPercentageResults = $expenseAsPercentageEquation->calculate($studyId, $tableDataArr['percentage_of'], $revenueStreamTypes, $categoryIds, $tableDataArr['start_date'], $loopEndDate, $tableDataArr['monthly_percentage'], $tableDataArr['payment_terms'], $vatRate, $isDeductible, $tableDataArr['withhold_tax_rate']) ;
                    $tableDataArr['expense_as_percentages']  =$expenseAsPercentageResults['total_before_vat']  ;
                    $tableDataArr['total_vat']  =$expenseAsPercentageResults['total_vat']  ;
                    $tableDataArr['total_after_vat']  =$expenseAsPercentageResults['total_after_vat']  ;
                    $withholdAmounts  = $expenseAsPercentageResults['total_withhold'];
                    $tableDataArr['payment_amounts'] = $study->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $tableDataArr['total_after_vat'], $datesAsIndexAndString, $customCollectionPolicy) ;
                    $payments = $study->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $tableDataArr['total_after_vat'], $datesAsIndexAndString, $customCollectionPolicy,true) ;
                    $withholdPayments = $study->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $withholdAmounts, $datesAsIndexAndString, $customCollectionPolicy) ;
                    $netPaymentsAfterWithhold = HArr::subtractAtDates([$payments,$withholdPayments], $dateWithDateIndex);
                    $tableDataArr['withhold_amounts'] = $withholdAmounts ;
                    $tableDataArr['withhold_payments']=$withholdPayments;
                    $tableDataArr['payment_amounts'] = $payments;
                    $tableDataArr['net_payments_after_withhold']=$netPaymentsAfterWithhold;
					$tableDataArr['withhold_statements']=$study->calculateWithholdStatement($withholdPayments , 0 , $dateIndexWithDate);
					

                    $tableDataArr['collection_statements']   =$this->calculateStatement($tableDataArr['expense_as_percentages'], $tableDataArr['total_vat'], $netPaymentsAfterWithhold, $withholdPayments, $dateIndexWithDate, $study);
                    
                }
                /**
                 * * One Time Expense
                */
                if ($tableId == 'one_time_expense') {
                    $startDateAsIndex = $tableDataArr['start_date'] ;
                    $amountBeforeVat = $tableDataArr['amount'] ;
                    $withholdAmount = $tableDataArr['withhold_tax_rate'] / 100 * $amountBeforeVat ;
                    $amortizationMonths = $tableDataArr['amortization_months']??12 ;
                    $oneTimeExpenses = $oneTimeExpenseEquation->calculate($amountBeforeVat, $amortizationMonths, $startDateAsIndex, $isDeductible, $vatRate);
                    $tableDataArr['payload']  = $oneTimeExpenses ;
                    $amountBeforeVatPayload = [$startDateAsIndex=>$amountBeforeVat] ;
                    $vatRate = $tableDataArr['vat_rate'] / 100 ;
                    $vats = [$startDateAsIndex=>$amountBeforeVat * $vatRate];
                    
                    $tableDataArr['total_vat']  =$vats  ;
                    $amountAfterVat = [$startDateAsIndex => $amountBeforeVat + $amountBeforeVat * $vatRate ];
                    $tableDataArr['total_after_vat']  =$amountAfterVat  ;
                    $withholdAmount = $tableDataArr['withhold_tax_rate']/100 ;
                    $withholdAmounts  = [$startDateAsIndex =>  $amountBeforeVat * $withholdAmount ] ;
                    $payments = $study->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $amountAfterVat, $datesAsIndexAndString, $customCollectionPolicy, true) ;
                    $withholdPayments = $study->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $withholdAmounts, $datesAsIndexAndString, $customCollectionPolicy) ;
                    $netPaymentsAfterWithhold = HArr::subtractAtDates([$payments,$withholdPayments], $dateWithDateIndex);
                    $tableDataArr['withhold_amounts'] = $withholdAmounts ;
                    $tableDataArr['withhold_payments']=$withholdPayments;
                    $tableDataArr['payment_amounts'] = $payments;
                    $tableDataArr['net_payments_after_withhold']=$netPaymentsAfterWithhold;
					$tableDataArr['withhold_statements']=$study->calculateWithholdStatement($withholdPayments , 0 , $dateIndexWithDate);
					
					// dd($tableDataArr['withhold_statements']);
					// dd($amountBeforeVatPayload,$withholdPayments);
					// dd('one',$this->calculateStatement($amountBeforeVatPayload, $tableDataArr['total_vat'], $netPaymentsAfterWithhold, $withholdPayments, $dateIndexWithDate, $study));
                    $tableDataArr['collection_statements']   =$this->calculateStatement($amountBeforeVatPayload, $tableDataArr['total_vat'], $netPaymentsAfterWithhold, $withholdPayments, $dateIndexWithDate, $study);
                }
              
                $tableDataArr['company_id']  = $company->id ;
                $tableDataArr['model_id']   = $modelId ;
                $tableDataArr['model_name']   = $modelName ;
                if ($name) {
                    $model->generateRelationDynamically($tableId, $expenseType)->create($tableDataArr);
                }
                    
                
            }
        }
        // general
		
        if ($request->get('saveAndContinue')) {
            return response()->json([
                'redirectTo'=>route('create.ffe.fixed.assets', ['company'=>$company->id,'study'=>$study->id])
            ]);
        }
        return response()->json([
            'redirectTo'=>route('create.expenses', ['company'=>$company->id,'study'=>$study->id])
        ]);
        
    }
    // private function calculateCollectionOrPaymentAmounts(string $paymentTerm, array $totalAfterVat, array $datesAsIndexAndString, array $customCollectionPolicy, $debug=false)
    // {
    //     $collectionPolicyType  = $paymentTerm == 'customize' ? 'customize':'system_default';
    //     $collectionPolicyValue = $collectionPolicyType ;
    //     $dateValue = $totalAfterVat;
    //     if ($collectionPolicyType == 'customize') {
    //         $collectionPolicyValue = $customCollectionPolicy ;
    //     } elseif ($collectionPolicyType == 'system_default' && $paymentTerm=='cash') {
    //         $collectionPolicyValue = 'monthly';
    //     } elseif ($collectionPolicyType == 'system_default') {
    //         $collectionPolicyValue = $paymentTerm;
    //     }
    //     $dateValue = convertIndexKeysToString($dateValue, $datesAsIndexAndString);
    //     $collectionPolicyValue = is_array($collectionPolicyValue) ?  $this->formatDues($collectionPolicyValue) : $collectionPolicyValue;
    //     $result = (new CollectionPolicyService())->applyCollectionPolicy(true, $collectionPolicyType, $collectionPolicyValue, $dateValue) ;
        
    //     return convertStringKeysToIndexes($result, $datesAsIndexAndString);
    // }
    private function formatDues(array $duesAndDays)
    {
        $result = [];
        foreach ($duesAndDays as $day => $due) {
            $result['due_in_days'][]=$day;
            $result['rate'][]=$due;
        }
        return $result;
    }
    public function calculateStatement(array $expenses, array $vats, array $netPaymentsAfterWithhold, array $withholdPayments, array $dateIndexWithDate, Study $study, float $beginningBalance = 0)
    {
        $expensesForIntervals = [
            'monthly'=>$expenses,
            // 'quarterly'=>sumIntervalsIndexes($expenses, 'quarterly', $study->financialYearStartMonth(), $dateIndexWithDate),
            // 'semi-annually'=>sumIntervalsIndexes($expenses, 'semi-annually', $study->financialYearStartMonth(), $dateIndexWithDate),
            // 'annually'=>sumIntervalsIndexes($expenses, 'annually', $study->financialYearStartMonth(), $dateIndexWithDate),
        ]; 
		$dateWithDateIndex = $study->getDateWithDateIndex();
		// $datesForIntervals = [
        //     'monthly'=>$dateWithDateIndex,
        //     // 'quarterly'=>sumIntervalsIndexes($dateWithDateIndex, 'quarterly', $study->financialYearStartMonth(), $dateIndexWithDate),
        //     // 'semi-annually'=>sumIntervalsIndexes($dateIndexWithDate, 'semi-annually', $study->financialYearStartMonth(), $dateIndexWithDate),
        //     // 'annually'=>sumIntervalsIndexes($dateIndexWithDate, 'annually', $study->financialYearStartMonth(), $dateIndexWithDate),
        // ];
		// dd($datesForIntervals);
        $netPaymentAfterWithholdForInterval = [
            'monthly'=>$netPaymentsAfterWithhold,
            // 'quarterly'=>sumIntervalsIndexes($netPaymentsAfterWithhold, 'quarterly', $study->financialYearStartMonth(), $dateIndexWithDate),
            // 'semi-annually'=>sumIntervalsIndexes($netPaymentsAfterWithhold, 'semi-annually', $study->financialYearStartMonth(), $dateIndexWithDate),
            // 'annually'=>sumIntervalsIndexes($netPaymentsAfterWithhold, 'annually', $study->financialYearStartMonth(), $dateIndexWithDate),
        ];
        
        $result = [];
        foreach (['monthly'=>__('Monthly')] as $intervalName=>$intervalNameFormatted) {
        // foreach (getIntervalFormatted() as $intervalName=>$intervalNameFormatted) {
            $beginningBalance = 0;
            foreach ($dateIndexWithDate as $dateIndex=>$dateAsString) {
				$currentExpenseValue = $expensesForIntervals[$intervalName][$dateIndex]??0 ;
                $date = $dateIndex;
                $result[$intervalName]['beginning_balance'][$date] = $beginningBalance;
                $currentVat = $vats[$date]??0 ;
                $totalDue[$date] =  $currentExpenseValue+$currentVat+$beginningBalance;
                $paymentAtDate = $netPaymentAfterWithholdForInterval[$intervalName][$date]??0 ;
                $withholdPaymentAtDate = $withholdPayments[$date]?? 0 ;
                $endBalance[$date] = $totalDue[$date] - $paymentAtDate  - $withholdPaymentAtDate ;
                $beginningBalance = $endBalance[$date] ;
                $result[$intervalName]['expense'][$date] =  $currentExpenseValue ;
                $result[$intervalName]['vat'][$date] =  $currentVat ;
                $result[$intervalName]['total_due'][$date] = $totalDue[$date];
                $result[$intervalName]['payment'][$date] = $paymentAtDate;
                $result[$intervalName]['withhold_amount'][$date] = $withholdPaymentAtDate;
                $result[$intervalName]['end_balance'][$date] =$endBalance[$date];
            }
        }
        return $result;
    
        
    }
    public function getExpenseNamesForCategory(Company $company, Request $request)
    {
        $categoryId =  $request->get('expenseCategoryId');
        $result = ExpenseName::where('company_id', $company->id)->where('expense_type', $categoryId)->orderBy('name')->get();
        return response()->json([
            'status'=>true ,
            'data'=>$result
        ]);
    }
    public function getExpenseNamesForCategoryOnlyEmployees(Company $company, Request $request)
    {
        $categoryId =  $request->get('expenseCategoryId');
        $result = ExpenseName::where('company_id', $company->id)->where('is_employee_expense', 1)->where('expense_type', $categoryId)->orderBy('name')->get();
        return response()->json([
            'status'=>true ,
            'data'=>$result
        ]);
    }
}
