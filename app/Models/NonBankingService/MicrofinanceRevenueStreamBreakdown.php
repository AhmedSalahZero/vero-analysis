<?php
namespace App\Models\NonBankingService;

use App\Helpers\HHelpers;
use App\Models\Company;
use App\Models\NonBankingService\Study;
use Illuminate\Database\Eloquent\Model;

class  MicrofinanceRevenueStreamBreakdown extends Model
{

	public function getViewVars(Company $company, Study $study):array{
		$microfinanceEclAndNewPortfolioFundingRate = $study?  $study->microfinanceEclAndNewPortfolioFundingRate : null;
		return [
			'company'=>$company ,
			'study'=>$study,
			'model'=>$study ,
			'microfinanceEclAndNewPortfolioFundingRate'=>$microfinanceEclAndNewPortfolioFundingRate,
			'title'=>__('Microfinance Revenue Stream Breakdown'),
			'storeRoute'=>route('store.microfinance.revenue.stream.breakdown',['company'=>$company->id , 'study'=>$study->id]),
			'yearsWithItsMonths' => $study->getOperationDurationPerYearFromIndexes(),
			'microfinanceProductsFormatted'=>HHelpers::formatForSelect2(MicrofinanceProduct::where('company_id',$company->id)->get()->pluck('title','id')->toArray())
		];
	}
	public function getFormName():string
	{
		return 'non_banking_services.microfinance-revenue-stream-breakdown.form';
	}
}
