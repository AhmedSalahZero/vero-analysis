<?php
namespace App\Http\Controllers;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Cheque;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Models\MoneyReceived;
use App\Models\OpeningBalance;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;

class OpeningBalancesController
{
    use GeneralFunctions;
	public function index(Company $company,Request $request)
	{
		$financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
		$accountTypes = AccountType::onlyCashAccounts()->get();		
		$selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
		$customerInvoices = CustomerInvoice::where('company_id',$company->id)->get()->formattedForSelect(true ,'getId','getName');
		
		$banks = Bank::pluck('view_name','id');
        return view('opening-balance.form', [
			'company'=>$company,
			'model'=>$company->openingBalance,
			'selectedBanks'=>$selectedBanks,
			'banks'=>$banks,
			'customerInvoicesFormatted'=>$customerInvoices,
			'financialInstitutionBanks'=>$financialInstitutionBanks,
			'accountTypes'=>$accountTypes
		]);
    }
	public function store(Request $request, Company $company){
		$openingBalanceDate = $request->get('date');
		$openingBalance = OpeningBalance::create([
			'date'=>$openingBalanceDate,
			'company_id'=>$company->id 
		]);
		foreach($request->get('cash-in-safe') as $index => $cashInSaveArr){
			$openingBalance->moneyReceived()->create([
				
				'received_amount'=>$cashInSaveArr['received_amount'] ?: 0 ,
				'currency'=>$cashInSaveArr['currency'],
				'receiving_date'=>$openingBalanceDate,
				'company_id'=>$company->id ,
				'type'=>MoneyReceived::CASH_IN_SAFE,
				'user_id'=>auth()->id(),
				'exchange_rate'=>isset($cashInSaveArr['exchange_rate']) ? $cashInSaveArr['exchange_rate'] : 1 
			]);
		}
		foreach($request->get(MoneyReceived::CHEQUE) as $index => $cheque){
			$customerInvoice = CustomerInvoice::find($cheque['customer_name'] ?: null);
			$moneyReceived = $openingBalance->moneyReceived()->create([
				'type'=>MoneyReceived::CHEQUE,
				'customer_name'=>$customerInvoice ? $customerInvoice->getCustomerName() : null ,
				'received_amount'=>$cheque['received_amount'] ?: 0 ,
				'currency'=>$cheque['currency'],
				'receiving_date'=>$openingBalanceDate,
				'company_id'=>$company->id ,
				'user_id'=>auth()->id(),
				'exchange_rate'=>isset($cheque['exchange_rate']) ? $cheque['exchange_rate'] : 1 
			]);
			$moneyReceived->cheque()->create([
				'cheque_number'=>$cheque['cheque_number'] ?: null ,
				'drawee_bank_id'=>isset($cheque['drawee_bank_id'])?$cheque['drawee_bank_id'] : null ,
				'due_date'=>$cheque['due_date'] ?: null ,
			]);
		}
		
		
		foreach($request->get(MoneyReceived::CHEQUE_UNDER_COLLECTION) as $index => $chequeUnderCollection){
			$customerInvoice = CustomerInvoice::find($chequeUnderCollection['customer_name'] ?: null);
			$moneyReceived = $openingBalance->moneyReceived()->create([
				'type'=>MoneyReceived::CHEQUE,
				'customer_name'=>$customerInvoice ? $customerInvoice->getCustomerName() : null ,
				'received_amount'=>$chequeUnderCollection['received_amount'] ?: 0 ,
				'currency'=>$chequeUnderCollection['currency'],
				'receiving_date'=>$openingBalanceDate,
				'company_id'=>$company->id ,
				'user_id'=>auth()->id(),
				'exchange_rate'=>isset($chequeUnderCollection['exchange_rate']) ? $chequeUnderCollection['exchange_rate'] : 1 
			]);
			$moneyReceived->cheque()->create([
				'status'=>Cheque::UNDER_COLLECTION,
				'cheque_number'=>$chequeUnderCollection['cheque_number'] ?: null ,
				'drawee_bank_id'=>isset($chequeUnderCollection['drawee_bank_id'])  ? $chequeUnderCollection['drawee_bank_id'] : null ,
				'due_date'=>$chequeUnderCollection['due_date'] ?: null ,
				'deposit_date'=>$chequeUnderCollection['deposit_date'] ?: null ,
				'drawl_bank_id'=>$chequeUnderCollection['drawl_bank_id'] ?: null ,
				'account_type'=>$chequeUnderCollection['account_type'] ?: null ,
				'account_number'=>$chequeUnderCollection['account_number'] ?: null ,
				'clearance_days'=>$chequeUnderCollection['clearance_days'] ?: 0 ,
			]);
		}
		

		return redirect()->route('opening-balance.index',['company'=>$company->id]);
	}
	public function update(Company $company , Request $request , OpeningBalance $openingBalance){
		$openingBalance->update([
			'date'=>$request->get('date'),
		]);
		
		/**
		 * * هنا تحديث ال
		 * * cash in safe
		 */
		$oldIdsFromDatabase = $openingBalance->cashInSafe->pluck('id')->toArray();
		$idsFromRequest =array_column($request->input(MoneyReceived::CASH_IN_SAFE,[]),'id') ;
	
		$elementsToDelete = array_diff($oldIdsFromDatabase,$idsFromRequest);
		$elementsToUpdate = array_intersect($idsFromRequest,$oldIdsFromDatabase);

		$openingBalance->cashInSafe()->whereIn('money_received.id',$elementsToDelete)->delete();
		foreach($elementsToUpdate as $id){
			$dataToUpdate = findByKey($request->input(MoneyReceived::CASH_IN_SAFE),'id',$id);
			$openingBalance->cashInSafe()->where('money_received.id',$id)->first()->update($dataToUpdate);
		}
		foreach($request->get(MoneyReceived::CASH_IN_SAFE,[]) as $data){
			if(!isset($data['id'])){
				unset($data['id']);
				$openingBalance->cashInSafe()->create(array_merge($data,[
					'company_id'=>$company->id ,
				'type'=>MoneyReceived::CASH_IN_SAFE,
				'user_id'=>auth()->id(),
				]));
			}
		}
		/**
		 * * هنا تحديث الشيكات في الخزنة
		 * * ChequeInSafe
		 */
		
		 $oldIdsFromDatabase = $openingBalance->chequeInSafe->pluck('id')->toArray();
		$idsFromRequest =array_column($request->input(MoneyReceived::CHEQUE,[]),'id') ;
	
		$elementsToDelete = array_diff($oldIdsFromDatabase,$idsFromRequest);
		$elementsToUpdate = array_intersect($idsFromRequest,$oldIdsFromDatabase);

		$openingBalance->chequeInSafe()->whereIn('money_received.id',$elementsToDelete)->delete();
		foreach($elementsToUpdate as $id){
			$dataToUpdate = findByKey($request->input(MoneyReceived::CHEQUE),'id',$id);
			unset($dataToUpdate['id']);
			$pivotData = [
				'due_date'=>$dataToUpdate['due_date'],
				'drawee_bank_id'=>isset($dataToUpdate['drawee_bank_id']) ? $dataToUpdate['drawee_bank_id'] : null,
				'cheque_number'=>$dataToUpdate['cheque_number'],
				
			];
			unset($dataToUpdate['due_date']);
			unset($dataToUpdate['drawee_bank_id']);
			unset($dataToUpdate['cheque_number']);
			$dataToUpdate['customer_name'] = is_numeric($dataToUpdate['customer_name']) ? CustomerInvoice::find($dataToUpdate['customer_name'])->getCustomerName() : $dataToUpdate['customer_name'] ;
			 
			$openingBalance->chequeInSafe()->where('money_received.id',$id)->first()->update($dataToUpdate);
			$openingBalance->chequeInSafe()->where('money_received.id',$id)->first()->cheque->update($pivotData);
		}
		foreach($request->get(MoneyReceived::CHEQUE,[]) as $data){
			if(!isset($data['id'])){
				unset($data['id']);
				$pivotData = [
					'due_date'=>$data['due_date'],
				'drawee_bank_id'=>isset($data['drawee_bank_id']) ? $data['drawee_bank_id'] : null,
				'cheque_number'=>$data['cheque_number'],
				];
				unset($data['due_date']);
				unset($data['drawee_bank_id']);
				unset($data['cheque_number']);
				$data['customer_name'] = is_numeric($data['customer_name']) ? CustomerInvoice::find($data['customer_name'])->getCustomerName() : $data['customer_name'] ;
				
				$moneyReceived = $openingBalance->chequeInSafe()->create(array_merge($data,[
					'type'=>MoneyReceived::CHEQUE,
					'user_id'=>auth()->id()
				]));
				
				$moneyReceived->cheque()->create($pivotData);
			}
		}
		
		
		
		
		
		
		
		
		
		/**
		 * * هنا تحديث الشيكات في الخزنة
		 * * cheques under collection
		 */
		
		 $oldIdsFromDatabase = $openingBalance->chequeUnderCollections->pluck('id')->toArray();
		$idsFromRequest =array_column($request->input(MoneyReceived::CHEQUE_UNDER_COLLECTION,[]),'id') ;
	
		$elementsToDelete = array_diff($oldIdsFromDatabase,$idsFromRequest);
		$elementsToUpdate = array_intersect($idsFromRequest,$oldIdsFromDatabase);

		$openingBalance->chequeUnderCollections()->whereIn('money_received.id',$elementsToDelete)->delete();
		foreach($elementsToUpdate as $id){
			$dataToUpdate = findByKey($request->input(MoneyReceived::CHEQUE_UNDER_COLLECTION),'id',$id);
			unset($dataToUpdate['id']);
			$pivotData = [
				'due_date'=>$dataToUpdate['due_date'],
				'drawee_bank_id'=>isset($dataToUpdate['drawee_bank_id']) ? $dataToUpdate['drawee_bank_id'] : null,
				'cheque_number'=>$dataToUpdate['cheque_number'],
				'deposit_date'=>$dataToUpdate['deposit_date'] ?: null ,
				'drawl_bank_id'=>$dataToUpdate['drawl_bank_id'] ?: null ,
				'account_type'=>$dataToUpdate['account_type'] ?: null ,
				'account_number'=>$dataToUpdate['account_number'] ?: null ,
				'clearance_days'=>$dataToUpdate['clearance_days'] ?: 0 ,
			];
			foreach($pivotData as $key => $val){
				unset($dataToUpdate[$key]);
			}
		
			$dataToUpdate['customer_name'] = is_numeric($dataToUpdate['customer_name']) ? CustomerInvoice::find($dataToUpdate['customer_name'])->getCustomerName() : $dataToUpdate['customer_name'] ;
			 
			$openingBalance->chequeUnderCollections()->where('money_received.id',$id)->first()->update($dataToUpdate);
			$openingBalance->chequeUnderCollections()->where('money_received.id',$id)->first()->cheque->update($pivotData);
		}
		foreach($request->get(MoneyReceived::CHEQUE_UNDER_COLLECTION,[]) as $data){
			if(!isset($data['id'])){
				unset($data['id']);
				$pivotData = [
					'due_date'=>$data['due_date'],
					'status'=>Cheque::UNDER_COLLECTION,
					'drawee_bank_id'=>isset($data['drawee_bank_id']) ? $data['drawee_bank_id'] : null,
					'cheque_number'=>$data['cheque_number'],
					'deposit_date'=>$data['deposit_date'] ?: null ,
					'drawl_bank_id'=>$data['drawl_bank_id'] ?: null ,
					'account_type'=>$data['account_type'] ?: null ,
					'account_number'=>$data['account_number'] ?: null ,
					'clearance_days'=>$data['clearance_days'] ?: 0 ,
				];
				foreach($pivotData as $key => $val){
					unset($data[$key]);
				}
				$data['customer_name'] = is_numeric($data['customer_name']) ? CustomerInvoice::find($data['customer_name'])->getCustomerName() : $data['customer_name'] ;
				
				$moneyReceived = $openingBalance->chequeUnderCollections()->create(array_merge($data,[
					'type'=>MoneyReceived::CHEQUE,
					'user_id'=>auth()->id()
				]));
				
				$moneyReceived->cheque()->create($pivotData);
			}
		}
		
		return redirect()->route('opening-balance.index',['company'=>$company->id]);
	}
}
