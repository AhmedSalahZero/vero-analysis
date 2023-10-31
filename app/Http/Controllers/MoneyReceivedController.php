<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ExportTable;
use App\Models\Bank;
use App\Models\Company;
use App\Models\CustomerDueCollectionAnalysis;
use App\Models\SalesGathering;
use App\ReadyFunctions\InvoiceAgingService;
use App\Services\Caching\CustomerDashboardCashing;
use App\Traits\GeneralFunctions;
use App\Traits\Intervals;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoneyReceivedController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
		// $customerNames = DB::table('customer_due_collection_analysis')->where('company_id',$company->id)
		// ->selectRaw('customer_name')->get()->pluck('customer_name')->unique()->values()->toArray();
		
        return view('reports.moneyReceived.index', compact('company'));
    }
	
	public function create()
	{
		// $customerNames = DB::table('customer_due_collection_analysis')->where('company_id',$company->id)
		// ->selectRaw('customer_name')->get()->pluck('customer_name')->unique()->values()->toArray();
		$banks = Bank::pluck('name_en','view_name');
		$customers = CustomerDueCollectionAnalysis::pluck('customer_name','id')->unique()->toArray(); 
		// dd();
        return view('reports.moneyReceived.form',[
			'banks'=>$banks,
			'customers'=>$customers 
		]);
    }
	
	public function result(Company $company , Request $request){
		
		return view('reports.moneyReceived.form',[
		]);
	}
	public function getInvoiceNumber(Company $company ,  Request $request , int $customerId)
	{
		$customer = CustomerDueCollectionAnalysis::find($customerId);
		$invoices = CustomerDueCollectionAnalysis::where('customer_name',$customer->customer_name)->where('company_id',$company->id)
		->where('net_invoice_amount','>',0)
		->orderBy('invoice_date','asc')
		->get(['invoice_number','invoice_date','net_invoice_amount'])
		->toArray();
		$invoices = $this->formatInvoices($invoices);
			return response()->json([
				'status'=>true , 
				'invoices'=>$invoices
			]);
		
	}
	protected function formatInvoices(array $invoices){
		$result = [];
		foreach($invoices as $index=>$invoiceArr){
			$result[$index]['invoice_number'] = $invoiceArr['invoice_number'];
			$result[$index]['net_invoice_amount'] = $invoiceArr['net_invoice_amount'];
			$result[$index]['net_invoice_amount'] = $invoiceArr['net_invoice_amount'];
			$result[$index]['invoice_date'] = Carbon::make($invoiceArr['invoice_date'])->format('d-m-Y');
		}
		return $result;
	}
}
