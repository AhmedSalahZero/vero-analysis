<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_statements', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->boolean('is_active')->default(true)->comment('الكولوم دا انا ضفته علشان ال commission اللي بتنزل كل ثلاث شهور مثلا .. فا لو لسه ميعاد الكومشن ما جاش يبقي هنعتبر الرو دا اكنه مش موجود اصلا ولما يجي ميعادة هنعدل الكولوم دا وهنحط بواحد علشان يدخل معايا في الحسبة بتاعتي ');
            $table->integer('financial_institution_account_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('loan_schedule_settlement_id')->nullable();
            $table->boolean('is_debit')->default(false);
            $table->boolean('is_credit')->default(true);
            $table->date('date')->nullable();
            $table->dateTime('full_date')->nullable();
            $table->decimal('beginning_balance', 14)->default(0);
            $table->decimal('debit', 14)->default(0);
            $table->decimal('credit', 14)->default(0);
            $table->decimal('end_balance', 14)->default(0);
            $table->timestamps();
            $table->string('comment_en')->nullable();
            $table->string('comment_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_statements');
    }
}
