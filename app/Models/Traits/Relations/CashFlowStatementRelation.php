<?php

namespace App\Models\Traits\Relations;

use App\Models\CashFlowStatementItem;
use App\Models\SharingLink;
use App\Models\Traits\Relations\Commons\CommonRelations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait CashFlowStatementRelation
{
    use CommonRelations;

    public function sharingLinks()
    {
        return $this->morphMany(SharingLink::class, 'shareable');
    }
    public function mainItems(): BelongsToMany
    {
        return $this->belongsToMany(
            CashFlowStatementItem::class,
            'cash_flow_statement_item_main_item',
            'cash_flow_statement_id',
            'cash_flow_statement_item_id'
        );
    }
    public function subItems(): BelongsToMany
    {
        // cash_flow_statement_id = 10 
        // cash_flow_statement_item_id = 11 ;
        
        return $this->belongsToMany(
            CashFlowStatementItem::class,
            'cash_flow_statement_main_item_sub_items',
            'cash_flow_statement_id',
            'cash_flow_statement_item_id'
        )->withPivot(['sub_item_name', 'payload', 'is_depreciation_or_amortization']);
    }

    public function mainRows($cashFlowStatementItemId=null): BelongsToMany
    {
        // cash_flow_statement_id = 10 
        // cash_flow_statement_item_id = 11 ;
        
        return $this->belongsToMany(
            CashFlowStatementItem::class,
            'cash_flow_statement_main_item_calculations',
            'cash_flow_statement_id',
            'cash_flow_statement_item_id'
        )
         ->when($cashFlowStatementItemId , function($q) use ($cashFlowStatementItemId){
            $q->where('cash_flow_statement_items.id',$cashFlowStatementItemId);
        })
        ->withPivot(['payload','company_id','creator_id']);
    }

}
