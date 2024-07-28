<?php

namespace App\Jobs;

use App\Models\Bank;
use App\Models\Cheque;
use App\Models\Company;
use App\Models\FinancialInstitution;
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
				 $pastDueCheques = DB::table('cheques')->where('cheques.company_id', $companyId)
				 ->where('cheques.status',Cheque::IN_SAFE)
				 ->whereBetween('cheques.due_date', [$beforeIntervalDate, $dayBeforeDayDate])
				 ->join('money_received','money_received_id','=','cheques.money_received_id')
				 ->get();
				 
				 
				 		/**
                 * * شيكات سيكون من المستحق الدفع   اليوم
                 */
				$currentDueCheques = DB::table('cheques')->where('cheques.company_id', $companyId)
				->where('cheques.status',Cheque::IN_SAFE)
				->where('cheques.due_date', $dayDate)
				->join('money_received','money_received_id','=','cheques.money_received_id')
				->get();
				
				/**
				 * * الشيكات  التي ذهبت الي البنك ولكنها لاتزال تحت التحصيل ويجب ان تحصل اليوم
				 */
			
				$underCollectionChequesToday = DB::table('cheques')->where('cheques.company_id', $companyId)
				->where('cheques.status',Cheque::UNDER_COLLECTION)
				->where('cheques.expected_collection_date',$dayDate)
				->join('money_received','money_received_id','=','cheques.money_received_id')
				->get();
				
				
				/**
				 * * الشيكات  التي ذهبت الي البنك ولكنها لاتزال تحت التحصيل وكان يجب ان تحصل منذ عدد من الايام ولكن لم تحصل بعد
				 */
				$afterIntervalDate = Carbon::make(now()->format($dateFormat))->addDays($chequesUnderCollectionDays)->format($dateFormat);
				$underCollectionCheques = DB::table('cheques')->where('cheques.company_id', $companyId)
				->where('cheques.status',Cheque::UNDER_COLLECTION)
				->join('money_received','money_received_id','=','cheques.money_received_id')
				->whereBetween('cheques.expected_collection_date',[$dayAfterNowDate,$afterIntervalDate])->get();

                foreach ($pastDueCustomerInvoices as $customerInvoice) {
                    $invoiceDueDate = $customerInvoice->invoice_due_date ;
                    $invoiceNumber = $customerInvoice->invoice_number;
                    $customerName = $customerInvoice->customer_name ;
					$invoiceDate = $customerInvoice->invoice_date ; 
					$currency = $customerInvoice->currency ;
					$invoiceAmount = $customerInvoice->invoice_amount ; 
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
                    $messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Past Due Since ',[],'en') . ' ' . $dueDays . ' ' . __('days For Customer',[],'en') . ' ' . $customerName ;
                    $messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Past Due Since ',[],'ar') . ' ' . $dueDays . ' ' . __('days For Customer',[],'ar') . ' ' . $customerName ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CUSTOMER_INVOICE_PAST_DUE,'customer',
					[
						'Customer Name'=>$customerName,
						'Invoice Number'=>$invoiceNumber ,
						'Invoice Date' => $invoiceDate ,
						'Currency'=>$currency , 
						'Invoice Amount' => $invoiceAmount ,
						'Due Date'=>$invoiceDueDate ,
						'Past Due Since (Days)'=>$dueDays ,
					]
				));
                }
                foreach ($currentDueCustomerInvoices as $customerInvoice) {
                    $invoiceDueDate = $customerInvoice->invoice_due_date ;
                    $invoiceNumber = $customerInvoice->invoice_number;
                    $customerName = $customerInvoice->customer_name ;
					$invoiceDate = $customerInvoice->invoice_date ; 
					$currency = $customerInvoice->currency ;
					$invoiceAmount = $customerInvoice->invoice_amount ; 
                    $messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Due Now For Customer',[],'en') . ' ' . $customerName ;
                    $messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Due Now For Customer',[],'ar') . ' ' . $customerName ;
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CUSTOMER_INVOICE_CURRENT_DUE,'customer',[
						'Customer Name'=>$customerName,
						'Invoice Number'=>$invoiceNumber ,
						'Invoice Date' => $invoiceDate ,
						'Currency'=>$currency , 
						'Invoice Amount' => $invoiceAmount ,
						'Due Date'=>$invoiceDueDate ,
					]));
                }

                foreach ($upcomingDueCustomerInvoices as $customerInvoice) {
                    $invoiceDueDate = $customerInvoice->invoice_due_date ;
                    $invoiceNumber = $customerInvoice->invoice_number;
                    $customerName = $customerInvoice->customer_name ;
					$invoiceDate = $customerInvoice->invoice_date ; 
					$currency = $customerInvoice->currency ;
					$invoiceAmount = $customerInvoice->invoice_amount ; 
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
                    $messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Due After ',[],'en') . ' ' . $dueDays . ' ' . __('days For Customer',[],'en').' ' . $customerName ;
                    $messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Due After ',[],'ar') . ' ' . $dueDays . ' ' . __('days For Customer',[],'ar').' ' . $customerName ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CUSTOMER_INVOICE_COMING_DUE,'customer',
					[
						'Customer Name'=>$customerName,
						'Invoice Number'=>$invoiceNumber ,
						'Invoice Date' => $invoiceDate ,
						'Currency'=>$currency , 
						'Invoice Amount' => $invoiceAmount ,
						'Due Date'=>$invoiceDueDate ,
						'Due After (Days)'=>$dueDays ,
					]
				));
                } 
				
				/**
				 * * الشيكات المتاخرة التي اوشكت علي الاستحقاق وبالتالي تذهب للبنك
				 */
				foreach ($pastDueCheques as $cheque) {
                    $chequeDueDate = $cheque->due_date ;
                    $chequeNumber = $cheque->cheque_number;
					$customerName = $cheque->customer_name ;
					$chequeAmount = $cheque->received_amount ;
					$draweeBank = Bank::find($cheque->drawee_bank_id);
					$chequeDate = $cheque->due_date ;
					$draweeBankName =  $draweeBank ? $draweeBank->getName() : __('N/A');
                    $dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($chequeDueDate));
                    $messageEn = __('Cheque Number ',[],'en') . $chequeNumber . ' ' . __('Is Past Due Since ',[],'en') . ' ' . $dueDays  ;
                    $messageAr = __('Cheque Number ',[],'ar') . $chequeNumber . ' ' . __('Is Past Due Since ',[],'ar') . ' ' . $dueDays  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CHEQUE_PAST_DUE,'receivable_cheque',
					[
						'Customer Name'=>$customerName ,
						'Cheque Number'=>$chequeNumber ,
						'Cheque Amount'=>$chequeAmount,
						'Drawee Bank'=>$draweeBankName,
						'Cheque Date'=>$chequeDate ,
						'Past Due Since (Days)'=>$dueDays 
					]
					
				));
                }
				
				/**
				 * * الشيكات  التي تستحق الذهاب للبنك اليوم
				 */
				foreach ($currentDueCheques as $cheque) {
					$chequeNumber = $cheque->cheque_number;
					$chequeDueDate = $cheque->due_date ;
                    $chequeNumber = $cheque->cheque_number;
					$customerName = $cheque->customer_name ;
					$chequeAmount = $cheque->received_amount ;
					$draweeBank = Bank::find($cheque->drawee_bank_id);
					$chequeDate = $cheque->due_date ;
					$draweeBankName =  $draweeBank ? $draweeBank->getName() : __('N/A');
					
                    $messageEn = __('Cheque Number ',[],'en') . $chequeNumber . ' ' . __('Is Due Today',[],'en')  ;
                    $messageAr = __('Cheque Number ',[],'ar') . $chequeNumber . ' ' . __('Is Due Today',[],'ar')  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CHEQUE_CURRENT_DUE,'receivable_cheque',
					[
						'Customer Name'=>$customerName ,
						'Cheque Number'=>$chequeNumber ,
						'Cheque Amount'=>$chequeAmount,
						'Drawee Bank'=>$draweeBankName,
						'Cheque Date'=>$chequeDate ,
						
					]
					
				));
                }
				
				
				/**
				 * * الشيكات  التي ذهبت الي البنك ولكنها تستحق التحصيل من البنك اليوم
				 */
				foreach ($underCollectionChequesToday as $cheque) {
					$chequeNumber = $cheque->cheque_number;
					$chequeDueDate = $cheque->due_date ;
					$customerName = $cheque->customer_name ;
					$chequeAmount = $cheque->received_amount ;
					$drawalBank = FinancialInstitution::find($cheque->drawl_bank_id);
					$drawalBankName =  $drawalBank ? $drawalBank->getName() : __('N/A');
					
                    $messageEn = __('Cheque Number ',[],'en') . $chequeNumber . ' ' . __('Should Be Collected Today',[],'en')  ;
                    $messageAr = __('Cheque Number ',[],'ar') . $chequeNumber . ' ' . __('Should Be Collected Today',[],'ar')  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CHEQUE_UNDER_COLLECTION_TODAY,'receivable_cheque',
					[
						'Customer Name'=>$customerName ,
						'Cheque Number'=>$chequeNumber ,
						'Cheque Amount'=>$chequeAmount,
						'Drawal Bank'=>$drawalBankName,
						'Cheque Date'=>$chequeDueDate ,
					]
				));
                }
				
				/**
				 * * الشيكات  التي ذهبت الي البنك ولكنها لاتزال تحت التحصيل وكان يجب ان تحصل منذ عدد من الايام ولكن لم تحصل بعد
				 */
				
				foreach ($underCollectionCheques as $cheque) {
					$chequeNumber = $cheque->cheque_number;
					$expectedCollectionDate = $cheque->expected_collection_date;
					
					$chequeDueDate = $cheque->due_date ;
					$customerName = $cheque->customer_name ;
					$chequeAmount = $cheque->received_amount ;
					$drawalBank = FinancialInstitution::find($cheque->drawl_bank_id);
					$drawalBankName =  $drawalBank ? $drawalBank->getName() : __('N/A');
					
					$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($expectedCollectionDate));
                    $messageEn = __('Cheque Number ',[],'en') . $chequeNumber . ' ' . __('Should Have Collected Since',[],'en').' ' . $dueDays .  __('Days',[],'en')  ;
                    $messageAr = __('Cheque Number ',[],'ar') . $chequeNumber . ' ' . __('Should Have Collected Since ',[],'ar').' ' . $dueDays .  __('Days',[],'ar')  ;
                    $company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::CHEQUE_UNDER_COLLECTION_SINCE_DAYS,'receivable_cheque',
				[
						'Customer Name'=>$customerName ,
						'Cheque Number'=>$chequeNumber ,
						'Cheque Amount'=>$chequeAmount,
						'Drawal Bank'=>$drawalBankName,
						'Cheque Date'=>$chequeDate ,
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
				 $pendingPayableCheques = PayableCheque::where('payable_cheques.company_id', $companyId)
				 ->where('payable_cheques.status',PayableCheque::PENDING)
				 ->whereBetween('payable_cheques.due_date', [$beforeIntervalDate, $dayBeforeDayDate])
				 ->join('money_payments','money_payments.id','=','money_payment_id')
				 ->get();
				 
				
				
					
			foreach ($pastDueSupplierInvoices as $supplierInvoice) {
				$invoiceDueDate = $supplierInvoice->invoice_due_date ;
				$invoiceNumber = $supplierInvoice->invoice_number;
				$supplierName = $supplierInvoice->supplier_name ;
				$invoiceDate = $supplierInvoice->invoice_date ; 
				$currency = $supplierInvoice->currency ;
				$invoiceAmount = $supplierInvoice->invoice_amount ; 
					
				$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
				$messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Past Due Since ',[],'en') . ' ' . $dueDays . ' ' . __('days For Supplier',[],'en') . ' ' . $supplierName ;
				$messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Past Due Since ',[],'ar') . ' ' . $dueDays . ' ' . __('days For Supplier',[],'ar').' ' . $supplierName ;
				$company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::SUPPLIER_INVOICE_PAST_DUE,'supplier',
				[
						'Supplier Name'=>$supplierName,
						'Invoice Number'=>$invoiceNumber ,
						'Invoice Date' => $invoiceDate ,
						'Currency'=>$currency , 
						'Invoice Amount' => $invoiceAmount ,
						'Due Date'=>$invoiceDueDate ,
						'Past Due Since (Days)'=>$dueDays ,
			
				]
			));
			}
			foreach ($currentDueSupplierInvoices as $supplierInvoice) {
				$invoiceDueDate = $supplierInvoice->invoice_due_date ;
				$invoiceNumber = $supplierInvoice->invoice_number;
				$supplierName = $supplierInvoice->supplier_name ;
				$invoiceDate = $supplierInvoice->invoice_date ; 
				$currency = $supplierInvoice->currency ;
				$invoiceAmount = $supplierInvoice->invoice_amount ; 
				$messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Due Now For Supplier',[],'en') . ' ' . $supplierName ;
				$messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Due Now For Supplier',[],'ar') . ' ' . $supplierName ;
				$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
				$company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::SUPPLIER_INVOICE_CURRENT_DUE,'supplier',
				[
						'Supplier Name'=>$supplierName,
						'Invoice Number'=>$invoiceNumber ,
						'Invoice Date' => $invoiceDate ,
						'Currency'=>$currency , 
						'Invoice Amount' => $invoiceAmount ,
						'Due Date'=>$invoiceDueDate 
					
				]
			));
			}

			foreach ($upcomingDueSupplierInvoices as $supplierInvoice) {
				$invoiceDueDate = $supplierInvoice->invoice_due_date ;
				$invoiceNumber = $supplierInvoice->invoice_number;
				$supplierName = $supplierInvoice->supplier_name ;
				$invoiceDate = $supplierInvoice->invoice_date ; 
				$currency = $supplierInvoice->currency ;
				$invoiceAmount = $supplierInvoice->invoice_amount ; 
				$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
				$messageEn = __('Invoice Number ',[],'en') . $invoiceNumber . ' ' . __('Is Due After ',[],'en') . ' ' . $dueDays . ' ' . __('days For Supplier ',[],'en') . $supplierName ;
				$messageAr = __('Invoice Number ',[],'ar') . $invoiceNumber . ' ' . __('Is Due After ',[],'ar') . ' ' . $dueDays . ' ' . __('days For Supplier ',[],'ar') . $supplierName ;
				$company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::SUPPLIER_INVOICE_COMING_DUE,'supplier',
				[
					'Supplier Name'=>$supplierName,
					'Invoice Number'=>$invoiceNumber ,
					'Invoice Date' => $invoiceDate ,
					'Currency'=>$currency , 
					'Invoice Amount' => $invoiceAmount ,
					'Due Date'=>$invoiceDueDate ,
					'Due After (Days)'=>$dueDays 
					
				]
			));
			} 
			
			foreach ($pendingPayableCheques as $pendingPayableCheque) {
				$invoiceDueDate = $pendingPayableCheque->due_date ;
				$chequeNumber = $pendingPayableCheque->cheque_number;
				$chequeAmount = $pendingPayableCheque->paid_amount ;
				$supplierName = $pendingPayableCheque->supplier_name ;
				$bankName = $pendingPayableCheque->getDeliveryBankName();
				$dueDays = Carbon::make(now()->format($dateFormat))->diffInDays(Carbon::make($invoiceDueDate));
				$messageEn = __('Cheque Number ',[],'en') . $chequeNumber . ' ' . __('Is Due After ',[],'en') . ' ' . $dueDays . ' ' . __('days For Bank',[],'en') . $bankName ;
				$messageAr = __('Cheque Number ',[],'ar') . $chequeNumber . ' ' . __('Is Due After ',[],'ar') . ' ' . $dueDays . ' ' . __('days For Bank',[],'ar') . $bankName ;
				$company->notify(new DueInvoiceNotification($messageEn, $messageAr, Notification::PENDING_PAYABLE_CHEQUES,'pending_payable_cheque',
				[
					'Supplier Name'=>$supplierName,
					'Cheque Amount'=>$chequeAmount,
					'Cheque Number'=>$chequeNumber ,
					'Due After (Days)'=>$dueDays ,
					'Payment Bank'=>$bankName
					
				]
			));
			} 
			
			

              
			
				
				
				
            }
			
			
        }
    }
}
