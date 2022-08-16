<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Analysis\SalesGathering\ZoneAgainstAnalysisReport;
use App\Models\AllocationSetting;
use App\Models\Company;
use App\Models\SalesForecast;
use App\Models\SecondAllocationSetting;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    public function forecastReport(Request $request, Company $company)
    {
        // Forecast
        $sales_forecast = SalesForecast::company()->first();
        // Company Sales Target
        $detailed_company_sales_target = (new SalesForecastReport)->productsAllocations($company, $request, 'detailed_company_sales_target');


        // Calculation of Total Company Sales Target In Quarters
        $total = $total = array_sum($detailed_company_sales_target['total']);
        $quarters = $this->companySalesTargetsQuarters($sales_forecast, $detailed_company_sales_target['total'], $total);
        //  Total Company Sales Target Data For Chart
        $chart_data = $this->totalCompanySalesTargetsChartData($detailed_company_sales_target['total'], $total);
        $new_products_targets_data['value'] = array_sum($detailed_company_sales_target['new']);
        $existing_products_targets_data['value'] = array_sum($detailed_company_sales_target['existing']);
        $new_products_targets_data['percentage'] = $total == 0 ? 0 : (($new_products_targets_data['value'] / $total) * 100);
        $existing_products_targets_data['percentage'] = $total == 0 ? 0 : (($existing_products_targets_data['value'] / $total) * 100);


        return view('client_view.forecast_summary_reports.dashboard', compact(
            'company',
            'quarters',
            'chart_data',
            'new_products_targets_data',
            'existing_products_targets_data'
        ));
    }

    public function companySalesTargetsQuarters($sales_forecast, $total_company_sales_target)
    {
        $quarters = [
            'Quarter One' => 0,
            'Quarter Two' => 0,
            'Quarter Three' => 0,
            'Quarter Four' => 0,
        ];
        $counter = 1;
        $total_quarter = 0;
        foreach ($total_company_sales_target as $date => $value) {
            $total_quarter += $value;
            if ($counter == 3) {
                $quarters['Quarter One'] = ['value' => $total_quarter, 'color_class' => 'warning'];
                $total_quarter = 0;
            } elseif ($counter == 6) {
                $quarters['Quarter Two'] = ['value' => $total_quarter, 'color_class' => 'danger'];
                $total_quarter = 0;
            } elseif ($counter == 9) {
                $quarters['Quarter Three'] = ['value' => $total_quarter, 'color_class' => 'success'];
                $total_quarter = 0;
            } elseif ($counter == 12) {
                $quarters['Quarter Four'] = ['value' => $total_quarter, 'color_class' => 'dark'];
                $total_quarter = 0;
            }

            $counter++;
        }
        $quarters['Total'] = ['value' => array_sum(array_column($quarters, 'value')), 'color_class' => 'brand'];

        return $quarters;
    }

    public function totalCompanySalesTargetsChartData($total_company_sales_target, $total)
    {

        $gr = (new ZoneAgainstAnalysisReport)->growthRate($total_company_sales_target);

        $multi_chart_data = [];
        $accumulated_chart_data = [];
        $month_sales_percentage = [];
        $accumulated_data = [];
        $accumulated_value = 0;
        foreach ($total_company_sales_target as $date => $value) {
            $formated_date = date('d-M-Y', strtotime(('01-' . $date)));

            $month_sales = $total == 0 ?  0 : (($value / $total) * 100);
            $month_sales_percentage[$formated_date] = $month_sales;
            $multi_chart_data[] = [
                'date' => $formated_date,
                'Sales Values' => number_format(($value ?? 0), 0),
                'Month Sales %' => number_format(($month_sales ?? 0), 0),
                'Growth Rate %' => number_format(($gr[$date] ?? 0), 1),
            ];

            // Accumulated Data
            $accumulated_value += $value;
            $accumulated_chart_data[] = [
                'date' => $formated_date,
                'price' => number_format($accumulated_value, 0),
            ];
            $accumulated_data[$formated_date] =  $accumulated_value;
        }
        return ['accumulated_chart' => $accumulated_chart_data, 'multi_chart' => $multi_chart_data, 'gr' =>  $gr, 'month_sales_percentage' => $month_sales_percentage, 'sales' => $total_company_sales_target, 'accumulated_data' => $accumulated_data];
    }

    public function breakdownForecastReport(Request $request, Company $company)
    {
        // First Allocation Setting
        $first_allocation_setting_base = AllocationSetting::company()->first() ;
        // Second Allocation Setting
        $second_allocation_setting_base = SecondAllocationSetting::company()->first();
        // Company Sales Target
        $company_sales_targets = (new SalesForecastReport)->productsAllocations($company, $request, 'total_sales_target');
        // dd($company_sales_targets);
        // dd($company_sales_targets);
        $reports_data['product_sales_target'] = $this->breakdownData($company_sales_targets);
        $types['product_sales_target'] = 'brand';
        $top_data['product_sales_target'] = $reports_data['product_sales_target'][0] ?? '-';
        // First Allocation sales targets
        $first_allocation_total_sales_targets = [];
        if (isset($first_allocation_setting_base)) {
            $first_allocation_total_sales_targets = (new AllocationsReport)->NewProductsSeasonality($request, $company, 'array');
            $base = $first_allocation_setting_base->allocation_base;
            arsort($first_allocation_total_sales_targets);
            // dd($first_allocation_total_sales_targets);
            $name = $base.'_sales_targets';
            // dd($first_allocation_total_sales_targets);
            $reports_data[$name] = $this->breakdownData($first_allocation_total_sales_targets);
// dd($reports_data[$name]);
            $types[$name] = 'warning';
            // dd($reports_data[$name]);
            $top_data[$name] = $reports_data[$name][0] ?? '-';
        }
        // Second Allocation sales targets
        $second_allocation_total_sales_targets = [];
        if (isset($second_allocation_setting_base)) {
            $second_allocation_total_sales_targets = (new SecondAllocationsReport)->NewProductsSeasonality($request, $company, 'array');
            // dd($second_allocation_total_sales_targets);
            $base = $second_allocation_setting_base->allocation_base;
            arsort($second_allocation_total_sales_targets);
            // dd($second_allocation_total_sales_targets);
            // dd($second_allocation_total_sales_targets);
            $name = $base.'_sales_targets';
            $reports_data[$name] = $this->breakdownData($second_allocation_total_sales_targets);
            
            $types[$name] = 'danger';
            
            $top_data[$name] = $reports_data[$name][0] ?? '-';
        
        }
        // dd($reports_data);
        return view('client_view.forecast_summary_reports.breakdown_dashboard', compact(
                'company',
            'reports_data',
            'types',
            'top_data',
        ));
    }

    public function breakdownData($data)
    {
        //  if($x != 6)
        // {
        // dd($data);
            
        // }
    //  (sort($data));
    //  dd($data);
        $result = collect($data)->flatMap(function($values,$name){
            return [[
                "item" => $name ,
                "Sales Value" => array_sum($values),
            ]];
        })->toArray();
        
       
        return $result;
    }

    public function collectionForecastReport(Request $request, Company $company)
    {
        $collection_data = (new CollectionController)->collectionReport($request,$company,'array');
        $forecast_year = $collection_data['forecast_year'];
        $monthly_dates =$collection_data['monthly_dates'] ;
        $collection = $collection_data['collection'] ;
        $collection_settings = $collection_data['collection_settings'] ;

        return view('client_view.forecast_summary_reports.collection_dashboard', compact(
            'company',
            'forecast_year',
            'monthly_dates',
            'collection',
            'collection_settings'
        ));
    }
}
