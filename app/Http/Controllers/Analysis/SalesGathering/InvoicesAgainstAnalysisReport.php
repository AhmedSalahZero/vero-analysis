<?php

namespace App\Http\Controllers\Analysis\SalesGathering;

use App\Http\Controllers\ExportTable;
use App\Models\Company;
use App\Models\SalesGathering;
use App\Traits\GeneralFunctions;
use App\Traits\Intervals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InvoicesAgainstAnalysisReport
{
    use GeneralFunctions;
    public function index(Company $company)
    {
        
        if(Request()->route()->named('invoices.salesChannels.analysis'))
        {
            $type = 'sales_channel';
            $view_name = 'Invoices Against Sales Channel Trend Analysis';
        }

        if(Request()->route()->named('invoices.branches.analysis'))
        {
            $type = 'branch';
            $view_name = 'Invoices Against Branches Trend Analysis';
        }


        if(Request()->route()->named('invoices.zones.analysis'))
        {
            $type = 'zone';
            $view_name = 'Invoices Against Zones Analysis';
        }


         if(Request()->route()->named('invoices.businessSectors.analysis'))
        {
            $type = 'business_sector';
            $view_name = 'Invoices Against Business Sectors Analysis';
        }
        
         if(Request()->route()->named('invoices.customers.analysis'))
        {
            $type = 'customer_name';
            $view_name = 'Invoices Against Customers Analysis';
        }
        if(Request()->route()->named('invoices.Items.analysis'))
        {
            $type = 'product_item';
            $view_name = 'Invoices Against Products Items Analysis';
        }
        if(Request()->route()->named('invoices.salesPersons.analysis'))
        {
             $type = 'sales_person';
            $view_name = 'Invoices Against Sales Persons Analysis';
        }
        // 
        // if (request()->route()->named('categories.zones.analysis')) {
        //     $type = 'zone';
        //     $view_name = 'Categories Against Zones Trend Analysis' ;
        // } elseif (request()->route()->named('categories.customers.analysis')) {
        //     $type = 'customer_name';
        //     $view_name = 'Categories Against Customers Trend Analysis' ;
        // }elseif (request()->route()->named('categories.salesChannels.analysis')) {
        //     $type  = 'sales_channel';
        //     $view_name = 'Categories Against Sales Channels Trend Analysis' ;
        // }elseif (request()->route()->named('categories.products.analysis')) {
        //     $type  = 'product_or_service';
        //     $view_name = 'Categories Against Products / Services Trend Analysis' ;
        // } elseif (request()->route()->named('categories.Items.analysis')) {
        //     $type  = 'product_item';
        //     $view_name = 'Categories Against Products Items Trend Analysis' ;
        // }elseif (request()->route()->named('categories.salesPersons.analysis')) {
        //     $type  = 'sales_person';
        //     $view_name = 'Categories Against Sales Persons Trend Analysis' ;
        // }elseif (request()->route()->named('categories.salesDiscount.analysis')) {
        //     $type  = 'quantity_discount';
        //     $view_name = 'Categories Against Sales Discount Trend Analysis' ;
        // }elseif (request()->route()->named('categories.businessSectors.analysis')) {
        //     $type  = 'business_sector';
        //     $view_name = 'Categories Against Business Sectors Trend Analysis' ;
        // }elseif (request()->route()->named('categories.branches.analysis')) {
        //     $type  = 'branch';
        //     $view_name = 'Categories Against Branches Trend Analysis' ;
        // }
        // elseif (request()->route()->named('categories.products.averagePrices')) {
        //     $type  = 'averagePrices';
        //     $view_name = 'Categories Products / Services Average Prices' ;
        // }

        // elseif (request()->route()->named('customers.categories.analysis')) {
        //     // by salah
        //     $type  = 'category';
        //     $view_name = Customers_Against_Categories_Trend_Analysis ;
        // }

        // elseif (request()->route()->named('customers.products.analysis')) {
        //     $type  = 'product_or_service';
        //     $view_name = Customers_Against_Products_Trend_Analysis ;
        // }

        //  elseif (request()->route()->named('customers.Items.analysis')) {
        //     $type  = 'product_item';
        //     $view_name = Customers_Against_Products_ITEMS_Trend_Analysis ;
        // }
        
        $name_of_selector_label = str_replace(['Categories Against ' ,' Trend Analysis'],'',$view_name);
        return view('client_view.reports.sales_gathering_analysis.invoices_sales_form', compact('company','name_of_selector_label','type','view_name'));
    }


      public function InvoicesSalesAnalysisResult(Request $request, Company $company , $array = false )
    {
       $report_data =[];
        $growth_rate_data =[];
        $final_report_total =[];
        $branches_names = [];
        $branches = is_array(json_decode(($request->branches[0]))) ? json_decode(($request->branches[0])) :$request->branches ;
        $type = $request->type;
        $view_name = $request->view_name;
        $branches = $this->formatTypesAsString($branches);
       $queryResult =  collect(DB::select("select ". $type.",((product_item)) as product_items, ((document_number)) as invoice_number  , Year , Month , net_sales_value
            from sales_gathering
            where document_type in ('INV' , 'inv' , 'invoice','INVOICE','فاتوره') and company_id = ". $company->id ."  
            and ". $type ." in ( ". "\"" . $branches . "\"". ")
            AND date between '".$request->start_date."' and '".$request->end_date."'
            order by year , month"));
            $queryResult = $queryResult->groupBy($type) ;

            $formattedResultForPeriod = $this->formatResultForInterval($queryResult , $request->interval , $type);
            $sumForEachInterval  = $this->sumForEachInterval($formattedResultForPeriod);
            $secondTypesArray = $queryResult->pluck($type)->unique()->toArray();
            $reportSalesValues = [];
            $request['sales_channels'] = $request->branches ;
            $request['businessSectors'] = $request->branches ;
                $request['zones'] = $request->branches ;
            
            if($type == 'sales_channel')
            {
                 $reportSalesValues  = (new SalesChannelsAgainstAnalysisReport())->SalesChannelsSalesAnalysisResult($request , $company , true);
            }
            if($type == 'branch')
            {
                 $reportSalesValues  = (new BranchesAgainstAnalysisReport())->BranchesSalesAnalysisResult($request , $company , true);
            }
            
            if($type == 'zone')
            {
                 $reportSalesValues  = (new ZoneSalesAnalysisReport())->ZoneSalesAnalysisResult($request , $company , true);
            }

            if($type == 'business_sector')
            {
                 $reportSalesValues  = (new BusinessSectorsAgainstAnalysisReport())->BusinessSectorsSalesAnalysisResult($request , $company , true);
            }

            // if($type == 'customer_name')
            // {
            //      $reportSalesValues  =getCustomerSalesAnalysisData($request , $company);
            // }
            // if($type  == 'sales_person')
            // {
            //      $reportSalesValues  = getSalesPersonsSalesAnalysisData($request , $company );
            // }
            if(! $reportSalesValues)
            {
                 $reportSalesValues  =getTypeSalesAnalysisData($request , $company , $type);
            }
            
          array_sort_multi_levels($sumForEachInterval);
          if($array)
          {
              return [
                  'sumForEachInterval'=>$sumForEachInterval , 
                  'reportSalesValues'=>$reportSalesValues
              ] ;
              
          }
        return view('client_view.reports.sales_gathering_analysis.invoices_analysis_report',compact('company','view_name','type','secondTypesArray','sumForEachInterval','reportSalesValues'));


        
        // $data_type = ($request->data_type === null || $request->data_type == 'value')? 'net_sales_value' : 'quantity';
        // foreach ($branches as  $branchName) {
        //     $branches_data =collect(DB::select(DB::raw("
        //         SELECT DATE_FORMAT(LAST_DAY(date),'%d-%m-%Y') as gr_date  , ".$data_type." ,branch," . $type ."
        //         FROM sales_gathering
        //         WHERE ( company_id = '".$company->id."' AND branch = '".$branchName."' AND date between '".$request->start_date."' and '".$request->end_date."')
        //         ORDER BY id "
        //         )))->groupBy($type)->map(function($item)use($data_type){
        //             return $item->groupBy('gr_date')->map(function($sub_item)use($data_type){

        //                 return $sub_item->sum($data_type);
        //             });
        //         })->toArray();
        //     foreach (($request->sales_channels??[]) as $branch_key => $branch) {


        //         $years = [];

        //         $data_per_main_item = $branches_data[$branch]??[];
        //         if (count(($data_per_main_item))>0 ) {

        //             array_walk($data_per_main_item, function ($val, $date) use (&$years) {
        //                 $years[] = date('Y', strtotime($date));
        //             });
        //             $years = array_unique($years);

        //             $report_data[$branchName][$branch]['Sales Values'] = $data_per_main_item;
        //             $interval_data = Intervals::intervals($report_data[$branchName][$branch], $years, $request->interval);
        //             $report_data[$branchName][$branch] = $interval_data['data_intervals'][$request->interval] ?? [];

        //             $report_data[$branchName]['Total']  = $this->finalTotal([($report_data[$branchName]['Total']  ?? []) ,($report_data[$branchName][$branch]['Sales Values']??[]) ]);
        //             $report_data[$branchName][$branch]['Growth Rate %'] = $this->growthRate(($report_data[$branchName][$branch]['Sales Values'] ?? []));


        //         }
        //     }
        //     $final_report_total = $this->finalTotal( [($report_data[$branchName]['Total']??[]) , ($final_report_total??[]) ]);
        //     $report_data[$branchName]['Growth Rate %'] =  $this->growthRate(($report_data[$branchName]['Total']??[]));
        //     $branches_names[] = (str_replace( ' ','_', $branchName));
        // }


        // $report_data['Total'] = $final_report_total;
        // $report_data['Growth Rate %']=  $this->growthRate($report_data['Total']);
        // $dates = array_keys($report_data['Total']);
        return view('client_view.reports.sales_gathering_analysis.invoices_analysis_report',compact('company','view_name','branches_names','dates','report_data',));
    }

    
    public function InvoicesSalesAnalysisIndex(Company $company)
    {
        // Get The Selected exportable fields returns a pair of ['field_name' => 'viewing name']
        $selected_fields = (new ExportTable)->customizedTableField($company, 'InventoryStatement', 'selected_fields');
        return view('client_view.reports.sales_gathering_analysis.categories_sales_form', compact('company', 'selected_fields'));
    }
    public function result(Request $request, Company $company,$result='view')
    {
        
    }
    public function resultForSalesDiscount(Request $request, Company $company)
    {

        // $report_data =[];
        // $final_report_data =[];
        // $growth_rate_data =[];
        // $zones_names = [];
        // $sales_values = [];
        // $sales_years = [];
        // $zones = is_array(json_decode(($request->categoriesData[0]))) ? json_decode(($request->categoriesData[0])) :$request->categoriesData ;

        // $type = $request->type;
        // $view_name = $request->view_name;

        // $fields ='';
        // foreach ($request->sales_discounts_fields as $sales_discount_field_key => $sales_discount_field) {
        //     $fields .= $sales_discount_field .',';
        // }


        // foreach ($zones as  $zone) {

        //     $sales =collect(DB::select(DB::raw("
        //         SELECT DATE_FORMAT(LAST_DAY(date),'%d-%m-%Y') as gr_date  , sales_value ," . $fields ." category
        //         FROM sales_gathering
        //         WHERE ( company_id = '".$company->id."'AND category = '".$zone."' AND date between '".$request->start_date."' and '".$request->end_date."')
        //         ORDER BY id"
        //     )))->groupBy('gr_date');
        //     $sales_values_per_zone[$zone] = $sales->map(function($sub_item){
        //                             return $sub_item->sum('sales_value');
        //                         })->toArray();



        //     foreach ($request->sales_discounts_fields as $sales_discount_field_key => $sales_discount_field) {
        //         $zones_discount = $sales->map(function($sub_item) use($sales_discount_field){
        //                                 return $sub_item->sum($sales_discount_field);
        //                             })->toArray();

        //         $zones_sales_values = [];
        //         $zones_per_month = [];
        //         $zones_data = [];
        //         $discount_years = [];

        //         if (@count($zones_discount) > 0) {


        //             array_walk($zones_discount, function ($val, $date) use (&$discount_years) {
        //                 $discount_years[] = date('Y', strtotime($date));
        //             });
        //             $discount_years = array_unique($discount_years);

        //             array_walk($zones_sales_values, function ($val, $date) use (&$sales_years) {
        //                 $sales_years[] = date('Y', strtotime($date));
        //             });
        //             $sales_years = array_unique($sales_years);



        //             $interval_data = Intervals::intervals($sales_values_per_zone, $sales_years, $request->interval);

        //             $sales_values[$zone]  = $interval_data['data_intervals'][$request->interval][$zone] ?? [];




        //             $final_report_data[$zone][$sales_discount_field]['Values'] = $zones_discount;
        //             $interval_data = Intervals::intervals($final_report_data[$zone][$sales_discount_field], $discount_years, $request->interval);
        //             $final_report_data[$zone][$sales_discount_field] = $interval_data['data_intervals'][$request->interval] ?? [];

        //             $final_report_data[$zone]['Total']  = $this->finalTotal([($final_report_data[$zone]['Total']  ?? []) ,($final_report_data[$zone][$sales_discount_field]['Values']??[]) ]);

        //             $final_report_data['Total'] = $this->finalTotal([($final_report_data['Total'] ?? []), (($final_report_data[$zone][$sales_discount_field]['Values']??[]))]);

        //             $final_report_data[$zone][$sales_discount_field]['Perc.% / Sales'] = $this->operationAmongTwoArrays(($final_report_data[$zone][$sales_discount_field]['Values']??[]), ($sales_values[$zone]??[]));


        //         }
        //     }
        //     $zones_names[] = (str_replace( ' ','_', $zone));
        // }

        // $sales_values = $this->finalTotal([$sales_values??[]]);
        // $total = $final_report_data['Total'] ?? [];
        // unset($final_report_data['Total']);
        // $final_report_data['Total'] = $total;
        // $final_report_data['Discount % / Total Sales'] = $this->operationAmongTwoArrays($final_report_data['Total'],$sales_values);

        // $report_data = $final_report_data;

        // $dates = array_keys(($report_data['Total']??[]));

        // $type_name = 'Categories';
        // return view('client_view.reports.sales_gathering_analysis.sales_discounts_analysis_report',compact('company','view_name','zones_names','dates','report_data','type_name'));

    }

    function formatResultForInterval(Collection $queryResult , $interval , $type)
    {
        $startAndEndYear = getYearsFromInterval(Request('start_date') , Request('end_date'));
        $startYear = $startAndEndYear['start_year'];
        $endYear = $startAndEndYear['end_year'];
        $branches  = \array_keys($queryResult->toArray());
        $results = [];
       foreach($branches as $branch)
       {
            for( $startYear ; $startYear <=$endYear ; $startYear++)
            {
            foreach(getPeriods($interval) as $periodName => $period)
            {
                  foreach($queryResult[$branch] as $result)
                  {
                      $result =  json_decode(json_encode($result), true);
                      if(in_array($result['Month'] , $period  ) && $result['Year'] == $startYear && $result[$type] == $branch)
                      {
                          isset($results[$branch][$startYear][$periodName][$result['Month']]) ? 
                          array_push($results[$branch][$startYear][$periodName][$result['Month']] , $result) :
                          $results[$branch][$startYear][$periodName][$result['Month']][0] = $result ; 
                      }
                  }
            }
          
        }
        $startYear = $startAndEndYear['start_year'] ;
       }
       return $results;
        
    }

    public function sumForEachInterval(array $array)
    {
        $result = [];
        foreach($array as $branchName=>$dataArray)
        {
            foreach($dataArray as $year => $data)
            {
            foreach($data as $intervalNumber=>$dataToArray)
            {
                $ProductsItemNumber = count_array_values($dataToArray);
                // $ProductsItemNumber = count(array_count_value_for_key($dataToArray  , 'product_items')); 
                $InvoiceNumber = count(array_unique_value($dataToArray  , 'invoice_number')); 
                $result[$branchName][$year][$intervalNumber]['product_item'] =$ProductsItemNumber ;
                $result[$branchName][$year][$intervalNumber]['invoice_number'] = $InvoiceNumber ;
                $result[$branchName][$year][$intervalNumber]['avg'] =$InvoiceNumber ?  $ProductsItemNumber / $InvoiceNumber  : 0 ;
            }
            }
        }
        return $result ;
    } 

    public function formatTypesAsString($branches)
    {
        if(is_array($branches))
        {
            return implode('", "',$branches);
        }
     
        return $branches ;
    }
  
    public function growthRate($data)
    {

        // $prev_month = 0;
        // $final_data = [];
        // foreach ($data as $date => $value) {
        //     $prev_month = (round($prev_month));
        //     if ($prev_month <= 0 && $value<=0) {
        //         $final_data[$date] = 0 ;
        //     }if ($prev_month <  0 && $value >= 0) {
        //         $final_data[$date] =  ((($value - $prev_month) / $prev_month) * 100)*(-1);
        //     }else{

        //         $final_data[$date] = $prev_month != 0 ? (($value - $prev_month) / $prev_month) * 100 : 0;
        //     }
        //     $prev_month = $value;
        // }
        // return $final_data;
    }


}
