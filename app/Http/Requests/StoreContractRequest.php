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
        return [
			'amount'=>['required',new TwoNumericsAreEqual(collect(Request()->input('salesOrders.*'))->sum('amount'),Request()->get('amount'),__('Total amounts of Sales Orders must be equal to Contact Amount'))],
			'salesOrders.*.so_number'=>[new UniqueArrayRule(Request()->input('salesOrders.*.so_number',[]),__('Sales Order Number Can Not Be Repeated'))]
        ];
    }
}
