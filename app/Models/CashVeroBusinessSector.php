<?php

namespace App\Models;

use App\Traits\HasBasicStoreRequest;
use App\Traits\HasCreatedAt;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class CashVeroBusinessSector extends Model
{
	const BUSINESS_SECTORS = 'business-sectors';
	use HasCreatedAt,HasBasicStoreRequest;
    protected $dates = [
    ];


    protected $guarded = [];


    /**
     * The table associated with the model.
     *
     * @var string
     */
	public function getId(){
		return $this->id ;
	}
	public function getName()
	{
		return $this->name ;
	}
	
	public function scopeOnlyCompany(Builder $query,$companyId){
		return $query->where('company_id',$companyId);
	}
	
}
