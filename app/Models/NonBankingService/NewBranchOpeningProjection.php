<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  NewBranchOpeningProjection extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy ;
	protected $connection= 'non_banking_service';
	protected $table ='new_branch_opening_projections';
	protected $guarded = ['id'];
	protected $casts =[
		// 'counts'=>'array',
	];
	
	// public function getCountsAtMonthIndex(int $monthIndex)
	// {
	// 	return $this->counts[$monthIndex] ?? 0  ; 
	// }
	public function getLoanOfficerCountPerBranch():int
	{
		return $this->loan_officer_count_per_branch?: 0;
	}
	public function getCounts():int
	{
		return $this->counts?: 0;
	}
	public function getStartDateAsIndex():int
	{
		return $this->start_date_as_index?: 0;
	}
	
	public function getStartDateAsString():string 
	{
		$dateWithDateIndex = $this->study->getDateIndexWithDate()[$this->getStartDateAsIndex()];
		return $dateWithDateIndex;
	}
	public function getTotalBranches():int
	{
		return $this->total_branches?: 0;
	}
}
