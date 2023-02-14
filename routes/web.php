<?php


use App\Http;
use App\Http\Controllers\Analysis\SalesGathering\SalesBreakdownAgainstAnalysisReport;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\CalculatedIrrController;
use App\Http\Controllers\CashFlowStatementController;
use App\Http\Controllers\DeleteAllRowsFromCaching;
use App\Http\Controllers\DeleteMultiRowsFromCaching;
use App\Http\Controllers\FilterMainTypeBasedOnDatesController;
use App\Http\Controllers\FinancialStatementController;
use App\Http\Controllers\getUploadPercentage;
use App\Http\Controllers\Helpers\DeleteSingleRecordController;
use App\Http\Controllers\Helpers\EditTableCellsController;
use App\Http\Controllers\IncomeStatementController;
use App\Http\Controllers\InventoryStatementController;
use App\Http\Controllers\InventoryStatementTestController;
use App\Http\Controllers\RemoveCompanycontroller;
use App\Http\Controllers\RemoveUsercontroller;
use App\Http\Controllers\RoutesDefinition;
use App\Http\Controllers\SalesGatheringController;
use App\Http\Controllers\SalesGatheringTestController;
use App\Http\Livewire\AdjustedCollectionDatesForm;
use App\Models\Branch;
use App\Models\CachingCompany;
use App\Models\Company;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
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



Route::middleware([])->group(function () {


	Route::any('FreeUserSubscription', 'UserController@freeSubscription')->name('free.user.subscription');
	Auth::routes();
	Route::group(
		[
			'prefix' => LaravelLocalization::setLocale(),
			'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
		],
		function () {

			Route::post('get-net-sales-for-type/', [SalesBreakdownAgainstAnalysisReport::class, 'getNetSalesValueSum'])->name('get.net.sales.modal.for.type');
			Route::post('getTopAndBottomsForDashboard', [SalesBreakdownAgainstAnalysisReport::class, 'topAndBottomsForDashboard'])->name('getTopAndBottomsForDashboard');


			Route::post('remove-user', [RemoveUsercontroller::class, '__invoke'])->name('remove.user');
			Route::post('remove-company', [RemoveCompanycontroller::class, '__invoke'])->name('remove.company');
			Route::get('/client', function () {
				return view('client_view.supplier_invoices.form');
			});

			Route::resource('section', 'SectionController');
			Route::resource('companySection', 'CompanyController');
			Route::resource('user', 'UserController');
			Route::resource('deduction', 'DeductionController');
			Route::resource('toolTipData', 'ToolTipDataController');



			// Route::resource('Roles&Permissions', 'RolesAndPermissionsController');
			Route::group(['prefix' => 'RolesPermissions/{scope}/', 'as' => 'roles.permissions.'], function () {
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
				Route::post('get-type-based-on-dates', [FilterMainTypeBasedOnDatesController::class, '__invoke'])->name('get.type.based.on.dates');

				Route::get('income-statement', [IncomeStatementController::class, 'view'])->name('admin.view.income.statement');
				Route::get('income-statement/create', [IncomeStatementController::class, 'create'])->name('admin.create.income.statement');
				Route::get('income-statement-report/{incomeStatement}/edit', [IncomeStatementController::class, 'editItems']);
				Route::post('income-statement/{incomeStatement}/update', [IncomeStatementController::class, 'update'])->name('admin.update.income.statement');
				Route::post('income-statement/store', [IncomeStatementController::class, 'store'])->name('admin.store.income.statement');
				Route::get('export-income-statement', 'IncomeStatementController@export')->name('admin.export.income.statement');
				Route::get('get-income-statement', 'IncomeStatementController@paginate')->name('admin.get.income.statement');
				Route::get('income-statement/{incomeStatement}/actual-report', [IncomeStatementController::class, 'createReport'])->name('admin.create.income.statement.actual.report');

				// actual.report the first segment represent type so do not change it
				Route::get('income-statement/{incomeStatement}/actual-report', [IncomeStatementController::class, 'createReport'])->name('admin.create.income.statement.actual.report');

				// forecast.report the first segment represent type so do not change it
				Route::get('income-statement/{incomeStatement}/forecast-report', [IncomeStatementController::class, 'createReport'])->name('admin.create.income.statement.forecast.report');
				// adjusted.report the first segment represent type so do not change it

				Route::get('income-statement/{incomeStatement}/adjusted-report', [IncomeStatementController::class, 'createReport'])->name('admin.create.income.statement.adjusted.report');

				Route::get('income-statement/{incomeStatement}/modified-report', [IncomeStatementController::class, 'createReport'])->name('admin.create.income.statement.modified.report');

				Route::post('income-statement-report/update', [IncomeStatementController::class, 'updateReport'])->name('admin.update.income.statement.report');
				Route::post('income-statement-report/delete', [IncomeStatementController::class, 'deleteReport'])->name('admin.destroy.income.statement.report');
				Route::post('income-statement/storeReport', [IncomeStatementController::class, 'storeReport'])->name('admin.store.income.statement.report');
				Route::post('export-income-statement-report', 'IncomeStatementController@exportReport')->name('admin.export.income.statement.report');
				Route::post('get-income-statement-report/{incomeStatement}', 'IncomeStatementController@paginateReport')->name('admin.get.income.statement.report');


				Route::get('balance-sheet', [BalanceSheetController::class, 'view'])->name('admin.view.balance.sheet');
				Route::get('balance-sheet/create', [BalanceSheetController::class, 'create'])->name('admin.create.balance.sheet');
				Route::get('balance-sheet-report/{balanceSheet}/edit', [BalanceSheetController::class, 'editItems']);
				Route::post('balance-sheet/{balanceSheet}/update', [BalanceSheetController::class, 'update'])->name('admin.update.balance.sheet');
				Route::post('balance-sheet/store', [BalanceSheetController::class, 'store'])->name('admin.store.balance.sheet');
				Route::get('export-balance-sheet', 'BalanceSheetController@export')->name('admin.export.balance.sheet');
				Route::get('get-balance-sheet', 'BalanceSheetController@paginate')->name('admin.get.balance.sheet');
				Route::get('balance-sheet/{balanceSheet}/report', [BalanceSheetController::class, 'createReport'])->name('admin.create.balance.sheet.report');
				Route::post('balance-sheet-report/update', [BalanceSheetController::class, 'updateReport'])->name('admin.update.balance.sheet.report');
				Route::post('balance-sheet-report/delete', [BalanceSheetController::class, 'deleteReport'])->name('admin.destroy.balance.sheet.report');
				Route::post('balance-sheet/storeReport', [BalanceSheetController::class, 'storeReport'])->name('admin.store.balance.sheet.report');
				Route::post('export-balance-sheet-report', 'BalanceSheetController@exportReport')->name('admin.export.balance.sheet.report');
				Route::post('get-balance-sheet-report/{balanceSheet}', 'BalanceSheetController@paginateReport')->name('admin.get.balance.sheet.report');




				Route::get('cash-flow-statement', [CashFlowStatementController::class, 'view'])->name('admin.view.cash.flow.statement');
				Route::get('cash-flow-statement/create', [CashFlowStatementController::class, 'create'])->name('admin.create.cash.flow.statement');
				Route::get('cash-flow-statement-report/{balanceSheet}/edit', [CashFlowStatementController::class, 'editItems']);
				Route::post('cash-flow-statement/{cashFlowStatement}/update', [CashFlowStatementController::class, 'update'])->name('admin.update.cash.flow.statement');
				Route::post('cash-flow-statement/store', [CashFlowStatementController::class, 'store'])->name('admin.store.cash.flow.statement');
				Route::get('export-cash-flow-statement', 'CashFlowStatementController@export')->name('admin.export.cash.flow.statement');
				Route::get('get-cash-flow-statement', 'CashFlowStatementController@paginate')->name('admin.get.cash.flow.statement');
				Route::get('cash-flow-statement/{cashFlowStatement}/report', [CashFlowStatementController::class, 'createReport'])->name('admin.create.cash.flow.statement.report');
				Route::post('cash-flow-statement-report/update', [CashFlowStatementController::class, 'updateReport'])->name('admin.update.cash.flow.statement.report');
				Route::post('cash-flow-statement-report/delete', [CashFlowStatementController::class, 'deleteReport'])->name('admin.destroy.cash.flow.statement.report');
				Route::post('cash-flow-statement/storeReport', [CashFlowStatementController::class, 'storeReport'])->name('admin.store.cash.flow.statement.report');
				Route::post('export-cash-flow-statement-report', 'CashFlowStatementController@exportReport')->name('admin.export.cash.flow.statement.report');
				Route::post('get-cash-flow-statement-report/{cashFlowStatement}', 'CashFlowStatementController@paginateReport')->name('admin.get.cash.flow.statement.report');



				Route::get('update-financial-statement-date', [FinancialStatementController::class, 'updateDate'])->name('admin.update.financial.statement.date');
				Route::delete('update-financial-statement-duration-type', [FinancialStatementController::class, 'updateDurationType'])->name('admin.update.financial.statement.duration.type');
				Route::get('financial-statement', [FinancialStatementController::class, 'view'])->name('admin.view.financial.statement');
				Route::get('financial-statement/create', [FinancialStatementController::class, 'create'])->name('admin.create.financial.statement');
				Route::get('financial-statement-report/{financialStatement}/edit', [FinancialStatementController::class, 'editItems']);
				Route::post('financial-statement/{financialStatement}/update', [FinancialStatementController::class, 'update'])->name('admin.update.financial.statement');
				Route::post('financial-statement/store', [FinancialStatementController::class, 'store'])->name('admin.store.financial.statement');
				Route::get('export-financial-statement', 'FinancialStatementController@export')->name('admin.export.financial.statement');

				Route::get('get-financial-statement', 'FinancialStatementController@paginate')->name('admin.get.financial.statement');
				Route::get('financial-statement/{financialStatement}/report', [FinancialStatementController::class, 'createReport'])->name('admin.create.financial.statement.report');
				Route::post('financial-statement-report/update', [FinancialStatementController::class, 'updateReport'])->name('admin.update.financial.statement.report');
				Route::post('financial-statement-report/delete', [FinancialStatementController::class, 'deleteReport'])->name('admin.destroy.financial.statement.report');
				Route::post('financial-statement/storeReport', [FinancialStatementController::class, 'storeReport'])->name('admin.store.financial.statement.report');
				Route::post('export-financial-statement-report', 'FinancialStatementController@exportReport')->name('admin.export.financial.statement.report');
				Route::post('get-financial-statement-report/{financialStatement}', 'FinancialStatementController@paginateReport')->name('admin.get.financial.statement.report');



				Route::post('edit-table-cell', [EditTableCellsController::class, '__invoke'])->name('admin.edit.table.cell');


				//Ajax
				Route::post('get/ZoneZonesData/', 'Analysis\SalesGathering\ZoneAgainstAnalysisReport@ZonesData')->name('get.zones.data');
				Route::get('get/viewData/', 'Analysis\SalesGathering\ZoneAgainstAnalysisReport@dataView')->name('get.view.data');
				Route::get('checkIfJobFinished', 'SalesGatheringTestController@activeJob')->name('active.job');

				Route::get('/redirect', 'HomeController@redirectFun')->name('home.redirect');
				############ Dashboard ############
				Route::get('/companyGroup', 'HomeController@companyGroup')->name('company.group');
				Route::any('Admin_Company', 'CompanyController@adminCompany')->name('admin.company');
				Route::any('Edit_Admin_Company/{companySection}', 'CompanyController@editAdminCompany')->name('edit.admin.company');

				############ Dashboards Links ############
				Route::prefix('/dashboard')->group(function () {

					Route::any('/', 'HomeController@dashboard')->name('dashboard');
					Route::any('/income-statement-revenue-dashboard', 'HomeController@incomeStatementDashboard')->name('income.statement.dashboard');
					Route::get('/HomePage', 'HomeController@welcomePage')->name('viewHomePage');
					Route::any('/breakdown', 'HomeController@dashboardBreakdownAnalysis')->name('dashboard.breakdown');
					Route::any('/income-statement-breakdown-dashboard/{incomeStatement?}', 'HomeController@dashboardBreakdownIncomeStatementAnalysis')->name('dashboard.breakdown.incomeStatement');
					Route::any('/customers', 'HomeController@dashboardCustomers')->name('dashboard.customers');
					Route::any('/salesPerson', 'HomeController@dashboardSalesPerson')->name('dashboard.salesPerson');
					Route::any('/salesDiscount', 'HomeController@dashboardSalesDiscount')->name('dashboard.salesDiscount');
					Route::any('/intervalComparing', 'HomeController@dashboardIntervalComparing')->name('dashboard.intervalComparing');
					Route::any('/incomeStatementIntervalComparing', 'HomeController@dashboardIncomeStatementIntervalComparing')->name('dashboard.intervalComparing.incomeStatement');
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
				Route::get('Truncate/{model}', 'DeletingClass@truncate')->name('truncate');
				Route::delete('DeleteMultipleRows/{model}', 'DeletingClass@multipleRowsDeleting')->name('multipleRowsDelete');
				Route::delete('delete-model', [DeleteSingleRecordController::class, '__invoke'])->name('delete.model');



				############ Inventory Links ############
				Route::prefix('/Inventory')->group(function () {
					Route::get('/EndBalanceAnalysis/View', 'Analysis\Inventory\EndBalanceAnalysisReport@index')->name('end.balance.analysis');
					Route::post('/EndBalanceAnalysis/Result', 'Analysis\Inventory\EndBalanceAnalysisReport@result')->name('end.balance.analysis.result');
				});
				Route::prefix('/SalesGathering')->group(function () {
					Route::get('SalesTrendAnalysis', 'AnalysisReports@salesAnalysisReports')->name('sales.trend.analysis');
					Route::get('SalesBreakdownAnalysis', 'AnalysisReports@salesAnalysisReports')->name('sales.breakdown.analysis');

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
					$routesDefinition = (new RoutesDefinition);
					$saleTrendRoutes = $routesDefinition->salesTrendAnalysisRoutes();
					foreach ($saleTrendRoutes as $nameOfMainItem => $info) {
						if (isset($info['class_path'])) {

							// Not All Reports Contains Analysis Reports
							!isset($info['analysis_view'])   ?: Route::get('/' . $nameOfMainItem . 'SalesAnalysis/View',  $info['class_path'] . '@' . $info['analysis_view'])->name($info['name'] . '.sales.analysis');
							!isset($info['analysis_result']) ?: Route::post('/' . $nameOfMainItem . 'SalesAnalysis/Result', $info['class_path'] . '@' . $info['analysis_result'])->name($info['name'] . '.sales.analysis.result');
							Route::post('/' . $nameOfMainItem . 'AgainstAnalysis/Result',  $info['class_path'] . '@' . $info['against_result'])->name($info['name'] . '.analysis.result');
							// Against Reports
							foreach ($info['sub_items'] as $viewName => $sub_item) {
								Route::get('/' . $nameOfMainItem . 'Against' . $viewName . 'Analysis/View', $info['class_path'] . '@' . $info['against_view'])->name($info['name'] . '.' . $sub_item . '.analysis');
							}
							Route::post('/' . $nameOfMainItem . 'AgainstSalesDiscountAnalysis/Result',  $info['class_path'] . '@' . $info['discount_result'])->name($info['name'] . '.salesDiscount.analysis.result');
							// Average Prices Links
							if (isset($info['avg_items'])) {

								foreach ($info['avg_items'] as $viewName => $avg_item) {

									Route::get('/' . $nameOfMainItem . $viewName . 'AveragePricesView', $info['class_path'] . '@' . $info['against_view'])->name($info['name'] . '.' . $avg_item . '.averagePrices');
								}
							}
						}
						// Discounts
						($info['has_discount'] === false) ?: Route::get('/' . $nameOfMainItem . 'VSDiscounts/View', 'Analysis\SalesGathering\DiscountsAnalysisReport@index')->name($info['name'] . '.vs.discounts.view');
						($info['has_break_down'] === false) ?: Route::get('/' . $nameOfMainItem . 'SalesBreakdownAnalysis/View', 'Analysis\SalesGathering\SalesBreakdownAgainstAnalysisReport@salesBreakdownAnalysisIndex')->name('salesBreakdown.' . $info['name'] . '.analysis');
					}

					############ Two Dimensional Breakdown ############
					$twoDimentionsRoutes = $routesDefinition->twoDimensionalBreakdownRoutes();
					foreach ($twoDimentionsRoutes as $nameOfMainItem => $info) {
						foreach ($info['sub_items'] as $viewName => $sub_item) {
							if (isset($info['is_provider']) && $info['is_provider'] === true) {

								Route::get('/' . $nameOfMainItem . 'VS' . $viewName . '/View', 'Analysis\SalesGathering\ProvidersTwodimensionalSalesBreakdownAgainstAnalysisReport@index')->name($info['name'] . '.vs.' . $sub_item . '.view');
							} else {
								Route::get('/' . $nameOfMainItem . 'VS' . $viewName . '/View', 'Analysis\SalesGathering\TwodimensionalSalesBreakdownAgainstAnalysisReport@index')->name($info['name'] . '.vs.' . $sub_item . '.view');
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
							} else {
								// dd($info['name'].'.vs.'.$sub_item.'Ranking'.'.view');
								Route::get('/' . $nameOfMainItem . 'VS' . $viewName . 'Ranking' . '/View', 'Analysis\SalesGathering\TwodimensionalSalesBreakdownAgainstRankingAnalysisReport@index')->name($info['name'] . '.vs.' . $sub_item . 'Ranking' . '.view');
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

					///////////////////////////////////////////////////////////////////////////////////////////////////////
					// Sales Forecast Quantity

					Route::any('/SalesForecastQuantity', 'QuantitySalesForecastReport@result')->name('sales.forecast.quantity');
					Route::post('/SalesForecastQuantity/save', 'QuantitySalesForecastReport@save')->name('sales.forecast.quantity.save');
					Route::any('/NewCategoriesQuantity', 'QuantitySalesForecastReport@createCategories')->name('categories.quantity.create');
					Route::any('/NewProductsQuantity', 'QuantitySalesForecastReport@createProducts')->name('products.quantity.create');
					Route::any('/ProductsSeasonalityQuantity', 'QuantitySalesForecastReport@productsSeasonality')->name('products.seasonality.quantity');
					Route::any('/ProductsSalesTargetsQuantity', 'QuantitySalesForecastReport@productsSalesTargets')->name('products.sales.targets.quantity');
					Route::any('/ProductsAllocationsQuantity', 'QuantitySalesForecastReport@productsAllocations')->name('products.allocations.quantity');

					// Seasonality
					Route::get('/ModifiedSeasonalityQuantity', 'QuantitySeasonalityReport@modifySeasonality')->name('modify.seasonality.quantity');
					Route::post('/SaveModifiedSeasonalityQuantity', 'QuantitySeasonalityReport@saveSeasonality')->name('save.modify.seasonality.quantity');

					// First Allocation
					Route::any('/AllocationsQuantity', 'QuantityAllocationsReport@allocationSettings')->name('allocations.quantity');
					Route::any('/NewProductsAllocationsQuantity', 'QuantityAllocationsReport@NewProductsAllocationBase')->name('new.product.allocation.base.quantity');
					Route::any('/ExistingProductsAllocationsQuantity', 'QuantityAllocationsReport@existingProductsAllocationBase')->name('existing.products.allocations.quantity');
					Route::any('/NewProductsSeasonalityQuantity', 'QuantityAllocationsReport@NewProductsSeasonality')->name('new.product.seasonality.quantity');
					// Second Allocation
					Route::any('/SecondAllocationsQuantity', 'QuantitySecondAllocationsReport@allocationSettings')->name('second.allocations.quantity');
					Route::any('/SecondNewProductsAllocationsQuantity', 'QuantitySecondAllocationsReport@NewProductsAllocationBase')->name('second.new.product.allocation.base.quantity');
					Route::any('/SecondExistingProductsAllocationsQuantity', 'QuantitySecondAllocationsReport@existingProductsAllocationBase')->name('second.existing.products.allocations.quantity');
					Route::any('/SecondNewProductsSeasonalityQuantity', 'QuantitySecondAllocationsReport@NewProductsSeasonality')->name('second.new.product.seasonality.quantity');
					// Collection
					Route::any('/CollectionQuantity', 'QuantityCollectionController@collectionSettings')->name('collection.settings.quantity');
					Route::any('/CollectionReportQuantity', 'QuantityCollectionController@collectionReport')->name('collection.quantity.report');
					//  Summary
					Route::any('/SummaryReportQuantity', 'QuantitySummaryController@forecastReport')->name('forecast.quantity.report');
					Route::any('/goToQuantitySummaryReport', 'QuantitySummaryController@goToSummaryReport')->name('go.to.summary.quantity.report');
					Route::any('/BreakdownQuantitySummaryReport', 'QuantitySummaryController@breakdownForecastReport')->name('breakdown.forecast.quantity.report');
					Route::any('/CollectionQuantitySummaryReport', 'QuantitySummaryController@collectionForecastReport')->name('collection.forecast.quantity.report');


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

Route::delete('deleteMultiRowsFromCaching/{company}', [DeleteMultiRowsFromCaching::class, '__invoke'])->name('deleteMultiRowsFromCaching');
Route::get('deleteAllRowsFromCaching/{company}', [DeleteAllRowsFromCaching::class, '__invoke'])->name('deleteAllCaches');
// Route::get('delete-cache-last-upload-phase', function (Company $company, Request $request) {
// 	Cache::forget(getCanReloadUploadPageCachingForCompany($company->id));
// })->name('delete.cache.for.last.stash.upload');
Route::post('get-uploading-percentage/{companyId}', [getUploadPercentage::class, '__invoke']);
Route::get('{lang}/remove-company-image/{company}', function ($lang, Company $company) {
	if ($company->getFirstMedia('default')) {
		$company->getFirstMedia('default')->delete();
	}
	return redirect()->back()->with('success', __('Company Image Has Been Deleted Successfully'));
})->name('remove.company.image');


// Route::get('irr', function () {
// 	$yearsAndFreeCash  = [
// 		0 => -5980364,
// 		1 => -12935560,
// 		2 => 72229784,
// 		3 => 21733457,
// 		4 => 340092719,
// 		5 => 1545132872
// 	];
// 	$requiredInvestmentReturn = 25 / 100;
// 	$result = CalculatedIrrController::calculateIrr($yearsAndFreeCash, $requiredInvestmentReturn);
// 	dd($result);
// });
