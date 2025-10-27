<?php 
namespace App\Traits;

use App\Helpers\HArr;

trait HasMultiBaseLoan
{
	 public function __calculateBasedOnDiffBaseRates(array $baseRatesMapping, string $loanType, string $loanStartDate, float $loanAmount, float $marginRate, float $tenor, string $installmentPaymentIntervalName, int $installmentPaymentIntervalValue, float $stepUpRate = 0, string $stepUpIntervalName = null, float $stepDownRate = 0, string $stepDownIntervalName = null, float $gracePeriod  = 0, int $monthIndex = 0, array $datesAsStringAndIndex = [], array $dateWithDateIndex = []):array
    {
        
        $currentStartDateAsIndex=$monthIndex ;
        $originalTenor = $tenor;
        if ($loanAmount <= 0) {
            return [] ;
        }
        $fixedAtEndResult = [];
        $i = 0 ;
        $previousResult = [];
        foreach ($baseRatesMapping as $currentBaseRateDate => $currentBaseRate) {
            if ($i != 0) {
                $currentBaseRateDateAsIndex = $datesAsStringAndIndex[$currentBaseRateDate];
				$gracePeriod = 0;
				if ($tenor >= 1){
					$currentStartDateAsIndex = HArr::getPreviousNonZeroValue($fixedAtEndResult['current_result'][$i-1]['schedulePayment']??[],$currentBaseRateDateAsIndex);
					$loanAmount =$fixedAtEndResult['current_result'][$i-1]['endBalance'][$currentStartDateAsIndex]??0;
					if(is_null($currentStartDateAsIndex)  ){
						$currentStartDateAsIndex = HArr::getNextNonZeroValue($fixedAtEndResult['current_result'][$i-1]['schedulePayment']??[],$currentBaseRateDateAsIndex);
						$loanAmount =$fixedAtEndResult['current_result'][$i-1]['endBalance'][$currentStartDateAsIndex]??0;
						
						if(is_null($currentStartDateAsIndex)){
						
							continue;
						}
						
						
				}
					
			
					}
                $loanStartDate = $dateWithDateIndex[$currentStartDateAsIndex]??null;
				if(is_null($loanStartDate)){
					continue;
				}
                $tenor = $originalTenor -($currentStartDateAsIndex - $monthIndex);
            }
            $currentResultArr = [];
            if ($tenor >= 1) {
                $currentResultArr =$this->__calculate($previousResult, $i, $loanType, $loanStartDate, $loanAmount, $currentBaseRate, $marginRate, $tenor, $installmentPaymentIntervalName, $stepUpRate, $stepUpIntervalName, $stepDownRate, $stepDownIntervalName, $gracePeriod, $currentStartDateAsIndex);
                $previousResult =$currentResultArr['final_result']??[];
                $fixedAtEndResult['current_result'][]= $currentResultArr['result']??[]  ;
                $fixedAtEndResult['final_result']= $currentResultArr['final_result']??[]  ;
                $i++ ;
            }
            
        }
        $finalResult = $fixedAtEndResult['final_result']??[] ;
        unset($finalResult['totals']);
        return $finalResult;
    }
}
