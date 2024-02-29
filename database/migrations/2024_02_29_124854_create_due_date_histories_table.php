<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDueDateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('due_date_histories', function (Blueprint $table) {
            $table->id();
			$table->integer('customer_invoice_id');
			$table->foreign('customer_invoice_id')->references('id')->on('customer_invoices')->cascadeOnDelete();
            $table->string('due_date')->comment('التاريخ اللي تم تاجيل الدفع ليه');
            $table->decimal('amount',14,2)->comment('هي عباره عن القيمة المتبقه من الفاتورة خلال تاريخ هذا التاجيل بمعني انك لما اجلت الفاتورة كان متبقي عليك الف جنية مثلا تاني مره اجلتها كان باقي عليك500 مثلا');
			$table->integer('company_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('due_date_histories');
    }
}
