<?php
namespace App\Traits\Models;

use Carbon\Carbon;



trait HasUserComment
{
	public function getUserComment():?string 
	{
		return $this->user_comment ?: '' ;
	}
	
}
