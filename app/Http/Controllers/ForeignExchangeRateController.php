<?php
namespace App\Http\Controllers;
use App\Interfaces\Models\IInvoice;
use App\Models\Company;
use App\Models\ForeignExchangeRate;
use App\Traits\GeneralFunctions;
use Illuminate\Http\Request;

class ForeignExchangeRateController
{
    use GeneralFunctions;
	public function index(Company $company,Request $request)
	{
		/**
		 * @var IInvoice $invoice ;
		 */
		
		$foreignExchangeRates = ForeignExchangeRate::where('company_id',$company->id)->orderByRaw('date desc')->get();
        return view('admin.foreign-exchange-rate', [
			'company'=>$company,
			'foreignExchangeRates'=>$foreignExchangeRates,
		]);
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
		
		
		
		return redirect()->route('view.foreign.exchange.rate',['company'=>$company->id]);
	}
	public function edit(Request $request , Company $company ,  $foreignExchangeRateId ){
		$foreignExchangeRate = ForeignExchangeRate::find($foreignExchangeRateId);
        return view('admin.foreign-exchange-rate', [
			'company'=>$company,
			'foreignExchangeRates'=>ForeignExchangeRate::where('company_id',$company->id)->get(),
			'model'=>$foreignExchangeRate,
		]);
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
		
		return redirect()->route('view.foreign.exchange.rate',['company'=>$company->id]);
		
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
	
}
