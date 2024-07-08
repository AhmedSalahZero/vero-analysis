<?php
namespace App\Traits\Models;

use App\Models\DueDateHistory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
/**
 * * للميسود المشترك بين
 * * CustomerInvoice , SupplierInvoice
 */

trait IsInvoice 
{
	
	public function getId(){
		return $this->id ;
	}
	public function scopeOnlyCompany(Builder $query,$companyId){
		return $query->where('company_id',$companyId);
	}
    public function scopeCompany($query)
    {
        return $query->where('company_id', request()->company->id?? Request('company_id'));
    }
 
    public function getNetBalance()
    {
        return $this->net_balance ?: 0 ;
    }
	public function getNetBalanceFormatted()
	{
		return number_format($this->getNetBalance(),0);
	}
    
	public function getName()
    {
        return $this->customer_name ;
    }
	public function getRemainingChequeAmount():float
    {
        $customerName =	$this->getName();
        $invoices = $this->getInvoicesFor($customerName);
        $totalInvoiceAmount = 0;
        foreach($invoices as $customerInvoice) {
            $totalInvoiceAmount += $customerInvoice->getNetInvoiceAmount();
        }
        return $totalInvoiceAmount;
    }
	/**
	 * * ال name 
	 * * هنا اما يكون اسم عميل او اسم مورد
	 */
    public function getInvoicesFor(string $name)
    {
        return self::where($this->clientNameColumnName, $name)->get() ;
    }
	public function getVatAmount()
	{
		return $this->vat_amount ?: 0 ;
	}
	public function getStatus()
	{
		return $this->invoice_status;
	}
	public function getStatusFormatted()
	{
		return snakeToCamel($this->getStatus());
	}
	public static function getOnlyNotClosedPeriods()
	{
		return self::where('company_id',getCurrentCompanyId())->where('is_period_closed',0)->get()->unique(function($item){return $item['invoice_month'] .'-'.$item['invoice_year'];})->values()->toArray();
	}
	public function getAging(){
		if($this->getStatus() == self::COLLETED_OR_PAID){
			return '-';
		}
		return now()->diffInDays(Carbon::make($this->getInvoiceDate()));
		
	}
	public function getCurrency()
	{
		return $this->currency;
	}
	public function getWithholdAmount()
	{
		return (float)$this->withhold_amount ; 
	}
	public function getNetInvoiceAmount()
    {
		$netInvoiceAmount = $this->net_invoice_amount ?:0 ; 
		return (float)$netInvoiceAmount;
    }
	public function getNetInvoiceInMainCurrencyAmount()
    {
		$netInvoiceAmount = $this->net_invoice_amount_in_main_currency ?:0 ; 
		return $netInvoiceAmount;
    }
	public function getNetInvoiceAmountFormatted()
	{
		return number_format($this->getNetInvoiceAmount());
	}

    
    protected function generateInvoiceStatus($totalCollectedOrPaid, $netInvoiceAmount)
    {
        $invoiceDueDate = Carbon::make($this->getInvoiceDueDate());
        $nowAsDate = Carbon::make(now()->setTime(0, 0)->format('d-m-Y'));
		$totalCollectedOrPaid += $this->withhold_amount;
        if($totalCollectedOrPaid == $netInvoiceAmount) {
            return self::COLLETED_OR_PAID;
        }
        if($totalCollectedOrPaid > 0 &&  $invoiceDueDate->lessThan($nowAsDate)) {
            return self::PARTIALLY_COLLECTED_OR_PAID_AND_PAST_DUE;
        }
        if($invoiceDueDate->greaterThan($nowAsDate)) {
            return 'not_due_yet';
        }
        if($invoiceDueDate->equalTo($nowAsDate)) {
            return 'due_to_day';
        }
        if($invoiceDueDate->lessThan($nowAsDate) && $totalCollectedOrPaid == 0) {
            return 'past_due';
        }
    }
    public function getInvoiceDueDate()
    {
        return $this->invoice_due_date ;
    }
	public function getDueDateFormatted()
    {
		$invoiceDueDate = $this->getInvoiceDueDate() ;
        return $invoiceDueDate ? Carbon::make($invoiceDueDate)->format('d-m-Y') : null   ;
    }
    public function getInvoiceDate()
	{
		return $this->invoice_date ? Carbon::make($this->invoice_date)->format('Y-m-d') : null;
	}
	public function getInvoiceDateFormatted()
	{
		return $this->invoice_date ? Carbon::make($this->invoice_date)->format('d-m-Y') : null ; 
	}
    public function getInvoiceNumber()
    {
        return $this->invoice_number ;
    }
	public static function getAllUniqueCustomerNames(int $companyId , $currencyName)
	{
		return self::where('company_id',$companyId)
		->where('currency',$currencyName)
		->get()->pluck(self::CLIENT_NAME_COLUMN_NAME,self::CLIENT_NAME_COLUMN_NAME)->toArray();
	}
	public static function getTotalInvoicesPlusVatAmountUntilDate( string $currencyName, string $customerName,string $startDate , string $endDate):float
	{

		return DB::table(self::TABLE_NAME)
		->where('company_id',getCurrentCompanyId())
		->where(self::CLIENT_NAME_COLUMN_NAME,$customerName)
		->where('currency',$currencyName)
		->whereBetween('invoice_date',[$startDate,$endDate])
		->sum(DB::raw('invoice_amount + vat_amount'));

	}
	public function dueDateHistories()
	{
		return $this->hasMany(DueDateHistory::class,'model_id','id')->where('model_type',getModelNameWithoutNamespace($this));
	}

	public static function getBeginningBalanceUntil( string $currencyName, string $customerName,string $startDate ,string $endDate)
	{
		$totalInvoicesPlusVatAmount  = self::getTotalInvoicesPlusVatAmountUntilDate($currencyName,$customerName,$startDate,$endDate);
		$totalMoneyReceivedAmountPlusWithhold = self::getTotalMoneyAmountPlusWithhold($currencyName,$customerName,$startDate  , $endDate);
		return $totalInvoicesPlusVatAmount - $totalMoneyReceivedAmountPlusWithhold;
	}
	public static function getTotalMoneyAmountPlusWithhold( string $currencyName, string $customerName,string $startDate , string $endDate)
	{
		
		return DB::table(self::MONEY_RECEIVED_OR_PAYMENT_TABLE_NAME)
		->where('company_id',getCurrentCompanyId())
		->where(self::CLIENT_NAME_COLUMN_NAME,$customerName)
		->where('currency',$currencyName)
		->whereBetween(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,[$startDate,$endDate])
		->sum(DB::raw('total_withhold_amount + '.self::RECEIVED_OR_PAYMENT_AMOUNT));
	}
	
	
}
