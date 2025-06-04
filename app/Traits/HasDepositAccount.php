<?php
namespace App\Traits;

use App\Models\AccountType;
use App\Models\CurrentAccountBankStatement;
use App\Models\FinancialInstitutionAccount;
use App\Models\TimeOfDeposit;

trait HasDepositAccount
{
	/**
	 * * نوع الحساب اللي هيتخصم منه الوديعة وهنا احنا معتبرينه علطول حساب جاري ولو فاضي هنعتبرها 
	 * * opening balance
	 */
	public function getDeductedFromAccountTypeId():?int 
	{
		return $this->deducted_from_account_type_id;
	}
	public function getDeductedFromAccountId():?int 
	{
		return $this->deducted_from_account_id;
	}
	public function handleDeductedForBankStatement(int $financialInstitutionId,string $date , float $amount , int $companyId,int $deductedFromAccountId,$accountNumber)
	{
		$commentEn=$this instanceof TimeOfDeposit ? __('Time Of Deposit') . ' '. $accountNumber : __('Certificate Of Deposit')  . ' '. $accountNumber;
		$commentAr=$this instanceof TimeOfDeposit ? __('Time Of Deposit') . ' '. $accountNumber : __('Certificate Of Deposit')  . ' '. $accountNumber;
		
		CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($this->currentAccountBankStatements->where('type',CurrentAccountBankStatement::DEDUCTED_FOR_CURRENT_ACCOUNT));
		if($deductedFromAccountId){
			$accountType = AccountType::onlyCurrentAccount()->first();
			$accountNumber = FinancialInstitutionAccount::find($deductedFromAccountId)->getAccountNumber();
			$amount = number_unformat($amount);
			$type = CurrentAccountBankStatement::DEDUCTED_FOR_CURRENT_ACCOUNT;
			$this->handleCreditStatement($companyId,$financialInstitutionId , $accountType , $accountNumber , null , $date,$amount,null,null,$commentEn,$commentAr,$type);
		}
	}
	
	
}
