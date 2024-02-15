<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labeling_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('update_at')->nullable();
            $table->string('building_name')->nullable();
            $table->string('c1')->nullable();
            $table->string('sub_2')->nullable();
            $table->string('c2')->nullable();
            $table->string('location')->nullable();
            $table->string('c3')->nullable();
            $table->string('sub_3')->nullable();
            $table->string('c4')->nullable();
            $table->string('classification')->nullable();
            $table->string('c5')->nullable();
            $table->string('sub_22')->nullable();
            $table->string('c6')->nullable();
            $table->string('sub_32')->nullable();
            $table->string('c7')->nullable();
            $table->string('qty')->nullable();
            $table->string('code')->nullable();
            $table->string('item')->nullable();
            $table->string('17')->nullable();
            $table->string('ahmed_salah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labeling_items');
    }
}
