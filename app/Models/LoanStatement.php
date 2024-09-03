<?php

namespace App\Models;

use App\Helpers\HDate;
use App\Interfaces\Models\Interfaces\IHaveStatement;
use App\Traits\Models\HasDeleteButTriggerChangeOnLastElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class LoanStatement extends Model  implements IHaveStatement
{
	use HasDeleteButTriggerChangeOnLastElement;
    protected $guarded = [
        'id'
    ];
	
	/**
	 * * ال 
	 * * global scope 
	 * * دا خاص بس بجزئيه ال
	 * * commission 
	 * * ما عدا ذالك ملهوش اي لزمة هو والكولوم اللي اسمة
	 * * is_active
	 */
	protected static function boot()
    {
        parent::boot();
        // static::addGlobalScope('only_active',function(Builder $builder){
		// 	$builder->where('is_active',1); 
		// });

    }
	

	public static function updateNextRows(self $model):string 
	{
		$minDate  = $model->full_date ;
	
		
		/**
		 * * ليه بنستخدم ال 
		 * * min date
		 * * علشان لو عدلنا العنصر الحالي وخلينا التاريخ بتاعه اكبر من التاريخ القديم وقتها العناصر اللي ما بين التاريخ مش هيتعدلوا
		 * * مع انهم كان مفروض يتعدلوا بس انت قولتله عدلي العناصر اللي التاريخ بتاعها اكبر من او يساوي التاريخ الجديد
		 * * ودا غلط مفروض التاريخ الاقل ما بين التاريخ الجديد و القديم للعنصر بحيث دايما يبدا يحدث من عنده
		 */

		 DB::table('loan_statements')
		->where('full_date','>=',$minDate)
		->orderByRaw('full_date asc , id asc')
		->where('financial_institution_account_id',$model->financial_institution_account_id)
		->each(function($loanStatement){
			DB::table('loan_statements')->where('id',$loanStatement->id)->update([
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
						'company_id','=',$model->company_id ,
					]
				]) ;
				$model->full_date = $fullDateTime;
			});
			
			static::created(function(self $model){
				self::updateNextRows($model);
			});
			
			static::updated(function (self $model) {
				
				$minDate = self::updateNextRows($model);
				
				
				$isChanged = $model->isDirty('financial_institution_account_id') ;
				/**
				 * * دي علشان لو غيرت ال
				 * * financial_institution_account_id
				 * * بمعني انه نقل السحبة مثلا من حساب الي حساب اخر .. يبقي هنحتاج نشغل الترجرز علشان الحساب القديم علشان يوزع تاني
				 */
				if($isChanged){
					$oldAccountIdId=$model->getRawOriginal('financial_institution_account_id');
					$oldBankStatementId=$model->getRawOriginal('id');
					// لو ما لقناش اول واحد فوقه هندور علي اول واحد بعدة					
					$firstBankStatementForOld = self::where('financial_institution_account_id',$oldAccountIdId)->where('id','!=',$oldBankStatementId)->orderBy('id')->first()  ;
					// لو كانت القديمة دي قبل ما تتغير هي الاستيتم الوحيده بعد كدا انت غيرتها بالتالي الحساب القديم دا معتش ليه لزمة فا هنحذف كل السحبات و التسديدات بتاعته
					if(!$firstBankStatementForOld){
						// وتلقائي هيحذف السحوبات settlements
					}else{
						DB::table('loan_statements')
						->where('full_date','>=',$minDate)
						->orderByRaw('full_date asc , id asc')
						->where('financial_institution_account_id',$model->financial_institution_account_id)->update([
							'updated_at'=>now()
						]);
						
					}
					
				}
				
			});
			
			static::deleting(function(self $loanStatement){
				// $oldDate = null ;
				// if($loanStatement->is_debit && Request('receiving_date')||$loanStatement->is_credit && Request('delivery_date')){
				// 		$oldDate = Carbon::make(Request('receiving_date',Request('delivery_date')))->format('Y-m-d');
				// 		$time  = now()->format('H:i:s');
				// 		$oldDate = date('Y-m-d H:i:s', strtotime("$oldDate $time")) ;
				// 		$currentDate = $loanStatement->full_date ;
				// 		$loanStatement->full_date = min($oldDate,$currentDate);
				// }
			
				
				$loanStatement->debit = 0;
				$loanStatement->credit = 0;
				$loanStatement->save();
				
			});
		}
		

    // public function moneyReceived()
    // {
    //     return $this->belongsTo(MoneyReceived::class, 'money_received_id', 'id');
    // }
	// public function certificateOfDeposit()
    // {
    //     return $this->belongsTo(CertificatesOfDeposit::class, 'certificate_of_deposit_id', 'id');
    // }
	// public function timeOfDeposit()
    // {
    //     return $this->belongsTo(TimeOfDeposit::class, 'time_of_deposit_id', 'id');
    // }
	// public function letterOfGuaranteeIssuance()
    // {
    //     return $this->belongsTo(LetterOfGuaranteeIssuance::class, 'letter_of_guarantee_issuance_id', 'id');
    // }
	// public function moneyPayment()
    // {
    //     return $this->belongsTo(MoneyPayment::class, 'money_payment_id', 'id');
    // }
	// public function cashExpense()
    // {
    //     return $this->belongsTo(CashExpense::class, 'cash_expense_id', 'id');
    // }
    public function getId()
    {
        return $this->id ;
    }
	
	public function getEndBalance()
	{
		return $this->end_balance ?: 0 ;
	}
	public function getEndBalanceFormatted()
	{
		return number_format($this->getEndBalance()) ;
	}

    public function setDateAttribute($value)
    {
        $date = explode('/', $value);
        if (count($date) != 3) {
            $this->attributes['date'] = $value ;

            return ;
        }
        $month = $date[0];
        $day = $date[1];
        $year = $date[2];

        $this->attributes['date'] = $year . '-' . $month . '-' . $day;
    }
	public function financialInstitutionAccount()
	{
		return $this->belongsTo(self::class,'financial_institution_account_id','id');
	}
	public function loanScheduleSettlement():BelongsTo
	{
		return $this->belongsTo(LoanScheduleSettlement::class,'loan_schedule_settlement_id','id');
	}	
	// public function internalMoneyTransfer()
	// {
	// 	return $this->belongsTo(InternalMoneyTransfer::class,'internal_money_transfer_id','id');
	// }
	// public function letterOfGuaranteeAdvancedPaymentHistory():BelongsTo
	// {
	// 	return $this->belongsTo(LetterOfGuaranteeIssuanceAdvancedPaymentHistory::class,'lg_advanced_payment_history_id','id');
	// }	
	// public function lcIssuanceExpense():BelongsTo
	// {
	// 	return $this->belongsTo(LcIssuanceExpense::class,'lc_issuance_expense_id','id');
	// }	
	// public static function updateNonActiveDaily(Company $company)
	// {
	// 	// logger('first row here loooo');
	// 	DB::table('loan_statements')
	// 	->where('company_id',$company->id)
	// 	->where('is_active',0)
	// 	->where('full_date','<=',now())
	// 	->orderByRaw('full_date asc , id asc')
	// 	->each(function($loanStatementRow){
	// 		$letterOfGuaranteeIssuanceId = $loanStatementRow->letter_of_guarantee_issuance_id;
			
	// 		$letterOfGuaranteeIssuance = DB::table('letter_of_guarantee_issuances')
	// 		->where('id',$letterOfGuaranteeIssuanceId)
	// 		->first();
			
	// 		$commissionRate = $letterOfGuaranteeIssuance->lg_commission_rate; 
			
	// 		$totalPaid = DB::table('lg_issuance_advanced_payment_histories')
	// 		->where('letter_of_guarantee_issuance_id',$letterOfGuaranteeIssuanceId)
	// 		->where('date' ,'<=' , $loanStatementRow->full_date)
	// 		->sum('amount');
			
	// 		DB::table('loan_statements')->where('id',$loanStatementRow->id)
	// 		->update([
	// 			'is_active'=>1 ,
	// 			'credit'=> ($letterOfGuaranteeIssuance->lg_amount - $totalPaid) * $commissionRate
	// 		]);
	// 		/**
	// 	 * * هنبدا نعمل ابديت من اول الرو اللي تاريخه اصغر حاجه في اللي كانوا محتاجين يتعدلوا
	// 	 * * وبالتالي هيتعدل هو وكل اللي تحتة
	// 	 */
	// 		self::updateNextRows(self::find($loanStatementRow->id));
			
	// 	});
	// }
}
