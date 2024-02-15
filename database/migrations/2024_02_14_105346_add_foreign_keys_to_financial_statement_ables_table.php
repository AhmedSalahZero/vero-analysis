<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFinancialStatementAblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_statement_ables', function (Blueprint $table) {
            $table->foreign(['company_id'], 'company_id_income_statements')->references(['id'])->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_statement_ables', function (Blueprint $table) {
            $table->dropForeign('company_id_income_statements');
        });
    }
}
