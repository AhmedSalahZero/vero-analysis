<?php

namespace App\Models;

use App\Interfaces\Models\IInvoice;
use App\Traits\Models\IsInvoice;
use App\Traits\StaticBoot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SupplierInvoice extends Model implements IInvoice
{
    use StaticBoot , IsInvoice;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    
    protected $dates = [
		
    ];
	
	const UNAPPLIED_SETTLEMENT_TABLE = 'paymentSettlements';
	const CLIENT_NAME_COLUMN_NAME = 'supplier_name';
	const CLIENT_ID_COLUMN_NAME = 'supplier_id';
	const JS_FILE = 'money-payment.js';
	const RECEIVED_OR_PAYMENT_AMOUNT = 'paid_amount';
	
	const RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME = 'delivery_date';
	const MONEY_RECEIVED_OR_PAYMENT_TABLE_NAME = 'money_payments';
	const MONEY_RECEIVED_OR_PAYMENT_TABLE_FOREIGN_NAME = 'money_payment_id';
	const TABLE_NAME = 'supplier_invoices';
	const COLLETED_OR_PAID = 'paid';
	const COLLETED_OR_PAID_AMOUNT = 'paid_amount';
	const PARTIALLY_COLLECTED_OR_PAID_AND_PAST_DUE = 'partially_paid_and_past_due';
	const MONEY_MODEL_NAME = 'MoneyPayment';
	const IS_CUSTOMER_OR_SUPPLIER = 'is_supplier';
	const AGING_CHEQUE_MODEL_NAME = 'PayableCheque';
	const AGING_CHEQUE_TABLE_NAME = 'payable_cheques';
	const DOWN_PAYMENT_SETTLEMENT_MODEL_NAME ='DownPaymentMoneyPaymentSettlement';
	const DOWN_PAYMENT_SETTLEMENT_TABLE_NAME ='down_payment_money_payment_settlements';
    protected $guarded = [];
	
	public function getClientDisplayName()
	{
		return __('Suppliers');
	}
	
	public function getCustomerOrSupplierAgingText()
	{
		return __('Suppliers Invoice Aging');
	}
	public function getAgingTitle()
	{
		return __('Supplier Aging Form');
	}
	public function getEffectivenessTitle()
	{
		return __('Payment Effectiveness Index Form');
	}
	public function getEffectivenessText()
	{
		return __('Payment Effectiveness Index');
	}
	public function getBalancesTitle()
	{
		return __('Supplier Balances');
	}
	public function getClientNameText()
	{
		return __('Supplier Name');
	}
	public function getMoneyReceivedOrPaidUrlName()
	{
		return 'create.money.payment';
	}
	public function getMoneyReceivedOrPaidText()
	{
		return __('Money Payments');
	}
	public function getCustomerOrSupplierStatementText()
	{
		return __('Supplier Statement');
	}
   
	public function getSupplierName()
    {
        return $this->getName() ;
    }
	public function getName()
	{
		return $this->supplier_name;
	}
	// do not use this directly use 
    public function moneyPayment()
    {
        return $this->hasMany(MoneyPayment::class, 'supplier_id', 'partner_id');
    }
	public function getPaidAmountAttribute($val)
    {
        return $val ;
    }
	public function getSupplierId()
    {
        return $this->supplier_id ;
    }
   
	
	public function isPaid()
	{
		return $this->getStatus() === self::COLLETED_OR_PAID; 
 	}
	
	 public static function hasProjectNameColumn()
	 {
		 return DB::table('supplier_invoices')->where('company_id',getCurrentCompanyId())->where('project_name','!=',null)->count();
	 }

	public function getNetBalanceUntil(string $date)
	{
		$invoiceId = $this->getId();
		$partnerId = $this->getSupplierId();
		$netInvoiceAmount = $this->getNetInvoiceAmount();
		$totalWithhold = $this->getWithholdAmount();
		$totalPaid = 0 ;
		$payments = $this->moneyPayment->where(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,'<=',$date) ;
		foreach($payments as $moneyPayment) {
			foreach($moneyPayment->getSettlementsForInvoiceNumber($invoiceId, $partnerId)  as $settlement) {
				$totalPaid += $settlement->getAmount();
			}
		}
		return $netInvoiceAmount - $totalPaid - $totalWithhold;
	}
	


	
	public function supplier()
	{
		return $this->belongsTo(Partner::class,self::CLIENT_ID_COLUMN_NAME,'id');
	}
	public function getPartnerId():int
	{
		return $this->supplier_id;
	}	
	public static function formatInvoices(array $invoices,int $inEditMode,$moneyPayment):array 
	{
		$result = [];
		foreach($invoices as $index=>$invoiceArr){
			if($inEditMode && $invoiceArr['settlement_amount'] == 0 && $invoiceArr['net_balance'] == 0 ){
				continue ;
			}
			$result[$index]['id'] = $invoiceArr['id'];
			$result[$index]['invoice_number'] = $invoiceArr['invoice_number'];
			$result[$index]['currency'] = $invoiceArr['currency'];
			$result[$index]['net_invoice_amount'] = $invoiceArr['net_invoice_amount'];
			$currentSettlementAmount = $invoiceArr['settlement_amount'] ?? 0 ;
			$currentSettlementAmount = (double) $currentSettlementAmount ;
			$result[$index]['paid_amount'] = $inEditMode 	?  (double)$invoiceArr['paid_amount'] - $currentSettlementAmount  : (double)$invoiceArr['paid_amount'];
			$result[$index]['net_balance'] = $inEditMode ? $invoiceArr['net_balance'] +  $currentSettlementAmount  + (double) $invoiceArr['withhold_amount'] : $invoiceArr['net_balance']  ;
			$result[$index]['settlement_amount'] = $inEditMode ? $currentSettlementAmount : 0;
			$result[$index]['withhold_amount'] = $inEditMode ? $invoiceArr['withhold_amount'] : 0;
			$result[$index]['invoice_date'] = Carbon::make($invoiceArr['invoice_date'])->format('d-m-Y');
			$result[$index]['invoice_due_date'] = Carbon::make($invoiceArr['invoice_due_date'])->format('d-m-Y');
			$result[$index]['settlement_allocations'] = $inEditMode ? $moneyPayment->settlementAllocations->where('invoice_id',$invoiceArr['id'])->map(function(SettlementAllocation $settlementAllocation){
				$settlementAllocation->contract_code = $settlementAllocation->contract->getCode();
				$settlementAllocation->contract_amount = $settlementAllocation->contract->getAmountWithCurrency();
				return $settlementAllocation;
			}) : [];
			
			
			
		}
		return $result;
	}
	public static function getSettlementsTemplate()
	{
		return '
		<div class=" kt-margin-b-10 border-class">
		<div class="form-group row align-items-end">

			<div class="col-md-1 width-10">
				<label> '. __('Invoice Number') .' </label>
				<div class="kt-input-icon">
					<div class="kt-input-icon">
						<div class="input-group date">
							<input type="hidden" name="settlements[][invoice_id]" value="0" class="js-invoice-id">
							<input readonly class="form-control js-invoice-number" data-invoice-id="0" name="settlements[][invoice_number]" value="0">
						</div>
					</div>
				</div>
			</div>


			<div class="col-md-1 width-9">
				<label>'.__('Invoice Date').'</label>
				<div class="kt-input-icon">
					<div class="input-group date">
						<input name="settlements[][invoice_date]" type="text" class="form-control js-invoice-date" disabled />
						
					</div>
				</div>
			</div>
			
			<div class="col-md-1 width-9">
				<label>'.__('Due Date').'</label>
				<div class="kt-input-icon">
					<div class="input-group date">
						<input name="settlements[][invoice_due_date]" type="text" class="form-control js-invoice-due-date" disabled />
						
					</div>
				</div>
			</div>
			

			<div class="col-md-1 width-8">
				<label>'.__('Currency').' </label>
				<div class="kt-input-icon">
					<input name="settlements[][currency]" type="text" disabled class="form-control js-currency">
				</div>
			</div>

			<div class="col-md-1 width-12">
				<label> '.__('Net Invoice Amount').' </label>
				<div class="kt-input-icon">
					<input name="settlements[][net_invoice_amount]" type="text" disabled class="form-control js-net-invoice-amount">
				</div>
			</div>


			<div class="col-md-2 width-12">
				<label> '. __('Paid Amount') .' </label>
				<div class="kt-input-icon">
					<input name="settlements[][paid_amount]" type="text" disabled class="form-control js-paid-amount">
				</div>
			</div>

			<div class="col-md-2 width-12">
				<label> '. __('Net Balance') .' </label>
				<div class="kt-input-icon">
					<input name="settlements[][net_balance]" type="text" readonly class="form-control js-net-balance">
				</div>
			</div>



			<div class="col-md-2 width-12">
				<label> '. __('Settlement Amount') .' <span class="text-danger ">*</span></label>
				<div class="kt-input-icon">
					<input name="settlements[][settlement_amount]" placeholder="'.__('Settlement Amount').'" type="text" class="form-control js-settlement-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
				</div>
			</div>
			<div class="col-md-2 width-12">
				<label>'. __('Withhold Amount') .' <span class="text-danger ">*</span> </label>
				<div class="kt-input-icon">
					<input name="settlements[][withhold_amount]" placeholder="'.__('Withhold Amount').'" type="text" class="form-control js-withhold-amount only-greater-than-or-equal-zero-allowed ">
				</div>
			</div>

		</div>

	</div>
		
		';
	}

	public static function getCurrencies():array 
	{
		return DB::table('supplier_invoices')
		->select('currency')
		->where('currency','!=','')
		->where('company_id',getCurrentCompanyId())
		->get()
		->unique('currency')->pluck('currency','currency')->toArray();
	}
	public static function getSupplierInvoicesUnderCollectionAtDates(array &$result , array &$totalCashOutFlowArray , int $companyId , string $startDate , string $endDate,string $currency  ,string $currentWeekYear):void
	{
		$key = __('Suppliers Invoices') ;

		$items = self::where('company_id',$companyId)
		->where('currency',$currency)
		->where('net_balance','>',0)
		->whereBetween('invoice_due_date',[$startDate,$endDate])->get();
		$sum = $items->sum('net_balance') ;
		$invoiceNumber = $items->count() ? $items->first()->invoice_number : null ;
		if($sum ){
			$invoiceNumber = __('Invoice No.') . ' ' .  $invoiceNumber;
			$result['suppliers'][$key][$invoiceNumber]['weeks'][$currentWeekYear] = isset($result['suppliers'][$key][$invoiceNumber]['weeks'][$currentWeekYear]) ? $result['suppliers'][$key][$invoiceNumber]['weeks'][$currentWeekYear] + $sum :  $sum;
			$result['suppliers'][$key][$invoiceNumber]['total'] = isset($result['suppliers'][$key][$invoiceNumber]['total']) ? $result['suppliers'][$key][$invoiceNumber]['total']  + $sum : $sum;
			$currentTotal = $sum;
			$result['suppliers'][$key]['total'][$currentWeekYear] = isset($result['suppliers'][$key]['total'][$currentWeekYear]) ? $result['suppliers'][$key]['total'][$currentWeekYear] +  $currentTotal : $currentTotal ;
			$totalCashOutFlowArray[$currentWeekYear] = isset($totalCashOutFlowArray[$currentWeekYear]) ? $totalCashOutFlowArray[$currentWeekYear] + $currentTotal : $currentTotal;
			$result['suppliers'][$key]['total']['total_of_total']= isset($result['suppliers'][$key]['total']['total_of_total']) ? $result['suppliers'][$key]['total']['total_of_total'] +$sum :$sum ;
		} 
	}
	public function letterOfCreditIssuancePaymentSettlements()
	{
		return $this->hasOne(PaymentSettlement::class,'invoice_id','id')->where('letter_of_credit_issuance_id','!=',null);
	}
	public function getDeleteByDateColumnName()
	{
		return 'invoice_date';
	}
}
