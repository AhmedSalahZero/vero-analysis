<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
			$table->integer('customer_coming_dues_invoices_notifications_days')->default(3);
			$table->integer('customer_past_dues_invoices_notifications_days')->default(1);
			$table->integer('cheques_in_safe_notifications_days')->default(3);
			$table->integer('cheques_under_collection_notifications_days')->default(0);
			
			$table->integer('supplier_coming_dues_invoices_notifications_days')->default(3);
			$table->integer('supplier_past_dues_invoices_notifications_days')->default(1);
			$table->integer('company_id');
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
        Schema::dropIfExists('notification_settings');
    }
}
