<?php
namespace App\Models\Traits\Accessors ;

use Illuminate\Support\Collection;

trait CashFlowStatementItemAccessor
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
    public function getSubItems(int $cashFlowStatementId):Collection{
        return $this->subItems($cashFlowStatementId)->wherePivot('cash_flow_statement_id',$cashFlowStatementId)->get();
    }
      public function getSubItemsPivot(int $cashFlowStatementId):Collection{
        return $this->getSubItems($cashFlowStatementId)->pluck('pivot');
    }


    public function getMainRowsPivot(int $cashFlowStatementId):Collection{
        return $this->mainRowsPivot($cashFlowStatementId)->wherePivot('cash_flow_statement_id',$cashFlowStatementId)->get()->pluck('pivot');
    }
  


 
}