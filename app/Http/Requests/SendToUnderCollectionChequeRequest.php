<?php

namespace App\Http\Requests;

use App\Models\FinancialInstitution;
use App\Models\MoneyReceived;
use App\Rules\DateMustBeGreaterThanOrEqualDate;
use App\Rules\DateMustBeLessThanOrEqualDate;
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
		$moneyReceivedIds = Request()->get('cheques');
		$ids = is_array($moneyReceivedIds) ? $moneyReceivedIds :  explode(',',$moneyReceivedIds);
		$firstMoneyReceived = MoneyReceived::whereIn('id',$ids)->orderByDesc('receiving_date')->first() ;
		$greatestReceivingDate = $firstMoneyReceived->receiving_date;
		// $financialInstitution = $firstMoneyReceived->getFinancialInstitution();
		$financialInstitution  = FinancialInstitution::find(Request()->input('drawl_bank_id'));
		$openingBalanceDate = $financialInstitution->getOpeningBalanceForAccount(Request()->get('account_type'),Request()->get('account_number'),);
        return [
            'deposit_date'=>['required'
			,new DateMustBeLessThanOrEqualDate(null,now(),__('Dates Must Be Less Than Or Equal To Today'))
			, new DateMustBeGreaterThanOrEqualDate(null,$greatestReceivingDate , __('Deposit Date Must Be Greater Than Or Equal Receiving Date')),
			, new DateMustBeGreaterThanOrEqualDate(null,$openingBalanceDate , __('Deposit Date Must Be Greater Than Or Equal Account Opening Balance Date')),
			
		],
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
