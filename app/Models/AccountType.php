<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * * هي عباره عن انواع الحسابات البنكية وليكن مثلا ال
 * * debit  (فلوس ليا عند البنك)-> current , time deposit , certificate of deposit الحساب الجاري الحساب الودايع حساب الشهادات
 * * credit التسهيلات البنكية (فلوس عليا) ->
 */
class AccountType extends Model
{
	CONST CURRENT_ACCOUNT = 'current-account';
	CONST CLEAN_OVERDRAFT = 'clean-overdraft';
	CONST OVERDRAFT_AGAINST_COMMERCIAL_PAPER = 'overdraft-against-commercial-paper';
	CONST OVERDRAFT_AGAINST_ASSIGNMENT_OF_CONTRACTS= 'overdraft-against-assignment-of-contracts';
	CONST CERTIFICATE_OF_DEPOSIT= 'certificate-of-deposit-cd';
	CONST TIME_OF_DEPOSIT= 'time-of-deposit-td';
	protected $guarded =[
		'id'
	];
	public function scopeOnlyCashAccounts(Builder $builder)
	{
		return $builder->onlySlugs([self::CURRENT_ACCOUNT,self::CLEAN_OVERDRAFT,self::OVERDRAFT_AGAINST_COMMERCIAL_PAPER,self::OVERDRAFT_AGAINST_ASSIGNMENT_OF_CONTRACTS]);
	}

	public function scopeOnlyCurrentAccount(Builder $builder)
	{
		return $builder->onlySlugs([self::CURRENT_ACCOUNT]);
	}
    public function scopeOnlyCdOrTdAccounts(Builder $builder)
	{
		return $builder->onlySlugs([self::CERTIFICATE_OF_DEPOSIT,self::TIME_OF_DEPOSIT]);
	}
	public function isCdOrTdAccount()
	{
		return in_array($this->slug , [self::CERTIFICATE_OF_DEPOSIT , self::TIME_OF_DEPOSIT]);
	}
	public function isCleanOverDraftAccount():bool
	{
		return $this->slug === self::CLEAN_OVERDRAFT ;
	}
	public function isCurrentAccount():bool
	{
		return $this->slug === self::CURRENT_ACCOUNT ;
	}
	public function getModelName()
	{
		return $this->model_name;
	}
	public function getSlug()
	{
		return $this->slug ;
	}

	public function scopeOnlySlugs(Builder $builder , array $slugs)
	{
		return $builder->whereIn('slug',$slugs);
	}
	public function getId()
	{
		return $this->id ;
	}
	public function getName()
	{
		return $this['name_'.app()->getLocale()];
	}



}
