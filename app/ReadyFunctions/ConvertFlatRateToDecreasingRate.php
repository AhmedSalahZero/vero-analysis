<?php
namespace App\ReadyFunctions;

use MathPHP\Finance;

class ConvertFlatRateToDecreasingRate
{
    public function excel_rate($nper, $pv, $fv = 0, $type = 0, $guess = 0.1)
    {
   //    	$nper = 13;
		$flatInterest = 0.34 ; 
		$pmt = -(1 + (1 * $flatInterest / 12 * $nper)) / $nper; // Payment: -0.10525641
	//	$pmt = -(1+(1*0.3/12*$nper))/$nper;
		// $pmt = -(1+(1*0.3/12*$nper))/$nper;
	//	$pv = 1;
	//	$fv = 0 ;
	//	$fv = 0;                       // Future value (default)
	//	$type = false;                 // Payments at end of period (default)
	//	$guess = 0.1;
		$annuallyDecreasingRate = Finance::rate($nper, $pmt, $pv, $fv,$type,$guess) * 12 ;
		return $annuallyDecreasingRate;
    }
}
