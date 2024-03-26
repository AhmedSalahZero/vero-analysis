<?php

namespace App\Models;


use App\Traits\Models\IsCheque;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{

	use IsCheque ;
	const IN_SAFE = 'in-safe';
	const UNDER_COLLECTION = 'under-collection';
	const REJECTED = 'rejected';
	const COLLECTED = 'collected';
		 
    protected $guarded = ['id'];
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class,'money_received_id');
	}

}
