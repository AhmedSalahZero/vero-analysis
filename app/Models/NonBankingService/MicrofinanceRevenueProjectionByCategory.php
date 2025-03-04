<?php
namespace App\Models\NonBankingService;

use App\Models\Company;
use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  MicrofinanceRevenueProjectionByCategory extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy ;
	protected $connection= 'non_banking_service';

	protected $guarded = ['id'];
	protected $casts =[
		'growth_rates'=>'array',
		'loan_case_amounts'=>'array',
		'monthly_due_cheques_percentages'=>'array',
		'microfinance_transactions_projections'=>'array',
	];
	public function getViewVars(Company $company, Study $study):array{
		$microfinanceEclAndNewPortfolioFundingRate = $study ?  $study->microfinanceEclAndNewPortfolioFundingRate : null;
		return [
			'company'=>$company ,
			'study'=>$study,
			'model'=>$study ,
			'microfinanceEclAndNewPortfolioFundingRate'=>$microfinanceEclAndNewPortfolioFundingRate,
			'title'=>__('Microfinance Revenue Stream Breakdown'),
			'storeRoute'=>route('store.microfinance.revenue.stream.breakdown',['company'=>$company->id , 'study'=>$study->id]),
			'yearsWithItsMonths' => $study->getOperationDurationPerYearFromIndexes(),
		];
	}
	public function getFormName():string
	{
		return 'non_banking_services.microfinance-revenue-stream-breakdown.form';
	}
	
	public function getLoanAmountsAtYearIndex(int $yearIndex)
	{
		return $this->getLoanAmounts()[$yearIndex] ?? 0  ; 
	}
	public function getLoanAmounts():array 
	{
		return (array)$this->loan_case_amounts;
	}
	public function getGrowthRateAtYearIndex(int $yearIndex)
	{
		return $this->growth_rates[$yearIndex] ?? 0  ; 
	}	
	
	
		
}
