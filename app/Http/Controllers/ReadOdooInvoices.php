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
		$startDate = $request->get('odoo_start_date');
		$endDate = $request->get('odoo_end_date');
		$oddo->startImportInvoices($startDate,$endDate,$company->id);
		return redirect()->back()->with('success',__('Invoices Reading Has Been Completed'));
		
	}
}
