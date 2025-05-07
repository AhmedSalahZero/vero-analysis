<?php

namespace App\Models;

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
}
