<?php

namespace App\Models;

use App\Traits\HasBasicStoreRequest;
use App\Traits\HasCompany;
use App\Traits\Models\HasCommissionStatements;
use App\Traits\Models\HasDeleteButTriggerChangeOnLastElement;
use App\Traits\Models\HasForeignExchangeGainOrLoss;
use App\Traits\Models\HasLetterOfCreditCashCoverStatements;
use App\Traits\Models\HasLetterOfCreditStatements;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterOfCreditIssuance extends Model
{
	use HasBasicStoreRequest,HasCompany,HasForeignExchangeGainOrLoss,HasCommissionStatements,HasLetterOfCreditStatements,HasLetterOfCreditCashCoverStatements,HasDeleteButTriggerChangeOnLastElement;
	const LC_FACILITY = 'lc-facility';
	const AGAINST_TD ='against-td';
	const AGAINST_CD ='against-cd';
	const HUNDRED_PERCENTAGE_CASH_COVER ='hundred-percentage-cash-cover';
	const RUNNING = 'running';
	const PAID = 'paid';
	const OPENING_BALANCE = 'opening-balance';
	const NEW_ISSUANCE = 'new-issuance';
    const LC_FACILITY_BEGINNING_BALANCE = 'lc-facility-beginning-balance';
    const HUNDRED_PERCENTAGE_CASH_COVER_BEGINNING_BALANCE = 'hundred-percentage-cash-cover-beginning-balance';
    const AGAINST_CD_BEGINNING_BALANCE = 'against-cd-beginning-balance';
    const AGAINST_TD_BEGINNING_BALANCE = 'against-td-beginning-balance';
	const FOR_PAID ='for-paid'; // هي الفلوس اللي انت حيطتها بسبب انه عمل تاكيد انه دفع
	const AMOUNT_TO_BE_DECREASED ='amount-to-be-decreased'; // 
    protected $guarded = ['id'];
	
	public function getCategoryName():string 
	{
		return $this->category_name;
	}
	public function isOpeningBalance():bool
	{
		return $this->getCategoryName() == self::OPENING_BALANCE;
	}
	public function lcFeesAndCommissionAccount()
	{
		return $this->belongsTo(FinancialInstitutionAccount::class,'lc_fees_and_commission_account_id','id');
	}
	public function getFeesAndCommissionAccountId():int
	{
		return $this->lcFeesAndCommissionAccount ? $this->lcFeesAndCommissionAccount->id : 0 ;
	}
	public function getFeesAndCommissionAccountTypeId()
	{
		return $this->lc_fees_and_commission_account_type;
	}
	public static function getCategories():array 
	{
		return [
			self::NEW_ISSUANCE=>__('New Issuance'),
			self::OPENING_BALANCE=>__('Opening Balance')
		];
	}
	public static function lcSources()
	{
		return [
			self::LC_FACILITY => __('LC Facility'),
			self::AGAINST_TD => __('Against TD'),
			self::AGAINST_CD => __('Against CD'),
			self::HUNDRED_PERCENTAGE_CASH_COVER=>__('100% Cash Cover')
		];
	}
	public function isRunning()
	{
		return $this->getStatus() === self::RUNNING;
	}
	public function isPaid()
	{
		return $this->getStatus() === self::PAID;
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
		
		return $this->source ?: self::LC_FACILITY ;
	}

	public function isCertificateOfDepositSource()
	{
		$accountTypeId = $this->getCdOrTdAccountTypeId() ;
		$accountType = AccountType::find($accountTypeId);
		return $accountType && $accountType->isCertificateOfDeposit();
	}
	public function getSourceFormatted()
	{
		return self::lcSources()[$this->getSource()];
		
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
	public function getLcType()
	{
		return $this->lc_type;
	}
	public function letterOfCreditFacility()
	{
		return $this->belongsTo(LetterOfCreditFacility::class,'lc_facility_id','id');
	}	
	public function getLcFacilityLimit()
	{
		return $this->letterOfCreditFacility ? $this->letterOfCreditFacility->getLimit():0;
	}
	public function getLcFacilityId()
	{
		return $this->letterOfCreditFacility ? $this->letterOfCreditFacility->id:0;
	}
	public function getLcFacilityName()
	{
		return $this->letterOfCreditFacility ? $this->letterOfCreditFacility->getName(): __('N/A');
	}
	public function getTotalLcOutstandingBalance()
	{
		return $this->total_lc_outstanding_balance ?: 0 ;
	}
	public function getTotalLcOutstandingBalanceFormatted()
	{
		return number_format($this->getTotalLcOutstandingBalance());
	}
	public function getLcTypeOutstandingBalance()
	{
		return $this->lc_type_outstanding_balance ?: 0 ;
	}
	public function getLcTypeOutstandingBalanceFormatted()
	{
		return number_format($this->getLcTypeOutstandingBalance());
	}
	public function getLcCode()
	{
		return $this->lc_code ;
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
	public function getSupplierName()
	{
		return $this->getBeneficiaryName();
	}
	public function supplier()
	{
		return $this->beneficiary();
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

	public function getLcDurationMonths()
	{
		return $this->lc_duration_months;
	}

	public function getDueDate()
	{
		return $this->due_date;
	}
	public function getDueDateFormatted()
	{
		$dueDate = $this->getDueDate() ;
		return $dueDate ? Carbon::make($dueDate)->format('d-m-Y'):null ;
	}
	public function setDueDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['due_date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];

		$this->attributes['due_date'] = $year.'-'.$month.'-'.$day;
	}

	public function getLcAmount():float
	{
		return $this->lc_amount ?: 0 ;
	}
	public function getLcAmountFormatted()
	{
		return number_format($this->getLcAmount());
	}
	public function getLcCurrency()
	{
		return $this->lc_currency ;
	}
	public function getCdOrTdCurrencyCurrency()
	{
		return $this->cd_or_td_currency;
	}
	public function getLcCashCoverCurrency()
	{
		return $this->lc_cash_cover_currency ;
	}
	public function getLcCurrentAmount()
	{
		return $this->getLcAmount();
	}
	public function getLcCurrentAmountFormatted()
	{
		return number_format($this->getLcCurrentAmount());
	}
	
	public function getCashCoverRate()
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
	public function getCashCoverDeductedFromAccountId()
	{
		return $this->cash_cover_deducted_from_account_id ?: $this->lc_fees_and_commission_account_id;
	}
	public function getInterestRate()
	{
		return $this->interest_rate ?: 0;
	}

	public function getLcCommissionRate()
	{
		return $this->lc_commission_rate ?: 0;
	}
	public function getLcCommissionRateFormatted()
	{
		return number_format($this->getLcCommissionRate(),1);
	}
	public function getLcCommissionAmount()
	{
		return $this->lc_commission_amount ?: 0 ;
	}
	public function getLcCommissionAmountFormatted()
	{
		return number_format($this->getLcCommissionAmount());
	}
	
	// public function getLcCommissionInterval()
	// {
	// 	return $this->lc_commission_interval ;
	// }
	public function letterOfCreditStatements()
	{
		return $this->hasMany(LetterOfCreditStatement::class,'letter_of_credit_issuance_id','id')->orderBy('full_date','desc');
	}
	public function letterOfCreditCashCoverStatements()
	{
		return $this->hasMany(LetterOfCreditCashCoverStatement::class,'letter_of_credit_issuance_id','id')->orderBy('full_date','desc');
	}
	public function lcOverdraftCreditBankStatement()
	{
		return $this->hasOne(LcOverdraftBankStatement::class,'lc_issuance_id','id')->where('is_credit',1)->orderBy('full_date','desc');
	}
	public function lcOverdraftBankStatements()
	{
		return $this->hasMany(LcOverdraftBankStatement::class,'lc_issuance_id','id')->orderBy('full_date','desc');
	}
	
	public function handleLcCreditBankStatement(int $lcFacilityId,string $moneyType ,$limit , string $date , $paidAmount,$source)
	{
		return $this->lcOverdraftBankStatements()->create([
			'source'=>$source,
			'type'=>$moneyType ,
			'lc_issuance_id'=>$this->id ,
			'lc_facility_id'=>$lcFacilityId,
			'company_id'=>$this->company_id ,
			'date'=>$date,
			'limit'=>$limit,
			'beginning_balance'=>0 ,
			'debit'=>0,
			'credit'=>$paidAmount
		]);
	}

	public function currentAccountCreditBankStatement()
	{
		return $this->hasOne(CurrentAccountBankStatement::class,'letter_of_Credit_issuance_id','id')->where('is_credit',1);
	}
	public function currentAccountCreditBankStatements()
	{
		return $this->hasMany(CurrentAccountBankStatement::class,'letter_of_Credit_issuance_id','id')->where('is_credit',1)->orderBy('full_date','desc');
	}
	
	public function currentAccountDebitBankStatement()
	{
		return $this->hasOne(CurrentAccountBankStatement::class,'letter_of_credit_issuance_id','id')->where('is_debit',1);
	}
	public function currentAccountDebitBankStatements()
	{
		return $this->hasMany(CurrentAccountBankStatement::class,'letter_of_credit_issuance_id','id')->where('is_debit',1)->orderBy('full_date','desc');
	}
	/**
	 * * علشان نجيب الاربعه مع بعض مرة واحدة
	 */
	public function currentAccountBankStatements()
	{
		return $this->hasMany(CurrentAccountBankStatement::class,'letter_of_Credit_issuance_id','id')->orderBy('full_date','desc');
	}
	public function getCdOrTdAccountTypeId()
	{
		return $this->cd_or_td_account_type_id ?:0 ;
	}
	
	public function getCdOrTdId()
	{
		return $this->cd_or_td_id;
	}
	
	public function deleteAllRelations():self
	{
		
		PaymentSettlement::deleteButTriggerChangeOnLastElement($this->settlements);
		CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($this->currentAccountDebitBankStatements);
		CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($this->currentAccountCreditBankStatements);
		CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($this->currentAccountCreditBankStatements()->withoutGlobalScope('only_active')->get());
		CurrentAccountBankStatement::deleteButTriggerChangeOnLastElement($this->currentAccountBankStatements);
		LetterOfCreditStatement::deleteButTriggerChangeOnLastElement($this->letterOfCreditStatements);
		LetterOfCreditCashCoverStatement::deleteButTriggerChangeOnLastElement($this->letterOfCreditCashCoverStatements);
		LcOverdraftBankStatement::deleteButTriggerChangeOnLastElement($this->lcOverdraftBankStatements);
		return $this;
	}	
	public function expenses()
	{
		return $this->hasMany(LcIssuanceExpense::class , 'lc_issuance_id','id');
	}
	public function getFinancialInstitutionId()
	{
		return $this->financial_institution_id ;
	}	
	public function getRemainingBalance()
	{
		$lastBankStatement = $this->lcOverdraftBankStatements->first() ;
		return  $lastBankStatement ? $lastBankStatement->end_balance : 0 ;
	}	
	public function getExchangeRate()
	{
		return $this->exchange_rate ?: 1 ;
	}
	public function getLcAmountInMainCurrency()
	{
		return $this->getExchangeRate() * $this->getLcAmount();
	}
	public function getAmountInMainCurrencyFormatted()
	{
		return number_format($this->getLcAmountInMainCurrency());
	}
	public function settlements():HasMany
	{
		return $this->hasMany(PaymentSettlement::class,'letter_of_Credit_issuance_id');
	}
	public function getTdOrCdCurrency(string $source,int $companyId)
	{
		$tdOrCdCurrencyName = null ;
		if($source == LetterOfCreditIssuance::AGAINST_CD){
				$currentCertificateOfDeposit = CertificatesOfDeposit::find($this->cd_or_td_id);
				$tdOrCdCurrencyName = $currentCertificateOfDeposit->getCurrency();
		}
		elseif($source == LetterOfCreditIssuance::AGAINST_TD){
				$currentTimeOfDeposit = TimeOfDeposit::find($this->cd_or_td_id);
				$tdOrCdCurrencyName = $currentTimeOfDeposit->getCurrency();
		}
		return $tdOrCdCurrencyName;
	}	
	
	public function settlementAllocations()
	{
		return $this->hasMany(SettlementAllocation::class,'letter_of_credit_issuance_id','id');
	}
	public function storeNewSettlementAfterDeleteOldOne(SupplierInvoice $supplierInvoice , Company $company)
	{
		$this->settlements->each(function(PaymentSettlement $settlement){
			$settlement->delete();
		});
		$this->settlements()->create([
			'invoice_number'=>$supplierInvoice->getInvoiceNumber(),
			'invoice_id'=>$supplierInvoice->id,
			'partner_id'=>$supplierInvoice->getPartnerId(),
			'supplier_name'=>$supplierInvoice->getSupplierName(),
			'withhold_amount'=>0,
			'company_id'=>$company->id ,
			'settlement_amount'=>$this->getLcAmount()
		]);
	}
	public function storeNewAllocationAfterDeleteOldOne(array $allocations)
	{
		$this->settlementAllocations()->delete();
		$supplierInvoice = SupplierInvoice::find(Request('supplier_invoice_id'));
		$invoiceNumber =$supplierInvoice->getInvoiceNumber();
		foreach($allocations as $index => $allocationArr){
			$partnerId = $allocationArr['partner_id'] ?? 0 ;
			$contractId = $allocationArr['contract_id'] ?? 0 ;
			$allocationAmount = $allocationArr['allocation_amount'] ?? 0 ;
			if($allocationAmount>0){
				$this->settlementAllocations()->create([
					'allocation_amount'=>$allocationAmount,
					'contract_id'=>$contractId,
					'partner_id'=>$partnerId ,
					'invoice_number'=>$invoiceNumber
				]);
			}
		}
	}
	public function getIssuanceFees()
	{
		return $this->issuance_fees ;
	}	
	
	public function getNewPoNumber()
	{
		return $this->purchaseOrder ? $this->purchaseOrder->getNumber() :'';
	}
	public function getContractType()
	{
		return $this->contract_type ;
	}
	public function getPaymentDate()
	{
		return $this->payment_date;
	}
	public function getDate()
	{
		return $this->getPaymentDate();
	}
	public function getReceivingOrPaymentMoneyDateFormatted()
	{
		return Carbon::make($this->getPaymentDate())->format('d-m-Y');
	}
	public function getType()
	{
		return 'lc-settlement';
	}
	public function getNumber()
	{
		return $this->getLcCode();
	}
	public function getAmountInInvoiceCurrency()
	{
		return $this->getLcAmount();
	}
	public function getInvoiceCurrency()
	{
		return $this->getLcCurrency();
	}
	public function getReceivingOrPaymentCurrency()
	{
		return $this->getLcCurrency();
	}
	public function getTotalWithholdAmount()
	{
		return 0;
	}
	public function getTotalWithholdInInvoiceExchangeRate()
	{
		return 0;
	}
	public function getAmountForMainCurrency()
	{
		return $this->getLcAmount() * $this->getExchangeRate();
	}
	
}
