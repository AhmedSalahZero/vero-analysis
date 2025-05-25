<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOpeningBalanceRequest;
use App\Models\Bank;
use App\Models\Company;
use App\Models\Partner;
use App\Models\SupplierOpeningBalance;
use App\Traits\GeneralFunctions;
use App\Traits\Models\HasDebitStatements;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SupplierOpeningBalancesController
{
    use GeneralFunctions;
    use HasDebitStatements;

    public function index(Company $company, Request $request)
    {
        // $financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
        // $accountTypes = AccountType::onlyCashAccounts()->get();
        // $selectedBanks = MoneyReceived::getDrawlBanksForCurrentCompany($company->id) ;
        $suppliers = Partner::where('company_id', $company->id)->where('is_supplier',1)->get()->formattedForSelect(true, 'getId', 'getName');
        // $suppliers = Partner::where('company_id', $company->id)->where('is_supplier',1)->get()->formattedForSelect(true, 'getId', 'getName');
		// $selectedBranches =  Branch::getBranchesForCurrentCompany($company->id) ;

        $banks = Bank::pluck('view_name', 'id');
        return view('supplier-opening-balance.form', [
            'company' => $company,
            'model' => $company->supplierOpeningBalance,
            // 'selectedBanks' => $selectedBanks,
            // 'banks' => $banks,
            'suppliersFormatted' => $suppliers,
            // 'financialInstitutionBanks' => $financialInstitutionBanks,
            // 'accountTypes' => $accountTypes,
			// 'suppliersFormatted'=>$suppliers,
			// 'selectedBranches'=>$selectedBranches
        ]);
    }

    public function store(StoreOpeningBalanceRequest $request, Company $company)
    {
		
        $openingBalanceDate = $request->get('date');
		
		$openingBalanceDate = Carbon::make($openingBalanceDate)->format('Y-m-d');
        $openingBalance = SupplierOpeningBalance::create([
            'date' => $openingBalanceDate,
            'company_id' => $company->id
        ]);
		
		
        foreach ($request->get('opening-balances',[]) as $index => $openingBalanceArr) {
			$invoiceData = self::generateData($openingBalanceDate,$openingBalanceArr,$company);
			$openingBalance->supplierInvoices()->create($invoiceData);
        }
       
		return response()->json([
			'redirectTo'=>route('suppliers-opening-balance.index',['company'=>$company->id])
		]);
      
    }

public function update(Company $company, StoreOpeningBalanceRequest $request, SupplierOpeningBalance $suppliers_opening_balance)
    {
		
		$openingBalanceDate = $request->get('date') ;
		$openingBalanceDate = Carbon::make($openingBalanceDate)->format('Y-m-d');
        $suppliers_opening_balance->update([
            'date' => $openingBalanceDate,
        ]);
        /**
         * * هنا تحديث ال
         * * cash in safe
         */
        $oldIdsFromDatabase = $suppliers_opening_balance->supplierInvoices->pluck('id')->toArray();
        $idsFromRequest = array_column($request->input('opening-balances', []), 'id') ;

      //  $elementsToDelete = array_diff($oldIdsFromDatabase, $idsFromRequest);

        $elementsToUpdate = array_intersect($idsFromRequest, $oldIdsFromDatabase); // origin one
		
	//	CashInSafeStatement::deleteButTriggerChangeOnLastElement($openingBalance->supplierInvoices->whereIn('id', $elementsToDelete));
	
        foreach ($elementsToUpdate as $id) {
            $dataToUpdate = findByKey($request->input('opening-balances'), 'id', $id);
			$invoiceData = self::generateData($openingBalanceDate,$dataToUpdate,$company);
            $suppliers_opening_balance->supplierInvoices()->where('supplier_invoices.id', $id)->first()->update($invoiceData);
        }
        foreach ($request->get('opening-balances', []) as $data) {
            if (!isset($data['id']) || (isset($data['id']) && $data['id'] == '0' )  ) {
                unset($data['id']);
				$invoiceData = self::generateData($openingBalanceDate,$data,$company);
                $suppliers_opening_balance->supplierInvoices()->create($invoiceData);
            }
        }
		 return response()->json([
			'redirectTo'=>route('suppliers-opening-balance.index',['company'=>$company->id])
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
				'supplier_id'=>$partnerId,
				'supplier_name'=>$partner->getName(),
				'invoice_date'=>$openingBalanceDate,
				'invoice_due_date'=>$invoiceDueDate,
				'invoice_amount'=>$amount , 
				'exchange_rate'=>$exchangeRate,
				'currency'=>$currencyName,
				'invoice_number'=>'opening-balance'
		];
	}
}
