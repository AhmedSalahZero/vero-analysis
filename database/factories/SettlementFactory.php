<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Settlement;
use Faker\Generator as Faker;

$factory->define(Settlement::class, function (Faker $faker) {
    return [
        'invoice_number'=>1 ,
		'customer_name'=>'salah',
		'settlement_amount'=> 0,
		'money_received_id'=>0 ,
		'company_id'=>41
    ];
});
