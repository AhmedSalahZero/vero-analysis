<?php

namespace App\Models;

use App\Models\LetterOfGuaranteeFacilityTermAndCondition;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LetterOfGuaranteeFacility extends Model
{
    protected $guarded = ['id'];
	public function getContractStartDate()
	{
		return $this->contract_start_date;
	}
	public function getContractStartDateFormatted()
	{
		$contractStartDate = $this->contract_start_date ;
		return $contractStartDate ? Carbon::make($contractStartDate)->format('d-m-Y'):null ;
	}
	public function getContractEndDate()
	{
		return $this->contract_end_date;
	}
	public function getContractEndDateFormatted()
	{
		$contractEndDate = $this->getContractStartDate() ;
		return $contractEndDate ? Carbon::make($contractEndDate)->format('d-m-Y'):null ;
	}
	public function getLimit()
	{
		return $this->limit ?: 0 ;
	}
	public function getCurrency()
	{
		return $this->currency ;
	}
	public function financialInstitution()
	{
		return $this->belongsTo(FinancialInstitution::class , 'financial_institution_id','id');
	}
	public function termAndConditions()
	{
		return $this->hasMany(LetterOfGuaranteeFacilityTermAndCondition::class , 'letter_of_guarantee_facility_id','id');
	}

	
	
	
}
