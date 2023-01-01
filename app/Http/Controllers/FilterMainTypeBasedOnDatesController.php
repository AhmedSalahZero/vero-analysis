<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class FilterMainTypeBasedOnDatesController extends Controller
{
    public function __invoke(Request $request , Company $company )
    {
        $mainTypeArray = getTypeFor($request->get('mainType'),$company->id,true,true,$request->get('startDate')  , $request->get('endDate'));
       array_pop($mainTypeArray);
        return response()->json([
            'status'=>true ,
            'data'=>$mainTypeArray ,
            'appendTo'=>'#'. $request->get('appendTo')
        ]);
    }
}
