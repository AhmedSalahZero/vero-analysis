<?php
namespace App\Traits;

use App\Models\AccountType;
use App\Models\CurrentAccountBankStatement;
use App\Models\FinancialInstitution;
use App\Models\TimeOfDeposit;
use Carbon\Carbon;



trait HasPeriodicInterest
{
	/**
	 * * يعني الفايدة بتنزل كاملة اخر المدة
	 */
	public function isAtMaturity()
	{
		return $this->is_at_maturity;
	}
	/**
	 * * يعني الفائدة هتنزل خلال فترة معينه
	 */
	public function isPeriodically()
	{
		return !$this->isAtMaturity();
	}
	public function applyPeriodicInterestInStatement(FinancialInstitution $financialInstitution,float $periodInterestAmount , string $periodInterestDate)
	{
		/**
		 * @var TimeOfDeposit $this
		 */
		$accountType = AccountType::where('slug',AccountType::CURRENT_ACCOUNT)->first() ;
		$periodInterestDate = Carbon::make($periodInterestDate)->format('Y-m-d');
		if($periodInterestAmount > 0){
			$accountNumber = $this->getMaturityAmountAddedToAccountNumber();
			$isPeriodInterest = true ;
			$commentEn=$this instanceof TimeOfDeposit ? __('Time Of Deposit') . ' '. $accountNumber : __('Certificate Of Deposit')  . ' '. $accountNumber;
			$commentAr=$this instanceof TimeOfDeposit ? __('Time Of Deposit') . ' '. $accountNumber : __('Certificate Of Deposit')  . ' '. $accountNumber;
			$this->handleDebitStatement($financialInstitution->id , $accountType , $this->getMaturityAmountAddedToAccountNumber() , null , $periodInterestDate,$periodInterestAmount,null,null,1,$commentEn,$commentAr,$isPeriodInterest);
		}
	}
	public function deletePeriodInterestAmounts()
	{
		if($this->isAtMaturity()){
			CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($this->currentAccountBankStatements->where('is_period_cd_or_td_interest',1));
		}
	}
}
