<?php

use App\Models\LetterOfCreditIssuance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLgFeesAndCommissionAccountTypeToLetterOfGuarantee2IssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	
		foreach(DB::table('letter_of_guarantee_issuances')->get() as $letterOfGuaranteeIssuance){
			DB::table('letter_of_guarantee_issuances')->where('id',$letterOfGuaranteeIssuance->id)->update([
				'lg_fees_and_commission_account_type'=>$letterOfGuaranteeIssuance->cash_cover_deducted_from_account_type,
				'lg_fees_and_commission_account_number'=>$letterOfGuaranteeIssuance->cash_cover_deducted_from_account_number
			]);
		}
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
