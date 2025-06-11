<?php

namespace App;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class OdooSetting extends Model
{
    protected $guarded = ['id'];
	
	public function getId()
	{
		return $this->id;
	}
	public function company()
	{
		return $this->belongsTo(Company::class , 'company_id','id');
	}
	public  function getLiquidityAccountOdooId():int
	{
		return $this->liquidity_transfer_account_id; 
	}
	public function getChequesReceivableCode()
	{
		return $this->cheques_receivable_code;
	}
	public function getChequesReceivableId()
	{
		return $this->cheques_receivable_id;
	}
		public function getChequesPayableCode()
	{
		return $this->cheques_payable_code;
	}
	public function getChequesPayableId()
	{
		return $this->cheques_payable_id;
	}
	public function getLgCashCoverCode()
	{
		return $this->lg_cash_cover_code;
	}
	public function getLgCashCoverId()
	{
		return $this->lg_cash_cover_id;
	}
	public function getLcCashCoverCode()
	{
		return $this->lc_cash_cover_code;
	}
	public function getLcCashCoverId()
	{
		return $this->lc_cash_cover_id;
	}
	public static function getSuspenseAccountId():int
	{
		return OdooSetting::where('company_id',getCurrentCompanyId())->first()->suspense_account_id ; 
	}

}
