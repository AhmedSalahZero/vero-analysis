<?php

namespace App\Providers;

use App\Exports\LabelingItemExport;

use App\Http\Controllers\ExportTable;
use App\Models\Company;
use App\Models\CustomersInvoice;
use App\Models\MoneyReceived;
use App\Models\Section;
use App\Models\User;
use App\Observers\CustomerInvoiceObserver;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Font;
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
		$moneyReceived = MoneyReceived::find(3);
		// dd(Str::slug('Time Deposit (T/D)'));
		// dd($moneyReceived->settlements);
		\PhpOffice\PhpSpreadsheet\Shared\Font::setAutoSizeMethod(Font::AUTOSIZE_METHOD_EXACT);
		 CustomersInvoice::observe(CustomerInvoiceObserver::class);
		require_once storage_path('dompdf/vendor/autoload.php');
		require_once app_path('Helpers/HArr.php');
		
		Collection::macro('formattedForSelect',function(bool $isFunction , string $idAttrOrFunction ,string $titleAttrOrFunction ){
			return $this->map(function($item) use ($isFunction , $idAttrOrFunction ,$titleAttrOrFunction ){
				return [
					'value' => $isFunction ? $item->$idAttrOrFunction() : $item->{$idAttrOrFunction} ,
					'title' => $isFunction ? $item->$titleAttrOrFunction() : $item->{$titleAttrOrFunction}
				];
			})->toArray();
		});
		
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
