<?php

use App\Models\OutgoingTransfer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActualPaymentDateToOutgoingTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outgoing_transfers', function (Blueprint $table) {
			$table->date('actual_payment_date')->nullable()->default(null)->comment('هو تاريخ التحويل الفعلي لان لازم ياكد');
			$table->string('status')->default(OutgoingTransfer::PENDING);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outgoing_transfers', function (Blueprint $table) {
            //
        });
    }
}
