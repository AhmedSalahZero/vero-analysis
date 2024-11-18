<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TriggerChangeDayColumnToSalesGatheringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $items=DB::table('sales_gathering')->orderBy('id')->get();
		foreach($items as $item){
			DB::table('sales_gathering')->where('id',$item->id)->update([
				'updated_at'=>now()
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
        Schema::table('sales_gathering', function (Blueprint $table) {
            //
        });
    }
}
