<?php

namespace App\Models;

use App\Helpers\HHelpers;
use Illuminate\Database\Eloquent\Model;

class ContractCashflow extends Model
{
	
	protected $guarded = ['id'];
	
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class,'model_id','id')->where('model_type',HHelpers::getClassNameWithoutNameSpace(new MoneyReceived()));
	}
	public function moneyPayment()
	{
		return $this->belongsTo(MoneyPayment::class,'model_id','id')->where('model_type',HHelpers::getClassNameWithoutNameSpace(new MoneyPayment()));
	}
	public function cashExpense()
	{
		return $this->belongsTo(CashExpense::class,'model_id','id')->where('model_type',HHelpers::getClassNameWithoutNameSpace(new CashExpense()));
	}
	public function customerContract()
	{
		return $this->belongsTo(Contract::class,'customer_contract_id','id');
	}
	public function supplierContract()
	{
		return $this->belongsTo(Contract::class,'supplier_contract_id','id');
	}
}	
