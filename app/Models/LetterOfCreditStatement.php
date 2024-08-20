<?php

namespace App\Models;

use App\Enums\LcTypes;
use App\Helpers\HDate;
use App\Traits\Models\HasDeleteButTriggerChangeOnLastElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LetterOfCreditStatement extends Model
{
	use HasDeleteButTriggerChangeOnLastElement;
    protected $guarded = [
        'id'
    ];

	public static function updateNextRows(LetterOfCreditStatement $model):string 
	{
		$minDate  = $model->full_date ;
	
		
		/**
		 * * ليه بنستخدم ال 
		 * * min date
		 * * علشان لو عدلنا العنصر الحالي وخلينا التاريخ بتاعه اكبر من التاريخ القديم وقتها العناصر اللي ما بين التاريخ مش هيتعدلوا
		 * * مع انهم كان مفروض يتعدلوا بس انت قولتله عدلي العناصر اللي التاريخ بتاعها اكبر من او يساوي التاريخ الجديد
		 * * ودا غلط مفروض التاريخ الاقل ما بين التاريخ الجديد و القديم للعنصر بحيث دايما يبدا يحدث من عنده
		 */

		 DB::table('letter_of_credit_statements')
		->where('full_date','>=',$minDate)
		->orderByRaw('full_date asc , id asc')
		->where('financial_institution_id',$model->financial_institution_id)
		->where('source',$model->source)
		->where('lc_facility_id',$model->lc_facility_id)
		->where('cd_or_td_id',$model->cd_or_td_id)
		->where('lc_type',$model->lc_type)
		->each(function($letterOfCreditStatement){
			DB::table('letter_of_credit_statements')->where('id',$letterOfCreditStatement->id)->update([
				'updated_at'=>now()
			]);
		});
		
		return $minDate;

	}
		protected static function booted(): void
		{
			static::creating(function(LetterOfCreditStatement $model){
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
			
			static::created(function(LetterOfCreditStatement $model){
				self::updateNextRows($model);
			});
			
			static::updated(function (LetterOfCreditStatement $model) {
				
				$minDate = self::updateNextRows($model);
				
				
				$lcFacilityIsChanged = $model->isDirty('lc_facility_id') ;
				$lcCdOrTdIdIsChanged = $model->isDirty('cd_or_td_id') ;
				$financialInstitutionIsChanged = $model->isDirty('financial_institution_id') ;
				$sourceIsChanged = $model->isDirty('source') ;
				$lcTypeIsChange = $model->isDirty('lc_type') ;
		
				/**
				 * * دي علشان لو غيرت ال
				 * * lc_facility_id
				 * * بمعني انه نقل السحبة مثلا من حساب الي حساب اخر .. يبقي هنحتاج نشغل الترجرز علشان الحساب القديم علشان يوزع تاني
				 */
				if($lcFacilityIsChanged ||$lcTypeIsChange || $financialInstitutionIsChanged || $sourceIsChanged || $lcCdOrTdIdIsChanged ){
					$oldLcFacilityId=$model->getRawOriginal('lc_facility_id');
					$oldSource=$model->getRawOriginal('source');
					$oldCdOrTdId=$model->getRawOriginal('cd_or_td_id');
					$financialInstitutionId=$model->getRawOriginal('financial_institution_id');
					$oldLcType=$model->getRawOriginal('lc_type');
					$oldStatementId =$model->getRawOriginal('id');
					// لو ما لقناش اول واحد فوقه هندور علي اول واحد بعدة					
					$firstBankStatementForOld = LetterOfCreditStatement::
					where('financial_institution_id',$financialInstitutionId)->
					where('lc_facility_id',$oldLcFacilityId)->
					where('cd_or_td_id',$oldCdOrTdId)->
					where('source',$oldSource)->
					
					where('lc_type',$oldLcType)
					->where('id','!=',$oldStatementId )->orderBy('id')->first()  ;
					// لو كانت القديمة دي قبل ما تتغير هي الاستيتم الوحيده بعد كدا انت غيرتها بالتالي الحساب القديم دا معتش ليه لزمة فا هنحذف كل السحبات و التسديدات بتاعته
					if(!$firstBankStatementForOld){
						// وتلقائي هيحذف السحوبات settlements
					}else{
						DB::table('letter_of_credit_statements')
						->where('full_date','>=',$minDate)
						->orderByRaw('full_date asc , id asc')
						->where('lc_facility_id',$model->lc_facility_id)
						->where('cd_or_td_id',$model->cd_or_td_id)
						->where('lc_type',$model->lc_type)
						->where('financial_institution_id',$model->financial_institution_id)
						->where('source',$model->source)
						
						->update([
							'updated_at'=>now()
						]);
						
					}
					
				}
				
			});
			
			static::deleting(function(LetterOfCreditStatement $letterOfCreditStatement){
				$oldDate = null ;
				if($letterOfCreditStatement->is_debit && Request('payment_date')||$letterOfCreditStatement->is_credit && Request('issuance_date')){
						$oldDate = Carbon::make(Request('payment_date',Request('issuance_date')))->format('Y-m-d');
						$time  = now()->format('H:i:s');
						$oldDate = date('Y-m-d H:i:s', strtotime("$oldDate $time")) ;
						$currentDate = $letterOfCreditStatement->full_date ;
						$letterOfCreditStatement->full_date = min($oldDate,$currentDate);
				}
				$letterOfCreditStatement->debit = 0;
				$letterOfCreditStatement->credit = 0;
				$letterOfCreditStatement->save();
				
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
	public function getLetterOfCreditIssuance()
	{
		return $this->belongsTo(LetterOfCreditIssuance::class,'letter_of_credit_issuance_id','id');
	} 
	public function getLetterOfCreditFacility()
	{
		return $this->belongsTo(LetterOfCreditIssuance::class,'lc_facility_id','id');
	} 

	// public function cashInSafes()
	// {
	// 	return $this->belongsTo(OpeningBalance::class,'opening_balance_id','id') ;
	// }
	// public function getExchangeRate()
	// {
	// 	return $this->exchange_rate ?:1 ;
	// }
	
	
	public static function getTotalOutstandingBalanceForAllTypes(int $companyId , int $financialInstitutionId,string $currencyName):float 
	{
		$totalLastOutstandingBalanceOfFourTypes = 0 ;
		foreach(LcTypes::getAll() as $lcTypeId => $lcTypeNameFormatted){	
			foreach(LetterOfCreditIssuance::lcSources() as $currentSourceId => $currentSourceTitle){
				if($currentSourceId != LetterOfCreditIssuance::LC_FACILITY ){
					continue ;
				}
				$letterOfCreditStatement = DB::table((new self)->getTable())
					->where('company_id',$companyId)
					->where('financial_institution_id',$financialInstitutionId)
					->where('currency',$currencyName)
					->where('lc_type',$lcTypeId)
					->where('source',$currentSourceId)
					->orderByRaw('full_date desc')
					->first();
					$letterOfCreditStatementEndBalance = $letterOfCreditStatement ? $letterOfCreditStatement->end_balance : 0 ;
					$totalLastOutstandingBalanceOfFourTypes += $letterOfCreditStatementEndBalance;
			}
			
		}
		return abs($totalLastOutstandingBalanceOfFourTypes) ; 
	}
	public static function getDashboardDataForFinancialInstitution(int $companyId , int $financialInstitutionId,string $currencyName,string $lcType)
	{
			$letterOfCreditStatement = DB::table((new self)->getTable())
			->where('company_id',$companyId)
			->where('financial_institution_id',$financialInstitutionId)
			->where('currency',$currencyName)
			->where('lc_type',$lcType)
			->orderByRaw('full_date desc')
			->first();
			$letterOfCreditStatementEndBalance = $letterOfCreditStatement ? $letterOfCreditStatement->end_balance : 0 ;
			return abs($letterOfCreditStatementEndBalance);
	} 
	public static function getDashboardOutstandingPerTypeFormattedData(array &$charts , Company $company  , string $currencyName , string $date , string $lcTypeId , ?string $source , $selectedFinancialInstitutionBankIds ):void
	{
		$lcTitle = LcTypes::getAll()[$lcTypeId] ;
		$sources = $source ? [$source => $source] : LetterOfCreditIssuance::lcSources();
		
		$totalEndBalance = 0 ;
		foreach($sources as $source => $sourceTitle){
			foreach($selectedFinancialInstitutionBankIds as $currentFinancialInstitutionId){
				$rowPerType  = DB::table((new self)->getTable())
						->where('company_id',$company->id )
						->where('financial_institution_id',$currentFinancialInstitutionId)
						->where('currency',$currencyName)
						->where('date','<=',$date)
						->where('lc_type',$lcTypeId)
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
		}
		
				$charts['outstanding_per_lc_type'][$currencyName][] = ['type'=>$lcTitle , 'outstanding'=>$totalEndBalance] ;
	}
	public static function getDashboardOutstandingPerFinancialInstitutionFormattedData(array &$charts , Company $company  , string $currencyName , string $date , int $financialInstitutionId , string $financialInstitutionName , ?string $source , $lcTypes):void
	{
		$sources = $source ? [$source => $source] : LetterOfCreditIssuance::lcSources();
		$totalEndBalance = 0 ;
		foreach($sources as $currentSourceId => $sourceTitle){
		foreach($lcTypes as $currentLcTypeId => $currentLcTypeTitle){
		$rowPerType  = DB::table((new self)->getTable())
		->where('company_id',$company->id )
		->where('financial_institution_id',$financialInstitutionId)
		->where('currency',$currencyName)
		->where('date','<=',$date)
		->where('source',$currentSourceId)
		->where('lc_type',$currentLcTypeId)
		->orderByRaw('full_date desc')
		->first();
		
		if(!$rowPerType){
			continue;
		}
		$totalEndBalance += abs($rowPerType->end_balance) ;
		}
		}
		$charts['lc_outstanding_per_financial_institution'][$currencyName][] = ['type'=>$financialInstitutionName , 'outstanding'=>$totalEndBalance] ;
	}
	public static function getDashboardOutstandingTableFormattedData(array &$tablesData , Company $company  , string $currencyName , string $date , int $financialInstitutionId,string $lcTypeId , string $financialInstitutionName ,  $lastLetterOfCreditFacility , ?string $source ):void
	{
		$allSources = $source ? [$source => $source] : LetterOfCreditIssuance::lcSources() ; ;
		foreach($allSources as $currentSourceId => $currentSourceTitle){
			$rowPerType  = DB::table((new self)->getTable())
				->where('company_id',$company->id )
				->where('financial_institution_id',$financialInstitutionId)
				->where('currency',$currencyName)
				->where('date','<=',$date)
				->where('source',$currentSourceId)
				->where('lc_type',$lcTypeId)
				->orderByRaw('full_date desc')
				->first();
				if(!$rowPerType){continue ;}
				$currentOutstandingBalance = abs($rowPerType->end_balance) ;
				$currentLimit = $lastLetterOfCreditFacility ? $lastLetterOfCreditFacility->limit : 0 ;
				$tablesData['lc_outstanding_for_table'][$currencyName][] = ['financial_institution_name'=>$financialInstitutionName , 'outstanding'=>$currentOutstandingBalance , 'source'=>LetterOfCreditIssuance::lcSources()[$rowPerType->source] , 'type'=>LcTypes::getAll()[$rowPerType->lc_type] , 'limit'=>$currentLimit , 'cash_cover'=>LetterOfCreditStatement::getTotalCashCoverForAllTypes($company->id,$financialInstitutionId,$currencyName,$lcTypeId,$currentSourceId)] ;
			
		}
		}
	public static function getTotalCashCoverForAllTypes(int $companyId , int $financialInstitutionId,string $currency , ?string $type = null , ?string $source = null):float 
	{
		$totalLastCashCoverOfFourTypes = 0 ;
		foreach(LcTypes::getAll() as $lcTypeId => $lcTypeNameFormatted){
			$letterOfCreditCashCover = DB::table('letter_of_credit_cash_cover_statements')
			->where('company_id',$companyId)
			->where('currency',$currency)
			->where('financial_institution_id',$financialInstitutionId)
			->where('lc_type',$lcTypeId)
			->when($type , function(Builder $builder) use ($type){
				$builder->where('lc_type',$type);
			})
			->when($source , function(Builder $builder) use ($source){
				$builder->where('source',$source);
			})
			->orderByRaw('full_date desc')
			->first();
			$letterOfCreditCashCoverEndBalance = $letterOfCreditCashCover ? $letterOfCreditCashCover->end_balance : 0 ;
			$totalLastCashCoverOfFourTypes += $letterOfCreditCashCoverEndBalance;
		}
		return abs($totalLastCashCoverOfFourTypes) ; 
	}
	
}
