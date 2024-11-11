<?php

namespace App\Console\Commands;


use App\Models\Branch;
use App\Models\Company;
use App\Models\Contract;
use App\Models\CurrentAccountBankStatement;
use App\Models\FinancialInstitution;
use App\Models\LetterOfGuaranteeIssuance;
use App\Models\LetterOfGuaranteeStatement;
use App\Models\MoneyReceived;
use App\Models\Settlement;
use App\Models\TimeOfDeposit;
use Http;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use KitLoong\MigrationsGenerator\Setting;
use Schema;

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
		$code =Contract::generateRandomContract(92,'ahmed salah','2010-04-01','2011-04-01');
		
		
		// $this->refreshStatement('CurrentAccountBankStatement','full_date');
	}
	public function refreshStatement($statementModelName,$dateColumnName = 'full_date'){
		$fullModelName ='App\Models\\'.$statementModelName;
		$fullModelName::orderBy($dateColumnName)->get()->each(function($statementRaw){
			$statementRaw->update([
				'updated_at'=>now()
			]);
		});
	}
}
