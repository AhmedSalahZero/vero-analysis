<?php

namespace App\Models;

use App\Traits\HasBasicStoreRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * * هنا عميلة تحويل الاموال من حساب بنك الي حساب بنكي اخر
 * * عن طريق بسحب كريدت من حساب احطة دبت في حساب تاني
 */
class InternalMoneyTransfer extends Model
{
    use HasBasicStoreRequest ;
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

    public function deleteRelations()
    {
        $this->cleanOverdraftBankStatements->each(function (CleanOverdraftBankStatement $cleanOverdraftBankStatement) {
			$cleanOverdraftBankStatement->delete();
		});
		$this->currentAccountBankStatements->each(function (CurrentAccountBankStatement $currentAccountBankStatement) {
			$currentAccountBankStatement->delete();
		});
		
    }
}
