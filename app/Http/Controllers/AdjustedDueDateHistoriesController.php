<?php
namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\DueDateHistory;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;

class AdjustedDueDateHistoriesController
{
    use GeneralFunctions;
	public function index(Company $company,Request $request,CustomerInvoice $customerInvoice)
	{
		$dueDateHistories = $customerInvoice->dueDateHistories;
		
        return view('admin.adjusted-due-date-histories', [
			'company'=>$company,
			'customerInvoice'=>$customerInvoice,
			'dueDateHistories'=>$dueDateHistories
		]);
    }
	public function store(Request $request, Company $company,CustomerInvoice $customerInvoice){
		$date = $request->get('due_date') ;
		$date = explode('/',$date);
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$dueDate = $year.'-'.$month.'-'.$day ;
		if(!$customerInvoice->dueDateHistories->count()){
			/**
			 * * في حالة اول مرة هنضيف تاريخ تحصيل الفاتورة الاصلي اكنة تاريخ علشان نحتفظ بيه علشان ما يضيعش
			 */
			DueDateHistory::create([
				'company_id'=>$company->id ,
				'amount'=>$customerInvoice->getNetBalance(),
				'due_date'=>$customerInvoice->getInvoiceDueDate(),
				'customer_invoice_id'=>$customerInvoice->id
			]);
		}
		DueDateHistory::create([
			'company_id'=>$company->id ,
			'amount'=>$customerInvoice->getNetBalance(),
			'due_date'=>$dueDate,
			'customer_invoice_id'=>$customerInvoice->id
		]);
		
		$customerInvoice->update([
			'invoice_due_date'=>$dueDate
		]);
		
		return redirect()->route('adjust.due.dates',['company'=>$company->id,'customerInvoice'=>$customerInvoice->id]);
	}
	public function edit(Request $request , Company $company , CustomerInvoice $customerInvoice , DueDateHistory $dueDateHistory){
		$dueDateHistories = $customerInvoice->dueDateHistories;
		
        return view('admin.adjusted-due-date-histories', [
			'company'=>$company,
			'customerInvoice'=>$customerInvoice,
			'dueDateHistories'=>$dueDateHistories,
			'model'=>$dueDateHistory
		]);
	}
	public function update(Request $request , Company $company , CustomerInvoice $customerInvoice , DueDateHistory $dueDateHistory){
		$date = $request->get('due_date') ;
		$date = explode('/',$date);
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		
		$dueDate = $year.'-'.$month.'-'.$day ;
		
		$dueDateHistory->update([
			'due_date'=>$dueDate 
		]);
		$customerInvoice->update([
			'invoice_due_date'=>$dueDate
		]);
		
		return redirect()->route('adjust.due.dates',['company'=>$company->id,'customerInvoice'=>$customerInvoice->id]);
		
	}
	public function destroy(Request $request , Company $company , CustomerInvoice $customerInvoice , DueDateHistory $dueDateHistory)
	{
		$dueDateHistory->delete();
		$lastHistory = $customerInvoice->dueDateHistories->last();
		
		$customerInvoice->update([
			'invoice_due_date'=>$lastHistory->due_date 
			]) ; 
			/**
			 * * لو معدش فاضل غيرها دا معناه انه حذف تاني عنصر وبالتالي العنصر الاول اللي معتش فاضل غيره هو الديو ديت الاصلي ففي الحاله
			 * * دي هنحذفه معتش ليه لزمة
			 */
			if($customerInvoice->dueDateHistories->count() == 1){
				$lastHistory->delete();
			}
			return redirect()->route('adjust.due.dates',['company'=>$company->id,'customerInvoice'=>$customerInvoice->id]);
	}
	
}
