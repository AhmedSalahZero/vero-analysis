<?php
namespace App\Models\NonBankingService;

use App\Equations\ExpenseAsPercentageEquation;
use App\Equations\MonthlyFixedRepeatingAmountEquation;
use App\Helpers\HArr;
use App\Helpers\HHelpers;
use App\Models\NonBankingService\Expense;
use App\Models\NonBankingService\GeneralAndReserveAssumption;
use App\Models\Traits\Scopes\BelongsToCompany;
use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\HasFixedAsset;
use App\ReadyFunctions\CalculateDurationService;
use App\ReadyFunctions\CalculateFixedLoanAtBeginningService;
use App\ReadyFunctions\CalculateFixedLoanAtEndService;
use App\ReadyFunctions\CalculateVariableLoanAtEndService;
use App\ReadyFunctions\CollectionPolicyService;
use App\ReadyFunctions\FixedAssetsPayableEndBalance;
use App\ReadyFunctions\ProjectsUnderProgress;
use App\Traits\HasBasicStoreRequest;
use App\Traits\HasCollectionOrPaymentStatement;
use App\Traits\HasSeasonality;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use MathPHP\Finance;

class Study extends Model
{
    use HasBasicStoreRequest;
    use CompanyScope,BelongsToCompany,HasFixedAsset,HasCollectionOrPaymentStatement,HasSeasonality;
    const STUDY = 'study' ;
    const BUSINESS_PLAN = 'business-plans';  // multiple years
    const ANNUALLY_STUDY = 'annually-study'; // one year
    const LEASING_CATEGORY = 'leasing-categories' ;
    const MiCROFINANCE_PRODUCTS = 'microfinance-products' ;
    const CONSUMERFINANCE_PRODUCTS = 'consumerfinance-products' ;
    const LEASING ='leasing';
    const IJARA ='ijara';
    const PORTFOLIO_MORTGAGE ='portfolio-mortgage';
    const MICROFINANCE ='microfinance';
    const SECURITIZATION ='securitization';
    const CONSUMER_FINANCE ='consumer-finance';
    const DIRECT_FACTORING ='direct-factoring';
    const REVERSE_FACTORING ='reverse-factoring';
    const FACTORING_CATEGORY_ID = 'factoring-category-id';

        
    protected $connection= 'non_banking_service';
    protected $table = 'studies';

    protected $guarded = [
        'id'
    ];
        
    protected $casts = [
        'operation_dates'=>'array',
        'study_dates'=>'array',
        'leasing_growth_rates'=>'array',
        'microfinance_branch_ids'=>'array',
        'product_mix_senior_loan_officers'=>'array',
        'product_mix_loan_officers'=>'array',
    ];
        
    public static function boot()
    {
        parent::boot();
        static::deleted(function (self $study) {
            $study->leasingRevenueStreamBreakdown->each(function (LeasingRevenueStreamBreakdown $leasingRevenueStreamBreakdown) {
                $leasingRevenueStreamBreakdown->delete();
            });
        });
        static::updated(function (self $study) {
            if ($study->isDirty('salary_taxes_rate') || $study->isDirty('social_insurance_rate')) {
                $study->recalculateManpower();
            }
			if($study->isDirty('company_nature') && $study->isNewCompany()){
				foreach([
					'cash_and_bank_opening_balances',
					'equity_opening_balances',
					'fixed_asset_opening_balances',
					'long_term_loan_opening_balances',
					'new_branch_microfinance_opening_projections',
					'other_credits_opening_balances',
					'other_debtors_opening_balances',
					'other_long_term_assets_opening_balances',
					'other_long_term_liabilities_opening_balances',
					'supplier_payable_opening_balances',
					'vat_and_credit_withhold_tax_opening_balances'
				] as $tableName){
					DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table($tableName)->where('study_id',$study->id)->delete();
				}
			}
        });
    }
    public function getName()
    {
        return $this->name;
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
    public function datesAndIndexesHelpers(array $studyDates)
    {
        $firstLoop = true ;
        $baseYear = null ;
        $datesIndexWithYearIndex = [];
        $yearIndexWithYear = [];
        $dateIndexWithDate = [];
        $dateIndexWithMonthNumber = [];
        $dateWithMonthNumber = [];
        $dateWithDateIndex = [];
        foreach ($studyDates as $dateIndex => $dateAsString) {
            $year = explode('-', $dateAsString)[0];
            $montNumber = explode('-', $dateAsString)[1];
            if ($firstLoop) {
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
    protected function editOperationDatesStartingIndex($operationDurationDates, $studyDurationDates)
    {
        $firstIndexInOperationDates = $operationDurationDates[0] ?? null;
        if (!$firstIndexInOperationDates) {
            return [];
        }
        $newDates = [];
        $firstIndex = array_search($firstIndexInOperationDates, $studyDurationDates);
        $loop = 0 ;
        foreach ($operationDurationDates as $oldIndex=>$value) {
            if ($loop == 0) {
                $newDates[$firstIndex] = $value;
            } else {
                $newDates[]=$value ;
            }
            $loop++;
        }
        return $newDates ;
    }
    public function updateStudyAndOperationDates(array $datesAsStringAndIndex, array $datesIndexWithYearIndex, array $yearIndexWithYear, array $dateIndexWithDate, array $dateWithMonthNumber)
    {
        
        $operationDurationDates = $this->getOperationDurationPerMonth($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber, false);
        $studyDurationDates = $this->getStudyDurationPerMonth($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber, false);

        $operationDurationDates = $this->editOperationDatesStartingIndex($operationDurationDates, $studyDurationDates);
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

    // public function getOperationStartDateAsIndex(array $datesAsStringAndIndex, ?string $operationStartDateFormatted): ?int
    // {
    //     return  $operationStartDateFormatted ? $datesAsStringAndIndex[$operationStartDateFormatted] : null;
    // }
    public function getOperationStartDateAsIndex():string
    {
        
        return $this->getIndexDateFromString($this->getOperationStartDate());
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
    public function getEndDateFormatted()
    {
        return $this->study_end_date;
    }
    public function getStudyStartDateAsIndex(array $datesAsStringAndIndex, ?string $studyStartDateAsString): ?int
    {
        return  $studyStartDateAsString ? $datesAsStringAndIndex[$studyStartDateAsString] : null;
    }
    public function getStudyEndDateAsIndex(): ?int
    {
        return $this->getIndexDateFromString($this->getStudyEndDate());
        // return  $studyEndDateAsString ? $datesAsStringAndIndex[$studyEndDateAsString] : null;
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
    public function getStudyDurationPerYear(array $datesAsStringAndIndex, array $datesIndexWithYearIndex, array $yearIndexWithYear, array $dateIndexWithDate, array $dateWithMonthNumber, $asIndexes = true, $maxYearIsStudyEndDate = true, $repeatIndexes = true)
    {
        
        $calculateDurationService = new CalculateDurationService();
        $studyStartDate  = $this->getStudyStartDate();
        $operationStartDate = $this->getOperationStartDate();
        if ($maxYearIsStudyEndDate) {
            $maxDate = $this->getStudyEndDate();
        } else {
            $maxDate = $this->getMaxDate($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber);
        }

        $studyDurationInYears = $this->getDurationInYears();

        $limitationDate = $operationStartDate;
        $studyDurationPerYear = $calculateDurationService->calculateMonthsDurationPerYear($studyStartDate, $maxDate, $studyDurationInYears, $limitationDate, true);
        
        $studyDurationPerYear = $this->removeDatesBeforeDate($studyDurationPerYear, $studyStartDate);
        
        $dates = [];
        if ($asIndexes) {
            $dates =  $this->convertMonthAndYearsToIndexes($studyDurationPerYear, $datesAsStringAndIndex, $datesIndexWithYearIndex);
        } else {
            $dates =  $studyDurationPerYear;
        }
        if ($repeatIndexes) {
            return $this->addMoreIndexes($dates, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber, $asIndexes);
        } else {
            return $dates;
        }
        // return $this->removeZeroValuesFromTwoDimArr($dates);
    }
    protected function addMoreIndexes(array $yearAndDatesValues, array $yearIndexWithYear, array $dateIndexWithDate, array $dateWithMonthNumber, bool $asIndexes):array
    {
        $maxYearsCount = 1;
        $lastYear = array_key_last($yearAndDatesValues);
        $firstYear = array_key_first($yearAndDatesValues);
        $maxYear = $firstYear  + $maxYearsCount;
        $firstYearAfterLast = $lastYear+1;
        for ($firstYearAfterLast; $firstYearAfterLast <= $maxYear; $firstYearAfterLast++) {
            $dates = $this->replaceIndexWithItsStringDate($yearAndDatesValues[$lastYear], $dateIndexWithDate);
            if ($asIndexes) {
                $yearAndDatesValues[$firstYearAfterLast] = $this->replaceYearWithAnotherYear($dates, $yearIndexWithYear[$firstYearAfterLast], $asIndexes, $dateIndexWithDate, $dateWithMonthNumber);
            } else {
                $yearAndDatesValues[$firstYearAfterLast] = $this->replaceYearWithAnotherYear($dates, $firstYearAfterLast, $asIndexes, $dateIndexWithDate, $dateWithMonthNumber);
            }
        }
        return $yearAndDatesValues;
    }
    protected function replaceYearWithAnotherYear(array $dateAndValues, $newYear, bool $asIndexes, array $dateIndexWithDate, array $dateWithMonthNumber)
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
    public function getStudyDurationPerMonth(array $datesAsStringAndIndex, array $datesIndexWithYearIndex, array $yearIndexWithYear, array $dateIndexWithDate, array $dateWithMonthNumber, $maxYearIsStudyEndDate = true, $repeatIndexes = true)
    {
        $studyDurationPerMonth = [];
    
        $studyDurationPerYear = $this->getStudyDurationPerYear($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber, false, $maxYearIsStudyEndDate, $repeatIndexes);
        
        foreach ($studyDurationPerYear as $year => $values) {
            foreach ($values as $date => $value) {
                $studyDurationPerMonth[$date] = $value;
            }
        }

        return array_keys($studyDurationPerMonth);
    }
    protected function getMaxDate(array $datesAsStringAndIndex, array $datesIndexWithYearIndex, array $yearIndexWithYear, array $dateIndexWithDate, array $dateWithMonthNumber)
    {
        $studyDurationPerMonth = $this->getStudyDurationPerMonth($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber);

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
    public function getOperationDurationPerYear(array $datesAsStringAndIndex, array $datesIndexWithYearIndex, array $yearIndexWithYear, array $dateIndexWithDate, array $dateWithMonthNumber, $asIndexes = true, $maxYearIsStudyEndDate = true)
    {
        $calculateDurationService = new CalculateDurationService();
        $operationStartDate  = $this->getOperationStartDateFormatted();
        if ($maxYearIsStudyEndDate) {
            $maxDate = $this->getStudyEndDate();
        } else {
            $maxDate = $this->getMaxDate($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber);
        }
        $studyDurationInYears = $this->getDurationInYears();
        $operationDurationPerYear = $calculateDurationService->calculateMonthsDurationPerYear($operationStartDate, $maxDate, $studyDurationInYears, true);

        $operationDurationPerYear = $this->removeZeroValuesFromTwoDimArr($operationDurationPerYear);
        if ($asIndexes) {
            return $this->convertMonthAndYearsToIndexes($operationDurationPerYear, $datesAsStringAndIndex, $datesIndexWithYearIndex);
        }

        return $operationDurationPerYear;
    }
    protected function convertMonthAndYearsToIndexes(array $yearsAndItsDates, array $datesAsStringAndIndex, array $datesIndexWithYearIndex)
    {
        $result = [];
        foreach ($yearsAndItsDates as $yearNumber => $datesAndZeros) {
            foreach ($datesAndZeros as $date => $zeroOrOne) {
                $dateIndex = $datesAsStringAndIndex[$date]??null;
				if(is_null($dateIndex)){
					continue;
				}
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
    public function getOperationDurationPerMonth(array $datesAsStringAndIndex, array $datesIndexWithYearIndex, array $yearIndexWithYear, array $dateIndexWithDate, array $dateWithMonthNumber, $maxYearIsStudyEndDate  = true)
    {
        $operationDurationPerMonth = [];
        $operationDurationPerYear = $this->getOperationDurationPerYear($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber, false, $maxYearIsStudyEndDate);
        foreach ($operationDurationPerYear as $key => $values) {
            foreach ($values as $k => $v) {
                if ($v) {
                    $operationDurationPerMonth[$k] = $v;
                }
            }
        }

        return array_keys($operationDurationPerMonth);
    }
        
        
    
    public function replaceIndexWithItsStringDate(array $dates, array $dateIndexWithDate):array
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
	public function isExistingCompany():bool
	{
		return $this->getCompanyNature() == 'existing';
	}
	public function isNewCompany():bool
	{
		return $this->getCompanyNature() == 'new';
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
        return $this->getOperationDurationPerYear($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber, true, false);
        
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
        return $this->getOperationDurationPerYear($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber);
        
    }
	public function getActiveTab():string 
	{
		$isMonthlyStudy = $this->isMonthlyStudy() ;
		$active = $isMonthlyStudy ? Study::ANNUALLY_STUDY : Study::BUSINESS_PLAN;
		return 		$active;
	}
    public function isMonthlyStudy():bool
    {
        return $this->duration_in_years < 2 ;
    }
    public function isBusinessPlan():bool
    {
        return !$this->isMonthlyStudy();
    }
    public function getActiveMonthlyDatesWithoutFormatting($yearIndexWithItsActiveMonths, $dateIndexWithDate)
    {
        $results = [];
        foreach ($yearIndexWithItsActiveMonths as $yearAsIndex => $monthsForThisYearArray) {
            foreach ($monthsForThisYearArray as $dateAsIndex => $isActive) {
                $dateAsString = $dateIndexWithDate[$dateAsIndex] ;
                $results[$dateAsIndex] = Carbon::parse($dateAsString)->format('Y-m-d');
            }
        }
        return $results;
            
    }
    public function getActiveMonthlyDates($yearIndexWithItsActiveMonths, $dateIndexWithDate)
    {
        $results = [];
        foreach ($yearIndexWithItsActiveMonths as $yearAsIndex => $monthsForThisYearArray) {
            foreach ($monthsForThisYearArray as $dateAsIndex => $isActive) {
                $dateAsString = $dateIndexWithDate[$dateAsIndex] ;
                $results[$dateAsIndex] = Carbon::parse($dateAsString)->format('M`Y');
            }
        }
        return $results;
            
    }
    public function getMonthlyIndexes()
    {
        $yearIndexWithItsActiveMonths = $this->getOperationDurationPerYearFromIndexes();
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        $dateIndexWithDate=$datesAndIndexesHelpers['dateIndexWithDate'];
        
        return $this->getActiveMonthlyDates($yearIndexWithItsActiveMonths, $dateIndexWithDate);
    }
    public function getYearlyIndexes():array
    {
        $yearIndexWithItsActiveMonths = $this->getOperationDurationPerYearFromIndexes();
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        $yearIndexWithYear=$datesAndIndexesHelpers['yearIndexWithYear'];
        $results = [];
        foreach ($yearIndexWithItsActiveMonths as $yearIndex => $monthsForThisYearArray) {
            $results[$yearIndex] = 'Yr-'.$yearIndexWithYear[$yearIndex] ;
        }
        return $results;
        
    }
    public function getYearOrMonthIndexes():array
    {
        if ($this->isMonthlyStudy()) {
            return $this->getMonthlyIndexes();
        }
        return $this->getYearlyIndexes();
    }
    
    public function getMonthsWithItsYear(array $yearWithItsIndexes):array
    {
        $result = [];
        
        foreach ($yearWithItsIndexes as $yearIndex => $months) {
            foreach ($months as $monthIndex=>$isActive) {
                if ($isActive) {
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
        return $this->hasOne(GeneralAndReserveAssumption::class, 'study_id', 'id');
    }
    public function leasingRevenueStreamBreakdown()
    {
        return $this->hasMany(LeasingRevenueStreamBreakdown::class, 'study_id', 'id');
    }
    public function revenueContracts()
    {
        return $this->hasMany(RevenueContract::class, 'study_id', 'id');
    }
    public function reverseFactoringRevenueStreamBreakdown()
    {
        return $this->hasMany(ReverseFactoringRevenueStreamBreakdown::class, 'study_id', 'id');
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
    public function getMicrofinanceType():?string
    {
        return $this->microfinance_type;
    }
    public function isWholeCompanyMicrofinance()
    {
        $isWholeCompany = $this->getMicrofinanceType() == 'whole-company';
        return $this->hasMicroFinance() && $isWholeCompany;
    }
    public function isByCompanyMicrofinance()
    {
        $isByBranch = $this->getMicrofinanceType() == 'by-branch';
        return $this->hasMicroFinance() && $isByBranch;
    }
    public function getMicrofinanceNoBranches()
    {
        return $this->microfinance_no_branches;
    }
    public function hasSecuritization():bool
    {
        return $this->has_securitization;
    }
    public function hasConsumerFinance():bool
    {
        return $this->has_consumer_finance;
    }
    public function eclAndNewPortfolioFundingRates():HasMany
    {
        return $this->HasMany(EclAndNewPortfolioFundingRate::class, 'study_id', 'id')
        // ->where('revenue_stream_type', self::LEASING)
        ;
    }
    public function getEclAndNewPortfolioFundingRatesForStreamType(string $revenueStreamType):?EclAndNewPortfolioFundingRate
    {
        return $this->eclAndNewPortfolioFundingRates->where('revenue_stream_type', $revenueStreamType)->first();
    }
    public function directFactoringEclAndNewPortfolioFundingRate():HasOne
    {
        return $this->hasOne(EclAndNewPortfolioFundingRate::class, 'study_id', 'id')->where('revenue_stream_type', self::DIRECT_FACTORING);
    }
    public function reverseFactoringEclAndNewPortfolioFundingRate():HasOne
    {
        return $this->hasOne(EclAndNewPortfolioFundingRate::class, 'study_id', 'id')->where('revenue_stream_type', self::REVERSE_FACTORING);
    }
    public function getSelectedRevenueStreamTypes():array
    {
        $result =[];
        foreach (self::getRevenueStreamTypes() as $typeId => $title) {
            if ($this->{$typeId}) {
                $result[] = $typeId;
            }
        }
    
        return $result;
    }
    public function getSelectedRevenueStreamTypesFormatted():array
    {
        $selected = $this->getSelectedRevenueStreamTypes();
        $mainTitleMapping = $this->getRevenueStreamTypes();
        $result = [];
        foreach ($selected as $revenueId) {
            $result[] = [
                'value'=>$revenueId,
                'title'=>$mainTitleMapping[$revenueId]
            ];
        }
        return $result;
      
    }
    public static function getRevenueStreamTypes():array
    {
        return [
            'has_leasing'=>__('Leasing'),
            'has_direct_factoring'=>__('Direct Factoring'),
            'has_reverse_factoring'=>__('Reverse Factoring'),
            'has_ijara_mortgage'=>__('Ijara Mortgage'),
            'has_portfolio_mortgage'=>__('Portfolio Mortgage'),
            'has_micro_finance'=>__('Microfinance'),
            'has_securitization'=>__('Securitization'),
            'has_consumer_finance'=>__('Consumer Finance'),
        ];
    }
    public function getCheckedRevenueStreamTypesForSelect():array
    {
        $result = [];
        foreach (self::getRevenueStreamTypes() as $type=>$title) {
            if ($this->{$type}) {
                $result[] = ['title'=>$title,'value'=>$type];
            }
        }
        return $result;
    }
    public function generateRelationDynamically(string $relationName, string $expenseType)
    {
        /**
         * * expense type for example CostOfService
         * * expense
         */
    
        return $this->hasMany(Expense::class, 'model_id', 'id')->where('model_name', 'Study')
        ->where('expense_type', $expenseType)->where('relation_name', $relationName);
    }
    public function directFactoringRevenueProjectionByCategory()
    {
        return $this->hasOne(DirectFactoringRevenueProjectionByCategory::class, 'study_id');
    }
    public function directFactoringBreakdowns():HasMany
    {
        return $this->hasMany(DirectFactoringBreakdown::class, 'study_id', 'id');
    }
    // public function directFactoryAdminFeesRate():HasOne
    // {
    //     return $this->hasOne(DirectFactoringAdminFeesRate::class, 'study_id', 'id');
    // }
    // public function directFactoringNewPortfolioFundingStructure():HasOne
    // {
    //     return $this->hasOne(DirectFactoringNewPortfolioFundingStructure::class, 'study_id', 'id');
    // }
    
    public function ReverseFactoringRevenueProjectionByCategory()
    {
        return $this->hasOne(ReverseFactoringRevenueProjectionByCategory::class, 'study_id');
    }
    public function reverseFactoringBreakdowns():HasMany
    {
        return $this->hasMany(ReverseFactoringBreakdown::class, 'study_id', 'id');
    }
    // public function reverseFactoryAdminFeesRate():HasOne
    // {
    //     return $this->hasOne(ReverseFactoringAdminFeesRate::class, 'study_id', 'id');
    // }
    // public function reverseFactoringNewPortfolioFundingStructure():HasOne
    // {
    //     return $this->hasOne(ReverseFactoringNewPortfolioFundingStructure::class, 'study_id', 'id');
    // }
    public function ijaraMortgageRevenueProjectionByCategory()
    {
        return $this->hasOne(IjaraMortgageRevenueProjectionByCategory::class, 'study_id');
    }
    public function ijaraMortgageBreakdowns():HasMany
    {
        return $this->hasMany(IjaraMortgageBreakdown::class, 'study_id', 'id');
    }
    // public function ijaraMortgageAdminFeesRate():HasOne
    // {
    //     return $this->hasOne(IjaraMortgageAdminFeesRate::class, 'study_id', 'id');
    // }
    // public function ijaraMortgageNewPortfolioFundingStructure():HasOne
    // {
    //     return $this->hasOne(IjaraMortgageNewPortfolioFundingStructure::class, 'study_id', 'id');
    // }
    public function ijaraMortgageRevenueStreamBreakdown()
    {
        return $this->hasMany(IjaraMortgageRevenueStreamBreakdown::class, 'study_id', 'id');
    }
    
    public function portfolioMortgageRevenueProjectionByCategories()
    {
        return $this->hasMany(PortfolioMortgageRevenueProjectionByCategory::class, 'study_id');
    }
    
    // public function portfolioMortgageAdminFeesRate():HasOne
    // {
    //     return $this->hasOne(PortfolioMortgageAdminFeesRate::class, 'study_id', 'id');
    // }
    // public function portfolioMortgageNewPortfolioFundingStructure():HasOne
    // {
    //     return $this->hasOne(PortfolioMortgageNewPortfolioFundingStructure::class, 'study_id', 'id');
    // }
    public function portfolioMortgageRevenueStreamBreakdown()
    {
        return $this->hasMany(PortfolioMortgageRevenueStreamBreakdown::class, 'study_id', 'id');
    }
    
    
    
    
    // public function microfinanceRevenueProjectionByCategory()
    // {
    //     return $this->hasOne(MicrofinanceRevenueProjectionByCategory::class, 'study_id');
    // }
    // public function microfinanceBreakdowns():HasMany
    // {
    //     return $this->hasMany(MicrofinanceBreakdown::class, 'study_id', 'id');
    // }
    // public function microfinanceAdminFeesRate():HasOne
    // {
    //     return $this->hasOne(MicrofinanceAdminFeesRate::class, 'study_id', 'id');
    // }
    // public function microfinanceNewPortfolioFundingStructure():HasOne
    // {
    //     return $this->hasOne(MicrofinanceNewPortfolioFundingStructure::class, 'study_id', 'id');
    // }
    // public function microfinanceRevenueStreamBreakdown()
    // {
    //     return $this->hasMany(MicrofinanceRevenueStreamBreakdown::class, 'study_id', 'id');
    // }
    
    public function convertYearToMonthIndexes(array $items):array
    {
        $result = [];

        $operationDurationPerYear=$this->getOperationDurationPerYearFromIndexes();
        foreach ($operationDurationPerYear as $yearIndex => $yearMonthIndexes) {
            $sumMonths = array_sum($yearMonthIndexes) ;
            foreach ($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne) {
                $result[$monthIndex] = $items[$yearIndex]??0  ;
            }
        }
        return $result;
    }
    public function convertYearToMonthIndexesAndDivideBySumMonths(array $items):array
    {
        $result = [];

        $operationDurationPerYear=$this->getOperationDurationPerYearFromIndexes();
        foreach ($operationDurationPerYear as $yearIndex => $yearMonthIndexes) {
            $sumMonths = array_sum($yearMonthIndexes) ;
            foreach ($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne) {
                $result[$monthIndex] = $items[$yearIndex] / $sumMonths ;
            }
        }
        return $result;
    }

    public function getTotalDirectFactoringNewPortfolioAmountsAtYearOrMonthIndex(int $yearOrMonthIndex)
    {
        $yearsWithItsMonths = $this->getOperationDurationPerYearFromIndexes();
        $isMonthlyStudy = $this->isMonthlyStudy();
        $resultPerCategory = [];
        $this->directFactoringBreakdowns->each(function (DirectFactoringBreakdown $directFactoringBreakdown) use (&$sum, &$resultPerCategory, $yearOrMonthIndex, $yearsWithItsMonths, $isMonthlyStudy) {
            if ($isMonthlyStudy) {
                $currentValue = $directFactoringBreakdown->getNetFundingAmountsAtMonthIndex($yearOrMonthIndex);
                $sum+= $currentValue ;
                $resultPerCategory[$directFactoringBreakdown->id][$yearOrMonthIndex] = isset($resultPerCategory[$directFactoringBreakdown->id][$yearOrMonthIndex]) ? $resultPerCategory[$directFactoringBreakdown->id][$yearOrMonthIndex] + $currentValue  : $currentValue;
                return true ; // to continue and return false if you want to break;
            }
            $yearMonthIndexes = $yearsWithItsMonths[$yearOrMonthIndex];
            foreach ($yearMonthIndexes as $monthIndex => $trueOrFalse) {
                if ($trueOrFalse) {
                    $currentValue = $directFactoringBreakdown->getNetFundingAmountsAtMonthIndex($monthIndex);
                    // logger($currentValue.'-'.$directFactoringBreakdown->id);
                    $sum+=$currentValue ;
                    $resultPerCategory[$directFactoringBreakdown->id][$monthIndex] = isset($resultPerCategory[$directFactoringBreakdown->id][$monthIndex]) ? $resultPerCategory[$directFactoringBreakdown->id][$monthIndex] + $currentValue  : $currentValue;
                    
                }
            }
        });
        return [
            'sum'=>$sum ,
            'per_category'=>$resultPerCategory
        ];
        
    }
    /**
     * * revenue_stream_type -> leasing , ijara .. etc
     * * relation name -> leasingRevenueStreamBreakdown ,
     */
    public function storeMonthlyLoan(string $revenueType, string $relationName)
    {
        $monthlyLoanAmounts = [];
        $contractCounts = [];
        $isDirectFactoring = $relationName === 'directFactoringBreakdowns' ;
        $operationDurationPerYear=$this->getOperationDurationPerYearFromIndexes();
		$isPortfolio = $relationName === 'portfolioMortgageRevenueProjectionByCategories' ;
        
        // Disbursement
        $revenueIdWitLoanAmounts = $isPortfolio  ?  HArr::getNetPresentValueFromEachMonth($this->{$relationName}->pluck('statement','id')->toArray())    :  $this->{$relationName}->pluck('loan_amounts', 'id')->toArray() ;
		// dd($revenueIdWitLoanAmounts);
        DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('revenue_contracts')->where('study_id', $this->id)->where('revenue_type', $revenueType)->delete();
		// dd($revenueIdWitLoanAmounts);
        foreach ($revenueIdWitLoanAmounts as $leasingRevenueStreamBreakdownId => $yearIndexWithAmount) {
            $model = $this->{$relationName}->where('id', $leasingRevenueStreamBreakdownId)->first() ;
            //    $foreignKeyName = $model->getForeignKeyName();
            foreach ($operationDurationPerYear as $yearIndex => $yearMonthIndexes) {
                foreach ($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne) {
                    if ($isDirectFactoring) {
                        $directFactoringMonthlyLoanAmounts = $this->isMonthlyStudy() ?  $this->getTotalDirectFactoringNewPortfolioAmountsAtYearOrMonthIndex($monthIndex)['per_category'][$leasingRevenueStreamBreakdownId]??[] :  $this->getTotalDirectFactoringNewPortfolioAmountsAtYearOrMonthIndex($yearIndex)['per_category'][$leasingRevenueStreamBreakdownId]??[];
                    }
                    $yearIndexWithAmount = is_string($yearIndexWithAmount) ? (array)json_decode($yearIndexWithAmount) : $yearIndexWithAmount;
                    $loanAtCurrentYear = $this->isMonthlyStudy() ? ($yearIndexWithAmount[$monthIndex]??0) : ($yearIndexWithAmount[$yearIndex]??0);
					// dd($loanAtCurrentYear);
                   
                    $currentMonthlyLoanAmount = $isPortfolio ? 0 : ( $this->isMonthlyStudy() ? $loanAtCurrentYear :  ($loanAtCurrentYear / count($yearMonthIndexes)))  ;
                    $currentMonthlyLoanAmount = $isPortfolio ? ($yearIndexWithAmount[$monthIndex]??0) : $currentMonthlyLoanAmount;
                    $currentMonthlyLoanAmount = $isDirectFactoring ? ($directFactoringMonthlyLoanAmounts[$monthIndex]??0) : $currentMonthlyLoanAmount;
					// if($monthIndex == 1){
					// 	dd($currentMonthlyLoanAmount);
					// }
                    // if($monthIndex != 0){
					// 	continue;
					// }
                    $monthlyLoanAmounts[$leasingRevenueStreamBreakdownId][$monthIndex] = $currentMonthlyLoanAmount ;
                    $contractCounts[$leasingRevenueStreamBreakdownId][$monthIndex] = (int)($currentMonthlyLoanAmount != 0)  ;
                }
            }
            $currentMonthlyAmounts = $monthlyLoanAmounts[$leasingRevenueStreamBreakdownId];
            $currentCounts = $contractCounts[$leasingRevenueStreamBreakdownId];
            $model->update([
                'monthly_loan_amounts'=>$currentMonthlyAmounts
            ]);
            $foreignKeyName = $model->getForeignKeyName();
            $revenueType = $model->getRevenueType();
            $categoryColumnName = $model->getCategoryColumnName();

            
            $newRevenueContractRows = [
                'study_id'=>$this->id ,
                'company_id'=>$this->company->id ,
                'monthly_loan_amounts'=>$currentMonthlyAmounts,
                'contract_counts'=>$currentCounts,
                $foreignKeyName=>$model->id,
                'revenue_type'=>$revenueType
            ];
            if ($categoryColumnName) {
                $newRevenueContractRows['category_id'] = $model->{$categoryColumnName};
            }
            RevenueContract::create($newRevenueContractRows);
            
        }
    }
    public function storeFixedLoans(string $revenueStreamType, string $relationName, bool $isSensitivity = false, array $pricingPerMonths = null):void
    {
        $studyId  = $this->id ;
        $companyId = $this->company->id ;
        $study = $this ;
        $loanSchedulePaymentTableName = $isSensitivity ? 'sensitivity_loan_schedule_payments' : 'loan_schedule_payments';
        DB::connection('non_banking_service')->table($loanSchedulePaymentTableName)->where('revenue_stream_type', $revenueStreamType)->where('study_id', $studyId)->delete();
        $revenueIdWitLoanAmounts = $this->{$relationName}->pluck('loan_amounts', 'id')->toArray() ;
        $this->storeMonthlyLoan($revenueStreamType, $relationName);
        $calculateFixedLoanAtEndService = new CalculateFixedLoanAtEndService ;
        $calculateFixedLoanAtBeginningService = new CalculateFixedLoanAtBeginningService ;
        $portfolioLoans = [];
        
        $operationDurationPerYear=$study->getOperationDurationPerYearFromIndexes();

        $leasingRevenueStreams =$study->{$relationName};
        $generalAndReserveAssumption = $study->generalAndReserveAssumption;
        $eclAndNewPortfolioFundingRate = $study->getEclAndNewPortfolioFundingRatesForStreamType($revenueStreamType);
        // $leasingNewPortfolioFundingRate = $study->{$newPortfolioFundingRateRelationName};
        $totalPortfolioEndBalance = [];
        // $operationStartDasIndex = $study->getOperationStartDateAsIndex()
        $operationDates = range($study->getOperationStartDateAsIndex(), $study->getStudyEndDateAsIndex());
        /**
         * @var EclAndNewPortfolioFundingRate $eclAndNewPortfolioFundingRate
         * @var GeneralAndReserveAssumption $generalAndReserveAssumption
         */
        $dateIndexWithDate = app('dateIndexWithDate');
        $dateWithDateIndex = app('dateWithDateIndex');
        $yearIndexWithYear = app('yearIndexWithYear');

        $baseRates = $generalAndReserveAssumption->getCbeLendingCorridorRates() ;
        // $baseRatesMapping= $generalAndReserveAssumption->getBaseRatesPerMonths();

        foreach ($operationDurationPerYear as $yearIndex => $yearMonthIndexes) {
            foreach ($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne) {
                $yearOrMonthIndex = $this->isMonthlyStudy() ? $monthIndex : $yearIndex;
                $baseRatesPerMonths[Carbon::make($dateIndexWithDate[$monthIndex])->format('Y-m-d')] = $baseRates[$yearOrMonthIndex];
            }
        }
        

        $baseRatesMapping = HArr::getFirstOfYear($baseRatesPerMonths);
        $bankLendingMarginRates=$generalAndReserveAssumption->getBankLendingMarginRates();
        $baseRatesMapping = HArr::isAllValuesEqual($baseRatesMapping, $bankLendingMarginRates);
		
        $totalMonthlyLoanAmounts = [];
        // $loanEndBalances =[];
        
        foreach ($operationDurationPerYear as $yearIndex => $yearMonthIndexes) {
			// logger('from qq');
            foreach ($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne) {
				// if($monthIndex != 0){
				// 	continue;
				// }
				// logger('from abc');
                $baseRatesMapping = is_array($baseRatesMapping) ? HArr::filterByYearIndex($baseRatesMapping, $yearIndexWithYear, $yearIndex, $dateIndexWithDate[$monthIndex], $this->isMonthlyStudy()) : $baseRatesMapping;
                $yearOrMonthIndex = $this->isMonthlyStudy() ? $monthIndex : $yearIndex;
				
                foreach ($revenueIdWitLoanAmounts as $leasingRevenueStreamBreakdownId => $yearIndexWithAmount) {
					// logger('from ddd');
                    $loanAtCurrentYear = $yearIndexWithAmount[$yearOrMonthIndex]??0 ;
                    $currentMonthlyLoanAmount = $loanAtCurrentYear / ($this->isMonthlyStudy() ? 1 : count($yearMonthIndexes))  ;
				
                    if ($currentMonthlyLoanAmount <= 0) {
                        continue ;
                    }
                    $totalMonthlyLoanAmounts[$monthIndex]  = isset($totalMonthlyLoanAmount[$monthIndex]) ? $totalMonthlyLoanAmount[$monthIndex] +  $currentMonthlyLoanAmount : $currentMonthlyLoanAmount ;
                
          
                    $leasingRevenueStreamBreakdown = $leasingRevenueStreams->where('id', $leasingRevenueStreamBreakdownId)->first();
                    $hasCategoryId = method_exists($leasingRevenueStreamBreakdown, 'getCategoryId') ;
                    $revenueCategoryId = $hasCategoryId ? $leasingRevenueStreamBreakdown->getCategoryId() : null;
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
                    if (is_array($baseRatesMapping)) {
						// logger('from if');
						// logger(json_encode($baseRatesMapping));
                        $currentPortfolioLoans=$loanService->__calculateBasedOnDiffBaseRates($baseRatesMapping, $loanType, $currentMonth, $currentMonthlyLoanAmount, $currentMarginRate, $tenor, $installmentInterval, $installmentPaymentIntervalValue, $stepUp, $stepInterval, $stepDown, $stepInterval, $gracePeriod, $monthIndex, $dateWithDateIndex, $dateIndexWithDate);
						
                    } else {
						// logger('from else');
                        $currentPortfolioLoans=$loanService->__calculate([], -1, $loanType, $currentMonth, $currentMonthlyLoanAmount, $baseRatesMapping, $currentMarginRate, $tenor, $installmentInterval, $stepUp, $stepInterval, $stepDown, $stepInterval, $gracePeriod, $monthIndex, null, $pricingPerMonths);
                        $finalResult = $currentPortfolioLoans['final_result']??[];
                        unset($finalResult['totals']);
                        $currentPortfolioLoans = $finalResult ;
                    }
                        
                    if (count($currentPortfolioLoans)) {
                        $currentPortfolioLoans['study_id'] = $studyId ;
                        $currentPortfolioLoans['company_id'] = $companyId ;
                        $currentPortfolioLoans['month_as_index'] = $monthIndex ;
                        $currentPortfolioLoans['revenue_stream_id'] =$leasingRevenueStreamBreakdownId ;
                        $currentPortfolioLoans['revenue_stream_category_id'] =$revenueCategoryId ;
                        $currentPortfolioLoans['portfolio_loan_type'] ='portfolio';
                        $currentPortfolioLoans['revenue_stream_type'] = $revenueStreamType;
                        $totalPortfolioEndBalance = HArr::sumAtDates([$totalPortfolioEndBalance,$currentPortfolioLoans['endBalance']??[]], $operationDates);
                    
                        $portfolioLoans[]=collect($currentPortfolioLoans)->map(function ($item, $keyName) {
                            if (is_array($item)) {
                                return json_encode($item);
                            }
                            return $item;
                        })->toArray();
                    }
                
                    if ($eclAndNewPortfolioFundingRate && count($totalMonthlyLoanAmounts)) {
                        $newLoanFundingRate = $eclAndNewPortfolioFundingRate->getNewLoansFundingRatesAtYearOrMonthIndex($yearOrMonthIndex);
                        $currentMarginRate = $generalAndReserveAssumption->getBankLendingMarginRatesAtYearOrMonthIndex($yearOrMonthIndex);
                        $currentMonthlyLoanAmount = $totalMonthlyLoanAmounts[$monthIndex];
                        $currentMonthlyLoanAmount = $currentMonthlyLoanAmount * $newLoanFundingRate / 100 ;
                        // $currentMonthlyLoanAmount = $currentMonthlyLoanAmount * $newLoanFundingRate / 100 ;
                        if (is_array($baseRatesMapping)) {
                            $currentPortfolioLoans=$loanService->__calculateBasedOnDiffBaseRates($baseRatesMapping, $loanType, $currentMonth, $currentMonthlyLoanAmount, $currentMarginRate, $tenor, $installmentInterval, $installmentPaymentIntervalValue, $stepUp, $stepInterval, $stepDown, $stepInterval, $gracePeriod, $monthIndex, $dateWithDateIndex, $dateIndexWithDate);
                        } else {
                            $currentPortfolioLoans=$loanService->__calculate([], -1, $loanType, $currentMonth, $currentMonthlyLoanAmount, $baseRatesMapping, $currentMarginRate, $tenor, $installmentInterval, $stepUp, $stepInterval, $stepDown, $stepInterval, $gracePeriod, $monthIndex);
                            $finalResult = $currentPortfolioLoans['final_result']??[];
                            unset($finalResult['totals']);
                            $currentPortfolioLoans = $finalResult;
                
                        }
                        // $loanEndBalances[$leasingRevenueStreamBreakdownId][$monthIndex] = $currentPortfolioLoans['endBalance']??[];
                        if (count($currentPortfolioLoans)) {
                            $currentPortfolioLoans['study_id'] = $studyId ;
                            $currentPortfolioLoans['company_id'] = $companyId ;
                            $currentPortfolioLoans['month_as_index'] = $monthIndex ;
                            $currentPortfolioLoans['revenue_stream_id'] =$leasingRevenueStreamBreakdownId ;
                            $currentPortfolioLoans['revenue_stream_category_id'] =$revenueCategoryId ;
                            $currentPortfolioLoans['portfolio_loan_type'] ='bank_portfolio';
                            $currentPortfolioLoans['revenue_stream_type'] = $revenueStreamType;
                            $portfolioLoans[]=collect($currentPortfolioLoans)->map(function ($item, $keyName) {
                                if (is_array($item)) {
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
     
        $this->recalculateMonthlyAndAccumulatedEcl($revenueStreamType, $totalPortfolioEndBalance);
        // $eclRates = $eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->ecl_rates: [];
        
        // $monthlyEclRates = $study->isMonthlyStudy() ? $eclRates : $this->convertYearToMonthIndexes($eclRates) ;
        // // $loansEnd
        // $monthlyEclValues = [];
        // foreach ($monthlyEclRates as $dateAsIndex => $eclRate) {
        //     $currentMonthPortfolioEndBalance  = $totalPortfolioEndBalance[$dateAsIndex]??0;
        //     $eclRate = $eclRate / 100 ;
        //     $monthlyEclValues[$dateAsIndex] =  $currentMonthPortfolioEndBalance * $eclRate;
        // }
        // $accumulatedEclValues = HArr::accumulateArray($monthlyEclValues);
        // DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('ecl_and_new_portfolio_funding_rates')->where('study_id', $this->id)->where('revenue_stream_type', $revenueStreamType)->update([
        //     'monthly_ecl_values'=>json_encode($monthlyEclValues),
        //     'accumulated_ecl_values'=>json_encode($accumulatedEclValues),
        // ]);
        
    }
   
    protected function sumBaseRateWithMarginRate(array $baseRates, float $marginRate)
    {
        $result = [];
        foreach ($baseRates as $dateAsString => $baseRate) {
            
            $result[$dateAsString] = ($baseRate + $marginRate) / 360 /100 ;
        }
        return $result;
    }
    public function storeVariableLoans(string $revenueStreamType, string $relationName, bool $isSensitivity = false):void
    {
        $loanSchedulePaymentTableName = $isSensitivity ? 'sensitivity_loan_schedule_payments' : 'loan_schedule_payments';
        
        $calculateVariableLoanAtEndService = new CalculateVariableLoanAtEndService ;
        
        $totalMonthlyLoanAmounts = [];
        $totalPortfolioEndBalance = [];
               
        $portfolioLoans = [];
        $studyId  = $this->id ;
        $companyId = $this->company->id ;
        $study = $this ;
        $operationDurationPerYear=$study->getOperationDurationPerYearFromIndexes();
        $loans = $this->{$relationName}->toArray() ;
        $generalAndReserveAssumption = $study->generalAndReserveAssumption;
        $eclAndNewPortfolioFundingRate = $study->getEclAndNewPortfolioFundingRatesForStreamType($revenueStreamType);
         
        // $leasingNewPortfolioFundingRate = $study->{$NewPortfolioFundingRateRelationName};
        // $leasingEcl = $study->{$eclRelationName};
    
        /**
         * @var GeneralAndReserveAssumption $generalAndReserveAssumption
         */
        $dateIndexWithDate = app('dateIndexWithDate');

        $yearIndexWithYear = app('yearIndexWithYear');

        // $baseRates = $generalAndReserveAssumption->getCbeLendingCorridorRates() ;
		$baseRatesMapping = $generalAndReserveAssumption->getBaseRatesPerMonths();
        // $baseRatesPerMonths= [];
        // foreach ($operationDurationPerYear as $yearIndex => $yearMonthIndexes) {
        //     foreach ($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne) {
        //         $yearOrMonthIndex = $this->isMonthlyStudy() ? $monthIndex : $yearIndex;
        //         $baseRatesPerMonths[Carbon::make($dateIndexWithDate[$monthIndex])->format('Y-m-d')] = $baseRates[$yearOrMonthIndex];
        //     }
        // }
        // $dateWithDateIndex = app('dateWithDateIndex');
        DB::connection('non_banking_service')->table($loanSchedulePaymentTableName)->where('revenue_stream_type', $revenueStreamType)->where('study_id', $studyId)->delete();
        // $baseRatesMapping = $baseRatesPerMonths;
        // $baseRatesMapping = HArr::getFirstOfYear($baseRatesPerMonths);
        // $bankLendingMarginRates=$generalAndReserveAssumption->getBankLendingMarginRates();

        
        
        // $baseRatesMapping = HArr::isAllValuesEqual($baseRatesMapping, $bankLendingMarginRates);
   
        // $operationStartDasIndex = $study->getOperationStartDateAsIndex()
        $operationDates = range($study->getOperationStartDateAsIndex(), $study->getStudyEndDateAsIndex());
        
        // $time = 0 ;
        //	$isAtEnd = true ;
        //		$start = microtime(true);
        $CurrentIndex = -1 ;
        foreach ($operationDurationPerYear as $yearIndex => $yearMonthIndexes) {
			//	$originalBaseRates = $baseRatesMapping;
            if (!$this->isMonthlyStudy()) {
				$CurrentIndex++ ;
            }
            foreach ($yearMonthIndexes as $monthIndex => $monthlyZeroOrOne) {
			
				
				$baseRatesMapping = is_array($baseRatesMapping) ? $study->interestYearSpread(HArr::filterByYearIndex($baseRatesMapping, $yearIndexWithYear, $yearIndex, $dateIndexWithDate[$monthIndex], $this->isMonthlyStudy()),$dateIndexWithDate) :  $baseRatesMapping;
                $yearOrMonthIndex = $this->isMonthlyStudy() ? $monthIndex : $yearIndex;
                if ($this->isMonthlyStudy()) {
                    $CurrentIndex++ ;
                }
				
                foreach ($loans as $index => $loanArr) {
					
                    $revenueStreamBreakdownId = $loanArr['id'];
					
					// $baseRatesMapping = $this->convertDateStringToYearIndex($baseRatesMapping);
					//$baseRatesMapping = $study->interestYearSpread($baseRatesMapping,$dateIndexWithDate);
                    $currentMonthlyLoanAmount = $loanArr['loan_amounts'][$CurrentIndex] / ($this->isMonthlyStudy() ? 1 :count($yearMonthIndexes)) ;
                    if ($currentMonthlyLoanAmount <= 0) {
                        continue ;
                    }
					
                    $totalMonthlyLoanAmounts[$monthIndex]  = isset($totalMonthlyLoanAmount[$monthIndex]) ? $totalMonthlyLoanAmount[$monthIndex] +  $currentMonthlyLoanAmount : $currentMonthlyLoanAmount ;
                    
                    $revenueCategoryId = $loanArr['category'];
                    $currentMonth = $dateIndexWithDate[$monthIndex];
                    $currentMonthFormatted = Carbon::make($currentMonth)->format('Y-m-d');
                    $currentMarginRate = $isSensitivity ?  $loanArr['sensitivity_margin_rate'] : $loanArr['margin_rate'];
                    $baseRatePortfolioLoans = is_array($baseRatesMapping) ? $this->sumBaseRateWithMarginRate($baseRatesMapping, $currentMarginRate) : $baseRatesMapping ;
					// $currentBaseRate = $baseRatePortfolioLoans
                    $gracePeriod = 0;
                    $tenor = $loanArr['tenor'];
                    $interestPaymentIntervalName = 'monthly';
                    $installmentPaymentIntervalName = 'monthly';
                    if ($revenueCategoryId == 'monthly-interest-and-quarterly-principle') {
                        $interestPaymentIntervalName = 'monthly';
                        $installmentPaymentIntervalName = 'quartly';
                    } elseif ($revenueCategoryId == 'quarterly-interest-and-principle') {
                        $interestPaymentIntervalName = 'quartly';
                        $installmentPaymentIntervalName = 'quartly';
                    }
                    $stepUp = 0;
                    $stepDown = 0;
                    $stepInterval = 'monthly';
                    $loanType = 'normal';
                    $loanService = $calculateVariableLoanAtEndService ;
                    /**
                     * @var CalculateVariableLoanAtEndService $loanService
                     */
                    // ;
                    $currentPortfolioLoans=[];
                    $currentPortfolioLoans=$loanService->__calculate([], -1, $loanType, $currentMonthFormatted, $currentMonthlyLoanAmount, $baseRatePortfolioLoans, $currentMarginRate, $tenor, $installmentPaymentIntervalName, $interestPaymentIntervalName, $stepUp, $stepInterval, $stepDown, $stepInterval, $gracePeriod, $monthIndex, $dateIndexWithDate);
                        
                    
                    $finalResult = $currentPortfolioLoans['final_result']??[];
                            
                    unset($finalResult['totals']);
                    $currentPortfolioLoans = $finalResult ;
                            
                        
                    if (count($currentPortfolioLoans)) {
                        $currentPortfolioLoans['study_id'] = $studyId ;
                        $currentPortfolioLoans['company_id'] = $companyId ;
                        $currentPortfolioLoans['month_as_index'] = $monthIndex ;
                        $currentPortfolioLoans['revenue_stream_id'] =$revenueStreamBreakdownId ;
                        $currentPortfolioLoans['revenue_stream_category_id'] =$revenueCategoryId ;
                        $currentPortfolioLoans['portfolio_loan_type'] ='portfolio';
                        $currentPortfolioLoans['revenue_stream_type'] =$revenueStreamType;
                        $totalPortfolioEndBalance = HArr::sumAtDates([$totalPortfolioEndBalance,$currentPortfolioLoans['endBalance']??[]], $operationDates);
                        $portfolioLoans[]=collect($currentPortfolioLoans)->map(function ($item, $keyName) {
                            if (is_array($item)) {
                                return json_encode($item);
                            }
                            return $item;
                        })->toArray();
                    }
                    if ($eclAndNewPortfolioFundingRate && count($totalMonthlyLoanAmounts)) {
                        $newLoanFundingRate = $eclAndNewPortfolioFundingRate->getNewLoansFundingRatesAtYearOrMonthIndex($yearOrMonthIndex);

                        $currentMarginRate = $generalAndReserveAssumption->getBankLendingMarginRatesAtYearOrMonthIndex($yearOrMonthIndex);
                    
                    
                        $currentMonthlyLoanAmount = $totalMonthlyLoanAmounts[$monthIndex];
                        $currentMonthlyLoanAmount = $currentMonthlyLoanAmount * $newLoanFundingRate / 100 ;
                        $baseRateBankPortfolioLoans = is_array($baseRatesMapping) ? $this->sumBaseRateWithMarginRate($baseRatesMapping, $currentMarginRate) : $baseRatesMapping ;
                            
                        $currentPortfolioLoans=$loanService->__calculate([], -1, $loanType, $currentMonthFormatted, $currentMonthlyLoanAmount, $baseRateBankPortfolioLoans, $currentMarginRate, $tenor, $installmentPaymentIntervalName, $interestPaymentIntervalName, $stepUp, $stepInterval, $stepDown, $stepInterval, $gracePeriod, $monthIndex, $dateIndexWithDate);
                        $finalResult = $currentPortfolioLoans['final_result']??[];
                        unset($finalResult['totals']);
                        $currentPortfolioLoans = $finalResult;
                        
                        if (count($currentPortfolioLoans)) {
                            $currentPortfolioLoans['study_id'] = $studyId ;
                            $currentPortfolioLoans['company_id'] = $companyId ;
                            $currentPortfolioLoans['month_as_index'] = $monthIndex ;
                            $currentPortfolioLoans['revenue_stream_id'] =$revenueStreamBreakdownId ;
                            $currentPortfolioLoans['revenue_stream_category_id'] =$revenueCategoryId ;
                            $currentPortfolioLoans['portfolio_loan_type'] ='bank_portfolio';
                            $currentPortfolioLoans['revenue_stream_type'] = $revenueStreamType;
                            $portfolioLoans[]=collect($currentPortfolioLoans)->map(function ($item, $keyName) {
                                if (is_array($item)) {
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
        $this->refresh();
    
        // $eclTableName = ($eclAndNewPortfolioFundingRate)->getTable();
        $this->recalculateMonthlyAndAccumulatedEcl($revenueStreamType, $totalPortfolioEndBalance);
        
      
        
    }
	// public function refreshEclAfterSecuritizations():array 
	// {
	// 	LoanSchedulePayment::where('study_id',)
	// }
    public function recalculateMonthlyAndAccumulatedEcl(string $revenueStreamType, array $totalPortfolioEndBalance )
    {
        $eclAndNewPortfolioFundingRate = $this->getEclAndNewPortfolioFundingRatesForStreamType($revenueStreamType);
        if (!$eclAndNewPortfolioFundingRate) {
            return ;
        }
        $eclRates = $eclAndNewPortfolioFundingRate->ecl_rates;
        $monthlyEclRates = $this->isMonthlyStudy() ? $eclRates : $this->convertYearToMonthIndexes($eclRates) ;

        // $loansEnd
        $monthlyEclValues = [];
        $previousAccumulated = 0 ;
        $accumulatedEclValues =[];
        foreach ($monthlyEclRates as $dateAsIndex => $eclRate) {
            $currentMonthPortfolioEndBalance  = $totalPortfolioEndBalance[$dateAsIndex]??0;
            $eclRate = $eclRate / 100 ;
            $monthlyEclValues[$dateAsIndex] =  $currentMonthPortfolioEndBalance * $eclRate - $previousAccumulated;
            $accumulatedEclValues[$dateAsIndex] = $monthlyEclValues[$dateAsIndex]+ ($accumulatedEclValues[$dateAsIndex-1]??0);
            $previousAccumulated = $accumulatedEclValues[$dateAsIndex];
        }
        DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('ecl_and_new_portfolio_funding_rates')->where('revenue_stream_type', $revenueStreamType)->where('study_id', $this->id)->update([
            'monthly_ecl_values'=>json_encode($monthlyEclValues),
            'accumulated_ecl_values'=>json_encode($accumulatedEclValues),
        ]);
        
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
        return $this->getStudyDurationPerMonth($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber, true, false);
        
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
        if ($financialYearStartMonthName =='january') {
            return 12;
        }
        if ($financialYearStartMonthName =='april') {
            return 3;
        }
        if ($financialYearStartMonthName =='july') {
            return 6;
        }
        
    }
    /*
    * * type -> manpower for example
    * * expense_type -> cost-of-service for example
    */

    
    
    public static function getProjectionTitles()
    {
        return [
            'all'=>__('All'),
            self::DIRECT_FACTORING=>__('Direct Factoring'),
            self::IJARA=>__('Ijara'),
            self::LEASING=>__('Leasing'),
            self::REVERSE_FACTORING=>__('Reverse Factoring'),
            self::PORTFOLIO_MORTGAGE=>__('Portfolio Mortgage'),
            self::MICROFINANCE => __('Microfinance')
        ];
    }
    
    public function getStudyDurationPerYearFromIndexes()
    {
        $datesAsStringAndIndex = $this->getDatesAsStringAndIndex();
        $datesIndexWithYearIndex = App('datesIndexWithYearIndex');
        $yearIndexWithYear = App('yearIndexWithYear');
        $dateIndexWithDate = App('dateIndexWithDate');
        $dateWithMonthNumber = App('dateWithMonthNumber');
        return $this->getStudyDurationPerMonth($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber, false);
        
    }
    public function updateExpensesPercentagesOfSales(bool $isSensitivity = false)
    {
		  $dateIndexWithDate = $this->getDateIndexWithDate();
		  $dateWithDateIndex = $this->getDateWithDateIndex();
      	  $this->generateRelationDynamically('percentage_of_sales', 'Expense')->each(function ($expense) use ($isSensitivity,$dateIndexWithDate,$dateWithDateIndex) {
            $expenseAsPercentageEquation = new ExpenseAsPercentageEquation;
            $customCollectionPolicy = $expense->custom_collection_policy?:[];
            $datesAsStringDateIndex = $this->getDatesAsStringAndIndex();
            $datesAsIndexAndString = array_flip($datesAsStringDateIndex);
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
            $expenseAsPercentageResults = $expenseAsPercentageEquation->calculate($this->id, $percentageOf, $revenueStreamTypes, $streamCategoryIds, $startDateAsIndex, $endDateAsIndex, $monthlyPercentage, $paymentTerms, $vatRate, $isDeductible, $withholdTaxRate, $isSensitivity);
            
            $tableDataArr['sensitivity_expense_as_percentages']=$expenseAsPercentageResults['total_before_vat'];
            $tableDataArr['expense_as_percentages']  =$expenseAsPercentageResults['total_before_vat']  ;
            $tableDataArr['total_vat']  =$expenseAsPercentageResults['total_vat']  ;
            $tableDataArr['total_after_vat']  =$expenseAsPercentageResults['total_after_vat']  ;
            $withholdAmounts  = $expenseAsPercentageResults['total_withhold'];
            $tableDataArr['payment_amounts'] = $this->calculateCollectionOrPaymentAmounts($paymentTerms, $tableDataArr['total_after_vat'], $datesAsIndexAndString, $customCollectionPolicy) ;
            $payments = $this->calculateCollectionOrPaymentAmounts($paymentTerms, $tableDataArr['total_after_vat'], $datesAsIndexAndString, $customCollectionPolicy) ;
            $withholdPayments = $this->calculateCollectionOrPaymentAmounts($paymentTerms, $withholdAmounts, $datesAsIndexAndString, $customCollectionPolicy) ;
            $netPaymentsAfterWithhold = HArr::subtractAtDates([$payments,$withholdPayments], $dateWithDateIndex);
            $tableDataArr['withhold_amounts'] = $withholdAmounts ;
            $tableDataArr['withhold_payments']=$withholdPayments;
            $tableDataArr['payment_amounts'] = $payments;
            $tableDataArr['net_payments_after_withhold']=$netPaymentsAfterWithhold;
			$tableDataArr['withhold_statements']=$this->calculateWithholdStatement($withholdPayments , 0 , $dateIndexWithDate);
            $tableDataArr['collection_statements']   =$this->calculateStatement($tableDataArr['expense_as_percentages'], $tableDataArr['total_vat'], $netPaymentsAfterWithhold, $withholdPayments, $dateIndexWithDate, $this);
            $expense->update($tableDataArr);
        });
    }
    public function calculateStatement(array $expenses, array $vats, array $netPaymentsAfterWithhold, array $withholdPayments, array $dateIndexWithDate, Study $study, float $beginningBalance = 0)
    {
        $expensesForIntervals = [
            'monthly'=>$expenses,
            'quarterly'=>sumIntervalsIndexes($expenses, 'quarterly', $study->financialYearStartMonth(), $dateIndexWithDate),
            'semi-annually'=>sumIntervalsIndexes($expenses, 'semi-annually', $study->financialYearStartMonth(), $dateIndexWithDate),
            'annually'=>sumIntervalsIndexes($expenses, 'annually', $study->financialYearStartMonth(), $dateIndexWithDate),
        ];
        $netPaymentAfterWithholdForInterval = [
            'monthly'=>$netPaymentsAfterWithhold,
            'quarterly'=>sumIntervalsIndexes($netPaymentsAfterWithhold, 'quarterly', $study->financialYearStartMonth(), $dateIndexWithDate),
            'semi-annually'=>sumIntervalsIndexes($netPaymentsAfterWithhold, 'semi-annually', $study->financialYearStartMonth(), $dateIndexWithDate),
            'annually'=>sumIntervalsIndexes($netPaymentsAfterWithhold, 'annually', $study->financialYearStartMonth(), $dateIndexWithDate),
        ];
        
        $result = [];
        foreach (getIntervalFormatted() as $intervalName=>$intervalNameFormatted) {
            $beginningBalance = 0;
            foreach ($expensesForIntervals[$intervalName] as $dateIndex=>$currentExpenseValue) {
                $date = $dateIndex;
                $result[$intervalName]['beginning_balance'][$date] = $beginningBalance;
                $currentVat = $vats[$date]??0 ;
                $totalDue[$date] =  $currentExpenseValue+$currentVat+$beginningBalance;
                $paymentAtDate = $netPaymentAfterWithholdForInterval[$intervalName][$date]??0 ;
                $withholdPaymentAtDate = $withholdPayments[$date]?? 0 ;
                $endBalance[$date] = $totalDue[$date] - $paymentAtDate  - $withholdPaymentAtDate ;
                $beginningBalance = $endBalance[$date] ;
                $result[$intervalName]['expense'][$date] =  $currentExpenseValue ;
                $result[$intervalName]['vat'][$date] =  $currentVat ;
                $result[$intervalName]['total_due'][$date] = $totalDue[$date];
                $result[$intervalName]['payment'][$date] = $paymentAtDate;
                $result[$intervalName]['withhold_amount'][$date] = $withholdPaymentAtDate;
                $result[$intervalName]['end_balance'][$date] =$endBalance[$date];
            }
        }
        return $result;
    
        
    }
    public function calculateManpowerResult(array $dateAsIndexes, int $existingCount, array $hiringCounts, int $studyStartIndex, float $monthlyNetSalary, float $salaryTaxesRate, float $socialInsuranceRate)
    {
        $yearWithItsIndexes = $this->getOperationDurationPerYearFromIndexesForAllStudyInfo();
        $monthsWithItsYear = $this->getMonthsWithItsYear($yearWithItsIndexes) ;
        $generalAndReserveAssumption = $this->generalAndReserveAssumption;
        $isYearsStudy = !$this->isMonthlyStudy();
        $currentIndex = 0 ;
        $currentSalaryAtMonthIndex = $monthlyNetSalary ;
        $accumulatedManpowerCounts = [];
        $monthlySalariesPayments = [];
        $salaryExpenses =[];
        foreach ($dateAsIndexes as $dateAsIndex) {
            if (!isset($hiringCounts[$dateAsIndex])) {
                continue;
            }
            $currentYearOrMonthIndex = $isYearsStudy ? $monthsWithItsYear[$dateAsIndex] : $dateAsIndex  ;
            $annualIncreaseRate = $generalAndReserveAssumption  ? $generalAndReserveAssumption->getSalariesAnnualIncreaseRateAtYearOrMonthIndex($currentYearOrMonthIndex) : 0 ;
            
            $previousHiringCount = $accumulatedManpowerCounts[$dateAsIndex-1] ?? $existingCount;
            $accumulatedManpowerCounts[$dateAsIndex] = $hiringCounts[$dateAsIndex] + $previousHiringCount   ;
            if ($currentIndex%12==0 && $currentIndex != 0) {
                $currentSalaryAtMonthIndex = $currentSalaryAtMonthIndex * (1+($annualIncreaseRate/100)) ;
            }
            $monthlySalariesPayments[$dateAsIndex] = $currentSalaryAtMonthIndex * $accumulatedManpowerCounts[$dateAsIndex];
            $salaryExpenses[$dateAsIndex] = $currentSalaryAtMonthIndex * $accumulatedManpowerCounts[$dateAsIndex] / (1 - ($salaryTaxesRate + $socialInsuranceRate));
            $currentIndex++;
            
        }
        
        /**
        * * To Calculate Payment Statement
        */
        $salaryTaxAndSocialInsuranceAmounts = HArr::MultiplyWithNumber($salaryExpenses, ($salaryTaxesRate+$socialInsuranceRate));
        $dateIndexWithDate = array_flip($dateAsIndexes);
        $salaryTaxAndSocialInsuranceAmountsPayment= (new CollectionPolicyService())->applyMultiCustomizedCollectionPolicy([30=>100], $salaryTaxAndSocialInsuranceAmounts);
        $salaryTaxAndSocialInsuranceAmountsStatement = ManPower::calculateStatement($salaryTaxAndSocialInsuranceAmounts, [], $salaryTaxAndSocialInsuranceAmountsPayment, [], $dateIndexWithDate);
    
        /**
         * * End Calculate
         */
        return [
            'accumulated_manpower_counts'=>$accumulatedManpowerCounts,
            'salary_expenses'=>$salaryExpenses,
            'salary_payments'=>$monthlySalariesPayments,
            'tax_and_social_insurance_statement'=>$salaryTaxAndSocialInsuranceAmountsStatement
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
        $dateAsIndexes = $this->getDateWithDateIndex();
        foreach ($positions as $position) {
            $positionArr = [];
            $hiringCounts = $position->getHiringCounts();
            $currentExistingCount = $position->getExistingCount();
            $monthlyNetSalary = $position->getMonthlyNetSalary();
            $additionalDatabaseResult =  $this->calculateManpowerResult($dateAsIndexes, $currentExistingCount, $hiringCounts, $operationStartDateAsIndex, $monthlyNetSalary, $salaryTaxesRate, $socialInsuranceRate);
            foreach ($additionalDatabaseResult as $columnName => $payload) {
                $positionArr[$columnName] = $payload;
            }
            $position->update($positionArr);
        }
        
        
    }

    public function getLeasingGrowthRateAtYearOrMonthIndex(int $yearOrMonthIndex)
    {
        return $this->leasing_growth_rates[$yearOrMonthIndex] ?? 0  ;
    }
    public function getFinancialYearsEndMonths():array
    {
        $studyStartDateMonth = $this->getStudyStartDate();
        $studyStartDateMonth = explode('-', $studyStartDateMonth)[1];
        $financialEndMonth = $this->getFinancialYearEndMonthNumber();
        $firstYearEndMonth  = $financialEndMonth - $studyStartDateMonth ;
        if ($firstYearEndMonth<0) {
            $firstYearEndMonth  = $firstYearEndMonth+12 ;
        }
        $result = [];
        for ($i = 0 ; $i<11 ; $i++) {
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
        // $dateIndexWithDates = app()->make('dateIndexWithDate');
         $dateIndexWithDates = app()->make('dateIndexWithDate');
        $monthsIndexes = array_keys($this->getMonthlyIndexes());
        $result = [];
        $totalPortfolioEndBalance = [];
        foreach ($this->refresh()->directFactoringBreakdowns as $directFactoringBreakdown) {
            $isFirstLoop = true ;
            $totalDuesAtMonths =[];
            /**
             * @var DirectFactoringBreakdown $directFactoringBreakdown
             */
            $directFactoringBreakdownId = $directFactoringBreakdown->id ;
            $amountAsPayload = $directFactoringBreakdown->getLoanAmountPayload();
            $currentMarginRate = $directFactoringBreakdown->getMarginRate();
            $category = $directFactoringBreakdown->getCategory();

            $directFactoringAmounts = $this->isMonthlyStudy() ? $amountAsPayload :  $this->convertYearToMonthIndexesAndDivideBySumMonths($amountAsPayload);
            $baseRates = $this->isMonthlyStudy() ? $baseRates : $this->convertYearToMonthIndexes($baseRates);
            $currentBeginningBalance = 0 ;
            $currentDirectFactoringBankBeginningBalance= 0 ;
     //       $currentBankInterestExpensePayment= 0 ;
            $factoringInterestRevenue = [];
            $directFactoringStatements[$directFactoringBreakdownId] = [];
            $directFactoringNetFundingAmounts = [];
            
            $directFactoringBankLoanStatements = [];
            $currentDirectFactoringBeginningBalance = 0 ;
            foreach ($directFactoringAmounts as $monthIndex => $currentDirectAmount) {
                
                $currentYearIndex = $datesIndexWithYearIndex[$monthIndex];
                $currentYearOrMonthIndex = $this->isMonthlyStudy() ? $monthIndex : $currentYearIndex;
               // $currentDaysInMonth = 30;
                    $currentDateAsString = $dateIndexWithDates[$monthIndex];
                 $currentDaysInMonth = Carbon::make($currentDateAsString)->daysInMonth;
                $currentBaseRate = $baseRates[$monthIndex];
                $currentBankMarginRate = $this->isMonthlyStudy() ? $bankMarginRates[$monthIndex] : $bankMarginRates[$currentYearIndex];
                $bankInterestRate = ($currentBaseRate + $currentBankMarginRate)/100  ;
                $currentDailyPricing = ($currentMarginRate  + $currentBaseRate) /100 / 360;
				
				// $allll[$monthIndex] = $bankInterestRate;
                $directFactoringStatements[$directFactoringBreakdownId]['beginning_balance'][$monthIndex] = $currentDirectFactoringBeginningBalance + $currentDirectAmount ;
                $directFactoringStatements[$directFactoringBreakdownId]['direct_factoring_settlements'][$monthIndex +  ceil($category/30) ] = $currentDirectAmount;
                $currentMonthSettlement = $directFactoringStatements[$directFactoringBreakdownId]['direct_factoring_settlements'][$monthIndex] ?? 0;
                $directFactoringStatements[$directFactoringBreakdownId]['end_balance'][$monthIndex] = $currentDirectFactoringBeginningBalance + $currentDirectAmount - $currentMonthSettlement ;
                $currentDirectFactoringBeginningBalance = $directFactoringStatements[$directFactoringBreakdownId]['end_balance'][$monthIndex] ;
                $unearned = [];
				
                foreach (HArr::getMonthsAsArray($category) as $index => $currentMonthNumber) {
					
                    $currentIndex = $monthIndex+$index
					// +1
					 ;
                    $currentAmount = $currentDirectAmount * $currentMonthNumber  * $currentDailyPricing  ;
                    $result[$directFactoringBreakdownId][$currentIndex] = isset($result[$directFactoringBreakdownId][$currentIndex]) ? $result[$directFactoringBreakdownId][$currentIndex]+($currentAmount) : $currentAmount;
                    $interestRevenues[$currentIndex] = $result[$directFactoringBreakdownId][$currentIndex] ;
                    $unearned[$monthIndex] = isset($unearned[$monthIndex]) ? $unearned[$monthIndex] + $currentAmount : $currentAmount;
                }
                $factoringInterestRevenue[$directFactoringBreakdownId]['beginning_balance'][$monthIndex] = $currentBeginningBalance;
                foreach ($interestRevenues as $i => $value) {
                    $factoringInterestRevenue[$directFactoringBreakdownId]['interest_revenue'][$i] =
                    $value;
                }
                $factoringInterestRevenue[$directFactoringBreakdownId]['unearned_interest'][$monthIndex] = $unearned[$monthIndex];
                $currentDirectFactoringNetFundingAmounts  = $currentDirectAmount -  $unearned[$monthIndex] ;
                $directFactoringNetFundingAmounts[$directFactoringBreakdownId][$monthIndex] = $currentDirectFactoringNetFundingAmounts ;
                $eclAndNewPortfolioFundingRate = $this->getEclAndNewPortfolioFundingRatesForStreamType(Study::DIRECT_FACTORING);
                if ($eclAndNewPortfolioFundingRate) {
                    $newLoanFundingRate = (100 - $eclAndNewPortfolioFundingRate->getEquityFundingRatesAtYearOrMonthIndex($currentYearOrMonthIndex))/100 ;
                    $currentBankLoanAmount = $currentDirectFactoringNetFundingAmounts * $newLoanFundingRate;
                    $directFactoringBankLoanStatements[$directFactoringBreakdownId]['beginning_balance'][$monthIndex] = $currentDirectFactoringBankBeginningBalance ;
                    $directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_amounts'][$monthIndex] = $currentBankLoanAmount;
                    $directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_settlements'][$monthIndex +  ceil($category/30) ] = $currentBankLoanAmount;
                    $currentBankLoanSettlementAtCurrentMonth = $directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_settlements'][$monthIndex]??0;
                    $totalDues = $currentDirectFactoringBankBeginningBalance + $currentBankLoanAmount - $currentBankLoanSettlementAtCurrentMonth
                    // - $currentBankInterestExpensePayment
                    ;
					$interestExpensePayment = $totalDues * $currentDaysInMonth * $bankInterestRate  / 360 ;
                    $directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense_payments'][$monthIndex] = $interestExpensePayment;
					
                    $totalDuesAtMonths[$monthIndex+1] =  $totalDues ;
					
                 //   $directFactoringBankLoanStatements[$directFactoringBreakdownId]['total_dues'][$monthIndex] =  $totalDuesAtMonths[$monthIndex];
               //     $isFirstLoop = false ;
                    $interestExpense = $totalDues * $currentDaysInMonth * $bankInterestRate  / 360 ;
					
				
                  
                    $directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense'][$monthIndex] = $interestExpense;
				
            //        $currentBankInterestExpensePayment = $interestExpensePayment;
                    $endBalance = $totalDues
// + $interestExpense
                    ;
                    $directFactoringBankLoanStatements[$directFactoringBreakdownId]['end_balance'][$monthIndex] = $endBalance;
                    $currentDirectFactoringBankBeginningBalance = $endBalance ;
                            
                }
                        
                        
                $currentInterestRevenueAtMonthIndex = $factoringInterestRevenue[$directFactoringBreakdownId]['interest_revenue'][$monthIndex]??0;
                $currentEndBalance = $currentBeginningBalance + $currentInterestRevenueAtMonthIndex - $factoringInterestRevenue[$directFactoringBreakdownId]['unearned_interest'][$monthIndex]  ;
                $factoringInterestRevenue[$directFactoringBreakdownId]['end_balance'][$monthIndex] =   $currentEndBalance;
                        
                $currentBeginningBalance = $currentEndBalance ;
            }
            $portfolioStatementEndBalance = $directFactoringStatements[$directFactoringBreakdownId]['end_balance']??[];
            
            $totalPortfolioEndBalance = HArr::sumAtDates([$totalPortfolioEndBalance , $portfolioStatementEndBalance], $monthsIndexes);
            
            $directFactoringBreakdown->update([
                'beginning_balance' => $factoringInterestRevenue[$directFactoringBreakdownId]['beginning_balance'],
                'interest_revenue' => $factoringInterestRevenue[$directFactoringBreakdownId]['interest_revenue'],
                'unearned_interest' => $factoringInterestRevenue[$directFactoringBreakdownId]['unearned_interest'],
                'end_balance' => $factoringInterestRevenue[$directFactoringBreakdownId]['end_balance'],
                'net_funding_amounts'=>$directFactoringNetFundingAmounts[$directFactoringBreakdownId],
                'statement_beginning_balance'=>$directFactoringStatements[$directFactoringBreakdownId]['beginning_balance'],
                'direct_factoring_amounts'=>$directFactoringAmounts,
                'direct_factoring_settlements'=>$directFactoringStatements[$directFactoringBreakdownId]['direct_factoring_settlements'],
                'statement_end_balance'=>$portfolioStatementEndBalance,
                'bank_beginning_balance'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['beginning_balance']??[],
                'bank_loan_amounts'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_amounts']??[],
                'bank_loan_settlements'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['loan_settlements']??[],
                'bank_interest_expense_payments'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense_payments']??[],
                'bank_total_dues'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['total_dues']??[],
                'bank_interest_expense'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['interest_expense']??[],
                'bank_end_balance'=>$directFactoringBankLoanStatements[$directFactoringBreakdownId]['end_balance']??[],
                ]);
                
        }
        $this->recalculateMonthlyAndAccumulatedEcl(Study::DIRECT_FACTORING, $totalPortfolioEndBalance);
    }
    public static function getTitleForBreakdown(string $relationName):string
    {
        return [
            'reverseFactoringBreakdowns'=>__('Reverse Factoring Breakdowns'),
            'leasingRevenueStreamBreakdown'=>__('Leasing Revenue Stream Breakdown'),
            'ijaraMortgageBreakdowns'=>__('Ijara Mortgage Breakdowns')
        ][$relationName];
    }
    public function calculateMonthlyAdminFeesAmounts(string $revenueStreamType, array $adminFeesRates, array $loanAmounts, array $occurrenceDates = []):array
    {
        $operationDurationPerYear  = $this->getOperationDurationPerYearFromIndexes() ;
        $isPortfolio = $revenueStreamType == Study::PORTFOLIO_MORTGAGE;
        $currentAdminFeesAmountsAtMonthIndex = [];
        foreach ($adminFeesRates as $currentYearOrMonthIndex => $currentAdminFeesRateAtYearIndex) {
            $currentLoanAmountAtYearOrMonthIndex =  $loanAmounts[$currentYearOrMonthIndex] ;
            
            $activeMonths = $this->isMonthlyStudy() ? [$currentYearOrMonthIndex=>1] : $operationDurationPerYear[$currentYearOrMonthIndex] ;
            $activeMonthsCount = $this->isMonthlyStudy() ?  1 : count($operationDurationPerYear[$currentYearOrMonthIndex]);
            $currentMonthlyLoanAmount = $currentLoanAmountAtYearOrMonthIndex / $activeMonthsCount ;
            foreach ($activeMonths as $monthIndex => $monthlyZeroOrOne) {
                if ($isPortfolio) {
                    $currentMonthlyLoanAmount = in_array($monthIndex, $occurrenceDates) ? $currentLoanAmountAtYearOrMonthIndex : 0 ;
                }
                $currentAdminFeesAmountsAtMonthIndex[$monthIndex] =  $currentMonthlyLoanAmount * $currentAdminFeesRateAtYearIndex /100 ;
            }
        }
        return $currentAdminFeesAmountsAtMonthIndex;
    }
   
    public function sumLeasingLoanAmounts():array
    {
        $total = [];
        foreach ($this->leasingRevenueStreamBreakdown?:[] as $breakdown) {
			// dd($breakdown);
            $loanAmountArr = $breakdown->loan_amounts;
            foreach ($loanAmountArr as $monthOrYearIndex => $value) {
                $total[$monthOrYearIndex] = isset($total[$monthOrYearIndex]) ? $total[$monthOrYearIndex] + $value : $value;
            }
            
        }
        return $total ;
    }
    public function getPortfolioMortgageTotalLoanAmounts():array
    {
        $result = [];
        foreach ($this->portfolioMortgageRevenueProjectionByCategories as $portfolioMortgageRevenueProjectionByCategory) {
            $currentRow = (array)$portfolioMortgageRevenueProjectionByCategory->portfolio_mortgage_transactions_projections;
            foreach ($currentRow as $dateOrYearIndex => $value) {
                $result[$dateOrYearIndex] = isset($result[$dateOrYearIndex]) ? $result[$dateOrYearIndex] + $value : $value;
            }
            
        }
        return $result;
    }
    public function getTotalMicrofinanceMonthlyLoanAmounts():array
    {
        $result = [];
        foreach ($this->microfinanceProductSalesProjects as $microfinanceProductSalesProject) {
            foreach ($microfinanceProductSalesProject->monthly_loan_amounts?:[] as $dateAsIndex => $value) {
                $result[$dateAsIndex] = isset($result[$dateAsIndex]) ? $result[$dateAsIndex] + $value : $value ;
            }
        }
        
        return $result;
    }
    public function getLoanAmountForAdminFeesForRevenueStreamType(string $revenueStreamType):array
    {
        $this->refresh();
        return [
            self::LEASING=>$this->sumLeasingLoanAmounts(),
            self::REVERSE_FACTORING=>$this->reverseFactoringRevenueProjectionByCategory ? $this->reverseFactoringRevenueProjectionByCategory->getReverseFactoringTransactionProjection() : [],
            self::IJARA=>$this->ijaraMortgageRevenueProjectionByCategory ? $this->ijaraMortgageRevenueProjectionByCategory->getIjaraMortgageTransactionProjection() : [],
            self::DIRECT_FACTORING=>$this->directFactoringRevenueProjectionByCategory ? $this->directFactoringRevenueProjectionByCategory->getDirectFactoringTransactionProjection() : [],
            self::PORTFOLIO_MORTGAGE => $this->portfolioMortgageRevenueProjectionByCategories->count() ? $this->getPortfolioMortgageTotalLoanAmounts() : [],
            self::MICROFINANCE => $this->microfinanceProductSalesProjects->count() ? $this->getTotalMicrofinanceMonthlyLoanAmounts() : []
        ][$revenueStreamType];
    }
  
    /**
     * * بتديلها
     * * array
     * * فيه الاندكس بتاع كل سنه وبترجعهالك مفرودة شهور
     *
     */
    public function convertYearlyArrayToMonthly(array $yearlyArrayItems, array $yearWithItsIndexes = null):array
    {
        $result = [];
        $yearWithItsIndexes = is_null($yearWithItsIndexes) ? $this->getOperationDurationPerYearFromIndexes() :$yearWithItsIndexes ;
        $monthsWithItsYear = $this->getMonthsWithItsYear($yearWithItsIndexes) ;
        foreach ($yearWithItsIndexes as $currentYearIndex => $months) {
            foreach ($months as $currentMonthIndex => $isActive) {
                $currentYearAsIndex =$monthsWithItsYear[$currentMonthIndex];
                $valueAtCurrentYearIndex = $yearlyArrayItems[$currentYearAsIndex] ?? 0;
                $result[$currentMonthIndex] = $valueAtCurrentYearIndex;
            }
        }
        return $result;
        
    }
    public function getMicrofinanceBranchesCount():int
    {
        return $this->microfinance_branches_count?:0;
    }
    public function getMicrofinanceLoanOfficerCount():int
    {
        return $this->microfinance_loan_officer_count?:0;
    }
    public function getConsumerfinanceBranchesCount():int
    {
        return $this->consumerfinance_branches_count?:0;
    }
    public function getConsumerfinanceLoanOfficerCount():int
    {
        return $this->consumerfinance_loan_officer_count?:0;
    }
    public function fixedAssets():HasMany
    {
        return $this->hasMany(FixedAsset::class, 'study_id', 'id');
    }
  
    public function generalFixedAssetsFundingStructure():HasOne
    {
        return $this->hasOne(FixedAssetsFundingStructure::class, 'study_id', 'id')->where('fixed_asset_type', FixedAsset::FFE);
    }
    public function newBranchFixedAssetsFundingStructure():HasOne
    {
        return $this->hasOne(FixedAssetsFundingStructure::class, 'study_id', 'id')->where('fixed_asset_type', FixedAsset::NEW_BRANCH);
    }
    public function perEmployeeFixedAssetsFundingStructure():HasOne
    {
        return $this->hasOne(FixedAssetsFundingStructure::class, 'study_id', 'id')->where('fixed_asset_type', FixedAsset::PER_EMPLOYEE);
    }
    // public function fixedAssetsFundingStructures():HasMany
    // {
    // 	return $this->hasMany(FixedAssetsFundingStructure::class,'study_id','id');
    // }
    
    public function getDateIndexWithDate():array
    {
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        return $datesAndIndexesHelpers['dateIndexWithDate'];
        ;
    }
    public function getMonthIndexWithMonthNumber():array
    {
        $result = [];
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        $dateWithDateIndex = $datesAndIndexesHelpers['dateWithDateIndex'];
        foreach ($datesAndIndexesHelpers['dateWithMonthNumber'] as $dateAsString => $dateAsNumber) {
            $dateAsIndex = $dateWithDateIndex[$dateAsString];
            $result[$dateAsIndex] = $dateAsNumber;
        }
        return $result;
    }
   
    public function recalculateFixedAssets(string $fixedAssetType, bool $isSensitivity = false)
    {
        $loanTableName = $isSensitivity ? 'sensitivity_loan_schedule_payments' : 'fixed_assets_loan_schedule_payments';
        $studyEndDateAsIndex = $this->getStudyEndDateAsIndex();
        $calculateFixedLoanAtEndService = new CalculateFixedLoanAtEndService();
        $projectUnderProgressService = new ProjectsUnderProgress();
        $datesAsStringAndIndex = $this->getDateWithDateIndex();
        $dateIndexWithDate = $this->getDateIndexWithDate();
        $dateWithDateIndex = $this->getDateWithDateIndex();
        $operationStartDateFormatted = $this->getOperationStartDateFormatted();
        $datesIndexWithYearIndex = $this->getDatesIndexWithYearIndex();
        $dateWithMonthNumber = $this->getDateWithMonthNumber();
        $operationStartDateAsIndex = $this->getOperationStartDateAsIndex($datesAsStringAndIndex, $operationStartDateFormatted);
        $yearIndexWithYear = $this->getYearIndexWithYear();
        $studyDurationPerYear = $this->getStudyDurationPerYear($datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber, true, true, false);
        $studyDates=$this->getOnlyDatesOfActiveStudy($studyDurationPerYear, $dateIndexWithDate);
        $fixedAssets = $this->fixedAssets->where('type', $fixedAssetType) ;
        DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table($loanTableName)->where('fixed_asset_type', $fixedAssetType)->where('study_id', $this->id)->delete();
        $studyDates = $this->getCalculatedExtendedStudyDates();
       

        foreach ($fixedAssets as $fixedAsset) {
            $totalFfePayable = [];
            $totalFfeAssetItems = [];
            $totalFfeExecutionAndPayment = [];
            $totalFfeLoanWithdrawalEndBalance = [];
            $totalLoanCapitalizedInterest = [];
            $totalProjectUnderProgressFFE = [];
            $totalMonthlyDepreciation = [];
            $totalFfeEquityPayment = [];
            $totalFfePayment = [];
            $totalFfeLoanWithdrawal = [];
            $totalIncomeStatementLoanCapitalizedInterests = [];
            $fixedAssetCounts = $fixedAsset->getCounts();
            $sumKeys = array_keys($fixedAssetCounts);
            
            foreach ($studyDates as $currentDateAsIndex) {
        
                $count = $fixedAssetCounts[$currentDateAsIndex]??0;
                $totalFixedAssetAmount = $fixedAsset->getTotalItemCostAtDateIndex($currentDateAsIndex);
                
                if ($count == 0) {
                    continue ;
                }
                // $totalFixedAssetAmount = $count* $fixedAssetAmount ;
                // $totalFixedAssetAmount = (1+$contingencyRate) * $totalFixedAssetAmount ;
            
                // $totalFFECosts[$dateAsIndex] = isset($totalFFECosts[$dateAsIndex]) ? $totalFFECosts[$dateAsIndex] + $totalFixedAssetAmount : $totalFixedAssetAmount;
                $fixedAssetStartDateAsIndex= $currentDateAsIndex;
                $fixedAssetEndDateAsIndex= $fixedAssetStartDateAsIndex;
                $fixedAssetCalculationResultArr = $calculateFixedLoanAtEndService->calculateExecutionAndPaymentAndLoan($fixedAssetType, $currentDateAsIndex, $totalFixedAssetAmount, $fixedAssetEndDateAsIndex, $fixedAsset);
				// dd($fixedAssetCalculationResultArr);

                
                $loanCapitalizedInterest = $fixedAssetCalculationResultArr['ffeLoanWithdrawalInterest'];
        
                $totalLoanCapitalizedInterest = HArr::sumAtDates([$totalLoanCapitalizedInterest,$loanCapitalizedInterest], $sumKeys);

                $loanArr = $fixedAssetCalculationResultArr['ffeLoanCalculations'] ?? [];
                $ffeEquityPayment = $fixedAssetCalculationResultArr['ffeEquityPayment']['FFE Equity Injection'] ?? [];
                $ffeLoanWithdrawal = $fixedAssetCalculationResultArr['ffeLoanWithdrawal']['FFE Loan Withdrawal'] ?? [];
                $ffePayment = $fixedAssetCalculationResultArr['contractPayments']['FFE Payment'] ?? [];
                $totalFfePayment = HArr::sumAtDates([$totalFfePayment,$ffePayment], $sumKeys);
                if (count($loanArr)) {
                    $loanArr['study_id'] = $this->id ;
                    $loanArr['fixed_asset_id'] = $fixedAsset->id ;
                
                }
                unset($loanArr['totals']);
                $totalFfeEquityPayment = HArr::sumAtDates([$totalFfeEquityPayment,$ffeEquityPayment], $sumKeys);
                $totalFfeLoanWithdrawal = HArr::sumAtDates([$totalFfeLoanWithdrawal,$ffeLoanWithdrawal], $sumKeys);
                if (count($loanArr)) {
                    DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table($loanTableName)->insert(HArr::encodeArr($loanArr));
                    
                }
				// dd($fixedAssetCalculationResultArr);
                $ffeExecutionAndPayment = $fixedAssetCalculationResultArr['ffeExecutionAndPayment'];
                    // dd($ffeExecutionAndPayment);
                $totalFfeExecutionAndPayment = HArr::sumAtDates([$totalFfeExecutionAndPayment,$ffeExecutionAndPayment], $sumKeys);
                $ffeLoanInterestAmounts = $fixedAssetCalculationResultArr['ffeLoanInterestAmounts'];
                $ffeLoanWithdrawalInterestAmounts = $fixedAssetCalculationResultArr['ffeLoanWithdrawalInterest'];
                $ffeLoanWithdrawalEndBalance = $fixedAssetCalculationResultArr['ffeLoanWithdrawalEndBalance'];
                $totalFfeLoanWithdrawalEndBalance = HArr::sumAtDates([$totalFfeLoanWithdrawalEndBalance,$ffeLoanWithdrawalEndBalance], $sumKeys);
             
                $projectUnderProgressFFE = $projectUnderProgressService->calculateForFFE($fixedAssetStartDateAsIndex, $fixedAssetEndDateAsIndex, $ffeExecutionAndPayment, $ffeLoanInterestAmounts, $ffeLoanWithdrawalInterestAmounts, $this, $operationStartDateAsIndex, $datesAsStringAndIndex, $datesIndexWithYearIndex, $yearIndexWithYear, $dateIndexWithDate, $dateWithMonthNumber);
                $totalProjectUnderProgressFFE = HArr::sumStatementAtDates($totalProjectUnderProgressFFE, $projectUnderProgressFFE, ['beginning_balance','additions','capitalized_interest','total','transferred_date_and_vales','end_balance'], $sumKeys);
                
                $transferDateAsIndex  = array_key_last($projectUnderProgressFFE['end_balance'])  ;
                $incomeStatementLoanCapitalizedInterests = is_null($transferDateAsIndex) ? [] :  HArr::slice_from_index($loanCapitalizedInterest, $transferDateAsIndex)  ;
                
                $totalIncomeStatementLoanCapitalizedInterests = HArr::sumAtDates([$totalIncomeStatementLoanCapitalizedInterests,$incomeStatementLoanCapitalizedInterests], $sumKeys);
                
                
                $transferredDateForFFEAsIndex = array_key_last($projectUnderProgressFFE['transferred_date_and_vales']??[]);
                
                $ffeAssetItems = $fixedAsset->calculateFFEAssetsForFFE($fixedAssetEndDateAsIndex, $transferredDateForFFEAsIndex, Arr::last($projectUnderProgressFFE['transferred_date_and_vales']??[], null, 0), $studyDates, $studyEndDateAsIndex, $this);
                $totalFfeAssetItems = HArr::sumStatementAtDates($totalFfeAssetItems, $ffeAssetItems, ['beginning_balance','additions','initial_total_gross','replacement_cost','final_total_gross','total_monthly_depreciation','accumulated_depreciation','end_balance'], $sumKeys);
            
                $monthlyDepreciation = $ffeAssetItems['total_monthly_depreciation'] ?? [];
                $totalMonthlyDepreciation = HArr::sumAtDates([$totalMonthlyDepreciation,$monthlyDepreciation], $sumKeys);
            
                $datesAsStringAndIndex = $this->getDatesAsStringAndIndex();
                $dateIndexWithDate = $this->getDateIndexWithDate();
                $ffeAcquisitionDatesAndAmounts =  $ffeExecutionAndPayment;
            
                $ffeAcquisitionDatesAndAmounts = $this->convertArrayOfIndexKeysToIndexAsDateStringWithItsOriginalValue($ffeAcquisitionDatesAndAmounts, $datesAsStringAndIndex);
                $ffeAcquisitionPayments = $ffePayment ;
                $ffePayable = [];
                if (count($ffeAcquisitionDatesAndAmounts)) {
                    $ffePayable=(new FixedAssetsPayableEndBalance())->calculateEndBalance($ffeAcquisitionDatesAndAmounts, $ffeAcquisitionPayments, $dateIndexWithDate);
                    $ffePayable = $ffePayable['monthly']['end_balance'] ?? [];
                    $totalFfePayable = HArr::sumAtDates([$ffePayable ,$totalFfePayable ], $sumKeys);

                }
            }
			// dd($totalFfePayment);
			// dd($totalFfeExecutionAndPayment);
            
            $fixedAsset->update([
               'loan_capitalized_interests'=>$totalLoanCapitalizedInterest,
               'income_statement_loan_capitalized_interests'=>$totalIncomeStatementLoanCapitalizedInterests,
               'capitalization_statement'=>$totalProjectUnderProgressFFE,
               //    'statement'=>$totalFfeAssetItems,
               'depreciation_statement'=>$totalFfeAssetItems,
              'total_monthly_depreciations'=>$totalMonthlyDepreciation,
               'ffe_equity_payment'=>$totalFfeEquityPayment,
               'ffe_loan_withdrawal'=>$totalFfeLoanWithdrawal,
               'ffe_loan_withdrawal_end_balance'=>$totalFfeLoanWithdrawalEndBalance,
               'ffe_payment'=>$totalFfePayment,
               'ffe_execution_and_payment'=>$totalFfeExecutionAndPayment,
               'ffe_payable'=>$totalFfePayable,
                
            ]);
            
        }
    }
    
    // public function recalculateFixedAssets(string $fixedAssetType)
    // {
     
    //   foreach($fixedAssets as $fixedAsset){
        
    //   }
    // }
    // public function recalculateFixedAssetStatement(string $fixedAssetType):void
    // {
    //     /**
    //      * * $fixedAssetType for example ffe , new-branches , etc
    //      */
    //     $resultFormattedToSaving = [];
    //     $fixedAssets =$this->fixedAssets->where('type', $fixedAssetType);
    //     $fixedAssetIds = $fixedAssets->pluck('id')->toArray();
    //     $dateIndexWithDate = $this->getDateIndexWithDate();
    //     $fixedAssetCalculationService = new FixedAssetCalculation;
    //     $operationStartDateFormatted = $this->getOperationStartDateFormatted();
    //     $dateWithDateIndex = $this->getDateWithDateIndex();
    //     $operationStartDateAsIndex = $this->getOperationStartDateAsIndex($dateWithDateIndex, $operationStartDateFormatted);
    //     $studyEndDateAsString = $this->getStudyEndDate();
    //     $studyEndDateAsIndex = $this->getStudyEndDateAsIndex($dateWithDateIndex, $studyEndDateAsString);
    //     DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('fixed_asset_statements')->whereIn('fixed_asset_id', $fixedAssetIds)->delete();
    //     $result = $fixedAssetCalculationService->__calculate($fixedAssets, $dateIndexWithDate, $operationStartDateAsIndex, $this->getStudyDates(), $studyEndDateAsIndex, $this->id, $this->company->id);
    //     foreach ($result as $fixedAssetId => $fixedAssetResult) {
    //         foreach ($fixedAssetResult as $columnName => $columnValue) {
    //             if (is_array($columnValue)) {
    //                 $resultFormattedToSaving[$fixedAssetId][$columnName] = json_encode($columnValue);
    //             } else {
    //                 $resultFormattedToSaving[$fixedAssetId][$columnName] = $columnValue;
    //             }
    //         }
    //     }
    //     $resultFormattedToSaving=array_values($resultFormattedToSaving);
    //     DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('fixed_asset_statements')->insert($resultFormattedToSaving);
    // }
    public function existingBranchesLoanCases():HasMany
    {
        return $this->hasMany(ExistingBranchesLoanCaseProjection::class, 'study_id', 'id');
    }
    public function newBranchMicrofinanceOpeningProjections():HasMany
    {
        return $this->hasMany(NewBranchMicrofinanceOpeningProjection::class, 'study_id', 'id');
    }
    public function getNewBranchCountPerDateIndex():array
    {
        $result = [];
        $newBranchOpeningProjects = $this->newBranchMicrofinanceOpeningProjections ;
        foreach ($newBranchOpeningProjects as $index => $newBranchOpeningProject) {
            $currentDateAsIndex = $newBranchOpeningProject->getStartDateAsIndex();
            $counts = $newBranchOpeningProject->getCounts();
            $result[$currentDateAsIndex] = isset($result[$currentDateAsIndex]) ? $result[$currentDateAsIndex]+$counts :$counts;
        }
        return $result;
    }
    // public function newBranchLoanCaseProjections():HasMany
    // {
    //     return $this->hasMany(NewBranchLoanCaseProjection::class, 'study_id', 'id');
    // }
    public function positions()
    {
        return $this->hasMany(Position::class, 'company_id', 'id');
    }
    public function getOnlyDatesOfActiveOperation(array $operationDurationPerYear, array $dateIndexWithDate, $removeZeros=true)
    {
        $result = [];
        foreach ($operationDurationPerYear as $currentYear => $datesAndZerosOrOnes) {
            foreach ($datesAndZerosOrOnes as $dateIndex => $zeroOrOneAtDate) {
                if ($zeroOrOneAtDate || !$removeZeros) {
                    if (is_numeric($dateIndex)) {
                        $dateFormatted =$dateIndexWithDate[$dateIndex];
                    } else {
                        $dateFormatted = $dateIndex;
                    }
                    $result[$dateFormatted] = $dateIndex;
                }
            }
        }

        return $result;
    }
    public function convertArrayOfStringDatesToStringDatesAndDateIndex(array $items, array $dateIndexWithDate, array $dateWithDateIndex)
    {
        $newItems = [];

        foreach ($items as $date=>$sumValue) {
            if (is_numeric($date)) {
                $newItems[$dateIndexWithDate[$date]]=$date;
            } else {
                $newItems[$date]=$dateWithDateIndex[$date];
            }
        }

        return $newItems;
    }
    public function getStudyStartDateYearAndMonth()
    {
        $studyStartDate = $this->getStudyStartDate() ;
        if (is_null($studyStartDate)) {
            return now()->format('Y-m');
        }
        return Carbon::make($studyStartDate)->format('Y-m');
    }
    public function getOperationStartDateYearAndMonth()
    {
        $operationStartDate = $this->getOperationStartDate() ;
        if (is_null($operationStartDate)) {
            return now()->format('Y-m');
        }
        return Carbon::make($operationStartDate)->format('Y-m');
    }
    public function getStudyEndDateYearAndMonth()
    {
        $date = $this->getEndDateFormatted() ;
        if (is_null($date)) {
            return now()->format('Y-m');
        }
        return Carbon::make($date)->format('Y-m');
    }
    public function expenses():HasMany
    {
        return $this->hasMany(Expense::class, 'study_id', 'id');
    }
    public function getExpensesViewVars():array
    {
        $company = $this->company;
        return [
            'company'=>$company ,
            'type'=>'create',
            'study'=>$this,
            'model'=>$this ,
            'expenses'=>$this->expenses,
            'expenseType'=>HHelpers::getClassNameWithoutNameSpace((new Expense())),
            'title'=>__('Expenses'),
            'storeRoute'=>route('store.expenses', ['company'=>$company->id , 'study'=>$this->id]),
            'yearsWithItsMonths' => $this->getOperationDurationPerYearFromIndexes(),
            'revenueStreamTypes'=>$this->getCheckedRevenueStreamTypesForSelect()
        ];
    }
    public function getDefaultStartDateAsYearAndMonth()
    {
        $operationStartDate = $this->getOperationStartDate() ;
        return Carbon::make($operationStartDate)->format('Y-m');
    }
    public function getDefaultEndDateAsYearAndMonth()
    {
        $operationStartDate = $this->study_end_date ;
        return Carbon::make($operationStartDate)->format('Y-m');
    }
    public function qqqw()
    {
        
    }
    public function getSelectedRevenuesCategories()
    {
        
    }
    // $revenueStreams for example // ['has_leasing','has_direct_factoring']
    public function getSelectedRevenueStreamWithCategories(array $revenueStreams):array
    {
        $mainTitleMapping = $this->getRevenueStreamTypes();
        $relationName = [
            'has_leasing'=>'leasingRevenueStreamBreakdown',
            'has_direct_factoring'=>'directFactoringBreakdowns',
            'has_reverse_factoring'=>'reverseFactoringBreakdowns',
            'has_ijara_mortgage'=>'ijaraMortgageBreakdowns',
            'has_portfolio_mortgage'=>'portfolioMortgageRevenueProjectionByCategories',
			'has_micro_finance'=>'microfinanceProductSalesProjects'
        ];
        $result = [];
        foreach ($revenueStreams as $currentRevenueType) {
            $currentRelationName = $relationName[$currentRevenueType];
            $currentTitle = $mainTitleMapping[$currentRevenueType];
            // $result[$currentRevenueType] = [
            //     'title'=>$currentTitle ,
            //     'value'=>$currentRevenueType
            // ];
            $relation = $this->{$currentRelationName} ;
            $idAndTitleColumnNames = [
                'leasingRevenueStreamBreakdown'=>[
                    'id'=>'category.id',
                    'title'=>'category.title'
                ],
                'directFactoringBreakdowns'=>[
                    'id'=>'category',
                    'title'=>'category'
                ],
                'reverseFactoringBreakdowns'=>[
                    'id'=>'category',
                    'title'=>'category'
                ],
                'ijaraMortgageBreakdowns'=>[
                    'id'=>'installment_interval',
                    'title'=>'installment_interval'
                ],
                'portfolioMortgageRevenueProjectionByCategories'=>[
                    'id'=>'portfolio_mortgage_duration',
                    'title'=>'portfolio_mortgage_duration'
                ],
				'microfinanceProductSalesProjects'=>[
                    'id'=>'microfinance_product_id',
                    'title'=>'microfinance_product_id'
                ],
               
                
            ][$currentRelationName];
            
            $id = $idAndTitleColumnNames['id']??null;
            
            $title = $idAndTitleColumnNames['title'];
                    
            $currentRevenues =  $relation->pluck($title, $id)->toArray();
			if($currentRelationName == 'microfinanceProductSalesProjects'){
				foreach($currentRevenues as $id => $title){
					$currentRevenues[$id] = MicrofinanceProduct::find($title)->getName();
				}
			}
		
		
            foreach ($currentRevenues as $id => $title) {
                $title  = camelizeWithSpace($title);
                if (is_numeric($title)) {
                    $dayOrYears = $currentRevenueType == 'has_portfolio_mortgage' ? __('Years') :  __('Days') ;
                    $title = $title . ' ' . $dayOrYears;
                }
                $result[] = ['title'=>$title , 'value'=>$id];
                // $result[$currentRevenueType]['subItems'][] = ['title'=>$title , 'value'=>$id];
            }
            
        }
        return $result;
    }
    
    
    public function fixedAssetOpeningBalances()
    {
        return $this->hasMany(FixedAssetOpeningBalance::class, 'study_id', 'id');
    }
    public function cashAndBankOpeningBalances():HasMany
    {
        return $this->hasMany(CashAndBankOpeningBalance::class, 'study_id', 'id');
    }
    public function otherDebtorsOpeningBalances():HasMany
    {
        return $this->hasMany(OtherDebtorsOpeningBalance::class, 'study_id', 'id');
    }
    public function supplierPayableOpeningBalances():HasMany
    {
        return $this->hasMany(SupplierPayableOpeningBalance::class, 'study_id', 'id');
    }
    public function otherCreditorsOpeningBalances():HasMany
    {
        return $this->hasMany(OtherCreditsOpeningBalance::class, 'study_id', 'id');
    }
    public function otherLongTermLiabilitiesOpeningBalances():HasMany
    {
        return $this->hasMany(OtherLongTermLiabilitiesOpeningBalance::class, 'study_id', 'id');
    }
    public function otherLongTermAssetsOpeningBalances():HasMany
    {
        return $this->hasMany(OtherLongTermAssetsOpeningBalance::class, 'study_id', 'id');
    }
    public function equityOpeningBalances():HasMany
    {
        return $this->hasMany(EquityOpeningBalance::class, 'study_id', 'id');
    }
    public function vatAndCreditWithholdTaxesOpeningBalances():HasMany
    {
        return $this->hasMany(VatAndCreditWithholdTaxOpeningBalance::class, 'study_id', 'id');
    }
    public function getVatOpeningBalanceAmount():float
    {
        $vatOpening = $this->vatAndCreditWithholdTaxesOpeningBalances->first();
        return $vatOpening ? $vatOpening->getVatAmount() : 0 ;
    }
    public function getCreditWithholdOpeningBalanceAmount():float
    {
        $vatOpening = $this->vatAndCreditWithholdTaxesOpeningBalances->first();
        return $vatOpening ? $vatOpening->getCreditWithholdTaxes() : 0 ;
    }
    public function longTermLoanOpeningBalances():HasMany
    {
        return $this->hasMany(LongTermLoanOpeningBalance::class, 'study_id', 'id');
    }
    
        
    public function getOpeningBalancesViewVars():array
    {
   
        $fixedAssetOpeningBalances = $this->fixedAssetOpeningBalances;
        $cashAndBankOpeningBalances = $this->cashAndBankOpeningBalances;
        $otherDebtorsOpeningBalances = $this->otherDebtorsOpeningBalances;
        $supplierPayableOpeningBalances = $this->supplierPayableOpeningBalances;
        $otherCreditorsOpeningBalances = $this->otherCreditorsOpeningBalances;
        $vatAndCreditWithholdTaxesOpeningBalances = $this->vatAndCreditWithholdTaxesOpeningBalances;
        $otherLongTermLiabilitiesOpeningBalances = $this->otherLongTermLiabilitiesOpeningBalances;
        $otherLongTermAssetsOpeningBalances = $this->otherLongTermAssetsOpeningBalances;
        $equityOpeningBalances = $this->equityOpeningBalances;
        $longTermLoanOpeningBalances = $this->longTermLoanOpeningBalances;
        $products = $this->products;
        return ['title'=>__('Opening Balances'),'study'=>$this,'vatAndCreditWithholdTaxesOpeningBalances'=>$vatAndCreditWithholdTaxesOpeningBalances,'longTermLoanOpeningBalances'=>$longTermLoanOpeningBalances,'equityOpeningBalances'=>$equityOpeningBalances,'otherLongTermLiabilitiesOpeningBalances'=>$otherLongTermLiabilitiesOpeningBalances,'otherLongTermAssetsOpeningBalances'=>$otherLongTermAssetsOpeningBalances,'otherCreditorsOpeningBalances'=>$otherCreditorsOpeningBalances,'supplierPayableOpeningBalances'=>$supplierPayableOpeningBalances,'otherDebtorsOpeningBalances'=>$otherDebtorsOpeningBalances,'fixedAssetOpeningBalances'=>$fixedAssetOpeningBalances,'cashAndBankOpeningBalances'=>$cashAndBankOpeningBalances,'products'=>$products];
        
    }
    
    public function getYearIndexWithItsMonthsAsIndexAndString()
    {
        $result =[];
        foreach ($this->getOperationDurationPerYearFromIndexesForAllStudyInfo() as $yearIndex => $dateAsIndexAndIsActive) {
            foreach ($dateAsIndexAndIsActive as $dateAsIndex => $isActive) {
                if ($isActive) {
                    $dateAsString = $this->getDateFromDateIndex($dateAsIndex);
                    $result[$yearIndex][$dateAsIndex]=$dateAsString;
                }
            }
            
        }
        return $result;
    }

    public function getDateWithDateIndex():array
    {
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        return $datesAndIndexesHelpers['dateWithDateIndex'];
    }
    public function getIndexDateFromString(string $dateAsString):int
    {
        $dateWithDateIndex = $this->getDateWithDateIndex();
        return $dateWithDateIndex[$dateAsString];
    }
    public function getDateFromDateIndex(int $dateAsIndex):string
    {
        $dateIndexWithDate = $this->getDateIndexWithDate();
        return $dateIndexWithDate[$dateAsIndex];
    }
    public function getYearIndexFromDateIndex(int $dateAsIndex)
    {
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        $datesIndexWithYearIndex = $datesAndIndexesHelpers['datesIndexWithYearIndex'];
        return $datesIndexWithYearIndex[$dateAsIndex];
    }
    public function getYearFromYearIndex(int $yearAsIndex):?int
    {
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        $yearIndexWithYear = $datesAndIndexesHelpers['yearIndexWithYear'];
        return $yearIndexWithYear[$yearAsIndex]??null;
    }
    public function getYearFromDateIndex(int $dateAsIndex):int
    {
        $yearIndex = $this->getYearIndexFromDateIndex($dateAsIndex);
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        $yearIndexWithYear = $datesAndIndexesHelpers['yearIndexWithYear'];
        return $yearIndexWithYear[$yearIndex];
    }
    public function getYearIndexWithYear():array
    {
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        return $datesAndIndexesHelpers['yearIndexWithYear'];
    }
    
    public function getDatesIndexWithYearIndex()
    {
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        return $datesAndIndexesHelpers['datesIndexWithYearIndex'];
    }
    public function getDateWithMonthNumber()
    {
        $datesAndIndexesHelpers = $this->getDatesIndexesHelper();
        return $datesAndIndexesHelpers['dateWithMonthNumber'];
    }
    public function getYearIndexWithItsMonths():array
    {
        $dateIndexWithYearIndex = $this->getDatesIndexWithYearIndex();
        $result = [];
        foreach ($dateIndexWithYearIndex as $dateAsIndex => $yearAsIndex) {
            $result[$yearAsIndex][$dateAsIndex] = $this->getDateFromDateIndex($dateAsIndex);
        }
        return $result;
    }
    public function getEndDate(): ?string
    {
        return $this->getStudyEndDate();
    }
    public function convertDateStringToDateIndex(string $dateAsString):int
    {
        return app('dateWithDateIndex')[$dateAsString];
    }
  
   
    public function convertStringIndexesToDateIndex(array $itemsAsDateStringAndValue):array
    {
        $result = [];
        foreach ($itemsAsDateStringAndValue as $dateAsString => $value) {
            $dateAsIndex = $this->getIndexDateFromString($dateAsString);
            if (!is_null($dateAsIndex)) {
                $result[$dateAsIndex] = $value ;
            }
        }
        return $result;
    }
 
    public function getOnlyDatesOfActiveStudy(array $studyDurationPerYear, array $dateIndexWithDate)
    {
        $result = [];
        foreach ($studyDurationPerYear as $currentYear => $datesAndZerosOrOnes) {
            foreach ($datesAndZerosOrOnes as $dateIndex => $zeroOrOneAtDate) {
                if (is_numeric($dateIndex)) {
                    $dateFormatted =$dateIndexWithDate[$dateIndex];
                } else {
                    $dateFormatted = $dateIndex;
                }
                $result[$dateFormatted] = $dateIndex;
            }
        }

        return $result;
    }
    public function storeAdminFeesAndFundingStructureFor(Request $request, string $revenueStreamType, array $portfolioMonthlyNewLoansFundingValues = [], array $occurrenceDates = [])
    {
        if ($request->has('admin_fees_rates')) {
            $isPortfolio = $revenueStreamType == Study::PORTFOLIO_MORTGAGE ;
            $isMicrofinance = $revenueStreamType == Study::MICROFINANCE ;
            $adminFeesRates = $request->get('admin_fees_rates', []);
            $newLoansFundingValues = $request->get('new_loans_funding_values', []) ;
			$newLoansFundingValuesFormatted = $isMicrofinance ? $newLoansFundingValues['by-mtls'] : $newLoansFundingValues ;
            $equityFundingValues = $request->get('equity_funding_values', []) ;
            $loanAmounts = $this->getLoanAmountForAdminFeesForRevenueStreamType($revenueStreamType);
			// dd($loanAmounts);
            $monthlyAdminFeesAmount = $this->calculateMonthlyAdminFeesAmounts($revenueStreamType, $adminFeesRates, $loanAmounts, $occurrenceDates);
            $monthlyNewLoansFundingValues  = $this->isMonthlyStudy() ? $newLoansFundingValuesFormatted : $this->convertYearIndexToActiveMonthIndexes($newLoansFundingValuesFormatted);
            $monthlyNewLoansFundingValues = $isPortfolio ? $portfolioMonthlyNewLoansFundingValues : $monthlyNewLoansFundingValues;
            $data = [
                'revenue_stream_type'=>$revenueStreamType,
                'admin_fees_rates'=>$adminFeesRates,
                'monthly_admin_fees_amounts'=>$monthlyAdminFeesAmount,
                'ecl_rates'=>$request->get('ecl_rates', []),
                'equity_funding_rates'=>$request->get('equity_funding_rates', []),
                'equity_funding_values'=>$equityFundingValues,
                'new_loans_funding_rates'=>$request->get('new_loans_funding_rates', []),
                'new_loans_funding_values'=>$newLoansFundingValues,
                'monthly_new_loans_funding_values'=>$monthlyNewLoansFundingValues,
                'company_id'=>$this->company->id
            ];
            $eclAndNewPortfolioFundingRate = $this->getEclAndNewPortfolioFundingRatesForStreamType($revenueStreamType);
			
            if ($eclAndNewPortfolioFundingRate) {
                $eclAndNewPortfolioFundingRate->update($data);
            } else {
               $eclAndNewPortfolioFundingRate = $this->eclAndNewPortfolioFundingRates()->create($data);
            }
            $this->refresh();
			return [
				'monthly_new_loans_funding_values'=>$monthlyNewLoansFundingValues,
				'eclAndNewPortfolioFundingRate'=>$eclAndNewPortfolioFundingRate
			];
            
        }
		return [
			'monthly_new_loans_funding_values'=>[],
			'eclAndNewPortfolioFundingRate'=>null
		];
		
        
    }
    public function getCashAndBanksAmount():float
    {
        $cashAndBankAmount   = $this->cashAndBankOpeningBalances->first();
        return $cashAndBankAmount ? $cashAndBankAmount->cash_and_bank_amount : 0 ;
    }
    
    public function getCashInOutFlowViewVars()
    {
        $yearWithItsIndexes = $this->getOperationDurationPerYearFromIndexes();
        $monthsWithItsYear = $this->getMonthsWithItsYear($yearWithItsIndexes) ;
        $financialYearEndMonthNumber = '12';
        $defaultNumericInputClasses = [
            'number-format-decimals'=>0,
            'is-percentage'=>false,
            'classes'=>'repeater-with-collapse-input readonly',
            'formatted-input-classes'=>'custom-input-numeric-width readonly',
        ];
        $defaultPercentageInputClasses = [
            'classes'=>'',
            'formatted-input-classes'=>'ddd',
            'is-percentage'=>true ,
            'number-format-decimals'=> 2,
        ];
        $defaultClasses = [
            $defaultNumericInputClasses,
            $defaultPercentageInputClasses
        ];
        $studyMonthsForViews = $this->getStudyDates();
        $studyMonthsForViews = array_slice($studyMonthsForViews, 0, $this->getViewStudyEndDateAsIndex()+1);
        $yearWithItsMonths=$this->getYearIndexWithItsMonths();
        //  unset($yearWithItsMonths[array_key_last($yearWithItsMonths)]);
        
        
        
        /**
         * * First Tab Sales Revenue
        */
        $cashAndBankAmount = $this->getCashAndBanksAmount();
        $tableDataFormatted[-1]['main_items']['cash-and-banks']['options'] = array_merge([
           'title'=>__('Cash And Banks')
        ], $defaultNumericInputClasses);
        $tableDataFormatted[-1]['main_items']['cash-and-banks']['data'] = [];
        $sumKeys = array_keys($studyMonthsForViews);
        
        $loanSchedulePayments = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('study_id', $this->id)->where('portfolio_loan_type', 'portfolio')->get();
        $loanSchedulePaymentPerType = HArr::sumLoanSchedulePerKey($loanSchedulePayments, $sumKeys, 'revenue_stream_type');
        $directFactoringSettlements =  DirectFactoringBreakdown::where('study_id', $this->id)->pluck('direct_factoring_settlements')->toArray();
        $directFactoringSettlements = HArr::sumAtDates($directFactoringSettlements, $sumKeys);
        $loanSchedulePaymentPerType['direct-factoring'] = $directFactoringSettlements;
        // cash in
        $tableDataFormatted[0]['main_items']['cash-in-flow']['options'] = array_merge([
          'title'=>__('Total CashIn Flow')
        ], $defaultNumericInputClasses);
        
        $cashAndBank = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('cash_and_bank_opening_balances')->where('study_id', $this->id)->first(['interests','payload']);
        if ($cashAndBank) {
            $settlements = json_decode($cashAndBank->payload, true);
            $interests = json_decode($cashAndBank->interests, true);
            $subItemTotal = HArr::sumAtDates([$settlements,$interests], $sumKeys);
            $id = __('Existing Outstanding Collection');
            $tableDataFormatted[0]['sub_items'][$id]['data'] = $subItemTotal;
            $tableDataFormatted[0]['sub_items'][$id]['options']['title'] = $id;
            $tableDataFormatted[0]['sub_items'][$id]['year_total'] = HArr::sumPerYearIndex($subItemTotal, $yearWithItsMonths);
        }
 
        
        
     //   $currentTotal = [];

        foreach ($loanSchedulePaymentPerType as $revenueType => $currentData) {
            $title = str_to_upper($revenueType) .' Collection'  ;
            $tableDataFormatted[0]['sub_items'][$title]['options'] =array_merge([
                'title'=>$title
            ], $defaultNumericInputClasses);
            $tableDataFormatted[0]['sub_items'][$title]['data'] = $currentData;
    //        $currentTotal = HArr::sumAtDates([$currentData,$currentTotal], $studyMonthsForViews);
            $tableDataFormatted[0]['sub_items'][$title]['year_total'] = HArr::sumPerYearIndex($currentData, $yearWithItsMonths);
        }
        
        $loanWithdrawalsByRevenueStreams  = EclAndNewPortfolioFundingRate::where('study_id', $this->id)->pluck('monthly_new_loans_funding_values', 'revenue_stream_type')->toArray();
		// dd('lol_lol',$loanWithdrawalsByRevenueStreams);
        foreach ($loanWithdrawalsByRevenueStreams as $revenueType=>  $currentData) {
            $title = str_to_upper($revenueType) .' Loan Withdrawal Amount'  ;
            $tableDataFormatted[0]['sub_items'][$title]['options'] =array_merge([
                'title'=>$title
            ], $defaultNumericInputClasses);
            $tableDataFormatted[0]['sub_items'][$title]['data'] = $currentData;
        //    $currentTotal = HArr::sumAtDates([$currentData,$currentTotal], $studyMonthsForViews);
            $tableDataFormatted[0]['sub_items'][$title]['year_total'] = HArr::sumPerYearIndex($currentData, $yearWithItsMonths);
        }
		
        $securitizationLoanSchedules = SecuritizationLoanSchedule::where('study_id', $this->id)->get();
        $securitizationNetPresentValues = [];
        $securitizationCollectionRevenues = [];
   	//	 $securitizationGainOrLosses =[];
        foreach ($securitizationLoanSchedules as $securitizationLoanSchedule) {
            $netPresentValue = $securitizationLoanSchedule->net_present_value;
            $collectionRevenueAmounts = $securitizationLoanSchedule->collection_revenue_amounts;
            $securitization = $securitizationLoanSchedule->securitization;
            $securitizationDateAsIndex = $securitization->securitization_date;
            $securitizationNetPresentValues[$securitizationDateAsIndex] = isset($securitizationNetPresentValues[$securitizationDateAsIndex]) ? $securitizationNetPresentValues[$securitizationDateAsIndex] +  $netPresentValue : $netPresentValue;
            foreach ($collectionRevenueAmounts as $dateAsIndex => $collectionRevenue) {
                $securitizationCollectionRevenues[$dateAsIndex] = isset($securitizationCollectionRevenues[$dateAsIndex]) ? $securitizationCollectionRevenues[$dateAsIndex] +  $collectionRevenue : $collectionRevenue;
            }
			
		
        //    $securitizationGainOrLoss = $securitizationLoanSchedule->securitization_profit_or_loss;
            $securitization = $securitizationLoanSchedule->securitization;
            $securitizationDateAsIndex = $securitization->securitization_date;
          	// if($securitizationGainOrLoss > 0){
			// 	$securitizationGainOrLoss = $securitizationGainOrLoss ;
			// 	$securitizationGainOrLosses[$securitizationDateAsIndex] = isset($securitizationGainOrLosses[$securitizationDateAsIndex]) ? $securitizationGainOrLosses[$securitizationDateAsIndex] +  $securitizationGainOrLoss : $securitizationGainOrLoss;
			// }
			
        }
        if (count($securitizationNetPresentValues)) {
            $title = __('Securitization Net Present Value');
            $tableDataFormatted[0]['sub_items'][$title]['options'] =array_merge([
               'title'=>$title
            ], $defaultNumericInputClasses);
            $tableDataFormatted[0]['sub_items'][$title]['data'] = $securitizationNetPresentValues;
          //  $currentTotal = HArr::sumAtDates([$securitizationNetPresentValues,$currentTotal], $studyMonthsForViews);
            $tableDataFormatted[0]['sub_items'][$title]['year_total'] = HArr::sumPerYearIndex($securitizationNetPresentValues, $yearWithItsMonths);
        }
        
        if (count($securitizationCollectionRevenues)) {
            $title = __('Securitization Collection Revenues');
            $tableDataFormatted[0]['sub_items'][$title]['options'] =array_merge([
               'title'=>$title
            ], $defaultNumericInputClasses);
            $tableDataFormatted[0]['sub_items'][$title]['data'] = $securitizationCollectionRevenues;
          //  $currentTotal = HArr::sumAtDates([$securitizationCollectionRevenues,$currentTotal], $studyMonthsForViews);
            $tableDataFormatted[0]['sub_items'][$title]['year_total'] = HArr::sumPerYearIndex($securitizationCollectionRevenues, $yearWithItsMonths);
        }
		
		
		
        
            
    
        $monthlyAdminFees = EclAndNewPortfolioFundingRate::where('study_id', $this->id)->get(['monthly_ecl_values','monthly_admin_fees_amounts'])->toArray();
        // $monthlyEclValues = array_column($monthlyAdminFees,'monthly_ecl_values');
        $monthAdminFees = array_column($monthlyAdminFees, 'monthly_admin_fees_amounts');
        // $monthlyEclValues = HArr::sumAtDates($monthlyEclValues,$studyDates);
        $monthAdminFees = HArr::sumAtDates($monthAdminFees, $sumKeys);
        $tableDataFormatted[0]['sub_items']['monthly-admin-fees']['data'] = $monthAdminFees;
        $tableDataFormatted[0]['sub_items']['monthly-admin-fees']['options']['title'] = __('Monthly Admin Fees');
        $tableDataFormatted[0]['sub_items']['monthly-admin-fees']['year_total'] = HArr::sumPerYearIndex($monthAdminFees, $yearWithItsMonths);
            
		
		
        $otherDebtors = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('other_debtors_opening_balances')->where('study_id', $this->id)->pluck('statement', 'name')->toArray();
        $totalOtherDebtorsPerKey = HArr::formatMultiSubItemsPerKey($otherDebtors, $sumKeys, ['monthly','payment']);
        foreach ($totalOtherDebtorsPerKey as $keyName => $subItemTotal) {
            $id = 'other_debtors_opening_balances'.$keyName;
            $tableDataFormatted[0]['sub_items'][$id]['data'] = $subItemTotal;
            $tableDataFormatted[0]['sub_items'][$id]['options']['title'] = $keyName;
            $tableDataFormatted[0]['sub_items'][$id]['year_total'] = HArr::sumPerYearIndex($subItemTotal, $yearWithItsMonths);
        }
        
        $otherLongTermAssetOpeningBalances = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('other_long_term_assets_opening_balances')->where('study_id', $this->id)->pluck('statement', 'name')->toArray();
        $totalOtherLongTermAssetOpeningBalances = HArr::formatMultiSubItemsPerKey($otherLongTermAssetOpeningBalances, $sumKeys, ['monthly','payment']);
        foreach ($totalOtherLongTermAssetOpeningBalances as $keyName => $subItemTotal) {
            $id = 'other_long_term_assets_opening_balances'.$keyName;
            $tableDataFormatted[0]['sub_items'][$id]['data'] = $subItemTotal;
            $tableDataFormatted[0]['sub_items'][$id]['options']['title'] = $keyName;
            $tableDataFormatted[0]['sub_items'][$id]['year_total'] = HArr::sumPerYearIndex($subItemTotal, $yearWithItsMonths);
        }
        
        
        $totalFixedAssetEquity = [];
        foreach ($this->fixedAssets as $fixedAsset) {
            $totalFixedAssetEquity = HArr::sumAtDates([$fixedAsset->getFfeEquityPayment(),$totalFixedAssetEquity], $sumKeys);
        }
        
        if (count($totalFixedAssetEquity)) {
            $tableDataFormatted[0]['sub_items'][__('Equity Injection')]['data'] = $totalFixedAssetEquity;
            $tableDataFormatted[0]['sub_items'][__('Equity Injection')]['year_total'] = HArr::sumPerYearIndex($totalFixedAssetEquity, $yearWithItsMonths);
        }
        
        
       
    
        $totalCashIn = HArr::sumAtDates(array_column($tableDataFormatted[0]['sub_items']??[], 'data'), $sumKeys);
        $tableDataFormatted[0]['main_items']['cash-in-flow']['data'] = $totalCashIn;
        $tableDataFormatted[0]['main_items']['cash-in-flow']['year_total'] = $totalCashInflowPerYear = HArr::sumPerYearIndex($totalCashIn, $yearWithItsMonths);
        // cash out
        $tableDataFormatted[1]['main_items']['cash-out-flow']['options'] = array_merge([
          'title'=>__('Total CashOut Flow')
        ], $defaultNumericInputClasses);
        
        
        $supplierPayables = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('supplier_payable_opening_balances')->where('study_id', $this->id)->first('payload');
        if ($supplierPayables) {
            $subItemTotal = json_decode($supplierPayables->payload, true);
            $keyName = __('Existing Supplier Payable');
            $tableDataFormatted[1]['sub_items'][$id]['data'] = $subItemTotal;
            $tableDataFormatted[1]['sub_items'][$id]['options']['title'] = $keyName;
            $tableDataFormatted[1]['sub_items'][$id]['year_total'] = HArr::sumPerYearIndex($subItemTotal, $yearWithItsMonths);
        }
       
    
        
        
        $revenueContracts  = RevenueContract::where('study_id', $this->id)->get();
        $totalPerType=[];
        foreach ($revenueContracts as $revenueType=>  $revenueContract) {
            $revenueType = $revenueContract->revenue_type ;
            $currentData = $revenueContract->monthly_loan_amounts;
            $title = str_to_upper($revenueType) .' New Portfolio Disbursement'  ;
            $tableDataFormatted[1]['sub_items'][$title]['options'] =array_merge([
                'title'=>$title
            ], $defaultNumericInputClasses);
            $totalPerType[$revenueType] = isset($totalPerType[$revenueType]) ? HArr::sumAtDates([$totalPerType[$revenueType],$currentData], $sumKeys) : $currentData;
            $tableDataFormatted[1]['sub_items'][$title]['data'] = $totalPerType[$revenueType] ;
            //       $currentTotal = HArr::sumAtDates([$currentData,$currentTotal], $studyMonthsForViews);
            $tableDataFormatted[1]['sub_items'][$title]['year_total'] = HArr::sumPerYearIndex($totalPerType[$revenueType], $yearWithItsMonths);
        
        }
        
        
        $totalPerType =[];
        $loanSchedulePayments = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('study_id', $this->id)->where('portfolio_loan_type', 'bank_portfolio')->get();
        $loanSchedulePaymentPerType = HArr::sumLoanSchedulePerKey($loanSchedulePayments, $sumKeys, 'revenue_stream_type');
        $directFactoringSettlements =  DirectFactoringBreakdown::where('study_id', $this->id)->pluck('bank_loan_settlements')->toArray();
        //$xx =  DirectFactoringBreakdown::where('study_id', $this->id)->pluck('bank_interest_expense')->toArray();
        $directFactoringInterestPayments =  DirectFactoringBreakdown::where('study_id', $this->id)->pluck('bank_interest_expense_payments')->toArray();
        $directFactoringSettlements = HArr::sumAtDates($directFactoringSettlements, $sumKeys);
        $directFactoringInterestPayments = HArr::sumAtDates($directFactoringInterestPayments, $sumKeys);
        $loanSchedulePaymentPerType['direct-factoring'] = HArr::sumAtDates([$directFactoringSettlements,$directFactoringInterestPayments], $sumKeys);
        foreach ($loanSchedulePaymentPerType as $revenueType => $currentData) {
            $title =  $revenueType == 'direct-factoring' ?  str_to_upper($revenueType) .' Loan Payments' :  str_to_upper($revenueType) .' Bank Loan Payments'  ;
            $tableDataFormatted[1]['sub_items'][$title]['options'] =array_merge([
                'title'=>$title
            ], $defaultNumericInputClasses);
            $totalPerType[$revenueType] = isset($totalPerType[$revenueType]) ? HArr::sumAtDates([$totalPerType[$revenueType],$currentData], $sumKeys) : $currentData;
            $tableDataFormatted[1]['sub_items'][$title]['data'] = $totalPerType[$revenueType];
            $tableDataFormatted[1]['sub_items'][$title]['year_total'] = HArr::sumPerYearIndex($totalPerType[$revenueType], $yearWithItsMonths);
        }
        $securitizationBankLoanSettlements = [];
        $securitizationBankEarlySettlements = [];
      //  $securitizationGainOrLosses = [];
		$securitizationExpenses = [];
        foreach ($securitizationLoanSchedules as $securitizationLoanSchedule) {
            $bankPortfolioEndBalance = $securitizationLoanSchedule->bank_portfolio_end_balance_sum;
            $bankPortfolioEarlySettlement = $securitizationLoanSchedule->early_settlements_expense_amount;
       //     $securitizationGainOrLoss = $securitizationLoanSchedule->securitization_profit_or_loss;
            $securitizationExpense = $securitizationLoanSchedule->securitization_expense_amount;
            $securitization = $securitizationLoanSchedule->securitization;
            $securitizationDateAsIndex = $securitization->securitization_date;
            $securitizationBankLoanSettlements[$securitizationDateAsIndex] = isset($securitizationBankLoanSettlements[$securitizationDateAsIndex]) ? $securitizationBankLoanSettlements[$securitizationDateAsIndex] +  $bankPortfolioEndBalance : $bankPortfolioEndBalance;
            $securitizationBankEarlySettlements[$securitizationDateAsIndex] = isset($securitizationBankEarlySettlements[$securitizationDateAsIndex]) ? $securitizationBankEarlySettlements[$securitizationDateAsIndex] +  $bankPortfolioEarlySettlement : $bankPortfolioEarlySettlement;
            $securitizationExpenses[$securitizationDateAsIndex] = isset($securitizationExpenses[$securitizationDateAsIndex]) ? $securitizationExpenses[$securitizationDateAsIndex] +  $securitizationExpense : $securitizationExpense;
			// if($securitizationGainOrLoss < 0){
			// 	$securitizationGainOrLoss = $securitizationGainOrLoss *-1;
			// 	$securitizationGainOrLosses[$securitizationDateAsIndex] = isset($securitizationGainOrLosses[$securitizationDateAsIndex]) ? $securitizationGainOrLosses[$securitizationDateAsIndex] +  $securitizationGainOrLoss : $securitizationGainOrLoss;
			// }
        }
        if (count($securitizationBankLoanSettlements)) {
            $title = __('Securitization Bank Loan Settlements');
            $tableDataFormatted[1]['sub_items'][$title]['options'] =array_merge([
               'title'=>$title
            ], $defaultNumericInputClasses);
            $tableDataFormatted[1]['sub_items'][$title]['data'] = $securitizationBankLoanSettlements;
         //   $currentTotal = HArr::sumAtDates([$securitizationBankLoanSettlements,$currentTotal], $studyMonthsForViews);
            $tableDataFormatted[1]['sub_items'][$title]['year_total'] = HArr::sumPerYearIndex($securitizationBankLoanSettlements, $yearWithItsMonths);
        }
		if (count($securitizationBankEarlySettlements)) {
            $title = __('Securitization Bank Settlement Expense');
            $tableDataFormatted[1]['sub_items'][$title]['options'] =array_merge([
               'title'=>$title
            ], $defaultNumericInputClasses);
            $tableDataFormatted[1]['sub_items'][$title]['data'] = $securitizationBankEarlySettlements;
            $tableDataFormatted[1]['sub_items'][$title]['year_total'] = HArr::sumPerYearIndex($securitizationBankEarlySettlements, $yearWithItsMonths);
        }
        if (count($securitizationExpenses)) {
            $title = __('Securitization Expenses');
            $tableDataFormatted[1]['sub_items'][$title]['options'] =array_merge([
               'title'=>$title
            ], $defaultNumericInputClasses);
            $tableDataFormatted[1]['sub_items'][$title]['data'] = $securitizationExpenses;
        //    $currentTotal = HArr::sumAtDates([$securitizationExpenses,$currentTotal], $studyMonthsForViews);
            $tableDataFormatted[1]['sub_items'][$title]['year_total'] = HArr::sumPerYearIndex($securitizationExpenses, $yearWithItsMonths);
        }
        
        // ddd
        
        
        $expenses = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('expenses')->where('study_id', $this->id)->get();
        $totalExpensePerCategory = [];
		$totalCreditWithholdPayments = [];
			$dateWithDateIndex = $this->getDateWithDateIndex();
        foreach ($expenses as $expense) {
            $expenseNameId = $expense->expense_name_id;
            $paymentAmounts = json_decode($expense->net_payments_after_withhold,true);
            $withholdStatements = json_decode($expense->withhold_statements,true);
			$withholdStatements = $withholdStatements['monthly']['payment']??[];
		
            foreach ($dateWithDateIndex as $dateIndex ) {
				$paymentAmount = $paymentAmounts[$dateIndex]??0;
				$currentWithholdAmount = $withholdStatements[$dateIndex]??0;
                $totalExpensePerCategory[$expenseNameId][$dateIndex] = isset($totalExpensePerCategory[$expenseNameId][$dateIndex]) ? $totalExpensePerCategory[$expenseNameId][$dateIndex] + $paymentAmount : $paymentAmount;
                $totalCreditWithholdPayments[$dateIndex] = isset($totalCreditWithholdPayments[$dateIndex]) ? $totalCreditWithholdPayments[$dateIndex] + $currentWithholdAmount : $currentWithholdAmount;
            }
        }
		
        $totalPerType =[];
        foreach ($totalExpensePerCategory as $expenseNameId => $currentData) {
            $expenseName =  ExpenseName::find($expenseNameId) ;
            $title = $expenseName  ? $expenseName->getName() : __('N/A');
            $tableDataFormatted[1]['sub_items'][$expenseNameId]['options'] =array_merge([
                'title'=>$title
            ], $defaultNumericInputClasses);
            $totalPerType[$expenseNameId] = isset($totalPerType[$expenseNameId]) ? HArr::sumAtDates([$totalPerType[$expenseNameId],$currentData], $sumKeys) : $currentData;
            $tableDataFormatted[1]['sub_items'][$expenseNameId]['data'] = $totalPerType[$expenseNameId];
            $tableDataFormatted[1]['sub_items'][$expenseNameId]['year_total'] = HArr::sumPerYearIndex($totalPerType[$expenseNameId], $yearWithItsMonths);
            
        }
		$tableDataFormatted[1]['sub_items']['credit-withhold-payments']['options']['title'] = __('Credit Withhold Taxes Payments');
		  $tableDataFormatted[1]['sub_items']['credit-withhold-payments']['data'] = $totalCreditWithholdPayments;
           $tableDataFormatted[1]['sub_items']['credit-withhold-payments']['year_total'] = HArr::sumPerYearIndex($totalCreditWithholdPayments, $yearWithItsMonths);
            
        
        
        
        $totalSalaryPayments = [];
        $totalExpenses = [];
        $totalTaxAndSocialInsurances = [];
        $salaryPayments = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('manpowers')->where('study_id', $this->id)->pluck('salary_payments')->toArray();
        $salaryTaxAndSocialInsurances = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('manpowers')->where('study_id', $this->id)->pluck('tax_and_social_insurance_statement')->toArray();
        foreach ($salaryPayments as $index=>$manpowerSalaryPayment) {
            $manpowerSalaryPayment = (array)json_decode($manpowerSalaryPayment);
            $salaryTaxAndSocialInsurance = ((array)json_decode($salaryTaxAndSocialInsurances[$index]))['monthly']??[];
            $salaryTaxAndSocialInsurance = (array)$salaryTaxAndSocialInsurance->payment;
            $totalSalaryPayments  = HArr::sumAtDates([$totalSalaryPayments,$manpowerSalaryPayment], $sumKeys);
            $totalTaxAndSocialInsurances  = HArr::sumAtDates([$totalTaxAndSocialInsurances,$salaryTaxAndSocialInsurance], $sumKeys);
        }
        
        $tableDataFormatted[1]['sub_items'][__('Salaries Payments')]['data'] = $totalSalaryPayments;
        $totalExpenses =  HArr::sumAtDates([$totalExpenses,$totalSalaryPayments], $sumKeys);
        $tableDataFormatted[1]['sub_items'][__('Salaries Payments')]['year_total'] = HArr::sumPerYearIndex($totalSalaryPayments, $yearWithItsMonths);
        
        $tableDataFormatted[1]['sub_items'][__('Salary Taxes & Social Insurance')]['data'] = $totalTaxAndSocialInsurances;
        $tableDataFormatted[1]['sub_items'][__('Salary Taxes & Social Insurance')]['year_total'] = HArr::sumPerYearIndex($totalTaxAndSocialInsurances, $yearWithItsMonths);
       
        $corporateTaxesPayments = $this->incomeStatement ?  array_get($this->incomeStatement->monthly_corporate_taxes_statements, 'monthly.payment') : [];
        $tableDataFormatted[1]['sub_items'][__('Corporate Taxes Payment')]['data'] = $corporateTaxesPayments;
        $tableDataFormatted[1]['sub_items'][__('Corporate Taxes Payment')]['year_total'] = HArr::sumPerYearIndex($corporateTaxesPayments, $yearWithItsMonths);
       
        
        
        
        $totalFixedAssetPayments = [];
        $fixedAssetPayments = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('fixed_assets')->where('study_id', $this->id)->pluck('ffe_payment')->toArray();
        foreach ($fixedAssetPayments as $index=>$fixedAssetPayment) {
            $fixedAssetPayment = json_decode($fixedAssetPayment, true);
            $totalFixedAssetPayments  = HArr::sumAtDates([$totalFixedAssetPayments,$fixedAssetPayment], $sumKeys);
        }
		// dd($fixedAssetPayments);
        $tableDataFormatted[1]['sub_items'][__('Fixed Asset Payments')]['data'] = $totalFixedAssetPayments;
        $tableDataFormatted[1]['sub_items'][__('Fixed Asset Payments')]['year_total'] = HArr::sumPerYearIndex($totalFixedAssetPayments, $yearWithItsMonths);
		
		
		
		
		  $totalFixedAssetReplacements = [];
        $fixedAssetReplacements = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('fixed_assets')->where('study_id', $this->id)->pluck('depreciation_statement')->toArray();
        
        foreach ($fixedAssetReplacements as $index=>$fixedAssetReplacement) {
            $fixedAssetReplacement = json_decode($fixedAssetReplacement, true);
            $fixedAssetReplacement = $fixedAssetReplacement['replacement_cost']??[];
            $totalFixedAssetReplacements  = HArr::sumAtDates([$totalFixedAssetReplacements,$fixedAssetReplacement], $sumKeys);
        }
        $tableDataFormatted[1]['sub_items'][__('Fixed Asset Replacement Payments')]['data'] = $totalFixedAssetReplacements;
        $tableDataFormatted[1]['sub_items'][__('Fixed Asset Replacement Payments')]['year_total'] = HArr::sumPerYearIndex($totalFixedAssetReplacements, $yearWithItsMonths);
		
		
		
		
		
        
        $otherCreditors = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('other_credits_opening_balances')->where('study_id', $this->id)->pluck('statement', 'name')->toArray();
        $totalOtherCreditorsPerKey = HArr::formatMultiSubItemsPerKey($otherCreditors, $sumKeys, ['monthly','payment']);
        foreach ($totalOtherCreditorsPerKey as $keyName => $subItemTotal) {
            $id = 'other_credits_opening_balances'.$keyName;
            $tableDataFormatted[1]['sub_items'][$id]['data'] = $subItemTotal;
            $tableDataFormatted[1]['sub_items'][$id]['options']['title'] = $keyName;
            $tableDataFormatted[1]['sub_items'][$id]['year_total'] = HArr::sumPerYearIndex($subItemTotal, $yearWithItsMonths);
        }
        
        $longTermLoanOpeningBalances = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('long_term_loan_opening_balances')->where('study_id', $this->id)->get(['interests','installments','name'])->toArray();
        foreach ($longTermLoanOpeningBalances as $longTermLoanOpeningBalance) {
            $keyName = __('outstanding Payments').' ' .$longTermLoanOpeningBalance->name;
            $id = 'long_term_loan_opening_balances'.$keyName;
            $interests = json_decode($longTermLoanOpeningBalance->interests, true) ;
            $installments = json_decode($longTermLoanOpeningBalance->installments, true) ;
            $subItemTotal = HArr::sumAtDates([$interests,$installments], $sumKeys);
            $tableDataFormatted[1]['sub_items'][$id]['data'] = $subItemTotal;
            $tableDataFormatted[1]['sub_items'][$id]['options']['title'] = $keyName;
            $tableDataFormatted[1]['sub_items'][$id]['year_total'] = HArr::sumPerYearIndex($subItemTotal, $yearWithItsMonths);
        }
        
        $longTermLiabilitiesOpeningBalances = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('other_long_term_liabilities_opening_balances')->where('study_id', $this->id)->get(['payload','name'])->toArray();
        foreach ($longTermLiabilitiesOpeningBalances as $longTermLiabilitiesOpeningBalance) {
            $keyName = __('Other Long Term Liabilities Payments').' ' .$longTermLiabilitiesOpeningBalance->name;
            $id = 'other_long_term_liabilities_opening_balances'.$keyName;
            $payload = json_decode($longTermLiabilitiesOpeningBalance->payload, true) ;
            $tableDataFormatted[1]['sub_items'][$id]['data'] = $payload;
            $tableDataFormatted[1]['sub_items'][$id]['options']['title'] = $keyName;
            $tableDataFormatted[1]['sub_items'][$id]['year_total'] = HArr::sumPerYearIndex($payload, $yearWithItsMonths);
        }
         
        
        $totalCashOut = HArr::sumAtDates(array_column($tableDataFormatted[1]['sub_items']??[], 'data'), $sumKeys);
        $tableDataFormatted[1]['main_items']['cash-out-flow']['data'] = $totalCashOut;
        $tableDataFormatted[1]['main_items']['cash-out-flow']['year_total'] = $totalCashOutflowPerYear = HArr::sumPerYearIndex($totalCashOut, $yearWithItsMonths);
        // cash out

        
        
        $workingCapitalStatement = HArr::calculateWorkingCapital($cashAndBankAmount, $totalCashIn, $totalCashOut, $sumKeys);
         
        
         
         
        $workingCapitalStatement = HArr::calculateWorkingCapital($cashAndBankAmount, $totalCashIn, $totalCashOut, $sumKeys);
        /**
         * * Start Net Cash Before Working Capital;
        */
        $currentTabIndex = 2 ;
        $currentTabId = 'net-cash-before-working-capital';
        
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabId]['options'] = array_merge([
           'title'=>__('Net Cash Before Working Capital')
        ], $defaultNumericInputClasses);
        
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabId]['data'] = $currentData = $workingCapitalStatement['net_cash_before_working_capital']??[];

        
        /**
         * * End Net Cash Before Working Capital;
         */
        
        /**
         * * Start Net Cash Before Working Capital;
        */
        $currentTabIndex = 3 ;
        $currentTabId = 'working-capital-injection';
        
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabId]['options'] = array_merge([
           'title'=>__('Working Capital Injection')
        ], $defaultNumericInputClasses);
        $workingCapitalInjection = $workingCapitalStatement['working_capital_injection']??[] ;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabId]['data'] = $currentData = $workingCapitalInjection;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabId]['year_total'] =  $totalWorkingCapitalInjectionPerYear  = HArr::sumPerYearIndex($currentData, $yearWithItsMonths);
        
        
        
        
        
        /**
         * * End Net Cash Before Working Capital;
         */
        
        /**
         * * Start Cash And Bank End Balance;
        */
        $currentTabIndex = 4 ;
        $currentTabId = 'cash-and-bank-end-balance';
        
        $cashEndBalance = $workingCapitalStatement['cash_end_balance']??[] ;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabId]['options'] = array_merge([
           'title'=>__('Cash And Bank End Balance')
        ], $defaultNumericInputClasses);
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabId]['data'] = $currentData = $cashEndBalance;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabId]['year_total'] =  [];
        
        
        $tableDataFormatted[-1]['main_items']['cash-and-banks']['data'] = $workingCapitalStatement['beginning_balance'] ??[];
        $tableDataFormatted[-1]['main_items']['cash-and-banks']['year_total'] =$totalCashAndBanksPerYear =  HArr::getPerYearIndexForCashAndBank($workingCapitalStatement['beginning_balance'] ??[], $yearWithItsMonths);
        

       
        //  $totalCashIn = [];
        $statementData= [
            'monthly_cash_and_banks'=>$cashEndBalance,
            'study_id'=>$this->id,
            'monthly_working_capital_injection'=>$workingCapitalInjection,
            'monthly_equity_injection'=>$totalFixedAssetEquity
        ];
        $this->cashInOutStatement ?  $this->cashInOutStatement->update($statementData) : $this->cashInOutStatement()->create($statementData);

        return  [
          'financialYearEndMonthNumber'=>$financialYearEndMonthNumber,
          'years','studyMonthsForViews'=>$studyMonthsForViews,
          'study'=>$this,
          'tableDataFormatted'=>$tableDataFormatted,
          'defaultClasses'=>$defaultClasses,
          'title'=>__('Cash In Out Flow'),
          'tableTitle'=>__('Cash In Out Flow'),
          // 'nextRoute'=>route('balance.sheet.result', ['study'=>$study->id]),
            
        ];
    }
    
    
    public function getBalanceSheetViewVars()
    {
        $yearWithItsIndexes = $this->getOperationDurationPerYearFromIndexes();
        $monthsWithItsYear = $this->getMonthsWithItsYear($yearWithItsIndexes) ;
        $financialYearEndMonthNumber = '12';
        $defaultNumericInputClasses = [
            'number-format-decimals'=>0,
            'is-percentage'=>false,
            'classes'=>'repeater-with-collapse-input readonly',
            'formatted-input-classes'=>'custom-input-numeric-width readonly',
        ];
        $defaultPercentageInputClasses = [
            'classes'=>'',
            'formatted-input-classes'=>'ddd',
            'is-percentage'=>true ,
            'number-format-decimals'=> 2,
        ];
        $defaultClasses = [
            $defaultNumericInputClasses,
            $defaultPercentageInputClasses
        ];
        $studyMonthsForViews = $this->getStudyDates();
        $studyMonthsForViews = array_slice($studyMonthsForViews, 0, $this->getViewStudyEndDateAsIndex()+1);
        $yearWithItsMonths=$this->getYearIndexWithItsMonths();
        /**
         * * First Tap
         */
        $currentTabIndex = 0 ;
        
        
        $sumKeys = array_keys($studyMonthsForViews);
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Non Current Assets');
        $nonCurrentAssetTabIndex= $currentTabIndex;
        $currentTabIndex++;
        // مجموع حاجتين لسه تحت اللي هو
        // fixed asset + other long term assets
        // اللي هو الاتنين اللي تحته
        // DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('');
        
        
        //////////////////
        /**
         * * Start Fixed Assets
         */
           
           
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Fixed Assets'); // with subs [fixed asset statement end balance]
        $fixedAssetStatements = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('fixed_assets')->where('fixed_assets.study_id', $this->id)->join('fixed_asset_names', 'fixed_asset_names.id', '=', 'fixed_assets.name_id')->get(['depreciation_statement','name as title'])->toArray();
		 $fixedAssetOpeningBalancesEndBalances = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('fixed_asset_opening_balances')->where('study_id', $this->id)->pluck('statement')->toArray();
		  array_walk($fixedAssetOpeningBalancesEndBalances, function (&$value) {
			 $value = json_decode($value,true)['end_balance']??[];
        });
		$fixedAssetOpeningBalancesEndBalances = HArr::sumAtDates($fixedAssetOpeningBalancesEndBalances,$sumKeys);
		
		// $fixedAssetStatements = 

        $totalFixedAssets = [];
		/// fix this one
        foreach ($fixedAssetStatements as $fixedAssetStatement) {
            $title = $fixedAssetStatement->title;
            $depreciationStatement = json_decode($fixedAssetStatement->depreciation_statement, true);
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['options']['title'] = $title;
            $endBalance =$depreciationStatement['end_balance']??[];
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data']= $endBalance;
			$totalFixedAssets = HArr::sumAtDates([$totalFixedAssets , $endBalance  ], $sumKeys);
			$tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total']= HArr::getPerYearIndexForEndBalance($endBalance, $yearWithItsMonths);
        }
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $totalFixedAssets; // with subs [fixed asset statement end balance]
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = HArr::getPerYearIndexForEndBalance($totalFixedAssets, $yearWithItsMonths);
        $currentTabIndex++;
        /**
        * * End  Fixed Assets
        */
        /**
         * * Start Other Long Term Assets
         */
        $totalOtherLongTermAssets = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('other_long_term_assets_opening_balances')->where('study_id', $this->id)->pluck('statement')->toArray();
        $totalOtherLongTermAssets= HArr::formatMultiSubItems($totalOtherLongTermAssets, $sumKeys, ['monthly','end_balance']);
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Other Long Term Assets');  // statement from other long term assets [statement]
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $totalOtherLongTermAssets;  // statement from other long term assets [statement]
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = HArr::getPerYearIndexForEndBalance($totalOtherLongTermAssets, $yearWithItsMonths);  // statement from other long term assets [statement]
        $currentTabIndex++;
        /**
          * * End Other Long Term Assets
          */
          
        $tableDataFormatted[$nonCurrentAssetTabIndex]['main_items'][$nonCurrentAssetTabIndex]['data'] =  $totalNonCurrentAssets = HArr::sumAtDates([$totalFixedAssets ,$totalOtherLongTermAssets], $sumKeys) ;
        $tableDataFormatted[$nonCurrentAssetTabIndex]['main_items'][$nonCurrentAssetTabIndex]['year_total'] =  HArr::getPerYearIndexForEndBalance($totalNonCurrentAssets, $yearWithItsMonths);
          
        /**
         * * Start Other Long Term Assets
         */
        $currentAssetOrderIndex = $currentTabIndex;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Current Assets');
        /**
         * ! مجموع كذا حاجه تحتها
         * total [ customer receiabvles + other debtors ]
         */
        $currentTabIndex++;
        /**
         * *  End Other Long Term Assets
         */
        
        /**
         * *  Start Cash & banks
         */
        $monthlyCashAndBanks = $this->cashInOutStatement ? $this->cashInOutStatement->monthly_cash_and_banks : [];
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Cash & banks');   // من cash in out // save it
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $monthlyCashAndBanks;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = HArr::getPerYearIndexForEndBalance($monthlyCashAndBanks, $yearWithItsMonths);
        $currentTabIndex++;
        /**
         * *  End Cash & banks
         */
        
        /**
         * *  Start Customer Receivables
         */
         
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Customer Outstanding');
        $cashAndBankOpeningBalances = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('cash_and_bank_opening_balances')->where('study_id', $this->id)->pluck('statement')->toArray();
        $cashAndBankOpeningBalances= HArr::formatMultiSubItems($cashAndBankOpeningBalances, $sumKeys, ['monthly','end_balance']);
        
        $title = __('Existing Customer Outstanding');
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['options']['title'] =$title ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] =$cashAndBankOpeningBalances ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] = HArr::getPerYearIndexForEndBalance($cashAndBankOpeningBalances, $yearWithItsMonths) ;
         
         
        $totalLoanBalances = [];
        $loanAccuredInterestsWithEndBalances =  DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('portfolio_loan_type', 'portfolio')->where('study_id', $this->id)->get(['endBalance','accured_interest','revenue_stream_type','securitization_date_index','id'])->toArray();
		
        $totalPerCategory = HArr::sumLoanSchedulePerCategory($loanAccuredInterestsWithEndBalances, $sumKeys, 'revenue_stream_type', 'endBalance');
     
        foreach ($totalPerCategory as $categoryName => $sumArr) {
            $title = str_to_upper($categoryName);
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] = $sumArr;
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] = HArr::getPerYearIndexForEndBalance($sumArr, $yearWithItsMonths);
            $totalLoanBalances = HArr::sumAtDates([$sumArr,$totalLoanBalances], $sumKeys);
        }
        // $loanEndBalancesForPortfolioMortgages =  DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('portfolio_loan_type', 'portfolio')->where('revenue_stream_type',Study::PORTFOLIO_MORTGAGE)->where('study_id', $this->id)->get(['endBalance','revenue_stream_type'])->toArray();
        
        // $totalPerCategory = HArr::sumFromCurrentIndexToTheEnd($loanEndBalancesForPortfolioMortgages, $sumKeys);
        // $title = str_to_upper(Study::PORTFOLIO_MORTGAGE);
        // $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] = $totalPerCategory;
        // $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] = HArr::getPerYearIndexForEndBalance($totalPerCategory, $yearWithItsMonths);
        // $totalLoanBalances = HArr::sumAtDates([$totalPerCategory,$totalLoanBalances], $sumKeys);
        



        $loanDirectFactoringEndBalances =  DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('direct_factoring_breakdowns')->where('study_id', $this->id)->pluck('statement_end_balance')->toArray();
        $loanDirectFactoringEndBalances = HArr::sumJsonArr(array_values($loanDirectFactoringEndBalances), $sumKeys);
        $title = __('Direct Factoring');
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] = $loanDirectFactoringEndBalances;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] = HArr::getPerYearIndexForEndBalance($loanDirectFactoringEndBalances, $yearWithItsMonths);
            
        $eclStatement =  DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('ecl_and_new_portfolio_funding_rates')->where('study_id', $this->id)->pluck('accumulated_ecl_values')->toArray();
        $totalEcl = HArr::sumJsonArr($eclStatement, $sumKeys);
        $totalEcl = HArr::MultiplyWithNumber($totalEcl, -1);
        $title = __('ECL');
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] = $totalEcl;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] = HArr::getPerYearIndexForEndBalance($totalEcl, $yearWithItsMonths);
        $totalCustomerReceivables = HArr::sumAtDates([$cashAndBankOpeningBalances,$totalLoanBalances,$loanDirectFactoringEndBalances,$totalEcl], $sumKeys);
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $totalCustomerReceivables ;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = HArr::getPerYearIndexForEndBalance($totalCustomerReceivables, $yearWithItsMonths) ;
        $currentTabIndex++;
     
        
        /**
         * * other debtors [with his subs]   other_debtors_opening_balances  -> statement end balance
         *
         */
        
        /**
        * * Start Other Debtors
        */
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Other Debtors');  // statement from other long term assets [statement]
        $totalOtherDebtorsOpeningBalances = [];
        $otherDebtorsOpeningBalances = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('other_debtors_opening_balances')->where('study_id', $this->id)->pluck('statement', 'name')->toArray();
        foreach ($otherDebtorsOpeningBalances as $title => $otherDebtorsOpeningBalance) {
            $otherDebtorsOpeningBalance = (array)(json_decode($otherDebtorsOpeningBalance));
            $otherDebtorsOpeningBalance = (array)($otherDebtorsOpeningBalance['monthly']??[]);
            $otherDebtorsOpeningBalance = $otherDebtorsOpeningBalance['end_balance'];
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data']  = $otherDebtorsOpeningBalance ;
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total']  = HArr::getPerYearIndexForEndBalance($otherDebtorsOpeningBalance, $yearWithItsMonths) ;
            $totalOtherDebtorsOpeningBalances = HArr::sumAtDates([$totalOtherDebtorsOpeningBalances,$otherDebtorsOpeningBalance ], $sumKeys);
        }
        
        // $accruedInterestRevenues = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('study_id',$this->id)->where('portfolio_loan_type','portfolio')->pluck('accured_interest','revenue_stream_type')->toArray();
        $accruedInterestRevenues = $loanAccuredInterestsWithEndBalances;
        $totalAccruedInterestRevenuesPerCategory = [];
        foreach ($accruedInterestRevenues as $accruedInterestRevenue) {
            $revenueStreamName = $accruedInterestRevenue->revenue_stream_type;
            $securitizationDateAsIndex = $accruedInterestRevenue->securitization_date_index;
            $accruedInterestRevenue = $accruedInterestRevenue->accured_interest ? json_decode($accruedInterestRevenue->accured_interest, true) : [];
            $accruedInterestRevenue = $accruedInterestRevenue['monthly']['end_balance']??[];
            foreach ($sumKeys as $dateAsIndex) {
                $value = $accruedInterestRevenue[$dateAsIndex]??0;
                if (isSecuritized($securitizationDateAsIndex, $dateAsIndex)) {
                    $value = 0 ;
                }
                $totalAccruedInterestRevenuesPerCategory[$revenueStreamName][$dateAsIndex] = isset($totalAccruedInterestRevenuesPerCategory[$revenueStreamName][$dateAsIndex]) ? $totalAccruedInterestRevenuesPerCategory[$revenueStreamName][$dateAsIndex] + $value : $value ;
            }
            // $totalAccruedInterestRevenuesPerCategory[$revenueStreamName] = isset($totalAccruedInterestRevenuesPerCategory[$revenueStreamName]) ? HArr::sumAtDates([$totalAccruedInterestRevenuesPerCategory[$revenueStreamName],$accruedInterestRevenue], $sumKeys) : $accruedInterestRevenue;
            // $totalAccruedInterestRevenuesPerCategory[$revenueStreamName] = isset($totalAccruedInterestRevenuesPerCategory[$revenueStreamName]) ? HArr::sumAtDates([$totalAccruedInterestRevenuesPerCategory[$revenueStreamName],$accruedInterestRevenue], $sumKeys) : $accruedInterestRevenue;
            ;
        }
        foreach ($totalAccruedInterestRevenuesPerCategory as $categoryName => $currentAccruedInterestRevenueForCategory) {
            $categoryName = str_to_upper($categoryName) . ' ' . __('Accured Interest Revenues');
            $tableDataFormatted[$currentTabIndex]['sub_items'][$categoryName]['data']  = $currentAccruedInterestRevenueForCategory ;
            $tableDataFormatted[$currentTabIndex]['sub_items'][$categoryName]['year_total']  = HArr::getPerYearIndexForEndBalance($currentAccruedInterestRevenueForCategory, $yearWithItsMonths) ;
        }
        $totalAccruedInterestRevenues = HArr::sumAtDates(array_values($totalAccruedInterestRevenuesPerCategory), $sumKeys);
        $expenses = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('expenses')->where('relation_name', 'one_time_expense')->where('study_id', $this->id)->get();
        $totalExpensePerCategory = [];
        foreach ($expenses as $expense) {
            $expenseNameId = $expense->expense_name_id;
            $collectionStatements = json_decode($expense->payload, true);
            $collectionStatements = (array)($collectionStatements['end_balance']??[]);
            foreach ($collectionStatements as $dateIndex => $amount) {
                $totalExpensePerCategory[$expenseNameId][$dateIndex] = isset($totalExpensePerCategory[$expenseNameId][$dateIndex]) ? $totalExpensePerCategory[$expenseNameId][$dateIndex] + $amount : $amount;
            }
        }
        $totalPerType =[];
        foreach ($totalExpensePerCategory as $expenseNameId => $currentData) {
            $expenseName = ExpenseName::find($expenseNameId) ;
            $title = $expenseName ? $expenseName->getName() : __('N/A');
            $tableDataFormatted[$currentTabIndex]['sub_items'][$expenseNameId]['options'] =array_merge([
                'title'=>$title
            ], $defaultNumericInputClasses);
            $totalPerType[$expenseNameId] = isset($totalPerType[$expenseNameId]) ? HArr::sumAtDates([$totalPerType[$expenseNameId],$currentData], $sumKeys) : $currentData;
            $tableDataFormatted[$currentTabIndex]['sub_items'][$expenseNameId]['data'] = $totalPerType[$expenseNameId];
            $tableDataFormatted[$currentTabIndex]['sub_items'][$expenseNameId]['year_total'] = HArr::getPerYearIndexForEndBalance($totalPerType[$expenseNameId], $yearWithItsMonths);
        }
        $totalExpenses = HArr::sumAtDates(array_values($totalPerType), $sumKeys) ;
        $totalOtherDebtorsOpeningBalances = HArr::sumAtDates([$totalOtherDebtorsOpeningBalances , $totalExpenses], $sumKeys);
        
        
        
        $totalOtherDebtors = HArr::sumAtDates([$totalOtherDebtorsOpeningBalances ,$totalAccruedInterestRevenues ], $sumKeys);
        $totalCurrentAssets = HArr::sumAtDates([$totalOtherDebtors , $totalCustomerReceivables , $monthlyCashAndBanks], $sumKeys);
        $tableDataFormatted[$currentAssetOrderIndex]['main_items'][$currentAssetOrderIndex]['data'] = $totalCurrentAssets;
        $tableDataFormatted[$currentAssetOrderIndex]['main_items'][$currentAssetOrderIndex]['year_total'] = HArr::getPerYearIndexForEndBalance($totalCurrentAssets, $yearWithItsMonths);
        ;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $totalOtherDebtors;  // statement from other long term assets [statement]
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = HArr::getPerYearIndexForEndBalance($totalOtherDebtors, $yearWithItsMonths);  // statement from other long term assets [statement]
        $currentTabIndex++;
        
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Total Assets');
        $totalAssets = HArr::sumAtDates([$totalNonCurrentAssets , $totalCurrentAssets], $sumKeys);
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $totalAssets;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = HArr::getPerYearIndexForEndBalance($totalAssets, $yearWithItsMonths);
        $currentTabIndex++;
                
                
        /**
          * * End Other Debtors
          */
        $totalCurrentLiabilities = [];
        $totalCurrentLiabilitiesTabIndex = $currentTabIndex;
        $tableDataFormatted[$totalCurrentLiabilitiesTabIndex]['main_items'][$totalCurrentLiabilitiesTabIndex]['options']['title'] = __('Current Liabilities');
       
        $currentTabIndex++;
        
        
        /**
         * * current Labilities   دا هيكون مجموع حجات تانيه تحتيه ودا مين ملهوش صابات
         * Bank Loan Payables +  Other Creditors
         */
        $totalBankLoanPayable = [];
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Bank Loan Payables');
        $title = 'Existing Supplier Payable';
        $supplierPayableOpeningBalances = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('supplier_payable_opening_balances')->where('study_id', $this->id)->pluck('statement')->toArray();
        $supplierPayableOpeningBalances= HArr::formatMultiSubItems($supplierPayableOpeningBalances, $sumKeys, ['monthly','end_balance']);
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['options']['title'] =$title ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] =$supplierPayableOpeningBalances ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] =HArr::getPerYearIndexForEndBalance($supplierPayableOpeningBalances, $yearWithItsMonths) ;
        
        
        $totalLoanBalances = [];
        
        $loanAccuredInterestsExpensesWithEndBalances =  DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('portfolio_loan_type', 'bank_portfolio')->where('study_id', $this->id)->get(['endBalance','accured_interest','revenue_stream_type','securitization_date_index'])->toArray();
        $totalPerCategory = HArr::sumLoanSchedulePerCategory($loanAccuredInterestsExpensesWithEndBalances, $sumKeys, 'revenue_stream_type', 'endBalance');
        foreach ($totalPerCategory as $categoryName => $sumArr) {
            $title = str_to_upper($categoryName);
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] = $sumArr;
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] = HArr::getPerYearIndexForEndBalance($sumArr, $yearWithItsMonths);
            $totalLoanBalances = HArr::sumAtDates([$sumArr,$totalLoanBalances], $sumKeys);
        }
        $loanDirectFactoringEndBalances =  DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('direct_factoring_breakdowns')->where('study_id', $this->id)->pluck('bank_end_balance')->toArray();
        $loanDirectFactoringEndBalances = HArr::sumJsonArr(array_values($loanDirectFactoringEndBalances), $sumKeys);
        
        $title = __('Direct Factoring Loan Payable');
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['options']['title'] =$title ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] =$loanDirectFactoringEndBalances ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] =HArr::getPerYearIndexForEndBalance($loanDirectFactoringEndBalances, $yearWithItsMonths) ;
        
        
        $totalBankLoanPayable =  HArr::sumAtDates([$supplierPayableOpeningBalances,$totalLoanBalances,$loanDirectFactoringEndBalances,], $sumKeys);
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $totalBankLoanPayable;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = HArr::getPerYearIndexForEndBalance($totalBankLoanPayable, $yearWithItsMonths);
        $currentTabIndex++;
        
        
        
        
        
        
        /**
        * * Other Creditors [with its subs]
        * * Existing Other Creditors other_credits_opening_balances -> statement -> end balance
        * * for each expense sum for expense_name_id collection_statements -> end balance
        * * corporate taxes statement end balance [from income statement  ]
        */
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Other Creditors');
        $totalOtherCreditorsOpeningBalances = [];
        $otherCreditorsOpeningBalances = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('other_credits_opening_balances')->where('study_id', $this->id)->pluck('statement', 'name')->toArray();
        foreach ($otherCreditorsOpeningBalances as $title => $otherCreditorsOpeningBalance) {
            $otherCreditorsOpeningBalance = (array)(json_decode($otherCreditorsOpeningBalance));
            $otherCreditorsOpeningBalance = (array)($otherCreditorsOpeningBalance['monthly']??[]);
            $otherCreditorsOpeningBalance = $otherCreditorsOpeningBalance['end_balance'];
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data']  = $otherCreditorsOpeningBalance ;
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total']  = HArr::getPerYearIndexForEndBalance($otherCreditorsOpeningBalance, $yearWithItsMonths) ;
            $totalOtherCreditorsOpeningBalances = HArr::sumAtDates([$totalOtherCreditorsOpeningBalances,$otherCreditorsOpeningBalance ], $sumKeys);
        }

		 
        /**
         * * expenses
         */
        
        
        $expenses = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('expenses')->where('study_id', $this->id)->get();
        $totalExpensePerCategory = [];
		$totalWithholdEndBalancePerCategories = [];
        foreach ($expenses as $expense) {
            $expenseNameId = $expense->expense_name_id;
            $collectionStatements = json_decode($expense->collection_statements, true);
            $withholdStatements = json_decode($expense->withhold_statements, true);
            $collectionStatements = (array)($collectionStatements['monthly']??[]);
            $collectionStatements = (array)($collectionStatements['end_balance']??[]);
			$withholdStatementEndBalances =$withholdStatements['monthly']['end_balance']??[];
			
			// $withholdAmount = 
            foreach ($collectionStatements as $dateIndex => $amount) {
				$withholdAmount = $withholdStatementEndBalances[$dateIndex]??0;
                $totalExpensePerCategory[$expenseNameId][$dateIndex] = isset($totalExpensePerCategory[$expenseNameId][$dateIndex]) ? $totalExpensePerCategory[$expenseNameId][$dateIndex] + $amount : $amount;
                $totalWithholdEndBalancePerCategories[$dateIndex] = isset($totalWithholdEndBalancePerCategories[$dateIndex]) ? $totalWithholdEndBalancePerCategories[$dateIndex] + $withholdAmount : $withholdAmount;
            }
        }
        $totalPerType =[];
        foreach ($totalExpensePerCategory as $expenseNameId => $currentData) {
			$expenseName = ExpenseName::find($expenseNameId) ;
            $title = $expenseName ? $expenseName->getName() : __('N/A');
            $tableDataFormatted[$currentTabIndex]['sub_items'][$expenseNameId]['options'] =array_merge([
				'title'=>$title
            ], $defaultNumericInputClasses);
            $totalPerType[$expenseNameId] = isset($totalPerType[$expenseNameId]) ? HArr::sumAtDates([$totalPerType[$expenseNameId],$currentData], $sumKeys) : $currentData;
            $tableDataFormatted[$currentTabIndex]['sub_items'][$expenseNameId]['data'] = $totalPerType[$expenseNameId];
            $tableDataFormatted[$currentTabIndex]['sub_items'][$expenseNameId]['year_total'] = HArr::getPerYearIndexForEndBalance($totalPerType[$expenseNameId], $yearWithItsMonths);
        }
		
		$tableDataFormatted[$currentTabIndex]['sub_items']['credit-withhold-taxes']['options']['title'] = __('Credit Withhold Taxes');
		$tableDataFormatted[$currentTabIndex]['sub_items']['credit-withhold-taxes']['data'] = $totalWithholdEndBalancePerCategories;
		$tableDataFormatted[$currentTabIndex]['sub_items']['credit-withhold-taxes']['year_total'] = HArr::getPerYearIndexForEndBalance($totalWithholdEndBalancePerCategories , $yearWithItsMonths);
        $totalExpenses = HArr::sumAtDates(array_values($totalPerType), $sumKeys) ;
        
        
        
        
        
        $accruedInterestExpenses = $loanAccuredInterestsExpensesWithEndBalances;
        
        $totalAccruedInterestExpensesPerCategory = [];
        foreach ($accruedInterestExpenses as $accruedInterestExpense) {
    
            $revenueStreamName = $accruedInterestExpense->revenue_stream_type;
            $securitizationDateAsIndex = $accruedInterestExpense->securitization_date_index;
            
            $accruedInterestExpense = $accruedInterestExpense->accured_interest ? json_decode($accruedInterestExpense->accured_interest, true) : [];
            $accruedInterestExpense = $accruedInterestExpense['monthly']['end_balance']??[];
            
            foreach ($sumKeys as $dateAsIndex) {
                $value = $accruedInterestExpense[$dateAsIndex]??0;
                if (isSecuritized($securitizationDateAsIndex, $dateAsIndex)) {
                    $value = 0 ;
                }
                $totalAccruedInterestExpensesPerCategory[$revenueStreamName][$dateAsIndex] = isset($totalAccruedInterestExpensesPerCategory[$revenueStreamName][$dateAsIndex]) ? $totalAccruedInterestExpensesPerCategory[$revenueStreamName][$dateAsIndex] + $value : $value;
            }
            ;
        }
        foreach ($totalAccruedInterestExpensesPerCategory as $categoryName => $currentAccruedInterestExpenseForCategory) {
            $categoryName = str_to_upper($categoryName) . ' ' . __('Accured Interest Expenses');
            $tableDataFormatted[$currentTabIndex]['sub_items'][$categoryName]['data']  = $currentAccruedInterestExpenseForCategory ;
            $tableDataFormatted[$currentTabIndex]['sub_items'][$categoryName]['year_total']  = HArr::getPerYearIndexForEndBalance($currentAccruedInterestExpenseForCategory, $yearWithItsMonths) ;
        }
        $totalAccruedInterestExpenses = HArr::sumAtDates(array_values($totalAccruedInterestExpensesPerCategory), $sumKeys);
        
        
        

        
        $socialTaxesTitle = __('Salaries & Social Insurance Taxes');
        $salaryStatements = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('manpowers')->where('study_id', $this->id)->pluck('tax_and_social_insurance_statement')->toArray();
    
        $salaryStatementEndBalances =  HArr::formatMultiSubItems($salaryStatements, $sumKeys, ['monthly','end_balance']);
        $totalCorporateTaxes =  $totalCorporateTaxes['monthly']['end_balance']??[] ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$socialTaxesTitle]['options']['title'] = $socialTaxesTitle ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$socialTaxesTitle]['data'] = $salaryStatementEndBalances ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$socialTaxesTitle]['year_total'] = HArr::getPerYearIndexForEndBalance($salaryStatementEndBalances, $yearWithItsMonths) ;

        
        
        $corporateTaxesTitle = __('Corporate Taxes');
        $totalCorporateTaxes = $this->incomeStatement ? $this->incomeStatement->monthly_corporate_taxes_statements : [];
        $totalCorporateTaxes =  $totalCorporateTaxes['monthly']['end_balance']??[] ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$corporateTaxesTitle]['options']['title'] = $corporateTaxesTitle ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$corporateTaxesTitle]['data'] = $totalCorporateTaxes ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$corporateTaxesTitle]['year_total'] = HArr::getPerYearIndexForEndBalance($totalCorporateTaxes, $yearWithItsMonths) ;

        ///////////////
        $directFactoringUnearnedRevenues = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('direct_factoring_breakdowns')->where('study_id', $this->id)->pluck('end_balance')->toArray();
        $totalDirectFactoringUnearnedRevenues = HArr::sumJsonArr($directFactoringUnearnedRevenues, $sumKeys) ;
        foreach ($totalDirectFactoringUnearnedRevenues as $dateAsIndex => $value) {
            $totalDirectFactoringUnearnedRevenues[$dateAsIndex] = $value * - 1 ;
        }
        $title = __('Direct Factoring Unearned Revenues');
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['options']['title'] = $title ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] = $totalDirectFactoringUnearnedRevenues ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] = HArr::getPerYearIndexForEndBalance($totalDirectFactoringUnearnedRevenues, $yearWithItsMonths) ;
 
        
        $portfolioFactoringUnearnedRevenues = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('portfolio_mortgage_revenue_projection_by_categories')->where('study_id', $this->id)->pluck('portfolio_mortgage_unearned_interest_statement')->toArray();
		
        $portfolioEndBalances = [];
        foreach ($portfolioFactoringUnearnedRevenues as $portfolioFactoringUnearnedRevenue) {
            $portfolioFactoringUnearnedRevenueArr = json_decode($portfolioFactoringUnearnedRevenue, true);
			$portfolioFactoringUnearnedRevenueArr = $portfolioFactoringUnearnedRevenueArr ? $portfolioFactoringUnearnedRevenueArr : [];
            foreach ($portfolioFactoringUnearnedRevenueArr as $mainDateIndex => $result) {
                foreach ($result as $dateAsIndex => $resultArr) {
                    $currentEndBalance = $resultArr['end_balance']??0 ;
                    $portfolioEndBalances[$dateAsIndex] = isset($portfolioEndBalances[$dateAsIndex]) ? $portfolioEndBalances[$dateAsIndex] + $currentEndBalance : $currentEndBalance ;
                }
            }
        }
        foreach ($portfolioEndBalances as &$portfolioEndBalance) {
            $portfolioEndBalance  = $portfolioEndBalance*-1;
        }
        $title = __('Portfolio Unearned Revenues');
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['options']['title'] = $title ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] = $portfolioEndBalances ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] = HArr::getPerYearIndexForEndBalance($portfolioEndBalances, $yearWithItsMonths) ;
		
		 $totalFixedAssetPayables = [];
        $fixedAssetPayables = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('fixed_assets')->where('study_id', $this->id)->pluck('ffe_payable')->toArray();
        foreach ($fixedAssetPayables as $index=>$fixedAssetPayable) {
            $fixedAssetPayable = json_decode($fixedAssetPayable, true);
            $totalFixedAssetPayables  = HArr::sumAtDates([$totalFixedAssetPayables,$fixedAssetPayable], $sumKeys);
        }
		
		
		
		  $title = __('Fixed Assets Payable');
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['options']['title'] = $title ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data'] = $totalFixedAssetPayables ;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total'] = HArr::getPerYearIndexForEndBalance($totalFixedAssetPayables, $yearWithItsMonths) ;
 
		
        

        $totalExistOtherCreditors = HArr::sumAtDates([$totalOtherCreditorsOpeningBalances,$totalAccruedInterestExpenses,$totalExpenses,$totalWithholdEndBalancePerCategories,$totalCorporateTaxes,$salaryStatementEndBalances,$totalDirectFactoringUnearnedRevenues,$portfolioEndBalances,$totalFixedAssetPayables], $sumKeys);
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $totalExistOtherCreditors;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] =HArr::getPerYearIndexForEndBalance($totalExistOtherCreditors, $yearWithItsMonths);

        $totalCurrentLiabilities = HArr::sumAtDates([$totalExistOtherCreditors , $totalBankLoanPayable], $sumKeys);
        $tableDataFormatted[$totalCurrentLiabilitiesTabIndex]['main_items'][$totalCurrentLiabilitiesTabIndex]['data'] = $totalCurrentLiabilities;
        $tableDataFormatted[$totalCurrentLiabilitiesTabIndex]['main_items'][$totalCurrentLiabilitiesTabIndex]['year_total'] = HArr::getPerYearIndexForEndBalance($totalCurrentLiabilities, $yearWithItsMonths);
        $currentTabIndex++;
      
        
    
        
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Other Long Term Liabilities');  // statement from other long term assets [statement]
        
        
          
            
        /**
         * * Long Term Liabilitties [with its subs]
         * * other_long_term_liabilities_opening_balances -> statement -> end balance
         * * long_term_loan_opening_balances -> statement -> end balance
         * * for each fix asset name fixed_assets_loan_schedule_payments -> end_balance
         */
        
        $totalOtherLongTermsOpening = [];
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Long Term Liabilities');
        $totalAmountOtherLongTerm = 0 ;
        $otherLongTermsOpeningBalanceEndBalances =  DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('other_long_term_liabilities_opening_balances')->where('study_id', $this->id)->get();
        foreach ($otherLongTermsOpeningBalanceEndBalances->pluck('statement')->toArray() as $otherLongTermsOpeningBalanceEndBalance) {
            $otherLongTermsOpeningBalanceEndBalance= ((array)((array)json_decode($otherLongTermsOpeningBalanceEndBalance))['monthly']??[])['end_balance']??[];
            $totalOtherLongTermsOpening = HArr::sumAtDates([$totalOtherLongTermsOpening,$otherLongTermsOpeningBalanceEndBalance], $sumKeys);
            $currentAmount = $otherLongTermsOpeningBalanceEndBalances[0]->amount ;
            $totalAmountOtherLongTerm += $currentAmount ;
        }
        $currentDataArr = $totalOtherLongTermsOpening ;
        $title = __('Other Long Term Liabilities');
        $currentTabId = $title ;
        
        
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['options'] = array_merge([
           'title'=>$title
        ], $defaultNumericInputClasses);
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['data'] = $currentDataArr;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['year_total'] =HArr::getPerYearIndexForEndBalance($currentDataArr, $yearWithItsMonths) ;
        
        
        /**
         * * End Key
         */
        
        $totalLoansOpening = [];
        $loansOpeningBalanceEndBalances =  DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('long_term_loan_opening_balances')->where('study_id', $this->id)->pluck('statement')->toArray();
        foreach ($loansOpeningBalanceEndBalances as $loansOpeningBalanceEndBalance) {
            $loansOpeningBalanceEndBalance= ((array)((array)json_decode($loansOpeningBalanceEndBalance))['monthly']??[])['end_balance']??[];
            $totalLoansOpening = HArr::sumAtDates([$totalLoansOpening,$loansOpeningBalanceEndBalance], $sumKeys);
        }
        
        
      
        $fixedAssetStatements = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('fixed_assets_loan_schedule_payments')->where('fixed_assets_loan_schedule_payments.study_id', $this->id)->join('fixed_assets', 'fixed_assets.id', '=', 'fixed_assets_loan_schedule_payments.fixed_asset_id')->join('fixed_asset_names', 'fixed_asset_names.id', '=', 'fixed_assets.name_id')->get(['endBalance','name as title'])->toArray();
        $totalFixedAssets = [];
        foreach ($fixedAssetStatements as $fixedAssetStatement) {
            $title = $fixedAssetStatement->title;
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['options']['title'] = $title;
            $endBalance = json_decode($fixedAssetStatement->endBalance, true);
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['data']= $endBalance;
            $totalFixedAssets = HArr::sumAtDates([$totalFixedAssets , $endBalance  ], $sumKeys);
            $tableDataFormatted[$currentTabIndex]['sub_items'][$title]['year_total']= HArr::getPerYearIndexForEndBalance($endBalance, $yearWithItsMonths);
        }
     
        $totalLongTermLiabilities = HArr::sumAtDates([$totalLoansOpening,$totalOtherLongTermsOpening,$totalFixedAssets], $sumKeys);
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $totalLongTermLiabilities;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = HArr::getPerYearIndexForEndBalance($totalLongTermLiabilities, $yearWithItsMonths);
        
        /**
         * * Start Key
         */
        
      
        $currentDataArr = $totalLoansOpening;
        ;
        $title = __('Long Term Loan');
        $currentTabId = $title ;
        
        
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['options'] = array_merge([
           'title'=>$title
        ], $defaultNumericInputClasses);
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['data'] = $currentDataArr;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['year_total'] =HArr::getPerYearIndexForEndBalance($currentDataArr, $yearWithItsMonths) ;
        $currentTabIndex++;
        /**
         * * End Key
         */
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Total Shareholders Equity');
        
        /**
         * * Start Key
         */

        
        $equityOpeningBalance = count($this->equityOpeningBalances) ? $this->equityOpeningBalances[0] : null;
        
        $paidUpCapitals = $equityOpeningBalance ? $equityOpeningBalance->getExtendedPaidUpCapitalAmount() : [];
        $currentDataArr =$paidUpCapitals ;
        ;
        $title = __('Paid Up Capital');
        $currentTabId = $title ;
        
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['options'] = array_merge([
           'title'=>$title
        ], $defaultNumericInputClasses);
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['data'] = $currentDataArr;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['year_total'] =HArr::getPerYearIndexForEndBalance($currentDataArr, $yearWithItsMonths) ;
        /**
         * * End Key
         */
        
        
        
        
        /**
         * * Start Key
         * !!
         */
        $cashInOutStatement =  $this->cashInOutStatement;
        $workingCapitalInjection = $cashInOutStatement ? $cashInOutStatement->monthly_working_capital_injection : [];
        $equityInjection = $cashInOutStatement ? $cashInOutStatement->monthly_equity_injection : [];

        $additionalPaidUpCapital = HArr::accumulateArray(HArr::sumAtDates([$workingCapitalInjection,$equityInjection], $sumKeys)) ;
        $currentDataArr =$additionalPaidUpCapital;
        ;
        $title = __('Additional Paid Up Capital');
        $currentTabId = $title ;
     
        
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['options'] = array_merge([
           'title'=>$title
        ], $defaultNumericInputClasses);
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['data'] = $currentDataArr;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['year_total'] =HArr::getPerYearIndexForEndBalance($currentDataArr, $yearWithItsMonths) ;
      
        
        
        /**
         * * Start Key
         */

        
        $legalReserve = $equityOpeningBalance ? $equityOpeningBalance->getExtendedLegalReserveAmount() : [];
        $currentDataArr =$legalReserve ;
        ;
        $title = __('Legal Reserve');
        $currentTabId = $title ;
        
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['options'] = array_merge([
           'title'=>$title
        ], $defaultNumericInputClasses);
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['data'] = $currentDataArr;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['year_total'] =HArr::getPerYearIndexForEndBalance($currentDataArr, $yearWithItsMonths) ;
        /**
        //  * * End Key
        //  */
        
        // /**
        //  * * Start Key
        //  */

        $incomeStatement  = $this->incomeStatement;
        $accumulatedRetainedEarnings = $incomeStatement ? $incomeStatement->accumulated_retained_earnings : [];
        
        $currentDataArr =$accumulatedRetainedEarnings ;
        ;
        $title = __('Retained Earnings');
        $currentTabId = $title ;
        
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['options'] = array_merge([
           'title'=>$title
        ], $defaultNumericInputClasses);
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['data'] = $currentDataArr;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['year_total'] =HArr::getPerYearIndexForFirstMonthInYear($currentDataArr, $yearWithItsMonths) ;
        
        
        
        /**
         * * End Key
         */
        
        
        $incomeStatement  = $this->incomeStatement;
        $netProfit = $incomeStatement ? $incomeStatement->monthly_net_profit : [];
        
        $currentDataArr =$netProfit ;
        ;
        $title = __('Net Profit');
        $currentTabId = $title ;
        
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['options'] = array_merge([
           'title'=>$title
        ], $defaultNumericInputClasses);
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['data'] = $currentDataArr;
        $tableDataFormatted[$currentTabIndex]['sub_items'][$currentTabId]['year_total'] =HArr::getPerYearIndexForFirstMonthInYear($currentDataArr, $yearWithItsMonths) ;
        
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $totalShareholderEquity = HArr::sumAtDates([$paidUpCapitals,$additionalPaidUpCapital,$legalReserve,$accumulatedRetainedEarnings,$netProfit], $sumKeys);
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = HArr::getPerYearIndexForFirstMonthInYear($totalShareholderEquity, $yearWithItsMonths);
        
        $currentTabIndex++;
        $sum = HArr::sumAtDates([$totalCurrentLiabilities,$totalLongTermLiabilities,$totalShareholderEquity], $sumKeys);
        $annuallyCheckError=[];
        //   $annuallyCheckError = HArr::sumAtDates([$totalCurrentLiabilities,$totalLongTermLiabilities,$totalShareholderEquity], $sumKeys);
        $checkErrors = HArr::subtractAtDates([$totalAssets,$sum], $sumKeys);
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['data'] = $checkErrors ;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = $annuallyCheckError ;
        /**
         * ! annualy
         */
        // $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['year_total'] = $checkErrors ;
        $tableDataFormatted[$currentTabIndex]['main_items'][$currentTabIndex]['options']['title'] = __('Check Error');

        // $totalLongTermLiabilities
        
       
        
      
        
        /**
         * * Total Shareholders Equity [with its subs]
         * * paid up capital  equity_opening_balances -> paid_up_capital_extended
         * * legal reserve  equity_opening_balances -> legal_reserve_extended
         * * retained earnings [function in mainfacturing pro]
         * * net profit [from income statement]
         */
        /**
         * * check error
         */
        
        
        // end_balance
             
        /**
         * *
         */
        
        return  [
          'financialYearEndMonthNumber'=>$financialYearEndMonthNumber,
          'years','studyMonthsForViews'=>$studyMonthsForViews,
          'study'=>$this,
          'tableDataFormatted'=>$tableDataFormatted,
          'defaultClasses'=>$defaultClasses,
          'title'=>__('Balance Sheet'),
          'tableTitle'=>__('Balance Sheet'),
          // 'nextRoute'=>route('balance.sheet.result', ['study'=>$study->id]),
            
        ];
    }
    
    public function getViewStudyEndDateAsIndex():int
    {
        return $this->getIndexDateFromString($this->getViewStudyEndDate());
    }
    public function getViewStudyEndDate(): ?string
    {
        return $this->study_end_date;
    }
    /**
     * * extended
     */
    public function getOperationDatesAsDateAndDateAsIndex()
    {
        $operationsYearAndItsMonths = $this->getOperationDurationPerYearFromIndexesForAllStudyInfo();
        $result =[];
        foreach ($operationsYearAndItsMonths as $yearAsIndex => $itsMonths) {
            foreach ($itsMonths as $dateAsIndex => $val) {
                $result[$this->getDateFromDateIndex($dateAsIndex)] =$dateAsIndex ;
            }
        }
        return $result;
        
    }
    /**
     *  to study end date
     */
    public function getOperationDatesAsDateAndDateAsIndexToStudyEndDate()
    {
        
        $operationsYearAndItsMonths = $this->getOperationDurationPerYearFromIndexesForAllStudyInfo();
        $studyEndDateAsIndex = $this->getStudyEndDateAsIndex() ;
        // array_pop($operationsYearAndItsMonths);
        $result =[];
        foreach ($operationsYearAndItsMonths as $yearAsIndex => $itsMonths) {
            foreach ($itsMonths as $dateAsIndex => $val) {
                if ($dateAsIndex <= $studyEndDateAsIndex) {
                    $result[$this->getDateFromDateIndex($dateAsIndex)] =$dateAsIndex ;
                }
            }
        }
        return $result;
        
    }
    public function convertYearIndexToActiveMonthIndexes(array $values)
    {
        $result = [];
        $yearIndexWithItsActiveMonths = $this->getYearIndexWithItsMonthsAsIndexAndString() ;
        foreach ($values as $yearIndex => $amount) {
            $activeMonths = $yearIndexWithItsActiveMonths[$yearIndex];
            $numberOfActiveMonths = count($activeMonths);
            $monthlyAmount = $amount / $numberOfActiveMonths;
            foreach ($activeMonths as $monthIndex => $monthAsString) {
                $result[$monthIndex]=$monthlyAmount;
            }
        }
        return $result;
    }
    public function getCorporateTaxesPayable():float
    {
        $corporateTaxesPayable = DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('vat_and_credit_withhold_tax_opening_balances')->where('study_id', $this->id)->first();
        return $corporateTaxesPayable ? $corporateTaxesPayable->corporate_taxes_payable  : 0 ;
    }
    public function getRevenueRoute(string $nextRevenueId):string
    {
        $allRevenueRoutes = [
            [
                'id'=>Study::LEASING,
                'can_show'=> $this->hasLeasing() ,
                'route'=>route('create.leasing.revenue.stream.breakdown', ['company'=>$this->company->id,'study'=>$this->id]),
            ],
            [
                    'id'=>Study::DIRECT_FACTORING,
                'can_show'=> $this->hasDirectFactoring() ,
                'route'=>route('create.direct.factoring.revenue.stream.breakdown', ['company'=>$this->company->id,'study'=>$this->id]),
            ],
            [
                    'id'=>Study::REVERSE_FACTORING,
                'can_show'=> $this->hasReverseFactoring() ,
                'route'=>route('create.reverse.factoring.revenue.stream.breakdown', ['company'=>$this->company->id,'study'=>$this->id]),
            ],
            [
                    'id'=>Study::IJARA,
                'can_show'=> $this->hasIjaraMortgage() ,
                'route'=>route('create.ijara.mortgage.revenue.stream.breakdown', ['company'=>$this->company->id,'study'=>$this->id]),
            ],
            [
                    'id'=>Study::PORTFOLIO_MORTGAGE,
                'can_show'=> $this->hasPortfolioMortgage() ,
                'route'=>route('create.portfolio.mortgage.revenue.stream.breakdown', ['company'=>$this->company->id,'study'=>$this->id]),
            ],
            [
                    'id'=>Study::MICROFINANCE,
                'can_show'=> $this->hasMicroFinance() ,
                'route'=>$this->getMicrofinanceFirstPage(),
            ],
            [
                'id'=>Study::SECURITIZATION,
                'can_show'=> $this->hasSecuritization() ,
                'route'=>route('create.securitization', ['company'=>$this->company->id,'study'=>$this->id]),
            ],
        ] ;
        $canReturn = false ;
        foreach ($allRevenueRoutes as $index => $revenueRouteArr) {
            if ($revenueRouteArr['id'] == $nextRevenueId) {
                $canReturn = true ;
            }
            if ($canReturn && $revenueRouteArr['can_show']) {
                return $revenueRouteArr['route'];
            }
        }
        return route('view.manpower.for.non.banking', ['company'=>$this->company->id,'study'=>$this->id]);
    
    }
    
    public function sumTwoArrayUntilIndex(array $first, array $second, int $limitDateAsIndex):array
    {
        $dates = array_values(array_unique(array_merge(array_keys($first), array_keys($second))));
        $result = [];
        foreach ($dates as $dateAsIndex) {
            if ($dateAsIndex<=$limitDateAsIndex) {
                $secondVal = $second[$dateAsIndex] ?? 0;
                $value = $first[$dateAsIndex] ?? 0;
                $result[$dateAsIndex] = $value  + $secondVal;
            } else {
                $result[$dateAsIndex] = 0;
            }
        }
        return $result;
    }
    public function convertArrayOfIndexKeysToIndexAsDateStringWithItsOriginalValue(array $items, array $datesAsStringAndIndex)
    {
        $newItems = [];

        foreach ($items as $dateAsIndex=>$value) {
            if (is_numeric($dateAsIndex)) {
                $newItems[$dateAsIndex]=$value;
            } else {
                $newItems[$datesAsStringAndIndex[$dateAsIndex]]=$value;
            }
        }

        return $newItems;
    }
    public function getLoanStructure(string $fixedAssetType)
    {
        return $this->getFixedAssetStructureForFixAssetType($fixedAssetType);
    }
    // $sumKeys == study dates
   
    public function getCalculatedExtendedStudyDates():array
    {
        return range(0, $this->duration_in_years * 12 +11);
    }
    public function cashInOutStatement():HasOne
    {
        return $this->hasOne(CashInOutStatement::class, 'study_id', 'id');
    }
    public function incomeStatement():HasOne
    {
        return $this->hasOne(IncomeStatement::class, 'study_id', 'id');
    }
    public function getFixedAssetsWithCountsDates(string $fixedAssetType)
    {
        $result = [];
        $ffeCounts = $this->fixedAssets->where('type', $fixedAssetType)->pluck('ffe_counts')->toArray();
    
        foreach ($ffeCounts as $index => $monthCount) {
            foreach ($monthCount as $monthAsIndex => $count) {
                if ($count) {
                    $result[$monthAsIndex] = $monthAsIndex;
                }
            }
            
        }
        ksort($result);
        return $result;
    }
    public function getTotalCostForAllTypesAtIndex(array $counts, string $fixedAssetType, int $dateAsIndex)
    {
        $totalCost = 0;
        $this->fixedAssets->where('type', $fixedAssetType)->each(function (FixedAsset $fixedAsset) use ($counts, $dateAsIndex, &$totalCost) {
            $totalCost += $fixedAsset->getTotalItemCostAtDateIndex($dateAsIndex);
        });
        return $totalCost;
        
    }
    public function getMicrofinanceBranches():array
    {
        return $this->microfinance_branch_ids?:[];
    }
    public function getMicrofinanceProductMixCount():int
    {
        return $this->microfinance_product_mix_count?:1;
    }
    public function getMicrofinanceProductMixOrExistingBranch()
    {
        return $this->microfinance_product_mix_or_existing_branch;
    }
    public function isMicrofinanceExistingBranch():bool
    {
        return $this->getMicrofinanceProductMixOrExistingBranch() == 'existing-branch';
    }
    public function isMicrofinanceProductMix():bool
    {
        return $this->getMicrofinanceProductMixOrExistingBranch() == 'product-mix';
    }
    public function getExistingBranchCounts():int
    {
        return $this->existing_branches_counts ?: $this->company->existingBranches->count();
    }
    public function microfinanceProductSalesProjects()
    {
        return $this->hasMany(MicrofinanceProductSalesProject::class, 'study_id', 'id');
    }
    public function microfinanceLoanOfficerCases()
    {
        return $this->hasMany(MicrofinanceLoanOfficerCasesProjection::class, 'study_id', 'id');
    }
	public function isByBranchMicrofinance():bool
	{
		return $this->microfinance_type == 'by-branch';
	}
    public function recalculateMicrofinanceTotalCasesCounts(string $type):void
    {
		RevenueContract::where('study_id',$this->id)->where('revenue_type',Study::MICROFINANCE)->delete();
		$monthlyAmountsAndContractsPerProductIds = [];
        if ($this->isMonthlyStudy()) {
            $totalLoanOfficerCases = [];
            $this->microfinanceLoanOfficerCases->where('type',$type)->each(function (MicrofinanceLoanOfficerCasesProjection $microfinanceLoanOfficerCasesProjection) use (&$totalLoanOfficerCases) {
				$totalExistingOfficersCasesCounts = $microfinanceLoanOfficerCasesProjection->total_existing_officers_cases_count?:[];
				$totalNewOfficersCasesCounts = $microfinanceLoanOfficerCasesProjection->total_new_officers_cases_count?:[];
				$totalLoanOfficerCases = HArr::sumAtDates([$totalLoanOfficerCases,$totalExistingOfficersCasesCounts,$totalNewOfficersCasesCounts],array_keys($totalNewOfficersCasesCounts));
				
            });
            $currentTotalCases = [];
            $monthlyLoanAmounts = [];
			/////////////////
            $this->microfinanceProductSalesProjects->where('type',$type)->each(function (MicrofinanceProductSalesProject $microfinanceProductSalesProject) use (&$currentTotalCases, &$monthlyLoanAmounts, $totalLoanOfficerCases,&$monthlyAmountsAndContractsPerProductIds) {
				$productId = $microfinanceProductSalesProject->microfinance_product_id;
                foreach ($microfinanceProductSalesProject->monthly_product_mixes?:[] as $dateAsIndex => $mixRate) {
                    $mixRate = $mixRate / 100;
                    $currentLoanOfficerCase = $totalLoanOfficerCases[$dateAsIndex]??0;
                    $currentMonthlyAmounts = $microfinanceProductSalesProject->monthly_amounts[$dateAsIndex];
					$currentCases = $currentLoanOfficerCase * $mixRate ;
                    $currentTotalCases[$dateAsIndex] = $currentCases  ;
					$currentMonthlyLoanAmount = $currentMonthlyAmounts *  $currentTotalCases[$dateAsIndex];
                    $monthlyLoanAmounts[$dateAsIndex] =$currentMonthlyLoanAmount  ;
					// $monthlyAmountsAndContractsPerProductIds[$productId]['monthly_loan_amounts'][$dateAsIndex] = isset($monthlyAmountsAndContractsPerProductIds[$productId]['monthly_loan_amounts'][$dateAsIndex]) ? $monthlyAmountsAndContractsPerProductIds[$productId]['monthly_loan_amounts'][$dateAsIndex] + $currentMonthlyLoanAmount : $currentMonthlyLoanAmount; 
					// $monthlyAmountsAndContractsPerProductIds[$productId]['contract_counts'][$dateAsIndex] = isset($monthlyAmountsAndContractsPerProductIds[$productId]['contract_counts'][$dateAsIndex]) ? $monthlyAmountsAndContractsPerProductIds[$productId]['contract_counts'][$dateAsIndex] + $currentCases : $currentCases; 
              
				}
				
                $microfinanceProductSalesProject->update([
                    'total_cases_counts'=>$currentTotalCases,
                    'monthly_loan_amounts'=>$monthlyLoanAmounts
                ]);
                
            });
            
        } else 
            {
				$yearWithItsIndexes = $this->getOperationDurationPerYearFromIndexesForAllStudyInfo();
            $monthIndexWithYearIndex = $this->getMonthsWithItsYear($yearWithItsIndexes);
			$totalCasesPerYear=[];
            $this->microfinanceLoanOfficerCases->where('type',$type)->each(function (MicrofinanceLoanOfficerCasesProjection $microfinanceLoanOfficerCasesProjection) use (&$totalCasesPerYear,$monthIndexWithYearIndex,$type) {
                $totalExistingCasesCounts = $microfinanceLoanOfficerCasesProjection->total_existing_officers_cases_count ;
                
                $totalNewOfficersCaseCount  = $microfinanceLoanOfficerCasesProjection->total_new_officers_cases_count ;
                $yearWithItsMonths=$this->getYearIndexWithItsMonths();
                unset($yearWithItsMonths[array_key_last($yearWithItsMonths)]);
                $totalExistingCasesCountsPerYear = HArr::sumPerYearIndex($totalExistingCasesCounts, $yearWithItsMonths);
                $totalNewOfficersCaseCountPerYear = HArr::sumPerYearIndex($totalNewOfficersCaseCount, $yearWithItsMonths);
                $years = count($totalNewOfficersCaseCountPerYear) ? array_keys($totalNewOfficersCaseCountPerYear) : array_keys($totalExistingCasesCountsPerYear);
                $totalCasesPerYear = HArr::sumAtDates([$totalCasesPerYear,$totalExistingCasesCountsPerYear,$totalNewOfficersCaseCountPerYear], $years);
               
            });
			
			 $result = [];
                $this->microfinanceProductSalesProjects->where('type',$type)->each(function (MicrofinanceProductSalesProject $microfinanceProductSalesProject) use ($totalCasesPerYear, &$result, $monthIndexWithYearIndex) {
						$productId = $microfinanceProductSalesProject->microfinance_product_id;
                    foreach ($microfinanceProductSalesProject->product_mixes?:[] as $yearIndex => $productMixRate) {
                        $currentTotalCase = array_values($totalCasesPerYear)[$yearIndex]??0;
                        $result[$yearIndex] = $productMixRate /100  * $currentTotalCase;
                    }
                    $monthlySeasonality = $microfinanceProductSalesProject->monthly_seasonality;
                    $monthlyAmounts = $microfinanceProductSalesProject->monthly_amounts;
                    $monthlyCases = [];
                    $monthlyLoanAmounts = [];
                    foreach ($monthlySeasonality as $monthIndex => $seasonalityValue) {
                        $currentYearIndex = $monthIndexWithYearIndex[$monthIndex];
                        $currentResult = ($result[$currentYearIndex]??0) *$seasonalityValue;
						$currentCases = $currentResult;
                        $monthlyCases[$monthIndex] = $currentCases    ;
						$currentMonthlyLoanAmount = $currentCases  * ($monthlyAmounts[$monthIndex]??0);
                        $monthlyLoanAmounts[$monthIndex] = $currentMonthlyLoanAmount;
						// $monthlyAmountsAndContractsPerProductIds[$productId]['monthly_loan_amounts'][$monthIndex] = isset($monthlyAmountsAndContractsPerProductIds[$productId]['monthly_loan_amounts'][$monthIndex]) ? $monthlyAmountsAndContractsPerProductIds[$productId]['monthly_loan_amounts'][$monthIndex] + $currentMonthlyLoanAmount : $currentMonthlyLoanAmount; 
						// $monthlyAmountsAndContractsPerProductIds[$productId]['contract_counts'][$monthIndex] = isset($monthlyAmountsAndContractsPerProductIds[$productId]['contract_counts'][$monthIndex]) ? $monthlyAmountsAndContractsPerProductIds[$productId]['contract_counts'][$monthIndex] + $currentCases : $currentCases; 
					
                    }
				//	logger($microfinanceLoanOfficerCasesProjection->id.'-'.$microfinanceProductSalesProject->id.'-'. json_encode($monthlyCases));
                    $microfinanceProductSalesProject->update([
                        'monthly_loan_amounts'=>$monthlyLoanAmounts,
                        'total_cases_counts'=>$monthlyCases
                    ]);
                });
			
			
			
			}
			$this->refresh();
			$monthlyAmountsAndContractsPerProductIds = [];
			foreach($this->microfinanceProductSalesProjects as $microfinanceProductSalesProject){
				$monthlyLoanAmounts = $microfinanceProductSalesProject->monthly_loan_amounts?:[];
				$currentCases = $microfinanceProductSalesProject->total_cases_counts?:[];
				$productId = $microfinanceProductSalesProject->microfinance_product_id;
				foreach($monthlyLoanAmounts as $monthIndex => $currentMonthlyLoanAmount ){
					$currentCase = $currentCases[$monthIndex]??0;
					$monthlyAmountsAndContractsPerProductIds[$productId]['monthly_loan_amounts'][$monthIndex] = isset($monthlyAmountsAndContractsPerProductIds[$productId]['monthly_loan_amounts'][$monthIndex]) ? $monthlyAmountsAndContractsPerProductIds[$productId]['monthly_loan_amounts'][$monthIndex] + $currentMonthlyLoanAmount : $currentMonthlyLoanAmount; 
					$monthlyAmountsAndContractsPerProductIds[$productId]['contract_counts'][$monthIndex] = isset($monthlyAmountsAndContractsPerProductIds[$productId]['contract_counts'][$monthIndex]) ? $monthlyAmountsAndContractsPerProductIds[$productId]['contract_counts'][$monthIndex] + $currentCase : $currentCase; 
					
				}
					
						
			}
			
	
		foreach($monthlyAmountsAndContractsPerProductIds as $productId => $monthlyLoanWithContractCount){
			$monthlyLoans = $monthlyLoanWithContractCount['monthly_loan_amounts'];
			$contractCounts = $monthlyLoanWithContractCount['contract_counts'];
			$companyId = $this->company->id;
			$studyId = $this->id;
			RevenueContract::create([
				'study_id'=>$studyId,
				'company_id'=>$companyId,
				'category_id'=>$productId,
				'monthly_loan_amounts'=>$monthlyLoans,
				'contract_counts'=>$contractCounts,
				'revenue_type'=>Study::MICROFINANCE,
			]);
		}
        
    }
    public function saveManpowerForm($request, $manpowerType = 'general' , $branchId = null)
    {
        $study = $this;
        $dateAsIndexes = $study->getDateWithDateIndex();
        $company = $this->company;
        foreach ($request->get('manpowers', []) as $positionId => $manpowerArr) {
            $position = Position::find($positionId);
            $manpower = $position->manpowers->where('type', $manpowerType)->where('study_id', $study->id)->first() ;
            $manpower = $manpower ?:new Manpower ;
            $manpower->position_id = $positionId;
            $manpower->type = $manpowerType;
            $manpower->study_id = $study->id;
            $manpower->branch_id = $branchId;
            $manpower->company_id = $company->id;
            $hiringCounts = $manpowerArr['hiring_counts'];
            $manpower->hiring_counts = $hiringCounts;
            $monthlyNetSalary = $manpowerArr['monthly_net_salary'];
            $manpower->monthly_net_salary =$monthlyNetSalary ;
            $currentExistingCount = $manpowerArr['existing_count'];
            $manpower->existing_count = $currentExistingCount;
            $operationStartDateAsIndex = $study->operation_start_month;
            $salaryTaxesRate = $study->getSalaryTaxesRate() / 100;
            $socialInsuranceRate = $study->getSocialInsuranceRate() /100 ;
            $additionalDatabaseResult =  $study->calculateManpowerResult($dateAsIndexes, $currentExistingCount, $hiringCounts, $operationStartDateAsIndex, $monthlyNetSalary, $salaryTaxesRate, $socialInsuranceRate);
		
		
                
            foreach ($additionalDatabaseResult as $columnName => $payload) {
                $manpower[$columnName] = $payload;
            }
            $manpower->save();
                
        }
    }
    /**
     * * From Request
     * * الافضل نسيفها بالكامل الاول بعدين نعمل اعادة حسبه
     */
    // public function handleFixedRepeatingExpenses(Request $request)
    // {
    // 	 $modelId = $request->get('model_id');
    //     $modelName = $request->get('model_name');
    //     $expenseType = $request->get('expense_type');
    // 	$isAllBranchExpense = $expenseType == 'all-branches'  ;
    // 	$numberOfBranches = $isAllBranchExpense ?  $this->getExistingBranchCounts() : 1 ;
    // 	$monthlyFixedRepeatingAmountEquation = new MonthlyFixedRepeatingAmountEquation;
    // 	 $datesAsStringDateIndex = $this->getDatesAsStringAndIndex();
    //     $datesAsIndexAndString = array_flip($datesAsStringDateIndex);
    //     $operationStartDateAsIndex = $datesAsStringDateIndex[$this->getOperationStartDate()];
    //     $studyExtendedEndDateAsIndex = Arr::last($datesAsStringDateIndex);
    //     $studyEndDateAsIndex = $this->getStudyEndDateAsIndex($datesAsStringDateIndex, $this->getStudyEndDate());
    //     $dateIndexWithDate = $this->getDateIndexWithDate();
    //     $model = ('\App\Models\\NonBankingService\\'.$modelName)::find($modelId);
    //     foreach (['fixed_monthly_repeating_amount'] as $tableId) {
    //         #::delete all
    //         $model->generateRelationDynamically($tableId, $expenseType)->delete();
    //         foreach ((array)$request->get($tableId) as $tableDataArr) {
    //             $tableDataArr['study_id'] = $this->id;
    //             $withholdRate = $tableDataArr['withhold_tax_rate']??0;
            
    //             if (isset($tableDataArr['start_date']) && count(explode('-', $tableDataArr['start_date'])) == 2) {
    //                 $tableDataArr['start_date'] = $tableDataArr['start_date'].'-01';
                    
    //             }if (isset($tableDataArr['end_date']) && count(explode('-', $tableDataArr['end_date'])) == 2) {
    //                 $tableDataArr['end_date'] = $tableDataArr['end_date'].'-01';
                    
    //             }
    //             $tableDataArr['expense_type'] = $expenseType;
    //             $name = $tableDataArr['expense_name_id']??null;
                    
    //             if (isset($tableDataArr['start_date'])) {
    //                 $tableDataArr['start_date'] = $datesAsStringDateIndex[$tableDataArr['start_date']];
    //             } else {
    //                 $tableDataArr['start_date'] = $operationStartDateAsIndex;
    //             }
    //             if (isset($tableDataArr['end_date'])) {
    //                 $tableDataArr['end_date'] = $datesAsStringDateIndex[$tableDataArr['end_date']];
    //             } else {
    //                 $tableDataArr['end_date'] = $operationStartDateAsIndex;
    //             }
    //             /**
    //              * * to repeat 2 years inside json
    //              */
    //             $loopEndDate = $tableDataArr['end_date'] >=  $studyEndDateAsIndex ? $studyExtendedEndDateAsIndex : $tableDataArr['end_date'];
    //             $loopEndDate = $loopEndDate ==  0 ? $studyEndDateAsIndex : $loopEndDate ;


    //             $tableDataArr['relation_name']  = $tableId ;
    //             /**
    //              * * Fixed Repeating
    //              */
    //             $vatRate = $tableDataArr['vat_rate']??0;
    //             $isDeductible = $tableDataArr['is_deductible'] ?? false;
    //             if ($tableDataArr['payment_terms'] == 'customize') {
    //                 $tableDataArr['custom_collection_policy'] = sumDueDayWithPayment($tableDataArr['payment_rate'], $tableDataArr['due_days']);
    //             }
    //             $customCollectionPolicy = $tableDataArr['custom_collection_policy']??[];
    //             if (is_array($isDeductible)) {
    //                 $tableDataArr['is_deductible'] = $isDeductible[0];
    //                 $isDeductible= $isDeductible[0];
    //             }
    //             $isFixedRepeating = isset($tableDataArr['amount']) && $tableId == 'fixed_monthly_repeating_amount';
                
    //             if ($isFixedRepeating ) {
    //                 $amount = $tableDataArr['amount']??0 ;
    //                 // $isDeductible = false;
    //                 $dateIndexWithYearIndex = $this->getDatesIndexWithYearIndex();
    //                     $monthlyFixedRepeatingResults = $monthlyFixedRepeatingAmountEquation->calculate($amount, $tableDataArr['start_date'], $loopEndDate, $tableDataArr['increase_interval']??'annually', $tableDataArr['increase_rates']??0, $isDeductible, $vatRate, $withholdRate, $dateIndexWithYearIndex,null,$numberOfBranches);
    //                 /**
    //                  * * دي القيمة اللي هتدخل في الاكسبنس
    //                  */
    //                 $repeatingExpenseValues = [];
    //                 $collectionValues = [];
    //                 if ($isFixedRepeating) {
    //                     $repeatingExpenseValues = $isDeductible ? $monthlyFixedRepeatingResults['total_before_vat'] : $monthlyFixedRepeatingResults['total_after_vat'];
    //                     $collectionValues = $monthlyFixedRepeatingResults['total_before_vat'];
    //                 }
    //                 $withholdAmounts  = $monthlyFixedRepeatingResults['withhold_amounts'];
    //                 $tableDataArr['monthly_repeating_amounts']  = $repeatingExpenseValues;
    //                 $tableDataArr['total_vat']  = $monthlyFixedRepeatingResults['total_vat'];
    //                 $tableDataArr['total_after_vat']  = $monthlyFixedRepeatingResults['total_after_vat'];
                    
    //                 $payments = $this->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $tableDataArr['total_after_vat'], $datesAsIndexAndString, $customCollectionPolicy) ;
    //                 $withholdPayments = $this->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $withholdAmounts, $datesAsIndexAndString, $customCollectionPolicy) ;
    //                 $netPaymentsAfterWithhold = HArr::subtractAtDates([$payments,$withholdPayments], $dateWithDateIndex);
    //                 $tableDataArr['withhold_amounts'] = $withholdAmounts ;
    //                 $tableDataArr['withhold_payments']=$withholdPayments;
    //                 $tableDataArr['payment_amounts'] = $payments;
    //                 $tableDataArr['net_payments_after_withhold']=$netPaymentsAfterWithhold;
    //                 $tableDataArr['collection_statements']   =$this->calculateStatement($collectionValues, $tableDataArr['total_vat'], $netPaymentsAfterWithhold, $withholdPayments, $dateIndexWithDate, $this);
        
    //             }
              
    //             $tableDataArr['company_id']  = $this->company->id ;
    //             $tableDataArr['model_id']   = $modelId ;
    //             $tableDataArr['model_name']   = $modelName ;
    //             if ($name) {
    //                 $model->generateRelationDynamically($tableId, $expenseType)->create($tableDataArr);
    //             }
                    
                
    //         }
    //     }
        
    // }
    
    
    /**
     * * From Request
     * * الافضل نسيفها بالكامل الاول بعدين نعمل اعادة حسبه
     */
    
    public function handleFixedRepeatingExpenses(Request $request, array $accumulatedOpeningBranchesCounts = null)
    {
        $modelId = $request->get('model_id');
        $modelName = $request->get('model_name');
        $expenseType = $request->get('expense_type');
        $isAllBranchExpense = $expenseType == 'all-branches'  ;
        $numberOfBranches = $isAllBranchExpense ?  $this->getExistingBranchCounts() : 1 ;
        
        $monthlyFixedRepeatingAmountEquation = new MonthlyFixedRepeatingAmountEquation;
        $datesAsStringDateIndex = $this->getDatesAsStringAndIndex();
        $datesAsIndexAndString = array_flip($datesAsStringDateIndex);
        $operationStartDateAsIndex = $datesAsStringDateIndex[$this->getOperationStartDate()];
        $studyExtendedEndDateAsIndex = Arr::last($datesAsStringDateIndex);
        $studyEndDateAsIndex = $this->getStudyEndDateAsIndex($datesAsStringDateIndex, $this->getStudyEndDate());
        $dateIndexWithDate = $this->getDateIndexWithDate();
		$dateWithDateIndex = $this->getDateWithDateIndex();
        $model = ('\App\Models\\NonBankingService\\'.$modelName)::find($modelId);
        foreach (['fixed_monthly_repeating_amount'] as $tableId) {
            #::delete all
            $model->generateRelationDynamically($tableId, $expenseType)->delete();
            foreach ((array)$request->get($tableId) as $tableDataArr) {
                $tableDataArr['start_date_type'] = $tableDataArr['start_date_type']??null;
                $tableDataArr['study_id'] = $this->id;
                $withholdRate = $tableDataArr['withhold_tax_rate']??0;
            
                if (isset($tableDataArr['start_date']) && count(explode('-', $tableDataArr['start_date'])) == 2) {
                    $tableDataArr['start_date'] = $tableDataArr['start_date'].'-01';
                    
                }if (isset($tableDataArr['end_date']) && count(explode('-', $tableDataArr['end_date'])) == 2) {
                    $tableDataArr['end_date'] = $tableDataArr['end_date'].'-01';
                    
                }
                $tableDataArr['expense_type'] = $expenseType;
                $name = $tableDataArr['expense_name_id']??null;
                    
                if (isset($tableDataArr['start_date'])) {
                    $tableDataArr['start_date'] = $datesAsStringDateIndex[$tableDataArr['start_date']];
                } else {
                    $tableDataArr['start_date'] = $operationStartDateAsIndex;
                }
                if (isset($tableDataArr['end_date'])) {
                    $tableDataArr['end_date'] = $datesAsStringDateIndex[$tableDataArr['end_date']];
                } else {
                    $tableDataArr['end_date'] = $operationStartDateAsIndex;
                }
                /**
                 * * to repeat 2 years inside json
                 */
                $loopEndDate = $tableDataArr['end_date'] >=  $studyEndDateAsIndex ? $studyExtendedEndDateAsIndex : $tableDataArr['end_date'];
                $loopEndDate = $loopEndDate ==  0 ? $studyEndDateAsIndex : $loopEndDate ;


                $tableDataArr['relation_name']  = $tableId ;
                /**
                 * * Fixed Repeating
                 */
                $vatRate = $tableDataArr['vat_rate']??0;
                $isDeductible = $tableDataArr['is_deductible'] ?? false;
                if ($tableDataArr['payment_terms'] == 'customize') {
                    $tableDataArr['custom_collection_policy'] = sumDueDayWithPayment($tableDataArr['payment_rate'], $tableDataArr['due_days']);
                }
                $customCollectionPolicy = $tableDataArr['custom_collection_policy']??[];
                if (is_array($isDeductible)) {
                    $tableDataArr['is_deductible'] = $isDeductible[0];
                    $isDeductible= $isDeductible[0];
                }
                $isFixedRepeating = isset($tableDataArr['amount']) && $tableId == 'fixed_monthly_repeating_amount';
                
                if ($isFixedRepeating) {
                    $amount = $tableDataArr['amount']??0 ;
                    // $isDeductible = false;
                    $dateIndexWithYearIndex = $this->getDatesIndexWithYearIndex();
                    $startDateType = $tableDataArr['start_date_type'] ;
                    $accumulatedOpeningBranchesCounts = $accumulatedOpeningBranchesCounts[$startDateType]??null;
                
                    $monthlyFixedRepeatingResults = $monthlyFixedRepeatingAmountEquation->calculate($amount, $tableDataArr['start_date'], $loopEndDate, $tableDataArr['increase_interval']??'annually', $tableDataArr['increase_rates']??0, $isDeductible, $vatRate, $withholdRate, $dateIndexWithYearIndex, $accumulatedOpeningBranchesCounts, $numberOfBranches);
                
                    /**
                     * * دي القيمة اللي هتدخل في الاكسبنس
                     */
                    $repeatingExpenseValues = [];
                    $collectionValues = [];
                    if ($isFixedRepeating) {
                        $repeatingExpenseValues = $isDeductible ? $monthlyFixedRepeatingResults['total_before_vat'] : $monthlyFixedRepeatingResults['total_after_vat'];
                        $collectionValues = $monthlyFixedRepeatingResults['total_before_vat'];
                    }
                    $withholdAmounts  = $monthlyFixedRepeatingResults['withhold_amounts'];
                    $tableDataArr['monthly_repeating_amounts']  = $repeatingExpenseValues;
                    $tableDataArr['total_vat']  = $monthlyFixedRepeatingResults['total_vat'];
                    $tableDataArr['total_after_vat']  = $monthlyFixedRepeatingResults['total_after_vat'];
                    
                    $payments = $this->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $tableDataArr['total_after_vat'], $datesAsIndexAndString, $customCollectionPolicy) ;
                    $withholdPayments = $this->calculateCollectionOrPaymentAmounts($tableDataArr['payment_terms'], $withholdAmounts, $datesAsIndexAndString, $customCollectionPolicy) ;
                    $netPaymentsAfterWithhold = HArr::subtractAtDates([$payments,$withholdPayments], $dateWithDateIndex);
                    $tableDataArr['withhold_amounts'] = $withholdAmounts ;
                    $tableDataArr['withhold_payments']=$withholdPayments;
                    $tableDataArr['payment_amounts'] = $payments;
                    $tableDataArr['net_payments_after_withhold']=$netPaymentsAfterWithhold;
							$tableDataArr['withhold_statements']=$this->calculateWithholdStatement($withholdPayments , 0 , $dateIndexWithDate);
                    $tableDataArr['collection_statements']   =$this->calculateStatement($collectionValues, $tableDataArr['total_vat'], $netPaymentsAfterWithhold, $withholdPayments, $dateIndexWithDate, $this);
        
                }
              
                $tableDataArr['company_id']  = $this->company->id ;
                $tableDataArr['model_id']   = $modelId ;
                $tableDataArr['model_name']   = $modelName ;
                if ($name) {
                    $model->generateRelationDynamically($tableId, $expenseType)->create($tableDataArr);
                }
                    
                
            }
        }
        
    }
    public function getNewBranchesOpeningBalancesAccumulation()
    {
        $resultForStartDates = $this->newBranchMicrofinanceOpeningProjections->sortBy('start_date')->pluck('counts', 'start_date')->toArray();
        $resultForOperationDates = $this->newBranchMicrofinanceOpeningProjections->sortBy('operation_date')->pluck('counts', 'operation_date')->toArray();
        $startDates = [];
        $operationDates = [];
        $startDate = array_key_first($resultForStartDates) ;
        $operationDate = array_key_first($resultForOperationDates) ;
        $studyEndDate = $this->getStudyEndDateAsIndex() ;
        $currentTotalCount = 0 ;
        for ($i = $startDate ; $i <= $studyEndDate ; $i++) {
            $count = $resultForStartDates[$i]??0;
            $startDates[$i] = $currentTotalCount + $count ;
            $currentTotalCount +=$count;
        }
        $currentTotalCount = 0 ;
        for ($i = $operationDate ; $i <= $studyEndDate ; $i++) {
            $count = $resultForOperationDates[$i]??0;
            $operationDates[$i] = $currentTotalCount + $count ;
            $currentTotalCount +=$count;
        }
        
        return [
            'start-date'=>$startDates, //key name is start-date
            'end-date'=>$operationDates, //key name is start-date
        ];
    }
    public function securitizations():HasMany
    {
        return $this->hasMany(Securitization::class, 'study_id', 'id');
    }
    public function calculateSecuritizationLoans():array
    {
        $result = [];
        $result = [];
        DB::connection(NON_BANKING_SERVICE_CONNECTION_NAME)->table('loan_schedule_payments')->where('study_id', $this->id)->update([
                'securitization_date_index'=>null
            ]);
        SecuritizationLoanSchedule::where('study_id', $this->id)->delete();
        foreach ($this->securitizations as $securitization) {
            $revenueStreamType = $securitization->revenue_stream_type;
            $disbursementDate = $securitization->disbursement_date;
            $securitizationDate = $securitization->securitization_date;
            $discountRate = $securitization->discount_rate / 100  / 12;
            $collectionRevenueRate = $securitization->collection_revenue_rate / 100;
            $earlySettlementExpenseRate = $securitization->early_settlements_expense_rate / 100;
            $securitizationExpenseAmount = $securitization->expense_amount?:0;
            $result[$securitization->id]['securitization_expense_amount'] = $securitizationExpenseAmount;
            $loanSchedulePayments = LoanSchedulePayment::where('study_id', $this->id)->where('revenue_stream_type', $revenueStreamType)->where('month_as_index', $disbursementDate)->get();
            foreach ($loanSchedulePayments as $loanSchedulePayment) {
                $isPortfolio = $loanSchedulePayment->portfolio_loan_type == 'portfolio';
                $monthAsIndex = $loanSchedulePayment->month_as_index ;
                $loanSchedulePayment->update([
                    'securitization_date_index'=>$securitizationDate
                ]);
                if ($isPortfolio) {
                    $schedulePayments = json_decode($loanSchedulePayment->schedulePayment, true);
                    $principlePayments = json_decode($loanSchedulePayment->principleAmount, true);
                    $beginningBalance = json_decode($loanSchedulePayment->beginning, true);
                    $currentBeginningBalance = $beginningBalance[$monthAsIndex]??0;
                    $result[$securitization->id]['portfolio_disbursement_amount'] = isset($result[$securitization->id]['portfolio_disbursement_amount']) ? $result[$securitization->id]['portfolio_disbursement_amount'] + $currentBeginningBalance : $currentBeginningBalance;
                    foreach ($schedulePayments as $dateAsIndex => $value) {
                        if ($dateAsIndex >=$securitizationDate) {
							$currentPrincipleAmount = $principlePayments[$dateAsIndex]??0;
                            $currentPortfolioValue = isset($result[$securitization->id]['portfolio_result'][$dateAsIndex]) ? $result[$securitization->id]['portfolio_result'][$dateAsIndex] + $value : $value ;
                            $result[$securitization->id]['portfolio_result'][$dateAsIndex]=$currentPortfolioValue;
                            $result[$securitization->id]['collection_revenue_amounts'][$dateAsIndex]=$currentPortfolioValue * $collectionRevenueRate;
                            $result[$securitization->id]['portfolio_schedule_payment_sum'] = isset($result[$securitization->id]['portfolio_schedule_payment_sum'])  ? $result[$securitization->id]['portfolio_schedule_payment_sum'] + $value : $value ;
                            $result[$securitization->id]['portfolio_principle_amount_sum'] = isset($result[$securitization->id]['portfolio_principle_amount_sum'])  ? $result[$securitization->id]['portfolio_principle_amount_sum'] + $currentPrincipleAmount : $currentPrincipleAmount ;
                        }
                    }
                } else {
                    $bankPortfolioEndBalance = json_decode($loanSchedulePayment->endBalance, true);
                    $currentEndBalance = $bankPortfolioEndBalance[$securitizationDate]??0 ;
                    $currentBankPortfolioEndBalance = isset($result[$securitization->id]['bank_portfolio_end_balance_sum'])? $result[$securitization->id]['bank_portfolio_end_balance_sum'] + $currentEndBalance : $currentEndBalance;
                    $result[$securitization->id]['bank_portfolio_end_balance_sum'] = $currentBankPortfolioEndBalance ;
                    $result[$securitization->id]['early_settlements_expense_amount'] = $earlySettlementExpenseRate * $currentBankPortfolioEndBalance;
                }
                
                // collection_revenue_amount
                $result[$securitization->id]['securitization_id'] = $securitization->id;
                $result[$securitization->id]['study_id'] = $this->id;
                $result[$securitization->id]['company_id'] = $this->company->id;
                $values = $result[$securitization->id]['portfolio_result']??[];
                $netPresetValue = Finance::npv($discountRate, array_values($values)) ;
              //  $schedulePaymentSum = $result[$securitization->id]['portfolio_schedule_payment_sum']??0;
                $principleAmountSum = $result[$securitization->id]['portfolio_principle_amount_sum']??0;
                $result[$securitization->id]['net_present_value'] = $netPresetValue;
                $result[$securitization->id]['securitization_profit_or_loss'] = $netPresetValue - $principleAmountSum ;
                // additional data to view
                $result[$securitization->id]['revenue_stream_type'] =camelizeWithSpace($revenueStreamType) ;
                $result[$securitization->id]['disbursement_date'] =formatDateForView($this->getDateFromDateIndex($disbursementDate)) ;
                $result[$securitization->id]['securitization_date'] =formatDateForView($this->getDateFromDateIndex($securitizationDate)) ;
                // end additional data to view
            }
        }
        foreach ($result as $arr) {
            SecuritizationLoanSchedule::create($arr);
        }
		// $this->recalculateMonthlyAndAccumulatedEcl();
        return $result;
    }
	public function calculateMicrofinanceLoans()
	{
			DB::connection('non_banking_service')->table('loan_schedule_payments')->where('study_id',$this->id)->where('revenue_stream_type',Study::MICROFINANCE)->delete();
			$this->calculateMicrofinanceForType(true);
			$this->calculateMicrofinanceForType(false);
		
	}
	private function calculateMicrofinanceForType(bool $isPortfolio )
	{
        $portfolioLoans = [];
		$dateWithDateIndex = $this->getDateWithDateIndex();
		$dateIndexWithDate = $this->getDateIndexWithDate();
        $totalPortfolioEndBalance = [];
		 $operationDates = range($this->getOperationStartDateAsIndex(), $this->getStudyEndDateAsIndex());
		 $microfinanceSalesProjects  = $isPortfolio ? $this->microfinanceProductSalesProjects : $this->microfinanceProductSalesProjects->where('funded_by','by-mtls');
		 $eclAndNewPortfolioFundingRate = $this->getEclAndNewPortfolioFundingRatesForStreamType(Study::MICROFINANCE);
		 $eclAndNewPortfolioFundingRates = $eclAndNewPortfolioFundingRate->new_loans_funding_rates['by-mtls']??[];
		
		 
		 $microfinanceSalesProjects->each(function (MicrofinanceProductSalesProject $microfinanceProductSalesProject) use ($isPortfolio, &$portfolioLoans, $operationDates, &$totalPortfolioEndBalance,$dateWithDateIndex,$dateIndexWithDate,$eclAndNewPortfolioFundingRates) {
			$microfinanceProductSalesProject = $microfinanceProductSalesProject->refresh();
            $tenor  = $microfinanceProductSalesProject->tenor ;
      //      $type  = $microfinanceProductSalesProject->type ;
            $productId  = $microfinanceProductSalesProject->microfinance_product_id ;
            $monthlyPortfolioLoanAmounts  = $microfinanceProductSalesProject->monthly_loan_amounts ;
            $decreasingRates  = $microfinanceProductSalesProject->decrease_rates ;
			$rates = $isPortfolio ? $decreasingRates :  $this->generalAndReserveAssumption->getBaseRatesPerMonths();
			
			// dd($monthlyPortfolioLoanAmounts);
					
            foreach ($monthlyPortfolioLoanAmounts as $loanStartDateAsIndex => $monthlyLoanAmount) {
				
				$fundingRate = ($eclAndNewPortfolioFundingRates[$loanStartDateAsIndex]??0) /100 ;
				$marginRate=  $isPortfolio ? 0 : $this->generalAndReserveAssumption->getBankLendingMarginRatesAtYearOrMonthIndex($loanStartDateAsIndex);
				$monthlyLoanAmount = $isPortfolio ? $monthlyLoanAmount : $monthlyLoanAmount* $fundingRate ;
                $loanStartDateAsString = $this->getDateFromDateIndex($loanStartDateAsIndex);
                $baseRate = is_array($rates) ?  ($rates[$loanStartDateAsIndex]??0) : $rates;
				$currentPortfolioLoans = [];
				if($isPortfolio){
					$currentPortfolioLoans = (new CalculateFixedLoanAtBeginningService)->__calculate([], -1, 'normal', $loanStartDateAsString, $monthlyLoanAmount, $baseRate, $marginRate, $tenor, 'monthly', 1, null, 0, null, 0, $loanStartDateAsIndex);
				}else{
					$currentPortfolioLoans = [];
					if(is_array($rates)){
						$currentPortfolioLoans = (new CalculateFixedLoanAtBeginningService)->__calculateBasedOnDiffBaseRates($rates,'normal',$loanStartDateAsString,$monthlyLoanAmount,$marginRate,$tenor,'monthly',1,0,null,0,null,0,$loanStartDateAsIndex,$dateWithDateIndex, $dateIndexWithDate);
					}else{
					
						$currentPortfolioLoans = (new CalculateFixedLoanAtBeginningService)->__calculate([], -1, 'normal', $loanStartDateAsString, $monthlyLoanAmount, $baseRate, $marginRate, $tenor, 'monthly', 1, null, 0, null, 0, $loanStartDateAsIndex);
					}
				}
                $finalResult = $currentPortfolioLoans['final_result']??[];
                unset($finalResult['totals']);
                $currentPortfolioLoans = $finalResult ;
				if(!count($finalResult)){
					continue;
				}
                $currentPortfolioLoans['study_id'] = $this->id ;
                $currentPortfolioLoans['company_id'] = $this->company->id ;
                $currentPortfolioLoans['month_as_index'] = $loanStartDateAsIndex ;
                $currentPortfolioLoans['revenue_stream_id'] =$microfinanceProductSalesProject->id ;
                $currentPortfolioLoans['revenue_stream_category_id'] =$productId;
                $currentPortfolioLoans['portfolio_loan_type'] =$isPortfolio ? 'portfolio' : 'bank_portfolio';
                $currentPortfolioLoans['revenue_stream_type'] = Study::MICROFINANCE;
                $totalPortfolioEndBalance = HArr::sumAtDates([$totalPortfolioEndBalance,$currentPortfolioLoans['endBalance']??[]], $operationDates);
                $portfolioLoans[]=collect($currentPortfolioLoans)->map(function ($item, $keyName) {
                    if (is_array($item)) {
                        return json_encode($item);
                    }
                    return $item;
                })->toArray();
            }
        });
		 DB::connection('non_banking_service')->table('loan_schedule_payments')->insert($portfolioLoans);
		 
		
	}
	public function getMicrofinanceMonths():int
	{
		return $this->isMonthlyStudy() ? 11 : 23;
	}
	public function microfinanceByBranchProductMixes():HasMany
	{
		return $this->hasMany(MicrofinanceByBranchProductMix::class,'study_id','id');
	}
	public function getMicrofinanceFirstPage():string 
	{
		$microfinanceFirstPageRoute = route('create.all-branches.microfinance',['company'=>$this->company->id,'study'=>$this->id]);
		if($this->isByBranchMicrofinance()){
			$microfinanceFirstPageRoute = route('create.microfinance.product.mix',['company'=>$this->company->id,'study'=>$this->id]);
		}
		return $microfinanceFirstPageRoute;
	}
	public function interestYearSpread($baseRatesMapping,$dateIndexWithDate)
	{
		$result = [];
		$lastValue = 0 ;
		foreach($dateIndexWithDate as $dateAsString ){
			$isExist = key_exists($dateAsString,$baseRatesMapping);
			if($isExist){
				$lastValue = $baseRatesMapping[$dateAsString] ;
				$result[$dateAsString] =$lastValue ;
			}else{
				$result[$dateAsString] =$lastValue ;
			}
		}
		return $result;
	}
	public function hasBranchFilled(int $branchId):bool
	{
		return $this->microfinanceProductSalesProjects->where('type','by-branch')->where('branch_id',$branchId)->count();
	}
	public function hasNewBranchFilled():bool
	{
		return $this->microfinanceProductSalesProjects->where('type','new-branches')->count();
	}
	public function getFixedAssetNextRoute():string
	{
		$study = $this;
		$company = $this->company;
		if($this->hasMicrofinance())
		{
			return route('create.new.branch.fixed.assets', ['company'=>$company->id,'study'=>$study->id]);
		}
		return route('create.per.employee.fixed.assets', ['company'=>$company->id,'study'=>$study->id]) ;
		
	}
}
