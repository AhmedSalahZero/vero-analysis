<?php

namespace App\Rules;

use App\Models\AccountType;
use App\Models\LetterOfGuaranteeIssuance;
use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Support\Facades\DB;

class LgTermAmountRule implements ImplicitRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
	protected $category_name, $lg_cash_cover_amount , $lg_commission_amount ,$issuance_date, $min_lg_commission_fees,$issuance_fees ,$account_type_id,$account_number,$company_id,$financial_institution_id;
    public function __construct($categoryName ,$accountTypeId,$accountNumber ,$issuanceDate,$lgCashCoverAmount,$lgCommissionAmount,$minLgCommissionFees,$issuanceFees,$companyId,$financialInstitutionId)
    {
		$this->category_name = $categoryName;
		$this->account_type_id = $accountTypeId;
		$this->lg_cash_cover_amount = number_unformat($lgCashCoverAmount);
		$this->lg_commission_amount = number_unformat($lgCommissionAmount);
		$this->min_lg_commission_fees = number_unformat($minLgCommissionFees);
		$this->issuance_fees = number_unformat($issuanceFees);
		$this->account_number = $accountNumber;
		$this->company_id = $companyId;
		$this->financial_institution_id = $financialInstitutionId;
		$this->issuance_date = $issuanceDate;
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
		$accountType = AccountType::find($this->account_type_id);
		if(!$accountType->isCurrentAccount()){
			return true ; 
		}
		if($this->category_name == LetterOfGuaranteeIssuance::OPENING_BALANCE){
			return true ;
		}
		$accountNumber = $this->account_number;
		$statementDate = $this->issuance_date;
		$accountNumberModel =  ('\App\Models\\'.$accountType->getModelName())::findByAccountNumber($accountNumber,$this->company_id,$this->financial_institution_id);
		$statementTableName = (get_class($accountNumberModel)::getStatementTableName()) ;
		$foreignKeyName = get_class($accountNumberModel)::getForeignKeyInStatementTable();
		$balanceRow = DB::table($statementTableName)->where($foreignKeyName,$accountNumberModel->id)->where('full_date','<=' , $statementDate)->orderByRaw('full_date desc')->first();
		$currentAccountBalanceAtIssuanceDate = $balanceRow ? $balanceRow->end_balance : 0 ;
        $maxBetweenCommissionAmountAndFees = max($this->lg_commission_amount , $this->min_lg_commission_fees);
		return $this->lg_cash_cover_amount + $maxBetweenCommissionAmountAndFees  + $this->issuance_fees <= $currentAccountBalanceAtIssuanceDate;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('There Is No Enough Balance In Current Account To Apply LG Cash Cover And Commission');
    }
}
