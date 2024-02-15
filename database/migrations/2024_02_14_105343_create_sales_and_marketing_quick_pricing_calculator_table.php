<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesAndMarketingQuickPricingCalculatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_and_marketing_quick_pricing_calculator', function (Blueprint $table) {
            $table->string('salesAndMarketingExpenseAble_type');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('salesAndMarketingExpenseAble_id');
            $table->unsignedBigInteger('sales_and_marketing_expense_id');
            $table->double('percentage_of_price', 8, 2)->default(0);
            $table->double('cost_per_unit')->default(0);
            $table->double('unit_cost')->default(0);
            $table->double('total_cost');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('creator_id')->nullable();
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
        Schema::dropIfExists('sales_and_marketing_quick_pricing_calculator');
    }
}
