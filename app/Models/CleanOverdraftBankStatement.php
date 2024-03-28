<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CleanOverdraftBankStatement extends Model
{
	
	protected $guarded =[
		'id'
	];
	const MONEY_TRANSFER  = 'money-transfer';

		protected static function booted(): void
		{
			# دي علشان نشغل التريجرز 
			// mysql
			// علشان تروح تحدث كل الروز اللي تحتها
			static::updated(function (CleanOverdraftBankStatement $model) {
				
				if($model->cleanOverDraft){
					$model->cleanOverDraft->update([
						'start_settlement_from_bank_statement_id'=>$model->id
					]);
				}
					
				DB::table('clean_overdraft_bank_statements')->where('id','>=',$model->id)->orderBy('id')->where('clean_overdraft_id',$model->clean_overdraft_id)->update([
					'updated_at'=>now()
				]);
				
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
						CleanOverdraft::find($oldCleanOverdraftId)->update([
							'start_settlement_from_bank_statement_id'=>$id = CleanOverdraftBankStatement::where('clean_overdraft_id',$oldCleanOverdraftId)->where('id','!=',$oldBankStatementId)->first()->id
						]);

						DB::table('clean_overdraft_bank_statements')->where('id','>=',$id)->orderBy('id')->where('clean_overdraft_id',$oldCleanOverdraftId)->update([
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
	
	
	
	
}
