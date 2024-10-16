<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFullySecuredOverdraftRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('fully_secured_overdrafts',function(Blueprint $table){
			$table->dropColumn('borrowing_rate');
			$table->dropColumn('bank_margin_rate');
			$table->dropColumn('interest_rate');
			$table->dropColumn('min_interest_rate');
		});
		
        Schema::create('fully_secured_overdraft_rates', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('full_secured_overdraft_id');
			$table->date('date');
			$table->decimal('borrowing_rate',14,2)->default(0);
			$table->decimal('margin_rate',14,2)->default(0);
			$table->decimal('interest_rate',14,2)->default(0);
			$table->decimal('min_interest_rate',14,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fully_secured_overdrafts');
    }
}
