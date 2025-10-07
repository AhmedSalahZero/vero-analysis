<?php
namespace App\Models\Traits\Scopes;


use App\Helpers\HArr;
use App\Models\NonBankingService\FixedAsset;
use App\ReadyFunctions\CalculateFixedLoanAtBeginningService;
use App\ReadyFunctions\CalculateFixedLoanAtEndService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait HasFixedAsset
{
	//  public function storeFixedLoansForFixedAssets(string $fixedAssetType, $isSensitivity = false):void
    // {
    //     $loanSchedulePaymentTableName = $isSensitivity ? 'sensitivity_fixed_assets_loan_schedule_payments' : 'fixed_assets_loan_schedule_payments';
    //     $fixedAssetsFundingStructure = $this->getFixedAssetStructureForFixAssetType($fixedAssetType);
    //     $loanAmounts = $fixedAssetsFundingStructure ? $fixedAssetsFundingStructure->getFfeAmounts() : 0;
    //     $calculateFixedLoanAtEndService = new CalculateFixedLoanAtEndService ;
    //     $calculateFixedLoanAtBeginningService = new CalculateFixedLoanAtBeginningService ;
    //     $portfolioLoans = [];
    //     $studyId  = $this->id ;
    //     $companyId = $this->company->id ;
    //     $study = $this ;
    //     $operationDurationPerYear=$study->getOperationDurationPerYearFromIndexes();

    //     // $leasingRevenueStreams =$study->{$relationName};
    //     $generalAndReserveAssumption = $study->generalAndReserveAssumption;
     
        
    //     /**
    //      * @var GeneralAndReserveAssumption $generalAndReserveAssumption
    //      */
    //     $dateIndexWithDate = app('dateIndexWithDate');
    //     $dateWithDateIndex = app('dateWithDateIndex');
    //     $yearIndexWithYear = app('yearIndexWithYear');

    //     $baseRates = $generalAndReserveAssumption->getCbeLendingCorridorRates() ;
    //     $pricingPerMonths = $fixedAssetsFundingStructure ? $fixedAssetsFundingStructure->getInterestRates(): null;
    //     $baseRatesPerMonths= [];
    //     foreach ($operationDurationPerYear as $yearIndex => $yearMonthIndexes) {
    //         foreach ($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne) {
    //             $yearOrMonthIndex = $this->isMonthlyStudy() ? $monthIndex : $yearIndex;
    //             $baseRatesPerMonths[Carbon::make($dateIndexWithDate[$monthIndex])->format('Y-m-d')] = $baseRates[$yearOrMonthIndex];
    //         }
    //     }
    //     DB::connection('non_banking_service')->table($loanSchedulePaymentTableName)
    //     // ->where('revenue_stream_type',$revenueStreamType)
    //     ->where('study_id', $studyId)->where('fixed_asset_type', $fixedAssetType)->delete();
        
    //     $baseRatesMapping = HArr::getFirstOfYear($baseRatesPerMonths);
    //     $bankLendingMarginRates=$generalAndReserveAssumption->getBankLendingMarginRates();

        
        
    //     $baseRatesMapping = HArr::isAllValuesEqual($baseRatesMapping, $bankLendingMarginRates);
    //     $totalMonthlyLoanAmounts = [];
    //     // $time = 0 ;
    
        
    //     foreach ($operationDurationPerYear as $yearIndex => $yearMonthIndexes) {
    //         $baseRatesMapping = is_array($baseRatesMapping) ? HArr::filterByYearIndex($baseRatesMapping, $yearIndexWithYear, $yearIndex, $dateIndexWithDate[$monthIndex], $this->isMonthlyStudy()) : $baseRatesMapping;
            
    //         foreach ($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne) {
    //             $yearOrMonthIndex = $this->isMonthlyStudy() ? $monthIndex : $yearIndex;
    //             $currentMonthlyLoanAmount = $loanAmounts[$monthIndex]??0;
    //             // foreach($loanAmounts as  $monthIndexWithAmount ){
    //             // $currentMonthlyLoanAmount = $monthIndexWithAmount[$monthIndex]??0 ;
        
                        
    //             if ($currentMonthlyLoanAmount <= 0) {
    //                 continue ;
    //             }
    //             $totalMonthlyLoanAmounts[$monthIndex]  = isset($totalMonthlyLoanAmount[$monthIndex]) ? $totalMonthlyLoanAmount[$monthIndex] +  $currentMonthlyLoanAmount : $currentMonthlyLoanAmount ;
                        
    //             $currentMonth = $dateIndexWithDate[$monthIndex];
    //             // $currentMonthFormatted = Carbon::make($currentMonth)->format('d-m-Y');
                        
                    
    //             $gracePeriod = $fixedAssetsFundingStructure? $fixedAssetsFundingStructure->getGracePeriodAtMonthIndex($monthIndex):0;
    //             $tenor = $fixedAssetsFundingStructure ? $fixedAssetsFundingStructure->getTenorsAtMonthIndex($monthIndex) : 0;
    //             if ($tenor <=0) {
    //                 continue ;
    //             }
    //             $installmentInterval = $fixedAssetsFundingStructure ? $fixedAssetsFundingStructure->getInstallmentIntervalAtMonthIndex($monthIndex):null;
    //             // $installmentPaymentIntervalValue = $calculateFixedLoanAtEndService->getInstallmentPaymentIntervalValue($installmentInterval);
    //             $stepUp = 0;
    //             $stepDown = 0;
    //             $stepInterval =null;
    //             $loanType = 'normal';
    //             // $loanNature = $leasingRevenueStreamBreakdown->getLoanNature();
    //             // $loanService = $loanNature == 'fixed-at-end' ? $calculateFixedLoanAtEndService : $calculateFixedLoanAtBeginningService ;
    //             $loanService = $calculateFixedLoanAtEndService ;
                        
    //             $newLoanFundingRate = $fixedAssetsFundingStructure->getNewLoansFundingRatesAtMonthIndex($monthIndex);
                            
    //             $currentMarginRate = $generalAndReserveAssumption->getBankLendingMarginRatesAtYearOrMonthIndex($yearOrMonthIndex);
    //             $currentMonthlyLoanAmount = $totalMonthlyLoanAmounts[$monthIndex];
    //             $currentMonthlyLoanAmount = $currentMonthlyLoanAmount * $newLoanFundingRate / 100 ;
                        
    //             // if(is_array($baseRatesMapping)){
    //             // 	$currentPortfolioLoans=$loanService->__calculateBasedOnDiffBaseRates($baseRatesMapping ,$loanType, $currentMonth, $currentMonthlyLoanAmount,  $currentMarginRate,  $tenor, $installmentInterval,$installmentPaymentIntervalValue, $stepUp, $stepInterval ,$stepDown ,  $stepInterval ,$gracePeriod,$monthIndex,$dateWithDateIndex,$dateIndexWithDate );
    //             // }else{
                                
    //             $currentLoanArr=$loanService->__calculate([], -1, $loanType, $currentMonth, $currentMonthlyLoanAmount, $baseRatesMapping, $currentMarginRate, $tenor, $installmentInterval, $stepUp, $stepInterval, $stepDown, $stepInterval, $gracePeriod, $monthIndex, null, $pricingPerMonths);
    //             $finalResult = $currentLoanArr['final_result']??[];
    //             unset($finalResult['totals']);
    //             $currentLoanArr = $finalResult;
                                
                            
                
    //             // }
    //             if (isset($currentLoanArr) && count($currentLoanArr)) {
    //                 $currentLoanArr['study_id'] = $studyId ;
    //                 $currentLoanArr['company_id'] = $companyId ;
    //                 $currentLoanArr['month_as_index'] = $monthIndex ;
    //                 $currentLoanArr['fixed_asset_type'] = $fixedAssetType ;
    //                 // $currentLoanArr['portfolio_loan_type'] ='bank_portfolio';
    //                 $portfolioLoans[]=collect($currentLoanArr)->map(function ($item, $keyName) {
    //                     if (is_array($item)) {
    //                         return json_encode($item);
    //                     }
    //                     return $item;
    //                 })->toArray();
    //             }
                            
                            
                        
                    
                        
                        
                        
                        
                        
                    
    //             // }
    //         }
    //     }
    //     DB::connection('non_banking_service')->table($loanSchedulePaymentTableName)->insert($portfolioLoans);
    // }
	public function getFixedAssetStructureForFixAssetType(string $fixedAssetType)
    {
        if ($fixedAssetType == FixedAsset::FFE) {
            return $this->generalFixedAssetsFundingStructure;
        } elseif ($fixedAssetType == FixedAsset::NEW_BRANCH) {
            return $this->newBranchFixedAssetsFundingStructure;
        } elseif ($fixedAssetType == FixedAsset::PER_EMPLOYEE) {
            return $this->perEmployeeFixedAssetsFundingStructure;
        }
        dd('not supported fixed asset type');
        // return $this->fixedAssetsFundingStructure->where('fixed_asset_type',$fixedAssetType)->first();
    }
	
} 
