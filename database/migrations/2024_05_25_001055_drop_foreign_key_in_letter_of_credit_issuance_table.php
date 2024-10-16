<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignKeyInLetterOfCreditIssuanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_credit_issuances', function (Blueprint $table) {
            $table->dropForeign(['purchase_order_id']);
            $table->foreign('purchase_order_id')
                ->references('id')
                ->on('sales_orders')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_of_credit_issuance', function (Blueprint $table) {
            //
        });
    }
}
