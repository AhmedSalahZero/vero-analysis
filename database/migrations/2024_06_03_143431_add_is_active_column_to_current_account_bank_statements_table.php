<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveColumnToCurrentAccountBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('current_account_bank_statements', function (Blueprint $table) {
            $table->boolean('is_active')->after('id')->default(1)->comment('الكولوم دا انا ضفته علشان ال commission اللي بتنزل كل ثلاث شهور مثلا .. فا لو لسه ميعاد الكومشن ما جاش يبقي هنعتبر الرو دا اكنه مش موجود اصلا ولما يجي ميعادة هنعدل الكولوم دا وهنحط بواحد علشان يدخل معايا في الحسبة بتاعتي ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('current_account_bank_statements', function (Blueprint $table) {
            //
        });
    }
}
