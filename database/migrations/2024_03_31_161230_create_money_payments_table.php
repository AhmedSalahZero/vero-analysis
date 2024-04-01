<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_payments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->enum('money_type', ['money-payment', 'down-payment'])->default('money-payment');
            $table->unsignedBigInteger('contract_id')->nullable()->index('money_payment_contract_id_foreign');
            $table->unsignedBigInteger('opening_balance_id')->nullable()->index('money_payment_opening_balance_id_foreign');
            $table->string('type')->nullable();
            $table->string('supplier_name')->nullable();
            $table->date('delivery_date')->nullable();
            $table->decimal('paid_amount', 14)->nullable();
            $table->double('total_withhold_amount')->default(0);
            $table->double('total_withhold_amount_in_main_currency')->nullable()->default(0);
            $table->double('received_amount_in_main_currency')->nullable()->default(0);
            $table->string('currency')->nullable();
            $table->double('exchange_rate')->nullable()->default(1);
            $table->integer('user_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->dateTime('created_at')->useCurrent();
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
        Schema::dropIfExists('money_payments');
    }
}
