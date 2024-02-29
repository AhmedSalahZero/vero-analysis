<?php
namespace App\Http\Controllers;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\CleanOverdraft;
use App\Models\Company;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitution;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NotificationSettingsController
{
    use GeneralFunctions;
	public function index(Company $company,Request $request)
	{
        return view('notifications.form', [
			'company'=>$company,
			'model'=>$company->notificationSetting
		]);
    }
	public function store(Request $request, Company $company){
		$setting = $company->notificationSetting;
		$data = $request->except(['_token']);
		$setting ? $setting->update($data) :$company->notificationSetting()->create($data) ;
		return redirect()->route('notifications-settings.index',['company'=>$company->id]);
	}
	public function markAsRead(Company $company)
	{
		$company->unreadNotifications->markAsRead();
	}
}
