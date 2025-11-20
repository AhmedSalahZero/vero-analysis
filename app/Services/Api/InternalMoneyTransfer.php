<?php
namespace App\Services\Api;

use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasPayment;
use App\Services\Api\Traits\HasUnlinkAccountBankStatementLine;
use Exception;

class InternalMoneyTransfer
{
    
    use AuthTrait,HasPayment,HasUnlinkAccountBankStatementLine;
    
    
    public function sendMoneyTo(string $date, float $amountInCurrency, float $amountInMainFunctionalCurrency, int $odooCurrencyId, int $journalId, int $bankOdooId, $message = 'to cash')
    {
        $amountInCurrency = $amountInCurrency * -1;
        $LiquidTransferId = $this->company->odooSetting->getLiquidityAccountOdooId();
        $journalEntryData = [
           'journal_id' => $journalId,
           'amount' => $amountInCurrency,
           'date' => $date,
           'ref' =>  $message,
           'line_ids' => [
                [0, 0, [
                    'account_id' => $LiquidTransferId, // 87
                    'debit' => abs($amountInMainFunctionalCurrency),
                    'amount_currency'=>abs($amountInCurrency),
                    'credit' => 0.0,
                    'currency_id' => $odooCurrencyId,
                    'name' => $message ,
                ]],
                   
                [0, 0, [
                    'account_id' => $bankOdooId,
                    'debit' => 0.0,
                    'credit' => abs($amountInMainFunctionalCurrency),
                    'amount_currency'=>$amountInCurrency,
                    'currency_id' => $odooCurrencyId,
                    'name' => '' ,
                        
                ]],
                   
            ],
        ];
              

        $context = [
            'check_move_validity' => true,
        ];
        $accountBankStatementLineId = $this->execute(
            'account.bank.statement.line',
            'create',
            [$journalEntryData],
            ['context' => $context]
        );

        if (!is_numeric($accountBankStatementLineId)) {
            throw new \Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
        }

            
            
        $statementData = $this->execute(
            'account.bank.statement.line',
            'read',
            [[$accountBankStatementLineId], ['move_id']],
            []
        );
        if (!is_array($statementData) || empty($statementData[0]['move_id'])) {
            throw new Exception("Failed to retrieve move_id for statement entry: " . $accountBankStatementLineId);
        }
        $journalEntryId = $statementData[0]['move_id'][0];
        if (!is_numeric($accountBankStatementLineId)) {
            throw new Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
        }
        $reference = $statementData[0]['move_id'][1]??null ;
        if ($reference) {
            $reference=explode(' ', $reference)[0];
        }
        return [
            'account_bank_statement_line_id'=>$accountBankStatementLineId,
            'journal_entry_id'=>$journalEntryId,
            'reference'=>$reference,
            /**
             * ! Need To Be Edited
             */
            'synced_with_odoo'=>true ,
            'odoo_error_message'=> null
        ];
    }
       
    
       
    public function updateSendMoneyTo(int $moveId, int $accountBankStatementOdooId, string $date, float $amountInCurrency, float $amountInMainFunctionalCurrency, int $odooCurrencyId, int $journalId, int $bankOdooId, $message = '')
    {
        $amountInCurrency = $amountInCurrency * -1;
        
        $LiquidTransferId = $this->company->odooSetting->getLiquidityAccountOdooId();
            
        $name = "/"; // when bank changed only;

        $this->execute(
            'account.bank.statement.line',
            'write',
            [[$accountBankStatementOdooId], ['state' => 'draft']],
        );
        
        $this->execute(
            'account.bank.statement.line',
            'write',
            [[$accountBankStatementOdooId],
            [
            'name' => $name,
           'journal_id' => $journalId,
           'amount' => $amountInMainFunctionalCurrency ,
           'amount_currency'=>$amountInCurrency,
           'date' => $date,
           'ref' => $message,
        ]]
        );
        ////
    
        $line_ids= $this->fetchData('account.move', ['id','line_ids'], [[['id', '=', $moveId]]]) [0]['line_ids']??[];
        if (!isset($line_ids[0])) {
            throw new Exception("Line Ids not found: " . $moveId);
        }


        $this->execute(
            'account.move',
            'write',
            [[$moveId],
                     [
                  
                    'line_ids' => [
                        [1, $line_ids[0], [
                            'account_id' => $LiquidTransferId,
                            'debit' => abs($amountInMainFunctionalCurrency),
                            'amount_currency'=>abs($amountInCurrency),
                            'credit' => 0.0,
                            'currency_id' => $odooCurrencyId,
                            'name' => $message,
                        ]],
                        [1, $line_ids[1], [
                            'account_id' => $bankOdooId,
                            'debit' => 0.0,
                            'credit' => abs($amountInMainFunctionalCurrency),
                            'amount_currency'=>$amountInCurrency,
                            'currency_id' => $odooCurrencyId,
                            'name' => $message,
                        ]],
                    ],
                ]]
        );
    

        $context = [
            'check_move_validity' => true,
        ];
            
        $this->execute(
            'account.move',
            'action_post',
            [[$moveId]],
            ['context' => $context]
        );
        
    
    }
       
    public function storeReceiveMoneyTo(string $date, float $amountInCurrency, float $amountInMainFunctionalCurrency, int $odooCurrencyId, int $journalId, int $bankOdooId, $message = '')
    {
        /**
         * @var InternalMoneyTransfer $this
         */
        
        
        $LiquidTransferId = $this->company->odooSetting->getLiquidityAccountOdooId();
    
        $journalEntryData = [
           'journal_id' => $journalId,
           'amount' => $amountInCurrency,
           'date' => $date,
           'ref' =>  $message,
           'line_ids' => [
                [0, 0, [
                    'account_id' => $bankOdooId, // 87
                    'debit' => abs($amountInMainFunctionalCurrency),
                    'amount_currency'=>abs($amountInCurrency),
                    'credit' => 0.0,
                    'currency_id' => $odooCurrencyId,
                    'name' => $message ,
                        
                ]],
                   
                [0, 0, [
                    'account_id' => $LiquidTransferId,
                    'debit' => 0.0,
                    'credit' => abs($amountInMainFunctionalCurrency),
                    'amount_currency'=>$amountInCurrency*-1,
                    'currency_id' => $odooCurrencyId,
                    'name' => '' ,
                        
                ]],
                   
            ],
        ];
              

        $context = [
            'check_move_validity' => true,
        ];
        $accountBankStatementLineId = $this->execute(
            'account.bank.statement.line',
            'create',
            [$journalEntryData],
            ['context' => $context]
        );
            

        if (!is_numeric($accountBankStatementLineId)) {
            throw new \Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
        }

            
            
            
        $statementData = $this->execute(
            'account.bank.statement.line',
            'read',
            [[$accountBankStatementLineId], ['move_id']],
            []
        );
        if (!is_array($statementData) || empty($statementData[0]['move_id'])) {
            throw new Exception("Failed to retrieve move_id for statement entry: " . $accountBankStatementLineId);
        }
        $journalEntryId = $statementData[0]['move_id'][0];
        if (!is_numeric($accountBankStatementLineId)) {
            throw new Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
        }
        
            
        $reference = $statementData[0]['move_id'][1]??null ;
        if ($reference) {
            $reference=explode(' ', $reference)[0];
        }
            
        
            
        
        
        return [
            'account_bank_statement_line_id'=>$accountBankStatementLineId,
            'journal_entry_id'=>$journalEntryId,
            'reference'=>$reference,
            /**
             * ! Need To Be Edited
             */
            'synced_with_odoo'=>true ,
            'odoo_error_message'=> null
        ];
    }
       
       
    public function updateReceiveMoneyTo(int $moveId, int $accountBankStatementOdooId, string $date, float $amountInCurrency, float $amountInMainFunctionalCurrency, int $odooCurrencyId, int $journalId, int $bankOdooId, $message = '')
    {
        
        $LiquidTransferId = $this->company->odooSetting->getLiquidityAccountOdooId();
            
        $name = "/"; // when bank changed only;

        $this->execute(
            'account.bank.statement.line',
            'write',
            [[$accountBankStatementOdooId], ['state' => 'draft']],
        );
        
        $this->execute(
            'account.bank.statement.line',
            'write',
            [[$accountBankStatementOdooId],
            [
            'name' => $name,
           'journal_id' => $journalId,
           'amount' => $amountInCurrency ,
           'date' => $date,
           'ref' => $message,
        ]]
        );
        ////
    
        $line_ids= $this->fetchData('account.move', ['id','line_ids'], [[['id', '=', $moveId]]]) [0]['line_ids']??[];
        if (!isset($line_ids[0])) {
            throw new Exception("Line Ids not found: " . $moveId);
        }


        $this->execute(
            'account.move',
            'write',
            [[$moveId],
                     [
                  
                    'line_ids' => [
                        [1, $line_ids[0], [
                            'account_id' => $bankOdooId,
                            'debit' => abs($amountInMainFunctionalCurrency),
                            'amount_currency' => abs($amountInCurrency),
                            'credit' => 0.0,
                            'currency_id' => $odooCurrencyId,
                            'name' => $message,
                        ]],
                        [1, $line_ids[1], [
                            'account_id' => $LiquidTransferId,
                            'debit' => 0.0,
                            'credit' => abs($amountInMainFunctionalCurrency),
                            'amount_currency' => $amountInCurrency*-1,
                            'currency_id' => $odooCurrencyId,
                            'name' => $message,
                        ]],
                    ],
                ]]
        );
    

        $context = [
            'check_move_validity' => true,
        ];
            
        $this->execute(
            'account.move',
            'action_post',
            [[$moveId]],
            ['context' => $context]
        );

    }
       
       
    
    
    public function cancelMoneyTransferPayment(int $paymentId)
    {
        return $this->cancelPayments($paymentId);
    }
    
    

    

   

   

    

    
    

   



    

}
