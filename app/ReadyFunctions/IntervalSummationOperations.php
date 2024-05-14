<?php 
namespace App\ReadyFunctions ;

use App\Models\HospitalitySector;
use Carbon\Carbon;

class IntervalSummationOperations 
{
	/**
	 * Sum An Array As Intervals  
	 *
	 * @param array $dateValues date and value array [01-01-2025=>20,01-02-2025=>30,etc]
	 * @param string $intervalName monthly , quarterly , semi-annually , annually
	 * @param string $financialYearStartMonth january , 01 or april , 04 or july , 07 
	 * @return array [01-01-2025=>20,01-02-2025=>30]
	 */
	
	public function sumForInterval(array $dateValues, string $intervalName,$financialYearStartMonth='january',array $dateIndexWithDate ):array 
	{

		$result = [];
		$periodInterval = $this->getPeriodsForStartMonths($intervalName,$financialYearStartMonth) ; 
		foreach ($dateValues as $dateAsString => $value) {
			if(is_numeric($dateAsString)){
				$dateAsString = $dateIndexWithDate[$dateAsString];
			}
			if(!is_numeric($value)){
				throw new \Exception('Value Must Be Numeric Value [ ' . $value . ' ] passed');
			}
			$dateObject = Carbon::make($dateAsString);
			$year = $dateObject->format('Y');
			$month = $dateObject->format('m');
			$day = $dateObject->format('d');
			$sumMonth = sprintf("%02d", $this->getSumMonth($month, $periodInterval));
			$resultDate = $day .'-'.$sumMonth.'-'. $year   ;
			$result[$resultDate] = isset($result[$resultDate]) ? $result[$resultDate] + $value  : $value;
		}
		return $result;
	}
	protected function getSumMonth($month, $mapMonths)
	{

		foreach ($mapMonths as $sumMonth => $sumMonths) {
			if (in_array($month, $sumMonths)) {
				return $sumMonth;
			}
		}
	}
	protected function getPeriodsForStartMonths($interval,$financialYearStartMonth = 'january')
	{
		if($financialYearStartMonth == 'january' || $financialYearStartMonth="01"){
			if ($interval == 'monthly') {
				return  [
					1 => [1],
					2 => [2],
					3 => [3],
					4 => [4],
					5 => [5],
					6 => [6],
					7 => [7],
					8 => [8],
					9 => [9],
					10 => [10],
					11 => [11],
					12 => [12],
				];
			}
	
			if ($interval == 'quarterly') {
	
				return [
					3 => [1, 2, 3], 6 => [4, 5, 6],9 => [7, 8, 9], 12 => [10, 11, 12]
				];
			}
			if ($interval == 'semi-annually') {
				return [
					6 => [1, 2, 3, 4, 5, 6], 12 => [7, 8, 9, 10, 11, 12]
				];
			}
	
			if ($interval == 'annually') {
				return [
					12 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
				];
			}
				
		}
		
		
		
		if($financialYearStartMonth == 'april' || $financialYearStartMonth=='04'){
			if ($interval == 'monthly') {
				return  [
					1 => [1],
					2 => [2],
					3 => [3],
					4 => [4],
					5 => [5],
					6 => [6],
					7 => [7],
					8 => [8],
					9 => [9],
					10 => [10],
					11 => [11],
					12 => [12],
				];
			}
	
			if ($interval == 'quarterly') {
	
				return [
					6 => [4, 5, 6], 9 => [7, 8, 9],12 => [10, 11, 12], 3 => [1, 2, 3]
				];
			}
			if ($interval == 'semi-annually') {
				return [
					9 => [4, 5, 6, 7,8,9], 3 => [10,11,12,1,2,3]
				];
			}
	
			if ($interval == 'annually') {
				return [
					3 => [4,5,6,7,8,9,10,11,12,1,2,3]
				];
			}
				
		}
		
		
		
		
		if($financialYearStartMonth == 'july' || $financialYearStartMonth=='07'){
			if ($interval == 'monthly') {
				return  [
					1 => [1],
					2 => [2],
					3 => [3],
					4 => [4],
					5 => [5],
					6 => [6],
					7 => [7],
					8 => [8],
					9 => [9],
					10 => [10],
					11 => [11],
					12 => [12],
				];
			}
	
			if ($interval == 'quarterly') {
	
				return [
					9 => [7,8,9], 12 => [10,11,12], 3 => [1,2,3], 6 => [4,5,6]
				];
			}
			if ($interval == 'semi-annually') {
				return [
					12 => [7,8,9,10,11,12], 6 => [1,2,3,4,5,6]
				];
			}
	
			if ($interval == 'annually') {
				return [
					6 => [7,8,9,10,11,12,1,2,3,4,5,6]
				];
			}
				
		}
		
		
		
	}
	
}
