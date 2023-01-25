<?php

use App\Http\Controllers\Analysis\SalesGathering\BranchesAgainstAnalysisReport;
use App\Http\Controllers\Analysis\SalesGathering\BusinessSectorsAgainstAnalysisReport;
use App\Http\Controllers\Analysis\SalesGathering\CategoriesAgainstAnalysisReport;
use App\Http\Controllers\Analysis\SalesGathering\ProductsAgainstAnalysisReport;
use App\Http\Controllers\Analysis\SalesGathering\SalesChannelsAgainstAnalysisReport;
use App\Http\Controllers\Analysis\SalesGathering\SalesPersonsAgainstAnalysisReport;
use App\Http\Controllers\Analysis\SalesGathering\SKUsAgainstAnalysisReport;
use App\Http\Controllers\Analysis\SalesGathering\ZoneAgainstAnalysisReport;
use App\Http\Controllers\ExportTable;
use App\Models\AllocationSetting;
use App\Models\BalanceSheet;
use App\Models\CashFlowStatement;
use App\Models\Company;
use App\Models\CustomizedFieldsExportation;
use App\Models\ExistingProductAllocationBase;
use App\Models\IncomeStatement;
use App\Models\ModifiedSeasonality;
use App\Models\ModifiedTarget;
use App\Models\NewProductAllocationBase;
use App\Models\ProductSeasonality;
use App\Models\QuantityProductSeasonality;
use App\Models\SecondAllocationSetting;
use App\Models\SecondExistingProductAllocationBase;
use App\Models\SecondNewProductAllocationBase;
use App\Models\User;
use App\Traits\Intervals;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

const MAX_RANKING = 5;
const Customers_Against_Products_Trend_Analysis = 'Customers Against Products Trend Analysis';
const Customers_Against_Categories_Trend_Analysis = 'Customers Against Categories Trend Analysis';
const Customers_Against_Products_ITEMS_Trend_Analysis = 'Customers Against Products Items Trend Analysis';
const INVOICES = 'Invoices';

function spaceAfterCapitalLetters($string)
{
	return preg_replace('/(?<!\ )[A-Z]/', ' $0', $string);;
}

function getDeadRepeatingCustomersCacheNameForCompanyInYearForType(Company $companyId, string $year, $type)
{
	return 'dead_repeating_reactivated_customers_for_company_' . $companyId->id . '_for_year_' . $year . 'for_type_' . $type;
}


function getHavingConditionForDeadReactivated($year)
{
	return " having max(case when Year = " . $year . " then 1 else 0 end ) = 1
	and max(case when Year = " . ($year - 1) . "  then 1 else 0 end ) = 0
	and max(case when Year = " . ($year - 2) . " then 1 else 0 end ) = 0
	and
	( max(case when Year = " . ($year - 3) . " then 1 else 0 end ) = 1 or

	(max(case when Year = " . ($year - 3) . " then 1 else 0 end ) = 0
	and max(case when Year = " . ($year - 4) . " then 1 else 0 end ) = 1)

	)


	order by total_sales desc ; ";
}

function getHavingConditionForDeadRepeating($year)
{
	return " having max(case when Year = " . $year . " then 1 else 0 end ) = 1
	and max(case when Year = " . ($year - 1) . "  then 1 else 0 end ) = 1
	and max(case when Year = " . ($year - 2) . " then 1 else 0 end ) = 0
	and max(case when Year = " . ($year - 3) . " then 1 else 0 end ) = 0
	and max(case when Year = " . ($year - 4) . " then 1 else 0 end ) = 1
	order by total_sales desc ; ";
}
function getYearsFromInterval($start, $end)
{
	return [
		'start_year' => explode('-', $start)[0],
		'end_year' => explode('-', $end)[0],
	];
}

function array_unique_value(array $array, string $key)
{

	$uniqueItems = [];
	foreach ($array as $arr) {
		foreach ($arr as $ar) {
			$uniqueItems[$ar[$key]] = $ar;
		}
	}
	return $uniqueItems;
}
function getDeadRepeatingCustomersCacheNameForCompanyInYear(Company $companyId, string $year)
{
	return 'dead_repeating_reactivated_customers_for_company_' . $companyId->id . 'for_year_' . $year;
}

function getPeriods($interval)
{

	if ($interval == 'monthly') {
		return  [
			1 => [1],
			2 => [2],
			3 => [3],
			4 => [4],
			5 => [5],
			6 => [6],
			7 => [7],
			8 => [8],
			9 => [9],
			10 => [10],
			11 => [11],
			12 => [12],
		];
	}
	if ($interval == 'quarterly') {

		return [
			3 => [1, 2, 3], 6 => [4, 5, 6], 9 => [7, 8, 9], 12 => [10, 11, 12]
		];
	}
	if ($interval == 'semi-annually') {
		return [
			6 => [1, 2, 3, 4, 5, 6], 12 => [7, 8, 9, 10, 11, 12]
		];
	}

	if ($interval == 'annually') {
		return [
			12 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
		];
	}
}
function getLongestArray($array)
{
	$result = [];
	foreach ($array as $arr) {
		if (count($arr) > count($result)) {
			$result = $arr;
		}
	}

	return $result;
}
function arrayCountAllLongest(array $array)
{
	$longestArray = getLongestArray($array);

	$counter = 0;

	foreach ($longestArray as $arr) {
		$counter += count($arr);
	}

	return $counter;
}
function flatten(array $array)
{
	$return = array();
	array_walk_recursive($array, function ($a) use (&$return) {
		$return[] = $a;
	});
	return $return;
}
function countTotalForBranch(array $array): int
{
	$total = 0;
	foreach ($array as $arr) {
		$total += count($arr);
	}

	return $total;
}

function countSumForAllRank(array $array, $i): array
{
	$total = [
		'total' => 0,
		'values' => 0,
		'percentages' => 0
	];
	foreach ($array as $arr) {
		if (isset($arr[$i])) {
			$total['total'] += count($arr[$i]);
			$total['values'] += array_sum(flatten($arr[$i]));
			$total['percentages'] += 0;
		}
	}

	return $total;
}
function camelize($input, $separator = '_')
{
	return str_replace($separator, '', ucwords($input, $separator));
}

if (!function_exists('lang')) {
	function lang()
	{
		return  app()->getLocale();
	}
}

if (!function_exists('company')) {
	function company()
	{
		if (Auth::check()) {
			$company =   Auth::user()->companies()->where('type', 'single')->first();

			$company = $company ?? Auth::user()->companies()->where('type', 'group')->first()->subCompanies()->first();

			return  $company;
		}
	}
}
if (!function_exists('company')) {
	function setCompany($company_id)
	{
		if (Auth::check()) {
			$company = Company::find($company_id);
			return  $company;
		}
	}
}
if (!function_exists('exportableFields')) {
	function exportableFields($company_id, $model)
	{
		if (Auth::check()) {
			$fields = CustomizedFieldsExportation::where('model_name', $model)->where('company_id', $company_id)->first();
			return  $fields;
		}
	}
}

if (!function_exists('strip_strings')) {
	function strip_strings(string $sentence)
	{
		$removeHtml =  strip_tags($sentence);

		return str_replace(['&amp;', '&nbsp;', 'nbsp;'],  '', $removeHtml);
	}
}

if (!function_exists('dateFormating')) {
	function dateFormating($date, $formate = "d-m-Y")
	{
		return date($formate, strtotime($date));
	}
}
if (!function_exists('routeName')) {
	function routeName($route)
	{
		$route_array = explode('.', $route);
		$route = $route_array[0];
		return $route;
	}
}
function getOrderMaxForBranch(string $branchName,  array $data)
{

	$arr_data = $data;

	uasort($arr_data, function ($a, $b) {
		return $a < $b;
	});
	$uniques = array_unique($arr_data);
	for ($i = 0; $i < count($uniques); $i++) {
		$key = array_values($uniques)[$i];
		$new["$key"] = $i + 1;
	};

	$value = $arr_data[$branchName];

	return $new[strval($value)];
}
function array_sort_multi_levels(&$array)
{
	uasort($array, function ($a, $b) {
		$sumA = 0;
		foreach ($a as $year => $data) {
			foreach ($data as $quarter => $data) {
				$sumA += $data['invoice_number'];
			}
		}

		$sumB = 0;
		foreach ($b as $year => $data) {
			foreach ($data as $quarter => $data) {
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
	return 'company_' . $company->id;
}
function getExportableFields($companyId = null): array
{

	$company  = Company::find($companyId ?: Request()->segment(2));
	if ($company) {
		return (new ExportTable)->customizedTableField($company, 'SalesGathering', 'selected_fields');
	}
	return [];
}
function getExportableFieldsKeysAsValues($companyId)
{
	return array_keys(getExportableFields($companyId)) ?? [];
}

function canViewCustomersDashboard(array $exportables)
{
	return in_array('Customer Name', $exportables) || in_array('Customer Code', $exportables);
}
// 1- customers dashboard
function getNewCustomersCacheNameForCompanyInYear(Company $companyId, string $year)
{
	return 'new_customers_for_company_' . $companyId->id . '_for_year_' . $year;
}
function getNewCustomersCacheNameForCompanyInYearForType(Company $companyId, string $year, $type)
{
	return 'new_customers_for_company_' . $companyId->id . '_for_year_' . $year . 'for_type_' . $type;
}


function getTotalCustomersCacheNameForCompanyInYearForType(Company $companyId, string $year, $type)
{
	return 'total_customers_for_company_' . $companyId->id . '_for_year_' . $year . 'for_type_' . $type;
}


//
function getRepeatingCustomersCacheNameForCompanyInYear(Company $companyId, string $year)
{
	return 'repeating_customers_for_company_' . $companyId->id . '_for_year_' . $year;
}

function getRepeatingCustomersCacheNameForCompanyInYearForType(Company $companyId, string $year, $type)
{
	return 'repeating_customers_for_company_' . $companyId->id . '_for_year_' . $year . 'for_type_'  . $type;
}

function getActiveCustomersCacheNameForCompanyInYear(Company $companyId, string $year)
{
	return 'active_customers_for_company_' . $companyId->id . '_for_year_' . $year;
}

function getActiveCustomersCacheNameForCompanyInYearForType(Company $companyId, string $year, $type)
{
	return 'active_customers_for_company_' . $companyId->id . '_for_year_' . $year . 'for_type_'  . $type;
}



function getStopReactivatedCustomersCacheNameForCompanyInYear(Company $companyId, string $year)
{
	return 'stop_reactivated_customers_for_company_' . $companyId->id . '_for_year_' . $year;
}
function getStopReactivatedCustomersCacheNameForCompanyInYearForType(Company $companyId, string $year, $type)
{
	return 'stop_reactivated_customers_for_company_' . $companyId->id . '_for_year_' . $year . 'for_type_'  . $type;
}
function getDeadReactivatedCustomersCacheNameForCompanyInYear(Company $companyId, string $year)
{
	return 'dead_reactivated_customers_for_company_' . $companyId->id . '_for_year_' . $year;
}

function getDeadReactiveCacheNameForCompanyInYearForType(Company $companyId, string $year, $type)
{
	return 'dead_reactivated_customers_for_company_' . $companyId->id . '_for_year_' . $year . 'for_type_'  . $type;
}
// getStopRepeatingCacheNameForCompanyInYearForType
// getDeadReactiveCacheNameForCompanyInYearForType
function getStopRepeatingCustomersCacheNameForCompanyInYear(Company $companyId, string $year)
{
	return 'stop_repeating_reactivated_customers_for_company_' . $companyId->id . 'for_year_' . $year;
}
function getStopRepeatingCustomersCacheNameForCompanyInYearForType(Company $companyId, string $year, $type)
{
	return 'stop_repeating_reactivated_customers_for_company_' . $companyId->id . '_for_year_' . $year . 'for_type_' . $type;
}
function getStopCustomersCacheNameForCompanyInYear(Company $companyId, string $year)
{
	return 'stop_customers_for_company_' . $companyId->id . '_for_year_' . $year;
}

function getStopCustomersCacheNameForCompanyInYearForType(Company $companyId, string $year, $type)
{
	return 'stop_customers_for_company_' . $companyId->id . '_for_year_' . $year . 'for_type_' . $type;
}


function getDeadCustomersCacheNameForCompanyInYear(Company $companyId, string $year)
{
	return 'dead_customers_for_company_' . $companyId->id . '_for_year_' . $year;
}
function getDeadCustomersCacheNameForCompanyInYearForType(Company $companyId, string $year, $type)
{
	return 'dead_customers_for_company_' . $companyId->id . '_for_year_' . $year . 'for_type_' . $type;
}

function getTotalCustomersCacheNameForCompanyInYear(Company $companyId, string $year)
{
	return 'total_customers_dashboard_for_company_' . $companyId->id . '_for_year_' . $year;
}

// intervalYearsForCompany (max date and min date in database for sales gatering)


function getIntervalYearsFormCompanyCacheNameForCompany(Company $companyId)
{
	return 'interval_years_for_company_' . $companyId->id;
}
function formatChartNameForDom($chartName)
{
	return str_replace(["/", ' '], '-', $chartName);
}





function sortReportForTotals(&$report_data)
{
	(uasort(
		$report_data,
		function ($a, $b) use (&$report_data) {
			if (isset($b['Total']) && isset($a['Total'])) {


				$a = array_sum($a['Total']);
				$b = array_sum($b['Total']);

				if ($a == $b) {
					return 0;
				}
				return ($a > $b) ? -1 : 1;
			}

			if (!is_multi_array($a) &&  is_multi_array($b)) {
				return 1;
			}

			if (is_multi_array($a) &&  !is_multi_array($b)) {
				return -1;
			}

			if (isset($a['Total']) && !isset($b['Total'])) {
				return -1;
			}

			if (!isset($a['Total']) && isset($b['Total'])) {
				return 1;
			}



			return -1;
		}

	)
	);
}

function sortSubItems(&$sales_channel_channels_data)
{

	(uasort(
		$sales_channel_channels_data,
		function ($a, $b) {

			if (isset($a['Sales Values']) && isset($b['Sales Values'])) {

				$a = array_sum($a['Sales Values']);
				$b = array_sum($b['Sales Values']);


				if ($a == $b) {
					return 0;
				}
				return ($a > $b) ? -1 : 1;
			}
			return;
		}

	)
	);
}
function sortTwoDimensionalArr(array &$arr)
{
	uasort($arr, function ($a, $b) {
		if ($a == $b) {
			return 0;
		}
		return ($a > $b) ? -1 : 1;
	});
}
function sortOneDimensionalArr(array &$arr)
{
	uasort($arr, function ($a, $b) {
		if ($a == $b) {
			return 0;
		}
		return ($a > $b) ? -1 : 1;
	});
}

function sortTwoDimensionalBaseOnKey(array &$arr, $key)
{
	uasort($arr, function ($a, $b) use ($key) {
		if ($a[$key] == $b[$key]) {
			return 0;
		}
		return ($a[$key] > $b[$key]) ? -1 : 1;
	});
}
function sortTwoDimensionalExcept(array &$arr, array $exceptKeys)
{
	uksort($arr, function ($key1, $key2) use ($exceptKeys, $arr) {
		if (!in_array($key1, $exceptKeys) && !in_array($key2, $exceptKeys)) {
			if ($arr[$key1] == $arr[$key2]) {
				return 0;
			}
			return $arr[$key1] > $arr[$key2] ? -1 : 1;
		} elseif (!in_array($key1, $exceptKeys) && in_array($key2, $exceptKeys)) {
			return -1;
		} elseif (in_array($key1, $exceptKeys) && !in_array($key2, $exceptKeys)) {
			return -1;
		} else {
			return -1;
		}
	});
}
function getTypeFor($type, $companyId, $formatted = false, $date = false, $start_date = null, $end_date = null)
{
	if ($formatted) {
		// 2022-03-22 
		// start 01-01-2021
		// end 01-01-2022 


		return  DB::table('sales_gathering')->where('company_id', $companyId)
			->when($date && $start_date, function (Builder $builder) use ($start_date) {
				$builder->where('date', '>=', $start_date);
			})
			->when($date && $end_date, function (Builder $builder) use ($end_date) {
				$builder->where('date', '<=', $end_date);
			})
			->orderBy($type)->distinct()->select($type)->get()->pluck($type, $type)->toArray();;
	} else {
		$data = DB::table('sales_gathering')->where('company_id', $companyId)
			->when($date && $start_date, function (Builder $builder) use ($start_date) {
				$builder->where('date', '>=', $start_date);
			})
			->when($date && $end_date, function (Builder $builder) use ($end_date) {
				$builder->where('date', '<=', $end_date);
			})
			->orderBy($type)->distinct()->select($type)->get()->pluck($type)->toArray();

		$data = array_filter($data, function ($item) {

			return $item;
		});
		return $data;
	}
	//   return  DB::table('sales_gathering')->where('company_id', $companyId)->distinct()->select($type)->get()->pluck($type)->toArray(); ;
}
function getNumberOfProductsItems($companyId)
{
	return ProductSeasonality::where('company_id', $companyId)->count();
}
function canShowNewItemsProducts($companyId)
{
	return  getNumberOfProductsItems($companyId);
}

function getProductsItems($companyId)
{
	return ProductSeasonality::where('company_id', $companyId)->get();
}
function deleteProductItemsForForecast($companyId)
{
	ProductSeasonality::where('company_id', $companyId)->delete();
}
function deleteNewProductAllocationBaseForForecast($companyId)
{
	NewProductAllocationBase::where('company_id', $companyId)->delete();
	SecondNewProductAllocationBase::where('company_id', $companyId)->delete();
	AllocationSetting::where('company_id', $companyId)->delete();
	SecondAllocationSetting::where('company_id', $companyId)->delete();
	ExistingProductAllocationBase::where('company_id', $companyId)->delete();
	SecondExistingProductAllocationBase::where('company_id', $companyId)->delete();
	ModifiedSeasonality::where('company_id', $companyId)->delete();
	ModifiedTarget::where('company_id', $companyId)->delete();
}

function getLargestArrayDates(array $array)
{

	if (count($array) == count($array, COUNT_RECURSIVE)) {
		$dates = [];
		foreach ($array as $date => $val) {
			if ($date) {
				try {
					$dates[] =
						Carbon::make($date)->format('d-M-Y');
				} catch (\Exception $e) {
					return $dates;
				}
			} else {
				return $dates;
			}
		}
		return $dates;
	} else {
		$largestArray = getLargestArray($array);
		return getLargestArrayDates($largestArray);
	}
}
function getLargestArray($array)
{
	$largestArr = [];
	foreach ($array as $arr) {
		if (count($arr) > count($largestArr)) {
			$largestArr = $arr;
		}
	}
	return $largestArr;
}
function getDateBetween(array $dates)
{
	$smallest = null;
	$largest = null;
	if (count($dates)) {

		foreach ($dates as $type => $date) {
			if (is_array($date)) {
				foreach ($date as $d => $k) {
					$d = Carbon::make($d);
					if (is_null($smallest)) {
						$smallest = $d;
					} else {
						if (!$d->greaterThan($smallest)) {
							$d = $smallest;
						}
					}

					if (is_null($largest)) {
						$largest = $d;
					} else {
						if ($d->greaterThan($largest)) {
							$largest = $d;
						}
					}
				}
			} else {
				$newDates = array_keys($dates);
				$smallest = Carbon::make($newDates[0]) ?? null;
				$largest = Carbon::make($newDates[count($newDates) - 1]) ?? null;
			}
		}



		$period = new DatePeriod(
			new DateTime($smallest->format('Y-m-d')),
			new DateInterval('P1M'),
			new DateTime($largest->format('Y-m-d'))
		);

		$per = [];
		foreach ($period as $p) {
			$per[] = $p->format('d-M-Y');
		}

		return $per;
	}


	return [];
}


function generateIdForExcelRow(int $companyId)
{
	return uniqid('company_' . $companyId) . Str::random(9) . $companyId . uniqid();
}

function getTotalUploadCacheKey($company_id, $jobId)
{
	return 'total_uploaded_for_company_' . $company_id  . 'for_job_' . $jobId;
}

function getShowCompletedTestMessageCacheKey($companyId)
{
	return 'show_complete_test_phase_' . $companyId;
}




function is_multi_array($arr)
{
	rsort($arr);
	return isset($arr[0]) && is_array($arr[0]);
}

function maxOptionsForOneSelector(): int
{
	// return 2 ; 
	return 12;
}

function isCustomerExceptionalCase($type, $name_of_selector_label)
{
	$conditionOne = ($type == 'category' && ($name_of_selector_label == 'Customers Against Categories' || $name_of_selector_label == 'Categories'));

	return $conditionOne;
}

function isCustomerExceptionalForProducts($type, $name_of_selector_label)
{

	$conditionTwo = ($type == 'product_or_service' && ($name_of_selector_label == 'Customers Against Products' ||  $name_of_selector_label == 'Products'));

	return $conditionTwo;
}

function isCustomerExceptionalForProductsItems($type, $name_of_selector_label)
{

	$conditionTwo = ($type == 'product_item' && ($name_of_selector_label == 'Customers Against Products Items' ||  $name_of_selector_label == 'Product Items'));

	return $conditionTwo;
}

function orderTotalsForRanking(array &$array)
{
	(uasort(
		$array,
		function ($a, $b) {

			if (isset($a['total']) && isset($b['total'])) {

				$a = ($a['total']);

				$b = ($b['total']);


				if ($a == $b) {
					return 0;
				}
				return ($a > $b) ? -1 : 1;
			}
			return;
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
	return __('Please Add New') . ' ' . capitializeType($allocation_type);
}
function hasProductsItems($company)
{

	$productItems = DB::select(DB::raw('select count(*) as has_product_item from sales_gathering where company_id = ' . $company->id . ' and product_item is not null'));
	return $productItems[0]->has_product_item ?? 0;
}
function hasAtLeastOneOfType($company, $type)
{
	$productItems = DB::select(DB::raw('select count(*) as has_product_item from sales_gathering where company_id = ' . $company->id . ' and ' . $type . ' is not null'));
	return $productItems[0]->has_product_item ?? 0;
}
function count_array_values(array $array)
{
	$counter = 0;
	foreach ($array as $arr) {
		$counter += count($arr);
	}
	return $counter;
}
function countExistingTypeFor($type,  $company)
{
	$productItems = DB::select(DB::raw('select count(*) as has_product_item from sales_gathering where company_id = ' . $company->id . ' and ' . $type . ' is not null'));
	return $productItems[0]->has_product_item ?? 0;
}


function capitializeType($type)
{
	return __(spaceAfterCapitalLetters(camelize($type)));
}


function getTypeSalesAnalysisData(Request $request, Company $company, $type)
{
	$dimension = $request->report_type;

	$report_data = [];
	$growth_rate_data = [];

	$sales_channels = is_array(json_decode(($request->sales_channels[0]))) ? json_decode(($request->sales_channels[0])) : $request->sales_channels;

	foreach ($sales_channels as  $sales_channel) {
		$sales_channel = str_replace("'", "\'", $sales_channel);
		$sales_channels_data = collect(DB::select(DB::raw(
			"
                SELECT DATE_FORMAT(LAST_DAY(date),'%d-%m-%Y') as gr_date  , net_sales_value ," . $type . "
                FROM sales_gathering
                WHERE ( company_id = '" . $company->id . "'AND " . $type . " = '" . $sales_channel . "' AND date between '" . $request->start_date . "' and '" . $request->end_date . "')
                ORDER BY id "
		)))->groupBy('gr_date')->map(function ($item) {
			return $item->sum('net_sales_value');
		})->toArray();

		$interval_data_per_item = [];
		$years = [];
		if (count($sales_channels_data) > 0) {
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
	$sales_channels_names = [];
	foreach ($sales_channels as  $sales_channel) {
		$final_report_data[$sales_channel]['Sales Values'] = ($report_data[$sales_channel] ?? []);
		$final_report_data[$sales_channel]['Growth Rate %'] = ($growth_rate_data[$sales_channel] ?? []);
		$sales_channels_names[] = (str_replace(' ', '_', $sales_channel));
	}

	return $report_data;
}


function sumBasedOnQuarterNumber($array, array $quarters, $total)
{
	$result = 0;
	foreach ($array as $month => $val) {
		if (in_array($month, $quarters)) {
			$result += $val;
		}
	}
	return $result ? number_format($result / $total  * 100, 2) . ' % ' : '-';
}

function indexIsExistIn(string $indexName, string $tableName)
{
	$indexesFound = (Schema::getConnection()->getDoctrineSchemaManager())->listTableIndexes($tableName);

	return array_key_exists($indexName, $indexesFound);
}

function getAllColumnsTypesForCaching($companyId)
{
	$exportables = array_keys(getExportableFields($companyId));
	$cacheablesFields = [
		'country', 'branch', 'sales_person', 'customer_name', 'business_sector', 'zone', 'sales_channel', 'category', 'product_or_service', 'product_item'
	];
	return array_intersect($exportables, $cacheablesFields);
}

function getCustomerNature(string $customerName, array $allDataArray)
{
	unset($allDataArray['totals']);
	foreach ($allDataArray as $key => $array) {
		foreach ($array as $type => $arr) {
			foreach ($arr as $ar) {
				//    if($customerName == 'TAQA Gas'  )
				//    {
				//  logger($ar->customer_name );
				//    }
				if ($ar->customer_name === $customerName) {
					return str_replace(' ', '', $type);
				}
			}
		}
	}
	return '';
}

function getSummaryCustomerDashboardForEachType($allFormattedWithOthers, $customerNature)
{
	$dataFormatted = [];
	foreach ($allFormattedWithOthers as $customerObject) {
		$userType = getCustomerNature($customerObject->customer_name, $customerNature);
		isset($dataFormatted[$userType]) ? $dataFormatted[$userType] = [
			'count' => $dataFormatted[$userType]['count'] + 1,
			'sales' => $dataFormatted[$userType]['sales'] + $customerObject->val
		]
			: $dataFormatted[$userType] = [
				'count' => 1,
				'sales' => $customerObject->val
			];
	}
	$dataFormatted = array_filter($dataFormatted);

	// foreach($dataFormatted as $key=>$val)
	// {
	//     if(! $key )
	//     {
	//         unset($dataFormatted[$key]);
	//     }
	// }
	return array_sort_type($dataFormatted);
}
function array_sort_type($array)
{
	(uasort(
		$array,
		function ($firstElement, $secondElement) {
			if (isset($firstElement['sales']) && isset($secondElement['sales'])) {

				$firstElement = $firstElement['sales'];

				$secondElement = $secondElement['sales'];
				if ($firstElement == $secondElement) {
					return 0;
				}
				return ($firstElement > $secondElement) ? -1 : 1;
			}
			return;
		}

	)
	);

	return $array;
}

function sum_array_of_std_objects(array $array,  string $key)
{

	$totalSum =  0;
	foreach ($array as $arr) {
		foreach ($arr as $ar) {
			$totalSum += $ar->{$key} ?? 0;
		}
	}
	return $totalSum;
}
function getIterableItems($array)
{
	$iterables = [];
	foreach ($array as $key => $arrVal) {
		foreach ($arrVal as $item => $val) {
			if (!isset($iterables[$item])) {
				$iterables[$item] = getTotalForThisTypeExceptDead($array, $item, 'total_sales');
			}
		}
	}
	sortTwoDimensionalArr($iterables);
	return $iterables;
}

function getTotalForSingleType($array, $key)
{
	$totals = 0;
	foreach ($array as $arr) {
		foreach ($arr as $ar) {
			$totals += $ar->{$key};
		}
	}
	return $totals;
}
function countTotalForSingleType($array)
{
	$totals = 0;
	foreach ($array as $arr) {
		foreach ($arr as $ar) {
			$totals += 1;
		}
	}
	return $totals;
}
function calcTotalsForTotalsActiveItems(array $array, $key)
{

	$totals = 0;
	foreach ($array as $arr) {
		foreach ($arr as $ar) {
			foreach ($ar as $item) {
				$totals += $item->{$key} ?? 0;
			}
		}
	}
	return $totals;
}

function countTotalsForTotalsActiveItems(array $array, $key)
{
	$totals = 0;
	foreach ($array as $arr) {
		foreach ($arr as $ar) {
			foreach ($ar as $item) {
				$totals += 1;
			}
		}
	}
	return $totals;
}


function getTotalForThisTypeExceptDead(array $array, $iterableSingleItem, $key)
{

	$total = 0;
	foreach ($array as $index => $arrayOfValues) {
		if (!in_array($index, ['Dead', 'Stop'])) {
			$items =  $arrayOfValues[$iterableSingleItem] ?? [];

			foreach ($items as $item) {
				$total += $item->{$key};
			}
		}
	}
	return $total;
}

function getTotalForThisType(array $array, $iterableSingleItem, $key)
{

	$total = 0;
	foreach ($array as $arrayOfValues) {
		$items =  $arrayOfValues[$iterableSingleItem] ?? [];
		foreach ($items as $item) {
			$total += $item->{$key};
		}
	}
	return $total;
}
function array_fill_keys_with_values(array $arr)
{
	$newArray = [];
	foreach ($arr as $a) {
		$newArray[$a] = $a;
	}
	return $newArray;
}
function countTotalForThisType(array $array, $iterableSingleItem)
{

	$total = 0;
	foreach ($array as $arrayOfValues) {
		$items =  $arrayOfValues[$iterableSingleItem] ?? [];
		foreach ($items as $item) {
			$total += 1;
		}
	}
	return $total;
}

function sum_array_of_std_objectsForSubType(array $array, $key)
{
	$sum =  0;
	foreach ($array as $arr) {
		$sum += $arr->{$key};
	}
	return $sum;
}

function count_array_of_std_objects(array $array)
{
	$counter = 0;
	foreach ($array as $arr) {
		$counter += 1;
	}
	return $counter;
}

function formatInvoiceForEachInterval(array $array, $selectedType)
{
	$finalResult = [];
	$result = [
		'product_item' => 0,
		'invoice_number' => 0
	];

	$finalResult = [
		'product_item_avg_count' => 0,
		'invoice_count' => 0,
		'avg_invoice_value' => 0
	];
	foreach ($array['sumForEachInterval'][$selectedType] ?? [] as $year => $data) {
		$result['product_item'] =  isset($result['product_item']) ? $result['product_item'] + $data[12]['product_item'] : $data[12]['product_item'];
		$result['invoice_number'] =  isset($result['invoice_number']) ? $result['invoice_number'] + $data[12]['invoice_number'] : $data[12]['invoice_number'];
	}
	$resultForSales = 0;
	foreach ($array['reportSalesValues'][$selectedType] ?? [] as $data => $saleValue) {
		$resultForSales += $saleValue;
	}

	$finalResult['invoice_count'] = $result['invoice_number'] ?? 0;
	$finalResult['product_item_avg_count'] = $result['invoice_number'] ? round($result['product_item'] / $result['invoice_number']) : 0;
	$finalResult['avg_invoice_value'] = $result['invoice_number'] ? number_format($resultForSales / $result['invoice_number'], 0) : 0;
	return $finalResult;
}
function getFieldsForTakeawayForType(string $type)
{
	$commonFields = ['customer_name' => __('Customers Count'), 'category' => __('Categories Count'), 'product_or_service' => __('Products/Service Count'), 'product_item' => __('Products Item Count'), 'sales_person' => __('Salesperson Count'), 'branch' => __('Branch Count'), 'invoice_count' => __('Invoices Count'), 'product_item_avg_count' => __('Avg Products Item Per Invoice'), 'avg_invoice_value' => __('Avg Invoice Values')];
	return [
		'business_sector' => array_merge($commonFields, []),
		'category' => array_merge(Arr::except($commonFields, ['category']), [
			'business_sector' => __('Business Sectors Count'),
			'sales_channel' => __('Sales Channel Count'),
			'zone' => __('Zone Count')
		]),
		'sales_channel' => array_merge($commonFields, [
			'business_sector' => __('Business Sectors Count'),
			'zone' => __('Zone Count')
		]),
		'branch' => array_merge($commonFields, [
			'business_sector' => __('Business Sectors Count'),
			'sales_channel' => __('Sales Channel Count'),

		]),
		'zone' => array_merge($commonFields, [
			'sales_channel' => __('Sales Channel Count'),
		]),
		'product_or_service' => array_merge(Arr::except($commonFields, ['category', 'product_or_service']), [
			'business_sector' => __('Business Sectors Count'),
			'sales_channel' => __('Sales Channel Count'),
			'zone' => __('Zone Count')
		]),

		'product_item' => array_merge(Arr::except($commonFields, ['category', 'product_or_service', 'product_item']), [
			'business_sector' => __('Business Sectors Count'),
			'sales_channel' => __('Sales Channel Count'),
			'zone' => __('Zone Count')
		])
	][$type] ?? $commonFields;
}
function orderStdClassBy($stdObjArray, $orderKey, $direction = 'desc')
{
	(uasort(
		$stdObjArray,
		function ($a, $b) {
			if (isset($a->total_sales_value) && isset($b->total_sales_value)) {

				$a = $a->total_sales_value;;

				$b = $b->total_sales_value;


				if ($a == $b) {
					return 0;
				}
				return ($a > $b) ? -1 : 1;
			}
			return;
		}

	)
	);
	return $stdObjArray;
}

function hasTopAndBottom($type)
{
	$allowedTypes = [
		'zone', 'product_or_service', 'product_item', 'customer_name', 'business_sector', 'category', 'sales_channel', 'sales_person', 'branch'
	];

	return in_array($type, $allowedTypes);
}

function forecastHasBeenChanged($sales_forecast, array $newData)
{

	if (is_null($sales_forecast)) {
		return true;
	}



	foreach (['previous_1_year_sales', 'previous_year', 'previous_year_gr', 'average_last_3_years', 'target_base', 'sales_target', 'new_start', 'growth_rate', 'add_new_products', 'number_of_products', 'sales_target', 'seasonality', 'start_date'] as $index => $field) {
		if (@$newData[$field] != $sales_forecast->{$field}) {
			return true;
		}
	}
	return false;
}

function getCacheKeyForFirstAllocationReport($companyId)
{
	return 'first_allocation_report_for_company_' . $companyId;
}


function getCacheKeyForSecondAllocationReport($companyId)
{
	return 'second_allocation_report_for_company_' . $companyId;
}
function formatExistingFormNewAllocation($newAllocation)
{
	if ($newAllocation) {
		$allocationsNames = $newAllocation->new_allocation_bases_names;
		$data = $newAllocation->allocation_base_data;
		if (!$data) {
			return [];
		}
		$sums = [];
		foreach ($data as $productItem => $newData) {
			foreach ($newData as  $branchName => $values) {
				$sums[$branchName] = ($sums[$branchName] ?? 0) + ($values['actual_value'] ?? 0);
			}
		}
		return $sums;
	}
	return [];
}

function formatDateVariable($dates, $start_date, $end_date)
{

	if (!$dates) {
		return [];
	}
	if (!$start_date || !$end_date) {
		return $dates;
	}
	$start_date = Carbon::make($start_date);

	$end_date = Carbon::make($end_date);
	// we will ignore day of end date
	$dayOfEndDate = $end_date->day;
	$monthOfEndDate = $end_date->month;
	$yearOfEndDate = $end_date->year;
	// get last day in month and year
	$end_date = Carbon::create($yearOfEndDate, $monthOfEndDate)->lastOfMonth()->format('Y-m-d');
	$end_date = Carbon::make($end_date);
	$filteredDates = [];
	foreach ($dates as $date) {
		$dateWithoutFormatting = $date;
		$date = Carbon::make($date);
		if (
			$date >= $start_date
			&& $date <= $end_date

		) {
			$filteredDates[] = $dateWithoutFormatting;
		}
	}
	return count($filteredDates) ? $filteredDates : $dates;
}

function getTotalsOfTotal($reportArray)
{
	$totalForEachItem = [];
	foreach ($reportArray  as $itemName => $data) {

		// sortSubItems($data);
		foreach ($data as $reportKey => $valueArr) {

			if ($reportKey != 'Growth Rate %' && $reportKey != 'Total' && $itemName != 'Total' && $itemName != 'Growth Rate %') {
				$totalForEachItem[$itemName][$reportKey] = 0;

				if (isset($reportArray[$itemName][$reportKey]['Sales Values'])) {
					$totalForEachItem[$itemName][$reportKey] += array_sum($reportArray[$itemName][$reportKey]['Sales Values']);
				}
			}
		}
	}

	$newArray = [];

	foreach ($totalForEachItem as $key => $arr) {


		uasort($arr, function ($a, $b) {
			$a = ($a);
			$b = ($b);

			if ($a == $b) {
				return 0;
			}
			return ($a > $b) ? -1 : 1;
		});

		$newArray[$key] = $arr;
	}
	return $newArray;
	// return $totalForEachItem ;
}

function getLopeItemsFromEachReport($firstReport, $secondReport)
{
	$first = [];
	$second = [];
	foreach ($secondReport as $key => $arrayOfValues) {
		foreach ($arrayOfValues as $itemName => $value) {
			$second[$itemName] = $itemName;
		}
	}
	foreach ($firstReport as $key => $arrayOfValues) {
		sortOneDimensionalArr($arrayOfValues);
		foreach ($arrayOfValues as $itemName => $value) {
			$first[$itemName] = $itemName;
		}
	}
	return array_unique(array_merge($second, $first));

	// return $data ;
}

function getMainItemsNameFromEachInterval($firstReport, $secondReport)
{
	array_sort_products($secondReport);

	$firstReportProductsItems = array_keys($firstReport);
	$secondReportProductsItems = array_keys($secondReport);
	return array_unique(array_merge($secondReportProductsItems, $firstReportProductsItems));
}
function array_sort_products(&$secondReport)
{
	uasort($secondReport, function ($a, $b) {
		//   foreach( )
		$a = array_sum($a);
		$b = array_sum($b);

		if ($a == $b) {
			return 0;
		}
		return ($a > $b) ? -1 : 1;
	});
}
function sum_all_array_values($array)
{
	$total = 0;
	foreach ($array as $key => $value) {
		$total += $value;
	}

	return $total;
}

function preventUserFromForeCast()
{
	return [12, 13, 14, 15, 16];
}

function getCanReloadUploadPageCachingForCompany($companyId)
{
	return 'can_reload_caching_page_for_company_' . $companyId;
}

function getComparingReportForAnalysis($request, $report_data, $secondReport, $company, $dates, $view_name, $Items_names, $modelType)
{
	if ($request->report_type == 'comparing' && $secondReport == true) {
		$firstReportData['first_report']  =   $dates;
		$firstReportData['first_report_date']  =   Carbon::make($request->start_date)->format('d M Y') . ' ' . __('To') . ' ' . Carbon::make($request->end_date)->format('d M Y');
		$firstReportData['report_data'] =  $report_data;
		$request['start_date'] = $request->start_date_second;
		$request['end_date'] = $request->end_date_second;
		if ($modelType == 'product_item') {
			$secondReportDataResult = (new SKUsAgainstAnalysisReport())->result($request, $company, false);
			$type = __('Products Items');
		} elseif ($modelType == 'zone') {
			$secondReportDataResult = (new ZoneAgainstAnalysisReport())->result($request, $company, 'view', false);
			$type = __('Zones');
		} elseif ($modelType == 'sales_channel') {
			$secondReportDataResult = (new SalesChannelsAgainstAnalysisReport())->result($request, $company, 'view', false);
			$type = __('Sales Channel');
		} elseif ($modelType == 'category') {
			$secondReportDataResult = (new CategoriesAgainstAnalysisReport())->result($request, $company, 'view', false);
			$type = __('Categories');
		} elseif ($modelType == 'product_or_service') {
			$secondReportDataResult = (new ProductsAgainstAnalysisReport())->result($request, $company, 'view', false);
			$type = __('Products Or Services');
		} elseif ($modelType == 'branch') {
			$secondReportDataResult = (new BranchesAgainstAnalysisReport())->result($request, $company, false);
			$type = __('Branch');
		} elseif ($modelType == 'business_sector') {
			$secondReportDataResult = (new BusinessSectorsAgainstAnalysisReport())->result($request, $company, 'view', false);
			$type = __('Business Sector');
		} elseif ($modelType == 'sales_person') {
			$secondReportDataResult = (new SalesPersonsAgainstAnalysisReport())->result($request, $company, false);
			$type = __('Business Sector');
		} else {
			dd('not supported type');
		}

		$secondReportData = $secondReportDataResult['report_data'] ?? [];
		$secondReportData['full_date'] = $secondReportDataResult['full_date'] ?? [];
		$report_data = getTotalsOfTotal($report_data);
		$secondReportData['report_data'] = getTotalsOfTotal($secondReportDataResult['report_data']);
		$secondItemsName = getLopeItemsFromEachReport($report_data, $secondReportData['report_data']);
		$secondReportData['report_data']  = addFirstReportKeysToSendReport($secondItemsName,  $secondReportData['report_data']);
		$mainItems = getMainItemsNameFromEachInterval($report_data, $secondReportData['report_data']);

		return view('client_view.reports.sales_gathering_analysis.second_comparing_analysis', compact('company', 'view_name', 'firstReportData', 'Items_names', 'dates', 'report_data', 'secondReportData', 'secondItemsName', 'mainItems', 'type'));
	}
}
function addFirstReportKeysToSendReport($keys, $secondReport)
{
	if (!count($secondReport)) {
		return $secondReport;
	}
	foreach ($secondReport as $key => $array) {
		foreach ($keys as $newKey) {
			!isset($array[$newKey]) ? $secondReport[$key][$newKey] = 0 : '';
		}
	}
	return $secondReport;
}
function sortResultData($arr)
{
}


function getCurrentCompany()
{
	$companyIdentifier = Request()->segment(2);
	return Company::find($companyIdentifier);
}
function getCurrentCompanyId(): int
{
	return Request()->segment(2) ?? 31;
}
function getCurrentDateForFormDate($fieldName, $format = 'm/d/Y')
{
	return old($fieldName) ?: date($format);
}
function getCompanyId()
{
	//  admin.get.revenue-business-line
	return Request()->segment(2);
}

function getExportFormat()
{
	return
		[
			[
				'title' => __('Excel'),
				'value' => 'Xlsx'
			],
			[
				'title' => __('PDF'),
				'value' => 'Dompdf'
			]

		];
}
function getDefaultOrderBy(): array
{
	return [
		'column' => 'created_at',
		'direction' => 'desc'
	];
}
function getModelNamespace()
{
	return '\App\Models\\';
}

function generateDatesBetweenTwoDates(Carbon $start_date, Carbon $end_date, $method = 'addMonth', $format = 'Y-m-d', $indexedArray = true, $indexFormat = "Y-m-d")
{
	$dates = [];

	for ($date = $start_date->copy(); $date->lte($end_date); $date->{$method}()) {
		if ($indexedArray) {
			$dates[] = $date->format($format);
		} else {
			$dates[$date->format($indexFormat)] = $date->format($format);
		}
	}
	return $dates;
}
function formatDateFromString(string $date): string
{
	if ($date) {
		return \Carbon\Carbon::make($date)->format(defaultUserDateFormat());
	}

	return __('N/A');
}
function defaultUserDateFormat()
{
	return 'd-M-Y';
	// return 'Y F d';
}
function formatReportDataForDashBoard(string $incomeStatementDurationType, string $incomeStatementStartDate, $data, $start_date, $end_date)
{

	$dates = generateDatesBetweenTwoDates(Carbon::make($start_date), Carbon::make($end_date), 'addMonth');

	$newData = [];

	foreach ($data as $index => $mainItem) {
		foreach ($dates as $date) {
			$mainItemName = $mainItem->name;
			$newData[$mainItemName]['data'][$date] = getTotalInPivotDate($incomeStatementDurationType, $incomeStatementStartDate, $mainItem->withSubItemsFor(
				$mainItem->pivot->financial_statement_able_id,
				$mainItem->pivot->sub_item_type
			)->get()->pluck('pivot'), $date, $dates);
		}
		if (isset($mainItemName)) {
			// withSubItemsFor($mainItem->pivot->financial_statement_able_id,$subItemType)
			$newData[$mainItemName]['sub_items'] = getSubItemsFormatted($mainItem->withSubItemsFor(
				$mainItem->pivot->financial_statement_able_id,
				$mainItem->pivot->sub_item_type
			)->get()->pluck('pivot'), $dates, $incomeStatementStartDate, $incomeStatementDurationType);
			$newData[$mainItemName]['name'] = $mainItemName;
		}
	}
	return $newData;
}
function getSubItemsFormatted($data, $dates, string $incomeStatementStartDate, string $incomeStatementDurationType): array
{
	$subItems = [];
	foreach ($data as $pivot) {
		$subItemName = $pivot->sub_item_name;
		$payload = $pivot->payload ? (array)json_decode($pivot->payload) : null;
		if ($payload) {
			$subItems[$subItemName] = array_sum_conditional($payload, $dates, $incomeStatementStartDate, $incomeStatementDurationType);
		} else {
			$subItems[$subItemName] = 0;
		}
	}
	return $subItems;
}
function yearInArray(string $date, array $dates)
{

	$year = explode('-', $date)[0];
	foreach ($dates as $newDate) {
		if (explode('-', $newDate)[0] == $year) {
			return true;
		}
		//  ;
	}
	return false;
}
function yearAndMonthInArray(string $date, array $dates)
{
	$year = explode('-', $date)[0];
	$month = explode('-', $date)[1];
	foreach ($dates as $newDate) {
		if (explode('-', $newDate)[0] == $year && $month == explode('-', $newDate)[1]) {
			return true;
		}
		//  ;
	}
	return false;
}
function array_sum_conditional($data, $dates, $incomeStatementStartDate, $incomeStatementDurationType)
{
	$incomeStatementStartDate = Carbon::make($incomeStatementStartDate);

	$total = 0;
	foreach ($data as $date => $value) {
		if ($incomeStatementDurationType == 'annually') {

			if (yearInArray($date, $dates)) {
				$total += $value;
			}
		} else {
			if (yearAndMonthInArray($date, $dates)) {
				$total += $value;
			}
		}
	}

	return $total;
}
function inDurationDate(string $date, $dates, $incomeStatementDurationType)
{
	if ($incomeStatementDurationType == 'annually') {
		return yearInArray($date, $dates);
	}
	return yearAndMonthInArray($date, $dates);
}
function getTotalInPivotDate(string $incomeStatementDurationType, string $incomeStatementStartDate, $pivot, $date, $dates): array
{
	// 1-1-2021

	// 2/1/2021
	$totalWithDepreciation = 0;
	$totalDepreciation = 0;
	$incomeStatementStartDate = Carbon::make($incomeStatementStartDate);

	// 2023
	if (inDurationDate($date, $dates, $incomeStatementDurationType)) {
		foreach ($pivot as $data) {
			$formattedDate = explode('-', $date)[0] . '-' .  explode('-', $date)[1] . '-' . sprintf("%02d", $incomeStatementStartDate->day);
			$payload = $data->payload ? (array)json_decode($data->payload) : null;
			if ($payload && isset($payload[$formattedDate]) && $payload[$formattedDate]) {
				$totalWithDepreciation += $payload[$formattedDate];
				if ($data->is_depreciation_or_amortization) {
					$totalDepreciation += $payload[$formattedDate];
				}
			}
		}
	}

	return [
		'total_with_depreciation' => $totalWithDepreciation,
		'total_depreciation' => $totalDepreciation
	];
}
// function formatDataForBreakDown($array)
// {
//     $data = [];
//     foreach($array as $key => $values){
//         foreach($values as $date => $value){
//             $data[] = [
//                 'gr_date'=>$date,
//                 'net_sales_value'=>$value ,
//                 'zone'=>$key
//             ];
//         }
//     }
//     return $data ;
// }
function get_total_for_group_by_key(array $data, string $key): array
{
	$totalWithDepreciation = 0;
	$totalDepreciation = 0;
	foreach ($data as $obj) {

		if ($obj['name'] == $key) {
			$totalWithDepreciation += array_sum(array_column($obj['data'], 'total_with_depreciation'));
			$totalDepreciation += array_sum(array_column($obj['data'], 'total_depreciation'));
		}
	}

	return [
		'total_with_depreciation' => $totalWithDepreciation,
		'total_depreciation' => $totalDepreciation
	];
}
function format_for_chart($array)
{
	$formattedData  = [];
	foreach ($array as $key => $data) {
		$formattedData[] = [
			'item' => $key,
			'Sales Value' => $data
		];
	}
	return $formattedData;
}
function getIncomeStatementForCompany(int $companyId): Collection
{
	return IncomeStatement::where('company_id', $companyId)->get();
}
function isProduction()
{
	return env('APP_ENV') == 'production';
}
function dateIsBetweenTwoDates(Carbon $date, Carbon $firstDate, Carbon $secondDate)
{
	return $date->isBetween($firstDate, $secondDate);
}
function combineTwoArrayKeys(array $firstArray, array $secondArray)
{
	$combinedArray = [];
	foreach ($firstArray as $key1 => $val1) {
		foreach ($secondArray as $key2 => $val2) {
			$combinedArray[$key1] = $key1;
			$combinedArray[$key2] = $key2;
		}
	}

	return $combinedArray;
}
function getYearsFromDate(array $data)
{
	$years = [];
	foreach ($data as $name => $values) {
		foreach ($values as $dateString => $value) {
			$year = Carbon::make($dateString)->year;
			$years[$year] = $year;
		}
	}
	return $years;
}
function getDataOfYear($data, $year): array
{
	$dataOfYear = [];
	foreach ($data as $currentDate => $currentValue) {
		if (Carbon::make($currentDate)->year == $year) {
			$dataOfYear[] = $currentValue;
		}
	}
	return $dataOfYear;
}
function sum_each_key($array)
{
	$sumForEachItem = [];
	foreach ($array as $key => $values) {
		$sumForEachItem[$key] = array_sum($values);
	}
	return $sumForEachItem;
}

function secondIntervalGreaterThanFirst(string $firstIntervalDates, string $secondIntervalDates)
{
	$secondSegmentOfFirstDate = explode('/', $firstIntervalDates)[1];
	$secondSegmentOfSecondDate = explode('/', $secondIntervalDates)[1];
	return Carbon::make($secondSegmentOfFirstDate)->greaterThan($secondSegmentOfSecondDate);
}
function getIntervalFromString(string $str): string
{
	$firstDate = explode('/', explode('#', $str)[1] ?? '')[0];
	$secondDate = explode('/', explode('#', $str)[1] ?? '')[1];

	return Carbon::make($firstDate)->format('M\'Y') . '/' . Carbon::make($secondDate)->format('M\'Y');
}
function sum_all_keys(array $items)
{
	$total = 0;
	foreach ($items as $itemValue) {
		$total += $itemValue;
	}
	return $total;
}
function getIntervals(array $items)
{
	$firstItem = array_key_first($items);
	return count($items[$firstItem]) ? array_keys($items[$firstItem]) : [];
}
function getSubItemsNames($items)
{
	$subItems = [];
	foreach ($items as $intervalName => $item) {
		foreach ($item as $key => $val) {

			$subItems[$key][$intervalName] = $val;
		}
	}
	return $subItems;
}
function getMonthOfDate(string $date)
{
	return explode('-', $date)[1];
}
function getYearOfDate(string $date)
{
	return explode('-', $date)[0];
}
function addLastMonthOfInterval(array $dates, string $quarterName, string $endMonthOfDate, string $endYearOfDate)
{
	$endMonthOfQuarterMonth = getMainMonthsForInterval($quarterName)[$endMonthOfDate];
	$formattedDate = $endYearOfDate . '-' . $endMonthOfQuarterMonth . '-' . '01';
	$dates[$formattedDate] = Carbon::make($formattedDate)->format('M\'Y');
	return $dates;
}
function getMainMonthsForInterval(string $quarterName): array
{

	return [
		'quarterly' => [
			"01" => "03",
			"02" => "03",
			"04" => "06",
			"05" => "06",
			"07" => "09",
			'08' => "09",
			"10" => "12",
			"11" => "12"
		],
		'semi-annually' => [
			"01" => "06",
			"02" => "06",
			"03" => "06",
			"04" => "06",
			"05" => "06",
			"07" => "12",
			"08" => "12",
			"09" => "12",
			"10" => "12",
			"11" => "12"
		]
	][$quarterName];
}
function formatDateIntervalFor(array $dates, string $quarterName)
{

	if (!in_array($quarterName, ['quarterly', 'semi-annually'])) {
		throw new Exception(__('Not Support Quarterly Name , Only Quarterly Or Semi Annually Allowed'));
	}
	$endMonthOfDates = getMonthOfDate(array_key_last($dates));
	$endYearOfDates = getYearOfDate(array_key_last($dates));
	$mainMonthsOfInterval = getMainMonthsForInterval($quarterName);

	if (!in_array($endMonthOfDates, $mainMonthsOfInterval)) {
		$dates = addLastMonthOfInterval($dates, $quarterName, $endMonthOfDates, $endYearOfDates);
	}
	return removeAdditionalMonthsOfInterval($dates, $quarterName, $mainMonthsOfInterval);
}
function removeAdditionalMonthsOfInterval(array $dates, string $quarterName, array $mainMonthsOfInterval)
{
	$newDates = [];
	foreach ($dates as $date => $dateFormatted) {
		if (in_array(explode('-', $date)[1], $mainMonthsOfInterval)) {
			$newDates[$date] = $dateFormatted;
		}
	}
	return $newDates;
}
function getArrayValuesFromIndex(array $array, int $index)
{
	$newArray = [];
	foreach ($array as $currentItemIndex => $item) {
		if ($currentItemIndex >= $index) {
			$newArray[$currentItemIndex] = $item;
		}
	}
	return $newArray;
}
function getIntervalForSelect(string $intervalName)
{
	$index = 0;
	$intervalsFormattedForSelect = getDurationIntervalTypesForSelect();
	foreach ($intervalsFormattedForSelect as $intervalArray) {
		if ($intervalArray['value'] != $intervalName) {
			$index++;
		}
		break;
	}
	return getArrayValuesFromIndex($intervalsFormattedForSelect, $index);
}
function getDurationIntervalTypesForSelect(): array
{
	return [
		[
			'value' => 'monthly',
			'title' => __('Monthly')
		],
		[
			'value' => 'quarterly',
			'title' => __('Quarterly')
		],
		[
			'value' => 'semi-annually',
			'title' => __('Semi Annually')
		],
		[
			'value' => 'annually',
			'title' => __('Annually')
		],
	];
}
function generateNameForFinancialStatementRelations(string $financialStatementName, $relationObject)
{
	if ($relationObject instanceof IncomeStatement) {
		return $financialStatementName . ' Income Statement';
	}
	if ($relationObject instanceof CashFlowStatement) {
		return $financialStatementName . ' Cash Flow Statement';
	}
	if ($relationObject instanceof BalanceSheet) {
		return $financialStatementName . ' Balance Sheet';
	}
	throw new \Exception('Can Not Generate Name For ' . $financialStatementName . ' Only Allowed [ Income Statement , Cash Flow And Balance Sheet ] Objects');
}
function getLastSegmentFromString(string $string, string $separator = '\\')
{
	$explodedString = explode($separator, $string);
	$countExplodedStringSegments = count($explodedString);
	if (!$countExplodedStringSegments) {
		throw new Exception('Invalid String Or Separator');
	}
	return $explodedString[$countExplodedStringSegments - 1];
}
function getReportNameFromRouteName(string $routeName): string
{
	$explodedRouteName = explode('.', $routeName);
	return $explodedRouteName[count($explodedRouteName) - 2];
}
function getDeleteSubItemsFor(string $subItem): array
{
	if ($subItem == 'forecast') {
		return getAllFinancialAbleTypes();
	} elseif ($subItem == 'actual') {
		return getAllFinancialAbleTypes(['forecast']);
	}
	return [$subItem];
}
function getAllFinancialAbleTypes(array $exclude = []): array
{
	$allTypes = ['forecast', 'actual', 'adjusted', 'modified'];
	$types = [];
	foreach ($allTypes as $type) {
		if (!in_array($type, $exclude)) {
			$types[] = $type;
		}
	}
	return $types;
}
function getDatedOf(array $first, array $second): array
{
	$firstArrayDates = array_keys($first);
	$secondArrayDates = array_keys($second);
	$dates = array_merge($firstArrayDates, $secondArrayDates);
	$dates = array_unique($dates);
	sort($dates);
	return $dates;
}
function combineNoneZeroValues(array $first, array $second): array
{
	$combined = [];
	$dates = getDatedOf($first, $second);
	foreach ($dates as $date) {
		$firstVal = $first[$date] ?? 0;
		$combined[$date] = isset($second[$date]) && $second[$date] != 0 ? $second[$date] : $firstVal;
	}
	return $combined;
}
function getAccountsToSentExceptionsFor(): array
{
	return [
		'ahmedconan17@yahoo.com'
	];
}
function getProductsItemsQuantity($companyId)
{
	return QuantityProductSeasonality::where('company_id', $companyId)->get();
}
function getNumberOfProductsItemsQuantity($companyId)
{
	return QuantityProductSeasonality::where('company_id', $companyId)->count();
}
function canShowNewItemsProductsQuantity($companyId)
{
	return  getNumberOfProductsItemsQuantity($companyId);
}
