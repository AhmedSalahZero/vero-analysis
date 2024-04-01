<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModelType2ToUnappliedAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unapplied_amounts', function (Blueprint $table) {
			$table->string('model_type')->comment('وليكن مثلا MoneyReceived , MoneyPayment');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unapplied_amounts', function (Blueprint $table) {
            //
        });
    }
}
