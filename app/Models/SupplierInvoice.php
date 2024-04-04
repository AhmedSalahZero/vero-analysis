<?php

namespace App\Models;

use App\Helpers\HArr;
use App\Interfaces\Models\IInvoice;
use App\Traits\Models\IsInvoice;
use App\Traits\StaticBoot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
       'invoice_date'
    ];
	
	const UNAPPLIED_SETTLEMENT_TABLE = 'paymentSettlements';
	const CLIENT_NAME_COLUMN_NAME = 'supplier_name';
	const CLIENT_ID_COLUMN_NAME = 'supplier_id';
	const JS_FILE = 'money-payment.js';
	const RECEIVED_OR_PAYMENT_AMOUNT = 'paid_amount';
	const RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME = 'delivery_date';
	const MONEY_RECEIVED_OR_PAYMENT_TABLE_NAME = 'money_payments';
	const TABLE_NAME = 'supplier_invoices';
	const COLLETED_OR_PAID = 'paid';
	const PARTIALLY_COLLECTED_OR_PAID_AND_PAST_DUE = 'partially_paid_and_past_due';
	const MONEY_MODEL_NAME = 'MoneyPayment';
	const AGING_CHEQUE_MODEL_NAME = 'PayableCheque';

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
        return $this->hasMany(MoneyPayment::class, self::CLIENT_NAME_COLUMN_NAME, self::CLIENT_NAME_COLUMN_NAME)->where('company_id',getCurrentCompanyId());
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
	
	
	
	public function getNetBalanceUntil(string $date)
	{
		$invoiceNumber = $this->getInvoiceNumber();
		$supplierName = $this->getName();
		$netInvoiceAmount = $this->getNetInvoiceAmount();
		$totalWithhold = $this->getWithholdAmount();
		$totalPaid = 0 ;
		$payments = $this->moneyPayment->where(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,'<=',$date) ;
		foreach($payments as $moneyPayment) {
			foreach($moneyPayment->getSettlementsForInvoiceNumber($invoiceNumber, $supplierName)  as $settlement) {
				$totalPaid += $settlement->getAmount();
			}
		}
		return $netInvoiceAmount - $totalPaid - $totalWithhold;
	}
	

	public static function getBeginningBalanceUntil( string $currencyName, string $supplierName,string $date)
	{
		$totalInvoicesPlusVatAmount  = self::getTotalInvoicesPlusVatAmountUntilDate($currencyName,$supplierName,$date);
		$totalMoneyReceivedAmountPlusWithhold = self::getTotalMoneyAmountPlusWithhold($currencyName,$supplierName,$date);
		return $totalInvoicesPlusVatAmount - $totalMoneyReceivedAmountPlusWithhold;
		
	}

	
	public static function getTotalMoneyAmountPlusWithhold( string $currencyName, string $supplierName,string $date)
	{
		
		return DB::table(self::MONEY_RECEIVED_OR_PAYMENT_TABLE_NAME)
		->where('company_id',getCurrentCompanyId())
		->where(self::CLIENT_NAME_COLUMN_NAME,$supplierName)
		->where('currency',$currencyName)
		->where(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,'<=',$date)
		->sum(DB::raw('total_withhold_amount + '.self::RECEIVED_OR_PAYMENT_AMOUNT));
	}
	public static function formatForStatementReport(Collection $supplierInvoices,string $supplierName,string $startDate,string $endDate,string $currency){
			$startDateFormatted = Carbon::make($startDate)->format('d-m-Y');
			$index = -1 ;
			$firstSupplierInvoice = $supplierInvoices->first() ?: null; 
			$oneDayBeforeStartDate = Carbon::make($startDate)->subDay()->format('Y-m-d');
			$beginningBalance = $firstSupplierInvoice ? $supplierInvoices->first()->getBeginningBalanceUntil($currency,$supplierName,$oneDayBeforeStartDate) : 0; 
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
			$allMoneyPayments =  MoneyPayment::
			where('company_id',getCurrentCompanyId())
			->whereBetween(self::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME,[$startDate,$endDate])
			->where('currency',$currency)
			->where(self::CLIENT_NAME_COLUMN_NAME,$supplierName)
			->get() ; 
		foreach($supplierInvoices as $supplierInvoice){
			$currentData = [];
			$invoiceDate = $supplierInvoice->getInvoiceDateFormatted() ;
			$invoiceNumber  = $supplierInvoice->getInvoiceNumber($supplierName) ;
			$currentData['date'] = $invoiceDate;
			$currentData['document_type'] = 'Invoice';
			$currentData['document_no'] = $invoiceNumber;
			$currentData['debit'] = $supplierInvoice->getNetInvoiceAmount();
			$currentData['credit'] =0;
			$currentData['comment'] =null;
			$index++ ;
			$formattedData[$index]=$currentData;
		}
		foreach($allMoneyPayments as $moneyPayment) {
			$deliveryDate = $moneyPayment->getDeliveryDateFormatted() ;
			$moneyPaymentType = $moneyPayment->getType();
			$bankName = $moneyPayment->getBankName();
			$docNumber = $moneyPayment->getNumber();
				$moneyPaymentAmount = $moneyPayment->getPaidAmount() ;
				if($moneyPaymentAmount){
					$currentData = []; 
					$currentData['date'] = $deliveryDate;
					$currentData['document_type'] = $moneyPaymentType;
					$currentData['document_no'] = $docNumber  ;
					$currentData['debit'] = 0;
					$currentData['credit'] =$moneyPaymentAmount;
					$currentData['comment'] =__('Settlement For Invoice No.') . ' ' . implode('/',$moneyPayment->settlements->pluck('invoice_number')->toArray()); ;
					$index++;
					$formattedData[] = $currentData ;
					$totalWithholdAmount = $moneyPayment->getTotalWithholdAmount();
					
					if($totalWithholdAmount){
						$currentData = []; 
					$currentData['date'] = $deliveryDate;
					$currentData['document_type'] = __('Withhold Taxes');
					$currentData['document_no'] =  $docNumber ;
					$currentData['debit'] = 0;
					$currentData['credit'] =$totalWithholdAmount;
					$currentData['comment'] =$bankName;
					$currentData['comment'] =__('Withhold Taxes For Invoice No.') . ' ' . implode('/',$moneyPayment->settlements->where('withhold_amount','>',0)->pluck('invoice_number')->toArray());
					$index++;
					$formattedData[] = $currentData ;
					}
				}
		}
		return HArr::sortBasedOnKey($formattedData,'date');
	}
	
	public function supplier()
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

			$result[$index]['paid_amount'] = $inEditMode 	?  (double)$invoiceArr['paid_amount'] - (double) $invoiceArr['settlement_amount']  : (double)$invoiceArr['paid_amount'];
			$result[$index]['net_balance'] = $inEditMode ? $invoiceArr['net_balance'] +  $invoiceArr['settlement_amount']  + (double) $invoiceArr['withhold_amount'] : $invoiceArr['net_balance']  ;
			$result[$index]['settlement_amount'] = $inEditMode ? $invoiceArr['settlement_amount'] : 0;
			$result[$index]['withhold_amount'] = $inEditMode ? $invoiceArr['withhold_amount'] : 0;
			$result[$index]['invoice_date'] = Carbon::make($invoiceArr['invoice_date'])->format('d-m-Y');
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
					<input name="settlements[][paid_amount]" type="text" disabled class="form-control ">
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
					<input name="settlements[][settlement_amount]" placeholder="'.__('Settlement Amount').'" type="text" class="form-control js-settlement-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
				</div>
			</div>
			<div class="col-md-2 width-12">
				<label>'. __('Withhold Amount') .' <span class="required">*</span></label>
				<div class="kt-input-icon">
					<input name="settlements[][withhold_amount]" placeholder="'.__('Withhold Amount').'" type="text" class="form-control js-withhold-amount only-greater-than-or-equal-zero-allowed ">
				</div>
			</div>

		</div>

	</div>
		
		';
	}
	
}
