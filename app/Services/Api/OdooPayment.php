<?php
namespace App\Services\Api;

use App\Models\Company;
use App\Models\Currency;
use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasJournal;
use App\Services\Api\Traits\HasPayment;
use Exception;
use Illuminate\Support\Facades\Log;

class OdooPayment
{
	use AuthTrait,HasPayment,HasJournal ;
	
	public function createDownPayment($moneyModel )
    {
	
      
		try{
			$company = $moneyModel->company ;
			$paymentDate = $moneyModel->getReceivingOrPaymentMoneyDate();
			if(!$company->withinIntegrationDate($paymentDate)){
				return ;
			}
			$journalId = $this->getJournalId($moneyModel) ;
			/**
			 * * $bankOrSafeId
			 */
			$paymentAmount = $moneyModel->isInvoiceSettlementWithDownPayment() ? $moneyModel->downPaymentSettlements->sum('down_payment_amount') : $moneyModel->getAmount()  ;
			if($moneyModel->isChequeAndNotCustomerOrSupplier()){
				$paymentAmount=$moneyModel->getAmount();
			}
			$currencyName = $moneyModel->getReceivingOrPaymentCurrency();
			$odooCurrencyId = Currency::getOdooId($currencyName);
			
			/**
			 * @var Company $company;
			 */
			
			$odooPartnerId = $moneyModel->partner->getOdooId();
			$inBoundOrOutBound =$moneyModel->getInboundOrOutbound();
			$customerOrSupplier = $moneyModel->getCustomerOrSupplier();
	
       
            // Step 2: Register payment using account.payment.register
            $context = [
                'active_model' => 'account.move',
           		'active_ids' => [],
            ];
			
            $paymentId = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'create',
                [[
                    'amount' => $paymentAmount,
                    'journal_id' => $journalId,
                    'date' => $paymentDate,
					'currency_id'=>$odooCurrencyId,
                    'partner_id' => $odooPartnerId,
                    'payment_type' => $inBoundOrOutBound,
                    'partner_type' => $customerOrSupplier ,
					'payment_method_line_id'=>(int)$moneyModel->getPaymentMethodLineId() 
                ]],
               ['context' => $context]
            );
			
			
             $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'action_post',
               	[[$paymentId]],
            );
			if(is_array($paymentId) && isset($paymentId['faultString'])){
				session()->put('fail',$paymentId['faultString']);
				$moneyModel->update([
					'synced_with_odoo'=>false ,
					'odoo_error_message'=>$paymentId['faultString']
				]);
				return ;
			}
			$odooAccountPayment = $this->fetchData('account.payment',['id','name'],[[['id','=',$paymentId]]]);
			$moneyModel->update([
				'odoo_id'=>$paymentId,
				'odoo_reference'=>$odooAccountPayment[0]['name']??null,
				'synced_with_odoo'=>true ,
				'odoo_error_message'=>null
			]);
		}
		catch(\Exception $e){
			session()->put('fail',__('Error While Connecting With Odoo : ' . $e->getMessage()));
			$moneyModel->update([
				'synced_with_odoo'=>false ,
				'odoo_error_message'=>$e->getMessage() 
			]);
		}
		

         
    }
	
	public function createDownPaymentFromSettlement($settlement )
    {
	
      
		try{
			$company = $settlement->company ;
			$moneyModel =  $settlement->getMoney() ;
			$paymentDate =$moneyModel->getReceivingOrPaymentMoneyDate();
			if(!$company->withinIntegrationDate($paymentDate)){
				return ;
			}
			$journalId = $this->getJournalId($moneyModel) ;
			/**
			 * * $bankOrSafeId
			 */
			$paymentAmount = $settlement->getAmountInReceivingCurrency()   ;
			$currencyName = $moneyModel->getReceivingOrPaymentCurrency();
			$odooCurrencyId = Currency::getOdooId($currencyName);
			
			/**
			 * @var Company $company;
			 */
			
			$odooPartnerId = $moneyModel->partner->getOdooId();
			$inBoundOrOutBound =$moneyModel->getInboundOrOutbound();
			$customerOrSupplier = $moneyModel->getCustomerOrSupplier();
	
       
            // Step 2: Register payment using account.payment.register
            $context = [
                'active_model' => 'account.move',
           		'active_ids' => [],
            ];

            $paymentId = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'create',
                [[
                    'amount' => $paymentAmount,
                    'journal_id' => $journalId,
                    'date' => $paymentDate,
					'currency_id'=>$odooCurrencyId,
                    'partner_id' => $odooPartnerId,
                    'payment_type' => $inBoundOrOutBound,
                    'partner_type' => $customerOrSupplier ,
					'payment_method_line_id'=>(int)$moneyModel->getPaymentMethodLineId() 
                ]],
               ['context' => $context]
            );
			
			
             $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'action_post',
               	[[$paymentId]],
            );
			if(is_array($paymentId) && isset($paymentId['faultString'])){
				session()->put('fail',$paymentId['faultString']);
				$moneyModel->update([
					'synced_with_odoo'=>false ,
					'odoo_error_message'=>$paymentId['faultString']
				]);
				return ;
			}
			$odooAccountPayment = $this->fetchData('account.payment',['id','name'],[[['id','=',$paymentId]]]);
			$moneyModel->update([
				'synced_with_odoo'=>true ,
				'odoo_error_message'=>null
			]);
			$settlement->update([
				'odoo_id'=>$paymentId,
				'odoo_reference_name'=>$odooAccountPayment[0]['name']??null,
			]);
				
		}
		catch(\Exception $e){
			session()->put('fail',__('Error While Connecting With Odoo : ' . $e->getMessage()));
			$moneyModel->update([
				'synced_with_odoo'=>false ,
				'odoo_error_message'=>$e->getMessage() 
			]);
		}
		

         
    }
    
	 public function createPayment($customerInvoiceSettlement )
    {
		
		
		try{
			
			$invoice = $customerInvoiceSettlement->invoice;
			$moneyModel = $customerInvoiceSettlement->getMoney();
			$amountInInReceivingCurrency = $customerInvoiceSettlement->getAmountInReceivingCurrency();
			if($invoice->opening_balance_id){
				return $this->createDownPaymentFromSettlement($customerInvoiceSettlement);
			}
			$journalId = $this->getJournalId($moneyModel) ;
			/**
			 * * $bankOrSafeId
			 */
			$invoiceId = $invoice->getOdooId();
			$receivingCurrencyName = $moneyModel->getReceivingOrPaymentCurrency();
			$odooReceivingCurrencyId =  Currency::getOdooId($receivingCurrencyName) ;
			$paymentDate = $moneyModel->getReceivingOrPaymentMoneyDate();
			if(!$this->company->withinIntegrationDate($paymentDate)){
				return ;
			}
			$odooPartnerId = $moneyModel->partner->getOdooId();
			$invoiceNumber = $invoice->getInvoiceNumber();
			$inBoundOrOutBound =$moneyModel->getInboundOrOutbound();
			$customerOrSupplier = $moneyModel->getCustomerOrSupplier();
	
       
            // Step 2: Register payment using account.payment.register
            $context = [
                'active_model' => 'account.move',
                'active_ids' => [$invoiceId],
            ];
			
            $paymentWizardId = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment.register',
                'create',
                [[
                    'amount' => $amountInInReceivingCurrency,
		   			 'currency_id'=>$odooReceivingCurrencyId,
                    'journal_id' => $journalId,
                    'payment_date' => $paymentDate,
                    'communication' => $invoiceNumber,
                    'partner_id' => $odooPartnerId,
                    'payment_type' => $inBoundOrOutBound,
                    'partner_type' => $customerOrSupplier ,
					 'payment_method_line_id'=>$moneyModel->getPaymentMethodLineId() 
                ]],
                ['context' => $context]
            );
			
            $paymentResult = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment.register',
                'action_create_payments',
                [[$paymentWizardId]],
                ['context' => $context]
            );
			if(is_array($paymentResult) && isset($paymentResult['faultString'])){
				session()->put('fail',$paymentResult['faultString']);
				$moneyModel->update([
					'synced_with_odoo'=>false ,
					'odoo_error_message'=>$paymentResult['faultString']
				]);
				return ;
			}
			
			$resId = $paymentResult['res_id'];
			if(is_numeric($resId)){
				$odooAccountPayment = $this->fetchData('account.payment',['id','name'],[[['id','=',$resId]]]);
				$moneyModel->update([
				'synced_with_odoo'=>true ,
				'odoo_error_message'=>null
			]);
			$customerInvoiceSettlement->update([
				'odoo_reference_name'=>$odooAccountPayment[0]['name']??null,
				'odoo_id'=>$resId
			]);
			
			
	
			return [
				'odoo_id'=>$resId
			];
			
			}
			
			
		}
		catch(\Exception $e){
			session()->put('fail',__('Error While Connecting With Odoo : ' . $e->getMessage()));
			$moneyModel->update([
				'synced_with_odoo'=>false ,
				'odoo_error_message'=>$e->getMessage() 
			]);
		}
    }
	
	public function reCreatePayment($customerInvoiceSettlement)
    {
		if($customerInvoiceSettlement->odoo_id){
			$this->cancelPayments($customerInvoiceSettlement->odoo_id);
		}
		$this->createPayment($customerInvoiceSettlement);

    }
	
	public function reCreateDownPayment($moneyModel)
    {
		if($moneyModel->odoo_id){
			$this->cancelPayments($moneyModel->odoo_id);
		}
		$this->createDownPayment($moneyModel);

    }
	
	
	public function chequeCollection(
        int $accountPayment_id,
        float $amount , 
        string $date , 
        int $currency_id , 
        int $journal_id , // NBE Journal
        int $debitOdooAccountId , // Misr Account
        int $creditOdooAccountId , // Cheque Receivable Account
        int $PartnerId ,
        $ref , 
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


            // Step 3: Check if payment is already linked to a bank statement
            $existingStatementLines = $this->execute(
                'account.bank.statement.line',
                'search',
                [[['payment_ids', 'in', [$accountPayment_id]]]],
                []
            );



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



                if (!is_array($statementData) || empty($statementData) || !isset($statementData[0]['move_id'])) {
                    throw new Exception("Failed to retrieve move_id for statement entry: $moveId, response: " . json_encode($statementData));
                }

                $statementMoveId = $statementData[0]['move_id'][0];
		
                $statementLineIds = $statementData[0]['line_ids'][1] ?? [];



                // Step 6: Reconcile payment and bank statement lines
                $paymentLineIds = $this->execute(
                    'account.move.line',
                    'search',
                    [[['move_id', '=', $moveId], ['account_id', '=', $creditOdooAccountId]]],
                    []
                );

                if (!$paymentLineIds || !is_array($paymentLineIds)) {
                    throw new Exception("Failed to retrieve payment move lines for move_id: $moveId");
                }

               $linesToReconcile = array_merge($paymentLineIds, (array)$statementLineIds);


               try {
                    $result = $this->execute(
                            'account.move.line',
                            'reconcile',
                            [$linesToReconcile],
                            ['context' => ['skip_full_reconcile_check' => true]]
                        );
                        // Handle success
                    } catch (Exception $e) {
						session()->put('fail',$e->getMessage());
				
                        // Log or handle error
                        Log::error('Odoo reconciliation failed: ' . $e->getMessage());
                    }
                
            } 

       
            // Step 7: Update payment to set is_matched to true if not already
            if (!$isMatched) {
                $matching  = $this->execute(
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
		
            return [
                'statement_entry_id' => $statementEntryId,
                'entry_id' => $statementMoveId,
                'payment_id' => $accountPayment_id,
                'invoice_state' => !empty($invoiceState) ? $invoiceState[0]['state'] : 'unknown',
                'message' => 'Cheque collection processed successfully, payment marked as matched, and invoice set to paid'
            ];

        } catch (\Exception $e) {
			session()->put('fail','Error in chequeCollection: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => 'Failed to process cheque collection: ' . $e->getMessage()
            ];
        }
    }
	
    public function chequePayment(
        $accountPayment_id = 112,
        float $amount = 22800, 
        string $date = '2025-06-04', 
        int $currency_id = 74, 
        int $journal_id = 243, // Misr Bank Journal
        int $debitOdooAccountId = 814, // Cheque Payable Account
        int $creditOdooAccountId = 260, // Bank Misr Account
        int $PartnerId = 331,
        string $ref , 
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

            // Step 3: Check if payment is already linked to a bank statement
            $existingStatementLines = $this->execute(
                'account.bank.statement.line',
                'search',
                [[['payment_ids', 'in', [$accountPayment_id]]]],
                []
            );


            $statementEntryId = null;
            $statementMoveId = null;
            $statementLineIds = [];


            

            if (empty($existingStatementLines)) {
                // Step 4: Create bank statement line to affect bank balance
                $statementEntryData = [
                    'journal_id' => $journal_id,
                    'amount' => $amount * -1, // Negative for bank payments
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



                if (!is_array($statementData) || empty($statementData) || !isset($statementData[0]['move_id'])) {
                    throw new Exception("Failed to retrieve move_id for statement entry: $moveId, response: " . json_encode($statementData));
                }

                $statementMoveId = $statementData[0]['move_id'][0];
                $statementLineIds = $statementData[0]['line_ids'][0] ?? [];



                // Step 6: Reconcile payment and bank statement lines
                $paymentLineIds = $this->execute(
                    'account.move.line',
                    'search',
                    [[['move_id', '=', $moveId], ['account_id', '=', $debitOdooAccountId]]],
                    []
                );


                if (!$paymentLineIds || !is_array($paymentLineIds)) {
                    throw new Exception("Failed to retrieve payment move lines for move_id: $moveId");
                }

               $linesToReconcile = array_merge($paymentLineIds, (array)$statementLineIds);


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
