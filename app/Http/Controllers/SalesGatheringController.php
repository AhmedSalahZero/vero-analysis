<?php

namespace App\Http\Controllers;

use App\Exports\ExportData;
use App\Helpers\HArr;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\Log;
use App\Models\SalesGathering;
use App\Models\TablesField;
use Illuminate\Http\Request;
use Schema;

class SalesGatheringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	protected function getSearchDateFieldName(string $modelName,?string $fieldName){
		if(!$fieldName){
			return null;
		}
		if($modelName == 'CustomerInvoice'){
			if($fieldName == 'invoice_due_date'){
				return 'invoice_due_date';
			}
			return 'invoice_date';
		}
		if($modelName == 'SalesGathering'){
			return 'date';
		}
		if($modelName == 'ExportAnalysis'){
			return 'purchase_order_date';
		}
		
	}
    public function index(Company $company, Request $request, string $uploadType='SalesGathering')
    {
        $modelName = $uploadType;
		$fieldValue = $request->get('field') ;
		$searchDateField = $this->getSearchDateFieldName($modelName,$fieldValue);
		$hasField = $request->has('field') ;
        $uploadingArr = getUploadParamsFromType($uploadType);
        $fullModelPath = $uploadingArr['fullModel'];
        $mainDateOrderBy = $uploadingArr['orderByDateField'];
        $uploadPermissionName = $uploadingArr['uploadPermissionName'];
        $exportPermissionName = $uploadingArr['exportPermissionName'];
        $deletePermissionName = $uploadingArr['deletePermissionName'];
        Log::storeNewLogRecord('enterSection', null, __('Data Gathering [ '. $uploadType . ' ]'));

        // $salesGatherings = SalesGathering::company()->orderBy('date','desc')->get;
        $salesGatherings = $fullModelPath::company()->when($hasField, function ($q) use ($request,$fieldValue) {
            $q->where($fieldValue, 'like', '%'.$request->get('value') .'%');
        })
        ->when($request->has('from'), function ($q) use ($request,$searchDateField) {
            $q->where($searchDateField, '>=', $request->get('from'));
        })
        ->when($request->has('to'), function ($q) use ($request,$searchDateField) {
            $q->where($searchDateField, '<=', $request->get('to'));
        })
        ->orderBy($mainDateOrderBy, 'desc')->paginate(50);
        $exportableFields  = (new ExportTable)->customizedTableField($company, $uploadType, 'selected_fields');
        if($modelName == 'CustomerInvoice') {
            unset($exportableFields['withhold_amount']);
        }
        $viewing_names = array_values($exportableFields);
        $db_names = array_keys($exportableFields);
        
        $notPeriodClosedCustomerInvoices = $modelName == 'CustomerInvoice' ? CustomerInvoice::getOnlyNotClosedPeriods() : null;
        $navigators =$this->getUploadingPageExportNavigation($modelName,$uploadPermissionName,$exportPermissionName,$deletePermissionName);
        return view('client_view.sales_gathering.index', compact('navigators', 'salesGatherings', 'company', 'viewing_names', 'db_names', 'uploadPermissionName', 'exportPermissionName', 'deletePermissionName', 'modelName', 'notPeriodClosedCustomerInvoices'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        $customerInvoice = new SalesGatheringViewModel($company);

        return view('client_view.sales_gathering.form', $customerInvoice);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        // $request['company_id'] = $company->id;
        SalesGathering::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesGathering  $salesGathering
     * @return \Illuminate\Http\Response
     */
    public function show(SalesGathering $salesGathering)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesGathering  $salesGathering
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, SalesGathering $salesGathering)
    {

        $salesGathering  = new SalesGatheringViewModel($company, $salesGathering);

        return view('client_view.sales_gathering.form', $salesGathering);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesGathering  $salesGathering
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company, SalesGathering $salesGathering)
    {

        $salesGathering->update($request->all());
        toastr()->success('Updated Successfully');
        return (new SalesGatheringViewModel($company, $salesGathering))->view('client_view.sales_gathering.form');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesGathering  $salesGathering
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, SalesGathering $salesGathering)
    {
        // dd('delete');
        toastr()->error('Deleted Successfully');
        $salesGathering->delete();
        return redirect()->back();
    }
    public function export(Company $company, string $modelName)
    {
        $uploadParams = getUploadParamsFromType($modelName);
        $exportableFields = exportableFields($company->id, $modelName);
        // If there are no exportable fields were found return with a warning msg
        if ($exportableFields === null) {
            toastr()->warning('Please choose exportable fields first');
            return redirect()->back() ;
        }
        // Get The Selected exportable fields returns a pair of ['field_name' => 'viewing name']
        $selected_fields = (new ExportTable)->customizedTableField($company, $modelName, 'selected_fields');
        // Array Contains Only the name of fields
        $exportable_fields = array_keys($selected_fields);
        
        $salesGathering = $uploadParams['fullModel']::where('company_id', $company->id)->get();
        // Customizing the collection to be exported
        $salesGathering = collect($salesGathering)->map(function ($invoice) use ($exportable_fields) {
            $data = [];
            foreach ($exportable_fields as $field) {
                if (str_contains($field, 'deduction_id_')) {
                    $value = Deduction::find($invoice->$field)->name[lang()] ??null;
                } elseif (str_contains($field, 'date')) {
                    $value = $invoice->$field ===null ?: date('d-m-Y', strtotime($invoice->$field));
                } else {
                    $value = $invoice->$field;
                }
                $data[$field] = $value ;
            }
            return $data;
        });

        return (new ExportData($company->id, array_values($selected_fields), $salesGathering))->download($modelName.'.xlsx');

    }
    public function getUploadingPageExportNavigation(string $modelName,string $uploadPermissionName,string $exportPermissionName,string $deletePermissionName)
    {
		$user = auth()->user();
		$company = getCurrentCompany();
		
		
        return [
            
        [
           'name'=>__('Upload Data'),
           'link'=>'#',
           'show'=>true,
		   'icon'=>'fas fa-upload',
           'sub_items'=>[
               [
                   'name'=>__('Template Download'),
                   'link'=>$user->can($uploadPermissionName)?route('table.fields.selection.view',[$company,$modelName,'sales_gathering']) : '#' ,
                   'show'=>true
               ],
               [
                   'name'=>__('Upload Data'),
                   'link'=>$user->can($uploadPermissionName) ? route('salesGatheringImport',['company'=>$company->id , 'model'=>$modelName]) : '#',
                   'show'=>true
               ]
           


			   ],
			   
        ],
		[
			'name'=>__('Filter'),
			'link'=>'#',
			'show'=>true,
			'icon'=>'fas fa-search ',
			'attr'=>[
				'data-toggle'=>'modal',
				'data-target'=>'#search-form-modal',
			]
			],
			
			
			
			[
				'name'=>__('Export All Data'),
				'link'=>$user->can($exportPermissionName) ? route('salesGathering.export',['company'=>$company->id , 'model'=>$modelName]):'#',
				'show'=>$user->can($exportPermissionName),
				'icon'=>'fas fa-file-import',
				'attr'=>[
					// 'data-toggle'=>'modal',
					// 'data-target'=>'#search-form-modal',
				]
				],
				
				
				
				[
					'name'=>__('Delete'),
					'link'=>'#',
					'show'=>true,
					'icon'=>'fas fa-trash',
					'sub_items'=>[
						[
							'name'=>__('Delete By Date'),
							'link'=>'#',
							'show'=>true,
							'attr'=>[
								'data-toggle'=>'modal',
								'data-target'=>'#delete_from_to_modal'
							]
						],
						[
							'name'=>__('Delete All Data'),
							'link'=>$user->can($deletePermissionName)?route('truncate',[$company,$modelName]):'#',
							'show'=>$user->can($deletePermissionName)
						]
					
		 
		 
						],
						
				 ],
				
				
				
				
				
				
				
				
        
    	];
    }


}
