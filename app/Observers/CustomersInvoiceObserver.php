<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\CustomersInvoice;

class CustomersInvoiceObserver
{
        /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function creating(CustomersInvoice $customersInvoice)
    {
        // $customersInvoice->customer_name = ucfirst($customersInvoice->customer_name);

    }
    /**
     * Handle the customers invoice "created" event.
     *
     *
     * @param  \App\CustomersInvoice  $customersInvoice
     * @return void
     */
    public function created(CustomersInvoice $customersInvoice)
    {
        //
    }

    /**
     * Handle the customers invoice "updated" event.
     *
     * @param  \App\CustomersInvoice  $customersInvoice
     * @return void
     */
    public function updated(CustomersInvoice $customersInvoice)
    {
        //
    }

    /**
     * Handle the customers invoice "deleted" event.
     *
     * @param  \App\CustomersInvoice  $customersInvoice
     * @return void
     */
    public function deleted(CustomersInvoice $customersInvoice)
    {
        //
    }

    /**
     * Handle the customers invoice "restored" event.
     *
     * @param  \App\CustomersInvoice  $customersInvoice
     * @return void
     */
    public function restored(CustomersInvoice $customersInvoice)
    {
        //
    }

    /**
     * Handle the customers invoice "force deleted" event.
     *
     * @param  \App\CustomersInvoice  $customersInvoice
     * @return void
     */
    public function forceDeleted(CustomersInvoice $customersInvoice)
    {
        //
    }
}
