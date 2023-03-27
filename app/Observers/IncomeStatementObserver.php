<?php

namespace App\Observers;

use App\Models\IncomeStatement;

class IncomeStatementObserver
{
	public function deleting(IncomeStatement $incomeStatement)
	{
		//		dd($incomeStatement, $incomeStatement->mainItems);

		// $incomeStatementItems = $incomeStatement->mainItems;
		// dd($incomeStatementItems);
		// foreach ($incomeStatementItems as $incomeStatementItem) {
		// 	$incomeStatementItem->withSubItemsFor($incomeStatement->id)->detach();
		// 	$incomeStatementItem->withMainRowsPivotFor($incomeStatement->id)->detach();
		// 	$incomeStatement->withMainItemsFor($incomeStatementItem->id)->detach();
		// 	//$incomeStatementItem->financialStatementAbles($incomeStatement->id)->detach();
		// }
	}
}
