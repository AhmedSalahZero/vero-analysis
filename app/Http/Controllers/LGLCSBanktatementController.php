<?php

namespace App\Http\Controllers;

use App\Enums\LcTypes;
use App\Enums\LgTypes;
use App\Models\AccountType;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\LcOverdraftBankStatement;
use App\Models\LetterOfCreditIssuance;
use App\Models\LetterOfGuaranteeIssuance;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LGLCSBanktatementController
{
    use GeneralFunctions;

    public function index(Company $company,Request $request)
    {
		$lcSources = LetterOfCreditIssuance::lcSources();
		$selectedAccountTypeName = $request->get('accountType');
		$selectedCurrency  = $request->get('currency');
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$accountTypes = AccountType::onlyCashAccounts()->get();		
        return view('lg_lc_statement_form', [
            'company' => $company,
            'financialInstitutionBanks' => $financialInstitutionBanks,
			'accountTypes'=>$accountTypes,
			'selectedAccountTypeName'=>$selectedAccountTypeName,
			'selectedCurrency'=>$selectedCurrency,
			'lcSources'=>$lcSources
        ]);
    }

    public function result(Company $company, Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $financialInstitutionId = $request->get('financial_institution_id');
		$financialInstitution = FinancialInstitution::find($financialInstitutionId);
		$financialInstitutionName = $financialInstitution->getName();
 
		
        $currencyName = $request->get('currency');
		$results = [];
		$reportType = $request->get('report_type');
		$statementTableName = [
			'LetterOfCreditIssuance'=>'letter_of_credit_statements',
			'LetterOfGuaranteeIssuance'=>'letter_of_guarantee_statements',
		][$reportType];
		$lcTypeOrLgTypeColumnName = [
			'LetterOfCreditIssuance'=>'lc_type',
			'LetterOfGuaranteeIssuance'=>'lg_type',
		][$reportType];
		$source = $request->get('source');
		$type = $request->get('type');
		
		
		
		
		
		$results = DB::table($statementTableName)
				 ->where($statementTableName.'.company_id',$company->id)
				 ->where('date', '>=', $startDate)
				 ->where('date', '<=', $endDate)
				 ->where('currency',$currencyName)
				 ->where('financial_institution_id',$financialInstitutionId)
				 ->where('source',$source)
				 ->where($lcTypeOrLgTypeColumnName,$type)
				 ->orderByRaw('full_date desc')
				 ->get();
				 

        if (!count($results)) {
            return redirect()->back()->with('fail', __('No Data Found'));
        }

		
		$source = [
			'LetterOfCreditIssuance'=>LetterOfCreditIssuance::lcSources(),
			'LetterOfGuaranteeIssuance'=>LetterOfGuaranteeIssuance::lgSources() ,
			'LCOverdraft'=>LcOverdraftBankStatement::getSources()
		][$reportType][$request->get('source')];
		
		$type = [
			'LetterOfCreditIssuance'=>LcTypes::getAll(),
			'LetterOfGuaranteeIssuance'=>LgTypes::getAll(),
			
		][$reportType][$request->get('type')];
		
        return view('lc_lg_bank_statement_result', [
            'results' => $results,
            'currency' => $currencyName,
			'financialInstitutionName'=>$financialInstitutionName,
			'type'=>$type,
			'source'=>$source
        ]);
    }
	public function getLgOrLcType(Request $request , Company $company){
		$modelName = $request->get('lcOrLg');
	
		$types = [
			'LetterOfCreditIssuance'=>LcTypes::getAll(),
			'LetterOfGuaranteeIssuance'=>LgTypes::getAll() 
		][$modelName];
		
		$sources = [
			'LetterOfCreditIssuance'=>LetterOfCreditIssuance::lcSources(),
			'LetterOfGuaranteeIssuance'=>LetterOfGuaranteeIssuance::lgSources() 
		][$modelName];
		return response()->json([
			'types'=>$types ,
			'sources'=>$sources
		]);
	}
}
