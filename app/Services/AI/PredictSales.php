<?php 
namespace App\Services\AI;

use App\Helpers\HArr;
use App\Models\Company;
use App\Models\SalesGathering;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PredictSales
{
	public function execute(Request $request, Company $company,$type,$endDate)
    {
		
        // enhanced in sales dashboard // salah
  
		$startDate = Carbon::make($endDate)->startOfMonth()->subMonthNoOverflow(24)->format('Y-m-d') ;
	
        $data = [];
        $main_data = SalesGathering::company($request)
                                    ->whereBetween('date', [$startDate, $endDate])
									// ->where($type,'!=',null)
                                    // ->limit(10)
                                    ->selectRaw('DATE_FORMAT(LAST_DAY(date),"%d-%m-%Y") as gr_date,DATE_FORMAT(date,"%Y") as year,net_sales_value,'.$type)->orderBy('date')
                                    ->get();
									
									$totalsPerDates = $main_data->groupBy('gr_date')->map(function($sub_item){
										return $sub_item->sum('net_sales_value');
									})->toArray() ;
							
									
									$lastAndGrowthRateForCompanyArr = $this->getLastAndGrowthRateForCompany($totalsPerDates,$endDate );
									// dd($lastAndGrowthRateForCompanyArr);
									// $last12AvgForCompany = $lastAndGrowthRateForCompanyArr['last_12_avg'];
									// $last24AvgForCompany = $lastAndGrowthRateForCompanyArr['last_24_avg'];
									$growthRateForCompany = $lastAndGrowthRateForCompanyArr['growth_rate'];
									
									
									$lastAndGrowthRateForItems = [];
          
         		   $data = $main_data->groupBy($type)->map(function($year){
                            return $year->groupBy('gr_date')->map(function($sub_item){
                                return $sub_item->sum('net_sales_value');
                            });
                        })->toArray();
						
						
       foreach($data as $name => $dataItem){
		$currentResult = $this->getLastAndGrowthRateForItem($dataItem,$endDate,$growthRateForCompany,$type,$name) ;
		if(!is_null($currentResult)){
			$lastAndGrowthRateForItems[$name]=$currentResult;
			
		}
	   }
	  
	 	  uasort($lastAndGrowthRateForItems, function ($a, $b) {
				return $b['next0ForecastForItem'] <=> $a['next0ForecastForItem'];
		});
		
		return $lastAndGrowthRateForItems;
       
    }
	
	protected function getLastAndGrowthRateForCompany(array $totalsPerDates,string $endDate  ):array 
	{
		// Get the last 12 keys
		$last12Items = HArr::sliceWithDates($totalsPerDates , $endDate,11);
		$slicedItems = $totalsPerDates ;
		foreach($last12Items as $key => $value){
			unset($slicedItems[$key]);
		}
		$previousOfPrevious12Items = HArr::sliceWithDates($slicedItems , $endDate,23) ;
		$last12ItemsCounter = count($last12Items);
		$sumOfLast6Months = array_sum(HArr::sliceWithDates($last12Items , $endDate,5));
		
		$previousOfPrevious12ItemsCounter = count($previousOfPrevious12Items);
		$last12ItemsAvg = $last12ItemsCounter ? array_sum($last12Items) / $last12ItemsCounter : 0;
		$previousOfPrevious12ItemsAvg =$previousOfPrevious12ItemsCounter ? array_sum($previousOfPrevious12Items) /  $previousOfPrevious12ItemsCounter : 0;
		$growthRateForCompany = $previousOfPrevious12ItemsAvg ? ($last12ItemsAvg / $previousOfPrevious12ItemsAvg) - 1 : 0 ;
		$next1Month = Carbon::make($endDate)->addMonthsNoOverflow(1)->format('Y-m-d');
		$next2Month = Carbon::make($endDate)->addMonthsNoOverflow(2)->format('Y-m-d');
		$next3Month = Carbon::make($endDate)->addMonthsNoOverflow(3)->format('Y-m-d');
		$valueOfMonth = HArr::getValueFromMonthAndYear($last12Items,Carbon::make($endDate)->format('m'),Carbon::make($endDate)->format('Y')) ;
		$next1MonthPercentageValueAtMonth = HArr::getValueFromMonth($last12Items,Carbon::make($next1Month)->format('m'));
		$next1MonthPercentage = array_sum($last12Items) && $sumOfLast6Months != 0  ? $next1MonthPercentageValueAtMonth / array_sum($last12Items) : 0;
		
		$next2MonthPercentageValueAtMonth = HArr::getValueFromMonth($last12Items,Carbon::make($next2Month)->format('m'));
		$next2MonthPercentage = array_sum($last12Items) && $sumOfLast6Months != 0  ? $next2MonthPercentageValueAtMonth / array_sum($last12Items) : 0;
		
		$next3MonthPercentageValueAtMonth = HArr::getValueFromMonth($last12Items,Carbon::make($next3Month)->format('m'));
		$next3MonthPercentage = array_sum($last12Items) && $sumOfLast6Months != 0  ? $next3MonthPercentageValueAtMonth / array_sum($last12Items) : 0;
		
		$next1ForecastForCompany = ($last12ItemsAvg*12) * (1+$growthRateForCompany) * $next1MonthPercentage;
		$next2ForecastForCompany = ($last12ItemsAvg*12) * (1+$growthRateForCompany) * $next2MonthPercentage;
		$next3ForecastForCompany = ($last12ItemsAvg*12) * (1+$growthRateForCompany) * $next3MonthPercentage;
	
		return [
			
			'growth_rate'=>$growthRateForCompany,
			'next0ForecastForCompany'=>$valueOfMonth,
			'next1ForecastForCompany'=>$next1ForecastForCompany,
			'next2ForecastForCompany'=>$next2ForecastForCompany,
			'next3ForecastForCompany'=>$next3ForecastForCompany,
		];
	}
	
	protected function getLastAndGrowthRateForItem(array $totalsPerDates,string $endDate  ,$grForCompany ,$type , $currentItemName):?array 
	{
		// Get the last 12 keys
		$last12Items = HArr::sliceWithDates($totalsPerDates , $endDate,11);
		$slicedItems = $totalsPerDates ;
		foreach($last12Items as $key => $value){
			unset($slicedItems[$key]);
		}
		$previousOfPrevious12Items = HArr::sliceWithDates($slicedItems , $endDate,23) ;
		$last12ItemsCounter = count($last12Items);
		$sumOfLast6Months = array_sum(HArr::sliceWithDates($last12Items , $endDate,5));
		if($sumOfLast6Months == 0){
			return null;
		}
		$previousOfPrevious12ItemsCounter = count($previousOfPrevious12Items);
		$last12ItemsAvg = $last12ItemsCounter ? array_sum($last12Items) / $last12ItemsCounter : 0;
		$previousOfPrevious12ItemsAvg =$previousOfPrevious12ItemsCounter ? array_sum($previousOfPrevious12Items) /  $previousOfPrevious12ItemsCounter : 0;
		$growthRateForItem = $previousOfPrevious12ItemsAvg ? ($last12ItemsAvg / $previousOfPrevious12ItemsAvg) - 1 : 0 ;
		$next1Month = Carbon::make($endDate)->addMonthsNoOverflow(1)->format('Y-m-d');
		$next2Month = Carbon::make($endDate)->addMonthsNoOverflow(2)->format('Y-m-d');
		$next3Month = Carbon::make($endDate)->addMonthsNoOverflow(3)->format('Y-m-d');
		
		
		$valueOfMonth = HArr::getValueFromMonthAndYear($last12Items,Carbon::make($endDate)->format('m'),Carbon::make($endDate)->format('Y')) ;
		
		$next1MonthPercentageValueAtMonth = HArr::getValueFromMonth($last12Items,Carbon::make($next1Month)->format('m'));
		$next1MonthPercentage = array_sum($last12Items) && $sumOfLast6Months != 0  ? $next1MonthPercentageValueAtMonth / array_sum($last12Items) : 0;
		
		$next2MonthPercentageValueAtMonth = HArr::getValueFromMonth($last12Items,Carbon::make($next2Month)->format('m'));
		$next2MonthPercentage = array_sum($last12Items) && $sumOfLast6Months != 0  ? $next2MonthPercentageValueAtMonth / array_sum($last12Items) : 0;
		
		$next3MonthPercentageValueAtMonth = HArr::getValueFromMonth($last12Items,Carbon::make($next3Month)->format('m'));
		$next3MonthPercentage = array_sum($last12Items) && $sumOfLast6Months != 0  ? $next3MonthPercentageValueAtMonth / array_sum($last12Items) : 0;
		
	
		$forecastMonthGrRate = 0 ;
		if($grForCompany < $growthRateForItem){
			
			$forecastMonthGrRate = ($grForCompany + $growthRateForItem) / 2 ; 
		}elseif($growthRateForItem == 0){
			$forecastMonthGrRate = $grForCompany ; 
		}
		else{
			$forecastMonthGrRate = $growthRateForItem;
		}
		
		
				// $forecastMonthGrRate = $grForCompany < $growthRateForItem  ? ($grForCompany + $growthRateForItem) / 2 : $growthRateForItem ;
			
				$next1ForecastForItem = ($last12ItemsAvg*12) * (1+$forecastMonthGrRate) * $next1MonthPercentage;
				$next1ForecastForItem = $next1ForecastForItem < 0 ? 0 : $next1ForecastForItem ;
				$next2ForecastForItem = ($last12ItemsAvg*12) * (1+$forecastMonthGrRate) * $next2MonthPercentage;
				$next2ForecastForItem = $next2ForecastForItem < 0 ? 0 : $next2ForecastForItem ;
				$next3ForecastForItem = ($last12ItemsAvg*12) * (1+$forecastMonthGrRate) * $next3MonthPercentage;
				$next3ForecastForItem = $next3ForecastForItem < 0 ? 0 : $next3ForecastForItem ;
				// if($type =='product_or_service'){
					// dd($last12Items,$currentItemName);
				// }
				if($type =='category' && $currentItemName == 'Public Relations'){
					dd($last12Items,$previousOfPrevious12Items,$grForCompany,$growthRateForItem,$forecastMonthGrRate);
					// dd($last12Items,$sumOfLast6Months,$last12ItemsAvg,$next1ForecastForItem,$next2ForecastForItem,$next3ForecastForItem);
				}
		// dd('good');
		return [
			// 'last_12_avg'=>$last12ItemsAvg ,
			// 'last_24_avg'=>$previousOfPrevious12ItemsAvg ,
			// 'growth_rate'=>$growthRateForCompany,
			// 'next1MonthPercentage'=>$next1MonthPercentage,
			// 'next2MonthPercentage'=>$next2MonthPercentage,
			// 'next3MonthPercentage'=>$next3MonthPercentage,
			'next0ForecastForItem'=>$valueOfMonth,
			'next1ForecastForItem'=>$next1ForecastForItem,
			'next2ForecastForItem'=>$next2ForecastForItem,
			'next3ForecastForItem'=>$next3ForecastForItem,
		
			
			
		];
	}
}
