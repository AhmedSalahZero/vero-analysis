<?php

use App\Models\FinancialInstitutionAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceDateColumnToFinancialInstitutionsAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_institution_accounts', function (Blueprint $table) {
            $table->date('balance_date')->after('financial_institution_id')->nullable();
			$table->dropForeign('financial_institution_accounts_account_type_id_foreign');
			$table->dropColumn('account_type_id');
        });

		foreach(FinancialInstitutionAccount::get() as $financialInstitutionAccount){
			$financialInstitutionAccount->update([
				'balance_date'=>$financialInstitutionAccount->financialInstitution->balance_date
			]);
		}
		
		Schema::table('financial_institutions', function (Blueprint $table) {
			$table->dropColumn('balance_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
		
		// remove colum 
    }
}
