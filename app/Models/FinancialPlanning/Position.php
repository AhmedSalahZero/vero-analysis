<?php

namespace App\Models\FinancialPlanning;

use App\Models\Traits\Scopes\BelongsToCompany;
use App\Models\Traits\Scopes\FinancialPlanning\BelongsToStudy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Position extends Model
{
	
	use BelongsToStudy,BelongsToCompany;
	protected $connection =FINANCIAL_PLANNING_CONNECTION_NAME;
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
		return $this->getHiringCounts()[$dateIndex];
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
	public static function calculateManpowerResult(array $dateAsIndexes , int $existingCount , array $hiringCounts , int $studyStartIndex,float $annualIncreaseRate,float $monthlyNetSalary,float $salaryTaxesRate , float $socialInsuranceRate )
	{

		$currentIndex = 0 ;
		$annuallyIncrease = $monthlyNetSalary ;
		$accumulatedManpowerCounts = [];
		$monthlySalariesPayments = [];
		$salaryExpenses =[];
		foreach($dateAsIndexes as  $dateAsIndex){
			$previousHiringCount =$accumulatedManpowerCounts[$dateAsIndex-1] ?? $existingCount;
			$accumulatedManpowerCounts[$dateAsIndex] = $hiringCounts[$dateAsIndex] + $previousHiringCount   ;
			if($currentIndex%12 == 0 && $currentIndex != 0){
				$annuallyIncrease = $annuallyIncrease * (1+($annualIncreaseRate/100)) * $accumulatedManpowerCounts[$dateAsIndex];   
			}
			$monthlySalariesPayments[$dateAsIndex] = $annuallyIncrease ;
			$salaryExpenses[$dateAsIndex] = $annuallyIncrease / (1 - ($salaryTaxesRate + $socialInsuranceRate));
			$currentIndex++;
			
		}
		return [
			'accumulated_manpower_counts'=>$accumulatedManpowerCounts,
			'manpower_salaries'=>$monthlySalariesPayments,
			'salary_expenses'=>$salaryExpenses,
		];
	}
	
}
