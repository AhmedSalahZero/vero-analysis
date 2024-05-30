<?php

namespace App;

use App\Models\CleanOverdraft;
use App\Models\Company;
use App\Models\FullySecuredOverdraft;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * * هو عباره عن التقسيمة الخاصة بال 
 * *clean overdraft 
 * * outstanding balance
 * * او اي نوع تاني خاص بالتسهيلات
 * * بمعني انك لما بتحط ال
 * * الفلوس اللي انت سحبتها من الحساب لحد لحظه فتح حسابك علي كاش فيرو ..سحبت قديه يوم قديه وقديه يوم قديه وهكذا 
 * * بمعني ان مجموع القيم لازم يساوي ال
 * * outstanding balance in clean overdraft 
 */
class OutstandingBreakdown extends Model
{
    protected $guarded = ['id'];
	public function getId()
	{
		return $this->id;
	}
	public function company()
	{
		return $this->belongsTo(Company::class , 'company_id','id');
	}
	public function getSettlementDate()
	{
		return $this->settlement_date;
	}
	public function getSettlementDateForSelect()
	{
		$settlementDate = $this->getSettlementDate();
		return $settlementDate ? Carbon::make($settlementDate)->format('m/d/Y'):$settlementDate;
	}
	public function setSettlementDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['settlement_date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$this->attributes['settlement_date'] = $year.'-'.$month.'-'.$day;
	}
	
	public function getAmount()
	{
		return $this->amount?:0 ;
	}
	public function cleanOverDraft()
	{
		return $this->belongsTo(CleanOverdraft::class,'model_id','id')->where('model_type',CleanOverdraft::class);
	}
	public function fullySecuredOverDraft()
	{
		return $this->belongsTo(FullySecuredOverdraft::class,'model_id','id')->where('model_type',FullySecuredOverdraft::class);
	}
	
}
