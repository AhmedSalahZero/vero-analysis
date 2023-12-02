<?php

namespace App\Observers;

use App\Models\CustomerInvoice;

class CustomerInvoiceObserver
{
    public function created(CustomerInvoice $customerInvoice)
	{
		// $customerInvoice->syncNetBalance();
		// $customerInvoice->insertInvoiceDateMonthAndYearColumnsInDB();
		// $customerInvoice->calculateAmountInMainCurrency();
	}
	public function updated(CustomerInvoice $customerInvoice)
	{
		// $customerInvoice->syncNetBalance();
		// $customerInvoice->insertInvoiceDateMonthAndYearColumnsInDB();
		// $customerInvoice->calculateAmountInMainCurrency();
	}
	public function deleting(CustomerInvoice $customerInvoice)
	{
		// $customerInvoice->syncNetBalance();
		// $customerInvoice->insertInvoiceDateMonthAndYearColumnsInDB();
		// $customerInvoice->calculateAmountInMainCurrency();
	}
	
}
