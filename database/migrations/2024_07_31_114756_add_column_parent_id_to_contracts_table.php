<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnParentIdToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->after('id')->comment('عباره عن انه مربوط بيه')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
			
        });
    }
}
