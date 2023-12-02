<?php

namespace App\Http\Controllers;

use App\Imports\ImportData;
use App\Jobs\Caches\HandleBreakdownDashboardCashingJob;
use App\Jobs\Caches\HandleCustomerDashboardCashingJob;
use App\Jobs\Caches\HandleCustomerNatureCashingJob;
use App\Jobs\Caches\RemoveIntervalYearCashingJob;
use App\Jobs\CalculateNetBalanceWithMonthlyDebits;
use App\Jobs\NotifyUserOfCompletedImport;
use App\Jobs\RemoveCachingCompaniesData;
use App\Jobs\SalesGatheringTestJob;
use App\Jobs\ShowCompletedMessageForSuccessJob;
use App\Models\ActiveJob;
use App\Models\CachingCompany;
use App\Models\Company;
use App\Models\SalesGatheringTest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalesGatheringTestController extends Controller
{
	public function paginate($items, $perPage = 50, $page = null, $options = [])
	{
		$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
		$items = $items instanceof Collection ? $items : Collection::make($items);
		return (new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
			'path'  => Request()->url(),
			'query' => Request()->query(),
		]));
	}

	public function import(Company $company,string $modelName = 'SalesGathering')
	{
		$uploadParamsType = getUploadParamsFromType($modelName);
		$importHeaderText = $uploadParamsType['importHeaderText'];
		$company_id = $company->id;
		$user_id = Auth::user()->id;
		$exportableFields = exportableFields($company_id, $modelName);
		if ($exportableFields === null) {
			toastr()->warning('Please choose exportable fields first');
			return redirect()->back();
		}
		// $salesGatherings = SalesGatheringTest::company()->paginate(50);


		if (request()->method()  == 'GET') {
			$cacheKeys = CachingCompany::where('company_id', $company_id)->where('model',$modelName)->get();

			$salesGatherings = [];
			foreach ($cacheKeys as $cacheKey) {
				$salesGatherings = array_merge(Cache::get($cacheKey->key_name) ?: [], $salesGatherings);
			}
		
			$salesGatherings = $this->paginate($salesGatherings);

			$exportableFields  = (new ExportTable)->customizedTableField($company, $modelName, 'selected_fields');
			$viewing_names = array_values($exportableFields);
			$db_names = array_keys($exportableFields);
			return view('client_view.sales_gathering.import', compact('company', 'salesGatherings', 'viewing_names', 'db_names','modelName','importHeaderText'));
		} else {


			// Get The Selected exportable fields returns a pair of ['field_name' => 'viewing name']
			$exportable_fields = (new ExportTable)->customizedTableField($company, $modelName, 'selected_fields');

			// $salesGathering = SalesGathering::where('company_id',$company_id)->get();
			// Customizing the collection to be exported

			$salesGathering_fields = [];
			foreach ($exportable_fields as $field_name => $column_name) {
				$salesGathering_fields[$field_name] = $column_name;
			}
			$salesGathering_fields['company_id'] = $company_id;
			$salesGathering_fields['created_by'] = $user_id;

			$active_job = ActiveJob::where('company_id',  $company_id)->where('model',$modelName)->where('status', 'test_table')->where('model_name', 'SalesGatheringTest')->first();
			if ($active_job === null) {

				$active_job = ActiveJob::create([
					'company_id'  => $company_id,
					'model_name'  => 'SalesGatheringTest',
					'status'  => 'test_table',
					'model'=>$modelName
				]);
			}
			$validationCacheKey = generateCacheKeyForValidationRow($company_id,$modelName);
			// dd($validationCacheKey);
			Cache::forget($validationCacheKey);
			
			$fileUpload = new  ImportData($company_id, request()->format, 'SalesGatheringTest', $salesGathering_fields, $active_job->id,auth()->user()->id,$modelName);
				Excel::queueImport($fileUpload, request()->file('excel_file'))->chain([
					new NotifyUserOfCompletedImport(request()->user(), $active_job->id,$company_id,$modelName),
					new ShowCompletedMessageForSuccessJob($company_id, $active_job->id,$modelName)
				]);
				
				
			// dd($fileUpload->getRowCount());



			toastr('Import started!', 'success');

			return redirect()->back();
		}
	}
	public function insertToMainTable(Company $company , string $modelName)
	{
		$active_job = ActiveJob::where('company_id',  $company->id)->where('model',$modelName)->where('status', 'save_to_table')->where('model_name', 'SalesGatheringTest')->first();
		if ($active_job === null) {

			$active_job = ActiveJob::create([
				'company_id'  => $company->id,
				'model_name'  => 'SalesGatheringTest',
				'status'  => 'save_to_table',
				'model'=>$modelName
			]);
		}
		
		$validationCacheKey = generateCacheKeyForValidationRow($company->id,$modelName);
		Cache::forget($validationCacheKey);
		Cache::forget(getShowCompletedTestMessageCacheKey($company->id,$modelName));
		if($modelName == 'SalesGathering'){
			SalesGatheringTestJob::withChain([
				new RemoveIntervalYearCashingJob($company),
				new NotifyUserOfCompletedImport(request()->user(), $active_job->id, $company->id,$modelName),
				new RemoveCachingCompaniesData($company->id,$modelName),
				new HandleCustomerDashboardCashingJob($company),
				new HandleCustomerNatureCashingJob($company),
				new HandleBreakdownDashboardCashingJob($company),
			])->dispatch($company->id,$modelName);
			
		}
		elseif($modelName == 'CustomerInvoice'){
			SalesGatheringTestJob::withChain([
				new NotifyUserOfCompletedImport(request()->user(), $active_job->id, $company->id,$modelName),
				new CalculateNetBalanceWithMonthlyDebits($company->id,$modelName),
				new RemoveCachingCompaniesData($company->id,$modelName),
			])->dispatch($company->id,$modelName);
		}
		else{
			SalesGatheringTestJob::withChain([
				// new RemoveIntervalYearCashingJob($company),
				new NotifyUserOfCompletedImport(request()->user(), $active_job->id, $company->id,$modelName),
				new RemoveCachingCompaniesData($company->id,$modelName),
				// new HandleCustomerDashboardCashingJob($company),
				// new HandleCustomerNatureCashingJob($company),
				// new HandleBreakdownDashboardCashingJob($company),
			])->dispatch($company->id,$modelName);
		}
		// remove old cashing for these company 

		return redirect()->back();
	}


	public function edit(Company $company, SalesGatheringTest $salesGatheringTest,string $modelName)
	{
		$exportableFields  = (new ExportTable)->customizedTableField($company, $modelName, 'selected_fields');
		$db_names = array_keys($exportableFields);
		return view('client_view.sales_gathering.importRowForm', compact('company', 'exportableFields', 'db_names', 'salesGatheringTest'));
	}

	public function update(Request $request, Company $company, SalesGatheringTest $salesGatheringTest,string $modelName)
	{
		$salesGatheringTest->update($request->all());
		toastr()->success('Updated Successfully');
		return redirect()->route('salesGatheringImport', ['company'=>$company->id , 'model'=>$modelName]);
	}

	public function destroy(Company $company, SalesGatheringTest $salesGatheringTest)
	{

		$salesGatheringTest->delete();
		toastr()->error('Deleted Successfully');
		return redirect()->back();
	}

	public function activeJob(Request $request, Company $company,string $modelName)
	{
		$row = DB::table('active_jobs')
			->where('company_id', $company->id)
			->where('status', 'test_table')
			->where('model_name', 'SalesGatheringTest')
			->where('model',$modelName)
			->first();
		return ($row === null) ? 0 :  1;
	}
	public function lastUploadFailed($companyId,$modelName){
		$rows = Cache::get(generateCacheKeyForValidationRow($companyId,$modelName));
		$headers = exportableFields($companyId,$modelName)->fields ;
		$headers = convertIdsToNames($headers);
		ksort($rows);
		return view('client_view.sales_gathering.failed',[
			'rows'=>$rows,
			'headers'=>$headers
		]);
	}

	public function createModel(Company $company ,Request $request, string $modelName )
	{
		$exportables = getExportableFieldsForModel($company->id,$modelName);
	
		return view('admin.create-excel-by-form',[
			'pageTitle'=>__('Create'),
			'type'=>'_create',
			'exportables'=>$exportables,
			'modelName'=>$modelName
		]);
	}
	public function storeModel(Company $company ,Request $request, string $modelName )
	{
		$companyId = $company->id;
		$class = '\App\Models\\'.$modelName ;
		$model = new $class;
		foreach((array)$request->get('tableIds') as $tableId){
			foreach((array)$request->get($tableId) as  $tableDataArr){
					$tableDataArr['company_id']  = $companyId ;
					$modelItem=$model->create($tableDataArr);
					// if($modelName =='CustomerInvoice'){
					// 	$modelItem->syncNetBalance();
					// 	$modelItem->insertInvoiceDateMonthAndYearColumnsInDB();
					// 	$modelItem->calculateAmountInMainCurrency();
					// }
			}
		}
		if($modelName == 'SalesGathering'){
			Artisan::call('caching:run',[
				'company_id'=>[$companyId] 
		   ]);
		}		
		return redirect()->back()->with('success',__('Done'));	
	}
	
	
	
	
	
	public function editModel(Company $company ,Request $request, string $modelName,$modelId )
	{
		$exportables = getExportableFieldsForModel($company->id,$modelName);
		$model = ('\App\Models\\'.$modelName)::find($modelId);
		// dd();
		return view('admin.create-excel-by-form',[
			'pageTitle'=>__('Create'),
			'type'=>'_create',
			'exportables'=>$exportables,
			'modelName'=>$modelName,
			'model'=>$model,
			'removeRepeater'=>true
		]);
	}
	public function updateModel(Company $company ,Request $request, string $modelName,$modelId )
	{
		$companyId = $company->id;
		$model = ('\App\Models\\'.$modelName)::find($modelId) ;
		foreach((array)$request->get('tableIds') as $tableId){
			foreach((array)$request->get($tableId) as  $tableDataArr){
					$tableDataArr['company_id']  = $companyId ;
					// dd($model ,$tableDataArr);
					$model->update($tableDataArr);
					// if($modelName =='CustomerInvoice'){
					// 	$model->syncNetBalance();
					// 	$model->insertInvoiceDateMonthAndYearColumnsInDB();
					// 	$model->calculateAmountInMainCurrency();
					// }
			}
		}
		if($modelName == 'SalesGathering'){
			Artisan::call('caching:run',[
				'company_id'=>[$companyId] 
		   ]);
		}
		return redirect()->route('view.uploading',['company'=>$company->id , 'model'=>$modelName])->with('success',__('Done'));	
	}
	
	
}
