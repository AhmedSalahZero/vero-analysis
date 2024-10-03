<?php

namespace App\Http\Controllers;

use App\Helpers\HArr;
use App\Helpers\HDate;
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
		$reportType = $request->get('report_type');
		$startDate = $request->get('start_date');
		$endDate = $request->get('end_date');
		
		$currency = $request->get('currency');
		$reportName = (new $fullClassName)->getEffectivenessText();
		$totalCurrentTotalToBeCollectedPerDate = [] ;
		$totalCurrentTotalCollectedPerDate = [] ;
		$collectionEffectivenessIndexForAllCustomersPerDate = [];
		
		$totalCurrentTotalToBeCollectedPerCustomer = [] ;
		$collectionEffectivenessIndexForAllCustomersPerCustomer = [];
		$totalCurrentTotalCollectedPerCustomer = [] ;
		$totalCurrentTotalCollectedPerAll =0;
		$totalCurrentTotalToBeCollectedPerAll = 0 ;
		$collectionEffectivenessIndexForAllCustomersPerAll = 0;
		
		$datesForHeader = [];
		$customerOrSupplierNameText = (new $fullClassName)->getClientNameText();
		$agingResult = (new AgingController)->result($company,$request,$modelType,true);
		$collectionEffectivenessIndexPerCustomer = [];
		$isMonthlyReport =$reportType == 'monthly'; 
		$dates = $isMonthlyReport ? HDate::generateStartDateAndEndDateBetween($startDate,$endDate) : [['start_date'=>$startDate,'end_date'=>$endDate]] ;  
		foreach($dates as $currentDateArr){
			$currentStartDate = $currentDateArr['start_date'];
			$currentEndDate = $currentDateArr['end_date'];
			$indexForStartAndEndDate = $currentStartDate.'/'.$currentEndDate;
			$datesForHeader[] =$indexForStartAndEndDate; 
			foreach($request->get('clients') as $partnerName){
			
				$currentPartner = Partner::getPartnerFromName($partnerName,$companyId);
				$currentPartnerId = $currentPartner->id; 
				$currentInvoiceStatementReportResult = (new CustomerInvoiceDashboardController())->showCustomerInvoiceStatementReport($company,$request,$currentPartnerId,$currency,$modelType,$currentStartDate,$currentEndDate,true);
				if(!count($currentInvoiceStatementReportResult)){
					continue ; 
				}
				$currentBeginningBalance = isset($currentInvoiceStatementReportResult) && $currentInvoiceStatementReportResult[0]['debit'] > 0 ? $currentInvoiceStatementReportResult[0]['debit'] : $currentInvoiceStatementReportResult[0]['credit'] * -1;
				unset($currentInvoiceStatementReportResult[0]);
				$currentSumOfDebit = array_sum(array_column($currentInvoiceStatementReportResult,'debit'));
				$currentSumOfCredit = array_sum(array_column($currentInvoiceStatementReportResult,'credit'));
				$currentTotalCollected =  $currentSumOfCredit ;
				$currentComingDues = $agingResult[$partnerName]['coming_due']['total'] ?? 0 ;
				$currentTotalToBeCollected =  $currentBeginningBalance + $currentSumOfDebit - $currentComingDues ;
				$totalCurrentTotalCollectedPerDate[$indexForStartAndEndDate]= isset($totalCurrentTotalCollectedPerDate[$indexForStartAndEndDate]) ? $totalCurrentTotalCollectedPerDate[$indexForStartAndEndDate] + $currentTotalCollected :$currentTotalCollected;
				$totalCurrentTotalCollectedPerCustomer[$partnerName]= isset($totalCurrentTotalCollectedPerCustomer[$partnerName]) ? $totalCurrentTotalCollectedPerCustomer[$partnerName] + $currentTotalCollected :$currentTotalCollected;
				$totalCurrentTotalCollectedPerAll+= $currentTotalCollected;
				$totalCurrentTotalToBeCollectedPerDate[$indexForStartAndEndDate] = isset($totalCurrentTotalToBeCollectedPerDate[$indexForStartAndEndDate]) ? $totalCurrentTotalToBeCollectedPerDate[$indexForStartAndEndDate]+ $currentTotalToBeCollected : $currentTotalToBeCollected;
				$totalCurrentTotalToBeCollectedPerCustomer[$partnerName] = isset($totalCurrentTotalToBeCollectedPerCustomer[$partnerName]) ? $totalCurrentTotalToBeCollectedPerCustomer[$partnerName]+ $currentTotalToBeCollected : $currentTotalToBeCollected;
				$totalCurrentTotalToBeCollectedPerAll += $currentTotalToBeCollected;
				$collectionEffectivenessIndexPerCustomer[$partnerName][$indexForStartAndEndDate] =$currentTotalToBeCollected ? $currentTotalCollected /$currentTotalToBeCollected *100 :0 ;
				$collectionEffectivenessIndexForAllCustomersPerDate[$indexForStartAndEndDate] = $totalCurrentTotalToBeCollectedPerDate[$indexForStartAndEndDate] ? $totalCurrentTotalCollectedPerDate[$indexForStartAndEndDate] /$totalCurrentTotalToBeCollectedPerDate[$indexForStartAndEndDate] *100 :0 ;
				$collectionEffectivenessIndexForAllCustomersPerCustomer[$partnerName] = $totalCurrentTotalToBeCollectedPerCustomer[$partnerName] ? $totalCurrentTotalCollectedPerCustomer[$partnerName] /$totalCurrentTotalToBeCollectedPerCustomer[$partnerName] *100 :0 ;
			}
		}
		$collectionEffectivenessIndexForAllCustomersPerAll = $totalCurrentTotalToBeCollectedPerAll ? $totalCurrentTotalCollectedPerAll/$totalCurrentTotalToBeCollectedPerAll*100 :0;
		$tableHeaders =  $datesForHeader ;
		
		return view('admin.reports.collection-effectiveness-index.result',[
			'collectionEffectivenessIndexPerCustomer'=>$collectionEffectivenessIndexPerCustomer,
			'reportName'=>$reportName,
			'tableHeaders'=>$tableHeaders,
			'customerOrSupplierNameText'=>$customerOrSupplierNameText,
			'collectionEffectivenessIndexForAllCustomersPerDate'=>$collectionEffectivenessIndexForAllCustomersPerDate,
			'collectionEffectivenessIndexForAllCustomersPerCustomer'=>$collectionEffectivenessIndexForAllCustomersPerCustomer,
			'isMonthlyReport'=>$isMonthlyReport,
			'collectionEffectivenessIndexForAllCustomersPerAll'=>$collectionEffectivenessIndexForAllCustomersPerAll
		]);
	}

	// public function getCustomersFromBusinessUnitsAndCurrencies(Company $company ,Request $request,string $modelType)
	// {
	// 	$invoiceTableName = getUploadParamsFromType($modelType)['dbName'];
	// 	$fullClassName = 'App\Models\\'.$modelType ;
	// 	$customer_or_supplier_name=$fullClassName::CLIENT_NAME_COLUMN_NAME;
	// 	$currency = $request->get('currencies');
	// 	$businessUnits = $request->get('business_units',[]);
	// 	$salesPersons = $request->get('sales_persons',[]);
	// 	$businessSectors = $request->get('business_sectors',[]);
	// 	$query = DB::table($invoiceTableName)->select($customer_or_supplier_name,'currency')
	// 	->where('currency',$currency)->where('company_id',$company->id)
	// 	->where('net_balance','>',0);
	// 	if(count($businessUnits)){
	// 		$query = $query->whereIn('business_unit',$businessUnits);
	// 	}
	// 	if(count($salesPersons)){
	// 		$query = $query->whereIn('sales_person',$salesPersons);
	// 	}
	// 	if(count($businessSectors)){
	// 		$query = $query->whereIn('business_sector',$businessSectors);
	// 	}

	// 	$data = $query->get();
	// 	/**
	// 	 * @var Collection $data ;
	// 	 */
	// 	$customers = $data->unique($customer_or_supplier_name)->pluck($customer_or_supplier_name);
	// 	$currencies = DB::table($invoiceTableName)->select($customer_or_supplier_name,'currency')
	// 	->where('company_id',$company->id)
	// 	->where('net_balance','>',0)
	// 	->get()
	// 	->unique('currency')->pluck('currency');
		
	
		
	// 	return response()->json([
	// 		'status'=>true ,
	// 		'message'=>__('Success'),
	// 		'data'=>[
	// 			'customer_names'=>$customers,
	// 			'currencies_names'=>$currencies,
	// 		]
	// 	]);
		
	// }


}
