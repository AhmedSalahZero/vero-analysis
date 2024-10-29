<?php

namespace App\Http\Requests;

use App\Models\FinancialInstitutionAccount;
use App\Rules\AtLeastOneMainFunctionalCurrencyExistAtAccountRule;
use App\Rules\DateMustBeGreaterThanOrEqualDate;
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
		$company = Request()->route('company') ;
		$mainFunctionalCurrency = $company->getMainFunctionalCurrency();

		/**
		 * @var FinancialInstitutionAccount $financialInstitutionAccount 
		 */

		$excludeAccountNumbers = (array)$financialInstitutionAccount->getAccountNumber();
		// $balanceDate = $financialInstitutionAccount->getBalanceDate() ;
		$balanceDate = Request('balance_date');
		$financialInstitutionId = $financialInstitutionAccount->getFinancialInstitutionId();
        return [
			
			'account_number'=>new UniqueAccountNumberRule($excludeAccountNumbers),
			'account_interests.*.start_date'=>['required',new DateMustBeGreaterThanOrEqualDate(null,$balanceDate,__('Interest Date Must Be Greater Than Or Equal Beginning Balance Date'),true)],
			'currency'=>['required',new AtLeastOneMainFunctionalCurrencyExistAtAccountRule($this->old_currency,$mainFunctionalCurrency,$financialInstitutionId)]
		];
    }
}
