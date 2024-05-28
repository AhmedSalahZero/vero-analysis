<?php

namespace App\Http\Controllers;

use App\Enums\LgTypes;
use App\Models\AccountType;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\LetterOfGuaranteeIssuance;
use App\Models\LetterOfGuaranteeStatement;
use App\Models\LgOpeningBalance;
use App\Models\Partner;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;

class LgOpeningBalancesController
{
    use GeneralFunctions;
    // use HasDebitStatements;

    public function index(Company $company, Request $request)
    {
        $financialInstitutionBanks = FinancialInstitution::onlyForCompany($company->id)->onlyBanks()->get();
        $accountTypes = AccountType::onlyCurrentAccount()->get();
        $cdOrTdAccountTypes = AccountType::onlyCdOrTdAccounts()->get();
		
        $customers = Partner::where('company_id', $company->id)->where('is_customer',1)->get()->formattedForSelect(true, 'getId', 'getName');
        $suppliers = Partner::where('company_id', $company->id)->where('is_supplier',1)->get()->formattedForSelect(true, 'getId', 'getName');
        $lgTypes  = LgTypes::getAll();
        return view('lg-opening-balance.form', [
            'company' => $company,
            'model' => $company->lgOpeningBalance,
            'customersFormatted' => $customers,
            'financialInstitutionBanks' => $financialInstitutionBanks,
            'accountTypes' => $accountTypes,
			'suppliersFormatted'=>$suppliers,
            'lgTypes'=>$lgTypes,
            'cdOrTdAccountTypes'=>$cdOrTdAccountTypes
        ]);
    }

    public function store(Request $request, Company $company)
    {

        $openingBalanceDate = $request->get('date');
        /**
         * @var LgOpeningBalance $lgOpeningBalance
         */
        $lgOpeningBalance = LgOpeningBalance::create([
            'date' => $openingBalanceDate,
            'company_id' => $company->id
        ]);
        foreach ($request->get('LgHundredPercentageCashCoverOpeningBalance') as $index => $item) {
            /**
             * @var LgOpeningBalance $lgOpeningBalance
             */
            $amount = $item['amount'] ?: 0 ;
            if($amount > 0){
                $lgType = $item['lg_type'] ;
                $currencyName = $item['currency'];
                $financialInstitutionId = $item['financial_institution_id'] ;
                $lgOpeningBalance->LgHundredPercentageCashCoverOpeningBalance()->create([
                    'amount'=>$amount ,
                    'financial_institution_id'=>$financialInstitutionId,
                    'current_account_number'=>$item['current_account_number'],
                    'lg_type'=>$lgType,
                    'lg_expiry_date'=>$item['lg_expiry_date'],
                    'currency'=>$currencyName
                ]);
                $lgOpeningBalance->handleLetterOfGuaranteeStatement($financialInstitutionId,LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER,0,$lgType,$company->id ,$openingBalanceDate ,  0,0,$amount,$currencyName,LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER_BEGINNING_BALANCE);
            }

        }


        foreach ($request->get('LgAgainstTdOrCdOpeningBalances') as $index => $item) {
            /**
             * @var LgOpeningBalance $lgOpeningBalance
             */
            $amount = $item['amount'] ?: 0 ;
            if($amount > 0){
                $lgType = $item['lg_type'] ;
                $currencyName = $item['currency'];
                $financialInstitutionId = $item['financial_institution_id'] ;
                $lgOpeningBalance->LgAgainstTdOrCdOpeningBalances()->create([
                    'amount'=>$amount ,
                    'financial_institution_id'=>$financialInstitutionId,
                    'account_type'=>$item['account_type'],
                    'account_number'=>$item['account_number'],
                    'lg_type'=>$lgType,
                    'lg_end_date'=>$item['lg_end_date'],
                    'currency'=>$currencyName
                ]);
                $lgOpeningBalance->handleLetterOfGuaranteeStatement($financialInstitutionId,LetterOfGuaranteeIssuance::AGAINST_CD_OR_TD,0,$lgType,$company->id ,$openingBalanceDate ,  0,0,$amount,$currencyName,LetterOfGuaranteeIssuance::AGAINST_CD_OR_TD_BEGINNING_BALANCE);
            }

        }


        return redirect()->route('lg-opening-balance.index', ['company' => $company->id]);
    }

    public function update(Company $company, Request $request, LgOpeningBalance $LgOpeningBalance)
    {

        /**
         * * بداية تحديث ال
         * * LgHundredPercentageCashCoverOpeningBalance
         */

         LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($LgOpeningBalance->letterOfGuaranteeStatements->where('type',LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER_BEGINNING_BALANCE));
        $LgOpeningBalance->LgHundredPercentageCashCoverOpeningBalance()->delete();
        $LgOpeningBalance->delete();

        /**
         * * نهاية تحديث ال
         * * LgHundredPercentageCashCoverOpeningBalance
         */


          /**
         * * بداية تحديث ال
         * * LgAgainstTdOrCdOpeningBalances
         */

         LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($LgOpeningBalance->letterOfGuaranteeStatements->where('type',LetterOfGuaranteeIssuance::AGAINST_CD_OR_TD_BEGINNING_BALANCE));
        $LgOpeningBalance->LgAgainstTdOrCdOpeningBalances()->delete();
        $LgOpeningBalance->delete();

        /**
         * * نهاية تحديث ال
         * * LgAgainstTdOrCdOpeningBalances
         */

         /**
          * * مشتركة بين الكل
          */
        $this->store($request,$company);

        return redirect()->route('lg-opening-balance.index', ['company' => $company->id]);
    }
}
