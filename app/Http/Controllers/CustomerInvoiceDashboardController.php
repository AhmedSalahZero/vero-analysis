<?php

namespace App\Http\Controllers;

use App\Helpers\HDate;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\Partner;
use App\ReadyFunctions\ChequeAgingService;
use App\ReadyFunctions\InvoiceAgingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerInvoiceDashboardController extends Controller
{
    public function viewCashDashboard(Company $company, Request $request)
    {
	
	
        $financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$financialInstitutionBankIds = $financialInstitutionBanks->pluck('id')->toArray();
		$selectedFinancialInstitutionBankIds = $request->has('financial_institution_ids') ? $request->get('financial_institution_ids') : $financialInstitutionBankIds ;
		// dd($selectedFinancialInstitutionBankIds,$financialInstitutionBanks->pluck('id')->toArray());
		$currentDate = now()->format('Y-m-d') ;
        $date = $request->get('date');
		$date = $date ? HDate::formatDateFromDatePicker($date) : $currentDate;
		
		$date = Carbon::make($date)->format('Y-m-d');
		$allCurrencies = getCurrenciesForSuppliersAndCustomers() ;

        $selectedCurrencies = $request->get('currencies', $allCurrencies) ;
        $reports = [];

        foreach ($selectedCurrencies as $currencyName) {
            $cashInSafeStatementAmountForCurrency = DB::table('cash_in_safe_statements')
			->where('date', '<=', $date)
			->where('company_id', $company->id)
			->where('currency', $currencyName)
			->orderBy('id', 'desc')->limit(1)->first();
			// dd($cashInSafeStatementAmountForCurrency);

            $cashInSafeStatementAmountForCurrency = $cashInSafeStatementAmountForCurrency ? $cashInSafeStatementAmountForCurrency->end_balance : 0;

            $currentAccountInBanks = 0 ;
            $totalCleanOverdraftRoom = 0 ;
            $totalCleanOverdraftAgainstCommercialRoom = 0 ;
            $totalCertificateOfDepositsForCurrentFinancialInstitutionAmount = 0 ;
            foreach ($selectedFinancialInstitutionBankIds as $financialInstitutionBankId) {
                /**
                 * * حساب ال current account
                 */
				
			
                $currentAccountEndBalanceForCurrency = DB::table('current_account_bank_statements')
                ->join('financial_institution_accounts', 'financial_institution_account_id', '=', 'financial_institution_accounts.id')
                ->where('financial_institution_accounts.company_id', $company->id)
                ->where('currency', $currencyName)
                ->where('date', '<=', $date)
                ->where('financial_institution_accounts.financial_institution_id', '=', $financialInstitutionBankId)
                ->orderBy('current_account_bank_statements.id', 'desc')
                ->limit(1)
                ->first();
				// start testing
						
				// end testing 
				
				// dd($currentAccountEndBalanceForCurrency);
                $currentAccountEndBalanceForCurrency = $currentAccountEndBalanceForCurrency ? $currentAccountEndBalanceForCurrency->end_balance : 0;

                $currentAccountInBanks += $currentAccountEndBalanceForCurrency ;

                /**
                 * * حساب certificates_of_deposits
                 */

                $certificateOfDepositsForCurrentFinancialInstitutionAmount = DB::table('certificates_of_deposits')->where('company_id', $company->id)->where('financial_institution_id', $financialInstitutionBankId)
				->where('currency', $currencyName)
				->first();
                $totalCertificateOfDepositsForCurrentFinancialInstitutionAmount += $certificateOfDepositsForCurrentFinancialInstitutionAmount ? $certificateOfDepositsForCurrentFinancialInstitutionAmount->amount : 0;

                /**
                 * * حساب ال clean_overdraft
                 */
                $cleanOverdraftRoom = DB::table('clean_overdraft_bank_statements')
                ->where('clean_overdraft_bank_statements.company_id', $company->id)->where('date', '<=', $date)
                ->join('clean_overdrafts', 'clean_overdraft_bank_statements.clean_overdraft_id', '=', 'clean_overdrafts.id')
                ->where('clean_overdrafts.currency', '=', $currencyName)
                ->orderBy('clean_overdraft_bank_statements.id')
                ->limit(1)
                ->first() ;
                $cleanOverdraftRoom = $cleanOverdraftRoom ? $cleanOverdraftRoom->room : 0 ;
                $totalCleanOverdraftRoom += $cleanOverdraftRoom ;

                /**
                 * * حساب ال clean_overdraft
                 * * مؤجلة لحساب الكلين اوفردرافت
                 * * aginst commerical
                 */
                //   $cleanOverdraftOverCommercialRoom = DB::table('clean_overdraft_against_commercial_bank_statements')
                //   ->where('clean_overdraft_against_commercial_bank_statements.company_id',$company->id)->where('date','<=',$date)
                //   ->join('clean_overdraft_against_commercials','clean_overdraft_against_commercial_bank_statements.clean_overdraft_id','=','clean_overdraft_against_commercials.id')
                //   ->where('clean_overdraft_against_commercials.currency','=',$currencyName)
                //   ->orderBy('clean_overdraft_against_commercial_bank_statements.id')
                //   ->limit(1)
                //   ->first() ;
                //   $cleanOverdraftOverCommercialRoom = $cleanOverdraftOverCommercialRoom ? $cleanOverdraftOverCommercialRoom->room : 0 ;
                //   $totalCleanOverdraftAgainstCommercialRoom +=$cleanOverdraftOverCommercialRoom ;
            }
            $reports['cash_and_banks'][$currencyName] = $cashInSafeStatementAmountForCurrency + $currentAccountInBanks ;
            $reports['certificate_of_deposits'][$currencyName] = $totalCertificateOfDepositsForCurrentFinancialInstitutionAmount ;
            $reports['credit_facilities_room'][$currencyName] = $totalCleanOverdraftRoom + $totalCleanOverdraftAgainstCommercialRoom ;

            $currentTotal = $reports['cash_and_banks'][$currencyName] + $reports['certificate_of_deposits'][$currencyName] + $reports['credit_facilities_room'][$currencyName] ;
            $reports['total'][$currencyName] = isset($reports['total'][$currencyName]) ? $reports['total'][$currencyName] + $currentTotal : $currentTotal ;
        }

        // $cleanOverdraftCardCommonQuery = DB::table('clean_overdraft_bank_statements')
        // ->where('clean_overdraft_bank_statements.company_id', $company->id)->where('date', '<=', $date)
        // ->join('clean_overdrafts', 'clean_overdraft_bank_statements.clean_overdraft_id', '=', 'clean_overdrafts.id')
        // ->where('clean_overdrafts.currency', '=', $currencyName)
        // ->orderBy('clean_overdraft_bank_statements.id');

        // $cleanOverdraftCardData = [
        //     'limit' => $cleanOverdraftCardCommonQuery->sum('clean_overdraft_bank_statements.limit'),
        //     'outstanding' => $cleanOverdraftCardCommonQuery->sum('clean_overdraft_bank_statements.end_balance'),
        //     'room' => $cleanOverdraftCardCommonQuery->sum('clean_overdraft_bank_statements.room'),
        // ];
		
	
		$cleanOverdraftCardCommonQuery = DB::table('clean_overdrafts')
        ->where('currency', '=', $currencyName)
        ->where('company_id', $company->id)->where('contract_start_date', '<=', $date)
        ->orderBy('clean_overdraft_bank_statements.id');
		
		$outstandingQuery = DB::table('clean_overdraft_bank_statements')
        ->where('clean_overdraft_bank_statements.company_id', $company->id)->where('date', '<=', $date)
        ->join('clean_overdrafts', 'clean_overdraft_bank_statements.clean_overdraft_id', '=', 'clean_overdrafts.id')
        ->where('clean_overdrafts.currency', '=', $currencyName)
		->groupBy('clean_overdraft_id')
        ->orderBy('clean_overdraft_bank_statements.id')
		->selectRaw('max(clean_overdraft_bank_statements.date) , clean_overdraft_bank_statements.end_balance');
	
		
        $cleanOverdraftCardData = [
            'limit' => $limit = $cleanOverdraftCardCommonQuery->sum('limit'),
            'outstanding' => $outstanding = $outstandingQuery->sum('end_balance'),
            'room' => $limit + $outstanding ,
        ];
		

        return view('admin.dashboard.cash', [
            'company' => $company,
            'financialInstitutionBanks' => $financialInstitutionBanks,
            'reports' => $reports,
            'selectedCurrencies' => $selectedCurrencies,
			'allCurrencies'=>$allCurrencies,
            'selectedFinancialInstitutionsIds' => $selectedFinancialInstitutionBankIds,
            'cleanOverdraftCardData' => $cleanOverdraftCardData
        ]);
    }

    public function viewForecastDashboard(Company $company, Request $request)
    {
        $dashboardResult = [];
        $invoiceTypesModels = ['CustomerInvoice', 'SupplierInvoice'] ;
        $startDate = $request->get('start_date', now()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::make($startDate)->addYear()->format('Y-m-d'));
        // $startDate = $request->get('start_date', now()->addYear()->format('Y-m-d'));
        $aginDate = $startDate ;
		$invoiceAgingService = new InvoiceAgingService($company->id, $aginDate);
		$chequeAgingService = new ChequeAgingService($company->id, $aginDate);
		
        foreach ($invoiceTypesModels as $modelType) {
            $clientNames = ('\App\Models\\' . $modelType)::getAllUniqueCustomerNames($company->id);
          
            /**
             * * Customers Invoices Aging & Supplier Invoices Aging
             */
            $agingsForInvoices = $invoiceAgingService->__execute($clientNames, $modelType) ;
            $agingsForInvoices = $invoiceAgingService->formatForDashboard($agingsForInvoices,$modelType);
            /**
             * * Customers Cheques Aging & Supplier Cheques Aging
             */
            $agingsForCheques = $chequeAgingService->__execute($clientNames, $modelType) ;
            $agingsForCheques = $chequeAgingService->formatForDashboard($agingsForCheques,$modelType);

            $dashboardResult['invoices_aging'][$modelType] = $agingsForInvoices ;
			
            $dashboardResult['cheques_aging'][$modelType] = $agingsForCheques ;
        }

        return view('admin.dashboard.forecast', [
            'company' => $company,
			'dashboardResult'=>$dashboardResult,
			'invoiceTypesModels'=>$invoiceTypesModels,
			'startDate'=>$startDate,
			'endDate'=>$endDate
        ]);

        return view('admin.dashboard.forecast', ['company' => $company]);
    }

    public function showInvoiceReport(Company $company, Request $request, int $partnerId, string $currency, $modelType)
    {
	
        $fullClassName = ('\App\Models\\' . $modelType) ;

        $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        $isCollectedOrPaid = $fullClassName::COLLETED_OR_PAID ;
        $moneyReceivedOrPaidText = (new $fullClassName())->getMoneyReceivedOrPaidText();
        $moneyReceivedOrPaidUrlName = (new $fullClassName())->getMoneyReceivedOrPaidUrlName();
        $invoices = ('App\Models\\' . $modelType)::where('company_id', $company->id)
        ->where($clientIdColumnName, $partnerId)
        ->where('currency', $currency)
        ->get();
        $customer = Partner::find($partnerId);
        if (!count($invoices)) {
            return  redirect()->back()->with('fail', __('No Data Found'));
        }

        return view('admin.reports.invoice-report', [
            'invoices' => $invoices,
            'partnerName' => $customer->getName(),
            'partnerId' => $customer->getId(),
            'currency' => $currency,
            'isCollectedOrPaid' => 'is' . ucfirst($isCollectedOrPaid),
            'moneyReceivedOrPaidText' => $moneyReceivedOrPaidText,
            'moneyReceivedOrPaidUrlName' => $moneyReceivedOrPaidUrlName,
			'modelType'=>$modelType
        ]);
    }
	
	
	public function viewLGLCDashboard(Company $company, Request $request)
    {
		return view('admin.reports.lglc-report');
		// dd('view dashboard here');
	
        // $fullClassName = ('\App\Models\\' . $modelType) ;

        // $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        // $isCollectedOrPaid = $fullClassName::COLLETED_OR_PAID ;
        // $moneyReceivedOrPaidText = (new $fullClassName())->getMoneyReceivedOrPaidText();
        // $moneyReceivedOrPaidUrlName = (new $fullClassName())->getMoneyReceivedOrPaidUrlName();
        // $invoices = ('App\Models\\' . $modelType)::where('company_id', $company->id)
        // ->where($clientIdColumnName, $partnerId)
        // ->where('currency', $currency)
        // ->get();
        // $customer = Partner::find($partnerId);
        // if (!count($invoices)) {
        //     return  redirect()->back()->with('fail', __('No Data Found'));
        // }

        // return view('admin.reports.invoice-report', [
        //     'invoices' => $invoices,
        //     'partnerName' => $customer->getName(),
        //     'partnerId' => $customer->getId(),
        //     'currency' => $currency,
        //     'isCollectedOrPaid' => 'is' . ucfirst($isCollectedOrPaid),
        //     'moneyReceivedOrPaidText' => $moneyReceivedOrPaidText,
        //     'moneyReceivedOrPaidUrlName' => $moneyReceivedOrPaidUrlName,
		// 	'modelType'=>$modelType
        // ]);
    }
	
    public function showCustomerInvoiceStatementReport(Company $company, Request $request, int $partnerId, string $currency, string $modelType)
    {
        $fullClassName = ('\App\Models\\' . $modelType) ;

        $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        $isCollectedOrPaid = $fullClassName::COLLETED_OR_PAID ;
        $moneyReceivedOrPaidText = (new $fullClassName())->getMoneyReceivedOrPaidText();
        $moneyReceivedOrPaidUrlName = (new $fullClassName())->getMoneyReceivedOrPaidUrlName();
        $customerStatementText = (new $fullClassName())->getCustomerOrSupplierStatementText();
        $startDate = $request->get('start_date', now()->subMonths(4)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $invoices = ('\App\Models\\' . $modelType)::where('company_id', $company->id)
        ->where('currency', $currency)
        ->whereBetween('invoice_date', [$startDate, $endDate])
        ->where($clientIdColumnName, '=', $partnerId)->get();
        $partner = Partner::find($partnerId);
        $partnerName = $partner->getName() ;
        $invoicesWithItsReceivedMoney = ('App\Models\\' . $modelType)::formatForStatementReport($invoices, $partnerName, $startDate, $endDate, $currency);
        if (count($invoicesWithItsReceivedMoney) <= 1) {
            return  redirect()->back()->with('fail', __('No Data Found'));
        }

        return view('admin.reports.customer-statement-report', [
            'invoicesWithItsReceivedMoney' => $invoicesWithItsReceivedMoney,
            'partnerName' => $partnerName,
            'partnerId' => $partnerId,
            'currency' => $currency,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerStatementText' => $customerStatementText
        ]);
    }
}
