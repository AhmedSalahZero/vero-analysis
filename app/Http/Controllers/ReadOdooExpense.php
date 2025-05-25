<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\OdooExpense;
use App\Models\Partner;
use App\Services\Api\ExpensePayment;
use Illuminate\Http\Request;


class ReadOdooExpense extends Controller
{
	public function handle(Request $request,  Company $company)
	{
		$startDate = $request->get('odoo_start_date');
		$endDate = $request->get('odoo_end_date');
		// dd($startDate,$endDate);
		$odooExpensePayment = new ExpensePayment($company->getOdooDBUrl(),$company->getOdooDBName(),$company->getOdooDBUserName(),$company->getOdooDBPassword(),$company->getId());
		
		$fields = ['id','write_date','currency_id','expense_line_ids', 'name', 'state', 'payment_state', 'employee_id', 'total_amount', 'account_move_ids', 'journal_id','payment_method_line_id', 'payment_mode'];
		
		$filters = [[['state','=','approve'],['payment_state','=','not_paid'],
			['write_date', '<=', $endDate],['write_date', '>=', $startDate]
		]];
		
		$odooExpenses =$odooExpensePayment->fetchData('hr.expense.sheet',$fields,$filters);
		
		foreach($odooExpenses as $odooExpense){
			$odooId = $odooExpense['id'];
			$odooPartnerId = $odooExpense['employee_id'][0] ;
			$odooPartnerName = $odooExpense['employee_id'][1];
			 Partner::handlePartnerForOdoo($odooPartnerId ,$odooPartnerName,false ,false,true,$company->id );
			$data = [
				'odoo_id'=>$odooId,
				'company_id'=>$company->id ,
				'name'=>$odooExpense['name'],
				'odoo_currency_id'=>$odooExpense['currency_id'][0],
				'state'=>$odooExpense['state'],
				'payment_state'=>$odooExpense['payment_state'],
				'odoo_employee_id'=>$odooPartnerId,
				'total_amount'=>$odooExpense['total_amount'],
				'account_move_ids'=>$odooExpense['account_move_ids'][0],
				'journal_id'=>$odooExpense['journal_id'][0],
				'payment_method_line_id'=>$odooExpense['payment_method_line_id'][0],
				'payment_mode'=>$odooExpense['payment_mode'][0]
			];
			$odooExpense = OdooExpense::where('company_id',$company->id)->where('odoo_id',$odooId)->first();
			if($odooExpense){
				$odooExpense->update($data);
			}else{
				OdooExpense::create($data);
			}
		}
		return redirect()->back()->with('success',__('Read Expenses Has Been Completed'));
		
	}
}
