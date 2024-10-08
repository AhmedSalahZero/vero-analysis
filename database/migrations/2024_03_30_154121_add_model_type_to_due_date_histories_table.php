<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModelTypeToDueDateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('due_date_histories', function (Blueprint $table) {
            $table->dropForeign(['customer_invoice_id']);
			$table->renameColumn('customer_invoice_id','model_id')->comment('هو الاي دي الخاص بال CustomerInvoice , SupplierInvoice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('due_date_histories', function (Blueprint $table) {
            //
        });
    }
}
