<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NonBankingService\Consolidation;
use App\Models\NonBankingService\Study;
use Illuminate\Http\Request;

class ConsolidationIncomeStatementController extends Controller
{
    public function index(Company $company, Request $request,Consolidation $consolidation)
    {
		$studyIds = $consolidation->study_ids ;
		$onlyViewVars= true;
		$incomeStatements = [];
		foreach($studyIds as $studyId){
			$study = Study::find($studyId);
			$incomeStatements[]  = (new IncomeStatementController)->index($company,$study,$onlyViewVars)['tableDataFormatted'];
		}
		
		// dd('d',$incomeStatements);
	}
}
