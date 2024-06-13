<?php
namespace App\Http\Controllers;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\BuyOrSellCurrency;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BuyOrSellCurrenciesController
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
		
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$currentType = $request->get('active',BuyOrSellCurrency::BANK_TO_BANK);
		
		$filterDates = [];
		foreach(BuyOrSellCurrency::getAllTypes() as $type => $title ){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		
		/**
		 * * start of bank to bank buy or sell currency 
		 */
		
		$bankToBankStartDate = $filterDates[BuyOrSellCurrency::BANK_TO_BANK]['startDate'] ?? null ;
		$bankToBankEndDate = $filterDates[BuyOrSellCurrency::BANK_TO_BANK]['endDate'] ?? null ;
		$bankToBankBuyOrSellCurrencies = $company->bankToBankBuyOrSellCurrencies ;
		$bankToBankBuyOrSellCurrencies =  $bankToBankBuyOrSellCurrencies->filterByTransferDate($bankToBankStartDate,$bankToBankEndDate) ;
		$bankToBankBuyOrSellCurrencies =  $currentType == BuyOrSellCurrency::BANK_TO_BANK ? $this->applyFilter($request,$bankToBankBuyOrSellCurrencies):$bankToBankBuyOrSellCurrencies ;

		/**
		 * * end of bank to bank buy or sell currency 
		 */
		
		 
		 /**
		 * * start of safe to bank buy or sell currency 
		 */
		
		$safeToBankStartDate = $filterDates[BuyOrSellCurrency::SAFE_TO_BANK]['startDate'] ?? null ;
		$safeToBankEndDate = $filterDates[BuyOrSellCurrency::SAFE_TO_BANK]['endDate'] ?? null ;
		$safeToBankBuyOrSellCurrencies = $company->safeToBankBuyOrSellCurrencies ;
		$safeToBankBuyOrSellCurrencies =  $safeToBankBuyOrSellCurrencies->filterByTransferDate($safeToBankStartDate,$safeToBankEndDate) ;
		$safeToBankBuyOrSellCurrencies =  $currentType == BuyOrSellCurrency::SAFE_TO_BANK ? $this->applyFilter($request,$safeToBankBuyOrSellCurrencies):$safeToBankBuyOrSellCurrencies ;

		/**
		 * * end of safe to bank buy or sell currency 
		 */
		
		 
		  /**
		 * * start of bank to safe buy or sell currency 
		 */
		
		$bankToSafeStartDate = $filterDates[BuyOrSellCurrency::BANK_TO_SAFE]['startDate'] ?? null ;
		$bankToSafeEndDate = $filterDates[BuyOrSellCurrency::BANK_TO_SAFE]['endDate'] ?? null ;
		$bankToSafeBuyOrSellCurrencies = $company->bankToSafeBuyOrSellCurrencies ;
		$bankToSafeBuyOrSellCurrencies =  $bankToSafeBuyOrSellCurrencies->filterByTransferDate($bankToSafeStartDate,$bankToSafeEndDate) ;
		$bankToSafeBuyOrSellCurrencies =  $currentType == BuyOrSellCurrency::BANK_TO_SAFE ? $this->applyFilter($request,$bankToSafeBuyOrSellCurrencies):$bankToSafeBuyOrSellCurrencies ;

		/**
		 * * end of bank to safe buy or sell currency 
		 */
		
		 
		 	  /**
		 * * start of safe to safe buy or sell currency 
		 */
		
		$safeToSafeStartDate = $filterDates[BuyOrSellCurrency::SAFE_TO_SAFE]['startDate'] ?? null ;
		$safeToSafeEndDate = $filterDates[BuyOrSellCurrency::SAFE_TO_SAFE]['endDate'] ?? null ;
		$safeToSafeBuyOrSellCurrencies = $company->safeToSafeBuyOrSellCurrencies ;
		$safeToSafeBuyOrSellCurrencies =  $bankToSafeBuyOrSellCurrencies->filterByTransferDate($safeToSafeStartDate,$safeToSafeEndDate) ;
		$safeToSafeBuyOrSellCurrencies =  $currentType == BuyOrSellCurrency::SAFE_TO_SAFE ? $this->applyFilter($request,$safeToSafeBuyOrSellCurrencies):$safeToSafeBuyOrSellCurrencies ;

		/**
		 * * end of safe to safe buy or sell currency 
		 */
		
		 
		
		 $searchFields = [
			BuyOrSellCurrency::BANK_TO_BANK=>[
				'transaction_date'=>__('Transaction Date')
			],
			BuyOrSellCurrency::SAFE_TO_BANK=>[
				'transaction_date'=>__('Transaction Date')
			],
			BuyOrSellCurrency::BANK_TO_SAFE=>[
				'transaction_date'=>__('Transaction Date')
			],
			BuyOrSellCurrency::SAFE_TO_SAFE=>[
				'transaction_date'=>__('Transaction Date')
			],
			
		];
	
		$models = [
			BuyOrSellCurrency::BANK_TO_BANK =>$bankToBankBuyOrSellCurrencies ,
			BuyOrSellCurrency::SAFE_TO_BANK =>$safeToBankBuyOrSellCurrencies ,
			BuyOrSellCurrency::BANK_TO_SAFE =>$bankToSafeBuyOrSellCurrencies ,
			BuyOrSellCurrency::SAFE_TO_SAFE =>$safeToSafeBuyOrSellCurrencies ,
			
		];

        return view('buy-or-sell-currency.index', [
			'company'=>$company,
			'searchFields'=>$searchFields,
			'models'=>$models
		]);
    }
	public function create(Company $company)
	{
        return view('buy-or-sell-currency.form',$this->getCommonViewVars($company));
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
			'model'=>$model,
			// 'type'=>$type
		];
	}
	
	public function store(Company $company , string $type  , Request $request){
		$internalMoneyTransfer = new BuyOrSellCurrency ;
		$internalMoneyTransfer->type = $type ;
		$transferDate = $request->get('transaction_date') ;
		$receivingDate = Carbon::make($transferDate)->addDay($request->get('transfer_days',0))->format('Y-m-d');
		$transferAmount = $request->get('amount') ;
		$internalMoneyTransfer->storeBasicForm($request);
		$fromFinancialInstitutionId = $request->get('from_bank_id');
		$toFinancialInstitutionId = $request->get('to_bank_id');
		$fromAccountTypeId = $request->get('from_account_type_id');
		$toAccountTypeId = $request->get('to_account_type_id');
		$fromAccountNumber = $request->get('from_account_number');
		$toAccountNumber = $request->get('to_account_number');
		$toBranchId = $request->get('to_branch_id');
		$fromBranchId = $request->get('from_branch_id');
		$currencyName = $request->get('currency');	
		$fromAccountType = AccountType::find($fromAccountTypeId);
		$toAccountType = AccountType::find($toAccountTypeId);
		if($type === BuyOrSellCurrency::BANK_TO_BANK){
			$internalMoneyTransfer->handleBankToBankTransfer($company->id , $fromAccountType , $fromAccountNumber  , $fromFinancialInstitutionId , $toAccountType ,  $toAccountNumber,$toFinancialInstitutionId,$transferDate,$receivingDate,$transferAmount);
		}
		elseif($type === BuyOrSellCurrency::BANK_TO_SAFE ){
			$internalMoneyTransfer->handleBankToSafeTransfer($company->id , $fromAccountType , $fromAccountNumber  , $fromFinancialInstitutionId ,$toBranchId , $currencyName , $transferDate,$transferAmount);
		}
		elseif($type === BuyOrSellCurrency::SAFE_TO_BANK ){
			$internalMoneyTransfer->handleSafeToBankTransfer($company->id , $toAccountType , $toAccountNumber  , $toFinancialInstitutionId ,$fromBranchId , $currencyName , $transferDate,$transferAmount);
		}
		
		$activeTab = $type ; 
		
	
		return redirect()->route('buy-or-sell-currencies.index',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Data Store Successfully'));
		
	}

	public function edit(Company $company,string $type,BuyOrSellCurrency $internalMoneyTransfer)
	{
		$formName = $type . '-form';
        return view('buy-or-sell-currency.'.$formName ,$this->getCommonViewVars($company,$type,$internalMoneyTransfer));
    }
	
	public function update(Company $company , string $type , Request $request , BuyOrSellCurrency $internalMoneyTransfer){
		
		$internalMoneyTransfer->deleteRelations();
		$internalMoneyTransfer->delete();
		$this->store($company,$type,$request);
		$activeTab = $type ;
		return redirect()->route('buy-or-sell-currencies.index',['company'=>$company->id,'active'=>$activeTab])->with('success',__('Item Has Been Updated Successfully'));
	}
	
	public function destroy(Company $company , string $type, BuyOrSellCurrency $internalMoneyTransfer)
	{
		$internalMoneyTransfer->deleteRelations();
		$internalMoneyTransfer->delete();
		return redirect()->back()->with('success',__('Item Has Been Delete Successfully'));
	}
}
