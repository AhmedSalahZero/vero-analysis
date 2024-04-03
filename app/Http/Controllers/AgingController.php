<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
class AgingController
{
    use GeneralFunctions;
    public function index(Company $company,string $modelType)
	{
		$fullClassName = ('\App\Models\\'.$modelType) ;
		$customersOrSupplierText = (new $fullClassName)->getClientDisplayName();
		$title = (new $fullClassName)->getAgingTitle();
		$clientNameColumnName = $fullClassName::CLIENT_NAME_COLUMN_NAME ;
		$invoiceTableName = getUploadParamsFromType($modelType)['dbName'];
		$exportables = getExportableFieldsForModel($company->id,$modelType) ; 
		$salesPersons = [];
		$businessUnits = [];
		$businessSectors = [];
		if(isset($exportables['business_unit'])){
			$businessUnits = DB::table($invoiceTableName)
			->where('company_id',$company->id)->where('business_unit','!=',null)
			->where('business_unit','!=',null)
			->where('business_unit','!=','')
			->selectRaw('business_unit')->get()->pluck('business_unit')->unique()->values()->toArray();
		}
		if(isset($exportables['sales_person'])){
			$salesPersons = DB::table($invoiceTableName)->where('company_id',$company->id)->where('sales_person','!=',null)->where('sales_person','!=','')
			->selectRaw('sales_person')->get()->pluck('sales_person')->unique()->values()->toArray();
		}
		if(isset($exportables['business_sector'])){
			$businessSectors = DB::table($invoiceTableName)->where('company_id',$company->id)->where('business_sector','!=',null)->where('business_sector','!=','')
			->selectRaw('business_sector')->get()->pluck('business_sector')->unique()->values()->toArray();
		}
	
		$currencies = DB::table($invoiceTableName)
		
		->where('company_id',$company->id)->where('currency','!=',null)->where('currency','!=','')
		->selectRaw('currency')->get()->pluck('currency')->unique()->values()->toArray();
		
		$invoices = ('\App\Models\\'.$modelType)::where($clientNameColumnName,'!=',null)->where($clientNameColumnName,'!=','')->onlyCompany($company->id)->get();
		$invoices = $invoices->unique('customer_name')->values() ;
        return view('reports.aging_form', [
			'businessUnits'=>$businessUnits,
			'company'=>$company,
			'invoices'=>$invoices ,
			'salesPersons'=>$salesPersons,
			'businessSectors'=>$businessSectors,
			'currencies'=>$currencies,
			'customersOrSupplierText'=>$customersOrSupplierText,
			'title'=>$title,
			'modelType'=>$modelType
		]);
    }
	public function result(Company $company , Request $request,string $modelType){
		
		$fullClassName = ('\App\Models\\'.$modelType) ;
		$customersOrSupplierAgingText = (new $fullClassName)->getCustomerOrSupplierAgingText();
		
		$aginDate = $request->get('again_date');
		$clientNames = $request->get('clients');
		
		$invoiceAgingService = new InvoiceAgingService($company->id ,$aginDate);
		$agings  = $invoiceAgingService->__execute($clientNames,$modelType) ;
		$weeksDates =formatWeeksDatesFromStartDate($aginDate);
		

		
		return view('admin.reports.invoices-aging',['agings'=>$agings,'aginDate'=>$aginDate,'weeksDates'=>$weeksDates,'customersOrSupplierAgingText'=>$customersOrSupplierAgingText]);
	}

	public function getCustomersFromBusinessUnitsAndCurrencies(Company $company ,Request $request,string $modelType)
	{
		$invoiceTableName = getUploadParamsFromType($modelType)['dbName'];
		$fullClassName = 'App\Models\\'.$modelType ;
		$customer_or_supplier_name=$fullClassName::CLIENT_NAME_COLUMN_NAME;
		$currency = $request->get('currencies');
		$businessUnits = $request->get('business_units',[]);
		$salesPersons = $request->get('sales_persons',[]);
		$businessSectors = $request->get('business_sectors',[]);
		$query = DB::table($invoiceTableName)->select($customer_or_supplier_name,'currency')->where('currency',$currency)->where('company_id',$company->id)->where('net_balance','>',0);
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
		$customers = $data->unique($customer_or_supplier_name)->pluck($customer_or_supplier_name);
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
