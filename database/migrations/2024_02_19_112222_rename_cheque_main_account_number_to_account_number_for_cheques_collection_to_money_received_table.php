<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameChequeMainAccountNumberToAccountNumberForChequesCollectionToMoneyReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('money_received', function (Blueprint $table) {
			$table->dropColumn('cheque_sub_account_number');
        });
		
		Schema::table('clean_overdrafts', function (Blueprint $table) {
            $table->integer('to_be_setteled_max_within_days')->comment('الصفر يمثل غير محدود')->nullable()->default(null);
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('money_received', function (Blueprint $table) {
            //
        });
    }
}
