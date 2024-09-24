<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;

class UnappliedAmountForContractAsDownPaymentRule implements ImplicitRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
	protected $total_unapplied_amount = 0;
	protected $is_down_payment ;
	protected $paid_amount ;
	protected $failed_message ;
    public function __construct($totalUnappliedAmount = null , $isDownPayment = false  , $paidAmount = 0 )
    {
        $this->total_unapplied_amount = $totalUnappliedAmount ;
		$this->is_down_payment = $isDownPayment ;		
		$this->paid_amount = $paidAmount ;		
		// $this->failed_message = $isDownPayment ;		
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		$isMoneyReceivedForm = Request()->has('received_amount');
		$receivedAmountOrPaidAmountKeyName = $isMoneyReceivedForm ? 'received_amount' : 'paid_amount';
		$totalPaidAmountForContract = array_sum(array_column($value,$receivedAmountOrPaidAmountKeyName));
		if($this->is_down_payment){
			$this->failed_message  = __('Total Paid Amount Must Equal To Total Down Payment');
			return $this->paid_amount == $totalPaidAmountForContract;
		}
		if($this->total_unapplied_amount <= 0 ){
			return true ;
		}
		$this->failed_message = __('Total Paid Amount For Contract Not Equal To Unapplied Amount');
		return $totalPaidAmountForContract == $this->total_unapplied_amount;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->failed_message;
    }
}
