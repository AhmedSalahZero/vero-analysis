<?php
namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\ForeignExchangeRate;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ForeignExchangeRateController
{
    use GeneralFunctions;
	
	protected function applyFilter(Request $request,Collection $collection,string $filterStartDate = null, string $filterEndDate = null ):Collection{
		if(!count($collection)){
			return $collection;
		}
		$searchFieldName = $request->get('field');
		$dateFieldName =  'issuance_date' ; // change it
		$from = $request->get('from');
		$to = $request->get('to');
		$value = $request->query('value');
		$collection = $collection
		->when($request->has('value'),function($collection) use ($request,$value,$searchFieldName){
			return $collection->filter(function($letterOfCreditIssuance) use ($value,$searchFieldName){
				$currentValue = $letterOfCreditIssuance->{$searchFieldName} ;
				return false !== stristr($currentValue , $value);
			});
		})
		->when($request->get('from') , function($collection) use($dateFieldName,$from){
			return $collection->where($dateFieldName,'>=',$from);
		})
		->when($request->get('to') , function($collection) use($dateFieldName,$to){
			return $collection->where($dateFieldName,'<=',$to);
		})
		->when($filterStartDate , function($collection) use ($filterStartDate,$filterEndDate){
			return $collection->filterByIssuanceDate($filterStartDate,$filterEndDate);
		})
		->sortByDesc('id');

		return $collection;
	}
	
	public function index(Company $company,Request $request , $returnIndexArray = false )
	{
		$numberOfMonthsBetweenEndDateAndStartDate = 18 ;
		$mainFunctionalCurrency = $company->getMainFunctionalCurrency() ;
		$activeType = $request->get('active',$mainFunctionalCurrency) ;
		$filterDates = [];
		$searchFields = [];
		$models = [];
		$existingCurrencies =ForeignExchangeRate::where('company_id',$company->id)->pluck('from_currency','from_currency')->toArray();
		
		foreach($existingCurrencies as $currentCurrency){
			$startDate = $request->has('startDate') ? $request->input('startDate.'.$currentCurrency) : now()->subMonths($numberOfMonthsBetweenEndDateAndStartDate)->format('Y-m-d');
			$endDate = $request->has('endDate') ? $request->input('endDate.'.$currentCurrency) : now()->format('Y-m-d');
			$filterDates[$currentCurrency] = [
				'startDate'=>$startDate,
				'endDate'=>$endDate
			];
			$models[$currentCurrency]   = ForeignExchangeRate::where('company_id',$company->id)->where('from_currency',$currentCurrency)->orderByRaw('date desc')->get(); ;

			if($currentCurrency == $activeType ){
				$models[$currentCurrency]   = $this->applyFilter($request,$models[$currentCurrency],$filterDates[$currentCurrency]['startDate'] , $filterDates[$currentCurrency]['endDate']) ;
			}
			$searchFields[$currentCurrency] =  [
				'from_currency'=>__('From Currency'),
				'to_currency'=>__('To Currency'),
				'date'=>__('Date')
			];

		}

		$viewDataArray = [
			'company'=>$company,
			'mainFunctionalCurrency'=>$mainFunctionalCurrency,
			'existingCurrencies'=>$existingCurrencies,
			'searchFields'=>$searchFields,
			'models'=>$models,
			'filterDates'=>$filterDates,
			'currentActiveTab'=>$activeType,
		] ;
		if($returnIndexArray){
			return $viewDataArray;
		}
        return view('admin.foreign-exchange-rate.foreign-exchange-rate',$viewDataArray );
    }
	public function store(Request $request, Company $company){
		$data = [
			'company_id'=>$company->id ,
			'exchange_rate'=>$request->get('exchange_rate'),
			'date'=>$request->get('date'),
			'from_currency'=>$request->get('from_currency'),
			'to_currency'=>$request->get('to_currency'),
		] ;
		
		
		ForeignExchangeRate::create($data);
		
		
		
		return redirect()->route('view.foreign.exchange.rate',['company'=>$company->id,'active'=>$request->get('from_currency')]);
	}
	public function edit(Request $request , Company $company ,  $foreignExchangeRateId ){
		$indexViewData = $this->index($company,$request,true);
		$foreignExchangeRate = ForeignExchangeRate::find($foreignExchangeRateId);
        return view('admin.foreign-exchange-rate.foreign-exchange-rate', array_merge($indexViewData,[
			'company'=>$company,
			'foreignExchangeRates'=>ForeignExchangeRate::where('company_id',$company->id)->get(),
			'model'=>$foreignExchangeRate,
			'currentActiveTab'=>$foreignExchangeRate->getFromCurrency()
		]));
	}
	public function update(Request $request , Company $company ,  $foreignExchangeRateId ){
		$date = $request->get('date') ;
		$foreignExchangeRate = ForeignExchangeRate::find($foreignExchangeRateId);
		$data = [
			'exchange_rate'=>$request->get('exchange_rate'),
			'date'=>$request->get('date'),
			'from_currency'=>$request->get('from_currency'),
			'to_currency'=>$request->get('to_currency'),
		] ;
		$foreignExchangeRate->update($data);
		
		return redirect()->route('view.foreign.exchange.rate',['company'=>$company->id,'active'=>$request->get('from_currency')]);
		
	}
	public function destroy(Request $request , Company $company ,  $foreignExchangeRateId )
	{
		$foreignExchangeRate = ForeignExchangeRate::find($foreignExchangeRateId); 
		$foreignExchangeRate->delete();
		
			/**
			 * * لو معدش فاضل غيرها دا معناه انه حذف تاني عنصر وبالتالي العنصر الاول اللي معتش فاضل غيره هو الديو ديت الاصلي ففي الحاله
			 * * دي هنحذفه معتش ليه لزمة
			 */
			// if(ForeignExchangeRate::where('company_id',$company->id)->count() == 1){
			// 	ForeignExchangeRate::where('company_id',$company->id)->delete();
			// }
			return redirect()->route('view.foreign.exchange.rate',['company'=>$company->id]);
	}
	public function getExchangeRate(Request $request  , Company $company)
	{
		$date = Carbon::make($request->get('date'))->format('Y-m-d') ;
		$exchangeRateRow = ForeignExchangeRate::where('company_id',$company->id)
		->where('from_currency',$request->get('fromCurrency'))
		->where('to_currency',$request->get('toCurrency'))
		->where('date','<=',$date)
		->orderByDesc('date')
		->first() ;
		return response()->json([
			'exchange_rate'=>$exchangeRateRow ? $exchangeRateRow->exchange_rate : 1 
		]);
	}
}
