<?php

namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\BelongsToCompany;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Position extends Model
{
	
	use BelongsToStudy,BelongsToCompany;
	protected $connection =NON_BANKING_SERVICE_CONNECTION_NAME;
 	protected $guarded = ['id'];
	protected $casts = [
		'hiring_counts'=>'array',
		'manpower_salaries'=>'array',
		'accumulated_manpower_counts'=>'array',
		'salary_expenses'=>'array',
	];
	public function getName()
	{
		return $this->name ;
	}
	public function getExistingCount():int 
	{
		return $this->existing_count;
	}
	public function getMonthlyNetSalary()
	{
		return $this->monthly_net_salary;
	}
	public function getHiringCounts():array
	{
		return (array)$this->hiring_counts;
	} 
	public function getHiringCountsAtDateIndex(int $dateIndex)
	{
		return $this->getHiringCounts()[$dateIndex]??0;
	}
	
	public function getManpowerSalaries():array
	{
		return $this->manpower_salaries;
	} 
	public function getManpowerSalariesAtDateIndex(int $dateIndex)
	{
		return $this->getManpowerSalaries()[$dateIndex];
	}
	
	public function getAccumulatedManpowerCounts():array
	{
		return $this->accumulated_manpower_counts;
	} 
	public function getAccumulatedManpowerCountsAtDateIndex(int $dateIndex)
	{
		return $this->getAccumulatedManpowerCounts()[$dateIndex];
	}
	
	public function department():BelongsTo
	{
		return $this->belongsTo(Department::class,'department_id','id');
	}
	
	
}
