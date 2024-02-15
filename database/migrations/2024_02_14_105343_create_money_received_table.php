<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_received', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('money_type')->nullable();
            $table->string('customer_name')->nullable();
            $table->date('receiving_date')->nullable();
            $table->integer('receiving_branch_id')->nullable();
            $table->string('received_amount')->nullable();
            $table->double('total_withhold_amount')->default(0);
            $table->double('total_withhold_amount_in_main_currency')->nullable()->default(0);
            $table->double('received_amount_in_main_currency')->nullable()->default(0);
            $table->string('currency')->nullable();
            $table->string('receipt_number')->nullable();
            $table->integer('receipt_bank_id')->nullable();
            $table->integer('drawee_bank_id');
            $table->string('receiving_bank_id')->nullable();
            $table->date('cheque_due_date')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('main_account_number')->nullable();
            $table->string('sub_account_number')->nullable();
            $table->string('cheque_deposit_date')->nullable();
            $table->string('cheque_drawl_bank_id')->nullable();
            $table->string('cheque_main_account_number')->nullable();
            $table->string('cheque_sub_account_number')->nullable();
            $table->string('cheque_account_balance')->nullable();
            $table->date('cheque_expected_collection_date')->nullable();
            $table->string('cheque_clearance_days')->nullable();
            $table->double('exchange_rate')->nullable()->default(1);
            $table->string('cheque_status')->nullable()->default('in safe');
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
        Schema::dropIfExists('money_received');
    }
}
