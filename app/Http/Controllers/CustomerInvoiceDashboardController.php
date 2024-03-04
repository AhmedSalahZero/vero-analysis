<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\Partner;
use Illuminate\Http\Request;

class CustomerInvoiceDashboardController extends Controller
{
    public function viewCashDashboard(Company $company , Request $request ){
		return view('admin.dashboard.cash',['company'=>$company]);
	} 
	public function viewForecastDashboard(Company $company , Request $request ){
		return view('admin.dashboard.forecast',['company'=>$company]);
	}
	public function showInvoiceReport(Company $company , Request $request , int  $partnerId,string $currency){
		$invoices = CustomerInvoice::where('company_id',$company->id)
		->where('customer_id',$partnerId)
		->where('currency',$currency)
		->get();
		$customer = Partner::find($partnerId);
		if(!count($invoices)){
			return  redirect()->back()->with('fail',__('No Data Found'));
		}

		return view('admin.reports.invoice-report',[
			'invoices'=>$invoices,
			'partnerName'=>$customer->getName(),
			'partnerId'=>$customer->getId() ,
			'currency'=>$currency
		]);
	}	
	
	public function showCustomerInvoiceStatementReport(Company $company , Request $request , int $partnerId,string $currency){
		$startDate= $request->get('start_date',now()->subMonths(4)->format('Y-m-d'));
		$endDate  = $request->get('end_date',now()->format('Y-m-d'));
		$invoices = CustomerInvoice::where('company_id',$company->id)
		->where('currency',$currency)
		->whereBetween('invoice_date',[$startDate , $endDate ])
		->where('customer_id','=',$partnerId)->get();
		$partner = Partner::find($partnerId);
		$partnerName = $partner->getName() ;
		$invoicesWithItsReceivedMoney = CustomerInvoice::formatForStatementReport($invoices,$partnerName,$startDate,$endDate,$currency);
		if(count($invoicesWithItsReceivedMoney) <= 1){
			return  redirect()->back()->with('fail',__('No Data Found'));
		}
		return view('admin.reports.customer-statement-report',[
			'invoicesWithItsReceivedMoney'=>$invoicesWithItsReceivedMoney,
			'partnerName'=>$partnerName,
			'partnerId'=>$partnerId,
			'currency'=>$currency ,
			'startDate'=>$startDate ,
			'endDate'=>$endDate
		]);
	}
	
	
}
