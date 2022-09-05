<?php

namespace App\Providers;

use App\Http\Controllers\ExportTable;
use App\Models\Company;
use App\Models\Language;

use App\Models\SalesGathering;
use App\Models\Section;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::share('langs',Language::all());
        View::share('lang',app()->getLocale());
        $currentCompany = Company::find(Request()->segment(2)) ;
        if($currentCompany){
          View::share('exportables', (new ExportTable)->customizedTableField($currentCompany, 'SalesGathering', 'selected_fields'));
        }
        View::composer('*' , function($view){
            
            $requestData = Request()->all() ; 
            if(isset($requestData['start_date']) && isset($requestData['end_date']))
            {
                $view->with([
                'start_date'=>$requestData['start_date'] , 
                'end_date'=>$requestData['end_date'] , 
            ]);    
            }
            elseif(isset($requestData['date']))
            {
                $view->with([
                    'date'=>$requestData['date']
                ]);
            }
            
        });
    
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
