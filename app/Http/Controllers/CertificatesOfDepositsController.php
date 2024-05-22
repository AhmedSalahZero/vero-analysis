<?php
namespace App\Http\Controllers;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\CertificatesOfDeposit;
use App\Models\Company;
use App\Models\CurrentAccountBankStatement;
use App\Models\FinancialInstitution;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CertificatesOfDepositsController
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
		 * @var Collection $runningCertificatesOfDeposits 
		 */
		
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$currentType = $request->get('active',CertificatesOfDeposit::RUNNING);
		$filterDates = [];
		foreach(CertificatesOfDeposit::getAllTypes() as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		/**
		 * * start of running certificates deposits 
		 */
		$runningCertificatesOfDepositsStartDate = $filterDates[CertificatesOfDeposit::RUNNING]['startDate'] ?? null ;
		$runningCertificatesOfDepositsEndDate = $filterDates[CertificatesOfDeposit::RUNNING]['endDate'] ?? null ;
		$runningCertificatesOfDeposits = $company->runningCertificatesOfDeposits ;
		$runningCertificatesOfDeposits =  $runningCertificatesOfDeposits->filterByStartDate($runningCertificatesOfDepositsStartDate,$runningCertificatesOfDepositsEndDate) ;
		$runningCertificatesOfDeposits =  $currentType == CertificatesOfDeposit::RUNNING ? $this->applyFilter($request,$runningCertificatesOfDeposits):$runningCertificatesOfDeposits ;
		/**
		 * * end of running certificates deposits 
		 */
		
		 
		 
		 /**
		 * * start of matured certificates deposits 
		 */
		$maturedCertificatesOfDepositsStartDate = $filterDates[CertificatesOfDeposit::MATURED]['startDate'] ?? null ;
		$maturedCertificatesOfDepositsEndDate = $filterDates[CertificatesOfDeposit::MATURED]['endDate'] ?? null ;
		$maturedCertificatesOfDeposits = $company->maturedCertificatesOfDeposits ;
		$maturedCertificatesOfDeposits =  $maturedCertificatesOfDeposits->filterByStartDate($maturedCertificatesOfDepositsStartDate,$maturedCertificatesOfDepositsEndDate) ;
		$maturedCertificatesOfDeposits =  $currentType == CertificatesOfDeposit::MATURED ? $this->applyFilter($request,$maturedCertificatesOfDeposits):$maturedCertificatesOfDeposits ;
		/**
		 * * end of matured certificates deposits 
		 */
		
		 
		 
		 	 /**
		 * * start of broken certificates deposits 
		 */
		$brokenCertificatesOfDepositsStartDate = $filterDates[CertificatesOfDeposit::BROKEN]['startDate'] ?? null ;
		$brokenCertificatesOfDepositsEndDate = $filterDates[CertificatesOfDeposit::BROKEN]['endDate'] ?? null ;
		$brokenCertificatesOfDeposits = $company->brokenCertificatesOfDeposits ;
		$brokenCertificatesOfDeposits =  $brokenCertificatesOfDeposits->filterByStartDate($brokenCertificatesOfDepositsStartDate,$brokenCertificatesOfDepositsEndDate) ;
		$brokenCertificatesOfDeposits =  $currentType == CertificatesOfDeposit::BROKEN ? $this->applyFilter($request,$brokenCertificatesOfDeposits):$brokenCertificatesOfDeposits ;
		/**
		 * * end of broken certificates deposits 
		 */
		
		 
		
		$searchFields = [
			CertificatesOfDeposit::RUNNING=>[
				'start_date'=>__('Start Date'),
				'end_date'=>__('End Date'),
				'account_number'=>__('Account Number'),
				'currency'=>__('Currency'),
			],
			CertificatesOfDeposit::MATURED=>[
				'start_date'=>__('Start Date'),
				'end_date'=>__('End Date'),
				'account_number'=>__('Account Number'),
				'currency'=>__('Currency'),
			],
			CertificatesOfDeposit::BROKEN=>[
				'start_date'=>__('Start Date'),
				'end_date'=>__('End Date'),
				'account_number'=>__('Account Number'),
				'currency'=>__('Currency'),
			]
		];
		
		 
		$models = [
			CertificatesOfDeposit::RUNNING =>$runningCertificatesOfDeposits ,
			CertificatesOfDeposit::MATURED =>$maturedCertificatesOfDeposits ,
			CertificatesOfDeposit::BROKEN =>$brokenCertificatesOfDeposits ,
		];
		
        return view('reports.certificates-of-deposit.index', [
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
		/**
		 * * عباره عن حساب جاري فقط
		 */
		$accounts = $financialInstitution->accounts ;
        return view('reports.certificates-of-deposit.form',[
			'banks'=>$banks,
			'selectedBranches'=>$selectedBranches,
			'financialInstitution'=>$financialInstitution,
			'accounts'=>$accounts
		]);
    }
	public function getCommonDataArr():array 
	{
		return ['start_date','account_number','amount','end_date','currency','interest_rate','interest_amount','maturity_amount_added_to_account_id'];
	}
	public function store(Company $company  ,FinancialInstitution $financialInstitution, Request $request){
		
		$data = $request->only( $this->getCommonDataArr());
		foreach(['start_date','end_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		$data['created_by'] = auth()->user()->id ;
		$data['company_id'] = $company->id ;
		$data['interest_amount'] = number_unformat($request->get('interest_amount')) ;
		$financialInstitution->certificatesOfDeposits()->create($data);
		$type = $request->get('type',CertificatesOfDeposit::RUNNING);
		$activeTab = $type ; 
		
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}
	
	public function edit(Company $company , Request $request , FinancialInstitution $financialInstitution , CertificatesOfDeposit $certificatesOfDeposit){
		$accounts = $financialInstitution->accounts ;
        return view('reports.certificates-of-deposit.form',[
			'financialInstitution'=>$financialInstitution,
			'model'=>$certificatesOfDeposit,
			'accounts'=>$accounts
		]);
		
	}
	
	public function update(Company $company , Request $request , FinancialInstitution $financialInstitution,CertificatesOfDeposit $certificatesOfDeposit){
		
		$data['updated_by'] = auth()->user()->id ;
		$data = $request->only($this->getCommonDataArr());
		foreach(['start_date','end_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		$data['interest_amount'] = number_unformat($request->get('interest_amount')) ;
		$certificatesOfDeposit->update($data);
		$type = $request->get('type',CertificatesOfDeposit::RUNNING);
		$activeTab = $type ;
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));
	}
	public function destroy(Company $company , FinancialInstitution $financialInstitution , CertificatesOFDeposit $certificatesOfDeposit)
	{
		CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($certificatesOfDeposit->currentAccountBankStatements);
		$certificatesOfDeposit->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}
	
	/**
	 * * هنا اليوزر هياكد انه نزله الفايدة المستحقة وبالتالي هنزلها في حسابه الجاري اللي هو اختارة من الفورمة
	 */
	public function applyDeposit(Company $company,Request $request,FinancialInstitution $financialInstitution,CertificatesOfDeposit $certificatesOfDeposit)
	{
		$actualDepositDate = Carbon::make($request->get('deposit_date'))->format('Y-m-d') ;
		$actualInterestAmount  = $request->get('actual_interest_amount') ;
		$certificateType = CertificatesOfDeposit::MATURED ;
		$certificatesOfDeposit->update([
			'deposit_date'=>$actualDepositDate,
			'actual_interest_amount'=>$actualInterestAmount,
			'status'=>$certificateType
		]);
		
		$accountType = AccountType::where('slug',AccountType::CURRENT_ACCOUNT)->first() ;
		if($actualInterestAmount > 0){
			$certificatesOfDeposit->handleDebitStatement($financialInstitution->id , $accountType , $certificatesOfDeposit->getMaturityAmountAddedToAccountNumber() , null , $actualDepositDate,$actualInterestAmount);
		}
		$certificatesOfDeposit->handleDebitStatement($financialInstitution->id , $accountType , $certificatesOfDeposit->getMaturityAmountAddedToAccountNumber() , null , $actualDepositDate,$certificatesOfDeposit->getAmount());
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id ,'active'=>$certificateType])->with('success',__('Certificate Has Been Marked As Matured'));
	}
	
	
	
		/**
	 * * هنا اليوزر هيعكس عملية التاكيد اللي كان اكدها اكنه عملها بالغلط فا هنرجع كل حاجه زي ما كانت ونحذف القيم اللي في جدول ال 
	 * * current account bank statements
	 */
	public function reverseDeposit(Company $company,Request $request,FinancialInstitution $financialInstitution,CertificatesOfDeposit $certificatesOfDeposit)
	{
		$certificateType = CertificatesOfDeposit::RUNNING ;
		$certificatesOfDeposit->update([
			'deposit_date'=>null,
			'actual_interest_amount'=>null,
			'status'=>CertificatesOfDeposit::RUNNING
		]);
		/**
		 * * هنشيل قيم ال
		 * * current account bank statement
		 */
		CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($certificatesOfDeposit->currentAccountBankStatements);
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id ,'active'=>$certificateType])->with('success',__('Certificate Has Been Marked As Matured'));
	}
	
	
	/**
	 * * لو انت عملت شهادة ايداع في البنك تقدر تكسرها وتاخد قيمة الشهادة بتاعتك بس بيطبق عليك غرامة
	 */
	public function applyBreak(Company $company,Request $request,FinancialInstitution $financialInstitution,CertificatesOfDeposit $certificatesOfDeposit)
	{
		$breakDate = Carbon::make($request->get('break_date'))->format('Y-m-d') ;
		$breakInterestAmount  = $request->get('break_interest_amount') ;
		$breakChargeAmount  = $request->get('break_charge_amount') ;
		$amount  = $request->get('amount') ;
		$certificateType = CertificatesOfDeposit::BROKEN ;
		$certificatesOfDeposit->update([
			'break_date'=>$breakDate,
			'break_interest_amount'=>$breakInterestAmount,
			'status'=>$certificateType,
			'break_charge_amount'=>$breakChargeAmount
		]);
		
		$accountType = AccountType::where('slug',AccountType::CURRENT_ACCOUNT)->first() ;
		/**
		 * * اول حاجه هنضيف دبت بقيمة الشهادة 
		 */
		if($amount > 0){
			$certificatesOfDeposit->handleDebitStatement($financialInstitution->id , $accountType , $certificatesOfDeposit->getMaturityAmountAddedToAccountNumber() , null , $breakDate,$amount);
		}
		/**
		 * * تاني حاجه هنضيف دبت بقيمة الفايدة
		 */
		if($breakInterestAmount > 0){
			$certificatesOfDeposit->handleDebitStatement($financialInstitution->id , $accountType , $certificatesOfDeposit->getMaturityAmountAddedToAccountNumber() , null , $breakDate,$breakInterestAmount);
		}
		/**
		 * * واخيرا هنضيف كريدت بقيمة الرسوم الادارية
		 */
		if($breakChargeAmount){
			$certificatesOfDeposit->handleCreditStatement($company->id,$financialInstitution->id , $accountType , $certificatesOfDeposit->getMaturityAmountAddedToAccountNumber() , null , $breakDate,$breakChargeAmount);
		}
		
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id ,'active'=>$certificateType])->with('success',__('Certificate Has Been Marked As Matured'));
	}
	
	
	/**
	 * * هنا اليوزر هيعكس عملية الكسر اللي كان اكدها اكنه عملها بالغلط فا هنرجع كل حاجه زي ما كانت ونحذف القيم اللي في جدول ال 
	 * * current account bank statements
	 */
	public function reverseBroken(Company $company,Request $request,FinancialInstitution $financialInstitution,CertificatesOfDeposit $certificatesOfDeposit)
	{
		$certificateType = CertificatesOfDeposit::RUNNING ;
		$certificatesOfDeposit->update([
			'break_date'=>null,
			'break_interest_amount'=>null,
			'status'=>$certificateType,
			'break_charge_amount'=>null,
			'status'=>CertificatesOfDeposit::RUNNING
		]);
		/**
		 * * هنشيل قيم ال
		 * * current account bank statement
		 */
		
		 CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($certificatesOfDeposit->currentAccountBankStatements);
		 
		 
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id ,'active'=>$certificateType])->with('success',__('Certificate Has Been Marked As Matured'));
	}
}
