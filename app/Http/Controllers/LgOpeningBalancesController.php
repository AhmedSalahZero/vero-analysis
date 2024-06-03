<?php

namespace App\Http\Controllers;

use App\Enums\LgTypes;
use App\Models\AccountType;
use App\Models\CertificatesOfDeposit;
use App\Models\Company;
use App\Models\FinancialInstitution;
use App\Models\LetterOfGuaranteeIssuance;
use App\Models\LetterOfGuaranteeStatement;
use App\Models\LgOpeningBalance;
use App\Models\Partner;
use App\Models\TimeOfDeposit;
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
                $lgOpeningBalance->handleLetterOfGuaranteeStatement($financialInstitutionId,LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER,0,$lgType,$company->id ,$openingBalanceDate ,  0,0,$amount,$currencyName,0,0,LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER_BEGINNING_BALANCE);
            }

        }


        foreach ($request->get('LgAgainstCertificateOfDepositOrTimeOfDepositOpeningBalances') as $index => $item) {
            /**
             * @var LgOpeningBalance $lgOpeningBalance
             */
            $amount = $item['amount'] ?: 0 ;
            if($amount > 0){
				$currentAccountNumber = $item['account_number'] ;
                $lgType = $item['lg_type'] ;
                $currencyName = $item['currency'];
                $financialInstitutionId = $item['financial_institution_id'] ;
				$accountTypeId = $item['account_type'] ;
				$accountType = AccountType::where('id',$accountTypeId)->first();
				$againstCdOrTdType = null ;
				$beginningBalanceType = null ;
				$additionalRelationData = [];
				$cdOrTdId = 0 ;
				if($accountType->isCertificateOfDeposit()){
					$againstCdOrTdType = LetterOfGuaranteeIssuance::AGAINST_CD ;
					$beginningBalanceType = LetterOfGuaranteeIssuance::AGAINST_CD_BEGINNING_BALANCE ;
					$additionalRelationData = [
						'type'=>LgOpeningBalance::CERTIFICATE_OF_DEPOSIT
					];
					$cdOrTdId = CertificatesOfDeposit::findByAccountNumber($company->id,$currentAccountNumber)->id ;
				}
				elseif($accountType->isTimeOfDeposit()){
					$againstCdOrTdType = LetterOfGuaranteeIssuance::AGAINST_TD ;
					$beginningBalanceType = LetterOfGuaranteeIssuance::AGAINST_TD_BEGINNING_BALANCE ;
					$additionalRelationData = [
						'type'=>LgOpeningBalance::TIME_OF_DEPOSIT
					];
					$cdOrTdId = TimeOfDeposit::findByAccountNumber($company->id,$currentAccountNumber)->id ;
				}
				$currentData = [
                    'amount'=>$amount ,
                    'financial_institution_id'=>$financialInstitutionId,
                    'account_type'=>$accountTypeId,
                    'account_number'=>$currentAccountNumber,
                    'lg_type'=>$lgType,
                    'lg_end_date'=>$item['lg_end_date'],
                    'currency'=>$currencyName
                ] ;
				$currentData = array_merge($currentData , $additionalRelationData);
				if($accountType->isCertificateOfDeposit()){
					$lgOpeningBalance->LgAgainstCertificateOfDepositOpeningBalances()->create($currentData);
				}
				elseif($accountType->isTimeOfDeposit()){
					$lgOpeningBalance->LgAgainstTimeOfDepositOpeningBalances()->create($currentData);
				}
				
                $lgOpeningBalance->handleLetterOfGuaranteeStatement($financialInstitutionId,$againstCdOrTdType,0,$lgType,$company->id ,$openingBalanceDate ,  0,0,$amount,$currencyName,0,$cdOrTdId,$beginningBalanceType);
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
         * * LgAgainstCertificateOfDepositOpeningBalances
         */

         LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($LgOpeningBalance->letterOfGuaranteeStatements->where('type',LetterOfGuaranteeIssuance::AGAINST_CD_BEGINNING_BALANCE));
         LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($LgOpeningBalance->letterOfGuaranteeStatements->where('type',LetterOfGuaranteeIssuance::AGAINST_TD_BEGINNING_BALANCE));
        $LgOpeningBalance->LgAgainstCertificateOfDepositOpeningBalances()->delete();
        $LgOpeningBalance->LgAgainstTimeOfDepositOpeningBalances()->delete();
        $LgOpeningBalance->delete();

        /**
         * * نهاية تحديث ال
         * * LgAgainstCertificateOfDepositOrTimeOfDepositOpeningBalances
         */

         /**
          * * مشتركة بين الكل
          */
        $this->store($request,$company);

        return redirect()->route('lg-opening-balance.index', ['company' => $company->id]);
    }
}
