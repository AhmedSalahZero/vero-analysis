<?php

use Illuminate\Database\Migrations\Migration;

class RefreshLetterOfGuaranteeCashCoverCal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		$rows = DB::table('letter_of_guarantee_cash_cover_statements')->orderBy('full_date','asc')->get();
		foreach($rows as $row){
			DB::table('letter_of_guarantee_cash_cover_statements')->where('id',$row->id)->update([
				'updated_at'=>now()
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
        //
    }
}
