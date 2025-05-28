<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\Api\OdooService;
use Illuminate\Http\Request;


class ReadOdooInvoices extends Controller
{
	public function handle(Request $request,  Company $company)
	{
		$odoo = new OdooService($company);
		$startDate = $request->get('odoo_start_date');
		$endDate = $request->get('odoo_end_date');
		$odoo->startImportInvoices($startDate,$endDate,$company->id);
		return redirect()->back()->with('success',__('Invoices Reading Has Been Completed'));
		
	}
}
