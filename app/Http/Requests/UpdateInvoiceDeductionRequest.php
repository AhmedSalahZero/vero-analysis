<?php

namespace App\Http\Requests;

use App\Rules\DateMustBeGreaterThanOrEqualDate;
use App\Rules\DateMustBeLessThanOrEqualDate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceDeductionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
	
		$InvoiceId = Request()->route('modelId');
		$invoiceModelName = Request()->route('modelType');
		$invoice = ('App\Models\\'.$invoiceModelName)::find($InvoiceId);
        return [
			'deductions.*.deduction_id'=>'required|numeric',
			'deductions.*.date'=>['required','date',
			new DateMustBeGreaterThanOrEqualDate(null,$invoice->getInvoiceDate() , __('Date Must Be Greater Than Or Equal Invoice Date And Less Than Or Equal Today'),true),
			new DateMustBeLessThanOrEqualDate(null,now() , __('Date Must Be Greater Than Or Equal Invoice Date And Less Than Or Equal Today'),true),
		],
			
			'deductions.*.amount'=>'required|numeric|gt:0',
        ];
    }
}
