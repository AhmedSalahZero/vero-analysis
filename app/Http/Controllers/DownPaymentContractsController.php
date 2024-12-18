<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDownPaymentSettlementRequest;
use App\Models\Company;
use App\Models\Contract;
use App\Models\CustomerInvoice;
use App\Models\MoneyReceived;
use App\Models\Partner;
use App\Traits\Models\HasBasicFilter;
use Illuminate\Http\Request;

class DownPaymentContractsController extends Controller
{
	use HasBasicFilter;
    public function viewContractsWithDownPayments(Company $company,Request $request,int $partnerId,string $modelType,string $currency)
	{
		$fullModelType = 'App\Models\\'.$modelType;
		$moneyModelName = $fullModelType::MONEY_MODEL_NAME ;
		$fullMoneyModelName = 'App\Models\\'.$fullModelType::MONEY_MODEL_NAME ;
		$moneyTableName = $fullModelType::MONEY_RECEIVED_OR_PAYMENT_TABLE_NAME ;
		$receivingOrPaymentCurrencyColumnName = $fullMoneyModelName::RECEIVING_OR_PAYMENT_CURRENCY_COLUMN_NAME;
		$partner = Partner::find($partnerId);
		$partnerId = $partner->id;
		$partnerName = $partner->getName();
		$contractsWithDownPayments = $fullMoneyModelName::CONTRACTS_WITH_DOWN_PAYMENTS;
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$currentType = $request->get('active',$contractsWithDownPayments);
		$filterDates = [];
		foreach([$contractsWithDownPayments] as $type){
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

		$moneyModels = $fullMoneyModelName::whereIn('money_type',[
			$fullMoneyModelName::DOWN_PAYMENT
			,$fullMoneyModelName::INVOICE_SETTLEMENT_WITH_DOWN_PAYMENT
		])
		->where($moneyTableName.'.company_id',$company->id)
		->where($moneyTableName.'.partner_id',$partnerId)
		->where($moneyTableName.'.'.$receivingOrPaymentCurrencyColumnName,$currency)
		->leftJoin('contracts','contracts.id','=','contract_id')
		->where(function($q){
			$q->where('contract_id','=',null)->orWhere('contracts.status','!=',Contract::FINISHED);
		})
		->with('contract')
		->selectRaw($moneyTableName.'.*,contracts.id as contractId')
		->get();

		
		 $searchFields = [
			$contractsWithDownPayments=>[
				'name'=>__('Name'),
				'start_date'=>__('Start Date'),
				'end_Date'=>__('End Date'),
			],
		];
	
		$models = [
			$contractsWithDownPayments =>$moneyModels ,
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
		$partnerId = $downPayment->getPartnerId();
		$partnerName = $downPayment->getPartnerName();
		$inEditMode = false ;
		$fullClassName = ('\App\Models\\' . $modelType) ;
        $clientIdColumnName = $fullClassName::CLIENT_ID_COLUMN_NAME ;
        $clientNameColumnName = $fullClassName::CLIENT_NAME_COLUMN_NAME ;
		$customerNameText = (new $fullClassName)->getClientNameText();
        $jsFile = $fullClassName::JS_FILE ;
		$contractCurrency = $downPayment->getCurrency();
		$currencies = $fullClassName::getCurrencies();
		$currencies = array_filter($currencies,function($item) use ($contractCurrency){
			return $item == $contractCurrency;
		});
		$invoices =  $fullClassName::
		when($contract,function($q) use ($contract){
			$q->where('contract_code',$contract->getCode());
		})
		->where($clientNameColumnName,$partnerName)
		->where('currency','=',$contractCurrency)
		->where('company_id',$company->id)
		->where('net_invoice_amount','>',0);
		if(!$inEditMode){
			$invoices->where('net_balance','>',0);
		}
	
		$invoices = $invoices->orderBy('invoice_date','asc')->get() ; 
		$downPaymentAmount =  $downPayment->getDownPaymentAmount();
		$isDownPaymentFromMoneyPayment = $downPayment->isInvoiceSettlementWithDownPayment();
		$hasProjectNameColumn = $fullClassName::hasProjectNameColumn();
		$clientName = (new $fullClassName)->getClientNameText();
		return view('contracts-down-payment.settlement_form',[
			'modelType'=>$downPaymentModelName,
			'customerNameText'=>$clientName,
			'hasProjectNameColumn'=>$hasProjectNameColumn,
			'invoices'=>$invoices ,
			'downPayment'=>$downPayment,
			'currencies'=>$currencies,
			'contract'=>$contract,
			'model'=>$downPayment,
			'company'=>$company,
			'jsFile'=>$jsFile,
			'modelType'=>$modelType,
			'customerNameText'=>$customerNameText,
			'customerNameColumnName'=>$clientNameColumnName,
			'customerIdColumnName'=>$clientIdColumnName,
			'partnerId'=>$partnerId ,
			'partnerName'=>$partnerName,
			'downPaymentAmount'=>$downPaymentAmount,
			'isDownPaymentFromMoneyPayment'=>$isDownPaymentFromMoneyPayment

		]);
	}
	public function storeDownPaymentSettlement(StoreDownPaymentSettlementRequest $request,Company $company,int $downPaymentId,int $partnerId,string $modelType)
	{
		/**
		 * @var MoneyReceived $downPayment
		 */
		$fullClassName = 'App\Models\\'.$modelType;
		$downPaymentModelName=$fullClassName::MONEY_MODEL_NAME;
		$downPaymentModelFullName = 'App\Models\\'.$downPaymentModelName ;   
		$downPayment =$downPaymentModelFullName::find($downPaymentId);
		$downPayment->update([
			'down_payment_settlement_date'=>$request->get('settlement_date')
		]);
		$settlements = $downPayment->settlements ; 
		$isFromDownPayment = 0 ;
		if($downPayment->isInvoiceSettlementWithDownPayment()){
			$settlements = $downPayment->settlementsForDownPaymentThatComeFromMoneyModel;
			$isFromDownPayment = 1 ;
		}
		
		$settlements
		->each(function($settlement){
			$settlement->delete();
		});
		$downPayment->storeNewSettlement($request->get('settlements',[]),$downPayment->getPartnerId(),$company->id,$isFromDownPayment);
		return redirect()->route('view.contracts.down.payments',['company'=>$company->id,'partnerId'=>$partnerId,'modelType'=>$modelType,'currency'=>$downPayment->getCurrency()]);
		
	}
}
