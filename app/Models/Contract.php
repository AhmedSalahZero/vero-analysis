<?php

namespace App\Models;

use App\Models\Partner;
use App\Traits\HasBasicStoreRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Contract extends Model
{
	use HasBasicStoreRequest;
	const RUNNING ='running';
	const RUNNING_AND_AGAINST = 'running_and_against';
	const FINISHED = 'finished';
	
	public function overdraftAgainstAssignmentOfContractLimits()
    {
        return $this->hasMany(OverdraftAgainstAssignmentOfContractLimit::class, 'contract_id', 'id');
    }
	public function deleteOverdraftAgainstAssignmentOfContractsLimits()
    {
        $this->overdraftAgainstAssignmentOfContractLimits->each(function ($overdraftAgainstAssignmentOfContractLimit) {
            $overdraftAgainstAssignmentOfContractLimit->update(['is_active' => 0]);
            DB::table('overdraft_against_assignment_of_contract_limits')->where('id', $overdraftAgainstAssignmentOfContractLimit->id)->delete();
        });
    }
	public function handleOverdraftAgainstAssignmentOfContractLimit(): void
    {
        /**
         * @var AccountType $accountType
         */
        $accountType = AccountType::find($this->getAccountType());
        $overdraftAgainstAssignmentOfContract = OverdraftAgainstAssignmentOfContract::where('account_number', $this->getAccountNumber())->first();

        if ($accountType && $accountType->isOverdraftAgainstAssignmentOfContractAccount() && $overdraftAgainstAssignmentOfContract) {
            $this->overdraftAgainstAssignmentOfContractLimits()->create([
                'company_id' => $this->company_id,
                'overdraft_against_assignment_of_contract_id' => $overdraftAgainstAssignmentOfContract->id
            ]);
        }
    }
	public function isRunning()
	{
		return $this->status == self::RUNNING;
	}
	public function isRunningAndAgainst()
	{
		return $this->status == self::RUNNING_AND_AGAINST;
	}
	public function isFinished()
	{
		return $this->status == self::FINISHED;
	}
	public static function boot()
    {
        parent::boot();
        self::saving(function($model){
			$model->end_date = $model->start_date && $model->duration ? Carbon::make($model->start_date)->addDays($model->duration)->format('Y-m-d') : null;  
        });
		
		
		static::updated(
            function (self $model) {
                $oldStatus = $model->getRawOriginal('status');
                $oldAccountTypeId = $model->getRawOriginal('account_type');
                $currentAccountTypeId = $model->getAccountType();
                $currentAccountType = AccountType::find($currentAccountTypeId);
                $oldAccountType = AccountType::find($oldAccountTypeId);
                $oldAccountNumber = $model->getRawOriginal('account_number');
                $currentAccountNumber = $model->getAccountNumber();
				// dd($model->isRunningAndAgainst() , $currentAccountType->isOverdraftAgainstAssignmentOfContractAccount() , $currentAccountType , $model->overdraftAgainstAssignmentOfContractLimits->count());

                /**
                 * * في حالة لو رجعته من
                 * * finished to be running and against
                 */
                if ($model->isRunningAndAgainst() && $oldStatus == self::FINISHED) {
                    $negativeOverdraftAgainstAssignmentOfContractLimit = $model->overdraftAgainstAssignmentOfContractLimits->where('limit', '<', 0)->first();
                    $negativeOverdraftAgainstAssignmentOfContractLimit ? $negativeOverdraftAgainstAssignmentOfContractLimit->update(['is_active' => 0]) : null ;
                    $negativeOverdraftAgainstAssignmentOfContractLimit ? DB::table('overdraft_against_assignment_of_contract_limits')->where('id', $negativeOverdraftAgainstAssignmentOfContractLimit->id)->delete() : null ;

                    return ;
                }
                /**
                 * * في حالة لو بقى
                 * * finished 
                 */
                if ($model->isFinished()) {
                    /**
                     * * هنضيف رو جديد بنفس القيمة ولكن بالسالب
                     */

                    $model->handleOverdraftAgainstAssignmentOfContractLimit();

                    return ;
                }

                if ($model->isRunning() ) {
                    $model->deleteOverdraftAgainstAssignmentOfContractsLimits();
                    return ;
                }
                /**
                 * * في حالة لو هو عدل شيك تحت التحصيل وفي نفس الوقت غير نوع الاكونت لاي اكونت تاني غير
                 * * overdraft against commercial paper
                 */
                if ($model->isRunningAndAgainst() && $currentAccountType && !$currentAccountType->isOverdraftAgainstAssignmentOfContractAccount()) {
                    $model->deleteOverdraftAgainstAssignmentOfContractsLimits();

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
                if ($model->isRunningAndAgainst() && $currentAccountType && $currentAccountType->isOverdraftAgainstAssignmentOfContractAccount() && !$model->overdraftAgainstAssignmentOfContractLimits->count() && $oldAccountType && !$oldAccountType->isOverdraftAgainstAssignmentOfContractAccount()) {
                    $model->handleOverdraftAgainstAssignmentOfContractLimit();

                    return ;
                }
                /**
                 * * في حالة لو غير رقم الحساب ال
                 * * overdraft against commercial paper
                 * * وحطها في حساب تاني حتى لو كانت بنك مختلف
                 */

                if ($model->isRunningAndAgainst() && $oldAccountType && $oldAccountType->isOverdraftAgainstAssignmentOfContractAccount() && $currentAccountType && $currentAccountType->isOverdraftAgainstAssignmentOfContractAccount() && $currentAccountNumber != $oldAccountNumber) {
                    $model->overdraftAgainstAssignmentOfContractLimits->each(function ($overdraftAgainstAssignmentOfContract) use ($model, $currentAccountNumber) {
                        $overdraftAgainstAssignmentOfContract->update([
                            'overdraft_against_assignment_of_contract_id' => DB::table('overdraft_against_assignment_of_contracts')->where('company_id', $model->company_id)->where('account_number', $currentAccountNumber)->first()->id,
                        ]);
                    });

                    return ;
                }
                /**
                 * * في حالة لو هو في الخزنة اول مرة وبالتالي مفيش
                 * * limits
                 */
                if ($model->isRunningAndAgainst() && $currentAccountType->isOverdraftAgainstAssignmentOfContractAccount() && !$model->overdraftAgainstAssignmentOfContractLimits->count()) {
                    $model->handleOverdraftAgainstAssignmentOfContractLimit();
                    return ;
                }
                $overdraftAgainstAssignmentOfContractLimit = $model->overdraftAgainstAssignmentOfContractLimits->sortBy('full_date')->first() ;
                $overdraftAgainstAssignmentOfContractLimit ? $overdraftAgainstAssignmentOfContractLimit->update(['updated_at' => now(), 'full_date' => $overdraftAgainstAssignmentOfContractLimit->updateFullDate()]) : null;
            }
        );

        static::deleted(
            function (self $model) {
                $model->deleteOverdraftAgainstAssignmentOfContractsLimits();
            }
        );
		

    }
	protected $guarded = ['id'];
	public function getId()
	{
		return $this->id ;
	}
	public function client()
	{
		return $this->belongsTo(Partner::class,'partner_id','id');
	}
	public function getClientName()
	{
		return $this->client ? $this->client->getName() :__('N/A');
	}
	public function getName()
	{
		return $this->name ;
	}
	public function getCode()
	{
		return $this->code ;
	}
	public function getStartDate()
	{
		return $this->start_date; 
	}
	public function getStartDateFormatted()
	{
		$date = $this->getStartDate() ;
		return $date ? Carbon::make($date)->format('d-m-Y'):null ;
	}
	public function setStartDateAttribute($value)
	{
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['start_date'] =  $value ;
			return ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		
		$this->attributes['start_date'] = $year.'-'.$month.'-'.$day;
	}
	public function getDuration()
	{
		return $this->duration ;
	}
	
	public function getEndDate()
	{
		return $this->end_date ;
	}
	public function getEndDateFormatted()
	{
		$date = $this->getEndDate() ;
		return $date ? Carbon::make($date)->format('d-m-Y'):null ;
	}
	
	public function getAmount()
	{
		return $this->amount?:0 ;
	}
	public function getAmountFormatted()
	{
		return number_format($this->getAmount(),0);
	}
	public function getCurrency()
	{
		return $this->currency;
	}
	public function salesOrders()
	{
		return $this->hasMany(SalesOrder::class,'contract_id','id');
	}
	public function purchasesOrders()
	{
		return $this->hasMany(PurchaseOrder::class,'contract_id','id');
	}
	public function forCustomer()
	{
		return $this->model_type === 'Customer';
	}
	public function forSupplier()
	{
		return $this->model_type === 'Supplier';
	}
	/**
	 * * اما 
	 * *sales order or purchase order
	 */
	public function getOrders()
	{
		return $this->forSupplier() ? $this->purchasesOrders : $this->salesOrders ;
	}
	
	public function letterOfGuaranteeIssuances()
	{
		return $this->hasMany(LetterOfGuaranteeIssuance::class , 'contract_id','id');
	}
	public function scopeOnlyForCompany(Builder $builder , int $companyId)
	{
		return $builder->where('company_id',$companyId);
	}	
	public function getExchangeRate()
	{
		return $this->exchange_rate ?: 1 ;
	}
	public static function getForParentAndCurrency(int $partnerId , string $currencyName):Collection
	{
		return self::where('partner_id',$partnerId)->where('currency',$currencyName)->get();
	}	
	public function lendingInformationForAgainstAssignmentContract():HasOne
	{
		return $this->hasOne(LendingInformationAgainstAssignmentOfContract::class,'contract_id','id');
	}
	public function getAccountType()
    {
        return $this->account_type ;
    }
	public function getAccountNumber()
    {
        return $this->account_number;
    }
	
}
