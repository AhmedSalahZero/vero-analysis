<?php
namespace App\Http\Controllers;
use App\Models\Company;
// use App\Traits\GeneralFunctions;
use App\Models\FinancialInstitution;
use App\Services\Api\OdooService;
use Illuminate\Http\Request;

class OtherOdooSettingController
{
    // use GeneralFunctions;
	public function index(Company $company,Request $request)
	{
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
        return view('other-odoo-settings.form', [
			'company'=>$company,
			'model'=>$company->odooSetting,
			'financialInstitutionBanks'=>$financialInstitutionBanks
		]);
    }
	public function store(Request $request, Company $company){
		$setting = $company->odooSetting;
		$result = [];
		$odooService = new OdooService($company);
		foreach($request->except(['_token']) as $key => $value){
			$journal = $odooService->fetchData('account.account',['code','name'],[[['code','=',$value]]]);
			if($journal){
				$dbKeyName = str_replace('_code','_id',$key) ;
				$result[$dbKeyName] = $journal[0]['id'] ; 
				$result[$key] = $value ; 
			}
		}
		$setting ? $setting->update($result) :$company->odooSetting()->create($result) ;
		return redirect()->route('odoo-settings.index',['company'=>$company->id]);
	}
	
}
