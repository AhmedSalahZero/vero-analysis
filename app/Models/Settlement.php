<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
	public function getWithhold()
	{
		return $this->withhold_amount ;
	}		
	public function unappliedAmount()
	{
		return $this->belongsTo(UnappliedAmount::class,'unapplied_amount_id','id');
	}
	public function getInvoiceNumber()
	{
		return $this->invoice_number ; 
	}
	public function getWithholdAmount()
	{
		return $this->withhold_amount?:0 ; 
	}
	public function getWithholdAmountFormatted()
	{
		return number_format($this->getWithholdAmount(),0);
	}
	public function getSettlementAmount()
	{
		return $this->settlement_amount?:0 ; 
	}
	public function getSettlementAmountFormatted()
	{
		return number_format($this->getSettlementAmount(),0);
	}
	public function getSettlementDate()
	{
		return $this->unappliedAmount->settlement_date ; 
	}
	public function getSettlementDateFormatted()
    {
        $settlementDate = $this->getSettlementDate() ;
        if($settlementDate) {
            return Carbon::make($settlementDate)->format('d-m-Y');
        }
    }
	
}
