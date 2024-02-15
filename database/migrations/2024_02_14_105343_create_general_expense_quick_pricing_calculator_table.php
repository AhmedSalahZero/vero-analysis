<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralExpenseQuickPricingCalculatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_expense_quick_pricing_calculator', function (Blueprint $table) {
            $table->string('generalExpenseAble_type');
            $table->unsignedBigInteger('generalExpenseAble_id');
            $table->unsignedBigInteger('general_expense_id')->index('gndm_p_id');
            $table->double('percentage_of_price', 8, 2)->default(0);
            $table->string('name')->nullable();
            $table->double('cost_per_unit')->default(0);
            $table->double('unit_cost')->default(0);
            $table->double('total_cost');
            $table->unsignedBigInteger('company_id')->index('company_id_general_expense_quick_pricing_calculator');
            $table->unsignedBigInteger('creator_id')->nullable()->index('creator_id_general_expense_quick_pricing_calculator');
            $table->timestamps();

            $table->index(['generalExpenseAble_type', 'generalExpenseAble_id'], 'generalMorph');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_expense_quick_pricing_calculator');
    }
}
