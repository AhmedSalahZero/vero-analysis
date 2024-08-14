<?php
namespace App\Traits\Models;

use App\Helpers\HHelpers;
use App\Models\ContractCashflow;

trait HasContractCashflow
{
	public function contractCashFlows()
	{
		return $this->hasMany(ContractCashflow::class , 'model_id','id')->where('model_type',HHelpers::getClassNameWithoutNameSpace($this));
	}
}
