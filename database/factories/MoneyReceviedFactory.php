<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\MoneyReceived;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(MoneyReceived::class, function (Faker $faker) {
    return [
        'money_type'=>'cheque',
		'customer_name'=>$faker->name , 
		'receiving_date'=>$receivingDate = $faker->dateTimeBetween('-10 years','now'),
		'cheque_amount'=>$faker->numberBetween(50000,100000),
		'drawee_bank_id'=>$faker->numberBetween(1,10) ,
		'cheque_due_date'=>Carbon::make($receivingDate)->addDays($faker->numberBetween(10,20)),
		'cheque_number'=>$faker->numberBetween(1000,1000000),
	
    ];
});
