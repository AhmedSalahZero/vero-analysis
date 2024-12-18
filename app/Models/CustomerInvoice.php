<?php

namespace App\Models;

use App\Interfaces\Models\IInvoice;
use App\Traits\Models\IsInvoice;
use App\Traits\StaticBoot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomerInvoice extends Model implements IInvoice
{
    use StaticBoot , IsInvoice;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */

	
	
	const UNAPPLIED_SETTLEMENT_TABLE = 'settlements';
	const CLIENT_NAME_COLUMN_NAME = 'customer_name';
	const CLIENT_ID_COLUMN_NAME = 'customer_id';
	const RECEIVED_OR_PAYMENT_AMOUNT = 'received_amount';
	const RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME = 'receiving_date';
	const MONEY_RECEIVED_OR_PAYMENT_TABLE_NAME = 'money_received';
	const MONEY_RECEIVED_OR_PAYMENT_TABLE_FOREIGN_NAME = 'money_received_id';
	const TABLE_NAME = 'customer_invoices';
	const JS_FILE = 'money-receive.js';
	const COLLETED_OR_PAID = 'collected';
	const COLLETED_OR_PAID_AMOUNT = 'collected_amount';
	const PARTIALLY_COLLECTED_OR_PAID_AND_PAST_DUE = 'partially_collected_and_past_due';
	const MONEY_MODEL_NAME = 'MoneyReceived';
	const IS_CUSTOMER_OR_SUPPLIER = 'is_customer';
	const AGING_CHEQUE_MODEL_NAME = 'Cheque';
	const AGING_CHEQUE_TABLE_NAME = 'cheques';
	const DOWN_PAYMENT_SETTLEMENT_MODEL_NAME ='DownPaymentSettlement';
	const DOWN_PAYMENT_SETTLEMENT_TABLE_NAME ='down_payment_settlements';
    protected $guarded = [];

	public function getClientDisplayName()
	{
		return __('Customers');
	}
	public function getCustomerOrSupplierAgingText()
	{
		return __('Customers Invoice Aging');
	}
	public function getAgingTitle()
	{
		return __('Customer Aging Form');
	}
	public function getEffectivenessTitle()
	{
		return __('Collection Effectiveness Index Form');
	}
	public function getEffectivenessText()
	{
		return __('Collection Effectiveness Index');
	}
	public function getBalancesTitle()
	{
		return __('Customer Balances');
	}
	public function getClientNameText()
	{
		return __('Customer Name');
	}
	public function getMoneyModelName()
	{
		return 'MoneyReceived';
	}
	public function getMoneyReceivedOrPaidUrlName()
	{
		return 'create.money.receive';
	}
	public function getMoneyReceivedOrPaidText()
	{
		return __('Money Received');
	}
	public function getCustomerOrSupplierStatementText()
	{
		return __('Customer Statement');
	}
   
	public function getCustomerName()
    {
        return $this->getName() ;
    }
	// do not use this directly use 
    public function moneyReceived()
    {
        return $this->hasMany(MoneyReceived::class, 'customer_id', 'partner_id');
    }
	public function getPartnerId():int
	{
		return $this->customer_id;
	}
	
	public function getCollectedAmountAttribute($val)
    {
        return $val ;
    }
	public function getCustomerId()
    {
        return $this->customer_id ;
    }
   
	
	public function isCollected()
	{
		return $this->getStatus() === 'collected'; 
 	}
	
	
	
	public function getNetBalanceUntil(string $date)
	{
		$invoiceId = $this->getId();
		$partnerId = $this->getCustomerId();
		$netInvoiceAmount = $this->getNetInvoiceAmount();
		$totalWithhold = $this->getWithholdAmount();
		$totalCollected = 0 ;
		$moneyReceives = $this->moneyReceived->where(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,'<=',$date) ;
		foreach($moneyReceives as $moneyReceived) {
			foreach($moneyReceived->getSettlementsForInvoiceNumber($invoiceId, $partnerId)  as $settlement) {
				$totalCollected += $settlement->getAmount();
			}
		}
		return $netInvoiceAmount - $totalCollected - $totalWithhold;
	}
	

	
	
	
	public function customer()
	{
		return $this->belongsTo(Partner::class,self::CLIENT_ID_COLUMN_NAME,'id');
	}
	public static function formatInvoices(array $invoices,int $inEditMode):array 
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
			$result[$index]['project_name'] = $invoiceArr['project_name'];

			// $result[$index]['collected_amount'] = $inEditMode 	?  (double)$invoiceArr['collected_amount'] - (double) $invoiceArr['settlement_amount']  : (double)$invoiceArr['collected_amount'];
			$result[$index]['collected_amount'] =  $inEditMode 	?  (double)$invoiceArr['collected_amount'] - (double) $invoiceArr['settlement_amount']  : (double)$invoiceArr['collected_amount'];
			$result[$index]['net_balance'] = $inEditMode ? $invoiceArr['net_balance'] +  $invoiceArr['settlement_amount']  + (double) $invoiceArr['withhold_amount'] : $invoiceArr['net_balance']  ;
			$result[$index]['settlement_amount'] = $inEditMode ? $invoiceArr['settlement_amount'] : 0;
			$result[$index]['withhold_amount'] = $inEditMode ? $invoiceArr['withhold_amount'] : 0;
			$result[$index]['invoice_date'] = Carbon::make($invoiceArr['invoice_date'])->format('d-m-Y');
			$result[$index]['invoice_due_date'] = Carbon::make($invoiceArr['invoice_due_date'])->format('d-m-Y');
		}
		return $result;
	}
	public static function hasProjectNameColumn()
	{
		return DB::table('customer_invoices')->where('company_id',getCurrentCompanyId())->where('project_name','!=',null)->count();
	}
	public function getProjectName()
	{
		return $this->project_name ?: '--';
	}
	public static function getSettlementsTemplate(string $invoiceNumber = null , string $dueDateFormatted = null , string $invoiceDueDateFormatted = null , string $invoiceCurrency = null , $netInvoiceAmountFormatted = 0 , $collectedAmountFormatted = 0,$netBalanceFormatted = 0 , $settlementAmount = 0 ,$withholdAmount = 0 )
	{
		$projectDiv = "";
		$hasProjectNameColumn = self::hasProjectNameColumn();
		if($hasProjectNameColumn){
			$projectDiv = '<div class="col-md-1 width-17">
					<label>'. __('Project Name') .'</label>
					<div class="kt-input-icon">
						<div class="kt-input-icon">
							<div class="input-group date">
								<input readonly class="form-control js-project-name" name="settlements['.$invoiceNumber.'][project_name]" value="">
							</div>
						</div>
					</div>
				</div>';
		}
		return  '
		<div class=" kt-margin-b-10 border-class">
			<div class="form-group row align-items-end">
			
			'. $projectDiv .'
				
				<div class="col-md-1 width-10">
					<label>'. __('Invoice Number') .'</label>
					<div class="kt-input-icon">
						<div class="kt-input-icon">
							<div class="input-group date">
								<input type="hidden" name="settlements['.$invoiceNumber.'][invoice_id]" value="0" class="js-invoice-id">
								<input readonly class="form-control js-invoice-number" data-invoice-id="0" name="settlements['.$invoiceNumber.'][invoice_number]" value="'. $invoiceNumber .'">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1 width-9">
					<label>'.__('Invoice Date').'</label>
					<div class="kt-input-icon">
						<div class="input-group date">
							<input name="settlements['.$invoiceNumber.'][invoice_date]" value="'.$dueDateFormatted.'" type="text" class="form-control js-invoice-date" disabled />
						</div>
					</div>
				</div>
				<div class="col-md-1 width-9">
					<label>'.__('Due Date').'</label>
					<div class="kt-input-icon">
						<div class="input-group date">
							<input name="settlements['.$invoiceNumber.'][invoice_due_date]" type="text" value="'.$invoiceDueDateFormatted.'" class="form-control js-invoice-due-date" disabled />
						</div>
					</div>
				</div>
				
				<div class="col-md-1 width-12 common-parent-js">
					<label> '. __('Invoice Amount')  .' [ '. '<span class="currency-span"></span>' .' ] ' .' </label>
					<div class="kt-input-icon">
						<input name="settlements['.$invoiceNumber.'][net_invoice_amount]" value="'.$netInvoiceAmountFormatted.'" type="text" disabled class="form-control js-net-invoice-amount">
					</div>
				</div>
				<div class="col-md-2 width-12">
					<label> '. __('Collected Amount') .'</label>
					<div class="kt-input-icon">
						<input name="settlements['.$invoiceNumber.'][collected_amount]" value="'. $collectedAmountFormatted .'" type="text" disabled class="form-control js-collected-amount">
					</div>
				</div>
		
				<div class="col-md-2 width-12">
					<label> '. __('Net Balance') .' </label>
					<div class="kt-input-icon">
						<input name="settlements['.$invoiceNumber.'][net_balance]" value="'.$netBalanceFormatted.'" type="text" readonly class="form-control js-net-balance">
					</div>
				</div>
		
				<div class="col-md-1 width-9.5">
					<label> '. __('Settlement Amount') .' <span class="text-danger ">*</span> </label>
					<div class="kt-input-icon">
						<input name="settlements['.$invoiceNumber.'][settlement_amount]" value="'.$settlementAmount.'" placeholder="'.__("Settlement Amount").'" type="text" class="form-control js-settlement-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
					</div>
				</div>
				<div class="col-md-1 width-9.5">
					<label> '. __('Withhold Amount') .' <span class="text-danger ">*</span> </label>
					<div class="kt-input-icon">
						<input name="settlements['.$invoiceNumber.'][withhold_amount]" value="'.$withholdAmount.'" placeholder="'. __('Withhold Amount') .'" type="text" class="form-control js-withhold-amount only-greater-than-or-equal-zero-allowed ">
					</div>
				</div>
		
			</div>
		
		</div>
		' ;
	}
	public static function getCurrencies($id = null)
	{
		return DB::table('customer_invoices')
		->when($id,function($q) use ($id){
			$q->where('id',$id);
		})
		->select('currency')
		->where('currency','!=','')
		->where('company_id',getCurrentCompanyId())
		->orderBy('currency')
		->get()
		->unique('currency')->pluck('currency','currency')->toArray();
	}
	public static function getCustomerInvoicesUnderCollectionAtDatesForContracts(array &$result , array &$totalCashInFlowArray , int $companyId , string $startDate , string $endDate,string $currency  , ?string $contractCode ,string $currentWeekYear):void
	{
		$key = __('Customers Invoices') ;

		$items = self::where('company_id',$companyId)
		
		->when($contractCode,function($builder) use ($contractCode){
			$builder->where('contract_code',$contractCode);
		})
		->where('currency',$currency)
		->where('net_balance','>',0)
		->whereBetween('invoice_due_date',[$startDate,$endDate])->get();
		$sum = $items->sum('net_balance') ;
		$invoiceNumber = $items->count() ? $items->first()->invoice_number : null ;
		if($sum ){
			$invoiceNumber = __('Invoice No.') . ' ' .  $invoiceNumber;
			$result['customers'][$key][$invoiceNumber]['weeks'][$currentWeekYear] = isset($result['customers'][$key][$invoiceNumber]['weeks'][$currentWeekYear]) ? $result['customers'][$key][$invoiceNumber]['weeks'][$currentWeekYear] + $sum :  $sum;
			$result['customers'][$key][$invoiceNumber]['total'] = isset($result['customers'][$key][$invoiceNumber]['total']) ? $result['customers'][$key][$invoiceNumber]['total']  + $sum : $sum;
			$currentTotal = $sum;
			$result['customers'][$key]['total'][$currentWeekYear] = isset($result['customers'][$key]['total'][$currentWeekYear]) ? $result['customers'][$key]['total'][$currentWeekYear] +  $currentTotal : $currentTotal ;
			$totalCashInFlowArray[$currentWeekYear] = isset($totalCashInFlowArray[$currentWeekYear]) ? $totalCashInFlowArray[$currentWeekYear] + $currentTotal : $currentTotal;
			$result['customers'][$key]['total']['total_of_total']= isset($result['customers'][$key]['total']['total_of_total']) ? $result['customers'][$key]['total']['total_of_total'] +$sum :$sum ;
		} 
	}
	
	public static function getSettlementAmountUnderDateForSpecificType(array &$result , array &$totalCashInFlowArray , string $moneyType , string $dateColumnName , string $startDate , string $endDate, ?string $contractCode , string $currentWeekYear , ?string $chequeStatus = null  , $currency = null , $companyId = null):void
	{
		/**
		 * 
		 * * في حالة لو مرر العقد فا مش محتاجين عمله لان العقد الواحد مربوط بعملة واحدة
		 */
		$totalCashInFlowKey = __('Total Cash Inflow');
		// $totalCashFlowKey = __('Net Cash (+/-)');
		$currentTypeText = [
			MoneyReceived::INCOMING_TRANSFER => __('Incoming Transfers'),
			MoneyReceived::CHEQUE => $chequeStatus == Cheque::IN_SAFE ? __('Cheques In Safe') : __('Checks Collected'),
			MoneyReceived::CASH_IN_BANK=>__('Bank Deposits'),
			MoneyReceived::CASH_IN_SAFE=>__('Cash Collections')
		][$moneyType];
		
		if($chequeStatus == Cheque::UNDER_COLLECTION){
			$currentTypeText = __('Cheques Under Collection');
		}
		
		$queryResultRaw =  DB::table('customer_invoices')
		->when($contractCode , function($query) use ($contractCode){
			$query->where('contract_code',$contractCode);
		})
		->when($currency,function($builder) use ($currency){
			$builder->where('customer_invoices.currency',$currency);
		})
		->join('settlements','settlements.invoice_id','=','customer_invoices.id')
		->join('money_received','money_received.id','=','settlements.money_received_id')
		->where('money_received.type','=',$moneyType)
		->whereBetween($dateColumnName,[$startDate,$endDate])
		->when($chequeStatus , function( $builder) use ($chequeStatus){
			$builder->join('cheques','cheques.money_received_id','=','money_received.id')->where('cheques.status',$chequeStatus);
		})
		->where('customer_invoices.company_id',$companyId)
		->selectRaw('sum(settlement_amount) as current_sum,customer_invoices.invoice_number')->first();


		if($queryResultRaw->current_sum){
			$invoiceNumber = __('Invoice No.') . ' ' .  $queryResultRaw->invoice_number ;
			$sum = $queryResultRaw->current_sum;
			$result['customers'][$currentTypeText][$invoiceNumber]['weeks'][$currentWeekYear] =  $sum;
			$result['customers'][$currentTypeText][$invoiceNumber]['total'] = isset($result['customers'][$currentTypeText][$invoiceNumber]['total']) ? $result['customers'][$currentTypeText][$invoiceNumber]['total']  + $sum : $sum;
			$currentTotal = $sum;
			$result['customers'][$currentTypeText]['total'][$currentWeekYear] = isset($result['customers'][$currentTypeText]['total'][$currentWeekYear]) ? $result['customers'][$currentTypeText]['total'][$currentWeekYear] +  $currentTotal : $currentTotal ;
			$result['customers'][$totalCashInFlowKey]['total'][$currentWeekYear] = isset($result['customers'][$totalCashInFlowKey]['total'][$currentWeekYear]) ? $result['customers'][$totalCashInFlowKey]['total'][$currentWeekYear] + $sum : $sum;
			$totalCashInFlowArray[$currentWeekYear] = isset($totalCashInFlowArray[$currentWeekYear]) ? $totalCashInFlowArray[$currentWeekYear] + $sum : $sum ;
			$result['customers'][$currentTypeText]['total']['total_of_total'] = isset($result['customers'][$currentTypeText]['total']['total_of_total']) ? $result['customers'][$currentTypeText]['total']['total_of_total'] + $sum : $sum;
		}
	
	}
	public function getDeleteByDateColumnName()
	{
		return 'invoice_date';
	}
	
}
