<?php

namespace App\Models;

use App\Helpers\HHelpers;
use App\Helpers\HStr;
use App\Models\Partner;
use App\Traits\HasBasicStoreRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;
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
        // $accountType = AccountType::find($this->getAccountType());
        $overdraftAgainstAssignmentOfContract = $this->overdraftAgainstAssignmentOfContract;
		//  OverdraftAgainstAssignmentOfContract::where('account_number', $this->getAccountNumber())->first();

        if (
			// $accountType && $accountType->isOverdraftAgainstAssignmentOfContractAccount() &&
		
		 $overdraftAgainstAssignmentOfContract) {
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
			$model->duration = $model->duration * 365/12;
			$model->end_date = $model->start_date && $model->duration ? Carbon::make($model->start_date)->addDays($model->duration)->format('Y-m-d') : null;  
        });
		
		
		static::updated(
            function (self $model) {
                $oldStatus = $model->getRawOriginal('status');
       
                /**
                 * * في حالة لو رجعته من
                 * * finished to be running and against
                 */
                if ($model->isRunningAndAgainst() && $oldStatus == self::FINISHED) {
                    $negativeOverdraftAgainstAssignmentOfContractLimit = $model->overdraftAgainstAssignmentOfContractLimits->where('limit', '<', 0)->first();
                    $negativeOverdraftAgainstAssignmentOfContractLimit ? $negativeOverdraftAgainstAssignmentOfContractLimit->update(['is_active' => 0]) : null ;
                    $negativeOverdraftAgainstAssignmentOfContractLimit ? DB::table('overdraft_against_assignment_of_contract_limits')->where('id', $negativeOverdraftAgainstAssignmentOfContractLimit->id)->delete() : null ;
					logger('frrrr');
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
					logger('from oo');

                    $model->handleOverdraftAgainstAssignmentOfContractLimit();

                    return ;
                }

                if ($model->isRunning() ) {
					logger('from qq');
                    $model->deleteOverdraftAgainstAssignmentOfContractsLimits();
                    return ;
                }
                /**
                 * * في حالة لو هو عدل شيك تحت التحصيل وفي نفس الوقت غير نوع الاكونت لاي اكونت تاني غير
                 * * overdraft against commercial paper
                 */
                // if ($model->isRunningAndAgainst() && $currentAccountType && !$currentAccountType->isOverdraftAgainstAssignmentOfContractAccount()) {
				// 	logger('from fff');
					
                //     $model->deleteOverdraftAgainstAssignmentOfContractsLimits();
                //     return ;
                // }

                /**
                 * * في حالة لو هو عدل شيك تحت التحصيل وفي نفس الوقت غير نوع الاكونت ل
                 * * overdraft against commercial paper
                 * * وكان عدد ال
                 * * papers limits
                 * * صفر يبقي هو اكيد كان جي من نوع تاني غير ال
                 * * overdraft against commercial paper
                 * *
                 */
                // if ($model->isRunningAndAgainst() && $currentAccountType && $currentAccountType->isOverdraftAgainstAssignmentOfContractAccount() && !$model->overdraftAgainstAssignmentOfContractLimits->count() && $oldAccountType && !$oldAccountType->isOverdraftAgainstAssignmentOfContractAccount()) {
				// 	logger('from bbb');
					
                //     $model->handleOverdraftAgainstAssignmentOfContractLimit();

                //     return ;
                // }
                /**
                 * * في حالة لو غير رقم الحساب ال
                 * * overdraft against commercial paper
                 * * وحطها في حساب تاني حتى لو كانت بنك مختلف
                 */
                // if ($model->isRunningAndAgainst() && $oldAccountType && $oldAccountType->isOverdraftAgainstAssignmentOfContractAccount() && $currentAccountType && $currentAccountType->isOverdraftAgainstAssignmentOfContractAccount() && $currentAccountNumber != $oldAccountNumber) {
				// 	logger('from lllt');
					
                //     $model->overdraftAgainstAssignmentOfContractLimits->each(function ($overdraftAgainstAssignmentOfContract) use ($model, $currentAccountNumber) {
                //         $overdraftAgainstAssignmentOfContract->update([
                //             'overdraft_against_assignment_of_contract_id' => DB::table('overdraft_against_assignment_of_contracts')->where('company_id', $model->company_id)->where('account_number', $currentAccountNumber)->first()->id,
                //         ]);
                //     });

                //     return ;
                // }
                /**
                 * * في حالة لو هو في الخزنة اول مرة وبالتالي مفيش
                 * * limits
                 */
                if ($model->isRunningAndAgainst() 
				// && $currentAccountType->isOverdraftAgainstAssignmentOfContractAccount()
			 	&& !$model->overdraftAgainstAssignmentOfContractLimits->count()) {
					logger('from tty');
					
                    $model->handleOverdraftAgainstAssignmentOfContractLimit();
                    return ;
                }
				
		
                $overdraftAgainstAssignmentOfContractLimit = $model->overdraftAgainstAssignmentOfContractLimits->sortBy('full_date')->first() ;
                $overdraftAgainstAssignmentOfContractLimit ? $overdraftAgainstAssignmentOfContractLimit->update(['updated_at' => now(), 'full_date' => $overdraftAgainstAssignmentOfContractLimit->updateFullDate()]) : null;
            }
        );


        static::deleted(
            function (self $model) {
				$model->detachRelatedContracts();
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
	public function getClientId()
	{
		return $this->client ? $this->client->id :0;
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
	public function getAmountWithCurrency()
	{
		return $this->getAmountFormatted() . ' ' . $this->getCurrency();
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
	public function overdraftAgainstAssignmentOfContract()
	{
		return $this->belongsTo(OverdraftAgainstAssignmentOfContract::class , 'overdraft_against_assignment_of_contract_id','id');
	}
	/**
	 * * عباره عن العقود اللي مربوطة بيها 
	 * * بحيث لو هو عقد عميل هيكون مربوط باكثر من عقد من الموردين
	 */
	public function relatedContracts():HasMany
	{
		return $this->hasMany(Contract::class , 'parent_id');
	}	
	public function relateWithContracts(array $contractsToBeRelated):void
	{
		$ids = Arr::pluck($contractsToBeRelated,'contract_id');
	
		Contract::whereIn('id',$ids)->update([
			'parent_id'=>$this->id 
		]);
	}
	public function detachRelatedContracts():void
	{
		$this->relatedContracts()->update([
			'parent_id'=>null 
		]);
	}
	public function syncWithContracts(array $contractsToBeRelated):void
	{
		$this->detachRelatedContracts();
		$this->relateWithContracts($contractsToBeRelated);
	}
	public function cashExpenses()
	{
		return $this->belongsToMany(CashExpense::class ,'cash_expense_contract','contract_id','cash_expense_id')
		->withTimestamps()
		->withPivot(['amount','cash_expense_id'])
		;
	}
	public function getCashExpensePerCategoryName(array &$result,array &$totalCashOutFlowArray,string $moneyType,string $dateFieldName,string $startDate , string $endDate ,string $currentWeekYear , string $currencyName , ?string $chequeStatus = null ):void
	{
		foreach($this->cashExpenses as $cashExpense){
			/**
			 * @var CashExpense $cashExpense
			 */
			$currentAllocationAmount = DB::table('cash_expense_contract')
			->where('contract_id',$this->id)
			->join('cash_expenses','cash_expenses.id','=','cash_expense_contract.cash_expense_id')
			->where('cash_expenses.type',$moneyType)
			->where('currency',$currencyName)
			// ->where('cash_expense_category_name_id',$cashExpense->getCashExpenseCategoryNameId())
			->whereBetween($dateFieldName,[$startDate,$endDate])
			->when($moneyType == CashExpense::PAYABLE_CHEQUE , function( $builder) use ($chequeStatus){
				$builder->join('payable_cheques','payable_cheques.cash_expense_id','=','cash_expenses.id')
				->where('payable_cheques.status',$chequeStatus)
				;
			})
			->where('cash_expenses.id',$cashExpense->id)
			->sum('cash_expense_contract.amount');
		
			
				$categoryName = $cashExpense->cashExpenseCategoryName ;
			 $categoryName = $cashExpense->getExpenseCategoryName() ;
			 $categoryNameName = $cashExpense->getExpenseName() ;
			$result['cash_expenses'][$categoryName][$categoryNameName]['weeks'][$currentWeekYear] = isset($result['cash_expenses'][$categoryName][$categoryNameName]['weeks'][$currentWeekYear]) ? $result['cash_expenses'][$categoryName][$categoryNameName]['weeks'][$currentWeekYear] + $currentAllocationAmount :  $currentAllocationAmount;
			$result['cash_expenses'][$categoryName][$categoryNameName]['total'] = isset($result['cash_expenses'][$categoryName][$categoryNameName]['total']) ? $result['cash_expenses'][$categoryName][$categoryNameName]['total']  + $currentAllocationAmount : $currentAllocationAmount;
			$currentTotal = $currentAllocationAmount;
			$result['cash_expenses'][$categoryName]['total'][$currentWeekYear] = isset($result['cash_expenses'][$categoryName]['total'][$currentWeekYear]) ? $result['cash_expenses'][$categoryName]['total'][$currentWeekYear] +  $currentTotal : $currentTotal ;
			$result['cash_expenses'][$categoryName]['total']['total_of_total'] = isset($result['cash_expenses'][$categoryName]['total']['total_of_total']) ? $result['cash_expenses'][$categoryName]['total']['total_of_total'] +   $currentAllocationAmount : $currentAllocationAmount ; 	
			$totalCashOutFlowArray[$currentWeekYear] = isset($totalCashOutFlowArray[$currentWeekYear]) ? $totalCashOutFlowArray[$currentWeekYear] +   $currentTotal : $currentTotal ;

	}
	
	
		
	}
	public function moneyReceived() // downpayments
	{
		return $this->hasMany(MoneyReceived::class,'contract_id','id')->whereIn('money_type',[MoneyReceived::DOWN_PAYMENT
		,MoneyReceived::INVOICE_SETTLEMENT_WITH_DOWN_PAYMENT
	]);
	}
	public function MoneyPayment() // downpayments
	{
		return $this->hasMany(MoneyPayment::class,'contract_id','id')->whereIn('money_type',[
			MoneyPayment::DOWN_PAYMENT,
			MoneyPayment::INVOICE_SETTLEMENT_WITH_DOWN_PAYMENT
		]);
	}
	public static function generateRandomContract(int $companyId , string $partnerName,string $startDate , string $modelType):string 
	{
		$prefix = $modelType == 'Customer' ? 'c-' : 's-';
		$startDate = Carbon::make($startDate)->format('Y-m-d');
		$startDateMonth = explode('-',$startDate)[1];
		$startDateYear = explode('-',$startDate)[0];
		$partnerNameItems = explode(' ',$partnerName);
		$randomNumbers = HHelpers::generateCodeOfLength(4,true);
		$partnerNameChar = '';
		foreach($partnerNameItems as $partnerNameItem){
			$partnerNameChar.=mb_substr($partnerNameItem, 0, 1, 'utf8') ;
		}
		$partnerNameChar = HStr::replaceSpecialCharacters($partnerNameChar);
		$code = $prefix . $startDateMonth.'-'.$startDateYear.'-'.$partnerNameChar.'-'.$randomNumbers ;
		if(Contract::where('code',$code)->where('company_id',$companyId)->exists()){
			return self::generateRandomContract($companyId,$partnerName,$startDate,$modelType);
		}
		return $code ;
	}
	public function customerInvoices()
	{
		return $this->hasMany(CustomerInvoice::class,'contract_code','code')->where('company_id',$this->company_id);
	}
}
