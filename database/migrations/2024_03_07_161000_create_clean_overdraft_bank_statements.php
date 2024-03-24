<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCleanOverdraftBankStatements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clean_overdraft_bank_statements', function (Blueprint $table) {
            $table->id();
			$table->string('type')->comment('وليكن مثلا beginning_balance,incoming_transfer,cheque_payment  , etc');
			$table->boolean('is_debit')->default(0);
			$table->boolean('is_credit')->default(1);
			$table->integer('priority')->default(3)->comment('عباره عن اولويه التسديد بمعني لما يحين وقت التسديد مين هيتسدد الاول لان الفؤائد بتسدد الاول');
			$table->unsignedInteger('clean_overdraft_id');// i will not use foreign key here
			$table->unsignedBigInteger('money_received_id');// i will not use foreign key here
			$table->unsignedBigInteger('company_id');// i will not use foreign key here
			$table->date('date');
			$table->decimal('limit',14,2)->default(0);
			$table->decimal('beginning_balance')->default(0);
			$table->decimal('debit')->default(0); 
			$table->decimal('credit')->default(0); 
			$table->decimal('end_balance')->default(0); 
			$table->decimal('room')->default(0); 
			
			// الفوائد
			$table->enum('interest_type',['normal','end_of_month'])->default('normal')->comment('الفايدة اما بتنزل بعد كل سحبة او ايداع او بتنزل بشكل اوتوماتك اخر كل شهر');
            $table->decimal('interest_rate_annually',8,5)->default(0);
            $table->decimal('interest_rate_daily',8,5)->default(0);
            $table->integer('days_count')->default(0);
            $table->decimal('interest_amount',14,2)->default(0);
			
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
        Schema::dropIfExists('clean_overdraft_bank_statements');
    }
}
