<?php

namespace App\Models;

use App\Helpers\HArr;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
	const SUPER_ADMIN = 'super-admin';
	const COMPANY_ADMIN = 'company-admin';
	const MANAGER = 'manager';
	const USER = 'user';
	
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
	public function hasAccessToSystems(array  $systemNames):bool{
			if($this->isSuperAdmin()){
				return true ;
			}
			$userSystemName = $this->getSystemsNames() ;
			return HArr::atLeastOneValueExistInArray($userSystemName,$systemNames);
			
	}
	public function getSystemsNames():array{
		if($this->isSuperAdmin()){
			return CompanySystem::getAllSystemNames();
		}
		$firstCompany = $this->companies->first() ;
		/**
		 * @var Company $firstCompany
		 */
		return $firstCompany ? $firstCompany->getSystemsNames() : [] ;
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
		return  $this->roles->first()->name == 'super-admin';
	}
	public function isCompanyAdmin():bool 
	{
	
		return  $this->roles->first()->name == 'company-admin';
	}
	public function isManager():bool 
	{
		return  $this->roles->first()->name == 'manager';
	}
	public function isUser():bool 
	{
		return  $this->roles->first()->name == 'user';
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
		/**
		 * @var User $user ;
		 */
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
	public function moneyPayments()
	{
		return $this->hasMany(MoneyPayment::class , 'user_id','id')->where('company_id',getCurrentCompanyId());
	}
	
	public function downPayment()
	{
		return $this->hasMany(DownPayment::class , 'user_id','id')->where('company_id',getCurrentCompanyId());
	}
	
	public function getMoneyReceived():Collection
	{
		return $this->moneyReceived->where('company_id',getCurrentCompanyId()) ;
	}
	public function getReceivedChequesInSafe(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CHEQUE)->filterByReceivingDate($startDate,$endDate)->filter(function(MoneyReceived $moneyReceived){
			$cheque = $moneyReceived->cheque ;
			return $cheque && in_array($cheque->getStatus(),[Cheque::IN_SAFE]) ;
		})->values();
		
	}
	/**
	 * * هي الشيكات اللي اترفضت ورجعتها الخزنة تاني وليكن مثلا بسبب ان حساب العميل مفيهوش فلوس حاليا
	 */
	public function getReceivedRejectedChequesInSafe(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CHEQUE)->filterByReceivingDate($startDate,$endDate)->filter(function(MoneyReceived $moneyReceived){
			$cheque = $moneyReceived->cheque ;
			return $cheque && in_array($cheque->getStatus(),[Cheque::REJECTED]) ;
		})->values();
	}
	
	public function getCollectedCheques(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CHEQUE)->filterByReceivingDate($startDate,$endDate)->filter(function(MoneyReceived $moneyReceived){
			$cheque = $moneyReceived->cheque ;
			return $cheque && in_array($cheque->getStatus(),[Cheque::COLLECTED]) ;
		})->values();
	}
	
	public function getReceivedChequesUnderCollection(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CHEQUE)->filterByReceivingDate($startDate,$endDate)->filter(function(MoneyReceived $moneyReceived){
			$cheque = $moneyReceived->cheque ;
			return $cheque && in_array($cheque->getStatus(),[Cheque::UNDER_COLLECTION]) ;
		})->values();
	}
	public function getReceivedCashesInSafe(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CASH_IN_SAFE)->whereNull('opening_balance_id')->filterByReceivingDate($startDate,$endDate) ;
	}
	public function getReceivedCashesInBank(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CASH_IN_BANK)->filterByReceivingDate($startDate,$endDate) ;
	}
	public function getReceivedTransfer(?string $startDate = null ,?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::INCOMING_TRANSFER)->filterByReceivingDate($startDate,$endDate) ;
	}
	
	
	
	public function overdraftAgainstCommercialPaper()
	{
		return $this->hasMany(OverdraftAgainstCommercialPaper::class , 'created_by','id')->where('company_id',getCurrentCompanyId());
	}
	
	public function overdraftAgainstAssignmentOfContract()
	{
		return $this->hasMany(OverdraftAgainstAssignmentOfContract::class , 'created_by','id')->where('company_id',getCurrentCompanyId());
	}
	
	public function isFreeTrialAccount()
	{
		return $this->subscription == 'free_trial';	
	}
	public function getExpirationDaysLeft()
	{
		$now = strtotime(date('Y-m-d')); // or your date as well
            $your_date = strtotime($this->expiration_date);
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
	


	 /**
	  * * For Money Payments 
	  */
	public function getCashPayments(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyPayments->where('type',MoneyPayment::CASH_PAYMENT)->whereNull('opening_balance_id')->filterByDeliveryDate($startDate,$endDate) ;
	}
	public function getOutgoingTransfer(?string $startDate = null ,?string $endDate = null):Collection
	{
		return $this->moneyPayments->where('type',MoneyPayment::OUTGOING_TRANSFER)->filterByDeliveryDate($startDate,$endDate) ;
	}	
	public function getPayableCheques(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyPayments->where('type',MoneyPayment::PAYABLE_CHEQUE)->filterByDeliveryDate($startDate,$endDate)->filter(function(MoneyPayment $moneyPayment){
			$payableCheque = $moneyPayment->payableCheque ;
			return $payableCheque && in_array($payableCheque->getStatus(),[PayableCheque::PENDING,PayableCheque::PAID]) ;
		})->values();
	}
	public function assignNewPermission(array $permissionArr , Permission $permission)
	{

		if(in_array($this->getRoleName(),$permissionArr['default-roles']) && $this->hasAccessToSystems($permissionArr['systems'])   
						){
							$this->givePermissionTo($permission->name);
						}
	}	
	public static function getUsersWithRoles(?Company $company,string $roleName = null)
	{
		$authUser = auth()->user();
		return User::with('roles')->when($company,function($q) use ($company,$authUser,$roleName){
			$q
			->whereHas('companies',function($q) use($company){
				$q->where('companies.id',$company->id);
			})
			->whereHas('roles',function($q) use ($authUser){
				if(!$authUser->can('view managers')){
					$q->where(function($q) use ($authUser){
						$q->where('roles.id','!=',4)->orWhere('users.id','=',$authUser->id);
					});
				}
				if(!$authUser->can('view company admin')){
					$q->where(function($q) use ($authUser){
						$q->where('roles.id','!=',2)->orWhere('users.id','=',$authUser->id);
					});
				}
				if(!$authUser->can('view super admin')){
					$q->where(function($q) use ($authUser){
						$q->where('roles.id','!=',1)->orWhere('users.id','=',$authUser->id);
					});
				}
				if(!$authUser->can('view users')){
					$q->where(function($q) use ($authUser){
						$q->where('roles.id','!=',3)->orWhere('users.id','=',$authUser->id);
					});
				}
			})->when($roleName,function($q) use ($roleName){
				$q->whereHas('roles',function($q) use ($roleName){
					$q->where('roles.name',$roleName);
				});
			})->whereHas('companies',function($q) use ($company){
				$q->where('companies.id',$company->id);
			});
		})
		->get();
	}
}
