<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreTdRenewalDateRequest;
use App\Models\Company;
use App\Models\CurrentAccountBankStatement;
use App\Models\FinancialInstitutionAccount;
use App\Models\TdRenewalDateHistory;
use App\Models\TimeOfDeposit;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeOfDepositRenewalDateController
{
    use GeneralFunctions;
	public function index(Company $company,Request $request,TimeOfDeposit $timeOfDeposit)
	{
		$renewalDateHistories = $timeOfDeposit->renewalDateHistories;
        return view('reports.time-of-deposit.renewal-date.index', [
			'company'=>$company,
			'timeOfDeposit'=>$timeOfDeposit,
			'renewalDateHistories'=>$renewalDateHistories,
		]);
    }
	public function store(StoreTdRenewalDateRequest $request, Company $company, TimeOfDeposit $timeOfDeposit){
	
		$date = $request->get('renewal_date') ;
		$newInterestRate = $request->get('interest_rate');
		// $accountNumber = $timeOfDeposit->getAccountNumber() ;
		// $renewalFeesAmount = $request->get('fees_amount');
		$expiryDate = $timeOfDeposit->getRenewalDate();
		$date = explode('/',$date);
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$renewalDate = $year.'-'.$month.'-'.$day ;
		// $financialInstitution = $timeOfDeposit->financialInstitution;
		// $lgType = $timeOfDeposit->getLgType();
		// $transactionName = $timeOfDeposit->getTransactionName();
		// $financialInstitutionAccount = FinancialInstitutionAccount::findByAccountNumber($accountNumber,$company->id , $financialInstitution->id);
	
		if(!$timeOfDeposit->renewalDateHistories->count()){
			/**
			 * * في حالة اول مرة هنضيف تاريخ التجديد الاصلي اكنة تاريخ علشان نحتفظ بيه علشان ما يضيعش
			 */
			TdRenewalDateHistory::create([
				'company_id'=>$company->id ,
				// 'fees_amount'=>0,
				'renewal_date'=>$expiryDate,
				'interest_rate'=>$timeOfDeposit->getInterestRate(),
				'expiry_date'=>$timeOfDeposit->getStartDate(),
				'time_of_deposit_id'=>$timeOfDeposit->id,
			]);
		}
		$tdRenewalDateHistory = TdRenewalDateHistory::create([
			'company_id'=>$company->id ,
			// 'fees_amount'=>$renewalFeesAmount,
			'renewal_date'=>$renewalDate,
			'interest_rate'=>$newInterestRate,
			'expiry_date'=>$expiryDate,
			'time_of_deposit_id'=>$timeOfDeposit->id
		]);
		// $this->storeCommissionToCreditCurrentAccountBankStatement($tdRenewalDateHistory,$timeOfDeposit,$company,$expiryDate,$renewalDate,$transactionName,$lgType);
		// $financialInstitutionAccountOpeningBalance = $financialInstitutionAccount->getOpeningBalanceDate();
		// if(Carbon::make($expiryDate)->greaterThanOrEqualTo(Carbon::make($financialInstitutionAccountOpeningBalance))){
		// 	$timeOfDeposit->storeCurrentAccountCreditBankStatement($expiryDate,$renewalFeesAmount , $financialInstitutionAccount->id,0,1,__('Renewal Fees [ :lgType ] Transaction Name [ :transactionName ]'  ,['lgType'=>__($lgType,[],'en'),'transactionName'=>$transactionName],'en') , __('Renewal Fees [ :lgType ] Transaction Name [ :transactionName ]'  ,['lgType'=>__($lgType,[],'ar'),'transactionName'=>$transactionName],'ar'),true);
		// }
		
		$timeOfDeposit->update([
			'end_date'=>$renewalDate,
			'start_date'=>$expiryDate,
			'interest_rate'=>$newInterestRate
		]);
		
		
		return redirect()->route('time.of.deposit.renewal.date',['company'=>$company->id,'timeOfDeposit'=>$timeOfDeposit->id]);
	}
	// protected function storeCommissionToCreditCurrentAccountBankStatement(TdRenewalDateHistory $tdRenewalDateHistory , TimeOfDeposit $timeOfDeposit,Company $company,string $expiryDate , string $renewalDate,string $transactionName, string $lgType )
	// {
	// 	$tdRenewalDateHistoryId = $tdRenewalDateHistory->id;
	// 	$lgCommissionInterval = $timeOfDeposit->getLgCommissionInterval();
	// 	$lgDurationMonths = Carbon::make($expiryDate)->diffInMonths(Carbon::make($renewalDate));
	
	// 	$numberOfIterationsForQuarter = ceil($lgDurationMonths / 3); 
	// 	$issuanceDate = $expiryDate;
	// 	$minLgCommissionAmount = $timeOfDeposit->getMinLgCommissionFees();
	// 	$lgCommissionAmount = $timeOfDeposit->getLgCommissionAmount();
	// 	$maxLgCommissionAmount = max($minLgCommissionAmount ,$lgCommissionAmount );
	// 	$financialInstitutionId = $timeOfDeposit->getFinancialInstitutionBankId();
	// 	$financialInstitutionAccountForFeesAndCommission = FinancialInstitutionAccount::findByAccountNumber($timeOfDeposit->getLgFeesAndCommissionAccountNumber(),$company->id , $financialInstitutionId);
	// 	$financialInstitutionAccountIdForFeesAndCommission = $financialInstitutionAccountForFeesAndCommission->id;
	// 	$openingBalanceDateOfCurrentAccount = $financialInstitutionAccountForFeesAndCommission->getOpeningBalanceDate();
	// 	$isOpeningBalance = $timeOfDeposit->isOpeningBalance();
	// 	$timeOfDeposit->storeCommissionAmountCreditBankStatement( $lgCommissionInterval ,  $numberOfIterationsForQuarter ,  $issuanceDate, $openingBalanceDateOfCurrentAccount,$maxLgCommissionAmount, $financialInstitutionAccountIdForFeesAndCommission, $transactionName, $lgType, $isOpeningBalance,$tdRenewalDateHistoryId);
		
	// }
	public function edit(Request $request , Company $company ,  TimeOfDeposit $timeOfDeposit , TdRenewalDateHistory $TdRenewalDateHistory){
		$renewalDateHistories = $timeOfDeposit->renewalDateHistories;
        return view('reports.time-of-deposit.renewal-date.index', [
			'company'=>$company,
			'timeOfDeposit'=>$timeOfDeposit,
			'renewalDateHistories'=>$renewalDateHistories,
			'model'=>$TdRenewalDateHistory
		]);
	}
	public function update(StoreTdRenewalDateRequest $request , Company $company ,  TimeOfDeposit $timeOfDeposit  , TdRenewalDateHistory $TdRenewalDateHistory){
		$date = $request->get('renewal_date') ;
		$newInterestRate  = $request->get('interest_rate');
		// $renewalFeesAmount = $request->get('fees_amount');
		$date = explode('/',$date);
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$renewalDate = $year.'-'.$month.'-'.$day ;
		$expiryDate = $request->get('expiry_date');
		// dd($renewalDate,$expiryDate);
		// $renewalFeesCurrentAccountBankStatement = $timeOfDeposit->renewalFeesCurrentAccountBankStatement($expiryDate) ;
	
		// dd($renewalFeesCurrentAccountBankStatement);
		// $financialInstitution = $timeOfDeposit->financialInstitution;
		// $financialInstitutionAccountOpeningBalance = 
		// $time  = now()->format('H:i:s');
		// $fullDateTime = date('Y-m-d H:i:s', strtotime("$renewalDate $time")) ;
		
		// dd($expiryDate,$renewalFeesCurrentAccountBankStatement);
		// CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($TdRenewalDateHistory->commissionCurrentBankStatements()->withoutGlobalScope('only_active')->get());
		// $transactionName = $timeOfDeposit->getTransactionName();
		// $lgType = $timeOfDeposit->getLgType();
		// $financialInstitutionAccount = FinancialInstitutionAccount::findByAccountNumber($timeOfDeposit->lg_fees_and_commission_account_number,$company->id , $financialInstitution->id);
		// $financialInstitutionAccountOpeningBalance = $financialInstitutionAccount->getOpeningBalanceDate();
		// $this->storeCommissionToCreditCurrentAccountBankStatement($TdRenewalDateHistory,$timeOfDeposit,$company,$expiryDate,$renewalDate,$transactionName,$lgType);
		// if($renewalFeesCurrentAccountBankStatement){
			
			
		// 	$currentFullDate =$renewalFeesCurrentAccountBankStatement->full_date ; 
		// 	$time  = Carbon::make($currentFullDate)->format('H:i:s');
		// 	$newFullDateTime = date('Y-m-d H:i:s', strtotime("$expiryDate $time")) ;
		// 	$minDateTime = min($currentFullDate ,$newFullDateTime );
		// 	DB::table('current_account_bank_statements')->where('id',$renewalFeesCurrentAccountBankStatement->id)->update([
		// 		'date'=>$expiryDate,
		// 		'full_date'=>$newFullDateTime ,
		// 		'credit'=>$renewalFeesAmount
		// 	]);
		// 	CurrentAccountBankStatement::where('full_date','>=',$minDateTime)
		// 	->where('financial_institution_account_id',$renewalFeesCurrentAccountBankStatement->financial_institution_account_id)
		// 	->orderByRaw('full_date asc, id asc')
		// 	->first()
		// 	->update([
		// 		'updated_at'=>now()
		// 	]);
			
		//  /**
		//   * ! عايزين نعملها بطريق
		//   * DB::Table()
		//   */
		//   /**
		//    * ! خلي بالك انها ممكن ما تبقاش موجودة وبالتالي لازم الاول نشوف لو حصل 
		//    * 
		//    */
		// 	// $renewalFeesCurrentAccountBankStatement->update([
		// 	// 	'date'=>$renewalDate,
		// 	// 	'full_date'=>$fullDateTime,
		// 	// 	'credit'=>$renewalFeesAmount
		// 	// ]);
			
		// }
		// else{
		// 	if(Carbon::make($expiryDate)->greaterThanOrEqualTo(Carbon::make($financialInstitutionAccountOpeningBalance))){
		// 		$timeOfDeposit->storeCurrentAccountCreditBankStatement($expiryDate,$renewalFeesAmount , $financialInstitutionAccount->id,0,1,__('Renewal Fees [ :lgType ] Transaction Name [ :transactionName ]'  ,['lgType'=>__($lgType,[],'en'),'transactionName'=>$transactionName],'en') , __('Renewal Fees [ :lgType ] Transaction Name [ :transactionName ]'  ,['lgType'=>__($lgType,[],'ar'),'transactionName'=>$transactionName],'ar'),true);
		// 	}
		// }
		$TdRenewalDateHistory->update([
			'renewal_date'=>$renewalDate ,
			'expiry_date'=>$expiryDate,
			'interest_rate'=>$newInterestRate
		]);
		$timeOfDeposit->update([
			'end_date'=>$renewalDate,
			'start_date'=>$expiryDate,
			'interest_rate'=>$newInterestRate
		]);
		

		return redirect()->route('time.of.deposit.renewal.date',['company'=>$company->id,'timeOfDeposit'=>$timeOfDeposit->id]);
		
	}
	public function destroy(Request $request , Company $company ,  TimeOfDeposit $timeOfDeposit , TdRenewalDateHistory $TdRenewalDateHistory)
	{
		
		// CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($TdRenewalDateHistory->commissionCurrentBankStatements()->withoutGlobalScope('only_active')->get());
		// $oldRenewalDate = $timeOfDeposit->getRenewalDate();
		// $expiryDate = $timeOfDeposit->getRenewalDateBefore($oldRenewalDate);
		// dd($oldRenewalDate,$expiryDate);
		// $renewalFeesCurrentAccountBankStatement = $timeOfDeposit->renewalFeesCurrentAccountBankStatement($expiryDate) ;
		// if($renewalFeesCurrentAccountBankStatement){
		// 	$renewalFeesCurrentAccountBankStatement->delete();
		// }
	
		$TdRenewalDateHistory->delete();
		$timeOfDeposit = $timeOfDeposit->refresh();
		$lastHistory = $timeOfDeposit->renewalDateHistories->last();
		
		$timeOfDeposit->update([
			'end_date'=>$lastHistory->renewal_date ,
			'start_date'=>$lastHistory->expiry_date,
			'interest_rate'=>$lastHistory->interest_rate
			]) ; 
			/**
			 * * لو معدش فاضل غيرها دا معناه انه حذف تاني عنصر وبالتالي العنصر الاول اللي معتش فاضل غيره هو الديو ديت الاصلي ففي الحاله
			 * * دي هنحذفه معتش ليه لزمة
			 */
			if($timeOfDeposit->renewalDateHistories->count() == 1){
				$lastHistory->delete();
			}
		return redirect()->route('time.of.deposit.renewal.date',['company'=>$company->id,'timeOfDeposit'=>$timeOfDeposit->id]);
	}
	
}
