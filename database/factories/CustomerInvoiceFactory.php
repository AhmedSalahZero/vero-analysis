<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CustomerInvoice;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(CustomerInvoice::class, function (Faker $faker) {
    return [
        'company_id'=>41,
		'customer_code'=>$faker->numberBetween(1,10000),
		'sales_person'=>null ,
		'business_unit'=>'terra',
		'customer_name'=>'customer_name_'.$faker->numberBetween(1,1000),
		'invoice_date'=>$invoiceDate = $faker->dateTimeBetween('-10 years','now'),
		'invoice_number'=>$faker->numberBetween(1,400000),
		'invoice_amount'=>$invoiceAmount = $faker->numberBetween(250000,1400000),
		'vat_amount'=>$vatAmount = (0.1 * $invoiceAmount),
		'withhold_amount'=>$withholdAmount=(0.03 * $invoiceAmount),
		'net_invoice_amount'=>$netInvoiceAmount = $invoiceAmount + $vatAmount-$withholdAmount,
		'collected_amount'=>$collectedAmount = 0,
		// 'collected_amount'=>$collectedAmount = $faker->numberBetween(50,100) / 100 * $netInvoiceAmount,
		'net_balance'=>$netInvoiceAmount - $collectedAmount,
		'invoice_due_date'=>Carbon::make($invoiceDate)->addDays($faker->numberBetween(30,45))->format('Y-m-d')
    ];
});
