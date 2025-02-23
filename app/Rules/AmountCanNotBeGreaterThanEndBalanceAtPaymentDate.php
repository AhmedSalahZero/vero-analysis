<?php

namespace App\Rules;

use App\Http\Controllers\MoneyPaymentController;
use App\Http\Controllers\MoneyReceivedController;
use App\Models\MoneyPayment;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ImplicitRule;

class AmountCanNotBeGreaterThanEndBalanceAtPaymentDate implements ImplicitRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
	protected $type,$company,$paid_amount,$account_type_id,$account_number,$financial_institution_id,$delivery_date,$branch_id ;
    public function __construct($type,$paidAmount, $company , $accountTypeId , $accountNumber,$financialInstitutionId,$deliveryDate,$branchId)
    {
		$this->company=  $company;
		$this->type=$type;
		$this->paid_amount=  $paidAmount;
		$this->account_type_id = $accountTypeId;
		$this->account_number = $accountNumber;
		$this->financial_institution_id = $financialInstitutionId; 
		$this->delivery_date = Carbon::make($deliveryDate)->format('Y-m-d');
		$this->branch_id = $branchId ;
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
		if($this->type == MoneyPayment::OUTGOING_TRANSFER || $this->type == 'ACTUAL_PAYMENT_DATE'){
			$response = (new MoneyReceivedController)->updateNetBalanceBasedOnAccountNumber(Request(),$this->company,$this->account_type_id,$this->account_number,$this->financial_institution_id,$this->delivery_date);
			$balance = $response->getData(true)['balance'] ;
			return $balance >= $this->paid_amount;
		}
		if($this->type == MoneyPAyment::CASH_PAYMENT){
			$response = (new MoneyPaymentController)->getCashInSafeStatementEndBalance(Request(),$this->company,Request('delivery_branch_id'),Request('payment_currency'),$this->delivery_date);
			$balance = $response->getData(true)['end_balance'];
			return $balance >= $this->paid_amount;
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
        return __('There Is No Enough Balance To Make This Payment');
    }
}
