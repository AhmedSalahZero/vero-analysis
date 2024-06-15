<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOverdraftAgainstAssignmentOfContractWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overdraft_against_assignment_of_contract_withdrawals', function (Blueprint $table) {
            $table->foreign(['overdraft_against_assignment_of_contract_bank_statement_id'], 'overdraft_against_assignment_of_contracts_identifier')->references(['id'])->on('overdraft_against_assignment_of_contract_bank_statements')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('clean_overdraft_withdrawals', function (Blueprint $table) {
        //     $table->dropForeign('clean_overdrafts_identifier');
        // });
    }
}
