<?php 
namespace App\Models\Traits\Controllers;

use App\Models\CleanOverdraft;
use App\Models\CleanOverdraftRate;
use App\Models\Company;
use App\Models\FinancialInstitution;
use Illuminate\Http\Request;

trait HasOverdraftRate 
{
	public function applyRate(Request $request , Company $company , FinancialInstitution $financialInstitution ,  $overdraftId )
	{
		$modelFullName = (self::getModelName()); // App\Models\CleanOverdraft for example
		$overdraftModel = $modelFullName::find($overdraftId);
		// dd($overdraftModel);
		$date = $request->get('date_create') ;
		$marginRate = $request->get('margin_rate_create') ;
		$borrowingRate = $request->get('borrowing_rate_create') ;
		$interestRate = $marginRate  + $borrowingRate  ;
		$overdraftModel->rates()->create([
			'date'=>$date,
			'margin_rate'=>$marginRate,
			'borrowing_rate'=>$borrowingRate,
			'interest_rate'=>$interestRate,
			'updated_at'=>now()
		]);
		$overdraftModel->updateBankStatementsFromDate($date);
		return redirect()->back()->with('success',__('Done'));
	
	}
	public function editRate(Request $request , Company $company , FinancialInstitution $financialInstitution ,  $rateId)
	{
		$modelFullName = (self::getModelName()); // App\Models\CleanOverdraft for example
		/**
		 * @var CleanOverdraft $modelFullName
		 */
		$rate = ($modelFullName::rateFullClassName())::find($rateId);
		$date = $request->get('date_edit') ;
		$marginRate = $request->get('margin_rate_edit') ;
		$borrowingRate = $request->get('borrowing_rate_edit') ;
		$interestRate = $marginRate  + $borrowingRate  ;
		$rate->update([
			'date'=>$date,
			'margin_rate'=>$marginRate,
			'borrowing_rate'=>$borrowingRate,
			'interest_rate'=>$interestRate,
			'updated_at'=>now()
		]);
		$rate->overdraftModal->updateBankStatementsFromDate($date);
		return response()->json([
			'status'=>true ,
			'reloadCurrentPage'=>true 
		]);
	}
	
	public function deleteRate(Request $request , Company $company , FinancialInstitution $financialInstitution ,  $rateId)
	{
		$modelFullName = (self::getModelName()); // App\Models\CleanOverdraft for example
		/**
		 * @var CleanOverdraft $modelFullName
		 */
		$rate = ($modelFullName::rateFullClassName())::find($rateId);
		$overdraftModel = $rate->overdraftModal;
		$date = $rate->getDate();
		$rate->delete();
		$overdraftModel->updateBankStatementsFromDate($date);
		return redirect()->back()->with('success',__('Done'));
	}
}
