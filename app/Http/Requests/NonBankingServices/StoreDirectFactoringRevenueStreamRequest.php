<?php

namespace App\Http\Requests\NonBankingServices;

use App\Rules\TotalBreakdownMustBeHundered;
use App\Rules\TotalBreakdownMustBeHundredRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DirectFactoringBreakdownRule;

class StoreDirectFactoringRevenueStreamRequest extends FormRequest
{
	protected string $errorMessage ;
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
	public function prepareForValidation()
	{
		
	}
    public function rules()
    {
		
		// dd(Request()->all());
	// directFactoringBreakdowns
        return [
            'total_must_be_hundred'=>[new TotalBreakdownMustBeHundredRule('directFactoringBreakdowns')],
			'direct_factoring_breakdown_rules'=>[new DirectFactoringBreakdownRule],
        ];
    }
}
