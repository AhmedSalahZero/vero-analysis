<?php
namespace App\Traits\Models;



trait HasLetterOfGuaranteeStatements
{
    public function generateLetterOfGuaranteeData(int $financialInstitutionId , string $source  , int $lgFacilityId,string $lgType,$companyId,string $date,$beginningBalance,$debit , $credit,string $currencyName , int $cdOrTdId = 0 , $type =null):array
    {
        return [
			'type'=>$type , // beginning-balance for example
			'lg_facility_id'=>$lgFacilityId ,
			'cd_or_td_id'=>$cdOrTdId,
			'source'=>$source,
			'financial_institution_id'=>$financialInstitutionId,
			'lg_type'=>$lgType ,
			'currency'=>$currencyName ,
			'company_id'=>$companyId ,
			'beginning_balance'=>$beginningBalance,
			'debit'=>$debit,
			'credit'=>$credit ,
			'date'=>$date,
		];
    }
		/**
	 * * هنا لو اليوزر ضاف فلوس في الحساب
	 * * بنحطها في الاستيت منت
	 * * سواء كانت كاش استيتمنت او بانك استيتمنت علي حسب نوع الحساب او الحركة يعني
	 */
	public function handleLetterOfGuaranteeStatement(int $financialInstitutionId , string $source  , int $lgFacilityId,string $lgType,$companyId,string $date,$beginningBalance,$debit , $credit,string $currencyName , $cdOrTdId = 0 , $type =null)
	{
		$data = $this->generateLetterOfGuaranteeData($financialInstitutionId , $source  , $lgFacilityId, $lgType,$companyId,$date,$beginningBalance,$debit , $credit,$currencyName , $cdOrTdId , $type) ;
		$this->letterOfGuaranteeStatements()->create($data);

	}

	
	// public function storeCurrentAccountDebitBankStatement(string $date , $debit , int $financialInstitutionAccountId)
	// {
	// 	return $this->currentAccountDebitBankStatement()->create([
	// 		'financial_institution_account_id'=>$financialInstitutionAccountId,
	// 		'company_id'=>$this->company_id ,
	// 		'credit'=>0,
	// 		'debit'=>$debit,
	// 		'date'=>$date
	// 	]);
	// }

}
