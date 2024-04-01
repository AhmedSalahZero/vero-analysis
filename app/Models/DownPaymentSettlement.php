<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * * هي عباره عن ال 
 * * down payment  Settlements
 * * الخاصة بال money received
 */
class DownPaymentSettlement extends Model
{
	protected $guarded = ['id'];
	protected $table ='down_payment_settlements';
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class , 'money_received_id','id');
	}
	public static  function getSettlementAmountByInvoiceNumber(string $invoiceNumber,int $companyId)
	{
		return Settlement::where('company_id',$companyId)->where('invoice_number',$invoiceNumber)->sum('settlement_amount');
	}	

	public function getAmount()
	{
		return $this->settlement_amount ;
	}	
	public function getWithhold()
	{
		return $this->withhold_amount ;
	}		

	public function getInvoiceNumber()
	{
		return $this->invoice_number ; 
	}


	public function getSettlementAmount()
	{
		return $this->settlement_amount?:0 ; 
	}
	public function getSettlementAmountFormatted()
	{
		return number_format($this->getSettlementAmount(),0);
	}
	
	public function getSettlementDateFormatted()
    {
        $settlementDate = $this->getSettlementDate() ;
        if($settlementDate) {
            return Carbon::make($settlementDate)->format('d-m-Y');
        }
    }
	
}
