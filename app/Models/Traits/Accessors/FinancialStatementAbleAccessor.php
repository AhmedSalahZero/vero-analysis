<?php

namespace App\Models\Traits\Accessors;

use Carbon\Carbon;
use Illuminate\Support\Collection;

trait FinancialStatementAbleAccessor
{
	public function getId(): int
	{
		return $this->id;
	}
	public function getName(): string
	{
		return $this->name;
	}
	public function getDurationType(): string
	{
		return $this->duration_type;
	}
	public function getCompanyId(): int
	{
		return $this->company->id ?? 0;
	}
	public function getCompanyName(): string
	{
		return $this->company->getName();
	}
	public function getCreatorName(): string
	{
		return $this->creator->name ?? __('N/A');
	}
	public function getIntervalFormatted(): array
	{
		$method = 'addMonth';
		$startDate = Carbon::make($this->start_from);
		if ($this->duration_type == 'annually') {
			$method = 'addYear';
			$endDate = Carbon::make($this->start_from)->addYears($this->duration);
		} elseif ($this->duration_type == 'quarterly') {
			$endDate = Carbon::make($this->start_from)->addMonths($this->duration - 1);
			$dateBetweenTwoIntervals = generateDatesBetweenTwoDates($startDate, $endDate, $method, 'M\'Y', false, 'Y-m-d');
			return formatDateIntervalFor($dateBetweenTwoIntervals, $this->duration_type);
		} else {
			$endDate = Carbon::make($this->start_from)->addMonths($this->duration - 1);
		}
		return \generateDatesBetweenTwoDates($startDate, $endDate, $method, 'M\'Y', false, 'Y-m-d');
	}

	public function isDependsOn(): bool
	{
		return $this->depends_on;
	}
	public function canViewActualReport(): bool
	{
		if (strEndsWith(get_class($this), 'CashFlowStatement')) {
			return false;
		}
		
		return $this->subItems()->wherePivot('sub_item_type', 'forecast')->count() > 1;
		// return $this->subItems()->wherePivot('sub_item_type', 'forecast')->count() > 1;
	}
	public function getSubItems(int $financialStatementAbleItemId, string $subItemType, string $subItemName = ''): Collection
	{
		return $this->withSubItemsFor($financialStatementAbleItemId, $subItemType, $subItemName)->get();
	}
	public function lastActualDates(?array $dates)
	{
		$lastActualDate = null ;
		if($dates && count($dates))
		{
			foreach($dates as $date){
				if(isActualDate($date)){
					$lastActualDate =$date; 
				}
			}
		}
		return $lastActualDate ; 
	}
	public function getFirstAndEndDate(): array
	{
		$dates = $this->getIntervalFormatted();
		$dates = array_keys($dates);
		$lastActualDate = $this->lastActualDates($dates);
		$dateLength = count($dates);
		$interval = [];
		if ($dateLength) {
			$endDate = $lastActualDate ?: ($dates[$dateLength - 1]) ;
			$year = explode('-',$endDate)[0];
			$month = explode('-',$endDate)[1];
			$endDate = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');
			// $day = explode('-',$endDate)[1];
			// dd($endDate);
			$interval = [
				'start_date' => ($dates[0]),
				'end_date' =>$endDate 
			];
			
			
		}
		// dd($interval);
		return $interval;
	}
}
