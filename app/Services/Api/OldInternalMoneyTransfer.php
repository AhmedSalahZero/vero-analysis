<?php 
namespace App\Services\Api;

use App\Services\Api\Traits\AuthTrait;
use Exception;
use Ramsey\Uuid\Uuid;

class OldInternalMoneyTransfer
{
	
	use AuthTrait ;
	
	
   
	public function execute($model, $method, $args)
    {
        return $this->models->execute_kw($this->db, $this->uid, $this->password, $model, $method, $args);
    }
	
	
    /**
     * Validate that a journal is a bank or cash journal
     * @param int $journalId
     * @return array Journal details
     */
  
	 
	 public function validateJournal($journalId)
	 {
		 try {
			 $fields = ['type', 'name', 'currency_id', 'default_account_id', 'suspense_account_id'];
			 // Dynamically check available fields to avoid errors
			 $journalFields = $this->execute('account.journal', 'fields_get', [[]]);
			 if (isset($journalFields['inbound_payment_method_line_ids'])) {
				 $fields[] = 'inbound_payment_method_line_ids';
			 }
			 if (isset($journalFields['outbound_payment_method_line_ids'])) {
				 $fields[] = 'outbound_payment_method_line_ids';
			 }
 
			 $journal = $this->execute('account.journal', 'read', [[$journalId], $fields])[0];
			 if (!in_array($journal['type'], ['bank', 'cash'])) {
				 throw new Exception("Journal {$journal['name']} is not a bank or cash journal");
			 }
			 if (!$journal['default_account_id']) {
				 throw new Exception("Journal {$journal['name']} has no default account configured");
			 }
			 \Log::debug("Journal {$journal['name']} fields: " . json_encode($journal));
			 return $journal;
		 } catch (Exception $e) {
			 throw new Exception("Failed to validate journal: " . $e->getMessage());
		 }
	 }
 
	 /**
	  * Get currency ID by currency code
	  * @param string $currencyCode
	  * @return int
	  */
	 public function getCurrencyId($currencyCode)
	 {
		 try {
			 $currencies = $this->execute('res.currency', 'search_read', [
				 [['name', '=', strtoupper($currencyCode)]],
				 ['id'],
				 ['limit' => 1]
			 ]);
			 if (empty($currencies)) {
				 throw new Exception("Currency {$currencyCode} not found");
			 }
			 return $currencies[0]['id'];
		 } catch (Exception $e) {
			 throw new Exception("Failed to fetch currency ID: " . $e->getMessage());
		 }
	 }
 
	 /**
	  * Fetch exchange rates for a currency
	  * @param string $currencyCode
	  * @param string $date
	  * @return array
	  */
	 public function getExchangeRates($currencyCode, $date)
	 {
		 try {
			 $currencyId = $this->getCurrencyId($currencyCode);
			 $domain = [['currency_id', '=', $currencyId], ['name', '=', $date]];
			 $rates = $this->execute('res.currency.rate', 'search_read', [
				 $domain,
				 ['name', 'rate'],
				 ['limit' => 1]
			 ]);
			 return [
				 'currency' => $currencyCode,
				 'rates' => array_map(function ($rate) {
					 return [
						 'date' => $rate['name'],
						 'rate' => $rate['rate'],
						 'direct_rate' => $rate['rate'] ? 1 / $rate['rate'] : 0,
					 ];
				 }, $rates)
			 ];
		 } catch (Exception $e) {
			 throw new Exception("Failed to fetch exchange rates: " . $e->getMessage());
		 }
	 }
 
	 /**
	  * Validate transfer account
	  * @param int $accountId
	  * @return bool
	  */
	 public function validateTransferAccount($accountId)
	 {
		 try {
			 $account = $this->execute('account.account', 'read', [[$accountId], ['id', 'name', 'code']])[0];
			 return !empty($account);
		 } catch (Exception $e) {
			 throw new Exception("Invalid transfer account: " . $e->getMessage());
		 }
	 }
 
	 /**
	  * Get the transfer (suspense) account ID for internal transfers
	  * @param int $sourceJournalId Source journal ID
	  * @return int Transfer account ID
	  */
	 public function getTransferAccountId($sourceJournalId)
	 {
		 try {
			 // Step 1: Check journal's suspense_account_id
			 $journal = $this->validateJournal($sourceJournalId);
			 
			 if ($journal['suspense_account_id'] && $this->validateTransferAccount($journal['suspense_account_id'][0])) {
				 return $journal['suspense_account_id'][0];
			 }
 
			 // Step 2: Fallback to searching for a suspense account by name or code
			 $companyId = $this->execute('res.company', 'search_read', [
				 [['id', '!=', 0]],
				 ['id'],
				 ['limit' => 1]
			 ])[0]['id'];
 
			 $accounts = $this->execute('account.account', 'search_read', [
				 [
					 ['company_id', '=', $companyId],
					 ['account_type', 'in', ['asset_current', 'liability_current']],
					 '|', ['name', 'ilike', 'Suspense'], ['code', 'ilike', '999%']
				 ],
				 ['id'],
				 ['limit' => 1]
			 ]);
			 if (!empty($accounts)) {
				 $accountId = $accounts[0]['id'];
				 if ($this->validateTransferAccount($accountId)) {
					 return $accountId;
				 }
			 }
 
			 throw new Exception(
				 'No transfer account found. Please configure a suspense_account_id on the source journal ' .
				 'or create an account named "Bank Suspense" or with code starting "999" in Accounting > Configuration > Accounts.'
			 );
		 } catch (Exception $e) {
			 throw new Exception("Failed to fetch transfer account ID: " . $e->getMessage());
		 }
	 }
 
	 /**
	  * Validate or fetch a payment method for a journal
	  * @param int $paymentMethodId
	  * @param int $journalId
	  * @param string $paymentType ('inbound' or 'outbound')
	  * @return int Valid payment method ID
	  */
	 public function validatePaymentMethod($paymentMethodId, $journalId, $paymentType)
	 {
		 try {
			 $journal = $this->validateJournal($journalId);
			 $journalType = $journal['type'];
 
			 // Define valid payment method codes for the journal type
			 $validCodes = $journalType == 'cash' ? ['manual', 'cash'] : ['manual', 'bank'];
 
			 // Select the appropriate payment method line field based on payment type
			 $methodLineField = $paymentType == 'inbound' ? 'inbound_payment_method_line_ids' : 'outbound_payment_method_line_ids';
			 $paymentMethodLineIds = isset($journal[$methodLineField]) ? $journal[$methodLineField] : [];
			 // Fetch journal's available payment method lines
			 $paymentMethodLines = [];
			 if (!empty($paymentMethodLineIds)) {
				 $paymentMethodLines = $this->execute('account.payment.method.line', 'search_read', [
					 [['id', 'in', $paymentMethodLineIds]],
					 ['payment_method_id', 'name'],
				 ]);
			 }
 
			 // Map payment method line IDs to payment method IDs
			 $journalPaymentMethodIds = array_column($paymentMethodLines, 'payment_method_id', 'payment_method_id');
			 $journalPaymentMethodIds = array_map(function($method) { return $method[0]; }, $journalPaymentMethodIds);
 
			 // Check if the provided payment method ID is valid for the journal
			 if (in_array($paymentMethodId, $journalPaymentMethodIds)) {
				 $paymentMethods = $this->execute('account.payment.method', 'search_read', [
					 [['id', '=', $paymentMethodId], ['code', 'in', $validCodes]],
					 ['id', 'name', 'code'],
				 ]);
				 if (!empty($paymentMethods)) {
					 \Log::info("Using provided payment method ID {$paymentMethodId} ({$paymentMethods[0]['name']}) for {$journalType} journal ($paymentType)");
					 return $paymentMethodId;
				 }
			 }
 
			 // Log all available payment methods for debugging
			 $allMethods = $this->execute('account.payment.method', 'search_read', [
				 [[]],
				 ['id', 'name', 'code'],
			 ]);
			 \Log::info("Available payment methods: " . json_encode($allMethods));
			 \Log::debug("Journal {$journal['name']} {$methodLineField}: " . json_encode($paymentMethodLines));
 
			 // Fetch a fallback payment method from the journal's payment method lines
			 if (!empty($paymentMethodLines)) {
				 foreach ($paymentMethodLines as $line) {
					 $methodId = $line['payment_method_id'][0];
					 $paymentMethods = $this->execute('account.payment.method', 'search_read', [
						 [['id', '=', $methodId], ['code', 'in', $validCodes]],
						 ['id', 'name', 'code'],
						//  ['limit' => 1]
					 ]);
					 if (!empty($paymentMethods)) {
						 $fallbackId = $paymentMethods[0]['id'];
						 \Log::info("Falling back to payment method ID {$fallbackId} ({$paymentMethods[0]['name']}) for {$journalType} journal ($paymentType)");
						 return $fallbackId;
					 }
				 }
			 }
 
			 // Fallback to any valid payment method
			 $fallbackMethods = $this->execute('account.payment.method', 'search_read', [
				 [['code', 'in', $validCodes]],
				 ['id', 'name', 'code'],
				 ['limit' => 1]
			 ]);
 
			 if (!empty($fallbackMethods)) {
				 $fallbackId = $fallbackMethods[0]['id'];
				 \Log::info("Falling back to payment method ID {$fallbackId} ({$fallbackMethods[0]['name']}) for {$journalType} journal ($paymentType)");
				 return $fallbackId;
			 }
 
			 throw new Exception(
				 "No valid payment method found for {$journalType} journal ($paymentType). " .
				 "Please configure a payment method with code 'manual' or '{$journalType}' in Accounting > Configuration > Payment Methods, " .
				 "and ensure it is assigned to the journal's {$methodLineField}. Available methods: " . json_encode($allMethods)
			 );
		 } catch (Exception $e) {
			 throw new Exception("Failed to validate payment method: " . $e->getMessage());
		 }
	 }
 
	 /**
	  * Get the correct reference field for account.payment
	  * @return string|null Field name
	  */
	 public function getPaymentReferenceField()
	 {
		 try {
			 $fields = $this->execute('account.payment', 'fields_get', [[]]);
			 if (isset($fields['ref'])) {
				 return 'ref';
			 }
			 if (isset($fields['name'])) {
				 return 'name';
			 }
			 return null; // No reference field available
		 } catch (Exception $e) {
			 throw new Exception("Failed to fetch account.payment fields: " . $e->getMessage());
		 }
	 }
 
	 /**
	  * Get the state field for account.payment
	  * @return string Field name
	  */
	 public function getPaymentStateField()
	 {
		 try {
			 $fields = $this->execute('account.payment', 'fields_get', [[]]);
			 return isset($fields['state']) ? 'state' : 'status'; // Fallback to 'status' if 'state' is customized
		 } catch (Exception $e) {
			 throw new Exception("Failed to fetch account.payment state field: " . $e->getMessage());
		 }
	 }
 
	 /**
	  * Reconcile a payment's journal entry with the suspense account
	  * @param int $paymentId
	  * @param int $transferAccountId
	  * @return void
	  */
	  public function reconcilePayment($paymentId, $transferAccountId)
	  {
		  try {
			  \Log::info("Starting reconciliation for payment ID {$paymentId} with transfer account ID {$transferAccountId}");
  
			  // Fetch the payment's journal entry (account.move)
			  $payment = $this->execute('account.payment', 'read', [[$paymentId], ['move_id', 'journal_id']])[0];
			  if (!$payment['move_id']) {
				  \Log::warning("No journal entry (move_id) found for payment ID {$paymentId}");
				  return false;
			  }
			  $moveId = $payment['move_id'][0];
			  \Log::info("Found journal entry ID {$moveId} for payment ID {$paymentId}");
  
			  // Fetch journal details to get default_account_id (liquidity account)
			  $journal = $this->execute('account.journal', 'read', [[$payment['journal_id'][0]], ['default_account_id']])[0];
			  $liquidityAccountId = $journal['default_account_id'] ? $journal['default_account_id'][0] : null;
			
			//  \Log::info("Journal liquidity account ID: " . ($liquidityAccountId ?: 'none'));
  
			  // Fetch all journal entry lines (account.move.line)
			  $moveLines = $this->execute('account.move.line', 'search_read', [
				  [['move_id', '=', $moveId]],
				  ['id', 'account_id', 'debit', 'credit', 'reconciled', 'name'],
			  ]);
			  \Log::debug("Journal entry lines for move ID {$moveId}: " . json_encode($moveLines));
  
			  // Find suspense account line
			  $suspenseLine = null;
			  foreach ($moveLines as $line) {
				  if ($line['account_id'][0] == $transferAccountId && !$line['reconciled']) {
					  $suspenseLine = $line;
					  break;
				  }
			  }
  
			  if (!$suspenseLine) {
				  \Log::warning("No unreconciled suspense account line found for payment ID {$paymentId} with account ID {$transferAccountId}");
				  return false;
			  }
			  \Log::info("Found suspense account line ID {$suspenseLine['id']} (Debit: {$suspenseLine['debit']}, Credit: {$suspenseLine['credit']})");
  
			  // Find liquidity account line
			  $liquidityLine = null;
			  foreach ($moveLines as $line) {
				  if ($line['account_id'][0] == $liquidityAccountId && !$line['reconciled']) {
					  $liquidityLine = $line;
					  break;
				  }
			  }
  
			  if (!$liquidityLine) {
				  \Log::warning("No unreconciled liquidity account line found for payment ID {$paymentId} with account ID {$liquidityAccountId}");
				  return false;
			  }
			  \Log::info("Found liquidity account line ID {$liquidityLine['id']} (Debit: {$liquidityLine['debit']}, Credit: {$liquidityLine['credit']})");
  
			  // Verify amounts match for reconciliation
			  if (abs($suspenseLine['debit'] - $liquidityLine['credit']) > 0.01 || abs($suspenseLine['credit'] - $liquidityLine['debit']) > 0.01) {
				  \Log::warning("Mismatched amounts for reconciliation: Suspense (Debit: {$suspenseLine['debit']}, Credit: {$suspenseLine['credit']}), Liquidity (Debit: {$liquidityLine['debit']}, Credit: {$liquidityLine['credit']})");
				  return false;
			  }
  
			  // Reconcile the suspense and liquidity lines
			  $reconcileLines = [$suspenseLine['id'], $liquidityLine['id']];
			  \Log::info("Attempting to reconcile lines: " . json_encode($reconcileLines));
			  $this->execute('account.move.line', 'reconcile', [[
				  'lines' => $reconcileLines,
				  'writeoff_acc_id' => false,
			  ]]);
  
			  \Log::info("Successfully reconciled payment ID {$paymentId} with lines: " . json_encode($reconcileLines));
			  return true;
		  } catch (Exception $e) {
			  \Log::error("Failed to reconcile payment ID {$paymentId}: " . $e->getMessage());
			  return false;
		  }
	  }
 
	 /**
	  * Check and archive existing payments with the same reference
	  * @param string $outboundRef
	  * @param string $inboundRef
	  * @param string $referenceField
	  * @return void
	  */
	 public function checkAndArchiveExistingPayments($outboundRef, $inboundRef, $referenceField)
	 {
		 try {
			 if (!$referenceField) {
				 return; // Skip archiving if no reference field is available
			 }
 
			 $existingPayments = $this->execute('account.payment', 'search_read', [
				 [[$referenceField, 'in', [$outboundRef, $inboundRef]], ['active', '=', true]],
				 ['id'],
			 ]);
 
			 if (!empty($existingPayments)) {
				 $paymentIds = array_column($existingPayments, 'id');
				 $this->execute('account.payment', 'write', [$paymentIds, ['active' => false]]);
				 \Log::info("Archived existing payments with IDs: " . json_encode($paymentIds));
			 }
		 } catch (Exception $e) {
			 throw new Exception("Failed to archive existing payments: " . $e->getMessage());
		 }
	 }
 
	 /**
	  * Create an internal transfer between two journals (bank or cash)
	  * @param int $sourceJournalId Source journal ID (bank or cash)
	  * @param int $destinationJournalId Destination journal ID (bank or cash)
	  * @param float $amount Transfer amount
	  * @param string $date Transfer date (YYYY-MM-DD)
	  * @param string $reference Transfer reference
	  * @param int|null $transferAccountId Suspense account ID (optional, fetched if null)
	  * @param int $paymentMethodId Payment method ID
	  * @return array Payment IDs
	  */
	  public function createInternalTransfer($sourceJournalId, $destinationJournalId, $amount, $date, $reference, $paymentMethodId)
    {
        try {
            // Step 1: Validate inputs
            if ($amount <= 0) {
                throw new Exception('Amount must be greater than zero');
            }
            if ($sourceJournalId == $destinationJournalId) {
                throw new Exception('Source and destination journals must be different');
            }

            // Step 2: Validate and get payment method IDs for both journals
            $sourcePaymentMethodId = $this->validatePaymentMethod($paymentMethodId, $sourceJournalId, 'outbound');
            $destinationPaymentMethodId = $this->validatePaymentMethod($paymentMethodId, $destinationJournalId, 'inbound');

            // Step 3: Get transfer account ID if not provided
            $transferAccountId =  $this->getTransferAccountId($sourceJournalId);
            $this->validateTransferAccount($transferAccountId);

            // Step 4: Get the correct reference field
            $referenceField = $this->getPaymentReferenceField();

            // Step 5: Generate unique payment references
            $uniqueId = Uuid::uuid4()->toString();
            $outboundRef = "{$reference} (Outbound) [{$uniqueId}]";
            $inboundRef = "{$reference} (Inbound) [{$uniqueId}]";

            // Step 6: Archive existing payments with the same references
            $this->checkAndArchiveExistingPayments($outboundRef, $inboundRef, $referenceField);

            // Step 7: Validate journals
            $sourceJournal = $this->validateJournal($sourceJournalId);
            $destinationJournal = $this->validateJournal($destinationJournalId);

            // Step 8: Handle multi-currency if journals have different currencies
            $sourceCurrencyId = $sourceJournal['currency_id'] ? $sourceJournal['currency_id'][0] : null;
            $destinationCurrencyId = $destinationJournal['currency_id'] ? $destinationJournal['currency_id'][0] : null;
            $amountDestination = $amount;
            if ($sourceCurrencyId && $destinationCurrencyId && $sourceCurrencyId != $destinationCurrencyId) {
                $rateData = $this->getExchangeRates($sourceJournal['currency_id'][1], $date);
                if (empty($rateData['rates'])) {
                    throw new Exception('No exchange rate found for the specified date');
                }
                $rate = $rateData['rates'][0]['rate'];
                $amountDestination = $amount * (1 / $rate); // Convert to destination currency
            }

            // Step 9: Create outbound payment from source journal to suspense account
            $outboundPaymentData = [
                'payment_type' => 'outbound',
                'partner_type' => 'supplier', // Using supplier for suspense account
                'partner_id' => false, // No partner for internal transfer
                'amount' => $amount,
                'currency_id' => $sourceCurrencyId ?: $this->getCurrencyId('USD'), // Default to USD if unset
                'date' => $date,
                'journal_id' => $sourceJournalId,
                'payment_method_id' => $sourcePaymentMethodId,
                'destination_account_id' => $transferAccountId,
            ];
            if ($referenceField) {
                $outboundPaymentData[$referenceField] = $outboundRef;
            }

            \Log::debug("Creating outbound payment: " . json_encode($outboundPaymentData));
            $outboundPaymentId = $this->execute('account.payment', 'create', [$outboundPaymentData]);
            $this->execute('account.payment', 'action_post', [[$outboundPaymentId]]);
            \Log::info("Created and posted outbound payment ID {$outboundPaymentId}");

            // Step 10: Create inbound payment to destination journal from suspense account
            $inboundPaymentData = [
                'payment_type' => 'inbound',
                'partner_type' => 'customer', // Using customer for suspense account
                'partner_id' => false, // No partner for internal transfer
                'amount' => $amountDestination,
                'currency_id' => $destinationCurrencyId ?: $this->getCurrencyId('USD'), // Default to USD if unset
                'date' => $date,
                'journal_id' => $destinationJournalId,
                'payment_method_id' => $destinationPaymentMethodId,
                'destination_account_id' => $transferAccountId,
            ];
            if ($referenceField) {
                $inboundPaymentData[$referenceField] = $inboundRef;
            }

            \Log::debug("Creating inbound payment: " . json_encode($inboundPaymentData));
            $inboundPaymentId = $this->execute('account.payment', 'create', [$inboundPaymentData]);
            $this->execute('account.payment', 'action_post', [[$inboundPaymentId]]);
            \Log::info("Created and posted inbound payment ID {$inboundPaymentId}");

            // Step 11: Reconcile inbound payment if destination journal is cash
            $reconciled = false;
            if ($destinationJournal['type'] == 'cash') {
                $reconciled = $this->reconcilePayment($inboundPaymentId, $transferAccountId);
                if (!$reconciled) {
                    \Log::warning("Reconciliation failed for inbound payment ID {$inboundPaymentId}. Attempting to force post.");
                }
            }

            // Step 12: Verify payment state and force post if needed
            $stateField = $this->getPaymentStateField();
            $inboundPayment = $this->execute('account.payment', 'read', [[$inboundPaymentId], [$stateField]])[0];
            \Log::info("Inbound payment ID {$inboundPaymentId} state: {$inboundPayment[$stateField]}");

            if ($destinationJournal['type'] == 'cash' && $inboundPayment[$stateField] == 'in_progress') {
                \Log::warning("Inbound payment ID {$inboundPaymentId} is still in_progress after reconciliation attempt.");
                if (!$reconciled) {
                    // Attempt to force post the payment
                    try {
                        $this->execute('account.payment', 'action_post', [[$inboundPaymentId]]);
                        $inboundPayment = $this->execute('account.payment', 'read', [[$inboundPaymentId], [$stateField]])[0];
                        \Log::info("After forcing post, inbound payment ID {$inboundPaymentId} state: {$inboundPayment[$stateField]}");
                    } catch (Exception $e) {
                        \Log::error("Failed to force post payment ID {$inboundPaymentId}: " . $e->getMessage());
                    }
                }
            }

            if ($inboundPayment[$stateField] != 'posted' && $inboundPayment[$stateField] != 'reconciled') {
                \Log::warning("Inbound payment ID {$inboundPaymentId} is in state '{$inboundPayment[$stateField]}' instead of 'posted' or 'reconciled'");
            }

            // Step 13: Return payment IDs
            return [
                'outbound_payment_id' => $outboundPaymentId,
                'inbound_payment_id' => $inboundPaymentId,
            ];
        } catch (Exception $e) {
            \Log::error("Failed to create internal transfer: " . $e->getMessage());
            throw new Exception("Failed to create internal transfer: " . $e->getMessage());
        }
    }
	 
	
}
?>
