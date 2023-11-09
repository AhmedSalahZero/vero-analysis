<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Bank extends Model
{
	protected $guarded = ['id'];
	public function getName()
	{
		return $this['name_'.App()->getLocale()];
	}
	public function getViewName()
	{
		return $this->view_name;
	}
}
