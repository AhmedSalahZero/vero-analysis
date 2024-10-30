<?php

namespace App\Models;

use App\Traits\HasBasicStoreRequest;
use App\Traits\HasCreatedAt;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
	use HasBasicStoreRequest,HasCreatedAt;
	const DEDUCTIONS = 'deductions';
	
	protected $guarded = ['id'];
	public function getName()
	{
		return $this->name;
	}
	
}
