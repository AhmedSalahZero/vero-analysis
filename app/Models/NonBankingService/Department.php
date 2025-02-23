<?php

namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\BelongsToCompany;
use App\Models\Traits\Scopes\IsDepartment;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	
	use BelongsToStudy,BelongsToCompany,IsDepartment;
	protected $table ='departments';
	protected $connection =NON_BANKING_SERVICE_CONNECTION_NAME;
 	protected $guarded = ['id'];
	 public static function boot()
	 {
		 parent::boot();
		 static::deleting(function(self $department){
			$department->positions->each(function(Position $position){
				$position->delete();
			});
		 });
	 }
	 public function positions()
	{
		return $this->hasMany(Position::class,'department_id','id');
	}
	
	public function getDeleteRoute():string
	{
		return route('delete.single.department.for.non.banking',['company'=>$this->company->id,'department'=>$this->id,'study'=>$this->study->id]);
	}	
}
