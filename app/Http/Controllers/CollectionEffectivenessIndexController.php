<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Partner;
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
class CollectionEffectivenessIndexController
{
    use GeneralFunctions;
    public function index(Company $company,Request $request)
	{
		$defaultStartDate = now()->subMonths(12);
		$defaultEndDate = now();
		$modelType = in_array('collection',$request->segments()) ? 'CustomerInvoice' : 'SupplierInvoice' ;
		$fullClassName = ('\App\Models\\'.$modelType) ;
		$customersOrSupplierText = (new $fullClassName)->getClientDisplayName();
		$title = (new $fullClassName)->getEffectivenessTitle();
		$clientNameColumnName = $fullClassName::CLIENT_NAME_COLUMN_NAME ;
		$invoiceTableName = getUploadParamsFromType($modelType)['dbName'];
		$exportables = getExportableFieldsForModel($company->id,$modelType) ; 
		$salesPersons = [];
		$businessUnits = [];
		$businessSectors = [];
		if(isset($exportables['business_unit'])){
			$businessUnits = DB::table('cash_vero_business_units')->where('company_id',$company->id)->pluck('name')->toArray();
		}
		if(isset($exportables['sales_person'])){
			$salesPersons = DB::table('cash_vero_sales_persons')->where('company_id',$company->id)->pluck('name')->toArray();
		}
		if(isset($exportables['business_sector'])){
			$businessSectors = DB::table('cash_vero_business_sectors')->where('company_id',$company->id)->pluck('name')->toArray();
		}
		$currencies = DB::table($invoiceTableName)
		
		->where('company_id',$company->id)->where('currency','!=',null)->where('currency','!=','')
		->selectRaw('currency')->get()->pluck('currency')->unique()->values()->toArray();
		
		$invoices = ('\App\Models\\'.$modelType)::where($clientNameColumnName,'!=',null)->where($clientNameColumnName,'!=','')->onlyCompany($company->id)->get();
		$invoices = $invoices->unique('customer_name')->values() ;
        return view('admin.reports.collection-effectiveness-index.form', [
			'businessUnits'=>$businessUnits,
			'company'=>$company,
			'invoices'=>$invoices ,
			'salesPersons'=>$salesPersons,
			'businessSectors'=>$businessSectors,
			'currencies'=>$currencies,
			'customersOrSupplierText'=>$customersOrSupplierText,
			'title'=>$title,
			'modelType'=>$modelType,
			'defaultStartDate'=>$defaultStartDate,
			'defaultEndDate'=>$defaultEndDate
		]);
    }
	public function result(Company $company , Request $request){
		$modelType = $request->get('model_type');
		$fullClassName = ('\App\Models\\'.$modelType) ;
		$companyId =$company->id ;
		$currency = $request->get('currency');
		$reportName = (new $fullClassName)->getEffectivenessText();
		$totalCurrentTotalToBeCollected = 0 ;
		$totalCurrentTotalCollected = 0 ;
		$customerOrSupplierNameText = (new $fullClassName)->getClientNameText();
		$agingResult = (new AgingController)->result($company,$request,$modelType,true);
		$collectionEffectivenessIndexPerCustomer = [];
		foreach($request->get('clients') as $partnerName){
			$currentPartner = Partner::getPartnerFromName($partnerName,$companyId);
			$currentPartnerId = $currentPartner->id; 
			$currentInvoiceStatementReportResult = (new CustomerInvoiceDashboardController())->showCustomerInvoiceStatementReport($company,$request,$currentPartnerId,$currency,$modelType,true);
			if(!count($currentInvoiceStatementReportResult)){
				continue ; 
			}
			
			$currentBeginningBalance = isset($currentInvoiceStatementReportResult) && $currentInvoiceStatementReportResult[0]['debit'] > 0 ? $currentInvoiceStatementReportResult[0]['debit'] : $currentInvoiceStatementReportResult[0]['credit'] * -1;
			
			unset($currentInvoiceStatementReportResult[0]);
			$currentSumOfDebit = array_sum(array_column($currentInvoiceStatementReportResult,'debit'));
			$currentSumOfCredit = array_sum(array_column($currentInvoiceStatementReportResult,'credit'));
			// $currentEndBalance = $currentBeginningBalance + $currentSumOfDebit - $currentSumOfCredit ;
			$currentTotalCollected =  $currentSumOfCredit ;
			$currentComingDues = $agingResult[$partnerName]['coming_due']['total'] ?? 0 ;
			$currentTotalToBeCollected =  $currentBeginningBalance + $currentSumOfDebit - $currentComingDues ;
			$totalCurrentTotalCollected +=$currentTotalCollected;
			$totalCurrentTotalToBeCollected +=$currentTotalToBeCollected;
			$collectionEffectivenessIndexPerCustomer[$partnerName] =$currentTotalToBeCollected ? $currentTotalCollected /$currentTotalToBeCollected *100 :0 ;
			
		}
		$collectionEffectivenessIndexForAllCustomers = $totalCurrentTotalToBeCollected ? $totalCurrentTotalCollected /$totalCurrentTotalToBeCollected *100 :0 ;

		return view('admin.reports.collection-effectiveness-index.result',[
			'collectionEffectivenessIndexPerCustomer'=>$collectionEffectivenessIndexPerCustomer,
			'reportName'=>$reportName,
			'customerOrSupplierNameText'=>$customerOrSupplierNameText,
			'collectionEffectivenessIndexForAllCustomers'=>$collectionEffectivenessIndexForAllCustomers
		]);
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
		$query = DB::table($invoiceTableName)->select($customer_or_supplier_name,'currency')
		->where('currency',$currency)->where('company_id',$company->id)
		->where('net_balance','>',0);
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
		$currencies = DB::table($invoiceTableName)->select($customer_or_supplier_name,'currency')
		->where('company_id',$company->id)
		->where('net_balance','>',0)
		->get()
		->unique('currency')->pluck('currency');
		
	
		
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
