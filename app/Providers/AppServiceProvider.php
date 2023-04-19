<?php

namespace App\Providers;

use App\Http\Controllers\ExportTable;
use App\Mail\sendDeleteTestMail;
use App\Models\BalanceSheetItem;
use App\Models\CashFlowStatement;
use App\Models\CashFlowStatementItem;
use App\Models\Company;

use App\Models\IncomeStatement;
use App\Models\Language;
use App\Models\SalesGathering;
use App\Models\Section;
use Auth;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Mail;
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


	public function boot(Request $request)
	{
		// $incomeStatement = IncomeStatement::find(119);
		// $incomeStatement->refreshCalculationFor('forecast');
		// $incomeStatement->refreshCalculationFor('actual');
		// $incomeStatement->refreshCalculationFor('adjusted');
		// $incomeStatement->refreshCalculationFor('modified');
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
			View::share('exportables', (new ExportTable)->customizedTableField($currentCompany, 'SalesGathering', 'selected_fields'));
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
			}
		});
	}








	// }
}
