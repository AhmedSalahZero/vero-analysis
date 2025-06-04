<?php 
namespace App\Services\Api;

use App\OdooSetting;
use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasEntryJournal;
use App\Services\Api\Traits\HasJournal;
use Exception;

class CashExpenseOdooService
{
    use AuthTrait,HasJournal,HasEntryJournal;
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
	
	 protected function createAndPostJournalEntry(string $date , float $amount  , int $odooCurrencyId , int $journalId, int $debitOdooAccountId , int $creditOdooAccountId  , array $analytic_distribution, ?string $ref , ?int $partner_id ,?string $message ) 
    {
			$id = null ;  // in edit mode 
            $journalEntryData = $this->getDataFormatted($date,$amount,$odooCurrencyId,$journalId,$debitOdooAccountId,$creditOdooAccountId,$analytic_distribution,$ref,$partner_id,$message,$id) ;

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
	
    public function createCashExpense(string $date,float $amount,int $journalId,int $odooCurrencyId,int $debitOdooAccountId,int $creditOdooAccountId,$analytic_distribution)
    {
          $ref = $this->getRef();
		  $message =$this->getMessage(); 
		  $amount = $amount * -1;
		  $odooPartnerId = $this->getOdooPartnerId();
          return $this->createAndPostJournalEntry($date,$amount,$odooCurrencyId,$journalId,$debitOdooAccountId,$creditOdooAccountId,$analytic_distribution,$ref,$odooPartnerId,$message);
       
    }
	protected function getDataFormatted(string $date , float $amount  , int $odooCurrencyId , int $journalId, int $debitOdooAccountId , int $creditOdooAccountId , array $analytic_distribution  , ?string $ref , ?int $partner_id ,?string $message , int $id = null ):array 
	{
		$inEditMode = is_null($id) ? 0 : 1;
		$id = is_null($id) ? 0 : $id ; 
		
		$distribution_analytic_account_ids = [];
		foreach (array_keys($analytic_distribution) as $key) {
			$distribution_analytic_account_ids[] = [0, (int)$key];
		}

// Wrap in outer array with 6 and 0
$distribution_analytic_account_ids = [[6, 0, ...$distribution_analytic_account_ids]];
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
						  'analytic_distribution' =>$analytic_distribution,   // 87  -> x_plan2_id     80 -> percentage   Allocate Amount / Paid Amount * 100     , 
             		       'distribution_analytic_account_ids' => $distribution_analytic_account_ids  ,
                    ]],
                    [$inEditMode, $id+1, [
                        'account_id' => $creditOdooAccountId, // chart of account odoo id 
                        'debit' => 0.0,
                        'credit' => abs($amount),
                        'currency_id' => $odooCurrencyId,
                        'name' => $message ,
                        'partner_id' => $partner_id,
						   'analytic_distribution' => [],
                    'distribution_analytic_account_ids' => [[6, 0, []]] ,
                    ]],
                ],
            ];
	}
	
	
	
	
  
}
?>
