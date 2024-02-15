<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsSeasonalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_seasonalities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('category_id');
            $table->decimal('sales_target_value', 20, 4)->nullable();
            $table->decimal('sales_target_percentage', 20, 4)->nullable();
            $table->enum('seasonality', ['new_seasonality_monthly', 'new_seasonality_quarterly'])->nullable();
            $table->json('seasonality_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_seasonalities');
    }
}
