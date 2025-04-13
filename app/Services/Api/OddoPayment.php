<?php 
namespace App\Services\Api;
class OddoPayment 
{
	public function registerPayment(Request $request)
{
    // Example request data from your app
    $paymentData = [
        'invoice_id' => $request->input('invoice_id'), // From Step 1
        'amount' => $request->input('amount'),
        'payment_date' => $request->input('payment_date', date('Y-m-d')),
        'journal_id' => $request->input('journal_id'), // Cash or Bank journal ID
        'payment_method_id' => 1, // Manual payment method (default ID is usually 1)
    ];

    // Authenticate
    $uid = $this->authenticate();
    if (!$uid) {
        return response()->json(['error' => 'Authentication failed'], 401);
    }

    // Register and reconcile payment
    $payment = $this->createPayment($uid, $paymentData);

    return response()->json($payment);
}

private function createPayment($uid, $paymentData)
{
    $client = new \xmlrpc_client($this->url . 'object');

    // Step 1: Create payment context with invoice to reconcile
    $context = [
        'active_ids' => [$paymentData['invoice_id']],
        'active_model' => 'account.move',
    ];

    $msg = new \xmlrpcmsg('execute_kw');
    $msg->addParam(new \xmlrpcval($this->db, 'string'));
    $msg->addParam(new \xmlrpcval($uid, 'int'));
    $msg->addParam(new \xmlrpcval($this->password, 'string'));
    $msg->addParam(new \xmlrpcval('account.payment.register', 'string')); // Model
    $msg->addParam(new \xmlrpcval('create', 'string')); // Method
    $msg->addParam(new \xmlrpcval([
        'amount' => new \xmlrpcval($paymentData['amount'], 'double'),
        'payment_date' => new \xmlrpcval($paymentData['payment_date'], 'string'),
        'journal_id' => new \xmlrpcval($paymentData['journal_id'], 'int'),
        'payment_method_id' => new \xmlrpcval($paymentData['payment_method_id'], 'int'),
    ], 'struct')); // Payment data
    $msg->addParam(new \xmlrpcval($context, 'struct')); // Context with invoice

    $resp = $client->send($msg);
    if ($resp->faultCode()) {
        return ['error' => $resp->faultString()];
    }

    $paymentRegisterId = $resp->value()->scalarval();

    // Step 2: Post the payment to reconcile it
    $msg = new \xmlrpcmsg('execute_kw');
    $msg->addParam(new \xmlrpcval($this->db, 'string'));
    $msg->addParam(new \xmlrpcval($uid, 'int'));
    $msg->addParam(new \xmlrpcval($this->password, 'string'));
    $msg->addParam(new \xmlrpcval('account.payment.register', 'string'));
    $msg->addParam(new \xmlrpcval('action_register_payment', 'string')); // Method to post
    $msg->addParam(new \xmlrpcval([$paymentRegisterId], 'array')); // Payment register ID

    $resp = $client->send($msg);
    if ($resp->faultCode()) {
        return ['error' => $resp->faultString()];
    }

    return ['success' => 'Payment registered and reconciled', 'payment_id' => $resp->value()->scalarval()];
}
}
