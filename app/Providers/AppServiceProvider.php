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

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot(Request $request)
	{
		// $items = [
		// 	"01-01-2021" => 1,
		// 	"01-02-2021" => 2,
		// 	"01-03-2021" => 3,
		// 	"01-04-2021" => 4,
		// 	"01-05-2021" => 5,
		// 	"01-06-2021" => 6,
		// 	"01-07-2021" => 7,
		// 	"01-08-2021" => 8,
		// 	"01-09-2021" => 9,
		// 	"01-10-2021" => 10,
		// 	"01-11-2021" => 11,
		// 	"01-12-2021" => 12,
		// 	"01-01-2022" => 1,
		// ];
		// $interval = 'quarterly';
		// dd();

		// if(!isProduction()){

		//     View::composer('*',function($view){
		//     $view->with('client_sections',[]);
		//     $view->with('exportables',[]);
		//     $view->with('super_admin_sections',[]);
		//     $view->with('lang','en');
		//     $view->with('company',Company::find(Request()->segment(2)));
		// });

		// }

		// Mail::to('ahmedconan17@yahoo.com')->send(new sendDeleteTestMail());
		// else{
		// throw new \Exception('Exeption message Here');

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
