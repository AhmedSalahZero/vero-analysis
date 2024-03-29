<?php

namespace App\Models;

use App\Models\LetterOfGuaranteeFacilityTermAndCondition;
use App\Traits\HasBasicStoreRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LetterOfGuaranteeIssuance extends Model
{
	use HasBasicStoreRequest;
    protected $guarded = ['id'];
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
}
