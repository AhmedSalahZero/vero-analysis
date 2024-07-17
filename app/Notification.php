<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	const CUSTOMER = 'customer';
	const SUPPLIER = 'supplier';
	const RECEIVABLE_CHEQUE = 'receivable_cheque';
	const PENDING_PAYABLE_CHEQUE = 'pending_payable_cheque';
	
    protected $guarded = ['id'];
	public static function getAllTypesFormatted():array 
	{
		return [self::CUSTOMER=>__('Customer'),self::SUPPLIER=>__('Supplier'),self::RECEIVABLE_CHEQUE=>__('Receivable Cheques') , self::PENDING_PAYABLE_CHEQUE=> __('Payable Cheques') ];
		
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
