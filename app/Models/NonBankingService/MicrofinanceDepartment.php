<?php

namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\BelongsToCompany;
use App\Models\Traits\Scopes\IsDepartment;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class MicrofinanceDepartment extends Model
{
	use BelongsToStudy,BelongsToCompany,IsDepartment,HasBasicStoreRequest;
	protected $table ='microfinance_departments';
	protected $connection =NON_BANKING_SERVICE_CONNECTION_NAME;
 	protected $guarded = ['id'];
	const DEPARTMENT = 'department';
	const MICROFINANCE_DEPARTMENT = 'microfinance-department';
	 public static function boot()
	 {
		 parent::boot();
		 static::deleting(function(self $department){
			$positions = MicrofinancePosition::where('department_id',$department->id)->get();
			$positions->each(function(MicrofinancePosition $position){
				$position->delete();
			});
		 });
	 }
	 public function positions()
	{
		return $this->hasMany(MicrofinancePosition::class,'department_id','id');
	}
	
	
}
