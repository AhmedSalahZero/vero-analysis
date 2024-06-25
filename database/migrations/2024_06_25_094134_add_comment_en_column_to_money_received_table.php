<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentEnColumnToMoneyReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
 
		
		Schema::table('internal_money_transfers', function (Blueprint $table) {
			$table->string('from_comment_en')->nullable()->after('company_id');
            $table->string('from_comment_ar')->nullable()->after('company_id');
			$table->renameColumn('comment_en','to_comment_en');
			$table->renameColumn('comment_ar','to_comment_ar');
        });
		Schema::table('buy_or_sell_currencies', function (Blueprint $table) {
			$table->string('buy_comment_en')->nullable()->after('company_id');
            $table->string('buy_comment_ar')->nullable()->after('company_id');
			$table->renameColumn('comment_en','sell_comment_en');
			$table->renameColumn('comment_ar','sell_comment_ar');
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
