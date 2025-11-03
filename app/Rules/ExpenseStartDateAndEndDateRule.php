<?php

namespace App\Rules;

use App\Models\NonBankingService\Study;
use Illuminate\Contracts\Validation\ImplicitRule;

class ExpenseStartDateAndEndDateRule implements ImplicitRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected Study $study;
    protected string $failedMessage;
    protected string $amountFieldName;
    public function __construct(Study $study, string $amountFieldName = 'amount')
    {
        $this->study = $study;
        $this->amountFieldName = $amountFieldName;
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
        
        try {
            $studyStartDate=  $this->study->study_start_date;
            $studyStartDateAsIndex = $this->study->convertDateStringToDateIndex($studyStartDate);
        
            foreach ((array)$value as $arr) {
                $amount = $arr[$this->amountFieldName]??0;
                if ($amount  <= 0) {
                    continue ;
                }
                $startDate = $arr['start_date'].'-01';
                $startDateAsIndex = $this->study->convertDateStringToDateIndex($startDate);
                $endDate =$arr['end_date'].'-01';
            
                $endDateAsIndex = $this->study->convertDateStringToDateIndex($endDate);
                $firstCondition = $startDateAsIndex < $studyStartDateAsIndex;
                $secondCondition = $endDateAsIndex < $startDateAsIndex;
                if ($firstCondition || $secondCondition) {
                    if ($firstCondition) {
                        $this->failedMessage = __('Expense Start Date Must Be Greater Than Or Equal Study Start Date');
                    } else {
                        $this->failedMessage = __('Expense End Date Must Be Greater Than Or Equal Expense Start Date');
                    }
                    return false ;
                }
            }
        } catch (\Exception $e) {
            $this->failedMessage = __('Expense Start Date Must Be Greater Than Or Equal Study Start Date');
            return false;
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
        return $this->failedMessage;
    }
}
