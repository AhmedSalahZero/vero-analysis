<?php

use App\Models\Settlement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use KitLoong\MigrationsGenerator\Setting;

class AddPartnerIdToSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_id')->after('customer_name')->default(0);
        });
		foreach(Settlement::get() as $settlement){
			DB::table('settlements')->where('id',$settlement->id)->update([
				'partner_id'=>DB::table('partners')->where('is_customer',1)
				->where('name',$settlement->customer_name)->first()->id
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
