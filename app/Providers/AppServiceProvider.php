<?php

namespace App\Providers;

use App\Http\Controllers\ExportTable;
use App\Jobs\Caches\HandleBreakdownDashboardCashingJob;
use App\Mail\sendDeleteTestMail;
use App\Models\BalanceSheetItem;
use App\Models\CashFlowStatement;
use App\Models\CashFlowStatementItem;

use App\Models\Company;
use App\Models\IncomeStatement;
use App\Models\Language;
use App\Models\SalesGathering;
use App\Models\Section;
use App\Models\User;
use App\ReadyFunctions\CalculateDurationService;
use App\ReadyFunctions\SeasonalityService;
use Auth;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Mail;
use Spatie\Permission\Models\Permission;
use stdClass;

class AppServiceProvider extends ServiceProvider
{
	
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	
	 
	public function register()
	{
		if ($this->app->isLocal()) {
			$this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
		}
		// 
	}
	
	
	public function boot()
	{
		
		require_once storage_path('dompdf/vendor/autoload.php');
		require_once app_path('Helpers/HArr.php');
		
		
		
		
		// $company = Company::find(44);
		/*
		*/
		// dispatch((new HandleBreakdownDashboardCashingJob($company)));
		// $years = $this->getIntervalYearsFormCompany(); 
		// dd($years);
		// $x = getEndYearBasedOnDataUploaded(Company::find(2),'jan');
		// dd($x);
		// dd(now()->format('Y'));
		// dd(number_unformat('112,500.456', FILTER_SANITIZE_NUMBER_INT));
		// Gate::before(function($user){
		// 	return true ;
		// });
		// foreach([1,2,3] as $number){
		// 	if($number == 1){
		// 		 try{
		// 			Permission::findByName('abc');
		// 		 }
		// 		 catch(\Exception $e){
		// 			logger('inside exceptio');
		// 		 }
		// 	}else{
		// 		logger('from else');
		// 	}
			
		// }
		// Zones Sales Breakdown Analysis 
	
		// dd($x);
		// dd(searchWordInstr(['products / service'],'( Products / Service ) Average Prices Per Category'));

		if(true){
			app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
			app()->make(\Spatie\Permission\PermissionRegistrar::class)->clearClassPermissions();
			$permissions = getPermissions();
			foreach($permissions as $permission){
				try{
					Permission::findByName($permission['name']);
				}
				catch(\Exception $e){
					$permission = Permission::create($permission);
					foreach(User::all() as $user){
						$user->givePermissionTo($permission);
					}
				}
			}	
		}
		


		// $itemStartDate = '2023-01-01';
		// $studyEndDate = '2028-02-01';
		// $studyDuration = 5;
		// $monthsDurationsPerYear = (new CalculateDurationService())->calculateMonthsDurationPerYear($itemStartDate, $studyEndDate, $studyDuration);
		// $revenueItem = [
		// 	'seasonality' => 'distribute_quarterly',
		// 	'quarters' => [
		// 		20, 20, 30, 30
		// 	],
		// 	'distribution_months_values' => []
		// ];
		// $x = SeasonalityService::salesSeasonality($revenueItem, $monthsDurationsPerYear);
		// dd($x);
		//  $incomeStatement = IncomeStatement::find(281);
		// $incomeStatement->refreshCalculationFor('forecast');
		// $incomeStatement->refreshCalculationFor('actual');
		// $incomeStatement->refreshCalculationFor('adjusted');
		//  $incomeStatement->refreshCalculationFor('forecast');
		$Language = new stdClass();
		$Language->id = 2;
		$Language->name = 'Arabic';
		$Language->code = 'ar';
		$Language->create_at = Carbon::make('2021-05-27 09:04:17');
		$Language2 = new stdClass();
		$Language2->id = 1;
		$Language2->name = 'English';
		$Language2->code = 'en';
		$Language2->create_at = Carbon::make('2021-05-27 09:04:17');

		$languages = collect([
			$Language2,
			$Language
		]);


		View::share('langs', $languages);
		// View::share('langs',Language::all());
		View::share('lang', app()->getLocale());

		$currentCompany = Company::find(Request()->segment(2));

		if ($currentCompany) {
			$excelType ='SalesGathering';
			if(in_array('uploading',Request()->segments())){
				$excelType = Request()->segment(4);
			}
			View::share('exportables', (new ExportTable)->customizedTableField($currentCompany, $excelType, 'selected_fields'));
			View::share('company', $currentCompany);
		}

		View::composer('*', function ($view) {

			$requestData = Request()->all();
			if (isset($requestData['start_date']) && isset($requestData['end_date'])) {
				$view->with([
					'start_date' => $requestData['start_date'],
					'end_date' => $requestData['end_date'],
				]);
			} elseif (isset($requestData['date'])) {
				$view->with([
					'date' => $requestData['date']
				]);
			}
		});
		View::composer('*', function ($view) {
			if (Auth::check()) {


				if (request()->route()->named('home') || (!isset(request()->company))) {
					$sections = [Section::with('subSections')->find(2)];
					$view->with('client_sections', $sections);
				} else {
					$view->with('client_sections', Section::mainClientSideSections()->with('subSections')->get());
				}
				if (Auth::user()->hasrole('super-admin')) {
					$view->with('super_admin_sections', Section::mainSuperAdminSections()->get());
				}
				if (Auth::user()->hasrole('company-admin')) {
					$view->with('super_admin_sections', Section::mainCompanyAdminSections()->get());
				}
			}
		});
	}








	// }
}
