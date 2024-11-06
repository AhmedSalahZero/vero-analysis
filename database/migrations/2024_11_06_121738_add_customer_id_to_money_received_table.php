<?php

use App\Models\MoneyReceived;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdToMoneyReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('money_received', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_id')->after('id')->comment('partner_id')->nullable();
        });
		
		foreach(MoneyReceived::get() as $moneyReceived){
			DB::table('money_received')->where('id',$moneyReceived->id)
			->update([
				'partner_id'=>DB::table('partners')->where($moneyReceived->partner_type,1)->where('name',$moneyReceived->customer_name)->first()->id
			]);
		}
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      
    }
}
