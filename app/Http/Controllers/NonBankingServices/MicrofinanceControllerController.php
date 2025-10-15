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

    public function store(Company $company, StoreLeasingRevenueStreamRequest $request, Study $study)
    {
            $study->storeRepeaterRelations($request, ['leasingRevenueStreamBreakdown'], $company);
        
     return response()->json([
                'redirectTo'=>route('create.leasing.revenue.stream.breakdown', ['company'=>$company->id,'study'=>$study->id])
            ]);
        
      
    }
}
