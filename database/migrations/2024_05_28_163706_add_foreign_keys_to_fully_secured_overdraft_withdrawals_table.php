<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFullySecuredOverdraftWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fully_secured_overdraft_withdrawals', function (Blueprint $table) {
            $table->foreign(['fully_secured_overdraft_bank_statement_id'], 'fully_secured_overdrafts_identifier')->references(['id'])->on('fully_secured_overdraft_bank_statements')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clean_overdraft_withdrawals', function (Blueprint $table) {
            $table->dropForeign('clean_overdrafts_identifier');
        });
    }
}
