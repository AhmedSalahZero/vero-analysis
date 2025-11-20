<?php
namespace App\Traits\Models;

use App\Models\Branch;
use App\Models\BuyOrSellCurrency;
use App\Models\Company;
use App\Models\Currency;
use App\Models\FinancialInstitution;
use App\Models\ForeignExchangeRate;
use App\Models\InternalMoneyTransfer;
use App\Services\Api\InternalMoneyTransfer as OdooInternalMoneyTransfer;

trait HasOdooMoneyTransfer
{
    
    private function storeOdoo(Company $company, string $date, int $outBankOdooId, int $outJournalId, int $inJournalId, int $inBankOdooId, float $amountInCurrency, string $currencyName, $isBreakDeposit= false)
    {
		// dd($inJournalId , $inBankOdooId);
        
        $odooCurrencyId = Currency::getOdooId($currencyName);
        $mainFunctionalCurrency =$company->getMainFunctionalCurrency();
        $amountInMainFunctionalCurrency = $currencyName != $mainFunctionalCurrency  ? $amountInCurrency * ForeignExchangeRate::getExchangeRateForCurrencyAndClosestDate($currencyName, $mainFunctionalCurrency, $date, $company->id) : $amountInCurrency ;
        $internalMoneyTransferService = (new OdooInternalMoneyTransfer($company));
        $outboundStatementColumnName = $isBreakDeposit ? 'outbound_break_account_bank_statement_odoo_id' : 'outbound_account_bank_statement_odoo_id';
        $outboundJournalColumnName = $isBreakDeposit ? 'outbound_break_journal_entry_id' : 'outbound_journal_entry_id';
        $inboundStatementColumnName = $isBreakDeposit ? 'inbound_break_account_bank_statement_odoo_id' : 'inbound_account_bank_statement_odoo_id';
        $inboundJournalColumnName = $isBreakDeposit ? 'inbound_break_journal_entry_id' : 'inbound_journal_entry_id';
        $inboundReferenceColumnName = $isBreakDeposit ? 'inbound_break_odoo_reference' : 'inbound_odoo_reference';
        $outboundReferenceColumnName = $isBreakDeposit ? 'outbound_break_odoo_reference' : 'outbound_odoo_reference';
        if ($this->{$outboundJournalColumnName}) {
            $receiveResult = $internalMoneyTransferService->unlink($this->{$outboundJournalColumnName});
        }
		// dd($odooCurrencyId,'send money tp '  , $outJournalId, $outBankOdooId , '--received' . $inJournalId, $inBankOdooId);
        $sendMoneyResult = $internalMoneyTransferService->sendMoneyTo($date, $amountInCurrency, $amountInMainFunctionalCurrency, $odooCurrencyId, $outJournalId, $outBankOdooId);
        $this->{$outboundStatementColumnName} = $sendMoneyResult['account_bank_statement_line_id'] ;
        $this->{$outboundJournalColumnName} = $sendMoneyResult['journal_entry_id'] ;
        $this->{$outboundReferenceColumnName} = $sendMoneyResult['reference'] ;
        /**
         * ! Need To Be Channged
         */
        $this->synced_with_odoo = $sendMoneyResult['synced_with_odoo'];
        $this->odoo_error_message = $sendMoneyResult['odoo_error_message'];
            
            
        if ($this->{$inboundJournalColumnName}) {
            $receiveResult = $internalMoneyTransferService->unlink($this->{$inboundJournalColumnName});
        }
        $receiveResult = $internalMoneyTransferService->storeReceiveMoneyTo($date, $amountInCurrency, $amountInMainFunctionalCurrency, $odooCurrencyId, $inJournalId, $inBankOdooId);
        $this->{$inboundStatementColumnName} = $receiveResult['account_bank_statement_line_id'] ;
        $this->{$inboundJournalColumnName} = $receiveResult['journal_entry_id'] ;
        $this->{$inboundReferenceColumnName} = $receiveResult['reference'] ;
        /**
         * ! Need To Be Channged
         */
        $this->synced_with_odoo = $receiveResult['synced_with_odoo'];
        $this->odoo_error_message = $receiveResult['odoo_error_message'];

        $this->save();
    }
    public function deleteOdoo()
    {
        $company = $this->company;
        if ($company->hasOdooIntegrationCredentials()) {
            $internalMoneyTransferService = (new OdooInternalMoneyTransfer($company));
            foreach (['inbound_journal_entry_id','outbound_journal_entry_id','inbound_break_journal_entry_id','outbound_break_journal_entry_id'] as $columnName) {
                if ($journalEntryId = $this->{$columnName}) {
                    $internalMoneyTransferService->unlink($journalEntryId);
                }
            }
        
        }
    }
    public function handleOdooTransfer()
    {
        /**
         * @var BuyOrSellCurrency
         */
        $company = $this->company;
        /**
         * @var Company $company
         */
        $transferDate = $this->getTransferDate();
        if ($company->hasOdooIntegrationCredentials() && $company->withinIntegrationDate($transferDate)) {
            $fromAccountTypeId = $this->from_account_type_id;
            $fromAccountNumber = $this->from_account_number;
            $toAccountTypeId = $this->to_account_type_id;
            $toAccountNumber = $this->to_account_number;
            $amountInCurrency = $this instanceof BuyOrSellCurrency ? $this->getAmountInMainCurrency() :  $this->getAmountInCurrency();
            $currencyName = $this instanceof BuyOrSellCurrency ? $this->getCurrencyToSell() :  $this->getCurrency();
            $fromBranchId = $this->from_branch_id;
            $toBranchId = $this->to_branch_id;
            $type = $this->getType();
            $fromFinancialInstitutionId =$this->from_bank_id;
            $toFinancialInstitutionId=$this->to_bank_id;
            $fromFinancialInstitution = FinancialInstitution::find($fromFinancialInstitutionId);
            $toFinancialInstitution = FinancialInstitution::find($toFinancialInstitutionId);
        
            if ($type == InternalMoneyTransfer::BANK_TO_BANK) {
                $fromJournalId = $fromFinancialInstitution->getJournalIdForAccount($fromAccountTypeId, $fromAccountNumber);
                $fromOdooId = $fromFinancialInstitution->getOdooIdForAccount($fromAccountTypeId, $fromAccountNumber);
                $toJournalId = $toFinancialInstitution->getJournalIdForAccount($toAccountTypeId, $toAccountNumber);
                $toOdooId = $toFinancialInstitution->getOdooIdForAccount($toAccountTypeId, $toAccountNumber);
                $this->storeOdoo($company, $transferDate, $fromOdooId, $fromJournalId, $toJournalId, $toOdooId, $amountInCurrency, $currencyName);
            } elseif ($type == InternalMoneyTransfer::BANK_TO_SAFE) {
                $fromOdooId = $fromFinancialInstitution->getOdooIdForAccount($fromAccountTypeId, $fromAccountNumber);
                $fromJournalId = $fromFinancialInstitution->getJournalIdForAccount($fromAccountTypeId, $fromAccountNumber);
                $branch = Branch::find($toBranchId) ;
                $toJournalId = $branch->getJournalId();
                $toOdooId = $branch->getOdooId();
                $this->storeOdoo($company, $transferDate, $fromOdooId, $fromJournalId,$toJournalId,$toOdooId, $amountInCurrency, $currencyName);
            } elseif ($type == InternalMoneyTransfer::SAFE_TO_BANK) {
                $branch = Branch::find($fromBranchId);
                $fromJournalId = $branch->getJournalId();
                $fromOdooId = $branch->getOdooId();
                $toJournalId = $toFinancialInstitution->getJournalIdForAccount($toAccountTypeId, $toAccountNumber);
                $toOdooId = $toFinancialInstitution->getOdooIdForAccount($toAccountTypeId, $toAccountNumber);
                $this->storeOdoo($company, $transferDate,$fromOdooId, $fromJournalId, $toJournalId,$toOdooId, $amountInCurrency, $currencyName);
                
            } elseif ($type == InternalMoneyTransfer::SAFE_TO_SAFE) {
                $fromBranch = Branch::find($fromBranchId);
                $fromJournalId = $fromBranch->getJournalId();
                $fromOdooId = $fromBranch->getOdooId();
                
                $toBranch = Branch::find($toBranchId);
                $toJournalId = $toBranch->getJournalId();
                $toOdooId = $toBranch->getOdooId();
                
                $this->storeOdoo($company,$transferDate,$fromOdooId,$fromJournalId,$toJournalId,$toOdooId,$amountInCurrency,$currencyName);
                
            }
            
        }
        
    }
    
    

}
