<?php

namespace App\Models;

use App\Traits\Models\IsSettlement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settlement extends Model
{
	use IsSettlement;
	protected $guarded = ['id'];
	
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class , 'money_received_id','id');
	}
	
	public function customerInvoice()
	{
		return $this->belongsTo(CustomerInvoice::class , 'invoice_id','id');
	}
	public function invoice():BelongsTo
	{
		return $this->customerInvoice();
	}

	
		
	
	
	
	

	
}
