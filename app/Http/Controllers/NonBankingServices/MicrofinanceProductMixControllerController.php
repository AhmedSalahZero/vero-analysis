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

class MicrofinanceProductMixControllerController extends Controller
{
    use NonBankingService ;
    public function create(Company $company, Request $request, Study $study)
    {
        return view('non_banking_services.microfinance-product-mix.form', $this->getViewVars($company, $study));
    }
    protected function getViewVars(Company $company, Study $study)
    {
		
        $yearsWithItsMonths =  $study->getOperationDurationPerYearFromIndexes() ;
        $yearOrMonthsIndexes = $study->getYearOrMonthIndexes();
        $isYearsStudy = !$study->isMonthlyStudy();
        return [
			'company'=>$company ,
			'products'=>$company->getActiveMicrofinanceProducts(),
            'model'=>$study ,
			'study'=>$study,
            'title'=>__('Microfinance Products Mix'),
            'storeRoute'=>route('store.microfinance.product.mix', ['company'=>$company->id , 'study'=>$study->id]),
            'yearsWithItsMonths' =>$yearsWithItsMonths,
            'yearOrMonthsIndexes'=>$yearOrMonthsIndexes,
            'isYearsStudy'=>$isYearsStudy
        ];
    }

    public function store(Company $company, Request $request, Study $study )
    {
       dd($study);
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
