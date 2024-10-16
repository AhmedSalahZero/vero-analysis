<?php

namespace App\Http\Requests;

use App\Models\CashExpense;
use App\Rules\SettlementPlusWithoutCanNotBeGreaterNetBalance;
use App\Rules\UniqueChequeNumberRule;
use App\Rules\UniqueReceiptNumberForReceivingBranchRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCashExpenseRequest extends FormRequest 
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
			'type'=>'required',
			'delivery_branch_id'=>$type == CashExpense::CASH_PAYMENT  ? ['required','not_in:-1'] : [],
			'paid_amount.'.$type => ['required','gt:0'],
			'account_type.'.$type => $type == CashExpense::OUTGOING_TRANSFER || $type == CashExpense::PAYABLE_CHEQUE ? 'required' : 'sometimes',
			'unapplied_amount'=>'sometimes|gte:0',
			'net_balance_rules'=>new SettlementPlusWithoutCanNotBeGreaterNetBalance($this->get('settlements',[])),
			'cheque_number'=>$type == CashExpense::PAYABLE_CHEQUE ? ['required',new UniqueChequeNumberRule(Request()->input('delivery_bank_id.payable_cheque'),Request()->get('current_cheque_id'),__('Cheque Number Already Exist'))] : [],
			'receipt_number'=>$type== CashExpense::CASH_PAYMENT ? ['required',new UniqueReceiptNumberForReceivingBranchRule('cash_payments',$this->delivery_branch_id?:0,$this->current_branch,__('Receipt Number For This Branch Already Exist'))] : []
        ];
    }
	public function messages()
	{
		$type = $this->type ; 
		return [
		
			'account_type.'.$type.'.required' => __('Please Select Account Type') ,
			'unapplied_amount.gte'=>__('Invalid Unapplied Amount'),
			
			'type.required'=>__('Please Select Money Type'),
			'paid_amount.'.$type.'.required'=>__('Please Enter Paid Amount'),
			'paid_amount.'.$type.'.gt'=>__('Paid Amount Must Be Greater Than Zero'),
			'type.required'=>__('Please Select Money Type'),
			'delivery_branch_id.not_in'=>__('Please Enter New Branch Name')
		];
	}
	
}
