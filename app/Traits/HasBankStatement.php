<?php
namespace App\Traits;

use App\Models\FinancialInstitutionAccount;
use Carbon\Carbon;


trait HasBankStatement
{
	public function updateBankStatementsFromDate(string $date)
	{
		$isFinancialInstitutionAccount  = new self instanceof FinancialInstitutionAccount ; 
		$orderBy = $isFinancialInstitutionAccount ? 'date asc , id asc' : 'date asc , priority asc , id asc';
		$firstBankStatementToBeUpdated = (self::getBankStatementTableClassName())::where(self::generateForeignKeyFormModelName(),$this->id)
		
		->where('date','>=',$date)
		->orderByRaw($orderBy)
		->first();	
		
		if($firstBankStatementToBeUpdated){
			$firstBankStatementToBeUpdated->update([
				'updated_at'=>now()
			]);
		}
	}
	
	public function handleEndOfMonthInterest(string $contractStartDate , string $contractEndDate , int $companyId)
	{
		$isFinancialInstitutionAccount  = new self instanceof FinancialInstitutionAccount ; 
		$foreignKeyColumnName = self::generateForeignKeyFormModelName(); // clean_overdraft_id for clean_overdrafts for example
		$fullBankStatement = self::getBankStatementTableClassName();
		
		$contractStartDateAsCarbon = Carbon::make($contractStartDate);
		$contractEndDateAsCarbon= Carbon::make($contractEndDate);
		
		$dates = generateDatesBetweenTwoDates($contractStartDateAsCarbon,$contractEndDateAsCarbon) ;
		$countDates = count($dates);
		// highest_debit_balance
		$interestText = 'interest';
		$interestTypeText = 'end_of_month';
		$fullBankStatement::where('company_id',$companyId)->where('type',$interestText)->where($foreignKeyColumnName,$this->id)->where('interest_type',$interestTypeText)->where('date','>',$contractEndDate)->delete();
		foreach($dates as $index => $dateAsString){
			$isLastLoop = $index == $countDates -1;
			$currentEndOfMonthDate = $isLastLoop ? Carbon::make($contractEndDate)->format('Y-m-d') : Carbon::make($dateAsString)->endOfMonth()->format('Y-m-d');
			$isExist = $fullBankStatement::where('company_id',$companyId)->where($foreignKeyColumnName,$this->id)->where('type',$interestText)->where('interest_type',$interestTypeText)->where('date',$currentEndOfMonthDate)->first();
			if(!$isExist){
				$data = [
				'company_id'=>$companyId,
				$foreignKeyColumnName=>$this->id ,
				'priority'=>1 ,
				'type'=>$interestText,
				'date'=>$currentEndOfMonthDate,
				'limit'=>$this->limit ,
				'credit'=>0 ,
				'interest_type'=>'end_of_month',
				'comment_en'=>__('End Of Month Interest'),
				'comment_ar'=>__('End Of Month Interest'),
			] ; 
			if($isFinancialInstitutionAccount){
				unset($data['priority']);
			}
			 $fullBankStatement::create($data);
			}
			
		}
	}
	
}
