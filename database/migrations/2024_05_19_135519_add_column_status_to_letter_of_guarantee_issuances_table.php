<?php

use App\Models\LetterOfGuaranteeIssuance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusToLetterOfGuaranteeIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_of_guarantee_issuances', function (Blueprint $table) {
			$table->string('status')->after('id')->default(LetterOfGuaranteeIssuance::RUNNING);
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
