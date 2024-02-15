<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_policies', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('company_id');
            $table->string('start_from')->nullable();
            $table->string('name');
            $table->enum('type', ['custom', 'instalment', 'last retention', 'installment_with_interest']);
            $table->string('down_payment')->nullable();
            $table->string('balance')->nullable();
            $table->integer('instalment_count')->nullable();
            $table->enum('instalment_interval', ['monthly', 'quartly', 'semi annually', 'annually'])->nullable();
            $table->enum('instalment_collection_nature', ['start', 'end'])->nullable();
            $table->integer('balance_duration')->nullable();
            $table->string('balance2')->nullable()->default('0');
            $table->integer('balance_duration2')->nullable()->default(0);
            $table->decimal('retention', 14)->nullable();
            $table->integer('retention_duration')->nullable();
            $table->string('created_by');
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
        Schema::dropIfExists('collection_policies');
    }
}
