<?php
namespace App\Traits\Models;

use App\Models\Currency;
use App\Models\ForeignExchangeRate;
use App\Models\MoneyReceived;
use App\Services\Api\MoneyPaymentOdooService;



trait HasNonCustomerOrSupplier
{
public function storeNonCustomerOrSupplierOdooExpense()
	{
		$company = $this->company ;
		$date = $this->getDate();
		if($company->hasOdooIntegrationCredentials() && $company->withinIntegrationDate($date)){
			$isMoneyReceived = $this instanceof MoneyReceived ;
			$moneyPaymentOdooService = new MoneyPaymentOdooService($company);
			$amountInCurrency = $this->getAmount();
			$paidCurrencyName = $this->getReceivingOrPaymentCurrency();
			$mainFunctionalCurrency = $company->getMainFunctionalCurrency();
			$amountInMainFunctionalCurrency = $mainFunctionalCurrency != $paidCurrencyName ? ForeignExchangeRate::getExchangeRateForCurrencyAndClosestDate($paidCurrencyName,$mainFunctionalCurrency,$date,$company->id) * $amountInCurrency : $amountInCurrency;
			$journalId = $moneyPaymentOdooService->getJournalId($this) ;
			$chartOfAccountOdooId = $moneyPaymentOdooService->getChartOfAccountId($this); 
			$odooCurrencyId = Currency::getOdooId($paidCurrencyName);
			$dooIdWithRef =  $this->getOdooIdWithRefOfTransaction() ;
			$creditOdooAccountId=$isMoneyReceived ? $dooIdWithRef['id'] : $chartOfAccountOdooId;
			$debitOdooAccountId = $isMoneyReceived ?  $chartOfAccountOdooId : $dooIdWithRef['id'] ;
			$isTax = $this->partner->isTax();
			$odooPartnerId = $this->partner->getOdooId();
		//	$debitOdooAccountId = $isTax ? $odooPartnerId : $debitOdooAccountId;
			$ref =$dooIdWithRef['ref'] ;
			$result   = $moneyPaymentOdooService->createCashExpense($date,$amountInCurrency,$amountInMainFunctionalCurrency,$journalId,$odooCurrencyId,$debitOdooAccountId,$creditOdooAccountId,$odooPartnerId,$ref,$isTax);
			$this->account_bank_statement_line_id = $result['account_bank_statement_line_id'];
			$this->journal_entry_id = $result['journal_entry_id'];
			$this->odoo_reference = $result['odoo_reference'];
			$this->save();
				
			
		}
	}
	public function unlinkNonCustomerOrSupplierOdooExpense()
	{
			$company = $this->company ;
			$journalEntryId = $this->journal_entry_id;
			if($company->hasOdooIntegrationCredentials() && $journalEntryId){
				$moneyPaymentOdooService = new MoneyPaymentOdooService($company);
				$moneyPaymentOdooService->unlink($journalEntryId);
			}
	}
	
}
