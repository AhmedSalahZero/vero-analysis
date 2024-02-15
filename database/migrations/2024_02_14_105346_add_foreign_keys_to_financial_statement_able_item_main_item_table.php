<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFinancialStatementAbleItemMainItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_statement_able_item_main_item', function (Blueprint $table) {
            $table->foreign(['company_id'], 'company_id_income_statement_item_main_item')->references(['id'])->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['financial_statement_able_item_id'], 'income_report_id')->references(['id'])->on('financial_statement_able_items')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['financial_statement_able_id'], 'income_statement_foreign')->references(['id'])->on('financial_statement_ables')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_statement_able_item_main_item', function (Blueprint $table) {
            $table->dropForeign('company_id_income_statement_item_main_item');
            $table->dropForeign('income_report_id');
            $table->dropForeign('income_statement_foreign');
        });
    }
}
