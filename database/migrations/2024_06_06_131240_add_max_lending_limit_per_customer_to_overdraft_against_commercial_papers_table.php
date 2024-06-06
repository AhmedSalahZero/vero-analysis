<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxLendingLimitPerCustomerToOverdraftAgainstCommercialPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overdraft_against_commercial_papers', function (Blueprint $table) {
            $table->decimal('max_lending_limit_per_customer',14,2)->after('admin_fees_rate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('overdraft_against_commercial_papers', function (Blueprint $table) {
            //
        });
    }
}
