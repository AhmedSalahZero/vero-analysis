<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreelancerExpenseQuickPricingCalculatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancer_expense_quick_pricing_calculator', function (Blueprint $table) {
            $table->string('freelancerExpenseAble_type');
            $table->unsignedBigInteger('freelancerExpenseAble_id');
            $table->unsignedBigInteger('freelancer_expense_id')->index('freelancer_p_id');
            $table->unsignedBigInteger('position_id')->index('pos_freelancer_id');
            $table->double('percentage_of_price', 8, 2)->default(0);
            $table->double('working_days')->default(0);
            $table->double('cost_per_day')->default(0);
            $table->double('total_cost')->default(0);
            $table->unsignedBigInteger('company_id')->index('company_id_freelancer_expense_quick_pricing_calculator');
            $table->unsignedBigInteger('creator_id')->nullable()->index('creator_id_freelancer_expense_quick_pricing_calculator');
            $table->timestamps();

            $table->index(['freelancerExpenseAble_type', 'freelancerExpenseAble_id'], 'freelancerMorph');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freelancer_expense_quick_pricing_calculator');
    }
}
