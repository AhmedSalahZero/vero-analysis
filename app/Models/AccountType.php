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
	protected $guarded =[
		'id'
	];
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
