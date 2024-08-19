<?php

namespace App\Models;

use App\Enums\LgTypes;
use App\Helpers\HDate;
use App\Traits\Models\HasDeleteButTriggerChangeOnLastElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LetterOfGuaranteeStatement extends Model
{
	use HasDeleteButTriggerChangeOnLastElement;
    protected $guarded = [
        'id'
    ];

	public static function updateNextRows(LetterOfGuaranteeStatement $model):string 
	{
		$minDate  = $model->full_date ;
	
		
		/**
		 * * ليه بنستخدم ال 
		 * * min date
		 * * علشان لو عدلنا العنصر الحالي وخلينا التاريخ بتاعه اكبر من التاريخ القديم وقتها العناصر اللي ما بين التاريخ مش هيتعدلوا
		 * * مع انهم كان مفروض يتعدلوا بس انت قولتله عدلي العناصر اللي التاريخ بتاعها اكبر من او يساوي التاريخ الجديد
		 * * ودا غلط مفروض التاريخ الاقل ما بين التاريخ الجديد و القديم للعنصر بحيث دايما يبدا يحدث من عنده
		 */

		 DB::table('letter_of_guarantee_statements')
		->where('full_date','>=',$minDate)
		->orderByRaw('full_date asc , id asc')
		->where('financial_institution_id',$model->financial_institution_id)
		->where('source',$model->source)
		->where('lg_facility_id',$model->lg_facility_id)
		->where('cd_or_td_id',$model->cd_or_td_id)
		->where('lg_type',$model->lg_type)
		->each(function($letterOfGuaranteeStatement){
			DB::table('letter_of_guarantee_statements')->where('id',$letterOfGuaranteeStatement->id)->update([
				'updated_at'=>now()
			]);
		});
		
		return $minDate;

	}
		protected static function booted(): void
		{
			static::creating(function(LetterOfGuaranteeStatement $model){
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
			
			static::created(function(LetterOfGuaranteeStatement $model){
				self::updateNextRows($model);
			});
			
			static::updated(function (LetterOfGuaranteeStatement $model) {
				
				$minDate = self::updateNextRows($model);
				
				
				$lgFacilityIsChanged = $model->isDirty('lg_facility_id') ;
				$lgCdOrTdIdIsChanged = $model->isDirty('cd_or_td_id') ;
				$financialInstitutionIsChanged = $model->isDirty('financial_institution_id') ;
				$sourceIsChanged = $model->isDirty('source') ;
				$lgTypeIsChange = $model->isDirty('lg_type') ;
		// 		->where('financial_institution_id',$model->financial_institution_id)
		// ->where('source',$model->source)
		
				/**
				 * * دي علشان لو غيرت ال
				 * * lg_facility_id
				 * * بمعني انه نقل السحبة مثلا من حساب الي حساب اخر .. يبقي هنحتاج نشغل الترجرز علشان الحساب القديم علشان يوزع تاني
				 */
				if($lgFacilityIsChanged ||$lgTypeIsChange || $financialInstitutionIsChanged || $sourceIsChanged || $lgCdOrTdIdIsChanged ){
					$oldLgFacilityId=$model->getRawOriginal('lg_facility_id');
					$oldSource=$model->getRawOriginal('source');
					$oldCdOrTdId=$model->getRawOriginal('cd_or_td_id');
					$financialInstitutionId=$model->getRawOriginal('financial_institution_id');
					$oldLgType=$model->getRawOriginal('lg_type');
					$oldStatementId =$model->getRawOriginal('id');
					// لو ما لقناش اول واحد فوقه هندور علي اول واحد بعدة					
					$firstBankStatementForOld = LetterOfGuaranteeStatement::
					where('financial_institution_id',$financialInstitutionId)->
					where('lg_facility_id',$oldLgFacilityId)->
					where('cd_or_td_id',$oldCdOrTdId)->
					where('source',$oldSource)->
					
					where('lg_type',$oldLgType)
					->where('id','!=',$oldStatementId )->orderBy('id')->first()  ;
					// لو كانت القديمة دي قبل ما تتغير هي الاستيتم الوحيده بعد كدا انت غيرتها بالتالي الحساب القديم دا معتش ليه لزمة فا هنحذف كل السحبات و التسديدات بتاعته
					if(!$firstBankStatementForOld){
						// وتلقائي هيحذف السحوبات settlements
					}else{
						DB::table('letter_of_guarantee_statements')
						->where('full_date','>=',$minDate)
						->orderByRaw('full_date asc , id asc')
						->where('lg_facility_id',$model->lg_facility_id)
						->where('cd_or_td_id',$model->cd_or_td_id)
						->where('lg_type',$model->lg_type)
						->where('financial_institution_id',$model->financial_institution_id)
						->where('source',$model->source)
						
						->update([
							'updated_at'=>now()
						]);
						
					}
					
				}
				
			});
			
			static::deleting(function(LetterOfGuaranteeStatement $letterOfGuaranteeStatement){
				$oldDate = null ;
				if($letterOfGuaranteeStatement->is_debit && Request('cancellation_date')||$letterOfGuaranteeStatement->is_credit && Request('issuance_date')){
						$oldDate = Carbon::make(Request('cancellation_date',Request('issuance_date')))->format('Y-m-d');
						$time  = now()->format('H:i:s');
						$oldDate = date('Y-m-d H:i:s', strtotime("$oldDate $time")) ;
						$currentDate = $letterOfGuaranteeStatement->full_date ;
						$letterOfGuaranteeStatement->full_date = min($oldDate,$currentDate);
				}
				$letterOfGuaranteeStatement->debit = 0;
				$letterOfGuaranteeStatement->credit = 0;
				$letterOfGuaranteeStatement->save();
				
			});
		}

    public function moneyReceived()
    {
        return $this->belongsTo(MoneyReceived::class, 'money_received_id', 'id');
    }
	public function moneyPayment()
    {
        return $this->belongsTo(MoneyPayment::class, 'money_payment_id', 'id');
    }
	public function cashExpense()
    {
        return $this->belongsTo(CashExpense::class, 'cash_expense_id', 'id');
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
	public function getDebitAmount()
	{
		return $this->debit ?: 0 ;
	}
	public function getCurrency()
	{
		return $this->currency ; 
	}
	public function getLetterOfGuaranteeIssuance()
	{
		return $this->belongsTo(LetterOfGuaranteeIssuance::class,'letter_of_guarantee_issuance_id','id');
	} 
	public function getLetterOfGuaranteeFacility()
	{
		return $this->belongsTo(LetterOfGuaranteeIssuance::class,'lg_facility_id','id');
	} 
	public static function getTotalOutstandingBalanceForAllLgTypes(int $companyId , int $financialInstitutionId,string $currencyName):float 
	{
		$totalLastOutstandingBalanceOfFourTypes = 0 ;
		foreach(LgTypes::getAll() as $lgTypeId => $lgTypeNameFormatted){
			$letterOfGuaranteeStatement = DB::table('letter_of_guarantee_statements')
			->where('company_id',$companyId)
			->where('financial_institution_id',$financialInstitutionId)
			->where('currency',$currencyName)
			->where('lg_type',$lgTypeId)
			->orderByRaw('full_date desc')
			->first();
			$letterOfGuaranteeStatementEndBalance = $letterOfGuaranteeStatement ? $letterOfGuaranteeStatement->end_balance : 0 ;
			$totalLastOutstandingBalanceOfFourTypes += $letterOfGuaranteeStatementEndBalance;
		}
		return abs($totalLastOutstandingBalanceOfFourTypes) ; 
	}
	public static function getDashboardDataForFinancialInstitution(int $companyId , int $financialInstitutionId,string $currencyName,string $lgType)
	{
			$letterOfGuaranteeStatement = DB::table('letter_of_guarantee_statements')
			->where('company_id',$companyId)
			->where('financial_institution_id',$financialInstitutionId)
			->where('currency',$currencyName)
			->where('lg_type',$lgType)
			->orderByRaw('full_date desc')
			->first();
			$letterOfGuaranteeStatementEndBalance = $letterOfGuaranteeStatement ? $letterOfGuaranteeStatement->end_balance : 0 ;
			return abs($letterOfGuaranteeStatementEndBalance);
	} 
	public static function getDashboardOutstandingPerLgTypeFormattedData(array &$charts , Company $company  , string $currencyName , string $date , string $lgTypeId , ?string $source , $selectedFinancialInstitutionBankIds ):void
	{
		$lgTitle = LgTypes::getAll()[$lgTypeId] ;
		$totalEndBalance = 0 ;
		foreach($selectedFinancialInstitutionBankIds as $currentFinancialInstitutionId){
			$rowPerType  = DB::table('letter_of_guarantee_statements')
					->where('company_id',$company->id )
					->where('financial_institution_id',$currentFinancialInstitutionId)
					->where('currency',$currencyName)
					->where('date','<=',$date)
					->where('lg_type',$lgTypeId)
					->when($source , function(Builder $builder) use ($source){
						$builder->where('source',$source);
					})
					->orderByRaw('full_date desc')
					->first();
					if(!$rowPerType){
						continue;
					}
					$totalEndBalance += abs($rowPerType->end_balance) ;
				}
				$charts['outstanding_per_lg_type'][$currencyName][] = ['type'=>$lgTitle , 'outstanding'=>$totalEndBalance] ;
	}
	public static function getDashboardOutstandingPerFinancialInstitutionFormattedData(array &$charts , Company $company  , string $currencyName , string $date , int $financialInstitutionId , string $financialInstitutionName , ?string $source):void
	{
		$rowsPerType  = DB::table('letter_of_guarantee_statements')
		->where('company_id',$company->id )
		->where('financial_institution_id',$financialInstitutionId)
		->where('currency',$currencyName)
		->where('date','<=',$date)
		->when($source , function(Builder $builder) use ($source){
			$builder->where('source',$source);
		})
		// ->where('lg_type',$lgTypeId)
		->orderByRaw('full_date desc')
		->get();
		if(!count($rowsPerType)){return ;}
		$charts['outstanding_per_financial_institution'][$currencyName][] = ['type'=>$financialInstitutionName , 'outstanding'=>$rowsPerType->sum(function($raw){return abs($raw->end_balance);})] ;
	
		// $charts['outstanding_per_financial_institution'][$currencyName][] = ['type'=>$financialInstitutionName , 'outstanding'=>$rowPerType ? abs($rowPerType->end_balance) : 0] ;
	}
	public static function getDashboardOutstandingTableFormattedData(array &$tablesData , Company $company  , string $currencyName , string $date , int $financialInstitutionId,string $lgTypeId , string $financialInstitutionName ,  $lastLetterOfGuaranteeFacility , ?string $source ):void
	{
		$rowPerType  = DB::table('letter_of_guarantee_statements')
		->where('company_id',$company->id )
		->where('financial_institution_id',$financialInstitutionId)
		->where('currency',$currencyName)
		->where('date','<=',$date)
		->where('lg_type',$lgTypeId)
		->when($source , function(Builder $builder) use ($source){
			$builder->where('source',$source);
		})
		->orderByRaw('full_date desc')
		->first();
		if(!$rowPerType){return ;}
		$currentOutstandingBalance = abs($rowPerType->end_balance) ;
		
		$currentLimit = $lastLetterOfGuaranteeFacility ? $lastLetterOfGuaranteeFacility->limit : 0 ;
		$tablesData['outstanding_for_table'][$currencyName][] = ['financial_institution_name'=>$financialInstitutionName , 'outstanding'=>$currentOutstandingBalance , 'source'=>LetterOfGuaranteeIssuance::lgSources()[$rowPerType->source] , 'type'=>LgTypes::getAll()[$rowPerType->lg_type] , 'limit'=>$currentLimit , 'cash_cover'=>LetterOfGuaranteeStatement::getTotalCashCoverForAllLgTypes($company->id,$financialInstitutionId,$currencyName,$lgTypeId)] ;
	}
	public static function getTotalCashCoverForAllLgTypes(int $companyId , int $financialInstitutionId,string $currency , ?string $type = null):float 
	{
		$totalLastCashCoverOfFourTypes = 0 ;
		foreach(LgTypes::getAll() as $lgTypeId => $lgTypeNameFormatted){
			$letterOfGuaranteeCashCover = DB::table('letter_of_guarantee_cash_cover_statements')
			->where('company_id',$companyId)
			->where('currency',$currency)
			->where('financial_institution_id',$financialInstitutionId)
			->where('lg_type',$lgTypeId)
			->when($type , function(Builder $builder) use ($type){
				$builder->where('lg_type',$type);
			})
			->orderByRaw('full_date desc')
			->first();
			$letterOfGuaranteeCashCoverEndBalance = $letterOfGuaranteeCashCover ? $letterOfGuaranteeCashCover->end_balance : 0 ;
			$totalLastCashCoverOfFourTypes += $letterOfGuaranteeCashCoverEndBalance;
		}
		return abs($totalLastCashCoverOfFourTypes) ; 
	}
	
}
