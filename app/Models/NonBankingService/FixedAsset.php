<?php

namespace App\Models\NonBankingService;

use App\Models\Company;
use App\Models\Traits\Scopes\BelongsToCompany;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use function PHPSTORM_META\map;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FixedAsset extends Model
{
    use BelongsToStudy,BelongsToCompany;
    protected $guarded = ['id'];
    protected $connection ='non_banking_service';
    public const FFE = 'ffe';
    public const NEW_BRANCH = 'new-branch';
    public const PER_EMPLOYEE = 'per-employee';
    protected $casts = [
        'ffe_counts'=>'array',
        'monthly_amounts'=>'array',
        'position_ids'=>'array',
        'department_ids'=>'array',
		'statement'=>'array',
		'ffe_equity_payment'=>'array',
		'ffe_loan_withdrawal'=>'array',
		'loan_capitalized_interests'=>'array',
		'income_statement_loan_capitalized_interests'=>'array',
		'ffe_loan_withdrawal_end_balance'=>'array',
		'depreciation_statement'=>'array',
		'capitalization_statement'=>'array',
		'ffe_execution_and_payment'=>'array',
		'ffe_payable'=>'array',
		'custom_collection_policy'=>'array',
		'total_monthly_depreciations'=>'array',
    ];
    public function getId()
    {
        return $this->id;
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function model()
    {
        $modelName = '\App\Models\\'.$this->model_name ;
        return $this->belongsTo($modelName, 'model_id', 'id');
    }
    public function getNameId():int
    {
        return $this->name_id ;
    }
    public function fixedAssetName():BelongsTo
    {
        return $this->belongsTo(FixedAssetName::class, 'name_id', 'id');
    }
    public function getName():string
    {
        return $this->fixedAssetName ? $this->fixedAssetName->getName() : __('N/A');
    }
    // public function getName()
    // {
    // 	return $this->name ;
    // }
    public function getType():string
    {
        return $this->type;
    }
   
    public function getVatRate()
    {
        return $this->vat_rate ?: 0;
    }
    public function getWithholdTaxRate()
    {
        return $this->withhold_tax_rate?:0;
    }
    public function getContingencyRate()
    {
        return $this->contingency_rate?:0;
    }
    public function getDepreciationDuration():int
    {
        return $this->depreciation_duration ;
    }
    public function getDepreciationDurationInMonths():int
    {
        return $this->getDepreciationDuration() * 12 ;
    }
    public function getPaymentTerm()
    {
        return $this->payment_terms ;
    }
    public function getReplacementInterval()
    {
        return $this->replacement_interval ;
    }
    public function getReplacementIntervalInMonths()
    {
        return $this->getReplacementInterval() * 12 ;
    }
    public function getTotalCost()
    {
        return (1+($this->getContingencyRate()/100))*$this->getItemCost();
    }
    public function getMonthlyAmounts():array
    {
        return (array)$this->monthly_amounts;
    }
    public function getCount():int
    {
        return $this->counts;
    }
    public function getPurchaseDates(array $dateIndexWithDate):array
    {
        // $dateAsIndexString = app('dateIndexWithDate');
        
        $dates= [];
        $ffeCounts = $this->getFfeCounts();
        foreach ($ffeCounts as $dateAsIndex => $ffeCount) {
            if ($ffeCount > 0) {
                $dates[$dateAsIndex] = $dateIndexWithDate[$dateAsIndex]  ;
            }
        }
        return $dates ;
    }
    public function getMonthlyAmountAtMonthIndex(int $dateAsIndex)
    {
        return $this->getMonthlyAmounts()[$dateAsIndex] ?? 0 ;
    }
    public function getFfeCountsAtDateIndex(int $dateIndex)
    {
        return $this->getFfeCounts()[$dateIndex]??0;
    }
    public function getFfeCounts():array
    {
        return (array)$this->ffe_counts;
    }
    public function getReplacementCostRate()
    {
        return $this->replacement_cost_rate ;
    }
    public function getCostAnnualIncreaseRate()
    {
        return $this->cost_annual_increase_rate ?: 0;
    }
		public function getCollectionPolicyValue():array
	{
		if($this->getPaymentTerm() == 'cash'){
			return [
				0 => 100
			];
		}
		return $this->custom_collection_policy;
	}
    public function getPaymentRate(int $rateIndex)
    {
        return array_values($this->custom_collection_policy ?? [])[$rateIndex] ?? 0 ;
    }
    public function getPaymentRateAtDueInDays($rateIndex)
    {
        return array_keys($this->custom_collection_policy ?? [])[$rateIndex] ?? 0 ;
    }
    public function getPositionIds()
    {
        return $this->position_ids;
    }public function getDepartmentIds()
    {
        return $this->department_ids;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * * new
     */
    
    
    public function calculateFFEAssetsForFFE(int $fixedAssetEndDateAsIndex, int  $transferredDateForFFEAsIndex, float  $transferredAmount, array $studyDates, int $studyEndDateAsIndex, Study $study):array
    {
        
        $depreciationDurationInMonthsForFFE = $this->getDepreciationDurationInMonths();
        $ffeReplacementCostRateForFFE = $this->getReplacementCostRate()  ;
        $ffeReplacementIntervalInMonthsForFFE = $this->getReplacementIntervalInMonths();
        $projectUnderProgressForFFE = [
            'transferred_date_and_vales'=>[
                $transferredDateForFFEAsIndex =>  $transferredAmount
            ]
        ];
        return  $this->calculateFFEAssets($fixedAssetEndDateAsIndex , $depreciationDurationInMonthsForFFE, $ffeReplacementCostRateForFFE, $ffeReplacementIntervalInMonthsForFFE, $projectUnderProgressForFFE, $studyDates, $studyEndDateAsIndex, $study);
    }
    
    public function calculateFFEAssets(int $fixedAssetEndDateAsIndex , int $propertyDepreciationDurationInMonths, float $propertyReplacementCostRate, int $propertyReplacementIntervalInMonths, array $projectUnderProgressForConstruction, array $studyDates, int $studyEndDateAsIndex, Study $study):array
    {
        $buildingAssets = [];
        $datesAsStringAndIndex = $study->getDatesAsStringAndIndex();
        $operationStartDateAsIndex = $study->getOperationStartDateAsIndex($datesAsStringAndIndex, $study->getOperationStartDateFormatted());
        // $fixedAssetEndDateAsIndex = $this->getEndDateAsIndex();
        $operationStartDateAsIndex  =  $operationStartDateAsIndex >= $fixedAssetEndDateAsIndex ? $operationStartDateAsIndex :$fixedAssetEndDateAsIndex;
        $propertyReplacementCostRate = $propertyReplacementCostRate /100;
        $constructionTransferredDateAndValue = $projectUnderProgressForConstruction['transferred_date_and_vales']??[];
        $constructionTransferredDateAsIndex = array_key_last($constructionTransferredDateAndValue);
        $constructionTransferredValue = $constructionTransferredDateAndValue[$constructionTransferredDateAsIndex]??0;
        
        

        $beginningBalance = 0;
        $totalMonthlyDepreciation = [];
        $accumulatedDepreciation = [];
        $replacementDates = calculateReplacementDates($studyDates, $operationStartDateAsIndex, $studyEndDateAsIndex, $propertyReplacementIntervalInMonths);
        $depreciation = [];
        $index = 0 ;
        $depreciationStartDateAsIndex = null;
        foreach ($studyDates as $dateAsIndex) {
            if ($constructionTransferredDateAsIndex < $operationStartDateAsIndex) {
                $depreciationStartDateAsIndex = $operationStartDateAsIndex;
            } else {
                $depreciationStartDateAsIndex = $dateAsIndex+1;
            }
            $depreciationEndDateAsIndex = $depreciationStartDateAsIndex >=0  ?  $depreciationStartDateAsIndex+ $propertyDepreciationDurationInMonths - 1 : null;
    
            $buildingAssets['beginning_balance'][$dateAsIndex]= $beginningBalance;
            $buildingAssets['additions'][$dateAsIndex]=  $dateAsIndex ==$constructionTransferredDateAsIndex ? $constructionTransferredValue : 0;
            $buildingAssets['initial_total_gross'][$dateAsIndex] =  $buildingAssets['additions'][$dateAsIndex] +  $beginningBalance;
            $currentInitialTotalGross = $buildingAssets['initial_total_gross'][$dateAsIndex] ??0;
            $replacementCost[$dateAsIndex] =    in_array($dateAsIndex, $replacementDates)  ? $this->calculateReplacementCost($currentInitialTotalGross, $propertyReplacementCostRate) : 0;
            if (in_array($dateAsIndex, $replacementDates) && ($constructionTransferredDateAsIndex <= $operationStartDateAsIndex)) {
                $depreciationEndDateAsIndex = $dateAsIndex+1+$propertyDepreciationDurationInMonths-1;
            }
            $replacementValueAtCurrentDate = $replacementCost[$dateAsIndex] ?? 0;
            $buildingAssets['replacement_cost'][$dateAsIndex] = $replacementCost[$dateAsIndex] ;
            $buildingAssets['final_total_gross'][$dateAsIndex] = $buildingAssets['initial_total_gross'][$dateAsIndex]  + $replacementValueAtCurrentDate;
            $depreciation[$dateAsIndex]=$this->calculateMonthlyDepreciation($dateAsIndex, $buildingAssets['additions'][$dateAsIndex], $replacementValueAtCurrentDate, $propertyDepreciationDurationInMonths, $depreciationStartDateAsIndex, $depreciationEndDateAsIndex, $totalMonthlyDepreciation, $accumulatedDepreciation, $studyDates);
            $accumulatedDepreciation = calculateAccumulatedDepreciation($totalMonthlyDepreciation, $studyDates);
            $buildingAssets['total_monthly_depreciation'] =$totalMonthlyDepreciation;
            $buildingAssets['accumulated_depreciation'] =$accumulatedDepreciation;
            $currentAccumulatedDepreciation = $buildingAssets['accumulated_depreciation'][$dateAsIndex] ?? 0;
            $buildingAssets['end_balance'][$dateAsIndex] =  $buildingAssets['final_total_gross'][$dateAsIndex] -  $currentAccumulatedDepreciation;
            $beginningBalance = $buildingAssets['final_total_gross'][$dateAsIndex];
            $index++;
        }
        return $buildingAssets ;
    }
    
    

    protected function calculateReplacementCost(float $totalGross, float $propertyReplacementCostRate)
    {
        return $totalGross * $propertyReplacementCostRate ;
    }
    
    protected function calculateMonthlyDepreciation(int $replacementDate, float $additions, float $replacementCost, int $propertyDepreciationDurationInMonths, ?int $depreciationStartDateAsIndex, ?int $depreciationEndDateAsIndex, &$totalMonthlyDepreciation, &$accumulatedDepreciation, array $studyDates)
    {
        if (is_null($depreciationStartDateAsIndex) || is_null($depreciationEndDateAsIndex)) {
            return [];
        }
        $monthlyDepreciations = [];
        $monthlyDepreciationAtCurrentDate =  $propertyDepreciationDurationInMonths ? ($additions+$replacementCost) / $propertyDepreciationDurationInMonths  : 0;
        $depreciationDates = generateDatesBetweenTwoIndexedDates($depreciationStartDateAsIndex, $depreciationEndDateAsIndex);

        foreach ($studyDates as $dateAsIndex) {
            if ($dateAsIndex <= $replacementDate) {
                continue;
            }
            $previousDateAsIndex = $dateAsIndex-1;
            if (in_array($dateAsIndex, $depreciationDates)) {
                $monthlyDepreciations[$dateAsIndex] = $monthlyDepreciationAtCurrentDate;
                $totalMonthlyDepreciation[$dateAsIndex] = isset($totalMonthlyDepreciation[$dateAsIndex]) ? $totalMonthlyDepreciation[$dateAsIndex] +$monthlyDepreciationAtCurrentDate : $monthlyDepreciationAtCurrentDate;
                $currentAccumulatedDepreciation = $accumulatedDepreciation[$previousDateAsIndex]??0;
                $accumulatedDepreciation[$dateAsIndex] = $previousDateAsIndex >=0 ? ($totalMonthlyDepreciation[$dateAsIndex] + $currentAccumulatedDepreciation) : $totalMonthlyDepreciation[$dateAsIndex];
            } else {
                $accumulatedDepreciation[$dateAsIndex] = $accumulatedDepreciation[$previousDateAsIndex] ?? 0 ;
            }
        }
        return $monthlyDepreciations;
    }
	 public function getItemCost()
    {
        return $this->ffe_item_cost;
    }
	public function getTotalItemsCost($fixedAssets):float 
	{
		$total = 0;
		$fixedAssets->each(function($ffeItem) use (&$total){
			$total += $ffeItem->getItemCost() * (1+($ffeItem->getContingencyRate()/100));
		});
	
		return $total ; 
		// return $this->getCounts() * $this->getAmount();
	}
	 public function getAmount()
    {
        return $this->amount ?: 0 ;
    }
	
	public function getDuration()
	{
		return 0;
	}


	
	
}
