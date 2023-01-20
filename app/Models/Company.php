<?php

namespace App\Models;

use App\Traits\StaticBoot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends Model implements HasMedia
{
	use
		//  SoftDeletes,
		StaticBoot,
		InteractsWithMedia;
	protected $guarded = [];
	protected $casts = ['name' => 'array'];
	public function users()
	{
		return $this->belongsToMany(User::class, 'companies_users');
	}
	public function subCompanies()
	{
		return $this->hasMany(Company::class, 'sub_of');
	}
	// public function branches()
	// {
	//     return $this->hasMany(Branch::class);
	// }
	public function getBranchesWithSectionsAttribute()
	{
		$branches = [];
		foreach ($this->branches as  $branch) {
			@count($branch->sections) == 0 ?: array_push($branches, $branch);
		}


		return $branches;
	}

	public function exportableModelFields($modelName)
	{
		return $this->hasOne(CustomizedFieldsExportation::class)->where('model_name', $modelName);
	}

	public function getName(): string
	{
		return $this->name[App()->getLocale()];
	}
}
