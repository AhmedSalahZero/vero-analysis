<?php

namespace App\Jobs;

use App\Models\Cheque;
use App\Models\Company;
use App\Models\PayableCheque;
use App\Notification;
use App\Notifications\DueInvoiceNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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
			/**
			 * @var Company $company 
			 */
            $companyId = $company->id;
            $customerInvoiceExportables = getExportableFieldsForModel($companyId, 'CustomerInvoice') ;
            $supplierInvoiceExportables = getExportableFieldsForModel($companyId, 'SupplierInvoice') ;
            if (count($customerInvoiceExportables)) {
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
                    $messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Past Due Since ',[],'en') . ' ' . $dueDays . ' ' . __('days For Customer',[],'en') . ' ' . $customerName ;
                    $messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Past Due Since ',[],'ar') . ' ' . $dueDays . ' ' . __('days For Customer',[],'ar') . ' ' . $customerName ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CUSTOMER_INVOICE_PAST_DUE,'customer',
					[
						'Invoice Number'=>$invoiceNumber ,
						'Past Due Since (Days)'=>$dueDays ,
						'Customer Name'=>$customerName
					]
				));
                }
                foreach ($currentDueCustomerInvoices as $customerInvoice) {
                    $invoiceDueDate = $customerInvoice->invoice_due_date ;
                    $invoiceNumber = $customerInvoice->invoice_number;
                    $customerName = $customerInvoice->customer_name ;
                    $messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Due Now For Customer',[],'en') . ' ' . $customerName ;
                    $messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Due Now For Customer',[],'ar') . ' ' . $customerName ;
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CUSTOMER_INVOICE_CURRENT_DUE,'customer',[
						'Invoice Number'=>$invoiceNumber ,
						'Customer Name'=>$customerName
					]));
                }

                foreach ($upcomingDueCustomerInvoices as $customerInvoice) {
                    $invoiceDueDate = $customerInvoice->invoice_due_date ;
                    $invoiceNumber = $customerInvoice->invoice_number;
                    $customerName = $customerInvoice->customer_name ;
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
                    $messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Coming Due For ',[],'en') . ' ' . $dueDays . ' ' . __('days For Customer',[],'en').' ' . $customerName ;
                    $messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Coming Due For ',[],'ar') . ' ' . $dueDays . ' ' . __('days For Customer',[],'ar').' ' . $customerName ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CUSTOMER_INVOICE_COMING_DUE,'customer',
					[
						'Invoice Number'=>$invoiceNumber ,
						'Coming Due For (Days)'=>$dueDays ,
						'Customer Name'=>$customerName
					]
				));
                } 
				
				/**
				 * * الشيكات المتاخرة التي اوشكت علي الاستحقاق وبالتالي تذهب للبنك
				 */
				foreach ($pastDueCheques as $cheque) {
                    $chequeDueDate = $cheque->due_date ;
                    $chequeNumber = $cheque->cheque_number;
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($chequeDueDate));
                    $messageEn = __('Cheque Number ',[],'en') . $chequeNumber . ' ' . __('Is Past Due Since ',[],'en') . ' ' . $dueDays  ;
                    $messageAr = __('Cheque Number ',[],'ar') . $chequeNumber . ' ' . __('Is Past Due Since ',[],'ar') . ' ' . $dueDays  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CHEQUE_PAST_DUE,'receivable_cheque',
					[
						'Cheque Number'=>$chequeNumber ,
						'Past Due Since (Days)'=>$dueDays 
					]
					
				));
                }
				
				/**
				 * * الشيكات  التي تستحق الذهاب للبنك اليوم
				 */
				foreach ($currentDueCheques as $cheque) {
					$chequeNumber = $cheque->cheque_number;
                    $messageEn = __('Cheque Number ',[],'en') . $chequeNumber . ' ' . __('Is Due Today',[],'en')  ;
                    $messageAr = __('Cheque Number ',[],'ar') . $chequeNumber . ' ' . __('Is Due Today',[],'ar')  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CHEQUE_CURRENT_DUE,'receivable_cheque',
					[
						'Cheque Number'=>$chequeNumber ,
						
					]
					
				));
                }
				
				
				/**
				 * * الشيكات  التي ذهبت الي البنك ولكنها تستحق التحصيل من البنك اليوم
				 */
				foreach ($underCollectionChequesToday as $cheque) {
					$chequeNumber = $cheque->cheque_number;
                    $messageEn = __('Cheque Number ',[],'en') . $chequeNumber . ' ' . __('Should Be Collected Today',[],'en')  ;
                    $messageAr = __('Cheque Number ',[],'ar') . $chequeNumber . ' ' . __('Should Be Collected Today',[],'ar')  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CHEQUE_UNDER_COLLECTION_TODAY,'receivable_cheque',
					[
						'Cheque Number'=>$chequeNumber ,
						
					]
				));
                }
				
				/**
				 * * الشيكات  التي ذهبت الي البنك ولكنها لاتزال تحت التحصيل وكان يجب ان تحصل منذ عدد من الايام ولكن لم تحصل بعد
				 */
				
				foreach ($underCollectionCheques as $cheque) {
					$chequeNumber = $cheque->cheque_number;
					$expectedCollectionDate = $cheque->expected_collection_date;
					$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($expectedCollectionDate));
                    $messageEn = __('Cheque Number ',[],'en') . $chequeNumber . ' ' . __('Should Have Collected Since',[],'en').' ' . $dueDays .  __('Days',[],'en')  ;
                    $messageAr = __('Cheque Number ',[],'ar') . $chequeNumber . ' ' . __('Should Have Collected Since ',[],'ar').' ' . $dueDays .  __('Days',[],'ar')  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CHEQUE_UNDER_COLLECTION_SINCE_DAYS,'receivable_cheque',
				[
					'Cheque Number'=>$chequeNumber ,
					'Should Have Collected Since (Days)'=>$dueDays
				]));
                }
				
            }
			
			
			
			if (count($supplierInvoiceExportables)) {
				
				
				
			
                $supplierInvoicePastDueDays = $company->getSupplierComingDuesInvoicesNotificationsDays()  ;
                $supplierInvoiceComingDueDays = $company->getSupplierPastDuesInvoicesNotificationsDays() ;
				
				$pendingPayableChequeNotificationDays = $company->getPendingPayableChequeNotificationDays() ;
				

                $dayDate = Carbon::make(now()->format($dateFormat))->format($dateFormat);
                $dayBeforeDayDate = Carbon::make(now()->format($dateFormat))->subDay()->format($dateFormat);
                $beforeIntervalDate = Carbon::make(now()->format($dateFormat))->subDays($supplierInvoicePastDueDays)->format($dateFormat);
				
				/**
                 * * سيكون مستحق الدفع بعد عدة ايام
                 */
				
                $pastDueSupplierInvoices = DB::table('supplier_invoices')->where('company_id', $companyId)
                ->where('net_balance', '>', 0)
                ->whereBetween('invoice_due_date', [$beforeIntervalDate, $dayBeforeDayDate])->get();

                /**
                 * * مستحق الدفع اليوم
                 */
                $currentDueSupplierInvoices = DB::table('supplier_invoices')->where('company_id', $companyId)
                ->where('net_balance', '>', 0)
                ->where('invoice_due_date', $dayDate)->get();

                /**
                 * * القادم
                 */
                $dayAfterNowDate = Carbon::make(now()->format($dateFormat))->addDay()->format($dateFormat);
                $afterIntervalDate = Carbon::make(now()->format($dateFormat))->addDays($supplierInvoiceComingDueDays)->format($dateFormat);
                $upcomingDueSupplierInvoices = DB::table('supplier_invoices')->where('company_id', $companyId)
                ->where('net_balance', '>', 0)
                ->whereBetween('invoice_due_date', [$dayAfterNowDate, $afterIntervalDate])->get();
				
				
				
				/**
                 * * شيكات سيكون من المستحق الدفع بعد عدة ايام
                 */
				 $beforeIntervalDate = Carbon::make(now()->format($dateFormat))->subDays($pendingPayableChequeNotificationDays)->format($dateFormat);
				 $pendingPayableCheques = PayableCheque::where('company_id', $companyId)
				 ->where('status',PayableCheque::PENDING)
				 ->whereBetween('due_date', [$beforeIntervalDate, $dayBeforeDayDate])->get();
				 
				
				
					
			foreach ($pastDueSupplierInvoices as $supplierInvoice) {
				$invoiceDueDate = $supplierInvoice->invoice_due_date ;
				$invoiceNumber = $supplierInvoice->invoice_number;
				$supplierName = $supplierInvoice->supplier_name ;
				$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
				$messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Past Due Since ',[],'en') . ' ' . $dueDays . ' ' . __('days For Supplier',[],'en') . ' ' . $supplierName ;
				$messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Past Due Since ',[],'ar') . ' ' . $dueDays . ' ' . __('days For Supplier',[],'ar').' ' . $supplierName ;
				$company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::SUPPLIER_INVOICE_PAST_DUE,'supplier',
				[
					'Invoice Number'=>$invoiceNumber ,
					'Past Due Since (Days)'=>$dueDays
				]
			));
			}
			foreach ($currentDueSupplierInvoices as $supplierInvoice) {
				$invoiceDueDate = $supplierInvoice->invoice_due_date ;
				$invoiceNumber = $supplierInvoice->invoice_number;
				$supplierName = $supplierInvoice->supplier_name ;
				$messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Due Now For Supplier',[],'en') . ' ' . $supplierName ;
				$messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Due Now For Supplier',[],'ar') . ' ' . $supplierName ;
				$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
				$company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::SUPPLIER_INVOICE_CURRENT_DUE,'supplier',
				[
					'Invoice Number'=>$invoiceNumber ,
					'Supplier Name'=>$supplierName ,
					
				]
			));
			}

			foreach ($upcomingDueSupplierInvoices as $supplierInvoice) {
				$invoiceDueDate = $supplierInvoice->invoice_due_date ;
				$invoiceNumber = $supplierInvoice->invoice_number;
				$supplierName = $supplierInvoice->supplier_name ;
				$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
				$messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Coming Due For ',[],'en') . ' ' . $dueDays . ' ' . __('days For Supplier ',[],'en') . $supplierName ;
				$messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Coming Due For ',[],'ar') . ' ' . $dueDays . ' ' . __('days For Supplier ',[],'ar') . $supplierName ;
				$company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::SUPPLIER_INVOICE_COMING_DUE,'supplier',
				[
					'Invoice Number'=>$invoiceNumber ,
					'Coming Due For (Days)'=>$dueDays ,
					'Supplier Name'=>$supplierName
					
				]
			));
			} 
			
			foreach ($pendingPayableCheques as $pendingPayableCheque) {
				$invoiceDueDate = $pendingPayableCheque->due_date ;
				$invoiceNumber = $pendingPayableCheque->cheque_number;
				$bankName = $pendingPayableCheque->getDeliveryBankName();
				$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
				$messageEn = __('Cheque Number ',[],'en') . $invoiceNumber . ' ' . __('Is Coming Due For ',[],'en') . ' ' . $dueDays . ' ' . __('days For Bank',[],'en') . $bankName ;
				$messageAr = __('Cheque Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Coming Due For ',[],'ar') . ' ' . $dueDays . ' ' . __('days For Bank',[],'ar') . $bankName ;
				$company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::PENDING_PAYABLE_CHEQUES,'pending_payable_cheque',
				[
					'Cheque Number'=>$invoiceNumber ,
					'Coming Due For (Days)'=>$dueDays ,
					'Bank Name'=>$bankName
					
				]
			));
			} 
			
			

              
			
				
				
				
            }
			
			
        }
    }
}
