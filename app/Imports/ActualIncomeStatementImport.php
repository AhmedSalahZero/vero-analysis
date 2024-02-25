<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\CustomerInvoiceTest;
use App\Models\IncomeStatement;
use App\Models\IncomeStatementItem;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
		$rows = $rows->forget([0]);
		// storeReport
		$subItemsValues = [];
        foreach ($rows as $index=>$row) 
        {
				$fullName = $row[0];
				$mainName = trim(explode('-', $fullName, 2)[0]);
				$subItemName = trim(explode('-', $fullName, 2)[1]);
				$mainItem = IncomeStatementItem::where('name',$mainName)->where('financial_statement_able_type','IncomeStatement')->first();
				foreach($dates as $dateIndex=>$date){
					$currentDate = $date.'-01' ;
					$currentValue = 0;
					if($row[$dateIndex+1] != null){
						$currentValue = $row[$dateIndex+1]; 
					}else{
						$model = $this->incomeStatement->subItems->where('pivot.financial_statement_able_id',$this->incomeStatement->id)->where('pivot.financial_statement_able_item_id',$mainItem->id)->where('pivot.sub_item_name',$subItemName)->where('pivot.sub_item_type','actual')->first() ;
						$currentValue = ((array)json_decode($model->pivot->payload))[$currentDate] ?? 0 ;
					}				
					$subItemsValues['value'][$this->incomeStatement->id][$mainItem->id][$subItemName][$currentDate] = number_unformat($currentValue);
				}
			}
			// dd($subItemsValues);
			$newRequest = new Request(array_merge([
				'sub_item_type'=> 'actual' ,
				'financial_statement_able_id'=>$this->incomeStatement->id ,
			],$subItemsValues));
			$this->incomeStatement->storeReport($newRequest);
		return $rows ;
    }
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */

    // public function model(array $row)
    // {
    //     return new CustomerInvoiceTest([
    //         'customer_name'                             => $row['Customer Name'],
    //         'company_id'                                => $this->company_id,
    //         'business_sector'                           => $row['Business Sector'],
    //         'invoice_number'                            => $row['Invoice Number'],
    //         'invoice_date'                              => $this->dateFormatting($row['Invoice Date']),
    //         'due_within'                                => $row['Due Within'],
    //         'invoice_due_date'                          => $this->dateFormatting($row['Invoice Due Date']),
    //         'contract_code'                             => $row['Contract Code'],
    //         'contract_date'                             => $this->dateFormatting($row['Contract Date']),
    //         'purchase_order_number'                     => $row['Purchase Order Number'],
    //         'purchase_order_date'                       => $this->dateFormatting($row['Purchase Order Date']),
    //         'sales_order_number'                        => $row['Sales Order Number'],
    //         'sales_order_date'                          => $this->dateFormatting($row['Sales Order Date']),
    //         'sales_person_name'                         => $row['Sales Person Name'],
    //         'sales_person_rate'                         => $row['Sales Person Rate'],
    //         'invoice_amount'                            => $row['Invoice Amount'],
    //         'currency'                                  => $row['Currency'],
    //         'advance_payment_amount'                    => $row['Advance Payment Amount'],
    //         'vat_amount'                                => $row['VAT Amount'],
    //         'deduction_id_one'                          => $row['Deduction One'],
    //         'deduction_amount_one'                      => $row['Deduction Amount One'],
    //         'deduction_id_two'                          => $row['Deduction Two'],
    //         'deduction_amount_two'                      => $row['Deduction Amount Two'],
    //         'deduction_id_three'                        => $row['Deduction Three'],
    //         'deduction_amount_three'                    => $row['Deduction Amount Three'],
    //         'deduction_id_four'                         => $row['Deduction Four'],
    //         'deduction_amount_four'                     => $row['Deduction Amount Four'],
    //         'deduction_id_five'                         => $row['Deduction Five'],
    //         'deduction_amount_five'                     => $row['Deduction Amount Five'],
    //         'deduction_id_six'                          => $row['Deduction Six'],
    //         'deduction_amount_six'                      => $row['Deduction Amount Six'],
    //         'total_deduction'                           => $row['Total Deduction'],
    //         'invoice_net_amount'                        => $row['Invoice Net Amount'],
    //         'invoices_due_notification_days'            => $row['Invoices Due Notification Days'],
    //         'past_due_invoices_notification_days'       => $row['Past Due Invoices Notification Days'],
    //         'created_by'                                => $this->user_id,
    //     ]);
    // }
    // public function batchSize(): int
    // {
    //     return 500;
    // }
    // public function chunkSize(): int
    // {
    //     return 500;
    // }
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
