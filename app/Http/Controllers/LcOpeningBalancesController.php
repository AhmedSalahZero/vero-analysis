<?php

namespace App\Http\Controllers;

use App\Enums\LcTypes;
use App\Models\AccountType;
use App\Models\CertificatesOfDeposit;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\LcOpeningBalance;
use App\Models\LetterOfCreditIssuance;
use App\Models\LetterOfCreditStatement;
use App\Models\Partner;
use App\Models\TimeOfDeposit;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;

class LcOpeningBalancesController
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
        $lcTypes  = LcTypes::getAll();

        return view('lc-opening-balance.form', [
            'company' => $company,
            'model' => $company->lcOpeningBalance,
            'customersFormatted' => $customers,
            'financialInstitutionBanks' => $financialInstitutionBanks,
            'accountTypes' => $accountTypes,
			'suppliersFormatted'=>$suppliers,
            'lcTypes'=>$lcTypes,
            'cdOrTdAccountTypes'=>$cdOrTdAccountTypes
        ]);
    }

    public function store(Request $request, Company $company)
    {

        $openingBalanceDate = $request->get('date');
        /**
         * @var LcOpeningBalance $lcOpeningBalance
         */
        $lcOpeningBalance = LcOpeningBalance::create([
            'date' => $openingBalanceDate,
            'company_id' => $company->id
        ]);
        foreach ($request->get('LcHundredPercentageCashCoverOpeningBalance') as $index => $item) {
            /**
             * @var LcOpeningBalance $lcOpeningBalance
             */
            $amount = $item['amount'] ?: 0 ;
            if($amount > 0){
                $lcType = $item['lc_type'] ;
                $currencyName = $item['currency'];
                $financialInstitutionId = $item['financial_institution_id'] ;
                $lcOpeningBalance->LcHundredPercentageCashCoverOpeningBalance()->create([
                    'amount'=>$amount ,
                    'financial_institution_id'=>$financialInstitutionId,
                    'current_account_number'=>$item['current_account_number'],
                    'lc_type'=>$lcType,
                    'lc_expiry_date'=>$item['lc_expiry_date'],
                    'currency'=>$currencyName
                ]);
                $lcOpeningBalance->handleLetterOfCreditStatement($financialInstitutionId,LetterOfCreditIssuance::HUNDRED_PERCENTAGE_CASH_COVER,0,$lcType,$company->id ,$openingBalanceDate ,  0,0,$amount,$currencyName,0,0,LetterOfCreditIssuance::HUNDRED_PERCENTAGE_CASH_COVER_BEGINNING_BALANCE);
            }

        }


        foreach ($request->get('LcAgainstCertificateOfDepositOrTimeOfDepositOpeningBalances') as $index => $item) {
            /**
             * @var LcOpeningBalance $lcOpeningBalance
             */
            $amount = $item['amount'] ?: 0 ;
            if($amount > 0){
				$currentAccountNumber = $item['account_number'] ;
                $lcType = $item['lc_type'] ;
                $currencyName = $item['currency'];
                $financialInstitutionId = $item['financial_institution_id'] ;
				$accountTypeId = $item['account_type'] ;
				$accountType = AccountType::where('id',$accountTypeId)->first();
				$againstCdOrTdType = null ;
				$beginningBalanceType = null ;
				$additionalRelationData = [];
				$cdOrTdId = 0 ;
				if($accountType->isCertificateOfDeposit()){
					$againstCdOrTdType = LetterOfCreditIssuance::AGAINST_CD ;
					$beginningBalanceType = LetterOfCreditIssuance::AGAINST_CD_BEGINNING_BALANCE ;
					$additionalRelationData = [
						'type'=>LcOpeningBalance::CERTIFICATE_OF_DEPOSIT
					];
					$cdOrTdId = CertificatesOfDeposit::findByAccountNumber($currentAccountNumber,$company->id)->id ;
				}
				elseif($accountType->isTimeOfDeposit()){
					$againstCdOrTdType = LetterOfCreditIssuance::AGAINST_TD ;
					$beginningBalanceType = LetterOfCreditIssuance::AGAINST_TD_BEGINNING_BALANCE ;
					$additionalRelationData = [
						'type'=>LcOpeningBalance::TIME_OF_DEPOSIT
					];
					$cdOrTdId = TimeOfDeposit::findByAccountNumber($currentAccountNumber,$company->id)->id ;
				}
				$currentData = [
                    'amount'=>$amount ,
                    'financial_institution_id'=>$financialInstitutionId,
                    'account_type'=>$accountTypeId,
                    'account_number'=>$currentAccountNumber,
                    'lc_type'=>$lcType,
                    'lc_end_date'=>$item['lc_end_date'],
                    'currency'=>$currencyName
                ] ;
				$currentData = array_merge($currentData , $additionalRelationData);
				if($accountType->isCertificateOfDeposit()){
					$lcOpeningBalance->LcAgainstCertificateOfDepositOpeningBalances()->create($currentData);
				}
				elseif($accountType->isTimeOfDeposit()){
					$lcOpeningBalance->LcAgainstTimeOfDepositOpeningBalances()->create($currentData);
				}
				
                $lcOpeningBalance->handleLetterOfCreditStatement($financialInstitutionId,$againstCdOrTdType,0,$lcType,$company->id ,$openingBalanceDate ,  0,0,$amount,$currencyName,0,$cdOrTdId,$beginningBalanceType);
            }

        }


        return redirect()->route('lc-opening-balance.index', ['company' => $company->id]);
    }

    public function update(Company $company, Request $request, LcOpeningBalance $LcOpeningBalance)
    {

        /**
         * * بداية تحديث ال
         * * LcHundredPercentageCashCoverOpeningBalance
         */

         LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($LcOpeningBalance->letterOfCreditStatements->where('type',LetterOfCreditIssuance::HUNDRED_PERCENTAGE_CASH_COVER_BEGINNING_BALANCE));
        $LcOpeningBalance->LcHundredPercentageCashCoverOpeningBalance()->delete();
        $LcOpeningBalance->delete();

        /**
         * * نهاية تحديث ال
         * * LcHundredPercentageCashCoverOpeningBalance
         */


          /**
         * * بداية تحديث ال
         * * LcAgainstCertificateOfDepositOpeningBalances
         */

         LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($LcOpeningBalance->letterOfCreditStatements->where('type',LetterOfCreditIssuance::AGAINST_CD_BEGINNING_BALANCE));
         LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($LcOpeningBalance->letterOfCreditStatements->where('type',LetterOfCreditIssuance::AGAINST_TD_BEGINNING_BALANCE));
        $LcOpeningBalance->LcAgainstCertificateOfDepositOpeningBalances()->delete();
        $LcOpeningBalance->LcAgainstTimeOfDepositOpeningBalances()->delete();
        $LcOpeningBalance->delete();

        /**
         * * نهاية تحديث ال
         * * LcAgainstCertificateOfDepositOrTimeOfDepositOpeningBalances
         */

         /**
          * * مشتركة بين الكل
          */
        $this->store($request,$company);

        return redirect()->route('lc-opening-balance.index', ['company' => $company->id]);
    }
}
