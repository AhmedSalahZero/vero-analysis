<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HArr;
use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StoreLeasingRevenueStreamRequest;
use App\Models\Company;
use App\Models\NonBankingService\LeasingCategory;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;

class LeasingController extends Controller
{
    use NonBankingService ;
    public function create(Company $company, Request $request, Study $study)
    {
		// Study::sumTwoIncomeStatements();
        return view('non_banking_services.leasing-revenue-stream-breakdown.form', $this->getViewVars($company, $study));
    }
    protected function getViewVars(Company $company, Study $study)
    {
        $eclAndNewPortfolioFundingRate = $study?  $study->getEclAndNewPortfolioFundingRatesForStreamType(Study::LEASING) : null;
        $yearsWithItsMonths =  $study->getOperationDurationPerYearFromIndexes() ;
        $yearOrMonthsIndexes = $study->getYearOrMonthIndexes();
        $isYearsStudy = !$study->isMonthlyStudy();
		// $additionalQueryParams = Request()->query();

		// $storeRoute =  ;
		// dd($additionalQueryParams);
		// dd($studyMonthsForViews = );
        return [
            'company'=>$company ,
            'study'=>$study,
            'model'=>$study ,
            'eclAndNewPortfolioFundingRate'=>$eclAndNewPortfolioFundingRate,
            'title'=>__('Leasing Revenue Stream Breakdown'),
            'storeRoute'=>routeWithQueryParam(route('store.leasing.revenue.stream.breakdown', ['company'=>$company->id , 'study'=>$study->id])),
            'yearsWithItsMonths' =>$yearsWithItsMonths,
            'yearOrMonthsIndexes'=>$yearOrMonthsIndexes,
            'isYearsStudy'=>$isYearsStudy
        ];
    }

    public function store(Company $company, StoreLeasingRevenueStreamRequest $request, Study $study)
    {
		// dd(Request()->all());
        if (count($request->get('leasingRevenueStreamBreakdown', []))) {
            $study->storeRepeaterRelations($request, ['leasingRevenueStreamBreakdown'], $company);
        }
        $loanAmounts = $request->get('loan_amounts', []);

        if ($request->has('loan_amounts')) {
            $study->leasingRevenueStreamBreakdown->each(function ($model) use ($loanAmounts) {
                $model->update([
                    'loan_amounts'=>$loanAmounts[$model->id]
                ]);
            });
            $study->update([
                'leasing_growth_rates'=>$request->get('growth_rate')
            ]);
        }
        $study->syncSeasonality($request->get('seasonality', []), Study::LEASING, $company->id) ;
        
        // $study->storeAdminFeesAndFundingStructureFor($request, Study::LEASING);
        $study->storeFixedLoans($request,Study::LEASING, 'leasingRevenueStreamBreakdown');
    
        
        if ($request->get('submitBtnType') == LeasingCategory::LEASING_CATEGORY_FORM_ID) {
            return response()->json([
                'redirectTo'=>route('create.leasing.revenue.stream.breakdown', ['company'=>$company->id,'study'=>$study->id])
            ]);
        }
        $study->updateExpensesPercentageAndCostPerUnitsOfSales();
		
		// $redirectRoute = $study->runIncomeStatementIfFromCashflow();
		// if($redirectRoute)
		// {
		// 	return $redirectRoute;
		// }
		
        
        return response()->json([
            'redirectTo'=>$study->getRevenueRoute(Study::DIRECT_FACTORING)
        ]);
    }
}
