<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashInSafe extends Model
{

	 
    protected $guarded = ['id'];
	
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class,'money_received_id');
	}
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
