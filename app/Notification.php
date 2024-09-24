<?php

namespace App;

use App\Helpers\HArr;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	const CUSTOMER = 'customer';
	const SUPPLIER = 'supplier';
	const RECEIVABLE_CHEQUE = 'receivable_cheque';
	const PENDING_PAYABLE_CHEQUE = 'pending_payable_cheque';
	const CUSTOMER_INVOICE_PAST_DUE = 'customer_invoice_past_due';
	const SUPPLIER_INVOICE_PAST_DUE = 'supplier_invoice_past_due';
	const CUSTOMER_INVOICE_CURRENT_DUE = 'customer_invoice_current_due';
	const SUPPLIER_INVOICE_CURRENT_DUE = 'supplier_invoice_current_due';
	const CUSTOMER_INVOICE_COMING_DUE = 'customer_invoice_coming_due';
	const SUPPLIER_INVOICE_COMING_DUE = 'supplier_invoice_coming_due';
	const PENDING_PAYABLE_CHEQUES = 'pending_payable_cheque';
	const CHEQUE_PAST_DUE = 'cheque_past_due';
	const CHEQUE_CURRENT_DUE = 'cheque_current_due';
	const CHEQUE_UNDER_COLLECTION_TODAY = 'cheque_under_collection_today';
	const CHEQUE_UNDER_COLLECTION_SINCE_DAYS = 'cheque_under_collection_since_days';
    protected $guarded = ['id'];
	public static function getAllMainTypes():array 
	{
		return [
			self::CUSTOMER_INVOICE_PAST_DUE => __('Customer Invoice Past Dues'),
			self::CUSTOMER_INVOICE_COMING_DUE => __('Customer Invoice Coming Dues'),
			self::CUSTOMER_INVOICE_CURRENT_DUE => __('Customer Invoice Current Dues'),
			self::SUPPLIER_INVOICE_PAST_DUE => __('Supplier Invoice Past Dues'),
			self::SUPPLIER_INVOICE_CURRENT_DUE => __('Supplier Invoice Current Dues'),
			self::SUPPLIER_INVOICE_COMING_DUE => __('Supplier Invoice Coming Dues'),
			self::PENDING_PAYABLE_CHEQUES => __('Pending Payable Cheques'),
			self::CHEQUE_PAST_DUE => __('Cheques Past Dues'),
			self::CHEQUE_CURRENT_DUE => __('Cheques Current Dues'),
			self::CHEQUE_UNDER_COLLECTION_TODAY => __('Cheques Under Collection Dues'),
			self::CHEQUE_UNDER_COLLECTION_SINCE_DAYS => __('Cheques Under Collection Since Days'),
		
		];
	}
	public static function getAllTypesFormatted():array 
	{
		$user = auth()->user();
		/**
		 * @var User $user ;
		 */
		if(!$user){
			return [];
		}
	
		
		$canViewCustomerInvoicePastDueNotification = $user->can('view customer invoice past due notification');
		$canViewCustomerInvoiceComingDueNotification = $user->can('view customer invoice coming due notification');
		$canViewCustomerInvoiceCurrentDueNotification = $user->can('view customer invoice current due notification');
		$canViewCustomerInvoicesNotifications = $canViewCustomerInvoicePastDueNotification || $canViewCustomerInvoiceComingDueNotification||$canViewCustomerInvoiceCurrentDueNotification ;
		
		
		
		$canViewSupplierInvoicesPastDueNotifications = $user->can('view supplier invoices past due notifications');
		$canViewSupplierInvoicesCurrentDueNotification = $user->can('view supplier invoices current due notifications');
		$canViewSupplierInvoicesComingDueNotification = $user->can('view supplier invoices coming due notifications');
		$canViewSupplierInvoicesNotifications = $canViewSupplierInvoicesPastDueNotifications || $canViewSupplierInvoicesCurrentDueNotification || $canViewSupplierInvoicesComingDueNotification;
		
		
		$canViewChequePastDueNotifications = $user->can('view cheque past due notifications');
		$canViewChequeComingDueNotifications = $user->can('view cheque current due notifications');
		$canViewChequeUnderCollectionTodayNotifications = $user->can('view cheque under collection today notifications');
		$canViewChequeUnderCollectionSinceDaysNotifications = $user->can('view cheque under collection since days notifications');
		$canViewReceivableChequesNotifications = $canViewChequePastDueNotifications || $canViewChequeComingDueNotifications ||$canViewChequeUnderCollectionTodayNotifications || $canViewChequeUnderCollectionSinceDaysNotifications;
		 
		$items = [];
		
		if($canViewCustomerInvoicePastDueNotification){
			$items[self::CUSTOMER]=[
				'title'=>__('Customer Invoices') ,
				'subitems'=>HArr::filterTrulyValue([
					$canViewCustomerInvoicePastDueNotification ? self::CUSTOMER_INVOICE_PAST_DUE : false ,
					$canViewCustomerInvoicesNotifications ? self:: CUSTOMER_INVOICE_COMING_DUE : false,
					$canViewCustomerInvoiceCurrentDueNotification ? self::CUSTOMER_INVOICE_CURRENT_DUE : false ,
				])
				];
		}
		if($canViewSupplierInvoicesNotifications){
			$items[self::SUPPLIER] = [
				'title'=>__('Supplier Invoices'),
				'subitems'=>HArr::filterTrulyValue([
					$canViewSupplierInvoicesPastDueNotifications ? self::SUPPLIER_INVOICE_PAST_DUE : false,
					$canViewSupplierInvoicesCurrentDueNotification ?  self::SUPPLIER_INVOICE_CURRENT_DUE : false ,
					$canViewSupplierInvoicesComingDueNotification ? self::SUPPLIER_INVOICE_COMING_DUE : false ,
				])
				];
		}
		if($canViewReceivableChequesNotifications){
			$items[self::RECEIVABLE_CHEQUE] = [
				'title'=>__('Receivable Cheques') ,
				'subitems'=>HArr::filterTrulyValue([
					$canViewChequePastDueNotifications ?self::CHEQUE_PAST_DUE:false,
					$canViewChequeComingDueNotifications ? self::CHEQUE_CURRENT_DUE : false ,
					$canViewChequeUnderCollectionTodayNotifications ? self::CHEQUE_UNDER_COLLECTION_TODAY : false ,
					$canViewChequeUnderCollectionSinceDaysNotifications ? self::CHEQUE_UNDER_COLLECTION_SINCE_DAYS : false
				])
				];
		}
		if($user->can('view pending payable cheques notifications')){
			$items[self::PENDING_PAYABLE_CHEQUE] = [
				'title'=>__('Payable Cheques') ,
				'subitems'=>HArr::filterTrulyValue([
					$user->can('view pending payable cheques notifications') ? self::PENDING_PAYABLE_CHEQUES:false
				])
			];
		}
		return $items ; 
	}
	public static function formatForMenuItem():array 
	{
		$formattedItems = [];
		foreach(self::getAllTypesFormatted() as $mainTypeId => $detailArray ){
			$mainArr = [
				'title'=>$detailArray['title'],
				'link'=>'#',
				'show'=>true ,
			];
			$subItems = [];
			foreach($detailArray['subitems'] as $subItemId){
				$subItemTitle = self::getAllMainTypes()[$subItemId] ;
				$subItems[] = [
					'title'=>$subItemTitle,
					'show'=>true ,
					'data-show-notification-modal'=>$subItemId,
					'link'=>'#'
				];
			}
			$mainArr['submenu'] = $subItems ;
			$formattedItems[] = $mainArr;
		}
		return $formattedItems;
	}
	public static function getSearchFieldsBasedOnTypes():array 
	{
		return [
			Notification::CUSTOMER=>[
				'created_at'=>__('Date')
			],
			Notification::SUPPLIER=>[
				'created_at'=>__('Date')
			],
			Notification::RECEIVABLE_CHEQUE=>[
				'created_at'=>__('Date')
			],
			Notification::PENDING_PAYABLE_CHEQUE=>[
				'created_at'=>__('Date')
			]
		];
	}
	
	
}
