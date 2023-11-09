<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Settlement extends Model
{
	protected $guarded = ['id'];
	
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class , 'money_received_id','id');
	}
	public static  function getSettlementAmountByInvoiceNumber(string $invoiceNumber,int $companyId)
	{
		return Settlement::where('company_id',$companyId)->where('invoice_number',$invoiceNumber)->sum('settlement_amount');
	}	
	public function customerInvoice()
	{
		return $this->belongsTo(MoneyReceived::class , 'money_received_id','id');
	}
	public function getAmount()
	{
		return $this->settlement_amount ;
	}		
}
