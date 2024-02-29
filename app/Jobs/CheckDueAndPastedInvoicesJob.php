<?php

namespace App\Jobs;

use App\Models\Cheque;
use App\Models\Company;
use App\Notifications\DueInvoiceNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CheckDueAndPastedInvoicesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dateFormat = 'Y-m-d' ;
        DB::table('notifications')->delete();
        foreach (Company::get() as $company) {
            $companyId = $company->id;
            $exportables = getExportableFieldsForModel($companyId, 'CustomerInvoice') ;
            if (count($exportables)) {
                $customerInvoicePastDueDays = $company->getCustomerComingDuesInvoicesNotificationsDays()  ;
                $customerInvoiceComingDueDays = $company->getCustomerPastDuesInvoicesNotificationsDays() ;
				
				$chequesPastDueDays = $company->getChequesInSafeNotificationDays() ;
				$chequesUnderCollectionDays = $company->getChequesUnderCollectionNotificationDays() ;
				

                $dayDate = Carbon::make(now()->format($dateFormat))->format($dateFormat);
                $dayBeforeDayDate = Carbon::make(now()->format($dateFormat))->subDay()->format($dateFormat);
                $beforeIntervalDate = Carbon::make(now()->format($dateFormat))->subDays($customerInvoicePastDueDays)->format($dateFormat);
				
				/**
                 * * سيكون مستحق الدفع بعد عدة ايام
                 */
				
                $pastDueCustomerInvoices = DB::table('customer_invoices')->where('company_id', $companyId)
                ->where('net_balance', '>', 0)
                ->whereBetween('invoice_due_date', [$beforeIntervalDate, $dayBeforeDayDate])->get();

                /**
                 * * مستحق الدفع اليوم
                 */
                $currentDueCustomerInvoices = DB::table('customer_invoices')->where('company_id', $companyId)
                ->where('net_balance', '>', 0)
                ->where('invoice_due_date', $dayDate)->get();

                /**
                 * * القادم
                 */
                $dayAfterNowDate = Carbon::make(now()->format($dateFormat))->addDay()->format($dateFormat);
                $afterIntervalDate = Carbon::make(now()->format($dateFormat))->addDays($customerInvoiceComingDueDays)->format($dateFormat);
                $upcomingDueCustomerInvoices = DB::table('customer_invoices')->where('company_id', $companyId)
                ->where('net_balance', '>', 0)
                ->whereBetween('invoice_due_date', [$dayAfterNowDate, $afterIntervalDate])->get();
				
				
				
					/**
                 * * شيكات سيكون من المستحق الدفع بعد عدة ايام
                 */
				 $beforeIntervalDate = Carbon::make(now()->format($dateFormat))->subDays($chequesPastDueDays)->format($dateFormat);
				 $pastDueCheques = DB::table('cheques')->where('company_id', $companyId)
				 ->where('status',Cheque::IN_SAFE)
				 ->whereBetween('due_date', [$beforeIntervalDate, $dayBeforeDayDate])->get();
				 
				 
				 		/**
                 * * شيكات سيكون من المستحق الدفع   اليوم
                 */
				$currentDueCheques = DB::table('cheques')->where('company_id', $companyId)
				->where('status',Cheque::IN_SAFE)
				->where('due_date', $dayDate)->get();
				
				/**
				 * * الشيكات  التي ذهبت الي البنك ولكنها لاتزال تحت التحصيل ويجب ان تحصل اليوم
				 */
			
				$underCollectionChequesToday = DB::table('cheques')->where('company_id', $companyId)
				->where('status',Cheque::UNDER_COLLECTION)
				->where('expected_collection_date',$dayDate)->get();
				
				
				/**
				 * * الشيكات  التي ذهبت الي البنك ولكنها لاتزال تحت التحصيل وكان يجب ان تحصل منذ عدد من الايام ولكن لم تحصل بعد
				 */
				$afterIntervalDate = Carbon::make(now()->format($dateFormat))->addDays($chequesUnderCollectionDays)->format($dateFormat);
				$underCollectionCheques = DB::table('cheques')->where('company_id', $companyId)
				->where('status',Cheque::UNDER_COLLECTION)
				->whereBetween('expected_collection_date',[$dayAfterNowDate,$afterIntervalDate])->get();

                foreach ($pastDueCustomerInvoices as $customerInvoice) {
                    $invoiceDueDate = $customerInvoice->invoice_due_date ;
                    $invoiceNumber = $customerInvoice->invoice_number;
                    $customerName = $customerInvoice->customer_name ;
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
                    $messageEn = __('Invoice Number ') . $invoiceNumber . ' ' . __('Is Past Due Since ') . ' ' . $dueDays . ' ' . 'days For Customer ' . $customerName ;
                    $messageAr = __('Invoice Number ') . $invoiceNumber . ' ' . __('Is Past Due Since ') . ' ' . $dueDays . ' ' . 'days For Customer ' . $customerName ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, 'invoice_past_due'));
                }
                foreach ($currentDueCustomerInvoices as $customerInvoice) {
                    $invoiceDueDate = $customerInvoice->invoice_due_date ;
                    $invoiceNumber = $customerInvoice->invoice_number;
                    $customerName = $customerInvoice->customer_name ;
                    $messageEn = __('Invoice Number ') . $invoiceNumber . ' ' . __('Is Due Now For Customer') . ' ' . $customerName ;
                    $messageAr = __('Invoice Number ') . $invoiceNumber . ' ' . __('Is Due Now For Customer') . ' ' . $customerName ;
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, 'invoice_current_due'));
                }

                foreach ($upcomingDueCustomerInvoices as $customerInvoice) {
                    $invoiceDueDate = $customerInvoice->invoice_due_date ;
                    $invoiceNumber = $customerInvoice->invoice_number;
                    $customerName = $customerInvoice->customer_name ;
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
                    $messageEn = __('Invoice Number ') . $invoiceNumber . ' ' . __('Is Coming Due For ') . ' ' . $dueDays . ' ' . 'days For Customer ' . $customerName ;
                    $messageAr = __('Invoice Number ') . $invoiceNumber . ' ' . __('Is Coming Due For ') . ' ' . $dueDays . ' ' . 'days For Customer ' . $customerName ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, 'invoice_coming_due'));
                } 
				
				/**
				 * * الشيكات المتاخرة التي اوشكت علي الاستحقاق وبالتالي تذهب للبنك
				 */
				foreach ($pastDueCheques as $cheque) {
                    $chequeDueDate = $cheque->due_date ;
                    $chequeNumber = $cheque->cheque_number;
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($chequeDueDate));
                    $messageEn = __('Cheque Number ') . $chequeNumber . ' ' . __('Is Past Due Since ') . ' ' . $dueDays  ;
                    $messageAr = __('Cheque Number ') . $chequeNumber . ' ' . __('Is Past Due Since ') . ' ' . $dueDays  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, 'cheque_past_due'));
                }
				
				/**
				 * * الشيكات  التي تستحق الذهاب للبنك اليوم
				 */
				foreach ($currentDueCheques as $cheque) {
					$chequeNumber = $cheque->cheque_number;
                    $messageEn = __('Cheque Number ') . $chequeNumber . ' ' . __('Is Due Today ')  ;
                    $messageAr = __('Cheque Number ') . $chequeNumber . ' ' . __('Is Due Today ')  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, 'cheque_current_due'));
                }
				
				
				/**
				 * * الشيكات  التي ذهبت الي البنك ولكنها تستحق التحصيل من البنك اليوم
				 */
				foreach ($underCollectionChequesToday as $cheque) {
					$chequeNumber = $cheque->cheque_number;
                    $messageEn = __('Cheque Number ') . $chequeNumber . ' ' . __('Should Be Collected Today')  ;
                    $messageAr = __('Cheque Number ') . $chequeNumber . ' ' . __('Should Be Collected Today ')  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, 'cheque_under_collection_today'));
                }
				
				/**
				 * * الشيكات  التي ذهبت الي البنك ولكنها لاتزال تحت التحصيل وكان يجب ان تحصل منذ عدد من الايام ولكن لم تحصل بعد
				 */
				
				foreach ($underCollectionCheques as $cheque) {
					$chequeNumber = $cheque->cheque_number;
					$expectedCollectionDate = $cheque->expected_collection_date;
					$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($expectedCollectionDate));
                    $messageEn = __('Cheque Number ') . $chequeNumber . ' ' . __('Should Have Collected Since').' ' . $dueDays .  __('Days')  ;
                    $messageAr = __('Cheque Number ') . $chequeNumber . ' ' . __('Should Have Collected Since ').' ' . $dueDays .  __('Days')  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, 'cheque_under_collection_since_days'));
                }
				
            }
        }
    }
}
