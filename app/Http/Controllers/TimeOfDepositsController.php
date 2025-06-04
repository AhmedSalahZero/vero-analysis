<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreTimeOfDepositRequest;
use App\Http\Requests\UpdateTimeOfDepositRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CurrentAccountBankStatement;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Models\TimeOfDeposit;
use App\Services\Api\OdooService;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TimeOfDepositsController
{
    use GeneralFunctions;
    protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName =  'start_date' ; // change it 
		if($request->get('field') == 'end_date'){
			$dateFieldName = 'end_date';
		}
		
		
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($moneyReceived) use ($value,$searchFieldName){
				$currentValue = $moneyReceived->{$searchFieldName} ;
				if($searchFieldName == 'bank_id'){
					$currentValue = $moneyReceived->getBankName() ;  
				}
				return false !== stristr($currentValue , $value);
			});
		})
		->when($request->get('from') , function($collection) use($dateFieldName,$from){
			return $collection->where($dateFieldName,'>=',$from);
		})
		->when($request->get('to') , function($collection) use($dateFieldName,$to){
			return $collection->where($dateFieldName,'<=',$to);
		})
		->sortByDesc('id');
		
		return $collection->values();
	}
	public function index(Company $company,Request $request,FinancialInstitution $financialInstitution)
	{
		/**
		 * @var Collection $runningTimeOfDeposits 
		 */
		
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$currentType = $request->get('active',TimeOfDeposit::RUNNING);
		$filterDates = [];
		foreach(TimeOfDeposit::getAllTypes() as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		/**
		 * * start of running time deposits 
		 */
		$runningTimeOfDepositsStartDate = $filterDates[TimeOfDeposit::RUNNING]['startDate'] ?? null ;
		$runningTimeOfDepositsEndDate = $filterDates[TimeOfDeposit::RUNNING]['endDate'] ?? null ;
		$runningTimeOfDeposits = $financialInstitution->runningTimeOfDeposits ;
		$runningTimeOfDeposits =  $runningTimeOfDeposits->filterByStartDate($runningTimeOfDepositsStartDate,$runningTimeOfDepositsEndDate) ;
		$runningTimeOfDeposits =  $currentType == TimeOfDeposit::RUNNING ? $this->applyFilter($request,$runningTimeOfDeposits):$runningTimeOfDeposits ;
		/**
		 * * end of running time deposits 
		 */
		
		 
		 
		 /**
		 * * start of matured time deposits 
		 */
		$maturedTimeOfDepositsStartDate = $filterDates[TimeOfDeposit::MATURED]['startDate'] ?? null ;
		$maturedTimeOfDepositsEndDate = $filterDates[TimeOfDeposit::MATURED]['endDate'] ?? null ;
		$maturedTimeOfDeposits = $financialInstitution->maturedTimeOfDeposits ;
		$maturedTimeOfDeposits =  $maturedTimeOfDeposits->filterByStartDate($maturedTimeOfDepositsStartDate,$maturedTimeOfDepositsEndDate) ;
		$maturedTimeOfDeposits =  $currentType == TimeOfDeposit::MATURED ? $this->applyFilter($request,$maturedTimeOfDeposits):$maturedTimeOfDeposits ;
		/**
		 * * end of matured time deposits 
		 */
		
		 
		 
		 	 /**
		 * * start of broken time deposits 
		 */
		$brokenTimeOfDepositsStartDate = $filterDates[TimeOfDeposit::BROKEN]['startDate'] ?? null ;
		$brokenTimeOfDepositsEndDate = $filterDates[TimeOfDeposit::BROKEN]['endDate'] ?? null ;
		$brokenTimeOfDeposits = $financialInstitution->brokenTimeOfDeposits ;
		$brokenTimeOfDeposits =  $brokenTimeOfDeposits->filterByStartDate($brokenTimeOfDepositsStartDate,$brokenTimeOfDepositsEndDate) ;
		$brokenTimeOfDeposits =  $currentType == TimeOfDeposit::BROKEN ? $this->applyFilter($request,$brokenTimeOfDeposits):$brokenTimeOfDeposits ;
		/**
		 * * end of broken time deposits 
		 */
		
		 
		
		$searchFields = [
			TimeOfDeposit::RUNNING=>[
				'start_date'=>__('Start Date'),
				'end_date'=>__('End Date'),
				'account_number'=>__('Account Number'),
				'currency'=>__('Currency'),
			],
			TimeOfDeposit::MATURED=>[
				'start_date'=>__('Start Date'),
				'end_date'=>__('End Date'),
				'account_number'=>__('Account Number'),
				'currency'=>__('Currency'),
			],
			TimeOfDeposit::BROKEN=>[
				'start_date'=>__('Start Date'),
				'end_date'=>__('End Date'),
				'account_number'=>__('Account Number'),
				'currency'=>__('Currency'),
			]
		];
		
		 
		$models = [
			TimeOfDeposit::RUNNING =>$runningTimeOfDeposits ,
			TimeOfDeposit::MATURED =>$maturedTimeOfDeposits ,
			TimeOfDeposit::BROKEN =>$brokenTimeOfDeposits ,
		];
		
        return view('reports.time-of-deposit.index', [
			'company'=>$company,
			'filterDates'=>$filterDates,
			'financialInstitution'=>$financialInstitution,
			'searchFields'=>$searchFields,
			'models'=>$models
		]);
    }
	
	public function create(Company $company,FinancialInstitution $financialInstitution)
	{
		$banks = Bank::pluck('view_name','id');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$accountTypes = AccountType::onlyCurrentAccount()->get();
		
		/**
		 * * عباره عن حساب جاري فقط
		 */
		$accounts = $financialInstitution->accounts ;
        return view('reports.time-of-deposit.form',[
			'banks'=>$banks,
			'selectedBranches'=>$selectedBranches,
			'financialInstitution'=>$financialInstitution,
			'accounts'=>$accounts,
			'accountTypes'=>$accountTypes
		]);
    }
	public function getCommonDataArr():array 
	{
		return ['start_date','account_number','amount','end_date','currency','interest_rate','interest_amount','maturity_amount_added_to_account_id','odoo_code'];
	}
	public function store(Company $company  ,FinancialInstitution $financialInstitution, StoreTimeOfDepositRequest $request){
		
		$data = $request->only( $this->getCommonDataArr());
		foreach(['start_date','end_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		$odooCode = $request->get('odoo_code') ;
		$deductedFromAccountId = $request->get('deducted_from_account_id',0) ;
		if($company->hasOdooIntegrationCredentials() && $odooCode ){
			$odooService = new OdooService($company);
			$data['odoo_id'] = $odooService->chartOfAccount($odooCode)['id'] ;
		}
		
		$data['created_by'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		$data['interest_amount'] = number_unformat($request->get('interest_amount')) ;
		$timeOfDeposit=$financialInstitution->timeOfDeposits()->create($data);
		/**
		 * @var TimeOfDeposit $timeOfDeposit
		 */

		$timeOfDeposit->handleDeductedForBankStatement($financialInstitution->id,$data['start_date'],number_unformat($request->get('amount')),$company->id,$deductedFromAccountId,$request->get('account_number'));
		
		
		$type = $request->get('type',TimeOfDeposit::RUNNING);
		$activeTab = $type ; 
		
		return redirect()->route('view.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}
	
	public function edit(Company $company , Request $request , FinancialInstitution $financialInstitution , TimeOfDeposit $timeOfDeposit){
		$accounts = $financialInstitution->accounts ;
		$accountTypes = AccountType::onlyCurrentAccount()->get();
        return view('reports.time-of-deposit.form',[
			'financialInstitution'=>$financialInstitution,
			'model'=>$timeOfDeposit,
			'accounts'=>$accounts,
			'accountTypes'=>$accountTypes
		]);
		
	}
	
	public function update(Company $company , UpdateTimeOfDepositRequest $request , FinancialInstitution $financialInstitution,TimeOfDeposit $timeOfDeposit){
		
		$data['updated_by'] = auth()->user()->id ;
		$data = $request->only($this->getCommonDataArr());
		foreach(['start_date','end_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		$data['interest_amount'] = number_unformat($request->get('interest_amount')) ;
		if($company->hasOdooIntegrationCredentials()){
			$odooService = new OdooService($company);
			$data['odoo_id'] = $odooService->chartOfAccount($request->get('odoo_code'))['id'] ;
		}
		
		$timeOfDeposit->update($data);
		$deductedFromAccountId = $request->get('deducted_from_account_id',0) ;
		$timeOfDeposit->handleDeductedForBankStatement($financialInstitution->id,$data['start_date'],number_unformat($request->get('amount')),$company->id,$deductedFromAccountId,$request->get('account_number'));

		$type = $request->get('type',TimeOfDeposit::RUNNING);
		$activeTab = $type ;
		return redirect()->route('view.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));
	}
	public function destroy(Company $company , FinancialInstitution $financialInstitution , TimeOFDeposit $timeOfDeposit)
	{
		CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($timeOfDeposit->currentAccountBankStatements);
		$timeOfDeposit->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}
	
	/**
	 * * هنا اليوزر هياكد انه نزله الفايدة المستحقة وبالتالي هنزلها في حسابه الجاري اللي هو اختارة من الفورمة
	 */
	public function applyDeposit(Company $company,Request $request,FinancialInstitution $financialInstitution,TimeOfDeposit $timeOfDeposit)
	{
		$actualDepositDate = Carbon::make($request->get('deposit_date'))->format('Y-m-d') ;
		$actualInterestAmount  = $request->get('actual_interest_amount') ;
		$type = TimeOfDeposit::MATURED ;
		$timeOfDeposit->update([
			'deposit_date'=>$actualDepositDate,
			'actual_interest_amount'=>$actualInterestAmount,
			'status'=>$type
		]);
		
		$accountType = AccountType::where('slug',AccountType::CURRENT_ACCOUNT)->first() ;
		if($actualInterestAmount > 0){
			$timeOfDeposit->handleDebitStatement($financialInstitution->id , $accountType , $timeOfDeposit->getMaturityAmountAddedToAccountNumber() , null , $actualDepositDate,$actualInterestAmount);
		}
		$timeOfDeposit->handleDebitStatement($financialInstitution->id , $accountType , $timeOfDeposit->getMaturityAmountAddedToAccountNumber() , null , $actualDepositDate,$timeOfDeposit->getAmount());
		return redirect()->route('view.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id ,'active'=>$type])->with('success',__('Time Of Deposit Has Been Marked As Matured'));
	}
	
	
	
		/**
	 * * هنا اليوزر هيعكس عملية التاكيد اللي كان اكدها اكنه عملها بالغلط فا هنرجع كل حاجه زي ما كانت ونحذف القيم اللي في جدول ال 
	 * * current account bank statements
	 */
	public function reverseDeposit(Company $company,Request $request,FinancialInstitution $financialInstitution,TimeOfDeposit $timeOfDeposit)
	{
		// $actualDepositDate = Carbon::make($request->get('actual_deposit_date'))->format('Y-m-d') ;
		// $actualInterestAmount  = $request->get('actual_interest_amount') ;
		$type = TimeOfDeposit::RUNNING ;
		$timeOfDeposit->update([
			'deposit_date'=>null,
			'actual_interest_amount'=>null,
			'status'=>TimeOfDeposit::RUNNING
		]);
		/**
		 * * هنشيل قيم ال
		 * * current account bank statement
		 */
		CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($timeOfDeposit->currentAccountBankStatements->where('type','!=',CurrentAccountBankStatement::DEDUCTED_FOR_CURRENT_ACCOUNT));
		return redirect()->route('view.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id ,'active'=>$type])->with('success',__('Time Of Deposit Has Been Marked As Matured'));
	}
	
	
	/**
	 * * لو انت عملت شهادة ايداع في البنك تقدر تكسرها وتاخد قيمة الشهادة بتاعتك بس بيطبق عليك غرامة
	 */
	public function applyBreak(Company $company,Request $request,FinancialInstitution $financialInstitution,TimeOfDeposit $timeOfDeposit)
	{
		$breakDate = Carbon::make($request->get('break_date'))->format('Y-m-d') ;
		$breakInterestAmount  = $request->get('break_interest_amount') ;
		$breakChargeAmount  = $request->get('break_charge_amount') ;
		$amount  = $request->get('amount') ;
		$type = TimeOfDeposit::BROKEN ;
		$timeOfDeposit->update([
			'break_date'=>$breakDate,
			'break_interest_amount'=>$breakInterestAmount,
			'status'=>$type,
			'break_charge_amount'=>$breakChargeAmount
		]);
		
		
		$accountType = AccountType::where('slug',AccountType::CURRENT_ACCOUNT)->first() ;
		/**
		 * * اول حاجه هنضيف دبت بقيمة الشهادة 
		 */
		if($amount > 0){
			$commentEn = __('TD Amount',[],'en');
			$commentAr = __('TD Amount',[],'ar');
			$timeOfDeposit->handleDebitStatement($financialInstitution->id , $accountType , $timeOfDeposit->getMaturityAmountAddedToAccountNumber() , null , $breakDate,$amount,null,null,1,$commentEn , $commentAr);
		}
		/**
		 * * تاني حاجه هنضيف دبت بقيمة الفايدة
		 */
		if($breakInterestAmount > 0){
			$commentEn = __('TD Interest Amount',[],'en');
			$commentAr = __('TD Interest Amount',[],'ar');
			$timeOfDeposit->handleDebitStatement($financialInstitution->id , $accountType , $timeOfDeposit->getMaturityAmountAddedToAccountNumber() , null , $breakDate,$breakInterestAmount,null,null,1,$commentEn,$commentAr);
		}
		/**
		 * * واخيرا هنضيف كريدت بقيمة الرسوم الادارية ( رسوم كسر الوديعة)
		 */
		if($breakChargeAmount){
			$commentEn = __('TD Break Fees Amount',[],'en');
			$commentAr = __('TD Break Fees Amount',[],'ar');
			$timeOfDeposit->handleCreditStatement($company->id,$financialInstitution->id , $accountType , $timeOfDeposit->getMaturityAmountAddedToAccountNumber() , null , $breakDate,$breakChargeAmount,null,null,$commentEn,$commentAr);
		}
		
		return redirect()->route('view.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id ,'active'=>$type])->with('success',__('Time Of Deposit Has Been Marked As Matured'));
	}
	
	
	/**
	 * * هنا اليوزر هيعكس عملية الكسر اللي كان اكدها اكنه عملها بالغلط فا هنرجع كل حاجه زي ما كانت ونحذف القيم اللي في جدول ال 
	 * * current account bank statements
	 */
	public function reverseBroken(Company $company,Request $request,FinancialInstitution $financialInstitution,TimeOfDeposit $timeOfDeposit)
	{
		// $actualDepositDate = Carbon::make($request->get('actual_deposit_date'))->format('Y-m-d') ;
		// $actualInterestAmount  = $request->get('actual_interest_amount') ;
		$type = TimeOfDeposit::RUNNING ;
		$timeOfDeposit->update([
			'break_date'=>null,
			'break_interest_amount'=>null,
			'status'=>$type,
			'break_charge_amount'=>null,
			'status'=>TimeOfDeposit::RUNNING
		]);
		/**
		 * * هنشيل قيم ال
		 * * current account bank statement
		 */
		
		 CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($timeOfDeposit->currentAccountBankStatements);
		 
		 
		return redirect()->route('view.time.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id ,'active'=>$type])->with('success',__('Time Of Deposit Has Been Marked As Matured'));
	}
}
