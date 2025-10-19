<?php 
namespace App\ReadyFunctions;

use App\Helpers\HArr;
use App\Models\NonBankingService\Study;
use Illuminate\Support\Facades\DB;

class PortfolioPresentValue 
{
	protected function calculateOccurrenceDates(array $operationDurationPerYearFromIndexes , array $startFromPerYear ,  array $frequencyPerYear)
	{
		$occurrenceDates = [];
		foreach($operationDurationPerYearFromIndexes  as $currentYearIndex => $months){
				$currentStartFrom = $startFromPerYear[$currentYearIndex];
				$currentFrequency = $frequencyPerYear[$currentYearIndex];
				$lastMonthIndexInCurrentYear =  array_key_last($months);
				if($currentFrequency == 0){
					$occurrenceDates[$currentYearIndex][] = $currentStartFrom;
				}else{
					for($i = $currentStartFrom  ; $i <=$lastMonthIndexInCurrentYear ; $i += $currentFrequency ){
						$occurrenceDates[$currentYearIndex][] = $i ; 
					}
				}
			}
			dd($occurrenceDates);
			return $occurrenceDates;
			
	}
	public function calculate(array $monthlyStudyOccurrenceDates,Study $study , array $dateIndexWithDate ,array $portfolioLoanFundingRatesPerMonths , array $operationDurationPerYearFromIndexes,int $tenorInYears,array $startFromPerYear , array $frequencyPerYear,array $portfolioMortgageTransactionAmountsPerYears,array $cbeLendingRatesPerMonths,float $marginRate,array $bankMarginRates , int $companyId , int $studyId , int $portfolioMortgageCategoryId):array 
	{
		
		DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('study_id',$studyId)->where('revenue_stream_type',Study::PORTFOLIO_MORTGAGE)->where('revenue_stream_id',$portfolioMortgageCategoryId)->delete();
					$portfolioMortgageLoanSchedulePayments = [];
			$bankPortfolioLoans=[];
			$currentUnearnedInterestStatement = [];
			$calculateFixedLoanAtEndService = new CalculateFixedLoanAtEndService; 
			$monthlyAmounts=[];
			$loanType = 'normal' ;
			$tenorInMonths = $tenorInYears *12;
			$installmentPaymentIntervalName='monthly';
			$accumulatedMonthsAmountsDueDates = [];
			$isMonthlyStudy = $study->isMonthlyStudy() ; 
			$occurrenceDates =  $isMonthlyStudy ? $monthlyStudyOccurrenceDates :   $this->calculateOccurrenceDates( $operationDurationPerYearFromIndexes ,  $startFromPerYear ,   $frequencyPerYear);
			foreach($occurrenceDates as $currentYearIndex=>$occurrenceIndexesAndDates){
				$currentYearAmount =  $portfolioMortgageTransactionAmountsPerYears[$currentYearIndex]??0;
				 
				foreach($occurrenceIndexesAndDates as $currentOccurrenceMonthIndex){
					$currentYearAmount = $isMonthlyStudy ? $portfolioMortgageTransactionAmountsPerYears[$currentOccurrenceMonthIndex] : $currentYearAmount;
					$monthlyAmounts[$currentOccurrenceMonthIndex] = $currentYearAmount;
				}
			
			}
			$totalPortfoliosMortgageEndBalances = [];
			$portfolioInterestAmounts =[];
			
			foreach($monthlyAmounts as $currentOccurrenceMonthIndex => &$currentOccurrenceAvgAmount){
				if($currentOccurrenceAvgAmount == 0){
					continue ;
				}
		
				$totalNetPresentValue = 0 ;
				$totalInterestAmount= 0;
				$schedulePaymentAmount = $currentOccurrenceAvgAmount  / $tenorInMonths ;
				$currentBaseRate = $cbeLendingRatesPerMonths[$currentOccurrenceMonthIndex] ;
				$currentPricingAtOccurrenceIndex = ($currentBaseRate + $marginRate) / 100;
				$currentMonthlyInterest =  $currentPricingAtOccurrenceIndex / 12  ;
				$isFirstLoop = true ;
				for($i = 0 ; $i<= $tenorInMonths ; $i++ ){
					$currentMonthsCount = $i ;
					$currentSchedulePaymentAmount = $isFirstLoop ? 0 :  $schedulePaymentAmount;
					
					$currentNetPresetValue = $currentSchedulePaymentAmount / pow(1+$currentMonthlyInterest,$currentMonthsCount); 
					$currentInterestAmount = $currentSchedulePaymentAmount -  $currentNetPresetValue ;
					$currentPrincipleAmount = $currentSchedulePaymentAmount - $currentInterestAmount ;
					$endBalance = $currentOccurrenceAvgAmount - $currentSchedulePaymentAmount;
					$totalNetPresentValue += $currentNetPresetValue;
					// $portfolioMortgageStatement[$i+$currentOccurrenceMonthIndex] = [
					// 	'month_as_index'=>$currentOccurrenceMonthIndex,
					// 	'beginning'=>$currentOccurrenceAvgAmount,
					// 	'interestAmount'=>$currentInterestAmount,
					// 	'schedulePayment'=>   $currentSchedulePaymentAmount ,
					// 	'principleAmount'=>$currentPrincipleAmount ,
					// 	'endBalance'=>$endBalance
					// ];
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['beginning'][$i+$currentOccurrenceMonthIndex] = $currentOccurrenceAvgAmount ;
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['interestAmount'][$i+$currentOccurrenceMonthIndex] = $currentInterestAmount ;
					$portfolioInterestAmounts[$currentOccurrenceMonthIndex][$i+$currentOccurrenceMonthIndex] = $currentInterestAmount;
					$totalInterestAmount+= $currentInterestAmount;
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['schedulePayment'][$i+$currentOccurrenceMonthIndex] = $currentSchedulePaymentAmount ;
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['principleAmount'][$i+$currentOccurrenceMonthIndex] = $currentPrincipleAmount ;
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['endBalance'][$i+$currentOccurrenceMonthIndex] = $endBalance ;
					$totalPortfoliosMortgageEndBalances[$i+$currentOccurrenceMonthIndex] = isset($totalPortfoliosMortgageEndBalances[$i+$currentOccurrenceMonthIndex]) ? $totalPortfoliosMortgageEndBalances[$i+$currentOccurrenceMonthIndex] + $endBalance : $endBalance;
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['revenue_stream_type'] = Study::PORTFOLIO_MORTGAGE ;
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['portfolio_loan_type'] = 'portfolio' ;
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['revenue_stream_id'] = $portfolioMortgageCategoryId ;
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['study_id'] = $studyId ;
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['company_id'] = $companyId ;
					$portfolioMortgageLoanSchedulePayments[$currentOccurrenceMonthIndex]['month_as_index'] = $i+$currentOccurrenceMonthIndex ;
					$isFirstLoop = false ;
					$currentOccurrenceAvgAmount = $endBalance;
					// logger($isFirstLoop ? 1 :0);
					// dd($currentSchedulePaymentAmount,$currentPricingAtOccurrenceIndex,$currentInterestAmount);
						
				//	$currentUnearnedInterest = $currentSchedulePaymentAmount-$currentNetPresetValue;
					// $currentMonthsAmountsDueDates[$currentOccurrenceMonthIndex][$currentOccurrenceMonthIndex+$i] = [
					// 	'schedule_payment'=>$currentSchedulePaymentAmount,
					// 	'month_counts'=>$currentMonthsCount,
					// 	'net_present_value'=>$currentNetPresetValue,
					// 	'unearned_interest'=> $currentUnearnedInterest 
					// ]; 
					
				}
					
					$portfolioLoanFundingRatesAtOccurrenceMonthIndex = $portfolioLoanFundingRatesPerMonths[$currentOccurrenceMonthIndex] / 100;
					$accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['net_present_value'] = $totalNetPresentValue;
					$accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['bank_loan_amount'] = $totalNetPresentValue * $portfolioLoanFundingRatesAtOccurrenceMonthIndex;
					$accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['unearned_interest'] = $totalInterestAmount;
					$accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['base_rate'] = $currentBaseRate ;
					// $accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['margin_rate'] = $marginRate ;	
					
			}
	
			// $portfolioInterestAmounts = $portfolioMortgageLoanSchedulePayments['interestAmount']??[];
			 $this->calculateMonthlyAmounts( $portfolioInterestAmounts , $bankMarginRates,$tenorInMonths,$installmentPaymentIntervalName,$loanType,$dateIndexWithDate,$currentUnearnedInterestStatement,$accumulatedMonthsAmountsDueDates,$bankPortfolioLoans,$calculateFixedLoanAtEndService,$portfolioMortgageCategoryId,$studyId,$companyId);
			 foreach($portfolioMortgageLoanSchedulePayments as $occurrenceDate => &$portfolioMortgageLoanSchedulePayment){
				foreach($portfolioMortgageLoanSchedulePayment as $key => &$value){
					if(is_array($value)){
						$value = json_encode($value);
					}
				}
			 }
			//  dd($portfolioMortgageLoanSchedulePayments);
			//  $portfolioMortgageLoanSchedulePayments
			 DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->insert(array_values($portfolioMortgageLoanSchedulePayments));
			 DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->insert($bankPortfolioLoans);
			$study->recalculateMonthlyAndAccumulatedEcl(Study::PORTFOLIO_MORTGAGE ,$totalPortfoliosMortgageEndBalances );

			return [
				'occurrence_dates'=>$occurrenceDates,
				'statement'=>$accumulatedMonthsAmountsDueDates,
				'portfolio_mortgage_unearned_interest_statement'=>$currentUnearnedInterestStatement,
				'loan_amounts'=>$monthlyAmounts
			];
	
	}
	// public function calculateForMonthlyStudy(array $bankMarginRates,Study $study , array $monthlyAmounts , array $cbeLendingRatesPerMonths,array $portfolioLoanFundingRatesPerMonths,float $marginRate,int $tenorInYears ,array $dateIndexWithDate   , int $portfolioMortgageCategoryId,int $studyId, int $companyId):array 
	// {
		
	// 	DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('study_id',$studyId)->where('revenue_stream_type',Study::PORTFOLIO_MORTGAGE)->where('revenue_stream_id',$portfolioMortgageCategoryId)->delete();
					
	// 	$portfolioLoans=[];
	// 	$currentUnearnedInterestStatement = [];
	// 		$calculateFixedLoanAtEndService = new CalculateFixedLoanAtEndService; 
	// 		$loanType = 'normal' ;
	// 		$tenorInMonths = $tenorInYears *12;
	// 		$installmentPaymentIntervalName='monthly';
	// 		$accumulatedMonthsAmountsDueDates = [];
	// 		$occurrenceDates = [];
			
	// 		foreach($monthlyAmounts as $currentOccurrenceMonthIndex => $currentOccurrenceAvgAmount){
	// 			$currentOccurrenceAvgAmount = $currentOccurrenceAvgAmount / $tenorInMonths ; 
	// 			if($currentOccurrenceAvgAmount > 0){
	// 				$occurrenceDates[] = $currentOccurrenceMonthIndex;
	// 			}
	// 			for($i = 1 ; $i<= $tenorInMonths ; $i++ ){
	// 				$currentBaseRate = $cbeLendingRatesPerMonths[$currentOccurrenceMonthIndex];
	// 				$currentPricingAtOccurrenceIndex = ($currentBaseRate + $marginRate) / 100;
	// 				$currentMonthlyInterest =  $currentPricingAtOccurrenceIndex / 12 ;
	// 				$currentMonthsCount = ($currentOccurrenceMonthIndex+$i -$currentOccurrenceMonthIndex  ) ;
	// 				$currentNetPresetValue = $currentOccurrenceAvgAmount / pow(1+$currentMonthlyInterest,$currentMonthsCount);  
	// 				$currentUnearnedInterest = $currentOccurrenceAvgAmount-$currentNetPresetValue;
	// 				$currentMonthsAmountsDueDates[$currentOccurrenceMonthIndex][$currentOccurrenceMonthIndex+$i] = [
	// 					'schedule_payment'=>$currentOccurrenceAvgAmount,
	// 					'month_counts'=>$currentMonthsCount,
	// 					'net_present_value'=>$currentNetPresetValue,
	// 					'unearned_interest'=> $currentUnearnedInterest 
	// 				]; 
	// 				$portfolioLoanFundingRatesAtOccurrenceMonthIndex = $portfolioLoanFundingRatesPerMonths[$currentOccurrenceMonthIndex] / 100;
	// 				$accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['net_present_value'] = isset($accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['net_present_value']) ? $accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['net_present_value'] + $currentNetPresetValue : $currentNetPresetValue;
	// 				$accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['bank_loan_amount'] = $accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['net_present_value'] * $portfolioLoanFundingRatesAtOccurrenceMonthIndex;
	// 				$accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['unearned_interest'] = isset($accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['unearned_interest']) ? $accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['unearned_interest'] + $currentUnearnedInterest : $currentUnearnedInterest;
	// 				$accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['schedule_payment'] =  $currentOccurrenceAvgAmount;
	// 				$accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['base_rate'] = $currentBaseRate ;
	// 				$accumulatedMonthsAmountsDueDates[$currentOccurrenceMonthIndex]['margin_rate'] = $marginRate ;	
	// 			}
	// 		}
			
 	// 	$totalPortfolioEndBalance = $this->calculateMonthlyAmounts($bankMarginRates,$study,$tenorInMonths,$installmentPaymentIntervalName,$loanType,$dateIndexWithDate,$currentUnearnedInterestStatement,$accumulatedMonthsAmountsDueDates,$portfolioLoans,$calculateFixedLoanAtEndService,$portfolioMortgageCategoryId,$studyId,$companyId);

		
	// 	DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->insert(
	// 			$portfolioLoans
	// 		);
			
	// 		$study->recalculateMonthlyAndAccumulatedEcl(Study::PORTFOLIO_MORTGAGE ,$totalPortfolioEndBalance );
	// 		return [
	// 			/**
	// 			 * * في حاله لو مفرودة شهور يبقي هناخد الشهور اللي كتب فيها ارقام
	// 			 */
	// 			'occurrence_dates'=>$occurrenceDates,
	// 			'statement'=>$accumulatedMonthsAmountsDueDates,
	// 			'portfolio_mortgage_unearned_interest_statement'=>$currentUnearnedInterestStatement,
	// 			'loan_amounts'=>$monthlyAmounts
	// 		];
	// }
	protected function calculateMonthlyAmounts(array $portfolioInterestAmounts , array $bankMarginRates ,$tenorInMonths,$installmentPaymentIntervalName,string $loanType,array $dateIndexWithDate,array &$currentUnearnedInterestStatement,array &$accumulatedMonthsAmountsDueDates ,array &$bankPortfolioLoans , CalculateFixedLoanAtEndService $calculateFixedLoanAtEndService , int $portfolioMortgageCategoryId,int $studyId, int $companyId ):void
	{
	//	 $totalPortfolioEndBalance = [];
	//	   $operationDates = range($study->getOperationStartDateAsIndex(), $study->getStudyEndDateAsIndex());

		foreach($accumulatedMonthsAmountsDueDates as $currentOccurrenceMonthIndex => $portfolioMortgageLoanArray){
				$currentBankMarginRate = $bankMarginRates[$currentOccurrenceMonthIndex]??0;
				$currentLoanDateAsString = $dateIndexWithDate[$currentOccurrenceMonthIndex];
		//		$currentLoanAmount = $portfolioMortgageLoanArray['net_present_value'];
				
				$currentBankLoanAmount = $portfolioMortgageLoanArray['bank_loan_amount'];
			
				$currentBaseRate = $portfolioMortgageLoanArray['base_rate'];
			//	$currentMarginRate = $portfolioMortgageLoanArray['margin_rate'];
				$currentUnearnedInterest = $portfolioMortgageLoanArray['unearned_interest'];
				$currentDaysCount = 30 ;
				
				// $portfolioLoanAmounts[$currentOccurrenceMonthIndex]=$calculateFixedLoanAtEndService->__calculate([],-1,$loanType,$currentLoanDateAsString,$currentLoanAmount,$currentBaseRate,$currentMarginRate,$tenorInMonths,$installmentPaymentIntervalName,0,null,0,null,0,$currentOccurrenceMonthIndex,$currentDaysCount)['final_result']??[];
			
				// $portfolioLoanAmountsFormatted = $portfolioLoanAmounts[$currentOccurrenceMonthIndex];
				$bankLoanAmounts[$currentOccurrenceMonthIndex]=$calculateFixedLoanAtEndService->__calculate([],-1,$loanType,$currentLoanDateAsString,$currentBankLoanAmount,$currentBaseRate,$currentBankMarginRate,$tenorInMonths,$installmentPaymentIntervalName,0,null,0,null,0,$currentOccurrenceMonthIndex,$currentDaysCount)['final_result']??[];
				$bankLoanAmountsFormatted=$bankLoanAmounts[$currentOccurrenceMonthIndex];
				
				// if(count($portfolioLoanAmountsFormatted)){
				// 	$portfolioLoanAmountsFormatted['study_id'] = $studyId ;
				// 	$portfolioLoanAmountsFormatted['company_id'] = $companyId ;
				// 	$portfolioLoanAmountsFormatted['month_as_index'] = $currentOccurrenceMonthIndex ;
				// 	$portfolioLoanAmountsFormatted['revenue_stream_id'] =$portfolioMortgageCategoryId ;
				// 	$portfolioLoanAmountsFormatted['revenue_stream_category_id'] =null ;
				// 	$portfolioLoanAmountsFormatted['portfolio_loan_type'] ='portfolio';
				// 	$portfolioLoanAmountsFormatted['revenue_stream_type'] =Study::PORTFOLIO_MORTGAGE;
                //     $totalPortfolioEndBalance = HArr::sumAtDates([$totalPortfolioEndBalance,$portfolioLoanAmountsFormatted['endBalance']??[]], $operationDates);
				// 	$portfolioLoans[]=collect($portfolioLoanAmountsFormatted)->map(function($item,$keyName){
						
				// 		if(is_array($item)){
				// 			return json_encode($item);
				// 		}
				// 		return $item;
				// 	})->toArray();
				// }
				if(count($bankLoanAmountsFormatted)){
					$bankLoanAmountsFormatted['study_id'] = $studyId ;
					$bankLoanAmountsFormatted['company_id'] = $companyId ;
					$bankLoanAmountsFormatted['month_as_index'] = $currentOccurrenceMonthIndex ;
					$bankLoanAmountsFormatted['revenue_stream_id'] =$portfolioMortgageCategoryId ;
					$bankLoanAmountsFormatted['revenue_stream_category_id'] =null ;
					$bankLoanAmountsFormatted['portfolio_loan_type'] ='bank_portfolio';
					$bankLoanAmountsFormatted['revenue_stream_type'] =Study::PORTFOLIO_MORTGAGE;
					
					$bankPortfolioLoans[]=collect($bankLoanAmountsFormatted)->map(function($item,$keyName){
						
						if(is_array($item)){
							return json_encode($item);
						}
						return $item;
					})->toArray();
				}
				
				
				

			//	$interestAmountsAtOccurrenceMonthIndex[$currentOccurrenceMonthIndex]=$portfolioLoanAmounts[$currentOccurrenceMonthIndex]['interestAmount']??[];
				$currentEndUnearnedBeginningBalance = 0 ;
				foreach($portfolioInterestAmounts[$currentOccurrenceMonthIndex] as $currentMonth => $currentInterestAmount){
					$currentEndUnearnedEndBalance = $currentEndUnearnedBeginningBalance + $currentInterestAmount - $currentUnearnedInterest;
					$currentUnearnedInterestStatement[$currentOccurrenceMonthIndex][$currentMonth]['beginning_balance'] = $currentEndUnearnedBeginningBalance;
					$currentUnearnedInterestStatement[$currentOccurrenceMonthIndex][$currentMonth]['interest_amount'] = $currentInterestAmount;
					$currentUnearnedInterestStatement[$currentOccurrenceMonthIndex][$currentMonth]['unearned_interest'] = $currentUnearnedInterest;
					$currentUnearnedInterestStatement[$currentOccurrenceMonthIndex][$currentMonth]['end_balance'] = $currentEndUnearnedEndBalance < 1 && $currentEndUnearnedEndBalance > -1 ? 0 : $currentEndUnearnedEndBalance ;
					$currentEndUnearnedBeginningBalance = $currentEndUnearnedEndBalance;
					$currentUnearnedInterest=0;
				}
			}
		
	}
}
