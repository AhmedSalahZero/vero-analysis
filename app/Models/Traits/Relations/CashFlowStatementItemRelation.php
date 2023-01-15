<?php

namespace App\Models\Traits\Relations;

use App\Models\CashFlowStatement;
use App\Models\SharingLink;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait CashFlowStatementItemRelation
{
    //    use CommonRelations  ;

    public function sharingLinks()
    {
        return $this->morphMany(SharingLink::class, 'shareable');
    }
    public function cashFlowStatements(): BelongsToMany
    {
        return $this->belongsToMany(
            CashFlowStatement::class,
            'cash_flow_statement_item_main_item',
            'cash_flow_statement_item_id',
            'cash_flow_statement_id'
        );
    }
    public function subItems($cashFlowStatementId = null): BelongsToMany
    {
        return $this->belongsToMany(
            CashFlowStatement::class,
            'cash_flow_statement_main_item_sub_items',
            'cash_flow_statement_item_id',
            'cash_flow_statement_id'
        )
        // pass 0 for all sub items
        ->when($cashFlowStatementId , function($q) use ($cashFlowStatementId){
            $q->where('cash_flow_statements.id',$cashFlowStatementId);
        })
        ->withPivot(['sub_item_name', 'payload', 'is_depreciation_or_amortization'])
        
            // ->wherePivot('sub_item_name', '!=', null)
        ;
    }
     public function mainRowsPivot($cashFlowStatementId=null): BelongsToMany
    {
        
        return $this->belongsToMany(
            CashFlowStatement::class,
            'cash_flow_statement_main_item_calculations',
            'cash_flow_statement_item_id',
            'cash_flow_statement_id'
        )
         ->when($cashFlowStatementId , function($q) use ($cashFlowStatementId){
            $q->where('cash_flow_statements.id',$cashFlowStatementId);
        })
        ->withPivot(['payload','company_id','creator_id']);
    }

}
