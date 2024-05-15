<?php 
namespace App\Traits\Models;

use App\Models\AccountType;
use App\Models\CleanOverdraft;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;

trait HasStatements 
{
		/**
	 * * هنا لو اليوزر ضاف فلوس في الحساب
	 * * بنحطها في الاستيت منت
	 * * سواء كانت كاش استيتمنت او بانك استيتمنت علي حسب نوع الحساب او الحركة يعني
	 */
	public function handleStatement(?int $financialInstitutionId ,?AccountType $accountType = null , ?string $accountNumber = null,?string $moneyType = null,?string $receivingDate = null,?float $receivedAmount = null,?string $currencyName = null,?int $receivingBranchId = null)
	{
		if($accountType && $accountType->getSlug() == AccountType::CLEAN_OVERDRAFT){
			$cleanOverdraft  = CleanOverdraft::findByAccountNumber($accountNumber,getCurrentCompanyId(),$financialInstitutionId);
			$this->storeCleanOverdraftBankStatement($moneyType,$cleanOverdraft,$receivingDate,$receivedAmount);
		}
		elseif($accountType && $accountType->getSlug() == AccountType::CURRENT_ACCOUNT){
			$financialInstitutionAccount = FinancialInstitutionAccount::findByAccountNumber($accountNumber,getCurrentCompanyId(),$financialInstitutionId);
			$this->storeCurrentAccountBankStatement($receivingDate,$receivedAmount,$financialInstitutionAccount->id);
		}
		elseif($this->isCashInSafe()){
			$this->storeCashInSafeStatement($receivingDate,$receivedAmount,$currencyName,$receivingBranchId);
		}
	}
	
	public function storeCleanOverdraftBankStatement(string $moneyType , CleanOverdraft $cleanOverdraft , string $date , $receivedAmount )
	{
		return $this->cleanOverdraftBankStatement()->create([
			'type'=>$moneyType ,
			'clean_overdraft_id'=>$cleanOverdraft->id ,
			'company_id'=>$this->company_id ,
			'date'=>$date,
			'limit'=>$cleanOverdraft->getLimit(),
			'beginning_balance'=>0 ,
			'debit'=>$receivedAmount,
			'credit'=>0 
		]) ;
	}
	public function storeCashInSafeStatement(string $date , $receivedAmount , string $currencyName,int $branchId)
	{
		return $this->cashInSafeStatement()->create([
			'branch_id'=>$branchId,
			'currency'=>$currencyName ,
			'company_id'=>$this->company_id ,
			'debit'=>$receivedAmount,
			'date'=>$date,
		]);
	}	
	public function storeCurrentAccountBankStatement(string $date , $receivedAmount , int $financialInstitutionAccountId)
	{
		// dump($date);
		return $this->currentAccountBankStatement()->create([
			'financial_institution_account_id'=>$financialInstitutionAccountId,
			'company_id'=>$this->company_id ,
			'debit'=>$receivedAmount,
			'date'=>$date
		]);
	}	
	
}
