<?php

namespace App\Models;

use App\Traits\Models\HasDeleteButTriggerChangeOnLastElement;
use App\Traits\Models\IsSettlement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentSettlement extends Model
{
	use HasDeleteButTriggerChangeOnLastElement ,  IsSettlement;
	protected $guarded = ['id'];
	
	public function moneyPayment()
	{
		return $this->belongsTo(MoneyReceived::class , 'money_payment_id','id');
	}
	
	public function supplierInvoice()
	{
		return $this->belongsTo(SupplierInvoice::class , 'invoice_id','id');
	}
	public function invoice():BelongsTo
	{
		return $this->supplierInvoice();
	}

	public function letterOfCreditIssuance()
	{
		return $this->belongsTo(LetterOfCreditIssuance::class ,'letter_of_credit_issuance_id');
	}
	
}
