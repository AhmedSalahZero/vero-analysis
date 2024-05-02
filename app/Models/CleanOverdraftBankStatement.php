<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CleanOverdraftBankStatement extends Model
{
	
	protected $guarded =[
		'id'
	];
	const MONEY_TRANSFER  = 'money-transfer';
	public static function updateNextRows(CleanOverdraftBankStatement $model)
	{
		// if($model->cleanOverDraft){
		// 	$model->cleanOverDraft->update([
		// 		'start_settlement_from_bank_statement_date'=> CleanOverdraftBankStatement::where('clean_overdraft_id',$model->clean_overdraft_id)->orderByRaw('full_date desc , priority asc')->first()->full_date ,
		// 	]);
		// }
			// logger(	DB::table('clean_overdraft_bank_statements')
			// // ->where('id','!=',$model->id)
			// // ->where('id','>=',$model->id)->orderBy('id')
			// # ->where('full_date', '>=', $model->full_date )
			// ->orderByRaw('full_date asc')
			// ->where('clean_overdraft_id',$model->clean_overdraft_id)->count());
			
		DB::table('clean_overdraft_bank_statements')
		->where('full_date','>=',$model->date)
		->orderByRaw('full_date asc')
		->where('clean_overdraft_id',$model->clean_overdraft_id)->update([
			'updated_at'=>now()
		]);
		// $model->cleanOverDraft->update([
		// 	'start_settlement_from_bank_statement_date'=>null
		// ]);
	}
		protected static function booted(): void
		{
			static::creating(function(CleanOverdraftBankStatement $model){
				$model->created_at = now();
				$date = $model->date ;
				$time  = now()->format('H:i:s');
				$model->full_date = date('Y-m-d H:i:s', strtotime("$date $time"));
			});
			
			static::created(function(CleanOverdraftBankStatement $model){
				self::updateNextRows($model);
			});
			// static::updating(function(CleanOverdraftBankStatement $model){
			// 	if($model->type = MoneyPayment::PAYABLE_CHEQUE ){
			// 		// $model->due_date = Carbon::make();
			// 	}
			// });
			# دي علشان نشغل التريجرز 
			// mysql
			// علشان تروح تحدث كل الروز اللي تحتها
			static::updated(function (CleanOverdraftBankStatement $model) {
				logger('from update');
				
				self::updateNextRows($model,$model->full_date);
				
				
				$isChanged = $model->isDirty('clean_overdraft_id') ;
				/**
				 * * دي علشان لو غيرت ال
				 * * clean_overdraft_id
				 * * بمعني انه نقل السحبة مثلا من حساب الي حساب اخر .. يبقي هنحتاج نشغل الترجرز علشان الحساب القديم علشان يوزع تاني
				 */
				if($isChanged){
					$oldCleanOverdraftId=$model->getRawOriginal('clean_overdraft_id');
					$oldBankStatementId=$model->getRawOriginal('id');
					// لو ما لقناش اول واحد فوقه هندور علي اول واحد بعدة					
					$firstBankStatementForOldCleanOverdraft = CleanOverdraftBankStatement::where('clean_overdraft_id',$oldCleanOverdraftId)->where('id','!=',$oldBankStatementId)->orderBy('id')->first()  ;
					// لو كانت القديمة دي قبل ما تتغير هي الاستيتم الوحيده بعد كدا انت غيرتها بالتالي الحساب القديم دا معتش ليه لزمة فا هنحذف كل السحبات و التسديدات بتاعته
					if(!$firstBankStatementForOldCleanOverdraft){
						CleanOverdraftWithdrawal::where('clean_overdraft_id',$oldCleanOverdraftId)->delete();
						// وتلقائي هيحذف السحوبات settlements
					}else{
						// CleanOverdraft::find($oldCleanOverdraftId)->update([
						// 	'start_settlement_from_bank_statement_date'=>$fullDate = CleanOverdraftBankStatement::where('clean_overdraft_id',$oldCleanOverdraftId)->where('id','!=',$oldBankStatementId)->orderByRaw('full_date desc , priority asc')->first()->full_date
						// ]);

						DB::table('clean_overdraft_bank_statements')
						->orderByRaw('full_date asc')
						->where('clean_overdraft_id',$model->clean_overdraft_id)->update([
							'updated_at'=>now()
						]);
						
					}
					
				}
				
			});
			
			static::deleting(function(CleanOverdraftBankStatement $cleanOverdraftBankStatement){
			
				$cleanOverdraftBankStatement->debit = 0;
				$cleanOverdraftBankStatement->credit = 0;
				$cleanOverdraftBankStatement->save();
				
			});
		}
		
	public function moneyReceived()
	{
		return $this->belongsTo(MoneyReceived::class,'money_received_id','id');
	}
	public function moneyPayment()
	{
		return $this->belongsTo(MoneyPayment::class,'money_payment_id','id');
	}
	public function withdrawals()
	{
		return $this->hasMany(CleanOverdraftWithdrawal::class,'clean_overdraft_bank_statement_id','id');
	}
	public function cleanOverDraft()
	{
		return $this->belongsTo(CleanOverdraft::class,'clean_overdraft_id','id');
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
	public function getStartSettlementFromBankStatementDateTime()
	{
		if($this->type == MoneyPayment::PAYABLE_CHEQUE  ){
			return $this->moneyPayment->payableCheque->actual_payment_date ;
		}
		if($this->type == MoneyPayment::OUTGOING_TRANSFER  ){
			return $this->moneyPayment->outgoingTransfer->actual_payment_date ;
		}
		return $this->full_date;
	}
	
	
	
}
