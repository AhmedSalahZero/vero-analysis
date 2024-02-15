<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsPlanningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_planning', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('asset_id');
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('payment_method_id');
            $table->integer('quantity');
            $table->enum('type', ['old', 'new']);
            $table->string('asset_value', 191);
            $table->string('depreciation_rate', 191);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
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
        Schema::dropIfExists('assets_planning');
    }
}
