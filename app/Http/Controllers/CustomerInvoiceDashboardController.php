<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CustomerInvoice;
use Illuminate\Http\Request;

class CustomerInvoiceDashboardController extends Controller
{
    public function viewCashDashboard(Company $company , Request $request ){
		return view('admin.dashboard.cash',['company'=>$company]);
	} 
	public function viewForecastDashboard(Company $company , Request $request ){
		return view('admin.dashboard.forecast',['company'=>$company]);
	}
	public function showInvoiceReport(Company $company , Request $request , string $customerName,string $currency){
		$invoices = CustomerInvoice::where('company_id',$company->id)
		->where('customer_name','=',$customerName)
		->where('currency',$currency)
		->get();
		if(!count($invoices)){
			return  redirect()->back()->with('fail',__('No Data Found'));
		}
		return view('admin.reports.invoice-report',[
			'invoices'=>$invoices,
			'customerName'=>$customerName,
			'currency'=>$currency
		]);
	}	
	
	public function showCustomerInvoiceStatementReport(Company $company , Request $request , string $customerName,string $currency){
		$startDate= $request->get('start_date',now()->subMonths(4)->format('Y-m-d'));
		$endDate  = $request->get('end_date',now()->format('Y-m-d'));
		$invoices = CustomerInvoice::where('company_id',$company->id)
		->where('currency',$currency)
		->whereBetween('invoice_date',[$startDate , $endDate ])
		->where('customer_name','=',$customerName)->get();
		
		$invoicesWithItsReceivedMoney = CustomerInvoice::formatForStatementReport($invoices,$customerName,$startDate,$endDate,$currency);
		if(count($invoicesWithItsReceivedMoney) <= 1){
			return  redirect()->back()->with('fail',__('No Data Found'));
		}
		return view('admin.reports.customer-statement-report',[
			'invoicesWithItsReceivedMoney'=>$invoicesWithItsReceivedMoney,
			'customerName'=>$customerName,
			'currency'=>$currency ,
			'startDate'=>$startDate ,
			'endDate'=>$endDate
		]);
	}
	
	
}
