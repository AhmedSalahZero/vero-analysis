<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOpeningBalanceRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\CashInSafeStatement;
use App\Models\Cheque;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\MoneyPayment;
use App\Models\MoneyReceived;
use App\Models\OpeningBalance;
use App\Models\Partner;
use App\Models\PayableCheque;
use App\Traits\GeneralFunctions;
use App\Traits\Models\HasDebitStatements;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OpeningBalancesController
{
    use GeneralFunctions;
    use HasDebitStatements;

    public function index(Company $company, Request $request)
    {
        $financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
        $accountTypes = AccountType::onlyCashAccounts()->get();
        $selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
        $customers = Partner::where('company_id', $company->id)->where('is_customer',1)->get()->formattedForSelect(true, 'getId', 'getName');
        $suppliers = Partner::where('company_id', $company->id)->where('is_supplier',1)->get()->formattedForSelect(true, 'getId', 'getName');
		$selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;

        $banks = Bank::pluck('view_name', 'id');

        return view('opening-balance.form', [
            'company' => $company,
            'model' => $company->openingBalance,
            'selectedBanks' => $selectedBanks,
            'banks' => $banks,
            'customersFormatted' => $customers,
            'financialInstitutionBanks' => $financialInstitutionBanks,
            'accountTypes' => $accountTypes,
			'suppliersFormatted'=>$suppliers,
			'selectedBranches'=>$selectedBranches
        ]);
    }

    public function store(StoreOpeningBalanceRequest $request, Company $company)
    {
		
        $openingBalanceDate = $request->get('date');
		
		$openingBalanceDate = Carbon::make($openingBalanceDate)->format('Y-m-d');
        $openingBalance = OpeningBalance::create([
            'date' => $openingBalanceDate,
            'company_id' => $company->id
        ]);
		
        foreach ($request->get('cash-in-safe',[]) as $index => $cashInSafeArr) {
            /**
             * @var MoneyReceived $moneyReceived
             */
            $amount = number_unformat($cashInSafeArr['received_amount'] ?: 0) ;
            $receivingBranchId = $cashInSafeArr['received_branch_id'] ?: null ;
            $exchangeRate = isset($cashInSafeArr['exchange_rate']) ? $cashInSafeArr['exchange_rate'] : 1  ;
		
            $openingBalance->cashInSafeStatements()->create([
				'type'=>OpeningBalance::OPEN_BALANCE,
                'branch_id' => $receivingBranchId,
                'currency' => $cashInSafeArr['currency'],
                'exchange_rate' => $exchangeRate,
                'company_id' => $company->id,
                'debit' =>$amount,
                'credit' => 0,
                'date' => $openingBalanceDate,
            ]);
			
        }
        foreach ($request->get(MoneyReceived::CHEQUE,[]) as $index => $cheque) {
            $customer = Partner::find($cheque['customer_id'] ?: null);

            $currentAmount = isset($cheque['received_amount']) ? number_unformat($cheque['received_amount']) : 0 ;
            if ($currentAmount > 0) {
                $moneyReceived = $openingBalance->moneyReceived()->create([
                    'type' => MoneyReceived::CHEQUE,
                    'customer_name' => $customer ? $customer->getName() : null,
                    'received_amount' => $currentAmount,
                    'amount_in_receiving_currency' => $currentAmount,
                    'currency' => $cheque['currency'],
                    'receiving_currency' => $cheque['currency'],
                    'receiving_date' => $openingBalanceDate,
                    'company_id' => $company->id,
                    'user_id' => auth()->id(),
                    'exchange_rate' => isset($cheque['exchange_rate']) ? $cheque['exchange_rate'] : 1
                ]);
                $moneyReceived->cheque()->create([
                    'cheque_number' => $cheque['cheque_number'] ?: null,
                    'drawee_bank_id' => isset($cheque['drawee_bank_id']) ? $cheque['drawee_bank_id'] : null,
                    'due_date' => $cheque['due_date'] ?: null,
					'company_id'=>$company->id
                ]);
            }
        }

		
		
		
		
        foreach ($request->get(MoneyReceived::CHEQUE_UNDER_COLLECTION,[]) as $index => $chequeUnderCollection) {
            $customer = Partner::find($chequeUnderCollection['customer_id'] ?: null);
            $currentAmount = isset($chequeUnderCollection['received_amount']) ? number_unformat($chequeUnderCollection['received_amount']) :  0 ;
            if ($currentAmount > 0) {
                $moneyReceived = $openingBalance->moneyReceived()->create([
                    'type' => MoneyReceived::CHEQUE,
                    'customer_name' => $customer ? $customer->getName() : null,
                    'received_amount' => $currentAmount,
					'amount_in_receiving_currency' => $currentAmount,
                    'currency' => $chequeUnderCollection['currency'],
                    'receiving_currency' => $chequeUnderCollection['currency'],
                    'receiving_date' => $openingBalanceDate,
                    'company_id' => $company->id,
                    'user_id' => auth()->id(),
                    'exchange_rate' => isset($chequeUnderCollection['exchange_rate']) ? $chequeUnderCollection['exchange_rate'] : 1
                ]);
                $currentUnderCollectionCheque = $moneyReceived->cheque()->create([
                    'status' => Cheque::UNDER_COLLECTION,
                    'cheque_number' => $chequeUnderCollection['cheque_number'] ?: null,
                    'drawee_bank_id' => isset($chequeUnderCollection['drawee_bank_id']) ? $chequeUnderCollection['drawee_bank_id'] : null,
                    'due_date' => $chequeUnderCollection['due_date'] ?: null,
                    'deposit_date' => $chequeUnderCollection['deposit_date'] ?: null,
                    'drawl_bank_id' => $chequeUnderCollection['drawl_bank_id'] ?: null,
                    'account_type' => $chequeUnderCollection['account_type'] ?: null,
                    'account_number' => $chequeUnderCollection['account_number'] ?: null,
                    'clearance_days' => $chequeUnderCollection['clearance_days'] ?: 0,
					'company_id'=>$company->id 
                ]);
				$currentUnderCollectionCheque->update([
					'updated_at'=>now()
				]);
				
            }
        }
		
		
		
		
		foreach ($request->get(MoneyPayment::PAYABLE_CHEQUE,[]) as $index => $payableChequeArr) {
            $supplier = Partner::find($payableChequeArr['supplier_id'] ?: null);
            $currentAmount = isset($payableChequeArr['paid_amount']) ? number_unformat($payableChequeArr['paid_amount']) : 0 ;
            if ($currentAmount > 0) {
                $moneyPayment = $openingBalance->moneyPayments()->create([
                    'type' => MoneyPayment::PAYABLE_CHEQUE,
                    'supplier_name' => $supplier ? $supplier->getName() : null,
                    'paid_amount' => $currentAmount,
					'amount_in_paying_currency' => $currentAmount,
                    'currency' => $payableChequeArr['currency'],
                    'delivery_date' => $openingBalanceDate,
                    'company_id' => $company->id,
                    'user_id' => auth()->id(),
                    'exchange_rate' => isset($payableChequeArr['exchange_rate']) ? $payableChequeArr['exchange_rate'] : 1
                ]);
                $currentPayableCheque = $moneyPayment->payableCheque()->create([
                    'status' => PayableCheque::PENDING,
                    'cheque_number' => $payableChequeArr['cheque_number'] ?: null,
                    'delivery_bank_id' => isset($payableChequeArr['delivery_bank_id']) ? $payableChequeArr['delivery_bank_id'] : null,
                    'due_date' => $payableChequeArr['due_date'] ?: null,
                    'delivery_date' => $openingBalanceDate ?: null,
					'company_id'=>$company->id,
                    'account_type' => $payableChequeArr['account_type'] ?: null,
                    'account_number' => $payableChequeArr['account_number'] ?: null,
                ]);
				$currentPayableCheque->update([
					'updated_at'=>now()
				]);
				
            }
        }
		
		
		
		
		
		
		return response()->json([
			'redirectTo'=>route('opening-balance.index',['company'=>$company->id])
		]);
      
    }

    public function update(Company $company, StoreOpeningBalanceRequest $request, OpeningBalance $openingBalance)
    {
		
		$openingBalanceDate = $request->get('date') ;
		$openingBalanceDate = Carbon::make($openingBalanceDate)->format('Y-m-d');
		
        $openingBalance->update([
            'date' => $openingBalanceDate,
        ]);

        /**
         * * هنا تحديث ال
         * * cash in safe
         */
        $oldIdsFromDatabase = $openingBalance->cashInSafeStatements->pluck('id')->toArray();
        $idsFromRequest = array_column($request->input(MoneyReceived::CASH_IN_SAFE, []), 'id') ;

        $elementsToDelete = array_diff($oldIdsFromDatabase, $idsFromRequest);
		// $elementsToUpdate = array_diff($idsFromRequest, $elementsToDelete); // test 

        $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase); // origin one
		
		CashInSafeStatement::deleteButTriggerChangeOnLastElement($openingBalance->cashInSafeStatements->whereIn('id', $elementsToDelete));
	
        foreach ($elementsToUpdate as $id) {
            $dataToUpdate = findByKey($request->input(MoneyReceived::CASH_IN_SAFE), 'id', $id);
			
            $openingBalance->cashInSafeStatements()->where('cash_in_safe_statements.id', $id)->first()->update(array_merge($dataToUpdate,[
				'debit'=>number_unformat($dataToUpdate['received_amount']),
				'branch_id'=>$dataToUpdate['received_branch_id'],
				'date'=>$openingBalanceDate
			]));
			
        }
        foreach ($request->get(MoneyReceived::CASH_IN_SAFE, []) as $data) {
            if (!isset($data['id']) || (isset($data['id']) && $data['id'] == '0' )  ) {
                unset($data['id']);
                $openingBalance->cashInSafeStatements()->create(array_merge($data, [
                    'company_id' => $company->id,
                    'type' => OpeningBalance::OPEN_BALANCE,
                    'user_id' => auth()->id(),
					'debit'=>number_unformat($data['received_amount']),
					'branch_id'=>$data['received_branch_id'],
					'date'=>$openingBalanceDate
                ]));
				
				
            }
        }
        /**
         * * هنا تحديث الشيكات في الخزنة
         * * ChequeInSafe
         */

        $oldIdsFromDatabase = $openingBalance->chequeInSafe->pluck('id')->toArray();
        $idsFromRequest = array_column($request->input(MoneyReceived::CHEQUE, []), 'id') ;

        $elementsToDelete = array_diff($oldIdsFromDatabase, $idsFromRequest);
        // $elementsToUpdate = array_diff($idsFromRequest, $elementsToDelete); // test 

        $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase); // origin one
	
        $openingBalance->chequeInSafe()->whereIn('money_received.id', $elementsToDelete)->delete();
        foreach ($elementsToUpdate as $id) {
            $dataToUpdate = findByKey($request->input(MoneyReceived::CHEQUE), 'id', $id);
	
		
            unset($dataToUpdate['id']);
            $pivotData = [
                'due_date' => $dataToUpdate['due_date'],
                'drawee_bank_id' => isset($dataToUpdate['drawee_bank_id']) ? $dataToUpdate['drawee_bank_id'] : null,
                'cheque_number' => $dataToUpdate['cheque_number'],
				'company_id'=>$company->id 
            ];
            unset($dataToUpdate['due_date'], $dataToUpdate['drawee_bank_id'], $dataToUpdate['cheque_number']);
			$dataToUpdate['received_amount'] = isset($dataToUpdate['received_amount']) ? number_unformat($dataToUpdate['received_amount']) : 0;
            $dataToUpdate['customer_name'] = is_numeric($dataToUpdate['customer_id']) ? Partner::find($dataToUpdate['customer_id'])->getName() : $dataToUpdate['customer_id'] ;
            $dataToUpdate['receiving_date'] =  $openingBalanceDate ;
            $dataToUpdate['company_id'] =  $company->id ;
			$dataToUpdate['receiving_currency'] = $dataToUpdate['currency'] ;
			$currentChequeInSafe = $openingBalance->chequeInSafe()->where('money_received.id', $id)->first() ;
            $currentChequeInSafe->update($dataToUpdate);
			$pivotData['money_received_id'] = $currentChequeInSafe->id ;
            $openingBalance->chequeInSafe()->where('money_received.id', $id)->first()->cheque->update($pivotData);
        }
        foreach ($request->get(MoneyReceived::CHEQUE, []) as $data) {
            if (!isset($data['id']) || (isset($data['id']) && $data['id'] == '0' ) ) {
                unset($data['id']);
                $pivotData = [
                    'due_date' => $data['due_date'],
                    'drawee_bank_id' => isset($data['drawee_bank_id']) ? $data['drawee_bank_id'] : null,
                    'cheque_number' => $data['cheque_number'],
					'company_id'=>$company->id 
                ];
                unset($data['due_date'], $data['drawee_bank_id'], $data['cheque_number']);
				$data['received_amount'] = isset($data['received_amount']) ? number_unformat($data['received_amount']) : 0;
                $data['customer_name'] = is_numeric($data['customer_id']) ? Partner::find($data['customer_id'])->getName() : $data['customer_id'] ;
                $data['receiving_date'] = $openingBalanceDate ;
                $data['receiving_currency'] = $data['currency'] ;
                $data['company_id'] = $company->id ;

                $moneyReceived = $openingBalance->chequeInSafe()->create(array_merge($data, [
                    'type' => MoneyReceived::CHEQUE,
                    'user_id' => auth()->id()
                ]));
				$pivotData['money_received_id'] = $moneyReceived->id ;
                $moneyReceived->cheque()->create($pivotData);
            }
        }

        /**
         * * هنا تحديث الشيكات اللي قيد التحصيل
         * * cheques under collection
         */

        $oldIdsFromDatabase = $openingBalance->chequeUnderCollections->pluck('id')->toArray();
        $idsFromRequest = array_column($request->input(MoneyReceived::CHEQUE_UNDER_COLLECTION, []), 'id') ;

        $elementsToDelete = array_diff($oldIdsFromDatabase, $idsFromRequest);
		// $elementsToUpdate = array_diff($idsFromRequest, $elementsToDelete); // test 

        $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase); // origin one
        $openingBalance->chequeUnderCollections()->whereIn('money_received.id', $elementsToDelete)->delete();

		
        foreach ($elementsToUpdate as $id) {
            $dataToUpdate = findByKey($request->input(MoneyReceived::CHEQUE_UNDER_COLLECTION), 'id', $id);
			$dataToUpdate['received_amount'] = isset($dataToUpdate['received_amount']) ? number_unformat($dataToUpdate['received_amount']) : 0;
            unset($dataToUpdate['id']);
            $pivotData = [
                'due_date' => $dataToUpdate['due_date'],
                'drawee_bank_id' => isset($dataToUpdate['drawee_bank_id']) ? $dataToUpdate['drawee_bank_id'] : null,
                'cheque_number' => $dataToUpdate['cheque_number'],
                'deposit_date' => $dataToUpdate['deposit_date'] ?: null,
                'drawl_bank_id' => $dataToUpdate['drawl_bank_id'] ?: null,
                'account_type' => $dataToUpdate['account_type'] ?: null,
                'account_number' => $dataToUpdate['account_number'] ?: null,
                'clearance_days' => $dataToUpdate['clearance_days'] ?: 0,
				'company_id'=>$company->id 
            ];
		
            foreach ($pivotData as $key => $val) {
				if($key != 'company_id'){
					unset($dataToUpdate[$key]);
				}
            }

            $dataToUpdate['customer_name'] = is_numeric($dataToUpdate['customer_id']) ? Partner::find($dataToUpdate['customer_id'])->getName() : $dataToUpdate['customer_id'] ;
			$dataToUpdate['receiving_date'] = $openingBalanceDate;
			$dataToUpdate['receiving_currency'] = $dataToUpdate['currency'];
			$dataToUpdate['company_id']=$company->id;
            $openingBalance->chequeUnderCollections()->where('money_received.id', $id)->first()->update(array_merge($dataToUpdate,['updated_at'=>now()]));
            $openingBalance->chequeUnderCollections()->where('money_received.id', $id)->first()->cheque->update(array_merge($pivotData,['updated_at'=>now()]));
		
        }

        foreach ($request->get(MoneyReceived::CHEQUE_UNDER_COLLECTION, []) as $data) {
            if (!isset($data['id']) || (isset($data['id']) && $data['id'] == '0')  ) {
                unset($data['id']);
                $pivotData = [
                    'due_date' => $data['due_date'],
                    'status' => Cheque::UNDER_COLLECTION,
                    'drawee_bank_id' => isset($data['drawee_bank_id']) ? $data['drawee_bank_id'] : null,
                    'cheque_number' => $data['cheque_number'],
                    'deposit_date' => $data['deposit_date'] ?: null,
                    'drawl_bank_id' => $data['drawl_bank_id'] ?: null,
                    'account_type' => $data['account_type'] ?: null,
                    'account_number' => $data['account_number'] ?: null,
                    'clearance_days' => $data['clearance_days'] ?: 0,
					'company_id'=>$company->id 
                ];
                foreach ($pivotData as $key => $val) {
                    unset($data[$key]);
                }
                $data['customer_name'] = is_numeric($data['customer_id']) ? Partner::find($data['customer_id'])->getName() : $data['customer_id'] ;
				$data['receiving_date']=$openingBalanceDate;
				$data['receiving_currency']=$data['currency'];
				$data['company_id']=$company->id;
				$data['received_amount'] = isset($data['received_amount']) ? number_unformat($data['received_amount']) : 0 ;
                $moneyReceived = $openingBalance->chequeUnderCollections()->create(array_merge($data, [
					'type' => MoneyReceived::CHEQUE,
                    'user_id' => auth()->id(),
					'company_id'=>$company->id 
                ]));
                $cheque = $moneyReceived->cheque()->create($pivotData);
				$cheque->update(['updated_at'=>now()]);
            }
        }
		
		
	
		 /**
         * * هنا تحديث ال payable cheques
         * * payable cheques
         */

		 $oldIdsFromDatabase = $openingBalance->payableCheques->pluck('id')->toArray();
		 $idsFromRequest = array_column($request->input(MoneyPayment::PAYABLE_CHEQUE, []), 'id') ;
		
		 $elementsToDelete = array_diff($oldIdsFromDatabase, $idsFromRequest);
		//  $elementsToUpdate = array_diff($idsFromRequest, $elementsToDelete); // test 

		 $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase); // origin one
		 $openingBalance->payableCheques()->whereIn('money_payments.id', $elementsToDelete)->delete();
 

		 foreach ($elementsToUpdate as $id) {
			 $dataToUpdate = findByKey($request->input(MoneyPayment::PAYABLE_CHEQUE), 'id', $id);
			 $dataToUpdate['paid_amount'] = isset($dataToUpdate['paid_amount']) ? number_unformat($dataToUpdate['paid_amount']) : 0;
			 $dataToUpdate['delivery_date'] = $openingBalanceDate ; 
			 unset($dataToUpdate['id']);
			 $pivotData = [
				 'due_date' => $dataToUpdate['due_date'],
				 'delivery_bank_id' => isset($dataToUpdate['delivery_bank_id']) ? $dataToUpdate['delivery_bank_id'] : null,
				 'cheque_number' => $dataToUpdate['cheque_number'],
				 'account_type' => $dataToUpdate['account_type'] ?: null,
				 'account_number' => $dataToUpdate['account_number'] ?: null,
			 ];
			 foreach ($pivotData as $key => $val) {
				 unset($dataToUpdate[$key]);
			 }
			 $dataToUpdate['supplier_name'] = is_numeric($dataToUpdate['supplier_id']) ? Partner::find($dataToUpdate['supplier_id'])->getName() : $dataToUpdate['supplier_id'] ;
			 $dataToUpdate['company_id'] = $company->id;
			 
			 $dataToUpdate['payment_currency'] = $dataToUpdate['currency'];
			 $dataToUpdate['amount_in_paying_currency'] = $dataToUpdate['paid_amount'];
			 $openingBalance->payableCheques()->where('money_payments.id', $id)->first()->update(array_merge($dataToUpdate,['updated_at'=>now()]));
			 $openingBalance->payableCheques()->where('money_payments.id', $id)->first()->payableCheque->update(array_merge($pivotData,['updated_at'=>now()]));
			}
	
		 foreach ($request->get(MoneyPayment::PAYABLE_CHEQUE, []) as $data) {
			 if (!isset($data['id']) || (isset($data['id']) && $data['id'] == '0')  ) {
				 unset($data['id']);
				 $pivotData = [
					 'due_date' => $data['due_date'],
					 'status' => PayableCheque::PENDING,
					 'delivery_bank_id' => isset($data['delivery_bank_id']) ? $data['delivery_bank_id'] : null,
					 'cheque_number' => $data['cheque_number'],
					 'account_type' => $data['account_type'] ?: null,
					 'account_number' => $data['account_number'] ?: null,
					];
					foreach ($pivotData as $key => $val) {
						unset($data[$key]);
					}
					$data['supplier_name'] = is_numeric($data['supplier_id']) ? Partner::find($data['supplier_id'])->getName() : $data['supplier_id'] ;
					$data['paid_amount'] = isset($data['paid_amount']) ? number_unformat($data['paid_amount']) : 0 ;
					$data['amount_in_paying_currency'] = $data['paid_amount'];
				 $moneyPayment = $openingBalance->payableCheques()->create(array_merge($data, [
					 'type' => MoneyPayment::PAYABLE_CHEQUE,
					 'user_id' => auth()->id(),
					 'payment_currency'=>$data['currency'],
					 'company_id'=>$company->id
				 ]));
				 $payableCheque = $moneyPayment->payableCheque()->create($pivotData);
				 $payableCheque->update(['updated_at'=>now()]);
			 }
		 }
		 return response()->json([
			'redirectTo'=>route('opening-balance.index',['company'=>$company->id])
		]);
		
    }
}
