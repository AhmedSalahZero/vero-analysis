<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{

	const IN_SAFE = 'in-safe';
	const UNDER_COLLECTION = 'under-collection';
	const REJECTED = 'rejected';
	const COLLECTED = 'collected';
		 
    protected $guarded = ['id'];
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class,'money_received_id');
	}
	public static function getChequeTypesForAging():array
	{
		return [
			self::IN_SAFE,
			self::UNDER_COLLECTION
		];
	}
	public function getDepositDate()
	{
		return $this->deposit_date ; 
	}
	public function getDepositDateFormatted()
	{
		$depositDate = $this->getDepositDate();
		return $depositDate ? Carbon::make($depositDate)->format('d-m-Y'): null ;
	}
	public function setDepositDateAttribute($value)
	{
		if(!$value){
			return null ;
		}
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['deposit_date'] = $value;
			return  ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$this->attributes['deposit_date'] = $year.'-'.$month.'-'.$day;
		
	}
	/**
	 * * هو البنك اللي جالي منة الشيك من العميل فا مش شرط يكون من بنوكي
	 */
	public function draweeBank(){
		return $this->belongsTo(Bank::class,'drawee_bank_id','id');
	}
	public function getDraweeBankId()
	{
		$draweeBank = $this->draweeBank;
		return $draweeBank ? $draweeBank->id : 0 ;
	}
	public function getDraweeBankName($lang = null)
	{
		$draweeBank = $this->draweeBank;
		return $draweeBank ? $draweeBank->getName($lang) : 0 ;
	}
	/**
	 * * هو البنك اللي انا باخد الشيك واسحبة منة وبالتالي لازم يكون من بنوكي
	 */
	public function drawlBank()
	{
		return $this->belongsTo(FinancialInstitution::class , 'drawl_bank_id','id');
	}
	public function getDrawlBankId()
	{
		$drawlBank = $this->drawlBank ;
		return $drawlBank  ? $drawlBank->id : 0 ;
	}
	
	public function getDrawlBankName()
	{
		$drawlBank = $this->drawlBank ;
		return $drawlBank  ? $drawlBank->getName() :__('N/A') ;
	}
	public function getChequeNumber()
	{
		return $this->cheque_number ;
	}
	public function getNumber()
	{
		return $this->getChequeNumber();
	}
	
	
	
	
	
	public function setActualCollectionDateAttribute($value)
	{
		if(!$value){
			return null ;
		}
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['actual_collection_date'] = $value;
			return  ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$this->attributes['actual_collection_date'] = $year.'-'.$month.'-'.$day;
		
	}
	
	public function getStatus()
	{
		return $this->status ;
	}
	
	public function getStatusFormatted()
	{
		return snakeToCamel($this->getStatus());
	}
	public function getDueDate()
	{
		return $this->due_date;
	}
	public function getDueDateFormatted()
	{
		$dueDate = $this->getDueDate();
		return  $dueDate ? Carbon::make($dueDate)->format('d-m-Y') : null ;
	}
	public function setDueDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['due_date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		
		$this->attributes['due_date'] = $year.'-'.$month.'-'.$day;
	}
	
	/**
	 * * هنعرفه ان كان مستحق الدفع ولا لا كا استرنج مش بولين
	 */
	public function getDueStatus():bool 
	{
		$dueDate = $this->getDueDate();
		return !Carbon::make($dueDate)->greaterThan(now());
	}
	/**
	 * * هنعرفه ان كان مستحق الدفع ولا لا كا استرنج مش بولين
	 */
	public function getDueStatusFormatted():array 
	{
		if($this->getDueStatus()){
			return [
				'status'=>__('Due') ,
				'color'=>'red'
			];
		}
		return [
			'status'=>__('Not Due Yet'),
			'color'=>'green'
		];
		
	}
	
	
		/**
	 * * هو عباره عن رقم الحساب اللي هينزل فيه مبلغ الشيك بعد التحصيل من البنك
	 */
	public function getAccountNumber()
	{
		return $this->account_number;
	}
	public function getAccountBalance()
	{
		return $this->account_balance ;
	}
	/**
	 * * عدد الايام المتوقع فيها تحصيل الشيك من البنك ولو البنك الخاص بالشيك اللي العميل جابه هو نفس البنك اللي هتحصل فيه 
	 * * فا بيكون قيمته بصفر
	 */
	public function getClearanceDays()
	{
		return $this->clearance_days ?: 0;
	}
	public function calculateChequeExpectedCollectionDate(string $chequeDepositDate , int $chequeClearanceDays):string 
	{
		$chequeDueDate = $this->getDueDate();
		$chequeDueDate = Carbon::make($chequeDueDate);
		$chequeDepositDate = Carbon::make($chequeDepositDate);
		if($chequeDepositDate->lessThan($chequeDueDate)){
			$diffInDays = $chequeDueDate->diffInDays($chequeDepositDate) + $chequeClearanceDays ;
			return $chequeDepositDate->addDays($diffInDays)->format('Y-m-d');
		}
		else{
			return $chequeDepositDate->addDays($chequeClearanceDays)->format('Y-m-d');	
		}
	}
	
	public function chequeAccountBalance()
	{
		return $this->account_balance?:0 ;
	}
	public function getCollectionFees()
	{
		return $this->collection_fees?:0 ;
	}
	
	public function getCollectionFeesFormatted()
	{
		$collectionFees = $this->getCollectionFees();
		return number_format($collectionFees,0) ;
	}
	public function chequeExpectedCollectionDate()
	{
		return $this->expected_collection_date ;
	}
	public function chequeExpectedCollectionDateFormatted()
	{
		$date  = $this->chequeExpectedCollectionDate() ;
		return $date ? Carbon::make($date)->format('d-m-Y') : null ;
	}
	public function chequeActualCollectionDate()
	{
		return $this->actual_collection_date ;
	}
	public function chequeActualCollectionDateFormatted()
	{
		$date  = $this->chequeActualCollectionDate() ;
		return $date ? Carbon::make($date)->format('d-m-Y') : null ;
	}
	public function getAccountType()
	{
		return $this->account_type ;
	}
	public function getDueAfterDays()
	{
		$firstDate = Carbon::make($this->getDueDate());
		$secondDate = Carbon::make($this->moneyReceived->getReceivingDate());
		return getDiffBetweenTwoDatesInDays($firstDate , $secondDate);
	}

}
