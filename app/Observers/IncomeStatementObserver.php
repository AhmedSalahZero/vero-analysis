<?php

namespace App\Observers;

use App\Models\IncomeStatement;

class IncomeStatementObserver
{
    public function deleting(IncomeStatement $incomeStatement){
        $incomeStatementItems = $incomeStatement->mainItems;
        foreach($incomeStatementItems as $incomeStatementItem){
            $incomeStatementItem->subItems($incomeStatement->id)->wherePivot('income_statement_id',$incomeStatement->id)->detach();
            $incomeStatement->mainItems()->wherePivot('income_statement_item_id',$incomeStatementItem->id)->detach();
        }

    }
}
