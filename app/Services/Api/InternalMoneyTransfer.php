<?php 
namespace App\Services\Api;

use App\OdooSetting;
use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasPayment;
use Exception;

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
            $accountBankStatementLineId = $this->execute(
                'account.bank.statement.line',
                'create',
                [$journalEntryData],
                ['context' => $context]
            );

            if (!is_numeric($accountBankStatementLineId)) {
                throw new \Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
            }

             $this->execute(
                'account.move',
                'action_post',
                [[$accountBankStatementLineId]]
            );
			
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
	   
	
	   
	   public function updateSendMoneyTo(int $statementEntryId , int $accountBankStatementOdooId , string $date ,float $amount, int $odooCurrencyId , int $journalId , int $bankOdooId , $message = 'To Cash') 
    {
		$amount = $amount * -1;
		
		$LiquidTransferId = $this->company->odooSetting->getLiquidityAccountOdooId();
			
			 $name = "/"; // when bank changed only;

       $this->execute(
            'account.bank.statement.line',
            'write',
            [[$statementEntryId], ['state' => 'draft']],
        );
        
         $this->execute(
            'account.bank.statement.line',
            'write',
            [[$statementEntryId],
             [
            'name' => $name,
           'journal_id' => $journalId,
           'amount' => $amount ,
           'date' => $date,
           'ref' => $message,
        ]]
    );
	////
	
	$line_ids= $this->fetchData('account.move',['id','line_ids'],[[['id', '=', $accountBankStatementOdooId]]]) [0]['line_ids']??[];
if(!isset($line_ids[0])){
     throw new Exception("Line Ids not found: " . $accountBankStatementOdooId);
}


$this->execute(
            'account.move',
            'write',
            [[$accountBankStatementOdooId],
             [
                  
            'line_ids' => [
                [1, $line_ids[0], [
                    'account_id' => $LiquidTransferId,
                    'debit' => abs($amount),
                    'credit' => 0.0,
                    'currency_id' => $odooCurrencyId,
                    'name' => $message,
                ]],
                [1, $line_ids[1], [
                    'account_id' => $bankOdooId,
                    'debit' => 0.0,
                    'credit' => abs($amount),
                    'currency_id' => $odooCurrencyId,
                    'name' => $message,
                ]],
            ],
        ]]
    );
	

            $context = [
                'check_move_validity' => true,
            ];
			
			   $this->execute(
            'account.move',
            'action_post',
            [[$accountBankStatementOdooId]],
            ['context' => $context]
        );
		
		// $amount = $amount * -1;
		// $LiquidTransferId = $this->company->odooSetting->getLiquidityAccountOdooId();
        //     $journalEntryData = [
        //        'journal_id' => $journalId,
        //        'amount' => $amount,
        //        'date' => $date,
        //        'ref' =>  $message,
        //        'line_ids' => [
        //             [0, 0, [
        //                 'account_id' => $LiquidTransferId, // 87
        //                 'debit' => abs($amount),
        //                 'credit' => 0.0,
        //                 'currency_id' => $odooCurrencyId,
        //                 'name' => $message ,
                        
        //             ]],
                   
        //             [0, 0, [
        //                 'account_id' => $bankOdooId,
        //                 'debit' => 0.0,
        //                 'credit' => abs($amount),
        //                 'currency_id' => $odooCurrencyId,
        //                 'name' => '' ,
                        
        //             ]],
                   
        //         ],
        //     ];
              

        //     $context = [
        //         'check_move_validity' => true,
        //     ];

        //     $accountBankStatementLineId = $this->execute(
        //         'account.bank.statement.line',
        //         'create',
        //         [$journalEntryData],
        //         ['context' => $context]
        //     );

        //     if (!is_numeric($accountBankStatementLineId)) {
        //         throw new \Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
        //     }

        //      $this->execute(
        //         'account.move',
        //         'action_post',
        //         [[$accountBankStatementLineId]]
        //     );
			
		// 	 $statementData = $this->execute(
        //     'account.bank.statement.line',
        //     'read',
        //     [[$accountBankStatementLineId], ['move_id']],
        //     []
        // );

        // if (!is_array($statementData) || empty($statementData[0]['move_id'])) {
        //     throw new Exception("Failed to retrieve move_id for statement entry: " . $accountBankStatementLineId);
        // }
		// 	$journalEntryId = $statementData[0]['move_id'][0];
        //     if (!is_numeric($accountBankStatementLineId)) {
        //         throw new Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
        //     }
			
        //     return [
		// 		'account_bank_statement_line_id'=>$accountBankStatementLineId,
		// 		'journal_entry_id'=>$journalEntryId
		// 	];
 	   }
	   
	   public function storeReceiveMoneyTo(string $date ,float $amount, int $odooCurrencyId , int $journalId , int $bankOdooId , $message = 'To Cash') 
    {
		
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

            $accountBankStatementLineId = $this->execute(
                'account.bank.statement.line',
                'create',
                [$journalEntryData],
                ['context' => $context]
            );

            if (!is_numeric($accountBankStatementLineId)) {
                throw new \Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
            }

             $this->execute(
                'account.move',
                'action_post',
                [[$accountBankStatementLineId]]
            );
			
			
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
	   
	   
	   public function updateReceiveMoneyTo(int $statementEntryId,int $accountBankStatementOdooId,string $date ,float $amount, int $odooCurrencyId , int $journalId , int $bankOdooId , $message = 'To Cash') 
    {
		
			$LiquidTransferId = $this->company->odooSetting->getLiquidityAccountOdooId();
			
			 $name = "/"; // when bank changed only;

       $this->execute(
            'account.bank.statement.line',
            'write',
            [[$statementEntryId], ['state' => 'draft']],
        );
        
         $this->execute(
            'account.bank.statement.line',
            'write',
            [[$statementEntryId],
             [
            'name' => $name,
           'journal_id' => $journalId,
           'amount' => $amount ,
           'date' => $date,
           'ref' => $message,
        ]]
    );
	////
	
	$line_ids= $this->fetchData('account.move',['id','line_ids'],[[['id', '=', $accountBankStatementOdooId]]]) [0]['line_ids']??[];
if(!isset($line_ids[0])){
     throw new Exception("Line Ids not found: " . $accountBankStatementOdooId);
}


$this->execute(
            'account.move',
            'write',
            [[$accountBankStatementOdooId],
             [
                  
            'line_ids' => [
                [1, $line_ids[0], [
                    'account_id' => $bankOdooId,
                    'debit' => abs($amount),
                    'credit' => 0.0,
                    'currency_id' => $odooCurrencyId,
                    'name' => $message,
                ]],
                [1, $line_ids[1], [
                    'account_id' => $LiquidTransferId,
                    'debit' => 0.0,
                    'credit' => abs($amount),
                    'currency_id' => $odooCurrencyId,
                    'name' => $message,
                ]],
            ],
        ]]
    );
	

            $context = [
                'check_move_validity' => true,
            ];
			
			   $this->execute(
            'account.move',
            'action_post',
            [[$accountBankStatementOdooId]],
            ['context' => $context]
        );

 	   }
	   
	   
	
	
	public function cancelMoneyTransferPayment(int $paymentId)
    {
        return $this->cancelPayments($paymentId);
    }
	
    

    

   

   

    

    
	

   



    
	
}
?>
