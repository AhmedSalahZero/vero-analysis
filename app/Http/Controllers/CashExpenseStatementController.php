<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\CashExpenseCategory;
use App\Models\CashExpenseCategoryName;
use App\Models\Company;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CashExpenseStatementController
{
    use GeneralFunctions;
    public function index(Company $company)
	{
		// $selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$cashExpenseCategories = CashExpenseCategory::where('company_id',$company->id)->orderBy('name','asc')->get()->formattedForSelect(true,'getId','getName');
        return view('cash_expense_statement_form', [
			'company'=>$company,
			'cashExpenseCategories'=>$cashExpenseCategories
			// 'selectedBranches'=>$selectedBranches
		]);
    }
	public function result(Company $company , Request $request){
		$startDate = $request->get('start_date');
		$endDate = $request->get('end_date');
		$currency = $request->get('currency');
		$expenseCategory =count($request->get('expense_category_id'))  == 1 ? CashExpenseCategory::find($request->get('expense_category_id'))->getName() : null;
		$cashExpenseCategoryId = $request->get('cash_expense_category_name_id'); 
		$expenseCategoryName = count($cashExpenseCategoryId)  == 1 ?  CashExpenseCategoryName::find($cashExpenseCategoryId)->getName() : null ;

		$result = DB::table('cash_expenses')->where('cash_expenses.company_id',$company->id)->where('currency',$currency)
		->where('payment_date','>=',$startDate)
		->where('payment_date','<=',$endDate)
		->whereIn('cash_expense_category_name_id',$cashExpenseCategoryId)
		->orderByRaw('payment_date asc')
		->join('cash_expense_category_names','cash_expense_category_names.id','=','cash_expenses.cash_expense_category_name_id')
		->join('cash_expense_categories','cash_expense_categories.id','=','cash_expense_category_names.cash_expense_category_id')
		->selectRaw('cash_expenses.*,cash_expense_category_names.name as sub_category_name , cash_expense_categories.name as main_category_name ' )
		->get();
		// dd($result);
		// ->whereBet('payment_date');
		// $results=DB::table('cash_in_safe_statements')
		// ->where('company_id',$company->id)
		// ->where('currency',$currency)
		// ->where('branch_id',$branchId)
		// ->where('date','>=',$startDate)
		// ->where('date','<=',$endDate)
		// ->orderByRaw('full_date asc , created_at asc')
		// ->get();
			if(!count($result)){
				return redirect()
									->back()
									->with('fail',__('No Data Found'))	
									;
			}
		
		return view('cash_expense_statement_result',[
			'results'=>$result,
			'currency'=>$currency,
			'expenseCategory'=>$expenseCategory,
			'expenseCategoryName'=>$expenseCategoryName
		]);
	}




}
