<?php

use App\Http\Controllers\ExportTable;
use App\Models\AllocationSetting;
use App\Models\Company;
use App\Models\CustomizedFieldsExportation;
use App\Models\ExistingProductAllocationBase;
use App\Models\ModifiedSeasonality;
use App\Models\ModifiedTarget;
use App\Models\NewProductAllocationBase;
use App\Models\ProductSeasonality;
use App\Models\SecondAllocationSetting;
use App\Models\SecondExistingProductAllocationBase;
use App\Models\SecondNewProductAllocationBase;
use App\Traits\Intervals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
const MAX_RANKING = 5 ;
const Customers_Against_Products_Trend_Analysis = 'Customers Against Products Trend Analysis' ;
const Customers_Against_Categories_Trend_Analysis = 'Customers Against Categories Trend Analysis';
const Customers_Against_Products_ITEMS_Trend_Analysis = 'Customers Against Products Items Trend Analysis';
const INVOICES = 'Invoices';

function spaceAfterCapitalLetters($string)
{
    return preg_replace('/(?<!\ )[A-Z]/', ' $0', $string); ;
}
function getYearsFromInterval($start , $end){
    return [
        'start_year'=>explode('-' , $start)[0],
        'end_year'=>explode('-' , $end)[0],
    ];
}

function array_unique_value(array $array , string $key)
{
 
    $uniqueItems = [];
    // dd($array);
    foreach($array as $arr)
    {
       foreach($arr as $ar)
       {
            $uniqueItems[$ar[$key]] = $ar ;
       }
    }
    return $uniqueItems ;
    
    
}

function getPeriods($interval)
{
  
    if($interval == 'monthly')
    {
       return  [
            1=>[1] ,
            2=>[2] ,
            3=>[3] ,
            4=>[4] ,
            5=>[5] ,
            6=>[6] ,
            7=>[7] ,
            8=>[8] ,
            9=>[9] ,
            10=>[10] ,
            11=>[11] ,
            12=>[12] ,
        ];
    }
    if($interval == 'quarterly')
    {
        
    return [
        3=>[1,2,3] ,6=>[4,5,6] , 9=>[7,8,9]  ,12 => [10,11,12]
    ];
    }
    if($interval == 'semi-annually')
    {
          return [
        6=>[1,2,3,4,5,6] ,12=>[7,8,9 , 10,11,12] 
               ];
    }

     if($interval == 'annually')
    {
          return [
        12=>[1,2,3,4,5,6,7,8,9 , 10,11,12]];
    }
    
}
function getLongestArray($array)
{
    $result = [];
    foreach($array as $arr)
    {
        if(count($arr) > count($result))
        {
            $result = $arr ;
        }
    }
    
    return $result;
}
function arrayCountAllLongest(array $array)
{
    $longestArray = getLongestArray($array);
    
    $counter = 0 ;

    foreach($longestArray as $arr )
    {
        $counter += count($arr);
    }

    return $counter ;
}
function flatten(array $array) {
    $return = array();
    array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
    return $return;
}
function countTotalForBranch(array $array):int {
    $total = 0 ; 
    foreach($array as $arr){
        $total += count($arr) ;  
    }

    return $total ;
}

function countSumForAllRank(array $array , $i ):array 
{
    $total = [
        'total'=> 0 ,
        'values'=> 0 , 
        'percentages'=>0 
    ] ;
    foreach($array as $arr){
        if(isset($arr[$i])){
        $total['total'] += count($arr[$i]) ;  
        $total['values'] += array_sum(flatten($arr[$i]));
        $total['percentages'] += 0     ;
        }
    }
    
    return $total  ; 
}
function camelize($input, $separator = '_')
{
    return str_replace($separator, '', ucwords($input, $separator));
}

if (! function_exists('lang')) {
    function lang()
    {
        return  app()->getLocale();
    }
}

if (! function_exists('company')) {
    function company()
    {
        if (Auth::check()) {
            $company =   Auth::user()->companies()->where('type','single')->first();
 
            $company = $company ?? Auth::user()->companies()->where('type','group')->first()->subCompanies()->first();

            return  $company;
        }
    }
}
if (! function_exists('company')) {
    function setCompany($company_id)
    {
        if (Auth::check()) {
            $company = Company::find($company_id)  ;
            return  $company;
        }
    }
}
if (! function_exists('exportableFields')) {
    function exportableFields($company_id,$model)
    {
        if (Auth::check()) {
            $fields = CustomizedFieldsExportation::where('model_name',$model)->where('company_id', $company_id)->first() ;
            return  $fields;
        }
    }
}

if (! function_exists('strip_strings')) {
    function strip_strings(string $sentence)
    {
        $removeHtml =  strip_tags($sentence);

        return str_replace(['&amp;', '&nbsp;', 'nbsp;'],  '', $removeHtml);
    }
}

if (! function_exists('dateFormating')) {
    function dateFormating($date,$formate="d-m-Y")
    {
        return date($formate,strtotime($date));
    }
}
if (! function_exists('routeName')) {
    function routeName($route)
    {
        $route_array = explode('.',$route);
        $route = $route_array[0];
        return $route;
    }
}
function getOrderMaxForBranch(string $branchName  ,  array $data)
{
    
    $arr_data = $data ;

    uasort ($arr_data, function($a, $b){
        return $a < $b ;
    });  
    $uniques = array_unique($arr_data) ; 
    for($i = 0 ; $i< count($uniques) ; $i++){
        $key = array_values($uniques)[$i] ;
        $new["$key"] = $i+1 ;
    } ; 

    $value = $arr_data[$branchName] ;

    return $new[strval($value)] ;
    
}
function array_sort_multi_levels(&$array)
{
    uasort($array , function($a  , $b){
        $sumA = 0; 
        foreach($a as $year=>$data)
        {
            foreach($data as $quarter => $data)
            {
            $sumA += $data['invoice_number'];
                
            }
        }

                $sumB = 0; 
        foreach($b as $year=>$data)
        {
              foreach($data as $quarter => $data){
            $sumB += $data['invoice_number'];
                  
              }
        }


         if ($sumA == $sumB) {
            return 0;
        }
        return ($sumA > $sumB) ? -1 : 1;
        

        
    });
}
// function $productName
function getMaxNthFromArray()
{
    $args = func_get_args();
    $max = 0;
    foreach ($args as $arg) {
        if ($arg > $max) {
            $max = $arg;
        }
    }
    return $max;
}
// caching
// miscelinuous
function getCompanyTagName(Company $company)
{
    return 'company_'.$company->id ; 
}
function getExportableFields($companyId = null):array 
{
        
        $company  = Company::find($companyId ?: Request()->segment(2));
        if($company){
            return   (new ExportTable)->customizedTableField($company, 'SalesGathering', 'selected_fields');
        }
        return [];
}
function canViewCustomersDashboard(array $exportables)
{
    return in_array('Customer Name',$exportables) || in_array('Customer Code',$exportables);
}
// 1- customers dashboard
function getNewCustomersCacheNameForCompanyInYear(Company $companyId , string $year ){
    return 'new_customers_for_company_'.$companyId->id .'_for_year_'.$year ;
}

function getNewCustomersCacheNameForCompanyInYearForType(Company $companyId , string $year , $type ){
    return 'new_customers_for_company_'.$companyId->id .'_for_year_'.$year.'for_type_' . $type ;
}

function getRepeatingCustomersCacheNameForCompanyInYear(Company $companyId , string $year ){
    return 'repeating_customers_for_company_'.$companyId->id .'_for_year_'.$year ;
}

function getRepeatingCustomersCacheNameForCompanyInYearForType(Company $companyId , string $year , $type){
    return 'repeating_customers_for_company_'.$companyId->id .'_for_year_'.$year.'for_type_'  . $type;
}

 function getActiveCustomersCacheNameForCompanyInYear(Company $companyId , string $year ){
    return 'active_customers_for_company_'.$companyId->id .'_for_year_'.$year ;
}  

 function getActiveCustomersCacheNameForCompanyInYearForType(Company $companyId , string $year , $type){
    return 'active_customers_for_company_'.$companyId->id .'_for_year_'.$year.'for_type_'  . $type;
}  



 function getStopReactivatedCustomersCacheNameForCompanyInYear(Company $companyId , string $year ){
    return 'stop_reactivated_customers_for_company_'.$companyId->id .'_for_year_'.$year ;
}   
function getStopReactivatedCustomersCacheNameForCompanyInYearForType(Company $companyId , string $year , $type){
    return 'stop_reactivated_customers_for_company_'.$companyId->id .'_for_year_'.$year.'for_type_'  . $type;
}
function getDeadReactivatedCustomersCacheNameForCompanyInYear(Company $companyId , string $year ){
    return 'dead_reactivated_customers_for_company_'.$companyId->id .'_for_year_'.$year ;
}   

 function getDeadReactiveCacheNameForCompanyInYearForType(Company $companyId , string $year , $type){
    return 'dead_reactivated_customers_for_company_'.$companyId->id .'_for_year_'.$year.'for_type_'  . $type;
}  
// getStopRepeatingCacheNameForCompanyInYearForType
// getDeadReactiveCacheNameForCompanyInYearForType
function getStopRepeatingCustomersCacheNameForCompanyInYear(Company $companyId , string $year ){
    return 'stop_repeating_reactivated_customers_for_company_'.$companyId->id .'for_year_'.$year ;
}   
function getStopRepeatingCustomersCacheNameForCompanyInYearForType(Company $companyId , string $year , $type){
    return 'stop_repeating_reactivated_customers_for_company_'.$companyId->id .'_for_year_'.$year.'for_type_'.$type ;
}   
function getStopCustomersCacheNameForCompanyInYear(Company $companyId , string $year ){
    return 'stop_customers_for_company_'.$companyId->id .'_for_year_'.$year ;
}   

function getStopCustomersCacheNameForCompanyInYearForType(Company $companyId , string $year , $type ){
    return 'stop_customers_for_company_'.$companyId->id .'_for_year_'.$year. 'for_type_'.$type ;
}   


function getDeadCustomersCacheNameForCompanyInYear(Company $companyId , string $year ){
    return 'dead_customers_for_company_'.$companyId->id .'_for_year_'.$year ;
}   
function getDeadCustomersCacheNameForCompanyInYearForType(Company $companyId , string $year , $type ){
    return 'dead_customers_for_company_'.$companyId->id .'_for_year_'.$year.'for_type_'.$type ;
}   

function getTotalCustomersCacheNameForCompanyInYear(Company $companyId , string $year){
    return 'total_customers_dashboard_for_company_'.$companyId->id .'_for_year_'.$year ;
}

// intervalYearsForCompany (max date and min date in database for sales gatering)


function getIntervalYearsFormCompanyCacheNameForCompany(Company $companyId ){
    return 'interval_years_for_company_'.$companyId->id  ;
}
function formatChartNameForDom($chartName){
    return str_replace(["/" ,' ' ] , '-' , $chartName) ;
}





function sortReportForTotals(&$report_data){
    (uasort($report_data,  function($a,$b) use(&$report_data){
    if(isset($b['Total']) && isset($a['Total'])){
   
    
        $a = array_sum($a['Total']);
        $b = array_sum($b['Total']);

        if ($a == $b) {
            return 0;
        }
        return ($a > $b) ? -1 : 1;
                                        }

                                         if(!is_multi_array($a) &&  is_multi_array($b) )
    {
        return 1 ;
    }

    if( is_multi_array($a) &&  ! is_multi_array($b) )
    {
        return -1 ;
    }
    
    if(isset($a['Total']) && !isset($b['Total']))
    {
        return -1 ; 
    }

      if(! isset($a['Total']) && isset($b['Total']))
    {
        return 1 ; 
    }
    
   
    
        return -1;
}

)
    );
   


}

function sortSubItems(&$sales_channel_channels_data)
{

    (uasort($sales_channel_channels_data,  function($a,$b) {

if(isset($a['Sales Values'])&&isset($b['Sales Values'])){
    
$a = array_sum($a['Sales Values']);

$b = array_sum($b['Sales Values']);


     if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
    }
    return ;
}

)
    );
}
function sortTwoDimensionalArr(array &$arr)
{
    uasort($arr , function($a , $b){
        if($a == $b)
        {
            return 0 ; 
        }
      return ($a > $b) ? -1 : 1;
    });
}

function sortTwoDimensionalBaseOnKey(array &$arr , $key)
{
    uasort($arr , function($a , $b) use($key){
        if($a[$key] == $b[$key])
        {
            return 0 ; 
        }
      return ($a[$key] > $b[$key]) ? -1 : 1;
    });
}
function sortTwoDimensionalExcept(array &$arr  , array $exceptKeys)
{
    uksort($arr , function($key1 , $key2) use($exceptKeys , $arr){
        if( ! in_array($key1 , $exceptKeys) && ! in_array($key2 , $exceptKeys)){
            if($arr[$key1] == $arr[$key2]){
                return 0; 
            }
            return $arr[$key1] > $arr[$key2] ? -1 : 1 ;
        }
        elseif(! in_array($key1 , $exceptKeys) && in_array($key2 , $exceptKeys) )
        {
            return -1 ;
        }
        elseif(in_array($key1 , $exceptKeys) && ! in_array($key2 , $exceptKeys) ){
              return -1 ;
        }
        else{
            return -1 ;
        }
    });
}
function getTypeFor($type,$companyId,$formatted=false){
   if($formatted)
   {
      return  DB::table('sales_gathering')->where('company_id', $companyId)->orderBy($type)->distinct()->select($type)->get()->pluck($type,$type)->toArray(); ;
      
   }
   else{
       $data = DB::table('sales_gathering')->where('company_id', $companyId)->orderBy($type)->distinct()->select($type)->get()->pluck($type)->toArray();
       $data = array_filter($data , function($item){
       
       return $item  ;
       });
       return $data ; 
       
       
   }
//    dd();
    //   return  DB::table('sales_gathering')->where('company_id', $companyId)->distinct()->select($type)->get()->pluck($type)->toArray(); ;
}
function getNumberOfProductsItems($companyId)
{
    return ProductSeasonality::where('company_id',$companyId)->count() ;
}
function canShowNewItemsProducts($companyId)
{
    return  getNumberOfProductsItems($companyId) ; 
}
function getProductsItems($companyId)
{
    return ProductSeasonality::where('company_id',$companyId)->get();
}
function deleteProductItemsForForecast($companyId)
{
     ProductSeasonality::where('company_id',$companyId)->delete() ;
}
function deleteNewProductAllocationBaseForForecast($companyId)
{
    NewProductAllocationBase::where('company_id',$companyId)->delete();
    SecondNewProductAllocationBase::where('company_id',$companyId)->delete();
    AllocationSetting::where('company_id',$companyId)->delete();
    SecondAllocationSetting::where('company_id',$companyId)->delete();
    ExistingProductAllocationBase::where('company_id',$companyId)->delete();
    SecondExistingProductAllocationBase::where('company_id',$companyId)->delete();
    ModifiedSeasonality::where('company_id',$companyId)->delete();
    ModifiedTarget::where('company_id',$companyId)->delete();
    
}

function getLargestArrayDates(array $array )
{
    if (count($array) == count($array, COUNT_RECURSIVE)) 
{
    $dates = [];
    foreach($array as $date=>$val)
    {
        $dates[] = Carbon::make($date)->format('d-M-Y');
    }
    return $dates ;
}
else
{
    $largestArray = getLargestArray($array);
    return getLargestArrayDates($largestArray);
    
}
}
function getLargestArray($array)
{
    $largestArr = [];
    foreach($array as $arr){
        if(count($arr) > count($largestArr))
        {
            $largestArr = $arr ; 
        }
    
 
    }
    return $largestArr ;
}
function getDateBetween(array $dates)
{
    $smallest = null;
    $largest = null;
    if(count($dates))
    {
  
        foreach($dates as $type=>$date){
            if(is_array($date))
            {
                  foreach($date as $d=>$k)
            {
                $d = Carbon::make($d);
                if(is_null($smallest))
                {
                    $smallest = $d ; 
                }
                else{
                if(!$d->greaterThan($smallest) )
                {
                    $d = $smallest ;
                }
            }

            if(is_null($largest))
                {
                    $largest = $d ; 
                }
                else{
                if($d->greaterThan($largest) )
                {
                    $largest = $d  ;
                }
            }
        }
            }
            else{
                // dd($dates);
                // dd(array_sum($dates));
                $newDates = array_keys($dates) ;
                $smallest = Carbon::make($newDates[0]) ?? null ;
                $largest = Carbon::make($newDates[count($newDates) - 1 ]) ?? null ; 
            }
          
    }



$period = new DatePeriod(
     new DateTime($smallest->format('Y-m-d')),
     new DateInterval('P1M'),
     new DateTime($largest->format('Y-m-d'))
);

$per = [];
    foreach($period as $p)
    {
        $per[] = $p->format('d-M-Y');
    }

    return $per ; 

}


return [];

}


function generateIdForExcelRow( int $companyId)
{
    return uniqid('company_'.$companyId) . Str::random(9) .$companyId . uniqid() ;
}

function getTotalUploadCacheKey($company_id ,$jobId )
{
    return 'total_uploaded_for_company_'. $company_id  .'for_job_' .$jobId ; 
}

function getShowCompletedTestMessageCacheKey($companyId)
{
    return 'show_complete_test_phase_' . $companyId  ; 
}




function is_multi_array( $arr ) {
    rsort( $arr );
    return isset( $arr[0] ) && is_array( $arr[0] );
}

function maxOptionsForOneSelector():int
{
    // return 2 ; 
    return 12 ; 
}

function isCustomerExceptionalCase($type , $name_of_selector_label)
{
    $conditionOne = ($type == 'category' && ($name_of_selector_label == 'Customers Against Categories' || $name_of_selector_label == 'Categories' ) );

return $conditionOne ;    
}

function isCustomerExceptionalForProducts($type , $name_of_selector_label)
{
    
    $conditionTwo = ($type == 'product_or_service' && ($name_of_selector_label == 'Customers Against Products' ||  $name_of_selector_label == 'Products'));

return $conditionTwo ;    
}

function isCustomerExceptionalForProductsItems($type , $name_of_selector_label)
{
    
    $conditionTwo = ($type == 'product_item' && ($name_of_selector_label == 'Customers Against Products Items' ||  $name_of_selector_label == 'Product Items'));

return $conditionTwo ;    
}

function orderTotalsForRanking(array &$array)
{
     (uasort($array,  function($a,$b) {

if(isset($a['total'])&&isset($b['total'])){
    
$a = ($a['total']);

$b = ($b['total']);


     if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
    }
    return ;
}

)
    );

    
    // $data[$branchName][$rankNumber] ?? []
;
}


// function hasProductsItems($company)
// {
        // $fields = (new ExportTable)->customizedTableField($company, 'SalesGathering', 'selected_fields');

        // return (false !== $found = array_search('Product Item', $fields));
// }
function failAllocationMessage($allocation_type)
{
    return __('Please Add New').' ' . capitializeType($allocation_type);
}
function hasProductsItems($company)
{
    
    $productItems = DB::select(DB::raw('select count(*) as has_product_item from sales_gathering where company_id = '. $company->id .' and product_item is not null'));
    return $productItems[0]->has_product_item ?? 0  ;
}

function count_array_values(array $array)
{
    $counter = 0 ; 
    foreach($array as $arr)
    {
        $counter+= count($arr);
    }
    return $counter ; 
}
function countExistingTypeFor($type ,  $company)
{
    $productItems = DB::select(DB::raw('select count(*) as has_product_item from sales_gathering where company_id = '. $company->id .' and '. $type .' is not null'));
    return $productItems[0]->has_product_item ?? 0  ;
}


function capitializeType($type)
{
    return __(spaceAfterCapitalLetters(camelize($type))) ;
}

function getCustomerSalesAnalysisData(Request $request , Company $company )
{
       $dimension = $request->report_type;

        $report_data =[];
        $growth_rate_data =[];

        $sales_channels = is_array(json_decode(($request->sales_channels[0]))) ? json_decode(($request->sales_channels[0])) :$request->sales_channels ;

        foreach ($sales_channels as  $sales_channel) {

            $sales_channels_data =collect(DB::select(DB::raw("
                SELECT DATE_FORMAT(LAST_DAY(date),'%d-%m-%Y') as gr_date  , net_sales_value ,customer_name
                FROM sales_gathering
                WHERE ( company_id = '".$company->id."'AND customer_name = '".$sales_channel."' AND date between '".$request->start_date."' and '".$request->end_date."')
                ORDER BY id "
                )))->groupBy('gr_date')->map(function($item){
                    return $item->sum('net_sales_value');
                })->toArray();
         
            $interval_data_per_item = [];
            $years = [];
            if (count($sales_channels_data)>0) {

                array_walk($sales_channels_data, function ($val, $date) use (&$years) {
                    $years[] = date('Y', strtotime($date));
                });
                $years = array_unique($years);
                $report_data[$sales_channel] = $sales_channels_data;
                $interval_data_per_item[$sales_channel] = $sales_channels_data;
                $interval_data = Intervals::intervals($interval_data_per_item, $years, $request->interval);

                $report_data[$sales_channel] = $interval_data['data_intervals'][$request->interval][$sales_channel] ?? [];



            }
        }

        $final_report_data = [];
        $sales_channels_names =[];
        foreach ($sales_channels as  $sales_channel) {
            $final_report_data[$sales_channel]['Sales Values'] = ($report_data[$sales_channel]??[]);
            $final_report_data[$sales_channel]['Growth Rate %'] = ($growth_rate_data[$sales_channel]??[]);
            $sales_channels_names[] = (str_replace( ' ','_', $sales_channel));
        }

            return $report_data ;
}




function getSalesPersonsSalesAnalysisData(Request $request , Company $company )
{
       $dimension = $request->report_type;

        $report_data =[];
        $growth_rate_data =[];

        $sales_channels = is_array(json_decode(($request->sales_channels[0]))) ? json_decode(($request->sales_channels[0])) :$request->sales_channels ;

        foreach ($sales_channels as  $sales_channel) {

            $sales_channels_data =collect(DB::select(DB::raw("
                SELECT DATE_FORMAT(LAST_DAY(date),'%d-%m-%Y') as gr_date  , net_sales_value ,sales_person
                FROM sales_gathering
                WHERE ( company_id = '".$company->id."'AND sales_person = '".$sales_channel."' AND date between '".$request->start_date."' and '".$request->end_date."')
                ORDER BY id "
                )))->groupBy('gr_date')->map(function($item){
                    return $item->sum('net_sales_value');
                })->toArray();
         
            $interval_data_per_item = [];
            $years = [];
            if (count($sales_channels_data)>0) {

                array_walk($sales_channels_data, function ($val, $date) use (&$years) {
                    $years[] = date('Y', strtotime($date));
                });
                $years = array_unique($years);
                $report_data[$sales_channel] = $sales_channels_data;
                $interval_data_per_item[$sales_channel] = $sales_channels_data;
                $interval_data = Intervals::intervals($interval_data_per_item, $years, $request->interval);

                $report_data[$sales_channel] = $interval_data['data_intervals'][$request->interval][$sales_channel] ?? [];



            }
        }

        $final_report_data = [];
        $sales_channels_names =[];
        foreach ($sales_channels as  $sales_channel) {
            $final_report_data[$sales_channel]['Sales Values'] = ($report_data[$sales_channel]??[]);
            $final_report_data[$sales_channel]['Growth Rate %'] = ($growth_rate_data[$sales_channel]??[]);
            $sales_channels_names[] = (str_replace( ' ','_', $sales_channel));
        }

            return $report_data ;
}

function sumBasedOnQuarterNumber($array , array $quarters  , $total )
{
    $result = 0 ; 
    foreach($array as $month=>$val)
    {
        if(in_array($month , $quarters ))
        {
            $result += $val ;
        }
    }
    return $result ? number_format($result / $total  * 100  , 2) . ' % ': '-';
     
}

function indexIsExistIn(string $indexName , string $tableName)
{
     $indexesFound = (Schema::getConnection()->getDoctrineSchemaManager())->listTableIndexes($tableName);
     
     return array_key_exists($indexName, $indexesFound) ;
}

function getAllColumnsTypesForCaching($companyId)
{
    $exportables = array_keys(getExportableFields($companyId)) ;
    $cacheablesFields = [
        'country' , 'branch','sales_person','customer_name','business_sector','zone','sales_channel','category','product_or_service','product_item'
    ] ;
    return array_intersect($exportables , $cacheablesFields) ;
    
}

function getCustomerNature(string $customerName , array $allDataArray)
{
    unset($allDataArray['totals']);
    if($customerName == 'TAQA Gas')
    {
    }
    // dd();
    foreach($allDataArray as $key=>$array)
    {
        // dump($array);
        foreach($array as $type=>$arr)
        {
           foreach($arr as $ar)
           {
            //    if($customerName == 'TAQA Gas'  )
            //    {
                //  logger($ar->customer_name );
            //    }
               if($ar->customer_name === $customerName)
               {
                    return $type ;   
               }
           }
        }
    }
    return '';
}