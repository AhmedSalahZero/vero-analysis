<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModelType2ToDueDateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('due_date_histories', function (Blueprint $table) {
			$table->string('model_type')->after('model_id')->comment('وليكن مثلا CustomerInvoice , SupplierInvoice');
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
