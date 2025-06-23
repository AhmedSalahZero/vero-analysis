<?php
namespace App\Traits;

use App\Models\AccountType;
use App\Models\Currency;
use App\Models\CurrentAccountBankStatement;
use App\Models\FinancialInstitutionAccount;
use App\Models\TimeOfDeposit;
use App\Services\Api\OdooService;
use App\Services\Api\TimeOrCertificateOfDepositOdooService;

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
	public function handleTdOrCdStoreDepositForOdoo(bool $accountNumberHasChanged)
	{
		/**
		 * @var TimeOfDeposit $this
		 */
		$company = $this->company ; 
		if($company->hasOdooIntegrationCredentials()){
			$fromFinancialInstitution = $this->financialInstitution;
			$toFinancialInstitution = $fromFinancialInstitution;
			$fromAccountTypeId = 27 ;
			$toAccountTypeId = $this instanceof TimeOfDeposit ? 28 : 29  ;
			$fromAccountNumber = FinancialInstitutionAccount::find($this->deducted_from_account_id)->getAccountNumber();
			$toAccountNumber = $this->getAccountNumber() ;
			$amount = $this->getAmount();
			$currencyName = $this->getCurrency();
			$date = $this->getStartDate();
			$fromJournalId = $fromFinancialInstitution->getJournalIdForAccount($fromAccountTypeId,$fromAccountNumber);
			 $fromOdooId = $fromFinancialInstitution->getOdooIdForAccount($fromAccountTypeId,$fromAccountNumber);
			$toJournalId = $toFinancialInstitution->getJournalIdForAccount($toAccountTypeId,$toAccountNumber);
			$toOdooId = $toFinancialInstitution->getOdooIdForAccount($toAccountTypeId,$toAccountNumber);
		
			if($toJournalId){
				$this->storeOdoo($company,$date,$fromOdooId,$fromJournalId,$toJournalId,$toOdooId, $amount, $currencyName, $accountNumberHasChanged);
			}else{
				$this->handleTdOrCdStoreDepositWithoutJournalForOdoo($accountNumberHasChanged);
			}
			
		}
	}
	public function handleTdOrCdStoreDepositWithoutJournalForOdoo(bool $accountNumberHasChanged)
	{
		/**
		 * @var TimeOfDeposit $this
		 */
		$company = $this->company ; 
		if($company->hasOdooIntegrationCredentials()){
			$timeOfCertificateOdooService = new TimeOrCertificateOfDepositOdooService($company);
			// $odooSetting = $company->odooSetting ;
			$fromFinancialInstitution = $this->financialInstitution;
			$toFinancialInstitution = $fromFinancialInstitution;
			$fromAccountTypeId = 27 ;
			$toAccountTypeId = $this instanceof TimeOfDeposit ? 28 : 29  ;
			$toAccountNumber = $this->getAccountNumber() ;
			$amount = $this->getAmount();
			$currencyName = $this->getCurrency();
			$date = $this->getStartDate();
			$odooCurrencyId = Currency::getOdooId($currencyName);
			$fromAccountNumber = FinancialInstitutionAccount::find($this->deducted_from_account_id)->getAccountNumber();
			$fromJournalId = $fromFinancialInstitution->getJournalIdForAccount($fromAccountTypeId,$fromAccountNumber);
			 $fromOdooId = $fromFinancialInstitution->getOdooIdForAccount($fromAccountTypeId,$fromAccountNumber);
			$toOdooId = $toFinancialInstitution->getOdooIdForAccount($toAccountTypeId,$toAccountNumber);
			$ref = $this instanceof TimeOfDeposit ?  __('Create Time Of Deposit') : __('Create Certificate Of Deposit');
			$message = $ref;
			$result = $timeOfCertificateOdooService->createAndPostJournalEntry($date,$amount*-1,$odooCurrencyId,$fromJournalId,$fromOdooId,$toOdooId,$ref,null,$message);
			$this->store_account_bank_statement_line_id = $result['account_bank_statement_line_id'];
			$this->store_journal_entry_id = $result['journal_entry_id'];
			$this->save();
				
		}
	}
	
	public function handleTdOrCdApplyDepositInterestForOdoo(bool $accountNumberHasChanged)
	{
		/**
		 * @var TimeOfDeposit $this
		 */
		$company = $this->company ; 
		$date = $this->getDepositDate();
		if($company->hasOdooIntegrationCredentials() && $company->withinIntegrationDate($date)){
			$timeOfCertificateOdooService = new TimeOrCertificateOfDepositOdooService($company);
			$odooSetting = $company->odooSetting ;
			$fromFinancialInstitution = $this->financialInstitution;
			$debitAccountTypeId = 27 ;
			$amount = $this->getAmount();
			$currencyName = $this->getCurrency();
			
			$odooCurrencyId = Currency::getOdooId($currencyName);
			
			$creditAccountTypeId = $this instanceof TimeOfDeposit ? 28 : 29  ;
			$debitAccountNumber = FinancialInstitutionAccount::find($this->deducted_from_account_id)->getAccountNumber();
			$creditAccountNumber = $this->getAccountNumber() ;
			$toFinancialInstitution = $fromFinancialInstitution;
			$creditJournalId = $fromFinancialInstitution->getJournalIdForAccount($creditAccountTypeId,$creditAccountNumber);
			 $creditOdooId = $fromFinancialInstitution->getOdooIdForAccount($creditAccountTypeId,$creditAccountNumber);
			$debitJournalId = $toFinancialInstitution->getJournalIdForAccount($debitAccountTypeId,$debitAccountNumber);
			$debitOdooId = $toFinancialInstitution->getOdooIdForAccount($debitAccountTypeId,$debitAccountNumber);
			 
			  if($creditJournalId){
				$this->storeOdoo($company,$date,$debitJournalId,$debitOdooId,$creditOdooId,$creditJournalId, $amount, $currencyName, $accountNumberHasChanged);
			 }else{
				$ref =$this instanceof TimeOfDeposit ? __('Time Of Deposit Maturity') : __('Certificate Of Deposit Maturity');
				$message=$ref;
				$result = $timeOfCertificateOdooService->createMoneyDepositInBank($date,$amount,$odooCurrencyId,$debitJournalId,$debitOdooId,$creditOdooId,$ref,null,$message);
				$this->maturity_account_bank_statement_line_id = $result['account_bank_statement_line_id'];
				$this->maturity_journal_entry_id = $result['journal_entry_id'];
			 }
			$creditAccountTypeId = $odooSetting->getInterestRevenueOdooId();
			$ref =$this instanceof TimeOfDeposit ? __('Time Of Deposit Interest') : __('Certificate Of Deposit Interest');
			$message=$ref;
			$interestAmount = $this->getInterestAmount();
			$result = $timeOfCertificateOdooService->createMoneyDepositInBank($date,$interestAmount,$odooCurrencyId,$debitJournalId,$debitOdooId,$creditAccountTypeId,$ref,null,$message);
			$this->interest_account_bank_statement_line_id = $result['account_bank_statement_line_id'];
			$this->interest_journal_entry_id = $result['journal_entry_id'];
			$this->save();
		}
	}
	public function storeRenewal(string $expiryDate,float $newInterestRate)
	{
		$company = $this->company ;
		if($company->hasOdooIntegrationCredentials()){
				$interestAmount = $this->getInterestAmount();
			$timeOfCertificateOdooService = new TimeOrCertificateOfDepositOdooService($company);
			$fromFinancialInstitution = $this->financialInstitution;
			$debitAccountTypeId = 27 ;
			$currencyName = $this->getCurrency();
			$date = $expiryDate;
			$odooCurrencyId = Currency::getOdooId($currencyName);
			$odooSetting = $company->odooSetting ;
	//		$creditAccountTypeId = $this instanceof TimeOfDeposit ? 28 : 29  ;
			$debitAccountNumber = FinancialInstitutionAccount::find($this->deducted_from_account_id)->getAccountNumber();
			//$creditAccountNumber = $this->getAccountNumber() ;
			$toFinancialInstitution = $fromFinancialInstitution;
			// $creditJournalId = $fromFinancialInstitution->getJournalIdForAccount($creditAccountTypeId,$creditAccountNumber);
			//  $creditOdooId = $fromFinancialInstitution->getOdooIdForAccount($creditAccountTypeId,$creditAccountNumber);
			$debitJournalId = $toFinancialInstitution->getJournalIdForAccount($debitAccountTypeId,$debitAccountNumber);
			$debitOdooId = $toFinancialInstitution->getOdooIdForAccount($debitAccountTypeId,$debitAccountNumber);
			$creditAccountTypeId = $odooSetting->getInterestRevenueOdooId();
			$ref =$this instanceof TimeOfDeposit ? __('Time Of Deposit Renewal Interest') : __('Certificate Of Deposit Renewal Interest');
			$message=$ref;
			$interestAmount = $newInterestRate;
			$result = $timeOfCertificateOdooService->createMoneyDepositInBank($date,$interestAmount,$odooCurrencyId,$debitJournalId,$debitOdooId,$creditAccountTypeId,$ref,null,$message);
			$this->renewal_account_bank_statement_line_id = $result['account_bank_statement_line_id'];
			$this->renewal_journal_entry_id = $result['journal_entry_id'];
			$this->save();
		}
	
			
	}
	public function storeOdooBreak($accountNumberHasChanged)
	{
		/**
		 * @var TimeOfDeposit $this
		 */
		$company = $this->company ; 
		$date = $this->getBreakDate();
		if($company->hasOdooIntegrationCredentials() && $company->withinIntegrationDate($date)) {
			$timeOfCertificateOdooService = new TimeOrCertificateOfDepositOdooService($company);
			$fromFinancialInstitution = $this->financialInstitution;
			$debitAccountTypeId = 27 ;
			$amount = $this->getBreakInterestAmount();
			$currencyName = $this->getCurrency();
			
			$odooCurrencyId = Currency::getOdooId($currencyName);
			$creditAccountTypeId = $this instanceof TimeOfDeposit ? 28 : 29  ;
			$debitAccountNumber = FinancialInstitutionAccount::find($this->deducted_from_account_id)->getAccountNumber();
			$creditAccountNumber = $this->getAccountNumber() ;
			$toFinancialInstitution = $fromFinancialInstitution;
			$creditJournalId = $fromFinancialInstitution->getJournalIdForAccount($creditAccountTypeId,$creditAccountNumber);
			 $creditOdooId = $fromFinancialInstitution->getOdooIdForAccount($creditAccountTypeId,$creditAccountNumber);
			$debitJournalId = $toFinancialInstitution->getJournalIdForAccount($debitAccountTypeId,$debitAccountNumber);
			$debitOdooId = $toFinancialInstitution->getOdooIdForAccount($debitAccountTypeId,$debitAccountNumber);
			 
			  if($creditJournalId){
				$this->storeOdoo($company,$date,$debitJournalId,$debitOdooId,$creditOdooId,$creditJournalId, $amount, $currencyName, $accountNumberHasChanged,true);
			 }else{
				$ref =$this instanceof TimeOfDeposit ? __('Time Of Deposit Break Interest') : __('Certificate Of Deposit Break Interest');
				$message=$ref;
				$result = $timeOfCertificateOdooService->createMoneyDepositInBank($date,$amount,$odooCurrencyId,$debitJournalId,$debitOdooId,$creditOdooId,$ref,null,$message);
				$this->break_account_bank_statement_line_id = $result['account_bank_statement_line_id'];
				$this->break_journal_entry_id = $result['journal_entry_id'];
			 }
			
		}
	}
	public function reverseOdooDeposit()
	{
		$company = $this->company;
		if($company->hasOdooIntegrationCredentials()){
			foreach(['maturity_account_bank_statement_line_id', 'interest_account_bank_statement_line_id'] as $name){
				$unlinkId = $this->{$name};
				if($unlinkId){
				$odoService = new OdooService($company);
				$odoService->unlink('account.bank.statement.line',$unlinkId);
				$this->{$name} = null ;
				$this->save();
				}
			}
			
		}
	}	
	
}
