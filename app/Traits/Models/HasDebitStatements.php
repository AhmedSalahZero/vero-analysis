<?php 
namespace App\Traits\Models;

use App\Models\AccountType;
use App\Models\CleanOverdraft;
use App\Models\FinancialInstitutionAccount;

trait HasDebitStatements 
{
		/**
	 * * هنا لو اليوزر ضاف فلوس في الحساب
	 * * بنحطها في الاستيت منت
	 * * سواء كانت كاش استيتمنت او بانك استيتمنت علي حسب نوع الحساب او الحركة يعني
	 */
	public function handleDebitStatement(?int $financialInstitutionId = 0 ,?AccountType $accountType = null , ?string $accountNumber = null,?string $moneyType = null,?string $receivingDate = null,?float $debit = 0,?string $currencyName = null,?int $receivingBranchId = null,$exchangeRate=1)
	{
		if($accountType && $accountType->getSlug() == AccountType::CLEAN_OVERDRAFT){
			$cleanOverdraft  = CleanOverdraft::findByAccountNumber($accountNumber,getCurrentCompanyId(),$financialInstitutionId);
			$this->storeCleanOverdraftDebitBankStatement($moneyType,$cleanOverdraft,$receivingDate,$debit);
		}
		elseif($accountType && $accountType->getSlug() == AccountType::CURRENT_ACCOUNT){
			$financialInstitutionAccount = FinancialInstitutionAccount::findByAccountNumber($accountNumber,getCurrentCompanyId(),$financialInstitutionId);
			$this->storeCurrentAccountDebitBankStatement($receivingDate,$debit,$financialInstitutionAccount->id);
		}
		elseif($this->isCashInSafe()){
			$this->storeCashInSafeDebitStatement($receivingDate,$debit,$currencyName,$receivingBranchId,$exchangeRate);
		}
	}
	
	public function storeCleanOverdraftDebitBankStatement(string $moneyType , CleanOverdraft $cleanOverdraft , string $date , $debit )
	{
		return $this->cleanOverdraftDebitBankStatement()->create([
			'type'=>$moneyType ,
			'clean_overdraft_id'=>$cleanOverdraft->id ,
			'company_id'=>$this->company_id ,
			'date'=>$date,
			'limit'=>$cleanOverdraft->getLimit(),
			'beginning_balance'=>0 ,
			'debit'=>$debit,
			'credit'=>0
		]) ;
	}
	public function storeCashInSafeDebitStatement(string $date , $debit , string $currencyName,int $branchId,$exchangeRate)
	{
		return $this->cashInSafeDebitStatement()->create([
			'branch_id'=>$branchId,
			'currency'=>$currencyName ,
			'exchange_rate'=>$exchangeRate,
			'company_id'=>$this->company_id ,
			'debit'=>$debit,
			'credit'=>0,
			'date'=>$date,
		]);
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
	
}
