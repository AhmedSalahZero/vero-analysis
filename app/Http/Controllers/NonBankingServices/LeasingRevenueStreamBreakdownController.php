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

class LeasingRevenueStreamBreakdownController extends Controller
{
	use NonBankingService ;
	public function create(Company $company , Request $request,Study $study){
		
		return view('non_banking_services.leasing-revenue-stream-breakdown.form', $this->getViewVars($company,$study));
	}
	protected function getViewVars(Company $company, Study $study){
		$leasingEclAndNewPortfolioFundingRate = $study?  $study->leasingEclAndNewPortfolioFundingRate : null;
		$yearsWithItsMonths =  $study->getOperationDurationPerYearFromIndexes() ;
		$yearOrMonthsIndexes = $study->getYearOrMonthIndexes();
		$isYearsStudy = !$study->isMonthlyStudy();
		
		return [
			'company'=>$company ,
			'study'=>$study,
			'model'=>$study ,
			'leasingEclAndNewPortfolioFundingRate'=>$leasingEclAndNewPortfolioFundingRate,
			'title'=>__('Leasing Revenue Stream Breakdown'),
			'storeRoute'=>route('store.leasing.revenue.stream.breakdown',['company'=>$company->id , 'study'=>$study->id]),
			'yearsWithItsMonths' =>$yearsWithItsMonths,
			'yearOrMonthsIndexes'=>$yearOrMonthsIndexes,
			'isYearsStudy'=>$isYearsStudy
		];
	}

	public function store(Company $company , StoreLeasingRevenueStreamRequest $request,Study $study)
	{
		if(count($request->get('leasingRevenueStreamBreakdown',[]))){
			$study->storeRepeaterRelations($request,['leasingRevenueStreamBreakdown'],$company);
		}
		////
		// $monthlyLoanAmounts = [];
		// $operationDurationPerYear=$study->getOperationDurationPerYearFromIndexes();
		// $revenueIdWitLoanAmounts = $study->leasingRevenueStreamBreakdown->pluck('loan_amounts','id')->toArray() ;
		// foreach($revenueIdWitLoanAmounts as $leasingRevenueStreamBreakdownId => $yearIndexWithAmount){
		// 	foreach($operationDurationPerYear as $yearIndex => $yearMonthIndexes){
			
		// 	foreach($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne ){
				
		// 		$loanAtCurrentYear = $yearIndexWithAmount[$yearIndex]??0 ;
		// 		$currentMonthlyLoanAmount = $loanAtCurrentYear / count($yearMonthIndexes)  ;
		// 		$monthlyLoanAmounts[$leasingRevenueStreamBreakdownId][$monthIndex] = $currentMonthlyLoanAmount ;
		// 	}
		// 	}
		// 	$study->leasingRevenueStreamBreakdown->where('id',$leasingRevenueStreamBreakdownId)->first()->update([
		// 		'monthly_loan_amounts'=>$monthlyLoanAmounts[$leasingRevenueStreamBreakdownId]
		// 	]);
		// }
		
		///
		$loanAmounts = $request->get('loan_amounts',[]);
		if($request->has('growth_rate')){
			$study->leasingRevenueStreamBreakdown->each(function($model) use ($loanAmounts){
				$model->update([
					'loan_amounts'=>$loanAmounts[$model->id]
				]);
			});
			$study->update([
				'leasing_growth_rates'=>$request->get('growth_rate')
			]);
		}
		
		if($request->has('admin_fees_rates')){
			$adminFeesRates = $request->get('admin_fees_rates',[]);
			$newLoansFundingValues = $request->get('new_loans_funding_values',[]) ;
			$equityFundingValues = $request->get('equity_funding_values',[]) ;
			$loanAmounts = $request->get('loan_amounts',[]);
			$sumLoanAmounts = HArr::sumForInternalIndexes($loanAmounts);
			$monthlyAdminFeesAmount = $study->calculateMonthlyAdminFeesAmounts($adminFeesRates , $sumLoanAmounts  );
							
			$data = [
				'revenue_stream_type'=>Study::LEASING,
				'admin_fees_rates'=>$adminFeesRates,
				'monthly_admin_fees_amounts'=>$monthlyAdminFeesAmount,
				'ecl_rates'=>$request->get('ecl_rates',[]),
				'equity_funding_rates'=>$request->get('equity_funding_rates',[]),
				'equity_funding_values'=>$equityFundingValues,
				'new_loans_funding_rates'=>$request->get('new_loans_funding_rates',[]),
				'new_loans_funding_values'=>$newLoansFundingValues,
				'company_id'=>$company->id
			];
			if($study->leasingEclAndNewPortfolioFundingRate){
				$study->leasingEclAndNewPortfolioFundingRate->update($data);
			}else{
				$study->leasingEclAndNewPortfolioFundingRate()->create($data);
			}
			
		}
		
		$study->storeFixedLoans(Study::LEASING,'leasingRevenueStreamBreakdown','leasingEclAndNewPortfolioFundingRate');
		
		/**
		 * * end testing
		 */
		
		if($request->get('submitBtnType') == LeasingCategory::LEASING_CATEGORY_FORM_ID){
			return response()->json([
				'redirectTo'=>route('create.leasing.revenue.stream.breakdown',['company'=>$company->id,'study'=>$study->id])
			]);
		}
		$study->updateExpensesPercentagesOfSales();
		
		return response()->json([
			'redirectTo'=>route('create.direct.factoring.revenue.stream.breakdown',['company'=>$company->id,'study'=>$study->id])
		]);
	}
}
