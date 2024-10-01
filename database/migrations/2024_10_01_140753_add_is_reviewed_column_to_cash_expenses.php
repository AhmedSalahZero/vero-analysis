<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReviewedColumnToCashExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
        Schema::table('cash_expenses', function (Blueprint $table) {
			$table->boolean('is_reviewed')->after('id')->default(0);
			$table->unsignedBigInteger('reviewed_by')->nullable()->after('is_reviewed')->comment('المشرف اللي حدد انه راجعه');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_expenses', function (Blueprint $table) {
            //
        });
    }
}
