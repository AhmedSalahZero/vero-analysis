<?php
namespace App\Traits\Models;

use App\Models\Currency;
use App\Models\ForeignExchangeRate;
use App\Models\MoneyReceived;
use App\Services\Api\MoneyPaymentOdooService;
use App\Services\Api\OdooPayment;

trait HasNonCustomerOrSupplier
{
    public function storeNonCustomerOrSupplierOdooExpense()
    {
        $company = $this->company ;
        $date = $this->getDate();
        if ($company->hasOdooIntegrationCredentials() && $company->withinIntegrationDate($date)) {
            $isMoneyReceived = $this instanceof MoneyReceived ;
            $odooPaymentService = new OdooPayment($company);
            if ($this->isChequeAndNotCustomerOrSupplier()) {
                $result = $odooPaymentService->createDownPayment($this);
                return ;
            }
             
            $moneyPaymentOdooService = new MoneyPaymentOdooService($company);
            $amountInCurrency = $this->getAmount();
            $paidCurrencyName = $this->getReceivingOrPaymentCurrency();
            $mainFunctionalCurrency = $company->getMainFunctionalCurrency();
            $amountInMainFunctionalCurrency = $mainFunctionalCurrency != $paidCurrencyName ? ForeignExchangeRate::getExchangeRateForCurrencyAndClosestDate($paidCurrencyName, $mainFunctionalCurrency, $date, $company->id) * $amountInCurrency : $amountInCurrency;
            $journalId = $moneyPaymentOdooService->getJournalId($this) ;
            $odooIdWithRef =  $this->getOdooIdWithRefOfTransaction() ;
            $chartOfAccountOdooId = $moneyPaymentOdooService->getChartOfAccountId($this);
            $odooCurrencyId = Currency::getOdooId($paidCurrencyName);
            $creditOdooAccountId=$isMoneyReceived ? $odooIdWithRef['id'] : $chartOfAccountOdooId;
            $debitOdooAccountId = $isMoneyReceived ?  $chartOfAccountOdooId : $odooIdWithRef['id'] ;
            $isTax = $this->partner->isTax();
            $odooPartnerId = $this->partner->getOdooId();
            //	$debitOdooAccountId = $isTax ? $odooPartnerId : $debitOdooAccountId;
            $ref =$odooIdWithRef['ref'] ;
            // if()																									// $journalId,int $odooCurrencyId,int $debitOdooAccountId,int $creditOdooAccountId,int $odooPartnerId
            $result   = $moneyPaymentOdooService->createCashExpense($date, $amountInCurrency, $amountInMainFunctionalCurrency, $journalId, $odooCurrencyId, $debitOdooAccountId, $creditOdooAccountId, $odooPartnerId, $ref, $isTax);
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
        
        if ($company->hasOdooIntegrationCredentials() && $journalEntryId) {
            $moneyPaymentOdooService = new MoneyPaymentOdooService($company);
            $moneyPaymentOdooService->unlink($journalEntryId);
        } elseif ($company->hasOdooIntegrationCredentials()) {
            $company =$this->company;
            if ($company->hasOdooIntegrationCredentials()) {
                $odooId = $this->odoo_id ;
                if ($odooId) {
                    $odooPaymentService = new OdooPayment($company);
                    $odooPaymentService->cancelDownPayment($odooId);
                }
            }
        }
        
            
    }

}
