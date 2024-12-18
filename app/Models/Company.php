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
		return $this->hasMany(LetterOfGuaranteeIssuance::class , 'company_id','id')->orderByRaw("case status when 'cancelled' then 2 else 1 end , renewal_date asc ");
	}
	public function letterOfCreditIssuances()
	{
		return $this->hasMany(LetterOfCreditIssuance::class , 'company_id','id');
	}
	public function openingBalance()
	{
		return $this->hasOne(OpeningBalance::class,'company_id');
	}
    // public function lgOpeningBalance()
	// {
	// 	return $this->hasOne(LgOpeningBalance::class,'company_id');
	// }
	// public function lcOpeningBalance()
	// {
	// 	return $this->hasOne(LcOpeningBalance::class,'company_id');
	// }
	public function contracts()
	{
		return $this->hasMany(Contract::class,'company_id','id');
	}
	public function lcSettlementInternalMoneyTransfers()
	{
		return $this->hasMany(LcSettlementInternalMoneyTransfer::class,'company_id','id');
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
	public function bankToLcSettlementInternalMoneyTransfers()
	{
		return $this->lcSettlementInternalMoneyTransfers()->where('type',LcSettlementInternalMoneyTransfer::BANK_TO_LETTER_OF_CREDIT);
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
		return $this->hasMany(FinancialInstitution::class,'company_id','id')
		->join('banks','banks.id','=','financial_institutions.bank_id')
		->selectRaw('financial_institutions.* , banks.name_en as bank_name')
		->orderBy('bank_name');
	}
	public function getNotificationsBasedOnType($type):Collection
	{
		return $this->notifications->where('data.tap_type',$type);
	}
	public function cashExpenses()
	{
		return $this->hasMany(CashExpense::class , 'company_id','id');
	}
	public function getCashExpenseCashPayments(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->cashExpenses->where('type',CashExpense::CASH_PAYMENT)->whereNull('opening_balance_id')->filterByPaymentDate($startDate,$endDate) ;
	}
	public function getCashExpenseOutgoingTransfer(?string $startDate = null ,?string $endDate = null):Collection
	{
		return $this->cashExpenses->where('type',CashExpense::OUTGOING_TRANSFER)->filterByPaymentDate($startDate,$endDate) ;
	}	
	public function getCashExpensePayableCheques(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->cashExpenses->where('type',CashExpense::PAYABLE_CHEQUE)->filterByPaymentDate($startDate,$endDate)->filter(function(CashExpense $cashExpense){
			$payableCheque = $cashExpense->payableCheque ;
			return $payableCheque && in_array($payableCheque->getStatus(),[PayableCheque::PENDING,PayableCheque::PAID]) ;
		})->values();
	}
	
	 /**
	  * * For Money Payments 
	  */
	  
	  public function moneyPayments()
	{
		return $this->hasMany(MoneyPayment::class , 'company_id','id')
		// ->where('company_id',getCurrentCompanyId())
		;
	}
	
	public function getMoneyPaymentCashPayments(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyPayments->where('type',MoneyPayment::CASH_PAYMENT)->whereNull('opening_balance_id')->filterByDeliveryDate($startDate,$endDate) ;
	}
	public function getMoneyPaymentOutgoingTransfer(?string $startDate = null ,?string $endDate = null):Collection
	{
		return $this->moneyPayments->where('type',MoneyPayment::OUTGOING_TRANSFER)->filterByDeliveryDate($startDate,$endDate) ;
	}	
	public function getMoneyPaymentPayableCheques(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyPayments->where('type',MoneyPayment::PAYABLE_CHEQUE)->filterByDeliveryDate($startDate,$endDate)->filter(function(MoneyPayment $moneyPayment){
			$payableCheque = $moneyPayment->payableCheque ;
			return $payableCheque && in_array($payableCheque->getStatus(),[PayableCheque::PENDING,PayableCheque::PAID]) ;
		})->values();
	}
	
	public function mediumTermLoans()
	{
		return $this->hasMany(MediumTermLoan::class,'company_id','id');
	}
	public function systems()
	{
		return $this->hasMany(CompanySystem::class,'company_id','id');
	}
	public function hasSystem(string $systemName)
	{
		return in_array($systemName,$this->getSystemsNames());
	}
	public function getSystemsNames():array
	{
		return $this->systems->pluck('system_name')->toArray();
	}
	public function hasCashVero():bool
	{
		return in_array(CASH_VERO,$this->getSystemsNames())
		|| (auth()->check() && auth()->user()->isSuperAdmin());
		// return $this->system == 'cash-vero' || $this->system == 'both' || (auth()->check() && auth()->user()->isSuperAdmin());
	}
	// public function getSystem()
	// {
	// 	return $this->system ;
	// }
	public function syncPermissionForAllUser(array $systemsToPreserve , array $newSystemsToBeAdded):void
	{
		$permissionsNamesToBePreserve = array_column(getPermissions($systemsToPreserve),'name'); 
		$permissionsNamesToBeAdded = array_column(getPermissions($newSystemsToBeAdded),'name');
		foreach($this->users as $user){
			$currentUserPermissions = array_values(array_intersect($user->permissions->pluck('name')->toArray(),$permissionsNamesToBePreserve));
			$permissions = array_merge($currentUserPermissions,$permissionsNamesToBeAdded);
			$user->syncPermissions($permissions);
		}	
	}
	public function customers()
	{
		return $this->hasMany(Partner::class,'company_id','id')->where('is_customer',1)->orderBy('name');
	}
	public function suppliers()
	{
		return $this->hasMany(Partner::class,'company_id','id')->where('is_supplier',1)->orderBy('name');
	}
	public function employees()
	{
		return $this->hasMany(Partner::class,'company_id','id')->where('is_employee',1)->orderBy('name');
	}
	public function shareholders()
	{
		return $this->hasMany(Partner::class,'company_id','id')->where('is_shareholder',1)->orderBy('name');
	}	
	public function subsidiaryCompanies()
	{
		return $this->hasMany(Partner::class,'company_id','id')->where('is_subsidiary_company',1)->orderBy('name');
	}
	public function otherPartners()
	{
		return $this->hasMany(Partner::class,'company_id','id')->where('is_other_partner',1)->orderBy('name');
	}
	public function businessSectors()
	{
		return $this->hasMany(CashVeroBusinessSector::class,'company_id','id')->orderBy('name');
	}
	public function salesChannels()
	{
		return $this->hasMany(CashVeroSalesChannel::class,'company_id','id')->orderBy('name');
	}
	public function salesPersons()
	{
		return $this->hasMany(CashVeroSalesPerson::class,'company_id','id')->orderBy('name');
	}
	public function businessUnits()
	{
		return $this->hasMany(CashVeroBusinessUnit::class,'company_id','id')->orderBy('name');
	}
	public function branches()
	{
		return $this->hasMany(CashVeroBranch::class,'company_id','id')->orderBy('name');
	}
	public function financialInstitutionsBanks():Collection
	{
		return $this->financialInstitutions->where('type','bank') ;
	}
	public function financialInstitutionsLeasingCompanies():Collection
	{
		return $this->financialInstitutions->where('type','leasing_companies') ;
	}
	public function financialInstitutionsFactoringCompanies():Collection
	{
		return $this->financialInstitutions->where('type','factoring_companies') ;
	}
	public function financialInstitutionsMortgageCompanies():Collection
	{
		return $this->financialInstitutions->where('type','mortgage_companies') ;
	}
	public function getMoneyReceived():Collection
	{
		return $this->moneyReceived->where('company_id',getCurrentCompanyId()) ;
	}
	public function getReceivedChequesInSafe(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CHEQUE)->filterByReceivingDate($startDate,$endDate)->filter(function(MoneyReceived $moneyReceived){
			$cheque = $moneyReceived->cheque ;
			return $cheque && in_array($cheque->getStatus(),[Cheque::IN_SAFE]) ;
		})->values();
		
	}
	/**
	 * * هي الشيكات اللي اترفضت ورجعتها الخزنة تاني وليكن مثلا بسبب ان حساب العميل مفيهوش فلوس حاليا
	 */
	public function getReceivedRejectedChequesInSafe(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CHEQUE)->filterByReceivingDate($startDate,$endDate)->filter(function(MoneyReceived $moneyReceived){
			$cheque = $moneyReceived->cheque ;
			return $cheque && in_array($cheque->getStatus(),[Cheque::REJECTED]) ;
		})->values();
	}
	
	public function getCollectedCheques(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CHEQUE)->filterByReceivingDate($startDate,$endDate)->filter(function(MoneyReceived $moneyReceived){
			$cheque = $moneyReceived->cheque ;
			return $cheque && in_array($cheque->getStatus(),[Cheque::COLLECTED]) ;
		})->values();
	}
	
	public function getReceivedChequesUnderCollection(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CHEQUE)->filterByReceivingDate($startDate,$endDate)->filter(function(MoneyReceived $moneyReceived){
			$cheque = $moneyReceived->cheque ;
			return $cheque && in_array($cheque->getStatus(),[Cheque::UNDER_COLLECTION]) ;
		})->values();
	}
	public function getReceivedCashesInSafe(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CASH_IN_SAFE)->whereNull('opening_balance_id')->filterByReceivingDate($startDate,$endDate) ;
	}
	public function getReceivedCashesInBank(?string $startDate = null , ?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::CASH_IN_BANK)->filterByReceivingDate($startDate,$endDate) ;
	}
	public function getReceivedTransfer(?string $startDate = null ,?string $endDate = null):Collection
	{
		return $this->moneyReceived->where('type',MoneyReceived::INCOMING_TRANSFER)->filterByReceivingDate($startDate,$endDate) ;
	}
	public function moneyReceived()
	{
		return $this->hasMany(MoneyReceived::class , 'company_id','id')
		// ->where('company_id',getCurrentCompanyId())
		;
	}
	public function deductions()
	{
		return $this->hasMany(Deduction::class,'company_id','id');
	}
	
	public function getOddoDBUrl()
	{
		return $this->oddo_db_url;
	}
	public function getOddoDBName()
	{
		return $this->oddo_db_name;
	}
	public function getOddoDBUserName()
	{
		return $this->oddo_username;
	}
	public function getOddoDBPassword()
	{
		return $this->oddo_db_password;
	}
	public function hasOddoIntegrationCredentials():bool
	{
		return $this->getOddoDBUrl() && $this->getOddoDBName() && $this->getOddoDBUserName() && $this->getOddoDBPassword();
	}
	public function lastUploadFileNames()
	{
		return $this->hasMany(LastUploadFileName::class,'company_id');
	}
	public function addNewFileUploadFileNameFor(string $fileName,string $modelName):LastUploadFileName{
		return $this->lastUploadFileNames()->create([
			'name'=>$fileName,
			'status'=>LastUploadFileName::CURRENT,
			'company_id'=>$this->id,
			'model_name'=>$modelName,
		]);
	}
	public function updateLastUploadFileNameStatus(string $modelName){
		return $this->lastUploadFileNames->where('status',LastUploadFileName::CURRENT)
		->where('model_name',$modelName)
		->last()->update([
			'status'=>LastUploadFileName::SUCCESS
		]);
		
	}
	public function getCurrentLastFileNameForModel(string $modelName){
		$lastFile = $this->lastUploadFileNames->where('status',LastUploadFileName::CURRENT)
		->where('model_name',$modelName)
		->last();
		return $lastFile ? $lastFile->name : __('N/A');
	}
	public function getSuccessLastFileNameForModel(string $modelName){
		$lastFile = $this->lastUploadFileNames->where('status',LastUploadFileName::SUCCESS)
		->where('model_name',$modelName)
		->last();
		return $lastFile ? $lastFile->name : __('N/A');
	}
	public function hasLastSuccessfullyUploadFileForModel(string $modelName){
		return  $this->lastUploadFileNames()->where('status',LastUploadFileName::SUCCESS)
		->where('model_name',$modelName)
		->exists();
	}
	public function hasLastCurrentUploadFileForModel(string $modelName){
		return  $this->lastUploadFileNames()->where('status',LastUploadFileName::CURRENT)
		->where('model_name',$modelName)
		->exists();
	}
	
	public function deleteAllOldLastUploadFileNamesFor(string $modelName,string $status):void{
		$this->lastUploadFileNames->where('model_name',$modelName)
		->where('status',$status)
		->each(function($lastUploadFileName){
			$lastUploadFileName->delete();
		});
	}
	
}
