<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_statements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type')->default('actual');
            $table->string('duration');
            $table->enum('duration_type', ['monthly', 'annually', 'semi-annually', 'quarterly'])->default('monthly');
            $table->string('start_from');
            $table->unsignedBigInteger('company_id')->index('company_id_income_statements');
            $table->unsignedBigInteger('creator_id')->nullable()->index('creator_id_income_statements');
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
        Schema::dropIfExists('financial_statements');
    }
}
