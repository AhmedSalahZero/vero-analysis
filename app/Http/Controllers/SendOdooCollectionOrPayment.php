<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\MoneyReceived;
use App\Models\Settlement;
use App\Services\Api\OddoPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SendOdooCollectionOrPayment extends Controller
{
	public function handle(Request $request,  Company $company)
	{
		$oddoPaymentService = new OddoPayment($company->getOddoDBUrl(),$company->getOddoDBName(),$company->getOddoDBUserName(),$company->getOddoDBPassword(),$company->getId());
		$startDate = $request->get('start_date');
		$endDate = $request->get('end_date');
		$customerInvoiceSettlements = Settlement::whereHas('invoice',function($q){
			$q->where('oddo_id','>',0);
		})->
		whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
		->where('company_id',$company->id)->get();
		
		foreach($customerInvoiceSettlements as $customerInvoiceSettlement){
			$paymentType='customer';
			$invoice = $customerInvoiceSettlement->invoice;
			$moneyReceived = $customerInvoiceSettlement->moneyReceived;
			if($moneyReceived->isIncomingTransfer()){
				$bankOdooId = $moneyReceived->getBankAccountOdooId();
				$invoiceId = $invoice->getOdooId();
				$paymentAmount = $customerInvoiceSettlement->getAmount();
				$currencyName = $moneyReceived->getReceivingOrPaymentCurrency();
				$currencyOddoId = DB::table('currencies')->where('name',$currencyName)->first()->oddo_id;
				$paymentDate = $moneyReceived->getReceivingOrPaymentMoneyDate();
				$oddoPartnerId = $moneyReceived->partner->getOdooId();
				$invoiceNumber = $invoice->getInvoiceNumber();
				$moneyType = $moneyReceived->getType();
				$journalId = [
					MoneyReceived::CASH_IN_SAFE=>7,
				][$moneyType] ?? $bankOdooId;
				$inBoundOrOutBound ='inbound';
				$oddoPaymentService->reCreatePayment($paymentType,$invoiceId,$paymentAmount,$currencyOddoId,$paymentDate,$oddoPartnerId,$invoiceNumber,$journalId,$inBoundOrOutBound);
			}
		}
		dd('qq');
		/**
		 * @var CustomerInvoice $customerInvoice 
		 */
		// foreach($customerInvoices as $customerInvoice){
		// 	}
		return redirect()->back()->with('success',__('Send Collection Or Payment Has Been Completed'));
		
	}
}
