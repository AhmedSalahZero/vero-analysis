<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class FilterMainTypeBasedOnDatesController extends Controller
{
    public function __invoke(Request $request , Company $company )
    {
        $mainTypeArray = getTypeFor($request->get('mainType',$request->get('subType')),$company->id,true,true,$request->get('startDate')  , $request->get('endDate'));
        return response()->json([
            'status'=>true ,
            'data'=>$mainTypeArray ,
            'appendTo'=>'#'. $request->get('appendTo')
        ]);
    }
}
