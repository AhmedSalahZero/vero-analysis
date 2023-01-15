<?php
namespace App\Models\Traits\Accessors ;

use Illuminate\Support\Collection;

trait BalanceSheetItemAccessor
{
    public function getId():int
    {
        return $this->id ; 
    }
    public function getName():string 
    {
        return $this->name ;
    }
     public function getCompanyId():int
    {
        return $this->company->id ?? 0; 
    }
    public function getCompanyName():string
    {
        return $this->company->getName() ;
    }
    public function getCreatorName():string
    {
        return $this->creator->name ?? __('N/A');
    }
    public function getSubItems(int $balanceSheetId):Collection{
        return $this->subItems($balanceSheetId)->wherePivot('balance_sheet_id',$balanceSheetId)->get();
    }
      public function getSubItemsPivot(int $balanceSheetId):Collection{
        return $this->getSubItems($balanceSheetId)->pluck('pivot');
    }


    public function getMainRowsPivot(int $balanceSheetId):Collection{
        return $this->mainRowsPivot($balanceSheetId)->wherePivot('balance_sheet_id',$balanceSheetId)->get()->pluck('pivot');
    }
  


 
}