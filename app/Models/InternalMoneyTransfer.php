<?php

namespace App\Models;

use App\Models\FullySecuredOverdraft;
use App\Traits\HasBasicStoreRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * * هنا عميلة تحويل الاموال من حساب بنك الي حساب بنكي اخر
 * * عن طريق بسحب كريدت من حساب احطة دبت في حساب تاني
 */
class InternalMoneyTransfer extends Model
{
	use HasBasicStoreRequest ;
	const BANK_TO_BANK = 'bank-to-bank';
	const BANK_TO_SAFE = 'bank-to-safe';
	const SAFE_TO_BANK = 'safe-to-bank';
	public static function getAllTypes()
	{
		return [
			self::BANK_TO_BANK,
			self::BANK_TO_SAFE,
			self::SAFE_TO_BANK
		];
	}
    protected $guarded = ['id'];

    public function getTransferDays()
    {
        return $this->transfer_days ?: 0 ;
    }
	public function getReceivingDateFormatted()
	{
		
		return Carbon::make($this->getTransferDate())->addDay($this->getTransferDays())->format('d-m-Y') ;
	}
    public function setTransferDateAttribute($value)
    {
        if (!$value) {
            return null ;
        }
        $date = explode('/', $value);
        if (count($date) != 3) {
            $this->attributes['transfer_date'] = $value;

            return  ;
        }
        $month = $date[0];
        $day = $date[1];
        $year = $date[2];
        $this->attributes['transfer_date'] = $year . '-' . $month . '-' . $day;
    }

    public function getTransferDate()
    {
        return $this->transfer_date ;
    }

    public function getTransferDateFormatted()
    {
        $transferDate = $this->getTransferDate() ;

        return $transferDate ? Carbon::make($transferDate)->format('d-m-Y') : null ;
    }

    public function fromBank()
    {
        return $this->belongsTo(FinancialInstitution::class, 'from_bank_id', 'id');
    }

    public function getFromBankName()
    {
        return $this->fromBank ? $this->fromBank->getName() : __('N/A');
    }

    public function getFromBankId()
    {
        return $this->fromBank ? $this->fromBank->id : 0;
    }

    public function fromAccountType()
    {
        return $this->belongsTo(AccountType::class, 'from_account_type_id');
    }

    public function getFromAccountTypeName()
    {
        return $this->fromAccountType ? $this->fromAccountType->getName() : __('N/A');
    } 
	 public function getFromAccountTypeId()
    {
        return $this->fromAccountType ? $this->fromAccountType->getId() : 0;
    }

    public function getFromAccountNumber()
    {
        return $this->from_account_number ;
    }

    public function getCurrency()
    {
        return $this->currency ;
    }
	public function getCurrencyFormatted()
    {
        return $this->getCurrency() ;
    }
    public function getAmount()
    {
        return $this->amount ?: 0;
    }
	
    public function getAmountFormatted()
    {
        return number_format($this->getAmount(), 0);
    }

    public function toBank()
    {
        return $this->belongsTo(FinancialInstitution::class, 'to_bank_id', 'id');
    }

    public function getToBankName()
    {
        return $this->toBank ? $this->toBank->getName() : __('N/A');
    }

    public function toAccountType()
    {
        return $this->belongsTo(AccountType::class, 'to_account_type_id');
    }
	public function getToAccountTypeId()
    {
        return $this->toAccountType ? $this->toAccountType->getId() : 0;
    }
    public function getToAccountTypeName()
    {
        return $this->toAccountType ? $this->toAccountType->getName() : __('N/A');
    }

    public function getToAccountNumber()
    {
        return $this->to_account_number ;
    }
	public function currentAccountBankStatements()
    {
        return $this->hasMany(CurrentAccountBankStatement::class, 'internal_money_transfer_id', 'id');
    }
    public function cleanOverdraftBankStatements()
    {
        return $this->hasMany(CleanOverdraftBankStatement::class, 'internal_money_transfer_id', 'id');
    }
	public function fullySecuredOverdraftBankStatements()
    {
        return $this->hasMany(FullySecuredOverdraftBankStatement::class, 'internal_money_transfer_id', 'id');
    }
	public function overdraftAgainstCommercialPaperBankStatements()
    {
        return $this->hasMany(overdraftAgainstCommercialPaperBankStatement::class, 'internal_money_transfer_id', 'id');
    }
	public function cashInSafeStatements():HasMany
	{
		return $this->hasMany(CashInSafeStatement::class,'internal_money_transfer_id','id');
	}
    public function deleteRelations()
    {
        $this->cleanOverdraftBankStatements->each(function (CleanOverdraftBankStatement $cleanOverdraftBankStatement) {
			$cleanOverdraftBankStatement->delete();
		});
		$this->fullySecuredOverdraftBankStatements->each(function (FullySecuredOverdraftBankStatement $fullySecuredOverdraftBankStatement) {
			$fullySecuredOverdraftBankStatement->delete();
		});
		$this->overdraftBankAgainstCommercialPaperStatements->each(function (OverdraftAgainstCommercialPaperBankStatement $overdraftAgainstCommercialPaperBankStatement) {
			$overdraftAgainstCommercialPaperBankStatement->delete();
		});
		$this->currentAccountBankStatements->each(function (CurrentAccountBankStatement $currentAccountBankStatement) {
			$currentAccountBankStatement->delete();
		});
		$this->cashInSafeStatements->each(function (CashInSafeStatement $cashInSafeStatement) {
			$cashInSafeStatement->delete();
		});
		
    }
	/**
	 * * هنا لما بنحول من بنك او الى بنك بغض النظر عن نوع الحساب
	 */
	public function handleBankTransfer(int $companyId , int $fromFinancialInstitutionId , AccountType $fromAccountType , string $fromAccountNumber ,string $transferDate  , $debitAmount , $creditAmount)
	{
		if($fromAccountType && $fromAccountType->isCurrentAccount()){
			/**
			 * @var CleanOverdraft $fromCleanOverDraft
			 */
			$fromCurrentAccount = FinancialInstitutionAccount::findByAccountNumber($fromAccountNumber,$companyId,$fromFinancialInstitutionId);
			CurrentAccountBankStatement::create([
				'financial_institution_account_id'=>$fromCurrentAccount->id ,
				'internal_money_transfer_id'=>$this->id  ,
				'company_id'=>$companyId ,
				'date' => $transferDate , 
				'credit'=>$creditAmount,
				'debit'=>$debitAmount
			]);
		}
		
		
		if($fromAccountType && $fromAccountType->isCleanOverDraftAccount()){
			/**
			 * @var CleanOverdraft $fromCleanOverDraft
			 */

			$fromCleanOverDraft = CleanOverdraft::findByAccountNumber($fromAccountNumber,$companyId,$fromFinancialInstitutionId);
			CleanOverdraftBankStatement::create([
				'type'=>CleanOverdraftBankStatement::MONEY_TRANSFER ,
				'clean_overdraft_id'=>$fromCleanOverDraft->id ,
				'internal_money_transfer_id'=>$this->id ,
				'company_id'=>$companyId ,
				'date' => $transferDate , 
				'limit' =>$fromCleanOverDraft->getLimit(),
				'credit'=>$creditAmount,
				'debit'=>$debitAmount
			]);
		}
		if($fromAccountType && $fromAccountType->isFullySecuredOverDraftAccount()){
			/**
			 * @var FullySecuredOverdraft $fromFullySecuredOverDraft
			 */

			 $fromFullySecuredOverDraft = FullySecuredOverdraft::findByAccountNumber($fromAccountNumber,$companyId,$fromFinancialInstitutionId);
			FullySecuredOverdraftBankStatement::create([
				'type'=>FullySecuredOverdraftBankStatement::MONEY_TRANSFER ,
				'fully_secured_overdraft_id'=>$fromFullySecuredOverDraft->id ,
				'internal_money_transfer_id'=>$this->id ,
				'company_id'=>$companyId ,
				'date' => $transferDate , 
				'limit' =>$fromFullySecuredOverDraft->getLimit(),
				'credit'=>$creditAmount,
				'debit'=>$debitAmount
			]);
		}
		
		if($fromAccountType && $fromAccountType->isOverDraftAgainstCommercialPaperAccount()){
			/**
			 * @var OverDraftAgainstCommercialPaper $fromOverDraftAgainstCommercialPaper
			 */

			 $fromOverDraftAgainstCommercialPaper = OverDraftAgainstCommercialPaper::findByAccountNumber($fromAccountNumber,$companyId,$fromFinancialInstitutionId);
			OverdraftAgainstCommercialPaperBankStatement::create([
				'type'=>OverdraftAgainstCommercialPaperBankStatement::MONEY_TRANSFER ,
				'overdraft_against_commercial_paper_id'=>$fromOverDraftAgainstCommercialPaper->id ,
				'internal_money_transfer_id'=>$this->id ,
				'company_id'=>$companyId ,
				'date' => $transferDate , 
				'limit' =>$fromOverDraftAgainstCommercialPaper->getLimit(),
				'credit'=>$creditAmount,
				'debit'=>$debitAmount
			]);
		}
		
		
	}
	
		
		
	// }
	/**
	 * * دي هتستخدم في الحالتين سواء من او الى
	 */
	public function handleSafeTransfer(int $companyId, string $date ,  $debitAmount , $creditAmount , int $branchId , string $currencyName , string $exchangeRate )
	{
	
				$this->cashInSafeStatements()->create([
					'type'=>CashInSafeStatement::MONEY_TRANSFER,
					'branch_id'=>$branchId ,
					'currency'=>$currencyName ,
					'exchange_rate'=>$exchangeRate,
					'company_id'=>$companyId ,
					'date'=>$date ,
					'debit'=>$debitAmount ,
					'credit'=> $creditAmount 
				]);
	}
	public function handleBankToBankTransfer( int $companyId , AccountType $fromAccountType , string $fromAccountNumber , int $fromFinancialInstitutionId , AccountType $toAccountType , string $toAccountNumber , int $toFinancialInstitutionId , string $transferDate , string $receivingDate, $transferAmount)
	{
		$this->handleBankTransfer($companyId , $fromFinancialInstitutionId ,  $fromAccountType , $fromAccountNumber , $transferDate , 0,$transferAmount);
		$this->handleBankTransfer($companyId , $toFinancialInstitutionId , $toAccountType , $toAccountNumber ,$receivingDate , $transferAmount,0);
	}
	public function handleBankToSafeTransfer( int $companyId , AccountType $fromAccountType , string $fromAccountNumber , int $fromFinancialInstitutionId , int $toBranchId , string $currencyName , string $transferDate , $transferAmount)
	{
		$this->handleBankTransfer($companyId , $fromFinancialInstitutionId ,  $fromAccountType , $fromAccountNumber , $transferDate ,0, $transferAmount);
		$this->handleSafeTransfer($companyId,$transferDate,$transferAmount,0,$toBranchId ,$currencyName,1);
	}
	public function handleSafeToBankTransfer( int $companyId , AccountType $toAccountType , string $toAccountNumber , int $toFinancialInstitutionId , int $fromBranchId , string $currencyName , string $transferDate , $transferAmount)
	{
		$this->handleSafeTransfer($companyId,$transferDate,0,$transferAmount,$fromBranchId ,$currencyName,1);
		$this->handleBankTransfer($companyId , $toFinancialInstitutionId ,  $toAccountType , $toAccountNumber , $transferDate , $transferAmount,0);
	}
	public function fromBranch()
	{
		return $this->belongsTo(Branch::class,'from_branch_id','id');
	}
	public function getFromBranchName()
	{
		return $this->fromBranch ? $this->fromBranch->getName()  : __('N/A');  
	}
	public function toBranch()
	{
		return $this->belongsTo(Branch::class,'to_branch_id','id');
	}
	public function getToBranchName()
	{
		return $this->toBranch ? $this->toBranch->getName()  : __('N/A');  
	}
}
