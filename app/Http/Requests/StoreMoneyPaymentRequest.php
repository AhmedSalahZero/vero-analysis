<?php

namespace App\Http\Requests;

use App\Models\MoneyPayment;
use App\Rules\SettlementPlusWithoutCanNotBeGreaterNetBalance;
use Illuminate\Foundation\Http\FormRequest;

class StoreMoneyPaymentRequest extends FormRequest 
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
		$type = $this->type ; 
	
        return [
			'account_type.'.$type => $type == MoneyPayment::OUTGOING_TRANSFER || $type == MoneyPayment::PAYABLE_CHEQUE ? 'required' : 'sometimes',
			'unapplied_amount'=>'sometimes|gte:0',
			'net_balance_rules'=>new SettlementPlusWithoutCanNotBeGreaterNetBalance($this->get('settlements',[]))
        ];
    }
	public function messages()
	{
		$type = $this->type ; 
		return [
		
			'account_type.'.$type.'.required' => __('Please Select Account Type') ,
			'unapplied_amount.gte'=>__('Invalid Unapplied Amount')
		];
	}
	
}
