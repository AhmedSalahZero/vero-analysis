<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\MoneyReceived;
use App\Services\Api\OddoPayment;
use App\Services\Api\OddoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SendOdooCollectionOrPayment extends Controller
{
	public function handle(Request $request,  Company $company)
	{
		$oddoPaymentService = new OddoPayment($company->getOddoDBUrl(),$company->getOddoDBName(),$company->getOddoDBUserName(),$company->getOddoDBPassword(),$company->getId());
		$startDate = $request->get('start_date');
		$endDate = $request->get('end_date');
		$customerInvoices = CustomerInvoice::whereIn('created_at',[$startDate,$endDate])->where('oddo_id','>',0)->where('company_id',$company->id)->get();
		
		
		/**
		 * @var CustomerInvoice $customerInvoice 
		 */
		foreach($customerInvoices as $customerInvoice){
			$paymentType='customer';
			$invoiceId = $customerInvoice->getOddoId();
			$paymentAmount = $customerInvoice->getReceivingOrPaidAmount();
			$currencyName = $customerInvoice->getReceivingOrPaymentCurrency();
			$currencyOddoId = DB::table('currencies')->where('name',$currencyName)->first()->oddo_id;
			$paymentDate = $customerInvoice->getReceivingOrPaymentMoneyDate();
			$oddoPartnerId = $customerInvoice->partner->getOdooId();
			$invoiceNumber = $customerInvoice->getInvoiceNumber();
			$moneyType = $customerInvoice->getType();
			$journalId = [
				MoneyReceived::CASH_IN_SAFE=>7,
			][$moneyType] ?? 12;
			$inBoundOrOutBound ='inbound';
			$oddoPaymentService->reCreatePayment($paymentType,$invoiceId,$paymentAmount,$currencyOddoId,$paymentDate,$oddoPartnerId,$invoiceNumber,$journalId,$inBoundOrOutBound);
		}
		return redirect()->back()->with('success',__('Send Collection Or Payment Has Been Completed'));
		
	}
}
