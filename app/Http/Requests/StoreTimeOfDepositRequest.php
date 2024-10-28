<?php

namespace App\Http\Requests;

use App\Models\FinancialInstitutionAccount;
use App\Rules\DateMustBeGreaterThanOrEqualDate;
use App\Rules\UniqueAccountNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Request;

class StoreTimeOfDepositRequest extends FormRequest
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
    public function rules(array $excludeAccountNumbers = [])
    {
		$financialInstitutionAccount = FinancialInstitutionAccount::find(Request()->get('maturity_amount_added_to_account_id'));
		$financialInstitutionBalanceDate = $financialInstitutionAccount->getOpeningBalanceDate() ;
        return [
            'account_number'=>new UniqueAccountNumberRule($excludeAccountNumbers),
			'end_date'=>['required',new DateMustBeGreaterThanOrEqualDate(null,$financialInstitutionBalanceDate,__('End Date Must Be Greater Than Or Equal Account Opening Balance Date'))]
        ];
    }
}
