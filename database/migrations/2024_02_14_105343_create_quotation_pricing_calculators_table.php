<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationPricingCalculatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_pricing_calculators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('business_sector_id')->nullable();
            $table->string('name')->nullable();
            $table->string('date');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->double('price_sensitivity')->default(0);
            $table->boolean('use_freelancer')->default(true);
            $table->string('total_recommend_price_without_vat')->default('0');
            $table->string('total_recommend_price_with_vat')->default('0');
            $table->string('price_per_day_without_vat')->default('0');
            $table->string('price_per_day_with_vat')->default('0');
            $table->string('total_net_profit_after_taxes')->default('0');
            $table->string('net_profit_after_taxes_per_day')->default('0');
            $table->string('total_sensitive_price_without_vat')->default('0');
            $table->string('total_sensitive_price_with_vat')->default('0');
            $table->string('sensitive_price_per_day_without_vat')->default('0');
            $table->string('sensitive_price_per_day_with_vat')->default('0');
            $table->string('sensitive_total_net_profit_after_taxes')->default('0');
            $table->string('sensitive_net_profit_after_taxes_per_day')->default('0');
            $table->string('sensitive_net_profit_after_taxes_percentage')->default('0');
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
        Schema::dropIfExists('quotation_pricing_calculators');
    }
}
