<?php 
namespace App\Services\Api;

use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasEntryJournal;
use App\Services\Api\Traits\HasJournal;
use App\Services\Api\Traits\HasPayment;
use Exception;

class LetterOfGuaranteeService
{
    use AuthTrait,HasPayment,HasEntryJournal,HasJournal;
	// string $date,int $outJournalId,float $amount,int $odooCurrencyId,int $lgOddoAccountId
	
	
    public function createLgIssuanceCashCover(string $date,float $amount,int $journalId,int $odooCurrencyId,int $lgDebitOdooAccountId,int $lgCreditOdooAccountId,int $odooPartnerId , string $ref  , string $message  )
    {

		  $amount = $amount * -1;
          return $this->createAndPostJournalEntry($date,$amount,$odooCurrencyId,$journalId,$lgDebitOdooAccountId,$lgCreditOdooAccountId,$ref,$odooPartnerId,$message);
       
    }
	
	
	
	 public function createLgCancelCashCover(string $date,float $amount,int $journalId,int $odooCurrencyId,int $lgDebitOdooAccountId,int $lgCreditOdooAccountId,int $odooPartnerId,string $ref,string $message)
    {
          
          return $this->createAndPostJournalEntry($date,$amount,$odooCurrencyId,$journalId,$lgCreditOdooAccountId,$lgDebitOdooAccountId,$ref,$odooPartnerId,$message);
		  
        
       
    }
	protected function getDataFormatted(string $date , float $amount  , int $odooCurrencyId , int $journalId, int $debitOdooAccountId , int $creditOdooAccountId  , ?string $ref , ?int $partner_id ,?string $message , int $id = null ):array 
	{
		$inEditMode = is_null($id) ? 0 : 1;
		$id = is_null($id) ? 0 : $id ; 

		return [
               'journal_id' => $journalId, // account journal id (safe or bank journal id )
               'amount' => $amount,
               'date' => $date,
               'partner_id' => $partner_id,
               'ref' =>  $ref, // create lg type
               'line_ids' => [
                    [$inEditMode, $id, [
                        'account_id' => $debitOdooAccountId, // lg cash cover odoo id (create lg cash cover)
                        'debit' => abs($amount),
                        'credit' => 0.0,
                        'currency_id' => $odooCurrencyId,
                        'name' => $message , // cash cover  
                        'partner_id' => $partner_id,
                    ]],
                    [$inEditMode, $id+1, [
                        'account_id' => $creditOdooAccountId, // chart of account odoo id 
                        'debit' => 0.0,
                        'credit' => abs($amount),
                        'currency_id' => $odooCurrencyId,
                        'name' => $message ,
                        'partner_id' => $partner_id,
                    ]],
                ],
            ];
	}
	 protected function createAndPostJournalEntry(string $date , float $amount  , int $odooCurrencyId , int $journalId, int $debitOdooAccountId , int $creditOdooAccountId  , ?string $ref , ?int $partner_id ,?string $message ) 
    {
			$id = null ;  // in edit mode 
            $journalEntryData = $this->getDataFormatted($date,$amount,$odooCurrencyId,$journalId,$debitOdooAccountId,$creditOdooAccountId,$ref,$partner_id,$message,$id) ;

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
                throw new Exception("Failed to create journal entry: " . json_encode($journalEntryId));
            }
			
		
			  $statementData = $this->execute(
            'account.bank.statement.line',
            'read',
            [[$journalEntryId], ['move_id']],
            []
        );

        if (!is_array($statementData) || empty($statementData[0]['move_id'])) {
            throw new Exception("Failed to retrieve move_id for statement entry: " . $journalEntryId);
        }
			$moveId = $statementData[0]['move_id'][0];
            if (!is_numeric($journalEntryId)) {
                throw new Exception("Failed to create journal entry: " . json_encode($journalEntryId));
            }
			
            return [
				'account_bank_statement_line_id'=>$journalEntryId,
				'journal_entry_id'=>$moveId
			];
    }
	
		
   
}
?>
