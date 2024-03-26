<?php

namespace App\Models;

use App\Traits\Models\IsIncomingTransfer;
use Illuminate\Database\Eloquent\Model;

class IncomingTransfer extends Model
{
	use IsIncomingTransfer ;
	 
    protected $guarded = ['id'];
	
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class,'money_received_id');
	}
	
}
