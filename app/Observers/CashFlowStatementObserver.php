<?php

namespace App\Observers;

use App\Models\CashFlowStatement;

class CashFlowStatementObserver
{
    public function deleting(CashFlowStatement $cashFlowStatement){
        $cashFlowStatementItems = $cashFlowStatement->mainItems;
        foreach($cashFlowStatementItems as $cashFlowStatementItem){
            $cashFlowStatementItem->subItems($cashFlowStatement->id)->wherePivot('cash_flow_statement_id',$cashFlowStatement->id)->detach();
            $cashFlowStatement->mainRows($cashFlowStatementItem->id)->detach();
            $cashFlowStatement->mainItems()->wherePivot('cash_flow_statement_item_id',$cashFlowStatementItem->id)->detach();
        }

    }
}
