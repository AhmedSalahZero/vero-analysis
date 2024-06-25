<?php

namespace App\Models;

use App\Models\FullySecuredOverdraft;
use App\Traits\HasBasicStoreRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * * هنا لو معايا عملة ورايح اغيرها وليكن مثلا من البنك وحطها في حسابي الجاري
 */
class BuyOrSellCurrency extends Model
{
	use HasBasicStoreRequest ;
	const BANK_TO_BANK = 'bank-to-bank';
	const BANK_TO_SAFE = 'bank-to-safe';
	const SAFE_TO_BANK = 'safe-to-bank';
	const SAFE_TO_SAFE = 'safe-to-safe';
	
	public static function generateComment(self $buyOrSellCurrency,string $lang)
	{
		if($buyOrSellCurrency->isBankToBank()){
			return __('From Bank :from To Bank :to',['from'=>$buyOrSellCurrency->getFromBankName(),'to'=>$buyOrSellCurrency->getToBankName()],$lang) ;
		}
		if($buyOrSellCurrency->isBankToSafe()){
			return __('From Bank :from To Safe',['from'=>$buyOrSellCurrency->getFromBankName()],$lang) ;
		}
		if($buyOrSellCurrency->isSafeToBank()){
			return __('From Safe To Bank :to',['to'=>$buyOrSellCurrency->getToBankName()],$lang) ;
		}
		if($buyOrSellCurrency->isSafeToSafe()){
			return __('From Safe To Safe',[],$lang) ;
		}
		
	}
	protected static function booted()
	{
		self::creating(function (self $buyOrSellCurrency): void {
			$buyOrSellCurrency->comment_en = self::generateComment($buyOrSellCurrency,'en');
			$buyOrSellCurrency->comment_ar = self::generateComment($buyOrSellCurrency,'ar');
		});
	}
	public function isBankToBank()
	{
		return $this->getType() == self::BANK_TO_BANK;
	}
	public function isBankToSafe()
	{
		return $this->getType() == self::BANK_TO_SAFE;
	}
	public function isSafeToBank()
	{
		return $this->getType() == self::SAFE_TO_BANK;
	}
	public function isSafeToSafe()
	{
		return $this->getType() == self::SAFE_TO_SAFE;
	}
	
	public static function getAllTypes()
	{
		return [
			self::BANK_TO_BANK => __('Bank To Bank'),
			self::BANK_TO_SAFE => __('Bank To Safe'),
			self::SAFE_TO_BANK => __('Safe To Bank'),
			self::SAFE_TO_SAFE => __('Safe To Safe')
		];
	}
    protected $guarded = ['id'];
	public function getType()
	{
		return $this->type;
	}
    // public function getTransferDays()
    // {
    //     return $this->transfer_days ?: 0 ;
    // }
	// public function getReceivingDateFormatted()
	// {
		
	// 	return Carbon::make($this->getTransferDate())->addDay($this->getTransferDays())->format('d-m-Y') ;
	// }
    public function setTransactionDateAttribute($value)
    {
        if (!$value) {
            return null ;
        }
        $date = explode('/', $value);
        if (count($date) != 3) {
            $this->attributes['transaction_date'] = $value;

            return  ;
        }
        $month = $date[0];
        $day = $date[1];
        $year = $date[2];
        $this->attributes['transaction_date'] = $year . '-' . $month . '-' . $day;
    }

    public function getTransactionDate()
    {
        return $this->transaction_date ;
    }

    public function getTransactionDateFormatted()
    {
        $transactionDate = $this->getTransactionDate() ;

        return $transactionDate ? Carbon::make($transactionDate)->format('d-m-Y') : null ;
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

    public function getCurrencyToBuy()
    {
        return $this->currency_to_buy ;
    }
	public function getCurrencyToBuyFormatted()
    {
        return $this->getCurrencyToBuy() ;
    }
	public function getCurrencyToSell()
    {
        return $this->currency_to_sell ;
    }
	public function getCurrencyToSellFormatted()
    {
        return $this->getCurrencyToSell() ;
    }
	public function getExchangeRate()
	{
		return $this->exchange_rate;
	}
    public function getAmountToSell()
    {
        return $this->currency_to_sell_amount ?: 0;
    }
	
    public function getAmountToSellFormatted()
    {
        return number_format($this->getAmountToSell(), 0);
    }
	
	public function getAmountToBuy()
    {
        return $this->currency_to_buy_amount ?: 0;
    }
	
    public function getAmountToBuyFormatted()
    {
        return number_format($this->getAmountToBuy(), 0);
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
        return $this->hasMany(CurrentAccountBankStatement::class, 'buy_or_sell_currency_id', 'id');
    }
    public function cleanOverdraftBankStatements()
    {
        return $this->hasMany(CleanOverdraftBankStatement::class, 'buy_or_sell_currency_id', 'id');
    }
	public function fullySecuredOverdraftBankStatements()
    {
        return $this->hasMany(FullySecuredOverdraftBankStatement::class, 'buy_or_sell_currency_id', 'id');
    }
	public function overdraftAgainstCommercialPaperBankStatements()
    {
        return $this->hasMany(OverdraftAgainstCommercialPaperBankStatement::class, 'buy_or_sell_currency_id', 'id');
    }
	public function overdraftAgainstAssignmentOfContractBankStatements()
    {
        return $this->hasMany(OverdraftAgainstAssignmentOfContractBankStatement::class, 'buy_or_sell_currency_id', 'id');
    }
	public function cashInSafeStatements():HasMany
	{
		return $this->hasMany(CashInSafeStatement::class,'buy_or_sell_currency_id','id');
	}
    public function deleteRelations()
    {
        $this->cleanOverdraftBankStatements->each(function (CleanOverdraftBankStatement $cleanOverdraftBankStatement) {
			$cleanOverdraftBankStatement->delete();
		});
		$this->fullySecuredOverdraftBankStatements->each(function (FullySecuredOverdraftBankStatement $fullySecuredOverdraftBankStatement) {
			$fullySecuredOverdraftBankStatement->delete();
		});
		$this->overdraftAgainstCommercialPaperBankStatements->each(function (OverdraftAgainstCommercialPaperBankStatement $overdraftAgainstCommercialPaperBankStatement) {
			$overdraftAgainstCommercialPaperBankStatement->delete();
		});
		$this->overdraftAgainstAssignmentOfContractBankStatements->each(function (OverdraftAgainstAssignmentOfContractBankStatement $odAgainstAssignmentOfContractBankStatement) {
			$odAgainstAssignmentOfContractBankStatement->delete();
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
	public function handleBankTransfer(int $companyId , int $fromFinancialInstitutionId , AccountType $fromAccountType , string $fromAccountNumber ,string $transactionDate  , $debitAmount , $creditAmount)
	{
		if($fromAccountType && $fromAccountType->isCurrentAccount()){
			/**
			 * @var CleanOverdraft $fromCleanOverdraft
			 */
			$fromCurrentAccount = FinancialInstitutionAccount::findByAccountNumber($fromAccountNumber,$companyId,$fromFinancialInstitutionId);
			CurrentAccountBankStatement::create([
				'financial_institution_account_id'=>$fromCurrentAccount->id ,
				'buy_or_sell_currency_id'=>$this->id  ,
				'company_id'=>$companyId ,
				'date' => $transactionDate , 
				'credit'=>$creditAmount,
				'debit'=>$debitAmount
			]);
		}
		
		
		if($fromAccountType && $fromAccountType->isCleanOverdraftAccount()){
			/**
			 * @var CleanOverdraft $fromCleanOverdraft
			 */

			$fromCleanOverdraft = CleanOverdraft::findByAccountNumber($fromAccountNumber,$companyId,$fromFinancialInstitutionId);
			CleanOverdraftBankStatement::create([
				'type'=>CleanOverdraftBankStatement::MONEY_TRANSFER ,
				'clean_overdraft_id'=>$fromCleanOverdraft->id ,
				'buy_or_sell_currency_id'=>$this->id ,
				'company_id'=>$companyId ,
				'date' => $transactionDate , 
				'limit' =>$fromCleanOverdraft->getLimit(),
				'credit'=>$creditAmount,
				'debit'=>$debitAmount
			]);
		}
		if($fromAccountType && $fromAccountType->isFullySecuredOverdraftAccount()){
			/**
			 * @var FullySecuredOverdraft $fromFullySecuredOverdraft
			 */

			 $fromFullySecuredOverdraft = FullySecuredOverdraft::findByAccountNumber($fromAccountNumber,$companyId,$fromFinancialInstitutionId);
			FullySecuredOverdraftBankStatement::create([
				'type'=>FullySecuredOverdraftBankStatement::MONEY_TRANSFER ,
				'fully_secured_overdraft_id'=>$fromFullySecuredOverdraft->id ,
				'buy_or_sell_currency_id'=>$this->id ,
				'company_id'=>$companyId ,
				'date' => $transactionDate , 
				'limit' =>$fromFullySecuredOverdraft->getLimit(),
				'credit'=>$creditAmount,
				'debit'=>$debitAmount
			]);
		}
		
		if($fromAccountType && $fromAccountType->isOverdraftAgainstCommercialPaperAccount()){
			/**
			 * @var OverdraftAgainstCommercialPaper $fromOverdraftAgainstCommercialPaper
			 */

			 $fromOverdraftAgainstCommercialPaper = OverdraftAgainstCommercialPaper::findByAccountNumber($fromAccountNumber,$companyId,$fromFinancialInstitutionId);
			OverdraftAgainstCommercialPaperBankStatement::create([
				'type'=>OverdraftAgainstCommercialPaperBankStatement::MONEY_TRANSFER ,
				'overdraft_against_commercial_paper_id'=>$fromOverdraftAgainstCommercialPaper->id ,
				'buy_or_sell_currency_id'=>$this->id ,
				'company_id'=>$companyId ,
				'date' => $transactionDate , 
				'limit' =>$fromOverdraftAgainstCommercialPaper->getLimit(),
				'credit'=>$creditAmount,
				'debit'=>$debitAmount
			]);
		}
		
		if($fromAccountType && $fromAccountType->isOverdraftAgainstAssignmentOfContractAccount()){
			/**
			 * @var OverdraftAgainstAssignmentOfContract $fromOverdraftAgainstAssignmentOfContract
			 */

			 $fromOverdraftAgainstAssignmentOfContract = OverdraftAgainstAssignmentOfContract::findByAccountNumber($fromAccountNumber,$companyId,$fromFinancialInstitutionId);
			OverdraftAgainstAssignmentOfContractBankStatement::create([
				'type'=>OverdraftAgainstAssignmentOfContractBankStatement::MONEY_TRANSFER ,
				'overdraft_against_assignment_of_contract_id'=>$fromOverdraftAgainstAssignmentOfContract->id ,
				'buy_or_sell_currency_id'=>$this->id ,
				'company_id'=>$companyId ,
				'date' => $transactionDate , 
				'limit' =>$fromOverdraftAgainstAssignmentOfContract->getLimit(),
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
	public function handleBankToBankTransfer( int $companyId , AccountType $fromAccountType , string $fromAccountNumber , int $fromFinancialInstitutionId , AccountType $toAccountType , string $toAccountNumber , int $toFinancialInstitutionId , string $transactionDate , string $receivingDate, $transferFromAmount,$transferToAmount = null )
	{
		$this->handleBankTransfer($companyId , $fromFinancialInstitutionId ,  $fromAccountType , $fromAccountNumber , $transactionDate , 0,$transferFromAmount);
		$this->handleBankTransfer($companyId , $toFinancialInstitutionId , $toAccountType , $toAccountNumber ,$receivingDate , $transferToAmount,0);
	}
	public function handleBankToSafeTransfer( int $companyId , AccountType $fromAccountType , string $fromAccountNumber , int $fromFinancialInstitutionId , int $toBranchId ,string $currencyToBuyName , string $transactionDate , $transferFromAmount,$transferToAmount)
	{
		$this->handleBankTransfer($companyId , $fromFinancialInstitutionId ,  $fromAccountType , $fromAccountNumber , $transactionDate ,0, $transferFromAmount);
		$this->handleSafeTransfer($companyId,$transactionDate,$transferToAmount,0,$toBranchId ,$currencyToBuyName,1);
	}
	public function handleSafeToBankTransfer( int $companyId , AccountType $toAccountType , string $toAccountNumber , int $toFinancialInstitutionId , int $fromBranchId , string $currencyToBuyName , string $transactionDate , $transferFromAmount,$transferToAmount)
	{
		$this->handleSafeTransfer($companyId,$transactionDate,0,$transferFromAmount,$fromBranchId ,$currencyToBuyName,1);
		$this->handleBankTransfer($companyId , $toFinancialInstitutionId ,  $toAccountType , $toAccountNumber , $transactionDate , $transferToAmount,0);
	}
	public function handleSafeToSafeTransfer( int $companyId , int $fromBranchId , string $currencyToBuyName , int $toBranchId , string $currencyToSellName , $exchangeRate , string $transactionDate , $transferFromAmount,$transferToAmount)
	{
		$this->handleSafeTransfer($companyId,$transactionDate,0,$transferFromAmount,$fromBranchId ,$currencyToBuyName,1);
		$this->handleSafeTransfer($companyId,$transactionDate,$transferToAmount,0,$toBranchId ,$currencyToSellName,$exchangeRate);
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
	public function getToBranchId()
	{
		return $this->toBranch ? $this->toBranch->id  :0;  
	}
	public function getChequeNumber()
	{
		return $this->cheque_number ; 
	}
}
