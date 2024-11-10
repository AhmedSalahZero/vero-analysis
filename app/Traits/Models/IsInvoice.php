<?php
namespace App\Traits\Models;

use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\Deduction;
use App\Models\DueDateHistory;
use App\Models\MoneyReceived;
use App\Models\SupplierInvoice;
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
	public function scopeOnlyCurrency(Builder $query , string $currency){
		return $query->where('currency',$currency);
	}
	public function scopeOnlyForPartner(Builder $query,$partnerId){
		return $query->where(self::CLIENT_ID_COLUMN_NAME,$partnerId);
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
	public function getExchangeRate()
	{
		return $this->exchange_rate ?:1  ;
	}
	public function getNetBalanceInMainCurrency()
	{
		return $this->net_balance_in_main_currency ;
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
	public function getWithholdAmountFormatted()
	{
		return number_format($this->getWithholdAmount());
	}
	public function getTotalDeduction()
	{
		return (float)$this->total_deductions ; 
	}
	public function getTotalDeductionFormatted()
	{
		return number_format($this->getTotalDeduction());
	}
	public function getTotalCollected()
	{
		return (float)$this->collected_amount ; 
	}
	public function getTotalCollectedFormatted()
	{
		return number_format($this->getTotalCollected());
	}
	public function getTotalCollectedOrPaid()
	{
		if($this instanceof CustomerInvoice){
			return (float)$this->collected_amount ; 
		}
		if($this instanceof SupplierInvoice){
			return (float)$this->paid_amount ; 
		}
		throw new \Exception('Custom Exception .. Only Instance Customer Invoice Or Supplier Invoice Allowed');
		
	}
	public function getTotalCollectedOrPaidFormatted()
	{
		return number_format($this->getTotalCollectedOrPaid());
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
	public function getInvoiceDueDateFormatted()
    {
		$invoiceDueDate = $this->getInvoiceDueDate();
        return  $invoiceDueDate ? Carbon::make($invoiceDueDate)->format('d-m-Y') : __('N/A') ;
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
	public static function getAllUniquePartnerIds(int $companyId , $currencyName)
	{
		return self::where('company_id',$companyId)
		->where('currency',$currencyName)
		->get()->pluck(self::CLIENT_ID_COLUMN_NAME,self::CLIENT_ID_COLUMN_NAME)->toArray();
	}
	
	public static function getTotalInvoicesPlusVatAmountUntilDate( string $currencyName, int $partnerId,string $startDate , string $endDate):float
	{
		
		return DB::table(self::TABLE_NAME)
		->where('company_id',getCurrentCompanyId())
		->where(self::CLIENT_ID_COLUMN_NAME,$partnerId)
		->where('currency',$currencyName)
		->whereBetween('invoice_date',[$startDate,$endDate])
		->sum(DB::raw( 'invoice_amount + vat_amount - total_deductions'));

	}
	public static function getForPartner(int $partnerId,string $currencyName,$isMainCurrency):array 
	{
		return self::where(self::CLIENT_ID_COLUMN_NAME,$partnerId)
		
		->when(!$isMainCurrency,function($q) use ($currencyName){
			$q->where('currency',$currencyName)
		;})
		->pluck('id','id')->toArray();
	}
	public function dueDateHistories()
	{
		return $this->hasMany(DueDateHistory::class,'model_id','id')->where('model_type',getModelNameWithoutNamespace($this));
	}

	public static function getBeginningBalanceUntil( string $currencyName, int $partnerId,string $startDate ,string $endDate)
	{
		$totalInvoicesPlusVatAmount  = self::getTotalInvoicesPlusVatAmountUntilDate($currencyName,$partnerId,$startDate,$endDate);
		$totalMoneyReceivedAmountPlusWithhold = self::getTotalMoneyAmountPlusWithhold($currencyName,$partnerId,$startDate  , $endDate);

		return $totalInvoicesPlusVatAmount - $totalMoneyReceivedAmountPlusWithhold;
	}
	public static function getTotalMoneyAmountPlusWithhold( string $currencyName, int $partnerId,string $startDate , string $endDate)
	{

		$fullMoneyModelName = '\App\Models\\'.self::MONEY_MODEL_NAME;
		$moneyReceivedOrPayments = $fullMoneyModelName::where('company_id',getCurrentCompanyId())
		->where('partner_id',$partnerId)
		->where('currency',$currencyName)
		->where('opening_balance_id',null)
		->with(['settlements.invoice'])
		->whereBetween(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,[$startDate,$endDate])->get() ;
		$totalSettlementAmounts = 0 ;
		$totalSettlementWithholdAmounts = 0 ;
		foreach($moneyReceivedOrPayments as $moneyReceivedOrPayment){
			foreach($moneyReceivedOrPayment->settlements as $settlement){
				$totalSettlementAmounts += $settlement->settlement_amount ;
				$totalSettlementWithholdAmounts += $settlement->withhold_amount ;
			}
		}
		return $totalSettlementAmounts + $totalSettlementWithholdAmounts ;
		
		
		return DB::table(self::MONEY_RECEIVED_OR_PAYMENT_TABLE_NAME)
		->where('company_id',getCurrentCompanyId())
		->where('partner_id',$partnerId)
		->where('currency',$currencyName)
		->where('opening_balance_id',null)
		->whereBetween(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,[$startDate,$endDate]);
		
		// ->sum(DB::raw('total_withhold_amount + '.self::RECEIVED_OR_PAYMENT_AMOUNT));
	}
	
	public function deductions()
	{
		return $this->belongsToMany(Deduction::class,'invoice_deductions','invoice_id','deduction_id')->where('invoice_type',getModelNameWithoutNamespace($this))
		->withPivot([
			'invoice_id',
			'invoice_type',
			'amount',
			'date'
		])
		;
	}
	public function calculateCollectedOrPaidAmountInEditMode(bool $inEditMode,$collectedOrPaidAmount , $settlementAmount )
	{
		if(!$inEditMode){
			return $collectedOrPaidAmount;
		}
		return $collectedOrPaidAmount - $settlementAmount ;
	}
	public function getCollectedOrPaidInEditModeForDownPayment($inEditMode,$totalSettlementAmount)
	{
		$collectedOrPaidAmount= $this->getCollectedOrPaidAmount();
		return $this->calculateCollectedOrPaidAmountInEditMode($inEditMode,$collectedOrPaidAmount,$totalSettlementAmount);
	}
	public function calculateNetBalanceInEditMode(bool $inEditMode , $totalSettlementAmount,$totalWithholdAmount )
	{
		$netBalance = $this->getNetBalance();
		if(!$inEditMode){
			return $netBalance;
		}
		return $netBalance + $totalSettlementAmount +  $totalWithholdAmount ;
	}
	public function getNetBalanceInEditModeForDownPayment($inEditMode,$downPayment,$isDownPaymentFromMoneyModel)
	{
		
		
	
		$inEditMode = !is_null($downPayment);
		$totalSettlements = $downPayment ? $downPayment->sumSettlementsForInvoice($this->id,$this->getPartnerId(),$isDownPaymentFromMoneyModel) : 0 ;
		return $this->calculateNetBalanceInEditMode($inEditMode,$netBalance , $settlementAmount , $withholdAmount);
	}
	
	public function getCollectedOrPaidAmount()
	{
		if($this instanceof CustomerInvoice){
			return $this->collected_amount ;
		}
		if($this instanceof SupplierInvoice){
			return $this->paid_amount ;
		}
		throw new \Exception('Custom Exception .. Not Allowed Money Type');
	}
	public static function getInvoicesForInvoiceStartAndEndDate(string $clientIdColumnName,int $partnerId,Company $company , string $currency , string $startDate , string $endDate)
	{
		return self::where('company_id', $company->id)
		->when($currency != 'main_currency',function($query)use($currency){
			$query->where('currency', $currency);
		})
        ->whereBetween('invoice_date', [$startDate, $endDate])
        ->where($clientIdColumnName, '=', $partnerId)->get();
	}

}
