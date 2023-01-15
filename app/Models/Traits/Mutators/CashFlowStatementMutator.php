<?php

namespace App\Models\Traits\Mutators;

use App\Models\CashFlowStatement;
use App\Models\CashFlowStatementItem;
use Auth;
use Illuminate\Http\Request;

trait CashFlowStatementMutator
{

    public function storeMainSection(Request $request)
    {
        $cashFlowStatement = CashFlowStatement::create($request->except(['_token']));
        return $cashFlowStatement;
    }
    public function storeMainItems(Request $request)
    {
        foreach (CashFlowStatementItem::get() as $cashFlowStatementItem) {

            $this->mainItems()->attach($cashFlowStatementItem->id, [
                'company_id' => \getCurrentCompanyId(),
                'creator_id' => Auth()->user()->id,
                'created_at' => now()
            ]);

            // if ($cashFlowStatementItem->isDependsOn()) {
            //     $cashFlowStatementItem->subItems()->attach($this->id, [
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
        $cashFlowStatement = CashFlowStatement::find($request->input('cash_flow_statement_id'));
        $cashFlowStatementItemId = $request->input('cash_flow_statement_item_id');


        foreach ((array)$request->sub_items as $index => $options) {
            if ($options['name']  && !$cashFlowStatement->subItems()->wherePivot('cash_flow_statement_item_id', $cashFlowStatementItemId)->wherePivot('sub_item_name', $options['name'])->exists()) {
                $cashFlowStatement->subItems()->attach($cashFlowStatementItemId, [
                    'company_id' => \getCurrentCompanyId(),
                    'creator_id' => Auth::id(),
                    'sub_item_name' => $options['name'],
                    'is_depreciation_or_amortization' => $options['is_depreciation_or_amortization'] ?? false,
                    'created_at' => now()
                ]);
            }
        }
        foreach ((array)$request->get('value') as $cashFlowStatementId => $cashFlowStatementItems) {
            $cashFlowStatement = CashFlowStatement::find($cashFlowStatementId)->load('subItems');

            foreach ($cashFlowStatementItems as $cashFlowStatementItemId => $values) {
                foreach ($values as $sub_item_origin_name => $payload) {
                    if ($cashFlowStatement->subItems()->wherePivot('sub_item_name', $sub_item_origin_name)->where('cash_flow_statement_items.id', $cashFlowStatementItemId)->exists()) {
                        $cashFlowStatement->subItems()->wherePivot('sub_item_name', $sub_item_origin_name)->where('cash_flow_statement_items.id', $cashFlowStatementItemId)->updateExistingPivot($cashFlowStatementItemId, [
                            'payload' => json_encode($payload)
                        ]);
                    }
                }
            }
        }
        // foreach ((array)$request->get('valueMainRowWithoutSubItems') as $cashFlowStatementId => $cashFlowStatementItems) {
        //     $cashFlowStatement = CashFlowStatement::find($cashFlowStatementId)->load('subItems');

        //     foreach ($cashFlowStatementItems as $cashFlowStatementItemId => $payload) {
        //         $cashFlowStatement->subItems()->wherePivot('sub_item_name', null)->where('cash_flow_statement_items.id', $cashFlowStatementItemId)->updateExistingPivot($cashFlowStatementItemId, [
        //             'payload' => json_encode($payload)
        //         ]);
        //     }
        // }
        foreach ((array)$request->get('cashFlowStatementItemName') as $cashFlowStatementId => $cashFlowStatementItems) {

                  foreach ($values as $sub_item_origin_name => $payload) {
            $cashFlowStatement = CashFlowStatement::find($cashFlowStatementId)->load('subItems');

            foreach ($cashFlowStatementItems as $cashFlowStatementItemId => $names) {
                $cashFlowStatement->subItems()->wherePivot('sub_item_name', array_keys($names)[0])->where('cash_flow_statement_items.id', $cashFlowStatementItemId)->updateExistingPivot($cashFlowStatementItemId, [
                    'sub_item_name'=>array_values($names)[0]
                ]);
            }
                  }
        }
        // store autocaulated values
        foreach((array)$request->valueMainRowThatHasSubItems as $cashFlowStatementId=>$cashFlowStatementItems){
                        $cashFlowStatement = CashFlowStatement::find($cashFlowStatementId)->load('mainRows');
                        foreach($cashFlowStatementItems as $cashFlowStatementItemId=>$payload){
                             $cashFlowStatement->mainRows($cashFlowStatementItemId)->detach($cashFlowStatementItemId);
                              $cashFlowStatement->mainRows($cashFlowStatementItemId)->attach($cashFlowStatementItemId,[
                                        'payload' => json_encode($payload),
                                            'company_id' => \getCurrentCompanyId(),
                                            'creator_id' => Auth::id(),
                                ] , false );

                        }   
        }

         foreach((array)$request->valueMainRowWithoutSubItems as $cashFlowStatementId=>$cashFlowStatementItems){
                        $cashFlowStatement = CashFlowStatement::find($cashFlowStatementId)->load('mainRows');
                        foreach($cashFlowStatementItems as $cashFlowStatementItemId=>$payload){
                             $cashFlowStatement->mainRows($cashFlowStatementItemId)->detach($cashFlowStatementItemId);
                              $cashFlowStatement->mainRows($cashFlowStatementItemId)->attach($cashFlowStatementItemId,[
                                        'payload' => json_encode($payload),
                                            'company_id' => \getCurrentCompanyId(),
                                            'creator_id' => Auth::id(),
                                ] , false );

                        }   
        }
        
        //     
        // foreach($request->names as $name){
        //     $cashFlowStatement->subItems()->attach($request->input('cash_flow_statement_item_id') , [
        //         'company_id'=>\getCurrentCompanyId(),
        //         'creator_id'=>Auth::id(),
        //         'sub_item_name'=>$name ,
        //         'created_at'=>now()
        //     ])    ;
        // }

    }
}
