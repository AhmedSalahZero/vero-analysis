<?php
namespace App\Traits\Models;


 
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
