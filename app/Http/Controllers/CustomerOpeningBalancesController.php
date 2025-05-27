<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOpeningBalanceRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\CashInSafeStatement;
use App\Models\Cheque;
use App\Models\Company;
use App\Models\CustomerOpeningBalance;
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

class CustomerOpeningBalancesController
{
    use GeneralFunctions;
    use HasDebitStatements;

    public function index(Company $company, Request $request)
    {
        // $financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
        // $accountTypes = AccountType::onlyCashAccounts()->get();
        // $selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
        $customers = Partner::where('company_id', $company->id)->where('is_customer',1)->get()->formattedForSelect(true, 'getId', 'getName');
        // $customers = Partner::where('company_id', $company->id)->where('is_customer',1)->get()->formattedForSelect(true, 'getId', 'getName');
		// $selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;

        $banks = Bank::pluck('view_name', 'id');
        return view('customer-opening-balance.form', [
            'company' => $company,
            'model' => $company->customerOpeningBalance,
            // 'selectedBanks' => $selectedBanks,
            // 'banks' => $banks,
            'customersFormatted' => $customers,
            // 'financialInstitutionBanks' => $financialInstitutionBanks,
            // 'accountTypes' => $accountTypes,
			// 'customersFormatted'=>$customers,
			// 'selectedBranches'=>$selectedBranches
        ]);
    }

    public function store(StoreOpeningBalanceRequest $request, Company $company)
    {
		
        $openingBalanceDate = $request->get('date');
		$openingBalanceDate = Carbon::make($openingBalanceDate)->format('Y-m-d');
        $openingBalance = CustomerOpeningBalance::create([
			'date' => $openingBalanceDate,
            'company_id' => $company->id
        ]);
		
		// store opening balances
		$currentKey = 'opening-balances';
        foreach ($request->get($currentKey,[]) as $index => $openingBalanceArr) {
			$invoiceData = self::generateData($openingBalanceDate,$openingBalanceArr,$company);
			$openingBalance->customerInvoices()->create($invoiceData);
        }
		
		// store opening balances
		$currentKey = 'advanced-opening-balances';
        foreach ($request->get($currentKey,[]) as $index => $openingBalanceArr) {
			$invoiceData = self::generateAdvancedData($openingBalanceDate,$openingBalanceArr,$company);
			$openingBalance->moneyReceived()->create($invoiceData);
        } 

       
		return response()->json([
			'redirectTo'=>route('customers-opening-balance.index',['company'=>$company->id])
		]);
      
    }

public function update(Company $company, StoreOpeningBalanceRequest $request, CustomerOpeningBalance $customers_opening_balance)
    {
		
		$openingBalanceDate = $request->get('date') ;
		$openingBalanceDate = Carbon::make($openingBalanceDate)->format('Y-m-d');
        $customers_opening_balance->update([
            'date' => $openingBalanceDate,
        ]);
        /**
         * * هنا تحديث ال
         * * opening-balances
         */
		$currentKey = 'opening-balances';
        $oldIdsFromDatabase = $customers_opening_balance->customerInvoices->pluck('id')->toArray();
        $idsFromRequest = array_column($request->input($currentKey, []), 'id') ;

        $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase); // origin one
	
        foreach ($elementsToUpdate as $id) {
            $dataToUpdate = findByKey($request->input($currentKey), 'id', $id);
			$invoiceData = self::generateData($openingBalanceDate,$dataToUpdate,$company);
            $customers_opening_balance->customerInvoices()->where('customer_invoices.id', $id)->first()->update($invoiceData);
        }
        foreach ($request->get($currentKey, []) as $data) {
            if (!isset($data['id']) || (isset($data['id']) && $data['id'] == '0' )  ) {
                unset($data['id']);
				$invoiceData = self::generateData($openingBalanceDate,$data,$company);
                $customers_opening_balance->customerInvoices()->create($invoiceData);
            }
        }
		
		
		
		
		
		/**
         * * هنا تحديث ال
         * * opening-balances
         */
		$currentKey = 'advanced-opening-balances';
        $oldIdsFromDatabase = $customers_opening_balance->moneyReceived->pluck('id')->toArray();
        $idsFromRequest = array_column($request->input($currentKey, []), 'id') ;

        $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase); // origin one
	
        foreach ($elementsToUpdate as $id) {
            $dataToUpdate = findByKey($request->input($currentKey), 'id', $id);
			$invoiceData = self::generateAdvancedData($openingBalanceDate,$dataToUpdate,$company);
            $customers_opening_balance->moneyReceived()->where('money_received.id', $id)->first()->update($invoiceData);
        }
        foreach ($request->get($currentKey, []) as $data) {
            if (!isset($data['id']) || (isset($data['id']) && $data['id'] == '0' )  ) {
                unset($data['id']);
				$invoiceData = self::generateAdvancedData($openingBalanceDate,$data,$company);
                $customers_opening_balance->moneyReceived()->create($invoiceData);
            }
        }
		
		 return response()->json([
			'redirectTo'=>route('customers-opening-balance.index',['company'=>$company->id])
		]);
		
    }
	public static function generateData(string $openingBalanceDate , array $openingBalanceArr , Company $company):array 
	{
		$amount = number_unformat($openingBalanceArr['received_amount'] ?: 0) ;
            $partnerId = $openingBalanceArr['partner_id'] ?: null ;
			$currencyName = $openingBalanceArr['currency'];
			$partner = Partner::find($partnerId);
			$invoiceDueDate = Carbon::make($openingBalanceArr['invoice_due_date'])->format('Y-m-d');
            $exchangeRate = isset($openingBalanceArr['exchange_rate']) ? $openingBalanceArr['exchange_rate'] : 1  ;
			return [
				'company_id'=>$company->id ,
				'customer_id'=>$partnerId,
				'customer_name'=>$partner->getName(),
				'invoice_date'=>$openingBalanceDate,
				'invoice_due_date'=>$invoiceDueDate,
				'invoice_amount'=>$amount , 
				'exchange_rate'=>$exchangeRate,
				'currency'=>$currencyName,
				'invoice_number'=>'opening-balance'
		];
	}
	
	
	public static function generateAdvancedData(string $openingBalanceDate , array $openingBalanceArr , Company $company):array 
	{
		$amount = number_unformat($openingBalanceArr['received_amount'] ?: 0) ;
            $partnerId = $openingBalanceArr['partner_id'] ?: null ;
			$currencyName = $openingBalanceArr['currency'];
			$partner = Partner::find($partnerId);
			$invoiceDueDate = Carbon::make($openingBalanceArr['invoice_due_date'])->format('Y-m-d');
            $exchangeRate = isset($openingBalanceArr['exchange_rate']) ? $openingBalanceArr['exchange_rate'] : 1  ;
			return [
				'company_id'=>$company->id ,
				'partner_id'=>$partnerId,
				'customer_name'=>$partner->getName(),
				'invoice_date'=>$openingBalanceDate,
				'invoice_due_date'=>$invoiceDueDate,
				'invoice_amount'=>$amount , 
				'exchange_rate'=>$exchangeRate,
				'currency'=>$currencyName,
				'invoice_number'=>'opening-balance'
		];
	}
	
}
