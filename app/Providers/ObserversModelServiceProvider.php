<?php

namespace App\Providers;
use App\Models\CustomersInvoice;
use App\Observers\CustomersInvoiceObserver;
use Illuminate\Support\ServiceProvider;

class ObserversModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        CustomersInvoice::observe(CustomersInvoiceObserver::class);
    }
}
