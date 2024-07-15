<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameOverdraftAgainstAssignmentOfContractsIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lending_information_against_assignment_of_contracts',function(Blueprint $table){
			$table->renameColumn('overdraft_against_assignment_of_contracts_id','overdraft_against_assignment_of_contract_id');
		});
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
