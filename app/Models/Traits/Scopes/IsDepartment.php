<?php
namespace App\Models\Traits\Scopes;



trait IsDepartment
{
	public function getName()
	{
		return $this->name ;
	}
	public function getNoPositions():int 
	{
		return $this->no_positions;
	}
	public function getExpenseTypeId():string
	{
		return $this->expense_type;
	}
} 
