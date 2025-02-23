<?php
namespace App\Models\NonBankingService;

use App\Models\Company;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Models\Traits\Scopes\CompanyScope;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  DirectFactoringRevenueProjectionByCategory extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy ;
	protected $connection= 'non_banking_service';

	protected $guarded = ['id'];
	protected $casts =[
		'growth_rates'=>'array',
		'direct_factoring_transactions_projections'=>'array',
	];
	public function getViewVars(Company $company, Study $study):array{
		$directFactoringEclAndNewPortfolioFundingRate = $study?  $study->directFactoringEclAndNewPortfolioFundingRate : null;
		return [
			'company'=>$company ,
			'study'=>$study,
			'model'=>$study ,
			'directFactoringEclAndNewPortfolioFundingRate'=>$directFactoringEclAndNewPortfolioFundingRate,
			'title'=>__('Direct Factoring Revenue Stream Breakdown'),
			'storeRoute'=>route('store.direct.factoring.revenue.stream.breakdown',['company'=>$company->id , 'study'=>$study->id]),
			'yearsWithItsMonths' => $study->getOperationDurationPerYearFromIndexes(),
		];
	}
	public function getFormName():string
	{
		return 'non_banking_services.direct-factoring-revenue-stream-breakdown.form';
	}
	
	public function getDirectFactoringTransactionProjectionAtYearIndex(int $yearIndex)
	{
		return $this->direct_factoring_transactions_projections[$yearIndex] ?? 0  ; 
	}
	public function getGrowthRateAtYearIndex(int $yearIndex)
	{
		return $this->growth_rates[$yearIndex] ?? 0  ; 
	}
	
		
}
