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
		$startDate = $request->get('odoo_start_date');
		$endDate = $request->get('odoo_end_date');
		$customerInvoiceSettlements = Settlement::whereHas('invoice',function($q){
			$q->where('oddo_id','>',0);
		})->
		whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
		->where('company_id',$company->id)->get();
		// syncFinancialInstitutions
		
		foreach($customerInvoiceSettlements as $customerInvoiceSettlement){
				$oddoPaymentService->reCreatePayment($customerInvoiceSettlement);
		}
		
		/**
		 * @var CustomerInvoice $customerInvoice 
		 */
		// foreach($customerInvoices as $customerInvoice){
		// 	}
		return redirect()->back()->with('success',__('Send Collection Or Payment Has Been Completed'));
		
	}
}
