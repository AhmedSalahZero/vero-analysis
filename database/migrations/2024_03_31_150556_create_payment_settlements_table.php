<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_settlements', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('invoice_number')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('withhold_amount')->nullable();
            $table->string('settlement_amount')->nullable();
            $table->unsignedBigInteger('unapplied_amount_id')->nullable()->index('settlements_unapplied_amount_id_foreign');
            $table->foreign(['unapplied_amount_id'])->references(['id'])->on('unapplied_amounts')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->integer('money_payment_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable();
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_settlements');
    }
}
