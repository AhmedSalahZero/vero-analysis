<?php

namespace App\Models;

use App\NotificationSetting;
use App\Traits\StaticBoot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends Model implements HasMedia
{
	use
		StaticBoot,
		InteractsWithMedia ,
		Notifiable;
	protected $guarded = [];
	public function getIdentifier():int
    {
        return $this->{$this->getRouteKeyName()};
    }
    public function getId()
    {
        return $this->getIdentifier();
    }
	protected $casts = ['name' => 'array','generate_labeling_code_fields'=>'array','labeling_print_headers'=>'array'];
	public function users()
	{
		return $this->belongsToMany(User::class, 'companies_users');
	}
	public function subCompanies()
	{
		return $this->hasMany(Company::class, 'sub_of');
	}
	// public function branches()
	// {
	//     return $this->hasMany(Branch::class);
	// }
	public function getBranchesWithSectionsAttribute()
	{
		$branches = [];
		foreach ($this->branches as  $branch) {
			@count($branch->sections) == 0 ?: array_push($branches, $branch);
		}


		return $branches;
	}

	public function exportableModelFields($modelName)
	{
		return $this->hasOne(CustomizedFieldsExportation::class)->where('model_name', $modelName);
	}

	public function getName(): string
	{
		return $this->name[App()->getLocale()];
	}
	public function logs()
	{
		return $this->hasMany(Log::class , 'company_id','id');
	}
	public function isCachingNow()
	{
		return $this->is_caching_now;
	}
	public function getMainFunctionalCurrency():string
	{
		return strtoupper($this->main_functional_currency) ?: __('Main Functional Currency');
	}
	public function getLabelingHeight()
	{
		return $this->label_height ?: 100 ;
	}
	public function getLabelingHorizontalPadding()
	{
		return $this->getLabelingWidth() *0 ;
	}
	public function getLabelingVerticalPadding()
	{
		return $this->getLabelingHeight() * 0.05 ;
	}
	public function getLabelingMarginBottom()
	{
		return .2;
	}

	public function getLabelingWidth()
	{
		// logo (clients)
		// qrcode
		// code

		return $this->label_width ?: 100 ;
	}
	public function getFirstLabelingLogo()
	{
		$logo = $this->labeling_logo_1 ;
		return $logo && file_exists('storage/'.$logo ) ? asset('storage/'.$logo) : null ;
	}
	public function getSecondLabelingLogo()
	{
		$logo = $this->labeling_logo_2 ;
		return $logo && file_exists('storage/'.$logo ) ? asset('storage/'.$logo) : null ;
	}
	public function getThirdLabelingLogo()
	{
		$logo = $this->labeling_logo_3 ;
		return $logo && file_exists('storage/'.$logo ) ? asset('storage/'.$logo) : null ;
	}
	public function getStampLabelingLogo()
	{
		$logo = $this->labeling_stamp ;
		return $logo && file_exists('storage/'.$logo ) ? asset('storage/'.$logo) : null ;
	}
	public function notificationSetting()
	{
		return $this->hasOne(NotificationSetting::class , 'company_id','id');
	}
	public function getCustomerComingDuesInvoicesNotificationsDays():int
	{
		$notificationSetting = $this->notificationSetting ;
		return  $notificationSetting  ? $notificationSetting->getCustomerComingDuesInvoicesNotificationsDays() : NotificationSetting::CUSTOMER_COMING_DUES_INVOICES_NOTIFICATIONS_DAYS ;
	}
	public function getSupplierComingDuesInvoicesNotificationsDays():int
	{
		$notificationSetting = $this->notificationSetting ;
		return  $notificationSetting  ? $notificationSetting->getSupplierComingDuesInvoicesNotificationsDays() : NotificationSetting::SUPPLIER_COMING_DUES_INVOICES_NOTIFICATIONS_DAYS ;
	}
	public function getCustomerPastDuesInvoicesNotificationsDays():int
	{
		$notificationSetting = $this->notificationSetting ;
		return  $notificationSetting  ? $notificationSetting->getCustomerPastDuesInvoicesNotificationsDays() : NotificationSetting::CUSTOMER_PAST_DUES_INVOICES_NOTIFICATIONS_DAYS ;
	}
	public function getSupplierPastDuesInvoicesNotificationsDays():int
	{
		$notificationSetting = $this->notificationSetting ;
		return  $notificationSetting  ? $notificationSetting->getSupplierPastDuesInvoicesNotificationsDays() : NotificationSetting::SUPPLIER_PAST_DUES_INVOICES_NOTIFICATIONS_DAYS ;
	}
	public function getChequesInSafeNotificationDays():int
	{
		$notificationSetting = $this->notificationSetting ;
		return  $notificationSetting  ? $notificationSetting->getChequesInSafeNotificationsDays() : NotificationSetting::CHEQUES_IN_SAFE_NOTIFICATIONS_DAYS ;
	}
	public function getChequesUnderCollectionNotificationDays()
	{
		$notificationSetting = $this->notificationSetting ;
		return  $notificationSetting  ? $notificationSetting->getChequesUnderCollectionNotificationsDays() : NotificationSetting::CHEQUES_UNDER_COLLECTION_NOTIFICATIONS_DAYS ;
	}
	public function getPendingPayableChequeNotificationDays()
	{
		$notificationSetting = $this->notificationSetting ;
		return  $notificationSetting  ? $notificationSetting->getPendingPayableChequeNotificationDays() : NotificationSetting::CHEQUES_UNDER_COLLECTION_NOTIFICATIONS_DAYS ;
	}
	public function letterOfGuaranteeIssuances()
	{
		return $this->hasMany(LetterOfGuaranteeIssuance::class , 'company_id','id');
	}
	public function letterOfCreditIssuances()
	{
		return $this->hasMany(LetterOfCreditIssuance::class , 'company_id','id');
	}
	public function openingBalance()
	{
		return $this->hasOne(OpeningBalance::class,'company_id');
	}
    public function lgOpeningBalance()
	{
		return $this->hasOne(LgOpeningBalance::class,'company_id');
	}
	public function lcOpeningBalance()
	{
		return $this->hasOne(LcOpeningBalance::class,'company_id');
	}
	public function contracts()
	{
		return $this->hasMany(Contract::class,'company_id','id');
	}
	public function internalMoneyTransfers()
	{
		return $this->hasMany(InternalMoneyTransfer::class,'company_id','id');
	}
	public function bankToBankInternalMoneyTransfers()
	{
		return $this->internalMoneyTransfers()->where('type',InternalMoneyTransfer::BANK_TO_BANK);
	}
	public function safeToBankInternalMoneyTransfers()
	{
		return $this->internalMoneyTransfers()->where('type',InternalMoneyTransfer::SAFE_TO_BANK);
	}
	public function bankToSafeInternalMoneyTransfers()
	{
		return $this->internalMoneyTransfers()->where('type',InternalMoneyTransfer::BANK_TO_SAFE);
	}
	
	
	
	
	
	
	public function buyOrSellCurrencies()
	{
		return $this->hasMany(BuyOrSellCurrency::class,'company_id','id');
	}
	public function bankToBankBuyOrSellCurrencies()
	{
		return $this->buyOrSellCurrencies()->where('type',BuyOrSellCurrency::BANK_TO_BANK);
	}
	public function safeToBankBuyOrSellCurrencies()
	{
		return $this->buyOrSellCurrencies()->where('type',BuyOrSellCurrency::SAFE_TO_BANK);
	}
	public function bankToSafeBuyOrSellCurrencies()
	{
		return $this->buyOrSellCurrencies()->where('type',BuyOrSellCurrency::BANK_TO_SAFE);
	}
	public function safeToSafeBuyOrSellCurrencies()
	{
		return $this->buyOrSellCurrencies()->where('type',BuyOrSellCurrency::SAFE_TO_SAFE);
	}
	
	
	public function getHeadOfficeId()
	{
		return DB::table('branch')->where('company_id',$this->id)->orderByRaw('created_at asc')->first()->id;
	}
	public function cleanOverdrafts()
	{
		return $this->hasMany(CleanOverdraft::class , 'company_id','id');
	}
	public function fullySecuredOverdrafts()
	{
		return $this->hasMany(FullySecuredOverdraft::class , 'company_id','id');
	}
	public function overdraftAgainstCommercialPapers()
	{
		return $this->hasMany(OverdraftAgainstCommercialPaper::class , 'company_id','id');
	}
	public function overdraftAgainstAssignmentOfContracts()
	{
		return $this->hasMany(OverdraftAgainstAssignmentOfContract::class , 'company_id','id');
	}
	public function financialInstitutions()
	{
		return $this->hasMany(FinancialInstitution::class,'company_id','id');
	}
	public function getNotificationsBasedOnType($type):Collection
	{
		return $this->notifications->where('data.tap_type',$type);
	}
}
