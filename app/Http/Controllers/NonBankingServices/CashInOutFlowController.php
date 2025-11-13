<?php

namespace App\Http\Controllers\NonBankingServices;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashInOutFlowController extends Controller
{
	use NonBankingService ;
	
	
	public function view(Request $request , Company $company,Study $study)
	{
		$basicCashflowStatement = $study->getCashInOutFlowViewVars() ;
		// $hasMicrofinanceWithOdas =$basicCashflowStatement['hasMicrofinanceWithOdas']; 
		// if($hasMicrofinanceWithOdas){
			$netCashBeforeWorkingCapital = $basicCashflowStatement['netCashBeforeWorking'];
			$tableDataFormattedForOdas = $study->cashFlowForOdas($netCashBeforeWorkingCapital);
			$tableDataFormatteds = [
				__('Cashflow Statement')=>$basicCashflowStatement['tableDataFormatted']??[],
				__('ODAs Statement')=>$tableDataFormattedForOdas,
			];
			
			$leasingEclAndNewPortfolioFundingRates =[];
			foreach($study->getRevenuesTypesWithTitles() as $revenueStreamId => $revenueStreamTitle){
				$loanStructure = $study->getEclAndNewPortfolioFundingRatesForStreamType($revenueStreamId) ;
				if($loanStructure){
					$leasingEclAndNewPortfolioFundingRates[$revenueStreamId] = $loanStructure;
				}
			}
			
			
			return view(
            'non_banking_services.income-statement.cash-flow-with-odas',
			array_merge(
				$basicCashflowStatement , 
				['tableDataFormatteds'=>$tableDataFormatteds],
				[
					'studyDates'=>$study->getStudyDates(),
					'leasingEclAndNewPortfolioFundingRates'=>$leasingEclAndNewPortfolioFundingRates
				]
			)
        );
		// }
		
		//   return view(
        //     'non_banking_services.income-statement.cash-flow',
		// 	$basicCashflowStatement
        // );
	}
}
