<?php
namespace App\Traits;

use App\Models\Company;
use App\OutstandingBreakdown;
use Illuminate\Http\Request;


trait HasOutstandingBreakdown
{
	/**
	 * * هو عباره عن التقسيمة الخاصة بال 
	 * *clean overdraft 
	 * * outstanding balance
	 * * او اي نوع تاني خاص بالتسهيلات
	 * * بمعني انك لما بتحط ال
	 * * الفلوس اللي انت سحبتها من الحساب لحد لحظه فتح حسابك علي كاش فيرو ..سحبت قديه يوم قديه وقديه يوم قديه وهكذا 
	 * * بمعني ان مجموع القيم لازم يساوي ال
	 * * outstanding balance in clean overdraft 
	 */
	public function outstandingBreakdowns()
	{
		return $this->hasMany(OutstandingBreakdown::class , 'model_id','id')->where('model_type',self::class);	
	}
	public function storeOutstandingBreakdown(Request $request , Company $company)
	{
		$this->outstandingBreakdowns()->delete();
		foreach($request->get('outstanding_breakdowns',[]) as $outstandingBreakdownArr){
			unset($outstandingBreakdownArr['id']);
			$outstandingBreakdownArr['company_id'] = $company->id ;
			$outstandingBreakdownArr['model_type'] = get_class($this);
			$outstandingBreakdownArr['amount'] = number_unformat($outstandingBreakdownArr['amount']);
			$this->outstandingBreakdowns()->create($outstandingBreakdownArr);
		}
	}
}
