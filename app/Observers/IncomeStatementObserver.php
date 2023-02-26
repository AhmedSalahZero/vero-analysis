<?php

namespace App\Observers;

use App\Models\IncomeStatement;

class IncomeStatementObserver
{
	public function deleting(IncomeStatement $incomeStatement)
	{
		$incomeStatementItems = $incomeStatement->mainItems;
		foreach ($incomeStatementItems as $incomeStatementItem) {
			$incomeStatementItem->withSubItemsFor($incomeStatement->id)->detach();
			$incomeStatementItem->withMainRowsPivotFor($incomeStatement->id)->detach();
			$incomeStatementItem->financialStatementAbles($incomeStatement->id)->detach();
		}
	}
}
