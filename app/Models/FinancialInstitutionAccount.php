<?php

namespace App\Models;

use App\Models\AccountInterest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class FinancialInstitutionAccount extends Model
{
    protected $guarded = ['id'];

    public function financialInstitution()
    {
        return $this->belongsTo(FinancialInstitution::class, 'financial_institution_id', 'id');
    }

	/**
	 * * رقم الحساب ( رقم الفيزا مثلا)
	 */
    public function getAccountNumber()
    {
        return $this->account_number ;
    }

    /**
     * *رقم الحساب البنكى الدولى International Bank Account Number وبذلك فهو يعبر عن رقم حسابك البنكى اثناء التحويلات البنكية الدولية وهذا الرقم يتم الحصول علية لكل الحسابات البنكية فى أغلب الدول حول العالم.
     **	ولذلك لا يعتبر رقم الايبان رقم جديد لحسابك ولكن هو شكل وصيغة مختلفة لرقم الحساب ليتم التعرف علية دوليا بسهولة وبالتالى يساعد فى سرعة وسهولة ** التحويلات البنكية الدولية وتجنب العديد من الاخطاء التى قد تحدث وتتسبب فى تأخير وصول الدفعات والحوالات البنكية.
     * *
     * *
     */
    public function getIban()
    {
        return $this->iban ;
    }

    public function getMainCurrency()
    {
        return $this->main_currency ;
    }

	/**
	 * * اجمالي الفلوس اللي معايا في الحساب دا
	 */
    public function getBalanceAmount()
    {
        return $this->balance_amount ?: 0 ;
    }
	public function getBalanceAmountFormatted()
	{
		return number_format($this->getBalanceAmount() , 0) ; 
	}
		// /**
		//  * * نسب الفايدة اللي بخدها من الحساب دا ( احيانا بيكون فيه عروض بحيث انك تنشئ حساب وتاخد علي نسبة فايدة كل شهر مثلا)
		//  */
	public function accountInterests():HasMany
	{
		return $this->hasMany(AccountInterest::class , 'financial_institution_account_id','id');
	}
	
	public function getExchangeRate()
    {
        return $this->exchange_rate ?: 1 ;
    }
	
	
	/**
	 * * هو اول حساب بيدخلة اليوزر وبيكون دايما مصري لان ما ينفعش تنشئ حساب دولاري مثلا من غير الحساب المصري
	 */
    public function isMainAccount():bool
	{
		return (bool)$this->is_main_account;
	}
	
	public function isMainAccountFormatted():string 
	{
		return $this->isMainAccount() ? __('Yes') : __('No');
	}
	
	public function getCertificatesOfDeposits():HasMany
	{
		return $this->hasMany(CertificatesOfDeposit::class,'maturity_amount_added_to_account_id','id');
	}
	

    public function getId()
    {
        return $this->id ;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
	public function getCurrencyFormatted()
	{
		return Str::upper($this->getCurrency());
	}
	public function getType()
	{
		return __('Current');
	}
	public function isBlocked():bool
	{
		return false;
	}
}
