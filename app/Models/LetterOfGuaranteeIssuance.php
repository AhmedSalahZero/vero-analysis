<?php

namespace App\Models;

use App\Enums\LgTypes;
use App\Traits\HasBasicStoreRequest;
use App\Traits\Models\HasLetterOfGuaranteeCashCoverStatements;
use App\Traits\Models\HasLetterOfGuaranteeStatements;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterOfGuaranteeIssuance extends Model
{
	use HasBasicStoreRequest,HasLetterOfGuaranteeStatements,HasLetterOfGuaranteeCashCoverStatements;
	const LG_FACILITY = 'lg-facility';
	const AGAINST_TD ='against-td';
	const AGAINST_CD ='against-cd';
	const HUNDRED_PERCENTAGE_CASH_COVER ='hundred-percentage-cash-cover';
	const RUNNING = 'running';
	const CANCELLED = 'cancelled';
    const LG_FACILITY_BEGINNING_BALANCE = 'lg-facility-beginning-balance';
    const HUNDRED_PERCENTAGE_CASH_COVER_BEGINNING_BALANCE = 'hundred-percentage-cash-cover-beginning-balance';
    const AGAINST_CD_BEGINNING_BALANCE = 'against-cd-beginning-balance';
    const AGAINST_TD_BEGINNING_BALANCE = 'against-td-beginning-balance';
	const FOR_CANCELLATION ='for-cancellation'; // هي الفلوس اللي انت حيطتها بسبب انه عمل الغاء
	const AMOUNT_TO_BE_DECREASED ='amount-to-be-decreased'; // 
    protected $guarded = ['id'];
	public static function lgSources()
	{
		return [
			self::LG_FACILITY => __('LG Facility'),
			self::AGAINST_TD => __('Against TD'),
			self::AGAINST_CD => __('Against CD'),
			self::HUNDRED_PERCENTAGE_CASH_COVER=>__('100% Cash Cover')
		];
	}
	public function isRunning()
	{
		return $this->getStatus() === self::RUNNING;
	}
	public function isCancelled()
	{
		return $this->getStatus() === self::CANCELLED;
	}

	public function getStatus()
	{
		return $this->status ;
	}
	public function getStatusFormatted()
	{
		return camelizeWithSpace($this->getStatus());
	}
	public function getSource()
	{
		
		return $this->source ?: self::LG_FACILITY ;
	}

	public function isCertificateOfDepositSource()
	{
		$accountTypeId = $this->getCdOrTdAccountTypeId() ;
		$accountType = AccountType::find($accountTypeId);
		return $accountType && $accountType->isCertificateOfDeposit();
	}
	public function getSourceFormatted()
	{
		
		$source = $this->getSource();
		if($source == self::LG_FACILITY){
			return __('LG Facility');
		}
		if($source == self::AGAINST_CD){
			return __('Against CD');
			
		}
		if($source == self::AGAINST_TD){
			return __('Against TD');
			
		}
		return camelizeWithSpace($source);
	}
	
	public function getTransactionName()
	{
		return $this->transaction_name;
	}
	public function financialInstitutionBank()
	{
		return $this->belongsTo(FinancialInstitution::class,'financial_institution_id','id') ;
	}
	public function getFinancialInstitutionBankName()
	{
		return $this->financialInstitutionBank ? $this->financialInstitutionBank->getName() : __('N/A') ;
	}

	public function getFinancialInstitutionBankId()
	{
		return $this->financialInstitutionBank ? $this->financialInstitutionBank->getName() : __('N/A') ;
	}
	public function getLgType()
	{
		return $this->lg_type;
	}
	public function isAdvancedPayment()
	{
		return $this->getLgType() === LgTypes::ADVANCED_PAYMENT_LGS;
	}
	public function getTotalLgOutstandingBalance()
	{
		return $this->total_lg_outstanding_balance ?: 0 ;
	}
	public function getTotalLgOutstandingBalanceFormatted()
	{
		return number_format($this->getTotalLgOutstandingBalance());
	}
	public function getLgTypeOutstandingBalance()
	{
		return $this->lg_type_outstanding_balance ?: 0 ;
	}
	public function getLgTypeOutstandingBalanceFormatted()
	{
		return number_format($this->getLgTypeOutstandingBalance());
	}
	public function getLgCode()
	{
		return $this->lg_code ;
	}
	public function beneficiary()
	{
		return $this->belongsTo(Partner::class,'partner_id','id') ;
	}
	public function getBeneficiaryName()
	{
		$beneficiary = $this->beneficiary ;
		return  $beneficiary ? $beneficiary->getName(): 0 ;
	}
	public function getBeneficiaryId()
	{
		$beneficiary = $this->beneficiary ;
		return  $beneficiary ? $beneficiary->getId(): 0 ;
	}

	public function contract()
	{
		return $this->belongsTo(Contract::class , 'contract_id','id');
	}
	public function getContractName()
	{
		$contract = $this->contract ;
		return  $contract ? $contract->getName(): 0 ;
	}
	public function getContractId()
	{
		$contract = $this->contract ;
		return  $contract ? $contract->getId(): 0 ;
	}
	public function purchaseOrder()
	{
		return $this->belongsTo(PurchaseOrder::class , 'purchase_order_id','id');
	}
	public function getPurchaseOrderName()
	{
		$purchaseOrder = $this->purchaseOrder ;
		return  $purchaseOrder ? $purchaseOrder->getName(): 0 ;
	}
	public function getPurchaseOrderId()
	{
		$purchaseOrder = $this->purchaseOrder ;
		return  $purchaseOrder ? $purchaseOrder->getId(): 0 ;
	}
	public function getPurchaseOrderDate()
	{
		return $this->purchase_order_date;
	}
	public function getPurchaseOrderDateFormatted()
	{
		$purchaseOrderDate = $this->getPurchaseOrderDate() ;
		return $purchaseOrderDate ? Carbon::make($purchaseOrderDate)->format('d-m-Y'):null ;
	}
	public function setPurchaseOrderDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['purchase_order_date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];

		$this->attributes['purchase_order_date'] = $year.'-'.$month.'-'.$day;
	}
	public function getTransactionDate()
	{
		return $this->transaction_date;
	}
	public function getTransactionDateFormatted()
	{
		$transactionDate = $this->getTransactionDate() ;
		return $transactionDate ? Carbon::make($transactionDate)->format('d-m-Y'):null ;
	}
	public function setTransactionDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['transaction_date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];

		$this->attributes['transaction_date'] = $year.'-'.$month.'-'.$day;
	}
	public function getTransactionReference()
	{
		return $this->transaction_reference ;
	}

	public function getIssuanceDate()
	{
		return $this->issuance_date;
	}
	public function getIssuanceDateFormatted()
	{
		$issuanceDate = $this->getIssuanceDate() ;
		return $issuanceDate ? Carbon::make($issuanceDate)->format('d-m-Y'):null ;
	}
	public function setIssuanceDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['issuance_date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];

		$this->attributes['issuance_date'] = $year.'-'.$month.'-'.$day;
	}

	public function getLgDurationMonths()
	{
		return $this->lg_duration_months;
	}

	public function getRenewalDate()
	{
		return $this->renewal_date;
	}
	public function getRenewalDateFormatted()
	{
		$renewalDate = $this->getRenewalDate() ;
		return $renewalDate ? Carbon::make($renewalDate)->format('d-m-Y'):null ;
	}
	public function setRenewalDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['renewal_date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];

		$this->attributes['renewal_date'] = $year.'-'.$month.'-'.$day;
	}

	public function getLgAmount()
	{
		return $this->lg_amount ?: 0 ;
	}
	public function getLgAmountFormatted()
	{
		return number_format($this->getLgAmount());
	}
	public function getLgCurrency()
	{
		return $this->lg_currency ;
	}

	public function getCasCoverRate()
	{
		return $this->cash_cover_rate?:0;
	}
	public function getCashCoverRateFormatted()
	{
		return number_format($this->getCashCoverRate(),1);
	}
	public function getCashCoverAmount()
	{
		return $this->cash_cover_amount ?: 0 ;
	}
	public function getCashCoverAmountFormatted()
	{
		return number_format($this->getCashCoverAmount());
	}
	public function getCashCoverDeductedFromAccountTypeId()
	{
		return $this->cash_cover_deducted_from_account_type;
	}
	public function getCashCoverDeductedFromAccountNumber()
	{
		return $this->cash_cover_deducted_from_account_number;
	}

	public function getLgCommissionRate()
	{
		return $this->lg_commission_rate ?: 0;
	}
	public function getLgCommissionRateFormatted()
	{
		return number_format($this->getLgCommissionRate(),1);
	}
	public function getLgCommissionAmount()
	{
		return $this->lg_commission_amount ?: 0 ;
	}
	public function getLgCommissionAmountFormatted()
	{
		return number_format($this->getLgCommissionAmount());
	}
	public function getLgCommissionInterval()
	{
		return $this->lg_commission_interval ;
	}
	public function letterOfGuaranteeStatements()
	{
		return $this->hasMany(LetterOfGuaranteeStatement::class,'letter_of_guarantee_issuance_id','id');
	}
	public function letterOfGuaranteeCashCoverStatements()
	{
		return $this->hasMany(LetterOfGuaranteeCashCoverStatement::class,'letter_of_guarantee_issuance_id','id');
	}
	
	public function currentAccountCreditBankStatement()
	{
		return $this->hasOne(CurrentAccountBankStatement::class,'letter_of_guarantee_issuance_id','id')->where('is_credit',1);
	}
	public function currentAccountCreditBankStatements()
	{
		return $this->hasMany(CurrentAccountBankStatement::class,'letter_of_guarantee_issuance_id','id')->where('is_credit',1)->orderBy('full_date','desc');
	}
	
	public function currentAccountDebitBankStatement()
	{
		return $this->hasOne(CurrentAccountBankStatement::class,'letter_of_guarantee_issuance_id','id')->where('is_debit',1);
	}
	public function currentAccountDebitBankStatements()
	{
		return $this->hasMany(CurrentAccountBankStatement::class,'letter_of_guarantee_issuance_id','id')->where('is_debit',1)->orderBy('full_date','desc');
	}
	/**
	 * * علشان نجيب الاربعه مع بعض مرة واحدة
	 */
	public function currentAccountBankStatements()
	{
		return $this->hasMany(CurrentAccountBankStatement::class,'letter_of_guarantee_issuance_id','id')->orderBy('full_date','desc');
	}
	public function getCdOrTdAccountTypeId()
	{
		return $this->cd_or_td_account_type_id ?:0 ;
	}
	public function getCdOrTdAccountNumber()
	{
		return $this->cd_or_td_account_number ?: 0;
	}
	public function getCdOrTdId()
	{
		$account = AccountType::find($this->getCdOrTdAccountTypeId());
		if($account && $account->isCertificateOfDeposit() ){
			return CertificatesOfDeposit::findByAccountNumber( $this->getCdOrTdAccountNumber(),$this->company_id)->id;
		}
		if($account && $account->isTimeOfDeposit() ){
			return TimeOfDeposit::findByAccountNumber( $this->getCdOrTdAccountNumber(),$this->company_id )->id;
		}
		return 0 ;
	}
	public function advancedPaymentHistories():HasMany
	{
		return $this->hasMany(LetterOfGuaranteeIssuanceAdvancedPaymentHistory::class , 'letter_of_guarantee_issuance_id','id');
	}
	public function getLgCurrentAmount()
	{
		return $this->getLgAmount() - $this->advancedPaymentHistories->sum('amount');
	}
	public function getLgCurrentAmountFormatted()
	{
		return number_format($this->getLgCurrentAmount());
	}
	
	public function deleteAllRelations():self
	{
		// currentAccountCreditBankStatement
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($this->advancedPaymentHistories);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($this->currentAccountDebitBankStatements);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($this->currentAccountCreditBankStatements);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($this->currentAccountCreditBankStatements()->withoutGlobalScope('only_active')->get());
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($this->currentAccountBankStatements);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($this->letterOfGuaranteeStatements);
		LetterOfGuaranteeStatement::deleteButTriggerChangeOnLastElement($this->letterOfGuaranteeCashCoverStatements);
		return $this;
	}
		

}
