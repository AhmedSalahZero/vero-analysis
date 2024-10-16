<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMoneyPaymentRequest;
use App\Http\Requests\StoreOpeningBalanceRequest;
use App\Models\AccountType;
use App\Models\Bank;
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

        $banks = Bank::pluck('view_name', 'id');

        return view('opening-balance.form', [
            'company' => $company,
            'model' => $company->openingBalance,
            'selectedBanks' => $selectedBanks,
            'banks' => $banks,
            'customersFormatted' => $customers,
            'financialInstitutionBanks' => $financialInstitutionBanks,
            'accountTypes' => $accountTypes,
			'suppliersFormatted'=>$suppliers
        ]);
    }

    public function store(StoreOpeningBalanceRequest $request, Company $company)
    {
        $openingBalanceDate = $request->get('date');
        $openingBalance = OpeningBalance::create([
            'date' => $openingBalanceDate,
            'company_id' => $company->id
        ]);
        foreach ($request->get('cash-in-safe') as $index => $cashInSaveArr) {
            /**
             * @var MoneyReceived $moneyReceived
             */
            $amount = $cashInSaveArr['received_amount'] ?: 0 ;
            $receivingBranchId = $cashInSaveArr['received_branch_id'] ?: null ;
            $exchangeRate = isset($cashInSaveArr['exchange_rate']) ? $cashInSaveArr['exchange_rate'] : 1  ;
            $openingBalance->cashInSafes()->create([
				'type'=>OpeningBalance::OPEN_BALANCE,
                'branch_id' => $receivingBranchId,
                'currency' => $cashInSaveArr['currency'],
                'exchange_rate' => $exchangeRate,
                'company_id' => $company->id,
                'debit' => $amount,
                'credit' => 0,
                'date' => $openingBalanceDate,
            ]);
			
        }
        foreach ($request->get(MoneyReceived::CHEQUE) as $index => $cheque) {
            $customer = Partner::find($cheque['customer_id'] ?: null);

            $currentAmount = $cheque['received_amount'] ?: 0 ;
            if ($currentAmount > 0) {
                $moneyReceived = $openingBalance->moneyReceived()->create([
                    'type' => MoneyReceived::CHEQUE,
                    'customer_name' => $customer ? $customer->getName() : null,
                    'received_amount' => $currentAmount,
                    'currency' => $cheque['currency'],
                    'receiving_date' => $openingBalanceDate,
                    'company_id' => $company->id,
                    'user_id' => auth()->id(),
                    'exchange_rate' => isset($cheque['exchange_rate']) ? $cheque['exchange_rate'] : 1
                ]);
                $moneyReceived->cheque()->create([
                    'cheque_number' => $cheque['cheque_number'] ?: null,
                    'drawee_bank_id' => isset($cheque['drawee_bank_id']) ? $cheque['drawee_bank_id'] : null,
                    'due_date' => $cheque['due_date'] ?: null,
                ]);
            }
        }

		
		
		
		
        foreach ($request->get(MoneyReceived::CHEQUE_UNDER_COLLECTION) as $index => $chequeUnderCollection) {
            $customer = Partner::find($chequeUnderCollection['customer_id'] ?: null);
            $currentAmount = $chequeUnderCollection['received_amount'] ?: 0 ;
            if ($currentAmount > 0) {
                $moneyReceived = $openingBalance->moneyReceived()->create([
                    'type' => MoneyReceived::CHEQUE,
                    'customer_name' => $customer ? $customer->getName() : null,
                    'received_amount' => $currentAmount,
                    'currency' => $chequeUnderCollection['currency'],
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
                ]);
				$currentUnderCollectionCheque->update([
					'updated_at'=>now()
				]);
				
            }
        }
		
		
		
		
		foreach ($request->get(MoneyPayment::PAYABLE_CHEQUE) as $index => $payableChequeArr) {
            $supplier = Partner::find($payableChequeArr['supplier_id'] ?: null);
            $currentAmount = $payableChequeArr['paid_amount'] ?: 0 ;
            if ($currentAmount > 0) {
                $moneyPayment = $openingBalance->moneyPayments()->create([
                    'type' => MoneyPayment::PAYABLE_CHEQUE,
                    'supplier_name' => $supplier ? $supplier->getName() : null,
                    'received_amount' => $currentAmount,
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
                    // 'delivery_date' => $chequeUnderCollection['delivery_date'] ?: null,
                    // 'drawl_bank_id' => $chequeUnderCollection['drawl_bank_id'] ?: null,
                    'account_type' => $payableChequeArr['account_type'] ?: null,
                    'account_number' => $payableChequeArr['account_number'] ?: null,
                ]);
				$currentPayableCheque->update([
					'updated_at'=>now()
				]);
				
            }
        }
		
		
		
		
		
		

        return redirect()->route('opening-balance.index', ['company' => $company->id]);
    }

    public function update(Company $company, Request $request, OpeningBalance $openingBalance)
    {

		
        $openingBalance->update([
            'date' => $request->get('date'),
        ]);

        /**
         * * هنا تحديث ال
         * * cash in safe
         */
        $oldIdsFromDatabase = $openingBalance->cashInSafes->pluck('id')->toArray();
        $idsFromRequest = array_column($request->input(MoneyReceived::CASH_IN_SAFE, []), 'id') ;

        $elementsToDelete = array_diff($oldIdsFromDatabase, $idsFromRequest);
        $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase);

        $openingBalance->cashInSafes()->whereIn('cash_in_safe_statements.id', $elementsToDelete)->delete();
        foreach ($elementsToUpdate as $id) {
            $dataToUpdate = findByKey($request->input(MoneyReceived::CASH_IN_SAFE), 'id', $id);
            $openingBalance->cashInSafes()->where('cash_in_safe_statements.id', $id)->first()->update($dataToUpdate);
        }
        foreach ($request->get(MoneyReceived::CASH_IN_SAFE, []) as $data) {
            if (!isset($data['id']) || (isset($data['id']) && $data['id'] == '0' )  ) {
                unset($data['id']);
                $openingBalance->cashInSafes()->create(array_merge($data, [
                    'company_id' => $company->id,
                    'type' => MoneyReceived::CASH_IN_SAFE,
                    'user_id' => auth()->id(),
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
        $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase);

        $openingBalance->chequeInSafe()->whereIn('money_received.id', $elementsToDelete)->delete();
        foreach ($elementsToUpdate as $id) {
            $dataToUpdate = findByKey($request->input(MoneyReceived::CHEQUE), 'id', $id);
            unset($dataToUpdate['id']);
            $pivotData = [
                'due_date' => $dataToUpdate['due_date'],
                'drawee_bank_id' => isset($dataToUpdate['drawee_bank_id']) ? $dataToUpdate['drawee_bank_id'] : null,
                'cheque_number' => $dataToUpdate['cheque_number'],

            ];
            unset($dataToUpdate['due_date'], $dataToUpdate['drawee_bank_id'], $dataToUpdate['cheque_number']);

            $dataToUpdate['customer_name'] = is_numeric($dataToUpdate['customer_id']) ? Partner::find($dataToUpdate['customer_id'])->getName() : $dataToUpdate['customer_id'] ;

            $openingBalance->chequeInSafe()->where('money_received.id', $id)->first()->update($dataToUpdate);
            $openingBalance->chequeInSafe()->where('money_received.id', $id)->first()->cheque->update($pivotData);
        }
        foreach ($request->get(MoneyReceived::CHEQUE, []) as $data) {
            if (!isset($data['id']) || (isset($data['id']) && $data['id'] == '0' ) ) {
                unset($data['id']);
                $pivotData = [
                    'due_date' => $data['due_date'],
                    'drawee_bank_id' => isset($data['drawee_bank_id']) ? $data['drawee_bank_id'] : null,
                    'cheque_number' => $data['cheque_number'],
                ];
                unset($data['due_date'], $data['drawee_bank_id'], $data['cheque_number']);

                $data['customer_name'] = is_numeric($data['customer_id']) ? Partner::find($data['customer_id'])->getName() : $data['customer_id'] ;

                $moneyReceived = $openingBalance->chequeInSafe()->create(array_merge($data, [
                    'type' => MoneyReceived::CHEQUE,
                    'user_id' => auth()->id()
                ]));

                $moneyReceived->cheque()->create($pivotData);
            }
        }

        /**
         * * هنا تحديث الشيكات في الخزنة
         * * cheques under collection
         */

        $oldIdsFromDatabase = $openingBalance->chequeUnderCollections->pluck('id')->toArray();
        $idsFromRequest = array_column($request->input(MoneyReceived::CHEQUE_UNDER_COLLECTION, []), 'id') ;

        $elementsToDelete = array_diff($oldIdsFromDatabase, $idsFromRequest);
        $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase);
        $openingBalance->chequeUnderCollections()->whereIn('money_received.id', $elementsToDelete)->delete();

		
        foreach ($elementsToUpdate as $id) {
            $dataToUpdate = findByKey($request->input(MoneyReceived::CHEQUE_UNDER_COLLECTION), 'id', $id);
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
            ];
            foreach ($pivotData as $key => $val) {
                unset($dataToUpdate[$key]);
            }

            $dataToUpdate['customer_name'] = is_numeric($dataToUpdate['customer_id']) ? Partner::find($dataToUpdate['customer_id'])->getName() : $dataToUpdate['customer_id'] ;

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
                ];
                foreach ($pivotData as $key => $val) {
                    unset($data[$key]);
                }
                $data['customer_name'] = is_numeric($data['customer_id']) ? Partner::find($data['customer_id'])->getName() : $data['customer_id'] ;
                $moneyReceived = $openingBalance->chequeUnderCollections()->create(array_merge($data, [
					'type' => MoneyReceived::CHEQUE,
                    'user_id' => auth()->id()
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
		 $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase);
		 $openingBalance->payableCheques()->whereIn('money_payments.id', $elementsToDelete)->delete();
 

		 foreach ($elementsToUpdate as $id) {
			 $dataToUpdate = findByKey($request->input(MoneyPayment::PAYABLE_CHEQUE), 'id', $id);
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
				 $moneyPayment = $openingBalance->payableCheques()->create(array_merge($data, [
					 'type' => MoneyPayment::PAYABLE_CHEQUE,
					 'user_id' => auth()->id(),
				 ]));
				 $payableCheque = $moneyPayment->payableCheque()->create($pivotData);
				 $payableCheque->update(['updated_at'=>now()]);
			 }
		 }
		 
		
		
        return redirect()->route('opening-balance.index', ['company' => $company->id]);
    }
}
