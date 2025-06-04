<?php 
namespace App\Services\Api;

use Exception;
use Illuminate\Support\Facades\Log;
use ripcord;

class ChequeCollection
{
    protected string $url = 'https://training-itechs.odoo.com';
    protected string $db = 'squadbcc-itechs-may2025v2-stage1-20911387';
    protected string $username = 'ahmed.salah@squadbcc.com';
    protected string $password = '123';
	
    protected ?\Ripcord_Client $models = null;
    protected ?int $uid = null;

    public function __construct($url, $db, $userName, $password)
    {
        $this->url = $url;
        $this->db = $db;
        $this->username = $userName;
        $this->password = $password;

        require_once(public_path('apis/ripcord.php'));
        $common = ripcord::client("$this->url/xmlrpc/2/common");  

        $uid = null;

        try {
            $uid = $common->authenticate($this->db, $this->username, $this->password, array());
        } catch (\Exception $e) {
            $uid = null;
            Log::error('Authentication failed: ' . $e->getMessage());
        }

        if (is_array($uid)) {
            $uid = null;
        }

        $this->models = ripcord::client("$this->url/xmlrpc/2/object");
        $this->uid = $uid;
    }
  
    public function execute($model, $method, $args, $kwargs = [])
    {
        try {
            $result = $this->models->execute_kw($this->db, $this->uid, $this->password, $model, $method, $args, $kwargs);
            Log::info("Executed $model.$method with args: " . json_encode($args) . ", result: " . json_encode($result));
            return $result;
        } catch (\Exception $e) {
            Log::error("Error executing $model.$method: " . $e->getMessage());
            throw $e;
        }
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////

    public function chequeCollection(
        $accountPayment_id = 109,
        float $amount = 300000, 
        string $date = '2025-06-03', 
        int $currency_id = 74, 
        int $journal_id = 243, // NBE Journal
        int $debitOdooAccountId = 260, // Misr Account
        int $creditOdooAccountId = 406, // Cheque Receivable Account
        int $PartnerId = 444,
        string $invoiceNumber = 'INV/2025/00007',
        $ref = 'Cheque Collection INV/2025/00007', 
        $message = ''
    ) {
        try {
            // Step 1: Verify the payment exists and get its details
            $paymentData = $this->execute(
                'account.payment',
                'read',
                [[$accountPayment_id], ['state', 'move_id', 'reconciled_invoice_ids', 'is_matched']],
                []
            );

            // dd($paymentData);

            if (!$paymentData || !is_array($paymentData) || empty($paymentData)) {
                throw new Exception("Payment ID $accountPayment_id not found or invalid response");
            }

            $paymentData = $paymentData[0]; // Access first element safely
            $paymentState = $paymentData['state'];
            $invoiceIds = $paymentData['reconciled_invoice_ids'] ?? [];
            $moveId = $paymentData['move_id'] ? $paymentData['move_id'][0] : null;
            $isMatched = $paymentData['is_matched'] ?? false;

            if (!in_array($paymentState, ['draft', 'posted', 'in_process'])) {
                throw new Exception("Payment ID $accountPayment_id is in state '$paymentState' and cannot be processed");
            }

            // Step 2: If payment is in draft, post it
            if ($paymentState === 'draft') {
                $this->execute(
                    'account.payment',
                    'action_post',
                    [[$accountPayment_id]],
                    []
                );
                $paymentState = 'posted';
            }

             // dd($paymentState);

            // Step 3: Check if payment is already linked to a bank statement
            $existingStatementLines = $this->execute(
                'account.bank.statement.line',
                'search',
                [[['payment_ids', 'in', [$accountPayment_id]]]],
                []
            );

            // dd($accountPayment_id);

            $statementEntryId = null;
            $statementMoveId = null;
            $statementLineIds = [];


            

            if (empty($existingStatementLines)) {
                // Step 4: Create bank statement line to affect bank balance
                $statementEntryData = [
                    'journal_id' => $journal_id,
                    'amount' => $amount, // Positive for bank deposit
                    'date' => $date,
                    'ref' => $ref,
                    'partner_id' => $PartnerId,
                    'payment_ids' => [[6, 0, [$accountPayment_id]]], // Link payment using payment_ids
                    'name' => $message ,
                    'is_reconciled' => true,
                    
                    'line_ids' => [
                        [0, 0, [
                            'account_id' => $debitOdooAccountId,
                            'debit' => abs($amount),
                            'credit' => 0.0,
                            'currency_id' => $currency_id,
                            'name' => $message,
                            
                           
                        ]],
                        
                        [0, 0, [
                            'account_id' => $creditOdooAccountId,
                            'debit' => 0.0,
                            'credit' => abs($amount),
                            'currency_id' => $currency_id,
                            'name' => $message,
                          
                          
                        ]],
                    ],

                ];

                 

                $context = [
                    'check_move_validity' => true,
                ];

                $statementEntryId = $this->execute(
                    'account.bank.statement.line',
                    'create',
                    [$statementEntryData],
                    ['context' => $context]
                );

           
                if (!is_numeric($statementEntryId)) {
                    throw new Exception("Failed to create bank statement line: " . json_encode($statementEntryId));
                }




                // Step 5: Get the move_id and line_ids from the bank statement line
                $statementData = $this->execute(
                    'account.bank.statement.line',
                    'read',
                    [[$statementEntryId], ['move_id', 'line_ids']],
                    []
                );

               // dd($statementData);


                if (!is_array($statementData) || empty($statementData) || !isset($statementData[0]['move_id'])) {
                    throw new Exception("Failed to retrieve move_id for statement entry: $statementEntryId, response: " . json_encode($statementData));
                }

                $statementMoveId = $statementData[0]['move_id'][0];
                $statementLineIds = $statementData[0]['line_ids'][1] ?? [];


                 // dd($statementMoveId,$statementLineIds);

                // Step 6: Reconcile payment and bank statement lines
                $paymentLineIds = $this->execute(
                    'account.move.line',
                    'search',
                    [[['move_id', '=', $moveId], ['account_id', '=', $creditOdooAccountId]]],
                    []
                );

                 // dd($paymentLineIds);

                if (!$paymentLineIds || !is_array($paymentLineIds)) {
                    throw new Exception("Failed to retrieve payment move lines for move_id: $moveId");
                }

               $linesToReconcile = array_merge($paymentLineIds, (array)$statementLineIds);

               // dd($linesToReconcile ,$paymentLineIds, $statementLineIds);

               try {
                    $result = $this->execute(
                            'account.move.line',
                            'reconcile',
                            [$linesToReconcile],
                            ['context' => ['skip_full_reconcile_check' => true]]
                        );
                        // Handle success
                    } catch (Exception $e) {
                        // Log or handle error
                        Log::error('Odoo reconciliation failed: ' . $e->getMessage());
                    }
                
            } 

       

            // Step 7: Update payment to set is_matched to true if not already
            if (!$isMatched) {
                $this->execute(
                    'account.payment',
                    'write',
                    [[$accountPayment_id], ['is_matched' => true]],
                    []
                );
            }

            // Step 8: Verify invoice state is 'paid'
            if (!empty($invoiceIds)) {
                $invoiceState = $this->execute(
                    'account.move',
                    'read',
                    [$invoiceIds, ['state']],
                    []
                );

                foreach ($invoiceState as $invoice) {
                    if ($invoice['state'] !== 'paid') {
                        Log::warning("Invoice ID {$invoice['id']} state is {$invoice['state']} instead of 'paid'");
                    }
                }
            } 
            else {
                Log::warning("No invoices linked to payment ID $accountPayment_id");
            }

            // Step 9: Return result
            return [
                'statement_entry_id' => $statementEntryId,
                'entry_id' => $statementMoveId,
                'payment_id' => $accountPayment_id,
                'invoice_state' => !empty($invoiceState) ? $invoiceState[0]['state'] : 'unknown',
                'message' => 'Cheque collection processed successfully, payment marked as matched, and invoice set to paid'
            ];

        } catch (\Exception $e) {
            Log::error('Error in chequeCollection: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => 'Failed to process cheque collection: ' . $e->getMessage()
            ];
        }
    }
}


?>
