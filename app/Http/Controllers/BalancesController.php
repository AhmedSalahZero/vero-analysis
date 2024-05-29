<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\ReadyFunctions\InvoiceAgingService;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalancesController
{
    use GeneralFunctions;
	protected function sumNetBalancePerCurrency(array $items , string $mainCurrency,string $clientNameColumnName ):array 
	{
		
		$total = [];
		foreach($items as $item){
			$id = $item->id ;
			$currencyName = $item->currency ;
			$customerName = $item->{$clientNameColumnName} ;
			$currentValueForCurrency = $item->net_balance;
			$currentValueForMainCurrency= $item->net_balance_in_main_currency;
			$total['currencies'][$currencyName] = isset($total['currencies'][$currencyName]) ? $total['currencies'][$currencyName] + $currentValueForCurrency   :  $currentValueForCurrency;
			$total['main_currency'][$mainCurrency] = isset($total['main_currency'][$mainCurrency]) ? $total['main_currency'][$mainCurrency] + $currentValueForMainCurrency  : $currentValueForMainCurrency;
			$total['customers_per_currency'][$mainCurrency][$customerName][$id] =   $currentValueForCurrency;
			$total['customers_per_main_currency'][$mainCurrency][$customerName][$id] =   $currentValueForMainCurrency;
		}
		$valueAtMainCurrency = $total['currencies'][$mainCurrency] ?? 0;
		unset($total['currencies'][$mainCurrency]);
		$totalOfCurrency  = $total['currencies'] ?? [];
		$total['currencies'] = [$mainCurrency => $valueAtMainCurrency]+$totalOfCurrency ;
		return $total ;
	}
    public function index(Request $request,Company $company,string $modelType)
	{
		$fullClassName = ('\App\Models\\'.$modelType) ;
		$customersOrSupplierText = (new $fullClassName )->getClientDisplayName();
		$title = (new $fullClassName )->getBalancesTitle();
		$customersOrSupplierStatementText = (new $fullClassName)->getCustomerOrSupplierStatementText();
		$clientNameColumnName = $fullClassName::CLIENT_NAME_COLUMN_NAME ;
		$clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
		$tableName = $fullClassName::TABLE_NAME ; 
		$user =User::where('id',$request->user()->id)->get();
		$mainCurrency = $company->getMainFunctionalCurrency();
		$invoicesBalances =DB::select(DB::raw('select id, '. $clientNameColumnName .' , '. $clientIdColumnName .' , currency , sum(net_balance) as net_balance , sum(net_balance_in_main_currency) as net_balance_in_main_currency from '. $tableName .' where net_balance > 0 and company_id = '. $company->id .'  group by '. $clientNameColumnName .' , currency order by net_balance desc;'));
		$cardNetBalances = $this->sumNetBalancePerCurrency($invoicesBalances,$mainCurrency,$clientNameColumnName);
        return view('admin.reports.balances_form', compact('company','title','invoicesBalances','cardNetBalances','mainCurrency','modelType','clientNameColumnName','clientIdColumnName','customersOrSupplierStatementText'));
    }
	public function result(Company $company , Request $request,string $modelType){
		
		$aginDate = $request->get('again_date');
		$customerNames = $request->get('customers');
		$invoiceAgingService = new InvoiceAgingService($company->id ,$aginDate);
		$customerAgings  = $invoiceAgingService->__execute($customerNames,$modelType) ;
		$weeksDates = formatWeeksDatesFromStartDate($aginDate);
		return view('admin.reports.customer-invoices-aging',['customerAgings'=>$customerAgings,'aginDate'=>$aginDate,'weeksDates'=>$weeksDates]);
	}
	public function showTotalNetBalanceDetailsReport(Request $request,Company $company , string $currency , string $modelType)
	{
		$onlyPasted = $request->has('only') ;
		$additionalWhereClause = $onlyPasted ? "and invoice_status in ('past_due' , 'partially_collected_and_past_due' )" :  '' ;
		$fullClassName = ('\App\Models\\'.$modelType) ;
		$customersOrSupplierText = (new $fullClassName )->getClientDisplayName();
		$title = (new $fullClassName )->getBalancesTitle();
		$clientNameColumnName = $fullClassName::CLIENT_NAME_COLUMN_NAME ;
		$clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
		$tableName = $fullClassName::TABLE_NAME ;
		$user =User::where('id',$request->user()->id)->get();
		$mainCurrency = $company->getMainFunctionalCurrency();
		$moneyReceivedOrPaidUrlName = (new $fullClassName)->getMoneyReceivedOrPaidUrlName();
		$moneyReceivedOrPaidText = (new $fullClassName)->getMoneyReceivedOrPaidText();
		$clientNameText = (new $fullClassName)->getClientNameText();
		$invoicesBalances=DB::select(DB::raw('select id,'. $clientNameColumnName .' ,invoice_due_date,invoice_status,invoice_number,DATE_FORMAT(invoice_date,"%d-%m-%Y") as invoice_date, currency , net_balance   from '. $tableName .' where net_balance > 0  and currency = "'. $currency .'" and company_id = '. $company->id . ' ' . $additionalWhereClause . ' order by invoice_due_date asc , net_balance desc ;'));
        return view('admin.reports.total_net_balance_details', compact('company','invoicesBalances','currency','moneyReceivedOrPaidUrlName','moneyReceivedOrPaidText','clientNameColumnName','clientNameText'));
    }



}
