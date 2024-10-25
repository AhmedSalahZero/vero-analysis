<?php

namespace App\Models;

use App\Http\Controllers\MoneyPaymentController;
use App\Models\OpeningBalance;
use App\Models\OutgoingTransfer;
use App\Traits\Models\HasCreditStatements;
use App\Traits\Models\HasPartnerStatement;
use App\Traits\Models\HasReviewedBy;
use App\Traits\Models\IsMoney;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MoneyPayment extends Model
{
	use IsMoney ,HasCreditStatements,HasPartnerStatement,HasReviewedBy;
	const CASH_PAYMENT  = 'cash_payment';
	const PAYABLE_CHEQUE  = 'payable_cheque';
	const OUTGOING_TRANSFER  = 'outgoing-transfer';
	const INVOICE_SETTLEMENT_WITH_DOWN_PAYMENT = 'invoice-settlement-with-down-payment';
	const DOWN_PAYMENT = 'down-payment';
	const CLIENT_NAME ='supplier_name';
	public static function generateComment(self $moneyPayment,string $lang)
	{
		$supplierName = $moneyPayment->getSupplierName();
		$paidInvoiceNumbers = getKeysWithSettlementAmount(Request()->get('settlements',[]),'settlement_amount');
		
		if($moneyPayment->isPayableCheque()){
			$chequeNumber = $moneyPayment->getPayableChequeNumber()?:Request('cheque_number');
			if($moneyPayment->isOpenBalance()){
				return __('Opening Balance Payable Cheque To [ :supplierName ]' , ['supplierName'=>$supplierName],$lang);
			}
			if($moneyPayment->isDownPayment()){
				return __('Down Payment - Cheque From :name [ :contractName ] [ :contractCode ] With Number [ :number ]',['name'=>$supplierName,'contractName'=>$moneyPayment->getContractName(),'contractCode'=>$moneyPayment->getContractCode(),'number'=>$chequeNumber],$lang) ;
			}
			if($moneyPayment->isInvoiceSettlementWithDownPayment()){
				return __('Cheque From :name With Number [ :number ] Settled Invoices [ :numbers ] [ :currency ] | Down Payment - [ :contractName ] [ :contractCode ]',[
					'name'=>$supplierName ,
					'numbers'=>$paidInvoiceNumbers ,
					'currency'=>$moneyPayment->getCurrency(),
					'contractName'=>$moneyPayment->getContractName(),
					'contractCode'=>$moneyPayment->getContractCode()
				]);
			}
			if($moneyPayment->getPartnerType()!='is_supplier'){
				return __('Payable Cheque To :name With Number [:number ] [ :partnerType ]',['name'=>$supplierName,'number'=>$chequeNumber,'partnerType'=>$moneyPayment->getPartnerTypeFormatted()],$lang);
			}
			return __('Payable Cheque To :name With Number [:number ] Paid Invoices [ :numbers ] [ :currency ]',['name'=>$supplierName,'number'=>$chequeNumber,'numbers'=>$paidInvoiceNumbers,'currency'=>$moneyPayment->getCurrency()],$lang) ;
		}
		if($moneyPayment->isCashPayment()){
			
			if($moneyPayment->isInvoiceSettlementWithDownPayment()){
				return __('Cash To :name Settled Invoices [ :numbers ] [ :currency ] | Down Payment - [ :contractName ] [ :contractCode ]',[
					'name'=>$supplierName ,
					'numbers'=>$paidInvoiceNumbers ,
					'currency'=>$moneyPayment->getCurrency(),
					'contractName'=>$moneyPayment->getContractName(),
					'contractCode'=>$moneyPayment->getContractCode()
				]);
			}
			if($moneyPayment->getPartnerType()!='is_supplier'){
				return __('Cash Payment To :name [ :partnerType ]',['name'=>$supplierName,'partnerType'=>$moneyPayment->getPartnerTypeFormatted()],$lang);
			}
			return __('Cash Payment To :name Paid Invoices [ :numbers ]',['name'=>$supplierName,'numbers'=>$paidInvoiceNumbers],$lang) ;
		}
		if($moneyPayment->isOutgoingTransfer()){
			if($moneyPayment->getPartnerType()!='is_supplier'){
				return __('Outgoing Transfer To :name [ :partnerType ]',['name'=>$supplierName,'partnerType'=>$moneyPayment->getPartnerTypeFormatted()],$lang);
			}
			return __('Outgoing Transfer To :name Paid Invoices [ :numbers ]',['name'=>$supplierName,'numbers'=>$paidInvoiceNumbers],$lang) ;
		}
	}
	protected static function booted()
	{
		self::creating(function (self $moneyPayment): void {
			$moneyPayment->comment_en = self::generateComment($moneyPayment,'en');
			$moneyPayment->comment_ar = self::generateComment($moneyPayment,'ar');
		});
		
	}
	
	
	public static function getAllTypes()
	{
		return [
			self::CASH_PAYMENT,
			self::PAYABLE_CHEQUE,
			self::OUTGOING_TRANSFER,
		];
	}
	
    protected $guarded = ['id'];
    protected $table = 'money_payments';
    
	
    public function isCashPayment()
    {
        return $this->getType() ==self::CASH_PAYMENT;
    }
	public function isPayableCheque()
    {
        return $this->getType() ==self::PAYABLE_CHEQUE;
    }
  
    public function isOutgoingTransfer()
    {
        return $this->getType() ==self::OUTGOING_TRANSFER;
    }
    public function getSupplierName()
    {
        return $this->supplier_name;
    }
	public function supplier()
	{
		return $this->belongsTo(Partner::class,'supplier_name','name')->where('is_supplier',1)->where('company_id',getCurrentCompanyId());
	}
	public function getSupplierId()
	{
		return $this->supplier ? $this->supplier->id : 0 ;
	}
	public function getName()
	{
		return $this->getSupplierName();
	}
    public function getDeliveryDate()
    {
        return $this->delivery_date;
    }
    public function getCashPaymentBranchId()
    {
		$cashPayment = $this->cashPayment ;
        return  $cashPayment ? $cashPayment->getDeliveryBranchId() :0;
    }
    public function getPaidAmount()
    {
        return  $this->paid_amount?:0 ;
    }
	public function getAmount()
	{
		return $this->getPaidAmount();
	}
	
	public function getPayableChequeDueDate(){
		return $this->payableCheque ? $this->payableCheque->getDueDate(): null;
	}
	public function getOutgoingTransferDueDate(){
		return $this->outgoingTransfer ? $this->outgoingTransfer->actualPaymentDate(): null;
	}
	public function getPayableChequeNumber()
	{
		return $this->payableCheque ? $this->payableCheque->getChequeNumber():null;
	}
	public function getPaidAmountFormatted()
    {
        return number_format($this->getPaidAmount()) ;
    }

	public function getCurrency()
	{
		return $this->currency;
	}
	
	public function getCurrencyFormatted()
	{
		return strtoupper($this->currency);
	}

	public function getCurrencyToPaymentCurrencyFormatted()
	{
		$currency = $this->getCurrency();
		$paymentCurrency = $this->getPaymentCurrency();
		if($currency == $paymentCurrency || is_null($paymentCurrency)){
			return $this->getCurrencyFormatted();
		}
		return $this->getCurrencyFormatted().'/'.$this->getPaymentCurrencyFormatted();
		
	}
	
	public function getPaymentCurrency()
	{
		return $this->payment_currency;
	}
	
	public function getPaymentCurrencyFormatted()
	{
		return strtoupper($this->getPaymentCurrency());
	}
	
	public function getExchangeRate()
	{
		
		return $this->exchange_rate?:1;
	}
	public function getPaymentBankName()
	{
		return '-';
	}


    public function getCashPaymentReceiptNumber()
    {
		$cashPayment = $this->cashPayment;
        return $cashPayment ? $cashPayment->getReceiptNumber() :  null ;
    }

  
	public function getNumber()
	{
		if($this->isPayableCheque()){
			return $this->payableCheque->getChequeNumber();
		}
		if($this->isCashPayment()){
			return $this->getCashPaymentReceiptNumber();
		}
		if($this->isOutgoingTransfer()){
			return $this->getOutgoingTransferAccountNumber();
		}
	}
	

	
	public function getBankName()
	{
		if($this->isCashPayment()){
			return $this->getCashPaymentBranchName();
		}
		if($this->isPayableCheque()){
			return $this->payableCheque->getDeliveryBankName();
		}
		if($this->isOutgoingTransfer()){
			return $this->getOutgoingTransferDeliveryBankName(app()->getLocale());
		}
		
	}
	
	public function outgoingTransfer()
	{
		return $this->hasOne(OutgoingTransfer::class,'money_payment_id','id');
	}

    public function getOutgoingTransferDeliveryBankId()
    {
		$outgoingTransfer = $this->outgoingTransfer ;
        return $outgoingTransfer ? $outgoingTransfer->getDeliveryBankId() : 0 ;
    }
	public function outgoingTransferDeliveryBank():?FinancialInstitution
	{
		/**
		 * @var OutgoingTransfer $outgoingTransfer 
		 */
		$outgoingTransfer = $this->outgoingTransfer ;
		
		return $outgoingTransfer ? $outgoingTransfer->deliveryBank() : null ;
	}
	public function getOutgoingTransferDeliveryBankName()
	{
		/**
		 * @var OutgoingTransfer $outgoingTransfer 
		 */
		$outgoingTransfer = $this->outgoingTransfer ;
        return $outgoingTransfer ? $outgoingTransfer->getDeliveryBankName() : __('N/A') ;
	}
	
	
	/**
	 * * For Supplier Payment Only
	 */
	
	/**
	 * * كل كل ال settlements
	 * * ودا بيشمل في حاله مثلا لو كان عندك
	 * * money payment with down payment
	 * * فا هتجيب كل ال settlements
	 * * سواء اللي اتعملت مع ال money payment
	 * * او اللي اتعملت مع ال down payment 
	 * * الخاصه بيها 
	 * * خلي بالك ان الاتنين مع بعض سواء ال 
	 * * money payment or its down payment
	 * * وبالتالي الاتنين ليهم نفس الاي دي
	 */
    public function settlements()
    {
        return $this->hasMany(PaymentSettlement::class, 'money_payment_id', 'id');
    }
	/**
	 * * هتفرق عن اللي فاتت بس في حاله ال
	 * * money received with down payment
	 * * دي هتجيب بس اللي اتعملت في ال 
	 * * money received 
	 * * نفسها
	 * * اما في باقي ال
	 * * types مش هتفرق لان مش بينزل معاهم داون بيمنت
	 */
	public function settlementsForMoneyPayment()
    {
        return $this->hasMany(PaymentSettlement::class, 'money_payment_id', 'id')->where('is_from_down_payment',0);
    }
	public function settlementsForDownPaymentThatComeFromMoneyModel()
    {
        return $this->hasMany(PaymentSettlement::class, 'money_payment_id', 'id')->where('is_from_down_payment',1);
    }
	
	/**
	 * * For Down Payment Only
	 */
    public function downPaymentSettlements()
    {
        return $this->hasMany(DownPaymentMoneyPaymentSettlement::class, 'money_payment_id', 'id');
    }
    public function supplierInvoice()
    {
        return $this->belongsTo(SupplierInvoice::class, 'supplier_name', 'supplier_name');
    }

	public function getSettlementsForCustomerName( string $supplierName):Collection
    {
        return $this->settlements->where('supplier_name', $supplierName) ;
    }
    public function getSettlementsForInvoiceNumber($invoiceNumber, string $supplierName,bool $isFromDownPayment = null):Collection
    {
		$settlements = $this->settlements ;
		if($isFromDownPayment == true){
			$settlements = $this->settlementsForDownPaymentThatComeFromMoneyModel;
		}
		if($isFromDownPayment == false){
			$settlements = $this->settlementsForMoneyPayment;
		}
        return $settlements->where('invoice_number', $invoiceNumber)->where('supplier_name', $supplierName) ;
    }
	public function getSettlementsForInvoiceNumberAmount($invoiceNumber, string $supplierName,bool $isFromDownPayment =null):float{
		return $this->getSettlementsForInvoiceNumber($invoiceNumber,$supplierName,$isFromDownPayment)->sum('settlement_amount');
	}
	public function getWithholdForInvoiceNumberAmount($invoiceNumber, string $supplierName,bool $isFromDownPayment =null):float{
		return $this->getSettlementsForInvoiceNumber($invoiceNumber,$supplierName,$isFromDownPayment)->sum('withhold_amount');
	}
	public function getDate()
	{
		return $this->getDeliveryDate();
	}
    public function getDeliveryDateFormatted()
    {
        $date = $this->getDeliveryDate() ;
        if($date) {
            return Carbon::make($date)->format('d-m-Y');
        }
    }
	public function setDeliveryDateAttribute($value)
	{
		if(is_object($value)){
			return $value ;
		}
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['delivery_date'] = $value;
			return  ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$this->attributes['delivery_date'] = $year.'-'.$month.'-'.$day;
		
	}
	
	public static function getUniqueBanks( $banks):array{
		$uniqueBanksIds = [];
		foreach($banks as $bankId){
				$uniqueBanksIds[$bankId] = $bankId;
		}
		return $uniqueBanksIds; 
	}
	
	public function cashPaymentDeliveryBranch()
	{
		/**
		 * @var CashPayment $cashPayment
		 */
		$cashPayment = $this->cashPayment;
		return $cashPayment ? $cashPayment->deliveryBranch : null ;
	}
	public function getCashPaymentBranchName()
	{
		$cashPayment = $this->cashPayment;

		return $cashPayment ? $cashPayment->getDeliveryBranchName() : null ;
	}
	
	public function getPayableChequeDeliveryDate()
	{
		$payable = $this->payableCheque;
		return $payable ? $payable->getDeliveryDate() : null;
	}
	public function getPayableChequeDeliveryDateFormattedForDatePicker()
	{
		$date = $this->getPayableChequeDeliveryDate();
		return $date ? Carbon::make($date)->format('m/d/Y') : null;
	}
	public function getChequeDeliveryDateFormatted()
	{
		$date = $this->getPayableChequeDeliveryDate();
		return $date ? Carbon::make($date)->format('d-m-Y') : null;
	}

	
	public function getPayableChequePaymentBankId()
	{
		$payableCheque = $this->payableCheque ;
		return $payableCheque ? $payableCheque->getDeliveryBankId() : null ;
	}
	public function getPayableChequeAccountType()
	{
		$payableCheque = $this->payableCheque ;
		return $payableCheque ? $payableCheque->getAccountType() : null ;
	}
	
	// public function getPayableChequeAccountNumber()
	// {
	// 	$payableCheque = $this->payableCheque ;
	// 	return $payableCheque ? $payableCheque->getAccountNumber() : null ;
	// }
	
	public function cashPayment()
	{
		return $this->hasOne(CashPayment::class,'money_payment_id','id');
	}
	
	public function payableCheque()
	{
		return $this->hasOne(PayableCheque::class,'money_payment_id','id');
	}

	public function getTotalWithholdAmount():float 
	{
		return $this->total_withhold_amount ?: 0 ;
	}
	public function getAccountTypeId()
	{
		if($this->isOutgoingTransfer()){
			return $this->outgoingTransfer->getAccountTypeId();
		}
		if($this->isPayableCheque()){
			return $this->payableCheque->getAccountTypeId();
		}
		throw new \Exception('Custom Exception .. getAccountTypeId .. This Method Is Only For Outgoing Transfer Or Payable Cheque');
	}
	public function getAccountNumber()
	{
		if($this->isOutgoingTransfer()){
			return $this->outgoingTransfer->getAccountNumber();
		}
		if($this->isPayableCheque()){
			return $this->payableCheque->getAccountNumber();
		}
		throw new \Exception('Custom Exception .. getAccountNumber .. This Method Is Only For Outgoing Transfer Or Payable Cheque');
	}
	public function getFinancialInstitutionId()
	{
		if($this->isOutgoingTransfer()){
			return $this->getOutgoingTransferDeliveryBankId();
		}
		if($this->isPayableCheque()){
			return $this->getPayableChequePaymentBankId();
		}
		throw new \Exception('Custom Exception .. getFinancialInstitutionId .. This Method Is Only For Outgoing Transfer Or Payable Cheque');
	}
	public function getOutgoingTransferAccountTypeId(){
		$outgoingTransfer = $this->outgoingTransfer;
		return $outgoingTransfer ? $outgoingTransfer->getAccountTypeId() : 0 ;
	}
	public function getOutgoingTransferAccountTypeName(){
		$outgoingTransfer = $this->outgoingTransfer;
		return $outgoingTransfer ? $outgoingTransfer->getAccountTypeName() : 0 ;
	}
	public function getOutgoingTransferAccountNumber(){
		$outgoingTransfer = $this->outgoingTransfer;
		return $outgoingTransfer ? $outgoingTransfer->getAccountNumber() : 0 ;
	}
	
	public function getPayableChequeAccountTypeId(){
		$payableCheque = $this->payableCheque;

		return $payableCheque ? $payableCheque->getAccountTypeId() : 0 ;
	}
	public function getPayableChequeAccountTypeName(){
		$payableCheque = $this->payableCheque;
		return $payableCheque ? $payableCheque->getAccountTypeName() : 0 ;
	}
	public function getPayableChequeAccountNumber(){
		$payableCheque = $this->payableCheque;
		return $payableCheque ? $payableCheque->getAccountNumber() : 0 ;
	}
	
	
	
	// public function unappliedAmounts()
	// {
	// 	return $this->hasMany(UnappliedAmount::class ,'model_id','id')->where('model_type',HHelpers::getClassNameWithoutNameSpace($this));	
	// }
	public function cleanOverdraftCreditBankStatement()
	{
		return $this->hasOne(CleanOverdraftBankStatement::class,'money_payment_id','id');
	}
	public function fullySecuredOverdraftCreditBankStatement()
	{
		return $this->hasOne(FullySecuredOverdraftBankStatement::class,'money_payment_id','id');
	}
	public function overdraftAgainstCommercialPaperCreditBankStatement()
	{
		return $this->hasOne(OverdraftAgainstCommercialPaperBankStatement::class,'money_payment_id','id');
	}
	public function overdraftAgainstAssignmentOfContractCreditBankStatement()
	{
		return $this->hasOne(OverdraftAgainstAssignmentOfContractBankStatement::class,'money_payment_id','id');
	}
	public function cashInSafeCreditStatement()
	{
		return $this->hasOne(CashInSafeStatement::class,'money_payment_id','id');
	}
	public function currentAccountCreditBankStatement()
	{
		return $this->hasOne(CurrentAccountBankStatement::class,'money_payment_id','id');
	}
	
	public function openingBalance()
	{
		return $this->belongsTo(OpeningBalance::class,'opening_balance_id');
	}
	public function isOpenBalance()
	{
		return $this->opening_balance_id !== null ;
	}
	
	public function isDownPayment()
	{
		return $this->getMoneyType() == 'down-payment';
	}
	public function isInvoiceSettlementWithDownPayment()
	{
		return $this->getMoneyType() == self::INVOICE_SETTLEMENT_WITH_DOWN_PAYMENT;
	}
	public function getMoneyType()
	{
		return $this->money_type; 
	}
	public function getMoneyTypeFormatted()
	{
		$moneyType = $this->getMoneyType();
		$partnerType = $this->getPartnerType();
		if($moneyType == 'money-payment'){
			$moneyType = 'invoice-settlement';
		}
		
		if($moneyType == MoneyPayment::INVOICE_SETTLEMENT_WITH_DOWN_PAYMENT){
			$moneyType = __('Invoice Settlement & Down Payment');
		}
		if($partnerType != 'is_supplier'){
			return __('Money Paid To :name [ :partnerType ]',['name'=>$this->getName(),'partnerType'=>$this->getPartnerTypeFormatted()]);	
		}
		return camelizeWithSpace($moneyType) ;
	}
	public function getContractId()
	{
		return $this->contract_id;
	}
	public function contract()
	{
		return $this->belongsTo(Contract::class,'contract_id','id');
	}
	public function getContractName()
	{
		return $this->contract ? $this->contract->getName() : __('N/A');
	}
	public function getContractCode()
	{
		return $this->contract ? $this->contract->getCode() : __('N/A');
	}
	public function getCurrentStatement()
	{
		if($this->cleanOverdraftCreditBankStatement){
			return $this->cleanOverdraftCreditBankStatement;
		}	
		if($this->fullySecuredOverdraftCreditBankStatement){
			return $this->fullySecuredOverdraftCreditBankStatement;
		}
		if($this->overdraftAgainstCommercialPaperCreditBankStatement){
			return $this->overdraftAgainstCommercialPaperCreditBankStatement;
		}	
		if($this->overdraftAgainstAssignmentOfContractCreditBankStatement){
			return $this->overdraftAgainstAssignmentOfContractCreditBankStatement;
		}
		if($this->cashInSafeCreditStatement){
			return $this->cashInSafeCreditStatement ;
		}
		if($this->currentAccountCreditBankStatement){
			return $this->currentAccountCreditBankStatement ;
		}
	}
	public function deleteRelations()
	{
		$oldType = $this->getType();
		$this->downPayment ? (new MoneyPaymentController())->destroy(getCurrentCompany(),$this->downPayment) : null ;
		$oldTypeRelationName = dashesToCamelCase($oldType);
		$this->downPayment? $this->downPayment->delete():null;
		$this->$oldTypeRelationName ? $this->$oldTypeRelationName->delete() : null;
		$this->settlements->each(function($settlement){
			$settlement->delete();
		});
		$this->settlementAllocations()->delete();
		//$this->unappliedAmounts()->delete();
		$currentStatement = $this->getCurrentStatement() ;
		if($currentStatement){
			$currentStatement->delete();
		}
		$this->deletePartnerStatement();
	}
	/**
	 * * دا عباره عن التاريخ اللي هنستخدمة في ال
	 * * statements 
	 * * سواء بانك او كاش الخ
	 */
	public function getStatementDate()
	{
		if($this->isPayableCheque()){
			return $this->getPayableChequeDueDate();
		}
		if($this->isOutgoingTransfer()){
			return $this->getOutgoingTransferDueDate();
		}
		return $this->getDeliveryDate();
	}
	public function settlementAllocations()
	{
		return $this->hasMany(SettlementAllocation::class,'money_payment_id','id');
	}
	public function storeNewAllocation(array $allocations)
	{
		foreach($allocations as $invoiceNumber => $allocationsArr){
			foreach($allocationsArr as $index => $allocationArr){
				$partnerId = $allocationArr['partner_id'] ?? 0 ;
				$contractId = $allocationArr['contract_id'] ?? 0 ;
				$allocationAmount = $allocationArr['allocation_amount'] ?? 0 ;
				if($allocationAmount>0){
					$this->settlementAllocations()->create([
						'allocation_amount'=>$allocationAmount,
						'contract_id'=>$contractId,
						'partner_id'=>$partnerId ,
						'invoice_number'=>$invoiceNumber
					]);
				}
			}
		}
	}
		
	public static function getCashOutForMoneyTypeAtDates(array &$result , array &$totalCashOutFlowArray  , string $moneyType,string $dateFieldName,string $currency , int $companyId, string $startDate , string $endDate , string $currentWeekYear , ?string $chequeStatus = null) 
	{
		$subTableName = (new self)->getTable(); // money_payments
		$keyNameForCurrentType = [
			MoneyPayment::OUTGOING_TRANSFER => __('Outgoing Transfers'),
			MoneyPayment::CASH_PAYMENT =>__('Cash Payments'),
			MoneyPayment::PAYABLE_CHEQUE => $chequeStatus == PayableCheque::PAID ? __('Paid Payable Cheques') : __('Under Payment Payable Cheques')
		][$moneyType];
		
		$mainTableName = [
			MoneyPayment::OUTGOING_TRANSFER => (new OutgoingTransfer())->getTable(),
			MoneyPayment::CASH_PAYMENT =>(new CashPayment())->getTable(),
			MoneyPayment::PAYABLE_CHEQUE => (new PayableCheque())->getTable()
		][$moneyType];
		
		$supplierNamesWithPaidAmount = DB::table($mainTableName)
						->where($subTableName.'.currency',$currency)
						->where('type',$moneyType)
						->where($subTableName.'.company_id',$companyId)
						->whereBetween($dateFieldName,[$startDate,$endDate])
						->join($subTableName,$subTableName.'.id','=',$mainTableName.'.money_payment_id')
						->when($chequeStatus , function(Builder $builder) use ($chequeStatus){
							$builder->where('payable_cheques.status',$chequeStatus);
						})
						->groupBy('supplier_name')
						->selectRaw('supplier_name,sum(paid_amount) as paid_amount')->get();
		foreach($supplierNamesWithPaidAmount as $supplierNameAndPaidAmount){
			$supplierName = $supplierNameAndPaidAmount->supplier_name;
			$currentPaidAmount = $supplierNameAndPaidAmount->paid_amount ;
			$result['suppliers'][$supplierName][$keyNameForCurrentType]['weeks'][$currentWeekYear] = isset($result['suppliers'][$supplierName][$keyNameForCurrentType]['weeks'][$currentWeekYear]) ? $result['suppliers'][$supplierName][$keyNameForCurrentType]['weeks'][$currentWeekYear] + $currentPaidAmount :  $currentPaidAmount;
			$result['suppliers'][$supplierName][$keyNameForCurrentType]['total'] = isset($result['suppliers'][$supplierName][$keyNameForCurrentType]['total']) ? $result['suppliers'][$supplierName][$keyNameForCurrentType]['total']  + $currentPaidAmount : $currentPaidAmount;
			$currentTotal = $currentPaidAmount;
			$result['suppliers'][$supplierName]['total'][$currentWeekYear] = isset($result['suppliers'][$supplierName]['total'][$currentWeekYear]) ? $result['suppliers'][$supplierName]['total'][$currentWeekYear] +  $currentTotal : $currentTotal ;
			$result['suppliers'][$supplierName]['total']['total_of_total'] = isset($result['suppliers'][$supplierName]['total']['total_of_total']) ? $result['suppliers'][$supplierName]['total']['total_of_total'] + $result['suppliers'][$supplierName]['total'][$currentWeekYear] : $result['suppliers'][$supplierName]['total'][$currentWeekYear];
			$totalCashOutFlowArray[$currentWeekYear] = isset($totalCashOutFlowArray[$currentWeekYear]) ? $totalCashOutFlowArray[$currentWeekYear] +   $currentTotal : $currentTotal ;
			
		}
		
	
	}
	
	
	/**
	 * * هنا لو معاك 
	 * * down payment
	 * * وعايز تعرف ال
	 * * money payment
	 * * اللي تم انشائها معاها
	 */
	// public function moneyPayment()
	// {
	// 	return $this->belongsTo(MoneyPayment::class,'money_payment_id','id');
	// }
	/**
	 * * هنا لو معاك 
	 * * money payment
	 * * وعايز تعرف ال
	 * * down payment
	 * * اللي تم انشائها معاها
	 */
	public function downPayment()
	{
		return $this->hasOne(MoneyPayment::class,'money_payment_id','id');
	}
	
	public  function getForeignKeyName()
	{
		return 'money_payment_id';
	}  
	public function storeNewPurchaseOrders(array $purchaseOrders,int $companyId , ?int $contractId,?int $supplierId)
	{
		foreach($purchaseOrders as $salesOrderReceivedAmountArr)
		{
			if(isset($salesOrderReceivedAmountArr['paid_amount'])&&$salesOrderReceivedAmountArr['paid_amount'] > 0){
				$salesOrderReceivedAmountArr['company_id'] = $companyId ;
				$this->downPaymentSettlements()->create(array_merge(
					$salesOrderReceivedAmountArr ,
					[
						'contract_id'=>$contractId,
						'supplier_id'=>$supplierId,
						'down_payment_amount'=>$salesOrderReceivedAmountArr['paid_amount']
						]
					));
			}
		}
	}
	

}
