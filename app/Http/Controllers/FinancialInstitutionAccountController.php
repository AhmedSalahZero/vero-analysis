<?php
namespace App\Http\Controllers;
use App\Http\Requests\UpdateCurrentAccountRequest;
use App\Models\Branch;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialInstitutionAccountController
{
    use GeneralFunctions;
  
	public function edit(Company $company , Request $request , FinancialInstitutionAccount $financialInstitutionAccount){

		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
        return view('reports.financial-institution-accounts.edit',[
			'selectedBranches'=>$selectedBranches,
			'model'=>$financialInstitutionAccount,
			'financialInstitution'=>$financialInstitutionAccount->financialInstitution
		]);
	}
	public function update(Company $company , UpdateCurrentAccountRequest $request ,FinancialInstitution $financialInstitution , FinancialInstitutionAccount $financialInstitutionAccount){

		$currency = $request->get('currency',$financialInstitutionAccount->getCurrency());
		
		$financialInstitutionAccount->update([
			'account_number'=>$request->get('account_number'),
			'currency'=>$currency ,
			'balance_amount'=>$request->get('balance_amount'),
			'iban'=>$request->get('iban'),
			'exchange_rate'=>$request->get('exchange_rate')
		]);
		$currentAccountBeginningBalance = $financialInstitutionAccount->currentAccountBankStatements->where('is_beginning_balance',1)->first() ;
		if($currentAccountBeginningBalance){
			$currentAccountBeginningBalance->update([
				'balance_amount'=>$request->get('balance_amount'),
				'comment_en'=>__('Beginning Balance',[],'en'),
				'comment_ar'=>__('Beginning Balance',[],'ar'),
			]);
		}
		
		$oldAccountInterestsIds = $financialInstitutionAccount->accountInterests->pluck('id')->toArray();
		$AccountInterestsIdsFromRequest =array_column($request->get('account_interests',[]),'id') ;
		$elementsToDelete = array_diff($oldAccountInterestsIds,$AccountInterestsIdsFromRequest);
		$elementsToUpdate = array_intersect($AccountInterestsIdsFromRequest,$oldAccountInterestsIds);
		$financialInstitutionAccount->accountInterests()->whereIn('account_interests.id',$elementsToDelete)->delete();
		foreach($elementsToUpdate as $id){
			$dataToUpdate = findByKey($request->get('account_interests'),'id',$id);
			unset($dataToUpdate['id']);
			$dataToUpdate['start_date'] = isset($dataToUpdate['start_date']) ? Carbon::make($dataToUpdate['start_date'])->format('Y-m-d') : null;
			$financialInstitutionAccount->accountInterests()->where('account_interests.id',$id)->update($dataToUpdate);
		}
		foreach($request->get('account_interests') as $accountInterestArr){
			if(!isset($accountInterestArr['id'])){
				unset($accountInterestArr['id']);
				$accountInterestArr['start_date'] = isset($accountInterestArr['start_date']) ? Carbon::make($accountInterestArr['start_date'])->format('Y-m-d') : null;
				$financialInstitutionAccount->accountInterests()->create($accountInterestArr);
			}
		}
		
		 $activeTab = 'bank';
		return redirect()->route('view.financial.institutions',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));
		
		
	}
	
	public function destroy(Company $company , FinancialInstitutionAccount $financialInstitutionAccount)
	{
		$financialInstitutionAccount->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}
	public function lockOrUnlock(Company $company , FinancialInstitutionAccount $financialInstitutionAccount)
	{
		$financialInstitutionAccount->is_active = ! $financialInstitutionAccount->isActive();
		$financialInstitutionAccount->save();
		return redirect()->back()->with('success',__('Item Has Been Updated Successfully'));
	}
	public function getAccountNumbersBasedOnCurrency(Company $company , Request $request , FinancialInstitution $financialInstitution,?string $currency)
	{
		$financialInstitution->accounts;
	}

	
	
}
