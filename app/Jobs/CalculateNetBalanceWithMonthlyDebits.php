<?php

namespace App\Jobs;

use App\Models\CachingCompany;
use App\Models\CustomerInvoice;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CalculateNetBalanceWithMonthlyDebits implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $companyId ;
    private $modelName ;
    
    public function __construct(int $companyId, string $modelName)
    {
        $this->companyId = $companyId ;
        $this->modelName = $modelName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$customersWithItsSmallestDate = [];
		
		// get only new customer invoices
        $customerInvoices = CustomerInvoice::where('company_id', $this->companyId)->where('net_balance', null)->get();
		
        foreach($customerInvoices as $customerInvoice) {
			// $customerName = $customerInvoice->getCustomerName();
			
            // first sync net balance
            // $customerInvoice->syncNetBalance();
			
            // $customerInvoice->insertInvoiceDateMonthAndYearColumnsInDB();
			
			// $customerInvoice->calculateAmountInMainCurrency();
        }
		// foreach($customersWithItsSmallestDate as $customerName => $customerInvoiceArr){
		// 	$customerInvoice = $customerInvoiceArr['customer_invoice'];
		// 	$latestDate = $customerInvoiceArr['invoice_date'];
		// 	$monthlyCustomerInvoices =$customerInvoice->monthlyCustomerInvoices ; 
		// 	if(!count($monthlyCustomerInvoices)){
		// 		$currentYear = explode('-',$latestDate)[0];
		// 		$currentMonth = explode('-',$latestDate)[1];
		// 		$getEndYearMonthFrom = getEndYearMonthFrom($currentMonth,$currentYear);
		// 		foreach($getEndYearMonthFrom as $month=>$year){
					
		// 		}
		// 	}
			
		// }
    }
	// protected function getLatestArrayWithSmallestDate(array $currentInvoiceArr , string $invoiceDate ):array 
	// {
	// 	$currentInvoiceDate = $currentInvoiceArr['invoice_date'];
	// 	if(Carbon::make($currentInvoiceDate)->greaterThan(Carbon::make($invoiceDate)))
	// 	{
	// 		$currentInvoiceArr['invoice_date'] = $invoiceDate;
	// 	}
	// 	return $currentInvoiceArr ;
		
	// }
	
}
