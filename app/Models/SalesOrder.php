<?php

namespace App\Models;

use App\Traits\Models\IsOrder;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
	use IsOrder ;
	protected $guarded = ['id'];
		
	
	
}
