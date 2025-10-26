<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HArr;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\MicrofinanceProductSalesProject;
use App\Models\NonBankingService\Study;
use App\ReadyFunctions\CalculateFixedLoanAtBeginningService;
use App\ReadyFunctions\ConvertFlatRateToDecreasingRate;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MicrofinanceLoanController extends Controller
{
    use NonBankingService ;
    public function create(Company $company, Request $request, Study $study)
    {
        return view('non_banking_services.microfinance.loan-form', $this->getViewVars($company, $study));
    }
    protected function getViewVars(Company $company, Study $study)
    {
        $yearsWithItsMonths =  $study->getOperationDurationPerYearFromIndexes() ;
        $yearOrMonthsIndexes = $study->getYearOrMonthIndexes();
        $isYearsStudy = !$study->isMonthlyStudy();
        $studyMonthsForViews =array_flip($study->getOperationDatesAsDateAndDateAsIndexToStudyEndDate()) ;
        $dateIndexWithDate = $study->getDateIndexWithDate();
        $salesProjects = $study->microfinanceProductSalesProjects ;
        $salesProjectsPerProducts= [];
        $salesProjectsPerFundedBy= [];
        $salesProjectsPerTypes= [];
        foreach ($salesProjects as $salesProject) {
            $productId = $salesProject-> microfinance_product_id;
            $fundedBy = $salesProject->funded_by;
            $type = $salesProject->type;
            $monthlyLoanAmounts = $salesProject->monthly_loan_amounts?:[];
            if (array_sum($monthlyLoanAmounts) == 0) {
                continue;
            }
            foreach ($monthlyLoanAmounts as $dateAsIndex => $monthlyLoanAmount) {
                $salesProjectsPerProducts[$productId][$dateAsIndex] =  isset($salesProjectsPerProducts[$productId][$dateAsIndex]) ? $salesProjectsPerProducts[$productId][$dateAsIndex] + $monthlyLoanAmount:$monthlyLoanAmount;
                $salesProjectsPerFundedBy[$fundedBy][$productId][$dateAsIndex] = isset($salesProjectsPerFundedBy[$fundedBy][$productId][$dateAsIndex]) ? $salesProjectsPerFundedBy[$fundedBy][$productId][$dateAsIndex] + $monthlyLoanAmount   : $monthlyLoanAmount  ;
                $salesProjectsPerTypes[$type][$productId][$dateAsIndex] = isset($salesProjectsPerTypes[$type][$productId][$dateAsIndex]) ? $salesProjectsPerTypes[$type][$productId][$dateAsIndex] + $monthlyLoanAmount   : $monthlyLoanAmount  ;
            }
        }
        return [
            'salesProjectsPerTypes'=>$salesProjectsPerTypes,
            'salesProjectsPerFundedBy'=>$salesProjectsPerFundedBy,
            'salesProjectsPerProducts'=>$salesProjectsPerProducts,
            'dateIndexWithDate'=>$dateIndexWithDate,
            'eclAndNewPortfolioFundingRate'=>$study->getEclAndNewPortfolioFundingRatesForStreamType(Study::MICROFINANCE),
            'company'=>$company ,
            'model'=>$study ,
            'study'=>$study,
            'products'=>$company->getActiveMicrofinanceProducts(),
            'title'=>__('Microfinance Loans'),
            'storeRoute'=>route('store.loan.microfinance', ['company'=>$company->id , 'study'=>$study->id]),
            'yearsWithItsMonths' =>$yearsWithItsMonths,
            'yearOrMonthsIndexes'=>$yearOrMonthsIndexes,
            'isYearsStudy'=>$isYearsStudy,
            'studyMonthsForViews'=>$studyMonthsForViews,
            'financialYearEndMonthNumber'=>$study->getFinancialYearEndMonthNumber(),
        ];
    }
    public function getDecreaseRateBasedOnFlatRate(Company $company, Request $request, Study $study)
    {
        $flatRate = $request->get('flatRate', 0) ;
        $tenor = $request->get('tenor', 0) ;
        $decreaseRate = (new ConvertFlatRateToDecreasingRate())->excel_rate($flatRate, $tenor);
        $decreaseRate = number_format($decreaseRate, 4) . ' %';
        return response()->json([
            'status'=>true ,
            'decreaseRate'=>$decreaseRate
        ]);
    }

    public function store(Company $company, Request $request, Study $study)
    {
      
       $study->calculateMicrofinanceLoans();
       
		
        $study->storeAdminFeesAndFundingStructureFor($request, Study::MICROFINANCE);
        
        
        
        return response()->json([
                'redirectTo'=>$study->getRevenueRoute(Study::SECURITIZATION)
            ]);
    }

}
