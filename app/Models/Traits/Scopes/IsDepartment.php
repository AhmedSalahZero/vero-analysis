<?php
namespace App\Models\Traits\Scopes;



trait IsDepartment
{
	public function getName()
	{
		return $this->name ;
	}
	public function getExpenseTypeId():string
	{
		return $this->expense_type;
	}
	public function getExpenseTypeName():string 
	{
		return getExpenseTypes()[$this->getExpenseTypeId()];
	}
} 
