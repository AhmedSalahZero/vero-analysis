<?php

namespace App\Models;

use App\Models\Company;
use App\Traits\HasBasicStoreRequest;
use App\Traits\Models\HasLetterOfGuaranteeStatements;
use Illuminate\Database\Eloquent\Model;

class LgOpeningBalance extends Model
{
	const TIME_OF_DEPOSIT = 'TimeOfDeposit' ;
	const CERTIFICATE_OF_DEPOSIT = 'CertificateOfDeposit' ;
    use HasBasicStoreRequest ;
    use HasLetterOfGuaranteeStatements ;

    protected $guarded = ['id'];
    protected $table = 'letter_of_guarantee_opening_balances';
	const LG_OPEN_BALANCE  = 'lg-opening-balance';
	public function getId()
	{
		return $this->id;
	}

	public function getDate()
	{
		return $this->date;
	}

    public function setDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];

		$this->attributes['date'] = $year.'-'.$month.'-'.$day;
	}

	public function company()
	{
		return $this->belongsTo(Company::class , 'company_id','id');
	}

	public function LgHundredPercentageCashCoverOpeningBalance()
	{
		return $this->hasMany(LgHundredPercentageCashCoverOpeningBalance::class , 'lg_opening_balance_id','id');
	}
    public function LgAgainstTimeOfDepositOpeningBalances()
	{
		return $this->hasMany(LgAgainstTdOrCdOpeningBalance::class , 'lg_opening_balance_id','id')->where('type',self::TIME_OF_DEPOSIT);
	}
	public function LgAgainstCertificateOfDepositOpeningBalances()
	{
		return $this->hasMany(LgAgainstTdOrCdOpeningBalance::class , 'lg_opening_balance_id','id')->where('type',self::CERTIFICATE_OF_DEPOSIT);
	}
	/**
	 * * نجيب الاتنين مع بعض
	 */
	public function LgAgainstCertificateOfDepositOrTimeOfDepositOpeningBalances()
	{
		return $this->hasMany(LgAgainstTdOrCdOpeningBalance::class , 'lg_opening_balance_id','id');
	}
	
	public function letterOfGuaranteeStatements()
	{
		return $this->hasMany(LetterOfGuaranteeStatement::class,'letter_of_guarantee_issuance_id','id');
	}
	







}
