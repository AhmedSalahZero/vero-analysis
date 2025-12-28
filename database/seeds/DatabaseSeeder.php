<?php


use App\Models\NonBankingService\Expense;
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
		$companyId = 31 ;
		$studyId = 86 ;
		$expense = Expense::first();
		$clonedExpense = $expense->replicate()->toArray();
		
		for($i = 0 ; $i<=200;$i++){
			Expense::create();
		}
		// $this->call(TestSeeder::class);
		// $this->call(AccountTypeSeeder::class);
		// for($i = 0 ; $i<=159591;$i++){
		// 	DB::table('money2')->insert([
		// 		'cash'=>250000,
		// 		'cheque'=>250000,
		// 		'transfer'=>250000,
		// 		'deposit'=>250000,
		// 	]);
		// }
    }
}
