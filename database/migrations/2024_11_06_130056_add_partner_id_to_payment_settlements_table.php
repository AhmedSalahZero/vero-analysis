<?php

use App\Models\PaymentSettlement;
use App\Models\Settlement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use KitLoong\MigrationsGenerator\Setting;

class AddPartnerIdToPaymentSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settlements', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_id')->after('supplier_name')->default(0);
        });
		foreach(PaymentSettlement::get() as $settlement){
			DB::table('payment_settlements')->where('id',$settlement->id)->update([
				'partner_id'=>DB::table('partners')->where('is_supplier',1)
				->where('name',$settlement->supplier_name)->first()->id
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
        Schema::table('settlements', function (Blueprint $table) {
            //
        });
    }
}
