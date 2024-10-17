<?php

namespace App\Http\Requests;

use App\Rules\TwoNumericsAreEqual;
use App\Rules\UniqueArrayRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$modelType=$this->route('type');
		$message = __('Total amounts of Sales Orders must be equal to Contract Amount') ;
		$columnName = 'salesOrders';
		if($modelType == 'Supplier'){
			$message = __('Total amounts of Purchase Orders must be equal to Contract Amount') ;
			$columnName = 'purchasesOrders';
		}

        return [
			'amount'=>['required',new TwoNumericsAreEqual(collect(Request()->input($columnName.'.*'))->sum('amount'),Request()->get('amount'),$message)],
			$columnName.'.*.so_number'=>[new UniqueArrayRule(Request()->input($columnName.'.*.so_number',[]),__('Sales Order Number Can Not Be Repeated'))]
        ];
    }
}
