<?php 
namespace App\Enums;
class LgTypes
{
	public const BID_BOND = 'bid-bond';
	public const FINAL_LGS = 'final-lgs';
	public const ADVANCED_PAYMENT_LGS = 'advanced-payment-lgs';
	public const PERFORMANCE_LG = 'performance-lg';
	public static function getAll():array 
	{
		return [
			self::BID_BOND => __('Bid Bond') , 
			self::FINAL_LGS => __('Final LG'),
			self::ADVANCED_PAYMENT_LGS=>__('Advanced Payment LG'),
			self::PERFORMANCE_LG=>__('Performance LG')
		];
	}
	 
}
