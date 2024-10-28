<?php

use Illuminate\Database\Migrations\Migration;

class RefreshPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('refresh:permissions');
    }

    public function down()
    {
      
    }
}
