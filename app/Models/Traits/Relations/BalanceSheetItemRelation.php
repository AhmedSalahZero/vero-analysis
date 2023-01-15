<?php

namespace App\Models\Traits\Relations;

use App\Models\BalanceSheet;
use App\Models\SharingLink;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BalanceSheetItemRelation
{
    //    use CommonRelations  ;

    public function sharingLinks()
    {
        return $this->morphMany(SharingLink::class, 'shareable');
    }
    public function balanceSheets(): BelongsToMany
    {
        return $this->belongsToMany(
            BalanceSheet::class,
            'balance_sheet_item_main_item',
            'balance_sheet_item_id',
            'balance_sheet_id'
        );
    }
    public function subItems($balanceSheetId = null): BelongsToMany
    {
        return $this->belongsToMany(
            BalanceSheet::class,
            'balance_sheet_main_item_sub_items',
            'balance_sheet_item_id',
            'balance_sheet_id'
        )
        // pass 0 for all sub items
        ->when($balanceSheetId , function($q) use ($balanceSheetId){
            $q->where('balance_sheets.id',$balanceSheetId);
        })
        ->withPivot(['sub_item_name', 'payload', 'is_depreciation_or_amortization']);
        
    }
     public function mainRowsPivot($balanceSheetId=null): BelongsToMany
    {
        
        return $this->belongsToMany(
            BalanceSheet::class,
            'balance_sheet_main_item_calculations',
            'balance_sheet_item_id',
            'balance_sheet_id'
        )
         ->when($balanceSheetId , function($q) use ($balanceSheetId){
            $q->where('balance_sheets.id',$balanceSheetId);
        })
        ->withPivot(['payload','company_id','creator_id']);
    }

}
