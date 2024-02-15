<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesOfDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates_of_deposits', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('financial_institution_id');
            $table->string('account_number')->nullable();
            $table->decimal('amount', 12)->nullable();
            $table->string('currency')->nullable();
            $table->decimal('interest_rate', 5)->default(0);
            $table->decimal('interest_amount', 14)->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('maturity_amount_added_to_account')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('update_by')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->decimal('updated_at', 10, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificates_of_deposits');
    }
}
