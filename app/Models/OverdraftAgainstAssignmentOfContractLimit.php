<?php

namespace App\Models;

use App\Helpers\HDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class OverdraftAgainstAssignmentOfContractLimit extends Model
{
	protected $table ='overdraft_against_assignment_of_contract_limits';
	
	protected $guarded =[
		'id'
	];
	public $oldFullDate = null;
	
	// public function cheque():BelongsTo
	// {
	// 	return $this->belongsTo(Cheque::class , 'cheque_id','id');
	// }
	public static function updateNextRows(self $model):string {
		$minDate  =min($model->full_date,$model->getRawOriginal('full_date')) ?: $model->full_date ;
		;
		DB::table('overdraft_against_assignment_of_contracts')->where('id',$model->overdraft_against_assignment_of_contract_id)->update([
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
		->orderByRaw('full_date asc  , id asc')
		->where('overdraft_against_assignment_of_contract_id',$model->overdraft_against_assignment_of_contract_id)
		->each(function($odAgainstAssignmentOfContractLimit) use($tableName){
			DB::table($tableName)->where('id',$odAgainstAssignmentOfContractLimit->id)->update([
				'updated_at'=>now(),
			]);
		});
		return $minDate;
	}
		public function getLimitFullDate()
		{
			return $this->contract->getStartDate();
		}
		// public function getChequeActualCollectionOrDepositDate()
		// {
		// 	if($this->cheque->isCollected()){
		// 		return $this->cheque->chequeActualCollectionDate();
		// 	}
		// 	elseif($this->cheque->isRejected()){
		// 		return $this->cheque->getDueDate();
		// 	}
		// 	return $this->cheque->getDepositDate();
		// }
		public function updateFullDate()
		{
				$this->created_at = now();
				$date = $this->getLimitFullDate()  ;
				$time  = now()->format('H:i:s');
				$fullDateTime = date('Y-m-d H:i:s', strtotime("$date $time")) ;
				/**
				 * * دي علشان لو ليهم نفس التاريخ والوقت بالظبط يزود ثانيه علي التاريخ القديم
				 */
				$fullDateTime = HDate::generateUniqueDateTimeForModel(self::class,'full_date',$fullDateTime,[
					[
						'overdraft_against_assignment_of_contract_id','=',$this->overdraft_against_assignment_of_contract_id ,
					]
				]) ;
				$this->full_date = $fullDateTime;
				return $this->full_date ;
		}
		protected static function booted(): void
		{
			static::creating(function(self $model){
				$model->updateFullDate();
			});
			
			static::created(function(self $model){
				self::updateNextRows($model);
			});
			
			static::updated(function (self $model) {
				$tableName = (new self)->getTable();
				
				$minDate = self::updateNextRows($model);
				
				
				$isChanged = $model->isDirty('overdraft_against_assignment_of_contract_id') ;
				/**
				 * * دي علشان لو غيرت ال
				 * * overdraft_against_assignment_of_contract_id
				 * * بمعني انه نقل السحبة مثلا من حساب الي حساب اخر .. يبقي هنحتاج نشغل الترجرز علشان الحساب القديم علشان يوزع تاني
				 */
				// logger('is changged'. $isChanged);
				if($isChanged){
					$oldOverdraftAgainstAssignmentOfContractId=$model->getRawOriginal('overdraft_against_assignment_of_contract_id');
					// $oldBankStatementId=$model->getRawOriginal('id');
					// لو ما لقناش اول واحد فوقه هندور علي اول واحد بعدة					
					// $firstBankStatementForOldOverdraftAgainstAssignmentOfContract = self::where('overdraft_against_assignment_of_contract_id',$oldOverdraftAgainstAssignmentOfContractId)->where('id','!=',$oldBankStatementId)->orderBy('id')->first()  ;
					// لو كانت القديمة دي قبل ما تتغير هي الاستيتم الوحيده بعد كدا انت غيرتها بالتالي الحساب القديم دا معتش ليه لزمة فا هنحذف كل السحبات و التسديدات بتاعته
				
						DB::table($tableName)
						->where('full_date','>=',$minDate)
						->orderByRaw('full_date asc , id asc')
						->where('overdraft_against_assignment_of_contract_id',$oldOverdraftAgainstAssignmentOfContractId)->update([
							'updated_at'=>now()
						]);
						
					
					
				}
				
			});
			
			static::deleting(function(self $odAgainstAssignmentOfContractLimit){
				$oldDate = null ;

				if($odAgainstAssignmentOfContractLimit->cheque_id
				// && Request('receiving_date')||$odAgainstAssignmentOfContractLimit->is_credit && Request('delivery_date')
				){
						$oldDate =$odAgainstAssignmentOfContractLimit->getLimitFullDate();
			
						$time  = now()->format('H:i:s');
						$oldDate = date('Y-m-d H:i:s', strtotime("$oldDate $time")) ;
						$currentDate = $odAgainstAssignmentOfContractLimit->full_date ;
						$odAgainstAssignmentOfContractLimit->full_date = min($oldDate,$currentDate);
				}
				DB::table('overdraft_against_assignments')->where('id',$odAgainstAssignmentOfContractLimit->overdraft_against_assignment_of_contract_id)->update([
					'oldest_full_date'=>$odAgainstAssignmentOfContractLimit->full_date
				]);
	
				// $odAgainstAssignmentOfContractLimit->limit = -1;
				// $odAgainstAssignmentOfContractLimit->accumulated_limit = 0;
				$odAgainstAssignmentOfContractLimit->save();
				
			});
		}
		
	public function contract()
	{
		return $this->belongsTo(Contract::class,'contract_id','id');
	}
	public function overdraftAgainstAssignmentOfContract()
	{
		return $this->belongsTo(OverdraftAgainstAssignmentOfContract::class,'overdraft_against_assignment_of_contract_id','id');
	}
	public function getId()
	{
		return $this->id ;
	}
	
	
}
