<?php

namespace App\Observers;

use App\Models\BalanceSheet;

class BalanceSheetObserver
{
    public function deleting(BalanceSheet $balanceSheet){
        $balanceSheetItems = $balanceSheet->mainItems;
        foreach($balanceSheetItems as $balanceSheetItem){
            $balanceSheetItem->subItems($balanceSheet->id)->wherePivot('balance_sheet_id',$balanceSheet->id)->detach();
            $balanceSheet->mainRows($balanceSheetItem->id)->detach();
            $balanceSheet->mainItems()->wherePivot('balance_sheet_item_id',$balanceSheetItem->id)->detach();
        }

    }
}
