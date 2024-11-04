<?php

namespace App\Console\Commands;


use App\Models\Branch;
use App\Models\Company;
use App\Models\CurrentAccountBankStatement;
use App\Models\FinancialInstitution;
use App\Models\LetterOfGuaranteeIssuance;
use App\Models\LetterOfGuaranteeStatement;
use App\Models\TimeOfDeposit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


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

		// $financialInstitution = FinancialInstitution::find(17);
		// dd($financialInstitution->getOpeningBalanceForAccount(31,151515,'EGP'));
	}
}
