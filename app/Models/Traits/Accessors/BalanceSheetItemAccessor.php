<?php

namespace App\Models\Traits\Accessors;

use App\Models\BalanceSheet;
use App\Models\BalanceSheetItem;
use Illuminate\Support\Collection;

trait BalanceSheetItemAccessor
{
	public function getId(): int
	{
		return $this->id;
	}
	public function getName(): string
	{
		return $this->name;
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
	public function getSubItems(int $balanceSheetId, string $subItemType, string $subItemName = ''): Collection
	{
		return $this->withSubItemsFor($balanceSheetId, $subItemType, $subItemName)->get();
	}
	public function getSubItemsPivot(int $balanceSheetId, string $subItemType, string $subItemName = ''): Collection
	{
		return $this->getSubItems($balanceSheetId, $subItemType, $subItemName)->pluck('pivot');
	}

	public function getMainRowsPivot(int $balanceSheetId): Collection
	{
		return $this->withMainRowsPivotFor($balanceSheetId)->get()->pluck('pivot');
	}
	public function getParentTableClassName(): string
	{
		return get_class(new BalanceSheet);
	}
	public function getParentTableName(): string
	{
		return (new BalanceSheet)->getTable();
	}
}
