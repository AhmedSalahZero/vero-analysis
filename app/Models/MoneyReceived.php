<?php

namespace App\Models;

use App\Models\OpeningBalance;
use App\Traits\Models\HasCreditStatements;
use App\Traits\Models\HasDebitStatements;
use App\Traits\Models\HasPartnerStatement;
use App\Traits\Models\HasReviewedBy;
use App\Traits\Models\IsMoney;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MoneyReceived extends Model
{
	use IsMoney ,HasDebitStatements,HasCreditStatements,HasPartnerStatement,HasReviewedBy;
	// protected $appends = [
	// 	'foreign_exchange_rate_at_date'
    // ];
	// public function getForeignExchangeRateAtDateAttribute(){
	// 	return 5;
	// }
	// public function getNpsAttribute() {
    //     return 5;
    // }


	const CASH_IN_SAFE  = 'cash-in-safe';
	const CASH_IN_BANK  = 'cash-in-bank';
	const INCOMING_TRANSFER  = 'incoming-transfer';
	const CHEQUE  = 'cheque';
	const CHEQUE_UNDER_COLLECTION  = 'cheque-under-collection';
	const CHEQUE_REJECTED  = 'cheque-rejected';
	const CHEQUE_COLLECTED = 'cheque-collected';
	const CHEQUE_COLLECTION_FEES = 'cheque-collection-fees';
	const CONTRACTS_WITH_DOWN_PAYMENTS = 'contracts-with-down-payments';
	const UNAPPLIED_AMOUNTS = 'unapplied-amounts';
	const DOWN_PAYMENT = 'down-payment';
	const INVOICE_SETTLEMENT_WITH_DOWN_PAYMENT = 'invoice-settlement-with-down-payment';
	const CLIENT_NAME ='customer_name';
	const DOWN_PAYMENT_OVER_CONTRACT = 'over_contract' ;
	const DOWN_PAYMENT_GENERAL = 'general' ;
	const RECEIVING_OR_PAYMENT_CURRENCY_COLUMN_NAME='receiving_currency';
	
	public static function generateComment(self $moneyReceived,string $lang,?string $invoiceNumbers = '',?string $customerName = null)
	{
		
		$settledInvoiceNumbers = getKeysWithSettlementAmount(Request()->get('settlements',[]),'settlement_amount');
		$settledInvoiceNumbers =  $settledInvoiceNumbers?: $invoiceNumbers;
		$customerName = is_null($customerName) ?$moneyReceived->getCustomerName() : $customerName;
		if($moneyReceived->isCheque()){
			$chequeNumber = $moneyReceived->getChequeNumber()?:Request('cheque_number');
			if($moneyReceived->isOpenBalance()){
				return __('Opening Balance Cheque From [ :customerName ]' , ['customerName'=>$customerName],$lang);
			}
			if($moneyReceived->isGeneralDownPayment()){
				return __('General Down Payment - Cheque :name With Number [ :number ]',['name'=>$customerName,'number'=>$chequeNumber],$lang) ;
			}
			if($moneyReceived->isOverContractDownPayment()){
				return __('Down Payment - Cheque :name [ :contractName ] [ :contractCode ] With Number [ :number ]',['name'=>$customerName,'contractName'=>$moneyReceived->getContractName(),'contractCode'=>$moneyReceived->getContractCode(),'number'=>$chequeNumber],$lang) ;
			}
			if($moneyReceived->isInvoiceSettlementWithDownPayment()){
				return __('Cheque :name With Number [ :number ] Settled Invoices [ :numbers ] [ :currency ] | Down Payment - [ :contractName ] [ :contractCode ]',[
					'name'=>$customerName ,
					'number'=>$chequeNumber,
					'numbers'=>$settledInvoiceNumbers ,
					'currency'=>$moneyReceived->getCurrency(),
					'contractName'=>$moneyReceived->getContractName(),
					'contractCode'=>$moneyReceived->getContractCode()
				]);
			}
			if($moneyReceived->getPartnerType()!='is_customer'){
				return __('Cheque :name [ :partnerType ] With Number [ :number ]',['name'=>$customerName,'number'=>$chequeNumber,'partnerType'=>$moneyReceived->getPartnerTypeFormatted()],$lang);
			}
			return __('Cheque :name With Number [ :number ] Settled Invoices [ :numbers ] [ :currency ]',['name'=>$customerName,'number'=>$chequeNumber,'numbers'=>$settledInvoiceNumbers,'currency'=>$moneyReceived->getCurrency()],$lang) ;
		}
		if($moneyReceived->isCashInSafe()){
			if($moneyReceived->isOpenBalance()){
				return __('Beginning Balance',[],$lang);
			}
			if($moneyReceived->isInvoiceSettlementWithDownPayment()){
				return __('Cash From :name Settled Invoices [ :numbers ] [ :currency ] | Down Payment - [ :contractName ] [ :contractCode ]',[
					'name'=>$customerName ,
					'numbers'=>$settledInvoiceNumbers ,
					'currency'=>$moneyReceived->getCurrency(),
					'contractName'=>$moneyReceived->getContractName(),
					'contractCode'=>$moneyReceived->getContractCode()
				]);
			}
			if($moneyReceived->getPartnerType()!='is_customer'){
				return __('Cash In Safe From :name [ :partnerType ]',['name'=>$customerName,'partnerType'=>$moneyReceived->getPartnerTypeFormatted()],$lang) ;
			}
			return __('Cash In Safe From :name Settled Invoices [ :numbers ]',['name'=>$customerName,'numbers'=>$settledInvoiceNumbers],$lang) ;
		}
		if($moneyReceived->isCashInBank()){
			if($moneyReceived->isInvoiceSettlementWithDownPayment()){
				return __('Bank Deposit From :name Settled Invoices [ :numbers ] [ :currency ] | Down Payment - [ :contractName ] [ :contractCode ]',[
					'name'=>$customerName ,
					'numbers'=>$settledInvoiceNumbers ,
					'currency'=>$moneyReceived->getCurrency(),
					'contractName'=>$moneyReceived->getContractName(),
					'contractCode'=>$moneyReceived->getContractCode()
				]);
			}
			if($moneyReceived->getPartnerType()!='is_customer'){
				return __('Bank Deposit From :name [ :partnerType ]',['name'=>$customerName,'partnerType'=>$moneyReceived->getPartnerTypeFormatted()],$lang) ;
			}
			return __('Bank Deposit From :name Settled Invoices [ :numbers ]',['name'=>$customerName,'numbers'=>$settledInvoiceNumbers],$lang) ;
		}
		if($moneyReceived->isIncomingTransfer()){
			
			if($moneyReceived->isGeneralDownPayment()){
				return __('General Down Payment - Incoming Transfer :name',['name'=>$customerName],$lang) ;
			}
			if($moneyReceived->isOverContractDownPayment()){
				return __('Down Payment - Incoming Transfer :name [ :contractName ] [ :contractCode ]',['name'=>$customerName,'contractName'=>$moneyReceived->getContractName(),'contractCode'=>$moneyReceived->getContractCode()],$lang) ;
			}
			if($moneyReceived->isInvoiceSettlementWithDownPayment()){
				return __('Incoming Transfer :name Settled Invoices [ :numbers ] [ :currency ] | Down Payment - [ :contractName ] [ :contractCode ]',[
					'name'=>$customerName ,
					'numbers'=>$settledInvoiceNumbers ,
					'currency'=>$moneyReceived->getCurrency(),
					'contractName'=>$moneyReceived->getContractName(),
					'contractCode'=>$moneyReceived->getContractCode()
				]);
			}
			
			if($moneyReceived->getPartnerType()!='is_customer'){
				return __('Incoming Transfer :name [ :partnerType ]',['name'=>$customerName,'partnerType'=>$moneyReceived->getPartnerTypeFormatted()],$lang) ;
			}
			return __('Incoming Transfer :name Settled Invoices [ :numbers ]',['name'=>$customerName,'numbers'=>$settledInvoiceNumbers],$lang) ;
		}
	}
	protected static function booted()
	{
	
		self::creating(function (self $moneyReceived): void {
			$moneyReceived->comment_en = self::generateComment($moneyReceived,'en');
			$moneyReceived->comment_ar = self::generateComment($moneyReceived,'ar');
		});
		
	}
	public static function getAllTypes()
	{
		return [
			self::CASH_IN_SAFE,
			self::CASH_IN_BANK,
			self::INCOMING_TRANSFER,
			self::CHEQUE,
			self::CHEQUE_UNDER_COLLECTION,
			self::CHEQUE_REJECTED,
			self::CHEQUE_COLLECTED,
			
		];
	}
	
    protected $guarded = ['id'];
    protected $table = 'money_received';
    
	public function getType():string 
	{
		return $this->type ;
	}
    public function isCashInSafe()
    {
        return $this->getType() ==self::CASH_IN_SAFE;
    }
	public function isCashInBank()
    {
        return $this->getType() ==self::CASH_IN_BANK;
    }
	public function isCheque()
    {
        return $this->getType() ==self::CHEQUE;
    }
	public function isChequeInSafe()
	{
		return $this->isCheque() && $this->cheque->isInSafe();
	}
	public function isRejectedCheque()
	{
		return $this->isCheque() && $this->cheque->isRejected();
	}
    public function isIncomingTransfer()
    {
        return $this->getType() ==self::INCOMING_TRANSFER;
    }
    
	public function getPartnerName()
	{
		return $this->partner ? $this->partner->getName() : __('N/A') ;
	}
    public function getCustomerName()
    {
		return $this->getPartnerName();
    }
	public function customer()
	{
		return $this->belongsTo(Partner::class,'partner_id','id');
	}
	public function getPartnerId()
	{
		return $this->partner ? $this->partner->id : 0 ;
	}
	public function getCustomerId()
	{
		return $this->getPartnerId();
	}
    public function getName()
    {
    	return $this->getCustomerName();
    }
	public function getDate()
	{
		return $this->getReceivingDate();
	}
    public function getReceivingDate()
    {
        return $this->receiving_date;
    }
    public function getCashInSafeReceivingBranchId()
    {
		$cashInSafe = $this->cashInSafe ;
        return  $cashInSafe ? $cashInSafe->getReceivingBranchId() :0;
    }
	public function getAmountInInvoiceCurrency()
    {
        return  $this->amount_in_invoice_currency?:0 ;
    }
	
	
    public function getReceivedAmount()
    {
        return  $this->received_amount?:0 ;
    }
	public function getAmount()
	{
		return $this->getReceivedAmount();
	}

	public function getChequeDueDate(){
		return $this->cheque ? $this->cheque->getDueDate(): null;
	}
	public function getChequeNumber()
	{
		return $this->cheque ? $this->cheque->getChequeNumber():null;
	}
	public function getReceivedAmountFormatted()
    {
        return number_format($this->getReceivedAmount()) ;
    }
	public function getInvoiceCurrency()
	{
		return $this->getCurrency();
	}
	
	public function getCurrency()
	{
		return $this->currency;
	}
	
	public function getCurrencyFormatted()
	{
		return strtoupper($this->currency);
	}
	public function getCurrencyToReceivingCurrencyFormatted()
	{
		$currency = $this->getCurrency();
		$receivingCurrency = $this->getReceivingCurrency();
		if($currency == $receivingCurrency || is_null($receivingCurrency)){
			return $this->getCurrencyFormatted();
		}
		return $this->getReceivingCurrencyFormatted().'/'.$this->getCurrencyFormatted();
		
	}
	public function getReceivingCurrency()
	{
		return $this->receiving_currency;
	}
	
	public function getReceivingCurrencyFormatted()
	{
		return strtoupper($this->getReceivingCurrency());
	}

	public function getExchangeRate()
	{
		
		return $this->exchange_rate?:1;
	}
	public function getPaymentBankName()
	{
		return '-';
	}


    public function getCashInSafeReceiptNumber()
    {
		$cashInSafe = $this->cashInSafe;
        return $cashInSafe ? $cashInSafe->getReceiptNumber() :  null ;
    }

  
	public function getNumber()
	{
		if($this->isCheque()){
			return $this->cheque ? $this->cheque->getChequeNumber() : __('N/A');
		}
		if($this->isCashInSafe()){
			return $this->getCashInSafeReceiptNumber();
		}
		if($this->isIncomingTransfer()){
			return $this->getIncomingTransferAccountNumber();
		}
		if($this->isCashInBank()){
			return $this->getCashInBankAccountNumber();
		}
	}
	

	
	public function getBankName()
	{
		if($this->isCashInSafe()){
			return $this->getCashInSafeBranchName();
		}
		if($this->isCheque()){
			return $this->cheque ? $this->cheque->getDraweeBankName() : __('N/A') ;
		}
		if($this->isIncomingTransfer()){
			return $this->getIncomingTransferReceivingBankName(app()->getLocale());
		}
		if($this->isCashInBank()){
			return $this->getCashInBankReceivingBankName(app()->getLocale());
		}
	}
	
	public function incomingTransfer()
	{
		return $this->hasOne(IncomingTransfer::class,'money_received_id','id');
	}

    public function getIncomingTransferReceivingBankId()
    {
		$incomingTransfer = $this->incomingTransfer ;
        return $incomingTransfer ? $incomingTransfer->getReceivingBankId() : 0 ;
    }
	public function incomingTransferReceivingBank():?FinancialInstitution
	{
		$incomingTransfer = $this->incomingTransfer ;
		return $incomingTransfer ? $incomingTransfer->receivingBank() : null ;
	}
	public function getIncomingTransferReceivingBankName()
	{
		$incomingTransfer = $this->incomingTransfer ;
        return $incomingTransfer ? $incomingTransfer->getReceivingBankName() : __('N/A') ;
	}
	
	public function cashInBank()
	{
		return $this->hasOne(CashInBank::class,'money_received_id','id');
	}
	public function getCashInBankReceivingBankName()
    {
		$cashInBank = $this->cashInBank ;
        return $cashInBank ? $cashInBank->getReceivingBankName() : 0 ;
    }

    public function getCashInBankReceivingBankId()
    {
		$cashInBank = $this->cashInBank ;
        return $cashInBank ? $cashInBank->getReceivingBankId() : 0 ;
    }
	public function cashInBankReceivingBank():?FinancialInstitution
	{
		$cashInBank = $this->cashInBank ;
		return $cashInBank ? $cashInBank->receivingBank() : null ;
	}
	public function getFinancialInstitutionId()
	{
		if($this->isCashInBank()){
			return $this->getCashInBankReceivingBankId();
		}
		if($this->isIncomingTransfer()){
			return $this->getIncomingTransferReceivingBankId();
		}
		if($this->isCheque()){
			return $this->cheque ? $this->cheque->getDrawlBankId() : 0;
		}
	}
	
	
	/**
	 * * For Money Received Only
	 */
	/**
	 * * كل كل ال settlements
	 * * ودا بيشمل في حاله مثلا لو كان عندك
	 * * money received with down payment
	 * * فا هتجيب كل ال settlements
	 * * سواء اللي اتعملت مع ال money received
	 * * او اللي اتعملت مع ال down payment 
	 * * الخاصه بيها 
	 * * خلي بالك ان الاتنين مع بعض سواء ال 
	 * * money received or its down payment
	 * * وبالتالي الاتنين ليهم نفس الاي دي
	 */
    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'money_received_id', 'id');
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
	public function settlementsForMoneyReceived()
    {
        return $this->hasMany(Settlement::class, 'money_received_id', 'id')->where('is_from_down_payment',0);
    }
	public function settlementsForDownPaymentThatComeFromMoneyModel()
    {
        return $this->hasMany(Settlement::class, 'money_received_id', 'id')->where('is_from_down_payment',1);
    }
	/**
	 * * For Down Payment Only
	 */
    public function downPaymentSettlements()
    {
        return $this->hasMany(DownPaymentSettlement::class, 'money_received_id', 'id');
    }
    public function customerInvoices()
    {
        return $this->hasMany(CustomerInvoice::class, 'partner_id', 'customer_id');
    }
	
    public function getSettlementsForInvoiceNumber(int $invoiceId, int $partnerId,bool $isFromDownPayment = null):Collection
    {
		$settlements = $this->settlements ;
		if($isFromDownPayment == true){
			$settlements = $this->settlementsForDownPaymentThatComeFromMoneyModel;
		}
	
		if($isFromDownPayment == false){
			$settlements = $this->settlementsForMoneyReceived;
		}
        return $settlements->where('invoice_id', $invoiceId)->where('partner_id', $partnerId) ;
    }
	public function sumSettlementsForInvoice(int $invoiceId, int $partnerId,bool $isFromDownPayment =null):float{
	
		return $this->getSettlementsForInvoiceNumber($invoiceId,$partnerId,$isFromDownPayment)
		->sum('settlement_amount');
		
		
	}
	public function sumWithholdAmountForInvoice($invoiceId, int $partnerId,bool $isFromDownPayment =null):float{
		return $this->getSettlementsForInvoiceNumber($invoiceId,$partnerId,$isFromDownPayment)->sum('withhold_amount');
	}
    public function getReceivingDateFormatted()
    {
        $receivingDate = $this->getReceivingDate() ;
        if($receivingDate) {
            return Carbon::make($receivingDate)->format('d-m-Y');
        }
    }
	public function setReceivingDateAttribute($value)
	{
		if(is_object($value)){
			return $value ;
		}
		$date = explode('/',$value);
		if(count($date) != 3){
			$this->attributes['receiving_date'] = $value;
			return  ;
		}
		$month = $date[0];
		$day = $date[1];
		$year = $date[2];
		$this->attributes['receiving_date'] = $year.'-'.$month.'-'.$day;
		
	}
	
	public static function getUniqueBanks( $banks):array{
		$uniqueBanksIds = [];
		foreach($banks as $bankId){
				$uniqueBanksIds[$bankId] = $bankId;
		}
		return $uniqueBanksIds; 
	}
	
	public static function getDrawlBanksForCurrentCompany(int $companyId){

		$cheques = self::where('company_id',$companyId)->has('cheque')->with('cheque')->get()->pluck('cheque.drawee_bank_id')->toArray();
		$cheques=Cheque::where('company_id',$companyId)->pluck('drawee_bank_id')->toArray();
		
		
		$banks = self::getUniqueBanks($cheques);
	
		$banksFormatted = [];
		foreach($banks as $bankId){
			$bank = Bank::find($bankId) ;
			if($bank){
				$banksFormatted[$bankId] = $bank->getViewName() ;
			}
		}
		return $banksFormatted; 
	}
	
	
	


	
	public function cashInSafeReceivingBranch()
	{
		$cashInSafe = $this->cashInSafe;
		return $cashInSafe ? $cashInSafe->receivingBranch : null ;
	}
	public function getCashInSafeBranchName()
	{
		$cashInSafe = $this->cashInSafe;

		return $cashInSafe ? $cashInSafe->getReceivingBranchName() : null ;
	}
	
	public function getChequeDepositDate()
	{
		$cheque = $this->cheque;
		return $cheque ? $cheque->getDepositDate() : null;
	}
	public function getChequeDepositDateFormattedForDatePicker()
	{
		$date = $this->getChequeDepositDate();
		return $date ? Carbon::make($date)->format('m/d/Y') : null;
	}
	public function getChequeDepositDateFormatted()
	{
		$date = $this->getChequeDepositDate();
		return $date ? Carbon::make($date)->format('d-m-Y') : null;
	}
	public function getChequeFinancialInstitutionOpeningBalanceDate()
	{
		// return $this->cheque && $this->cheque->drawlBank 
	}
	
	
	
	/** drawl_bank_id
	**	هو البنك اللي بنسحب منه الشيك وليكن مثلا شخص اداني شيك معين وقتها بروح اسحبه من هذا 
	**	البنك فا شرط يكون من البنوك بتاعتي علشان البنك بتاعي يتواصل مع بنك ال
	**	drawee بعدين يحطلي الفلوس بتاعته في حسابي
	*/		 
	
	public function getChequeDrawlBankName()
	{
		return $this->cheque ? $this->cheque->getDrawlBankName() : __('N/A') ;
	}
	public function getChequeDrawlBankId()
	{
		return $this->cheque ? $this->cheque->getDrawlBankId() : 0 ;
	}
	
	public function getChequeAccountType()
	{
		$cheque = $this->cheque ;
		return $cheque ? $cheque->getAccountType() : null ;
	}
	
	public function getChequeAccountNumber()
	{
		$cheque = $this->cheque ;
		return $cheque ? $cheque->getAccountNumber() : null ;
	}
	
	public function cashInSafe()
	{
		return $this->hasOne(CashInSafe::class,'money_received_id','id');
	}
	
	public function cheque()
	{
		return $this->hasOne(Cheque::class,'money_received_id','id');
	}
		
	public function isChequeUnderCollection()
	{
		return $this->cheque && $this->cheque->getStatus() == Cheque::UNDER_COLLECTION;
	}
	public function getTotalWithholdAmount():float 
	{
		return $this->total_withhold_amount ?: 0 ;
	}
	public function getIncomingTransferAccountTypeId(){
		$incomingTransfer = $this->incomingTransfer;
		return $incomingTransfer ? $incomingTransfer->getAccountTypeId() : 0 ;
	}
	public function getIncomingTransferAccountTypeName(){
		$incomingTransfer = $this->incomingTransfer;
		return $incomingTransfer ? $incomingTransfer->getAccountTypeName() : 0 ;
	}
	public function getIncomingTransferAccountNumber(){
		$incomingTransfer = $this->incomingTransfer;
		return $incomingTransfer ? $incomingTransfer->getAccountNumber() : 0 ;
	}
	public function getCashInBankAccountTypeId(){
		$cashInBank = $this->cashInBank;
		return $cashInBank ? $cashInBank->getAccountTypeId() : 0 ;
	}
	public function getCashInBankAccountTypeName(){
		$cashInBank = $this->cashInBank;
		return $cashInBank ? $cashInBank->getAccountTypeName() : 0 ;
	}
	public function getCashInBankAccountNumber(){
		$cashInBank = $this->cashInBank;
		return $cashInBank ? $cashInBank->getAccountNumber() : 0 ;
	}

	public function cleanOverdraftDebitBankStatement()
	{
		return $this->hasOne(CleanOverdraftBankStatement::class,'money_received_id','id');
	}
	
	public function fullySecuredOverdraftDebitBankStatement()
	{
		return $this->hasOne(FullySecuredOverdraftBankStatement::class,'money_received_id','id');
	}
	
	public function overdraftAgainstCommercialPaperDebitBankStatement()
	{
		return $this->hasOne(OverdraftAgainstCommercialPaperBankStatement::class,'money_received_id','id');
	}
	public function overdraftAgainstAssignmentOfContractDebitBankStatement()
	{
		return $this->hasOne(OverdraftAgainstAssignmentOfContractBankStatement::class,'money_received_id','id');
	}
	public function cashInSafeDebitStatement()
	{
		return $this->hasOne(CashInSafeStatement::class,'money_received_id','id');
	}
	
	
	
	
	
	
	
	public function currentAccountDebitBankStatement()
	{
		return $this->hasOne(CurrentAccountBankStatement::class,'money_received_id','id');
	}
		
	public function openingBalance()
	{
		return $this->belongsTo(OpeningBalance::class,'opening_balance_id');
	}
	public function isOpenBalance()
	{
		return $this->opening_balance_id !== null ;
	}
	public function getChequeClearanceDays()
	{
		return $this->cheque ? $this->cheque->clearance_days : 0 ;
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
		if($moneyType == 'money-received'){
			$moneyType = 'invoice-settlement';
		}
		if($moneyType == self::INVOICE_SETTLEMENT_WITH_DOWN_PAYMENT){
			$moneyType = __('Invoice Settlement & Down Payment');
		}

		if($partnerType != 'is_customer'){
			return __('Money Received From [ :partnerType ]',['partnerType'=>$this->getPartnerTypeFormatted()]);	
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
		return $this->contract ? $this->contract->getName() : __('General');
	}
	public function getContractCode()
	{
		return $this->contract ? $this->contract->getCode() : '-';
	}
	
	public function deleteRelations()
	{
		$oldType = $this->getType();

		// $this->downPayment ? (new MoneyReceivedController())->destroy(getCurrentCompany(),$this->downPayment) : null ;
		// $oldTypeRelationName = dashesToCamelCase($oldType);
		$this->incomingTransfer ? $this->incomingTransfer->delete() :null ;
		$this->cashInBank ? $this->cashInBank->delete() :null ;
		$this->cashInSafe ? $this->cashInSafe->delete() :null ;
		$this->cheque ? $this->cheque->delete() :null ;
		$this->cleanOverdraftDebitBankStatement ? $this->cleanOverdraftDebitBankStatement->delete() :null ;
		$this->fullySecuredOverdraftDebitBankStatement ? $this->fullySecuredOverdraftDebitBankStatement->delete() :null ;
		$this->overdraftAgainstCommercialPaperDebitBankStatement ? $this->overdraftAgainstCommercialPaperDebitBankStatement->delete() :null ;
		$this->overdraftAgainstAssignmentOfContractDebitBankStatement ? $this->overdraftAgainstAssignmentOfContractDebitBankStatement->delete() :null ;
		$this->cashInSafeDebitStatement ? $this->cashInSafeDebitStatement->delete() :null ;
		$this->currentAccountDebitBankStatement ? $this->currentAccountDebitBankStatement->delete() :null ;
		$this->currentAccountCreditBankStatement ? $this->currentAccountCreditBankStatement->delete() :null ;
		$this->cashInSafeCreditStatement ? $this->cashInSafeCreditStatement->delete() :null ;
		$this->overdraftAgainstAssignmentOfContractCreditBankStatement ? $this->overdraftAgainstAssignmentOfContractCreditBankStatement->delete() :null ;
		$this->overdraftAgainstCommercialPaperCreditBankStatement ? $this->overdraftAgainstCommercialPaperCreditBankStatement->delete() :null ;
		// $this->$oldTypeRelationName ? $this->$oldTypeRelationName->delete() : null;
		$this->settlements->each(function($settlement){
			$settlement->delete();
		});
		$this->downPaymentSettlements->each(function($downPaymentSettlement){
			$downPaymentSettlement->delete();
		});
		// money_received_id
		// $this->subsidiaryCompanyStatement ? $this->subsidiaryCompanyStatement->delete() : null;
		// $this->shareholderStatement ? $this->shareholderStatement->delete() : null;
		// $this->employeeStatement ? $this->employeeStatement->delete() : null;
		// $this->cleanOverdraftDebitBankStatement ? $this->cleanOverdraftDebitBankStatement->delete() :null ;
		
		$this->deletePartnerStatement();
	}
	public function getCurrentStatement()
	{
		if($this->cleanOverdraftDebitBankStatement){
			return $this->cleanOverdraftDebitBankStatement ;
		}
		if($this->fullySecuredOverdraftDebitBankStatement){
			return $this->fullySecuredOverdraftDebitBankStatement;
		}
		if($this->overdraftAgainstCommercialPaperDebitBankStatement){
			return $this->overdraftAgainstCommercialPaperDebitBankStatement;
		}	
		if($this->overdraftAgainstAssignmentOfContractDebitBankStatement){
			return $this->overdraftAgainstAssignmentOfContractDebitBankStatement;
		}
		if($this->overdraftDebitBankStatement){
			return $this->overdraftDebitBankStatement ;
		}
		if($this->cashInSafeDebitStatement){
			return $this->cashInSafeDebitStatement;
		}
		if($this->currentAccountDebitBankStatement){
			return $this->currentAccountDebitBankStatement ;
		}
		
		
	}

	
	/**
	 * * دا عباره عن التاريخ اللي هنستخدمة في ال
	 * * statements 
	 * * سواء بانك او كاش الخ
	 */
	public function getStatementDate()
	{
		if($this->isCheque()){
			return $this->getChequeDueDate();
		}
		return $this->getReceivingDate();
	}
	public function overdraftAgainstCommercialPaperCreditBankStatement()
	{
		return $this->hasOne(OverdraftAgainstCommercialPaperBankStatement::class,'money_received_id','id');
	}
	public function currentAccountCreditBankStatement()
	{
		return $this->hasOne(CurrentAccountBankStatement::class,'money_received_id','id');
	}
	
	public function cashInSafeCreditStatement()
	{
		return $this->hasOne(CashInSafeStatement::class,'money_received_id','id');
	}
	public function overdraftAgainstAssignmentOfContractCreditBankStatement()
	{
		return $this->hasOne(OverdraftAgainstAssignmentOfContractBankStatement::class,'money_received_id','id');
	}
	public static function getChequesCollectedUnderDates(int $companyId , string $startDate , string $endDate,string $currency,string $chequeStatus,string $dateColumnName ) 
	{
		return  DB::table('money_received')
		->where('type',MoneyReceived::CHEQUE)
		->where('money_received.currency',$currency)
		->join('cheques','cheques.money_received_id','=','money_received.id')
		->where('money_received.company_id',$companyId)
		->whereBetween('cheques.'.$dateColumnName,[$startDate,$endDate])
		->where('cheques.status',$chequeStatus)
		->sum('received_amount');
	}
	public static function getIncomingTransferUnderDates(int $companyId , string $startDate , string $endDate,string $currency,$customerName = null , $contractCode = null) 
	{
		$isContract = $customerName && $contractCode ;
		$sumColumnName = $isContract ? 'settlement_amount' : 'received_amount' ;
		
			return  DB::table('money_received')
		->where('type',MoneyReceived::INCOMING_TRANSFER)
		->where('money_received.company_id',$companyId)
		->where('money_received.currency',$currency)
		->join('incoming_transfers','incoming_transfers.money_received_id','=','money_received.id')
		->where('money_received.company_id',$companyId)
		->whereBetween('money_received.receiving_date',[$startDate,$endDate])
		->when($isContract , function(Builder $builder) use ($contractCode){
			$builder->join('customer_invoices','customer_invoices.customer_id' ,'=','money_received.partner_id')
			->where('customer_invoices.contract_code',$contractCode)
			->join('settlements',function(Builder $builder){
				$builder->on('money_received.id','=','settlements.money_received_id')
				->on('settlements.invoice_id','customer_invoices.id');
			})
			;
		})
		->sum($sumColumnName);
	}
	public static function getBankDepositsUnderDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		return  DB::table('money_received')
	
		->where('type',MoneyReceived::CASH_IN_BANK)
		->where('money_received.currency',$currency)
		->join('cash_in_banks','cash_in_banks.money_received_id','=','money_received.id')
		->where('money_received.company_id',$companyId)
		->whereBetween('money_received.receiving_date',[$startDate,$endDate])
		->sum('received_amount');
	}
	public static function getCashInSafeUnderDates(int $companyId , string $startDate , string $endDate,string $currency) 
	{
		
		return  DB::table('money_received')
		->where('type',MoneyReceived::CASH_IN_SAFE)
		->where('money_received.currency',$currency)
		->join('cash_in_safes','cash_in_safes.money_received_id','=','money_received.id')
		->where('money_received.company_id',$companyId)
		->whereBetween('money_received.receiving_date',[$startDate,$endDate])
		->sum('received_amount');
	}
	/**
	 * * هنا لو معاك 
	 * * down payment
	 * * وعايز تعرف ال
	 * * ماني ريسيفد 
	 * * اللي تم انشائها معاها
	 */
	// public function moneyReceived()
	// {
	// 	return $this->belongsTo(MoneyReceived::class,'money_received_id','id');
	// }
	/**
	 * * هنا لو معاك 
	 * * ماني ريسيفد وعايز تعرف ال
	 * * down payment
	 * * اللي تم انشائها معاها
	 */
	// public function downPayment()
	// {
	// 	return $this->hasOne(MoneyReceived::class,'money_received_id','id');
	// }
	public  function getForeignKeyName()
	{
		return 'money_received_id';
	}  
	public function getChequeDraweeBankId():int
	{
		return $this->cheque ? $this->cheque->getDraweeBankId() : 0 ;
	}
	public function storeNewSalesOrdersAmounts(array $salesOrdersAmounts,?int $contractId,?int $customerId,int $companyId,$receivedAmount = null)
	{
		if(!count($salesOrdersAmounts)){
			$salesOrdersAmounts[] = [
				'received_amount'=>$receivedAmount,
				'company_id'=>$companyId,
				'contract_id'=>null ,
				'down_payment_amount'=>$receivedAmount,
				'currency'=>$this->getReceivingCurrency(),
				'sales_order_id'=>null
			];
		}
		foreach($salesOrdersAmounts as $salesOrderReceivedAmountArr)
		{
			if(isset($salesOrderReceivedAmountArr['received_amount'])&&$salesOrderReceivedAmountArr['received_amount'] > 0){
				$downPaymentAmount = $salesOrderReceivedAmountArr['received_amount'];
				$salesOrderReceivedAmountArr['company_id'] = $companyId;
				$dataArr = array_merge(
					$salesOrderReceivedAmountArr ,
					[
						'contract_id'=>$contractId,
						'customer_id'=>$customerId,
						'down_payment_amount'=>$downPaymentAmount,
						'currency'=>$this->getReceivingCurrency()
					],
					[
						'sales_order_id'=>$salesOrderReceivedAmountArr['sales_order_id'] == -1 ? null : $salesOrderReceivedAmountArr['sales_order_id'],
						'down_payment_balance'=>$downPaymentAmount
					]
				) ;
				$this->downPaymentSettlements()->create($dataArr);
			}
		}
	}
	public function getAccountTypeId()
	{
		if($this->isIncomingTransfer()){
			return $this->incomingTransfer->getAccountTypeId();
		}
		if($this->isCheque()){
			return $this->cheque->getAccountTypeId();
		}
		if($this->isCashInBank()){
			return $this->cashInBank->getAccountTypeId();
		}
		throw new \Exception('Custom Exception .. getAccountTypeId .. This Method Is Only For Incoming Transfer Or Payable Cheque');
	}
	public function getAccountNumber()
	{
		if($this->isIncomingTransfer()){
			return $this->incomingTransfer->getAccountNumber();
		}
		if($this->isCheque()){
			return $this->cheque->getAccountNumber();
		}
		if($this->isCashInBank()){
			return $this->cashInBank->getAccountNumber();
		}
		throw new \Exception('Custom Exception .. getAccountNumber .. This Method Is Only For Incoming Transfer Or Payable Cheque');
	}	
		
	
}
