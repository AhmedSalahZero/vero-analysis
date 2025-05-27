<?php 
namespace App\Services\Api;

use App\OdooSetting;
use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasPayment;
use Exception;

class LetterOfGuaranteeService
{
    use AuthTrait,HasPayment;

    public function createLgIssuanceCashCover(string $date,int $outJournalId,float $amount,int $odooCurrencyId,int $lgOddoAccountId)
    {
          
            $paymentId = $this->createPayment('outbound',$outJournalId,$date, $amount, $odooCurrencyId);
            $updateData = [];
            if (!empty($updateData)) {
                $this->setPaymentToDraft($paymentId);
                $this->updatePayment($paymentId, $updateData);
            }

            $this->postPayment($paymentId);

            $journalEntryId = $this->createAndPostJournalEntry(
                $amount ,
                $date ,
                $odooCurrencyId ,
                $outJournalId,
				$lgOddoAccountId,
				OdooSetting::getSuspenseAccountId()
            );
            return response()->json([
                'success' => true,
                'message' => 'Payment and journal entry registered and posted successfully',
                'payment_id' => $paymentId,
                'journal_entry_id' => $journalEntryId
            ]);
       
    }
	
	
	 public function createLgCancelCashCover(string $date,int $outJournalId,float $amount,int $odooCurrencyId,int $lgOddoAccountId)
    {
          
            $paymentId = $this->createPayment('inbound',$outJournalId,$date, $amount, $odooCurrencyId);
            $updateData = [];
            if (!empty($updateData)) {
                $this->setPaymentToDraft($paymentId);
                $this->updatePayment($paymentId, $updateData);
            }

            $this->postPayment($paymentId);

            $journalEntryId = $this->createAndPostJournalEntry(
                $amount ,
                $date ,
                $odooCurrencyId ,
                $outJournalId,
				OdooSetting::getSuspenseAccountId(),
				$lgOddoAccountId,
            );
            return response()->json([
                'success' => true,
                'message' => 'Payment and journal entry registered and posted successfully',
                'payment_id' => $paymentId,
                'journal_entry_id' => $journalEntryId
            ]);
       
    }
	
   
	protected function createAndPostJournalEntry(float $amount, string $date, int $currency_id, int $journal_id , int $debitOdooAccountId,int $creditOdooAccountId)
    {
            $journalEntryData = [
                'journal_id' => $journal_id,
                'date' => $date,
                'ref' => 'LG Cash Cover',
                'line_ids' => [
                    [0, 0, [
                        'account_id' => $debitOdooAccountId, // 87
                        'debit' => abs($amount),
                        'credit' => 0.0,
                        'currency_id' => $currency_id,
                        'name' => 'LG Cash Cover Debit',
                    ]],
                    [0, 0, [
                        'account_id' => $creditOdooAccountId,
                        'debit' => 0.0,
                        'credit' => abs($amount),
                        'currency_id' => $currency_id,
                        'name' => 'Bank Suspense To LG Cash Cover',
                    ]],
                ],
            ];

            $context = [
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

			 $this->execute(
                'account.move',
                'action_post',
                [[$journalEntryId]]
            );

            return $journalEntryId;
    }
}
?>
