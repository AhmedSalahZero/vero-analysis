<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\IncomeStatement;
use App\Models\IncomeStatementItem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;


HeadingRowFormatter::default('none');
class ActualIncomeStatementImport implements
ToCollection,
    //   WithChunkReading,
    //   ShouldQueue,
      WithCalculatedFormulas,
      WithHeadingRow
	//   ,   WithBatchInserts

{
    public $company;
    public $incomeStatement;
    public function __construct(Company $company,IncomeStatement $incomeStatement)
    {
        $this->company = $company;
        $this->incomeStatement =$incomeStatement;
    }
	public function collection(Collection $rows)
    {

		$dates = checkIfAllDates($rows[0]->toArray());
	
		if(! count($dates)){
			return  collect([]);
		}
		$rows = $rows->forget([0])->values();
		// storeReport
		$subItems = [];
		$quantities =[];
        foreach ($rows as $index=>$row) 
        {		
				$fullName = $row[0];
				$mainName = trim(explode('-', $fullName, 2)[0]);
				$subItemName = trim(explode('-', $fullName, 2)[1]);
				$mainItem = IncomeStatementItem::where('name',$mainName)->where('financial_statement_able_type','IncomeStatement')->first();
				$currentValues = [];
				foreach($dates as $dateIndex=>$dateAsString){
					// $currentDate = $date.'-01' ;
					$currentValue = 0;
					if($row[$dateIndex+1] != null){
						$currentValue = $row[$dateIndex+1]; 
					}else{
						$model = $this->incomeStatement->subItems->where('pivot.financial_statement_able_id',$this->incomeStatement->id)->where('pivot.financial_statement_able_item_id',$mainItem->id)->where('pivot.sub_item_name',$subItemName)->where('pivot.sub_item_type','actual')->first() ;
						$currentValue = ((array)json_decode($model->pivot->payload))[$dateIndex] ?? 0 ;
					}
					$currentValues[$dateIndex] = 	number_unformat($currentValue) ;	
					// $subItems['value'][$this->incomeStatement->id][$mainItem->id][$subItemName][$currentDate] = number_unformat($currentValue);
				}
				
				if($mainItem && $mainItem->id == IncomeStatementItem::SALES_REVENUE_ID && str_contains($subItemName,' ( Quantity )') ){
					$quantities[$index] = $currentValues;
				}
				
				$subItems[$index] = [
					'name'=>$subItemName ,
					'financial_statement_able_item_id'=> $mainItem->id ,
					'percentage_or_fixed'=>'non_repeating_fixed',
					'can_be_percentage_or_fixed'=>1 ,
					'vat_rate'=>0,
					'non_repeating_popup'=>$currentValues
				];
			}
			// remove quantities and append it to values 
			/**
			 * * هنعمل فورمات تاني علشان نحط ال quantity , value 
			 * * مع بعض في نفس ال array 
			 * * بدل ما هما في اتنين اري مختلفين
			 */
			foreach($quantities as $index => $quantityValArr){
				unset($subItems[$index]);
				$subItems[$index+1]['quantity'] =  $quantityValArr;
				$subItems[$index+1]['val']  = $subItems[$index+1]['non_repeating_popup'];
				unset($subItems[$index+1]['non_repeating_popup']);
			}
			$subItems=array_values($subItems);
			
			
			$newRequest = (new Request())->merge([
				'in_add_or_edit_modal'=>1 ,
				'sub_item_type'=>'actual',
				'financial_statement_able_id'=>$this->incomeStatement->id,
				'income_statement_id'=>$this->incomeStatement->id,
				'sub_items'=>$subItems
			]);
			
			$this->incomeStatement->storeReport($newRequest);
		return $rows ;
    }

    public function dateFormatting($date)
    {
        if(is_numeric($date)){
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
        }else{

            if(str_contains($date,'/')){
                $this->format = str_replace('-','/',$this->format);
            }
            $strtotimeValue = date_create_from_format($this->format,$date);

            $date =  $strtotimeValue->format('Y-m-d');
        }
        return $date;

    }
	public function headingRow(): int
    {
        return 2;
    }

}
