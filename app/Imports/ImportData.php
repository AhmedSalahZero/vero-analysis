<?php

namespace App\Imports;

use App\Events\ImportFailedEvent;
use App\Models\ActiveJob;
use App\Models\CachingCompany;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ImportData implements
	// ToModel,
	ToCollection,
	WithChunkReading,
	ShouldQueue,
	WithCalculatedFormulas,
	WithHeadingRow,
	WithBatchInserts,
	WithEvents
{
	use RegistersEventListeners;

	public $timeout = 50000*60;

	public $failOnTimeout = true;
	public $hasFailed = false;

	public static $static_model;

	public static $company_id;

	public $modelFields;

	public $format;

	public $model;

	private $job_id;

	private $companyId;

	private $batch;
	private $uploadModelName;

	private $errorMessage='';

	private $dateFailed =false;

	private $userId='';
	// private $rows = 0 ;

	public function __construct($company_id, $format, $model, $modelFields, $jobId, $userId,$uploadModelName)
	{
		Self::$company_id = $company_id;
		Self::$static_model = $model;
		$this->modelFields = $modelFields;
		$this->format = $format;
		$this->model = $model;
		$this->companyId = $company_id;
		$this->job_id = $jobId;
		$this->userId = $userId;
		$this->uploadModelName = $uploadModelName;
		// $this->batch = $batch;
	}
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */

	// public function getRowCount(): int
	// {
	//     return $this->rows;
	// }

	public function collection(Collection $chunks)
	{
		$dates = [];
		$validationRow = null;
		$isInvalidData = false;
		$rowId = 2 ;
		foreach ($chunks as $key=>$rows) {
			$data = $this->dataCustomizationImport($rows,$rowId);
			$rowId ++ ;
			if (isset($data['validations'])) {
				$isInvalidData = true;
				$validationRow = $data['validations'];
		
					DB::table('caching_company')->where('job_id', $this->job_id)->delete();
					$cachingKey = generateCacheKeyForValidationRow($this->companyId,$this->uploadModelName);
					$validationRows = $validationRow;
					if (Cache::has($cachingKey)) {
						$validationRows = arrayMergeTwoDimArray($validationRows,Cache::get($cachingKey, []));
					}
					Cache::forever($cachingKey , $validationRows);
				
			}
			$dates[] = $data;
		}
		
		if(!$isInvalidData){
			$key = Str::random(10) . 'for_company_' . $this->companyId;
			Cache::forever($key, $dates);
			DB::table('caching_company')->insert([
				'key_name'=>$key,
				'company_id'=>$this->companyId,
				'job_id'=>$this->job_id,
				'model'=>$this->uploadModelName
			]);
			
		}
	}

	public function batchSize(): int
	{
		return 1000;
	}

	public function chunkSize(): int
	{
		return 50000;
	}

	public function dateFormatting($date)
	{
		if (is_numeric($date)) {
			$date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
		} else {
			if (str_contains($date, '/')) {
				$this->format = str_replace('-', '/', $this->format);
			}
			$strtotimeValue = date_create_from_format($this->format, $date);
			if(!$strtotimeValue){
				$this->format = str_replace('/', '-', $this->format);
				$strtotimeValue = date_create_from_format($this->format, $date);
				$this->format = str_replace('-', '/', $this->format);
			}
			if (!$strtotimeValue) {
				// $cacheKey = generateKeyForFailed($this->companyId , $this->userId);
				// Cache::forever($cacheKey ,  );
				$this->errorMessage = __('Some Date Formate Is Not Correct');
				//TODO:if format [$this->format] is not correct it return false . so the following code causes error
				// logger([$this->format , $date]);
				return null;
			} else {
				$date =  $strtotimeValue->format('Y-m-d');
			}
		}

		return $date;
	}

	protected function validateRowValue($key, $value):array
	{
		
		$invalidDates = [];
		$allValidations =[ ];
		if(in_array($key , ['Date'  , __('Date') , 'Estimated',__('Estimated')])){
			$dateValidation = $this->dateFormatting($value);
				if (is_null($dateValidation)) {
					$allValidations[$key] =  [
						'value'=>$value,
						'message'=>__('Invalid Date Format'),
					];
				}
		}

		if(in_array($key , ['Document Type',__('Document Type')])){
			if (!in_array($value, ['INV', 'inv', 'invoice', 'INVOICE', 'فاتوره'])) {
				$allValidations[$key] =  [
					'value'=>$value,
					'message'=>__('Invalid Document Type Only Allowed [INV , inv , invoice , INVOICE ,فاتوره ] '),
				];
			}	
		}
		if(in_array($key , ['Quantity' , __('Quantity') , 'Quantity Discount' , __('Quantity Discount') , 'Cash Discount' , __('Cash Discount') , 'Special Discount' , __('Special Discount') , __('Other Discounts') , 'Net Sales Value' , __('Net Sales Value'),'Price Per Unit' , __('Price Per Unit') , __('Sales Value') , __('Sales Value')] )){
			if (!is_numeric($value) && !is_null($value) && $value != '') {
				$allValidations[$key] =  [
					'message'=>__('Invalid Numeric Value'),
					'value'=>$value
				];
			}
		}
		// if (is_null($value)) {
		// 	$allValidations[$key] =  [
		// 		'value'=>$value,
		// 		'message'=>__('Empty Values Not Allowed')
		// 	];
		// }
		return $allValidations;
		
		
	}

	public function dataCustomizationImport($row,$rowId)
	{
		$data = [];
		$row_with_no_spaces = [];
		$validations = [];
		
		foreach ($row as $key => $value) {
			$row_with_no_spaces[trim($key)] = trim($value);
			$rowValidation = $this->validateRowValue(trim($key), trim($value));
			if (isset($rowValidation[$key]) && count($rowValidation[$key])) {
				$validations[$rowId][$key] =  $rowValidation[$key] ;
			}
		}
		if(count($validations)){
			return [
				'validations'=>$validations
			] ;
		}

		foreach ($this->modelFields as $field_name => $row_name) {
			if (is_int($row_name)) {
				$data[$field_name] = $row_name;
			} else {
				if (isset($row_with_no_spaces[$row_name])) {
					if (str_contains($field_name, 'date') || str_contains($field_name,'estimated')) {
						$data[$field_name] = $this->dateFormatting($row_with_no_spaces[$row_name]);
					} else {
						$item = str_replace('\\', '', $row_with_no_spaces[$row_name]);
						$data[$field_name] = trim(preg_replace('/\s+/', ' ', $item));
					}
				} else {
					$data[$field_name] = null;
				}
			}
		}
		$data['id'] = generateIdForExcelRow($this->companyId);

		return $data;
	}

	public function registerEvents(): array
	{
		$error = $this->errorMessage;

		return [
			ImportFailed::class => function (ImportFailed $event) use ($error) {
				ActiveJob::where('id', $this->job_id)->where('model',$this->uploadModelName)->delete();
				CachingCompany::where('job_id', $this->job_id)->where('model',$this->uploadModelName)->delete();
				$key = generateCacheFailedName($this->companyId, $this->userId,$this->uploadModelName);
				$err = __('Excel Import Failed') . ' ' . $error;
				Cache::forever($key, $err);
			},
		];
	}

	
}
