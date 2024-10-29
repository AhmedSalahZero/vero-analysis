<?php

use App\Models\CurrentAccountBankStatement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInterestAmountColumnToCurrentAccountBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('current_account_bank_statements', function (Blueprint $table) {
            $table->string('type')->nullable()->after('id');
			$table->string('interest_type')->after('end_balance')->nullable();
			$table->decimal('interest_rate_annually',8,5)->after('interest_type')->default(0);
			$table->decimal('interest_rate_daily',8,5)->after('interest_rate_annually')->default(0);
			$table->integer('days_count')->after('interest_rate_daily')->default(0);
			$table->decimal('interest_amount',14,2)->after('days_count')->default(0);
        });
		
		CurrentAccountBankStatement::orderBy('full_date','asc')->get()->each(function(CurrentAccountBankStatement $currentAccountBankStatement){
			$currentAccountBankStatement->update([
				'updated_at'=>now()
			]);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('current_account_bank_statements', function (Blueprint $table) {
            //
        });
    }
}
