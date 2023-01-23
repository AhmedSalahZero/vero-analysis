<?php

namespace App\Models\Traits\Mutators;

use App\Models\IncomeStatement;
use App\Models\IncomeStatementItem;
use Auth;
use Illuminate\Http\Request;

trait IncomeStatementMutator
{

    public function storeMainSection(Request $request)
    {
        $incomeStatement = IncomeStatement::create($request->except(['_token']));
        return $incomeStatement;
    }
    public function storeMainItems(Request $request)
    {
        foreach (IncomeStatementItem::get() as $incomeStatementItem) {

            $this->mainItems()->attach($incomeStatementItem->id, [
                'company_id' => \getCurrentCompanyId(),
                'creator_id' => Auth()->user()->id,
                'created_at' => now()
            ]);

            // if ($incomeStatementItem->isDependsOn()) {
            //     $incomeStatementItem->subItems()->attach($this->id, [
            //         'company_id' => \getCurrentCompanyId(),
            //         'creator_id' => Auth()->user()->id,
            //         'created_at' => now(),
            //         'sub_item_name' => null
            //     ]);
            // }
        }
        return $this;
    }
    public function storeReport(Request $request)
    {
        // dd();
        
        // dd($request->all());
        $incomeStatement = IncomeStatement::find($request->input('income_statement_id'));
        $incomeStatementItemId = $request->input('income_statement_item_id');


        foreach ((array)$request->sub_items as $index => $options) {
            if ($options['name']  && !$incomeStatement->subItems()->wherePivot('income_statement_item_id', $incomeStatementItemId)->wherePivot('sub_item_name', $options['name'])->exists()) {
                $incomeStatement->subItems()->attach($incomeStatementItemId, [
                    'company_id' => \getCurrentCompanyId(),
                    'creator_id' => Auth::id(),
                    'sub_item_name' => $options['name'],
                    'is_depreciation_or_amortization' => $options['is_depreciation_or_amortization'] ?? false,
                    'created_at' => now()
                ]);
            }
        }
        foreach ((array)$request->get('value') as $incomeStatementId => $incomeStatementItems) {
            $incomeStatement = IncomeStatement::find($incomeStatementId)->load('subItems');

            foreach ($incomeStatementItems as $incomeStatementItemId => $values) {
                foreach ($values as $sub_item_origin_name => $payload) {
                    if ($incomeStatement->subItems()->wherePivot('sub_item_name', $sub_item_origin_name)->where('income_statement_items.id', $incomeStatementItemId)->exists()) {
                        $incomeStatement->subItems()->wherePivot('sub_item_name', $sub_item_origin_name)->where('income_statement_items.id', $incomeStatementItemId)->updateExistingPivot($incomeStatementItemId, [
                            'payload' => json_encode($payload)
                        ]);
                    }
                }
            }
        }
        // foreach ((array)$request->get('valueMainRowWithoutSubItems') as $incomeStatementId => $incomeStatementItems) {
        //     $incomeStatement = IncomeStatement::find($incomeStatementId)->load('subItems');

        //     foreach ($incomeStatementItems as $incomeStatementItemId => $payload) {
        //         $incomeStatement->subItems()->wherePivot('sub_item_name', null)->where('income_statement_items.id', $incomeStatementItemId)->updateExistingPivot($incomeStatementItemId, [
        //             'payload' => json_encode($payload)
        //         ]);
        //     }
        // }
        foreach ((array)$request->get('incomeStatementItemName') as $incomeStatementId => $incomeStatementItems) {

                  foreach ($values as $sub_item_origin_name => $payload) {
            $incomeStatement = IncomeStatement::find($incomeStatementId)->load('subItems');

            foreach ($incomeStatementItems as $incomeStatementItemId => $names) {
                $incomeStatement->subItems()->wherePivot('sub_item_name', array_keys($names)[0])->where('income_statement_items.id', $incomeStatementItemId)->updateExistingPivot($incomeStatementItemId, [
                    'sub_item_name'=>array_values($names)[0]
                ]);
            }
                  }
        }
        // store autocaulated values
        foreach((array)$request->valueMainRowThatHasSubItems as $incomeStatementId=>$incomeStatementItems){
                        $incomeStatement = IncomeStatement::find($incomeStatementId)->load('mainRows');
                        foreach($incomeStatementItems as $incomeStatementItemId=>$payload){
                             $incomeStatement->mainRows($incomeStatementItemId)->detach($incomeStatementItemId);
                              $incomeStatement->mainRows($incomeStatementItemId)->attach($incomeStatementItemId,[
                                        'payload' => json_encode($payload),
                                            'company_id' => \getCurrentCompanyId(),
                                            'creator_id' => Auth::id(),
                                ] , false );

                        }   
        }

         foreach((array)$request->valueMainRowWithoutSubItems as $incomeStatementId=>$incomeStatementItems){
                        $incomeStatement = IncomeStatement::find($incomeStatementId)->load('mainRows');
                        foreach($incomeStatementItems as $incomeStatementItemId=>$payload){
                             $incomeStatement->mainRows($incomeStatementItemId)->detach($incomeStatementItemId);
                              $incomeStatement->mainRows($incomeStatementItemId)->attach($incomeStatementItemId,[
                                        'payload' => json_encode($payload),
                                            'company_id' => \getCurrentCompanyId(),
                                            'creator_id' => Auth::id(),
                                ] , false );

                        }   
        }
        
        //     
        // foreach($request->names as $name){
        //     $incomeStatement->subItems()->attach($request->input('income_statement_item_id') , [
        //         'company_id'=>\getCurrentCompanyId(),
        //         'creator_id'=>Auth::id(),
        //         'sub_item_name'=>$name ,
        //         'created_at'=>now()
        //     ])    ;
        // }

    }
}
