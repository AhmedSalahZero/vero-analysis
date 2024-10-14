<?php

namespace App\Http\Requests;

use App\Models\MoneyReceived;
use App\Rules\AtLeaseOneSettlementMustBeExist;
use App\Rules\SettlementPlusWithoutCanNotBeGreaterNetBalance;
use App\Rules\UnappliedAmountForContractAsDownPaymentRule;
use App\Rules\UniqueChequeNumberForCustomerRule;
use App\Rules\UniqueReceiptNumberForReceivingBranchRule;
use Illuminate\Foundation\Http\FormRequest;
class StoreMoneyReceivedRequest extends FormRequest 
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
		$partnerType = $this->partner_type;
		$receivedAmount = $this->{'received_amount.'.$type };
        return [
			'type'=>'required',
			'receiving_branch_id'=>$type == MoneyReceived::CASH_IN_SAFE  ? ['required','not_in:-1'] : [],
			'received_amount.'.$type => ['required','gt:0'],
			'account_type.'.$type => $type == MoneyReceived::INCOMING_TRANSFER || $type == MoneyReceived::CASH_IN_BANK ? 'required' : 'sometimes',
			'unapplied_amount'=>'sometimes|gte:0',
			'net_balance_rules'=>new SettlementPlusWithoutCanNotBeGreaterNetBalance($this->get('settlements',[])),
			'settlements'=>$partnerType =='is_customer' ? new AtLeaseOneSettlementMustBeExist($this->get('settlements',[])) : [],
			'cheque_number'=>$type == MoneyReceived::CHEQUE  ? ['required',new UniqueChequeNumberForCustomerRule(Request()->get('drawee_bank_id'),Request('current_cheque_id'),__('Cheque Number Already Exist'))] : [],
			'receipt_number'=>$type== MoneyReceived::CASH_IN_SAFE ? ['required',new UniqueReceiptNumberForReceivingBranchRule('cash_in_safes',$this->receiving_branch_id?:0,$this->current_branch,__('Receipt Number For This Branch Already Exist'))] : [],
			'sales_orders_amounts'=>[new UnappliedAmountForContractAsDownPaymentRule($this->unapplied_amount?:0,$this->is_down_payment,$receivedAmount)]
        ];
    }
	public function messages()
	{
		$type = $this->type ; 
		return [
			'receiving_branch_id.not_in'=>__('Please Enter New Branch Name'),
			'account_type.'.$type.'.required' => __('Please Select Account Type') ,
			'unapplied_amount.gte'=>__('Invalid Unapplied Amount'),
			'type.required'=>__('Please Select Money Type'),
			'received_amount.'.$type.'.required'=>__('Please Enter Received Amount'),
			'received_amount.'.$type.'.gt'=>__('Received Amount Must Be Greater Than Zero'),
		];
	}
	
}
