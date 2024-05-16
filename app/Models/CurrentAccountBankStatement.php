<?php

namespace App\Models;

use App\Helpers\HDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CurrentAccountBankStatement extends Model
{
    protected $guarded = [
        'id'
    ];

	public static function updateNextRows(CurrentAccountBankStatement $model):string 
	{
		$minDate  = $model->full_date ;
	
		
		/**
		 * * ليه بنستخدم ال 
		 * * min date
		 * * علشان لو عدلنا العنصر الحالي وخلينا التاريخ بتاعه اكبر من التاريخ القديم وقتها العناصر اللي ما بين التاريخ مش هيتعدلوا
		 * * مع انهم كان مفروض يتعدلوا بس انت قولتله عدلي العناصر اللي التاريخ بتاعها اكبر من او يساوي التاريخ الجديد
		 * * ودا غلط مفروض التاريخ الاقل ما بين التاريخ الجديد و القديم للعنصر بحيث دايما يبدا يحدث من عنده
		 */

		 DB::table('current_account_bank_statements')
		->where('full_date','>=',$minDate)
		->orderByRaw('full_date asc , id asc')
		->where('financial_institution_account_id',$model->financial_institution_account_id)
		->each(function($cleanOverdraftBankStatement){
			DB::table('current_account_bank_statements')->where('id',$cleanOverdraftBankStatement->id)->update([
				'updated_at'=>now()
			]);
		});
		
		return $minDate;

	}
	/**
	 * * هنا لما نعوز نحذف اكثر من واحدة .. فا مش هنشغل التريجر غير مع اللي اقل تاريخ فيهم
	 */
	public static function deleteButTriggerChangeOnLastElement(Collection $currentAccountBankStatements):void
	{
		$length = count($currentAccountBankStatements);
		$currentAccountBankStatements->each(function(CurrentAccountBankStatement $currentAccountBankStatement,$index) use ($length){
			/**
			 * * لو هو اخر عنصر اللي هو تاريخ الاصغر ما بينهم .. في الحاله دي هنحذفه بالطريقة اللي بتشغل ال
			 * * observers
			 * * علشان لو عندك خمسين عنصر مثلا هيتحذفوا ما يروحش يترجر مع كل واحد
			 * * انما لما هيترجر مع الاصفر تاريخ منهم فا في الحاله دي هيعمل مرة واحدة بس ترجر ياحدث من اول التاريخ الصغير دا وانت نازل .. و وانت نازل دي
			 * * معناه انه هيحدث العناصر اللي المفروض يحدثها كلها
			 * * وخلي بالك انك مرتب 
			 * * currentAccountBankStatements 
			 * * من الكبير للصغير من حيث ال 
			 * * full_date 
			 * * فا الاخير هيكون هو الاصغر اللي هنبدا نشكل ال
			 * * observer 
			 * * من عندة
			 */
			if($index == $length-1){
				$currentAccountBankStatement->delete();
			}else{
				DB::table('current_account_bank_statements')->where('id',$currentAccountBankStatement->id)->delete();
			}
		});
		
	}
		protected static function booted(): void
		{
			static::creating(function(CurrentAccountBankStatement $model){
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
			
			static::created(function(CurrentAccountBankStatement $model){
				self::updateNextRows($model);
			});
			
			static::updated(function (CurrentAccountBankStatement $model) {
				
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
					$firstBankStatementForOldCleanOverdraft = CurrentAccountBankStatement::where('financial_institution_account_id',$oldAccountIdId)->where('id','!=',$oldBankStatementId)->orderBy('id')->first()  ;
					// لو كانت القديمة دي قبل ما تتغير هي الاستيتم الوحيده بعد كدا انت غيرتها بالتالي الحساب القديم دا معتش ليه لزمة فا هنحذف كل السحبات و التسديدات بتاعته
					if(!$firstBankStatementForOldCleanOverdraft){
						// CleanOverdraftWithdrawal::where('financial_institution_account_id',$oldCleanOverdraftId)->delete();
						// وتلقائي هيحذف السحوبات settlements
					}else{
						DB::table('current_account_bank_statements')
						->where('full_date','>=',$minDate)
						->orderByRaw('full_date asc , id asc')
						->where('financial_institution_account_id',$model->financial_institution_account_id)->update([
							'updated_at'=>now()
						]);
						
					}
					
				}
				
			});
			
			static::deleting(function(CurrentAccountBankStatement $cleanOverdraftBankStatement){
				$oldDate = null ;
				if($cleanOverdraftBankStatement->is_debit && Request('receiving_date')||$cleanOverdraftBankStatement->is_credit && Request('delivery_date')){
						$oldDate = Carbon::make(Request('receiving_date',Request('delivery_date')))->format('Y-m-d');
						$time  = now()->format('H:i:s');
						$oldDate = date('Y-m-d H:i:s', strtotime("$oldDate $time")) ;
						$currentDate = $cleanOverdraftBankStatement->full_date ;
						$cleanOverdraftBankStatement->full_date = min($oldDate,$currentDate);
				}
			
				
				$cleanOverdraftBankStatement->debit = 0;
				$cleanOverdraftBankStatement->credit = 0;
				$cleanOverdraftBankStatement->save();
				
			});
		}
		

    public function moneyReceived()
    {
        return $this->belongsTo(MoneyReceived::class, 'money_received_id', 'id');
    }
	public function certificateOfDeposit()
    {
        return $this->belongsTo(CertificatesOfDeposit::class, 'certificate_of_deposit_id', 'id');
    }
	public function moneyPayment()
    {
        return $this->belongsTo(MoneyPayment::class, 'money_payment_id', 'id');
    }
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
		return $this->belongsTo(CurrentAccountBankStatement::class,'financial_institution_account_id','id');
	}
	
}
