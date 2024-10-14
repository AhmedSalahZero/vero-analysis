<?php 
namespace App\Traits\Models;

use App\Models\AccountType;
use App\Models\EmployeeStatement;
use App\Models\ShareholderStatement;
use App\Models\SubsidiaryCompanyStatement;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasCreditPartnerStatement 
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
		return $this->partner_type ;
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
		return $this->hasOne(EmployeeStatement::class,'money_received_id','id');
	}
	public function shareholderStatement():HasOne
	{
		return $this->hasOne(ShareholderStatement::class,'money_received_id','id');
	}
	public function subsidiaryCompanyStatement():HasOne
	{
		return $this->hasOne(SubsidiaryCompanyStatement::class,'money_received_id','id');
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
				'comment_en'=>$this->generatePartnerComment($bankNameOrBranchName,$accountType ? $accountType->getName('en') : null,$accountNumber),
				'comment_ar'=>$this->generatePartnerComment($bankNameOrBranchName,$accountType ? $accountType->getName('ar') : null,$accountNumber),
				
		];
		if($partnerType == 'is_employee'){
			$this->employeeStatement()->create($statementData);
		}
		if($partnerType == 'is_shareholder'){
			$this->shareholderStatement()->create($statementData);
		}
		if($partnerType == 'is_subsidiary_company'){
			$this->subsidiaryCompanyStatement()->create($statementData);
		}
		 
	}
	public function generatePartnerComment(string $bankNameOrBranchName , ?string $accountTypeName , ?string $accountNumber  )
	{
		if($accountTypeName){
			return __('Received In [ :bankName ] [ :accountType ] [ :accountNumber ]',['bankName'=>$bankNameOrBranchName,'accountType'=>$accountTypeName  , 'accountNumber'=>$accountNumber]);
		}
		return __('Received In [ :bankName ]',['bankName'=>$bankNameOrBranchName]);
		
		// if($accountType && $accountType->getSlug() == AccountType::CLEAN_OVERDRAFT){
			
		// }
		// if($accountType && $accountType->getSlug() == AccountType::FULLY_SECURED_OVERDRAFT){
		// 	$fullySecuredOverdraft  = FullySecuredOverdraft::findByAccountNumber($accountNumber,getCurrentCompanyId(),$financialInstitutionId);
		// 	$this->storeFullySecuredOverdraftDebitBankStatement($moneyType,$fullySecuredOverdraft,$date,$debit);
		// }
		// if($accountType && $accountType->getSlug() == AccountType::OVERDRAFT_AGAINST_COMMERCIAL_PAPER){
		// 	$overdraftAgainstCommercialPaper  = OverdraftAgainstCommercialPaper::findByAccountNumber($accountNumber,getCurrentCompanyId(),$financialInstitutionId);
		// 	$this->storeOverdraftAgainstCommercialPaperDebitBankStatement($moneyType,$overdraftAgainstCommercialPaper,$date,$debit);
		// }
		// if($accountType && $accountType->getSlug() == AccountType::OVERDRAFT_AGAINST_ASSIGNMENT_OF_CONTRACTS){
		// 	$odAgainstAssignmentOfContract  = OverdraftAgainstAssignmentOfContract::findByAccountNumber($accountNumber,getCurrentCompanyId(),$financialInstitutionId);
		// 	$this->storeOverdraftAgainstAssignmentOfContractDebitBankStatement($moneyType,$odAgainstAssignmentOfContract,$date,$debit);
		// }
		// elseif($accountType && $accountType->getSlug() == AccountType::CURRENT_ACCOUNT){
		// 	$financialInstitutionAccount = FinancialInstitutionAccount::findByAccountNumber($accountNumber,getCurrentCompanyId(),$financialInstitutionId);
		// 	$this->storeCurrentAccountDebitBankStatement($date,$debit,$financialInstitutionAccount->id);
		// }
		// elseif($this->isCashInSafe()){
		// 	$this->storeCashInSafeDebitStatement($date,$debit,$currencyName,$receivingBranchId,$exchangeRate);
		// }
	}
	
		
	
}
