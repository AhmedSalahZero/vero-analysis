<?php

namespace App;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $guarded = ['id'];
	
	const CUSTOMER_COMING_DUES_INVOICES_NOTIFICATIONS_DAYS = 3;
	const CUSTOMER_PAST_DUES_INVOICES_NOTIFICATIONS_DAYS = 1;
	const CHEQUES_IN_SAFE_NOTIFICATIONS_DAYS = 3;
	const CHEQUES_UNDER_COLLECTION_NOTIFICATIONS_DAYS = 0;
	
	public function getId()
	{
		return $this->id;
	}
	public function company()
	{
		return $this->belongsTo(Company::class , 'company_id','id');
	}
	/**
	 * * هو عبارة عن عدد الايام اللي المفروض السيستم يبعت قبلها نوتيفكشن في حالة استحقاق فواتير العملاء
	 */
	public function getCustomerComingDuesInvoicesNotificationsDays()
	{
		// before due date
		return $this->customer_coming_dues_invoices_notifications_days;
	}

	
	/**
	 * * هو عبارة عن عدد الايام اللي المفروض السيستم يبعت بعدها نوتيفكشن في حالة لو الفاتورة المتاخره في السداد من فواتير العملاء
	 */
	public function getCustomerPastDuesInvoicesNotificationsDays()
	{
		return $this->customer_past_dues_invoices_notifications_days;
	}

	
	 /**
	 * * هو عبارة عن عدد الايام اللي قبل ما الشيك يستحق علشان اروح ابعته البنك
	 */
	public function getChequesInSafeNotificationsDays()
	{
		return $this->cheques_in_safe_notifications_days;
	}

	
		
	 /**
	 * * هو عبارة عن عدد الايام اللي المفروض ينبهني ان الشيك تم تحصيلة ولا لا لان ممكن يكون الشيك ارتد
	 * * ودا هيتحسب من تاريخ ال
	 * * expected_collection_date
	 */
	public function getChequesUnderCollectionNotificationsDays()
	{
		return $this->cheques_under_collection_notifications_days;
	}
	
	
		/**
	 * * هو عبارة عن عدد الايام اللي المفروض السيستم يبعت قبلها نوتيفكشن في حالة استحقاق فواتير الموريدين
	 */
	public function getSupplierComingDuesInvoicesNotificationsDays()
	{
		return $this->supplier_coming_dues_invoices_notifications_days;
	}

	
	/**
	 * * هو عبارة عن عدد الايام اللي المفروض السيستم يبعت بعدها نوتيفكشن في حالة لو الفاتورة المتاخره في السداد من فواتير الموردين
	 */
	public function getSupplierPastDuesInvoicesNotificationsDays()
	{
		return $this->supplier_past_dues_invoices_notifications_days;
	}
	

	
	
	
}
