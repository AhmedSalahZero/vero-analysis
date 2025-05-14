<?php 
namespace App\Services\Api;

use Exception;
use ripcord;

class InternalMoneyTransfer
{
	
	protected string $url ;
	protected String $db;
	protected string $username;
	protected string $password ; 
	protected \Ripcord_Client $models;
	protected ?int $uid;
	protected int $company_id;
	public function __construct($url , $db , $userName , $password,$companyId)
	{
		$this->url = $url;
		$this->db = $db;
		$this->username =$userName;
		$this->password = $password;
		$this->company_id = $companyId ;
		
		require_once(public_path('apis/ripcord.php'));
		$common = ripcord::client("$this->url/xmlrpc/2/common");
		$uid = null ;
		try{
			$uid = $common->authenticate($this->db, $this->username, $this->password, array());
		}
		catch(\Exception $e){
			$uid = null;
		}
		if(is_array($uid)){
			$uid = null ;
		}
		$models = ripcord::client("$this->url/xmlrpc/2/object");
		$this->models = $models;
		
		$this->uid = $uid;
	}

    public function execute($model, $method, $args, $kwargs = [])
    {
        $result = $this->models->execute_kw($this->db, $this->uid, $this->password, $model, $method, $args, $kwargs);
        if (is_array($result) && isset($result['faultCode'], $result['faultString'])) {
            throw new Exception("Odoo API error: {$result['faultString']}");
        }
        return $result;
    }

    /**
     * Validate journal and get its default account ID
     */
    private function validateJournal($journalId, $context = 'source')
    {
        try {
            $journal = $this->execute('account.journal', 'read', [[$journalId], ['type', 'default_account_id', 'suspense_account_id', 'name']])[0];
            if (!in_array($journal['type'], ['bank', 'cash'])) {
                throw new Exception("Journal {$journalId} ($context) must be of type bank or cash");
            }
            if (!$journal['default_account_id']) {
                throw new Exception("Journal {$journalId} ($context: {$journal['name']}) has no default account configured");
            }
            $accountId = $journal['default_account_id'][0];
            $account = $this->execute('account.account', 'read', [[$accountId], ['account_type', 'name']])[0];
            if ($journal['suspense_account_id'] && $journal['suspense_account_id'][0] == $accountId) {
                throw new Exception("Journal {$journalId} ($context: {$journal['name']}) uses a suspense account ({$account['name']}) as default account");
            }
            if ($account['account_type'] === 'asset_receivable') {
                throw new Exception("Journal {$journalId} ($context: {$journal['name']}) default account ({$account['name']}) is a receivable account");
            }
            return $accountId;
        } catch (Exception $e) {
            throw new Exception("Failed to validate journal {$journalId} ($context): " . $e->getMessage());
        }
    }

    /**
     * Create an internal money transfer using account.payment
     * @param string $transferDate Date of transfer (YYYY-MM-DD)
     * @param float $transferAmount Transfer amount
     * @param int $fromJournalId Source journal ID
     * @param int $toJournalId Destination journal ID
     * @param int $oddoCurrencyId Currency ID
     * @param string|null $comment Optional comment
     * @return int Payment ID
     */
    public function createInternalMoneyTransfer(string $transferDate, float $transferAmount, int $fromJournalId, int $toJournalId, int $oddoCurrencyId, string $comment = null)
    {
        try {
            // Step 1: Validate inputs
            if ($transferAmount <= 0) {
                throw new Exception('Transfer amount must be positive');
            }
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $transferDate)) {
                throw new Exception('Transfer date must be in YYYY-MM-DD format');
            }
            if ($fromJournalId == $toJournalId) {
                throw new Exception('Source and destination journals cannot be the same');
            }
            $sourceAccountId = $this->validateJournal($fromJournalId, 'source');
            $destAccountId = $this->validateJournal($toJournalId, 'destination');
			
            // Validate currency
            $currency = $this->execute('res.currency', 'read', [[$oddoCurrencyId], ['name']]);
            if (empty($currency)) {
				throw new Exception("Invalid currency ID: {$oddoCurrencyId}");
            }
			
            // Step 2: Create payment
            $paymentData = [
				'payment_type' => 'outbound',
                'journal_id' => $fromJournalId,
                'amount' => $transferAmount,
                'currency_id' => $oddoCurrencyId,
                'date' => $transferDate,
                'communication' => $comment ?? "Internal transfer from Journal {$fromJournalId} to {$toJournalId}",
                'destination_account_id' => $destAccountId, // Corrected to use account ID
            ];
            \Log::info('Creating payment', ['data' => $paymentData]);
			
			dd($paymentData);
            $paymentId = $this->execute('account.payment', 'create', [$paymentData]);
			
            // Step 3: Post payment
            $this->execute('account.payment', 'action_post', [[$paymentId]]);
            \Log::info('Payment posted', ['payment_id' => $paymentId]);
			
            return $paymentId;
        } catch (Exception $e) {
            \Log::error('Failed to create internal money transfer', [
                'error' => $e->getMessage(),
                'from_journal' => $fromJournalId,
                'to_journal' => $toJournalId,
                'amount' => $transferAmount,
                'date' => $transferDate,
                'currency_id' => $oddoCurrencyId
            ]);
            throw new Exception("Failed to create internal money transfer: " . $e->getMessage());
        }
    }

    /**
     * Archive a payment by setting active to false
     */
    public function archivePayment($paymentId)
    {
        try {
            $this->execute('account.payment', 'write', [[$paymentId], ['active' => false]]);
            \Log::info('Payment archived', ['payment_id' => $paymentId]);
            return true;
        } catch (Exception $e) {
            \Log::error('Failed to archive payment', ['payment_id' => $paymentId, 'error' => $e->getMessage()]);
            throw new Exception("Failed to archive payment: " . $e->getMessage());
        }
    }

    /**
     * Check if payment is reconciled with a bank statement
     */
    public function isPaymentBankReconciled($paymentId)
    {
        $moveLines = $this->execute('account.move.line', 'search_read', [
            [['payment_id', '=', $paymentId], ['reconciled', '=', true]],
            ['id']
        ]);
        return !empty($moveLines);
    }

    /**
     * Unreconcile payment from bank statements
     */
    public function unreconcilePayment($paymentId)
    {
        $moveLines = $this->execute('account.move.line', 'search', [
            [['payment_id', '=', $paymentId], ['reconciled', '=', true]]
        ]);
        if (!empty($moveLines)) {
            $this->execute('account.move.line', 'remove_move_reconcile', [$moveLines]);
            \Log::info('Payment unreconciled', ['payment_id' => $paymentId, 'lines' => $moveLines]);
        }
    }

    /**
     * Get payment details
     */
    public function getPaymentDetails($paymentId)
    {
        return $this->execute('account.payment', 'read', [[$paymentId], [
            'state', 'payment_type', 'reconciled_invoice_ids', 'destination_account_id'
        ]])[0];
    }

    /**
     * Delete or archive a payment
     * @param int $paymentId Odoo payment ID
     * @param bool $forceDelete If true, attempt to cancel and delete instead of archiving
     */
    public function deletePayment($paymentId, $forceDelete = false)
    {
        try {
            if (!$forceDelete) {
                $this->archivePayment($paymentId);
                return response()->json(['success' => 'Payment archived successfully']);
            }

            $payment = $this->getPaymentDetails($paymentId);
            if ($payment['state'] === 'posted') {
                if ($this->isPaymentBankReconciled($paymentId)) {
                    $this->unreconcilePayment($paymentId);
                }
                $this->execute('account.payment', 'action_cancel', [[$paymentId]]);
            }
            $this->execute('account.payment', 'unlink', [[$paymentId]]);
            \Log::info('Payment deleted', ['payment_id' => $paymentId]);
            return response()->json(['success' => 'Payment deleted successfully']);
        } catch (Exception $e) {
            \Log::error('Failed to process payment', ['payment_id' => $paymentId, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to process payment: ' . $e->getMessage()], 500);
        }
    }

    // Optional: Retain createInternalTransfer (transitory account approach) for fallback
    private function getTransferAccount()
    {
        try {
            $accounts = $this->execute('account.account', 'search_read', [
                [['name', 'ilike', 'Internal Transfer'], ['account_type', '=', 'asset_current']],
                ['id', 'name', 'code']
            ]);
            if ($accounts && !empty($accounts[0]['id'])) {
                \Log::info('Found internal transfer account', ['account_id' => $accounts[0]['id']]);
                return $accounts[0]['id'];
            }
            $companyId = $this->execute('res.users', 'read', [[$this->uid], ['company_id']])[0]['company_id'][0];
            $accountData = [
                'name' => 'Internal Transfer',
                'code' => '999999',
                'account_type' => 'asset_current',
                'company_id' => $companyId,
            ];
            $accountId = $this->execute('account.account', 'create', [$accountData]);
            \Log::info('Created internal transfer account', ['account_id' => $accountId]);
            return $accountId;
        } catch (Exception $e) {
            throw new Exception("Failed to get or create transfer account: " . $e->getMessage());
        }
    }

    public function createInternalTransfer($fromJournalId, $toJournalId, $amount, $transferDate)
    {
        try {
            if ($amount <= 0) {
                throw new Exception('Transfer amount must be positive');
            }
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $transferDate)) {
                throw new Exception('Transfer date must be in YYYY-MM-DD format');
            }
            $sourceAccountId = $this->validateJournal($fromJournalId, 'source');
            $destAccountId = $this->validateJournal($toJournalId, 'destination');
            if ($fromJournalId == $toJournalId) {
                throw new Exception('Source and destination journals cannot be the same');
            }
            $transferAccountId = $this->getTransferAccount();

            $sourceMoveData = [
                'journal_id' => $fromJournalId,
                'date' => $transferDate,
                'ref' => "Internal Transfer Out on $transferDate",
                'line_ids' => [
                    [0, 0, [
                        'account_id' => $transferAccountId,
                        'debit' => $amount,
                        'credit' => 0.0,
                        'name' => "Transfer to Journal $toJournalId",
                    ]],
                    [0, 0, [
                        'account_id' => $sourceAccountId,
                        'debit' => 0.0,
                        'credit' => $amount,
                        'name' => 'Transfer Out',
                    ]],
                ],
            ];
            \Log::info('Creating source journal entry', ['data' => $sourceMoveData]);
            $sourceMoveId = $this->execute('account.move', 'create', [$sourceMoveData]);
            $this->execute('account.move', 'action_post', [[$sourceMoveId]]);
            $destMoveData = [
                'journal_id' => $toJournalId,
                'date' => $transferDate,
                'ref' => "Internal Transfer In on $transferDate",
                'line_ids' => [
                    [0, 0, [
                        'account_id' => $destAccountId,
                        'debit' => $amount,
                        'credit' => 0.0,
                        'name' => 'Transfer In',
                    ]],
                    [0, 0, [
                        'account_id' => $transferAccountId,
                        'debit' => 0.0,
                        'credit' => $amount,
                        'name' => "Transfer from Journal $fromJournalId",
                    ]],
                ],
            ];
            \Log::info('Creating destination journal entry', ['data' => $destMoveData]);
            $destMoveId = $this->execute('account.move', 'create', [$destMoveData]);
            $this->execute('account.move', 'action_post', [[$destMoveId]]);

            $transitoryLines = $this->execute('account.move.line', 'search', [
                [['account_id', '=', $transferAccountId], ['move_id', 'in', [$sourceMoveId, $destMoveId]]]
            ]);
            if (count($transitoryLines) >= 2) {
                \Log::info('Reconciling transitory lines', ['lines' => $transitoryLines]);
                $this->execute('account.move.line', 'reconcile', [$transitoryLines]);
            } else {
                \Log::warning('Insufficient transitory lines for reconciliation', ['lines' => $transitoryLines]);
            }

            return [$sourceMoveId, $destMoveId];
        } catch (Exception $e) {
            \Log::error('Failed to create internal transfer', [
                'error' => $e->getMessage(),
                'from_journal' => $fromJournalId,
                'to_journal' => $toJournalId,
                'amount' => $amount,
                'date' => $transferDate
            ]);
            throw new Exception("Failed to create internal transfer: " . $e->getMessage());
        }
    }
	
	 
}
?>
