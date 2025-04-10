<?php

namespace App\Http\Controllers;

use Ripcord\Ripcord;
use Illuminate\Http\Request;

class OdooInvoiceController extends Controller
{
    private $url = 'http://your-odoo-instance:8069/xmlrpc/2/';
    private $db = 'your_database';
    private $username = 'your_username';
    private $password = 'your_password';
    private $common;
    private $models;
    private $uid;

    public function __construct()
    {
        $this->common = Ripcord::client($this->url . 'common');
        $this->models = Ripcord::client($this->url . 'object');
        $this->uid = $this->common->authenticate($this->db, $this->username, $this->password, []);
        if (!$this->uid) {
            throw new \Exception('Odoo authentication failed.');
        }
    }

    public function settleInvoice(Request $request)
    {
        try {
            $invoiceId = $request->input('invoice_id');
            if (!$invoiceId) {
                return response()->json(['error' => 'Invoice ID is required'], 400);
            }

            // Step 1: Verify invoice
            $invoices = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.move',
                'read',
                [[$invoiceId]],
                ['fields' => ['name', 'state', 'amount_residual', 'partner_id']]
            );

            if (!$invoices || empty($invoices)) {
                return response()->json(['error' => 'Invoice not found'], 404);
            }

            $invoice = $invoices[0];
            if ($invoice['state'] !== 'posted') {
                return response()->json(['error' => 'Invoice must be posted'], 400);
            }
            if ($invoice['amount_residual'] <= 0) {
                return response()->json(['error' => 'Invoice already paid'], 400);
            }

            // Step 2: Fetch bank journal
            $journals = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.journal',
                'search_read',
                [['type', '=', 'bank']],
                ['fields' => ['id'], 'limit' => 1]
            );

            if (!$journals || empty($journals)) {
                return response()->json(['error' => 'No bank journal found'], 500);
            }
            $journalId = $journals[0]['id'];

            // Step 3: Use payment register wizard
            $paymentRegisterId = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment.register',
                'create',
                [[
                    'journal_id' => $journalId,
                    'amount' => $invoice['amount_residual'],
                    'payment_date' => date('Y-m-d'), // Current date
                    'invoice_ids' => [[6, 0, [$invoiceId]]], // Replace existing links with this invoice
                ]],
                ['context' => ['active_ids' => [$invoiceId], 'active_model' => 'account.move']]
            );

            if (!$paymentRegisterId) {
                return response()->json(['error' => 'Failed to create payment register'], 500);
            }

            // Step 4: Create and post payment
            $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment.register',
                'action_create_payments',
                [[$paymentRegisterId]]
            );

            // Step 5: Verify invoice is paid
            $updatedInvoice = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.move',
                'read',
                [[$invoiceId]],
                ['fields' => ['payment_state']]
            );

            if ($updatedInvoice && $updatedInvoice[0]['payment_state'] === 'paid') {
                return response()->json(['message' => "Invoice {$invoice['name']} settled successfully"]);
            }

            return response()->json(['error' => 'Payment registered but invoice not settled'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
