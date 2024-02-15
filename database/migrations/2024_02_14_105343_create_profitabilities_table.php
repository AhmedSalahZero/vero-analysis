<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profitabilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('profitabilityAble_type');
            $table->unsignedBigInteger('profitabilityAble_id');
            $table->double('percentage', 8, 2)->default(0);
            $table->double('net_profit_after_taxes', 8, 2)->default(0);
            $table->double('vat', 8, 2)->default(0);
            $table->unsignedBigInteger('company_id')->index('company_id_profitabilities');
            $table->unsignedBigInteger('creator_id')->nullable()->index('creator_id_profitabilities');
            $table->timestamps();

            $table->index(['profitabilityAble_type', 'profitabilityAble_id'], 'profitAble');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profitabilities');
    }
}
