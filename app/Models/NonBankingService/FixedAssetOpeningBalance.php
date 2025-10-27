<?php
namespace App\Models\NonBankingService;


use App\Models\NonBankingService\Study;
use App\Traits\HasCollectionOrPaymentStatement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FixedAssetOpeningBalance extends Model
{
	use HasCollectionOrPaymentStatement;
		protected $connection= 'non_banking_service';
    protected $guarded = ['id'];
	protected $casts = [
		'product_allocations'=>'array',
		'admin_depreciations'=>'array',
		'manufacturing_depreciations'=>'array',
		'monthly_accumulated_depreciations'=>'array',
		'statement'=>'array',
		'monthly_product_allocations'=>'array',
	];
	
	public static function getOpeningBalanceColumnName():string
	{
		return 'gross_amount';
	}
	public static function getPayloadStatementColumn():string 
	{
		return 'monthly_accumulated_depreciations';
	}
	public static function booted()
	{
			parent::boot();
			static::saving(function(self $model){
				// $statementPayload = $model->{self::getPayloadStatementColumn()} ?: [];
				$openingBalance = $model->{self::getOpeningBalanceColumnName()};
				$monthlyDepreciation = $model->monthly_depreciation ;
				$dates = range(0,$model->monthly_counts-1);
				$monthlyDepreciations = [];
				$accumulatedDepreciations = [];
				$currentAccumulatedDepreciation = $model->accumulated_depreciation;
				// $endBalances =[];
				$statement = [];
				foreach($dates as $dateAsIndex){
				$statement['beginning_balance']	[$dateAsIndex] = $openingBalance;
				$statement['monthly_depreciation'][$dateAsIndex] = $monthlyDepreciation;
				$monthlyDepreciations[$dateAsIndex] = $monthlyDepreciation;
				$currentAccumulated =array_sum($monthlyDepreciations)+$currentAccumulatedDepreciation;
				$statement['accumulated_depreciation'][$dateAsIndex] = $currentAccumulated;
					$accumulatedDepreciations[$dateAsIndex] = $currentAccumulated ;
					$statement['end_balance'][$dateAsIndex] = $openingBalance-$currentAccumulated;
				}
				// dd($statement,$monthlyDepreciations,$accumulatedDepreciations,$endBalances);
				// $dateIndexWithDate = $model->study->getDateIndexWithDate();
				// $extendedStudyEndDate = $model->study->convertDateStringToDateIndex($model->study->getEndDate()) ;
				// $dates = range(0,$extendedStudyEndDate);
				// $debug = false ;
				$model->statement =$statement;
				// if(!is_null($openingBalance)){
				// }
			});
	}
	
	
    public function study():BelongsTo
    {
        return $this->belongsTo(Study::class, 'study_id', 'id');
    }
	
    public function getName():string 
    {
        return $this->name ;
    }
	public function getMonthlyCounts():int 
	{
		return $this->monthly_counts;
	}
	
	public function getGrossAmount():float
	{
		return $this->gross_amount;
	}
	public function getAccumulatedDepreciation():float
	{
		return $this->accumulated_depreciation?:0;
	}
	public function getNetAmount():float
	{
		return $this->getGrossAmount() - $this->getAccumulatedDepreciation();
	}
    public function getMonthlyDepreciation():float 
	{
		return $this->monthly_depreciation;
	}  


}
