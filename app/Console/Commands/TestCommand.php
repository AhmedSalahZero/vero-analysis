<?php

namespace App\Console\Commands;

use App\Models\CustomerInvoice;
use App\Models\TablesField;
use Illuminate\Console\Command;

class TestCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'run:test';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Test Code Command';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		TablesField::where('model_name','CustomerInvoice')->each(function(TablesField $model){
			$model->model_name = 'SupplierInvoice';
			$data = $model->toArray();
			unset($data['id']);
			TablesField::create($data);
		});
		// CashInSafeStatement::first()->update([
		// 	'credit'=>10
		// ]);
		// CashInSafeStatement::create([
		// 	'money_received_id'=>1 ,
		// 	'company_id'=>2 ,
		// 	'debit'=>50,
		// 	'date'=>now()->format('Y-m-d')
		// ]);
		
		// $openingBalance = OpeningBalance::find(18);
		// dd($openingBalance->chequeInSafe);
		// $item = CleanOverdraftBankStatement::where('id',3)->first();
		// $item->delete();
		///////////////////
		// $item = CleanOverdraftBankStatement::where('id',3)->first();
		// $item->clean_overdraft_id = 2 ;
		// $item->debit = 0 ;
		// $item->save();
		
		
dd('good');		
		
		// CleanOverdraftBankStatement::where('id','>=',2)->each(function($item){
		// 	$debit = $item->id ==3  ? 100 : $item->debit ;
		// 	$item->update([
		// 		'updated_at'=>now(),
		// 		'debit'=>$debit
		// 	]);
		// });
		// dd('good');
	}
}
