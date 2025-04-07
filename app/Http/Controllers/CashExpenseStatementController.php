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
		$expenseCategory = CashExpenseCategory::find($request->get('expense_category_id'))->getName();
		$cashExpenseCategoryId = $request->get('cash_expense_category_name_id'); 
		$expenseCategoryName = CashExpenseCategoryName::find($cashExpenseCategoryId)->getName();

		$result = DB::table('cash_expenses')->where('company_id',$company->id)->where('currency',$currency)
		->where('payment_date','>=',$startDate)
		->where('payment_date','<=',$endDate)
		->where('cash_expense_category_name_id',$cashExpenseCategoryId)
		->orderBy('payment_date')
		->get();
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
