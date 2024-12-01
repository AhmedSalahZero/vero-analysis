<?php

namespace App\Console;

use App\Jobs\CheckDueAndPastedInvoicesJob;
use App\Jobs\ImportInvoicesJob;
use App\Models\Company;
use App\Models\CurrentAccountBankStatement;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Jobs\ImportOddoInvoicesJob;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		
		$schedule->job(new CheckDueAndPastedInvoicesJob)->name('check_due_date')->everyFiveMinutes()->withoutOverlapping();
		$schedule->job(new ImportOddoInvoicesJob)->name('import_odd_invoices')->dailyAt('00:02')->withoutOverlapping();
		foreach(Company::all() as $company){
			$firstRaw = CurrentAccountBankStatement::
			where('company_id',$company->id)
			->where('is_active',0)
			->orderByRaw('full_date asc , id asc')
			->where('full_date','<=',now())->first() ;
			if($firstRaw){
				DB::table('current_account_bank_statements')
				->where('company_id',$company->id)
				->where('is_active',0)
				->orderByRaw('full_date asc , id asc')
				->where('full_date','<=',now())
				->update([
					'is_active'=>1 
				]);
				/**
				 * * هنبدا نعمل ابديت من اول الرو اللي تاريخه اصغر حاجه في اللي كانوا محتاجين يتعدلوا
				 * * وبالتالي هيتعدل هو وكل اللي تحتة
				 */
				CurrentAccountBankStatement::updateNextRows($firstRaw);
				
			}
		}
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
