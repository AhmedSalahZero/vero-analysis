<?php
namespace App\Http\Controllers;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\CleanOverdraft;
use App\Models\CleanOverdraftBankStatement;
use App\Models\Company;
use App\Models\CurrentAccountBankStatement;
use App\Models\FinancialInstitution;
use App\Models\FinancialInstitutionAccount;
use App\Models\InternalMoneyTransfer;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class InternalMoneyTransferController
{
    use GeneralFunctions;
    protected function applyFilter(Request $request,Collection $collection):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName =  'created_at' ; // change it 
		// $dateFieldName = $searchFieldName === 'balance_date' ? 'balance_date' : 'created_at'; 
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
		
		return $collection;
	}
	public function index(Company $company,Request $request)
	{
		
		$models = $company->moneyTransfers ;
		$models =   $this->applyFilter($request,$models) ;
		
		$searchFields = [
			'transfer_date'=>__('Transfer Date'),
			// 'contract_end_date'=>__('Contract End Date'),
			// 'account_number'=>__('Contract Number'),
			// 'currency'=>__('Currency'),
			// 'limit'=>__('Limit'),
			// 'outstanding_balance'=>__('Outstanding Balance'),
			// 'balance_date'=>__('Balance Date'),
			
		];

        return view('internal-money-transfer.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'models'=>$models
		]);
    }
	public function create(Company $company)
	{
        return view('internal-money-transfer.form',$this->getCommonViewVars($company));
    }
	public function getCommonViewVars(Company $company,$model = null)
	{
		$banks = Bank::pluck('view_name','id');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		
		return [
			'banks'=>$banks,
			'selectedBranches'=>$selectedBranches,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'accountTypes'=>$accountTypes,
			'model'=>$model
		];
	}
	
	public function store(Company $company  , Request $request){
	
		$internalMoneyTransfer = new InternalMoneyTransfer ;
		$transferDate = $request->get('transfer_date') ;
		$receivingDate = Carbon::make($transferDate)->addDay($request->get('transfer_days',0))->format('Y-m-d');
		$transferAmount = $request->get('amount') ;
		$internalMoneyTransfer->storeBasicForm($request);
		$fromFinancialInstitutionId = $request->get('from_bank_id');
		$toFinancialInstitutionId = $request->get('to_bank_id');
		$fromAccountTypeId = $request->get('from_account_type_id');
		$toAccountTypeId = $request->get('to_account_type_id');
		$fromAccountType = AccountType::find($fromAccountTypeId);
		$toAccountType = AccountType::find($toAccountTypeId);
		
		if($fromAccountType && $fromAccountType->isCurrentAccount()){
			/**
			 * @var CleanOverdraft $fromCleanOverDraft
			 */
			$fromCurrentAccount = FinancialInstitutionAccount::findByAccountNumber($request->get('from_account_number'),$company->id,$fromFinancialInstitutionId);
			CurrentAccountBankStatement::create([
				'financial_institution_account_id'=>$fromCurrentAccount->id ,
				'internal_money_transfer_id'=>$internalMoneyTransfer->id ,
				'company_id'=>$company->id ,
				'date' => $transferDate , 
				'credit'=>$transferAmount
			]);
		}
		
		if($toAccountType && $toAccountType->isCurrentAccount()){
			/**
			 * @var CleanOverdraft $fromCleanOverDraft
			 */
			$toCurrentAccount = FinancialInstitutionAccount::findByAccountNumber($request->get('to_account_number'),$company->id,$toFinancialInstitutionId);
			CurrentAccountBankStatement::create([
				'financial_institution_account_id'=>$toCurrentAccount->id ,
				'internal_money_transfer_id'=>$internalMoneyTransfer->id ,
				'company_id'=>$company->id ,
				'date' => $receivingDate , 
				'debit'=>$transferAmount,
			]);
		}
		
		//////////////////////////
		
		if($fromAccountType && $fromAccountType->isCleanOverDraftAccount()){
			/**
			 * @var CleanOverdraft $fromCleanOverDraft
			 */

			$fromCleanOverDraft = CleanOverdraft::findByAccountNumber($request->get('from_account_number'),$company->id,$fromFinancialInstitutionId);
			CleanOverdraftBankStatement::create([
				'type'=>CleanOverdraftBankStatement::MONEY_TRANSFER ,
				'clean_overdraft_id'=>$fromCleanOverDraft->id ,
				'internal_money_transfer_id'=>$internalMoneyTransfer->id ,
				'company_id'=>$company->id ,
				'date' => $transferDate , 
				'limit' =>$fromCleanOverDraft->getLimit(),
				'credit'=>$transferAmount
			]);
		}
		
		if($toAccountType && $toAccountType->isCleanOverDraftAccount()){
			/**
			 * @var CleanOverdraft $fromCleanOverDraft
			 */
			$toCleanOverDraft = CleanOverdraft::findByAccountNumber($request->get('to_account_number'),$company->id,$toFinancialInstitutionId);
			CleanOverdraftBankStatement::create([
				'type'=>CleanOverdraftBankStatement::MONEY_TRANSFER ,
				'clean_overdraft_id'=>$toCleanOverDraft->id ,
				'internal_money_transfer_id'=>$internalMoneyTransfer->id ,
				'company_id'=>$company->id ,
				'date' => $receivingDate , 
				'limit' =>$toCleanOverDraft->getLimit(),
				'debit'=>$transferAmount
			]);
		}
		
		$type = $request->get('type','internal-money-transfer');
		$activeTab = $type ; 
		
	
		return redirect()->route('internal-money-transfers.index',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}

	public function edit(Company $company,InternalMoneyTransfer $internalMoneyTransfer)
	{
		
        return view('internal-money-transfer.form',$this->getCommonViewVars($company,$internalMoneyTransfer));
    }
	
	public function update(Company $company , Request $request , InternalMoneyTransfer $internalMoneyTransfer){
		
		$type = $request->get('type','internal-money-transfer');
		$internalMoneyTransfer->deleteRelations();
		$internalMoneyTransfer->delete();
		$this->store($company,$request);
		$activeTab = $type ;
		return redirect()->route('internal-money-transfers.index',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));
		
		
	}
	
	public function destroy(Company $company, InternalMoneyTransfer $internalMoneyTransfer)
	{
		$internalMoneyTransfer->deleteRelations();
		$internalMoneyTransfer->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}

	
	
}
