<?php

namespace App\Http\Controllers\Analysis\SalesGathering;

use App\Http\Controllers\ExportTable;
use App\Models\Company;
use App\Models\SalesGathering;
use App\Traits\GeneralFunctions;
use App\Traits\Intervals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsAgainstAnalysisReport
{
    use GeneralFunctions;
    public function index(Company $company)
    {
        if (request()->route()->named('products.sales.analysis')) {
            $type = 'product_or_service';
            $view_name = 'Products Trend Analysis';
        } elseif (request()->route()->named('products.zones.analysis')) {
            $type = 'zone';
            $view_name = 'Products Against Zones Trend Analysis';
        } elseif (request()->route()->named('products.customers.analysis')) {
            $type = 'customer_name';
            $view_name = 'Products Against Customers Trend Analysis';
        } elseif (request()->route()->named('products.salesChannels.analysis')) {
            $type  = 'sales_channel';
            $view_name = 'Products Against Sales Channels Trend Analysis';
        }

        elseif (request()->route()->named('products.customers.analysis')) {
            $type  = 'customer_name';
            $view_name = 'Products Against Customers Trend Analysis';
        }
        // dd('q');
        // elseif (request()->route()->named('products.categories.analysis')) {
        //     $type  = 'category';
        //     $view_name = 'Products Against Categories Trend Analysis';
        // } elseif (request()->route()->named('products.principles.analysis')) {
        //     $type  = 'principle';
        //     $view_name = 'Products Against Principles Trend Analysis';
        // }
        elseif (request()->route()->named('products.Items.analysis')) {
            $type  = 'product_item';
            $view_name = 'Products Against Products Items Trend Analysis';
        } elseif (request()->route()->named('products.salesPersons.analysis')) {
            $type  = 'sales_person';
            $view_name = 'Products Against Sales Persons Trend Analysis';
        } elseif (request()->route()->named('products.salesDiscount.analysis')) {
            $type  = 'quantity_discount';
            $view_name = 'Products Against Sales Discount Trend Analysis';
        } elseif (request()->route()->named('products.businessSectors.analysis')) {
            $type  = 'business_sector';
            $view_name = 'Products Against Business Sectors Trend Analysis';
        } elseif (request()->route()->named('products.branches.analysis')) {
            $type  = 'branch';
            $view_name = 'Products Against Branches Trend Analysis';
        }elseif (request()->route()->named('products.Items.averagePrices')) {
            $type  = 'averagePricesProductItems';
            $view_name = 'Products Items Average Prices' ;
        }
        $name_of_selector_label = ($type == 'averagePricesProductItems') ? 'Products Items' : str_replace(['Products Against ', ' Trend Analysis'], '', $view_name);
        // dd($view_name);
        return view('client_view.reports.sales_gathering_analysis.products_analysis_form', compact('company', 'name_of_selector_label', 'type', 'view_name'));
    }
    public function result(Request $request, Company $company,$result="view")
    {

        $report_data = [];
        $growth_rate_data = [];
        $final_report_total = [];
        $products_names = [];
        $mainData = is_array(json_decode(($request->productsData[0]))) ? json_decode(($request->productsData[0])) : $request->productsData;
        $type = $request->type;
        $view_name = $request->view_name;
        $name_of_report_item  = ($result=='view') ? 'Sales Values' : 'Avg. Prices';
        $data_type = ($request->data_type === null || $request->data_type == 'value')? 'net_sales_value' : 'quantity';
        // dd($mainData);
        foreach ($mainData as  $main_row) {
            if ($result == 'view' || $result == 'data') {
                $main_row = str_replace("'" , "''",$main_row);
                // dd($main_row);
                $mainData_data =collect(DB::select(DB::raw("
                    SELECT DATE_FORMAT(LAST_DAY(date),'%d-%m-%Y') as gr_date  , ".$data_type." ,product_or_service," . $type ."
                    FROM sales_gathering 
                    WHERE ( company_id = '".$company->id."'AND product_or_service = '".  $main_row."'AND date between '".$request->start_date."' and '".$request->end_date."')
                    ORDER BY id "
                    )))->groupBy($type)->map(function($item)use($data_type){
                        return $item->groupBy('gr_date')->map(function($sub_item)use($data_type){
                            return $sub_item->sum($data_type);
                        });
                    })->toArray();
            }else{

                
                $mainData_data = DB::table('sales_gathering')
                    ->where('company_id',$company->id)
                    ->where('product_or_service', $main_row)
                    ->whereNotNull($type)
                    ->whereBetween('date', [$request->start_date, $request->end_date])
                    ->selectRaw('DATE_FORMAT(LAST_DAY(date),"%d-%m-%Y") as gr_date ,
                    (IFNULL('.$data_type.',0) ) as '.$data_type.' ,product_or_service,' . $type)
                    ->get()
                    ->groupBy($type)->map(function($item)use($data_type){
                        return $item->groupBy('gr_date')->map(function($sub_item)use($data_type){
                            return $sub_item->sum($data_type);
                        });
                    })->toArray();
                       $report_data_quantity = DB::table('sales_gathering')
                    ->where('company_id',$company->id)
                    ->where('product_or_service', $main_row)
                    ->whereNotNull($type)
                    ->whereBetween('date', [$request->start_date, $request->end_date])
                    ->selectRaw('DATE_FORMAT(LAST_DAY(date),"%d-%m-%Y") as gr_date ,
                    (IFNULL('.$data_type.',0) ) as '.$data_type.' ,IFNULL(quantity_bonus,0) quantity_bonus , IFNULL(quantity,0) quantity , product_or_service,' . $type)
                    ->get()
                    ->groupBy($type)->map(function($item)use($data_type){
                        return $item->groupBy('gr_date')->map(function($sub_item)use($data_type){
                            return ($sub_item->sum('quantity_bonus') + $sub_item->sum('quantity') ) ; 
                        });
                    })->toArray();
                    

                    //  $mainData_data = DB::table('sales_gathering')
                    // ->where('company_id',$company->id)
                    // ->where('product_or_service', $main_row)
                    // ->whereNotNull($type)
                    // ->whereBetween('date', [$request->start_date, $request->end_date])
                    // ->selectRaw('DATE_FORMAT(LAST_DAY(date),"%d-%m-%Y") as gr_date ,
                    // (IFNULL('.$data_type.',0)/(IFNULL(quantity_bonus,0)+IFNULL(quantity,0) ) ) as '.$data_type.' ,product_or_service,' . $type)
                    // ->get()
                    // ->groupBy($type)->map(function($item)use($data_type){
                    //     return $item->groupBy('gr_date')->map(function($sub_item)use($data_type){
                    //         return $sub_item->sum($data_type);
                    //     });
                    // })->toArray();

                    
                    
                    //  $salesChannels_data = DB::table('sales_gathering')
                    // ->where('company_id',$company->id)
                    // ->where('sales_channel', $salesChannelName)
                    // ->whereNotNull($type)
                    // ->whereBetween('date', [$request->start_date, $request->end_date])
                    // ->selectRaw('DATE_FORMAT(LAST_DAY(date),"%d-%m-%Y") as gr_date ,  sales_channel , '. $data_type .' , IFNULL(quantity_bonus,0) quantity_bonus , IFNULL(quantity,0) quantity , 
                    //  sales_channel,' . $type)
                    
                    //  ->get() 
                    // ->groupBy($type)->map(function($item)use($data_type){
                    //     return $item->groupBy('gr_date')->map(function($sub_item)use($data_type,$item){
                            
                    //         return 
                    //         $sub_item->sum('net_sales_value') ;
                    //     });
                    // })->toArray();


                    //        $qq = DB::table('sales_gathering')
                    // ->where('company_id',$company->id)
                    // ->where('sales_channel', $salesChannelName)
                    // ->whereNotNull($type)
                    // ->whereBetween('date', [$request->start_date, $request->end_date])
                    // ->selectRaw('DATE_FORMAT(LAST_DAY(date),"%d-%m-%Y") as gr_date ,  sales_channel , '. $data_type .' , IFNULL(quantity_bonus,0) quantity_bonus , IFNULL(quantity,0) quantity , 
                    //  sales_channel,' . $type)
                    
                    //  ->get() 
                    // ->groupBy($type)->map(function($item)use($data_type){
                    //     return $item->groupBy('gr_date')->map(function($sub_item)use($data_type,$item){
                            
                    //         return 
                    //         ($sub_item->sum('quantity_bonus') + $sub_item->sum('quantity') ) ;
                    //     });
                    // })->toArray();
                    
                    

            }

             foreach (($request->sales_channels ?? []) as $sales_channel_key => $sales_channel) {

                $years = [];

                $data_per_main_item = $mainData_data[$sales_channel]??[];
                if (count(($data_per_main_item))>0 ) {

                    // Data & Growth Rate Per Sales Channel
                    array_walk($data_per_main_item, function ($val, $date) use (&$years) {
                        $years[] = date('Y', strtotime($date));
                    });
                    $years = array_unique($years);

                    $report_data[$main_row][$sales_channel][$name_of_report_item] = $data_per_main_item;
                    $interval_data = Intervals::intervals($report_data[$main_row][$sales_channel], $years, $request->interval);
                    $report_data[$main_row][$sales_channel] = $interval_data['data_intervals'][$request->interval] ?? [];

                    $report_data[$main_row]['Total']  = $this->finalTotal([($report_data[$main_row]['Total']  ?? []) ,($report_data[$main_row][$sales_channel][$name_of_report_item]??[]) ]);
                    $report_data[$main_row][$sales_channel]['Growth Rate %'] = $this->growthRate(($report_data[$main_row][$sales_channel][$name_of_report_item] ?? []));

                }
            }


             if($result == 'array'){
                foreach (($request->sales_channels ?? []) as $sales_channel_key => $sales_channel) {

                $years_quantity = [];

                $data_per_main_item = $report_data_quantity[$sales_channel]??[];
                if (count(($data_per_main_item))>0 ) {

                    // Data & Growth Rate Per Sales Channel
                    array_walk($data_per_main_item, function ($val, $date) use (&$years_quantity) {
                        $years_quantity[] = date('Y', strtotime($date));
                    });
                    $years_quantity = array_unique($years_quantity);

                    $report_data_quantity[$main_row][$sales_channel][$name_of_report_item] = $data_per_main_item;
                    $interval_data = Intervals::intervals($report_data_quantity[$main_row][$sales_channel], $years_quantity, $request->interval);
                    $report_data_quantity[$main_row][$sales_channel] = $interval_data['data_intervals'][$request->interval] ?? [];

                    $report_data_quantity[$main_row]['Total']  = $this->finalTotal([($report_data_quantity[$main_row]['Total']  ?? []) ,($report_data_quantity[$main_row][$sales_channel][$name_of_report_item]??[]) ]);
                    $report_data_quantity[$main_row][$sales_channel]['Growth Rate %'] = $this->growthRate(($report_data_quantity[$main_row][$sales_channel][$name_of_report_item] ?? []));

                }
            }
         

            // if( == '')
          
                 foreach($report_data as $reportType=>$dates){
                                // Baby 20

                        if($main_row == $reportType)
                        {
                             foreach($dates as $dateName=>$items){
                    if($dateName != 'Total')
                    {
                      
                                                //Avg. Prices
                    foreach($items as $itemKey=> $values){
                        if($itemKey == 'Avg. Prices'){
                            foreach($values as $datee => $dateVal){
                                
                                        $report_data[$reportType][$dateName][$itemKey][$datee] =  
                              $report_data_quantity[$reportType][$dateName][$itemKey][$datee]  ?
                            $report_data[$reportType][$dateName][$itemKey][$datee] / $report_data_quantity[$reportType][$dateName][$itemKey][$datee]
                            :  0; 

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

            $final_report_total = $this->finalTotal( [($report_data[$main_row]['Total']??[]) , ($final_report_total??[]) ]);
            $report_data[$main_row]['Growth Rate %'] =  $this->growthRate(($report_data[$main_row]['Total'] ?? []));

            $products_names[] = (str_replace(' ', '_', $main_row));
        }

          foreach($report_data as $r=>$d){
            unset($report_data[$r]['Totals']);
        }

        
            // dd($report_data);

        // Total Zones & Growth Rate

        $report_data['Total'] = $final_report_total;
        $report_data['Growth Rate %'] =  $this->growthRate($report_data['Total']);
        $dates = array_keys($report_data['Total']);

        if ($result =='view') {
            return view('client_view.reports.sales_gathering_analysis.products_analysis_report', compact('company','name_of_report_item', 'view_name', 'products_names', 'dates', 'report_data',));
        }else {
            return [ 'report_data'=>$report_data,'view_name'=>$view_name,'names'=> $products_names];
        }

    }

    public function resultForSalesDiscount(Request $request, Company $company)
    {

        $report_data =[];
        $final_report_data =[];
        $growth_rate_data =[];
        $zones_names = [];
        $sales_values = [];
        $sales_years = [];
        $zones = is_array(json_decode(($request->productsData[0]))) ? json_decode(($request->productsData[0])) :$request->productsData ;
        $type = $request->type;
        $view_name = $request->view_name;
        $zones_discount = [];


        $fields ='';
        foreach ($request->sales_discounts_fields as $sales_discount_field_key => $sales_discount_field) {
            $fields .= $sales_discount_field .',';
        }


        foreach ($zones as  $zone) {

            $sales =collect(DB::select(DB::raw("
                SELECT DATE_FORMAT(LAST_DAY(date),'%d-%m-%Y') as gr_date  , sales_value ," . $fields ." product_or_service
                FROM sales_gathering
                WHERE ( company_id = '".$company->id."'AND product_or_service = '".$zone."' AND date between '".$request->start_date."' and '".$request->end_date."')
                ORDER BY id"
            )))->groupBy('gr_date');
            $sales_values_per_zone[$zone] = $sales->map(function($sub_item){
                                    return $sub_item->sum('sales_value');
                                })->toArray();



            foreach ($request->sales_discounts_fields as $sales_discount_field_key => $sales_discount_field) {
                $zones_discount = $sales->map(function($sub_item) use($sales_discount_field){
                                        return $sub_item->sum($sales_discount_field);
                                    })->toArray();

                $zones_sales_values = [];
                $zones_per_month = [];
                $zones_data = [];
                $discount_years = [];

                if (@count($zones_discount) > 0) {

                    // Data & Growth Rate Per Sales Channel


                    array_walk($zones_discount, function ($val, $date) use (&$discount_years) {
                        $discount_years[] = date('Y', strtotime($date));
                    });
                    $discount_years = array_unique($discount_years);

                    array_walk($zones_sales_values, function ($val, $date) use (&$sales_years) {
                        $sales_years[] = date('Y', strtotime($date));
                    });
                    $sales_years = array_unique($sales_years);



                    $interval_data = Intervals::intervals($sales_values_per_zone, $sales_years, $request->interval);

                    $sales_values[$zone]  = $interval_data['data_intervals'][$request->interval][$zone] ?? [];




                    $final_report_data[$zone][$sales_discount_field]['Values'] = $zones_discount;
                    $interval_data = Intervals::intervals($final_report_data[$zone][$sales_discount_field], $discount_years, $request->interval);
                    $final_report_data[$zone][$sales_discount_field] = $interval_data['data_intervals'][$request->interval] ?? [];


                    $final_report_data[$zone]['Total']  = $this->finalTotal([($final_report_data[$zone]['Total']  ?? []) ,($final_report_data[$zone][$sales_discount_field]['Values']??[]) ]);






                    $final_report_data['Total'] = $this->finalTotal([($final_report_data['Total'] ?? []), (($final_report_data[$zone][$sales_discount_field]['Values']??[]))]);


                    $final_report_data[$zone][$sales_discount_field]['Perc.% / Sales'] = $this->operationAmongTwoArrays(($final_report_data[$zone][$sales_discount_field]['Values']??[]), ($sales_values[$zone]??[]));




                }
            }
            $zones_names[] = (str_replace( ' ','_', $zone));
        }

        $sales_values = $this->finalTotal([$sales_values??[]]);
        $total = $final_report_data['Total'];
        unset($final_report_data['Total']);
        $final_report_data['Total'] = $total;
        $final_report_data['Discount % / Total Sales'] = $this->operationAmongTwoArrays($final_report_data['Total'],$sales_values);

        // Total Zones & Growth Rate

        $report_data = $final_report_data;

        $dates = array_keys($report_data['Total']);

        $type_name = 'Products / Services';
        return view('client_view.reports.sales_gathering_analysis.sales_discounts_analysis_report',compact('company','view_name','zones_names','dates','report_data','type_name'));

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
    // public function ProductsSalesAnalysisIndex(Company $company)
    // {
    //     // Get The Selected exportable fields returns a pair of ['field_name' => 'viewing name']
    //     $selected_fields = (new ExportTable)->customizedTableField($company, 'InventoryStatement', 'selected_fields');
    //     return view('client_view.reports.sales_gathering_analysis.products_sales_form', compact('company', 'selected_fields'));
    // }


    // public function ProductsSalesAnalysisResult(Request $request, Company $company)
    // {
    //     $dimension = $request->report_type;

    //     $report_data =[];
    //     $growth_rate_data =[];
    //     $products = is_array(json_decode(($request->products[0]))) ? json_decode(($request->products[0])) :$request->products ;

    //     foreach ($products as  $category) {

    //         $sales_gatherings = SalesGathering::company()
    //                 ->where('category',$category)
    //                 ->whereBetween('date', [$request->start_date, $request->end_date])
    //                 ->selectRaw('DATE_FORMAT(date,"%d-%m-%Y") as date,net_sales_value,category')
    //                 ->get()
    //                 ->toArray();

    //         $products_per_month = [];
    //         $products_data = [];


    //         $dt = Carbon::parse($sales_gatherings[0]['date']);
    //         $month = $dt->endOfMonth()->format('d-m-Y');



    //         foreach ($sales_gatherings as $key => $row) {

    //             $dt = Carbon::parse($row['date']);
    //             $current_month = $dt->endOfMonth()->format('d-m-Y');
    //             if($current_month == $month){
    //                 $products_per_month[$current_month][] = $row['net_sales_value'];

    //             }else{
    //                 $month = $current_month;
    //                 $products_per_month[$current_month][] = $row['net_sales_value'];
    //             }

    //             $products_data[$month] = array_sum($products_per_month[$month]);
    //         }

    //         $report_data[$category] = $products_data;
    //         $growth_rate_data[$category] = $this->growthRate($products_data);

    //     }

    //     $total_products = $this->finalTotal($report_data);
    //     $total_products_growth_rates =  $this->growthRate($total_products);
    //     $final_report_data = [];
    //     $products_names =[];
    //     foreach ($products as  $category) {
    //         $final_report_data[$category]['Sales Values'] = $report_data[$category];
    //         $final_report_data[$category]['Growth Rate %'] = $growth_rate_data[$category];
    //         $products_names[] = (str_replace( ' ','_', $category));
    //     }

    //     return view('client_view.reports.sales_gathering_analysis.products_sales_report',compact('company','products_names','total_products_growth_rates','final_report_data','total_products'));

    // }



}
