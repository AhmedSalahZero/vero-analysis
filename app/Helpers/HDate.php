<?php 
namespace App\Helpers;


class HDate 
{
	public static function formatDateFromDatePicker(?string $date):?string
	{
		if(!$date){
			return null ;
		}
		$date = explode('/',$date);
		return $date[2] .'-'.$date[1] . '-'.$date[0];
	}	
}
