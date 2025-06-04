<?php 
namespace App\Services\Api\Traits;

use Exception;


trait HasEntryJournal 
{
	
	
	
	
	
public function updateJournalEntry(
        int $statementEntryId = 457,
        int $move_id = 1338,
        string $date = '2025-06-01', 
        float $amount = 33000, 
        int $currency_id = 74, 
        int $journal_id = 23, 
        int $debitOdooAccountId = 134, 
        int $creditOdooAccountId = 229, 
        $ref = 'HI Salah 160', 
        $message = ''
    ) {

		 $name = "/"; // when bank changed only;

       $reset = $this->execute(
            'account.bank.statement.line',
            'write',
            [[$statementEntryId], ['state' => 'draft']],
        );
        
        $bankJournal = $this->execute(
            'account.bank.statement.line',
            'write',
            [[$statementEntryId],
             [
            'name' => $name,
           'journal_id' => $journal_id,
           'amount' => $amount * -1,
           'date' => $date,
           'ref' => $ref,
        ]]
    );




$line_ids= $this->fetchData('account.move',['id','line_ids'],[[['id', '=', $move_id]]]) [0]['line_ids']??[];
if(!isset($line_ids[0])){
     throw new Exception("Line Ids not found: " . $move_id);
}
 $updateDebitAndCredit = $this->execute(
            'account.move',
            'write',
            [[$move_id],
             [
                  
            'line_ids' => [
                [1, $line_ids[0], [
                    'account_id' => $debitOdooAccountId,
                    'debit' => abs($amount),
                    'credit' => 0.0,
                    'currency_id' => $currency_id,
                    'name' => $message,
                ]],
                [1, $line_ids[1], [
                    'account_id' => $creditOdooAccountId,
                    'debit' => 0.0,
                    'credit' => abs($amount),
                    'currency_id' => $currency_id,
                    'name' => $message,
                ]],
            ],
        ]]
    );

    $context = [
            'check_move_validity' => true,
        ];


  $posted = $this->execute(
            'account.move',
            'action_post',
            [[$move_id]],
            ['context' => $context]
        );

}
	
	
}
