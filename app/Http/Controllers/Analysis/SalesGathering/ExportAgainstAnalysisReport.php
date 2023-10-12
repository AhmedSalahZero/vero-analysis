<?php

namespace App\Http\Controllers\Analysis\SalesGathering;

use App\Http\Controllers\ExportTable;
use App\Models\Company;
use App\Models\SalesGathering;
use App\Traits\GeneralFunctions;
use App\Traits\Intervals;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportAgainstAnalysisReport
{
    use GeneralFunctions;
    public function index(Company $company,string $firstColumn , string $secondColumn)
	{
            $type = $firstColumn;
			$firstColumnViewName = capitializeType(str_replace('_',' ',$firstColumn)) ;
			$secondColumnViewName = capitializeType(str_replace('_',' ',$secondColumn)) ;
			$revenueStreams = getExportFor('revenue_stream',$company->id , false);
			$currencies = getExportFor('currency',$company->id , false);
            $view_name = $firstColumnViewName . ' Against '. $secondColumnViewName .' Export Analysis Report' ;
			$firstColumnData = getExportFor($firstColumn , $company->id , false );
			$secondColumnData = getExportFor($secondColumn , $company->id , false );
        return view('client_view.reports.sales_gathering_analysis.export-against-report', compact('company','type','view_name','firstColumnData','secondColumnData','firstColumn','secondColumn','firstColumnViewName','secondColumnViewName','revenueStreams','currencies'));
    }
    public function CategoriesSalesAnalysisIndex(Company $company)
    {
        // Get The Selected exportable fields returns a pair of ['field_name' => 'viewing name']
        $selected_fields = (new ExportTable)->customizedTableField($company, 'InventoryStatement', 'selected_fields');
        return view('client_view.reports.sales_gathering_analysis.first_columns_sales_form', compact('company', 'selected_fields'));
    }
    public function result(Request $request, Company $company,$result='view' , $secondReport = true )
    {
        $report_data =[];
        $report_data_quantity =[];
        $growth_rate_data =[];
        $final_report_total =[];
        $first_columns_names = [];
        $firstColumnItems = is_array(json_decode(($request->firstColumnData[0]))) ? json_decode(($request->firstColumnData[0])) :$request->firstColumnData ;
        $secondColumnName = $request->type ;
		$type = $secondColumnName;
		
		// dd($type);
        $name_of_report_item  = ($result=='view') ? 'Sales Values' : 'Avg. Prices';
        $data_type = ($request->data_type === null || $request->data_type == 'value')? 'purchase_order_net_value' : 'quantity';
		$firstColumn = $request->get('firstColumnName');
		// $secondColumnName  = $request->get('secondColumnName');
		$firstColumnViewName = ucwords(str_replace('_',' ',$firstColumn));
		$secondColumnViewName = ucwords(str_replace('_',' ',$secondColumnName));
        $view_name = $firstColumnViewName . __('Against') . ' '  . $secondColumnViewName . ' ' . __('Export Analysis Report');
		$revenueStreams = $request->get('revenue_streams');
		$currencies = $request->get('currency');
		$revenueStreamsSql = convertArrayToSqlString($revenueStreams);
		$currenciesSql = convertArrayToSqlString($currencies);
		
		$whereIn = 'and  revenue_stream in ( '. $revenueStreamsSql .' ) and currency  in ('. $currenciesSql .')';
        foreach ($firstColumnItems as  $firstColumnItem) {

            if ($result == 'view') {
                $results =collect(DB::select(DB::raw("
                    SELECT DATE_FORMAT(LAST_DAY(purchase_order_date),'%d-%m-%Y') as gr_date  , ".$data_type." ,".$firstColumn."," . $secondColumnName ."
                    FROM export_analysis
                    WHERE ( company_id = '".$company->id."'AND ". $firstColumn ."  = '".$firstColumnItem."' AND purchase_order_date between '".$request->start_date."' and '".$request->end_date."')
					". $whereIn ."
                    ORDER BY id "
                    )))->groupBy($type)->map(function($item)use($data_type){
                        return $item->groupBy('gr_date')->map(function($sub_item)use($data_type){
                        
                            return $sub_item->sum($data_type);
                        });
                    })->toArray();
            }else{
                $results = DB::table('export_analysis')
                    ->where('company_id',$company->id)
                    ->where($firstColumn, $firstColumnItem)
                    ->whereNotNull($type)
                    ->whereBetween('purchase_order_date', [$request->start_date, $request->end_date])
                    ->selectRaw('DATE_FORMAT(LAST_DAY(purchase_order_date),"%d-%m-%Y") as gr_date ,
                    (IFNULL('.$data_type.',0) ) as '.$data_type.' ,'.$firstColumn.',' . $type)
                    ->get()
                    ->groupBy($type)->map(function($item)use($data_type){
                        return $item->groupBy('gr_date')->map(function($sub_item)use($data_type){
                            return $sub_item->sum($data_type);
                        });
                    })->toArray();

                     $results_quantity = DB::table('export_analysis')
                    ->where('company_id',$company->id)
                    ->where($firstColumn, $firstColumnItem)
                    ->whereNotNull($type)
                    ->whereBetween('purchase_order_date', [$request->start_date, $request->end_date])
                    ->selectRaw('DATE_FORMAT(LAST_DAY(purchase_order_date),"%d-%m-%Y") as gr_date ,
                    (IFNULL('.$data_type.',0)  ) as '.$data_type.' , IFNULL(quantity,0) quantity,'.$firstColumn.',' . $type)
                    ->get()
                    ->groupBy($type)->map(function($item)use($data_type){
                        return $item->groupBy('gr_date')->map(function($sub_item)use($data_type){
                            return ( $sub_item->sum('quantity') ) ;
                        });
                    })->toArray();

                }
// dd($report_data,$request->secondColumnData);
				
            foreach (($request->secondColumnData??[]) as $second_column_key => $second_column) {

                $years = [];
                $data_per_main_item = $results[$second_column]??[];
                if (count(($data_per_main_item))>0 ) {
                    // Data & Growth Rate Per Sales Channel
                    array_walk($data_per_main_item, function ($val, $date) use (&$years) {
                        $years[] = date('Y', strtotime($date));
                    });
                    $years = array_unique($years);
                    $report_data[$firstColumnItem][$second_column][$name_of_report_item] = $data_per_main_item;
                    $interval_data = Intervals::intervalsWithoutDouble($request->get('end_date'),$report_data[$firstColumnItem][$second_column], $years, $request->interval);
                    $report_data[$firstColumnItem][$second_column] = $interval_data['data_intervals'][$request->interval] ?? [];
                    $report_data[$firstColumnItem]['Total']  = $this->finalTotal([($report_data[$firstColumnItem]['Total']  ?? []) ,($report_data[$firstColumnItem][$second_column][$name_of_report_item]??[]) ]);
                    $report_data[$firstColumnItem][$second_column]['Growth Rate %'] = $this->growthRate(($report_data[$firstColumnItem][$second_column][$name_of_report_item] ?? []));

                }
            }

            if($result == 'array'){
                
                 foreach (($request->secondColumnData??[]) as $second_column_key => $second_column) {

                $years = [];

                $data_per_main_item = $results_quantity[$second_column]??[];
                if (count(($data_per_main_item))>0 ) {
                    // Data & Growth Rate Per Sales Channel
                    array_walk($data_per_main_item, function ($val, $date) use (&$years) {
                        $years[] = date('Y', strtotime($date));
                    });
                    $years = array_unique($years);

                    $report_data_quantity[$firstColumnItem][$second_column][$name_of_report_item] = $data_per_main_item;
                    $interval_data = Intervals::intervalsWithoutDouble($request->get('end_date'),$report_data_quantity[$firstColumnItem][$second_column], $years, $request->interval);
                    $report_data_quantity[$firstColumnItem][$second_column] = $interval_data['data_intervals'][$request->interval] ?? [];

                    $report_data_quantity[$firstColumnItem]['Total']  = $this->finalTotal([($report_data_quantity[$firstColumnItem]['Total']  ?? []) ,($report_data_quantity[$firstColumnItem][$second_column][$name_of_report_item]??[]) ]);
                    $report_data_quantity[$firstColumnItem][$second_column]['Growth Rate %'] = $this->growthRate(($report_data_quantity[$firstColumnItem][$second_column][$name_of_report_item] ?? []));

                }
            }


            foreach($report_data as $reportType=>$dates){
                       // Baby 20
                
                if($firstColumnItem  == $reportType )
                {
                    foreach($dates as $dateName=>$items){
                    if($dateName != 'Total')
                    {
                                                //Avg. Prices
                    foreach($items as $itemKey=> $values){
                        if($itemKey == 'Avg. Prices'){
                            foreach($values as $datee => $dateVal){
                            $report_data[$reportType][$dateName][$itemKey][$datee] =  
                            $report_data_quantity[$reportType][$dateName][$itemKey][$datee] ?
                            $report_data[$reportType][$dateName][$itemKey][$datee] / $report_data_quantity[$reportType][$dateName][$itemKey][$datee]
                            : 0 ; 

                            $report_data[$reportType]['Totals'][$datee] = $report_data[$reportType][$dateName][$itemKey][$datee] + ($report_data[$reportType]['Totals'][$datee] ??0);
                          
                            
                            
                            $report_data[$reportType]['Total'][$datee] = $report_data[$reportType]['Totals'][$datee];
                            
                        }
                        
                        
                        }

                        elseif($itemKey == 'Growth Rate %'){
                            foreach($values as $datee => $dateVal){
                                $report_data[$reportType][$dateName]['Avg. Prices'][$datee];
                                $keys = array_flip(array_keys($report_data[$reportType][$dateName]['Avg. Prices']));
                                $values = array_values($report_data[$reportType][$dateName]['Avg. Prices']);
                                $previousValue = isset($values[$keys[$datee]-1]) ? $values[$keys[$datee]-1] : 0 ;
                                $report_data[$reportType][$dateName][$itemKey][$datee] =  $previousValue ? (($report_data[$reportType][$dateName]['Avg. Prices'][$datee] - $previousValue  )/ $previousValue)*100 : 0;
                          
                            }
                        }
                        
                        
                        
                        
                    }   
                    }
                
                }
                }
                             

                             
                
            }
            
            
                
            }

            // Total & Growth Rate Per Zone
            $final_report_total = $this->finalTotal( [($report_data[$firstColumnItem]['Total']??[]) , ($final_report_total??[]) ]);
            $report_data[$firstColumnItem]['Growth Rate %'] =  $this->growthRate(($report_data[$firstColumnItem]['Total']??[]));
            $first_columns_names[] = (str_replace( ' ','_', $firstColumnItem));

        }
          foreach($report_data as $r=>$d){
            unset($report_data[$r]['Totals']);
        }

        
        // Total Zones & Growth Rate


        $report_data['Total'] = $final_report_total;
        $report_data['Growth Rate %']=  $this->growthRate($report_data['Total']);
        $dates = array_keys($report_data['Total']);
        //  $dates = formatDateVariable($dates , $request->start_date  , $request->end_date);
        $Items_names = $first_columns_names ;
         $report_view = getComparingReportForAnalysis($request , $report_data , $secondReport , $company , $dates , $view_name , $Items_names , $firstColumn );
        if($report_view instanceof View)
        {
            return $report_view ; 
        }
        if($request->report_type =='comparing')
        {
             return [
                 'report_data'=>$report_data ,
                 'dates'=>$dates ,
                 'full_date' =>Carbon::make($request->start_date)->format('d M Y') .' '.__('To').' '.Carbon::make($request->end_date)->format('d M Y') 
             ];
        }
        
        if ($result=='view') {
            // dd(get_defined_vars());
            return view('client_view.reports.sales_gathering_analysis.first_columns_analysis_report',compact('company','firstColumnViewName','name_of_report_item','view_name','first_columns_names','dates','report_data'));
        }else {
            return [ 'report_data'=>$report_data,'view_name'=>$view_name,'names'=> $first_columns_names];
        }


    }
    // public function resultForSalesDiscount(Request $request, Company $company)
    // {

    //     $report_data =[];
    //     $final_report_data =[];
    //     $growth_rate_data =[];
    //     $zones_names = [];
    //     $sales_values = [];
    //     $sales_years = [];
    //     $zones = is_array(json_decode(($request->first_columnsData[0]))) ? json_decode(($request->first_columnsData[0])) :$request->first_columnsData ;

    //     $type = $request->type;
    //     $view_name = $request->view_name;

    //     $fields ='';
    //     foreach ($request->sales_discounts_fields as $sales_discount_field_key => $sales_discount_field) {
    //         $fields .= $sales_discount_field .',';
    //     }


    //     foreach ($zones as  $firstColumnItem) {

    //         $sales =collect(DB::select(DB::raw("
    //             SELECT DATE_FORMAT(LAST_DAY(date),'%d-%m-%Y') as gr_date  , sales_value ," . $fields ." category
    //             FROM sales_gathering
    //             WHERE ( company_id = '".$company->id."'AND category = '".$firstColumnItem."' AND date between '".$request->start_date."' and '".$request->end_date."')
    //             ORDER BY id"
    //         )))->groupBy('gr_date');
    //         $sales_values_per_zone[$firstColumnItem] = $sales->map(function($sub_item){
    //                                 return $sub_item->sum('sales_value');
    //                             })->toArray();



    //         foreach ($request->sales_discounts_fields as $sales_discount_field_key => $sales_discount_field) {
    //             $zones_discount = $sales->map(function($sub_item) use($sales_discount_field){
    //                                     return $sub_item->sum($sales_discount_field);
    //                                 })->toArray();

    //             $zones_sales_values = [];
    //             $zones_per_month = [];
    //             $results = [];
    //             $discount_years = [];

    //             if (@count($zones_discount) > 0) {

    //                 // Data & Growth Rate Per Sales Channel


    //                 array_walk($zones_discount, function ($val, $date) use (&$discount_years) {
    //                     $discount_years[] = date('Y', strtotime($date));
    //                 });
    //                 $discount_years = array_unique($discount_years);

    //                 array_walk($zones_sales_values, function ($val, $date) use (&$sales_years) {
    //                     $sales_years[] = date('Y', strtotime($date));
    //                 });
    //                 $sales_years = array_unique($sales_years);



    //                 $interval_data = Intervals::intervalsWithoutDouble($request->get('end_date'),$sales_values_per_zone, $sales_years, $request->interval);

    //                 $sales_values[$firstColumnItem]  = $interval_data['data_intervals'][$request->interval][$firstColumnItem] ?? [];




    //                 $final_report_data[$firstColumnItem][$sales_discount_field]['Values'] = $zones_discount;
    //                 $interval_data = Intervals::intervalsWithoutDouble($request->get('end_date'),$final_report_data[$firstColumnItem][$sales_discount_field], $discount_years, $request->interval);
    //                 $final_report_data[$firstColumnItem][$sales_discount_field] = $interval_data['data_intervals'][$request->interval] ?? [];


    //                 $final_report_data[$firstColumnItem]['Total']  = $this->finalTotal([($final_report_data[$firstColumnItem]['Total']  ?? []) ,($final_report_data[$firstColumnItem][$sales_discount_field]['Values']??[]) ]);






    //                 $final_report_data['Total'] = $this->finalTotal([($final_report_data['Total'] ?? []), (($final_report_data[$firstColumnItem][$sales_discount_field]['Values']??[]))]);


    //                 $final_report_data[$firstColumnItem][$sales_discount_field]['Perc.% / Sales'] = $this->operationAmongTwoArrays(($final_report_data[$firstColumnItem][$sales_discount_field]['Values']??[]), ($sales_values[$firstColumnItem]??[]));


    //             }
    //         }
    //         $zones_names[] = (str_replace( ' ','_', $firstColumnItem));
    //     }

    //     $sales_values = $this->finalTotal([$sales_values??[]]);
    //     $total = $final_report_data['Total'] ?? [];
    //     unset($final_report_data['Total']);
    //     $final_report_data['Total'] = $total;
    //     $final_report_data['Discount % / Total Sales'] = $this->operationAmongTwoArrays($final_report_data['Total'],$sales_values);

    //     // Total Zones & Growth Rate

    //     $report_data = $final_report_data;

    //     $dates = array_keys(($report_data['Total']??[]));

    //     $type_name = 'Categories';
    //     return view('client_view.reports.sales_gathering_analysis.sales_discounts_analysis_report',compact('company','view_name','zones_names','dates','report_data','type_name'));

    // }


    // public function CategoriesSalesAnalysisResult(Request $request, Company $company)
    // {
    //     $dimension = $request->report_type;

    //     $report_data =[];
    //     $growth_rate_data =[];
    //     $first_columns = is_array(json_decode(($request->first_columns[0]))) ? json_decode(($request->first_columns[0])) :$request->first_columns ;

    //     foreach ($first_columns as  $category) {

    //         $first_columns_data = [];



    //         $first_columns_data =collect(DB::select(DB::raw("
    //             SELECT DATE_FORMAT(LAST_DAY(date),'%d-%m-%Y') as gr_date  , purchase_order_net_value ,category
    //             FROM sales_gathering
    //             WHERE ( company_id = '".$company->id."'AND category = '".$category."' AND date between '".$request->start_date."' and '".$request->end_date."')
    //             ORDER BY id "
    //             )))->groupBy('gr_date')->map(function($item){
    //                 return $item->sum('purchase_order_net_value');
    //             })->toArray();


    //         $interval_data_per_item = [];
    //         $years = [];
    //         if (count($first_columns_data)>0) {

    //             // Data & Growth Rate Per Sales Channel
    //             array_walk($first_columns_data, function ($val, $date) use (&$years) {
    //                 $years[] = date('Y', strtotime($date));
    //             });
    //             $years = array_unique($years);
    //             $report_data[$category] = $first_columns_data;
    //             $interval_data_per_item[$category] = $first_columns_data;
    //             $interval_data = Intervals::intervalsWithoutDouble($request->get('end_date'),$interval_data_per_item, $years, $request->interval);

    //             $report_data[$category] = $interval_data['data_intervals'][$request->interval][$category] ?? [];
    //             $growth_rate_data[$category] = $this->growthRate($report_data[$category]);



    //         }
    //     }

    //     $total_first_columns = $this->finalTotal($report_data);
    //     $total_first_columns_growth_rates =  $this->growthRate($total_first_columns);
    //     $final_report_data = [];
    //     $first_columns_names =[];
    //     foreach ($first_columns as  $category) {
    //         $final_report_data[$category]['Sales Values'] = ($report_data[$category]??[]);
    //         $final_report_data[$category]['Growth Rate %'] = ($growth_rate_data[$category]??[]);
    //         $first_columns_names[] = (str_replace( ' ','_', $category));
    //     }
	// 	// dd(get_defined_vars());
	// 	$dates = array_keys($total_first_columns ?? []); 
	// 	// dd($total_first_columns , $first_columns_data);
    //     return view('client_view.reports.sales_gathering_analysis.first_columns_sales_report',compact('company','first_columns_names','total_first_columns_growth_rates','final_report_data','total_first_columns','dates'));

    // }
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


}
