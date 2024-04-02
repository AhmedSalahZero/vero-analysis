<?php

namespace App\Models;

use App\Helpers\HArr;
use App\Interfaces\Models\IInvoice;
use App\Traits\Models\IsInvoice;
use App\Traits\StaticBoot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CustomerInvoice extends Model implements IInvoice
{
    use StaticBoot , IsInvoice;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    
    protected $dates = [
       'invoice_date'
    ];
	
	
	const CLIENT_NAME_COLUMN_NAME = 'customer_name';
	const CLIENT_ID_COLUMN_NAME = 'customer_id';
	const RECEIVED_OR_PAYMENT_AMOUNT = 'received_amount';
	const RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME = 'receiving_date';
	const MONEY_RECEIVED_OR_PAYMENT_TABLE_NAME = 'money_received';
	const TABLE_NAME = 'customer_invoices';
	const COLLETED_OR_PAID = 'collected';
	const PARTIALLY_COLLECTED_OR_PAID_AND_PAST_DUE = 'partially_collected_and_past_due';

    protected $guarded = [];
	
	public function getClientDisplayName()
	{
		return __('Customers');
	}
	public function getCustomerOrSupplierAgingText()
	{
		return __('Customers Invoice Aging');
	}
	public function getAgingTitle()
	{
		return __('Customer Aging Form');
	}
	public function getBalancesTitle()
	{
		return __('Customer Balances');
	}
	public function getClientNameText()
	{
		return __('Customer Name');
	}
	public function getMoneyReceivedOrPaidUrlName()
	{
		return 'create.money.receive';
	}
	public function getMoneyReceivedOrPaidText()
	{
		return __('Money Received');
	}
	public function getCustomerOrSupplierStatementText()
	{
		return __('Customer Statement');
	}
   
	public function getCustomerName()
    {
        return $this->getName() ;
    }
	// do not use this directly use 
    public function moneyReceived()
    {
        return $this->hasMany(MoneyReceived::class, self::CLIENT_NAME_COLUMN_NAME, self::CLIENT_NAME_COLUMN_NAME)->where('company_id',getCurrentCompanyId());
    }
	public function getCollectedAmountAttribute($val)
    {
        return $val ;
    }
	public function getCustomerId()
    {
        return $this->customer_id ;
    }
   
	
	public function isCollected()
	{
		return $this->getStatus() === 'collected'; 
 	}
	
	
	
	public function getNetBalanceUntil(string $date)
	{
		$invoiceNumber = $this->getInvoiceNumber();
		$customerName = $this->getName();
		$netInvoiceAmount = $this->getNetInvoiceAmount();
		$totalWithhold = $this->getWithholdAmount();
		$totalCollected = 0 ;
		$moneyReceives = $this->moneyReceived->where(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,'<=',$date) ;
		foreach($moneyReceives as $moneyReceived) {
			foreach($moneyReceived->getSettlementsForInvoiceNumber($invoiceNumber, $customerName)  as $settlement) {
				$totalCollected += $settlement->getAmount();
			}
		}
		return $netInvoiceAmount - $totalCollected - $totalWithhold;
	}
	

	public static function getBeginningBalanceUntil( string $currencyName, string $customerName,string $date)
	{
		$totalInvoicesPlusVatAmount  = self::getTotalInvoicesPlusVatAmountUntilDate($currencyName,$customerName,$date);
		$totalMoneyReceivedAmountPlusWithhold = self::getTotalMoneyAmountPlusWithhold($currencyName,$customerName,$date);
		return $totalInvoicesPlusVatAmount - $totalMoneyReceivedAmountPlusWithhold;
		
	}

	
	public static function getTotalMoneyAmountPlusWithhold( string $currencyName, string $customerName,string $date)
	{
		
		return DB::table(self::MONEY_RECEIVED_OR_PAYMENT_TABLE_NAME)
		->where('company_id',getCurrentCompanyId())
		->where(self::CLIENT_NAME_COLUMN_NAME,$customerName)
		->where('currency',$currencyName)
		->where(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,'<=',$date)
		->sum(DB::raw('total_withhold_amount + '.self::RECEIVED_OR_PAYMENT_AMOUNT));
	}
	public static function formatForStatementReport(Collection $customerInvoices,string $customerName,string $startDate,string $endDate,string $currency){
			$startDateFormatted = Carbon::make($startDate)->format('d-m-Y');
			$index = -1 ;
			$firstCustomerInvoice = $customerInvoices->first() ?: null; 
			$oneDayBeforeStartDate = Carbon::make($startDate)->subDay()->format('Y-m-d');
			$beginningBalance = $firstCustomerInvoice ? $customerInvoices->first()->getBeginningBalanceUntil($currency,$customerName,$oneDayBeforeStartDate) : 0; 
			$formattedData = [];
			$currentData['date'] = $startDateFormatted;
			$currentData['document_type'] = 'Beginning Balance';
			$currentData['document_no'] = null;
			$currentData['debit'] = $debit = $beginningBalance >= 0 ? $beginningBalance : 0;
			$currentData['credit'] = $credit = $beginningBalance < 0 ? $beginningBalance * -1 : 0 ;
			$currentData['end_balance'] =$debit - $credit;
			$currentData['comment'] =null;
			$index++ ;
			$formattedData[$index] = $currentData;
			$allMoneyReceived =  MoneyReceived::
			where('company_id',getCurrentCompanyId())
			->whereBetween(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,[$startDate,$endDate])
			->where('currency',$currency)
			->where(self::CLIENT_NAME_COLUMN_NAME,$customerName)
			->get() ; 
		foreach($customerInvoices as $customerInvoice){
			$currentData = [];
			$invoiceDate = $customerInvoice->getInvoiceDateFormatted() ;
			$invoiceNumber  = $customerInvoice->getInvoiceNumber($customerName) ;
			$currentData['date'] = $invoiceDate;
			$currentData['document_type'] = 'Invoice';
			$currentData['document_no'] = $invoiceNumber;
			$currentData['debit'] = $customerInvoice->getNetInvoiceAmount();
			$currentData['credit'] =0;
			$currentData['comment'] =null;
			$index++ ;
			$formattedData[$index]=$currentData;
		}
		foreach($allMoneyReceived as $moneyReceived) {
			$dateReceiving = $moneyReceived->getReceivingDateFormatted() ;
			$moneyReceivedType = $moneyReceived->getType();
			$bankName = $moneyReceived->getBankName();
			$docNumber = $moneyReceived->getNumber();
				$moneyReceivedAmount = $moneyReceived->getReceivedAmount() ;
				if($moneyReceivedAmount){
					$currentData = []; 
					$currentData['date'] = $dateReceiving;
					$currentData['document_type'] = $moneyReceivedType;
					$currentData['document_no'] = $docNumber  ;
					$currentData['debit'] = 0;
					$currentData['credit'] =$moneyReceivedAmount;
					$currentData['comment'] =__('Settlement For Invoice No.') . ' ' . implode('/',$moneyReceived->settlements->pluck('invoice_number')->toArray()); ;
					$index++;
					$formattedData[] = $currentData ;
					$totalWithholdAmount = $moneyReceived->getTotalWithholdAmount();
					
					if($totalWithholdAmount){
						$currentData = []; 
					$currentData['date'] = $dateReceiving;
					$currentData['document_type'] = __('Withhold Taxes');
					$currentData['document_no'] =  $docNumber ;
					$currentData['debit'] = 0;
					$currentData['credit'] =$totalWithholdAmount;
					$currentData['comment'] =$bankName;
					$currentData['comment'] =__('Withhold Taxes For Invoice No.') . ' ' . implode('/',$moneyReceived->settlements->where('withhold_amount','>',0)->pluck('invoice_number')->toArray());
					$index++;
					$formattedData[] = $currentData ;
					}
				}
		}
		return HArr::sortBasedOnKey($formattedData,'date');
	}
	
	
	public function customer()
	{
		return $this->belongsTo(Partner::class,self::CLIENT_ID_COLUMN_NAME,'id');
	}
	
}
