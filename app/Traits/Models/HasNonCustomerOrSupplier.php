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
		if($company->hasOdooIntegrationCredentials()){
			$isMoneyReceived = $this instanceof MoneyReceived ;
			$moneyPaymentOdooService = new MoneyPaymentOdooService($company);
			$date = $this->getDate();
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
			$ref =$dooIdWithRef['ref'] ;
			$odooPartnerId = $this->partner->getOdooId();
			// $inUpdateMode = $this->account_bank_statement_line_id && $this->journal_entry_id ;
			// if($inUpdateMode){
			// 	 $moneyPaymentOdooService->unlink($this->journal_entry_id);
			// }
			
				$result   = $moneyPaymentOdooService->createCashExpense($date,$amountInCurrency,$amountInMainFunctionalCurrency,$journalId,$odooCurrencyId,$debitOdooAccountId,$creditOdooAccountId,$odooPartnerId,$ref);
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
