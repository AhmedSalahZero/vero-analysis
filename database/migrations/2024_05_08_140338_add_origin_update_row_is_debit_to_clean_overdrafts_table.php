<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginUpdateRowIsDebitToCleanOverdraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clean_overdrafts', function (Blueprint $table) {
            $table->boolean('origin_update_row_is_debit')->default(false)->comment('دلوقت احنا لما بنحدث وليكن ماني ريسيفد .. عايز نعرف ان الرو الاصلي اللي عدلناه كان ماني ريسيفد')->nullable();
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
