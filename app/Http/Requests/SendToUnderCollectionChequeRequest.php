<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendToUnderCollectionChequeRequest extends FormRequest
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
            'deposit_date'=>['required'],
			'account_type'=>['required'],
        ];
    }
	public function messages()
	{
		return [
			'deposit_date.required'=>__('Please Select :attribute',['attribute'=>__('Deposit Date - Max Date Of Today')]),
			'account_type.required'=>__('Please Select :attribute',['attribute'=>__('Account Type')]),
			// ''=>
		];
		
	}
}
