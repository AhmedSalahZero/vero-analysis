<?php

namespace App\Observers;

use App\Models\BalanceSheet;

class BalanceSheetObserver
{
	public function deleting(BalanceSheet $balanceSheet)
	{
		$balanceSheetItems = $balanceSheet->mainItems;
		foreach ($balanceSheetItems as $balanceSheetItem) {
			$balanceSheetItem->withSubItemsFor($balanceSheet->id)->detach();
			$balanceSheet->withMainRowsFor($balanceSheetItem->id)->detach();
			$balanceSheet->withMainItemsFor($balanceSheetItem->id)->detach();
		}
	}
}
