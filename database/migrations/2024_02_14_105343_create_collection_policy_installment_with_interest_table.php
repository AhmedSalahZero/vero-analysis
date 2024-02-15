<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionPolicyInstallmentWithInterestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_policy_installment_with_interest', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('collection_policy_id');
            $table->decimal('down_payment_one', 14)->nullable();
            $table->decimal('down_payment_two', 14)->nullable();
            $table->unsignedInteger('down_payment_two_month')->nullable();
            $table->decimal('balance', 14)->nullable();
            $table->enum('installment_type', ['variable', 'fixed']);
            $table->decimal('borrowing_rate', 14)->nullable();
            $table->decimal('margin_interest', 14)->nullable();
            $table->decimal('min_interest', 14)->nullable();
            $table->integer('duration')->nullable();
            $table->integer('grace_period')->nullable();
            $table->enum('installment_interval', ['monthly', 'quartly', 'semi annually', 'annually'])->nullable();
            $table->enum('interest_interval', ['monthly', 'quartly', 'semi annually', 'annually'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_policy_installment_with_interest');
    }
}
