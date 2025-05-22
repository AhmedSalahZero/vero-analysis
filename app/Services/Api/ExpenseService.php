<?php
namespace App\Services\Api;


use App\Services\Api\Traits\AuthTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpenseService
{
	use AuthTrait ;
	public function fetchData(string $modelName ,array $fields = [],  array $filters = [[]]  )
	{
		$ids=$this->models->execute_kw($this->db, $this->uid, $this->password, $modelName, 'search',$filters );
		return $this->models->execute_kw($this->db, $this->uid, $this->password, $modelName, 'read', array($ids),[
			'fields'=>$fields
		]);
	}
	 public function payApprovedExpense()
    {
        try {
            // Step 1: Fetch the expense sheet by ID
			$expenseSheetId = 8 ;
            $expense_sheets = $this->fetchData('hr.expense.sheet', ['id', 'name', 'total_amount', 'employee_id', 'account_move_ids', 'state'], [[['id', '=', $expenseSheetId]]]);
            Log::info('Expense Sheets Response', ['response' => $expense_sheets]);

            if (empty($expense_sheets)) {
                return response()->json(['message' => 'No expense sheet found with ID 8.'], 404);
            }
            $expense_sheet = $expense_sheets[0];
            $expense_sheet_id = $expense_sheet['id'];
            $amount = $expense_sheet['total_amount'];

            // Validate state
            if ($expense_sheet['state'] !== 'approve') {
                return response()->json(['error' => "Expense sheet ID {$expense_sheet_id} is not in 'approve' state."], 400);
            }

            // Validate employee_id
            if (empty($expense_sheet['employee_id']) || !is_array($expense_sheet['employee_id'])) {
                throw new Exception('Employee ID is missing or invalid for expense sheet ID: ' . $expense_sheet_id);
            }
            // Validate account_move_ids
            if (empty($expense_sheet['account_move_ids']) || !is_array($expense_sheet['account_move_ids'])) {
                throw new Exception('Journal entry (account_move_ids) is missing for expense sheet ID: ' . $expense_sheet_id);
            }
            $move_id = $expense_sheet['account_move_ids'][0];

            // Step 2: Check for existing payments to avoid duplication
            $existing_payments = $this->fetchData('account.payment', ['id'], [[['move_id', '=', $move_id], ['state', '=', 'posted']]]);

            if (!empty($existing_payments)) {
                return response()->json(['message' => 'Payment already exists for expense sheet ID: ' . $expense_sheet_id], 400);
            }

            // Step 3: Get cash journal
            $journal_id = 23; // Replace with your cash journal ID
            $payment_method_lines = $this->fetchData('account.payment.method.line', ['id', 'name'], [[['journal_id', '=', $journal_id]]]);
            Log::info('Payment Method Lines Response', ['response' => $payment_method_lines]);

            if (empty($payment_method_lines)) {
                throw new Exception('No payment method line found for journal ID: ' . $journal_id);
            }
            $payment_method_line_id = $payment_method_lines[0]['id'];

            // Step 4: Create payment
            $payment_id = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'create',
                [[
                    'payment_type' => 'outbound',
                    'partner_type' => 'supplier',
                    'partner_id' => $expense_sheet['employee_id'][0],
                    'amount' => $amount,
                    'journal_id' => $journal_id,
                    'payment_method_line_id' => $payment_method_line_id,
                    'payment_reference' => "Payment for expense sheet {$expense_sheet['name']}",
                ]]
            );
            Log::info('Payment Created', ['payment_id' => $payment_id]);

            // Step 5: Post the payment
            $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'action_post',
                [[$payment_id]]
            );

            // Step 6: Reconcile the payment with the journal entry
			// $x = $this->getFieldAcceptableValues('account.move');
			// dd($x);
			
			dd($this->fetchData('account.move',[],[[['type','=','payable']]]));
            $move_line = $this->fetchData('account.move.line', [], [[['move_id', '=', $move_id]
			// , ['account_id.type_name', '=', 'payable']
			]]);
			dd($move_line);
			// dd($move_line);

            if (empty($move_line)) {
                throw new Exception('No payable line found for journal entry ID: ' . $move_id);
            }

            $payment_line = $this->fetchData('account.move.line', ['id'], [[['payment_id', '=', $payment_id]]]);

            if (empty($payment_line)) {
                throw new Exception('No liquidity line found for payment ID: ' . $payment_id);
            }
			// dd($payment_line);

            $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.move.line',
                'reconcile',
                [[$move_line[0]['id'], $payment_line[0]['id']]],
                []
            );

            // Step 7: Set expense sheet status to "Done"
            $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'hr.expense.sheet',
                'write',
                [[$expense_sheet_id], ['state' => 'done']]
            );

            // Step 8: Verify cash balance decrease
            $journal_entries = $this->fetchData('account.move.line', ['balance'], [[['journal_id', '=', $journal_id], ['payment_id', '=', $payment_id]]]);
            Log::info('Journal Entries Response', ['response' => $journal_entries]);
            $cash_balance_decreased = !empty($journal_entries) && $journal_entries[0]['balance'] < 0;

            return response()->json([
                'message' => 'Expense payment processed successfully.',
                'expense_sheet_id' => $expense_sheet_id,
                'payment_id' => $payment_id,
                'cash_balance_decreased' => $cash_balance_decreased
            ]);

        } catch (Exception $e) {
            Log::error('Odoo Error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
	
	
}
