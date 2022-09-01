<?php

use App\Http;
use App\Http\Controllers\Analysis\SalesGathering\SalesBreakdownAgainstAnalysisReport;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DeleteAllRowsFromCaching;
use App\Http\Controllers\DeleteMultiRowsFromCaching;
use App\Http\Controllers\getUploadPercentage;
use App\Http\Controllers\RemoveCompanycontroller;
use App\Http\Controllers\RemoveUsercontroller;
use App\Http\Controllers\RoutesDefinition;
use App\Http\Livewire\AdjustedCollectionDatesForm;
use App\Models\Branch;
use App\Models\CachingCompany;
use App\Models\Company;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware([])->group(function(){

    
Route::any('FreeUserSubscription','UserController@freeSubscription')->name('free.user.subscription');
Auth::routes();
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () {
        
        Route::post('get-net-sales-for-type/'  , [SalesBreakdownAgainstAnalysisReport::class , 'getNetSalesValueSum'])->name('get.net.sales.modal.for.type');
        Route::post('getTopAndBottomsForDashboard' , [SalesBreakdownAgainstAnalysisReport::class , 'topAndBottomsForDashboard'])->name('getTopAndBottomsForDashboard');

        
        Route::post('remove-user' , [RemoveUsercontroller::class ,'__invoke'])->name('remove.user');
        Route::post('remove-company' , [RemoveCompanycontroller::class ,'__invoke'])->name('remove.company');
        Route::get('/client', function () {
            return view('client_view.supplier_invoices.form');
        });

        Route::resource('section', 'SectionController');
        Route::resource('companySection', 'CompanyController');
        Route::resource('user', 'UserController');
        Route::resource('deduction', 'DeductionController');
        Route::resource('toolTipData', 'ToolTipDataController');



        // Route::resource('Roles&Permissions', 'RolesAndPermissionsController');
        Route::group(['prefix'=>'RolesPermissions/{scope}/','as'=>'roles.permissions.'] ,function () {
            Route::get('/index', 'RolesAndPermissionsController@index')->name('index');
            Route::get('/create', 'RolesAndPermissionsController@create')->name('create');
            Route::post('/store', 'RolesAndPermissionsController@store')->name('store');
            Route::get('/edit/{role}', 'RolesAndPermissionsController@edit')->name('edit');
            Route::post('/update/{role}', 'RolesAndPermissionsController@update')->name('update');
        });
        Route::get('toolTipSectionsFields/{id}', 'ToolTipDataController@sectionFields')->name('section.fields');

        ############ Client View ############
        Route::get('/', 'HomeController@index')->name('home');


        Route::prefix('{company}')->group(function () {

            //Ajax
            Route::post('get/ZoneZonesData/', 'Analysis\SalesGathering\ZoneAgainstAnalysisReport@ZonesData')->name('get.zones.data');
            Route::get('get/viewData/', 'Analysis\SalesGathering\ZoneAgainstAnalysisReport@dataView')->name('get.view.data');
            Route::get('checkIfJobFinished', 'SalesGatheringTestController@activeJob')->name('active.job');

            Route::get('/redirect', 'HomeController@redirectFun')->name('home.redirect');
            ############ Dashboard ############
            Route::get('/companyGroup', 'HomeController@companyGroup')->name('company.group');
            Route::any('Admin_Company','CompanyController@adminCompany')->name('admin.company');
            Route::any('Edit_Admin_Company/{companySection}','CompanyController@editAdminCompany')->name('edit.admin.company');

            ############ Dashboards Links ############
            Route::prefix('/dashboard')->group(function () {
                
                Route::any('/', 'HomeController@dashboard')->name('dashboard');
                Route::get('/HomePage', 'HomeController@welcomePage')->name('viewHomePage');
                Route::any('/breakdown', 'HomeController@dashboardBreakdownAnalysis')->name('dashboard.breakdown');
                Route::any('/customers', 'HomeController@dashboardCustomers')->name('dashboard.customers');
                Route::any('/salesPerson', 'HomeController@dashboardSalesPerson')->name('dashboard.salesPerson');
                Route::any('/salesDiscount', 'HomeController@dashboardSalesDiscount')->name('dashboard.salesDiscount');
                Route::any('/intervalComparing', 'HomeController@dashboardIntervalComparing')->name('dashboard.intervalComparing');
            });


            ############ Import Routs ############
            Route::any('inventoryStatementImport', 'InventoryStatementTestController@import')->name('inventoryStatementImport');
            Route::get('inventoryStatement/insertToMainTable', 'InventoryStatementTestController@insertToMainTable')->name('inventoryStatementTest.insertToMainTable');
            Route::any('salesGatheringImport', 'SalesGatheringTestController@import')->name('salesGatheringImport');
            Route::get('SalesGathering/insertToMainTable', 'SalesGatheringTestController@insertToMainTable')->name('salesGatheringTest.insertToMainTable');




            ############ Export Routes ############
            Route::get('inventoryStatement/export', 'InventoryStatementController@export')->name('inventoryStatement.export');
            Route::get('salesGathering/export', 'SalesGatheringController@export')->name('salesGathering.export');



            // ->parameters(['name-of-route'=> inventoryStatement [dependancies injection of model]])

            ############ test table for uploading ############
            Route::resource('inventoryStatementTest', InventoryStatementTestController::class)
            ->only(['edit', 'update', 'destroy']);
            Route::resource('salesGatheringTest', SalesGatheringTestController::class)
            ->only(['edit', 'update', 'destroy']);

            ############ Sections Resources ############

            Route::resource('inventoryStatement', InventoryStatementController::class);
            Route::resource('salesGathering', SalesGatheringController::class);

            ############  (TRUNCATE) ############
            Route::get('Truncate/{model}','DeletingClass@truncate')->name('truncate');
            Route::delete('DeleteMultipleRows/{model}','DeletingClass@multipleRowsDeleting')->name('multipleRowsDelete');






            ############ Inventory Links ############
            Route::prefix('/Inventory')->group(function () {
                Route::get('/EndBalanceAnalysis/View', 'Analysis\Inventory\EndBalanceAnalysisReport@index')->name('end.balance.analysis');
                Route::post('/EndBalanceAnalysis/Result', 'Analysis\Inventory\EndBalanceAnalysisReport@result')->name('end.balance.analysis.result');

            });
            Route::prefix('/SalesGathering')->group(function () {
                Route::get('SalesTrendAnalysis','AnalysisReports@salesAnalysisReports')->name('sales.trend.analysis');
                Route::get('SalesBreakdownAnalysis','AnalysisReports@salesAnalysisReports')->name('sales.breakdown.analysis');

                ############ Average Prices Post Link ############
                Route::post('/AveragePrices/Result', 'Analysis\SalesGathering\AveragePricesReport@result')->name('averagePrices.result');
                ############ Breakdown Post Link ############
                Route::post('/SalesBreakdownAnalysis/Result', 'Analysis\SalesGathering\SalesBreakdownAgainstAnalysisReport@salesBreakdownAnalysisResult')->name('salesBreakdown.analysis.result');
                Route::post('/SalesDiscountSalesBreakdownAnalysis/Result', 'Analysis\SalesGathering\SalesBreakdownAgainstAnalysisReport@discountsSalesBreakdownAnalysisResult')->name('salesBreakdown.salesDiscounts.analysis.result');
                ############ Two Dimensional Breakdown Post Link ############
                Route::post('/TwoDimensionalBreakdown', 'Analysis\SalesGathering\TwodimensionalSalesBreakdownAgainstAnalysisReport@result')->name('TwoDimensionalBreakdown.result');
                Route::post('/DiscountsAnalysisResult', 'Analysis\SalesGathering\DiscountsAnalysisReport@result')->name('discounts.analysis.result');

                   ############ Two Dimensional Breakdown Ranking Post Link ############
                Route::post('/TwoDimensionalBreakdownRanking', 'Analysis\SalesGathering\TwodimensionalSalesBreakdownAgainstRankingAnalysisReport@result')->name('TwoDimensionalBreakdownRanking.result');
                Route::post('/DiscountsRankingAnalysisResult', 'Analysis\SalesGathering\DiscountsRankingAnalysisReport@result')->name('discounts.Ranking.analysis.result');
                
                    // Providers Two Dimensional Breakdown
                Route::post('/ProvidersTwoDimensionalBreakdown', 'Analysis\SalesGathering\ProvidersTwodimensionalSalesBreakdownAgainstAnalysisReport@result')->name('ProvidersTwoDimensionalBreakdown.result');

                ############ Sales Trend Analysis Links +   Average Prices +  Breakdown ############
                    // For [Zone , Sales Channels , Categories , Products , Product Items , Branches , Business Sectors ,Sales Persons]
                    $routesDefinition= (new RoutesDefinition);
                    $saleTrendRoutes = $routesDefinition->salesTrendAnalysisRoutes();
                    foreach ($saleTrendRoutes as $nameOfMainItem => $info) {
                        if (isset($info['class_path'])) {

                            // Not All Reports Contains Analysis Reports
                            !isset($info['analysis_view'])   ?: Route::get('/'. $nameOfMainItem.'SalesAnalysis/View',  $info['class_path'].'@'.$info['analysis_view'])->name( $info['name'].'.sales.analysis');
                            !isset($info['analysis_result']) ?: Route::post('/'.$nameOfMainItem.'SalesAnalysis/Result',$info['class_path'].'@'.$info['analysis_result'])->name( $info['name'].'.sales.analysis.result');
                            Route::post('/'.$nameOfMainItem.'AgainstAnalysis/Result',  $info['class_path'].'@'.$info['against_result'])->name( $info['name'].'.analysis.result');
                            // Against Reports
                            foreach ($info['sub_items'] as $viewName => $sub_item) {
                                Route::get('/'. $nameOfMainItem.'Against'.$viewName.'Analysis/View',$info['class_path'].'@'.$info['against_view'])->name( $info['name'].'.'.$sub_item.'.analysis');
                            }
                            Route::post('/'.$nameOfMainItem.'AgainstSalesDiscountAnalysis/Result',  $info['class_path'].'@'.$info['discount_result'])->name( $info['name'].'.salesDiscount.analysis.result');
                            // Average Prices Links
                            if (isset($info['avg_items'])) {
                                foreach ($info['avg_items'] as $viewName => $avg_item) {
                                    Route::get('/'. $nameOfMainItem.$viewName.'AveragePricesView',$info['class_path'].'@'.$info['against_view'])->name( $info['name'].'.'.$avg_item.'.averagePrices');
                                }
                            }
                        }
                        // Discounts
                        ($info['has_discount'] === false) ?: Route::get('/'. $nameOfMainItem.'VSDiscounts/View', 'Analysis\SalesGathering\DiscountsAnalysisReport@index')->name($info['name'].'.vs.discounts.view');
                        ($info['has_break_down'] === false) ?: Route::get('/'. $nameOfMainItem.'SalesBreakdownAnalysis/View', 'Analysis\SalesGathering\SalesBreakdownAgainstAnalysisReport@salesBreakdownAnalysisIndex')->name('salesBreakdown.'.$info['name'].'.analysis');

                    }

                ############ Two Dimensional Breakdown ############
                    $twoDimentionsRoutes = $routesDefinition->twoDimensionalBreakdownRoutes();
                    foreach ($twoDimentionsRoutes as $nameOfMainItem => $info) {
                        foreach ($info['sub_items'] as $viewName => $sub_item) {
                            if (isset($info['is_provider']) && $info['is_provider'] === true) {

                                Route::get('/' .$nameOfMainItem.'VS' .$viewName. '/View', 'Analysis\SalesGathering\ProvidersTwodimensionalSalesBreakdownAgainstAnalysisReport@index')->name( $info['name'].'.vs.'.$sub_item.'.view');
                            }else{
                                Route::get('/' .$nameOfMainItem.'VS' .$viewName. '/View', 'Analysis\SalesGathering\TwodimensionalSalesBreakdownAgainstAnalysisReport@index')->name( $info['name'].'.vs.'.$sub_item.'.view');
                            }
                        }
                    }


                    ############ Two Dimensional Ranking ############
                    $twoDimentionsRoutes = $routesDefinition->twoDimensionalRankingsRoutes();
                    foreach ($twoDimentionsRoutes as $nameOfMainItem => $info) {
                        // dd($nameOfMainItem , $info['sub_items']);
                         
                        foreach ($info['sub_items'] as $viewName => $sub_item) {
                            if (isset($info['is_provider']) && $info['is_provider'] === true) {
// dd($viewName);
                                // Route::get('/' .$nameOfMainItem.'VS' .$viewName. '/View', 'Analysis\SalesGathering\ProvidersTwodimensionalSalesBreakdownAgainstAnalysisReport@index')->name( $info['name'].'.vs.'.$sub_item.'.view');
                            }else{
                                // dd($info['name'].'.vs.'.$sub_item.'Ranking'.'.view');
                                Route::get('/' .$nameOfMainItem.'VS' .$viewName.'Ranking'. '/View', 'Analysis\SalesGathering\TwodimensionalSalesBreakdownAgainstRankingAnalysisReport@index')->name( $info['name'].'.vs.'.$sub_item.'Ranking'.'.view');
                            }
                        }
                    }

                ############ Sales Report ############
                    Route::get('/SalesReport/View', 'Analysis\SalesGathering\salesReport@index')->name('salesReport.view');
                    Route::post('/SalesReport/Result', 'Analysis\SalesGathering\salesReport@result')->name('salesReport.result');




                // Comparing Analysis
                    Route::post('/Comparing/Result', 'Analysis\SalesGathering\IntervalsComparingReport@result')->name('intervalComparing.analysis.result');
                    Route::post('/SalesDiscountComparing/Result', 'Analysis\SalesGathering\IntervalsComparingReport@discountsComparingResult')->name('intervalComparing.salesDiscounts.analysis.result');
                    //Zones
                    Route::get('/ZonesComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.zone.analysis');
                    // Sales Channels
                    Route::get('/SalesChannelsComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.salesChannels.analysis');
                    // Customers
                    Route::get('/CustomersComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.customers.analysis');
                    // Business Sectors
                    Route::get('/BusinessSectorsComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.businessSectors.analysis');
                    // Branches
                    Route::get('/BranchesComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.branches.analysis');
                    // Categories
                    Route::get('/CategoriesComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.categories.analysis');
                    // Products
                    Route::get('/ProductsComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.products.analysis');
                    //Items
                    Route::get('/ProductItemsComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.Items.analysis');
                    // SalesPersons
                    Route::get('/SalesPersonsComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.salesPersons.analysis');
                    // SalesDiscount
                    Route::get('/SalesDiscountComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.salesDiscounts.analysis');
                    // Principles
                    Route::get('/PrinciplesComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.principles.analysis');
                    // service_provider_name
                    Route::get('/ServiceProvidersComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.serviceProviders.analysis');
                    // serviceProvidersType
                    Route::get('/ServiceProvidersTypeComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.serviceProvidersType.analysis');
                    // serviceProvidersBirthYear
                    Route::get('/ServiceProvidersBirthYearComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.serviceProvidersBirthYear.analysis');
                    //Countries
                    Route::get('/CountriesComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.country.analysis');
                /////////////////////////////////////////////////////////////////////////


                // Customers Nature
                    Route::post('/CustomersNaturesAnalysis/Result', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@result')->name('customersNatures.analysis.result');
                    Route::post('/CustomersNaturesAnalysisTwoDimensional/Result', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@twoDimensionalResult')->name('customersNatures.twoDimensional.analysis.result');
                    Route::get('/CustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('customersNatures.analysis');
                    Route::get('/ZonesVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('zones.vs.customersNatures');
                    Route::get('/SalesChannelsVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('salesChannels.vs.customersNatures');
                    Route::get('/BusinessSectorsVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('businessSectors.vs.customersNatures');
                    Route::get('/BranchesVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('branches.vs.customersNatures');
                    Route::get('/CategoriesVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('categories.vs.customersNatures');
                    Route::get('/ProductsServicesVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('products.vs.customersNatures');
                    Route::get('/ProductItemsVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('Items.vs.customersNatures');
                    Route::get('/CountriesVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('countries.vs.customersNatures');
                /////////////////////////////////////////////////////////////////////////
                // Sales Forecast
                Route::any('/SalesForecast', 'SalesForecastReport@result')->name('sales.forecast');
                Route::post('/SalesForecast/save', 'SalesForecastReport@save')->name('sales.forecast.save');
                Route::any('/NewCategories', 'SalesForecastReport@createCategories')->name('categories.create');
                Route::any('/NewProducts', 'SalesForecastReport@createProducts')->name('products.create');
                Route::any('/ProductsSeasonality', 'SalesForecastReport@productsSeasonality')->name('products.seasonality');
                Route::any('/ProductsSalesTargets', 'SalesForecastReport@productsSalesTargets')->name('products.sales.targets');
                Route::any('/ProductsAllocations', 'SalesForecastReport@productsAllocations')->name('products.allocations');

                // Seasonality
                Route::get('/ModifiedSeasonality', 'SeasonalityReport@modifySeasonality')->name('modify.seasonality');
                Route::post('/SaveModifiedSeasonality', 'SeasonalityReport@saveSeasonality')->name('save.modify.seasonality');

                // First Allocation
                Route::any('/Allocations', 'AllocationsReport@allocationSettings')->name('allocations');
                Route::any('/NewProductsAllocations', 'AllocationsReport@NewProductsAllocationBase')->name('new.product.allocation.base');
                Route::any('/ExistingProductsAllocations', 'AllocationsReport@existingProductsAllocationBase')->name('existing.products.allocations');
                Route::any('/NewProductsSeasonality', 'AllocationsReport@NewProductsSeasonality')->name('new.product.seasonality');
                // Second Allocation
                Route::any('/SecondAllocations', 'SecondAllocationsReport@allocationSettings')->name('second.allocations');
                Route::any('/SecondNewProductsAllocations', 'SecondAllocationsReport@NewProductsAllocationBase')->name('second.new.product.allocation.base');
                Route::any('/SecondExistingProductsAllocations', 'SecondAllocationsReport@existingProductsAllocationBase')->name('second.existing.products.allocations');
                Route::any('/SecondNewProductsSeasonality', 'SecondAllocationsReport@NewProductsSeasonality')->name('second.new.product.seasonality');
                // Collection
                Route::any('/Collection', 'CollectionController@collectionSettings')->name('collection.settings');
                Route::any('/CollectionReport', 'CollectionController@collectionReport')->name('collection.report');
                //  Summary
                Route::any('/SummaryReport', 'SummaryController@forecastReport')->name('forecast.report');
                Route::any('/goToSummaryReport', 'SummaryController@goToSummaryReport')->name('go.to.summary.report');
                Route::any('/BreakdownSummaryReport', 'SummaryController@breakdownForecastReport')->name('breakdown.forecast.report');
                Route::any('/CollectionSummaryReport', 'SummaryController@collectionForecastReport')->name('collection.forecast.report');


                /////////////////////////////////////////////////////////////////////////

            });



            Route::resource('adjustedCollectionDate', AdjustedCollectionDateController::class);


            ############ Exportable Fields Selection Routes ############
            Route::get('fieldsToBeExported/{model}/{view}', 'ExportTable@customizedTableField')->name('table.fields.selection.view');
            Route::post('fieldsToBeExportedSave/{model}/{view}', 'ExportTable@customizedTableFieldSave')->name('table.fields.selection.save');


        });











        ############ Live Wire ########
        // Route::get('/post', AdjustedCollectionDatesForm::class)->name('adjusted_collection.view');
        // Route::any('adjusted_collection_view', AdjustedCollectionDatesForm::class)->name('adjusted_collection.view');

        Route::post('/adjusted_collection_view', [AdjustedCollectionDatesForm::class, 'render']);
    }
);


    
});

Route::delete('deleteMultiRowsFromCaching/{company}'  , [DeleteMultiRowsFromCaching::class , '__invoke'])->name('deleteMultiRowsFromCaching');
Route::get('deleteAllRowsFromCaching/{company}'  , [DeleteAllRowsFromCaching::class , '__invoke'])->name('deleteAllCaches');
Route::post('get-uploading-percentage/{companyId}' , [getUploadPercentage::class , '__invoke']);
