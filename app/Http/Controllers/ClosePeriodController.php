<?php
use App\Http\Controllers\ExportTable;
namespace App\Http\Controllers;
use App\Http\Requests\StoreMoneyReceivedRequest;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\MoneyReceived;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClosePeriodController
{
    use GeneralFunctions;
    public function execute(Company $company,Request $request)
	{
		dd($request->all());
    }
}
