<?php

namespace App\Http\Controllers;

use App\Models\CashInSafeStatement;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerInvoiceDashboardController extends Controller
{
    public function viewCashDashboard(Company $company , Request $request ){
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$date=  $request->get('date',now()->format('Y-m-d'));
		$cashInSafeStatementStd = DB::table('cash_in_safe_statements')->where('date','<=',$date)->where('company_id',$company->id)->orderBy('id','desc')->first();

		$cashInSafeStatementAmount =  $cashInSafeStatementStd ? $cashInSafeStatementStd->end_balance : 0 ;
		
		// علي حسب البنوك اللي اختارها وباي دي فولت هيكونوا كلهم
		$currentAccountInBanks = 0 ;
		$totalCashAndBanks = $cashInSafeStatementAmount + $currentAccountInBanks ; 
		foreach($request->get('financial_institution_ids',[]) as $financialInstitutionId){
			
		}
		
		return view('admin.dashboard.cash',[
			'company'=>$company,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'totalCashAndBanks'=>$totalCashAndBanks
		]);
	} 
	public function viewForecastDashboard(Company $company , Request $request ){
		return view('admin.dashboard.forecast',['company'=>$company]);
	}
	public function showInvoiceReport(Company $company , Request $request , int  $partnerId,string $currency,$modelType){
		$fullClassName = ('\App\Models\\'.$modelType) ;
	
		$clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
		$isCollectedOrPaid = $fullClassName::COLLETED_OR_PAID ;
		$moneyReceivedOrPaidText  =(new $fullClassName) ->getMoneyReceivedOrPaidText();
		$moneyReceivedOrPaidUrlName  =(new $fullClassName) ->getMoneyReceivedOrPaidUrlName();
		
		$invoices = ('App\Models\\'.$modelType)::where('company_id',$company->id)
		->where($clientIdColumnName,$partnerId)
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
			'currency'=>$currency,
			'isCollectedOrPaid'=>'is'.ucfirst($isCollectedOrPaid),
			'moneyReceivedOrPaidText'=>$moneyReceivedOrPaidText,
			'moneyReceivedOrPaidUrlName'=>$moneyReceivedOrPaidUrlName
			
		]);
	}	
	
	public function showCustomerInvoiceStatementReport(Company $company , Request $request , int $partnerId,string $currency,string $modelType){
		$fullClassName = ('\App\Models\\'.$modelType) ;
	
		$clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
		$isCollectedOrPaid = $fullClassName::COLLETED_OR_PAID ;
		$moneyReceivedOrPaidText  =(new $fullClassName) ->getMoneyReceivedOrPaidText();
		$moneyReceivedOrPaidUrlName  =(new $fullClassName) ->getMoneyReceivedOrPaidUrlName();
		$customerStatementText = (new $fullClassName)->getCustomerOrSupplierStatementText();
		$startDate= $request->get('start_date',now()->subMonths(4)->format('Y-m-d'));
		$endDate  = $request->get('end_date',now()->format('Y-m-d'));
		$invoices = ('\App\Models\\'.$modelType)::where('company_id',$company->id)
		->where('currency',$currency)
		->whereBetween('invoice_date',[$startDate , $endDate ])
		->where($clientIdColumnName,'=',$partnerId)->get();
		$partner = Partner::find($partnerId);
		$partnerName = $partner->getName() ;
		$invoicesWithItsReceivedMoney = ('App\Models\\'.$modelType)::formatForStatementReport($invoices,$partnerName,$startDate,$endDate,$currency);
		if(count($invoicesWithItsReceivedMoney) <= 1){
			return  redirect()->back()->with('fail',__('No Data Found'));
		}
		return view('admin.reports.customer-statement-report',[
			'invoicesWithItsReceivedMoney'=>$invoicesWithItsReceivedMoney,
			'partnerName'=>$partnerName,
			'partnerId'=>$partnerId,
			'currency'=>$currency ,
			'startDate'=>$startDate ,
			'endDate'=>$endDate,
			'customerStatementText'=>$customerStatementText
		]);
	}
	
	
}
