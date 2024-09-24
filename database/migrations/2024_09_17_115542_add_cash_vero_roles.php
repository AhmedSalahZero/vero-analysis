<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashVeroRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	
		DB::table('roles')->insert([
			// [
			// 	'name'=>'system admin',
			// 	'scope'=>'cash',
			// 	'guard_name'=>'cash'
			// ],
			[
				'name'=>'manager',
				'scope'=>'admin',
					'guard_name'=>'web'
			],
			// [
			// 	'name'=>'cash-vero-user',
			// 	'scope'=>'cash',
			// 	'guard_name'=>'cash'
			// ]
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
