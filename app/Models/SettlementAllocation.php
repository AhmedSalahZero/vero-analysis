<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementAllocation extends Model
{
	
	protected $guarded = ['id'];
	

	public function moneyPayment()
	{
		return $this->belongsTo(MoneyPayment::class,'money_payment_id','id');
	}
	
	public function contract()
	{
		return $this->belongsTo(Contract::class,'supplier_contract_id','id');
	}
	public function getInvoiceNumber()
	{
		return $this->invoice_number;
	}
	public function getAmount()
	{
		return $this->allocation_amount ;
	}
	
}	
