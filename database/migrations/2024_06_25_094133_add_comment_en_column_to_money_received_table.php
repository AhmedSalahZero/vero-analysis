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
        Schema::table('money_received', function (Blueprint $table) {
            $table->string('comment_en')->nullable()->after('company_id');
            $table->string('comment_ar')->nullable()->after('company_id');
        });
		
		Schema::table('money_payments', function (Blueprint $table) {
            $table->string('comment_en')->nullable()->after('company_id');
            $table->string('comment_ar')->nullable()->after('company_id');
        });
		
		Schema::table('internal_money_transfers', function (Blueprint $table) {
            $table->string('comment_en')->nullable()->after('company_id');
            $table->string('comment_ar')->nullable()->after('company_id');
        });
		
		Schema::table('buy_or_sell_currencies', function (Blueprint $table) {
            $table->string('comment_en')->nullable()->after('company_id');
            $table->string('comment_ar')->nullable()->after('company_id');
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
