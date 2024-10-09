<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDownPaymentSettlementRequest;
use App\Models\Company;
use App\Models\MoneyReceived;
use App\Models\Partner;
use App\Traits\Models\HasBasicFilter;
use Illuminate\Http\Request;

class UnappliedAmountsController extends Controller
{
	use HasBasicFilter;
    public function index(Company $company,Request $request,int $partnerId,string $modelType)
	{
		
		$fullModelType = 'App\Models\\'.$modelType;
		$moneyModelName = $fullModelType::MONEY_MODEL_NAME ;
		$partner = Partner::find($partnerId);
		$partnerName = $partner->getName();
		$unappliedAmountsType = MoneyReceived::UNAPPLIED_AMOUNTS;
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		// $currentType = $request->get('active',MediumTermLoan::RUNNING);
		$currentType = $request->get('active',$unappliedAmountsType);
		
		$filterDates = [];
		foreach([$unappliedAmountsType] as $type){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$type) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$type) : now()->format('Y-m-d');
			
			$filterDates[$type] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
		}
		
		
		 
		  /**
		 * * start of bank to safe internal money transfer 
		 */
		
		$runningStartDate = $filterDates[$unappliedAmountsType]['startDate'] ?? null ;
		$runningEndDate = $filterDates[$unappliedAmountsType]['endDate'] ?? null ;
		$unappliedAmounts = $company->unappliedAmounts ;
		$unappliedAmounts =  $unappliedAmounts->filterByStartDate($runningStartDate,$runningEndDate) ;
		$unappliedAmounts =  $currentType == $unappliedAmountsType ? $this->applyFilter($request,$unappliedAmounts):$unappliedAmounts ;

		/**
		 * * end of bank to safe internal money transfer 
		 */
		 
		
		 $searchFields = [
			$unappliedAmountsType=>[
				'name'=>__('Name'),
				'start_date'=>__('Start Date'),
				'end_Date'=>__('End Date'),
			],
		];
	
		$models = [
			$unappliedAmountsType =>$unappliedAmounts ,
		];

        return view('contracts-down-payment.index', [
			'company'=>$company,
			'modelType'=>$modelType,
			'moneyModelName'=>$moneyModelName,
			'searchFields'=>$searchFields,
			'models'=>$models,
			'title'=>$partnerName . ' ' .__('Contracts Down Payment'),
			'tableTitle'=>__('Contracts Down Payment Table') ,
			// 'financialInstitution'=>$financialInstitution,
			'filterDates'=>$filterDates
		]);
    }
	public function downPaymentSettlements(Company $company,Request $request, int $downPaymentId ,string $modelType)
	{
		$fullClassName = 'App\Models\\'.$modelType;
		$downPaymentModelName=$fullClassName::MONEY_MODEL_NAME;
		$downPaymentModelFullName = 'App\Models\\'.$downPaymentModelName ;   
		$downPayment =$downPaymentModelFullName::find($downPaymentId);
		$contract = $downPayment->contract;
		$partnerId = $contract->getClientId();
		$partnerName = $contract->getClientName();
		$inEditMode = false ;
		$fullClassName = ('\App\Models\\' . $modelType) ;
        $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        $clientNameColumnName = $fullClassName::CLIENT_NAME_COLUMN_NAME ;
		$customerNameText = (new $fullClassName)->getClientNameText();
        $jsFile = $fullClassName::JS_FILE ;
		$contractCurrency = $contract->getCurrency();
		$currencies = $fullClassName::getCurrencies();
		$currencies = array_filter($currencies,function($item) use ($contractCurrency){
			return $item == $contractCurrency;
		});
		$invoices =  $fullClassName::where('contract_code',$contract->getCode())
		->where('customer_name',$partnerName)
		->where('currency','=',$contractCurrency)
		->where('company_id',$company->id)
		->where('net_invoice_amount','>',0);
		if(!$inEditMode){
			$invoices->where('net_balance','>',0);
		}
		$invoices = $invoices->orderBy('invoice_date','asc')->get() ; 

		return view('contracts-down-payment.settlement_form',[
			'modelType'=>'MoneyReceived',
			'customerNameText'=>__('Customer Name'),
			'invoices'=>$invoices ,
			'downPayment'=>$downPayment,
			'currencies'=>$currencies,
			'contract'=>$contract,
			'model'=>$contract->moneyReceived,
			'company'=>$company,
			'jsFile'=>$jsFile,
			'modelType'=>$modelType,
			'customerNameText'=>$customerNameText,
			'customerNameColumnName'=>$clientNameColumnName,
			'customerIdColumnName'=>$clientIdColumnName,
			'partnerId'=>$partnerId ,
			'partnerName'=>$partnerName

		]);
	}
	public function storeDownPaymentSettlement(StoreDownPaymentSettlementRequest $request,Company $company,int $downPaymentId,int $partnerId,string $modelType)
	{
		$fullClassName = 'App\Models\\'.$modelType;
		$downPaymentModelName=$fullClassName::MONEY_MODEL_NAME;
		$downPaymentModelFullName = 'App\Models\\'.$downPaymentModelName ;   
		$downPayment =$downPaymentModelFullName::find($downPaymentId);
		$downPayment->update([
			'down_payment_settlement_date'=>$request->get('settlement_date')
		]);
		$downPayment->settlements->each(function($settlement){
			$settlement->delete();
		});
		$downPayment->storeNewSettlement($request->get('settlements',[]),$downPayment->getName(),$company->id);
		return redirect()->route('view.contracts.down.payments',['company'=>$company->id,'partnerId'=>$partnerId,'modelType'=>$modelType]);
		
	}
}
