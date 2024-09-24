<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;

class ValidAllocationsRule implements ImplicitRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
	protected $failedMessage = null;
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $allocationItems)
    {
        foreach((array)$allocationItems as $invoiceNumber=>$arrayOfAllocations){
			$totalAllocationsForInvoiceNumber = array_sum(array_column($arrayOfAllocations,'allocation_amount'));
			if($totalAllocationsForInvoiceNumber != Request()->input('settlements.'.$invoiceNumber.'.settlement_amount',0)){
				$this->failedMessage  = __('Invalid Allocation For Invoice :invoiceNumber' ,['invoiceNumber'=>$invoiceNumber]);  
				return false ;
			}
			
			// foreach($arrayOfAllocations as  $allocationArr){
			
			// }
		}
		return true ;
		
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->failedMessage;
    }
}
