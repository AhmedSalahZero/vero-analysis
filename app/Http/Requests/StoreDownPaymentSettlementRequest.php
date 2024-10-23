<?php

namespace App\Http\Requests;

use App\Rules\DateMustBeGreaterThanOrEqualDate;
use Illuminate\Foundation\Http\FormRequest;

class StoreDownPaymentSettlementRequest extends FormRequest
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
		$modelType = Request('model_type');
		$downPaymentId = Request('down_payment_id');
		$fullClassName = 'App\Models\\'.$modelType;
		$downPaymentModelName=$fullClassName::MONEY_MODEL_NAME;
		$downPaymentModelFullName = 'App\Models\\'.$downPaymentModelName ;   
		$downPayment =$downPaymentModelFullName::find($downPaymentId);
		$receivingDate  = $downPayment->getDate();
		$settlementDate = Request('settlement_date');
        return [
            'settlement_date'=> ['required',new DateMustBeGreaterThanOrEqualDate($settlementDate,$receivingDate,__('Settlement Date Must Be Greater Or Equal Down Payment Receiving Date'))]
        ];
    }
}
