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
			$incomeStatement->withMainRowsFor($incomeStatementItem->id)->detach();
			$incomeStatement->withMainItemsFor($incomeStatementItem->id)->detach();
		}
	}
}
