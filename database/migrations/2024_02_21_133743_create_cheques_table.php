<?php

use App\Models\Cheque;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheques', function (Blueprint $table) {
			$table->id();
			$table->string('cheque_number')->nullable();
			$table->string('status')->default(Cheque::IN_SAFE);
			$table->integer('money_received_id');
			$table->foreign('money_received_id')->references('id')->on('money_received')->cascadeOnDelete();
			$table->integer('drawee_bank_id')->comment('هو البنك اللي جالي منة الشيك من العميل فا مش شرط يكون من بنوكي')->nullable();
			$table->foreign('drawee_bank_id')->references('id')->on('banks')->nullOnDelete();		
			$table->integer('drawl_bank_id')->comment('هو البنك اللي انا باخد الشيك واسحبة منة وبالتالي لازم يكون من بنوكي')->nullable();
			$table->foreign('drawl_bank_id')->references('id')->on('financial_institutions')->nullOnDelete();
			$table->string('account_type')->default(null)->comment('نوع الحساب اللي هينزلك عليه فلوس الشيك بعد اما تودية البنك');
			$table->string('account_number')->default(null)->comment('رقم الحساب اللي هينزلك عليه فلوس الشيك بعد اما تودية البنك');
			$table->date('due_date')->nullable()->default(null)->comment('هو تاريخ استحقاق الشيك .. يعني اقدر اسحبة امتة');
			$table->date('deposit_date')->nullable()->default(null)->comment('هو تاريخ ايداع الشيك في البنك.. يعني ممكن يكون تاريخ الاستحقاق بكرا بس هطيته في البنك النهاردا');
			$table->date('expected_collection_date')->nullable()->default(null)->comment('هو تاريخ اللي متوقع ان البنك يحطلي فيه قيمة الشيك في حسابي');
			$table->date('actual_collection_date')->nullable()->default(null)->comment('هو تاريخ اللي البنك حطلي فيه قيمة الشيك في حسابي بشكل فعلي لاني ممكن اتوقع في يوم بس فعليا البنك حطة في يوم تاني بس وجود اجازة مثلا في اليوم اللي انا توقعته');
			$table->integer('clearance_days')->nullable()->default(0);
			$table->decimal('account_balance',14,2)->default(0)->comment('دي اجمالي اللي معايا في الحساب بعد اما الشيك مثلا انسحب ودي احنا اللي بنجسبها افتراضيا');
			$table->decimal('collection_fees',14,2)->default(0.00)->comment('الرسوم اللي البنك بياخدها منك لتحصيل الشيك');
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
        Schema::dropIfExists('cheques');
    }
}
