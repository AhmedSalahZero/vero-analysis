<?php
namespace App\Models\NonBankingService;

use App\Models\Company;
use App\Models\NonBankingService\Study;
use Illuminate\Database\Eloquent\Model;

class  IjaraMortgageRevenueStreamBreakdown extends Model
{

	public function getViewVars(Company $company, Study $study):array{
		$ijaraMortgageEclAndNewPortfolioFundingRate = $study?  $study->ijaraMortgageEclAndNewPortfolioFundingRate : null;
		return [
			'company'=>$company ,
			'study'=>$study,
			'model'=>$study ,
			'ijaraMortgageEclAndNewPortfolioFundingRate'=>$ijaraMortgageEclAndNewPortfolioFundingRate,
			'title'=>__('Ijara Mortgage Revenue Stream Breakdown'),
			'storeRoute'=>route('store.ijara.mortgage.revenue.stream.breakdown',['company'=>$company->id , 'study'=>$study->id]),
			'yearsWithItsMonths' => $study->getOperationDurationPerYearFromIndexes(),
		];
	}
	public function getFormName():string
	{
		return 'non_banking_services.ijara-mortgage-revenue-stream-breakdown.form';
	}
}
