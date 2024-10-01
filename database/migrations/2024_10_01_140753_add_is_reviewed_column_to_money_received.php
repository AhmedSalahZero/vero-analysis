<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AddIsReviewedColumnToMoneyReceived extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
        Schema::table('money_received', function (Blueprint $table) {
			$table->boolean('is_reviewed')->after('id')->default(0);
			$table->unsignedBigInteger('reviewed_by')->nullable()->after('is_reviewed')->comment('المشرف اللي حدد انه راجعه');
        });
		Artisan::call('refresh:permissions');
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
