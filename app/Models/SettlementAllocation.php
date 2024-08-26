<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SettlementAllocation extends Model
{
	
	protected $guarded = ['id'];
	

	public function moneyPayment()
	{
		return $this->belongsTo(MoneyPayment::class,'money_payment_id','id');
	}
	
	public function contract()
	{
		return $this->belongsTo(Contract::class,'contract_id','id');
	}
	public function getInvoiceNumber()
	{
		return $this->invoice_number;
	}
	public function getAmount()
	{
		return $this->allocation_amount ;
	}
	public static function getSettlementAllocationPerContractAndMoneyType(array &$result , array &$totalCashOutFlowArray  , string $moneyType,string $dateFieldName,int $contractId , int $customerId, string $startDate , string $endDate , string $currentWeekYear , ?string $chequeStatus = null ):void
	{
		// $totalCashFlowKey = __('Net Cash (+/-)');
		// $totalCashOutFlowKey = __('Total Cash Outflow');
		$keyNameForCurrentType = [
			MoneyPayment::OUTGOING_TRANSFER => __('Outgoing Transfers'),
			MoneyPayment::CASH_PAYMENT =>__('Cash Payments'),
			MoneyPayment::PAYABLE_CHEQUE => $chequeStatus == PayableCheque::PAID ? __('Paid Payable Cheques') : __('Under Payment Payable Cheques')
		][$moneyType];
		
		
	
		$settlementAllocations  =  self::where('settlement_allocations.contract_id',$contractId)->with(['moneyPayment','moneyPayment.supplier'])
			->join('money_payments','settlement_allocations.money_payment_id','=','money_payments.id')
			->where('money_payments.type',$moneyType)
			->where('partner_id',$customerId)
			->whereBetween($dateFieldName,[$startDate,$endDate])
			->when($chequeStatus , function(Builder $builder) use ($chequeStatus){
				$builder->join('payable_cheques','payable_cheques.money_payment_id','=','money_payments.id')
				->where('payable_cheques.status',$chequeStatus);
			})
			->get(['settlement_allocations.contract_id','invoice_number','settlement_allocations.money_payment_id','allocation_amount']);
		
			foreach($settlementAllocations as $settlementAllocation){
				$supplier = $settlementAllocation->moneyPayment->supplier ;
				$invoiceNumber = $settlementAllocation->invoice_number ; 
				$keyNameForCurrentType = $keyNameForCurrentType.' - '. __('Invoice No') .' ' .$invoiceNumber ;
		
				$currentAmountAllocationAmount = $settlementAllocation->allocation_amount ;
				$supplierName = $supplier->getName();
				$result['suppliers'][$supplierName][$keyNameForCurrentType]['weeks'][$currentWeekYear] = isset($result['suppliers'][$supplierName][$keyNameForCurrentType]['weeks'][$currentWeekYear]) ? $result['suppliers'][$supplierName][$keyNameForCurrentType]['weeks'][$currentWeekYear] + $currentAmountAllocationAmount :  $currentAmountAllocationAmount;
				$result['suppliers'][$supplierName][$keyNameForCurrentType]['total'] = isset($result['suppliers'][$supplierName][$keyNameForCurrentType]['total']) ? $result['suppliers'][$supplierName][$keyNameForCurrentType]['total']  + $currentAmountAllocationAmount : $currentAmountAllocationAmount;
				$currentTotal = $currentAmountAllocationAmount;
				$result['suppliers'][$supplierName]['total'][$currentWeekYear] = isset($result['suppliers'][$supplierName]['total'][$currentWeekYear]) ? $result['suppliers'][$supplierName]['total'][$currentWeekYear] +  $currentTotal : $currentTotal ;
				$result['suppliers'][$supplierName]['total']['total_of_total'] = isset($result['suppliers'][$supplierName]['total']['total_of_total']) ? $result['suppliers'][$supplierName]['total']['total_of_total'] + $result['suppliers'][$supplierName]['total'][$currentWeekYear] : $result['suppliers'][$supplierName]['total'][$currentWeekYear];
				$totalCashOutFlowArray[$currentWeekYear] = isset($totalCashOutFlowArray[$currentWeekYear]) ? $totalCashOutFlowArray[$currentWeekYear] +   $currentTotal : $currentTotal ;
				// $result['cash_expenses'][$totalCashOutFlowKey]['total'][$currentWeekYear] = isset($result['cash_expenses'][$totalCashOutFlowKey]['total'][$currentWeekYear]) ? $result['cash_expenses'][$totalCashOutFlowKey]['total'][$currentWeekYear] +  $currentTotal : $currentTotal ;
				// $result['cash_expenses'][$totalCashFlowKey]['total'][$currentWeekYear] = isset($result['cash_expenses'][$totalCashFlowKey]['total'][$currentWeekYear]) ? $result['cash_expenses'][$totalCashFlowKey]['total'][$currentWeekYear] -  $currentTotal : $currentTotal * -1 ;
		
				// $currentTotalInflow = $totalCashInFlowArray[$currentWeekYear]??0  ;
				// $totalCashFlowArray[$currentWeekYear] =  isset($totalCashFlowArray[$currentWeekYear]) ? $totalCashFlowArray[$currentWeekYear] + $currentTotalInflow - $totalCashOutFlowArray[$currentWeekYear] : $currentTotalInflow - $totalCashOutFlowArray[$currentWeekYear]; 
			}
	}
	
}	
