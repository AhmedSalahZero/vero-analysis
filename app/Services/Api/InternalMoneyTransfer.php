<?php 
namespace App\Services\Api;

use App\OdooSetting;
use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasPayment;

class InternalMoneyTransfer
{
	
	use AuthTrait,HasPayment;
	
	
 	public function sendMoneyTo(string $date ,float $amount, int $odooCurrencyId , int $journalId , int $bankOdooId , $message = 'To Cash') 
    {
		$amount = $amount * -1;
		$LiquidTransferId = $this->company->odooSetting->getLiquidityAccountOdooId();
            $journalEntryData = [
               'journal_id' => $journalId,
               'amount' => $amount,
               'date' => $date,
               'ref' =>  $message,
               'line_ids' => [
                    [0, 0, [
                        'account_id' => $LiquidTransferId, // 87
                        'debit' => abs($amount),
                        'credit' => 0.0,
                        'currency_id' => $odooCurrencyId,
                        'name' => $message ,
                        
                    ]],
                   
                    [0, 0, [
                        'account_id' => $bankOdooId,
                        'debit' => 0.0,
                        'credit' => abs($amount),
                        'currency_id' => $odooCurrencyId,
                        'name' => '' ,
                        
                    ]],
                   
                ],
            ];
              

            $context = [
                'check_move_validity' => true,
            ];

            $journalEntryId = $this->execute(
                'account.bank.statement.line',
                'create',
                [$journalEntryData],
                ['context' => $context]
            );

            if (!is_numeric($journalEntryId)) {
                throw new \Exception("Failed to create journal entry: " . json_encode($journalEntryId));
            }

             $this->execute(
                'account.move',
                'action_post',
                [[$journalEntryId]]
            );

            return $journalEntryId;
 	   }
	   
	   public function receiveMoneyTo(string $date ,float $amount, int $odooCurrencyId , int $journalId , int $bankOdooId , $message = 'To Cash') 
    {
		$amount = $amount ;
		$LiquidTransferId = $this->company->odooSetting->getLiquidityAccountOdooId();
            $journalEntryData = [
               'journal_id' => $journalId,
               'amount' => $amount,
               'date' => $date,
               'ref' =>  $message,
               'line_ids' => [
                    [0, 0, [
                        'account_id' => $bankOdooId, // 87
                        'debit' => abs($amount),
                        'credit' => 0.0,
                        'currency_id' => $odooCurrencyId,
                        'name' => $message ,
                        
                    ]],
                   
                    [0, 0, [
                        'account_id' => $LiquidTransferId,
                        'debit' => 0.0,
                        'credit' => abs($amount),
                        'currency_id' => $odooCurrencyId,
                        'name' => '' ,
                        
                    ]],
                   
                ],
            ];
              

            $context = [
                'check_move_validity' => true,
            ];

            $journalEntryId = $this->execute(
                'account.bank.statement.line',
                'create',
                [$journalEntryData],
                ['context' => $context]
            );

            if (!is_numeric($journalEntryId)) {
                throw new \Exception("Failed to create journal entry: " . json_encode($journalEntryId));
            }

             $this->execute(
                'account.move',
                'action_post',
                [[$journalEntryId]]
            );

            return $journalEntryId;
 	   }
	   
	
	
	//  public function processOutboundPayment(string $date,int $outJournalId,float $amount,int $odooCurrencyId)
    // {
    //     // try {
    //         // Create payment
    //         $paymentId = $this->createPayment('outbound',$outJournalId,$date, $amount, $odooCurrencyId);

    //         // Example: Update payment if needed
    //         $updateData = [
    //             // Add any fields that need updating, e.g.:
    //         ];

    //         if (!empty($updateData)) {
    //             $this->setPaymentToDraft($paymentId);
    //             $this->updatePayment($paymentId, $updateData);
    //         }

    //         // Post payment
    //         $this->postPayment($paymentId);

 
	// 		return $paymentId;
         
    // }
	
	public function processInboundPayment(string $date , int $inboundJournalId , float $amount ,int $odooCurrencyId)
    {
            // Create payment
            $paymentId = $this->createPayment('inbound',$inboundJournalId,$date  , $amount , $odooCurrencyId);
            // Example: Update payment if needed
            $updateData = [
                // Add any fields that need updating, e.g.:
                // 'amount' => 2500,
                // 'date' => '2025-05-22',
            ];

            if (!empty($updateData)) {
                $this->setPaymentToDraft($paymentId);
                $this->updatePayment($paymentId, $updateData);
            }

            // Post payment
            $this->postPayment($paymentId);

            // Assuming MoneyModel is your Laravel model
            // MoneyModel::update(['odoo_id' => $paymentId]);
			return $paymentId;
            
        
    }
	public function cancelMoneyTransferPayment(int $paymentId)
    {
        return $this->cancelPayments($paymentId);
    }
	
    

    

   

   

    

    
	

   



    
	
}
?>
