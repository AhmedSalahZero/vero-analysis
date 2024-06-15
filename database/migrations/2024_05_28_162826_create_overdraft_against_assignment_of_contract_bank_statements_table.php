<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverdraftAgainstAssignmentOfContractBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overdraft_against_assignment_of_contract_bank_statements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->comment('وليكن مثلا beginning_balance,incoming_transfer,cheque_payment  , etc');
            $table->boolean('is_debit')->default(false);
            $table->boolean('is_credit')->default(true);
            $table->integer('priority')->default(3)->comment('عباره عن اولويه التسديد بمعني لما يحين وقت التسديد مين هيتسدد الاول لان الفؤائد بتسدد الاول');
            $table->unsignedInteger('overdraft_against_assignment_of_contract_id');
            $table->unsignedBigInteger('money_received_id');
            $table->unsignedBigInteger('money_payment_id')->nullable();
            $table->unsignedBigInteger('internal_money_transfer_id')->nullable();
			$table->unsignedBigInteger('buy_or_sell_currency_id')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->date('date');
            $table->decimal('limit', 14)->default(0);
            $table->decimal('beginning_balance', 14)->default(0);
            $table->decimal('debit', 14)->default(0);
            $table->decimal('credit', 14)->default(0);
            $table->decimal('end_balance', 14)->default(0);
            $table->decimal('room', 14)->default(0);
            $table->enum('interest_type', ['normal', 'end_of_month'])->default('normal')->comment('الفايدة اما بتنزل بعد كل سحبة او ايداع او بتنزل بشكل اوتوماتك اخر كل شهر');
            $table->decimal('interest_rate_annually', 8, 5)->default(0);
            $table->decimal('interest_rate_daily', 8, 5)->default(0);
            $table->integer('days_count')->default(0);
            $table->decimal('interest_amount', 14)->default(0);
            $table->timestamps();
            $table->dateTime('full_date')->nullable()->comment('دا هنستخدمة علشان نرتب بيه ونجيب ال الرو السابق بناء علي التاريخ و الوقت');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overdraft_against_assignment_of_contract_bank_statements');
    }
}
