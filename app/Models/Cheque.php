<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cheque extends Model
{
    public const IN_SAFE = 'in-safe';

    public const UNDER_COLLECTION = 'under-collection';

    public const REJECTED = 'rejected';

    public const COLLECTED = 'collected';

    protected $guarded = ['id'];

    public function moneyReceived()
    {
        return $this->belongsTo(MoneyReceived::class, 'money_received_id');
    }

    public static function getChequeTypesForAging(): array
    {
        return [
            self::IN_SAFE,
            self::UNDER_COLLECTION
        ];
    }

    public function getDepositDate()
    {
        return $this->deposit_date ;
    }

    public function getDepositDateFormatted()
    {
        $depositDate = $this->getDepositDate();

        return $depositDate ? Carbon::make($depositDate)->format('d-m-Y') : null ;
    }

    public function setDepositDateAttribute($value)
    {
        if (!$value) {
            return null ;
        }
        $date = explode('/', $value);
        if (count($date) != 3) {
            $this->attributes['deposit_date'] = $value;

            return  ;
        }
        $month = $date[0];
        $day = $date[1];
        $year = $date[2];
        $this->attributes['deposit_date'] = $year . '-' . $month . '-' . $day;
    }

    /**
     * * هو البنك اللي جالي منة الشيك من العميل فا مش شرط يكون من بنوكي
     */
    public function draweeBank()
    {
        return $this->belongsTo(Bank::class, 'drawee_bank_id', 'id');
    }

    public function getDraweeBankId()
    {
        $draweeBank = $this->draweeBank;

        return $draweeBank ? $draweeBank->id : 0 ;
    }

    public function getDraweeBankName($lang = null)
    {
        $draweeBank = $this->draweeBank;

        return $draweeBank ? $draweeBank->getName($lang) : 0 ;
    }

    /**
     * * هو البنك اللي انا باخد الشيك واسحبة منة وبالتالي لازم يكون من بنوكي
     */
    public function drawlBank()
    {
        return $this->belongsTo(FinancialInstitution::class, 'drawl_bank_id', 'id');
    }

    public function getDrawlBankId()
    {
        $drawlBank = $this->drawlBank ;

        return $drawlBank ? $drawlBank->id : 0 ;
    }

    public function getDrawlBankName()
    {
        $drawlBank = $this->drawlBank ;

        return $drawlBank ? $drawlBank->getName() : __('N/A') ;
    }

    public function getChequeNumber()
    {
        return $this->cheque_number ;
    }

    public function getNumber()
    {
        return $this->getChequeNumber();
    }

    public function setActualCollectionDateAttribute($value)
    {
        if (!$value) {
            return null ;
        }
        $date = explode('/', $value);
        if (count($date) != 3) {
            $this->attributes['actual_collection_date'] = $value;

            return  ;
        }
        $month = $date[0];
        $day = $date[1];
        $year = $date[2];
        $this->attributes['actual_collection_date'] = $year . '-' . $month . '-' . $day;
    }

    public function getStatus()
    {
        return $this->status ;
    }

    public function isCollected(): bool
    {
        return $this->getStatus() === self::COLLECTED;
    }

    public function isRejected(): bool
    {
        return $this->getStatus() == self::REJECTED;
    }

    public function isUnderCollection()
    {
        return $this->getStatus() == self::UNDER_COLLECTION;
    }

    public function isInSafe(): bool
    {
        return $this->getStatus() == self::IN_SAFE;
    }

    public function getStatusFormatted()
    {
        return snakeToCamel($this->getStatus());
    }

    public function getDueDate()
    {
        return $this->due_date;
    }

    public function getDueDateFormatted()
    {
        $dueDate = $this->getDueDate();

        return  $dueDate ? Carbon::make($dueDate)->format('d-m-Y') : null ;
    }

    public function setDueDateAttribute($value)
    {
        $date = explode('/', $value);
        if (count($date) != 3) {
            $this->attributes['due_date'] = $value ;

            return ;
        }
        $month = $date[0];
        $day = $date[1];
        $year = $date[2];

        $this->attributes['due_date'] = $year . '-' . $month . '-' . $day;
    }

    /**
     * * هنعرفه ان كان مستحق الدفع ولا لا كا استرنج مش بولين
     */
    public function getDueStatus(): bool
    {
        $dueDate = $this->getDueDate();

        return !Carbon::make($dueDate)->greaterThan(now());
    }

    /**
     * * هنعرفه ان كان مستحق الدفع ولا لا كا استرنج مش بولين
     */
    public function getDueStatusFormatted(): array
    {
        if ($this->getDueStatus()) {
            return [
                'status' => __('Due'),
                'color' => 'red'
            ];
        }

        return [
            'status' => __('Not Due Yet'),
            'color' => 'green'
        ];
    }

    /**
     * * هو عباره عن رقم الحساب اللي هينزل فيه مبلغ الشيك بعد التحصيل من البنك
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    public function getAccountBalance()
    {
        return $this->account_balance ;
    }

    /**
     * * عدد الايام المتوقع فيها تحصيل الشيك من البنك ولو البنك الخاص بالشيك اللي العميل جابه هو نفس البنك اللي هتحصل فيه
     * * فا بيكون قيمته بصفر
     */
    public function getClearanceDays()
    {
        return $this->clearance_days ?: 0;
    }

    public function calculateChequeExpectedCollectionDate(string $chequeDepositDate, int $chequeClearanceDays): string
    {
        $chequeDueDate = $this->getDueDate();
        $chequeDueDate = Carbon::make($chequeDueDate);
        $chequeDepositDate = Carbon::make($chequeDepositDate);
        if ($chequeDepositDate->lessThan($chequeDueDate)) {
            $diffInDays = $chequeDueDate->diffInDays($chequeDepositDate) + $chequeClearanceDays ;

            return $chequeDepositDate->addDays($diffInDays)->format('Y-m-d');
        } else {
            return $chequeDepositDate->addDays($chequeClearanceDays)->format('Y-m-d');
        }
    }

    public function chequeAccountBalance()
    {
        return $this->account_balance ?: 0 ;
    }

    public function getCollectionFees()
    {
        return $this->collection_fees ?: 0 ;
    }

    public function getCollectionFeesFormatted()
    {
        $collectionFees = $this->getCollectionFees();

        return number_format($collectionFees, 0) ;
    }

    public function chequeExpectedCollectionDate()
    {
        return $this->expected_collection_date ;
    }

    public function chequeExpectedCollectionDateFormatted()
    {
        $date = $this->chequeExpectedCollectionDate() ;

        // dd($this);
        return $date ? Carbon::make($date)->format('d-m-Y') : null ;
    }

    public function chequeActualCollectionDate()
    {
        return $this->actual_collection_date ;
    }

    public function chequeActualCollectionDateFormatted()
    {
        $date = $this->chequeActualCollectionDate() ;

        return $date ? Carbon::make($date)->format('d-m-Y') : null ;
    }
	public function accountType()
	{
		return $this->belongsTo(AccountType::class,'account_type','id');
	}
	public function getAccountTypeName()
	{
		$accountType = $this->accountType; 
		return $accountType ? $accountType->getName() : __('N/A') ; 
	}
    public function getAccountType()
    {
        return $this->account_type ;
    }

    public function getDueAfterDays()
    {
        $firstDate = Carbon::make($this->getDueDate());
        $secondDate = Carbon::make($this->moneyReceived->getReceivingDate());

        return getDiffBetweenTwoDatesInDays($firstDate, $secondDate);
    }

    protected static function booted(): void
    {
        static::updated(
            function (self $model) {
                $oldStatus = $model->getRawOriginal('status');
                $oldAccountTypeId = $model->getRawOriginal('account_type');
                $currentAccountTypeId = $model->getAccountType();
                $currentAccountType = AccountType::find($currentAccountTypeId);
                $oldAccountType = AccountType::find($oldAccountTypeId);
                $oldAccountNumber = $model->getRawOriginal('account_number');
                $currentAccountNumber = $model->getAccountNumber();

                /**
                 * * في حالة لو رجعته من
                 * * collected to be under collection
                 */
                if ($model->isUnderCollection() && $oldStatus == self::COLLECTED) {
                    $negativeOverdraftAgainstCommercialPaperLimit = $model->overdraftAgainstCommercialPaperLimits->where('limit', '<', 0)->first();
                    $negativeOverdraftAgainstCommercialPaperLimit ? $negativeOverdraftAgainstCommercialPaperLimit->update(['is_active' => 0]) : null ;
                    $negativeOverdraftAgainstCommercialPaperLimit ? DB::table('overdraft_against_commercial_paper_limits')->where('id', $negativeOverdraftAgainstCommercialPaperLimit->id)->delete() : null ;

                    return ;
                }
                /**
                 * * في حالة لو بقى
                 * * collected or rejected
                 */
                if ($model->isCollected()) {
                    /**
                     * * هنضيف رو جديد بنفس القيمة ولكن بالسالب
                     */

                    $model->handleOverdraftAgainstCommercialPaperLimit();

                    return ;
                }

                if ($model->isInSafe() || $model->isRejected()) {
                    $model->deleteOverdraftAgainstCommercialPapersLimits();

                    return ;
                }
                /**
                 * * في حالة لو هو عدل شيك تحت التحصيل وفي نفس الوقت غير نوع الاكونت لاي اكونت تاني غير
                 * * overdraft against commercial paper
                 */
                if ($model->isUnderCollection() && $currentAccountType && !$currentAccountType->isOverdraftAgainstCommercialPaperAccount()) {
                    $model->deleteOverdraftAgainstCommercialPapersLimits();

                    return ;
                }

                /**
                 * * في حالة لو هو عدل شيك تحت التحصيل وفي نفس الوقت غير نوع الاكونت ل
                 * * overdraft against commercial paper
                 * * وكان عدد ال
                 * * papers limits
                 * * صفر يبقي هو اكيد كان جي من نوع تاني غير ال
                 * * overdraft against commercial paper
                 * *
                 */
                if ($model->isUnderCollection() && $currentAccountType && $currentAccountType->isOverdraftAgainstCommercialPaperAccount() && !$model->overdraftAgainstCommercialPaperLimits->count() && $oldAccountType && !$oldAccountType->isOverdraftAgainstCommercialPaperAccount()) {
                    $model->handleOverdraftAgainstCommercialPaperLimit();

                    return ;
                }
                /**
                 * * في حالة لو غير رقم الحساب ال
                 * * overdraft against commercial paper
                 * * وحطها في حساب تاني حتى لو كانت بنك مختلف
                 */

                if ($model->isUnderCollection() && $oldAccountType && $oldAccountType->isOverdraftAgainstCommercialPaperAccount() && $currentAccountType && $currentAccountType->isOverdraftAgainstCommercialPaperAccount() && $currentAccountNumber != $oldAccountNumber) {
                    $model->overdraftAgainstCommercialPaperLimits->each(function ($overdraftAgainstCommercialPaper) use ($model, $currentAccountNumber) {
                        $overdraftAgainstCommercialPaper->update([
                            'overdraft_against_commercial_paper_id' => DB::table('overdraft_against_commercial_papers')->where('company_id', $model->company_id)->where('account_number', $currentAccountNumber)->first()->id,
                        ]);
                    });

                    return ;
                }
                /**
                 * * في حالة لو هو في الخزنة اول مرة وبالتالي مفيش
                 * * limits
                 */
                if ($model->isUnderCollection() && $currentAccountType->isOverdraftAgainstCommercialPaperAccount() && !$model->overdraftAgainstCommercialPaperLimits->count()) {
                    $model->handleOverdraftAgainstCommercialPaperLimit();

                    return ;
                }
                $overdraftAgainstCommercialPaperLimit = $model->overdraftAgainstCommercialPaperLimits->sortBy('full_date')->first() ;
                $overdraftAgainstCommercialPaperLimit ? $overdraftAgainstCommercialPaperLimit->update(['updated_at' => now(), 'full_date' => $overdraftAgainstCommercialPaperLimit->updateFullDate()]) : null;
            }
        );

        static::deleted(
            function (self $model) {
                $model->deleteOverdraftAgainstCommercialPapersLimits();
            }
        );
    }

    public function deleteOverdraftAgainstCommercialPapersLimits()
    {
        $this->overdraftAgainstCommercialPaperLimits->each(function ($overdraftAgainstCommercialPaperLimit) {
            $overdraftAgainstCommercialPaperLimit->update(['is_active' => 0]);
            DB::table('overdraft_against_commercial_paper_limits')->where('id', $overdraftAgainstCommercialPaperLimit->id)->delete();
        });
    }

    public function overdraftAgainstCommercialPaperLimits()
    {
        return $this->hasMany(OverdraftAgainstCommercialPaperLimit::class, 'cheque_id', 'id');
    }

    public function handleOverdraftAgainstCommercialPaperLimit(): void
    {
        /**
         * @var AccountType $accountType
         */
        $accountType = AccountType::find($this->getAccountType());
        $overdraftAgainstCommercialPaper = OverdraftAgainstCommercialPaper::where('account_number', $this->getAccountNumber())->first();

        if ($accountType && $accountType->isOverdraftAgainstCommercialPaperAccount() && $overdraftAgainstCommercialPaper) {
            $this->overdraftAgainstCommercialPaperLimits()->create([
                'company_id' => $this->company_id,
                'overdraft_against_commercial_paper_id' => $overdraftAgainstCommercialPaper->id
            ]);
        }
    }
}
