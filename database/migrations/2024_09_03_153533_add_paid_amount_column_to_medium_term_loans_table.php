<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidAmountColumnToMediumTermLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medium_term_loans', function (Blueprint $table) {
            $table->decimal('paid_amount',14,2)->after('limit')->default(0);
            $table->decimal('outstanding_amount',14,2)->after('paid_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medium_term_loans', function (Blueprint $table) {
            //
        });
    }
}
