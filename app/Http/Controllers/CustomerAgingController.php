<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CustomerInvoice;
use App\ReadyFunctions\InvoiceAgingService;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * * هي اسمها اعمار الديون
 * * هو عباره عن الفواتير اللي لسه مفتوحة ( اعمار الديون) .. سواء الدين لسه جايه او المتاخر او حق اليوم
 * * وبالتالي بمجرد ما تندفع مش بتيجي هنا (لو النت بلانس اكبر من صفر يبقي لسه ما استدتش كاملا)
 */
class CustomerAgingController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
		$exportables = getExportableFieldsForModel($company->id,'CustomerInvoice') ; 
		$salesPersons = [];
		$businessUnits = [];
		$businessSectors = [];
		if(isset($exportables['business_unit'])){
			$businessUnits = DB::table('customer_invoices')
			->where('company_id',$company->id)->where('business_unit','!=',null)
			->where('business_unit','!=',null)
			->where('business_unit','!=','')
			->selectRaw('business_unit')->get()->pluck('business_unit')->unique()->values()->toArray();
		}
		if(isset($exportables['sales_person'])){
			$salesPersons = DB::table('customer_invoices')->where('company_id',$company->id)->where('sales_person','!=',null)->where('sales_person','!=','')
			->selectRaw('sales_person')->get()->pluck('sales_person')->unique()->values()->toArray();
		}
		if(isset($exportables['business_sector'])){
			$businessSectors = DB::table('customer_invoices')->where('company_id',$company->id)->where('business_sector','!=',null)->where('business_sector','!=','')
			->selectRaw('business_sector')->get()->pluck('business_sector')->unique()->values()->toArray();
		}
	
		$currencies = DB::table('customer_invoices')
		
		->where('company_id',$company->id)->where('currency','!=',null)->where('currency','!=','')
		->selectRaw('currency')->get()->pluck('currency')->unique()->values()->toArray();
	
		
		$customerInvoices = CustomerInvoice::where('customer_name','!=',null)->where('customer_name','!=','')->onlyCompany($company->id)->get();
        return view('reports.customer_aging_form', [
			'businessUnits'=>$businessUnits,
			'company'=>$company,
			'customerInvoices'=>$customerInvoices ,
			'salesPersons'=>$salesPersons,
			'businessSectors'=>$businessSectors,
			'currencies'=>$currencies
		]);
    }
	public function result(Company $company , Request $request){
		
		$aginDate = $request->get('again_date');
		$customerNames = $request->get('customers');
		$invoiceAgingService = new InvoiceAgingService($company->id ,$aginDate);
		$customerAgings  = $invoiceAgingService->__execute($customerNames) ;
		$weeksDates = formatWeeksDatesFromStartDate($aginDate);
		return view('admin.reports.customer-invoices-aging',['customerAgings'=>$customerAgings,'aginDate'=>$aginDate,'weeksDates'=>$weeksDates]);
	}

	public function getCustomersFromBusinessUnitsAndCurrencies(Company $company ,Request $request)
	{
		$currency = $request->get('currencies');
		$businessUnits = $request->get('business_units',[]);
		$salesPersons = $request->get('sales_persons',[]);
		$businessSectors = $request->get('business_sectors',[]);
		$query = DB::table('customer_invoices')->select('customer_name','currency')->where('currency',$currency)->where('company_id',$company->id)->where('net_balance','>',0);
		if(count($businessUnits)){
			$query = $query->whereIn('business_unit',$businessUnits);
		}
		if(count($salesPersons)){
			$query = $query->whereIn('sales_person',$salesPersons);
		}
		if(count($businessSectors)){
			$query = $query->whereIn('business_sector',$businessSectors);
		}

		$data = $query->get();
		/**
		 * @var Collection $data ;
		 */
		$customers = $data->unique('customer_name')->pluck('customer_name');
		$currencies = $data->unique('currency')->pluck('currency');
		return response()->json([
			'status'=>true ,
			'message'=>__('Success'),
			'data'=>[
				'customer_names'=>$customers,
				'currencies_names'=>$currencies,
			]
		]);
		
	}


}
