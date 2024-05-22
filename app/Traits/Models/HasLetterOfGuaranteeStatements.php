<?php 
namespace App\Traits\Models;



trait HasLetterOfGuaranteeStatements 
{
		/**
	 * * هنا لو اليوزر ضاف فلوس في الحساب
	 * * بنحطها في الاستيت منت
	 * * سواء كانت كاش استيتمنت او بانك استيتمنت علي حسب نوع الحساب او الحركة يعني
	 */
	public function handleLetterOfGuaranteeStatement(int $financialInstitutionId , string $source  , int $lgFacilityId,string $lgType,$companyId,string $date,$beginningBalance,$debit , $credit,string $currencyName , $type =null)
	{
		
		$this->letterOfGuaranteeStatements()->create([
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
		]);
	
	}
	
	// public function storeCleanOverdraftDebitBankStatement(string $moneyType , CleanOverdraft $cleanOverdraft , string $date , $debit )
	// {
	// 	return $this->cleanOverdraftDebitBankStatement()->create([
	// 		'type'=>$moneyType ,
	// 		'clean_overdraft_id'=>$cleanOverdraft->id ,
	// 		'company_id'=>$this->company_id ,
	// 		'date'=>$date,
	// 		'limit'=>$cleanOverdraft->getLimit(),
	// 		'beginning_balance'=>0 ,
	// 		'debit'=>$debit,
	// 		'credit'=>0
	// 	]) ;
	// }
	// public function storeCashInSafeDebitStatement(string $date , $debit , string $currencyName,int $branchId,$exchangeRate)
	// {
	// 	return $this->cashInSafeDebitStatement()->create([
	// 		'branch_id'=>$branchId,
	// 		'currency'=>$currencyName ,
	// 		'exchange_rate'=>$exchangeRate,
	// 		'company_id'=>$this->company_id ,
	// 		'debit'=>$debit,
	// 		'credit'=>0,
	// 		'date'=>$date,
	// 	]);
	// }	
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
	
}
