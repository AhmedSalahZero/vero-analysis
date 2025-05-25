<?php
namespace App\Http\Controllers;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\CashExpenseCategoryName;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Models\LoanSchedule;
use App\Models\LoanScheduleSettlement;
use App\Models\OdooExpense;
use App\Services\Api\ExpensePayment;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OdooExpensesController
{
    use GeneralFunctions;
    protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName =  'created_at' ; // change it 
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($model) use ($value,$searchFieldName){
				$currentValue = $model->{$searchFieldName} ;
				// if($searchFieldName == 'bank_id'){
				// 	$currentValue = $model->getBankName() ;  
				// }
				return false !== stristr($currentValue , $value);
			});
		})
		->when($request->get('from') , function($collection) use($dateFieldName,$from){
			return $collection->where($dateFieldName,'>=',$from);
		})
		->when($request->get('to') , function($collection) use($dateFieldName,$to){
			return $collection->where($dateFieldName,'<=',$to);
		})
		->sortByDesc('id')->values();
		return $collection;
	}
	public function index(Company $company,Request $request)
	{
		
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$currentType = $request->get('active',OdooExpense::APPROVED);
		
		$filterDates = [];
		foreach(OdooExpense::getAllTypes() as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		
		
		 
		  /**
		 * * start of bank to safe internal money transfer 
		 */
		
		$runningStartDate = $filterDates[OdooExpense::APPROVED]['startDate'] ?? null ;
		$runningEndDate = $filterDates[OdooExpense::APPROVED]['endDate'] ?? null ;
		$rows = $company->odooApprovedExpenses ;
		$rows =  $rows->filterByCreatedAt($runningStartDate,$runningEndDate) ;
		$rows =  $currentType == OdooExpense::APPROVED ? $this->applyFilter($request,$rows):$rows ;

		/**
		 * * end of bank to safe internal money transfer 
		 */
		 
		
		 $searchFields = [
			OdooExpense::APPROVED=>[
				'name'=>__('Name'),
				'created_at'=>__('Created Date'),
				// 'end_Date'=>__('End Date'),
			],
		];
	
		$models = [
			OdooExpense::APPROVED =>$rows ,
		];

        return view('odoo-expenses.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'models'=>$models,
			'filterDates'=>$filterDates
		]);
    }
	public function markAsPaid(Request $request,Company $company){
		$id = $request->get('id');
		$paymentDate = Carbon::make($request->get('payment_date'))->format('Y-m-d');
		$odooExpense = OdooExpense::find($id);
		/**
		 * @var OdooExpense $odooExpense
		 */
		$journalId = $odooExpense->getJournalId();
		 $paymentMethodId = $odooExpense->getPaymentMethodId();
		 $odooExpenseSheetId =$odooExpense->getOdooId(); 
        $expensePaymentService = new ExpensePayment($company->getOdooDBUrl(),$company->getOdooDBName(),$company->getOdooDBUserName(),$company->getOdooDBPassword(),$company->getId());
		$settlementResult = $expensePaymentService->settleApprovedExpenses($journalId,$paymentMethodId,$paymentDate,$odooExpenseSheetId);
		$code = $settlementResult['account_result']['account_code'];
		$expenseCategorySub = CashExpenseCategoryName::findByOdooChatOfAccountNumber($company->id ,$code );
		// $expenseCategoryParentId = $expenseCategorySub->cashExpenseCategory->id;
		$expenseCategorySubId = $expenseCategorySub->id ;
		$odooExpense->generateCashExpenseData($paymentDate,$expenseCategorySubId);
		$odooExpense->update([
			'state'=>'paid'
		]);
		
	}
	// public function create(Company $company)
	// {
    //     return view('odoo-expenses.form',$this->getCommonViewVars($company));
    // }
	// public function getCommonViewVars(Company $company,$model = null)
	// {
	// 	return [
	// 		'model'=>$model,
	// 		'company'=>$company
	// 	];
	// }
	
	// public function store(Company $company   , Request $request , FinancialInstitution $financialInstitution){
	// 	$type = OdooExpense::APPROVED;
	// 	$mediumTermLoan = new MediumTermLoan ;
	// 	$mediumTermLoan->status = OdooExpense::APPROVED;
	// 	$mediumTermLoan->storeBasicForm($request);
	// 	$activeTab = $type ; 
	// 	return redirect()->route('odoo-expenses.index',['company'=>$company->id,'active'=>$activeTab,'financialInstitution'=>$financialInstitution->id])->with('success',__('Data Store Successfully'));
		
	// }

	// public function edit(Company $company,OdooExpense $odooExpense)
	// {

    //     return view('odoo-expenses.form' ,$this->getCommonViewVars($company,$financialInstitution,$mediumTermLoan));
    // }
	
	// public function update(Company $company, Request $request , FinancialInstitution $financialInstitution , MediumTermLoan $mediumTermLoan){
		
	// 	$mediumTermLoan->deleteRelations();
	// 	$mediumTermLoan->delete();
	// 	$type = OdooExpense::APPROVED;
	// 	$this->store($company,$request,$financialInstitution);
	// 	$activeTab = $type ;
	// 	return redirect()->route('odoo-expenses.index',['company'=>$company->id,'active'=>$activeTab,'financialInstitution'=>$financialInstitution->id])->with('success',__('Item Has Been Updated Successfully'));
	// }
	
	public function destroy(Company $company , OdooExpense $odooExpense)
	{
		dd('delete it ');
		// $odooExpense->deleteRelations();
		$odooExpense->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}
	

}
