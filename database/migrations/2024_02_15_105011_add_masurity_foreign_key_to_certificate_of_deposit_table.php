<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMasurityForeignKeyToCertificateOfDepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificates_of_deposits', function (Blueprint $table) {
			$table->integer('maturity_amount_added_to_account_id')->after('interest_amount');
			$table->foreign('maturity_amount_added_to_account_id','foreign_id')->references('id')->on('financial_institution_accounts')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificates_of_deposits', function (Blueprint $table) {
            //
        });
    }
}
