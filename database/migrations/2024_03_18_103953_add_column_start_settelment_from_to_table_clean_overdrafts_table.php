<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStartSettelmentFromToTableCleanOverdraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clean_overdrafts', function (Blueprint $table) {
            $table->unsignedBigInteger('start_settlement_from_bank_statement_id')->nullable()->comment('هو عباره عن الكولوم اللي هنبدا نعمل سيتلمنت من عنده تاني ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clean_overdrafts', function (Blueprint $table) {
            //
        });
    }
}
