<?php

use App\Models\Branch;
use App\Models\Company;
use Illuminate\Database\Migrations\Migration;

class FixMainBranchIssue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(Company::all() as $company){
			$companyId = $company->id ;
			$bank = DB::table('branch')->where('company_id',$companyId)->orderByRaw('created_at asc')->first();
			if(!$bank){
				Branch::storeHeadOffice($companyId);
			}
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
