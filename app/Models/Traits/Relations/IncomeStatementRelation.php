<?php

namespace App\Models\Traits\Relations;

use App\Models\IncomeStatementItem;
use App\Models\SharingLink;
use App\Models\Traits\Relations\Commons\CommonRelations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait IncomeStatementRelation
{
    use CommonRelations;

    public function sharingLinks()
    {
        return $this->morphMany(SharingLink::class, 'shareable');
    }
    public function mainItems(): BelongsToMany
    {
        return $this->belongsToMany(
            IncomeStatementItem::class,
            'income_statement_item_main_item',
            'income_statement_id',
            'income_statement_item_id'
        );
    }
    public function subItems(): BelongsToMany
    {
        // income_statement_id = 10 
        // income_statement_item_id = 11 ;
        
        return $this->belongsToMany(
            IncomeStatementItem::class,
            'income_statement_main_item_sub_items',
            'income_statement_id',
            'income_statement_item_id'
        )->withPivot(['sub_item_name', 'payload', 'is_depreciation_or_amortization']);
    }

    public function mainRows($incomeStatementItemId=null): BelongsToMany
    {
        // income_statement_id = 10 
        // income_statement_item_id = 11 ;
        
        return $this->belongsToMany(
            IncomeStatementItem::class,
            'income_statement_main_item_calculations',
            'income_statement_id',
            'income_statement_item_id'
        )
         ->when($incomeStatementItemId , function($q) use ($incomeStatementItemId){
            $q->where('income_statement_items.id',$incomeStatementItemId);
        })
        ->withPivot(['payload','company_id','creator_id']);
    }

}
