<?php 
namespace App\Services\Api;

use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasJournal;
use App\Services\Api\Traits\HasJournalEntry;
use App\Services\Api\Traits\HasPayment;
use App\Services\Api\Traits\HasUnlinkAccountBankStatementLine;

class LetterOfGuaranteeService
{
    use AuthTrait,HasPayment,HasJournal,HasJournalEntry,HasUnlinkAccountBankStatementLine;
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
	// protected function getDataFormatted(string $date , float $amount  , int $odooCurrencyId , int $journalId, int $debitOdooAccountId , int $creditOdooAccountId  , ?string $ref , ?int $partnerId ,?string $message , int $id = null ):array 
	// {
	// 	$inEditMode = is_null($id) ? 0 : 1;
	// 	$id = is_null($id) ? 0 : $id ; 

	// 	return [
    //            'journal_id' => $journalId, // account journal id (safe or bank journal id )
    //            'amount' => $amount,
    //            'date' => $date,
    //            'partner_id' => $partnerId,
    //            'ref' =>  $ref, // create lg type
    //            'line_ids' => [
    //                 [$inEditMode, $id, [
    //                     'account_id' => $debitOdooAccountId, // lg cash cover odoo id (create lg cash cover)
    //                     'debit' => abs($amount),
    //                     'credit' => 0.0,
    //                     'currency_id' => $odooCurrencyId,
    //                     'name' => $message , // cash cover  
    //                     'partner_id' => $partnerId,
    //                 ]],
    //                 [$inEditMode, $id+1, [
    //                     'account_id' => $creditOdooAccountId, // chart of account odoo id 
    //                     'debit' => 0.0,
    //                     'credit' => abs($amount),
    //                     'currency_id' => $odooCurrencyId,
    //                     'name' => $message ,
    //                     'partner_id' => $partnerId,
    //                 ]],
    //             ],
    //         ];
	// }
	 
  
}
?>
