<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModelTypeToUnappliedAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unapplied_amounts', function (Blueprint $table) {
            $table->dropForeign(['money_received_id']);
			$table->renameColumn('money_received_id','model_id')->comment('هو الاي دي الخاص بال MoneyReceived , MoneyPayment');
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
