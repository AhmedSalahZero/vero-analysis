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
		return $this->hasMany(FullySecuredOverdraftBankStatement::class,'clean_overdraft_id','id');
	}
	public function bankStatements()
	{
		return $this->hasMany(CleanOverdraftBankStatement::class , 'clean_overdraft_id','id');
	}	
	
	public function generateForeignKeyFormModelName()
	{
		return 'clean_overdraft_id';
	}	
	public function getBankStatementTableName()
	{
		return 'clean_overdraft_bank_statements';
	}
	
	
}
