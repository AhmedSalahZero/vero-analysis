<?php

namespace App\Http\Controllers;

use App\Helpers\HArr;
use App\Models\Company;
use App\Models\DownPaymentSettlement;
use App\Models\MoneyReceived;
use App\Models\User;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BalancesController
{
    use GeneralFunctions;
	protected function sumNetBalancePerCurrency(array $items , string $mainCurrency,string $clientNameColumnName ):array 
	{
		
		$total = [];

		$id = 0 ;
		foreach($items as $item){
			$currencyName = $item->currency ;
			if(!$currencyName){
				continue;
			}
			$customerName = $item->{$clientNameColumnName} ;
			$currentValueForCurrency = $item->net_balance;
			$currentValueForMainCurrency= $item->net_balance_in_main_currency;
			$total['currencies'][$currencyName] = isset($total['currencies'][$currencyName]) ? $total['currencies'][$currencyName] + $currentValueForCurrency   :  $currentValueForCurrency;
			// $total['main_currency'][$mainCurrency] = isset($total['main_currency'][$mainCurrency]) ? $total['main_currency'][$mainCurrency] + $currentValueForMainCurrency  : $currentValueForMainCurrency;
			$total['customers_per_currency'][$mainCurrency][$customerName][$id] =   $currentValueForCurrency;
			$total['customers_per_main_currency'][$mainCurrency][$customerName][$id] =   $currentValueForMainCurrency;
			$id++;
			
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
		$isCustomerOrSupplierColumnName = $fullClassName::IS_CUSTOMER_OR_SUPPLIER;
		$tableName = $fullClassName::TABLE_NAME ; 
		$user =User::where('id',$request->user()->id)->get();
		$mainCurrency = $company->getMainFunctionalCurrency();
		$mainFunctionalCurrency = $company->getMainFunctionalCurrency();
		$downPaymentTableName = $fullClassName::DOWN_PAYMENT_SETTLEMENT_TABLE_NAME;
		$downPaymentSettlementModelName=$fullClassName::DOWN_PAYMENT_SETTLEMENT_MODEL_NAME;
		$moneyModelName=$fullClassName::MONEY_MODEL_NAME;
		$invoiceNetBalanceSqlQuery = 'select partners.id as '. $clientIdColumnName .' , partners.name as '.$clientNameColumnName.' , currency , ifnull(sum(net_balance),0) as net_balance , ifnull(sum(net_balance_in_main_currency),0) as net_balance_in_main_currency from partners left join  '. $tableName .' on partners.id = '.$tableName.'.'.$clientIdColumnName.' where '.$isCustomerOrSupplierColumnName.'=1 and partners.company_id = '. $company->id .' group by '.$clientNameColumnName.' , currency order by net_balance desc;';
		$downPaymentSqlQuery =  'select  '.  $clientIdColumnName .' , currency , sum(down_payment_balance) as down_payment_balance from '. $downPaymentTableName .' where   company_id = '. $company->id .' group by '. $clientIdColumnName .' , currency order by down_payment_balance desc;';
		$invoicesBalances =DB::select(DB::raw($invoiceNetBalanceSqlQuery));
		$partnerIds = collect($invoicesBalances)->pluck($clientIdColumnName,$clientIdColumnName)->toArray() ;
		$downPaymentsInMainCurrency = $this->getDownPaymentInMainCurrency($partnerIds,$mainFunctionalCurrency,$clientIdColumnName,$downPaymentSettlementModelName,$moneyModelName);
		
		$downPayments =DB::select(DB::raw($downPaymentSqlQuery));
		$invoicesBalancesWithPartnersWithoutInvoices = $this->subtractQuery($invoicesBalances,$downPayments,$clientIdColumnName,$clientNameColumnName);
		$invoicesBalances = $invoicesBalancesWithPartnersWithoutInvoices['data'] ?? [];
		$partnersWithoutInvoices = $invoicesBalancesWithPartnersWithoutInvoices['partners_without_invoices'];
		$invoicesBalancesForMainFunctionalCurrency = $this->addMainCurrency($invoicesBalances,$downPaymentsInMainCurrency,$partnersWithoutInvoices,$clientNameColumnName,$clientIdColumnName);
		$invoicesBalances = array_merge($invoicesBalances , $invoicesBalancesForMainFunctionalCurrency);
		$cardNetBalances = $this->sumNetBalancePerCurrency($invoicesBalances,$mainFunctionalCurrency,$clientNameColumnName);
		$hasMoreThanCurrency = isset($cardNetBalances['currencies']) && count($cardNetBalances['currencies']) >1 ; 
		
		
        return view('admin.reports.balances_form', compact('company','mainFunctionalCurrency','hasMoreThanCurrency','title','invoicesBalances','cardNetBalances','mainCurrency','modelType','clientNameColumnName','clientIdColumnName','customersOrSupplierStatementText'));
    }
	protected function getDownPaymentInMainCurrency(array $partnerIds,string $mainFunctionalCurrency,string $clientIdColumnName,string $downPaymentSettlementModelName , string $moneyModelName):array{
		$result = [];
		$fullDownPaymentModelName = 'App\Models\\'.$downPaymentSettlementModelName;
		$downPaymentSettlements = $fullDownPaymentModelName::
		where('down_payment_balance','!=',0)
		->whereIn($clientIdColumnName,$partnerIds)
		->with([$moneyModelName])
		->get();
		foreach($downPaymentSettlements as $downPaymentSettlement){
			$moneyReceived = $downPaymentSettlement->moneyReceived ;
			$partnerId = $downPaymentSettlement->{$clientIdColumnName};
			$downPaymentCurrency = $downPaymentSettlement->currency ;
			$foreignExchangeRateAtDate =$moneyReceived->getForeignExchangeRateAtDate();
			$downPaymentBalance = $downPaymentSettlement->down_payment_balance  ;
			$downPaymentBalanceInMainCurrency = $downPaymentBalance * $foreignExchangeRateAtDate;
			if($mainFunctionalCurrency != $downPaymentCurrency){
				$result[$partnerId] = isset($result[$partnerId]) ? $result[$partnerId] + $downPaymentBalanceInMainCurrency : $downPaymentBalanceInMainCurrency;
			}else{
				$result[$partnerId] = isset($result[$partnerId]) ? $result[$partnerId] + $downPaymentBalance : $downPaymentBalance;
			}

		}
		return $result ;
		
		
	}
	protected function subtractQuery($invoicesBalances,$downPayments,$clientIdColumnName,$clientNameColumnName){
	$newRecords = [];
	$partnersWithoutInvoices = [];
		foreach($invoicesBalances as $invoiceBalanceStdClass ){
			$addNewRecord = false ;
			$invoicePartnerId =$invoiceBalanceStdClass->{$clientIdColumnName};
			$invoicePartnerName =$invoiceBalanceStdClass->{$clientNameColumnName};
			$invoiceCurrency = $invoiceBalanceStdClass->currency;

			foreach($downPayments as $downPaymentStdClass){
				
				
				$downPaymentPartnerId = $downPaymentStdClass->{$clientIdColumnName} ;
				$downPaymentCurrency = $downPaymentStdClass->currency ;
				
			
				
				if($downPaymentCurrency == $invoiceCurrency && $downPaymentPartnerId == $invoicePartnerId
				){
					$invoiceBalanceStdClass->net_balance = $invoiceBalanceStdClass->net_balance - $downPaymentStdClass->down_payment_balance;
					continue;
				}
				if(is_null($invoiceCurrency) && $downPaymentPartnerId == $invoicePartnerId ){
					$partnersWithoutInvoices[$invoicePartnerId] = $invoicePartnerId;
					if(!$addNewRecord){
						$invoiceBalanceStdClass->currency = $downPaymentCurrency ;
						$invoiceBalanceStdClass->net_balance = 0 - $downPaymentStdClass->down_payment_balance;
						$addNewRecord = true;
					}else{
						$newRecords[] = json_decode(json_encode([
							$clientIdColumnName=>$invoicePartnerId,
							$clientNameColumnName=>$invoicePartnerName,
							'currency'=>$downPaymentCurrency,
							'net_balance'=>0 - $downPaymentStdClass->down_payment_balance,
							'net_balance_in_main_currency'=>0 - $downPaymentStdClass->down_payment_balance
						]));
					}
				}
			}
		}
			return [
				'partners_without_invoices'=>$partnersWithoutInvoices ,
				'data'=>array_merge($invoicesBalances,$newRecords)
			] ;
	}
		
		protected function addMainCurrency(array $items,array $downPaymentsInMainCurrency,array $partnersWithoutInvoices,string $clientNameColumnName,string $clientIdColumnName ){
	
			$formattedResult = [];
			$partnerNames = [];
			$totalPerCustomerForMainCurrency = [];
			foreach($items as $stdClass ){
				$partnerId = $stdClass->{$clientIdColumnName} ;
				$partnerName = $stdClass->{$clientNameColumnName} ;
				$partnerNames[$partnerId] = $partnerName;
				$totalPerCustomerForMainCurrency[$partnerId] = isset($totalPerCustomerForMainCurrency[$partnerId]) ? $totalPerCustomerForMainCurrency[$partnerId] + $stdClass->net_balance_in_main_currency :  $stdClass->net_balance_in_main_currency;
			}
			foreach($totalPerCustomerForMainCurrency as $partnerId => $total){
				$downPaymentForPartner = $downPaymentsInMainCurrency[$partnerId] ?? 0 ;
				$total = in_array($partnerId,$partnersWithoutInvoices) ? -1*$downPaymentForPartner : $total-$downPaymentForPartner  ;
				$formattedResult[] = json_decode(json_encode([
					$clientIdColumnName=>$partnerId,
					$clientNameColumnName=>$partnerNames[$partnerId],
					'currency'=>'main_currency',
					'net_balance'=>$total,
					'net_balance_in_main_currency'=>$total 
				]));
			}
			return $formattedResult;
		
			
		
		return $result;
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
