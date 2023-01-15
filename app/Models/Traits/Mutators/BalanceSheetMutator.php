<?php

namespace App\Models\Traits\Mutators;

use App\Models\BalanceSheet;
use App\Models\BalanceSheetItem;
use Auth;
use Illuminate\Http\Request;

trait BalanceSheetMutator
{

    public function storeMainSection(Request $request)
    {
        $balanceSheet = BalanceSheet::create($request->except(['_token']));
        return $balanceSheet;
    }
    public function storeMainItems(Request $request)
    {
        foreach (BalanceSheetItem::get() as $balanceSheetItem) {

            $this->mainItems()->attach($balanceSheetItem->id, [
                'company_id' => \getCurrentCompanyId(),
                'creator_id' => Auth()->user()->id,
                'created_at' => now()
            ]);

            // if ($balanceSheetItem->isDependsOn()) {
            //     $balanceSheetItem->subItems()->attach($this->id, [
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
        $balanceSheet = BalanceSheet::find($request->input('balance_sheet_id'));
        $balanceSheetItemId = $request->input('balance_sheet_item_id');


        foreach ((array)$request->sub_items as $index => $options) {
            if ($options['name']  && !$balanceSheet->subItems()->wherePivot('balance_sheet_item_id', $balanceSheetItemId)->wherePivot('sub_item_name', $options['name'])->exists()) {
                $balanceSheet->subItems()->attach($balanceSheetItemId, [
                    'company_id' => \getCurrentCompanyId(),
                    'creator_id' => Auth::id(),
                    'sub_item_name' => $options['name'],
                    'is_depreciation_or_amortization' => $options['is_depreciation_or_amortization'] ?? false,
                    'created_at' => now()
                ]);
            }
        }
        foreach ((array)$request->get('value') as $balanceSheetId => $balanceSheetItems) {
            $balanceSheet = BalanceSheet::find($balanceSheetId)->load('subItems');

            foreach ($balanceSheetItems as $balanceSheetItemId => $values) {
                foreach ($values as $sub_item_origin_name => $payload) {
                    if ($balanceSheet->subItems()->wherePivot('sub_item_name', $sub_item_origin_name)->where('balance_sheet_items.id', $balanceSheetItemId)->exists()) {
                        $balanceSheet->subItems()->wherePivot('sub_item_name', $sub_item_origin_name)->where('balance_sheet_items.id', $balanceSheetItemId)->updateExistingPivot($balanceSheetItemId, [
                            'payload' => json_encode($payload)
                        ]);
                    }
                }
            }
        }
        // foreach ((array)$request->get('valueMainRowWithoutSubItems') as $balanceSheetId => $balanceSheetItems) {
        //     $balanceSheet = BalanceSheet::find($balanceSheetId)->load('subItems');

        //     foreach ($balanceSheetItems as $balanceSheetItemId => $payload) {
        //         $balanceSheet->subItems()->wherePivot('sub_item_name', null)->where('balance_sheet_items.id', $balanceSheetItemId)->updateExistingPivot($balanceSheetItemId, [
        //             'payload' => json_encode($payload)
        //         ]);
        //     }
        // }
        foreach ((array)$request->get('balanceSheetItemName') as $balanceSheetId => $balanceSheetItems) {

                  foreach ($values as $sub_item_origin_name => $payload) {
            $balanceSheet = BalanceSheet::find($balanceSheetId)->load('subItems');

            foreach ($balanceSheetItems as $balanceSheetItemId => $names) {
                $balanceSheet->subItems()->wherePivot('sub_item_name', array_keys($names)[0])->where('balance_sheet_items.id', $balanceSheetItemId)->updateExistingPivot($balanceSheetItemId, [
                    'sub_item_name'=>array_values($names)[0]
                ]);
            }
                  }
        }
        // store autocaulated values
        foreach((array)$request->valueMainRowThatHasSubItems as $balanceSheetId=>$balanceSheetItems){
                        $balanceSheet = BalanceSheet::find($balanceSheetId)->load('mainRows');
                        foreach($balanceSheetItems as $balanceSheetItemId=>$payload){
                             $balanceSheet->mainRows($balanceSheetItemId)->detach($balanceSheetItemId);
                              $balanceSheet->mainRows($balanceSheetItemId)->attach($balanceSheetItemId,[
                                        'payload' => json_encode($payload),
                                            'company_id' => \getCurrentCompanyId(),
                                            'creator_id' => Auth::id(),
                                ] , false );

                        }   
        }

         foreach((array)$request->valueMainRowWithoutSubItems as $balanceSheetId=>$balanceSheetItems){
                        $balanceSheet = BalanceSheet::find($balanceSheetId)->load('mainRows');
                        foreach($balanceSheetItems as $balanceSheetItemId=>$payload){
                             $balanceSheet->mainRows($balanceSheetItemId)->detach($balanceSheetItemId);
                              $balanceSheet->mainRows($balanceSheetItemId)->attach($balanceSheetItemId,[
                                        'payload' => json_encode($payload),
                                            'company_id' => \getCurrentCompanyId(),
                                            'creator_id' => Auth::id(),
                                ] , false );

                        }   
        }
        
       
    }
}
