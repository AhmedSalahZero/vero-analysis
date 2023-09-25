<?php

namespace App\Models;

use App\Traits\StaticBoot;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Notifiable,HasRoles,InteractsWithMedia;
    // SoftDeletes,
    // StaticBoot;

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
        // return in_array($this->email , [
        //     'mahmoud.youssef@squadbcc.com',
        //     'samer.tawfik@squadbcc.com',
        //     'admin@admin.com',
		// 	'f.dandachi@digitect.com',
		// 	's.elbana@digitect.com',
		// 	'm.qutbuddin@digitect.com',
		// 	'mabdallah@jobmastergroup.com',
		// 	'khairy@edgeconsultant.com'
        // ]);
    }

    public function getName():string
    {
        return $this->name ;
    }
	public function getRoleName()
	{
		return Auth()->user()->roles->first()->name;
	}
	public function isSuperAdmin()
	{
		return Auth()->user() && Auth()->user()->roles->first()->name == 'super-admin';;
	}
	public function isCompanyAdmin():bool 
	{
		return Auth()->user() && Auth()->user()->roles->first()->name == 'company-admin';
	}
	public function isUser():bool 
	{
		return Auth()->user() && Auth()->user()->roles->first()->name == 'user';
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
		// dd(reportNames(),$reportName);
		$reports  = searchWordInstr(reportNames(),$reportName);
		// dd($reports);
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
}
