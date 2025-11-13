<?php

namespace App\Http\Requests;

use App\Rules\DateMustBeGreaterThanOrEqualDate;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AtLeastOneRevenueMustBeSelectedRule;

class StoreStudyRequest extends FormRequest
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
		$operationStartDate = $this->get('operation_start_date').'-01';
		$studyStartDate = $this->get('study_start_date').'-01';
		
        return [
           'study_start_date'=>['required',new DateMustBeGreaterThanOrEqualDate($studyStartDate,$operationStartDate,__('Operation Date Must Be Greater Than Or Equal Study Start Date'))],
		   'at_least_one_revenue_should_be_selected'=>[new AtLeastOneRevenueMustBeSelectedRule()]
		   
        ];
    }
}
