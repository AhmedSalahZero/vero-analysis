<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnToFullySecuredTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fully_secured_overdrafts', function (Blueprint $table) {
			if(Schema::hasColumn('fully_secured_overdrafts','cd_or_td_account_number')){
				$table->renameColumn('cd_or_td_account_number','cd_or_td_account_type_id');
			}
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fully_secured', function (Blueprint $table) {
            //
        });
    }
}
