<?php

use App\Models\AccountType;
use App\Models\CertificatesOfDeposit;
use App\Models\FinancialInstitutionAccount;
use App\Models\TimeOfDeposit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameLgFeesAndCommissionAccountNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		foreach(['letter_of_guarantee_issuances'] as $tableName){
			Schema::table($tableName, function (Blueprint $table) use($tableName){
				if(Schema::hasColumn($tableName,'lg_fees_and_commission_account_number')){
					$table->renameColumn('lg_fees_and_commission_account_number','lg_fees_and_commission_account_id');
				}
			});	
			DB::table($tableName)->get()->each(function($letterOfIssuance) use($tableName){
				$accountType = AccountType::find($letterOfIssuance->lg_fees_and_commission_account_type);
				if(is_null($accountType)){
					return ;
				}
				if($accountType->isCertificateOfDeposit()){
					$cdOrTd = CertificatesOfDeposit::findByAccountNumber($letterOfIssuance->lg_fees_and_commission_account_id,$letterOfIssuance->company_id);
					$cdOrTdId = $cdOrTd ? $cdOrTd->id : null ;
					DB::table($tableName)->where('id',$letterOfIssuance->id)->update([
						'lg_fees_and_commission_account_id'=>$cdOrTdId  
					]);
				}
				elseif($accountType->isTimeOfDeposit()){
					$cdOrTd = TimeOfDeposit::findByAccountNumber($letterOfIssuance->lg_fees_and_commission_account_id,$letterOfIssuance->company_id);
					$cdOrTdId = $cdOrTd ? $cdOrTd->id : null ;
					DB::table($tableName)->where('id',$letterOfIssuance->id)->update([
						'lg_fees_and_commission_account_id'=>$cdOrTdId  
					]);
				}
				else{
					$cdOrTd = FinancialInstitutionAccount::findByAccountNumber($letterOfIssuance->lg_fees_and_commission_account_id,$letterOfIssuance->company_id,$letterOfIssuance->financial_institution_id);
					$cdOrTdId = $cdOrTd ? $cdOrTd->id : null ;
					DB::table($tableName)->where('id',$letterOfIssuance->id)->update([
						'lg_fees_and_commission_account_id'=>$cdOrTdId  
					]);
				}
			});
		}
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cd_or_td_id_to_x', function (Blueprint $table) {
            //
        });
    }
}
