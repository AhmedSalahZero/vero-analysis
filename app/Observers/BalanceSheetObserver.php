<?php

namespace App\Observers;

use App\Models\BalanceSheet;

class BalanceSheetObserver
{
	public function deleting(BalanceSheet $balanceSheet)
	{
		// $balanceSheetItems = $balanceSheet->mainItems;
		// foreach ($balanceSheetItems as $balanceSheetItem) {
		// 	$balanceSheetItem->withSubItemsFor($balanceSheet->id)->detach();
		// 	$balanceSheetItem->withMainRowsPivotFor($balanceSheet->id)->detach();
		// 	$balanceSheetItem->withMainItemsFor($balanceSheet->id)->detach();

		// 	//$balanceSheetItem->financialStatementAbles($balanceSheet->id)->detach();
		// }
	}
}
