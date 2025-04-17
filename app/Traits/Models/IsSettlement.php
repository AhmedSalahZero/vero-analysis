<?php 
namespace App\Traits\Models;

use App\Models\MoneyPayment;
use App\Models\MoneyReceived;
use App\Models\PaymentSettlement;
use App\Models\Settlement;
use App\Traits\HasCompany;

trait IsSettlement 
{
	use HasCompany;
	public function getMoney()
	{
		if($this instanceof Settlement){
			return $this->moneyReceived();
		}
		if($this instanceof PaymentSettlement){
			return $this->moneyPayment();
		}
		dd('test dd');
	}
	public function getAmount()
	{
		return $this->settlement_amount ;
	}	
	public function getWithhold()
	{
		return $this->withhold_amount ;
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
	public function getInvoiceExchangeRate()
	{
		return $this->invoice->getExchangeRate();
	}
	public function getInvoiceNumber()
	{
		return $this->invoice->getInvoiceNumber();
	}
	
	
	
}
