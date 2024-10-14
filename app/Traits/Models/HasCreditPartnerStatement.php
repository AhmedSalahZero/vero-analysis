<?php 
namespace App\Traits\Models;

use App\Models\AccountType;
use App\Models\EmployeeStatement;
use App\Models\ShareholderStatement;
use App\Models\SubsidiaryCompanyStatement;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasCreditPartnerStatement 
{
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
	public function handlePartnerCreditStatement(string $partnerType , int $moneyReceivedId  ,int $companyId, string $statementDate , $amount ,string $currencyName , string $bankNameOrBranchName , AccountType $accountType , string $accountNumber ):void
	{
		$statementData = [
				'currency_name'=>$currencyName,
				'money_received_id'=>$moneyReceivedId ,
				'company_id'=>$companyId ,
				'date'=>$statementDate,
				'debit'=>0,
				'credit'=>$amount,
				'comment_en'=>$this->generateComment($bankNameOrBranchName,$accountType->getName('en'),$accountNumber),
				'comment_ar'=>$this->generateComment($bankNameOrBranchName,$accountType->getName('ar'),$accountNumber),
				
		];
		 [
			'is_employee'=>$this->employeeStatement()->create($statementData),
			'is_shareholder'=>$this->shareholderStatement()->create($statementData),
			'is_subsidiary_company'=>$this->subsidiaryCompanyStatement()->create($statementData),
		][$partnerType];
	}
	public function generateComment(string $bankNameOrBranchName , string $accountTypeName , string $accountNumber  )
	{
		return __('Received In [ :bankName ] [ :accountType ] [ :accountNumber ]',['bankName'=>$bankNameOrBranchName,'accountType'=>$accountTypeName  , 'accountNumber'=>$accountNumber]);
		
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
