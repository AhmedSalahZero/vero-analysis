<?php

namespace App\Models;


use App\Traits\Models\HasLetterOfGuaranteeCashCoverStatements;
use App\Traits\Models\HasLetterOfGuaranteeStatements;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LcFacilityExpense extends Model
{
	use HasLetterOfGuaranteeStatements,HasLetterOfGuaranteeCashCoverStatements;
	protected $table ='lc_facility_expenses';
	protected $guarded =  [
		'id'
	];
	public function letterOfGuaranteeFacility()
	{
		return $this->belongsTo(LetterOfGuaranteeFacility::class,'lc_facility_id');
	}
	public function getDate()
    {
        return $this->date ;
    }
	public function getDateFormatted()
    {
		$date = $this->getDate() ;
        return $date ? Carbon::make($date)->format('d-m-Y') : null   ;
    }
	public function getAmount()
	{
		return $this->amount ?:0 ;
	}
	public function getAmountFormatted()
	{
		return number_format($this->getAmount()) ;
	}	
	

	
}
