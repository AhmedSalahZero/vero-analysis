<?php 
namespace App\Helpers;
class HStr {
	public static function camelizeWithSpace($input, $separator = '-')
	{
		return str_replace($separator, ' ', ucwords($input, $separator));
	}
	public static function replaceSpecialCharacters($string){
		return str_replace(array( '\'', '"',',' , ';', '<', '>','\\' ), ' ', $string);
	} 
}
