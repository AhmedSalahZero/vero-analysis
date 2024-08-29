<?php

use App\Models\MediumTermLoan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediumTermLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medium_term_loans', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('company_id');
			$table->unsignedBigInteger('financial_institution_id');
			$table->string('status')->default(MediumTermLoan::RUNNING);
			$table->string('name')->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->string('currency');
			$table->string('account_number');
			$table->decimal('borrowing_rate',14,2)->default(0);
			$table->decimal('margin_rate',14,2)->default(0);
			$table->unsignedBigInteger('duration')->comment('tenor (duration in months) ')->nullable();
			$table->string('installment_payment_interval');
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
        Schema::dropIfExists('medium_term_loans');
    }
}
