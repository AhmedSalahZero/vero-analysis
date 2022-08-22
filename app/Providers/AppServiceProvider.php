<?php

namespace App\Providers;

use App\Http\Controllers\ExportTable;
use App\Jobs\Caches\HandleCashingJob;
use App\Models\Branch;
use App\Models\CachingCompany;
use App\Models\Company;
use App\Models\Language;

use App\Models\SalesGathering;
use App\Models\Section;
use App\Services\Caching\CashingService;
use App\Services\Caching\CustomerDashboardCashing;
use Auth;
use Illuminate\Contracts\Pagination\Paginator;
// use Illuminate\Supp  ort\Facades\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\Input;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        // $section = Section::where('id',260)->first();
        // dd($section->subSections);
                // Paginator::useBootstrap();
      
        View::share('langs',Language::all());
        View::share('lang',app()->getLocale());
        $currentCompany = Company::find(Request()->segment(2)) ;
        if($currentCompany){
          View::share('exportables', (new ExportTable)->customizedTableField($currentCompany, 'SalesGathering', 'selected_fields'));
        }
        
        //  foreach(Company::all() as $company){
        //        $cachingService = new CashingService($company);
        //           $cachingService->refreshCashing();
        // }
            
        View::composer('*', function($view){
            if (Auth::check()) {
                

                if(request()->route()->named('home') || (!isset(request()->company)) ){
                    $sections = [Section::with('subSections')->find(2)];
                    $view->with('client_sections',$sections);
                }else{
                    $view->with('client_sections',Section::mainClientSideSections()->with('subSections')->get()) ;
                }
                if(Auth::user()->hasrole('super-admin')){
                    $view->with('super_admin_sections',Section::mainSuperAdminSections()->get());
                }
            }
            
        });

        
 

    }
}
