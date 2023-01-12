<?php
namespace App\Models\Traits\Accessors ;

use Illuminate\Support\Collection;

trait IncomeStatementItemAccessor
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
    public function getSubItems(int $incomeStatementId):Collection{
        return $this->subItems($incomeStatementId)->wherePivot('income_statement_id',$incomeStatementId)->get();
    }
      public function getSubItemsPivot(int $incomeStatementId):Collection{
        return $this->getSubItems($incomeStatementId)->pluck('pivot');
    }


    public function getMainRowsPivot(int $incomeStatementId):Collection{
        return $this->mainRowsPivot($incomeStatementId)->wherePivot('income_statement_id',$incomeStatementId)->get()->pluck('pivot');
    }
  


 
}