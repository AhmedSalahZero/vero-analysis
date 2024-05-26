<?php
namespace App\Traits\Models;



trait HasLetterOfGuaranteeCashCoverStatements
{
    public function generateLetterOfGuaranteeCashCoverData(int $financialInstitutionId , string $source  , int $lgFacilityId,string $lgType,$companyId,string $date,$beginningBalance,$debit , $credit,string $currencyName , $type =null):array
    {
        return [
			'type'=>$type , // beginning-balance for example
			'lg_facility_id'=>$lgFacilityId ,
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

	public function handleLetterOfGuaranteeCashCoverStatement(int $financialInstitutionId , string $source  , int $lgFacilityId,string $lgType,$companyId,string $date,$beginningBalance,$debit , $credit,string $currencyName , $type =null)
	{
		$data = $this->generateLetterOfGuaranteeCashCoverData($financialInstitutionId , $source  , $lgFacilityId, $lgType,$companyId,$date,$beginningBalance,$debit , $credit,$currencyName , $type) ;
		$this->letterOfGuaranteeCashCoverStatements()->create($data);

	}

	
	public function storeCurrentAccountDebitBankStatement(string $date , $debit , int $financialInstitutionAccountId)
	{
		return $this->currentAccountDebitBankStatement()->create([
			'financial_institution_account_id'=>$financialInstitutionAccountId,
			'company_id'=>$this->company_id ,
			'credit'=>0,
			'debit'=>$debit,
			'date'=>$date
		]);
	}
	public function storeCurrentAccountCreditBankStatement(string $date , $credit , int $financialInstitutionAccountId)
	{
		return $this->currentAccountCreditBankStatement()->create([
			'financial_institution_account_id'=>$financialInstitutionAccountId,
			'company_id'=>$this->company_id ,
			'credit'=>$credit,
			'debit'=>0,
			'date'=>$date
		]);
	}
}
