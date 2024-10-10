<?php
namespace App\Traits\Models;

use Carbon\Carbon;


 
/**
 * * ال تريت دا مشترك بين
 * * MoneyReceived || MoneyPayment
 */
trait IsMoney 
{
	public function getId()
	{
		return $this->id ;
	}	
	public function getType():string 
	{
		return $this->type ;
	}
	public function storeNewSettlement(array $settlements,string $customerName,int $companyId)
	{
		$totalWithholdAmount= 0 ;
		foreach($settlements as $settlementArr)
		{
			$settlementArr['settlement_amount'] = isset($settlementArr['settlement_amount']) ?  unformat_number($settlementArr['settlement_amount']) :  0 ;  
			if($settlementArr['settlement_amount'] > 0){
				$settlementArr['company_id'] = $companyId ;
				$settlementArr['customer_name'] = $customerName ;
				$withholdAmount = isset($settlementArr['withhold_amount']) ? unformat_number($settlementArr['withhold_amount']) : 0 ;
				$settlementArr['withhold_amount'] = $withholdAmount ;
				$totalWithholdAmount += $withholdAmount  ;
				unset($settlementArr['net_balance']);
				$this->settlements()->create($settlementArr);
			}
		}
		return $totalWithholdAmount ;
	}
	public function getTotalSettlementAmount()
	{
		return $this->settlements->sum('settlement_amount');
	}
	
	public function getTotalSettlementAmountFormatted()
	{
		return number_format($this->getTotalSettlementAmount());
	}
	public function getTotalSettlementsNetBalance()
	{
		return $this->getReceivedAmount()  - $this->getTotalSettlementAmount();
	}
	public function setDownPaymentSettlementDateAttribute($value)
    {
        $date = explode('/', $value);
        if (count($date) != 3) {
            $this->attributes['down_payment_settlement_date'] = $value ;

            return ;
        }
        $month = $date[0];
        $day = $date[1];
        $year = $date[2];

        $this->attributes['down_payment_settlement_date'] = $year . '-' . $month . '-' . $day;
    }
	public function getDownPaymentSettlementDate()
    {
        return $this->down_payment_settlement_date;
    }

    public function getDownPaymentSettlementDateFormatted()
    {
        $downPaymentSettlement = $this->getDownPaymentSettlementDate();

        return  $downPaymentSettlement ? Carbon::make($downPaymentSettlement)->format('d-m-Y') : null ;
    }
	public function isUserType(string $type):bool
	{
		return $this->user_type == $type; 
	}
	
}
