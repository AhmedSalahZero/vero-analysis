<?php
namespace App\Traits\Models;

use App\Models\AccountType;
use App\Models\Branch;
use App\Models\FinancialInstitution;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 
/**
 * * ال تريت دا مشترك بين
 * * MoneyReceived || MoneyPayment
 */
trait IsMoney 
{
	public function getId()
	{
		return $this->id ;
	}	
	public function getType():string 
	{
		return $this->type ;
	}
	
}
