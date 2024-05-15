<?php

use App\Models\CertificatesOfDeposit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCertificatesOfDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificates_of_deposits', function (Blueprint $table) {
			$table->string('status')->after('id')->default(CertificatesOfDeposit::RUNNING);
            $table->decimal('actual_interest_amount',14,2)->after('interest_amount')->nullable();
			$table->date('deposit_date')->after('actual_interest_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificates_of_deposits', function (Blueprint $table) {
            //
        });
    }
}
