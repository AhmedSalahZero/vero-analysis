<?php

namespace App\Http\Controllers\Analysis\SalesGathering;

use App\Models\Company;
use App\Models\SalesGathering;
use App\Services\Caching\CustomerDashboardCashing;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CustomersNaturesAnalysisReport
{
    use GeneralFunctions;
    public function index(Company $company)
    {

        if (request()->route()->named('customersNatures.analysis')) {
            $type = 'customer_nature';
            $view_name = 'Customers Natures Analysis';
        } elseif (request()->route()->named('zones.vs.customersNatures')) {
            $type = 'zone';
            $view_name = 'Zones Versus Customers Natures Analysis';
        } elseif (request()->route()->named('salesChannels.vs.customersNatures')) {
            $type = 'sales_channel';
            $view_name = 'Sales Channels Versus Customers Natures Analysis';
        } elseif (request()->route()->named('businessSectors.vs.customersNatures')) {
            $type = 'business_sector';
            $view_name = 'Business Sectors Versus Customers Natures Analysis';
        } elseif (request()->route()->named('branches.vs.customersNatures')) {
            $type = 'branch';
            $view_name = 'Branches Versus Customers Natures Analysis';
        } elseif (request()->route()->named('categories.vs.customersNatures')) {
            $type = 'category';
            $view_name = 'Categories Versus Customers Natures Analysis';
        } elseif (request()->route()->named('products.vs.customersNatures')) {
            $type = 'product_or_service';
            $view_name = 'Products Versus Customers Natures Analysis';
        } elseif (request()->route()->named('Items.vs.customersNatures')) {
            $type = 'product_item';
            $view_name = 'Products Items Versus Customers Natures Analysis';
        }elseif (request()->route()->named('countries.vs.customersNatures')) {
            $type = 'country';
            $view_name = 'Countries Versus Customers Natures Analysis';
        }


        return view('client_view.reports.sales_gathering_analysis.customer_nature.sales_form', compact('company', 'view_name', 'type'));
    }

    public function result(Request $request, Company $company,$result='view')
    {
        $report_data = [];
        $type = $request->type;
        $view_name = $request->view_name;
        $requested_date = $request->date;
        $first_date_of_current_year = date('Y-01-01', strtotime($request->date));
        $dates = [
            'start_date' => date('d-M-Y', strtotime($first_date_of_current_year)),
            'end_date' => date('d-M-Y', strtotime($request->date))
        ];
        $all_items = [];


        $year = Carbon::make($request->date)->format('Y');
        // dd($dates);
        // dd($company , $year);
        
        
        $customerDashboardCashing = new CustomerDashboardCashing($company , $year);
        
        $cashedResult = $customerDashboardCashing->cacheAll();
        
        $newCustomers = $cashedResult['newCustomers']; 
        $RepeatingCustomers = $cashedResult['RepeatingCustomers']; 
        $activeCustomers = $cashedResult['activeCustomers']; 
        $stopReactive = $cashedResult['stopReactive']; 
        $deadReactivatedCustomers = $cashedResult['deadReactivatedCustomers']; 
        $stopRepeatingCustomers = $cashedResult['stopRepeatingCustomers']; 
        $stopCustomers = $cashedResult['stopCustomers']; 
        $deadCustomers = $cashedResult['deadCustomers']; 
        $totals = $cashedResult['totals']; 
        $customers_natures = $statics = [
                'totals'=>$totals,
                'statictics'=>[
                    'New'=>$newCustomers,
                    'Repeating'=>$RepeatingCustomers,
                    'Active'=>$activeCustomers,
                    'Stop / Reactivated'=>$stopReactive,
                    'Dead / Reactivated'=>$deadReactivatedCustomers,
                    'Stop / Repeating'=>$stopRepeatingCustomers,
                ] ,
                 'stops'=>[
                    'Stop'=>$stopCustomers,
                    'Dead'=>$deadCustomers,
                ]
            ] ;
        /** End New Date */
        
        // $sales_gathering = collect(DB::select(DB::raw("
        //     SELECT DATE_FORMAT((date),'%Y') as year,date , net_sales_value,customer_name
        //     FROM sales_gathering
        //     WHERE ( company_id = '".$company->id."' AND date <= '".$request->date."')
        //     ORDER BY id "
        // )));



        // $customers_years = $sales_gathering->groupBy('customer_name')->map(function($item,$year){
        //     return  $item->unique(function($sub_item,$name)use($item,$year){

        //             return  $sub_item->year;
        //     })->pluck('year')->toArray();
        // })->toArray();



        // $years = $sales_gathering->groupBy('year')->flatMap(function($item,$year){

        //         return  [$year];
        //         })
        //         ->toArray();


        // $current_year = date('Y', strtotime($request->date));
        // $previous_year_one = $current_year - 1;
        // $previous_year_two = $current_year - 2;

        // $previous_date_one =  $previous_year_one.'-01-01';
        // $previous_date_two =  $previous_year_two.'-01-01';




        // $customers_data_years = [];
        // $customers_natures = [];
        // $report_data = [];
        // $charts_data = ['counts' => [], 'total_sales_values' => []];


        // $report_data = [
        //     'New' => [],
        //     'Repeating' => [],
        //     'Active' => [],
        //     'Stop' => [],
        //     'Dead' => [],
        //     'Stop / Reactivated' => [],
        //     'Dead / Reactivated' => [],
        //     'Stop / Repeating' => []
        // ];

        // foreach ($customers_years as  $customer_name => $customer_years) {
        //     foreach ($years as  $year) {
        //         if (false !== $found = array_search($year, $customer_years)) {
                    
        //             $customers_data_years[$customer_name][$year] = 1;
        //         } else {
        //             $customers_data_years[$customer_name][$year] = 0;
        //         }
        //     }

        //     if ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && array_sum(($customers_data_years[$customer_name] ?? [])) === 1) {
        //         $report_data['New']['customers'][] = $customer_name;
        //         $report_data['New']['count'] = ($report_data['New']['count'] ?? 0) + 1;
        //     } elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && ((($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && array_sum(($customers_data_years[$customer_name] ?? [])) === 2)) {
        //         $report_data['Repeating']['customers'][] = $customer_name;
        //         $report_data['Repeating']['count'] = ($report_data['Repeating']['count'] ?? 0) + 1;
        //     } elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
        //         $report_data['Active']['customers'][] = $customer_name;
        //         $report_data['Active']['count'] = ($report_data['Active']['count'] ?? 0) + 1;
        //     } elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
        //         $report_data['Dead']['customers'][] = $customer_name;
        //         $report_data['Dead']['count'] = ($report_data['Dead']['count'] ?? 0) + 1;
        //     } elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1)) {
        //         $report_data['Stop']['customers'][] = $customer_name;
        //         $report_data['Stop']['count'] = ($report_data['Stop']['count'] ?? 0) + 1;
        //     } elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
        //         $report_data['Stop / Reactivated']['customers'][] = $customer_name;
        //         $report_data['Stop / Reactivated']['count'] = ($report_data['Stop / Reactivated']['count'] ?? 0) + 1;
        //     } elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 0)) {
        //         $report_data['Dead / Reactivated']['customers'][] = $customer_name;
        //         $report_data['Dead / Reactivated']['count'] = ($report_data['Dead / Reactivated']['count'] ?? 0) + 1;
        //     } elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && ((($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 0))) {
        //         $report_data['Stop / Repeating']['customers'][] = $customer_name;
        //         $report_data['Stop / Repeating']['count'] = ($report_data['Stop / Repeating']['count'] ?? 0) + 1;
        //     }
        //     ksort($customers_data_years[$customer_name]);
        // }



        // $data_of_previous_date_one = $sales_gathering->whereBetween('date', [$previous_date_one, $request->date]);
        // $data_of_previous_date_two = $sales_gathering->whereBetween('date', [$previous_date_two, $request->date]);
        // $data_of_first_date_of_current_year = $sales_gathering->whereBetween('date', [$first_date_of_current_year, $request->date]);



        // foreach ($report_data as $customer_nature => $nature_data) {
        //     $customers = $nature_data['customers'] ?? [];
        //     if($customer_nature == 'Stop'){
        //         $total_sales_values = $data_of_previous_date_one->whereIn('customer_name', $customers)->sum('net_sales_value');
        //     }elseif ($customer_nature == 'Dead') {
        //         $total_sales_values = $data_of_previous_date_two->whereIn('customer_name', $customers)->sum('net_sales_value');

        //     }else{
        //         $total_sales_values = $data_of_first_date_of_current_year->whereIn('customer_name', $customers)->sum('net_sales_value');
        //     }
        //     $report_data[$customer_nature]['Total Sales Values'] = $total_sales_values;
           
        //     $charts_data['counts'][] = ['name' => $customer_nature, 'value' => ($nature_data['count']??0)];
        //     $charts_data['total_sales_values'][] = ['name' => $customer_nature, 'value' => $total_sales_values];

        // }
        $last_date = null;

        if ($result=='view') {
            $last_date = SalesGathering::company()->latest('date')->first()->date ??'';
            $last_date = date('d-M-Y', strtotime($last_date));
            $date = $requested_date ;
            $reportDataFormatted = $this->formatCustomerAnalysisReport($customers_natures);
            return view('client_view.reports.sales_gathering_analysis.customer_nature.sales_report', compact('reportDataFormatted','last_date', 'type', 'view_name', 'dates', 'company', 'date', 'statics','requested_date','newCustomers','customers_natures'));
        }else{
            return array_merge($report_data , $statics
            
            );
        }

    }
    private function formatCustomerAnalysisReport($customers_natures)
    {
        $data = array_merge($customers_natures['statictics'] , $customers_natures['stops']);
        
        $reportData = [
            'Counts'=>[],
            'Total Sales Values'=>[]
        ];
        $allTypesCount =   array_sum(array_map("count", $data)) ;
        
        
        foreach($data as $customerType=>$values){
            $totalSumOfType = 0 ; 
            $reportData['Counts'][]= ['name'=>$customerType  ,'val'=>$allTypesCount ? ( count($values) / $allTypesCount ) * 100 : 0 ] ; 
            foreach($data[$customerType] as $singleCustomerOfType){
                $totalSumOfType += $singleCustomerOfType->total_sales  ; 
            }
            $reportData['Total Sales Values'][]= ['name'=>$customerType , 'val'=>$totalSumOfType];
        }

        return $reportData ; 
        
    }




    public function oldtwoDimensionalResult(Request $request, Company $company)
    {

        $report_sales_values = [];
        $report_counts = [];
        $type = $request->type;

        $view_name = $request->view_name;
        $last_date = null;
        $first_date_of_current_year = date('Y-01-01', strtotime($request->date));
        $dates = [
            'start_date' => date('d-M-Y', strtotime($first_date_of_current_year)),
            'end_date' => date('d-M-Y', strtotime($request->date))
        ];
        $all_items = [];
        $main_type_items = SalesGathering::company()->whereNotNull($type)->groupBy($type)->selectRaw($type)->whereDate('date', '<=', $request->date)->get()->pluck($type)->toArray();

        // Years
        $current_year = date('Y', strtotime($request->date));
        $previous_year_one = $current_year - 1;
        $previous_year_two = $current_year - 2;


        $previous_date_one =  $previous_year_one.'-01-01';
        $previous_date_two =  $previous_year_two.'-01-01';
        ///////////////////////////////////////////////
        $all_items = [
            'New',
            'Repeating',
            'Active',
            'Stop',
            'Dead',
            'Stop / Reactivated',
            'Dead / Reactivated',
            'Stop / Repeating'
        ];
        $report_totals_sales_values = [];
        $report_counts_totals = [];
        foreach ($main_type_items as  $main_type_item_name) {


            $sales_gathering = SalesGathering::company()->whereNotNull($type)->where($type,$main_type_item_name)->whereDate('date', '<=', $request->date)->selectRaw('DATE_FORMAT(date,"%Y") as year,net_sales_value,customer_name,date');
            $all_data  = $sales_gathering->get();
            $years = $sales_gathering->get()->pluck('year')->toArray();
            $years = array_unique($years);

            $customers_years = $sales_gathering->groupBy(['customer_name', 'year']) // group by query
                ->get()
                ->mapToGroups(function ($item, $key) {
                    return [$item['customer_name'] => $item['year']];
                });


            $report_data[$main_type_item_name] = [
                'New' => [],
                'Repeating' => [],
                'Active' => [],
                'Stop' => [],
                'Dead' => [],
                'Stop / Reactivated' => [],
                'Dead / Reactivated' => [],
                'Stop / Repeating' => []
            ];
            // Customer Natures
            foreach ($customers_years as  $customer_name => $years_query) {
                $customer_years = $years_query->toArray();
                foreach ($years as  $year) {
                    if (false !== $found = array_search($year, $customer_years)) {
                        $customers_data_years[$customer_name][$year] = 1;
                    } else {
                        $customers_data_years[$customer_name][$year] = 0;
                    }
                }


                // New
                if ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && array_sum(($customers_data_years[$customer_name] ?? [])) === 1) {
                    $report_data[$main_type_item_name]['New']['customers'][] = $customer_name;
                    $report_data[$main_type_item_name]['New']['count'] = ($report_data[$main_type_item_name]['New']['count'] ?? 0) + 1;
                }
                // Repeating
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && ((($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && array_sum(($customers_data_years[$customer_name] ?? [])) === 2)) {
                    $report_data[$main_type_item_name]['Repeating']['customers'][] = $customer_name;
                    $report_data[$main_type_item_name]['Repeating']['count'] = ($report_data[$main_type_item_name]['Repeating']['count'] ?? 0) + 1;
                }
                // Active
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
                    $report_data[$main_type_item_name]['Active']['customers'][] = $customer_name;
                    $report_data[$main_type_item_name]['Active']['count'] = ($report_data[$main_type_item_name]['Active']['count'] ?? 0) + 1;
                }
                // Dead
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
                    $report_data[$main_type_item_name]['Dead']['customers'][] = $customer_name;
                    $report_data[$main_type_item_name]['Dead']['count'] = ($report_data[$main_type_item_name]['Dead']['count'] ?? 0) + 1;
                }
                // Stop
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1)) {
                    $report_data[$main_type_item_name]['Stop']['customers'][] = $customer_name;
                    $report_data[$main_type_item_name]['Stop']['count'] = ($report_data[$main_type_item_name]['Stop']['count'] ?? 0) + 1;
                }
                // 'Stop / Reactivated
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
                    $report_data[$main_type_item_name]['Stop / Reactivated']['customers'][] = $customer_name;
                    $report_data[$main_type_item_name]['Stop / Reactivated']['count'] = ($report_data[$main_type_item_name]['Stop / Reactivated']['count'] ?? 0) + 1;
                }
                // Dead / Reactivated
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 0)) {
                    $report_data[$main_type_item_name]['Dead / Reactivated']['customers'][] = $customer_name;
                    $report_data[$main_type_item_name]['Dead / Reactivated']['count'] = ($report_data[$main_type_item_name]['Dead / Reactivated']['count'] ?? 0) + 1;
                }
                // Stop / Repeating
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && ((($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 0))) {
                    $report_data[$main_type_item_name]['Stop / Repeating']['customers'][] = $customer_name;
                    $report_data[$main_type_item_name]['Stop / Repeating']['count'] = ($report_data[$main_type_item_name]['Stop / Repeating']['count'] ?? 0) + 1;
                }
                ksort($customers_data_years[$customer_name]);
            }
            // Calculating Total Sales Values
            foreach ($report_data[$main_type_item_name] as $customer_nature => $nature_data) {
                $customers = $nature_data['customers'] ?? [];
                if($customer_nature == 'Stop'){
                    $total_sales_values = SalesGathering::company()->whereBetween('date', [$previous_date_one, $request->date])->whereIn('customer_name', $customers)->sum('net_sales_value');
                }elseif ($customer_nature == 'Dead') {
                    $total_sales_values = SalesGathering::company()->whereBetween('date', [$previous_date_two, $request->date])->whereIn('customer_name', $customers)->sum('net_sales_value');
                }else{

                    $total_sales_values = SalesGathering::company()->whereBetween('date', [$first_date_of_current_year, $request->date])->whereIn('customer_name', $customers)->sum('net_sales_value');
                }
                $report_sales_values[$main_type_item_name][$customer_nature] = $total_sales_values;
                $report_counts[$main_type_item_name][$customer_nature] = ($nature_data['count']??0);
            }


            $report_totals_sales_values[$main_type_item_name] =  array_sum($report_sales_values[$main_type_item_name] ?? []);
            $report_totals_counts[$main_type_item_name] =  array_sum($report_counts[$main_type_item_name] ?? []);

        }



        // sales_values
            $items_totals_sales_values = $this->finalTotal([$report_sales_values]);
            // $main_type_items_totals

            arsort($report_totals_sales_values);


            if(count($report_totals_sales_values) > 20){
                $report_view_data = collect($report_totals_sales_values);
                $top_20 = $report_view_data->take(20);
                $report_view_data = $top_20->toArray();
                $report_totals_sales_values = $report_view_data;
                foreach ($report_view_data as $name_of_main_item => $data) {
                    $result[$name_of_main_item] =$report_sales_values[$name_of_main_item];
                    unset($report_sales_values[$name_of_main_item]);
                }
                $result['Others '.count($report_sales_values)] =  $this->finalTotal([$report_sales_values]);

                $report_totals_sales_values['Others '.count($report_sales_values)]  = array_sum(($result['Others '.count($report_sales_values)]??[]));
                $report_sales_values = $result;
            }

        // counts
        $items_totals_counts = $this->finalTotal([$report_counts]);
        // $main_type_items_totals

        arsort($report_totals_counts);


        if(count($report_totals_counts) > 20){
            $report_view_data = collect($report_totals_counts);
            $top_20 = $report_view_data->take(20);
            $report_view_data = $top_20->toArray();
            $report_totals_counts = $report_view_data;
            foreach ($report_view_data as $name_of_main_item => $data) {
                $result[$name_of_main_item] =$report_counts[$name_of_main_item];
                unset($report_counts[$name_of_main_item]);
            }
            $result['Others '.count($report_counts)] =  $this->finalTotal([$report_counts]);

            $report_totals_counts['Others '.count($report_counts)]  = array_sum(($result['Others '.count($report_counts)]??[]));
            $report_counts = $result;
        }

        $last_date = SalesGathering::company()->latest('date')->first()->date;
        $last_date = date('d-M-Y', strtotime($last_date));
        $all_items = array_unique($all_items);

        return view('client_view.reports.sales_gathering_analysis.customer_nature.two_dimensional_report', compact('company', 'view_name',
                                                                                                                    'type',
                                                                                                                    'all_items', 'main_type_items',
                                                                                                                    'report_counts','items_totals_counts',
                                                                                                                    'report_totals_counts',
                                                                                                                    'report_sales_values', 'last_date',
                                                                                                                    'dates', 'items_totals_sales_values',
                                                                                                                    'report_totals_sales_values'));
    }






























    public function twoDimensionalResult(Request $request, Company $company)
    {
        $start = microtime(true);

        $report_sales_values = [];
        $report_counts = [];
        $report_totals_counts = [];
        $type = $request->type;

        $view_name = $request->view_name;
        $last_date = null;
        $first_date_of_current_year = date('Y-01-01', strtotime($request->date));
        $dates = [
            'start_date' => date('d-M-Y', strtotime($first_date_of_current_year)),
            'end_date' => date('d-M-Y', strtotime($request->date))
        ];
        $all_items = [];

        // $all_data_query = SalesGathering::company()
        //                     ->whereNotNull($type)
        //                     ->whereDate('date', '<=', $request->date)
        //                     ->selectRaw('DATE_FORMAT(date,"%Y") as year,id,net_sales_value,customer_name,date,'.$type);



        $sales_gathering = collect(DB::select(DB::raw("
            SELECT DATE_FORMAT(LAST_DAY(date),'%Y') as year,date , net_sales_value,customer_name, ".$type."
            FROM sales_gathering
            WHERE ( company_id = '".$company->id."' AND date <= '".$request->date."')
            ORDER BY id "
        )));

        $customers_years = $sales_gathering->groupBy('customer_name')->map(function($item,$year){
                                return  $item->unique(function($sub_item,$name)use($item,$year){
                                        return  $sub_item->year;
                                })->pluck('year')->toArray();
                            })->toArray();

        // Years
        $current_year = date('Y', strtotime($request->date));
        $previous_year_one = $current_year - 1;
        $previous_year_two = $current_year - 2;
        $first_date_of_current_year = $current_year.'-01-01';
        $previous_date_one =  $previous_year_one.'-01-01';
        $previous_date_two =  $previous_year_two.'-01-01';


        $current_year_sales_gathering =$sales_gathering->whereBetween('date', [$first_date_of_current_year, $request->date]);
        $previous_date_one_sales_gathering =$sales_gathering->whereBetween('date', [$previous_date_one, $request->date]);
        $previous_date_two_sales_gathering =$sales_gathering->whereBetween('date', [$previous_date_two, $request->date]);


        $main_type_items_totals = $current_year_sales_gathering->groupBy($type)->map(function($item,$name){
            return  $item->sum('net_sales_value') ;
         })->sortDesc()->toArray();


        $years = $sales_gathering->groupBy('year')->flatMap(function($item,$year){return  [$year];})->toArray();





        ///////////////////////////////////////////////
        $all_items = [
            'New',
            'Repeating',
            'Active',
            'Stop',
            'Dead',
            'Stop / Reactivated',
            'Dead / Reactivated',
            'Stop / Repeating'
        ];
        $report_totals_sales_values = [];
        $report_counts_totals = [];
        $items_totals_sales_values = [];
        $report_totals_counts = [];




            $report_data  = [
                'New' => [],
                'Repeating' => [],
                'Active' => [],
                'Stop' => [],
                'Dead' => [],
                'Stop / Reactivated' => [],
                'Dead / Reactivated' => [],
                'Stop / Repeating' => []
            ];
            // Customer Natures
            foreach ($customers_years as  $customer_name => $customer_years) {
                // $customer_years = $years_query->toArray();
                count($customer_years)==0 ?: array_unique($customer_years);
                foreach ($years as  $year) {
                    if (false !== $found = array_search($year, $customer_years)) {
                        $customers_data_years[$customer_name][$year] = 1;
                    } else {
                        $customers_data_years[$customer_name][$year] = 0;
                    }
                }


                // New
                if ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) &&
                    array_sum(($customers_data_years[$customer_name] ?? [])) === 1) {
                    $report_data['New']['customers'][] = $customer_name;
                    $report_data['New']['count'] = ($report_data['New']['count'] ?? 0) + 1;
                }
                // Repeating
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) &&
                    ((($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) &&
                    array_sum(($customers_data_years[$customer_name] ?? [])) === 2)) {
                    $report_data['Repeating']['customers'][] = $customer_name;
                    $report_data['Repeating']['count'] = ($report_data['Repeating']['count'] ?? 0) + 1;
                }
                // Active
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) &&
                         (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) &&
                        (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
                    $report_data['Active']['customers'][] = $customer_name;
                    $report_data['Active']['count'] = ($report_data['Active']['count'] ?? 0) + 1;
                }
                // Dead
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 0) &&
                (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) &&
                (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
                    $report_data['Dead']['customers'][] = $customer_name;
                    $report_data['Dead']['count'] = ($report_data['Dead']['count'] ?? 0) + 1;
                }
                // Stop
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 0) &&
                (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1)) {
                    $report_data['Stop']['customers'][] = $customer_name;
                    $report_data['Stop']['count'] = ($report_data['Stop']['count'] ?? 0) + 1;
                }
                // 'Stop / Reactivated
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) &&
                (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
                    $report_data['Stop / Reactivated']['customers'][] = $customer_name;
                    $report_data['Stop / Reactivated']['count'] = ($report_data['Stop / Reactivated']['count'] ?? 0) + 1;
                }
                // Dead / Reactivated
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 0)) {
                    $report_data['Dead / Reactivated']['customers'][] = $customer_name;
                    $report_data['Dead / Reactivated']['count'] = ($report_data['Dead / Reactivated']['count'] ?? 0) + 1;
                }
                // Stop / Repeating
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && ((($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 0))) {
                    $report_data['Stop / Repeating']['customers'][] = $customer_name;
                    $report_data['Stop / Repeating']['count'] = ($report_data['Stop / Repeating']['count'] ?? 0) + 1;
                }
                ksort($customers_data_years[$customer_name]);
            }





            $report_sales_values =[];
            $report_totals_counts =[];
            $main_type_items = array_keys($main_type_items_totals);

            foreach ($report_data as $customers_nature => $customers_nature_data) {

                $customers = $customers_nature_data['customers']??[] ;
                foreach ($main_type_items as   $item_name) {
                    if ($customers_nature == 'Stop') {
                       $data_query_interval =  $previous_date_one_sales_gathering;
                    }elseif ($customers_nature == 'Dead') {
                       $data_query_interval =  $previous_date_two_sales_gathering;
                    }
                    else  {
                       $data_query_interval =  $current_year_sales_gathering;
                    }
                    $queries = $data_query_interval->where($type,$item_name)
                                                 ->whereIn('customer_name',$customers)
                                                 ->groupBy('customer_name')
                                                 ->map(function ($item_name){
                                                    return $item_name->sum('net_sales_value');
                                                })->toArray();
                    $report_sales_values[$item_name][$customers_nature] = array_sum(($queries??[]));
                    $report_counts[$item_name][$customers_nature] = count(($queries??[]));

                    $queries=[];
                }



                // $report_totals_counts[$item_name] = array_sum($report_counts[$item_name]);
            }
            foreach ($report_counts as $item => $values) {
                $report_totals_counts[$item] = array_sum($values);
            }
            $report_totals_sales_values  =$main_type_items_totals  ;




        // sales_values
            $items_totals_sales_values = $this->finalTotal([$report_sales_values]);
            // $main_type_items_totals



            if(count($report_totals_sales_values) > 50){
                arsort($report_totals_sales_values);
                $report_view_data = collect($report_totals_sales_values);
                $top_20 = $report_view_data->take(50);
                $report_view_data = $top_20->toArray();
                $report_totals_sales_values = $report_view_data;
                foreach ($report_view_data as $name_of_main_item => $data) {
                    $result[$name_of_main_item] =$report_sales_values[$name_of_main_item];
                    unset($report_sales_values[$name_of_main_item]);
                }
                $result['Others '.count($report_sales_values)] =  $this->finalTotal([$report_sales_values]);

                $report_totals_sales_values['Others '.count($report_sales_values)]  = array_sum(($result['Others '.count($report_sales_values)]??[]));
                $report_sales_values = $result;
            }

        // counts
        $items_totals_counts = $this->finalTotal([$report_counts]);
        // $main_type_items_totals




        if(count($report_totals_counts) > 50){
            arsort($report_totals_counts);
            $report_view_data = collect($report_totals_counts);
            $top_20 = $report_view_data->take(50);
            $report_view_data = $top_20->toArray();
            $report_totals_counts = $report_view_data;
            foreach ($report_view_data as $name_of_main_item => $data) {
                $result[$name_of_main_item] =$report_counts[$name_of_main_item];
                unset($report_counts[$name_of_main_item]);
            }
            $result['Others '.count($report_counts)] =  $this->finalTotal([$report_counts]);

            $report_totals_counts['Others '.count($report_counts)]  = array_sum(($result['Others '.count($report_counts)]??[]));
            $report_counts = $result;
        }

        $last_date = SalesGathering::company()->latest('date')->first()->date;
        $last_date = date('d-M-Y', strtotime($last_date));
        // $all_items = array_unique($all_items);
        $all_items = [
            'New',
            'Repeating',
            'Active',
            'Stop / Reactivated',
            'Dead / Reactivated',
            'Stop / Repeating'
        ];
        return view('client_view.reports.sales_gathering_analysis.customer_nature.two_dimensional_report', compact('company', 'view_name',
                                                                                                                    'type',
                                                                                                                    'all_items', 'main_type_items',
                                                                                                                    'report_counts','items_totals_counts',
                                                                                                                    'report_totals_counts',
                                                                                                                    'report_sales_values', 'last_date',
                                                                                                                    'dates', 'items_totals_sales_values',
                                                                                                                    'report_totals_sales_values'));
    }





















































    // // New
    public function NweTwoDimensionalResult(Request $request, Company $company)
    {

        $report_sales_values = [];
        $report_counts = [];
        $type = $request->type;

        $view_name = $request->view_name;
        $last_date = null;
        $first_date_of_current_year = date('Y-01-01', strtotime($request->date));
        $dates = [
            'start_date' => date('d-M-Y', strtotime($first_date_of_current_year)),
            'end_date' => date('d-M-Y', strtotime($request->date))
        ];
        $all_items = [];

        $sales_gathering = SalesGathering::company()->whereNotNull($type)->whereDate('date', '<=', $request->date)->selectRaw('DATE_FORMAT(date,"%Y") as year,net_sales_value,customer_name,date,'.$type);


        // Years
        $current_year = date('Y', strtotime($request->date));
        $previous_year_one = $current_year - 1;
        $previous_year_two = $current_year - 2;


        $previous_date_one =  $previous_year_one.'-01-01';
        $previous_date_two =  $previous_year_two.'-01-01';
        ///////////////////////////////////////////////

        $report_totals_sales_values = [];
        $report_counts_totals = [];

        $all_data  = $sales_gathering->get();

        $years = $sales_gathering->get()->pluck('year')->toArray();
        $years = array_unique($years);

        $customers_years = $sales_gathering->groupBy(['customer_name', 'year']) // group by query
            ->get()
            ->mapToGroups(function ($item, $key) {
                return [$item['customer_name'] => $item['year']];
            });


                // dd($customers_years);
            $report_data = [
                'New' => [],
                'Repeating' => [],
                'Active' => [],
                'Stop' => [],
                'Dead' => [],
                'Stop / Reactivated' => [],
                'Dead / Reactivated' => [],
                'Stop / Repeating' => []
            ];
            // Customer Natures
            foreach ($customers_years as  $customer_name => $years_query) {
                $customer_years = $years_query->toArray();
                count($customer_years)==0 ?: array_unique($customer_years);
                foreach ($years as  $year) {
                    if (false !== $found = array_search($year, $customer_years)) {
                        $customers_data_years[$customer_name][$year] = 1;
                    } else {
                        $customers_data_years[$customer_name][$year] = 0;
                    }
                }


                // New
                if ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && array_sum(($customers_data_years[$customer_name] ?? [])) === 1) {
                    $report_data['New']['customers'][] = $customer_name;
                    $report_data['New']['count'] = ($report_data['New']['count'] ?? 0) + 1;
                }
                // Repeating
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && ((($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && array_sum(($customers_data_years[$customer_name] ?? [])) === 2)) {
                    $report_data['Repeating']['customers'][] = $customer_name;
                    $report_data['Repeating']['count'] = ($report_data['Repeating']['count'] ?? 0) + 1;
                }
                // Active
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
                    $report_data['Active']['customers'][] = $customer_name;
                    $report_data['Active']['count'] = ($report_data['Active']['count'] ?? 0) + 1;
                }
                // Dead
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {

                    $report_data['Dead']['customers'][] = $customer_name;
                    $report_data['Dead']['count'] = ($report_data['Dead']['count'] ?? 0) + 1;
                }
                // Stop
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1)) {
                    $report_data['Stop']['customers'][] = $customer_name;
                    $report_data['Stop']['count'] = ($report_data['Stop']['count'] ?? 0) + 1;
                }
                // 'Stop / Reactivated
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
                    $report_data['Stop / Reactivated']['customers'][] = $customer_name;
                    $report_data['Stop / Reactivated']['count'] = ($report_data['Stop / Reactivated']['count'] ?? 0) + 1;
                }
                // Dead / Reactivated
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 0)) {
                    $report_data['Dead / Reactivated']['customers'][] = $customer_name;
                    $report_data['Dead / Reactivated']['count'] = ($report_data['Dead / Reactivated']['count'] ?? 0) + 1;
                }
                // Stop / Repeating
                elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && ((($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 0))) {
                    $report_data['Stop / Repeating']['customers'][] = $customer_name;
                    $report_data['Stop / Repeating']['count'] = ($report_data['Stop / Repeating']['count'] ?? 0) + 1;
                }

                ksort($customers_data_years[$customer_name]);

            }

            // Calculating Total Sales Values
            foreach ($report_data as $customer_nature => $nature_data) {

                $customers = $nature_data['customers'] ?? [];
                if($customer_nature == 'Stop'){
                    $total_sales_values = SalesGathering::company()->whereNotNull($type)->whereIn('customer_name',$customers)->whereBetween('date', [$previous_date_one, $request->date])->selectRaw('net_sales_value, product_item')->get();

                }elseif ($customer_nature == 'Dead') {
                    $total_sales_values = SalesGathering::company()->whereNotNull($type)->whereIn('customer_name',$customers)->whereBetween('date', [$previous_date_two, $request->date])->selectRaw('net_sales_value, product_item')->get();

                }else{

                    $total_sales_values = SalesGathering::company()->whereNotNull($type)->whereIn('customer_name',$customers)->whereBetween('date', [$first_date_of_current_year, $request->date])->selectRaw('net_sales_value, product_item')->get();
                }


                $total_sales_values = collect($total_sales_values)->groupBy('product_item');
                $total_sales_values = $total_sales_values->mapWithKeys(function ($item,$key) {
                    return [$key=> $item->sum('net_sales_value')];
                })->toArray();
                 // group by query
                $report_data[$customer_nature][$type] = $total_sales_values;
                $report_data[$customer_nature]['Total '.$type] = array_sum($total_sales_values);

                $report_sales_values[$customer_nature]= array_sum($total_sales_values);
                $report_totals_counts[$customer_nature]= ($nature_data['count']??0);

            }


            $report_totals_sales_values =  $this->finalTotal(array_column($report_data,$type));






        // sales_values
        $items_totals_sales_values =$report_sales_values;
        // $main_type_items_totals

        arsort($report_totals_sales_values);



            if(count($report_totals_sales_values) > 50){
                $report_view_data = collect($report_totals_sales_values);
                $top_20 = $report_view_data->take(50);
                $report_view_data = $top_20->toArray();
                // $report_totals_sales_values = $report_view_data;

                foreach ($report_view_data as $name_of_main_item => $data) {
                    $result[$name_of_main_item] =$report_totals_sales_values[$name_of_main_item];
                    unset($report_totals_sales_values[$name_of_main_item]);
                }
                $result['Others '.count($report_totals_sales_values)] = $report_totals_sales_values;

                $report_totals_sales_values['Others '.count($report_totals_sales_values)]  = array_sum(($result['Others '.count($report_totals_sales_values)]??[]));
                $report_totals_sales_values = $result;
            }

        // counts
        $items_totals_counts = $this->finalTotal([$report_counts]);
        // $main_type_items_totals

        arsort($report_totals_counts);


        if(count($report_totals_counts) > 50){
            $report_view_data = collect($report_totals_counts);
            $top_20 = $report_view_data->take(50);
            $report_view_data = $top_20->toArray();
            $report_totals_counts = $report_view_data;

            foreach ($report_view_data as $name_of_main_item => $data) {
                $result[$name_of_main_item] =$report_counts[$name_of_main_item];
                unset($report_counts[$name_of_main_item]);
            }
            $result['Others '.count($report_counts)] =  $this->finalTotal([$report_counts]);

            $report_totals_counts['Others '.count($report_counts)]  = array_sum(($result['Others '.count($report_counts)]??[]));
            $report_counts = $result;
        }
        $main_type_items = $sales_gathering->groupBy($type);
        $last_date = SalesGathering::company()->latest('date')->first()->date;
        $last_date = date('d-M-Y', strtotime($last_date));
        $all_items = array_unique($all_items);

        return view('client_view.reports.sales_gathering_analysis.customer_nature.two_dimensional_report', compact('company', 'view_name',
                                                                                                                    'type',
                                                                                                                    'all_items', 'main_type_items',
                                                                                                                    'report_counts','items_totals_counts',
                                                                                                                    'report_totals_counts',
                                                                                                                    'report_sales_values', 'last_date',
                                                                                                                    'dates', 'items_totals_sales_values',
                                                                                                                    'report_totals_sales_values'));
    }












    // public function twoDimensionalResult(Request $request, Company $company)
    // {

    //     $report_sales_values = [];
    //     $report_counts = [];
    //     $type = $request->type;

    //     $view_name = $request->view_name;
    //     $last_date = null;
    //     $first_date_of_current_year = date('Y-01-01', strtotime($request->date));
    //     $dates = [
    //         'start_date' => date('d-M-Y', strtotime($first_date_of_current_year)),
    //         'end_date' => date('d-M-Y', strtotime($request->date))
    //     ];
    //     $all_items = [];

    //     $all_data = SalesGathering::company()->whereNotNull($type)->whereDate('date', '<=', $request->date)->selectRaw('DATE_FORMAT(date,"%Y") as year,net_sales_value,customer_name,date,'.$type)->get();
    //     $main_type_items = collect($all_data)->groupBy($type);

    //     // Years
    //     $current_year = date('Y', strtotime($request->date));
    //     $previous_year_one = $current_year - 1;
    //     $previous_year_two = $current_year - 2;


    //     $previous_date_one =  $previous_year_one.'-01-01';
    //     $previous_date_two =  $previous_year_two.'-01-01';
    //     ///////////////////////////////////////////////
    //     $all_items = [
    //         'New',
    //         'Repeating',
    //         'Active',
    //         'Stop',
    //         'Dead',
    //         'Stop / Reactivated',
    //         'Dead / Reactivated',
    //         'Stop / Repeating'
    //     ];
    //     $report_totals_sales_values = [];
    //     $report_counts_totals = [];
    //     foreach ($main_type_items as  $main_type_item_name => $sales_gathering_per_main_item) {

    //         // $sales_gathering = SalesGathering::company()->whereNotNull($type)->where($type,$main_type_item_name)->whereDate('date', '<=', $request->date)->selectRaw('DATE_FORMAT(date,"%Y") as year,net_sales_value,customer_name,date');

    //         // $all_data  = $sales_gathering->get();
    //         $years = $sales_gathering_per_main_item->pluck('year')->toArray();
    //         $years = array_unique($years);

    //         $customers_years = collect($sales_gathering_per_main_item)
    //             // ->groupBy(['customer_name', 'year']) // group by query
    //             // ->get()
    //             ->mapToGroups(function ($item, $key) {
    //                 return [$item['customer_name'] => $item['year']];
    //             });

    //         $report_data[$main_type_item_name] = [
    //             'New' => [],
    //             'Repeating' => [],
    //             'Active' => [],
    //             'Stop' => [],
    //             'Dead' => [],
    //             'Stop / Reactivated' => [],
    //             'Dead / Reactivated' => [],
    //             'Stop / Repeating' => []
    //         ];
    //         // Customer Natures
    //         foreach ($customers_years as  $customer_name => $years_query) {
    //             $customer_years = $years_query->toArray();
    //             count($customer_years)==0 ?: array_unique($customer_years);
    //             foreach ($years as  $year) {
    //                 if (false !== $found = array_search($year, $customer_years)) {
    //                     $customers_data_years[$customer_name][$year] = 1;
    //                 } else {
    //                     $customers_data_years[$customer_name][$year] = 0;
    //                 }
    //             }


    //             // New
    //             if ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && array_sum(($customers_data_years[$customer_name] ?? [])) === 1) {
    //                 $report_data[$main_type_item_name]['New']['customers'][] = $customer_name;
    //                 $report_data[$main_type_item_name]['New']['count'] = ($report_data[$main_type_item_name]['New']['count'] ?? 0) + 1;
    //             }
    //             // Repeating
    //             elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && ((($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && array_sum(($customers_data_years[$customer_name] ?? [])) === 2)) {
    //                 $report_data[$main_type_item_name]['Repeating']['customers'][] = $customer_name;
    //                 $report_data[$main_type_item_name]['Repeating']['count'] = ($report_data[$main_type_item_name]['Repeating']['count'] ?? 0) + 1;
    //             }
    //             // Active
    //             elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
    //                 $report_data[$main_type_item_name]['Active']['customers'][] = $customer_name;
    //                 $report_data[$main_type_item_name]['Active']['count'] = ($report_data[$main_type_item_name]['Active']['count'] ?? 0) + 1;
    //             }
    //             // Dead
    //             elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {

    //                 $report_data[$main_type_item_name]['Dead']['customers'][] = $customer_name;
    //                 $report_data[$main_type_item_name]['Dead']['count'] = ($report_data[$main_type_item_name]['Dead']['count'] ?? 0) + 1;
    //             }
    //             // Stop
    //             elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1)) {
    //                 $report_data[$main_type_item_name]['Stop']['customers'][] = $customer_name;
    //                 $report_data[$main_type_item_name]['Stop']['count'] = ($report_data[$main_type_item_name]['Stop']['count'] ?? 0) + 1;
    //             }
    //             // 'Stop / Reactivated
    //             elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 1)) {
    //                 $report_data[$main_type_item_name]['Stop / Reactivated']['customers'][] = $customer_name;
    //                 $report_data[$main_type_item_name]['Stop / Reactivated']['count'] = ($report_data[$main_type_item_name]['Stop / Reactivated']['count'] ?? 0) + 1;
    //             }
    //             // Dead / Reactivated
    //             elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 0) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 0)) {
    //                 $report_data[$main_type_item_name]['Dead / Reactivated']['customers'][] = $customer_name;
    //                 $report_data[$main_type_item_name]['Dead / Reactivated']['count'] = ($report_data[$main_type_item_name]['Dead / Reactivated']['count'] ?? 0) + 1;
    //             }
    //             // Stop / Repeating
    //             elseif ((($customers_data_years[$customer_name][$current_year] ?? 0) == 1) && ((($customers_data_years[$customer_name][$previous_year_one] ?? 0) == 1) && (($customers_data_years[$customer_name][$previous_year_two] ?? 0) == 0))) {
    //                 $report_data[$main_type_item_name]['Stop / Repeating']['customers'][] = $customer_name;
    //                 $report_data[$main_type_item_name]['Stop / Repeating']['count'] = ($report_data[$main_type_item_name]['Stop / Repeating']['count'] ?? 0) + 1;
    //             }

    //             ksort($customers_data_years[$customer_name]);
    //         }

    //         // Calculating Total Sales Values
    //         foreach ($report_data[$main_type_item_name] as $customer_nature => $nature_data) {

    //             $customers = $nature_data['customers'] ?? [];
    //             if($customer_nature == 'Stop'){
    //                 $total_sales_values = SalesGathering::company()->whereNotNull($type)->where($type,$main_type_item_name)->whereBetween('date', [$previous_date_one, $request->date])->whereIn('customer_name', $customers)->sum('net_sales_value');

    //             }elseif ($customer_nature == 'Dead') {
    //                 $total_sales_values = SalesGathering::company()->whereNotNull($type)->where($type,$main_type_item_name)->whereBetween('date', [$previous_date_two, $request->date])->whereIn('customer_name', $customers)->sum('net_sales_value');

    //             }else{

    //                 $total_sales_values = SalesGathering::company()->whereNotNull($type)->where($type,$main_type_item_name)->whereBetween('date', [$first_date_of_current_year, $request->date])->whereIn('customer_name', $customers)->sum('net_sales_value');
    //             }

    //             $report_sales_values[$main_type_item_name][$customer_nature] = $total_sales_values;
    //             $report_counts[$main_type_item_name][$customer_nature] = ($nature_data['count']??0);
    //         }


    //         $report_totals_sales_values[$main_type_item_name] =  array_sum($report_sales_values[$main_type_item_name] ?? []);
    //         $report_totals_counts[$main_type_item_name] =  array_sum($report_counts[$main_type_item_name] ?? []);

    //     }

    //     dd($report_sales_values);

    //     // sales_values
    //     $items_totals_sales_values = $this->finalTotal([$report_sales_values]);
    //     // $main_type_items_totals
    //     dd($items_totals_sales_values);

    //         arsort($report_totals_sales_values);


    //         if(count($report_totals_sales_values) > 50){
    //             $report_view_data = collect($report_totals_sales_values);
    //             $top_20 = $report_view_data->take(50);
    //             $report_view_data = $top_20->toArray();
    //             $report_totals_sales_values = $report_view_data;
    //             foreach ($report_view_data as $name_of_main_item => $data) {
    //                 $result[$name_of_main_item] =$report_sales_values[$name_of_main_item];
    //                 unset($report_sales_values[$name_of_main_item]);
    //             }
    //             $result['Others '.count($report_sales_values)] =  $this->finalTotal([$report_sales_values]);

    //             $report_totals_sales_values['Others '.count($report_sales_values)]  = array_sum(($result['Others '.count($report_sales_values)]??[]));
    //             $report_sales_values = $result;
    //         }

    //     // counts
    //     $items_totals_counts = $this->finalTotal([$report_counts]);
    //     // $main_type_items_totals

    //     arsort($report_totals_counts);


    //     if(count($report_totals_counts) > 50){
    //         $report_view_data = collect($report_totals_counts);
    //         $top_20 = $report_view_data->take(50);
    //         $report_view_data = $top_20->toArray();
    //         $report_totals_counts = $report_view_data;
    //         foreach ($report_view_data as $name_of_main_item => $data) {
    //             $result[$name_of_main_item] =$report_counts[$name_of_main_item];
    //             unset($report_counts[$name_of_main_item]);
    //         }
    //         $result['Others '.count($report_counts)] =  $this->finalTotal([$report_counts]);

    //         $report_totals_counts['Others '.count($report_counts)]  = array_sum(($result['Others '.count($report_counts)]??[]));
    //         $report_counts = $result;
    //     }

    //     $last_date = SalesGathering::company()->latest('date')->first()->date;
    //     $last_date = date('d-M-Y', strtotime($last_date));
    //     $all_items = array_unique($all_items);

    //     return view('client_view.reports.sales_gathering_analysis.customer_nature.two_dimensional_report', compact('company', 'view_name',
    //                                                                                                                 'type',
    //                                                                                                                 'all_items', 'main_type_items',
    //                                                                                                                 'report_counts','items_totals_counts',
    //                                                                                                                 'report_totals_counts',
    //                                                                                                                 'report_sales_values', 'last_date',
    //                                                                                                                 'dates', 'items_totals_sales_values',
    //                                                                                                                 'report_totals_sales_values'));
    // }
}
