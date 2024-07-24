<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentsToLcSettlementInternalMoneyTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('lc_settlement_internal_money_transfers', function (Blueprint $table) {
			$table->string('from_comment_en')->nullable()->after('company_id');
            $table->string('from_comment_ar')->nullable()->after('company_id');	
			$table->string('to_comment_en')->nullable()->after('from_comment_en');
            $table->string('to_comment_ar')->nullable()->after('from_comment_ar');
        });
		
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('current_account_bank_statements', function (Blueprint $table) {
            //
        });
    }
}
