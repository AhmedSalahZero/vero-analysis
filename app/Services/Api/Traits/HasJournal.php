<?php 
namespace App\Services\Api\Traits;


trait HasJournal 
{

	public function getJournalId($moneyModel):int 
	{
		$isCashInSafeOrCashPayment = $moneyModel->isCash();
		return $isCashInSafeOrCashPayment  ? $moneyModel->getCashBranchJournalId() : $moneyModel->getBankAccountJournalId();
	}
	
	public function getChartOfAccountId($moneyModel):int 
	{
		$isCashInSafeOrCashPayment = $moneyModel->isCash();
		return $isCashInSafeOrCashPayment  ? $moneyModel->getCashBranchOdooId() : $moneyModel->getBankAccountOdooId();
	}
	
}
