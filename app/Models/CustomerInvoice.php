<?php

namespace App\Models;

use App\Helpers\HArr;
use App\Interfaces\Models\IInvoice;
use App\Traits\Models\IsInvoice;
use App\Traits\StaticBoot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
	const TABLE_NAME = 'customer_invoices';
	const JS_FILE = 'money-receive.js';
	const COLLETED_OR_PAID = 'collected';
	const PARTIALLY_COLLECTED_OR_PAID_AND_PAST_DUE = 'partially_collected_and_past_due';
	const MONEY_MODEL_NAME = 'MoneyReceived';
	const AGING_CHEQUE_MODEL_NAME = 'Cheque';
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
        return $this->hasMany(MoneyReceived::class, self::CLIENT_NAME_COLUMN_NAME, self::CLIENT_NAME_COLUMN_NAME)->where('company_id',getCurrentCompanyId());
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
		$invoiceNumber = $this->getInvoiceNumber();
		$customerName = $this->getName();
		$netInvoiceAmount = $this->getNetInvoiceAmount();
		$totalWithhold = $this->getWithholdAmount();
		$totalCollected = 0 ;
		$moneyReceives = $this->moneyReceived->where(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,'<=',$date) ;
		foreach($moneyReceives as $moneyReceived) {
			foreach($moneyReceived->getSettlementsForInvoiceNumber($invoiceNumber, $customerName)  as $settlement) {
				$totalCollected += $settlement->getAmount();
			}
		}
		return $netInvoiceAmount - $totalCollected - $totalWithhold;
	}
	



	

	public static function formatForStatementReport(Collection $customerInvoices,string $customerName,string $startDate,string $endDate,string $currency){
			$startDateFormatted = Carbon::make($startDate)->format('d-m-Y');
			$index = -1 ;
			/**
			 * @var CustomerInvoice $firstCustomerInvoice
			 */
			$oneDayBeforeStartDate = Carbon::make($startDate)->subDays(1000)->format('Y-m-d');
			$beginningBalance = self::getBeginningBalanceUntil($currency,$customerName,$oneDayBeforeStartDate,$startDate) ; 
			$formattedData = [];
			$currentData['date'] = $startDateFormatted;
			$currentData['document_type'] = 'Beginning Balance';
			$currentData['document_no'] = null;
			$currentData['debit'] = $debit = $beginningBalance >= 0 ? $beginningBalance : 0;
			$currentData['credit'] = $credit = $beginningBalance < 0 ? $beginningBalance * -1 : 0 ;
			$currentData['end_balance'] =$debit - $credit;
			$currentData['comment'] =null;
			$index++ ;
			$formattedData[$index] = $currentData;
			$allMoneyReceived =  MoneyReceived::
			where('company_id',getCurrentCompanyId())
			->whereBetween(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,[$startDate,$endDate])
			->where('currency',$currency)
			->where(self::CLIENT_NAME_COLUMN_NAME,$customerName)
			->get() ; 
		
		foreach($customerInvoices as $customerInvoice){
			$currentData = [];
			$invoiceDate = $customerInvoice->getInvoiceDateFormatted() ;
			$invoiceNumber  = $customerInvoice->getInvoiceNumber($customerName) ;
			$currentData['date'] = $invoiceDate;
			$currentData['document_type'] = 'Invoice';
			$currentData['document_no'] = $invoiceNumber;
			$currentData['debit'] = $customerInvoice->getNetInvoiceAmount();
			$currentData['credit'] =0;
			$currentData['comment'] =null;
			$index++ ;
			$formattedData[$index]=$currentData;
		}
		foreach($allMoneyReceived as $moneyReceived) {
			$dateReceiving = $moneyReceived->getReceivingDateFormatted() ;
			$moneyReceivedType = $moneyReceived->getType();
			$bankName = $moneyReceived->getBankName();
			$docNumber = $moneyReceived->getNumber();
				$moneyReceivedAmount = $moneyReceived->getReceivedAmount() ;
				if($moneyReceivedAmount){
					$isDownPayment = $moneyReceived->isDownPayment() ;
					$currentComment = $isDownPayment ?  __('Down Payment For Contract :contractName',['contractName'=>$moneyReceived->contract->getName()]) :__('Settlement For Invoice No.') . ' ' . implode('/',$moneyReceived->settlements->pluck('invoice_number')->toArray());
					$currentData = []; 
					$currentData['date'] = $dateReceiving;
					$currentData['document_type'] = $moneyReceivedType;
					$currentData['document_no'] = $docNumber  ;
					$currentData['debit'] = 0;
					$currentData['credit'] =$moneyReceivedAmount;
					$currentData['comment'] = $currentComment ;
					$index++;
					$formattedData[] = $currentData ;
					$totalWithholdAmount = $moneyReceived->getTotalWithholdAmount();
					
					if($totalWithholdAmount){
						$currentData = []; 
					$currentData['date'] = $dateReceiving;
					$currentData['document_type'] = __('Withhold Taxes');
					$currentData['document_no'] =  $docNumber ;
					$currentData['debit'] = 0;
					$currentData['credit'] =$totalWithholdAmount;
					$currentData['comment'] =$bankName;
					$currentData['comment'] =__('Withhold Taxes For Invoice No.') . ' ' . implode('/',$moneyReceived->settlements->where('withhold_amount','>',0)->pluck('invoice_number')->toArray());
					$index++;
					$formattedData[] = $currentData ;
					}
				}
		}
		return HArr::sortBasedOnKey($formattedData,'date');
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
			
			$result[$index]['invoice_number'] = $invoiceArr['invoice_number'];
			$result[$index]['currency'] = $invoiceArr['currency'];
			$result[$index]['net_invoice_amount'] = $invoiceArr['net_invoice_amount'];

			$result[$index]['collected_amount'] = $inEditMode 	?  (double)$invoiceArr['collected_amount'] - (double) $invoiceArr['settlement_amount']  : (double)$invoiceArr['collected_amount'];
			$result[$index]['net_balance'] = $inEditMode ? $invoiceArr['net_balance'] +  $invoiceArr['settlement_amount']  + (double) $invoiceArr['withhold_amount'] : $invoiceArr['net_balance']  ;
			$result[$index]['settlement_amount'] = $inEditMode ? $invoiceArr['settlement_amount'] : 0;
			$result[$index]['withhold_amount'] = $inEditMode ? $invoiceArr['withhold_amount'] : 0;
			$result[$index]['invoice_date'] = Carbon::make($invoiceArr['invoice_date'])->format('d-m-Y');
			$result[$index]['invoice_due_date'] = Carbon::make($invoiceArr['invoice_due_date'])->format('d-m-Y');
		}
		return $result;
	}
	public static function getSettlementsTemplate()
	{
		return  '
		<div class=" kt-margin-b-10 border-class">
			<div class="form-group row align-items-end">
				<div class="col-md-1 width-10">
					<label>'. __('Invoice Number') .'</label>
					<div class="kt-input-icon">
						<div class="kt-input-icon">
							<div class="input-group date">
								<input readonly class="form-control js-invoice-number" name="settlements[][invoice_number]" value="0">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1 width-8">
					<label>'.__('Invoice Date').'</label>
					<div class="kt-input-icon">
						<div class="input-group date">
							<input name="settlements[][invoice_date]" type="text" class="form-control js-invoice-date" disabled />
						</div>
					</div>
				</div>
				<div class="col-md-1 width-8">
					<label>'.__('Due Date').'</label>
					<div class="kt-input-icon">
						<div class="input-group date">
							<input name="settlements[][invoice_due_date]" type="text" class="form-control js-invoice-due-date" disabled />
						</div>
					</div>
				</div>
				<div class="col-md-1 width-8">
					<label> '. __('Currency') .' </label>
					<div class="kt-input-icon">
						<input name="settlements[][currency]" type="text" disabled class="form-control js-currency">
					</div>
				</div>
				<div class="col-md-1 width-12">
					<label> '. __('Net Invoice Amount') .' </label>
					<div class="kt-input-icon">
						<input name="settlements[][net_invoice_amount]" type="text" disabled class="form-control js-net-invoice-amount">
					</div>
				</div>
				<div class="col-md-2 width-12">
					<label> '. __('Collected Amount') .'</label>
					<div class="kt-input-icon">
						<input name="settlements[][collected_amount]" type="text" disabled class="form-control js-collected-amount">
					</div>
				</div>
		
				<div class="col-md-2 width-12">
					<label> '. __('Net Balance') .' </label>
					<div class="kt-input-icon">
						<input name="settlements[][net_balance]" type="text" readonly class="form-control js-net-balance">
					</div>
				</div>
		
				<div class="col-md-2 width-12">
					<label> '. __('Settlement Amount') .' <span class="text-danger ">*</span> </label>
					<div class="kt-input-icon">
						<input name="settlements[][settlement_amount]" placeholder="'.__("Settlement Amount").'" type="text" class="form-control js-settlement-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
					</div>
				</div>
				<div class="col-md-2 width-12">
					<label> '. __('Withhold Amount') .' <span class="text-danger ">*</span> </label>
					<div class="kt-input-icon">
						<input name="settlements[][withhold_amount]" placeholder="'. __('Withhold Amount') .'" type="text" class="form-control js-withhold-amount only-greater-than-or-equal-zero-allowed ">
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
		$sum = $items->sum('net_invoice_amount') ;
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
	public static function getCustomerInvoicesUnderCollectionAtDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
	
		$items = self::where('company_id',$companyId)
		->where('currency',$currency)
		->where('net_balance','>',0)
		->whereBetween('invoice_due_date',[$startDate,$endDate])->get();
		return $items->sum('net_invoice_amount');
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
		->join('settlements','settlements.invoice_number','=','customer_invoices.invoice_number')
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
			// dd($queryResultRaw);
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
	
}
