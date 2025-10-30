<?php
namespace App\Models\Traits\Scopes;



trait IsDepartment
{
	public function getName()
	{
		return $this->name ;
	}
	public function getExpenseTypeId():?string
	{
		// dd($this);
		// if($this->type == Department::MICROFINANCE){
		// 	dd($this);
		// 	// return $this
		// }
		return $this->positions->count() ? $this->positions->first()->expense_type : null;
	}
	public function getExpenseTypeName():string 
	{
		return getExpenseTypes()[$this->getExpenseTypeId()];
	}
} 
