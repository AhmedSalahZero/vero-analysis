<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('name');
            $table->integer('reservation_collection')->nullable();
            $table->integer('reservation_collection_month')->nullable();
            $table->integer('contract_collection')->nullable();
            $table->integer('contract_collection_month')->nullable();
            $table->integer('total_annual_collection')->nullable();
            $table->integer('annual_collection_count')->nullable();
            $table->string('annual_collection_start')->nullable();
            $table->integer('delivery_collection')->nullable();
            $table->integer('delivery_collection_month')->nullable();
            $table->string('delivery_collection_start')->nullable();
            $table->integer('installment_collection_start_month')->nullable();
            $table->string('installment_collection_interval')->nullable();
            $table->string('mortage_collection')->nullable()->default('0');
            $table->integer('mortage_collection_month')->nullable();
            $table->integer('maintenance_collection')->nullable();
            $table->integer('maintenance_collection_count')->nullable();
            $table->integer('maintenance_collection_start_month')->nullable();
            $table->string('maintenance_collection_interval')->nullable();
            $table->boolean('installment_duplication')->default(false);
            $table->integer('company_id');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('collections');
    }
}
