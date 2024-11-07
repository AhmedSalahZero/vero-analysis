<?php

namespace App\Models;

use App\Traits\Models\HasDeleteButTriggerChangeOnLastElement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentSettlement extends Model
{
	use HasDeleteButTriggerChangeOnLastElement;
	protected $guarded = ['id'];
	
	public function moneyPayment()
	{
		return $this->belongsTo(MoneyReceived::class , 'money_payment_id','id');
	}
	
	public function supplierInvoice()
	{
		return $this->belongsTo(SupplierInvoice::class , 'invoice_id','id');
	}
	public function invoice():BelongsTo
	{
		return $this->supplierInvoice();
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
	public function letterOfCreditIssuance()
	{
		return $this->belongsTo(LetterOfCreditIssuance::class ,'letter_of_credit_issuance_id');
	}
	
}
