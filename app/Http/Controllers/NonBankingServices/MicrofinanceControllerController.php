<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Equations\MonthlyFixedRepeatingAmountEquation;
use App\Helpers\HArr;
use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StoreLeasingRevenueStreamRequest;
use App\Models\Company;
use App\Models\NonBankingService\LeasingCategory;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MicrofinanceControllerController extends Controller
{
    use NonBankingService ;
    public function create(Company $company, Request $request, Study $study)
    {
        return view('non_banking_services.microfinance.form', $this->getViewVars($company, $study));
    }
    protected function getViewVars(Company $company, Study $study)
    {
        $yearsWithItsMonths =  $study->getOperationDurationPerYearFromIndexes() ;
        $yearOrMonthsIndexes = $study->getYearOrMonthIndexes();
        $isYearsStudy = !$study->isMonthlyStudy();
        return [
            'company'=>$company ,
            'model'=>$study ,
			'study'=>$study,
			'expenseType'=>'Microfinance',
            'title'=>__('Microfinance'),
            'storeRoute'=>route('store.microfinance', ['company'=>$company->id , 'study'=>$study->id]),
            'yearsWithItsMonths' =>$yearsWithItsMonths,
            'yearOrMonthsIndexes'=>$yearOrMonthsIndexes,
            'isYearsStudy'=>$isYearsStudy
        ];
    }

    public function store(Company $company, StoreLeasingRevenueStreamRequest $request, Study $study , MonthlyFixedRepeatingAmountEquation $monthlyFixedRepeatingAmountEquation)
    {
		
          
		
		 
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
           
                
                if ($isFixedRepeating ) {
                    $amount = $tableDataArr['amount']??0 ;
                    // $isDeductible = false;
                    $dateIndexWithYearIndex = $study->getDatesIndexWithYearIndex();
                        $monthlyFixedRepeatingResults = $monthlyFixedRepeatingAmountEquation->calculate($amount, $tableDataArr['start_date'], $loopEndDate, $tableDataArr['increase_interval']??'annually', $tableDataArr['increase_rates']??0, $isDeductible, $vatRate, $withholdRate, $dateIndexWithYearIndex);
                    /**
                     * * دي القيمة اللي هتدخل في الاكسبنس
                     */
                    $repeatingExpenseValues = [];
                    $collectionValues = [];
                    if ($isFixedRepeating) {
                        $repeatingExpenseValues = $isDeductible ? $monthlyFixedRepeatingResults['total_before_vat'] : $monthlyFixedRepeatingResults['total_after_vat'];
                        $collectionValues = $monthlyFixedRepeatingResults['total_before_vat'];
                    }
                    $withholdAmounts  = $monthlyFixedRepeatingResults['withhold_amounts'];
                    $tableDataArr['monthly_repeating_amounts']  = $repeatingExpenseValues;
                    $tableDataArr['total_vat']  = $monthlyFixedRepeatingResults['total_vat'];
                    $tableDataArr['total_after_vat']  = $monthlyFixedRepeatingResults['total_after_vat'];
                    
                    $payments = $study->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $tableDataArr['total_after_vat'], $datesAsIndexAndString, $customCollectionPolicy) ;
                    $withholdPayments = $study->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $withholdAmounts, $datesAsIndexAndString, $customCollectionPolicy) ;
                    $netPaymentsAfterWithhold = HArr::subtractAtDates([$payments,$withholdPayments], array_keys($payments));
                    $tableDataArr['withhold_amounts'] = $withholdAmounts ;
                    $tableDataArr['withhold_payments']=$withholdPayments;
                    $tableDataArr['payment_amounts'] = $payments;
                    $tableDataArr['net_payments_after_withhold']=$netPaymentsAfterWithhold;
                    $tableDataArr['collection_statements']   =$this->calculateStatement($collectionValues, $tableDataArr['total_vat'], $netPaymentsAfterWithhold, $withholdPayments, $dateIndexWithDate, $study);
        
                }
              
                $tableDataArr['company_id']  = $company->id ;
                $tableDataArr['model_id']   = $modelId ;
                $tableDataArr['model_name']   = $modelName ;
                if ($name) {
                    $model->generateRelationDynamically($tableId, $expenseType)->create($tableDataArr);
                }
                    
                
            }
        }
		return response()->json([
                'redirectTo'=>route('view.manpower.for.non.banking', ['company'=>$company->id,'study'=>$study->id])
            ]);
        
      
    }
	 public function calculateStatement(array $expenses, array $vats, array $netPaymentsAfterWithhold, array $withholdPayments, array $dateIndexWithDate, Study $study, float $beginningBalance = 0)
    {
        $expensesForIntervals = [
            'monthly'=>$expenses,
            'quarterly'=>sumIntervalsIndexes($expenses, 'quarterly', $study->financialYearStartMonth(), $dateIndexWithDate),
            'semi-annually'=>sumIntervalsIndexes($expenses, 'semi-annually', $study->financialYearStartMonth(), $dateIndexWithDate),
            'annually'=>sumIntervalsIndexes($expenses, 'annually', $study->financialYearStartMonth(), $dateIndexWithDate),
        ];
        $netPaymentAfterWithholdForInterval = [
            'monthly'=>$netPaymentsAfterWithhold,
            'quarterly'=>sumIntervalsIndexes($netPaymentsAfterWithhold, 'quarterly', $study->financialYearStartMonth(), $dateIndexWithDate),
            'semi-annually'=>sumIntervalsIndexes($netPaymentsAfterWithhold, 'semi-annually', $study->financialYearStartMonth(), $dateIndexWithDate),
            'annually'=>sumIntervalsIndexes($netPaymentsAfterWithhold, 'annually', $study->financialYearStartMonth(), $dateIndexWithDate),
        ];
        
        $result = [];
        foreach (getIntervalFormatted() as $intervalName=>$intervalNameFormatted) {
            $beginningBalance = 0;
            foreach ($expensesForIntervals[$intervalName] as $dateIndex=>$currentExpenseValue) {
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
	
}
