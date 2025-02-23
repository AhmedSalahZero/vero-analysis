<?php
namespace App\Traits\Models;

use App\Models\Branch;
 
/**
 * * ال تريت دا مشترك بين
 * * CashInSafe 
 * * الخاصة بال money received
 * * وال cashInSafe الخاصة بال down payments
 */
trait IsCashInSafe 
{
	public function receivingBranch(){
		return $this->belongsTo(Branch::class,'receiving_branch_id','id');
	}
	public function getReceivingBranchId()
	{
		$branch = $this->receivingBranch;
		return $branch ? $branch->id : 0 ;
	}
	public function getReceivingBranchName()
	{
		$branch = $this->receivingBranch;
		return $branch ? $branch->getName() : 0 ;
	}
	public function getReceiptNumber()
	{
		return $this->receipt_number ;
	}
}
