<?php

namespace App\Models;

use App\Traits\HasBasicStoreRequest;
use App\Traits\HasCreatedAt;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
	use HasBasicStoreRequest,HasCreatedAt;
	const DEDUCTIONS = 'deductions';
	
	protected $guarded = ['id'];
	public function getId()
	{
		return $this->id;
	}
	public function getName()
	{
		return $this->name;
	}
	
	public function scopeOnlyForCompany(Builder $builder , int $companyId)
	{
		return $builder->where('company_id',$companyId);
	}
	
}
