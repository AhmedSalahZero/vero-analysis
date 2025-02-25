<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  ReverseFactoringBreakdown extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy ;
	protected $connection= 'non_banking_service';

	protected $guarded = ['id'];
	protected $casts =[
		'percentage_payload'=>'array',
		'loan_amounts'=>'array',
	];
	public function getPercentageAtYearIndex(int $yearIndex)
	{
		return $this->percentage_payload[$yearIndex] ?? 0  ; 
	}
	public function getLoanAmountPayloadAtYearIndex(int $yearIndex)
	{
		return $this->loan_amounts[$yearIndex] ?? 0  ; 
	}
	public function getCategory()
	{
		return $this->category;
	}
	public function getMarginRate()
	{
		return $this->margin_rate?:0;
	}
	public function getSensitivityMarginRate():float
	{
		return $this->sensitivity_margin_rate;
	}
	public function getTenor()
	{
		return $this->tenor?:0;
	}
	public function getLoanType()
	{
		return 'normal';
	}
		
	public function getReviewForTable()
	{
		// dd($this->category);
		/**
		 * ! Need To Be Fixed
		 */
		if(is_numeric($this->category)){
			return '-';
		}
		
		return $this->category->getTitle().'[' . $this->getLoanNature() . ' / ' . $this->getLoanType(). ' / ' . $this->getTenor(). ' M/ ' . $this->getGracePeriod(). ' M/ ' . $this->getMarginRate(). ' %/ ' . $this->getInstallmentInterval(). ' / ' . $this->getStepRate(). ' %/ ' . $this->getStepInterval() . ' ]';
	}
	
}
