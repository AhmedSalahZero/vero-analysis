<?php 
namespace App\Enums;
class LcTypes
{
	public const SIGHT_LC = 'sight-lc';
	public const DEFERRED = 'deferred';
	public const CASH_AGAINST_DOCUMENT = 'cash-against-document';
	public static function getAll():array 
	{
		return [
			self::SIGHT_LC => __('Sight LC') , 
			self::DEFERRED => __('Deferred'),
			self::CASH_AGAINST_DOCUMENT=>__('Cash Against Document'),
		];
	}
	 
}
