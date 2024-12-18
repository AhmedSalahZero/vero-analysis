<?php

namespace App\Models;

use App\Helpers\HDate;
use App\Models\LcSettlementInternalMoneyTransfer;
use App\Traits\IsBankStatement;
use App\Traits\Models\HasDeleteButTriggerChangeOnLastElement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class LcOverdraftBankStatement extends Model
{
	use HasDeleteButTriggerChangeOnLastElement,IsBankStatement ;
	protected $guarded =[
		'id'
	];
	const LC_OVERDRAFT_MONEY_TRANSFER  = 'lc-overdraft-money-transfer';
	public static function getSources()
	{
		return [
			'lc-facility'=>__('LC Facility')
		];
	}
	public $oldFullDate = null;
	public static function updateNextRows(self $model):string 
	{
		$minDate  = $model->full_date ;
		DB::table('letter_of_credit_facilities')->where('id',$model->lc_facility_id)->update([
			'oldest_full_date'=>$minDate,
		]);
		/**
		 * * ليه بنستخدم ال 
		 * * min date
		 * * علشان لو عدلنا العنصر الحالي وخلينا التاريخ بتاعه اكبر من التاريخ القديم وقتها العناصر اللي ما بين التاريخ مش هيتعدلوا
		 * * مع انهم كان مفروض يتعدلوا بس انت قولتله عدلي العناصر اللي التاريخ بتاعها اكبر من او يساوي التاريخ الجديد
		 * * ودا غلط مفروض التاريخ الاقل ما بين التاريخ الجديد و القديم للعنصر بحيث دايما يبدا يحدث من عنده
		 */
		$tableName = (new self)->getTable();
		 DB::table($tableName)
		->where('full_date','>=',$minDate)
		->orderByRaw('full_date asc , priority asc , id asc')
		->where($tableName.'.lc_facility_id',$model->lc_facility_id)
		->each(function($lcOverdraftBankStatement) use($tableName){
			DB::table($tableName)->where('id',$lcOverdraftBankStatement->id)->update([
				'updated_at'=>now()
			]);
		});
		
		return $minDate;

	}
		protected static function booted(): void
		{
			static::creating(function(self $model){
				$model->created_at = now();
				$date = $model->date ;
				$time  = now()->format('H:i:s');
				$fullDateTime = date('Y-m-d H:i:s', strtotime("$date $time")) ;
				/**
				 * * دي علشان لو ليهم نفس التاريخ والوقت بالظبط يزود ثانيه علي التاريخ القديم
				 */
				$fullDateTime = HDate::generateUniqueDateTimeForModel(self::class,'full_date',$fullDateTime,[
					[
						'lc_facility_id','=',$model->lc_facility_id ,
					]
				]) ;
				$model->full_date = $fullDateTime;
			});
			
			static::created(function(self $model){
				self::updateNextRows($model);
			});
			
			static::updated(function (self $model) {
				$tableName = (new self)->getTable();
				$minDate = self::updateNextRows($model);
				$isChanged = $model->isDirty('lc_facility_id') ;
				/**
				 * * دي علشان لو غيرت ال
				 * * lc_facility_id
				 * * بمعني انه نقل السحبة مثلا من حساب الي حساب اخر .. يبقي هنحتاج نشغل الترجرز علشان الحساب القديم علشان يوزع تاني
				 */
				if($isChanged){
					$oldLcOverdraftId=$model->getRawOriginal('lc_facility_id');
					$oldBankStatementId=$model->getRawOriginal('id');
					// لو ما لقناش اول واحد فوقه هندور علي اول واحد بعدة					
					$firstBankStatementForOldLcOverdraft = self::where('lc_facility_id',$oldLcOverdraftId)->where('id','!=',$oldBankStatementId)->orderBy('id')->first()  ;
					// لو كانت القديمة دي قبل ما تتغير هي الاستيتم الوحيده بعد كدا انت غيرتها بالتالي الحساب القديم دا معتش ليه لزمة فا هنحذف كل السحبات و التسديدات بتاعته
					if(!$firstBankStatementForOldLcOverdraft){
						LcOverdraftWithdrawal::where('lc_facility_id',$oldLcOverdraftId)->delete();
						// وتلقائي هيحذف السحوبات settlements
					}else{
						DB::table($tableName)
						->where('full_date','>=',$minDate)
						->orderByRaw('full_date asc , priority asc , id asc')
						->where('lc_facility_id',$model->lc_facility_id)->update([
							'updated_at'=>now()
						]);
						
					}
					
				}
				
			});
			
			static::deleting(function(self $lcOverdraftBankStatement){
				$oldDate = null ;

				
				if($lcOverdraftBankStatement->is_debit && Request('receiving_date')||$lcOverdraftBankStatement->is_credit && Request('delivery_date')){
						$oldDate = Carbon::make(Request('receiving_date',Request('delivery_date')))->format('Y-m-d');
						$time  = now()->format('H:i:s');
						$oldDate = date('Y-m-d H:i:s', strtotime("$oldDate $time")) ;
						$currentDate = $lcOverdraftBankStatement->full_date ;
						$lcOverdraftBankStatement->full_date = min($oldDate,$currentDate);
				}
				DB::table('letter_of_credit_facilities')->where('id',$lcOverdraftBankStatement->lc_facility_id)->update([
					'oldest_full_date'=>$lcOverdraftBankStatement->full_date,
					// 'origin_update_row_is_debit'=>$lcOverdraftBankStatement->is_debit
				]);
				
				$lcOverdraftBankStatement->debit = 0;
				$lcOverdraftBankStatement->credit = 0;
				
				$lcOverdraftBankStatement->save();
				
			});
		}
		

	public function withdrawals()
	{
		return $this->hasMany(LcOverdraftWithdrawal::class,'lc_overdraft_bank_statement_id','id');
	}
	public function lcIssuance()
	{
		return $this->belongsTo(LetterOfCreditIssuance::class,'lc_issuance_id','id');
	}
	public function getId()
	{
		return $this->id ;
	}
	public function setDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		
		$this->attributes['date'] = $year.'-'.$month.'-'.$day;
	}

	
	public function lcSettlementInternalMoneyTransfer()
	{
		return $this->belongsTo(LcSettlementInternalMoneyTransfer::class,'lc_settlement_internal_money_transfer_id','id');
	}
	public function lcOverdraftCreditBankStatement()
	{
		return $this->hasOne(LcOverdraftBankStatement::class,'money_payment_id','lc_issuance_id');
	}

	public function getForeignKeyNamesThatUsedInFilter():array 
	{
		return [
			'lc_facility_id'
		];
	}	
	
	
}
