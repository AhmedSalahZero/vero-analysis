<?php
namespace App\Http\Controllers;
use App\Models\Company;
// use App\Traits\GeneralFunctions;
use App\Models\FinancialInstitution;
use App\Models\Partner;
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
		$taxesColumns = [
			'vat_taxes_code'=>'VAT Taxes',
			'credit_withhold_taxes_code'=>'Credit Withhold Taxes',
			'salary_taxes_code'=>'Salary Taxes',
			'social_insurance_code' => 'Social Insurance',
			'income_taxes_code'=>'Income Taxes',
			'real_estate_taxes_code'=>'Real Estate Taxes',
			'stamp_duty_taxes_code'=>'Stamp Duty Taxes',
			'other_taxes_code'=>'Other Taxes'
		];
		foreach($taxesColumns as $name){
			$row = Partner::where('company_id',$company->id)->where('is_tax',1)->where('name',$name)->first();
			$data = [
				'name'=>$name ,
				'is_tax'=>1 ,
				'is_customer'=>0,
				'is_supplier'=>0 ,
				'company_id'=>$company->id,
			];
			if($row){
					$row->update($data);
			}else{
				Partner::create($data);
			}
		}
		foreach($request->except(array_merge(['_token'])) as $key => $value){
			$journal = $odooService->fetchData('account.account',['code','name'],[[['code','=',$value]]]);
			if($journal){
				$dbKeyName = str_replace('_code','_id',$key) ;
				$result[$dbKeyName] = $journal[0]['id'] ; 
				$result[$key] = $value ; 
				if(in_array($key,array_keys($taxesColumns))){
					Partner::where('company_id',$company->id)->where('name',$taxesColumns[$key])->where('is_tax',1)->update([
						'odoo_id'=>$result[$dbKeyName]
					]);
				}
			}
		}
		$setting ? $setting->update($result) :$company->odooSetting()->create($result) ;
		
		return redirect()->route('odoo-settings.index',['company'=>$company->id]);
	}
	
}
