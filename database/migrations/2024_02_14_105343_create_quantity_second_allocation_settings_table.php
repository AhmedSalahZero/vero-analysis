<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuantitySecondAllocationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantity_second_allocation_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->nullable();
            $table->enum('allocation_base', ['branch', 'business_sector', 'sales_channel', 'zone']);
            $table->enum('breakdown', ['previous_year', 'last_3_years', 'new_breakdown_annually', 'new_breakdown_quarterly'])->nullable();
            $table->boolean('add_new_items')->default(false);
            $table->integer('number_of_items')->default(0);
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
        Schema::dropIfExists('quantity_second_allocation_settings');
    }
}
