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
}
