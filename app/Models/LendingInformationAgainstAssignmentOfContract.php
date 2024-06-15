<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LendingInformationAgainstAssignmentOfContract extends Model
{
    protected $guarded = ['id'];
	public function overdraftAgainstAssignmentOfContract()
	{
		return $this->belongsTo(OverdraftAgainstAssignmentOfContract::class,'overdraft_against_assignment_of_contract_id','id');
	}
	
	public function getId(){
		return $this->id ; 
	}
	public function getCustomerId()
	{
		return $this->customer_id;
	}	
	public function customer()
	{
		return $this->belongsTo(Partner::class,'customer_id','id');
	}
	public function getCustomerName()
	{
		return $this->customer ? $this->customer->getName():__('N/A');
	}
	
	public function contract()
	{
		return $this->belongsTo(Contract::class,'contract_id','id');
	}
	public function getContractStartDate()
	{
		return $this->contract ? $this->contract->getStartDate():__('N/A');
		
	}
	public function getContractEndDate()
	{
		return $this->contract ? $this->contract->getEndDate():__('N/A');
		
	}
	public function getContractName()
	{
		return $this->contract ? $this->contract->getName():__('N/A');
	}
	public function getLendingRate()
	{
		return $this->lending_rate ?: 0 ;
	}
	public function getLendingRateFormatted()
	{
		return number_format($this->getLendingRate()) ;
	}
	
}
