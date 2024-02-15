<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialStatementAbleMainItemCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_statement_able_main_item_calculations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('financial_statement_able_id');
            $table->integer('financial_statement_able_item_id');
            $table->json('payload');
            $table->string('total');
            $table->string('sub_item_type')->default('forecast');
            $table->integer('company_id');
            $table->integer('creator_id');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_statement_able_main_item_calculations');
    }
}
