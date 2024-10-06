<?php

namespace App\Http\Requests;

use App\Rules\UniqueToCompanyAndAdditionalColumnsRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubsidiaryCompanyRequest extends FormRequest
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
        return [
            'name'=>['required',new UniqueToCompanyAndAdditionalColumnsRule('Partner','name',$this->id,[['is_subsidiary_company','=',1]],__('This Employee Already Exist'))]
        ];
    }
}
