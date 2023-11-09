<?php

namespace App\Observers;

use App\Models\CustomerInvoice;

class CustomerInvoiceObserver
{
    public function created(CustomerInvoice $customerInvoice)
	{
		$customerInvoice->syncNetBalance();
	}
	public function updated(CustomerInvoice $customerInvoice)
	{
		$customerInvoice->syncNetBalance();
	}
	public function deleting(CustomerInvoice $customerInvoice)
	{
		$customerInvoice->syncNetBalance();
	}
	
}
