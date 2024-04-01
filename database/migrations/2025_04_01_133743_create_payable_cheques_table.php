<?php

use App\Models\Cheque;
use App\Models\PayableCheque;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayableChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payable_cheques', function (Blueprint $table) {
			$table->id();
			$table->string('cheque_number')->nullable();
			$table->string('status')->default(PayableCheque::PENDING);
			$table->integer('money_payment_id');
			$table->foreign('money_payment_id')->references('id')->on('money_payments')->cascadeOnDelete();
			$table->integer('delivery_bank_id')->comment('هو البنك اللي انا طلعت منة الشيك للمورد وبالتالي لازم يكون من بنوكي')->nullable();
			$table->foreign('delivery_bank_id')->references('id')->on('financial_institutions')->nullOnDelete();
			$table->string('account_type')->default(null)->comment('نوع الحساب اللي هسحب منة الشيك علشان ادية للمورد');
			$table->string('account_number')->default(null)->comment('رقم الحساب اللي هسحب منة الشيك علشان ادية للمورد');
			$table->date('due_date')->nullable()->default(null)->comment('هو تاريخ استحقاق الشيك .. يعني اقدر اسحبة امتة');
			$table->date('delivery_date')->nullable()->default(null)->comment('هو تاريخ الي اديت فيه الشيك للمورد');
			$table->date('actual_payment_date')->nullable()->default(null)->comment('هو تاريخ التسليم الفعلي لان لازم ياكد');
			$table->decimal('account_balance',14,2)->default(0)->comment('دي اجمالي اللي معايا في الحساب بعد اما الشيك مثلا انسحب ودي احنا اللي بنجسبها افتراضيا');
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
        Schema::dropIfExists('payable_cheques');
    }
}
