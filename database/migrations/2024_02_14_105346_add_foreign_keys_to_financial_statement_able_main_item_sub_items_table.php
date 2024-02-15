<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFinancialStatementAbleMainItemSubItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_statement_able_main_item_sub_items', function (Blueprint $table) {
            $table->foreign(['company_id'], 'company_id_income_statement_main_item_sub_items')->references(['id'])->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_statement_able_main_item_sub_items', function (Blueprint $table) {
            $table->dropForeign('company_id_income_statement_main_item_sub_items');
        });
    }
}
