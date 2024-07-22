<?php

namespace App;

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
			self::CUSTOMER_INVOICE_PAST_DUE => __('Customer Invoice Past '),
			self::CUSTOMER_INVOICE_COMING_DUE => __('Customer Invoice Coming Due'),
			self::CUSTOMER_INVOICE_CURRENT_DUE => __('Customer Invoice Current Due'),
			self::SUPPLIER_INVOICE_PAST_DUE => __('Supplier Invoice Past Due'),
			self::SUPPLIER_INVOICE_CURRENT_DUE => __('Supplier Invoice Current Due'),
			self::SUPPLIER_INVOICE_COMING_DUE => __('Supplier Invoice Coming Due'),
			self::PENDING_PAYABLE_CHEQUES => __('Pending Payable Cheques'),
			self::CHEQUE_PAST_DUE => __('Cheques Past Due'),
			self::CHEQUE_CURRENT_DUE => __('Cheques Current Due'),
			self::CHEQUE_UNDER_COLLECTION_TODAY => __('Cheques Under Collection Due'),
			self::CHEQUE_UNDER_COLLECTION_SINCE_DAYS => __('Cheques Under Collection Since Days'),
		
		];
	}
	public static function getAllTypesFormatted():array 
	{
		return [
			self::CUSTOMER=>[
				'title'=>__('Customer Invoices') ,
				'subitems'=>[
					self::CUSTOMER_INVOICE_PAST_DUE ,
					self::CUSTOMER_INVOICE_COMING_DUE,
					self::CUSTOMER_INVOICE_CURRENT_DUE ,
					
				]
			],
			self::SUPPLIER=>[
				'title'=>__('Supplier Invoices'),
				'subitems'=>[
					self::SUPPLIER_INVOICE_PAST_DUE,
					self::SUPPLIER_INVOICE_CURRENT_DUE,
					self::SUPPLIER_INVOICE_COMING_DUE,
				]
			],
			self::RECEIVABLE_CHEQUE=> [
				'title'=>__('Payable Cheques') ,
				'subitems'=>[
					self::CHEQUE_PAST_DUE,
					self::CHEQUE_CURRENT_DUE,
					self::CHEQUE_UNDER_COLLECTION_TODAY,
					self::CHEQUE_UNDER_COLLECTION_SINCE_DAYS
				]
			],
			self::PENDING_PAYABLE_CHEQUE=>[
				'title'=>__('Receivable Cheques') ,
				'subitems'=>[
					self::PENDING_PAYABLE_CHEQUES
				]
			] ,
	
			 ];
		
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
