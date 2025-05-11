<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CashflowReport extends Model
{
	protected $guarded = [];
	protected $casts = [
		'report_data'=>'array'
		// 'result'=>'array',
		// 'dates'=>'array',
		// 'weeks'=>'array',
		// 'finalResult'=>'array',
		// 'pastDueCustomerInvoices'=>'array',
		// 'customerDueInvoices'=>'array',
		// 'months'=>'array',
		// 'days'=>'array',
		// 'pastDueSupplierInvoices'=>'array',
		// 'supplierDueInvoices'=>'array',
		// 'pastDueInstallments'=>'array',
		// 'pastDueLoanInstallments'=>'array',
	];
	public function cashProjects()
	{
		return $this->hasMany(CashProjection::class,'cashflow_report_id');
	}
	public function getName():string 
	{
		return $this->report_name ;
	}
	public function getReportName():string 
	{
		return $this->getName();
	}
	public function getIntervalName():string 
	{
		return $this->report_interval ;
	}
	public function getStartDate():string 
	{
		return $this->start_date ;
	}
	public function getStartDateFormatted()
	{
		$date = $this->getStartDate() ;
		return $date ? Carbon::make($date)->format('d-m-Y'):null ;
	}
	public function getEndDate():string
	{
		return $this->end_date ;
	}
	public function getEndDateFormatted()
	{
		$date = $this->getEndDate() ;
		return $date ? Carbon::make($date)->format('d-m-Y'):null ;
	}
		
	
}
