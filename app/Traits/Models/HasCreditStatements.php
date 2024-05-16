<?php 
namespace App\Traits\Models;

use App\Models\AccountType;
use App\Models\CleanOverdraft;
use App\Models\FinancialInstitutionAccount;

trait HasCreditStatements 
{
		/**
	 * * هنا لو اليوزر ضاف فلوس في الحساب
	 * * بنحطها في الاستيت منت
	 * * سواء كانت كاش استيتمنت او بانك استيتمنت علي حسب نوع الحساب او الحركة يعني
	 */
	public function handleCreditStatement(int $companyId , $bankId = null ,?AccountType $accountType = null , ?string $accountNumber = null,?string $moneyType = null,?string $statementDate = null,?float $paidAmount = null,$deliveryBranchId=null,?string $currencyName = null)
	{
		if($accountType && $accountType->getSlug() == AccountType::CLEAN_OVERDRAFT){
			$cleanOverdraft  = CleanOverdraft::findByAccountNumber($accountNumber,$companyId,$bankId);
			$this->storeCleanOverdraftCreditBankStatement($moneyType,$cleanOverdraft,$statementDate,$paidAmount);
		}
		elseif($accountType && $accountType->getSlug() == AccountType::CURRENT_ACCOUNT){
			$financialInstitutionAccount = FinancialInstitutionAccount::findByAccountNumber($accountNumber,$companyId,$bankId);
			$this->storeCurrentAccountCreditBankStatement($statementDate,$paidAmount,$financialInstitutionAccount->id);
		}
		elseif($this->isCashPayment()){
			$this->storeCashInSafeCreditStatement($statementDate,$paidAmount,$currencyName,$deliveryBranchId);
		}
	}
	
	public function storeCashInSafeCreditStatement(string $date , $paidAmount , string $currencyName,int $branchId)
	{
		/**
		 * @var MoneyPayment $this 
		 */
		return $this->cashInSafeCreditStatement()->create([
			'branch_id'=>$branchId,
			'currency'=>$currencyName ,
			'company_id'=>$this->company_id ,
			'credit'=>$paidAmount,
			'date'=>$date
		]);
	}	
	
	public function storeCurrentAccountCreditBankStatement(string $date , $paidAmount , int $financialInstitutionAccountId)
	{
		return $this->currentAccountCreditBankStatement()->create([
			'financial_institution_account_id'=>$financialInstitutionAccountId ,
			'company_id'=>$this->company_id ,
			'credit'=>$paidAmount,
			'date'=>$date
		]);
	}	
	
	public function storeCleanOverdraftCreditBankStatement(string $moneyType , CleanOverdraft $cleanOverdraft , string $date , $paidAmount )
	{
		return  $this->cleanOverdraftCreditBankStatement()->create([
			'type'=>$moneyType ,
			'clean_overdraft_id'=>$cleanOverdraft->id ,
			'company_id'=>$this->company_id ,
			'date'=>$date,
			'limit'=>$cleanOverdraft->getLimit(),
			'beginning_balance'=>0 ,
			'debit'=>0,
			'credit'=>$paidAmount 
		]) ;
		
	}	
		
	
}
