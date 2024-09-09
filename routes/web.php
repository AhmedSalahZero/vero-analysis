<?php

use App\Http\Controllers\AddNewCustomerController;
use App\Http\Controllers\Analysis\SalesGathering\SalesBreakdownAgainstAnalysisReport;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\CashFlowStatementController;
use App\Http\Controllers\DeleteAllRowsFromCaching;
use App\Http\Controllers\DeleteMultiRowsFromCaching;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FilterMainTypeBasedOnDatesController;
use App\Http\Controllers\FinancialStatementController;
use App\Http\Controllers\getUploadPercentage;
use App\Http\Controllers\Helpers\DeleteSingleRecordController;
use App\Http\Controllers\Helpers\EditTableCellsController;
use App\Http\Controllers\Helpers\getEditFormController;
use App\Http\Controllers\Helpers\HelpersController;
use App\Http\Controllers\Helpers\UpdateBasedOnGlobalController;
use App\Http\Controllers\Helpers\UpdateCitiesBasedOnCountryController;
use App\Http\Controllers\IncomeStatementController;
use App\Http\Controllers\QuickPricingCalculatorController;
use App\Http\Controllers\RemoveCompanycontroller;
use App\Http\Controllers\RemoveUsercontroller;
use App\Http\Controllers\RevenueBusinessLineController;
use App\Http\Controllers\RoutesDefinition;
use App\Http\Controllers\SalesGatheringTestController;
use App\Models\Company;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
            'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'checkIfAccountExpired']
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
            // Route::resource('deduction', 'DeductionController');
            Route::resource('toolTipData', 'ToolTipDataController');

            Route::group(['prefix' => 'RolesPermissions/{scope}/', 'as' => 'roles.permissions.'], function () {
                Route::get('/index', 'RolesAndPermissionsController@index')->name('index');
                Route::get('/create', 'RolesAndPermissionsController@create')->name('create');
                Route::post('/store', 'RolesAndPermissionsController@store')->name('store');
                Route::get('/edit/{role}', 'RolesAndPermissionsController@edit')->name('edit');
                Route::post('/update/{role}', 'RolesAndPermissionsController@update')->name('update');
            });


            
            Route::group(['prefix' => 'userPermissions/{user}/', 'as' => 'user.permissions.'], function () {
                Route::get('/index', 'UsersAndPermissionsController@index')->name('index');
                Route::get('/create', 'UsersAndPermissionsController@create')->name('create');
                Route::post('/store', 'UsersAndPermissionsController@store')->name('store');
                Route::get('/edit', 'UsersAndPermissionsController@edit')->name('edit');
                Route::post('/update', 'UsersAndPermissionsController@update')->name('update');
            });
            Route::get('toolTipSectionsFields/{id}', 'ToolTipDataController@sectionFields')->name('section.fields');
            Route::get('logs', 'LogController@show')->name('admin.show.logs');
            Route::get('logs/{user}', 'LogController@showDetail')->name('admin.show.logs.detail');
            //########### Client View ############
            Route::get('/', 'HomeController@index')->name('home');

            Route::prefix('{company}')->group(function () {
				Route::get('update-currency-account-based-on-currency/{financialInstitution}','UpdateCurrentAccountBasedOnCurrencyController@index')->name('update.current.account.based.on.currency');
                Route::post('save-labeling-data', 'CompanyController@saveLabelingData')->name('save.labeling.item');

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
                Route::post('export-income-statement-report-excel', 'IncomeStatementController@exportReport')->name('admin.export.income.statement.report');
                Route::post('export-income-statement-report-pdf', 'IncomeStatementController@exportReportAsPdf')->name('admin.export.income.statement.report.pdf');
                Route::post('get-income-statement-report/{incomeStatement}', 'IncomeStatementController@paginateReport')->name('admin.get.income.statement.report');

                // balance sheet

                Route::get('balance-sheet', [BalanceSheetController::class, 'view'])->name('admin.view.balance.sheet');
                Route::get('balance-sheet/create', [BalanceSheetController::class, 'create'])->name('admin.create.balance.sheet');
                Route::get('balance-sheet-report/{balanceSheet}/edit', [BalanceSheetController::class, 'editItems']);
                Route::post('balance-sheet/{balanceSheet}/update', [BalanceSheetController::class, 'update'])->name('admin.update.balance.sheet');
                Route::post('balance-sheet/store', [BalanceSheetController::class, 'store'])->name('admin.store.balance.sheet');
                Route::get('export-balance-sheet', 'BalanceSheetController@export')->name('admin.export.balance.sheet');
                Route::get('get-balance-sheet', 'BalanceSheetController@paginate')->name('admin.get.balance.sheet');
                Route::get('balance-sheet/{balanceSheet}/actual-report', [BalanceSheetController::class, 'createReport'])->name('admin.create.balance.sheet.actual.report');

                // actual.report the first segment represent type so do not change it
                Route::get('balance-sheet/{balanceSheet}/actual-report', [BalanceSheetController::class, 'createReport'])->name('admin.create.balance.sheet.actual.report');

                // forecast.report the first segment represent type so do not change it
                Route::get('balance-sheet/{balanceSheet}/forecast-report', [BalanceSheetController::class, 'createReport'])->name('admin.create.balance.sheet.forecast.report');
                // adjusted.report the first segment represent type so do not change it

                Route::get('balance-sheet/{balanceSheet}/adjusted-report', [BalanceSheetController::class, 'createReport'])->name('admin.create.balance.sheet.adjusted.report');

                Route::get('balance-sheet/{balanceSheet}/modified-report', [BalanceSheetController::class, 'createReport'])->name('admin.create.balance.sheet.modified.report');

                Route::post('balance-sheet-report/update', [BalanceSheetController::class, 'updateReport'])->name('admin.update.balance.sheet.report');
                Route::post('balance-sheet-report/delete', [BalanceSheetController::class, 'deleteReport'])->name('admin.destroy.balance.sheet.report');
                Route::post('balance-sheet/storeReport', [BalanceSheetController::class, 'storeReport'])->name('admin.store.balance.sheet.report');
                Route::post('export-balance-sheet-report', 'BalanceSheetController@exportReport')->name('admin.export.balance.sheet.report');
                Route::post('get-balance-sheet-report/{balanceSheet}', 'BalanceSheetController@paginateReport')->name('admin.get.balance.sheet.report');

                // cash flow statement

                Route::get('cash-flow-statement', [CashFlowStatementController::class, 'view'])->name('admin.view.cash.flow.statement');
                Route::get('cash-flow-statement/create', [CashFlowStatementController::class, 'create'])->name('admin.create.cash.flow.statement');
                Route::get('cash-flow-statement-report/{cashFlowStatement}/edit', [CashFlowStatementController::class, 'editItems']);
                Route::post('cash-flow-statement/{cashFlowStatement}/update', [CashFlowStatementController::class, 'update'])->name('admin.update.cash.flow.statement');
                Route::post('cash-flow-statement/store', [CashFlowStatementController::class, 'store'])->name('admin.store.cash.flow.statement');
                Route::get('export-cash-flow-statement', 'CashFlowStatementController@export')->name('admin.export.cash.flow.statement');
                Route::get('get-cash-flow-statement', 'CashFlowStatementController@paginate')->name('admin.get.cash.flow.statement');
                Route::get('cash-flow-statement/{cashFlowStatement}/actual-report', [CashFlowStatementController::class, 'createReport'])->name('admin.create.cash.flow.statement.actual.report');

                Route::get('cash-and-banks/{cashFlowStatement}/{reportType}', 'CashFlowStatementController@createReport')->name('admin.show-cash-and-banks');
                Route::post('store-cash-and-banks', 'CashFlowStatementController@storeCashAndBanks')->name('admin.store-cash-and-banks');
                // actual.report the first segment represent type so do not change it
                Route::get('cash-flow-statement/{cashFlowStatement}/actual-report', [CashFlowStatementController::class, 'createReport'])->name('admin.create.cash.flow.statement.actual.report');

                // forecast.report the first segment represent type so do not change it
                Route::get('cash-flow-statement/{cashFlowStatement}/forecast-report', [CashFlowStatementController::class, 'createReport'])->name('admin.create.cash.flow.statement.forecast.report');
                // adjusted.report the first segment represent type so do not change it

                Route::get('cash-flow-statement/{cashFlowStatement}/adjusted-report', [CashFlowStatementController::class, 'createReport'])->name('admin.create.cash.flow.statement.adjusted.report');

                Route::get('cash-flow-statement/{cashFlowStatement}/modified-report', [CashFlowStatementController::class, 'createReport'])->name('admin.create.cash.flow.statement.modified.report');

                Route::post('cash-flow-statement-report/update', [CashFlowStatementController::class, 'updateReport'])->name('admin.update.cash.flow.statement.report');
                Route::post('cash-flow-statement-report/delete', [CashFlowStatementController::class, 'deleteReport'])->name('admin.destroy.cash.flow.statement.report');
                Route::post('cash-flow-statement/storeReport', [CashFlowStatementController::class, 'storeReport'])->name('admin.store.cash.flow.statement.report');
                Route::post('export-cash-flow-statement-report', 'CashFlowStatementController@exportReport')->name('admin.export.cash.flow.statement.report');
                Route::post('get-cash-flow-statement-report/{cashFlowStatement}', 'CashFlowStatementController@paginateReport')->name('admin.get.cash.flow.statement.report');

                // excel for financial statement
                Route::get('download-excel-template-for-actual/{incomeStatement}', [FinancialStatementController::class, 'downloadExcelTemplateForActual'])->name('admin.export.excel.template');
                Route::any('salesGatheringImport/last-upload-failed/{model}', 'SalesGatheringTestController@lastUploadFailed')->name('last.upload.failed');
                // Route::delete('delete-from-gathering','SalesGatheringTestController@deleteFromTo')->name('delete.export.from.to');
                Route::post('import-excel-template-for-actual/{incomeStatement}', [FinancialStatementController::class, 'importExcelTemplateForActual'])->name('admin.import.excel.template');
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

                Route::get('expense-form/create', [ExpenseController::class, 'create'])->name('admin.create.expense');
                Route::post('expense-form/store', [ExpenseController::class, 'store'])->name('admin.store.expense');

                Route::post('edit-table-cell', [EditTableCellsController::class, '__invoke'])->name('admin.edit.table.cell');

                //Ajax
                Route::post('get/ZoneZonesData/', 'Analysis\SalesGathering\ZoneAgainstAnalysisReport@ZonesData')->name('get.zones.data');
                Route::get('get/viewData/', 'Analysis\SalesGathering\ZoneAgainstAnalysisReport@dataView')->name('get.view.data');
                Route::get('checkIfJobFinished/{modelName}', 'SalesGatheringTestController@activeJob')->name('active.job');

                Route::get('/redirect', 'HomeController@redirectFun')->name('home.redirect');
                //########### Dashboard ############
                Route::get('/companyGroup', 'HomeController@companyGroup')->name('company.group');
                Route::any('Admin_Company', 'CompanyController@adminCompany')->name('admin.company');
                Route::any('Edit_Admin_Company/{companySection}', 'CompanyController@editAdminCompany')->name('edit.admin.company');

                //########### Dashboards Links ############
                Route::prefix('/dashboard')->group(function () {
                    Route::any('/', 'HomeController@dashboard')->name('dashboard');
                    Route::any('/income-statement-revenue-dashboard', 'HomeController@incomeStatementDashboard')->name('income.statement.dashboard');
                    Route::get('/HomePage', 'HomeController@welcomePage')->name('viewHomePage');
                    Route::any('/breakdown', 'HomeController@dashboardBreakdownAnalysis')->name('dashboard.breakdown');
					Route::get('ajax-refresh-limits-chart','CustomerInvoiceDashboardController@refreshBankMovementChart')->name('refresh.chart.limits.data') ; // ajax request
                    Route::any('/income-statement-breakdown-dashboard/{reportType}/{incomeStatement?}', 'HomeController@dashboardBreakdownIncomeStatementAnalysis')->name('dashboard.breakdown.incomeStatement');
                    Route::any('/balance-sheet-breakdown-dashboard/{reportType}/{balanceSheet?}', 'HomeController@dashboardBreakdownBalanceSheetAnalysis')->name('dashboard.breakdown.balanceSheet');
                    Route::any('/cash-flow-statement-breakdown-dashboard/{reportType}/{cashFlowStatement?}', 'HomeController@dashboardBreakdownCashFlowStatementAnalysis')->name('dashboard.breakdown.cashFlowStatement');
                    Route::any('/customers', 'HomeController@dashboardCustomers')->name('dashboard.customers');
                    Route::any('/salesPerson', 'HomeController@dashboardSalesPerson')->name('dashboard.salesPerson');
                    Route::any('/salesDiscount', 'HomeController@dashboardSalesDiscount')->name('dashboard.salesDiscount');
                    Route::any('/intervalComparing', 'HomeController@dashboardIntervalComparing')->name('dashboard.intervalComparing');
                    Route::any('/incomeStatementIntervalComparing/{subItemType?}', 'HomeController@dashboardIncomeStatementIntervalComparing')->name('dashboard.intervalComparing.incomeStatement');
                    Route::any('/variousIncomeStatementComparing/{subItemType}', 'HomeController@dashboardIncomeStatementVariousComparing')->name('dashboard.various.incomeStatement');
                });

                //########### Import Routs ############
                // Route::any('inventoryStatementImport', 'InventoryStatementTestController@import')->name('inventoryStatementImport');
                // Route::get('inventoryStatement/insertToMainTable', 'InventoryStatementTestController@insertToMainTable')->name('inventoryStatementTest.insertToMainTable');
                Route::any('salesGatheringImport/{model}', 'SalesGatheringTestController@import')->name('salesGatheringImport');
                Route::get('SalesGathering/insertToMainTable/{modelName}', 'SalesGatheringTestController@insertToMainTable')->name('salesGatheringTest.insertToMainTable');

                //########### Export Routes ############
                Route::get('salesGathering/export/{model}', 'SalesGatheringController@export')->name('salesGathering.export');
                // type excel or pdf
                Route::get('/export-labeling-items/{type}', 'SalesGatheringController@exportLabelingItems')->name('export.labeling.item');
                Route::get('/print-labeling-items-qrcode/{fromIndex}/{toIndex}', 'SalesGatheringController@printLabelingItemsQrcode')->name('print.labeling.item.qrcode');
                Route::post('/print-by-headers', 'SalesGatheringController@printLabelingByCustomHeaders')->name('print.custom.header');

                // ->parameters(['name-of-route'=> inventoryStatement [dependancies injection of model]])

                //########### test table for uploading ############
                // Route::resource('inventoryStatementTest', 'InventoryStatementTestController')
                // 	->only(['edit', 'update', 'destroy']);
                Route::resource('salesGatheringTest', 'SalesGatheringTestController')
                    ->only(['edit', 'update', 'destroy']);

                //########### Sections Resources ############

                Route::resource('inventoryStatement', 'InventoryStatementController');
                Route::resource('salesGathering', 'SalesGatheringController');

                Route::get('uploading/{model}/{loanId?}', 'SalesGatheringController@index')->name('view.uploading');

                //###########  (TRUNCATE) ############
                Route::get('Truncate/{model}', 'DeletingClass@truncate')->name('truncate');
                Route::get('delete-all-labeling', 'SalesGatheringController@deleteAllLabelingItemsWithColumns')->name('delete.all.labeling.items.with.columns');
                Route::delete('DeleteMultipleRows/{model}', 'DeletingClass@multipleRowsDeleting')->name('multipleRowsDelete');
                Route::delete('delete-model', [DeleteSingleRecordController::class, '__invoke'])->name('delete.model');

                //########### Inventory Links ############
                Route::prefix('/Inventory')->group(function () {
                    Route::get('/EndBalanceAnalysis/View', 'Analysis\Inventory\EndBalanceAnalysisReport@index')->name('end.balance.analysis');
                    Route::post('/EndBalanceAnalysis/Result', 'Analysis\Inventory\EndBalanceAnalysisReport@result')->name('end.balance.analysis.result');
                });

                Route::delete('delete-multi-rows', [HelpersController::class, 'deleteMulti'])->name('delete.multi');
                Route::post('store-new-model', [HelpersController::class, 'storeNewModal'])->name('admin.store.new.modal');


                // bank certificate of deposit
                Route::middleware('isCashManagement')->group(function () {

					   /**
                 * * Start Of Financial Institution Routes
                 */

				 Route::get('financial-institutions', 'FinancialInstitutionController@index')->name('view.financial.institutions');
				 Route::get('financial-institutions/create/{model?}', 'FinancialInstitutionController@create')->name('create.financial.institutions');
				 Route::post('financial-institutions/create', 'FinancialInstitutionController@store')->name('store.financial.institutions');
				 Route::get('financial-institutions/edit/{financialInstitution}', 'FinancialInstitutionController@edit')->name('edit.financial.institutions');
				 Route::put('financial-institutions/update/{financialInstitution}', 'FinancialInstitutionController@update')->name('update.financial.institutions');
				 Route::delete('financial-institutions/delete/{financialInstitution}', 'FinancialInstitutionController@destroy')->name('delete.financial.institutions');

				 Route::get('get-financial-institution-accounts-number-based-on-currency/{financialInstitution}/{currency}', 'FinancialInstitutionController@getAccountNumbersBasedOnCurrency');

				 Route::get('financial-institutions', 'FinancialInstitutionController@index')->name('view.financial.institutions');
				 Route::get('financial-institutions/create/{model?}', 'FinancialInstitutionController@create')->name('create.financial.institutions');
				 Route::post('financial-institutions/create', 'FinancialInstitutionController@store')->name('store.financial.institutions');
				 Route::get('financial-institutions/edit/{financialInstitution}', 'FinancialInstitutionController@edit')->name('edit.financial.institutions');
				 Route::put('financial-institutions/update/{financialInstitution}', 'FinancialInstitutionController@update')->name('update.financial.institutions');
				 Route::delete('financial-institutions/delete/{financialInstitution}', 'FinancialInstitutionController@destroy')->name('delete.financial.institutions');

				 Route::get('financial-institutions/{financialInstitution}/add-account', 'FinancialInstitutionController@addAccount')->name('financial.institution.add.account');
				 Route::post('financial-institutions/{financialInstitution}/add-account', 'FinancialInstitutionController@storeAccount')->name('financial.institution.store.account');
				 Route::get('financial-institution-accounts/edit/{financialInstitutionAccount}', 'FinancialInstitutionAccountController@edit')->name('edit.financial.institutions.account');
				 Route::put('financial-institution-accounts/update/{financialInstitution}/{financialInstitutionAccount}', 'FinancialInstitutionAccountController@update')->name('update.financial.institutions.account');
				 Route::delete('financial-institution-accounts/delete/{financialInstitutionAccount}', 'FinancialInstitutionAccountController@destroy')->name('delete.financial.institutions.account');
				 Route::put('financial-institution-accounts/lock-or-unlock/{financialInstitutionAccount}', 'FinancialInstitutionAccountController@lockOrUnlock')->name('lock.or.unlock.financial.institutions.account');

				 /**
				  * * Bank Accounts
				  * * لعرض الاكونتات الخاصة بالعميل في بنك معين او مؤسسة مالية
				  */
				 Route::get('financial-institutions/{financialInstitution}/bank-accounts', 'FinancialInstitutionController@viewAllAccounts')->name('view.all.bank.accounts');

				 Route::post('add-new-partner','AddNewCustomerController@addNew')->name('add.new.partner');
				 Route::post('add-new-partner/{type}','AddNewCustomerController@addNew2')->name('add.new.partner.type');
				 Route::resource('opening-balance', 'OpeningBalancesController');
				 Route::resource('lg-opening-balance', 'LgOpeningBalancesController');
				 Route::resource('lc-opening-balance', 'LcOpeningBalancesController');
				//  Route::resource('buy-or-sell-currencies', 'InternalMoneyTransferController');
				 //
				 
				 
				 Route::get('lc-settlement-internal-money-transfers','LcSettlementInternalMoneyTransferController@index')->name('lc-settlement-internal-money-transfers.index');
				 Route::get('lc-settlement-internal-money-transfers/create','LcSettlementInternalMoneyTransferController@create')->name('lc-settlement-internal-money-transfers.create');
				 Route::post('lc-settlement-internal-money-transfers/store','LcSettlementInternalMoneyTransferController@store')->name('lc-settlement-internal-money-transfers.store');
				 Route::get('lc-settlement-internal-money-transfers/{lc_settlement_internal_transfer}/edit','LcSettlementInternalMoneyTransferController@edit')->name('lc-settlement-internal-money-transfers.edit');
				 Route::put('lc-settlement-internal-money-transfers/{lc_settlement_internal_transfer}/update','LcSettlementInternalMoneyTransferController@update')->name('lc-settlement-internal-money-transfers.update');
				 Route::delete('lc-settlement-internal-money-transfers/{lc_settlement_internal_transfer}/delete','LcSettlementInternalMoneyTransferController@destroy')->name('lc-settlement-internal-money-transfers.destroy');
				 
				 
				 
				 
				 
				 
				 
				 
				 Route::get('internal-money-transfers','InternalMoneyTransferController@index')->name('internal-money-transfers.index');
				 Route::get('internal-money-transfers/{type}/create','InternalMoneyTransferController@create')->name('internal-money-transfers.create');
				 Route::post('internal-money-transfers/{type}/store','InternalMoneyTransferController@store')->name('internal-money-transfers.store');
				 Route::get('internal-money-transfers/{type}/{internal_money_transfer}/edit','InternalMoneyTransferController@edit')->name('internal-money-transfers.edit');
				 Route::put('internal-money-transfers/{type}/{internal_money_transfer}/update','InternalMoneyTransferController@update')->name('internal-money-transfers.update');
				 Route::delete('internal-money-transfers/{type}/{internal_money_transfer}/delete','InternalMoneyTransferController@destroy')->name('internal-money-transfers.destroy');
				 
				 
				 Route::get('buy-or-sell-currencies','BuyOrSellCurrenciesController@index')->name('buy-or-sell-currencies.index');
				 Route::get('buy-or-sell-currencies/create','BuyOrSellCurrenciesController@create')->name('buy-or-sell-currencies.create');
				 Route::post('buy-or-sell-currencies/store','BuyOrSellCurrenciesController@store')->name('buy-or-sell-currencies.store');
				 Route::get('buy-or-sell-currencies/{buy_or_sell_currency}/edit','BuyOrSellCurrenciesController@edit')->name('buy-or-sell-currencies.edit');
				 Route::put('buy-or-sell-currencies/{buy_or_sell_currency}/update','BuyOrSellCurrenciesController@update')->name('buy-or-sell-currencies.update');
				 Route::delete('buy-or-sell-currencies/{buy_or_sell_currency}/delete','BuyOrSellCurrenciesController@destroy')->name('buy-or-sell-currencies.destroy');
				 
				 
				 
				 
				//  Route::get('internal-money-');
				 
				//  Route::resource('contracts', 'ContractsController');

				 Route::get('contracts/{type}','ContractsController@index')->name('contracts.index');
				 Route::get('contracts/create/{type}','ContractsController@create')->name('contracts.create');
				 Route::post('contracts/{type}','ContractsController@store')->name('contracts.store');
				 Route::get('contracts/{contract}/edit/{type}','ContractsController@edit')->name('contracts.edit');
				 Route::put('contracts/{contract}/{type}','ContractsController@update')->name('contracts.update');
				 Route::delete('contracts/{contract}/{type}','ContractsController@destroy')->name('contracts.destroy');
				 Route::get('get-contracts-for-customer-or-supplier','ContractsController@getContractsForCustomerOrSupplier')->name('get.contracts.for.customer.or.supplier');
				 Route::get('financial-institutions/js-update-contracts-based-on-customer', 'ContractsController@updateContractsBasedOnCustomer')->name('update.contracts.based.on.customer');
				 Route::get('financial-institutions/js-update-purchase-orders-based-on-contract', 'ContractsController@updatePurchaseOrdersBasedOnContract')->name('update.purchase.orders.based.on.contract');
				 Route::get('financial-institutions/get-lc-issuance-based-of-financial-institution', 'FinancialInstitutionController@getLcIssuanceBasedOnFinancialInstitution')->name('update.lc.issuance.based.on.financial.institution');
				 
				 
				 // 
				 
				 Route::get('cash-expense-category','CashExpenseCategoryController@index')->name('cash.expense.category.index');
				 Route::get('cash-expense-category/create','CashExpenseCategoryController@create')->name('cash.expense.category.create');
				 Route::post('cash-expense-category','CashExpenseCategoryController@store')->name('cash.expense.category.store');
				 Route::get('cash-expense-category/{cashExpenseCategory}/edit','CashExpenseCategoryController@edit')->name('cash.expense.category.edit');
				 Route::put('cash-expense-category/{cashExpenseCategory}','CashExpenseCategoryController@update')->name('cash.expense.category.update');
				 Route::delete('cash-expense-category/{cashExpenseCategory}','CashExpenseCategoryController@destroy')->name('cash.expense.category.destroy');
				 Route::get('update-expense-category-name-based-on-expense-category-category','CashExpenseCategoryController@updateExpenseCategoryNameBasedOnCategory')->name('update.expense.category.name.based.on.category');
				 // 
				 Route::get('notifications/{type}','NotificationsController@index')->name('view.notifications');
				 Route::resource('notifications-settings', 'NotificationSettingsController');
				 Route::get('mark-notifications-as-read', 'NotificationSettingsController@markAsRead')->name('mark.notifications.as.read');

				 Route::get('adjust-due-dates/{modelId}/{modelType}', 'AdjustedDueDateHistoriesController@index')->name('adjust.due.dates');
				 Route::post('adjust-due-dates/{modelId}/{modelType}', 'AdjustedDueDateHistoriesController@store')->name('store.adjust.due.dates');
				 Route::get('adjust-due-dates/edit/{modelId}/{modelType}/{dueDateHistory}', 'AdjustedDueDateHistoriesController@edit')->name('edit.adjust.due.dates');
				 Route::patch('adjust-due-dates/edit/{modelId}/{modelType}/{dueDateHistory}', 'AdjustedDueDateHistoriesController@update')->name('update.adjust.due.dates');
				 Route::delete('delete-adjust-due-dates/edit/{modelId}/{modelType}/{dueDateHistory}', 'AdjustedDueDateHistoriesController@destroy')->name('delete.adjust.due.dates');



				 Route::get('foreign-exchange-rate', 'ForeignExchangeRateController@index')->name('view.foreign.exchange.rate');
				 Route::post('foreign-exchange-rate', 'ForeignExchangeRateController@store')->name('store.foreign.exchange.rate');
				 Route::get('foreign-exchange-rate/edit/{foreignExchangeRate}', 'ForeignExchangeRateController@edit')->name('edit.foreign.exchange.rate');
				 Route::patch('foreign-exchange-rate/edit/{foreignExchangeRate}', 'ForeignExchangeRateController@update')->name('update.foreign.exchange.rate');
				 Route::delete('delete-foreign-exchange-rate/edit/{foreignExchangeRate}', 'ForeignExchangeRateController@destroy')->name('delete.foreign.exchange.rate');



				 Route::get('financial-institutions/{financialInstitution}/full-secured-overdraft', 'FullySecuredOverdraftController@index')->name('view.fully.secured.overdraft');
				 Route::get('financial-institutions/{financialInstitution}/full-secured-overdraft/create', 'FullySecuredOverdraftController@create')->name('create.fully.secured.overdraft');
				 Route::post('financial-institutions/{financialInstitution}/full-secured-overdraft/create', 'FullySecuredOverdraftController@store')->name('store.fully.secured.overdraft');
				 Route::get('financial-institutions/{financialInstitution}/full-secured-overdraft/edit/{fullySecuredOverdraft}', 'FullySecuredOverdraftController@edit')->name('edit.fully.secured.overdraft');
				 Route::put('financial-institutions/{financialInstitution}/full-secured-overdraft/update/{fullySecuredOverdraft}', 'FullySecuredOverdraftController@update')->name('update.fully.secured.overdraft');
				 Route::delete('financial-institutions/{financialInstitution}/full-secured-overdraft/delete/{fullySecuredOverdraft}', 'FullySecuredOverdraftController@destroy')->name('delete.fully.secured.overdraft');
				
				 Route::post('financial-institutions/{financialInstitution}/fully-secured-overdraft/apply-rate/{fullySecuredOverdraft}', 'FullySecuredOverdraftController@applyRate')->name('fully-secured-overdraft-apply.rates');
				 Route::post('financial-institutions/{financialInstitution}/fully-secured-overdraft/edit-rates/{rate}', 'FullySecuredOverdraftController@editRate')->name('fully-secured-overdraft-edit-rates');
				 Route::get('financial-institutions/{financialInstitution}/fully-secured-overdraft/delete-rates/{rate}', 'FullySecuredOverdraftController@deleteRate')->name('fully-secured-overdraft-delete-rate');
				 
				 
				 
				 
				 Route::get('financial-institutions/{financialInstitution}/clean-overdraft', 'CleanOverdraftController@index')->name('view.clean.overdraft');
				 Route::get('financial-institutions/{financialInstitution}/clean-overdraft/create', 'CleanOverdraftController@create')->name('create.clean.overdraft');
				 Route::post('financial-institutions/{financialInstitution}/clean-overdraft/create', 'CleanOverdraftController@store')->name('store.clean.overdraft');
				 Route::get('financial-institutions/{financialInstitution}/clean-overdraft/edit/{cleanOverdraft}', 'CleanOverdraftController@edit')->name('edit.clean.overdraft');
				 Route::put('financial-institutions/{financialInstitution}/clean-overdraft/update/{cleanOverdraft}', 'CleanOverdraftController@update')->name('update.clean.overdraft');
				 Route::delete('financial-institutions/{financialInstitution}/clean-overdraft/delete/{cleanOverdraft}', 'CleanOverdraftController@destroy')->name('delete.clean.overdraft');
				 Route::post('financial-institutions/{financialInstitution}/clean-overdraft/apply-rate/{cleanOverdraft}', 'CleanOverdraftController@applyRate')->name('clean-overdraft-apply.rates');
				 Route::post('financial-institutions/{financialInstitution}/clean-overdraft/edit-rates/{rate}', 'CleanOverdraftController@editRate')->name('clean-overdraft-edit-rates');
				 Route::get('financial-institutions/{financialInstitution}/clean-overdraft/delete-rates/{rate}', 'CleanOverdraftController@deleteRate')->name('clean-overdraft-delete-rate');
				 
				 
				 Route::get('financial-institutions/{financialInstitution}/medium-term-loan','MediumTermLoanController@index')->name('loans.index');
				 Route::get('financial-institutions/{financialInstitution}/medium-term-loan/create','MediumTermLoanController@create')->name('loans.create');
				 Route::post('financial-institutions/{financialInstitution}/medium-term-loan/store','MediumTermLoanController@store')->name('loans.store');
				 Route::get('financial-institutions/{financialInstitution}/medium-term-loan/{mediumTermLoan}/edit','MediumTermLoanController@edit')->name('loans.edit');
				 Route::put('financial-institutions/{financialInstitution}/medium-term-loan/{mediumTermLoan}/update','MediumTermLoanController@update')->name('loans.update');
				 Route::delete('financial-institutions/{financialInstitution}/medium-term-loan/{mediumTermLoan}/delete','MediumTermLoanController@destroy')->name('loans.destroy');
				 Route::get('loan-schedule-settlement/{loanSchedule}','MediumTermLoanController@viewLoanScheduleSettlement')->name('view.loan.schedule.settlements');
				 Route::post('loan-schedule-settlements/{loanSchedule}','MediumTermLoanController@storeLoanScheduleSettlement')->name('store.loan.schedule.settlements');
				 Route::get('edit-loan-schedule-settlement/{loanScheduleSettlement}','MediumTermLoanController@editLoanScheduleSettlement')->name('edit.loan.schedule.settlements');
				 Route::patch('loan-schedule-settlements/{loanScheduleSettlement}','MediumTermLoanController@updateLoanScheduleSettlement')->name('update.loan.schedule.settlements');
				 Route::delete('delete-loan-schedule-settlement/{loanScheduleSettlement}','MediumTermLoanController@deleteLoanScheduleSettlement')->name('delete.loan.schedule.settlements');
				 Route::get('medium-term-loan-report','MediumTermLoanController@refreshReport')->name('refresh.medium.term.loan.report'); // ajax
				 Route::get('get-medium-term-loan-for-financial-institution','MediumTermLoanController@getMediumTermLoanForFinancialInstitution')->name('get.medium.term.loan.for.financial.institution');
				 

				 Route::get('financial-institutions/{financialInstitution}/overdraft-against-commercial-paper', 'OverdraftAgainstCommercialPaperController@index')->name('view.overdraft.against.commercial.paper');
				 Route::get('financial-institutions/{financialInstitution}/overdraft-against-commercial-paper/create', 'OverdraftAgainstCommercialPaperController@create')->name('create.overdraft.against.commercial.paper');
				 Route::post('financial-institutions/{financialInstitution}/overdraft-against-commercial-paper/create', 'OverdraftAgainstCommercialPaperController@store')->name('store.overdraft.against.commercial.paper');
				 Route::get('financial-institutions/{financialInstitution}/overdraft-against-commercial-paper/edit/{overdraftAgainstCommercialPaper}', 'OverdraftAgainstCommercialPaperController@edit')->name('edit.overdraft.against.commercial.paper');
				 Route::put('financial-institutions/{financialInstitution}/overdraft-against-commercial-paper/update/{overdraftAgainstCommercialPaper}', 'OverdraftAgainstCommercialPaperController@update')->name('update.overdraft.against.commercial.paper');
				 Route::delete('financial-institutions/{financialInstitution}/overdraft-against-commercial-paper/delete/{overdraftAgainstCommercialPaper}', 'OverdraftAgainstCommercialPaperController@destroy')->name('delete.overdraft.against.commercial.paper');
				 
				 Route::post('financial-institutions/{financialInstitution}/overdraft-against-commercial-paper/apply-rate/{overdraftAgainstCommercialPaper}', 'OverdraftAgainstCommercialPaperController@applyRate')->name('overdraft-against-commercial-paper-apply.rates');
				 Route::post('financial-institutions/{financialInstitution}/overdraft-against-commercial-paper/edit-rates/{rate}', 'OverdraftAgainstCommercialPaperController@editRate')->name('overdraft-against-commercial-paper-edit-rates');
				 Route::get('financial-institutions/{financialInstitution}/overdraft-against-commercial-paper/delete-rates/{rate}', 'OverdraftAgainstCommercialPaperController@deleteRate')->name('overdraft-against-commercial-paper-delete-rate');
				 
				 
				 
				 Route::get('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract', 'OverdraftAgainstAssignmentOfContractController@index')->name('view.overdraft.against.assignment.of.contract');
				 Route::get('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/create', 'OverdraftAgainstAssignmentOfContractController@create')->name('create.overdraft.against.assignment.of.contract');
				 Route::post('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/create', 'OverdraftAgainstAssignmentOfContractController@store')->name('store.overdraft.against.assignment.of.contract');
				 Route::get('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/edit/{odAgainstAssignmentOfContract}', 'OverdraftAgainstAssignmentOfContractController@edit')->name('edit.overdraft.against.assignment.of.contract');
				 Route::put('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/update/{odAgainstAssignmentOfContract}', 'OverdraftAgainstAssignmentOfContractController@update')->name('update.overdraft.against.assignment.of.contract');
				 Route::delete('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/delete/{odAgainstAssignmentOfContract}', 'OverdraftAgainstAssignmentOfContractController@destroy')->name('delete.overdraft.against.assignment.of.contract');
				 
				 Route::post('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/lending-information/{odAgainstAssignmentOfContract}', 'OverdraftAgainstAssignmentOfContractController@applyLendingInformation')->name('lending.information.apply.for.against.assignment.of.contract');
				 Route::post('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/edit-lending-information/{lendingInformation}', 'OverdraftAgainstAssignmentOfContractController@editLendingInformation')->name('lending.information.edit.for.against.assignment.of.contract');
				 Route::get('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/delete-lending-information/{lendingInformation}', 'OverdraftAgainstAssignmentOfContractController@deleteLendingInformation')->name('lending.information.delete.for.against.assignment.of.contract');
				 Route::get('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/apply-against-lending/{lendingInformation}', 'OverdraftAgainstAssignmentOfContractController@applyAgainstLending')->name('apply.against.lending');
				 Route::put('contract/{contract}/{type}/mark-as-finished', 'ContractsController@markAsFinished')->name('contract.mark.as.finished');
				 Route::put('contract/{contract}/{type}/mark-as-running-and-against', 'ContractsController@markAsRunningAndAgainst')->name('contract.mark.as.running.and.against');
				 
				 
				 Route::post('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/apply-rate/{odAgainstAssignmentOfContract}', 'OverdraftAgainstAssignmentOfContractController@applyRate')->name('overdraft-against-assignment-of-contract-apply.rates');
				 Route::post('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/edit-rates/{rate}', 'OverdraftAgainstAssignmentOfContractController@editRate')->name('overdraft-against-assignment-of-contract-edit-rates');
				 Route::get('financial-institutions/{financialInstitution}/overdraft-against-assignment-of-contract/delete-rates/{rate}', 'OverdraftAgainstAssignmentOfContractController@deleteRate')->name('overdraft-against-assignment-of-contract-delete-rate');
				 
					/**
					 * * start certificates of deposit
					 */

                    Route::get('financial-institutions/{financialInstitution}/certificates-of-deposit', 'CertificatesOfDepositsController@index')->name('view.certificates.of.deposit');
                    Route::get('financial-institutions/{financialInstitution}/certificates-of-deposit/create', 'CertificatesOfDepositsController@create')->name('create.certificates.of.deposit');
                    Route::post('financial-institutions/{financialInstitution}/certificates-of-deposit/create', 'CertificatesOfDepositsController@store')->name('store.certificates.of.deposit');
                    Route::get('financial-institutions/{financialInstitution}/certificates-of-deposit/edit/{certificatesOfDeposit}', 'CertificatesOfDepositsController@edit')->name('edit.certificates.of.deposit');
                    Route::put('financial-institutions/{financialInstitution}/certificates-of-deposit/update/{certificatesOfDeposit}', 'CertificatesOfDepositsController@update')->name('update.certificates.of.deposit');
                    Route::delete('financial-institutions/{financialInstitution}/certificates-of-deposit/delete/{certificatesOfDeposit}', 'CertificatesOfDepositsController@destroy')->name('delete.certificates.of.deposit');
                    Route::post('financial-institutions/{financialInstitution}/certificates-of-deposit/apply-deposit/{certificatesOfDeposit}', 'CertificatesOfDepositsController@applyDeposit')->name('apply.deposit.to.certificate.of.deposit');
                    Route::post('financial-institutions/{financialInstitution}/certificates-of-deposit/apply-break/{certificatesOfDeposit}', 'CertificatesOfDepositsController@applyBreak')->name('apply.break.to.certificate.of.deposit');
                    Route::post('financial-institutions/{financialInstitution}/certificates-of-deposit/reverse-deposit/{certificatesOfDeposit}', 'CertificatesOfDepositsController@reverseDeposit')->name('reverse.deposit.to.certificate.of.deposit');
                    Route::post('financial-institutions/{financialInstitution}/certificates-of-deposit/reverse-broken/{certificatesOfDeposit}', 'CertificatesOfDepositsController@reverseBroken')->name('reverse.broken.to.certificate.of.deposit');

					/**
					 * * end certificates of deposit
					 */





					 	/**
					 * * start time of deposit
					 */

					 Route::get('financial-institutions/{financialInstitution}/time-of-deposit', 'TimeOfDepositsController@index')->name('view.time.of.deposit');
					 Route::get('financial-institutions/{financialInstitution}/time-of-deposit/create', 'TimeOfDepositsController@create')->name('create.time.of.deposit');
					 Route::post('financial-institutions/{financialInstitution}/time-of-deposit/create', 'TimeOfDepositsController@store')->name('store.time.of.deposit');
					 Route::get('financial-institutions/{financialInstitution}/time-of-deposit/edit/{timeOfDeposit}', 'TimeOfDepositsController@edit')->name('edit.time.of.deposit');
					 Route::put('financial-institutions/{financialInstitution}/time-of-deposit/update/{timeOfDeposit}', 'TimeOfDepositsController@update')->name('update.time.of.deposit');
					 Route::delete('financial-institutions/{financialInstitution}/time-of-deposit/delete/{timeOfDeposit}', 'TimeOfDepositsController@destroy')->name('delete.time.of.deposit');
					 Route::post('financial-institutions/{financialInstitution}/time-of-deposit/apply-deposit/{timeOfDeposit}', 'TimeOfDepositsController@applyDeposit')->name('apply.deposit.to.time.of.deposit');
					 Route::post('financial-institutions/{financialInstitution}/time-of-deposit/apply-break/{timeOfDeposit}', 'TimeOfDepositsController@applyBreak')->name('apply.break.to.time.of.deposit');
					 Route::post('financial-institutions/{financialInstitution}/time-of-deposit/reverse-deposit/{timeOfDeposit}', 'TimeOfDepositsController@reverseDeposit')->name('reverse.deposit.to.time.of.deposit');
					 Route::post('financial-institutions/{financialInstitution}/time-of-deposit/reverse-broken/{timeOfDeposit}', 'TimeOfDepositsController@reverseBroken')->name('reverse.broken.to.time.of.deposit');

					 /**
					  * * end time of deposit
					  */




                    Route::get('financial-institutions/{financialInstitution}/letter-of-guarantee-facility', 'LetterOfGuaranteeFacilityController@index')->name('view.letter.of.guarantee.facility');
                    Route::get('financial-institutions/{financialInstitution}/letter-of-guarantee-facility/create', 'LetterOfGuaranteeFacilityController@create')->name('create.letter.of.guarantee.facility');
                    Route::post('financial-institutions/{financialInstitution}/letter-of-guarantee-facility/create', 'LetterOfGuaranteeFacilityController@store')->name('store.letter.of.guarantee.facility');
                    Route::get('financial-institutions/{financialInstitution}/letter-of-guarantee-facility/edit/{letterOfGuaranteeFacility}', 'LetterOfGuaranteeFacilityController@edit')->name('edit.letter.of.guarantee.facility');
                    Route::put('financial-institutions/{financialInstitution}/letter-of-guarantee-facility/update/{letterOfGuaranteeFacility}', 'LetterOfGuaranteeFacilityController@update')->name('update.letter.of.guarantee.facility');
                    Route::delete('financial-institutions/{financialInstitution}/letter-of-guarantee-facility/delete/{letterOfGuaranteeFacility}', 'LetterOfGuaranteeFacilityController@destroy')->name('delete.letter.of.guarantee.facility');
                    Route::get('financial-institutions/update-outstanding-balance-and-limits', 'LetterOfGuaranteeFacilityController@updateOutstandingBalanceAndLimits')->name('update.letter.of.guarantee.outstanding.balance.and.limit');

                    Route::get('letter-of-guarantee-issuance', 'LetterOfGuaranteeIssuanceController@index')->name('view.letter.of.guarantee.issuance');
                    Route::get('letter-of-guarantee-issuance/create/{source}', 'LetterOfGuaranteeIssuanceController@create')->name('create.letter.of.guarantee.issuance');
                    Route::post('letter-of-guarantee-issuance/create/{source}', 'LetterOfGuaranteeIssuanceController@store')->name('store.letter.of.guarantee.issuance');
                    Route::get('letter-of-guarantee-issuance/edit/{letterOfGuaranteeIssuance}/{source}', 'LetterOfGuaranteeIssuanceController@edit')->name('edit.letter.of.guarantee.issuance');
                    Route::put('letter-of-guarantee-issuance/update/{letterOfGuaranteeIssuance}/{source}', 'LetterOfGuaranteeIssuanceController@update')->name('update.letter.of.guarantee.issuance');
                    Route::delete('letter-of-guarantee-issuance/delete/{letterOfGuaranteeIssuance}/{source}', 'LetterOfGuaranteeIssuanceController@destroy')->name('delete.letter.of.guarantee.issuance');
                    Route::post('letter-of-guarantee-issuance/cancel/{letterOfGuaranteeIssuance}/{source}', 'LetterOfGuaranteeIssuanceController@cancel')->name('cancel.letter.of.guarantee.issuance');
                    Route::post('letter-of-guarantee-issuance/apply-amount-to-be-decreased/{letterOfGuaranteeIssuance}/{source}', 'LetterOfGuaranteeIssuanceController@applyAmountToBeDecreased')->name('advanced.lg.payment.apply.amount.to.be.decreased');
                    Route::post('letter-of-guarantee-issuance/edit-amount-to-be-decreased/{lgAdvancedPaymentHistory}/{source}', 'LetterOfGuaranteeIssuanceController@editAmountToBeDecreased')->name('advanced.lg.payment.edit.amount.to.be.decreased');
                    Route::get('letter-of-guarantee-issuance/delete-advanced-payment/{lgAdvancedPaymentHistory}', 'LetterOfGuaranteeIssuanceController@deleteAdvancedPayment')->name('delete.lg.advanced.payment');
                    Route::post('letter-of-guarantee-issuance/back-to-running/{letterOfGuaranteeIssuance}/{source}', 'LetterOfGuaranteeIssuanceController@bankToRunningStatus')->name('back.to.running.letter.of.guarantee.issuance');
					
					
					// letter of credit issuance
					
					Route::get('letter-of-credit-issuance', 'LetterOfCreditIssuanceController@index')->name('view.letter.of.credit.issuance');
                    Route::get('letter-of-credit-issuance/create/{source}', 'LetterOfCreditIssuanceController@create')->name('create.letter.of.credit.issuance');
                    Route::post('letter-of-credit-issuance/create/{source}', 'LetterOfCreditIssuanceController@store')->name('store.letter.of.credit.issuance');
                    Route::get('letter-of-credit-issuance/edit/{letterOfCreditIssuance}/{source}', 'LetterOfCreditIssuanceController@edit')->name('edit.letter.of.credit.issuance');
                    Route::put('letter-of-credit-issuance/update/{letterOfCreditIssuance}/{source}', 'LetterOfCreditIssuanceController@update')->name('update.letter.of.credit.issuance');
                    Route::delete('letter-of-credit-issuance/delete/{letterOfCreditIssuance}/{source}', 'LetterOfCreditIssuanceController@destroy')->name('delete.letter.of.credit.issuance');
                    Route::post('letter-of-credit-issuance/cancel/{letterOfCreditIssuance}/{source}', 'LetterOfCreditIssuanceController@markAsPaid')->name('make.letter.of.credit.issuance.as.paid');
                    // Route::post('letter-of-credit-issuance/apply-amount-to-be-decreased/{letterOfCreditIssuance}/{source}', 'LetterOfCreditIssuanceController@applyAmountToBeDecreased')->name('advanced.lc.payment.apply.amount.to.be.decreased');
                    // Route::post('letter-of-credit-issuance/edit-amount-to-be-decreased/{lcAdvancedPaymentHistory}/{source}', 'LetterOfCreditIssuanceController@editAmountToBeDecreased')->name('advanced.lc.payment.edit.amount.to.be.decreased');
                    // Route::get('letter-of-credit-issuance/delete-advanced-payment/{lcAdvancedPaymentHistory}', 'LetterOfCreditIssuanceController@deleteAdvancedPayment')->name('delete.lc.advanced.payment');
                    Route::post('letter-of-credit-issuance/back-to-running/{letterOfCreditIssuance}/{source}', 'LetterOfCreditIssuanceController@bankToRunningStatus')->name('back.to.running.letter.of.credit.issuance');
					Route::get('financial-institutions/update-outstanding-balance-and-limits-for-lc', 'LetterOfCreditFacilityController@updateOutstandingBalanceAndLimits')->name('update.letter.of.credit.outstanding.balance.and.limit');
					Route::post('letter-of-credit-issuance/apply-expense/{letterOfCreditIssuance}','LetterOfCreditIssuanceController@applyExpense')->name('apply.lc.issuance.expense');
					Route::post('letter-of-credit-issuance/update-expense/{expense}','LetterOfCreditIssuanceController@updateExpense')->name('update.lc.issuance.expense');
					Route::get('letter-of-credit-issuance/delete-expense/{expense}','LetterOfCreditIssuanceController@deleteExpense')->name('delete.lc.issuance.expense');
					Route::get('letter-of-credit-issuance-remaining-balance', 'LetterOfCreditIssuanceController@getRemainingBalance')->name('get.remaining.balance.lc.issuance');
					
					// end letter of credit issuance
					
                    Route::get('financial-institutions/{financialInstitution}/letter-of-credit-facility', 'LetterOfCreditFacilityController@index')->name('view.letter.of.credit.facility');
                    Route::get('financial-institutions/{financialInstitution}/letter-of-credit-facility/create', 'LetterOfCreditFacilityController@create')->name('create.letter.of.credit.facility');
                    Route::post('financial-institutions/{financialInstitution}/letter-of-credit-facility/create', 'LetterOfCreditFacilityController@store')->name('store.letter.of.credit.facility');
                    Route::get('financial-institutions/{financialInstitution}/letter-of-credit-facility/edit/{letterOfCreditFacility}', 'LetterOfCreditFacilityController@edit')->name('edit.letter.of.credit.facility');
                    Route::put('financial-institutions/{financialInstitution}/letter-of-credit-facility/update/{letterOfCreditFacility}', 'LetterOfCreditFacilityController@update')->name('update.letter.of.credit.facility');
                    Route::delete('financial-institutions/{financialInstitution}/letter-of-credit-facility/delete/{letterOfCreditFacility}', 'LetterOfCreditFacilityController@destroy')->name('delete.letter.of.credit.facility');

					
					
					
					
                    Route::get('aging-analysis/{modelType}', 'AgingController@index')->name('view.aging.analysis');
                    Route::post('aging-analysis/{modelType}', 'AgingController@result')->name('result.aging.analysis');


					Route::get('safe-statement', 'SafeStatementController@index')->name('view.safe.statement');
                    Route::post('safe-statement', 'SafeStatementController@result')->name('result.safe.statement');

					Route::get('bank-statement', 'BankStatementController@index')->name('view.bank.statement');
                    Route::post('bank-statement', 'BankStatementController@result')->name('result.bank.statement');
					
					Route::get('lg-lc-bank-statement', 'LGLCSBanktatementController@index')->name('view.lg.lc.bank.statement');
                    Route::post('lg-lc-bank-statement', 'LGLCSBanktatementController@result')->name('result.lg.lc.bank.statement');
					Route::get('get-lg-lc-types','LGLCSBanktatementController@getLgOrLcType')->name('get.lc.or.lg.types');

                    Route::get('customer-balances/{modelType}', 'BalancesController@index')->name('view.balances');
                    Route::get('/cashvero-dashboard/cash', 'CustomerInvoiceDashboardController@viewCashDashboard')->name('view.customer.invoice.dashboard.cash');
                    Route::get('/cashvero-dashboard/forecast', 'CustomerInvoiceDashboardController@viewForecastDashboard')->name('view.customer.invoice.dashboard.forecast');
                    Route::get('/cashvero-dashboard/lglc', 'CustomerInvoiceDashboardController@viewLGLCDashboard')->name('view.lglc.dashboard');
					// Route::get('/cashvero-dashboard-update-lg-dashboard','CustomerInvoiceDashboardController@updateLgDashboard')->name('update.lg.table.and.charts');
                    Route::get('/customer-balances/invoices-report/{partnerId}/{currency}/{modelType}', 'CustomerInvoiceDashboardController@showInvoiceReport')->name('view.invoice.report');
                    Route::get('/customer-balances/invoices-statement-report/{partnerId}/{currency}/{modelType}', 'CustomerInvoiceDashboardController@showCustomerInvoiceStatementReport')->name('view.invoice.statement.report');
                    Route::get('/customer-balances/total-net-balance-details/{currency}/{modelType}', 'BalancesController@showTotalNetBalanceDetailsReport')->name('show.total.net.balance.in');

					Route::get('cashflow-report', 'CashFlowReportController@index')->name('view.cashflow.report');
					Route::post('cashflow-report', 'CashFlowReportController@result')->name('result.cashflow.report');
					
					Route::get('contract-cashflow-report', 'ContractCashFlowReportController@index')->name('view.contract.cashflow.report');
					Route::post('contract-cashflow-report', 'ContractCashFlowReportController@result')->name('result.contract.cashflow.report');
					

					Route::get('withdrawals-settlements-report', 'WithdrawalsSettlementReportController@index')->name('view.withdrawals.settlement.report');
					Route::post('withdrawals-settlements-report', 'WithdrawalsSettlementReportController@result')->name('result.withdrawals.settlement.report');

					Route::get('refresh-withdrawal-dues-report','WithdrawalsSettlementReportController@refreshReport')->name('refresh.withdrawal.report'); // ajax

					
					Route::get('down-payment-contracts/{partnerId}/{modelType}','MoneyReceivedController@viewContractsWithDownPayments')->name('view.contracts.down.payments');
					Route::get('down-payment-contracts-settlements/{downPaymentId}/{modelType}','MoneyReceivedController@downPaymentSettlements')->name('view.down.payment.settlement');
					Route::post('store-down-payment-settlement/{downPaymentId}/{partnerId}/{modelType}','MoneyReceivedController@storeDownPaymentSettlement')->name('store.down.payment.settlement');
					
                    Route::get('money-received', 'MoneyReceivedController@index')->name('view.money.receive');
                    Route::get('money-received/create/{model?}', 'MoneyReceivedController@create')->name('create.money.receive');
                    Route::post('money-received/create', 'MoneyReceivedController@store')->name('store.money.receive');
                    Route::get('money-received/edit/{moneyReceived}', 'MoneyReceivedController@edit')->name('edit.money.receive');
                    Route::put('money-received/update/{moneyReceived}', 'MoneyReceivedController@update')->name('update.money.receive');
                    Route::delete('money-received/delete/{moneyReceived}', 'MoneyReceivedController@destroy')->name('delete.money.receive');
					Route::get('money-received/get-invoice-numbers/{customer_name}/{currency?}', 'MoneyReceivedController@getInvoiceNumber'); // ajax request
					Route::get('money-received/get-account-numbers-based-on-account-type/{accountType}/{currency}/{financialInstitutionId}', 'MoneyReceivedController@getAccountNumbersForAccountType'); // ajax request
					Route::get('money-received/get-net-balance-based-on-account-number', 'MoneyReceivedController@updateNetBalanceBasedOnAccountNumber')->name('update.balance.and.net.balance.based.on.account.number');
					Route::get('money-received/get-net-balance-based-on-account-number-by-ajax/{accountType}/{accountNumber}/{financialInstitutionId}', 'MoneyReceivedController@updateNetBalanceBasedOnAccountNumberByAjax')->name('update.balance.and.net.balance.based.on.account.number.ajax');
					Route::get('money-received/get-account-amount-based-on-account-number/{accountType}/{accountNumber}', 'MoneyReceivedController@getAccountAmountForAccountNumber')->name('get.account.amount.based.on.account.number'); // ajax request

						

					Route::get('money-received', 'MoneyReceivedController@index')->name('view.money.receive');
                    Route::get('money-received/create/{model?}', 'MoneyReceivedController@create')->name('create.money.receive');
                    Route::post('money-received/create', 'MoneyReceivedController@store')->name('store.money.receive');
                    Route::get('money-received/edit/{moneyReceived}', 'MoneyReceivedController@edit')->name('edit.money.receive');
                    Route::put('money-received/update/{moneyReceived}', 'MoneyReceivedController@update')->name('update.money.receive');
                    Route::delete('money-received/delete/{moneyReceived}', 'MoneyReceivedController@destroy')->name('delete.money.receive');
					Route::get('money-received/get-invoice-numbers/{customer_name}/{currency?}', 'MoneyReceivedController@getInvoiceNumber'); // ajax request
					Route::get('money-received/get-account-numbers-based-on-account-type/{accountType}/{currency}/{financialInstitutionId}', 'MoneyReceivedController@getAccountNumbersForAccountType'); // ajax request
					Route::get('get-interest-rate-for-financial-institution-id','FinancialInstitutionController@getInterestRateForFinancialInstitution')->name('get.interest.rate.for.financial.institution.id');

					// money payments
					Route::get('money-payment', 'MoneyPaymentController@index')->name('view.money.payment');
                    Route::get('money-payment/create/{model?}', 'MoneyPaymentController@create')->name('create.money.payment');
                    Route::post('money-payment/create', 'MoneyPaymentController@store')->name('store.money.payment');
                    Route::get('money-payment/edit/{moneyPayment}', 'MoneyPaymentController@edit')->name('edit.money.payment');
                    Route::put('money-payment/update/{moneyPayment}', 'MoneyPaymentController@update')->name('update.money.payment');
                    Route::delete('money-payment/delete/{moneyPayment}', 'MoneyPaymentController@destroy')->name('delete.money.payment');
					Route::get('money-payment/get-invoice-numbers/{supplier_name}/{currency?}', 'MoneyPaymentController@getInvoiceNumber'); // ajax request
					Route::get('money-payment/get-account-numbers-based-on-account-type/{accountType}/{currency}/{financialInstitutionId}', 'MoneyPaymentController@getAccountNumbersForAccountType'); // ajax request
					Route::post('mark-payable-cheques-as-paid', 'MoneyPaymentController@markChequesAsPaid')->name('payable.cheque.mark.as.paid');
					Route::post('mark-outgoing-transfer-as-paid', 'MoneyPaymentController@markOutgoingTransfersAsPaid')->name('outgoing.transfer.mark.as.paid');
					Route::get('get-supplier-invoices','SupplierInvoicesController@getSupplierInvoicesForSupplier')->name('get.supplier.invoices');
					
					// cash expense
					
					
					Route::get('cash-expense', 'CashExpenseController@index')->name('view.cash.expense');
                    Route::get('cash-expense/create/{model?}', 'CashExpenseController@create')->name('create.cash.expense');
                    Route::post('cash-expense/create', 'CashExpenseController@store')->name('store.cash.expense');
                    Route::get('cash-expense/edit/{cashExpense}', 'CashExpenseController@edit')->name('edit.cash.expense');
                    Route::put('cash-expense/update/{cashExpense}', 'CashExpenseController@update')->name('update.cash.expense');
                    Route::delete('cash-expense/delete/{cashExpense}', 'CashExpenseController@destroy')->name('delete.cash.expense');
					Route::get('cash-expense/get-account-numbers-based-on-account-type/{accountType}/{currency}/{financialInstitutionId}', 'CashExpenseController@getAccountNumbersForAccountType'); // ajax request
					Route::post('mark-payable-cheques-as-paid', 'CashExpenseController@markChequesAsPaid')->name('payable.cheque.mark.as.paid');
					Route::post('mark-outgoing-transfer-as-paid', 'CashExpenseController@markOutgoingTransfersAsPaid')->name('outgoing.transfer.mark.as.paid');

					
					
					Route::post('adjust-customer-due-invoices','CashFlowReportController@adjustCustomerDueInvoices')->name('adjust.customer.dues.invoices');
                    Route::get('unapplied-amounts/{partnerId}', 'UnappliedAmountController@index')->name('view.settlement.by.unapplied.amounts');
                    Route::get('unapplied-amounts/create/{customerInvoiceId}/{modelType}', 'UnappliedAmountController@create')->name('create.settlement.by.unapplied.amounts');
                    Route::post('unapplied-amounts/create/{modelType}', 'UnappliedAmountController@store')->name('store.settlement.by.unapplied.amounts');
                });

                /**
                 * * End Of Financial Institution Routes
                 *
                 */

                // Route::resource('sharing-links', 'SharingLinkController');
                // Route::get('shareable-paginate', 'SharingLinkController@paginate')->name('admin.get.sharing.links');
                // Route::get('export-shareable-link', 'SharingLinkController@export')->name('admin.export.sharing.link');

				Route::get('fixed-payments-at-end-php/{financialInstitution}', 'Loans2Controller@viewTestLoanAtEndPhp')->name('fixed.loan.fixed.at.end.php');
				Route::post('loan-by-php/{financialInstitution}','Loans2Controller@calculateByPhp')->name('loan2.store.php');
				Route::post('save-fixed-at-end', 'SaveFixedAtEndController@__invoke')->name('save.fixed.at.end');
				Route::post('save-loan-dates', 'SaveLoanDatesController@__invoke')->name('save.loan.dates');
				Route::get('fixed-payments-at-end', 'Loans2Controller@create')->name('fixed.loan.fixed.at.end');
				Route::get('calculate-loan-amount', 'Loans2Controller@create')->name('calc.loan.amount');
				Route::get('calculate-interest-percentage', 'Loans2Controller@create')->name('calc.interest.percentage');
				Route::get('fixed-payments-at-beginning', 'Loans2Controller@create')->name('fixed.loan.fixed.at.beginning');
				Route::get('variable-payments', 'Loans2Controller@create')->name('variable.payments');


                Route::post('edit-table-cell', [EditTableCellsController::class, '__invoke'])->name('admin.edit.table.cell');
                Route::delete('delete-revenue-business-line/{revenueBusinessLine}', [RevenueBusinessLineController::class, 'deleteRevenueBusinessLine'])->name('admin.delete.revenue.business.line');
                Route::delete('delete-service-category/{serviceCategory}', [RevenueBusinessLineController::class, 'deleteServiceCategory'])->name('admin.delete.service.category');
                Route::delete('delete-service-item/{serviceItem}', [RevenueBusinessLineController::class, 'deleteServiceItem'])->name('admin.delete.service.item');

                //helpers
                Route::get('get-edit-form', [getEditFormController::class, '__invoke']);
                Route::get('helpers/updateCitiesBasedOnCountry', [UpdateCitiesBasedOnCountryController::class, '__invoke']);
                Route::get('helpers/updateBasedOnGlobalController', [UpdateBasedOnGlobalController::class, '__invoke']);
                //Quick pricing calculator
                Route::get('quick-pricing-calculator', [QuickPricingCalculatorController::class, 'view'])->name('admin.view.quick.pricing.calculator');

                Route::get('quick-pricing-calculator/create/{pricingPlanId?}', [QuickPricingCalculatorController::class, 'create'])->name('admin.create.quick.pricing.calculator');
                Route::get('quick-pricing-calculator/{quickPricingCalculator}/edit', [QuickPricingCalculatorController::class, 'edit'])->name('admin.edit.quick.pricing.calculator');
                Route::post('quick-pricing-calculator/{quickPricingCalculator}/update', [QuickPricingCalculatorController::class, 'update'])->name('admin.update.quick.pricing.calculator');
                Route::post('quick-pricing-calculator/store', [QuickPricingCalculatorController::class, 'store'])->name('admin.store.quick.pricing.calculator');
                Route::get('export-quick-pricing-calculator', 'QuickPricingCalculatorController@export')->name('admin.export.quick.pricing.calculator');
                Route::get('get-quick-pricing-calculator', 'QuickPricingCalculatorController@paginate')->name('admin.get.quick.pricing.calculator');
                Route::delete('delete-quick-pricing-calculator/{quickPricingCalculator}', 'QuickPricingCalculatorController@destroy')->name('admin.delete.quick.pricing.calculator');

                //Quotation pricing calculator
                // Route::get('quotation-pricing-calculator', [QuotationPricingCalculatorController::class, 'view'])->name('admin.view.quotation.pricing.calculator');
                // Route::get('quotation-pricing-calculator/create', [QuotationPricingCalculatorController::class, 'create'])->name('admin.create.quotation.pricing.calculator');
                // Route::get('quotation-pricing-calculator/{quotationPricingCalculator}/edit', [QuotationPricingCalculatorController::class, 'edit'])->name('admin.edit.quotation.pricing.calculator');
                // Route::post('quotation-pricing-calculator/{quotationPricingCalculator}/update', [QuotationPricingCalculatorController::class, 'update'])->name('admin.update.quotation.pricing.calculator');
                // Route::post('quotation-pricing-calculator/store', [QuotationPricingCalculatorController::class, 'store'])->name('admin.store.quotation.pricing.calculator');
                // Route::get('export-quotation-pricing-calculator', 'QuotationPricingCalculatorController@export')->name('admin.export.quotation.pricing.calculator');
                // Route::get('get-quotation-pricing-calculator', 'QuotationPricingCalculatorController@paginate')->name('admin.get.quotation.pricing.calculator');

                Route::resource('pricing-expenses', 'PricingExpensesController');
                Route::resource('positions', 'PositionsController');
                Route::resource('pricing-plans', 'PricingPlansController');

                //Revenue Business Line
                Route::get('get-revenue-business-line', 'RevenueBusinessLineController@paginate')->name('admin.get.revenue-business-line');
                Route::get('get-revenue-business-line/create', 'RevenueBusinessLineController@create')->name('admin.create.revenue-business-line');
                Route::post('get-revenue-business-line/create', 'RevenueBusinessLineController@store')->name('admin.store.revenue-business-line');
                Route::get('export-revenue-business-line', 'RevenueBusinessLineController@export')->name('admin.export.revenue-business-line');
                Route::resource('revenue-business', 'RevenueBusinessLineController')->names([
                    'index' => 'admin.view.revenue.business.line',
                ]);
                Route::get('revenue-business-edit/{revenueBusinessLine}/{serviceCategory?}/{serviceItem?}', 'RevenueBusinessLineController@editForm')->name('admin.edit.revenue');
                Route::post('admin.update.revenue-business', 'RevenueBusinessLineController@updateForm')->name('admin.update.revenue');

				Route::post('send-cheques-to-collection', 'MoneyReceivedController@sendToCollection')->name('cheque.send.to.collection');
                Route::get('send-cheques-to-safe/{moneyReceived}', 'MoneyReceivedController@sendToSafe')->name('cheque.send.to.safe');
			Route::post('send-cheques-to-collection/{moneyReceived}', 'MoneyReceivedController@applyCollection')->name('cheque.apply.collection');
                Route::get('send-cheques-to-rejected-safe/{moneyReceived}', 'MoneyReceivedController@sendToSafeAsRejected')->name('cheque.send.to.rejected.safe');
                Route::get('send-cheques-to-under-collection-safe/{moneyReceived}', 'MoneyReceivedController@sendToUnderCollection')->name('cheque.send.to.under.collection');
                Route::get('down-payments/get-contracts-for-customer-with-start-and-end-date', 'MoneyReceivedController@getContractsForCustomerWithStartAndEndDate')->name('get.contracts.for.customer.with.start.and.end.date'); // ajax request
                Route::get('down-payments/get-contracts-for-customer', 'MoneyReceivedController@getContractsForCustomer')->name('get.contracts.for.customer'); // ajax request
                Route::get('down-payments/get-contracts-for-supplier', 'MoneyPaymentController@getContractsForCustomer')->name('get.contracts.for.supplier'); // ajax request
                Route::get('down-payments/get-sales-orders-for-contract/{contract_id}/{currency?}', 'MoneyReceivedController@getSalesOrdersForContract'); // ajax request

                Route::get('/filter-labeling-items', 'SalesGatheringController@filterLabelingItems')->name('filter.labeling.item');
                Route::get('/create-labeling-items', 'DynamicItemsController@createLabelingItems')->name('create.labeling.items');
                Route::get('/create-labeling-form', 'DynamicItemsController@createLabelingForm')->name('create.labeling.form');
                Route::get('/create-labeling-items/building-label', 'DynamicItemsController@showBuildingLabel')->name('show.building.label');
                Route::get('/create-labeling-items/ff&e-label', 'DynamicItemsController@showffeLabel')->name('show.ffe.label');
                Route::post('/create-labeling-items', 'DynamicItemsController@storeItemsCount')->name('add.count.dynamic.items');
                Route::post('store-new', 'DynamicItemsController@storeNewModal')->name('admin.store.new.modal.dynamic');

                Route::post('/store-dynamic-items', 'DynamicItemsController@storeSubItems')->name('store.dynamic.items.names');
                Route::get('/create-item/{model}', 'SalesGatheringTestController@createModel')->name('create.sales.form');
                Route::post('/create-item/{model}', 'SalesGatheringTestController@storeModel')->name('admin.store.analysis');
                Route::post('/close-period-action', 'ClosePeriodController@execute')->name('store.close.period');

                Route::get('/create-item/{model}/edit/{modelId}', 'SalesGatheringTestController@editModel')->name('edit.sales.form');
                Route::post('/create-item/{model}/update/{modelId}', 'SalesGatheringTestController@updateModel')->name('admin.update.analysis');

                Route::resource('sharing-links', 'SharingLinkController');

                Route::prefix('/SalesGathering')->group(function () {
                    Route::get('SalesTrendAnalysis', 'AnalysisReports@salesAnalysisReports')->name('sales.trend.analysis');
                    Route::get('SalesExportAnalysis', 'AnalysisReports@exportAnalysisReports')->name('sales.export.analysis');
                    Route::get('SalesBreakdownAnalysis', 'AnalysisReports@salesAnalysisReports')->name('sales.breakdown.analysis');

                    //########### Average Prices Post Link ############
                    Route::post('/AveragePrices/Result', 'Analysis\SalesGathering\AveragePricesReport@result')->name('averagePrices.result');
                    //########### Breakdown Post Link ############
                    Route::post('/SalesBreakdownAnalysis/Result', 'Analysis\SalesGathering\SalesBreakdownAgainstAnalysisReport@salesBreakdownAnalysisResult')->name('salesBreakdown.analysis.result');
                    Route::post('/SalesDiscountSalesBreakdownAnalysis/Result', 'Analysis\SalesGathering\SalesBreakdownAgainstAnalysisReport@discountsSalesBreakdownAnalysisResult')->name('salesBreakdown.salesDiscounts.analysis.result');
                    //########### Two Dimensional Breakdown Post Link ############
                    Route::post('/TwoDimensionalBreakdown', 'Analysis\SalesGathering\TwodimensionalSalesBreakdownAgainstAnalysisReport@result')->name('TwoDimensionalBreakdown.result');
                    Route::post('/DiscountsAnalysisResult', 'Analysis\SalesGathering\DiscountsAnalysisReport@result')->name('discounts.analysis.result');

                    //########### Two Dimensional Breakdown Ranking Post Link ############
                    Route::post('/TwoDimensionalBreakdownRanking', 'Analysis\SalesGathering\TwodimensionalSalesBreakdownAgainstRankingAnalysisReport@result')->name('TwoDimensionalBreakdownRanking.result');
                    Route::post('/DiscountsRankingAnalysisResult', 'Analysis\SalesGathering\DiscountsRankingAnalysisReport@result')->name('discounts.Ranking.analysis.result');

                    // Providers Two Dimensional Breakdown
                    Route::post('/ProvidersTwoDimensionalBreakdown', 'Analysis\SalesGathering\ProvidersTwodimensionalSalesBreakdownAgainstAnalysisReport@result')->name('ProvidersTwoDimensionalBreakdown.result');
                    Route::get('/get-customers-from-currencies/{modelType}', 'AgingController@getCustomersFromBusinessUnitsAndCurrencies')->name('get.customers.or.suppliers.from.business.units.currencies');
                    //########### Sales Trend Analysis Links +   Average Prices +  Breakdown ############
                    // For [Zone , Sales Channels , Categories , Products , Product Items , Branches , Business Sectors ,Sales Persons]
                    $routesDefinition = (new RoutesDefinition());
                    $saleTrendRoutes = $routesDefinition->salesTrendAnalysisRoutes();
                    // dd($saleTrendRoutes);
                    foreach ($saleTrendRoutes as $nameOfMainItem => $info) {
                        if (isset($info['class_path'])) {
                            // 						if($nameOfMainItem == 'Products'){
                            // dd($info['name'] . '.sales.analysis',!isset($info['analysis_view']));
                            // 						}

                            // Not All Reports Contains Analysis Reports
                            !isset($info['analysis_view']) ?: Route::get('/' . $nameOfMainItem . 'SalesAnalysis/View', $info['class_path'] . '@' . $info['analysis_view'])->name($info['name'] . '.sales.analysis');
                            !isset($info['analysis_result']) ?: Route::post('/' . $nameOfMainItem . 'SalesAnalysis/Result', $info['class_path'] . '@' . $info['analysis_result'])->name($info['name'] . '.sales.analysis.result');
                            Route::post('/' . $nameOfMainItem . 'AgainstAnalysis/Result', $info['class_path'] . '@' . $info['against_result'])->name($info['name'] . '.analysis.result');
                            // Against Reports
                            foreach ($info['sub_items'] as $viewName => $sub_item) {
                                Route::get('/' . $nameOfMainItem . 'Against' . $viewName . 'Analysis/View', $info['class_path'] . '@' . $info['against_view'])->name($info['name'] . '.' . $sub_item . '.analysis');
                            }
                            Route::post('/' . $nameOfMainItem . 'AgainstSalesDiscountAnalysis/Result', $info['class_path'] . '@' . $info['discount_result'])->name($info['name'] . '.salesDiscount.analysis.result');
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

                    //########### Two Dimensional Breakdown ############
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

                    //########### Two Dimensional Ranking ############
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

                    //########### Sales Report ############
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
                    Route::get('/BusinessUnitsComparing/View', 'Analysis\SalesGathering\IntervalsComparingReport@index')->name('intervalComparing.businessUnits.analysis');
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

                    Route::get('export-analysis-reports/{firstColumn}/{secondColumn}', 'Analysis\SalesGathering\ExportAgainstAnalysisReport@index')->name('view.export.against.report');
                    Route::post('export-analysis-reports', 'Analysis\SalesGathering\ExportAgainstAnalysisReport@result')->name('result.export.against.report');

                    // Customers Nature
                    Route::post('/CustomersNaturesAnalysis/Result', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@result')->name('customersNatures.analysis.result');
                    Route::post('/CustomersNaturesAnalysisTwoDimensional/Result', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@twoDimensionalResult')->name('customersNatures.twoDimensional.analysis.result');
                    Route::get('/CustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('customersNatures.analysis');
                    Route::get('/ZonesVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('zones.vs.customersNatures');
                    Route::get('/SalesChannelsVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('salesChannels.vs.customersNatures');
                    Route::get('/BusinessSectorsVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('businessSectors.vs.customersNatures');
                    Route::get('/BusinessUnitsVsCustomersNaturesAnalysis/View', 'Analysis\SalesGathering\CustomersNaturesAnalysisReport@index')->name('businessUnits.vs.customersNatures');
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
                    Route::any('/ForecastedSalesValues', 'QuantitySalesForecastReport@forecastedSalesValues')->name('forecasted.sales.values');
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


                //########### Exportable Fields Selection Routes ############
                Route::get('fieldsToBeExported/{model}/{view}', 'ExportTable@customizedTableField')->name('table.fields.selection.view');
                Route::post('fieldsToBeExportedSave/{model}/{modelName}', 'ExportTable@customizedTableFieldSave')->name('table.fields.selection.save');
            });
        }
    );
});

Route::delete('deleteMultiRowsFromCaching/{company}/{modelName}', [DeleteMultiRowsFromCaching::class, '__invoke'])->name('deleteMultiRowsFromCaching');
Route::get('deleteAllRowsFromCaching/{company}/{modelType}', [DeleteAllRowsFromCaching::class, '__invoke'])->name('deleteAllCaches');
Route::post('get-uploading-percentage/{companyId}/{modelName}', [getUploadPercentage::class, '__invoke']);
Route::get('{lang}/remove-company-image/{company}', function ($lang, Company $company) {
    if ($company->getFirstMedia('default')) {
        $company->getFirstMedia('default')->delete();
    }

    return redirect()->back()->with('success', __('Company Image Has Been Deleted Successfully'));
})->name('remove.company.image');

Route::get('getStartDateAndEndDateOfIncomeStatementForCompany', 'HomeController@getIncomeStatementStartDateAndEndDate');
Route::get('removeSessionForRedirect', function () {
    if (session()->has('redirectTo')) {
        $url = session()->get('redirectTo');
        session()->forget('redirectTo');

        return response()->json([
            'status' => true,
            'url' => $url
        ]);
    }
});
Route::get('testing', function (Request $request) {
    // foreach()
    $test = Test::find(1);
    $test->delete();
    // $test->update([
    // 	'debit'=>0,
    // 	'updated_at'=>now()
    // ]);
    dd('updated2....');
    // foreach(Test::first() as $test){}
});
