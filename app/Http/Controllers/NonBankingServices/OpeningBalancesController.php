<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HArr;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOpeningBalancesRequest;
use App\Models\Company;
use App\Models\NonBankingService\LongTermLoanOpeningBalance;
use App\Models\NonBankingService\OtherCreditsOpeningBalance;
use App\Models\NonBankingService\OtherDebtorsOpeningBalance;
use App\Models\NonBankingService\OtherLongTermAssetsOpeningBalance;
use App\Models\NonBankingService\OtherLongTermLiabilitiesOpeningBalance;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpeningBalancesController extends Controller
{
    use NonBankingService ;
    
    public function create(Company $company, Request $request, Study $study)
    {
        return view('non_banking_services.openingBalances.form', array_merge($study->getOpeningBalancesViewVars(), ['inEditMode'=>false]));
    }
    
    public function store(Company $company, StoreOpeningBalancesRequest $request, Study $study)
    {
		
        $study->storeRepeaterRelations($request, ['fixedAssetOpeningBalances','cashAndBankOpeningBalances','otherDebtorsOpeningBalances','vatAndCreditWithholdTaxesOpeningBalances'
        ,'supplierPayableOpeningBalances','otherCreditorsOpeningBalances','otherLongTermAssetsOpeningBalances','otherLongTermLiabilitiesOpeningBalances','equityOpeningBalances','longTermLoanOpeningBalances'
         ], $company, ['study_id'=>$study->id]);
        $longTermLoanOpeningBalanceInterests = [];
        $studyMonthsForViews = $study->getStudyDates();
        $studyMonthsForViews = array_slice($studyMonthsForViews, 0, $study->getViewStudyEndDateAsIndex()+1);
        $sumKeys = array_keys($studyMonthsForViews);
        
        $totalExistingLongTermLoansPayments = [];
        $study->longTermLoanOpeningBalances->each(function (LongTermLoanOpeningBalance $longTermLoanOpeningBalance) use (&$longTermLoanOpeningBalanceInterests, &$totalExistingLongTermLoansPayments, $sumKeys) {
            $currentInterest = $longTermLoanOpeningBalance->interests ;
            $currentInstallments = $longTermLoanOpeningBalance->installments ;
            $longTermLoanOpeningBalanceInterests = HArr::sumAtDates([$longTermLoanOpeningBalanceInterests,$currentInterest], $sumKeys);
            $totalExistingLongTermLoansPayments[$longTermLoanOpeningBalance->id] =  HArr::sumAtDates([$currentInstallments,$currentInterest], $sumKeys);
            
        });
       
        
        $totalOtherLongTermAssetOpeningBalances=[];
        $study->otherLongTermAssetsOpeningBalances->each(function (OtherLongTermAssetsOpeningBalance $otherLongTermAssetOpeningBalance) use (&$totalOtherLongTermAssetOpeningBalances) {
            $totalOtherLongTermAssetOpeningBalances[$otherLongTermAssetOpeningBalance->id] = (array)$otherLongTermAssetOpeningBalance->payload;
        });
        
        $existingOtherLongTermLiabilitiesPayment=[];
        $study->otherLongTermLiabilitiesOpeningBalances->each(function (OtherLongTermLiabilitiesOpeningBalance $otherLongTermLiability) use (&$existingOtherLongTermLiabilitiesPayment) {
            $existingOtherLongTermLiabilitiesPayment[$otherLongTermLiability->id] = $otherLongTermLiability->payload;
        });
        
        $totalExistingOtherDebtorsCollection=[];
        $study->otherDebtorsOpeningBalances->each(function (OtherDebtorsOpeningBalance $otherDebtorOpeningBalance) use (&$totalExistingOtherDebtorsCollection) {
            $totalExistingOtherDebtorsCollection[$otherDebtorOpeningBalance->id] = $otherDebtorOpeningBalance->payload;
        });
        
        
        $totalExistingOtherCreditorsPayments=[];
        $study->otherCreditorsOpeningBalances->each(function (OtherCreditsOpeningBalance $otherCreditorOpeningBalance) use (&$totalExistingOtherCreditorsPayments) {
            $totalExistingOtherCreditorsPayments[$otherCreditorOpeningBalance->id] = $otherCreditorOpeningBalance->payload;
        });
    
        $openingBalance = $study->cashAndBankOpeningBalances->first() ;
        $openingCashAmount = $openingBalance ? $openingBalance->cash_and_bank_amount : 0;
        $totalExistingPortfolioInterest = $openingBalance ? $openingBalance->interests : [];
        $totalExistingPortfolioPrinciple = $openingBalance ? $openingBalance->payload : [];
        $totalExistingPortfolioCollection = HArr::sumAtDates([$totalExistingPortfolioInterest ,$totalExistingPortfolioPrinciple ], $sumKeys);
        
        
        
        $supplierPayableOpeningBalance = $study->supplierPayableOpeningBalances->first() ;
        // $openingCashAmount = $openingBalance ? $openingBalance->cash_and_bank_amount : 0;
        $totalExistingPortfolioLoansInterest = $supplierPayableOpeningBalance ? $supplierPayableOpeningBalance->portfolio_interest_expenses : [];
        $totalExistingPortfolioLoansPrinciple = $supplierPayableOpeningBalance ? $supplierPayableOpeningBalance->payload : [];
        $totalExistingPortfolioLoansPayments = HArr::sumAtDates([$totalExistingPortfolioLoansInterest ,$totalExistingPortfolioLoansPrinciple ], $sumKeys);
        
        
        
        
        DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('cashflow_statement_reports')->where('study_id', $study->id)->update([
                    'other_long_term_asset_collections'=>json_encode($totalOtherLongTermAssetOpeningBalances),
                    'total_other_long_term_asset_collections'=>json_encode(HArr::sumAtDates(array_values($totalOtherLongTermAssetOpeningBalances), $sumKeys)),
                    'opening_cash'=>$openingCashAmount,
                    'existing_portfolio_collection'=>$totalExistingPortfolioCollection,
                    'existing_other_debtors_collection'=>$totalExistingOtherDebtorsCollection,
                    'total_existing_other_debtors_collection'=>json_encode(HArr::sumAtDates(array_values($totalExistingOtherDebtorsCollection), $sumKeys)),
                    'existing_portfolio_loans_payment'=>$totalExistingPortfolioLoansPayments,
                    'existing_other_creditors_payment'=>$totalExistingOtherCreditorsPayments,
                    'total_existing_other_creditors_payment'=>json_encode(HArr::sumAtDates(array_values($totalExistingOtherCreditorsPayments), $sumKeys)),
                    'existing_long_term_loans_payment'=>$totalExistingLongTermLoansPayments,
                    'total_existing_long_term_loans_payment'=>json_encode(HArr::sumAtDates(array_values($totalExistingLongTermLoansPayments), $sumKeys)),
                    'existing_other_long_term_liabilities_payment'=>$existingOtherLongTermLiabilitiesPayment,
                    'total_existing_other_long_term_liabilities_payment'=>json_encode(HArr::sumAtDates(array_values($existingOtherLongTermLiabilitiesPayment), $sumKeys))
        ]);
        
        
        
        DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('income_statement_reports')->where('study_id', $study->id)->update([
                'existing_loans_interests_expense'=>json_encode($longTermLoanOpeningBalanceInterests)
        ]);
        // dd($request->all());
        return redirect()->route('view.non.banking.forecast.income.statement', ['company'=>$company->id,'study'=>$study->id]);
    
    }
    public function getCommonData(Request $request, Company $company)
    {
        return [
            'name'=>$request->get('name'),
            'company_id'=>$company->id ,
        ];
    }
    
    
    
    

}
