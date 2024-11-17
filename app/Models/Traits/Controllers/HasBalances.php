<?php 
namespace App\Models\Traits\Controllers;

use App\Helpers\HArr;
use App\Models\InvoiceDeduction;
use App\Models\MoneyReceived;
use Carbon\Carbon;
use Illuminate\Support\Collection;



trait HasBalances 
{
	public static function formatForStatementReport(Collection $invoices,int $partnerId,string $startDate,string $endDate,string $currency,string $modelType){
		$isMainCurrency = $currency == 'main_currency' ;
		$startDateFormatted = Carbon::make($startDate)->format('d-m-Y');
		$index = -1 ;
		/**
		 * @var CustomerInvoice $firstCustomerInvoice
		 */
		$oneDayBeforeStartDate = Carbon::make($startDate)->subDays(1000)->format('Y-m-d');
	
		$startDateMinusOne = Carbon::make($startDate)->subDay()->format('Y-m-d');
		$fullClassName = ('\App\Models\\' . $modelType) ;
		$clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
		
		$clientInvoiceIds = $fullClassName::getForPartner($partnerId,$currency,$isMainCurrency);
		$invoicesForBeginningBalance = $fullClassName::getInvoicesForInvoiceStartAndEndDate( $clientIdColumnName, $partnerId, getCurrentCompany() ,  $currency ,  $oneDayBeforeStartDate,$startDateMinusOne );
		$formattedData = [];
		$beginningBalance = 
		// $isMainCurrency ? 
		self::appendBalances($isMainCurrency , $currency,$invoicesForBeginningBalance, $index, $formattedData, $partnerId, $oneDayBeforeStartDate,$startDateMinusOne,$clientInvoiceIds,$modelType,false) ;
		// : self::getBeginningBalanceUntil($currency,$partnerId,$oneDayBeforeStartDate,$startDateMinusOne) ; 
		$index = 0 ;
		$currentData['date'] = $startDateFormatted;
		$currentData['document_type'] = 'Beginning Balance';
		$currentData['document_no'] = null;
		$currentData['debit'] = $debit = $beginningBalance >= 0 ? $beginningBalance : 0;
		$currentData['credit'] = $credit = $beginningBalance < 0 ? $beginningBalance * -1 : 0 ;
		$currentData['end_balance'] =$debit - $credit;
		$currentData['comment'] =null;
		$index++ ;
		$formattedData[$index] = $currentData;

		
		// $currentData['date'] = $startDateFormatted;
		// $currentData['document_type'] = 'Beginning Balance';
		// $currentData['document_no'] = null;
		// $currentData['debit'] = 0;
		// $currentData['credit'] =0;
		// $currentData['end_balance'] =0;
		// $currentData['comment'] =null;
		// $index++ ;
		// $formattedData[$index] = $currentData;
		
		

		self::appendBalances($isMainCurrency , $currency,$invoices, $index, $formattedData, $partnerId, $startDate, $endDate,$clientInvoiceIds,$modelType,true);
	
		
	return HArr::sortBasedOnKey($formattedData,'date');
}

	public static function appendBalances($isMainCurrency ,string $currency,$invoices,int &$index,array &$formattedData,int $partnerId,string $startDate,string $endDate , array $clientInvoiceIds , string $modelType , bool $isNotBegBalance = true )
	{
		$isCustomer = $modelType == 'CustomerInvoice';
		$tempArr = [];
		$fullInvoiceModelName = 'App\Models\\'.$modelType;
		$fullMoneyModelName ='App\Models\\'.$fullInvoiceModelName::MONEY_MODEL_NAME ;
		$dateColumnName = $fullInvoiceModelName::RECEIVING_OR_PAYMENT_DATE_COLUMN_NAME;
		foreach($invoices as $customerInvoice){
			$currentAmount =  $isMainCurrency ?  $customerInvoice->getNetInvoiceInMainCurrencyAmount() : $customerInvoice->getNetInvoiceAmount();
			$currentDebit = $isCustomer ? $currentAmount : 0;
			$currentCredit = $isCustomer ? 0 : $currentAmount ;
			$invoiceExchangeRate = $customerInvoice->getExchangeRate();
			$currentData = [];
			$invoiceDate = $customerInvoice->getInvoiceDateFormatted() ;
			$invoiceNumber  = $customerInvoice->getInvoiceNumber() ;
			$currentData['date'] = $invoiceDate;
			$currentData['document_type'] = 'Invoice';
			$currentData['document_no'] = $invoiceNumber;
			$currentData['debit'] = $currentDebit  ;
			$currentData['credit'] =$currentCredit;
			$currentData['comment'] =null;
			if($isNotBegBalance){
				$index++ ;
				$formattedData[$index]=$currentData;
			}else{
				$index++ ;
				$tempArr[$index] = $currentData ;
				
			}
			
			
			
		}
		foreach(InvoiceDeduction::getForInvoices($clientInvoiceIds,$modelType,$startDate,$endDate) as $invoiceDeduction){
			$invoice = $invoiceDeduction->getInvoice();
			$invoiceExchangeRate = $invoice->getExchangeRate();
			$currentInvoiceNumber = $invoice->getInvoiceNumber();
			$deductionAmount = $invoiceDeduction->getAmount() ;
			$currentDeductionAmount =$isMainCurrency ? $invoiceExchangeRate * $deductionAmount : $deductionAmount;
			$currentDebit = $isCustomer  ?  0 : $currentDeductionAmount  ;
			$currentCredit = $isCustomer  ?  $currentDeductionAmount : 0 ;
			$deductionDate = $invoiceDeduction->getDate() ;
			$currentData['date'] = Carbon::make($deductionDate)->format('d-m-Y');
			$currentData['document_type'] = 'Deduction';
			$currentData['document_no'] = $currentInvoiceNumber;
			$currentData['debit'] = $currentDebit;
			$currentData['credit'] = $currentCredit;
			$currentData['comment'] =$invoiceDeduction->getDeductionName() . ' [ '  . $currentInvoiceNumber .' ] ' ;
			if($isNotBegBalance){
				$index++ ;
				$formattedData[$index]=$currentData;
			}else{
				$index++ ;
				$tempArr[$index] = $currentData ;
			}
		}
		
		$allMoneyModels =  $fullMoneyModelName::
		where('company_id',getCurrentCompanyId())
		->whereBetween($dateColumnName,[$startDate,$endDate])
		->where('partner_id',$partnerId)
		->when(!$isMainCurrency , function($q) use ($currency){
			// $q->where('currency',$currency);
		})
		->get() ; 
	
		foreach($allMoneyModels as $moneyModel) {
		
			$dateReceivingFormatted = $moneyModel->getReceivingOrPaymentMoneyDateFormatted() ;
			$moneyModelType = $moneyModel->getType();
			$docNumber = $moneyModel->getNumber();
				$moneyModelAmount = $isMainCurrency ? $moneyModel->getAmountForMainCurrency() :$moneyModel->getAmountInInvoiceCurrency() ;
				if($moneyModelAmount){
					if($moneyModel->getInvoiceCurrency() == $currency  || $isMainCurrency	 ){
						$currentAmount =  $moneyModelAmount ;
						$currentDebit = $isCustomer ? 0 : $currentAmount;
						$currentCredit = $isCustomer ? $currentAmount : 0 ;
						$invoiceNumbers = implode('/',$moneyModel->settlements->pluck('invoice.invoice_number')->toArray());
						$currentComment = $fullMoneyModelName::generateComment($moneyModel,app()->getLocale(),$invoiceNumbers,'');
						$currentData = []; 
						$currentData['date'] = $dateReceivingFormatted;
						$currentData['document_type'] = $moneyModelType;
						$currentData['document_no'] = $docNumber  ;
						$currentData['debit'] = $currentDebit;
						$currentData['credit'] =$currentCredit;
						$currentData['comment'] = $currentComment ;
						if($isNotBegBalance){
							$index++ ;
							$formattedData[] = $currentData ;
						}else{
							$index++ ;
							$tempArr[] = $currentData ;
						}
						
						
						$totalWithholdAmount = $isMainCurrency ? $moneyModel->getTotalWithholdInInvoiceExchangeRate() : $moneyModel->getTotalWithholdAmount();
					if($isNotBegBalance){
						$isMainCurrency  ? $moneyModel->appendForeignExchangeGainOrLoss($formattedData,$index) : null ; 
					}else{
						$isMainCurrency  ? $moneyModel->appendForeignExchangeGainOrLoss($tempArr,$index) : null ; 
					}
					if($totalWithholdAmount){
						$currentDebit = $isCustomer ? 0 : $totalWithholdAmount;
						$currentCredit = $isCustomer ? $totalWithholdAmount:0;
						$currentData = []; 
						$currentData['date'] = $dateReceivingFormatted;
						$currentData['document_type'] = __('Withhold Taxes');
						$currentData['document_no'] =  $docNumber ;
						$currentData['debit'] = $currentDebit;
						$currentData['credit'] =$currentCredit;
						$currentData['comment'] =__('Withhold Taxes For Invoice No.') . ' ' . implode('/',$moneyModel->settlements->where('withhold_amount','>',0)->pluck('invoice.invoice_number')->toArray());
						if($isNotBegBalance){
							$index++ ;
							$formattedData[] = $currentData ;
						}
						else{
							$index++ ;
							$tempArr[] = $currentData ;
						}
						
						
					}
					
					
             
					
					
					
					
					
					}
					
					
					elseif($moneyModel->getReceivingOrPaymentCurrency() == $currency || $isMainCurrency){
						
						  // start down payment from receiving currency 
				
							$receivedAmountOrPaidAmount = $moneyModel->getAmount();
							$exchangeRate =  $moneyModel->getExchangeRate() ;
							$currentAmount =  $receivedAmountOrPaidAmount -  ($moneyModelAmount*$exchangeRate) ;
							if($currentAmount == 0){
								continue ;
							}
						  $currentDebit = $isCustomer ? 0 : $currentAmount;
						  $currentCredit = $isCustomer ? $currentAmount : 0 ;
						  $invoiceNumbers = implode('/',$moneyModel->settlements->pluck('invoice.invoice_number')->toArray());
						  $currentComment = $fullMoneyModelName::generateComment($moneyModel,app()->getLocale(),$invoiceNumbers,'');
						  $currentData = []; 
						  $currentData['date'] = $dateReceivingFormatted;
						  $currentData['document_type'] = $moneyModelType;
						  $currentData['document_no'] = $docNumber  ;
						  $currentData['debit'] = $currentDebit;
						  $currentData['credit'] =$currentCredit;
						  $currentData['comment'] = $currentComment ;
						  if($isNotBegBalance){
							  $index++ ;
							  $formattedData[] = $currentData ;
						  }else{
							  $index++ ;
							  $tempArr[] = $currentData ;
						  }
						  
					  
					  // end down payment from receiving currency
						
					}
					
					
				}
			
				
				
				
				
				
				
		}
		if(!$isNotBegBalance){
			return array_sum(array_column($tempArr,'debit')) - array_sum(array_column($tempArr,'credit'));
		}
		return $formattedData;
	}
	
	

}
