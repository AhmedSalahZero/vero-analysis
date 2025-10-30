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
		$hasMicrofinanceWithOdas =$basicCashflowStatement['hasMicrofinanceWithOdas']; 
		if($hasMicrofinanceWithOdas){
			$netCashBeforeWorkingCapital = $basicCashflowStatement['netCashBeforeWorking'];
			$tableDataFormattedForOdas = $study->cashFlowForOdas($netCashBeforeWorkingCapital);
			$tableDataFormattedExtraCapitalInjections = $study->cashFlowForExtraCapitalInjections();
			$tableDataFormatteds = [
				$basicCashflowStatement['tableDataFormatted']??[],
				$tableDataFormattedForOdas,
				$tableDataFormattedExtraCapitalInjections
				
			];
			
			
			
			
			return view(
            'non_banking_services.income-statement.cash-flow-with-odas',
			array_merge(
				$basicCashflowStatement , 
				['tableDataFormatteds'=>$tableDataFormatteds]
			)
        );
		}
		
		  return view(
            'non_banking_services.income-statement.cash-flow',
			$basicCashflowStatement
        );
	}
}
