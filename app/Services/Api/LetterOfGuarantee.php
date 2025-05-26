<?php 
namespace App\Services\Api;

use App\Services\Api\Traits\AuthTrait;
use Exception;
use Illuminate\Support\Facades\Log;
use ripcord;

class AMoneyTransfer
{
     protected string $url ;
    protected string $db ;
    protected string $username ;
    protected string $password ;
    protected ?\ripcord_client $models = null;
    protected ?int $uid = null;

    use AuthTrait;

    public function createOutboundPayment($paymentData)
    {

            $context = [
                'active_model' => 'account.move',
                'active_ids' => [],
            ];

            $paymentId = $this->execute(
                'account.payment',
                'create',
                [[
                    'amount' => abs($paymentData['amount']),
                    'journal_id' => $paymentData['journal_id'],
                    'date' => $paymentData['date'],
                    'currency_id' => $paymentData['currency_id'],
                    'destination_account_id' => $paymentData['destination_account_id'],
                    'payment_type' => $paymentData['payment_type'],
                    'payment_method_id' => $paymentData['payment_method_id']
                ]],
                ['context' => $context]
            );

            Log::info("Created Payment ID: $paymentId");
            return $paymentId;
       
    }

    public function setPaymentToDraft($paymentId)
    {

             $this->execute(
                'account.payment',
                'action_draft',
                [[$paymentId]]
            );
         
    }

    public function updatePayment($paymentId, $updateData)
    {
            $result = $this->execute(
                'account.payment',
                'write',
                [[$paymentId], $updateData]
            );
          
    }

    public function postPayment($paymentId)
    {
        try {
            $result = $this->execute(
                'account.payment',
                'action_post',
                [[$paymentId]]
            );
            Log::info("Posted Payment ID=$paymentId Result=" . json_encode($result));
            return true;
        } catch (Exception $e) {
            Log::error("Odoo Post Payment failed ID=$paymentId: " . $e->getMessage());
            throw $e;
        }
    }

    public function cancelPayment($paymentId)
    {
        try {
            $result = $this->execute(
                'account.payment',
                'action_cancel',
                [[$paymentId]]
            );
            Log::info("Cancelled Payment ID=$paymentId Result=" . json_encode($result));
            return true;
        } catch (Exception $e) {
            Log::error("Odoo Cancel Payment failed ID=$paymentId: " . $e->getMessage());
            throw $e;
        }
    }

    public function createAndPostJournalEntry($amount, $date, $currency_id, $journal_id = 25)
    {
        try {
            if (!$this->uid) {
                throw new Exception("Odoo authentication failed: UID is null");
            }

            if (!is_numeric($amount) || $amount <= 0) {
                throw new Exception("Invalid amount: $amount");
            }
            if (empty($date)) {
                throw new Exception("Date is required");
            }
            if (!is_numeric($currency_id)) {
                throw new Exception("Invalid currency_id: $currency_id");
            }
            if (!is_numeric($journal_id)) {
                throw new Exception("Invalid journal_id: $journal_id");
            }

            $journalEntryData = [
                'journal_id' => $journal_id,
                'date' => $date,
                'ref' => 'LG Cash Cover to Bank Suspense',
            //    'company_id' => $this->company_id,
                'line_ids' => [
                    [0, 0, [
                        'account_id' => 87,
                        'debit' => abs($amount),
                        'credit' => 0.0,
                        'currency_id' => $currency_id,
                        'name' => 'LG Cash Cover Debit',
                    ]],
                    [0, 0, [
                        'account_id' => 101,
                        'debit' => 0.0,
                        'credit' => abs($amount),
                        'currency_id' => $currency_id,
                        'name' => 'Bank Suspense Credit',
                    ]],
                ],
            ];

            $context = [
        //        'company_id' => $this->company_id,
                'check_move_validity' => true,
            ];

            $journalEntryId = $this->execute(
                'account.move',
                'create',
                [$journalEntryData],
                ['context' => $context]
            );

            if (!is_numeric($journalEntryId)) {
                throw new Exception("Failed to create journal entry: " . json_encode($journalEntryId));
            }

            Log::info("Created Journal Entry ID=$journalEntryId Data=" . json_encode($journalEntryData));

            $postResult = $this->execute(
                'account.move',
                'action_post',
                [[$journalEntryId]]
            );

            Log::info("Posted Journal Entry ID=$journalEntryId Result=" . json_encode($postResult));
            return $journalEntryId;
        } catch (Exception $e) {
            Log::error("Odoo Create and Post Journal Entry failed: " . $e->getMessage() . " Amount=$amount Date=$date Currency=$currency_id Journal=$journal_id");
            throw $e;
        }
    }

    public function processOutboundPayment($paymentData)
    {
        try {
          
            $paymentId = $this->createOutboundPayment($paymentData);
            $updateData = [];
            if (!empty($updateData)) {
                $this->setPaymentToDraft($paymentId);
                $this->updatePayment($paymentId, $updateData);
            }

            $this->postPayment($paymentId);

            $journalEntryId = $this->createAndPostJournalEntry(
                $paymentData['amount'] ,
                $paymentData['date'] ,
                $paymentData['currency_id'] ,
                $paymentData['journal_id']
            );
            return response()->json([
                'success' => true,
                'message' => 'Payment and journal entry registered and posted successfully',
                'payment_id' => $paymentId,
                'journal_entry_id' => $journalEntryId
            ]);
        } catch (Exception $e) {
            Log::error("Odoo Process Outbound Payment failed: " . $e->getMessage() . " PaymentData=" . json_encode($paymentData));
            return response()->json([
                'success' => false,
                'message' => 'Payment or journal entry processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancelDownPayment(int $downPaymentOdooId)
    {
        try {
            $result = $this->cancelPayment($downPaymentOdooId);
            Log::info("Cancelled Down Payment ID=$downPaymentOdooId Result=" . json_encode($result));
            return $result;
        } catch (Exception $e) {
            Log::error("Odoo Cancel Down Payment failed ID=$downPaymentOdooId: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
