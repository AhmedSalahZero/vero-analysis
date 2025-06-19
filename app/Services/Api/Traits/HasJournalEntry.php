<?php 
namespace App\Services\Api\Traits;

use Exception;


trait HasJournalEntry 
{

	public function createAndPostJournalEntry(string $date , float $amount  , int $odooCurrencyId , int $journalId, int $debitOdooAccountId , int $creditOdooAccountId  , ?string $ref , ?int $partnerId ,?string $message ) 
    {
			$id = null ;  // in edit mode 
            $journalEntryData = $this->getDataFormatted($date,$amount,$odooCurrencyId,$journalId,$debitOdooAccountId,$creditOdooAccountId,$ref,$partnerId,$message,$id) ;

            $context = [
                'check_move_validity' => true,
            ];

            $accountBankStatementLineId = $this->execute(
                'account.bank.statement.line',
                'create',
                [$journalEntryData],
                ['context' => $context]
            );

            if (!is_numeric($accountBankStatementLineId)) {
                throw new Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
            }
			
		
			  $statementData = $this->execute(
            'account.bank.statement.line',
            'read',
            [[$accountBankStatementLineId], ['move_id']],
            []
        );

        if (!is_array($statementData) || empty($statementData[0]['move_id'])) {
            throw new Exception("Failed to retrieve move_id for statement entry: " . $accountBankStatementLineId);
        }
			$journalEntryId = $statementData[0]['move_id'][0];
            if (!is_numeric($accountBankStatementLineId)) {
                throw new Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
            }
			
            return [
				'account_bank_statement_line_id'=>$accountBankStatementLineId,
				'journal_entry_id'=>$journalEntryId
			];
    }
	
		
 
// public function updateJournalEntry(
//         int $moveId = 457,
//         int $accountBankStatementLineOdooId = 1338, // move_id
//         string $date = '2025-06-01', 
//         float $amount = 33000, 
//         int $currency_id = 74, 
//         int $journal_id = 23, 
//         int $debitOdooAccountId = 134, 
//         int $creditOdooAccountId = 229, 
// 		?int $partnerId,
//         string $ref , 
// 		bool $accountNumberHasChanged,
//         $message = ''
//     ) {

// 		// $name = "/"; // when bank changed only;

//        $this->execute(
//             'account.bank.statement.line',
//             'write',
//             [[$accountBankStatementLineOdooId], ['state' => 'draft']],
//         );
//         $basicArr = [
//       //      'name' => $name,
//            'journal_id' => $journal_id,
//            'amount' => $amount * -1,
//            'date' => $date,
//            'ref' => $ref,
		   
// 		];
// 		if($accountNumberHasChanged){
// 			$basicArr['name'] = "/";
// 		}
//          $this->execute(
//             'account.bank.statement.line',
//             'write',
//             [[$accountBankStatementLineOdooId],
// 			$basicArr
//              ]
//     );




// 		$line_ids= $this->fetchData('account.move',['id','line_ids'],[[['id', '=', $moveId]]]) [0]['line_ids']??[];
// 		if(!isset($line_ids[0])){
// 			throw new Exception("Line Ids not found: " . $moveId);
// 		}
//   $this->execute(
//             'account.move',
//             'write',
//             [[$moveId],
//              [
                  
//             'line_ids' => [
//                 [1, $line_ids[0], [
//                     'account_id' => $debitOdooAccountId,
//                     'debit' => abs($amount),
//                     'credit' => 0.0,
//                     'currency_id' => $currency_id,
//                     'name' => $message,
// 					'partner_id' => $partnerId,
//                 ]],
//                 [1, $line_ids[1], [
//                     'account_id' => $creditOdooAccountId,
//                     'debit' => 0.0,
//                     'credit' => abs($amount),
//                     'currency_id' => $currency_id,
//                     'name' => $message,
// 					'partner_id' => $partnerId,
//                 ]],
//             ],
//         ]]
//     );

//     $context = [
//             'check_move_validity' => true,
//         ];


//    $this->execute(
//             'account.move',
//             'action_post',
//             [[$moveId]],
//             ['context' => $context]
//         );

// }
	
	protected function getDataFormatted(string $date , float $amount  , int $odooCurrencyId , int $journalId, int $debitOdooAccountId , int $creditOdooAccountId  , ?string $ref , ?int $partnerId ,?string $message , int $id = null ):array 
	{
		$inEditMode = is_null($id) ? 0 : 1;
		$id = is_null($id) ? 0 : $id ; 

		return [
               'journal_id' => $journalId, // account journal id (safe or bank journal id )
               'amount' => $amount,
               'date' => $date,
               'partner_id' => $partnerId,
               'ref' =>  $ref, // create lg type
               'line_ids' => [
                    [$inEditMode, $id, [
                        'account_id' => $debitOdooAccountId, // lg cash cover odoo id (create lg cash cover)
                        'debit' => abs($amount),
                        'credit' => 0.0,
                        'currency_id' => $odooCurrencyId,
                        'name' => $message , // cash cover  
                        'partner_id' => $partnerId,
                    ]],
                    [$inEditMode, $id+1, [
                        'account_id' => $creditOdooAccountId, // chart of account odoo id 
                        'debit' => 0.0,
                        'credit' => abs($amount),
                        'currency_id' => $odooCurrencyId,
                        'name' => $message ,
                        'partner_id' => $partnerId,
                    ]],
                ],
            ];
	}
}
