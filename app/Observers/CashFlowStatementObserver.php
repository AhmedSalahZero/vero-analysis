<?php

namespace App\Observers;

use App\Models\CashFlowStatement;

class CashFlowStatementObserver
{
	public function deleting(CashFlowStatement $cashFlowStatement)
	{
		// $cashFlowStatementItems = $cashFlowStatement->mainItems;
		// foreach ($cashFlowStatementItems as $cashFlowStatementItem) {
		// 	$cashFlowStatementItem->withSubItemsFor($cashFlowStatement->id)->detach();
		// 	$cashFlowStatement->withMainRowsFor($cashFlowStatementItem->id)->detach();
		// 	$cashFlowStatement->withMainItemsFor($cashFlowStatementItem->id)->detach();
		// }
	}
}
