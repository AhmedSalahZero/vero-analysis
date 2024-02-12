<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\CleanOverdraft;
use App\Models\OverdraftAgainstCommercialPaper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class FinancialInstitution extends Model
{
    protected $guarded = ['id'];
	
	public function scopeOnlyBanks(Builder $builder)
	{
		$builder->where('type','bank');
	}
	public function getType():string 
	{
		return $this->type ;
	}
    public function isBank():bool
    {
        return $this->getType() =='bank';
    }
    public function isLeasingCompanies():bool
    {
        return $this->getType() =='leasing_companies';
    }
    public function isFactoringCompanies():bool
    {
        return $this->getType() =='factoring_companies';
    }
	public function isMortgageCompanies():bool
    {
        return $this->getType() =='mortgage_companies';
    }
	public function getName()
	{
		return $this->isBank() ? $this->getBankName() : $this->name ;
	}
	public function getBranchName()
	{
		return $this->branch_name ;
	}
	public function getCompanyAccountNumber()
	{
		return $this->company_account_number ; 
	}
	public function getSwiftCode()
	{
		return $this->swift_code ; 
	}
	public function getIbanCode()
	{
		return $this->iban_code ; 
	}
	public function getCurrentAccountNumber()
	{
		return $this->current_account_number ;
	}
	
	public function getBalanceAmount()
	{
		return $this->balance_amount ?: 0 ;
	}
	public function getBalanceAmountFormatted()
	{
		$balanceAmount = $this->getBalanceAmount();
		
		return $balanceAmount ? number_format($balanceAmount,0) : 0  ;
	}
	public function getBalanceDate()
	{
		return $this->balance_date ;
	}
	public function getBalanceDateFormatted()
	{
		$balanceDate = $this->getBalanceDate();
		return $balanceDate ? Carbon::make($balanceDate)->format('d-m-Y') : null;
	}
	public function getBankId()
    {
        return $this->bank_id ;
    }
	public function bank()
	{
		return $this->belongsTo(Bank::class ,'bank_id','id');
	}
	public function getBankName()
	{
		 return $this->bank ? $this->bank->getViewName() : __('N/A');
	}	
	public function getBankNameIn(string $lang)
	{
		 return $this->bank ? $this->bank['name_'.$lang] : __('N/A');
	}
	public function accounts():HasMany
	{
		return $this->hasMany(FinancialInstitutionAccount::class,'financial_institution_id','id');
	}
	public function overdraftAgainstCommercialPapers()
	{
		return $this->hasMany(OverdraftAgainstCommercialPaper::class , 'financial_institution_id','id');
	}
	public function cleanOverdrafts()
	{
		return $this->hasMany(CleanOverdraft::class , 'financial_institution_id','id');
	}
	public function LetterOfGuaranteeFacilities()
	{
		return $this->hasMany(LetterOfGuaranteeFacility::class , 'financial_institution_id','id');
	}
	public function LetterOfCreditFacilities()
	{
		return $this->hasMany(LetterOfCreditFacility::class , 'financial_institution_id','id');
	}
	
}
