<?php

namespace App\Models\NonBankingService;

use App\Traits\HasCollectionOrPaymentStatement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashAndBankOpeningBalance extends Model
{
	use HasCollectionOrPaymentStatement;
    protected $guarded = ['id'];
	protected $connection= 'non_banking_service';
	protected $casts = [
		'payload'=>'array',
		'statement'=>'array',
		'interests'=>'array',
	];
	public static function getOpeningBalanceColumnName():string
	{
		return 'customer_receivable_amount';
	}
	public static function getPayloadStatementColumn():string 
	{
		return 'payload';
	}
	public static function booted()
	{
			parent::boot();
			static::saving(function(self $model){
				$openingBalance = $model->{self::getOpeningBalanceColumnName()};
				$statementPayload = $model->{self::getPayloadStatementColumn()};
				$dateIndexWithDate = $model->study->getDateIndexWithDate();
				$extendedStudyEndDate = $model->study->convertDateStringToDateIndex($model->study->getEndDate()) ;
				$dates = range(0,$extendedStudyEndDate);
				if(!is_null($openingBalance)){
					$model->statement = self::calculateSettlementStatement($dates,$statementPayload,[],$openingBalance,$dateIndexWithDate);
				}
			});
	}
    public function study():BelongsTo
    {
        return $this->belongsTo(Study::class, 'study_id', 'id');
    }
	
    public function getCashAndBankAmount():float 
    {
        return $this->cash_and_bank_amount ;
    }
	    public function getCustomerReceivableAmount():float 
    {
        return $this->customer_receivable_amount ;
    }
	  public function getExpectedCreditLossAmount():float 
    {
        return $this->expected_credit_loss ;
    }
	public function getPayload():array 
	{
		return $this->payload?:[] ;
	}
	public function getInterest():array 
	{
		return $this->interests??[] ;
	}
	
	public function getInterestAtDateIndex(int $dateAsIndex):float 
	{
		return $this->getInterest()[$dateAsIndex]??0;
	}
	public function getPayloadAtDateIndex(int $dateAsIndex):float 
	{
		return $this->getPayload()[$dateAsIndex]??0;
	}
	
	
}
