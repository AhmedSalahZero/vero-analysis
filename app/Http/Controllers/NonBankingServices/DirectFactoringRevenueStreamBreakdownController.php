<?php

namespace App\Http\Controllers\NonBankingServices;

use App\Helpers\HArr;
use App\Http\Controllers\Controller;
use App\Http\Requests\NonBankingServices\StoreDirectFactoringRevenueStreamRequest;
use App\Models\Company;
use App\Models\NonBankingService\DirectFactoringBreakdown;
use App\Models\NonBankingService\Study;
use App\Traits\NonBankingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DirectFactoringRevenueStreamBreakdownController extends Controller
{
	use NonBankingService ;
	public function create(Company $company , Request $request,Study $study){
		$directFactoringEclAndNewPortfolioFundingRate = $study?  $study->directFactoringEclAndNewPortfolioFundingRate : null;
		$viewVars =  [
			'company'=>$company ,
			'study'=>$study,
			'model'=>$study ,
			'directFactoringEclAndNewPortfolioFundingRate'=>$directFactoringEclAndNewPortfolioFundingRate,
			'title'=>__('Direct Factoring Revenue Stream Breakdown'),
			'storeRoute'=>route('store.direct.factoring.revenue.stream.breakdown',['company'=>$company->id , 'study'=>$study->id]),
			'yearsWithItsMonths' => $study->getOperationDurationPerYearFromIndexes(),
		];
		return view( 'non_banking_services.direct-factoring-revenue-stream-breakdown.form', $viewVars);
	}
	public function getRepeaterRelations():array 
	{
		return [
			'directFactoringBreakdowns'
		];
	}
	
	public function store(Company $company , StoreDirectFactoringRevenueStreamRequest $request,Study $study)
	{
			$studyHasDirectFactoringBreakdowns = $study->refresh()->directFactoringBreakdowns->count(); 
			$study->storeRelationsWithNoRepeater($request,$company);
			$study->storeRepeaterRelations($request,$this->getRepeaterRelations(),$company);
			$generalAndReserveAssumption = $study->generalAndReserveAssumption;
			$baseRates = $generalAndReserveAssumption->getCbeLendingCorridorRates() ;
			$bankMarginRates = $generalAndReserveAssumption->getBankLendingMarginRates() ;
			$datesIndexWithYearIndex = app()->make('datesIndexWithYearIndex');
			$dateIndexWithDates = app()->make('dateIndexWithDate');
			$result = [];
			foreach($study->refresh()->directFactoringBreakdowns as $directFactoringBreakdown){
				/**
				 * @var DirectFactoringBreakdown $directFactoringBreakdown
				 */
				$directFactoringBreakdownId = $directFactoringBreakdown->id ;
				$amountAsPayload = $directFactoringBreakdown->getLoanAmountPayload();
				$currentMarginRate = $directFactoringBreakdown->getMarginRate();
				$category = $directFactoringBreakdown->getCategory();
				$directFactoringAmounts = $study->convertYearToMonthIndexesAndDivideBySumMonths($amountAsPayload);
				$baseRates = $study->convertYearToMonthIndexes($baseRates);
				$currentBeginningBalance = 0 ;
				$currentDirectFactoringBankBeginningBalance= 0 ;
				$currentBankInterestExpensePayment= 0 ;
				$factoringInterestRevenue = [];
				$directFactoringStatements[$directFactoringBreakdownId] = [];
				$directFactoringNetFundingAmounts = [];
				$directFactoringBankLoanStatements = [];
				$currentDirectFactoringBeginningBalance = 0 ;
				foreach($directFactoringAmounts as $monthIndex => $currentDirectAmount){
					$currentYearIndex = $datesIndexWithYearIndex[$monthIndex];
					 $currentDateAsString = $dateIndexWithDates[$monthIndex];
					 $currentDaysInMonth = Carbon::make($currentDateAsString)->daysInMonth;
					$currentBaseRate = $baseRates[$monthIndex];
					$currentBankMarginRate = $bankMarginRates[$currentYearIndex];
					$bankInterestRate = ($currentBaseRate + $currentBankMarginRate)/100  ;
					$currentDailyPricing = ($currentMarginRate  + $currentBaseRate) /100 / 360; 
					$directFactoringStatements[$directFactoringBreakdownId]['beginning_balance'][$monthIndex] = $currentDirectFactoringBeginningBalance + $currentDirectAmount ;
					$directFactoringStatements[$directFactoringBreakdownId]['direct_factoring_settlements'][$monthIndex +  ceil($category/30) ] = $currentDirectAmount;
					$currentMonthSettlement = $directFactoringStatements[$directFactoringBreakdownId]['direct_factoring_settlements'][$monthIndex] ?? 0;
					$directFactoringStatements[$directFactoringBreakdownId]['end_balance'][$monthIndex] = $currentDirectFactoringBeginningBalance + $currentDirectAmount - $currentMonthSettlement ;
					$currentDirectFactoringBeginningBalance = $directFactoringStatements[$directFactoringBreakdownId]['end_balance'][$monthIndex] ;
					
					$unearned = [];
						foreach(HArr::getMonthsAsArray($category) as $index => $currentMonthNumber){
							$currentIndex = $monthIndex+$index+1 ;
							$currentAmount = $currentDirectAmount * $currentMonthNumber  * $currentDailyPricing  ;
							$result[$directFactoringBreakdownId][$currentIndex] = isset($result[$directFactoringBreakdownId][$currentIndex]) ? $result[$directFactoringBreakdownId][$currentIndex]+($currentAmount) : $currentAmount;
							$interestRevenues[$currentIndex] = $result[$directFactoringBreakdownId][$currentIndex] ;
							$unearned[$monthIndex] = isset($unearned[$monthIndex]) ? $unearned[$monthIndex] + $currentAmount : $currentAmount;
						}
						$factoringInterestRevenue[$directFactoringBreakdownId]['beginning_balance'][$monthIndex] = $currentBeginningBalance;
						foreach($interestRevenues as $i => $value){
							$factoringInterestRevenue[$directFactoringBreakdownId]['interest_revenue'][$i] = 
							$value;
						}
						
						$factoringInterestRevenue[$directFactoringBreakdownId]['unearned_interest'][$monthIndex] = $unearned[$monthIndex];
						
						$currentDirectFactoringNetFundingAmounts  = $currentDirectAmount -  $unearned[$monthIndex] ;
						$directFactoringNetFundingAmounts[$directFactoringBreakdownId][$monthIndex] = $currentDirectFactoringNetFundingAmounts ;
						if($study->directFactoringNewPortfolioFundingStructure){
							$newLoanFundingRate = (100 - $study->directFactoringNewPortfolioFundingStructure->getEquityFundingRatesAtYearIndex($currentYearIndex))/100 ;
							$currentBankLoanAmount = $currentDirectFactoringNetFundingAmounts * $newLoanFundingRate;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['beginning_balance'][$monthIndex] = $currentDirectFactoringBankBeginningBalance ;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_amounts'][$monthIndex] = $currentBankLoanAmount;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_settlements'][$monthIndex +  ceil($category/30) ] = $currentBankLoanAmount;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense_payments'][$monthIndex] = $currentBankInterestExpensePayment;
							$currentBankLoanSettlementAtCurrentMonth = $directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_settlements'][$monthIndex]??0;
							$totalDues = $currentDirectFactoringBankBeginningBalance + $currentBankLoanAmount - $currentBankLoanSettlementAtCurrentMonth - $currentBankInterestExpensePayment;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['total_dues'][$monthIndex] = $totalDues;
							$interestExpense = $totalDues * $currentDaysInMonth * $bankInterestRate  / 360 ;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense'][$monthIndex] = $interestExpense;
							$currentBankInterestExpensePayment = $interestExpense;
							$endBalance = $totalDues + $interestExpense ;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['end_balance'][$monthIndex] = $endBalance;
							$currentDirectFactoringBankBeginningBalance = $endBalance ;
							
						}
						
						
						$currentInterestRevenueAtMonthIndex = $factoringInterestRevenue[$directFactoringBreakdownId]['interest_revenue'][$monthIndex]??0;
						$currentEndBalance = $currentBeginningBalance + $currentInterestRevenueAtMonthIndex - $factoringInterestRevenue[$directFactoringBreakdownId]['unearned_interest'][$monthIndex]  ; 
						$factoringInterestRevenue[$directFactoringBreakdownId]['end_balance'][$monthIndex] =   $currentEndBalance;
						
						$currentBeginningBalance = $currentEndBalance ;
					}
				
					$directFactoringBreakdown->update([
						'beginning_balance' => $factoringInterestRevenue[$directFactoringBreakdownId]['beginning_balance'],
						'interest_revenue' => $factoringInterestRevenue[$directFactoringBreakdownId]['interest_revenue'],
						'unearned_interest' => $factoringInterestRevenue[$directFactoringBreakdownId]['unearned_interest'],
						'end_balance' => $factoringInterestRevenue[$directFactoringBreakdownId]['end_balance'],
						'net_funding_amounts'=>$directFactoringNetFundingAmounts[$directFactoringBreakdownId],
						
						'statement_beginning_balance'=>$directFactoringStatements[$directFactoringBreakdownId]['beginning_balance'],
						'direct_factoring_amounts'=>$directFactoringAmounts,
						'direct_factoring_settlements'=>$directFactoringStatements[$directFactoringBreakdownId]['direct_factoring_settlements'],
						'statement_end_balance'=>$directFactoringStatements[$directFactoringBreakdownId]['end_balance'],
						
						
						'bank_beginning_balance'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['beginning_balance']??[],
						'bank_loan_amounts'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_amounts']??[],
						'bank_loan_settlements'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_settlements']??[],
						'bank_interest_expense_payments'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense_payments']??[],
						'bank_total_dues'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['total_dues']??[],
						'bank_interest_expense'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense']??[],
						'bank_end_balance'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['end_balance']??[],
						]);
				
			}
	
			$study->updateExpensesOfSales();
			
		if($studyHasDirectFactoringBreakdowns){
			return response()->json([
				'redirectTo'=>route('create.reverse.factoring.revenue.stream.breakdown',['company'=>$company->id,'study'=>$study->id])
			]);	
		}
		return response()->json([
			'redirectTo'=>route('create.direct.factoring.revenue.stream.breakdown',['company'=>$company->id,'study'=>$study->id]) 
			// .'#new-funding-id'
		]);
		
	}
}
