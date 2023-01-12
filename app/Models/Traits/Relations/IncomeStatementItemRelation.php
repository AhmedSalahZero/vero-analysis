<?php

namespace App\Models\Traits\Relations;

use App\Models\IncomeStatement;
use App\Models\SharingLink;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait IncomeStatementItemRelation
{
    //    use CommonRelations  ;

    public function sharingLinks()
    {
        return $this->morphMany(SharingLink::class, 'shareable');
    }
    public function incomeStatements(): BelongsToMany
    {
        return $this->belongsToMany(
            IncomeStatement::class,
            'income_statement_item_main_item',
            'income_statement_item_id',
            'income_statement_id'
        );
    }
    public function subItems($incomeStatementId = null): BelongsToMany
    {
        return $this->belongsToMany(
            IncomeStatement::class,
            'income_statement_main_item_sub_items',
            'income_statement_item_id',
            'income_statement_id'
        )
        // pass 0 for all sub items
        ->when($incomeStatementId , function($q) use ($incomeStatementId){
            $q->where('income_statements.id',$incomeStatementId);
        })
        ->withPivot(['sub_item_name', 'payload', 'is_depreciation_or_amortization'])
        
            // ->wherePivot('sub_item_name', '!=', null)
        ;
    }
     public function mainRowsPivot($incomeStatementId=null): BelongsToMany
    {
        
        return $this->belongsToMany(
            IncomeStatement::class,
            'income_statement_main_item_calculations',
            'income_statement_item_id',
            'income_statement_id'
        )
         ->when($incomeStatementId , function($q) use ($incomeStatementId){
            $q->where('income_statements.id',$incomeStatementId);
        })
        ->withPivot(['payload','company_id','creator_id']);
    }

}
