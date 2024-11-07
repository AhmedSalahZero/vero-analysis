<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settlement extends Model
{
	protected $guarded = ['id'];
	
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class , 'money_received_id','id');
	}
	
	public function customerInvoice()
	{
		return $this->belongsTo(CustomerInvoice::class , 'invoice_number','invoice_number')->where('customer_id',$this->partner_id);
	}
	public function invoice():BelongsTo
	{
		return $this->customerInvoice();
	}
	public function getInvoiceNumber():string 
	{
		return $this->invoice_number;
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
