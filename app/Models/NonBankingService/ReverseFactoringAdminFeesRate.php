<?php
namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\CompanyScope;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
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
		'monthly_admin_fees_amounts'=>'array',
		'ecl_rates'=>'array',
	];
	public function getAdminFeeRatesAtYearIndex(int $yearIndex)
	{
		return $this->getAdminFeesRates()[$yearIndex] ?? 0  ; 
	}
	public function getAdminFeesRates():array
	{
		return $this->admin_fees_rates;
	}
	public function getMonthlyAdminFeesAmountsAtMonthIndex(int $monthIndex)
	{
		return $this->monthly_admin_fees_amounts[$monthIndex] ?? 0  ; 
	}
	public function getEclRatesAtYearOrMonthIndex(int $yearOrMonthIndex)
	{
		return $this->ecl_rates[$yearOrMonthIndex] ?? 0  ; 
	}
}
