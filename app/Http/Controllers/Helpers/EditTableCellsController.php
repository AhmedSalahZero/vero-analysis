<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\RevenueBusinessLine;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Information\Value;

class EditTableCellsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $modelName = $request->get('modelName');
        $modelId = $request->get('modelId');
        $data = $request->get('data');
        $columnName = $request->get('columnName');
        $isRelation = $request->get('isRelation');
        $isCollectionRelation = $request->get('isCollectionRelation');
        $collectionItemId = $request->get('collectionItemId');
        $isJson = $request->get('isJson');
        $relationName = $request->get('relationName');
        $modelNamespace = getModelNamespace();
        // dd(($modelNamespace.$modelName));
        // $theSameItemAlreadyExist = ($modelNamespace.$modelName)::find($modelId);
        $model = ($modelNamespace.$modelName)::find($modelId);
        // dd($isRelation);
      
        $model = $isRelation ? $model->{$relationName} : $model ;
          if($isCollectionRelation)
            {
                $model = $model->where('id',$collectionItemId)->first();
            }
        // dd($model);
        // dd();
        // dd($model);
        // dd(get_class($model));
        if(get_class($model)::where('company_id',getCurrentCompanyId())->where($columnName , $data)->exists())
        {
            // this record already exist ;
            return response()->json([
                'status'=>false ,
                'dataTableId'=>$request->get('dataTableId')
            ]) ; 
        }
        if($isJson)
        {
            $columnNameSegments = explode('_',$columnName);
            $columnName = $columnNameSegments[0];
            $model->{$columnName} = [
                'en'=>$data , 
                'ar'=>$data 
            ];
        }
        elseif(! $isJson)
        {
            
          $model->{$columnName} = $data ;
                        
        }
        // dd($request->get('dataTableId'));
        // dd(now());
             $model->updated_at = now();
            //  dd($model);
             $model->save();
             return response()->json([
                 'dataTableId'=>$request->get('dataTableId')
             ]);
        
    }
}
