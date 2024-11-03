<?php
namespace App\Http\Controllers;

use App\Http\Requests\UpdateInvoiceDeductionRequest;
use App\Models\Company;
use App\Models\InvoiceDeduction;
use App\Traits\GeneralFunctions;


class InvoiceDeductionsController
{
    use GeneralFunctions;
	
	public function update(UpdateInvoiceDeductionRequest $request , Company $company ,  $InvoiceId , $invoiceModelName ){
		$totalDeductions = array_sum(array_column($request->input('deductions',[]),'amount'));

		$invoice = ('App\Models\\'.$invoiceModelName)::find($InvoiceId);
		// dd($invoice->net_balance,$invoice->deductions->sum('pivot.amount'));
		$currentBalance  =$invoice->net_balance + $invoice->deductions->sum('pivot.amount');
		// dd($currentBalance);
		$invoice->net_balance = $currentBalance - $totalDeductions;
		
		// if(true ){
		if($invoice->net_balance < 0 ){
			return response()->json([
				'status'=>true,
				'errorMessage'=>__('No Enough Balance .. Current Balance Is ' . $currentBalance)
			]);
		}
	
		$invoice->deductions()->detach();
		$invoice->update([
			'total_deductions'=>0
		]);
		foreach($request->get('deductions',[]) as $deductionArr){
			InvoiceDeduction::create(array_merge($deductionArr,['invoice_type'=>$invoiceModelName,'invoice_id'=>$invoice->id,'company_id'=>$company->id]));
		}
		$invoice->update([
			'total_deductions'=>$totalDeductions
		]);
		return response()->json([
			'reloadCurrentPage'=>true
		]);
		
	}
	
	
}
