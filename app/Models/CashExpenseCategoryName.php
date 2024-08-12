<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CashExpenseCategoryName extends Model
{
	
	protected $guarded = ['id'];
	
	public function cashExpenseCategory()
	{
		return $this->belongsTo(CashExpenseCategory::class,'cash_expense_category_id','id');
	}
	public function getName()
	{
		return $this->name;
	}
	public function cashExpenses()
	{
		return $this->hasMany(CashExpense::class,'cash_expense_category_name_id','id');
	}
		
	
	
}
