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

class CustomerAgingController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
		$customerNames = DB::table('customer_due_collection_analysis')->where('company_id',$company->id)
		->selectRaw('customer_name')->get()->pluck('customer_name')->unique()->values()->toArray();
		
        return view('reports.customer_aging_form', compact('company','customerNames'));
    }
	public function result(Company $company , Request $request){
		
		$aginDate = $request->get('again_date');
		$customerNames = $request->get('customers');
		// dd($aginDate);
		$invoiceAgingService = new InvoiceAgingService($company->id ,$aginDate);
		$customerAgings  = $invoiceAgingService->__execute($customerNames) ;
		$weeksDates = formatWeeksDatesFromStartDate($aginDate);
		// dd($customerAgings);
		// dd($customerAgings);
		// if(!count($customerAgings))
		return view('admin.reports.customer-invoices-aging',['customerAgings'=>$customerAgings,'aginDate'=>$aginDate,'weeksDates'=>$weeksDates]);
	}


}
