<?php 
namespace App\Traits\Models;

use App\Models\AccountType;
use App\Models\EmployeeStatement;
use App\Models\MoneyPayment;
use App\Models\MoneyReceived;
use App\Models\ShareholderStatement;
use App\Models\SubsidiaryCompanyStatement;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * * دي ال 
 * * Statement 
 * * الخاصة بالشركاء زي
 * * employees , shareholders  , subsidiary company
 */
trait HasPartnerStatement 
{
	public function deletePartnerStatement()
	{
		if($this->isEmployee()){
			$this->employeeStatement->delete();
		}
		if($this->isShareholder()){
			$this->shareholderStatement->delete();
		}
		if($this->isSubsidiaryCompany()){
			$this->subsidiaryCompanyStatement->delete();
		}
		
	}
	public function getPartnerType()
	{
		$partnerType = $this->partner_type ;
		if(!$partnerType){
			if($this instanceof MoneyReceived){
				return 'is_customer';
			}
			if($this instanceof MoneyPayment){
				return 'is_supplier';
			}
		}
		return $partnerType ;
	}
	public function getPartnerTypeFormatted()
	{
		$partnerType = $this->getPartnerType();
		if($partnerType == 'is_customer'){
			return __('Customer');
		}
		if($partnerType == 'is_supplier'){
			return __('Supplier');
		}
		if($partnerType == 'is_employee'){
			return __('Employee');
		}
		if($partnerType == 'is_shareholder'){
			return __('Shareholder');
		}
		if($partnerType == 'is_subsidiary_company'){
			return __('Subsidiary Company');
		}
		throw new \Exception('Custom Exception .. This Partner Type Not Allowed [ ' . $partnerType .' ]');
	}
	public function isEmployee()
	{
		return $this->getPartnerType() == 'is_employee';
	}
	public function isShareholder()
	{
		return $this->getPartnerType() == 'is_shareholder';
	}
	public function isSubsidiaryCompany()
	{
		return $this->getPartnerType() == 'is_subsidiary_company';
	}
	public function employeeStatement():HasOne
	{
		return $this->hasOne(EmployeeStatement::class,$this->getForeignKeyName(),'id');
	}
	public function shareholderStatement():HasOne
	{
		return $this->hasOne(ShareholderStatement::class,$this->getForeignKeyName(),'id');
	}
	public function subsidiaryCompanyStatement():HasOne
	{
		return $this->hasOne(SubsidiaryCompanyStatement::class,$this->getForeignKeyName(),'id');
	}
	public function handlePartnerCreditStatement(string $partnerType , int $partnerId , int $moneyReceivedId  ,int $companyId, string $statementDate , $amount ,string $currencyName , string $bankNameOrBranchName , ?AccountType $accountType , ?string $accountNumber ):void
	{
		$statementData = [
				'currency_name'=>$currencyName,
				'money_received_id'=>$moneyReceivedId ,
				'company_id'=>$companyId ,
				'date'=>$statementDate,
				'partner_id'=>$partnerId,
				'debit'=>0,
				'credit'=>$amount,
				'comment_en'=>$this->generatePartnerCreditComment($bankNameOrBranchName,$accountType ? $accountType->getName('en') : null,$accountNumber),
				'comment_ar'=>$this->generatePartnerCreditComment($bankNameOrBranchName,$accountType ? $accountType->getName('ar') : null,$accountNumber),
				
		];
		if($partnerType == 'is_employee'){
			$this->employeeStatement()->create($statementData);
		}
		elseif($partnerType == 'is_shareholder'){
			$this->shareholderStatement()->create($statementData);
		}
		elseif($partnerType == 'is_subsidiary_company'){
			$this->subsidiaryCompanyStatement()->create($statementData);
		}
		 
	}
	public function handlePartnerDebitStatement(string $partnerType , int $partnerId , int $moneyPaymentId  ,int $companyId, string $statementDate , $amount ,string $currencyName , string $bankNameOrBranchName , ?AccountType $accountType , ?string $accountNumber ):void
	{
		$statementData = [
				'currency_name'=>$currencyName,
				'money_payment_id'=>$moneyPaymentId ,
				'company_id'=>$companyId ,
				'date'=>$statementDate,
				'partner_id'=>$partnerId,
				'debit'=>$amount,
				'credit'=>0,
				'comment_en'=>$this->generatePartnerDebitComment($bankNameOrBranchName,$accountType ? $accountType->getName('en') : null,$accountNumber),
				'comment_ar'=>$this->generatePartnerDebitComment($bankNameOrBranchName,$accountType ? $accountType->getName('ar') : null,$accountNumber),
				
		];
		if($partnerType == 'is_employee'){
			$this->employeeStatement()->create($statementData);
		}
		elseif($partnerType == 'is_shareholder'){
			$this->shareholderStatement()->create($statementData);
		}
		elseif($partnerType == 'is_subsidiary_company'){
			$this->subsidiaryCompanyStatement()->create($statementData);
		}
		 
	}
	public function generatePartnerCreditComment(string $bankNameOrBranchName , ?string $accountTypeName , ?string $accountNumber  )
	{
		if($accountTypeName){
			return __('Received In [ :bankName ] [ :accountType ] [ :accountNumber ]',['bankName'=>$bankNameOrBranchName,'accountType'=>$accountTypeName  , 'accountNumber'=>$accountNumber]);
		}
		return __('Received In [ :bankName ]',['bankName'=>$bankNameOrBranchName]);
	}
	public function generatePartnerDebitComment(string $bankNameOrBranchName , ?string $accountTypeName , ?string $accountNumber  )
	{
		if($accountTypeName){
			return __('Paid From [ :bankName ] [ :accountType ] [ :accountNumber ]',['bankName'=>$bankNameOrBranchName,'accountType'=>$accountTypeName  , 'accountNumber'=>$accountNumber]);
		}
		return __('Paid From [ :bankName ]',['bankName'=>$bankNameOrBranchName]);
	}
		
	
}
