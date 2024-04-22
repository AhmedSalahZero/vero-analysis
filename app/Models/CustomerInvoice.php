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
					$currentData = []; 
					$currentData['date'] = $dateReceiving;
					$currentData['document_type'] = $moneyReceivedType;
					$currentData['document_no'] = $docNumber  ;
					$currentData['debit'] = 0;
					$currentData['credit'] =$moneyReceivedAmount;
					$currentData['comment'] =__('Settlement For Invoice No.') . ' ' . implode('/',$moneyReceived->settlements->pluck('invoice_number')->toArray()); ;
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
			$result[$index]['invoice_number'] = $invoiceArr['invoice_number'];
			$result[$index]['currency'] = $invoiceArr['currency'];
			$result[$index]['net_invoice_amount'] = $invoiceArr['net_invoice_amount'];

			$result[$index]['collected_amount'] = $inEditMode 	?  (double)$invoiceArr['collected_amount'] - (double) $invoiceArr['settlement_amount']  : (double)$invoiceArr['collected_amount'];
			$result[$index]['net_balance'] = $inEditMode ? $invoiceArr['net_balance'] +  $invoiceArr['settlement_amount']  + (double) $invoiceArr['withhold_amount'] : $invoiceArr['net_balance']  ;
			$result[$index]['settlement_amount'] = $inEditMode ? $invoiceArr['settlement_amount'] : 0;
			$result[$index]['withhold_amount'] = $inEditMode ? $invoiceArr['withhold_amount'] : 0;
			$result[$index]['invoice_date'] = Carbon::make($invoiceArr['invoice_date'])->format('d-m-Y');
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
				<div class="col-md-1 width-12">
					<label>'.__('Invoice Date').'</label>
					<div class="kt-input-icon">
						<div class="input-group date">
							<input name="settlements[][invoice_date]" type="text" class="form-control js-invoice-date" disabled />
							<div class="input-group-append">
								<span class="input-group-text">
									<i class="la la-calendar-check-o"></i>
								</span>
							</div>
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
						<input name="settlements[][net_balance]" type="text" disabled class="form-control js-net-balance">
					</div>
				</div>
		
				<div class="col-md-2 width-12">
					<label> '. __('Settlement Amount') .' <span class="required">*</span></label>
					<div class="kt-input-icon">
						<input name="settlements[][settlement_amount]" placeholder="'.__("Settlement Amount").'" type="text" class="form-control js-settlement-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
					</div>
				</div>
				<div class="col-md-2 width-12">
					<label> '. __('Withhold Amount') .' <span class="required">*</span></label>
					<div class="kt-input-icon">
						<input name="settlements[][withhold_amount]" placeholder="'. __('Withhold Amount') .'" type="text" class="form-control js-withhold-amount only-greater-than-or-equal-zero-allowed ">
					</div>
				</div>
		
			</div>
		
		</div>
		' ;
	}
	public static function getCurrencies()
	{
		return DB::table('customer_invoices')
		->select('currency')
		->where('currency','!=','')
		->where('company_id',getCurrentCompanyId())
		->orderBy('currency')
		->get()
		->unique('currency')->pluck('currency','currency')->toArray();
	}
}
