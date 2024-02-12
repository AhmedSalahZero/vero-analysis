<?php

namespace App\Models;

use App\Models\LetterOfCreditFacility;
use App\Models\LetterOfGuaranteeFacility;
use App\Traits\StaticBoot;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Notifiable,HasRoles,InteractsWithMedia;
	protected $connection = 'mysql';
    protected $fillable = [
        'name', 'email', 'password','max_users',
		'created_by'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'companies_users');
    }
    public function canViewIncomeStatement()
    {
		return true ;
    }

    public function getName():string
    {
        return $this->name ;
    }
	public function getRoleName()
	{
		return $this->roles->first()->name;
	}
	
	public function isSuperAdmin()
	{
		return auth()->check() && $this->roles->first()->name == 'super-admin';;
	}
	public function isCompanyAdmin():bool 
	{
		return auth()->check() && $this->roles->first()->name == 'company-admin';
	}
	public function isUser():bool 
	{
		return auth()->check() && $this->roles->first()->name == 'user';
	}
	public function usersCreatedBy()
	{
		return $this->hasMany(User::class , 'created_by','id');
	}
	public function canStoreMoreUser():bool
	{
		if($this->isCompanyAdmin())
		{
			return $this->usersCreatedBy->count() < $this->max_users;
		}	
		return true ;
	}
	public function canViewReport(string $reportName):bool
	{
	
		$canViewReport = false ;
		$user = Auth()->user() ; 
		$reports  = searchWordInstr(reportNames(),$reportName);
		foreach($reports as $report){
			$canViewReport = $user->can(generateReportName($report));
			if(!$canViewReport){
				return false ;
			}
		}
		return $canViewReport ;
	}
	public function logs()
	{
		return $this->hasMany(Log::class , 'user_id','id');
	}
	public function hasRole($roleName):bool
	{
		return $this->roles->first()->name == $roleName ;
	}
	public function moneyReceived()
	{
		return $this->hasMany(MoneyReceived::class , 'user_id','id')->where('company_id',getCurrentCompanyId());
	}
	
	public function getMoneyReceived():Collection
	{
		return $this->moneyReceived->where('company_id',getCurrentCompanyId()) ;
	}
	public function getReceivedCheques():Collection
	{
		return $this->moneyReceived->where('money_type','cheque') ;
	}
	public function getReceivedCashes():Collection
	{
		return $this->moneyReceived->where('money_type','cash') ;
	}
	public function getReceivedTransfer():Collection
	{
		return $this->moneyReceived->where('money_type','incoming_transfer') ;
	}
	public function financialInstitutions()
	{
		return $this->hasMany(FinancialInstitution::class , 'created_by','id')->where('company_id',getCurrentCompanyId());
	}
	public function financialInstitutionsBanks():Collection
	{
		return $this->financialInstitutions->where('type','bank') ;
	}
	public function financialInstitutionsLeasingCompanies():Collection
	{
		return $this->financialInstitutions->where('type','leasing_companies') ;
	}
	public function financialInstitutionsFactoringCompanies():Collection
	{
		return $this->financialInstitutions->where('type','factoring_companies') ;
	}
	public function financialInstitutionsMortgageCompanies():Collection
	{
		return $this->financialInstitutions->where('type','mortgage_companies') ;
	}
	public function overdraftAgainstCommercialPaper()
	{
		return $this->hasMany(OverdraftAgainstCommercialPaper::class , 'created_by','id')->where('company_id',getCurrentCompanyId());
	}
	public function cleanOverdraft()
	{
		return $this->hasMany(CleanOverdraft::class , 'created_by','id')->where('company_id',getCurrentCompanyId());
	}
	public function letterOfGuaranteeFacilities()
	{
		return $this->hasMany(LetterOfGuaranteeFacility::class , 'created_by','id')->where('company_id',getCurrentCompanyId());
	}
	public function letterOfCreditFacilities()
	{
		return $this->hasMany(LetterOfCreditFacility::class , 'created_by','id')->where('company_id',getCurrentCompanyId());
	}
	public function isFreeTrialAccount()
	{
		return $this->subscription == 'free_trial';	
	}
	public function getExpirationDaysLeft()
	{
		$now = strtotime(date('Y-m-d')); // or your date as well
            $your_date = strtotime($this->expiration_date);
			# dd($your_date); 
            $datediff = $your_date - $now;
            return round($datediff / (60 * 60 * 24));
	}
	public function AccountExpired()
	{
		$expirationDate = $this->expiration_date ;
		if($expirationDate && $this->isFreeTrialAccount()){
			return now()->greaterThan($this->expiration_date);
		}
		return false ;
	}
	
	
}
