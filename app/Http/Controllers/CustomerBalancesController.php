<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\ReadyFunctions\InvoiceAgingService;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerBalancesController
{
    use GeneralFunctions;
	protected function sumNetBalancePerCurrency(array $items , string $mainCurrency ):array 
	{
		
		$total = [];
		// dd($items);
		foreach($items as $item){
			$id = $item->id ;
			$currencyName = $item->currency ;
			$customerName = $item->customer_name ;
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
    public function index(Request $request,Company $company)
	{
		$user =User::where('id',$request->user()->id)->get();
		$mainCurrency = $company->getMainFunctionalCurrency();
		$customerInvoicesBalances=DB::select(DB::raw('select id, customer_name , currency , sum(net_balance) as net_balance , sum(net_balance_in_main_currency) as net_balance_in_main_currency from customer_invoices where net_balance > 0 and company_id = '. $company->id .'  group by customer_name , currency order by net_balance desc;'));
		$cardNetBalances = $this->sumNetBalancePerCurrency($customerInvoicesBalances,$mainCurrency);
		// dd($cardNetBalances);
        return view('admin.reports.customer_balances_form', compact('company','customerInvoicesBalances','cardNetBalances','mainCurrency'));
    }
	public function result(Company $company , Request $request){
		
		$aginDate = $request->get('again_date');
		$customerNames = $request->get('customers');
		$invoiceAgingService = new InvoiceAgingService($company->id ,$aginDate);
		$customerAgings  = $invoiceAgingService->__execute($customerNames) ;
		$weeksDates = formatWeeksDatesFromStartDate($aginDate);
		return view('admin.reports.customer-invoices-aging',['customerAgings'=>$customerAgings,'aginDate'=>$aginDate,'weeksDates'=>$weeksDates]);
	}
	public function showTotalNetBalanceDetailsReport(Request $request,Company $company , string $currency)
	{
		$user =User::where('id',$request->user()->id)->get();
		$mainCurrency = $company->getMainFunctionalCurrency();
		// $customerInvoicesBalances=DB::select(DB::raw('select id,customer_name , currency , sum(net_balance) as net_balance , sum(net_balance_in_main_currency) as net_balance_in_main_currency from customer_invoices where net_balance > 0 and company_id = '. $company->id .'  group by customer_name , currency order by customer_name asc;'));
		
		$customerInvoicesBalances=DB::select(DB::raw('select id,customer_name ,invoice_number,DATE_FORMAT(invoice_date,"%d-%m-%Y") as invoice_date, currency , net_balance   from customer_invoices where net_balance > 0  and currency = "'. $currency .'" and company_id = '. $company->id .' order by customer_name asc;'));
        return view('admin.reports.total_net_balance_details', compact('company','customerInvoicesBalances','currency'));
    }
	public function getCustomersFromSalesPersons(Company $company ,Request $request)
	{
		$businessUnits = $request->get('salesPersons',[]);
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
