<?php
namespace App\Http\Controllers;
use App\Models\CashExpenseCategory;
use App\Models\Company;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;


class CashExpenseCategoryController
{
    use GeneralFunctions;
	public function index(Company  $company )
    {
	
		
		$cashExpenseCategories = CashExpenseCategory::where('company_id',$company->id)->get();
		$items = [];
	
			foreach($cashExpenseCategories as $index=>$cashExpenseCategory){
				$cashExpenseId = $cashExpenseCategory->id ;
				$items[$cashExpenseId]['parent'] = [
					'name'=>$cashExpenseCategory->getName() ,
					'cashExpenseCateCashExpenseCategory'=>$cashExpenseCategory,
				];
				foreach($cashExpenseCategory->cashExpenseCategoryNames as $cashExpenseCategoryName){
					$items[$cashExpenseId]['sub_items'][$cashExpenseCategoryName->id]['name'] =$cashExpenseCategoryName->getName() ;
					$items[$cashExpenseId]['sub_items'][$cashExpenseCategoryName->id]['id'] =$cashExpenseCategoryName->id ;
				}
		}
		

        return view('cash-expense-categories.index',compact('company','items'));
    }
	public function create(Request $request,Company $company)
	{
		return view('cash-expense-categories.form',$this->getCommonVars($company));
	}
	public function getCommonVars(Company $company,$model = null):array 
	{

	
		return [
		
			'company'=>$company,
			'model'=>$model,
			'inEditMode'=>isset($model)
		]
		;
	}
	public function store(Request $request, Company $company){
			$cashExpenseCategory = new CashExpenseCategory ;
			$cashExpenseCategory->storeBasicForm($request);
			return redirect()->route('cash.expense.category.index',['company'=>$company->id]);
	}
	public function edit(Request $request,Company $company,CashExpenseCategory $cashExpenseCategory)
	{
		return view('cash-expense-categories.form',$this->getCommonVars($company,$cashExpenseCategory));
	}
	public function update(Company $company , Request $request , CashExpenseCategory $cashExpenseCategory){
		
			$cashExpenseCategory->storeBasicForm($request);

			return redirect()->route('cash.expense.category.index',['company'=>$company->id]);
	}
	public function destroy(Company $company , Request $request , CashExpenseCategory $cashExpenseCategory){
		$cashExpenseCategory->delete();
		return redirect()->route('cash.expense.category.index',['company'=>$company->id]);  
	}	
	public function updateExpenseCategoryNameBasedOnCategory(Company $company , Request $request){
		$expenseCategories = CashExpenseCategory::whereIn('id',$request->get('expenseCategoryId'))->get();
		$result = [];
		foreach($expenseCategories as $expenseCategory){
			$subItems   = $expenseCategory->cashExpenseCategoryNames->sortBy('name')->pluck('id','name')->toArray() ;
			foreach($subItems as $name=>$id){
				$result[$name]=$id;
			}
		}
		
		return response()->json([
			'categoryNames'=>$result
		]);
	}	
	
}
