<?php
namespace App\Traits\Models;



trait HasBlockedAgainst
{
	public function getBlockedAgainstFormatted()
	{
		if($this->fullySecuredCleanOverdraft){
			return __('Blocked Against Overdraft');
		}
		return __('Free To Use');
	}
}
