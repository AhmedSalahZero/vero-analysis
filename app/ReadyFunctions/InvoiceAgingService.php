<?php 
namespace App\ReadyFunctions;

use App\Models\CustomerDueCollectionAnalysis;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class InvoiceAgingService
{
	const MORE_THAN_150  = 'More Than 150';
	protected $company_id , $aging_date ;  
	
	public function __construct(int $companyId , string $agingDate)
	{
		$this->company_id = $companyId ; 
		if(!isValidDateFormat($agingDate , 'Y-m-d')){
			throw new \Exception('Custom Exception Invalid Date Format Passed .. Excepted Format To Be Y-m-d');
		}
		$this->aging_date = $agingDate ; 
		
	}
	public function __execute(array $customerNames)
	{
		$result = [];
		$items = DB::table('customer_due_collection_analysis')->where('company_id',$this->company_id)
		->selectRaw('customer_name ,invoice_due_date, invoice_date,invoice_number,net_invoice_amount')->where('invoice_date' ,'<=' , $this->aging_date);
		
		if(count($customerNames)){
			$items->whereIn('customer_name',$customerNames);
		}
		$items = $items->get();
		foreach($items as $index => $item){
			$customerName = $item->customer_name ;
			$invoiceNumber = $item->invoice_number;
			$invoiceDueDate = $item->invoice_due_date;
			$netInvoiceAmount = $item->net_invoice_amount ;
			$dueNameWithDiffDays = $this->getDueNameWithDiffInDays($invoiceDueDate,$this->aging_date);
				$dueName = array_key_first($dueNameWithDiffDays);
				$diffInDays = $dueNameWithDiffDays[$dueName];
				$dayInterval = $this->getDayInterval($diffInDays);
				if($diffInDays == 0){
					$dueName = 'current_due';
					$dayInterval = 0 ;
				}
					$result[$customerName][$dueName][$dayInterval] = isset($result[$customerName][$dueName][$dayInterval])  ?  $result[$customerName][$dueName][$dayInterval] + $netInvoiceAmount : $netInvoiceAmount ;
					if($netInvoiceAmount){
						$result[$customerName][$dueName]['no_invoices'][$dayInterval]  = isset($result[$customerName][$dueName]['no_invoices'][$dayInterval]) ? $result[$customerName][$dueName]['no_invoices'][$dayInterval] + 1 : 1 ;
					}
					
					$result[$customerName][$dueName]['total'] = isset($result[$customerName][$dueName]['total']) ? $result[$customerName][$dueName]['total'] + $netInvoiceAmount : $netInvoiceAmount ; 
					$result[$customerName]['total'] = isset($result[$customerName]['total']) ? $result[$customerName]['total'] + $netInvoiceAmount : $netInvoiceAmount;
					$result[$customerName]['invoices'][$invoiceNumber][$dueName][$dayInterval] = $netInvoiceAmount;
					$result[$customerName]['invoices'][$invoiceNumber][$dueName]['total'] = isset($result[$customerName]['invoices'][$invoiceNumber][$dueName]['total']) ? $result[$customerName]['invoices'][$invoiceNumber][$dueName]['total']  +$netInvoiceAmount  : $netInvoiceAmount;
					$result[$customerName]['invoices'][$invoiceNumber]['total'] = isset($result[$customerName]['invoices'][$invoiceNumber]['total']) ? $result[$customerName]['invoices'][$invoiceNumber]['total']  +$netInvoiceAmount  : $netInvoiceAmount;
					$result['total'][$dueName][$dayInterval] = isset($result['total'][$dueName][$dayInterval]) ? $result['total'][$dueName][$dayInterval] + $netInvoiceAmount :$netInvoiceAmount ;
					if($netInvoiceAmount){
						$result['invoice_count'][$dueName][$dayInterval] = isset($result['invoice_count'][$dueName][$dayInterval]) ? $result['invoice_count'][$dueName][$dayInterval] + 1 : 1 ;
						$result['invoice_count'][$dueName]['customers'][$dayInterval][$customerName] = $customerName;
					}
					
					$result['grand_total'] = isset($result['grand_total']) ? $result['grand_total'] + $netInvoiceAmount :$netInvoiceAmount ;
					if($netInvoiceAmount){
						$result['grand_customers_total'][$customerName] = $customerName ;
					}
					$result['total_of_due'][$dueName] = isset($result['total_of_due'][$dueName]) ? $result['total_of_due'][$dueName] + $netInvoiceAmount: $netInvoiceAmount ;
					
					if($netInvoiceAmount){
						$result['total_customers_due'][$dueName][$customerName] = $customerName ;
					}
				}
				
				foreach(['coming_due','current_due','past_due'] as $dueName){
						$totalOfAllDue = isset($result['total_of_due']) ? array_sum($result['total_of_due']) : 0 ;
						$result['charts']['Total Aging Analysis Chart'][] =[
							'item'=>$this->getTotalAgainItemNameFromDue($dueName,$this->aging_date),
							'value'=>$totalAgingValue = $result['total_of_due'][$dueName] ?? 0,
							'percentage'=>$totalAgingValue && $totalOfAllDue ? $totalAgingValue /  $totalOfAllDue * 100:0  ,
							'total_for_all_values'=>isset($totalOfAllDue) ? $totalOfAllDue : 0,
							'total_for_all_percentages'=>isset($totalOfAllDue) && $totalOfAllDue > 0 ? '100' : 0
						]; 
						if($dueName == 'coming_due' || $dueName =='past_due'){
							foreach(array_merge(getInvoiceDayIntervals()  , [self::MORE_THAN_150]) as $dayInterval){
								$chartKeyName = null;
								if($dueName == 'past_due'){
									$chartKeyName = 'Total Past Dues Aging Analysis Chart';
								}
								if($dueName =='coming_due'){
									$chartKeyName = 'Total Coming Dues Aging Analysis Chart';
								}
								$totalOfAllValues = isset($result['total'][$dueName]) ? array_sum($result['total'][$dueName]) :  0 ; 
								$result['charts'][$chartKeyName] []= [
									'item'=>$dayInterval .  ' ' . __('Days'),
									'value'=>$currentValue = $result['total'][$dueName][$dayInterval] ?? 0 ,
									'percentage'=>$currentValue && $totalOfAllValues ? $currentValue /$totalOfAllValues * 100  : 0 ,
									'total_for_all_values'=>$totalOfAllValues ,
									'total_for_all_percentages' =>  $totalOfAllValues > 0 ? 100 : 0 
								];
							}	
						}
						
				}
				// dd($result['charts']);
				// dd($result['charts']);
				// dd($result['total_customers_due']);
				// dd($result);
		return $result ;
	}
	
	protected function getDueNameWithDiffInDays(string $date , string $agingDate):array{
		$date = Carbon::make($date);
		$agingDate = Carbon::make($agingDate);
		$diffInDays = $date->diffInDays($agingDate);
		// dd()
		if($diffInDays == 0){
			return ['current_due'=>$diffInDays];
		} 
		if($agingDate->greaterThan($date)){
			return ['past_due'=>$diffInDays];
		}
		return ['coming_due'=>$diffInDays];
	}
	
	protected function getInvoiceDayIntervals()
	{
		return getInvoiceDayIntervals();
	}
	protected function getDayInterval(int $diffDays){
		foreach($this->getInvoiceDayIntervals() as $dayInterval){
			$days = explode('-',$dayInterval);
			$firstDay = $days[0];
			$twoDay = $days[1];
			if(in_array($diffDays, range($firstDay,$twoDay))){
				return 				$dayInterval;
			}
		}
		return SELF::MORE_THAN_150 ; 
	}
	
function getTotalAgainItemNameFromDue(string $dueName,string $againDate)
{
	if($dueName == 'past_due'){
		return 'Total Past Dues';
	}
	if($dueName == 'current_due'){
		return 'Current Due [at date '. Carbon::make($againDate)->format('d-m-Y') .'] ';
	}
	if($dueName == 'coming_due'){
		return 'Total Coming Dues';
	}
}
	
}
