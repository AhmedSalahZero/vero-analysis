<?php
namespace App\Services\Api;

use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasJournal;
use App\Services\Api\Traits\HasUnlinkAccountBankStatementLine;
use Exception;

class CashExpenseOdooService
{
    use AuthTrait,HasJournal,HasUnlinkAccountBankStatementLine;
    // string $date,int $outJournalId,float $amount,int $odooCurrencyId,int $lgOddoAccountId
    
    protected function getRef()
    {
        return null ;
    }protected function getMessage()
    {
        return null;
    }
    public function getOdooPartnerId()
    {
        return null ;
    }
    
    protected function createAndPostJournalEntry(string $subCategoryName, string $date, float $amountInCurrency, float $amountInMainFunctionalCurrency, int $odooCurrencyId, int $journalId, int $debitOdooAccountId, int $creditOdooAccountId, array $analytic_distribution, ?string $ref, ?int $partner_id, ?string $message)
    {
        $id = null ;  // in edit mode
            
        $journalEntryData = $this->getDataFormatted($subCategoryName, $date, $amountInCurrency, $amountInMainFunctionalCurrency, $odooCurrencyId, $journalId, $debitOdooAccountId, $creditOdooAccountId, $analytic_distribution, $ref, $partner_id, $message, $id) ;

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
            'journal_entry_id'=>$journalEntryId,
			'reference'=>$statementData[0]['move_id'][1]??null
        ];
    }
    protected function getDataFormatted(string $subCategoryName, string $date, float $amountInCurrency, float $amountInMainFunctionalCurrency, int $odooCurrencyId, int $journalId, int $debitOdooAccountId, int $creditOdooAccountId, array $analytic_distribution, ?string $ref, ?int $partner_id, ?string $message, int $id = null):array
    {
        $inEditMode = is_null($id) ? 0 : 1;
        $id = is_null($id) ? 0 : $id ;
        
        $distribution_analytic_account_ids = $this->getAnalysisAccountIds($analytic_distribution);
  
        $paymentRef = 'Expense Payment ' . $subCategoryName;
        $message = $paymentRef;
        $ref = $paymentRef;

        if (is_null($partner_id)) {
            $distribution_analytic_account_ids = [[6, 0, []]];
        }
        $data = [
                       'journal_id' => $journalId, // account journal id (safe or bank journal id )
                       'amount' => -$amountInCurrency,
                       'date' => $date,
                      'partner_id' => $partner_id,
                       'ref' =>  $ref, // create lg type
                       'payment_ref' =>  $paymentRef, // create lg type
                       'line_ids' => [
                            [$inEditMode,0, [
                                'account_id' => $debitOdooAccountId, // lg cash cover odoo id (create lg cash cover)
                                'debit' => abs($amountInMainFunctionalCurrency),
                                'amount_currency'=>abs($amountInCurrency),
                                'credit' => 0.0,
                               'partner_id' => $partner_id,
                                'currency_id' => $odooCurrencyId,
                                'name' => $message , // cash cover
                                  'analytic_distribution' =>$analytic_distribution,   // 87  -> x_plan2_id     80 -> percentage   Allocate Amount / Paid Amount * 100     ,
                                    'distribution_analytic_account_ids' => $distribution_analytic_account_ids  ,
                            ]],
                            [$inEditMode,0, [
                                'account_id' => $creditOdooAccountId, // chart of account odoo id
                                'debit' => 0.0,
                                'credit' => abs($amountInMainFunctionalCurrency),
                                'amount_currency'=>-$amountInCurrency,
                                'currency_id' => $odooCurrencyId,
                                'name' => $message ,
                                'partner_id' => $partner_id,
                                'analytic_distribution' => [],
                                'distribution_analytic_account_ids' => [[6, 0, []]] ,
                            ]],
                        ],
                    ] ;
        return $data;
    }
    
    public function createCashExpense(string $subCategoryName, string $date, float $amountInCurrency, float $amountInMainFunctionalCurrency, int $journalId, int $odooCurrencyId, int $debitOdooAccountId, int $creditOdooAccountId, $analytic_distribution)
    {
        $ref = $this->getRef();
        $message =$this->getMessage();
        $odooPartnerId = $this->getOdooPartnerId();
        return $this->createAndPostJournalEntry($subCategoryName, $date, $amountInCurrency, $amountInMainFunctionalCurrency, $odooCurrencyId, $journalId, $debitOdooAccountId, $creditOdooAccountId, $analytic_distribution, $ref, $odooPartnerId, $message);
       
    }
    protected function getAnalysisAccountIds(array $analytic_distribution):array
    {
        $distribution_analytic_account_ids = [];
        foreach (array_keys($analytic_distribution) as $key) {
            if ($key > 0) {
                $distribution_analytic_account_ids[] = [0, (int)$key];
            }
        }
        // Wrap in outer array with 6 and 0
		if(count($distribution_analytic_account_ids)){
			$distribution_analytic_account_ids = [[6, 0, ...$distribution_analytic_account_ids]];
		}else{
			$distribution_analytic_account_ids = [[6, 0, []]];
		}
		// dd($distribution_analytic_account_ids);
        return $distribution_analytic_account_ids;
    }
    
    
    
    
    
    // public function updateJournalEntry(
    //         int $moveId ,
    //         int $accountBankStatementOdooId ,
    //         string $date ,
    //         float $amountInCurrency ,
    // 		float $amountInMainFunctionalCurrency,
    //         int $currency_id ,
    //         int $journal_id ,
    //         int $debitOdooAccountId ,
    //         int $creditOdooAccountId ,
    // 		array $analytic_distribution,
    // 		bool $accountNumberHasChanged,
    //         $ref = 'HI Salah 160',
    //         $message = ''
    //     ) {

    // 	//	 $name = "/"; // when bank changed only;

    //        $this->execute(
    //             'account.bank.statement.line',
    //             'write',
    //             [[$accountBankStatementOdooId], ['state' => 'draft']],
    //         );
    //         $basicArr =  [
    //          //   'name' => $name,
    //            'journal_id' => $journal_id,
    //            'amount' => $amountInCurrency  * -1,
    //            'date' => $date,
    //            'ref' => $ref,
    // 		];
    // 		if($accountNumberHasChanged){
    // 			$basicArr['name']="/";
    // 		}
    //         $bankJournal = $this->execute(
    //             'account.bank.statement.line',
    //             'write',
    //             [[$accountBankStatementOdooId],
    // 			$basicArr
    //             ]
    //     );




    // $line_ids= $this->fetchData('account.move',['id','line_ids'],[[['id', '=', $moveId]]]) [0]['line_ids']??[];
    // if(!isset($line_ids[0])){
    //      throw new Exception("Line Ids not found: " . $moveId);
    // }
    // $distribution_analytic_account_ids = $this->getAnalysisAccountIds($analytic_distribution);
    //  $updateDebitAndCredit = $this->execute(
    //             'account.move',
    //             'write',
    //             [[$moveId],
    //              [
    
    //             'line_ids' => [
    //                 [1, $line_ids[0], [
    //                     'account_id' => $debitOdooAccountId,
    //                     'debit' => abs($amountInMainFunctionalCurrency),
    // 					'amount_currency'=>abs($amountInCurrency),
    //                     'credit' => 0.0,
    //                     'currency_id' => $currency_id,
    //                     'name' => $message,
    // 					  'analytic_distribution' =>$analytic_distribution,   // 87  -> x_plan2_id     80 -> percentage   Allocate Amount / Paid Amount * 100     ,
    //              		       'distribution_analytic_account_ids' => $distribution_analytic_account_ids  ,
    
    //                 ]],
    //                 [1, $line_ids[1], [
    //                     'account_id' => $creditOdooAccountId,
    //                     'debit' => 0.0,
    //                     'credit' => abs($amountInMainFunctionalCurrency),
    // 					'amount_currency'=>$amountInCurrency*-1,
    //                     'currency_id' => $currency_id,
    //                     'name' => $message,
    // 					'analytic_distribution' => [],
    //                     'distribution_analytic_account_ids' => [[6, 0, []]] ,
    //                 ]],
    //             ],
    //         ]]
    //     );

    //     $context = [
    //             'check_move_validity' => true,
    //         ];


    //   $posted = $this->execute(
    //             'account.move',
    //             'action_post',
    //             [[$moveId]],
    //             ['context' => $context]
    //         );

    // }

    
    /**
     * ! TEST
     */

    //  public function TESTcreateAndPostJournalEntry(
    //         float $amountInCurrency = 100,
    // 		float $amountInMainFunctionalCurrency = 100 ,
    //         string $date = '2025-06-18',
    //         int $currency_id = 1,
    //         int $journal_id = 243, // Bank account id
    //         int $debitOdooAccountId = 614, // Expense Item
    //         int $creditOdooAccountId = 260, // Bank Account
    //         int $partnerId = 408,
    //         $ref = 'HI MYA 101',
    //         $message = 'MYA 108'
    //     ) {
    //         $statementEntryData = [
    //             'journal_id' => $journal_id,
    //             'amount' => $amountInCurrency * -1,
    //             'date' => $date,
    // 			'payment_ref'=> 'main part payment ref',
    // 			'partner_id'=> $partnerId,
    //             'ref' => 'main part ref',
    //             'line_ids' => [
    //                 [0, 0, [
    //                     'account_id' => $debitOdooAccountId,
    //                     'debit' => abs($amountInMainFunctionalCurrency),
    // 					'amount_currency'=> abs($amountInCurrency),
    //                     'credit' => 0.0,
    // 					'partner_id'=> $partnerId,
    //                     'currency_id' => $currency_id,
    //                     'name' =>'comment from debit part',
    //                     'analytic_distribution' => ["87" => 80.0,"81" => 20.0],
    //                     'distribution_analytic_account_ids' => [[6, 0, [0,87],[0,81]]] ,
    
    //                 ]],
    //                 [0, 0, [
    //                     'account_id' => $creditOdooAccountId,
    //                     'debit' => 0.0,
    //                     'credit' => abs($amountInMainFunctionalCurrency),
    // 					'amount_currency'=> -$amountInCurrency,
    //                     'currency_id' => $currency_id,
    // 					'partner_id'=> $partnerId,
    //                     'name' => 'comment from credit part',
    //                     'analytic_distribution' => [],
    //                     'distribution_analytic_account_ids' => [[6, 0, []]] ,
    //                 ]],
    //             ],
    //         ];
    //         $context = [
    //             'check_move_validity' => true
    //         ];

    //         $moveId = $this->execute(
    //             'account.bank.statement.line',
    //             'create',
    //             [$statementEntryData],
    //             ['context' => $context]
    //         );

    //         if (!is_numeric($moveId)) {
    //             throw new Exception("Failed to create journal entry: " . json_encode($moveId));
    //         }

    //         // Retrieve the move_id from the created bank statement line
    //         $statementData = $this->execute(
    //             'account.bank.statement.line',
    //             'read',
    //             [[$moveId], ['move_id']],
    //             []
    //         );

    //         if (!is_array($statementData) || empty($statementData[0]['move_id'])) {
    //             throw new Exception("Failed to retrieve move_id for statement entry: " . $moveId);
    //         }

    //         $moveId = $statementData[0]['move_id'][0];

        

    //         return [
    //             'statement_entry_id' => $moveId,
    //             'entry_id' => $moveId,
    
    //         ];
    //     }
    
    

}
