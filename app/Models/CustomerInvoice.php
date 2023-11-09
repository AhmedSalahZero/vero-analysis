<?php

namespace App\Models;

use App\Traits\StaticBoot;
use Carbon\Carbon;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
    public function getNetBalanceAttribute()
    {
		$netInvoice = $this->net_invoice_amount ?: 0 ;
		$collected = $this->collected_amount  ?: 0;
        return $netInvoice - $collected ;
    }
    public function getNetBalance()
    {
        return $this->net_balance ;
    }
    public function getCollectedAmountAttribute($val)
    {
        return $val ;
    }
    public function getName()
    {
        return $this->customer_name ;
    }
    
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
        return $this->net_invoice_amount;
    }
    
    protected function generateInvoiceStatus($totalCollected, $netInvoiceAmount)
    {
        $invoiceDueDate = Carbon::make($this->getInvoiceDueDate());
        $nowAsDate = Carbon::make(now()->setTime(0, 0)->format('d-m-Y'));
        if($totalCollected == $netInvoiceAmount) {
            return 'collected';
        }
        if($totalCollected > 0 &&  $invoiceDueDate->lessThan($nowAsDate)) {
            return 'partially_collected_and_past_due';
        }
        if($invoiceDueDate->greaterThan($nowAsDate)) {
            return 'not_due_yet';
        }
        if($invoiceDueDate->equalTo($nowAsDate)) {
            return 'due_to_day';
        }
        if($invoiceDueDate->lessThan($nowAsDate) && $totalCollected == 0) {
            return 'past_due';
        }
    }
    public function getInvoiceDueDate()
    {
        return $this->invoice_due_date ;
    }
    
    public function getInvoiceNumber()
    {
        return $this->invoice_number ;
    }
    public function getInvoicesForCustomerName(string $customerName)
    {
        return self::where('customer_name', $customerName)->get() ;
    }

    
    public function syncNetBalance()
    {
        $customerName =	$this->getCustomerName();
        $invoices = $this->getInvoicesForCustomerName($customerName);
        foreach($invoices as $customerInvoice) {
            $invoiceNumber  = $customerInvoice->getInvoiceNumber($customerName) ;
            $totalCollected = 0 ;
            foreach($customerInvoice->moneyReceived as $moneyReceived) {
                foreach($moneyReceived->getSettlementsForInvoiceNumber($invoiceNumber, $customerName)  as $settlement) {
                    $totalCollected += $settlement->getAmount();
                }
            }
            $customerInvoice->updateNetBalance($totalCollected);
        }
        
    }
    
    protected function updateNetBalance(float $totalCollected)
    {
        $netInvoiceAmount = $this->getNetInvoiceAmount();
        $this->net_balance = $netInvoiceAmount - $totalCollected ;
        $this->invoice_status = $this->generateInvoiceStatus($totalCollected, $netInvoiceAmount) ;
        $this->collected_amount = $totalCollected;
        $this->save();
    }
	public function getNetBalanceUntil(string $date)
	{
		$invoiceNumber = $this->getInvoiceNumber();
		$customerName = $this->getCustomerName();
		$netInvoiceAmount = $this->getNetInvoiceAmount();
		$totalCollected = 0 ;
		// dump($this);
		$moneyReceives = $this->moneyReceived->where('receiving_date','<=',$date) ;
		foreach($moneyReceives as $moneyReceived) {
			foreach($moneyReceived->getSettlementsForInvoiceNumber($invoiceNumber, $customerName)  as $settlement) {
				$totalCollected += $settlement->getAmount();
			}
		}
		// dump($netInvoiceAmount - $totalCollected);
		return $netInvoiceAmount - $totalCollected;
	}

}
