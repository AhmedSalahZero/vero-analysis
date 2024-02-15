<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProfitabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profitabilities', function (Blueprint $table) {
            $table->foreign(['company_id'], 'company_id_profitabilities')->references(['id'])->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['creator_id'], 'creator_id_profitabilities')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profitabilities', function (Blueprint $table) {
            $table->dropForeign('company_id_profitabilities');
            $table->dropForeign('creator_id_profitabilities');
        });
    }
}
