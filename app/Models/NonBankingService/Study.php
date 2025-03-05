<?php
namespace App\Models\NonBankingService;

use App\Equations\ExpenseAsPercentageEquation;
use App\Helpers\HArr;
use App\Models\NonBankingService\Expense;
use App\Models\NonBankingService\GeneralAndReserveAssumption;
use App\Models\Traits\Scopes\BelongsToCompany;
use App\Models\Traits\Scopes\CompanyScope;
use App\ReadyFunctions\CalculateDurationService;
use App\ReadyFunctions\CalculateFixedLoanAtBeginningService;
use App\ReadyFunctions\CalculateFixedLoanAtEndService;
use App\ReadyFunctions\CalculateVariableLoanAtEndService;
use App\Traits\HasBasicStoreRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

	class  Study extends Model
	{
		use HasBasicStoreRequest;
		
		const STUDY = 'study' ;
		const BUSINESS_PLAN = 'business-plans';  // multiple years
		const ANNUALLY_STUDY = 'annually-study'; // one year
		const LEASING_CATEGORY = 'leasing-categories' ;
		const MiCROFINANCE_PRODUCTS = 'microfinance-products' ;
		const CONSUMERFINANCE_PRODUCTS = 'consumerfinance-products' ;
		const LEASING ='leasing';
		const IJARA ='ijara';
		const PORTFOLIO_MORTGAGE ='portfolio-mortgage';
		const MiCROFINANCE ='microfinance';
		const DIRECT_FACTORING ='direct-factoring';
		const REVERSE_FACTORING ='reverse-factoring';
		const FACTORING_CATEGORY_ID = 'factoring-category-id';
		use CompanyScope,BelongsToCompany;
		
		protected $connection= 'non_banking_service';
 	   protected $table = 'studies';

		protected $guarded = [
			'id'
		];
		
		protected $casts = [
			'operation_dates'=>'array',
			'study_dates'=>'array',
			'leasing_growth_rates'=>'array'
		];
		
		public static function boot()
		{
			parent::boot();
			static::deleted(function(self $study){
				$study->leasingRevenueStreamBreakdown->each(function(LeasingRevenueStreamBreakdown $leasingRevenueStreamBreakdown){
					$leasingRevenueStreamBreakdown->delete();
				});
			});
			static::updated(function(self $study){
				 if($study->isDirty('salary_taxes_rate') || $study->isDirty('social_insurance_rate')){
					$study->recalculateManpower();
				 } 
			});
		}
		public function getName()
		{
			return $this->study_name;
		}
		public function getMainFunctionalCurrency()
		{
			return $this->company->getMainFunctionalCurrency();
		}
		public function getPropertyStatus()
	{
		return $this->property_status;
	}
	public function getOperationStartMonth(): ?int
	{
		return $this->operation_start_month ?: 0;
	}
	public function financialYearStartMonth(): ?string
	{
		return $this->financial_year_start_month;
	}
	public function getCorporateTaxesRate()
	{
		return $this->corporate_taxes_rate ?: 0;
	}
	public function getSalaryTaxesRate()
	{
		return $this->salary_taxes_rate ?: 0 ;
	}
	public function getSocialInsuranceRate()
	{
		return $this->social_insurance_rate ?: 0 ;
	}
	public function getInvestmentReturnRate()
	{
		return $this->investment_return_rate ?: 0 ;
	}
	public function getPerpetualGrowthRate()
	{
		return $this->perpetual_growth_rate ?: 0 ;
	}
	public function getShareholderEquityMultiplier()
	{
		return $this->shareholder_equity_multiplier ?: 0 ;
	}
	
	// 	public function getOperationDates(): array
	// {
	// 	return $this->operation_dates ?: [];
	// }
	public function datesAndIndexesHelpers(array $studyDates){
		$firstLoop = true ;
		$baseYear = null ;
		$datesIndexWithYearIndex = [];
		$yearIndexWithYear = [];
		$dateIndexWithDate = [];
		$dateIndexWithMonthNumber = [];
		$dateWithMonthNumber = [];
		$dateWithDateIndex = [];
		
		foreach($studyDates as $dateIndex => $dateAsString){
			$year = explode('-',$dateAsString)[0];
			$montNumber = explode('-',$dateAsString)[1];
			if($firstLoop ){
				$baseYear = $year ;
				$firstLoop = false ; 
			}
			$yearIndex = $year - $baseYear ;
			$datesIndexWithYearIndex[$dateIndex] =$yearIndex ;
			$yearIndexWithYear[$yearIndex] = $year ;
			$dateIndexWithDate[$dateIndex] = $dateAsString ;
			$dateIndexWithMonthNumber[$dateIndex] = $montNumber ;
			$dateWithMonthNumber[$dateAsString] = $montNumber ;
			$dateWithDateIndex[$dateAsString] =$dateIndex ;
			
		}
	
		return [
			'datesIndexWithYearIndex'=>$datesIndexWithYearIndex,
			'yearIndexWithYear'=>$yearIndexWithYear,
			'dateIndexWithDate'=>$dateIndexWithDate,
			'dateIndexWithMonthNumber'=>$dateIndexWithMonthNumber,
			'dateWithMonthNumber'=>$dateWithMonthNumber,
			'dateWithDateIndex'=>$dateWithDateIndex,
		];
		return $datesIndexWithYearIndex ;
	}
	public function getStudyDates(): array
	{
		return  $this->study_dates ?: [];
	}
	
		public function getDatesAsStringAndIndex()
	{
		return array_flip($this->getStudyDates());
	}
	protected function editOperationDatesStartingIndex($operationDurationDates,$studyDurationDates){
		$firstIndexInOperationDates = $operationDurationDates[0] ?? null;
		if(!$firstIndexInOperationDates)
		{
			return [];
		}
		$newDates = [];
		$firstIndex = array_search($firstIndexInOperationDates , $studyDurationDates);
		$loop = 0 ;
		foreach($operationDurationDates as $oldIndex=>$value){
				if($loop == 0){
					$newDates[$firstIndex] = $value;
				}else{
					$newDates[]=$value ;
				}
				$loop++;
		}
		return $newDates ;
	}
	public function updateStudyAndOperationDates(array $datesAsStringAndIndex,array $datesIndexWithYearIndex,array $yearIndexWithYear,array $dateIndexWithDate,array $dateWithMonthNumber)
	{
		
		$operationDurationDates = $this->getOperationDurationPerMonth($datesAsStringAndIndex,$datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber,false);
		$studyDurationDates = $this->getStudyDurationPerMonth($datesAsStringAndIndex,$datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber,false);

		$operationDurationDates = $this->editOperationDatesStartingIndex($operationDurationDates,$studyDurationDates);
		$this->update([
			'study_dates'=>$studyDurationDates,
			'operation_dates'=>$operationDurationDates,
		]);
	}
	public function getDurationInYears(): ?int
	{
		return $this->duration_in_years;
	}
	
	public function getOperationStartDate(): ?string
	{
		$startDate=$this->operation_start_date;

		return $startDate;
	}

	public function getOperationStartDateAsIndex(array $datesAsStringAndIndex, ?string $operationStartDateFormatted): ?int
	{
		return  $operationStartDateFormatted ? $datesAsStringAndIndex[$operationStartDateFormatted] : null;
	}
	public function getStudyStartDate(): ?string
	{
		return $this->study_start_date;
	}

	public function getStudyStartDateFormattedForView(): string
	{
		$studyStartDate = $this->getStudyStartDate();

		return dateFormatting($studyStartDate, 'M\' Y');
	}
	public function getStudyEndDate(): ?string
	{
		return $this->study_end_date;
	}
	public function getStudyEndDateFormatted()
	{
	
	}
	public function getStudyEndDateFormattedForView(): string
	{
		$studyEndDate = $this->getStudyEndDate();
		return dateFormatting($studyEndDate, 'M\' Y');
	}
	public function removeDatesBeforeDate(array $items, string $limitDate)
	{
		$newItems = [];
		$limitDate = Carbon::make($limitDate);
		foreach ($items as $year=>$dateAndValues) {
			foreach ($dateAndValues as $date=>$value) {
				$currentDate = Carbon::make($date);
				if ($limitDate->lessThanOrEqualTo($currentDate)) {
					$newItems[$year][$date]=$value;
				}
			}
		}

		return $newItems;
	}
	public function getStudyDurationPerYear(array $datesAsStringAndIndex,array $datesIndexWithYearIndex,array $yearIndexWithYear,array $dateIndexWithDate,array $dateWithMonthNumber, $asIndexes = true, $maxYearIsStudyEndDate = true, $repeatIndexes = true)
	{
		
		$calculateDurationService = new CalculateDurationService();
		$studyStartDate  = $this->getStudyStartDate();
		$operationStartDate = $this->getOperationStartDate();
		if ($maxYearIsStudyEndDate) {
			$maxDate = $this->getStudyEndDate();
		} else {
			$maxDate = $this->getMaxDate($datesAsStringAndIndex,$datesIndexWithYearIndex ,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber);
		}

		$studyDurationInYears = $this->getDurationInYears();

		$limitationDate = $operationStartDate;
		$studyDurationPerYear = $calculateDurationService->calculateMonthsDurationPerYear($studyStartDate, $maxDate, $studyDurationInYears, $limitationDate,true);
		
		$studyDurationPerYear = $this->removeDatesBeforeDate($studyDurationPerYear, $studyStartDate);
		
		$dates = [];
		if ($asIndexes) {
			$dates =  $this->convertMonthAndYearsToIndexes($studyDurationPerYear, $datesAsStringAndIndex,$datesIndexWithYearIndex);
		} else {
			$dates =  $studyDurationPerYear;
		}
		if ($repeatIndexes) {
			return $this->addMoreIndexes($dates,$yearIndexWithYear, $dateIndexWithDate,$dateWithMonthNumber ,$asIndexes);
		} else {
			return $dates;
		}
		// return $this->removeZeroValuesFromTwoDimArr($dates);
	}
	protected function addMoreIndexes(array $yearAndDatesValues,array $yearIndexWithYear , array $dateIndexWithDate,array $dateWithMonthNumber ,bool $asIndexes):array
	{
		$maxYearsCount = MAX_YEARS_COUNT;
		$lastYear = array_key_last($yearAndDatesValues);
		$firstYear = array_key_first($yearAndDatesValues);
		$maxYear = $firstYear  + $maxYearsCount;
		$firstYearAfterLast = $lastYear+1;
		for ($firstYearAfterLast; $firstYearAfterLast < $maxYear; $firstYearAfterLast++) {
			$dates = $this->replaceIndexWithItsStringDate($yearAndDatesValues[$lastYear],$dateIndexWithDate);
			if ($asIndexes) {
				$yearAndDatesValues[$firstYearAfterLast] = $this->replaceYearWithAnotherYear($dates, $yearIndexWithYear[$firstYearAfterLast], $asIndexes,$dateIndexWithDate,$dateWithMonthNumber);
			} else {
				$yearAndDatesValues[$firstYearAfterLast] = $this->replaceYearWithAnotherYear($dates, $firstYearAfterLast, $asIndexes,$dateIndexWithDate,$dateWithMonthNumber);
			}
		}
		return $yearAndDatesValues;
	}
	protected function replaceYearWithAnotherYear(array $dateAndValues, $newYear, bool $asIndexes,array $dateIndexWithDate,array $dateWithMonthNumber)
	{
		$newDatesAndValues   = [];
		foreach ($dateAndValues as $date=>$value) {
			$dateAsIndex = null;
			if ($asIndexes) {
				$dateAsIndex = $date;
				$date = $dateIndexWithDate[$date];
			}
			$day = getDayFromDate($date);
			
			$monthNumber = $dateWithMonthNumber[$date] ?? getMonthFromDate($date);
			$fullDate =$newYear.'-' .$monthNumber . '-'  .$day  ;

			if ($asIndexes) {
				$newDatesAndValues[$dateAsIndex] = $value;
			} else {
				$newDatesAndValues[$fullDate] = $value;
			}
		}

		return $newDatesAndValues;
	}
	public function getStudyDurationPerMonth(array $datesAsStringAndIndex,array $datesIndexWithYearIndex,array $yearIndexWithYear,array $dateIndexWithDate,array $dateWithMonthNumber, $maxYearIsStudyEndDate = true, $repeatIndexes = true)
	{
		$studyDurationPerMonth = [];
		$studyDurationPerYear = $this->getStudyDurationPerYear($datesAsStringAndIndex,$datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber, false, $maxYearIsStudyEndDate,$repeatIndexes);
		foreach ($studyDurationPerYear as $year => $values) {
			foreach ($values as $date => $value) {
				$studyDurationPerMonth[$date] = $value;
			}
		}

		return array_keys($studyDurationPerMonth);
	}
	protected function getMaxDate(array $datesAsStringAndIndex,array $datesIndexWithYearIndex ,array $yearIndexWithYear ,array $dateIndexWithDate,array $dateWithMonthNumber)
	{
		$studyDurationPerMonth = $this->getStudyDurationPerMonth($datesAsStringAndIndex,$datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber);

		return $studyDurationPerMonth[array_key_last($studyDurationPerMonth)];
	}
	public function getOperationStartDateFormatted()
	{
		$operationStartDate = $this->getOperationStartDate();

		return  $operationStartDate ? Carbon::make($operationStartDate)->format('Y-m-d') : null;
	}
	public function getOperationStartDateFormattedForView()
	{
		$operationStartDate = $this->getOperationStartDate();

		return  $operationStartDate ? dateFormatting($operationStartDate, 'M\' Y') : null;
	}
	public function getOperationDurationPerYear(array $datesAsStringAndIndex,array $datesIndexWithYearIndex,array $yearIndexWithYear,array $dateIndexWithDate,array $dateWithMonthNumber  , $asIndexes = true, $maxYearIsStudyEndDate = true)
	{
		$calculateDurationService = new CalculateDurationService();
		$operationStartDate  = $this->getOperationStartDateFormatted();
		if ($maxYearIsStudyEndDate) {
			$maxDate = $this->getStudyEndDate();
		} else {
			$maxDate = $this->getMaxDate($datesAsStringAndIndex,$datesIndexWithYearIndex ,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber);
		}
		$studyDurationInYears = $this->getDurationInYears();
		$operationDurationPerYear = $calculateDurationService->calculateMonthsDurationPerYear($operationStartDate, $maxDate, $studyDurationInYears,true);

		$operationDurationPerYear = $this->removeZeroValuesFromTwoDimArr($operationDurationPerYear);
		if ($asIndexes) {
			return $this->convertMonthAndYearsToIndexes($operationDurationPerYear, $datesAsStringAndIndex,$datesIndexWithYearIndex);
		}

		return $operationDurationPerYear;
	}
	protected function convertMonthAndYearsToIndexes(array $yearsAndItsDates, array $datesAsStringAndIndex, array $datesIndexWithYearIndex)
	{
		$result = [];
		foreach ($yearsAndItsDates as $yearNumber => $datesAndZeros) {
			foreach ($datesAndZeros as $date => $zeroOrOne) {
				$dateIndex = $datesAsStringAndIndex[$date];
				$yearIndex = $datesIndexWithYearIndex[$dateIndex];
				$result[$yearIndex][$dateIndex] = $zeroOrOne;
			}
		}

		return $result;
	}	
	protected function removeZeroValuesFromTwoDimArr(array $dates)
	{
		$result = [];
		foreach ($dates as $year => $dateAndValues) {
			foreach ($dateAndValues as $date=>$value) {
				if ($value) {
					$result[$year][$date] = $value;
				}
			}
		}

		return $result;
	}
	public function getOperationDurationPerMonth(array $datesAsStringAndIndex , array $datesIndexWithYearIndex ,array $yearIndexWithYear,array $dateIndexWithDate,array $dateWithMonthNumber, $maxYearIsStudyEndDate  = true)
	{
		$operationDurationPerMonth = [];
		$operationDurationPerYear = $this->getOperationDurationPerYear($datesAsStringAndIndex, $datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber, false, $maxYearIsStudyEndDate);
		foreach ($operationDurationPerYear as $key => $values) {
			foreach ($values as $k => $v) {
				if ($v) {
					$operationDurationPerMonth[$k] = $v;
				}
			}
		}

		return array_keys($operationDurationPerMonth);
	}		
		
		
	
	public function replaceIndexWithItsStringDate(array $dates,array $dateIndexWithDate):array
	{
		$stringFormattedDates = [];
		foreach ($dates as $dateIndex => $value) {
			if (is_numeric($dateIndex)) {
				// is index date like 25
				$stringFormattedDates[$dateIndexWithDate[$dateIndex]] =$value;
			} else {
				// is already date string like 10-10-2025
				$stringFormattedDates[$dateIndex] = $value;
			}
		}

		return $stringFormattedDates;
	}	
	public function getCompanyNature()
	{
		return $this->company_nature;
	}	
	/**
	 * * التواريخ كله بالفردة بتاعتها
	 */
	public function getOperationDurationPerYearFromIndexesForAllStudyInfo() 
	{
		$datesAsStringAndIndex = $this->getDatesAsStringAndIndex();
		$datesIndexWithYearIndex = App('datesIndexWithYearIndex');
		$yearIndexWithYear = App('yearIndexWithYear');
		$dateIndexWithDate = App('dateIndexWithDate');
		$dateWithMonthNumber = App('dateWithMonthNumber');
		return $this->getOperationDurationPerYear($datesAsStringAndIndex,$datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber,true,false);
		
	}	
	/**
	 * * التواريخ اللي هتتعرض بس اللي هو اختارها
	 */	
	public function getOperationDurationPerYearFromIndexes() 
	{
		$datesAsStringAndIndex = $this->getDatesAsStringAndIndex();
		$datesIndexWithYearIndex = App('datesIndexWithYearIndex');
		$yearIndexWithYear = App('yearIndexWithYear');
		$dateIndexWithDate = App('dateIndexWithDate');
		$dateWithMonthNumber = App('dateWithMonthNumber');
		return $this->getOperationDurationPerYear($datesAsStringAndIndex,$datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber);
		
	}		
	public function getMonthsWithItsYear(array $yearWithItsIndexes):array 
	{
		$result = [];
		
		foreach($yearWithItsIndexes as $yearIndex => $months){
			foreach($months as $monthIndex=>$isActive){
				if($isActive){
					$result[$monthIndex] = $yearIndex; 
				}
				
			}
		}
		return $result;
	}	
	public function getDatesIndexesHelper()
	{
		$studyDates = $this->getStudyDates() ;

		$studyStartDate = Arr::first($studyDates);

		$studyEndDate = Arr::last($studyDates);
		$studyStartDate = $studyStartDate ? Carbon::make($studyStartDate)->format('Y-m-d'):null;
		$studyEndDate = $studyEndDate ? Carbon::make($studyEndDate)->format('Y-m-d'):null;
		return $this->datesAndIndexesHelpers($studyDates);
	}		
	public function generalAndReserveAssumption()
	{
		return $this->hasOne(GeneralAndReserveAssumption::class,'study_id','id');
	}
	public function leasingRevenueStreamBreakdown()
	{
		return $this->hasMany(LeasingRevenueStreamBreakdown::class,'study_id','id');
	}	
	public function reverseFactoringRevenueStreamBreakdown()
	{
		return $this->hasMany(ReverseFactoringRevenueStreamBreakdown::class,'study_id','id');
	}		
	public function hasLeasing():bool
	{
		return $this->has_leasing;
	}	
	public function hasDirectFactoring():bool
	{
		return $this->has_direct_factoring;
	}	
	public function hasReverseFactoring():bool
	{
		return $this->has_reverse_factoring;
	}	
	public function hasIjaraMortgage():bool
	{
		return $this->has_ijara_mortgage;
	}	
	public function hasPortfolioMortgage():bool
	{
		return $this->has_portfolio_mortgage;
	}	
	public function hasMicroFinance():bool
	{
		return $this->has_micro_finance;
	}	
	public function hasSecuritization():bool
	{
		return $this->has_securitization;
	}	
	public function hasConsumerFinance():bool
	{
		return $this->has_consumer_finance;
	}	
	public function leasingEclAndNewPortfolioFundingRate():HasOne
	{
		return $this->hasOne(EclAndNewPortfolioFundingRate::class,'study_id','id')->where('revenue_stream_type',self::LEASING);
	}

	public function directFactoringEclAndNewPortfolioFundingRate():HasOne
	{
		return $this->hasOne(EclAndNewPortfolioFundingRate::class,'study_id','id')->where('revenue_stream_type',self::DIRECT_FACTORING);
	}
	public function reverseFactoringEclAndNewPortfolioFundingRate():HasOne
	{
		return $this->hasOne(EclAndNewPortfolioFundingRate::class,'study_id','id')->where('revenue_stream_type',self::REVERSE_FACTORING);
	}
	public static function getRevenueStreamTypes():array 
	{
		return [
			'has_leasing'=>__('Leasing'),
			'has_direct_factoring'=>__('Direct Factoring'),
			'has_reverse_factoring'=>__('Reverse Factoring'),
			'has_ijara_mortgage'=>__('Ijara Mortgage'),
			'has_portfolio_mortgage'=>__('Portfolio Mortgage'),
			'has_micro_finance'=>__('Micro Finance'),
			'has_securitization'=>__('Securitization'),
			'has_consumer_finance'=>__('Consumer Finance'),
		];
	}
	public function getCheckedRevenueStreamTypesForSelect():array 
	{
		$result = [];
		foreach(self::getRevenueStreamTypes() as $type=>$title){
			if($this->{$type}){
				$result[] = ['title'=>$title,'value'=>$type];
			}
		}
		return $result;
	}
	public function generateRelationDynamically(string $relationName,string $expenseType ){
		/**
		 * * expense type for example CostOfService
		 * * expense 
		 */
	
		return $this->hasMany(Expense::class , 'model_id','id')->where('model_name','Study')
		->where('expense_type',$expenseType)->where('relation_name',$relationName);
	}
	public function directFactoringRevenueProjectionByCategory()
	{
		return $this->hasOne(DirectFactoringRevenueProjectionByCategory::class,'study_id');
	}
	public function directFactoringBreakdowns():HasMany
	{
		return $this->hasMany(DirectFactoringBreakdown::class,'study_id','id');
	}	
	public function directFactoryAdminFeesRate():HasOne
	{
		return $this->hasOne(DirectFactoringAdminFeesRate::class,'study_id','id');
	}
	public function directFactoringNewPortfolioFundingStructure():HasOne
	{
		return $this->hasOne(DirectFactoringNewPortfolioFundingStructure::class,'study_id','id');
	}
	public function ReverseFactoringRevenueProjectionByCategory()
	{
		return $this->hasOne(ReverseFactoringRevenueProjectionByCategory::class,'study_id');
	}
	public function reverseFactoringBreakdowns():HasMany
	{
		return $this->hasMany(ReverseFactoringBreakdown::class,'study_id','id');
	}	
	public function reverseFactoryAdminFeesRate():HasOne
	{
		return $this->hasOne(ReverseFactoringAdminFeesRate::class,'study_id','id');
	}
	public function reverseFactoringNewPortfolioFundingStructure():HasOne
	{
		return $this->hasOne(ReverseFactoringNewPortfolioFundingStructure::class,'study_id','id');
	}
	
	
	
	public function ijaraMortgageRevenueProjectionByCategory()
	{
		return $this->hasOne(IjaraMortgageRevenueProjectionByCategory::class,'study_id');
	}
	public function ijaraMortgageBreakdowns():HasMany
	{
		return $this->hasMany(IjaraMortgageBreakdown::class,'study_id','id');
	}	
	public function ijaraMortgageAdminFeesRate():HasOne
	{
		return $this->hasOne(IjaraMortgageAdminFeesRate::class,'study_id','id');
	}
	public function ijaraMortgageNewPortfolioFundingStructure():HasOne
	{
		return $this->hasOne(IjaraMortgageNewPortfolioFundingStructure::class,'study_id','id');
	}
	public function ijaraMortgageRevenueStreamBreakdown()
	{
		return $this->hasMany(IjaraMortgageRevenueStreamBreakdown::class,'study_id','id');
	}		
	
	
	public function portfolioMortgageRevenueProjectionByCategories()
	{
		return $this->hasMany(PortfolioMortgageRevenueProjectionByCategory::class,'study_id');
	}

	public function portfolioMortgageAdminFeesRate():HasOne
	{
		return $this->hasOne(PortfolioMortgageAdminFeesRate::class,'study_id','id');
	}
	public function portfolioMortgageNewPortfolioFundingStructure():HasOne
	{
		return $this->hasOne(PortfolioMortgageNewPortfolioFundingStructure::class,'study_id','id');
	}
	public function portfolioMortgageRevenueStreamBreakdown()
	{
		return $this->hasMany(PortfolioMortgageRevenueStreamBreakdown::class,'study_id','id');
	}	
	
	
	
	
	public function microfinanceRevenueProjectionByCategory()
	{
		return $this->hasOne(MicrofinanceRevenueProjectionByCategory::class,'study_id');
	}
	public function microfinanceBreakdowns():HasMany
	{
		return $this->hasMany(MicrofinanceBreakdown::class,'study_id','id');
	}	
	public function microfinanceAdminFeesRate():HasOne
	{
		return $this->hasOne(MicrofinanceAdminFeesRate::class,'study_id','id');
	}
	public function microfinanceNewPortfolioFundingStructure():HasOne
	{
		return $this->hasOne(MicrofinanceNewPortfolioFundingStructure::class,'study_id','id');
	}
	public function microfinanceRevenueStreamBreakdown()
	{
		return $this->hasMany(MicrofinanceRevenueStreamBreakdown::class,'study_id','id');
	}	
	
	public  function convertYearToMonthIndexes(array $items):array
	{
		$result = [];

		$operationDurationPerYear=$this->getOperationDurationPerYearFromIndexes();
		foreach($operationDurationPerYear as $yearIndex => $yearMonthIndexes)
			{
				$sumMonths = array_sum($yearMonthIndexes) ;
				foreach($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne ){
					$result[$monthIndex] = $items[$yearIndex]  ;
				}
			}
			return $result;
	}		
	public  function convertYearToMonthIndexesAndDivideBySumMonths(array $items):array
	{
		$result = [];

		$operationDurationPerYear=$this->getOperationDurationPerYearFromIndexes();
		foreach($operationDurationPerYear as $yearIndex => $yearMonthIndexes)
			{
				$sumMonths = array_sum($yearMonthIndexes) ;
				foreach($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne ){
					$result[$monthIndex] = $items[$yearIndex] / $sumMonths ;
				}
			}
			return $result;
	}	

	public function getTotalDirectFactoringNewPortfolioAmountsAtYearIndex(int $yearIndex)
	{
		$yearsWithItsMonths = $this->getOperationDurationPerYearFromIndexes();
		$this->directFactoringBreakdowns->each(function(DirectFactoringBreakdown $directFactoringBreakdown) use (&$sum,$yearIndex,$yearsWithItsMonths){
			$yearMonthIndexes = $yearsWithItsMonths[$yearIndex];
			foreach($yearMonthIndexes as $monthIndex => $trueOrFalse){
				if($trueOrFalse){
					$sum+= $directFactoringBreakdown->getNetFundingAmountsAtMonthIndex($monthIndex);
				}
			}
		});
		return $sum;
	}
	/**
	 * * revenue_stream_type -> leasing , ijara .. etc
	 * * relation name -> leasingRevenueStreamBreakdown ,
	 */
	public function storeFixedLoans(string $revenueStreamType ,string $relationName,$eclRelationName,bool $isSensitivity = false  , array $pricingPerMonths = null):void
	{
		$loanSchedulePaymentTableName = $isSensitivity ? 'sensitivity_loan_schedule_payments' : 'loan_schedule_payments';
		$revenueIdWitLoanAmounts = $this->{$relationName}->pluck('loan_amounts','id')->toArray() ;
		$calculateFixedLoanAtEndService = new CalculateFixedLoanAtEndService ;
		$calculateFixedLoanAtBeginningService = new CalculateFixedLoanAtBeginningService ;
		$portfolioLoans = [];
		$studyId  = $this->id ;
		$companyId = $this->company->id ;
		$study = $this ;
		$counter = 0 ;
		$operationDurationPerYear=$study->getOperationDurationPerYearFromIndexes();

		$leasingRevenueStreams =$study->{$relationName};
		$generalAndReserveAssumption = $study->generalAndReserveAssumption;
		$leasingEclAndNewPortfolioFundingRate = $study->{$eclRelationName};
		
		/**
		 * @var EclAndNewPortfolioFundingRate $leasingEclAndNewPortfolioFundingRate
		 * @var GeneralAndReserveAssumption $generalAndReserveAssumption
		 */
		$dateIndexWithDate = app('dateIndexWithDate');
		$dateWithDateIndex = app('dateWithDateIndex');
		$yearIndexWithYear = app('yearIndexWithYear');

		$baseRates = $generalAndReserveAssumption->getCbeLendingCorridorRates() ;
	
		$baseRatesPerMonths= [];
		foreach($operationDurationPerYear as $yearIndex => $yearMonthIndexes)
		{
			foreach($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne ){
				$baseRatesPerMonths[Carbon::make($dateIndexWithDate[$monthIndex])->format('Y-m-d')] = $baseRates[$yearIndex];
			}
		}
		DB::connection('non_banking_service')->table($loanSchedulePaymentTableName)->where('revenue_stream_type',$revenueStreamType)->where('study_id',$studyId)->delete();
		$baseRatesMapping = HArr::getFirstOfYear($baseRatesPerMonths);
		$bankLendingMarginRates=$generalAndReserveAssumption->getBankLendingMarginRates();

		
		
		 $baseRatesMapping = HArr::isAllValuesEqual($baseRatesMapping,$bankLendingMarginRates);
		$totalMonthlyLoanAmounts = [];
		// $time = 0 ;
	
		
		foreach($operationDurationPerYear as $yearIndex => $yearMonthIndexes){
			$baseRatesMapping = is_array($baseRatesMapping) ? HArr::filterByYearIndex($baseRatesMapping,$yearIndexWithYear,$yearIndex) : $baseRatesMapping;
			foreach($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne ){
			
				foreach($revenueIdWitLoanAmounts as $leasingRevenueStreamBreakdownId => $yearIndexWithAmount ){
			
					$counter ++ ;
					$loanAtCurrentYear = $yearIndexWithAmount[$yearIndex]??0 ;
					$currentMonthlyLoanAmount = $loanAtCurrentYear / count($yearMonthIndexes)  ;
						
						if($currentMonthlyLoanAmount <= 0){
							continue ;
						}
						$totalMonthlyLoanAmounts[$monthIndex]  = isset($totalMonthlyLoanAmount[$monthIndex]) ? $totalMonthlyLoanAmount[$monthIndex] +  $currentMonthlyLoanAmount : $currentMonthlyLoanAmount ;
					
						$leasingRevenueStreamBreakdown = $leasingRevenueStreams->where('id',$leasingRevenueStreamBreakdownId)->first();
						$hasCategoryId = method_exists($leasingRevenueStreamBreakdown,'getCategoryId') ;
						$revenueCategoryId = $hasCategoryId ? $leasingRevenueStreamBreakdown->getCategoryId() : null;
						// dd($dateIndexWithDate,$monthIndex);
						$currentMonth = $dateIndexWithDate[$monthIndex];
						// $currentMonthFormatted = Carbon::make($currentMonth)->format('d-m-Y');
						$currentMarginRate = $isSensitivity ?  $leasingRevenueStreamBreakdown->getSensitivityMarginRate() : $leasingRevenueStreamBreakdown->getMarginRate();
						
						$gracePeriod = $leasingRevenueStreamBreakdown->getGracePeriod();
						$tenor = $leasingRevenueStreamBreakdown->getTenor();
						$installmentInterval = $leasingRevenueStreamBreakdown->getInstallmentInterval();
						$installmentPaymentIntervalValue = $calculateFixedLoanAtEndService->getInstallmentPaymentIntervalValue($installmentInterval);
						$stepUp = $leasingRevenueStreamBreakdown->getStepUp();
						$stepDown = $leasingRevenueStreamBreakdown->getStepDown();
						$stepInterval = $leasingRevenueStreamBreakdown->getStepInterval();
						$loanType = $leasingRevenueStreamBreakdown->getLoanType();
						$loanNature = $leasingRevenueStreamBreakdown->getLoanNature();
						$loanService = $loanNature == 'fixed-at-end' ? $calculateFixedLoanAtEndService : $calculateFixedLoanAtBeginningService ; 
						
						
						$currentPortfolioLoans=[];
						if(is_array($baseRatesMapping)){
							$currentPortfolioLoans=$loanService->__calculateBasedOnDiffBaseRates($baseRatesMapping ,$loanType, $currentMonth, $currentMonthlyLoanAmount,  $currentMarginRate,  $tenor, $installmentInterval,$installmentPaymentIntervalValue, $stepUp, $stepInterval ,$stepDown ,  $stepInterval ,$gracePeriod ,$monthIndex, $dateWithDateIndex ,$dateIndexWithDate);
						}else{
							
							$currentPortfolioLoans=$loanService->__calculate([] ,-1,$loanType, $currentMonth, $currentMonthlyLoanAmount,$baseRatesMapping, $currentMarginRate,  $tenor, $installmentInterval, $stepUp,$stepInterval ,$stepDown ,  $stepInterval ,$gracePeriod,$monthIndex,null,$pricingPerMonths);
							dd($currentPortfolioLoans);
						
							$finalResult = $currentPortfolioLoans['final_result']??[];
							unset($finalResult['totals']);
							$currentPortfolioLoans = $finalResult ;
					
						}
						
						if(count($currentPortfolioLoans)){
							$currentPortfolioLoans['study_id'] = $studyId ;
							$currentPortfolioLoans['company_id'] = $companyId ;
							$currentPortfolioLoans['month_as_index'] = $monthIndex ;
							$currentPortfolioLoans['revenue_stream_id'] =$leasingRevenueStreamBreakdownId ;
							$currentPortfolioLoans['revenue_stream_category_id'] =$revenueCategoryId ;
							$currentPortfolioLoans['portfolio_loan_type'] ='portfolio';
							$currentPortfolioLoans['revenue_stream_type'] =$revenueStreamType;
							$portfolioLoans[]=collect($currentPortfolioLoans)->map(function($item,$keyName){
								if(is_array($item)){
									return json_encode($item);
								}
								return $item;
							})->toArray();
						}
				
						if( $leasingEclAndNewPortfolioFundingRate && count($totalMonthlyLoanAmounts)){
							$counter++;
							$newLoanFundingRate = $leasingEclAndNewPortfolioFundingRate->getNewLoansFundingRatesAtYearIndex($yearIndex);
							
							$currentMarginRate = $generalAndReserveAssumption->getBankLendingMarginRatesAtYearIndex($yearIndex);
							$currentMonthlyLoanAmount = $totalMonthlyLoanAmounts[$monthIndex];
							$currentMonthlyLoanAmount = $currentMonthlyLoanAmount * $newLoanFundingRate / 100 ;
						
							// $currentMonthlyLoanAmount = $currentMonthlyLoanAmount * $newLoanFundingRate / 100 ;
							if(is_array($baseRatesMapping)){
								$currentPortfolioLoans=$loanService->__calculateBasedOnDiffBaseRates($baseRatesMapping ,$loanType, $currentMonth, $currentMonthlyLoanAmount,  $currentMarginRate,  $tenor, $installmentInterval,$installmentPaymentIntervalValue, $stepUp, $stepInterval ,$stepDown ,  $stepInterval ,$gracePeriod,$monthIndex,$dateWithDateIndex,$dateIndexWithDate );
							}else{
								
								$currentPortfolioLoans=$loanService->__calculate([] ,-1,$loanType, $currentMonth, $currentMonthlyLoanAmount,$baseRatesMapping, $currentMarginRate,  $tenor, $installmentInterval, $stepUp,$stepInterval ,$stepDown ,  $stepInterval ,$gracePeriod,$monthIndex );
								$finalResult = $currentPortfolioLoans['final_result']??[];
								unset($finalResult['totals']);
								$currentPortfolioLoans = $finalResult;
				
							}
							if(count($currentPortfolioLoans)){
								$currentPortfolioLoans['study_id'] = $studyId ;
								$currentPortfolioLoans['company_id'] = $companyId ;
								$currentPortfolioLoans['month_as_index'] = $monthIndex ;
								$currentPortfolioLoans['revenue_stream_id'] =$leasingRevenueStreamBreakdownId ;
								$currentPortfolioLoans['revenue_stream_category_id'] =$revenueCategoryId ;
								$currentPortfolioLoans['portfolio_loan_type'] ='bank_portfolio';
								$currentPortfolioLoans['revenue_stream_type'] =$revenueStreamType;
								$portfolioLoans[]=collect($currentPortfolioLoans)->map(function($item,$keyName){
								if(is_array($item)){
									return json_encode($item);
								}
								return $item;
							})->toArray();
							}
							
							
						
					
						}
						
						
						
						
						
					
				}
				
		
				
				
				
			}
			
		}
		DB::connection('non_banking_service')->table($loanSchedulePaymentTableName)->insert($portfolioLoans);
	}
		
	protected function sumBaseRateWithMarginRate(array $baseRates , float $marginRate){
		$result = [];
		foreach($baseRates as $dateAsString => $baseRate){
			
			$result[$dateAsString] = ($baseRate + $marginRate) / 360 /100 ; 
		}
		return $result;
	}
	public function storeVariableLoans(string $revenueStreamType , string $relationName,$eclRelationName,bool $isSensitivity = false):void
	{
		$loanSchedulePaymentTableName = $isSensitivity ? 'sensitivity_loan_schedule_payments' : 'loan_schedule_payments';
		
		$calculateVariableLoanAtEndService = new CalculateVariableLoanAtEndService ;
		
		$portfolioLoans = [];
		$studyId  = $this->id ;
		$companyId = $this->company->id ;
		$study = $this ;
		$counter = 0 ;
		$operationDurationPerYear=$study->getOperationDurationPerYearFromIndexes();
		$loans = $this->{$relationName}->toArray() ;
		$generalAndReserveAssumption = $study->generalAndReserveAssumption;
		$leasingEclAndNewPortfolioFundingRate = $study->{$eclRelationName};
		/**
		 * @var EclAndNewPortfolioFundingRate $leasingEclAndNewPortfolioFundingRate
		 * @var GeneralAndReserveAssumption $generalAndReserveAssumption
		 */
		$dateIndexWithDate = app('dateIndexWithDate');

		$yearIndexWithYear = app('yearIndexWithYear');

		$baseRates = $generalAndReserveAssumption->getCbeLendingCorridorRates() ;
	
	
		$baseRatesPerMonths= [];
		foreach($operationDurationPerYear as $yearIndex => $yearMonthIndexes)
		{
			foreach($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne ){
				$baseRatesPerMonths[Carbon::make($dateIndexWithDate[$monthIndex])->format('Y-m-d')] = $baseRates[$yearIndex];
			}
		}
		// $dateWithDateIndex = app('dateWithDateIndex');
		DB::connection('non_banking_service')->table($loanSchedulePaymentTableName)->where('revenue_stream_type',$revenueStreamType)->where('study_id',$studyId)->delete();
		$baseRatesMapping = $baseRatesPerMonths;
		// $baseRatesMapping = HArr::getFirstOfYear($baseRatesPerMonths);
		$bankLendingMarginRates=$generalAndReserveAssumption->getBankLendingMarginRates();

		
		
		 $baseRatesMapping = HArr::isAllValuesEqual($baseRatesMapping,$bankLendingMarginRates);
		$totalMonthlyLoanAmounts = [];
		// $time = 0 ;
	//	$isAtEnd = true ;
//		$start = microtime(true);

		foreach($operationDurationPerYear as $yearIndex => $yearMonthIndexes){
			$baseRatesMapping = is_array($baseRatesMapping) ? HArr::filterByYearIndex($baseRatesMapping,$yearIndexWithYear,$yearIndex) :  $baseRatesMapping;
		//	$originalBaseRates = $baseRatesMapping;
			foreach($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne ){

				foreach($loans as $index => $loanArr ){
					$revenueStreamBreakdownId = $loanArr['id'];
					$counter ++ ;
					$currentMonthlyLoanAmount = $loanArr['loan_amounts'][$yearIndex] / count($yearMonthIndexes) ;
					if($currentMonthlyLoanAmount <= 0){
						continue ;
					}
					$totalMonthlyLoanAmounts[$monthIndex]  = isset($totalMonthlyLoanAmount[$monthIndex]) ? $totalMonthlyLoanAmount[$monthIndex] +  $currentMonthlyLoanAmount : $currentMonthlyLoanAmount ;
					
						$revenueCategoryId = $loanArr['category'];
						$currentMonth = $dateIndexWithDate[$monthIndex];
						$currentMonthFormatted = Carbon::make($currentMonth)->format('Y-m-d');
				
						$currentMarginRate = $isSensitivity ?  $loanArr['sensitivity_margin_rate'] : $loanArr['margin_rate'];
						$baseRatePortfolioLoans = is_array($baseRatesMapping) ? $this->sumBaseRateWithMarginRate($baseRatesMapping,$currentMarginRate) : $baseRatesMapping ;
						$gracePeriod = 0;
						$tenor = $loanArr['tenor'];
						$interestPaymentIntervalName = 'monthly';
						$installmentPaymentIntervalName = 'monthly';
						if($revenueCategoryId == 'monthly-interest-and-quarterly-principle'){
							$interestPaymentIntervalName = 'monthly';
							$installmentPaymentIntervalName = 'quartly';
						}elseif($revenueCategoryId == 'quarterly-interest-and-principle'){
							$interestPaymentIntervalName = 'quartly';
							$installmentPaymentIntervalName = 'quartly';
						}
						$stepUp = 0;
						$stepDown = 0;
						$stepInterval = 'monthly';
						$loanType = 'normal';
						// $loanNature = $revenueStreamBreakdown->getLoanNature();
						$loanService = $calculateVariableLoanAtEndService ; 
						/**
						 * @var CalculateVariableLoanAtEndService $loanService
						 */
						// ;
						$currentPortfolioLoans=[];
						$currentPortfolioLoans=$loanService->__calculate([] ,-1,$loanType, $currentMonthFormatted, $currentMonthlyLoanAmount,$baseRatePortfolioLoans, $currentMarginRate,  $tenor, $installmentPaymentIntervalName,$interestPaymentIntervalName, $stepUp,$stepInterval ,$stepDown ,  $stepInterval ,$gracePeriod,$monthIndex ,$dateIndexWithDate);
						
					
							$finalResult = $currentPortfolioLoans['final_result']??[];
							
							unset($finalResult['totals']);
							$currentPortfolioLoans = $finalResult ;
							
						
						if(count($currentPortfolioLoans)){
							$currentPortfolioLoans['study_id'] = $studyId ;
							$currentPortfolioLoans['company_id'] = $companyId ;
							$currentPortfolioLoans['month_as_index'] = $monthIndex ;
							$currentPortfolioLoans['revenue_stream_id'] =$revenueStreamBreakdownId ;
							$currentPortfolioLoans['revenue_stream_category_id'] =$revenueCategoryId ;
							$currentPortfolioLoans['portfolio_loan_type'] ='portfolio';
							$currentPortfolioLoans['revenue_stream_type'] =$revenueStreamType;
							$portfolioLoans[]=collect($currentPortfolioLoans)->map(function($item,$keyName){
								if(is_array($item)){
									return json_encode($item);
								}
								return $item;
							})->toArray();
						}
						if( $leasingEclAndNewPortfolioFundingRate && count($totalMonthlyLoanAmounts)){
							$counter++;
							$newLoanFundingRate = $leasingEclAndNewPortfolioFundingRate->getNewLoansFundingRatesAtYearIndex($yearIndex);

							$currentMarginRate = $generalAndReserveAssumption->getBankLendingMarginRatesAtYearIndex($yearIndex);
					
					
							$currentMonthlyLoanAmount = $totalMonthlyLoanAmounts[$monthIndex];
							$currentMonthlyLoanAmount = $currentMonthlyLoanAmount * $newLoanFundingRate / 100 ;
							$baseRateBankPortfolioLoans = is_array($baseRatesMapping) ? $this->sumBaseRateWithMarginRate($baseRatesMapping,$currentMarginRate) : $baseRatesMapping ;
							
								$currentPortfolioLoans=$loanService->__calculate([] ,-1,$loanType, $currentMonthFormatted, $currentMonthlyLoanAmount,$baseRateBankPortfolioLoans, $currentMarginRate,  $tenor, $installmentPaymentIntervalName,$interestPaymentIntervalName, $stepUp,$stepInterval ,$stepDown ,  $stepInterval ,$gracePeriod ,$monthIndex,$dateIndexWithDate);
								$finalResult = $currentPortfolioLoans['final_result']??[];
								unset($finalResult['totals']);
								$currentPortfolioLoans = $finalResult;
						
							if(count($currentPortfolioLoans)){
								$currentPortfolioLoans['study_id'] = $studyId ;
								$currentPortfolioLoans['company_id'] = $companyId ;
								$currentPortfolioLoans['month_as_index'] = $monthIndex ;
								$currentPortfolioLoans['revenue_stream_id'] =$revenueStreamBreakdownId ;
								$currentPortfolioLoans['revenue_stream_category_id'] =$revenueCategoryId ;
								$currentPortfolioLoans['portfolio_loan_type'] ='bank_portfolio';
								$currentPortfolioLoans['revenue_stream_type'] =$revenueStreamType;
								$portfolioLoans[]=collect($currentPortfolioLoans)->map(function($item,$keyName){
								if(is_array($item)){
									return json_encode($item);
								}
								return $item;
							})->toArray();
							}
							
							
						
					
						}
						
						
						
						
						
					
				}
				
		
				
				
				
			}
			
		}
		
		DB::connection('non_banking_service')->table($loanSchedulePaymentTableName)->insert($portfolioLoans);
	}
	/**
	 * * هنا مفرودة لغايه السنوات الاضافيه
	 */
	public function getStudyDurationPerYearFromIndexesForView() 
	{
		$datesAsStringAndIndex = $this->getDatesAsStringAndIndex();
		$datesIndexWithYearIndex = App('datesIndexWithYearIndex');
		$yearIndexWithYear = App('yearIndexWithYear');
		$dateIndexWithDate = App('dateIndexWithDate');
		$dateWithMonthNumber = App('dateWithMonthNumber');
		return $this->getStudyDurationPerMonth($datesAsStringAndIndex,$datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber,true,false);
		
	}		
	/**
	 * * هنا لحد نهايه الدراسة
	 */
	// public function getStudyDurationPerYearFromIndexesForViewWithEndDate() 
	// {
	// 	$datesAsStringAndIndex = $this->getDatesAsStringAndIndex();
	// 	$datesIndexWithYearIndex = App('datesIndexWithYearIndex');
	// 	$yearIndexWithYear = App('yearIndexWithYear');
	// 	$dateIndexWithDate = App('dateIndexWithDate');
	// 	$dateWithMonthNumber = App('dateWithMonthNumber');
	// 	return $this->getStudyDurationPerMonth($datesAsStringAndIndex,$datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber,true,false);
		
	// }		
	public function getFinancialYearEndMonthNumber():int
	 {
		$financialYearStartMonthName = $this->financialYearStartMonth();
		if($financialYearStartMonthName =='january')
			return 12;
		if($financialYearStartMonthName =='april')
			return 3;
		if($financialYearStartMonthName =='july')
			return 6;
		
	 }
	 /* 
	* * type -> manpower for example 
	* * expense_type -> cost-of-service for example
	 */
	public function departmentsFor(string $type )
	{
		return Department::where('study_id',$this->id)->where('type',$type)->get();
	}
	public function positions()
	{
		return $this->hasMany(Position::class,'study_id','id');
	}
	public static function getProjectionTitles()
	{
		return [
			'all'=>__('All'),
			self::DIRECT_FACTORING=>__('Direct Factoring'),
			self::IJARA=>__('Ijara'),
			self::LEASING=>__('Leasing'),
			self::REVERSE_FACTORING=>__('Reverse Factoring'),
			self::PORTFOLIO_MORTGAGE=>__('Portfolio Mortgage'),
			self::MiCROFINANCE => __('Microfinance')
		];
	}
	
	public function getStudyDurationPerYearFromIndexes() 
	{
		$datesAsStringAndIndex = $this->getDatesAsStringAndIndex();
		$datesIndexWithYearIndex = App('datesIndexWithYearIndex');
		$yearIndexWithYear = App('yearIndexWithYear');
		$dateIndexWithDate = App('dateIndexWithDate');
		$dateWithMonthNumber = App('dateWithMonthNumber');
		return $this->getStudyDurationPerMonth($datesAsStringAndIndex,$datesIndexWithYearIndex,$yearIndexWithYear,$dateIndexWithDate,$dateWithMonthNumber,false);
		
	}	
	public function updateExpensesPercentagesOfSales(bool $isSensitivity = false)
	{
		$this->generateRelationDynamically('percentage_of_sales','Expense')->each(function($expense) use ($isSensitivity){
			$expenseAsPercentageEquation = new ExpenseAsPercentageEquation;
			$percentageOf = $expense->getPercentageOf();
			$revenueStreamTypes = $expense->getRevenueStreamTypes();
			$streamCategoryIds = $expense->getStreamCategoryIds();
			$startDateAsIndex = $expense->getStartDateAsIndex();
			$monthlyPercentage = $expense->getMonthlyPercentage();
			$endDateAsIndex = $expense->getEndDateAsIndex();
			$vatRate = $expense->getVatRate();
			$isDeductible=  $expense->isDeductible();
			$paymentTerms = $expense->getPaymentTerm();
			$withholdTaxRate = $expense->getWithholdTaxRate();
			if($isSensitivity){
				$result['sensitivity_expense_as_percentages']=$expenseAsPercentageEquation->calculate($this->id,$percentageOf,$revenueStreamTypes,$streamCategoryIds,$startDateAsIndex,$endDateAsIndex,$monthlyPercentage,$paymentTerms,$vatRate,$isDeductible,$withholdTaxRate,true);
			}else{
				$result['expense_as_percentages']=$expenseAsPercentageEquation->calculate($this->id,$percentageOf,$revenueStreamTypes,$streamCategoryIds,$startDateAsIndex,$endDateAsIndex,$monthlyPercentage,$paymentTerms,$vatRate,$isDeductible,$withholdTaxRate,false);
				
			}
			$expense->update($result);
		});
	}
	public  function calculateManpowerResult(array $dateAsIndexes , int $existingCount , array $hiringCounts , int $studyStartIndex,float $monthlyNetSalary,float $salaryTaxesRate , float $socialInsuranceRate )
	{
		$yearWithItsIndexes = $this->getOperationDurationPerYearFromIndexesForAllStudyInfo();
		$monthsWithItsYear = $this->getMonthsWithItsYear($yearWithItsIndexes) ;
		$generalAndReserveAssumption = $this->generalAndReserveAssumption;
		$currentIndex = 0 ;
		$currentSalaryAtMonthIndex = $monthlyNetSalary ;
		$accumulatedManpowerCounts = [];
		$monthlySalariesPayments = [];
		$salaryExpenses =[];
		foreach($dateAsIndexes as  $dateAsIndex){
			$currentYearIndex = $monthsWithItsYear[$dateAsIndex]  ;
			$annualIncreaseRate = $generalAndReserveAssumption->getSalariesAnnualIncreaseRateAtYearIndex($currentYearIndex) ;  
			$previousHiringCount = $accumulatedManpowerCounts[$dateAsIndex-1] ?? $existingCount;
			$accumulatedManpowerCounts[$dateAsIndex] = $hiringCounts[$dateAsIndex] + $previousHiringCount   ;
			if($currentIndex%12 == 0 && $currentIndex != 0){
				$currentSalaryAtMonthIndex = $currentSalaryAtMonthIndex * (1+($annualIncreaseRate/100)) ;   
			}
			$monthlySalariesPayments[$dateAsIndex] = $currentSalaryAtMonthIndex * $accumulatedManpowerCounts[$dateAsIndex];
			$salaryExpenses[$dateAsIndex] = $currentSalaryAtMonthIndex * $accumulatedManpowerCounts[$dateAsIndex] / (1 - ($salaryTaxesRate + $socialInsuranceRate));
			$currentIndex++;
			
		}
		
		return [
			'accumulated_manpower_counts'=>$accumulatedManpowerCounts,
			'manpower_salaries'=>$monthlySalariesPayments,
			'salary_expenses'=>$salaryExpenses,
		];
	}
	public function recalculateManpower()
	{
		$positions = $this->positions ;
		/**
		 * @var Position $position
		 */
		$operationStartDateAsIndex = $this->operation_start_month;
		$salaryTaxesRate = $this->getSalaryTaxesRate() / 100;
        $socialInsuranceRate = $this->getSocialInsuranceRate() /100 ;
		foreach($positions as $position){
			$positionArr = [];
			$hiringCounts = $position->getHiringCounts();
			$currentExistingCount = $position->getExistingCount();
			$dateAsIndexes = array_keys($hiringCounts);
			$monthlyNetSalary = $position->getMonthlyNetSalary();
			$additionalDatabaseResult =  $this->calculateManpowerResult($dateAsIndexes,$currentExistingCount,$hiringCounts,$operationStartDateAsIndex,$monthlyNetSalary,$salaryTaxesRate,$socialInsuranceRate);
			foreach($additionalDatabaseResult as $columnName => $payload){
				$positionArr[$columnName] = $payload;
			}
			$position->update($positionArr);
		}
		
		
	}

	public function getLeasingGrowthRateAtYearIndex(int $yearIndex)
	{
		return $this->leasing_growth_rates[$yearIndex] ?? 0  ; 
	}
	public function getFinancialYearsEndMonths():array
	{
		$studyStartDateMonth = $this->getStudyStartDate();
		$studyStartDateMonth = explode('-',$studyStartDateMonth)[1];
		$financialEndMonth = $this->getFinancialYearEndMonthNumber();
		$firstYearEndMonth  = $financialEndMonth - $studyStartDateMonth ;
		if($firstYearEndMonth<0){
			$firstYearEndMonth  = $firstYearEndMonth+12 ;
		}
		$result = [];
		for($i = 0 ; $i<11 ; $i++){
			$result[] = $firstYearEndMonth   ;
			$firstYearEndMonth  = $firstYearEndMonth  + 12 ;
		}
		return $result;
	}
	public function refreshDirectFactoringLoans()
	{
			$generalAndReserveAssumption = $this->generalAndReserveAssumption;
			/**
			 * @var GeneralAndReserveAssumption $generalAndReserveAssumption
			 */
			$baseRates = $generalAndReserveAssumption->getCbeLendingCorridorRates() ;
			$bankMarginRates = $generalAndReserveAssumption->getBankLendingMarginRates() ;
			$datesIndexWithYearIndex = app()->make('datesIndexWithYearIndex');
			$dateIndexWithDates = app()->make('dateIndexWithDate');
			
			$result = [];
			foreach($this->refresh()->directFactoringBreakdowns as $directFactoringBreakdown){
				/**
				 * @var DirectFactoringBreakdown $directFactoringBreakdown
				 */
				$directFactoringBreakdownId = $directFactoringBreakdown->id ;
				$amountAsPayload = $directFactoringBreakdown->getLoanAmountPayload();
				$currentMarginRate = $directFactoringBreakdown->getMarginRate();
				$category = $directFactoringBreakdown->getCategory();
				$directFactoringAmounts = $this->convertYearToMonthIndexesAndDivideBySumMonths($amountAsPayload);
				$baseRates = $this->convertYearToMonthIndexes($baseRates);
				$currentBeginningBalance = 0 ;
				$currentDirectFactoringBankBeginningBalance= 0 ;
				$currentBankInterestExpensePayment= 0 ;
				$factoringInterestRevenue = [];
				$directFactoringStatements[$directFactoringBreakdownId] = [];
				$directFactoringNetFundingAmounts = [];
				$directFactoringBankLoanStatements = [];
				$currentDirectFactoringBeginningBalance = 0 ;
				foreach($directFactoringAmounts as $monthIndex => $currentDirectAmount){
					$currentYearIndex = $datesIndexWithYearIndex[$monthIndex];
					 $currentDateAsString = $dateIndexWithDates[$monthIndex];
					 $currentDaysInMonth = Carbon::make($currentDateAsString)->daysInMonth;
					$currentBaseRate = $baseRates[$monthIndex];
					$currentBankMarginRate = $bankMarginRates[$currentYearIndex];
					$bankInterestRate = ($currentBaseRate + $currentBankMarginRate)/100  ;
					$currentDailyPricing = ($currentMarginRate  + $currentBaseRate) /100 / 360; 
					$directFactoringStatements[$directFactoringBreakdownId]['beginning_balance'][$monthIndex] = $currentDirectFactoringBeginningBalance + $currentDirectAmount ;
					$directFactoringStatements[$directFactoringBreakdownId]['direct_factoring_settlements'][$monthIndex +  ceil($category/30) ] = $currentDirectAmount;
					$currentMonthSettlement = $directFactoringStatements[$directFactoringBreakdownId]['direct_factoring_settlements'][$monthIndex] ?? 0;
					$directFactoringStatements[$directFactoringBreakdownId]['end_balance'][$monthIndex] = $currentDirectFactoringBeginningBalance + $currentDirectAmount - $currentMonthSettlement ;
					$currentDirectFactoringBeginningBalance = $directFactoringStatements[$directFactoringBreakdownId]['end_balance'][$monthIndex] ;
					
					$unearned = [];
						foreach(HArr::getMonthsAsArray($category) as $index => $currentMonthNumber){
							$currentIndex = $monthIndex+$index+1 ;
							$currentAmount = $currentDirectAmount * $currentMonthNumber  * $currentDailyPricing  ;
							$result[$directFactoringBreakdownId][$currentIndex] = isset($result[$directFactoringBreakdownId][$currentIndex]) ? $result[$directFactoringBreakdownId][$currentIndex]+($currentAmount) : $currentAmount;
							$interestRevenues[$currentIndex] = $result[$directFactoringBreakdownId][$currentIndex] ;
							$unearned[$monthIndex] = isset($unearned[$monthIndex]) ? $unearned[$monthIndex] + $currentAmount : $currentAmount;
						}
						$factoringInterestRevenue[$directFactoringBreakdownId]['beginning_balance'][$monthIndex] = $currentBeginningBalance;
						foreach($interestRevenues as $i => $value){
							$factoringInterestRevenue[$directFactoringBreakdownId]['interest_revenue'][$i] = 
							$value;
						}
						
						$factoringInterestRevenue[$directFactoringBreakdownId]['unearned_interest'][$monthIndex] = $unearned[$monthIndex];
						
						$currentDirectFactoringNetFundingAmounts  = $currentDirectAmount -  $unearned[$monthIndex] ;
						$directFactoringNetFundingAmounts[$directFactoringBreakdownId][$monthIndex] = $currentDirectFactoringNetFundingAmounts ;
						if($this->directFactoringNewPortfolioFundingStructure){
							$newLoanFundingRate = (100 - $this->directFactoringNewPortfolioFundingStructure->getEquityFundingRatesAtYearIndex($currentYearIndex))/100 ;
							$currentBankLoanAmount = $currentDirectFactoringNetFundingAmounts * $newLoanFundingRate;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['beginning_balance'][$monthIndex] = $currentDirectFactoringBankBeginningBalance ;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_amounts'][$monthIndex] = $currentBankLoanAmount;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_settlements'][$monthIndex +  ceil($category/30) ] = $currentBankLoanAmount;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense_payments'][$monthIndex] = $currentBankInterestExpensePayment;
							$currentBankLoanSettlementAtCurrentMonth = $directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_settlements'][$monthIndex]??0;
							$totalDues = $currentDirectFactoringBankBeginningBalance + $currentBankLoanAmount - $currentBankLoanSettlementAtCurrentMonth - $currentBankInterestExpensePayment;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['total_dues'][$monthIndex] = $totalDues;
							$interestExpense = $totalDues * $currentDaysInMonth * $bankInterestRate  / 360 ;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense'][$monthIndex] = $interestExpense;
							$currentBankInterestExpensePayment = $interestExpense;
							$endBalance = $totalDues + $interestExpense ;
							$directFactoringBankLoanStatements[$directFactoringBreakdownId]['end_balance'][$monthIndex] = $endBalance;
							$currentDirectFactoringBankBeginningBalance = $endBalance ;
							
						}
						
						
						$currentInterestRevenueAtMonthIndex = $factoringInterestRevenue[$directFactoringBreakdownId]['interest_revenue'][$monthIndex]??0;
						$currentEndBalance = $currentBeginningBalance + $currentInterestRevenueAtMonthIndex - $factoringInterestRevenue[$directFactoringBreakdownId]['unearned_interest'][$monthIndex]  ; 
						$factoringInterestRevenue[$directFactoringBreakdownId]['end_balance'][$monthIndex] =   $currentEndBalance;
						
						$currentBeginningBalance = $currentEndBalance ;
					}
				
					$directFactoringBreakdown->update([
						'beginning_balance' => $factoringInterestRevenue[$directFactoringBreakdownId]['beginning_balance'],
						'interest_revenue' => $factoringInterestRevenue[$directFactoringBreakdownId]['interest_revenue'],
						'unearned_interest' => $factoringInterestRevenue[$directFactoringBreakdownId]['unearned_interest'],
						'end_balance' => $factoringInterestRevenue[$directFactoringBreakdownId]['end_balance'],
						'net_funding_amounts'=>$directFactoringNetFundingAmounts[$directFactoringBreakdownId],
						
						'statement_beginning_balance'=>$directFactoringStatements[$directFactoringBreakdownId]['beginning_balance'],
						'direct_factoring_amounts'=>$directFactoringAmounts,
						'direct_factoring_settlements'=>$directFactoringStatements[$directFactoringBreakdownId]['direct_factoring_settlements'],
						'statement_end_balance'=>$directFactoringStatements[$directFactoringBreakdownId]['end_balance'],
						
						
						'bank_beginning_balance'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['beginning_balance']??[],
						'bank_loan_amounts'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_amounts']??[],
						'bank_loan_settlements'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_settlements']??[],
						'bank_interest_expense_payments'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense_payments']??[],
						'bank_total_dues'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['total_dues']??[],
						'bank_interest_expense'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense']??[],
						'bank_end_balance'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['end_balance']??[],
						]);
				
			}
	}
	public static function getTitleForBreakdown(string $relationName):string {
		return [
			'reverseFactoringBreakdowns'=>__('Reverse Factoring Breakdowns'),
			'leasingRevenueStreamBreakdown'=>__('Leasing Revenue Stream Breakdown'),
			'ijaraMortgageBreakdowns'=>__('Ijara Mortgage Breakdowns')
		][$relationName];
	}
	public  function calculateMonthlyAdminFeesAmounts(array $adminFeesRates , array $loanAmounts  ):array{
		$operationDurationPerYear  = $this->getOperationDurationPerYearFromIndexes() ; 
		$currentAdminFeesAmountsAtMonthIndex = [];
		foreach($adminFeesRates as $currentYearIndex => $currentAdminFeesRateAtYearIndex ){
			$currentLoanAmountAtYearIndex = $loanAmounts[$currentYearIndex] ;
			$currentMonthlyLoanAmount = $currentLoanAmountAtYearIndex / count($operationDurationPerYear[$currentYearIndex]) ;
			foreach($operationDurationPerYear[$currentYearIndex] as $monthIndex => $monthlyZeroOrOne){
				$currentAdminFeesAmountsAtMonthIndex[$monthIndex] =  $currentMonthlyLoanAmount * $currentAdminFeesRateAtYearIndex /100 ;
			}
		}
	
		return $currentAdminFeesAmountsAtMonthIndex;
	}
	public function updateDirectFactoryMonthlyAdminFeesAmounts():void
	{
		$directFactoringAdminFeesRate = $this->directFactoryAdminFeesRate;
		$directFactoring = $this->directFactoringRevenueProjectionByCategory ;
		
		$directFactoringProjections = $directFactoring->getDirectFactoringTransactionProjection();
		$directFactoringAdminFeesRate->update([
			'monthly_admin_fees_amounts'=>$this->calculateMonthlyAdminFeesAmounts($directFactoringAdminFeesRate->getAdminFeesRates(),$directFactoringProjections)
		]);
	}
	public function updateReverseFactoryMonthlyAdminFeesAmounts():void
	{
		$reverseFactoringAdminFeesRate = $this->reverseFactoryAdminFeesRate;
		$reverseFactoring = $this->reverseFactoringRevenueProjectionByCategory ;
		$reverseFactoringProjections = $reverseFactoring->getReverseFactoringTransactionProjection();
		$reverseFactoringAdminFeesRate->update([
			'monthly_admin_fees_amounts'=>$this->calculateMonthlyAdminFeesAmounts($reverseFactoringAdminFeesRate->getAdminFeesRates(),$reverseFactoringProjections)
		]);
	}
	public function updateIjaraMortgageMonthlyAdminFeesAmounts():void
	{
		$adminFeesRate = $this->ijaraMortgageAdminFeesRate;
		$revenueProjection = $this->ijaraMortgageRevenueProjectionByCategory ;
		$reverseFactoringProjections = $revenueProjection->getIjaraMortgageTransactionProjection();
		$adminFeesRate->update([
			'monthly_admin_fees_amounts'=>$this->calculateMonthlyAdminFeesAmounts($adminFeesRate->getAdminFeesRates(),$reverseFactoringProjections)
		]);
	}
	public function updateMicrofinanceMonthlyAdminFeesAmounts():void
	{
		$adminFeesRate = $this->microfinanceAdminFeesRate;
		$revenueProjection = $this->microfinanceRevenueProjectionByCategory ;
		$reverseFactoringProjections = $revenueProjection->getLoanAmounts();
		$adminFeesRate->update([
			'monthly_admin_fees_amounts'=>$this->calculateMonthlyAdminFeesAmounts($adminFeesRate->getAdminFeesRates(),$reverseFactoringProjections)
		]);
	}
	public function updatePortfolioMortgageMonthlyAdminFeesAmounts():void
	{
		$adminFeesRate = $this->portfolioMortgageAdminFeesRate;
		$revenueProjection = $this->portfolioMortgageRevenueProjectionByCategory ;
		$projections = $revenueProjection->getPortfolioMortgageTransactionProjection();
		$adminFeesRate->update([
			'monthly_admin_fees_amounts'=>$this->calculateMonthlyAdminFeesAmounts($adminFeesRate->getAdminFeesRates(),$projections)
		]);
	}
	/**
	 * * بتديلها 
	 * * array 
	 * * فيه الاندكس بتاع كل سنه وبترجعهالك مفرودة شهور
	 * 
	 */
	public function convertYearlyArrayToMonthly(array $yearlyArrayItems , array $yearWithItsIndexes = null):array 
	{
		$result = [];
		$yearWithItsIndexes = is_null($yearWithItsIndexes) ? $this->getOperationDurationPerYearFromIndexes() :$yearWithItsIndexes ;
		$monthsWithItsYear = $this->getMonthsWithItsYear($yearWithItsIndexes) ;
		foreach($yearWithItsIndexes  as $currentYearIndex => $months){
			foreach($months as $currentMonthIndex => $isActive){
				$currentYearAsIndex =$monthsWithItsYear[$currentMonthIndex]; 
				$valueAtCurrentYearIndex = $yearlyArrayItems[$currentYearAsIndex] ?? 0;
				$result[$currentMonthIndex] = $valueAtCurrentYearIndex;
			}
		}
		return $result; 
		
	}
	public function getMicrofinanceBranchesCount():int
	{
		return $this->microfinance_branches_count;
	}
	public function getMicrofinanceLoanOfficerCount():int
	{
		return $this->microfinance_loan_officer_count;
	}
	public function getConsumerfinanceBranchesCount():int
	{
		return $this->consumerfinance_branches_count;
	}
	public function getConsumerfinanceLoanOfficerCount():int
	{
		return $this->consumerfinance_loan_officer_count;
	}
}
