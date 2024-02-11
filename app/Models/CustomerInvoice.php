<?php

namespace App\Models;

use App\Helpers\HArr;
use App\Traits\StaticBoot;
use Carbon\Carbon;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CustomerInvoice extends Model
{
    use StaticBoot;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    
    protected $dates = [
       'invoice_date'
    ];
	
	

    protected $guarded = [];


    //  protected $connection= 'mysql2';
    // protected $table = 'sales_gathering';
    // protected $primaryKey  = 'user_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public function scopeCompany($query)
    {
        return $query->where('company_id', request()->company->id?? Request('company_id'));
    }
    private static function generateSubTabArr()
    {
        return [];
    }
    public static function getTabs(int $companyId)
    {
        return [
            'exportAnalysis'=>[
                'view_name'=>__('Export Analysis'),
                'icon'=>'fa fa-crosshairs',
                'subTabs'=>[
                    [
                        'first_col'=>$firstColumn ='customer_name',
                        'second_col'=>$secondColumn = 'product_item',
                        'view_name'=>__('Customer Name Against Product Item'),
                        'route'=>route('view.export.against.report', [$companyId,$firstColumn,$secondColumn])
                    ],[
                        'first_col'=>$firstColumn ='product_item',
                        'second_col'=>$secondColumn = 'customer_name',
                        'view_name'=>__('Product Item Against Customer Name'),
                        'route'=>route('view.export.against.report', [$companyId,$firstColumn,$secondColumn])
                    ],
                    [
                        'first_col'=>$firstColumn='shipping_line',
                        'second_col'=>$secondColumn = 'destination_country',
                        'view_name'=>__('Shipping Line Against Destination Country'),
                        'route'=>route('view.export.against.report', [$companyId,$firstColumn,$secondColumn]),
                    ],
                    [
                        'first_col'=>$firstColumn='destination_country',
                        'second_col'=>$secondColumn = 'shipping_line',
                        'view_name'=>__('Destination Country Against Shipping Line'),
                        'route'=>route('view.export.against.report', [$companyId,$firstColumn,$secondColumn]),
                    ],
                    [
                        'first_col'=>$firstColumn='customer_name',
                        'second_col'=>$secondColumn = 'estimated_time_of_arrival',
                        'view_name'=>__('Customers’ Orders Against Estimated Arrival Date'),
                        'route'=>route('view.export.against.report', [$companyId,$firstColumn,$secondColumn]),
                    ],
                    [
                        'first_col'=>$firstColumn='customer_name',
                        'second_col'=>$secondColumn = 'purchase_order_status',
                        'view_name'=>__('Customers’ Orders Against Purchase Order Status'),
                        'route'=>route('view.export.against.report', [$companyId,$firstColumn,$secondColumn]),
                    ],
                    [
                        'first_col'=>$firstColumn='purchase_order_status',
                        'second_col'=>$secondColumn = 'customer_name',
                        'view_name'=>__('Purchase Order Status Against Customers’ Orders'),
                        'route'=>route('view.export.against.report', [$companyId,$firstColumn,$secondColumn]),
                    ],
                    [
                        'first_col'=>$firstColumn='payment_terms',
                        'second_col'=>$secondColumn = 'customer_name',
                        'view_name'=>__('Collection Terms Against Customers'),
                        'route'=>route('view.export.against.report', [$companyId,$firstColumn,$secondColumn]),
                    ],[
                        'first_col'=>$firstColumn='business_unit',
                        'second_col'=>$secondColumn = 'revenue_stream',
                        'view_name'=>__('Business Unit Against Revenue Stream'),
                        'route'=>route('view.export.against.report', [$companyId,$firstColumn,$secondColumn]),
                    ],[
                        'first_col'=>$firstColumn='export_bank',
                        'second_col'=>$secondColumn = 'customer_name',
                        'view_name'=>__('Export Bank Against Customer Name'),
                        'route'=>route('view.export.against.report', [$companyId,$firstColumn,$secondColumn]),
                    ],
                ]
                ],
                
        ];
    }
    // public function getNetBalanceAttribute()
    // {
	// 	$netInvoice = $this->net_invoice_amount ?: 0 ;
	// 	$collected = $this->collected_amount  ?: 0;
    //     return $netInvoice - $collected ;
    // }
    public function getNetBalance()
    {
		// if($this->invoice_number == 202015){
		// 	dd($this->net_balance);
		// }
        return $this->net_balance ?: 0 ;
    }
	public function getNetBalanceFormatted()
	{
		return number_format($this->getNetBalance(),0);
	}
    public function getCollectedAmountAttribute($val)
    {
        return $val ;
    }
    public function getName()
    {
        return $this->customer_name ;
    }
    
	// do not use this directly use 
    public function moneyReceived()
    {
        return $this->hasMany(MoneyReceived::class, 'customer_name', 'customer_name')->where('company_id',getCurrentCompanyId());
    }
    
    public function getRemainingChequeAmount():float
    {
        $customerName =	$this->getCustomerName();
        $invoices = $this->getInvoicesForCustomerName($customerName);
        $totalInvoiceAmount = 0;
        foreach($invoices as $customerInvoice) {
            $totalInvoiceAmount += $customerInvoice->getNetInvoiceAmount();
        }
        return $totalInvoiceAmount;
    }
    public function getCustomerName()
    {
        return $this->customer_name ;
    }
    public function getNetInvoiceAmount()
    {
		$netInvoiceAmount = $this->net_invoice_amount ?:0 ; 
        return  $netInvoiceAmount + $this->getVatAmount();
    }
	public function getNetInvoiceInMainCurrencyAmount()
    {
		$netInvoiceAmount = $this->net_invoice_amount_in_main_currency ?:0 ; 
        return  $netInvoiceAmount + $this->getVatAmount();
    }
	public function getNetInvoiceAmountFormatted()
	{
		return number_format($this->getNetInvoiceAmount());
	}

    
    // protected function generateInvoiceStatus($totalCollected, $netInvoiceAmount)
    // {
    //     $invoiceDueDate = Carbon::make($this->getInvoiceDueDate());
    //     $nowAsDate = Carbon::make(now()->setTime(0, 0)->format('d-m-Y'));
	// 	$totalCollected += $this->withhold_amount;
    //     if($totalCollected == $netInvoiceAmount) {
    //         return 'collected';
    //     }
    //     if($totalCollected > 0 &&  $invoiceDueDate->lessThan($nowAsDate)) {
    //         return 'partially_collected_and_past_due';
    //     }
    //     if($invoiceDueDate->greaterThan($nowAsDate)) {
    //         return 'not_due_yet';
    //     }
    //     if($invoiceDueDate->equalTo($nowAsDate)) {
    //         return 'due_to_day';
    //     }
    //     if($invoiceDueDate->lessThan($nowAsDate) && $totalCollected == 0) {
    //         return 'past_due';
    //     }
    // }
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
		return $this->invoice_date->format('Y-m-d');
	}
	public function getInvoiceDateFormatted()
	{
		return $this->invoice_date ? Carbon::make($this->invoice_date)->format('d-m-Y') : null ; 
	}
    public function getInvoiceNumber()
    {
        return $this->invoice_number ;
    }
    public function getInvoicesForCustomerName(string $customerName)
    {
        return self::where('customer_name', $customerName)->get() ;
    }

    
    // public function syncNetBalance()
    // {
    //     $customerName =	$this->getCustomerName();
    //     $invoices = $this->getInvoicesForCustomerName($customerName);
    //     foreach($invoices as $customerInvoice) {
    //         $invoiceNumber  = $customerInvoice->getInvoiceNumber($customerName) ;
    //         $totalCollected = 0 ;
	// 		$totalWithhold = 0 ;
    //         foreach($customerInvoice->moneyReceived as $moneyReceived) {
    //             foreach($moneyReceived->getSettlementsForInvoiceNumber($invoiceNumber, $customerName)  as $settlement) {
    //                 $totalCollected += $settlement->getAmount();
    //                 $totalWithhold += $settlement->getWithhold();
    //             }
    //         }
    //         $customerInvoice->updateNetBalance($totalCollected,$totalWithhold);
    //     }
        
    // }
	// public function insertInvoiceDateMonthAndYearColumnsInDB()
	// {
	// 	$this->invoice_month = sprintf("%02d", explode('-',$this->invoice_date)[1]);	
	// 	$this->invoice_year = explode('-',$this->invoice_date)[0];	
	// 	$this->save();
	// }
	public function getVatAmount()
	{
		return $this->vat_amount ?: 0 ;
	}
	// public function calculateAmountInMainCurrency()
	// {
	// 	$this->invoice_amount_in_main_currency = $this->invoice_amount * $this->exchange_rate ; 	
	// 	$this->vat_amount_in_main_currency = $this->vat_amount * $this->exchange_rate ; 	
	// 	$this->net_invoice_amount_in_main_currency = $this->net_invoice_amount * $this->exchange_rate ; 	
	// 	$this->save();
	// }
    // protected function updateNetBalance(float $totalCollected,float $totalWithholdAmount)
    // {
    //     $netInvoiceAmount = $this->getNetInvoiceAmount();
    //     $this->net_balance = $netInvoiceAmount - $totalCollected ;
    //     $this->invoice_status = $this->generateInvoiceStatus($totalCollected, $netInvoiceAmount) ;
    //     $this->collected_amount = $totalCollected;
    //     $this->withhold_amount = $totalWithholdAmount;
    //     $this->save();
    // }
	public function getStatus()
	{
		return $this->invoice_status;
	}
	public function getStatusFormatted()
	{
		return snakeToCamel($this->getStatus());
	}
	
	public function getDebitsDataFormattedArr():array
	{
		return [
			'beginning_balance'=> 0 ,
			'monthly_debit'=>$this->getNetInvoiceAmount(),
			'monthly_credit'=> 0 ,
			'end_balance'=> $this->getNetInvoiceAmount() 
		];
	}
	public function monthlyCustomerInvoices()
	{
		return $this->hasMany(MonthlyCustomerInvoices::class , 'customer_name','customer_name');
	}
	public function getInvoiceDateMonth():int
	{
		return sprintf("%02d", $this->invoice_month) ;
	}
	public function getInvoiceDateYear()
	{
		return $this->invoice_year ;
	}
	public function getInvoiceDateMonthAndYearFormatted()
	{
		return $this->getInvoiceDateMonth() .'-'.$this->getInvoiceDateYear();
	}
	public function monthlyCustomerInvoiceByMonthAndYear():?MonthlyCustomerInvoices{
		$month = $this->getInvoiceDateMonth();
		$year = $this->getInvoiceDateYear();
		return $this->monthlyCustomerInvoices()->where('is_closed',0)->where('month',$month)->where('year',$year)->first() ;
	}
	public static function getOnlyNotClosedPeriods()
	{
		return self::where('company_id',getCurrentCompanyId())->where('is_period_closed',0)->get()->unique(function($item){return $item['invoice_month'] .'-'.$item['invoice_year'];})->values()->toArray();
	}
	public function getAging(){
		if($this->getStatus() == 'collected'){
			return '-';
		}
		return now()->diffInDays(Carbon::make($this->getInvoiceDate()));
		
	}
	
	public function getNetBalanceUntil(string $date)
	{
		$invoiceNumber = $this->getInvoiceNumber();
		$customerName = $this->getCustomerName();
		$netInvoiceAmount = $this->getNetInvoiceAmount();
		$totalCollected = 0 ;
		$moneyReceives = $this->moneyReceived->where('receiving_date','<=',$date) ;
		foreach($moneyReceives as $moneyReceived) {
			foreach($moneyReceived->getSettlementsForInvoiceNumber($invoiceNumber, $customerName)  as $settlement) {
				$totalCollected += $settlement->getAmount();
			}
		}
		// dump($netInvoiceAmount - $totalCollected);
		return $netInvoiceAmount - $totalCollected;
	}
	

	public static function getBeginningBalanceUntil( string $currencyName, string $customerName,string $date)
	{
		$totalInvoicesPlusVatAmount  = self::getTotalInvoicesPlusVatAmountUntilDate($currencyName,$customerName,$date);
		$totalMoneyReceivedAmountPlusWithhold = self::getTotalMoneyReceivedAmountPlusWithhold($currencyName,$customerName,$date);
		return $totalInvoicesPlusVatAmount - $totalMoneyReceivedAmountPlusWithhold;
		
	}
	
	public static function getTotalInvoicesPlusVatAmountUntilDate( string $currencyName, string $customerName,string $date):float
	{
		return DB::table('customer_invoices')
		->where('company_id',getCurrentCompanyId())
		->where('customer_name',$customerName)
		->where('currency',$currencyName)
		->where('invoice_date','<=',$date)
		->sum(DB::raw('invoice_amount + vat_amount'));

	}
	public static function getTotalMoneyReceivedAmountPlusWithhold( string $currencyName, string $customerName,string $date)
	{
		
		return DB::table('money_received')
		->where('company_id',getCurrentCompanyId())
		->where('customer_name',$customerName)
		->where('currency',$currencyName)
		->where('receiving_date','<=',$date)
		->sum(DB::raw('total_withhold_amount + received_amount'));
				
		
		// return Settlement::where('company_id',getCurrentCompany())
		// ->where('customer_name',$customerName)
		// ->where('currency',$currencyName)
		// ->where('invoice_date','<=',$date)
		// ->sum(function($e){
		// 	dd('good',$e);
		// });
		

	}
	
	
	public static function formatForStatementReport(Collection $customerInvoices,string $customerName,string $startDate,string $endDate,string $currency){
			$startDateFormatted = Carbon::make($startDate)->format('d-m-Y');
			$index = -1 ;
			
			// 
			$firstCustomerInvoice = $customerInvoices->first() ?: null; 
			$oneDayBeforeStartDate = Carbon::make($startDate)->subDay()->format('Y-m-d');
			// dd(CustomerInvoice::getBeginningBalanceUntil($currency,$customerName,$oneDayBeforeStartDate));
			// dd($oneDayBeforeStartDate);
			$beginningBalance = $firstCustomerInvoice ? $customerInvoices->first()->getBeginningBalanceUntil($currency,$customerName,$oneDayBeforeStartDate) : 0; 
			$formattedData = [];
			$currentData['date'] = $startDateFormatted;
			$currentData['document_type'] = 'Beginning Balance';
			$currentData['document_no'] = null;
			$currentData['debit'] = $debit = $beginningBalance >= 0 ? $beginningBalance : 0;
			$currentData['credit'] = $credit = $beginningBalance < 0 ? $beginningBalance * -1 : 0 ;
			$currentData['end_balance'] =$debit - $credit;
			$currentData['comment'] =null;
			// $currentData['comment'] =__('Debit - Credit');
			$index++ ;
			$formattedData[$index] = $currentData;
			
			$allMoneyReceived =  MoneyReceived::
			where('company_id',getCurrentCompanyId())
			->whereBetween('receiving_date',[$startDate,$endDate])
			->where('currency',$currency)
			->where('customer_name',$customerName)
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
		// dd($allMoneyReceived);
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
					$currentData['comment'] =null ;
					$index++;
					$formattedData[] = $currentData ;
					
					if($totalWithholdAmount = $moneyReceived->getTotalWithholdAmount()){
						
						
						$currentData = []; 
					$currentData['date'] = $dateReceiving;
					$currentData['document_type'] = __('Withhold Taxes');
					$currentData['document_no'] =  $docNumber ;
					$currentData['debit'] = 0;
					$currentData['credit'] =$totalWithholdAmount;
					//$currentData['end_balance'] =$formattedData[$index]['end_balance'] + $formattedData[$index]['debit'] - $formattedData[$index]['credit'];
					$currentData['comment'] =$bankName;
					$currentData['comment'] =__('Withhold Taxes For Invoice No.') . ' ' . $docNumber;
					$index++;
					$formattedData[] = $currentData ;
							
					}
					
					
				}
				
			// }
		}
		
		return HArr::sortBasedOnKey($formattedData,'date');
		// return $formattedData;
		// dd($formattedData);
	}
	

	
}
