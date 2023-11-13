<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ExportTable;
use App\Models\Company;
use App\Models\SalesGathering;
use App\ReadyFunctions\InvoiceAgingService;
use App\Traits\GeneralFunctions;
use App\Traits\Intervals;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerBalancesController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
		$businessUnits = DB::table('customer_invoices')->where('company_id',$company->id)
		->selectRaw('business_unit')->get()->pluck('business_unit')->unique()->values()->toArray();
		
        return view('admin.reports.customer_balances_form', compact('company','businessUnits'));
    }
	public function result(Company $company , Request $request){
		
		$aginDate = $request->get('again_date');
		$customerNames = $request->get('customers');
		$invoiceAgingService = new InvoiceAgingService($company->id ,$aginDate);
		$customerAgings  = $invoiceAgingService->__execute($customerNames) ;
		$weeksDates = formatWeeksDatesFromStartDate($aginDate);
		return view('admin.reports.customer-invoices-aging',['customerAgings'=>$customerAgings,'aginDate'=>$aginDate,'weeksDates'=>$weeksDates]);
	}
	public function getCustomersFromSalesPersons(Company $company ,Request $request)
	{
		$businessUnits = $request->get('salesPersons',[]);
	// dd($businessUnits);
		$data = DB::table('customer_invoices')->select('customer_name')->whereIn('business_unit',$businessUnits)
		->where('net_balance','>',0)
		->where('company_id',$company->id)->get();
		$data = $data->unique();
		return response()->json([
			'status'=>true ,
			'message'=>__('Success'),
			'data'=>[
				'customer_names'=>$data
			]
		]);
		
	}


}
