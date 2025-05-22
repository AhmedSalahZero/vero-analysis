<?php 
namespace App\Services\Api;

use App\Services\Api\Traits\AuthTrait;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use ripcord;

class InternalMoneyTransfer
{
	
	use AuthTrait;
	
	
	
    private function validateJournal($journalId)
    {
        $journal = $this->execute('account.journal', 'read', [[$journalId], ['type', 'currency_id', 'default_account_id', 'name', 'code']])[0];
        if (!in_array($journal['type'], ['bank', 'cash'])) {
            throw new Exception("Journal ID {$journalId} is not a bank or cash journal");
        }
        if (!$journal['default_account_id']) {
            throw new Exception("Journal ID {$journalId} has no default account configured");
        }
        return $journal;
    }

    private function getCurrencyId($currencyCode)
    {
        $currency = $this->execute('res.currency', 'search_read', [[['name', '=', $currencyCode]], ['id']]);
        if (empty($currency)) {
            throw new Exception("Currency {$currencyCode} not found");
        }
        return $currency[0]['id'];
    }

    private function getOrCreateBankStatement($journalId, $date)
    {
        try {
            $statement = $this->execute('account.bank.statement', 'search_read', [
                [['journal_id', '=', $journalId], ['date', '=', $date]],
                ['id']
            ]);

            if (!empty($statement)) {
                return $statement[0]['id'];
            }

            $statementData = [
                'journal_id' => $journalId,
                'date' => $date,
                'name' => "Statement {$date}-{$journalId}",
                'balance_end_real' => 0.0,
            ];
            $statementId = $this->execute('account.bank.statement', 'create', [$statementData]);
            return $statementId;
        } catch (Exception $e) {
            throw new Exception("Failed to get or create bank statement: " . $e->getMessage());
        }
    }

    public function createOutgoingTransferToSuspense($journalId, $amount, $date, $reference)
    {
		dd($this->getAvailableActionsForBankStatement());
        try {
            if ($amount <= 0) {
                throw new Exception('Amount must be greater than zero');
            }

            $journal = $this->validateJournal($journalId);
            $bankAccountId = $journal['default_account_id'][0];
            $suspenseAccount = $this->execute('account.account', 'search_read', [[['code', '=', '201001']], ['id']]);
            if (empty($suspenseAccount)) {
                throw new Exception("Bank Suspense Account (201001) not found");
            }
            $suspenseAccountId = $suspenseAccount[0]['id'];

            $initialBalance = $this->execute('account.account', 'read', [[$bankAccountId], ['current_balance']])[0]['current_balance'];
            Log::info("Initial balance - Bank account: {$initialBalance}");

            $statementId = $this->getOrCreateBankStatement($journalId, $date);
            Log::info("Using statement ID {$statementId}");

            // Read initial statement fields for debugging
            $statementFields = $this->execute('account.bank.statement', 'read', [[$statementId], ['balance_start', 'balance_end', 'balance_end_real']])[0];
            Log::info("Statement initial fields: " . json_encode($statementFields));

            $uniqueId = Uuid::uuid4()->toString();
            $paymentRef = "Transfer to suspense - {$reference} [{$uniqueId}]";

            $statementLineData = [
                'statement_id' => $statementId,
                'journal_id' => $journalId,
                'date' => $date,
                'payment_ref' => $paymentRef,
                'amount' => -$amount, // Negative for outgoing
                'currency_id' => $journal['currency_id'] ? $journal['currency_id'][0] : $this->getCurrencyId('USD'),
                'partner_id' => false,
                'account_number' => '201001', // Debit suspense account
            ];
            Log::debug("Creating statement line: " . json_encode($statementLineData));
            $statementLineId = $this->execute('account.bank.statement.line', 'create', [$statementLineData]);
            Log::info("Created statement line ID {$statementLineId}");

            // Attempt to process the statement (disabled until we confirm methods)
            /*
            $potentialMethods = ['button_confirm', 'process', 'action_confirm', 'button_done', 'button_validate', 'confirm_bank'];
            $statementProcessed = false;
            foreach ($potentialMethods as $method) {
                $result = $this->execute('account.bank.statement', $method, [[$statementId]]);
                if ($result !== null) {
                    Log::info("Successfully called {$method} on statement ID {$statementId}");
                    $statementProcessed = true;
                    break;
                }
            }
            if (!$statementProcessed) {
                Log::warning("No valid method found to process statement ID {$statementId}. Attempting to update balance_end_real manually.");
            }
            */

            // Manual update as fallback
            Log::info("Attempting to update balance_end_real manually.");
            $updated = $this->execute('account.bank.statement', 'write', [[$statementId], ['balance_end_real' => $statementFields['balance_end_real'] - $amount]]);
            if ($updated) {
                Log::info("Manually updated balance_end_real for statement ID {$statementId}");
            } else {
                Log::warning("Failed to manually update balance_end_real for statement ID {$statementId}");
            }

            // Verify the move and post it
            $statementLine = $this->execute('account.bank.statement.line', 'read', [[$statementLineId], ['move_id']])[0];
            if ($statementLine['move_id']) {
                $moveId = $statementLine['move_id'][0];
                $move = $this->execute('account.move', 'read', [[$moveId], ['state']])[0];
                if ($move['state'] != 'posted') {
                    Log::info("Posting move ID {$moveId}");
                    $this->execute('account.move', 'action_post', [[$moveId]]);
                }
                $moveLines = $this->execute('account.move.line', 'search_read', [
                    ['move_id', '=', $moveId],
                    ['id', 'account_id', 'debit', 'credit']
                ]);
                Log::info("Move lines for move ID {$moveId}: " . json_encode($moveLines));
            } else {
                Log::warning("No move_id created for statement line ID {$statementLineId}");
            }

            // Check final statement fields
            $updatedStatement = $this->execute('account.bank.statement', 'read', [[$statementId], ['balance_start', 'balance_end', 'balance_end_real']])[0];
            Log::info("Statement final fields: " . json_encode($updatedStatement));

            $finalBalance = $this->execute('account.account', 'read', [[$bankAccountId], ['current_balance']])[0]['current_balance'];
            Log::info("Final balance - Bank account: {$finalBalance}");

            return [
                'statement_line_id' => $statementLineId,
                'initial_balance' => $initialBalance,
                'final_balance' => $finalBalance,
                'balance_end_real' => $updatedStatement['balance_end_real'],
            ];
        } catch (Exception $e) {
            Log::error("Failed to create outgoing transfer: " . $e->getMessage());
            throw new Exception("Failed to create outgoing transfer: " . $e->getMessage());
        }
    }

    public function getAvailableActionsForBankStatement()
    {
        $model = 'account.bank.statement';
        $actions = [];

        $fields = $this->execute($model, 'fields_get', []);
        if ($fields) {
            $actions['fields'] = array_keys($fields);
            Log::info("Retrieved fields for {$model}: " . json_encode(array_keys($fields)));
        }

        $potentialMethods = [
            // 'create',
            // 'write',
            'unlink',
            'search',
            'read',
            'search_read',
        //    'post',
        //    'confirm',
          //  'reconcile',
            // 'check_confirm',
            // 'button_open',
            // 'button_close',
            // 'button_reset',
            // 'button_done',
            // 'button_reopen',
            // 'process',
            // 'close',
            // 'open',
            // 'action_open',
            // 'action_close',
            // 'action_confirm',
            // 'action_done',
            // 'action_reset',
            // 'action_reopen',
            'action_check',
            'button_validate',
            'confirm_bank',
        ];

        foreach ($potentialMethods as $method) {
            $result = $this->execute($model, $method, [[]]);
            if ($result !== null) {
                $actions['methods'][] = $method;
                Log::info("Method {$method} is available for {$model}");
            }
        }

        if (empty($actions['methods'])) {
            Log::warning("No callable methods found for {$model}. Consider using Odoo shell for full method list.");
        }

        return $actions;
    }

	
}
?>
