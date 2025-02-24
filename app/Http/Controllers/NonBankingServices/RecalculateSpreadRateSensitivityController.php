<?php

namespace App\Http\Controllers\NonBankingServices;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RecalculateSpreadRateSensitivityController extends Controller
{
	use NonBankingService ;
	
	public function recalculate(Company $company , Study $study,Request $request)
	{
		$sensitivityMarginRates = $request->get('sensitivity_margin_rate',[]);
		foreach($sensitivityMarginRates as $leasingRevenueStreamBreakdownId => $sensitivityMarginRate){
			DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('leasing_revenue_stream_breakdowns')->where('id',$leasingRevenueStreamBreakdownId)->update([
				'sensitivity_margin_rate'=>number_unformat($sensitivityMarginRate)
			]);
		}
		$study->storeFixedLoans(Study::LEASING,'leasingRevenueStreamBreakdown','leasingEclAndNewPortfolioFundingRate',true);
		return redirect()->route('view.results.dashboard',['company'=>$company->id,'study'=>$study->id]);
	}
}
