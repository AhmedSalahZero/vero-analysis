<?php
namespace App\Traits\Models;

use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\MoneyPayment;
use App\Models\MoneyReceived;
use App\Models\Partner;
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
	public function getSettlementAndWithholdAmountInMainCurrency($receivingCurrencyOrPaymentCurrency,$invoiceCurrency,$exchangeRate,$foreignExchangeRate,$invoiceExchangeRate,$settlementAmountInInvoiceCurrency,$withholdAmountInInvoiceCurrency):array 
	{
		$mainFunctionCurrency = getCurrentCompany()->getMainFunctionalCurrency();
		if($receivingCurrencyOrPaymentCurrency == $mainFunctionCurrency && $mainFunctionCurrency ==  $invoiceCurrency  ){
			return [
				'settlement_amount_in_main_currency'=>$settlementAmountInInvoiceCurrency ,
				'withhold_amount_in_main_currency'=>$withholdAmountInInvoiceCurrency,
				'settlement_in_invoice_exchange_rate'=>$settlementAmountInInvoiceCurrency
			] ;
		}
		if($receivingCurrencyOrPaymentCurrency != $invoiceCurrency && $receivingCurrencyOrPaymentCurrency == $mainFunctionCurrency ){
			return [
				'settlement_amount_in_main_currency'=>$settlementAmountInInvoiceCurrency * $exchangeRate ,
				'withhold_amount_in_main_currency'=>$withholdAmountInInvoiceCurrency* $invoiceExchangeRate,
				'settlement_in_invoice_exchange_rate'=>$settlementAmountInInvoiceCurrency*$invoiceExchangeRate
			]  ;
		}
		if($receivingCurrencyOrPaymentCurrency ==$invoiceCurrency && $receivingCurrencyOrPaymentCurrency != $mainFunctionCurrency
			|| 
			$receivingCurrencyOrPaymentCurrency != $invoiceCurrency && $receivingCurrencyOrPaymentCurrency != $mainFunctionCurrency
		){
			return [
				'settlement_amount_in_main_currency'=>$settlementAmountInInvoiceCurrency * $foreignExchangeRate ,
				'withhold_amount_in_main_currency'=>$withholdAmountInInvoiceCurrency* $invoiceExchangeRate,
				'settlement_in_invoice_exchange_rate'=>$settlementAmountInInvoiceCurrency*$invoiceExchangeRate
			] ;
		}
		return [
			'settlement_amount_in_main_currency'=>-8 ,
			'withhold_amount_in_main_currency'=>-8,
			'settlement_in_invoice_exchange_rate'=>-8
		];
	}
	public function storeNewSettlement(
		// string $receivingCurrencyOrPaymentCurrency,string $invoiceCurrency , $exchangeRate ,$foreignExchangeRate,
	array $settlements,int $partnerId,int $companyId , bool $isFromDownPayment = false )
	{
		// $fullInvoiceModelName = $this instanceof MoneyReceived ?'App\Models\CustomerInvoice' : 'App\Models\SupplierInvoice';
		
		$totalWithholdAmount= 0 ;
		foreach($settlements as $settlementArr)
		{
			$settlementArr['settlement_amount'] = isset($settlementArr['settlement_amount']) ?  unformat_number($settlementArr['settlement_amount']) :  0 ;  
			if($settlementArr['settlement_amount'] > 0){
				$settlementArr['company_id'] = $companyId ;
				$settlementArr['partner_id'] = $partnerId;
				$settlementArr['is_from_down_payment'] = $isFromDownPayment ;
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
	public function getTotalSettlementAmountForDownPayment()
	{
		if($this->isInvoiceSettlementWithDownPayment()){
			return $this->settlementsForDownPaymentThatComeFromMoneyModel->sum('settlement_amount');
		}
		return $this->getTotalSettlementAmount();
	}
	public function getTotalSettlementAmountForDownPaymentFormatted()
	{
		return number_format($this->getTotalSettlementAmountForDownPayment());
	}
	public function getTotalSettlementsNetBalance()
	{
		return $this->getAmount()  - $this->getTotalSettlementAmount();
	}
	public function getTotalSettlementsNetBalanceForDownPayment()
	{
		if($this->isInvoiceSettlementWithDownPayment()){
			return $this->getDownPaymentAmount()  - $this->getTotalSettlementAmountForDownPayment();
		}
		return $this->getAmountInInvoiceCurrency()  - $this->getTotalSettlementAmount();
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
		// is_supplier
		return $this->partner->{$type} == 1 ;
	
	}
	
	public function getDownPaymentAmount()
    {
		if($this->isDownPayment()){
			return $this->getAmountInInvoiceCurrency();
		}elseif($this->isInvoiceSettlementWithDownPayment()){
			return $this->downPaymentSettlements->sum('down_payment_amount') ;
		}
		throw new \Exception('Customer Exception .. Not Down Payment');
    }
	public function getDownPaymentAmountFormatted()
    {
		return number_format($this->getDownPaymentAmount());
    }
	public function getReceivingOrPaymentMoneyFormatted():string
	{
		if($this instanceof MoneyReceived){
			return $this->getReceivingDateFormatted();
		}
		if($this instanceof MoneyPayment){
			return $this->getDeliveryDateFormatted();
		}
		throw new \Exception('Customer Exception Invalid Money Type');
	}
	public static function getAllUniquePartnerIdsForCheques(int $companyId , $currencyName)
	{
		return self::where('company_id',$companyId)
		->where('type','cheque')
		->where('currency',$currencyName)
		->get()->pluck('partner_id','partner_id')->toArray();
	}
	public function getFinancialInstitution()
	{
		return FinancialInstitution::find($this->getFinancialInstitutionId());
	}
	public function company()
	{
		return $this->belongsTo(Company::class,'company_id','id');
	}
	public function partner()
	{
		return $this->belongsTo(Partner::class,'partner_id','id');
	}
	public function getDownPaymentType()
	{
		return $this->down_payment_type ;
	}
	public function isDownPaymentOverContract()
	{
		return $this->getDownPaymentType() == self::DOWN_PAYMENT_OVER_CONTRACT;
	}
	public function isFreeDownPayment()
	{
		return $this->getDownPaymentType() == self::DOWN_PAYMENT_FREE;
	}
	
}
