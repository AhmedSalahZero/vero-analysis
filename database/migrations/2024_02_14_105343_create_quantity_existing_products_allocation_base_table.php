<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuantityExistingProductsAllocationBaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantity_existing_products_allocation_base', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->nullable();
            $table->enum('allocation_base', ['branch', 'business_sector', 'sales_channel', 'zone']);
            $table->json('existing_products_target')->nullable();
            $table->decimal('total_existing_target', 20)->nullable();
            $table->boolean('use_modified_targets')->default(false);
            $table->json('allocation_base_percentages');
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('quantity_existing_products_allocation_base');
    }
}
