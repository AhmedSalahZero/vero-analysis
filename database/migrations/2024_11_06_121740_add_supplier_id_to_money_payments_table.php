<?php

use App\Models\MoneyPayment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierIdToMoneyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
		Schema::table('money_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_id')->after('id')->comment('partner_id')->nullable();
        });
		
		foreach(MoneyPayment::get() as $moneyPayment){
			DB::table('money_payments')->where('id',$moneyPayment->id)
			->update([
				'partner_id'=>DB::table('partners')->where($moneyPayment->partner_type,1)->where('name',$moneyPayment->supplier_name)->first()->id
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
