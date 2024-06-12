<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveColumnToOverdraftAgainstCommercialPaperLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overdraft_against_commercial_paper_limits', function (Blueprint $table) {
            $table->boolean('is_active')->after('id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('overdraft_against_commercial_paper_limits', function (Blueprint $table) {
            //
        });
    }
}
