<?php

namespace App\Models;

use App\Models\LetterOfCreditFacilityTermAndCondition;
use App\Traits\Models\HasLetterOfCreditCashCoverStatements;
use App\Traits\Models\HasLetterOfCreditStatements;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LetterOfCreditFacility extends Model
{
	use HasLetterOfCreditStatements , HasLetterOfCreditCashCoverStatements;
    
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
		$contractEndDate = $this->getContractEndDate() ;
		return $contractEndDate ? Carbon::make($contractEndDate)->format('d-m-Y'):null ;
	}

	public function getOutstandingDate()
	{
		return $this->outstanding_date;
	}
	public function getOutstandingDateFormatted()
	{
		$outstandingDate = $this->getOutstandingDate() ;
		return $outstandingDate ? Carbon::make($outstandingDate)->format('d-m-Y'):null ;
	}

	public function getLimit()
	{
		return $this->limit ?: 0 ;
	}

	public function getLimitFormatted()
	{
		return number_format($this->getLimit()) ;
	}
	public function getOutstandingAmount()
	{
		return $this->outstanding_amount ?: 0 ;
	}

	public function getOutstandingAmountFormatted()
	{
		return number_format($this->getOutstandingAmount()) ;
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
		return $this->hasMany(LetterOfCreditFacilityTermAndCondition::class , 'letter_of_credit_facility_id','id');
	}
    public function termAndConditionForLcType(string $lcType){
        return $this->termAndConditions->where('lc_type',$lcType)->first();
    }
	public function letterOfCreditStatements()
	{
		return $this->hasMany(LetterOfCreditStatement::class,'lc_facility_id','id');
	}
	public function letterOfCreditCashCoverStatements()
	{
		return $this->hasMany(LetterOfCreditCashCoverStatement::class,'lc_facility_id','id');
	}

}
