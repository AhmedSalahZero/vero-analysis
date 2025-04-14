<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\MoneyReceived;
use App\Services\Api\OddoService;
use Illuminate\Http\Request;


class ReadOdooInvoices extends Controller
{
	public function handle(Request $request,  Company $company)
	{
		$oddo = new OddoService($company->getOddoDBUrl(),$company->getOddoDBName(),$company->getOddoDBUserName(),$company->getOddoDBPassword(),$company->getId());
		$startDate = $request->get('start_date');
		$endDate = $request->get('end_date');
		$oddo->startImportInvoices($startDate,$endDate);
		return redirect()->back()->with('success',__('Invoices Reading Has Been Completed'));
		
	}
}
