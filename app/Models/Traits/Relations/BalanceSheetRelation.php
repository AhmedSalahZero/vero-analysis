<?php

namespace App\Models\Traits\Relations;

use App\Models\BalanceSheetItem;
use App\Models\SharingLink;
use App\Models\Traits\Relations\Commons\CommonRelations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BalanceSheetRelation
{
    use CommonRelations;

    public function sharingLinks()
    {
        return $this->morphMany(SharingLink::class, 'shareable');
    }
    public function mainItems(): BelongsToMany
    {
        return $this->belongsToMany(
            BalanceSheetItem::class,
            'balance_sheet_item_main_item',
            'balance_sheet_id',
            'balance_sheet_item_id'
        );
    }
    public function subItems(): BelongsToMany
    {
        // balance_sheet_id = 10 
        // balance_sheet_item_id = 11 ;
        
        return $this->belongsToMany(
            BalanceSheetItem::class,
            'balance_sheet_main_item_sub_items',
            'balance_sheet_id',
            'balance_sheet_item_id'
        )->withPivot(['sub_item_name', 'payload', 'is_depreciation_or_amortization']);
    }

    public function mainRows($balanceSheetItemId=null): BelongsToMany
    {
        // balance_sheet_id = 10 
        // balance_sheet_item_id = 11 ;
        
        return $this->belongsToMany(
            BalanceSheetItem::class,
            'balance_sheet_main_item_calculations',
            'balance_sheet_id',
            'balance_sheet_item_id'
        )
         ->when($balanceSheetItemId , function($q) use ($balanceSheetItemId){
            $q->where('balance_sheet_items.id',$balanceSheetItemId);
        })
        ->withPivot(['payload','company_id','creator_id']);
    }

}
