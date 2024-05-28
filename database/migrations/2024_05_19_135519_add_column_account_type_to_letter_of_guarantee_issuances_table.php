<?php

use App\Models\LetterOfGuaranteeIssuance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAccountTypeToLetterOfGuaranteeIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_guarantee_issuances', function (Blueprint $table) {
			$table->string('cd_or_td_account_number')->nullable()->after('financial_institution_id');
			$table->string('cd_or_td_account_type_id')->nullable()->after('financial_institution_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_of_guarantee_issuances', function (Blueprint $table) {
            //
        });
    }
}
