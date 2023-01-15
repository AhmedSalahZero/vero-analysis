<?php

namespace App\Providers;

use App\Models\BalanceSheet;
use App\Models\CashFlowStatement;
use App\Models\CustomersInvoice;
use App\Models\IncomeStatement;
use App\Observers\BalanceSheetObserver;
use App\Observers\CashFlowStatementObserver;
use App\Observers\CustomersInvoiceObserver;
use App\Observers\IncomeStatementObserver;
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
        IncomeStatement::observe(IncomeStatementObserver::class);
        BalanceSheet::observe(BalanceSheetObserver::class);
        CashFlowStatement::observe(CashFlowStatementObserver::class);
    }
}
