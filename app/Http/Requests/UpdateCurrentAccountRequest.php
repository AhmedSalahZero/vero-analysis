<?php

namespace App\Http\Requests;

use App\Models\FinancialInstitutionAccount;
use App\Rules\UniqueAccountNumberRule;


class UpdateCurrentAccountRequest extends StoreCurrentAccountRequest
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
		$financialInstitutionAccount = Request()->route('financialInstitutionAccount') ;
		/**
		 * @var FinancialInstitutionAccount $financialInstitutionAccount 
		 */

		$excludeAccountNumbers = (array)$financialInstitutionAccount->getAccountNumber();
        return [
			'account_number'=>new UniqueAccountNumberRule($excludeAccountNumbers)
		];
    }
}
