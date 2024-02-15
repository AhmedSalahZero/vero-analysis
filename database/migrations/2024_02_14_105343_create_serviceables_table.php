<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serviceables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serviceable_type');
            $table->unsignedBigInteger('serviceable_id');
            $table->unsignedBigInteger('revenue_business_line_id');
            $table->unsignedBigInteger('service_category_id');
            $table->unsignedBigInteger('service_item_id');
            $table->unsignedBigInteger('service_nature_id');
            $table->double('delivery_days')->default(0);
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
        Schema::dropIfExists('serviceables');
    }
}
