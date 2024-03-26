<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\IsCashInSafe;

class CashInSafe extends Model
{
	use IsCashInSafe;
    protected $guarded = ['id'];
	
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class,'money_received_id');
	}
	
}
