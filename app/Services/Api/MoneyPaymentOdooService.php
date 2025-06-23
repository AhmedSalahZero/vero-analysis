<?php 
namespace App\Services\Api;

use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasJournal;
use App\Services\Api\Traits\HasUnlinkAccountBankStatementLine;
use Exception;

class MoneyPaymentOdooService
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
	
	 protected function createAndPostJournalEntry(string $date , float $amountInCurrency , float $amountInMainFunctionalCurrency  , int $odooCurrencyId , int $journalId, int $debitOdooAccountId , int $creditOdooAccountId , ?string $ref , ?int $partner_id ,?string $message , ?int $isTax ) 
    {
			// $id = null ;  // in edit mode 
            $journalEntryData = $this->getDataFormatted($date,$amountInCurrency,$amountInMainFunctionalCurrency,$odooCurrencyId,$journalId,$debitOdooAccountId,$creditOdooAccountId,$ref,$partner_id,$message,$isTax) ;

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
         	   [[$accountBankStatementLineId], ['move_id','name']],
        	    []
       		 );

        if (!is_array($statementData) || empty($statementData[0]['move_id'])) {
            throw new Exception("Failed to retrieve move_id for statement entry: " . $accountBankStatementLineId);
        }
			$moveId = $statementData[0]['move_id'][0];
            if (!is_numeric($accountBankStatementLineId)) {
                throw new Exception("Failed to create journal entry: " . json_encode($accountBankStatementLineId));
            }
			if($partner_id){
				$this->updatePartner($partner_id,$moveId,$context);
			}
			
			
            return [
				'account_bank_statement_line_id'=>$accountBankStatementLineId,
				'journal_entry_id'=>$moveId,
				'odoo_reference'=>$statementData[0]['name']??null
			];
    }
	protected function updatePartner($partner_id,$moveId,$context)
	{
		$this->execute(
            'account.move',
            'button_draft',
            [[$moveId]],
            ['context' => $context]
        );
		
		$this->execute(
            'account.move',
            'read',
            [$moveId, ['partner_id', 'commercial_partner_id', 'bank_partner_id']],
            ['context' => $context]
        );
		$x = $this->execute(
                'account.move',
                'write',
                [$moveId, [
                    'partner_id' => $partner_id,
                    'commercial_partner_id' => $partner_id,
                    'bank_partner_id' => $partner_id,
                ]]
            );
			$x  = $this->execute(
                'account.move',
                'action_post',
                [[$moveId]]
            );
			
	}
	protected function getDataFormatted(string $date , float $amountInCurrency  , float $amountInMainFunctionalCurrency  , int $odooCurrencyId , int $journalId, int $debitOdooAccountId , int $creditOdooAccountId   , ?string $ref , ?int $partner_id ,?string $message , int $isTax = null ):array 
	{
		// $inEditMode = is_null($id) ? 0 : 1;
		// $id = is_null($id) ? 0 : $id ; 
		
		
// if(!isset($line_ids[0])){
//      throw new Exception("Line Ids not found: " . $moveId);

// }
// $ref = $paymentRef;
$paymentRef = $ref ;
$message =$paymentRef;
		return [
               'journal_id' => $journalId, // account journal id (safe or bank journal id )
               'amount' => -$amountInCurrency,
               'date' => $date,
               'partner_id' => $partner_id,
               'ref' =>  $ref, // create lg type
               'payment_ref' =>  $paymentRef, // create lg type
               'line_ids' => [
                    [0,0, [
                        'account_id' => $debitOdooAccountId, // lg cash cover odoo id (create lg cash cover)
                        'debit' => abs($amountInMainFunctionalCurrency),
						'amount_currency'=>abs($amountInCurrency),
                        'credit' => 0.0,
                       'partner_id' => $partner_id ,
                        'currency_id' => $odooCurrencyId,
                        'name' => $message , // cash cover  
                    ]],
                    [0,0, [
                        'account_id' => $creditOdooAccountId, // chart of account odoo id 
                        'debit' => 0.0,
                        'credit' => abs($amountInMainFunctionalCurrency),
						'amount_currency'=>-$amountInCurrency,
                        'currency_id' => $odooCurrencyId,
                        'name' => $message ,
                     'partner_id' => $partner_id
                    ]],
                ],
            ];
	}
	
    public function createCashExpense(string $date,float $amountInCurrency,float $amountInMainFunctionalCurrency,int $journalId,int $odooCurrencyId,int $debitOdooAccountId,int $creditOdooAccountId,int $odooPartnerId,string $ref,int $isTax )
    {
		  $message =$this->getMessage(); 
		  $odooPartnerId = $isTax ? null : $odooPartnerId;
          return $this->createAndPostJournalEntry($date,$amountInCurrency,$amountInMainFunctionalCurrency,$odooCurrencyId,$journalId,$debitOdooAccountId,$creditOdooAccountId,$ref,$odooPartnerId,$message,$isTax);
       
    }
	// protected function getAnalysisAccountIds(array $analytic_distribution):array 
	// {
	// 	$distribution_analytic_account_ids = [];
	// 	foreach (array_keys($analytic_distribution) as $key) {
	// 		$distribution_analytic_account_ids[] = [0, (int)$key];
	// 	}

	// 	// Wrap in outer array with 6 and 0
	// 	$distribution_analytic_account_ids = [[6, 0, ...$distribution_analytic_account_ids]];
	// 	return $distribution_analytic_account_ids;
	// }
	
	
	
	
	
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
// 		bool $accountNumberHasChanged,
// 		bool $odooPartnerId ,
//         string $ref, 
//         $message = ''
//     ) {
		

// 	    $currentState = $this->execute(
//             'account.move',
//             'read',
//             [[$moveId], ['state' => 'draft']],
//         );
// 		$currentState = $currentState[0]['state'] ;
// 		if($currentState == 'posted'){
// 			$this->execute(
// 				'account.move',
// 				'button_draft',
// 				[[$moveId]]
// 			);
// 		}
	

//         $basicArr =  [
//            'journal_id' => $journal_id,
//            'amount' => $amountInCurrency  * -1,
//            'date' => $date,
// 		   'partner_id'=>$odooPartnerId,
//            'ref' => $ref,
// 		];
// 		if($accountNumberHasChanged){
// 			$basicArr['name']="/";
// 		}
//           $this->execute(
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

//   $this->execute(
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
// 					'partner_id' => $odooPartnerId,
//                     'currency_id' => $currency_id,
//                     'name' => $message,
//                 ]],
//                 [1, $line_ids[1], [
//                     'account_id' => $creditOdooAccountId,
//                     'debit' => 0.0,
//                     'credit' => abs($amountInMainFunctionalCurrency),
// 					'amount_currency'=>$amountInCurrency*-1,
//                     'currency_id' => $currency_id,
// 					'partner_id' => $odooPartnerId,
//                     'name' => $message,
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
		
		
// 		$this->updatePartner($odooPartnerId,$moveId,$context);

// }

}
?>
