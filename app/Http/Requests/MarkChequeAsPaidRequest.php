<?php

namespace App\Http\Requests;

use App\Models\MoneyPayment;
use App\Rules\DateMustBeGreaterThanOrEqualDate;
use Illuminate\Foundation\Http\FormRequest;

class MarkChequeAsPaidRequest extends FormRequest
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
		$isCashExpense = Request()->route()->getName() == 'cash.expense.payable.cheque.mark.as.paid' ;
		$modelName = $isCashExpense ? 'App\Models\CashExpense' : 'App\Models\MoneyPayment';
		$tableName = $isCashExpense ? 'cash_expenses' : 'money_payments';
		$foreignId = $isCashExpense ? 'cash_expense_id' : 'money_payment_id';
		
		$ids = Request()->get('cheques');
		$ids = is_array($ids) ? $ids :  explode(',',$ids);
		$dueDate = $modelName::whereIn($tableName.'.id',$ids)
		->join('payable_cheques','payable_cheques.'.$foreignId,'=',$tableName.'.id')->orderByDesc('due_date')
		->first()->due_date ;
        return [
            'actual_payment_date'=>['required',new DateMustBeGreaterThanOrEqualDate(null,$dueDate,__('Payment Date Must Be Greater Than Or Equal Cheque Due Date'))]
        ];
    }
}
