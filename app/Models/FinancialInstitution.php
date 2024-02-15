<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\CertificatesOfDeposit;
use App\Models\CleanOverdraft;
use App\Models\OverdraftAgainstCommercialPaper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialInstitution extends Model
{
    protected $guarded = ['id'];
	
	public function scopeOnlyBanks(Builder $builder)
	{
		$builder->where('type','bank');
	}
	/**
	 * * نوع المؤسسة المالية وليكن مثلا بنك
	 */
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
	/**
	 * * هو رقم مميز للحساب الرئيسي زي ال الاي دي وبالتالي هو يختلف عن رقم الحساب نفسه 
	 */
	public function getCompanyAccountNumber()
	{
		return $this->company_account_number ; 
	}
	/**
	 * * تاريخ المبالغ الماليه اللي معايا في حساباتي في المؤسسة المالية دي 
	 */
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
	public function certificatesOfDeposits()
	{
		return $this->hasMany(CertificatesOfDeposit::class , 'financial_institution_id','id');
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
	public function storeNewAccounts(array $accounts,string $startDate = null,$inAddAdditionalAccountForm = false)
	{
		foreach($accounts as $index=>$accountArr){
			$isMainAccount = $inAddAdditionalAccountForm ? false : $index == 0 ;
			$account = $this->accounts()->create([
				'account_number'=>$accountArr['account_number'],
				'balance_amount'=>$accountArr['balance_amount'],
				'exchange_rate'=>$accountArr['exchange_rate'],
				'currency'=>$isMainAccount ?'egp': strtolower($accountArr['currency']),
				'iban'=>$accountArr['iban'],
				'is_main_account'=>$isMainAccount // الحساب المصري
			]);
			$startDate = isset($accountArr['start_date']) && $accountArr['start_date'] ? Carbon::make($accountArr['start_date'])->format('Y-m-d') : $startDate;
			$account->accountInterests()->create([
				'interest_rate'=>$accountArr['interest_rate'],
				'min_balance'=>$accountArr['min_balance'],
				'start_date'=>$startDate
			]);
		}
	}
	
}
