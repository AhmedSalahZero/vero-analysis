<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('company_id');
			$table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
			
			$table->unsignedBigInteger('contract_id');
			$table->foreign('contract_id')->references('id')->on('contracts')->cascadeOnDelete();
			
			$table->string('so_number')->nullable();
			$table->decimal('amount',14,2)->nullable()->default(0);
			
			for($i = 1 ; $i <= 5 ; $i++){
				$table->date('start_date_'.$i)->nullable();
				$table->date('end_date_'.$i)->nullable();
				$table->decimal('execution_percentage_'.$i,5,2)->nullable()->default(0);
				$table->integer('execution_days_'.$i)->nullable()->default(0);
				$table->integer('collection_days_'.$i)->nullable()->default(0);
			}
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
        Schema::dropIfExists('sales_orders');
    }
}
