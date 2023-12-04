<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LetterOfCreditFacilityTermAndCondition extends Model
{
    protected $guarded = ['id'];
	public function getLgType()
	{
		return $this->lg_type;
	}
	public function getOutstandingBalance()
	{
		return $this->outstanding_balance ?: 0 ;
	}
	
	public function getOutstandingDateFormatted()
	{
		$outStandingDate = $this->outstanding_date ;
		return $outStandingDate ? Carbon::make($outStandingDate)->format('d-m-Y'):null ;
	}
	
	public function getCashCoverRate()
	{
		return $this->cash_cover_rate ?: 0 ;
	}
	public function getCommissionRate()
	{
		return $this->commission_rate ?: 0 ;
	}
	public function getCommissionInterval()
	{
		return $this->commission_interval  ;
	}
	public function letterOfCreditFacility()
	{
		return $this->belongsTo(LetterOfCreditFacility::class , 'letter_of_credit_facility_id','id');
	}
}
