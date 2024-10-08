<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverdraftAgainstCommercialPaperLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overdraft_against_commercial_paper_limits', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('company_id');
			$table->unsignedBigInteger('overdraft_against_commercial_paper_id');
			$table->unsignedBigInteger('cheque_id');
			$table->dateTime('full_date')->comment('هو عباره عن تاريخ ال actual_collection_date if exist , else  , due_date');
			$table->decimal('limit',14,2)->default(0);
			$table->decimal('accumulated_limit',14,2)->default(0);
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
        Schema::dropIfExists('overdraft_against_commercial_paper_limits');
    }
}
