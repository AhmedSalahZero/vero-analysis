<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSalesTrendColumnToTableFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tables_fields', function (Blueprint $table) {
            $table->boolean('is_sales_trend')->default(0)->after('view_name');
        });
		// foreach(['zone','sales_channel','category','product_or_service','product_item','branch','business_sector','sales_person','country','business_unit','document_type','sales_person',''] as $tableName){
			
		// }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
