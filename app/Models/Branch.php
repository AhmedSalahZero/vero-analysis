<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
	protected $table ='branch';
	protected $guarded = ['id'];
	public function getName()
	{
		return $this->name;
	}
	public function getBranch()
	{
		return $this->belongsTo(Company::class , 'company_id','id');
	}
	public function creator()
	{
		return $this->belongsTo(User::class , 'creator_id','id');
	}
	public static function getBranchesForCurrentCompany(int $companyId){
		return Branch::where('company_id',$companyId)->pluck('name','id')->toArray();
	}
	public function cashInSafeStatements()
	{
		return $this->hasMany(CashInSafeStatement::class,'branch_id','id');
	}
	public static function storeHeadOffice(int $companyId)
	{
		self::create([
			'company_id'=>$companyId,
			'name'=>'Head Office'
		]);
	}
}
