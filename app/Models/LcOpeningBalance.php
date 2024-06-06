<?php

namespace App\Models;

use App\Models\Company;
use App\Traits\HasBasicStoreRequest;
use App\Traits\Models\HasLetterOfCreditStatements;
use Illuminate\Database\Eloquent\Model;

class LcOpeningBalance extends Model
{
	const TIME_OF_DEPOSIT = 'TimeOfDeposit' ;
	const CERTIFICATE_OF_DEPOSIT = 'CertificateOfDeposit' ;
    use HasBasicStoreRequest ;
    use HasLetterOfCreditStatements ;

    protected $guarded = ['id'];
    protected $table = 'letter_of_credit_opening_balances';
	const LC_OPEN_BALANCE  = 'lc-opening-balance';
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

	public function LcHundredPercentageCashCoverOpeningBalance()
	{
		return $this->hasMany(LcHundredPercentageCashCoverOpeningBalance::class , 'lc_opening_balance_id','id');
	}
    public function LcAgainstTimeOfDepositOpeningBalances()
	{
		return $this->hasMany(LcAgainstTdOrCdOpeningBalance::class , 'lc_opening_balance_id','id')->where('type',self::TIME_OF_DEPOSIT);
	}
	public function LcAgainstCertificateOfDepositOpeningBalances()
	{
		return $this->hasMany(LcAgainstTdOrCdOpeningBalance::class , 'lc_opening_balance_id','id')->where('type',self::CERTIFICATE_OF_DEPOSIT);
	}
	/**
	 * * نجيب الاتنين مع بعض
	 */
	public function LcAgainstCertificateOfDepositOrTimeOfDepositOpeningBalances()
	{
		return $this->hasMany(LcAgainstTdOrCdOpeningBalance::class , 'lc_opening_balance_id','id');
	}
	
	public function letterOfCreditStatements()
	{
		return $this->hasMany(LetterOfCreditStatement::class,'letter_of_credit_issuance_id','id');
	}
	







}
