<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use App\Models\Traits\Scopes\CompanyScope;
use App\Traits\HasBasicStoreRequest;
use Illuminate\Database\Eloquent\Model;

class  ReverseFactoringAdminFeesRate extends Model
{
	use HasBasicStoreRequest,CompanyScope , BelongsToStudy ;
	protected $connection= 'non_banking_service';
	protected $table='reverse_factoring_administration_fees_rates';
	protected $guarded = ['id'];
	protected $casts =[
		'admin_fees_rates'=>'array',
		'ecl_rates'=>'array',
	];
	public function getAdminFeeRatesAtYearIndex(int $yearIndex)
	{
		return $this->admin_fees_rates[$yearIndex] ?? 0  ; 
	}
	public function getEclRatesAtYearIndex(int $yearIndex)
	{
		return $this->ecl_rates[$yearIndex] ?? 0  ; 
	}
}
