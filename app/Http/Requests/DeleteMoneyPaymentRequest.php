<?php

namespace App\Http\Requests;

use App\Rules\MoneyPaymentCanBeDeletedRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\MoneyPayment;

class DeleteMoneyPaymentRequest extends FormRequest
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
		$moneyPayment = Request()->route('moneyPayment') ;
		/**
		 * @var MoneyPayment $moneyPayment 
		 */
		$company = Request()->route('company');
	
        return [
            'net_balance'=>[new MoneyPaymentCanBeDeletedRule($moneyPayment ,$company )]
        ];
    }
}
