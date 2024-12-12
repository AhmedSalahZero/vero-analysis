<?php

namespace App\Http\Controllers\Analysis\SalesGathering;

use App\Helpers\HArr;
use App\Models\Company;
use App\Models\Log;
use App\Models\SalesGathering;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;

class salesReport
{
    use GeneralFunctions;
    public function index(Company $company)
    {
		Log::storeNewLogRecord('enterSection',null,__('Sales Report'));
		
        return view('client_view.reports.sales_gathering_analysis.sales_report.sales_form', compact('company'));
    }
	protected function getLastAndGrowthRate(array $totalsPerDates,string $startDate,string $endDate  , $grForCompany = null ):array 
	{
		// Get the last 12 keys
		$last12Items = HArr::sliceWithDates($totalsPerDates , $endDate);
		$slicedItems = $totalsPerDates ;
		foreach($last12Items as $key => $value){
			unset($slicedItems[$key]);
		}
		$previousOfPrevious12Items = HArr::sliceWithDates($slicedItems , $endDate,23) ;
		$last12ItemsCounter = count($last12Items);
		$previousOfPrevious12ItemsCounter = count($previousOfPrevious12Items);
		$last12ItemsAvg = $last12ItemsCounter ? array_sum($last12Items) / $last12ItemsCounter : 0;
		$previousOfPrevious12ItemsAvg =$previousOfPrevious12ItemsCounter ? array_sum($previousOfPrevious12Items) /  $previousOfPrevious12ItemsCounter : 0;
		$growthRateForCompany = $previousOfPrevious12ItemsAvg ? ($last12ItemsAvg / $previousOfPrevious12ItemsAvg) - 1 : 0 ;
		$next1Month = Carbon::make($endDate)->addMonthsNoOverflow(1)->format('Y-m-d');
		$next2Month = Carbon::make($endDate)->addMonthsNoOverflow(2)->format('Y-m-d');
		$next3Month = Carbon::make($endDate)->addMonthsNoOverflow(3)->format('Y-m-d');
		
		$valueOfMonth = HArr::getValueFromMonthAndYear($last12Items,Carbon::make($endDate)->format('m'),Carbon::make($endDate)->format('Y')) ;
		
		$next1MonthPercentageValueAtMonth = HArr::getValueFromMonth($last12Items,Carbon::make($next1Month)->format('m'));
		$next1MonthPercentage = array_sum($last12Items) ? $next1MonthPercentageValueAtMonth / array_sum($last12Items) : 0;
		
		$next2MonthPercentageValueAtMonth = HArr::getValueFromMonth($last12Items,Carbon::make($next2Month)->format('m'));
		$next2MonthPercentage = array_sum($last12Items) ? $next2MonthPercentageValueAtMonth / array_sum($last12Items) : 0;
		
		$next3MonthPercentageValueAtMonth = HArr::getValueFromMonth($last12Items,Carbon::make($next3Month)->format('m'));
		$next3MonthPercentage = array_sum($last12Items) ? $next3MonthPercentageValueAtMonth / array_sum($last12Items) : 0;
		
		$next1ForecastForCompany = ($last12ItemsAvg*12) * (1+$growthRateForCompany) * $next1MonthPercentage;
		$next2ForecastForCompany = ($last12ItemsAvg*12) * (1+$growthRateForCompany) * $next2MonthPercentage;
		$next3ForecastForCompany = ($last12ItemsAvg*12) * (1+$growthRateForCompany) * $next3MonthPercentage;
		
		
		$next1ForecastForCompany = ($last12ItemsAvg*12) * (1+$growthRateForCompany) * $next1MonthPercentage;
		$next2ForecastForCompany = ($last12ItemsAvg*12) * (1+$growthRateForCompany) * $next2MonthPercentage;
		$next3ForecastForCompany = ($last12ItemsAvg*12) * (1+$growthRateForCompany) * $next3MonthPercentage;
		$next1ForecastForType = 0 ;
		$next2ForecastForType = 0;
		$next3ForecastForType = 0;
		$forecastMonthGrRate = 0 ;
		if(!is_null($grForCompany)){
			$forecastMonthGrRate = $grForCompany < $growthRateForCompany  ? ($grForCompany + $growthRateForCompany) / 2 : $growthRateForCompany ;
			if(array_sum($last12Items) == 0 ){
				$next1ForecastForType = 0 ;
				$next2ForecastForType  = 0 ;
				$next3ForecastForType= 0;
			}else{
				$next1ForecastForType = ($last12ItemsAvg*12) * (1+$forecastMonthGrRate) * $next1MonthPercentage;
				$next1ForecastForType = $next1ForecastForType < 0 ? 0 : $next1ForecastForType ;
				$next2ForecastForType = ($last12ItemsAvg*12) * (1+$forecastMonthGrRate) * $next2MonthPercentage;
				$next2ForecastForType = $next2ForecastForType < 0 ? 0 : $next2ForecastForType ;
				$next3ForecastForType = ($last12ItemsAvg*12) * (1+$forecastMonthGrRate) * $next3MonthPercentage;
				$next3ForecastForType = $next3ForecastForType < 0 ? 0 : $next3ForecastForType ;
			}
	
		}
		return [
			'last_12_avg'=>$last12ItemsAvg ,
			'last_24_avg'=>$previousOfPrevious12ItemsAvg ,
			'growth_rate'=>$growthRateForCompany,
			'next1MonthPercentage'=>$next1MonthPercentage,
			'next2MonthPercentage'=>$next2MonthPercentage,
			'next3MonthPercentage'=>$next3MonthPercentage,
			'next1ForecastForCompany'=>$next1ForecastForCompany,
			'next2ForecastForCompany'=>$next2ForecastForCompany,
			'next3ForecastForCompany'=>$next3ForecastForCompany,
			'next0ForecastForType'=>$valueOfMonth,
			'next1ForecastForType'=>$next1ForecastForType,
			'next2ForecastForType'=>$next2ForecastForType,
			'next3ForecastForType'=>$next3ForecastForType,
			
			
		];
	}
	public function predictSales(Request $request, Company $company,$type,$endDate)
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
										return $year->groupBy('gr_date');
									})->toArray() ;
									
									$lastAndGrowthRateForCompanyArr = $this->getLastAndGrowthRate($totalsPerDates,$startDate,$endDate );
									$last12AvgForCompany = $lastAndGrowthRateForCompanyArr['last_12_avg'];
									$last24AvgForCompany = $lastAndGrowthRateForCompanyArr['last_24_avg'];
									$growthRateForCompany = $lastAndGrowthRateForCompanyArr['growth_rate'];
									
									
									$lastAndGrowthRateForItems = [];
          
         		   $data = $main_data->groupBy($type)->map(function($year){
                            return $year->groupBy('gr_date')->map(function($sub_item){
                                return $sub_item->sum('net_sales_value');
                            });
                        })->toArray();
						
						
       foreach($data as $name => $dataItem){
			$lastAndGrowthRateForItems[$name]=$this->getLastAndGrowthRate($dataItem,$startDate,$endDate,$growthRateForCompany);
	   }
	   return $lastAndGrowthRateForItems;
       
    }
    public function result(Request $request, Company $company,$result='view')
    {
        // enhanced in sales dashboard // salah
        $report_data = [];
        $growth_rate_data = [];

        $dates = [];
        $gr = [];
        $last_date = null;
        $request_dates = [
            'start_date' => date('d-M-Y',strtotime($request->start_date)),
            'end_date' => date('d-M-Y',strtotime($request->end_date))
        ];
        $data = [];

        $main_data = SalesGathering::company()
                                    ->whereBetween('date', [$request->start_date, $request->end_date])
                                    // ->limit(10)
                                    ->selectRaw('DATE_FORMAT(LAST_DAY(date),"%d-%m-%Y") as gr_date,DATE_FORMAT(date,"%Y") as year,net_sales_value')->orderBy('date')
                                    ->get();
          
        if ($request->report_type == 'comparing') {
            $data = $main_data->groupBy('year')->map(function($year){
                            return $year->groupBy('gr_date')->map(function($sub_item){
                                return $sub_item->sum('net_sales_value');
                            });
                        })->toArray();
            count($data)>0 ? ksort($data) : '';

            $year_number = 1;
            $previous_data = [];
            foreach ($data as $year => $data_per_year) {
                $data_per_year = $data_per_year??[];
                $report_data[$year]['Months'] = array_keys($data_per_year);
                $report_data[$year]['Sales Values'] = $data_per_year;
                $report_data[$year]['Month Sales %'] = $this->operationAmongArrayAndNumber($data_per_year,array_sum(($data_per_year??[])));
                $report_data[$year]['Month Sales %'] = $this->operationAmongArrayAndNumber($report_data[$year]['Month Sales %'] ,100 ,'multiply');
                if ($year_number == 1) {
                    $report_data[$year]['YoY GR%'] = array_fill_keys(array_keys($data_per_year),0);
                }else{
                    $report_data[$year]['YoY GR%'] = $this->growthRatePerMonth($data_per_year,$previous_data,$year);
                }
                $year_number++;
                $previous_data = $data_per_year;
            }
            $totals = $this->finalTotal(array_column($report_data,'Sales Values')??[]);
            $total_full_data = $this->monthsTotal($totals);
        }else{
            $data = $main_data->groupBy('gr_date')->map(function($item)
                    { return $item->sum('net_sales_value'); })->toArray();


            if (count($data) > 0) {

                $report_data['Sales Values'] =  $this->sorting($data);

                $gr = $this->growthRate($data);

                $total  = array_sum($data);

                $report_data['Month Sales %'] = $this->operationAmongArrayAndNumber($report_data['Sales Values'],$total);
                $report_data['Month Sales %'] = $this->operationAmongArrayAndNumber($report_data['Month Sales %'] ,100 ,'multiply');

                $dates = array_keys($report_data['Sales Values']);
                $last_date = SalesGathering::company()->latest('date')->first()->date;
                $last_date = date('d-M-Y',strtotime($last_date));

            }
        }





        // Alert No Data
        if ($result == 'view' && count($data) == 0)  {

            toastr()->error('No Data Found');
            return redirect()->back();
        }
        // View
        if ($result == 'view') {
            if ($request->report_type == 'comparing') {

                return view('client_view.reports.sales_gathering_analysis.sales_report.comparing_sales_report',
                            compact('company',
                                    'total_full_data',
                                    'gr',
                                    'request_dates',
                                    'last_date',
                                    'dates',
                                    'report_data'));
            }else{
                return view('client_view.reports.sales_gathering_analysis.sales_report.sales_report', compact('company','gr','request_dates','last_date',  'dates', 'report_data'));
            }
        }
        // Interval Comparing Sales Report
        elseif ($result == 'array' && $request->report_type == 'comparing')  {
            return [
                'total_full_data' =>$total_full_data,
                'report_data' =>$report_data,
            ];
        }
        // Trend Sales Report
        else{
            return ['gr'=>$gr??[],
                    'dates' => $dates??[],
                    'last_date' =>$last_date,
                    'report_data'=> $report_data??[]];
        }
    }
    public function growthRate($data)
    {

        $prev_month = 0;
        $final_data = [];
        foreach ($data as $date => $value) {
            $prev_month = (round($prev_month));
            if ($prev_month <= 0 && $value<=0) {
                $final_data[$date] = 0 ;
            }if ($prev_month <  0 && $value >= 0) {
                $final_data[$date] =  ((($value - $prev_month) / $prev_month) * 100)*(-1);
            }else{

                $final_data[$date] = $prev_month != 0 ? (($value - $prev_month) / $prev_month) * 100 : 0;
            }
            $prev_month = $value;
        }
        return $final_data;
    }
    public function growthRatePerMonth($current_data,$prev_data,$year)
    {

        $final_data = [];
        $prev_year = $year-1;
        foreach ($current_data as $date => $value) {
            $previous_date = date('d-m-',strtotime($date));
            if (date('m',strtotime($date)) ==  02 ) {

                $prev_month = 0;
                if (isset($prev_data['28-02-'.$prev_year])) {
                    $prev_month = $prev_data['28-02-'.$prev_year]??0;
                } elseif (isset($prev_data['29-02-'.$prev_year])){
                    $prev_month = $prev_data['29-02-'.$prev_year]??0;
                }

            } else {
                $prev_month = $prev_data[$previous_date.$prev_year]??0;
            }

            if ($prev_month <= 0 && $value<=0) {
                $final_data[$date] = 0 ;
            }if ($prev_month <  0 && $value >= 0) {
                $final_data[$date] =  ((($value - $prev_month) / $prev_month) * 100)*(-1);
            }else{

                $final_data[$date] = $prev_month != 0 ? (($value - $prev_month) / $prev_month) * 100 : 0;
            }
            $prev_month = $value;
        }
        return $final_data;
    }
    public function monthsTotal($total_full_data)
    {
        $result = [];
        foreach ($total_full_data as $date => $value) {
            $month = date('F',strtotime($date));

            $result[$month] =  ($result[$month]??0) + $value ;

        }
        return $result;
    }
}
