<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('labeling_report_title')->nullable();
            $table->string('labeling_stamp', 300)->nullable();
            $table->string('labeling_logo_3', 300)->nullable();
            $table->string('labeling_logo_2', 300)->nullable();
            $table->string('labeling_logo_1', 300)->nullable();
            $table->json('labeling_print_headers')->nullable();
            $table->string('no_rows_for_each_page_labeling')->nullable();
            $table->string('print_labeling_type')->nullable();
            $table->json('generate_labeling_code_fields')->nullable();
            $table->integer('labeling_use_client_logo')->nullable()->default(0);
            $table->string('labeling_client_logo')->nullable();
            $table->string('labeling_pagination_per_page')->nullable()->default('20');
            $table->string('labeling_type')->nullable();
            $table->string('qrcode_height')->nullable();
            $table->string('qrcode_width')->nullable();
            $table->string('label_height')->nullable();
            $table->string('label_width')->nullable();
            $table->string('logo_width')->nullable();
            $table->string('labeling_paper_size')->nullable();
            $table->json('name');
            $table->string('sub_of')->default('0');
            $table->boolean('is_caching_now')->default(false);
            $table->string('main_functional_currency')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
