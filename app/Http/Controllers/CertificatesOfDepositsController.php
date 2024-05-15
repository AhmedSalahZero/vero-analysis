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
		 * * start of running certificates deposits 
		 */
		$maturedCertificatesOfDepositsStartDate = $filterDates[CertificatesOfDeposit::MATURED]['startDate'] ?? null ;
		$maturedCertificatesOfDepositsEndDate = $filterDates[CertificatesOfDeposit::MATURED]['endDate'] ?? null ;
		$maturedCertificatesOfDeposits = $company->maturedCertificatesOfDeposits ;
		$maturedCertificatesOfDeposits =  $maturedCertificatesOfDeposits->filterByStartDate($maturedCertificatesOfDepositsStartDate,$maturedCertificatesOfDepositsEndDate) ;
		$maturedCertificatesOfDeposits =  $currentType == CertificatesOfDeposit::MATURED ? $this->applyFilter($request,$maturedCertificatesOfDeposits):$maturedCertificatesOfDeposits ;
		/**
		 * * end of running certificates deposits 
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
			]
		];
		
		
		$models = [
			CertificatesOfDeposit::RUNNING =>$runningCertificatesOfDeposits ,
			CertificatesOfDeposit::MATURED =>$maturedCertificatesOfDeposits ,
			
		];
		// $maturedSearchFields = ;
		
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
		$type = $request->get('type','certificates-of-deposit');
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
		// $type = $request->get('type');
		$infos =  $request->get('infos',[]) ;
		
		$data['updated_by'] = auth()->user()->id ;
		$data = $request->only($this->getCommonDataArr());
		foreach(['start_date','end_date'] as $dateField){
			$data[$dateField] = $request->get($dateField) ? Carbon::make($request->get($dateField))->format('Y-m-d'):null;
		}
		$data['interest_amount'] = number_unformat($request->get('interest_amount')) ;
		$certificatesOfDeposit->update($data);
		
		$type = $request->get('type','certificates-of-deposit');
		$activeTab = $type ;
		//  $activeTab = $this->getActiveTab($type);
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));
	}
	public function destroy(Company $company , FinancialInstitution $financialInstitution , CertificatesOFDeposit $certificatesOfDeposit)
	{
		$certificatesOfDeposit->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}
	
	/**
	 * * هنا اليوزر هياكد انه نزله الفايدة المستحقة وبالتالي هنزلها في حسابه الجاري اللي هو اختارة من الفورمة
	 */
	public function applyDeposit(Company $company,Request $request,FinancialInstitution $financialInstitution,CertificatesOfDeposit $certificatesOfDeposit)
	{
		$actualDepositDate = Carbon::make($request->get('actual_deposit_date'))->format('Y-m-d') ;
		$actualInterestAmount  = $request->get('actual_interest_amount') ;
		$certificateType = CertificatesOfDeposit::MATURED ;
		$certificatesOfDeposit->update([
			'actual_deposit_date'=>$actualDepositDate,
			'actual_interest_amount'=>$actualInterestAmount,
			'status'=>$certificateType
		]);
		
		$accountType = AccountType::where('slug',AccountType::CURRENT_ACCOUNT)->first() ;
		if($actualInterestAmount > 0){
			$certificatesOfDeposit->handleStatement($financialInstitution->id , $accountType , $certificatesOfDeposit->getAccountNumber() , null , $actualDepositDate,$actualInterestAmount);
		}
		$certificatesOfDeposit->handleStatement($financialInstitution->id , $accountType , $certificatesOfDeposit->getAccountNumber() , null , $actualDepositDate,$certificatesOfDeposit->getAmount());
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id ,'active'=>$certificateType])->with('success',__('Certificate Has Been Marked As Matured'));
	}
	
	
	
		/**
	 * * هنا اليوزر هيعكس عملية التاكيد اللي كان اكدها اكنه عملها بالغلط فا هنرجع كل حاجه زي ما كانت ونحذف القيم اللي في جدول ال 
	 * * current account bank statements
	 */
	public function reverseDeposit(Company $company,Request $request,FinancialInstitution $financialInstitution,CertificatesOfDeposit $certificatesOfDeposit)
	{
		// $actualDepositDate = Carbon::make($request->get('actual_deposit_date'))->format('Y-m-d') ;
		// $actualInterestAmount  = $request->get('actual_interest_amount') ;
		$certificateType = CertificatesOfDeposit::MATURED ;
		$certificatesOfDeposit->update([
			'actual_deposit_date'=>null,
			'actual_interest_amount'=>null,
			'status'=>CertificatesOfDeposit::RUNNING
		]);
		/**
		 * * هنشيل قيم ال
		 * * current account bank statement
		 */
		$currentAccountBankStatements = $certificatesOfDeposit->currentAccountBankStatements ;
		$length = count($currentAccountBankStatements);
		$currentAccountBankStatements->each(function(CurrentAccountBankStatement $currentAccountBankStatement,$index) use ($length){
			/**
			 * * لو هو اخر عنصر اللي هو تاريخ الاصغر ما بينهم .. في الحاله دي هنحذفه بالطريقة اللي بتشغل ال
			 * * observers
			 * * علشان لو عندك خمسين عنصر مثلا هيتحذفوا ما يروحش يترجر مع كل واحد
			 * * انما لما هيترجر مع الاصفر تاريخ منهم فا في الحاله دي هيعمل مرة واحدة بس ترجر ياحدث من اول التاريخ الصغير دا وانت نازل .. و وانت نازل دي
			 * * معناه انه هيحدث العناصر اللي المفروض يحدثها كلها
			 * * وخلي بالك انك مرتب 
			 * * currentAccountBankStatements 
			 * * من الكبير للصغير من حيث ال 
			 * * full_date 
			 * * فا الاخير هيكون هو الاصغر اللي هنبدا نشكل ال
			 * * observer 
			 * * من عندة
			 */
			if($index == $length-1){
				logger('last loop');
				$currentAccountBankStatement->delete();
			}else{
				logger('start');
				DB::table('current_account_bank_statements')->where('id',$currentAccountBankStatement->id)->delete();
			}
			// DB::table('current_account_bank_statements')->where('id',);
		});
		return redirect()->route('view.certificates.of.deposit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id ,'active'=>$certificateType])->with('success',__('Certificate Has Been Marked As Matured'));
	}
	
	
}
