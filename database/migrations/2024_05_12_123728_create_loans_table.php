<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TABLE `loans` (
			`id` int unsigned NOT NULL AUTO_INCREMENT,
			`company_id` int NOT NULL,
			`section_name` varchar(255) DEFAULT NULL,
			`is_with_capitalization` int DEFAULT 0,
			`financial_institution_id` int DEFAULT 0,
			`model_type` varchar(255) DEFAULT NULL,
			`loan_type` varchar(255) DEFAULT NULL,
			`grace_period` varchar(255) DEFAULT NULL,
			`loan_amount` varchar(255) DEFAULT NULL,
			`installment_interval` varchar(255) DEFAULT NULL,
			`start_date` varchar(255) DEFAULT NULL,
			`end_date` varchar(255) DEFAULT NULL,
			`period` varchar(255) DEFAULT NULL,
			`fixedType` varchar(255) DEFAULT NULL,
			`base_rate` varchar(255) DEFAULT NULL,
			`margin_rate` varchar(255) DEFAULT NULL,
			`pricing` varchar(255) DEFAULT NULL,
			`duration` varchar(255) DEFAULT NULL COMMENT 'tenor',
			`step_down_rate` varchar(255) DEFAULT NULL,
			`step_up_rate` varchar(255) DEFAULT NULL,
			`step_up_interval` varchar(255) DEFAULT NULL,
			`step_down_interval` varchar(255) DEFAULT NULL,
			`borrowing_rate` varchar(255) DEFAULT NULL,
			`capitalization_type` varchar(255) DEFAULT NULL,
			`margin_interest` varchar(255) DEFAULT NULL,
			`loan_interest` varchar(255) DEFAULT NULL,
			`min_interest` varchar(255) DEFAULT NULL,
			`repayment_duration` varchar(255) DEFAULT NULL,
			`installment_amount` varchar(255) DEFAULT NULL,
			`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`updated_at` datetime DEFAULT NULL,
			PRIMARY KEY (`id`)
		  ) ENGINE=InnoDB AUTO_INCREMENT=258 DEFAULT CHARSET=latin1"
	   );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
