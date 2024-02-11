<?php

use App\Models\CustomerInvoice;
use App\Models\MoneyReceived;
use App\Models\Settlement;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		$faker = Container::getInstance()->make(Generator::class);
		$factory = factory(CustomerInvoice::class , 2000)->create()->each(function($customerInvoice) use($faker){
			factory(MoneyReceived::class,1)->create([
				'customer_name'=>$customerInvoice->getCustomerName(),
				'received_amount'=>$customerInvoice->getNetInvoiceAmount()  ,
			])
			->each(function($moneyReceived) use ($customerInvoice){
				factory(Settlement::class , 1)->create([
					'invoice_number'=>$customerInvoice->getInvoiceNumber(),
					'customer_name'=>$customerInvoice->getCustomerName(),
					'settlement_amount'=>$moneyReceived->getReceivedAmount(),
					'money_received_id'=>$moneyReceived->id 
				]);
			});
		});
    }
}
