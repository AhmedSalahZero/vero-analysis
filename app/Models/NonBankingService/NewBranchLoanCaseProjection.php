<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  NewBranchLoanCaseProjection extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy ;
	protected $connection= 'non_banking_service';
	// protected $table ='new_branch_opening_projections';
	protected $guarded = ['id'];
	protected $casts =[
		// 'counts'=>'array',
	];

	public function getFirstThreeCount():int
	{
		return $this->first_three_count?: 0;
	}
	public function getSecondThreeCount():int
	{
		return $this->second_three_count?: 0;
	}
	public function getThirdThreeCount():int
	{
		return $this->third_three_count?: 0;
	}
	public function getFourthThreeCount():int
	{
		return $this->fourth_three_count?: 0;
	}
}
