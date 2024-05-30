<?php

namespace App\Models;

use App\Traits\HasOutstandingBreakdown;
use App\Traits\IsOverdraft;
use Illuminate\Database\Eloquent\Model;

/**
 * * هو نوع من انواع حسابات التسهيل البنكية (زي القرض يعني بس فية فرق بينهم ) وبيسمى حد جاري مدين بدون ضمان
 * * بدون ضمان يعني مش بياخدوا مقابل قصادة يعني مثلا مش بياخدوا منك شيكات مثلا او بيت .. الخ علشان كدا اسمه كلين
 * * والفرق بينه وبين القرض ان هنا انت مش ملتزم تسدد مبلغ معين في فتره معين اي لا  يوجد اقساط للدفع
 * * وبناء عليه كل اما قللت التسديد كل اما هينزل عليك فايدة اكبر الشهر الجاي
 * * وعموما في حالة انك مدان للبنك وليكن مثلا لو انت سالف من البنك عشر الالف وسحبت تسعه ونزل عليك فايدة خمس مئة جنية
 * * وقتها ال خمس مئة جنية دول بينسحبوا من حسابك علطول وبالتالي انت ما عتش فاضلك غير خمس مئة مثلا
 */
class FullySecuredOverdraft extends Model
{
    protected $guarded = ['id'];
	use HasOutstandingBreakdown , IsOverdraft;
	
	public function fullySecuredOverdraftBankStatements()
	{
		return $this->hasMany(FullySecuredOverdraftBankStatement::class,'fully_secured_overdraft_id','id');
	}
	public function bankStatements()
	{
		return $this->hasMany(FullySecuredOverdraftBankStatement::class , 'fully_secured_overdraft_id','id');
	}	
	
	public static function generateForeignKeyFormModelName()
	{
		return 'fully_secured_overdraft_id';
	}	
	public static function getBankStatementTableName()
	{
		return 'fully_secured_overdraft_bank_statements';
	}
	public static function getWithdrawalTableName()
	{
		return 'fully_secured_overdraft_withdrawals';
	}
	public static function getBankStatementIdName():string 
	{
		return 'fully_secured_overdraft_bank_statement_id';
	}
	public static function getTableNameFormatted()
	{
		return __('Fully Secured Overdraft');
	}
	public function internalMoneyTransfer()
	{
		return $this->belongsTo(InternalMoneyTransfer::class,'internal_money_transfer_id','id');
	}	
	public function cdOrTdAccountType()
	{
		return $this->belongsTo(AccountType::class,'cd_or_td_account_type_id','id');
	}
	public function getCdOrTdAccountTypeId()
	{
		return $this->cdOrTdAccountType ? $this->cdOrTdAccountType->id : 0 ; 
	}
	
	public function getCdOrTdAccountNumber()
	{
		return $this->cd_or_td_account_id;
	}
	
	
}
