<?php

namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\BelongsToCompany;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Position extends Model
{
	
	use BelongsToStudy,BelongsToCompany;
	protected $connection =NON_BANKING_SERVICE_CONNECTION_NAME;
 	protected $guarded = ['id'];
	protected $casts = [
		// 'hiring_counts'=>'array',
		// 'salary_payments'=>'array',
		// 'accumulated_manpower_counts'=>'array',
		// 'salary_expenses'=>'array',
	];
	public function getName()
	{
		return $this->name ;
	}
	public function manpowers():HasMany
	{
		return $this->hasMany(Manpower::class,'position_id','id');
	}
	public function department():BelongsTo
	{
		return $this->belongsTo(Department::class,'department_id','id');
	}
	
	
}
