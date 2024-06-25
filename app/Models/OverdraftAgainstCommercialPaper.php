<?php

namespace App\Models;

use App\Interfaces\Models\Interfaces\IHaveStatement;
use App\Traits\HasOutstandingBreakdown;
use App\Traits\IsOverdraft;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class OverdraftAgainstCommercialPaper extends Model implements IHaveStatement
{
    protected $guarded = ['id'];
	
	use HasOutstandingBreakdown , IsOverdraft;
	
	public function overdraftAgainstCommercialPaperBankStatements()
	{
		return $this->hasMany(OverdraftAgainstCommercialPaperBankStatement::class,'overdraft_against_commercial_paper_id','id');
	}
	public function bankStatements()
	{
		return $this->hasMany(OverdraftAgainstCommercialPaperBankStatement::class , 'overdraft_against_commercial_paper_id','id');
	}	
	public function lendingInformation():HasMany
	{
		return $this->hasMany(LendingInformation::class , 'overdraft_against_commercial_paper_id','id');
	}
	public static function generateForeignKeyFormModelName():string 
	{
		return 'overdraft_against_commercial_paper_id';
	}	
	public static function getBankStatementTableName():string 
	{
		return 'overdraft_against_commercial_paper_bank_statements';
	}
	public static function getWithdrawalTableName():string 
	{
		return 'overdraft_against_commercial_paper_withdrawals';
	}
	public static function getBankStatementIdName():string 
	{
		return 'overdraft_against_commercial_paper_bank_statement_id';
	}
	public static function getTableNameFormatted()
	{
		return __('Overdraft Against Commercial Paper');
	}
	public static function getStatementTableName():string
	 {
		return 'overdraft_against_commercial_paper_bank_statements';	
	}
	public static function getForeignKeyInStatementTable()
	{
		 return 'overdraft_against_commercial_paper_id';
	}
	
	
public static function getCommonQueryForCashDashboard(Company $company , string $currencyName , string $date )
{
	return DB::table('overdraft_against_commercial_papers')
		->where('currency', '=', $currencyName)
		->where('company_id', $company->id)
		->where('contract_start_date', '<=', $date)
		->orderBy('overdraft_against_commercial_papers.id');
}
public static function hasAnyRecord(Company $company,string $currency)
{
	return DB::table('overdraft_against_commercial_papers')->where('company_id',$company->id)->where('currency',$currency)->exists();
}
public static function getCashDashboardDataForFinancialInstitution(array &$totalRoomForEachOverdraftAgainstCommercialPaperId,Company $company , array $overdraftAgainstCommercialPaperIds , string $currencyName , string $date , int $financialInstitutionBankId , &$totalOverdraftAgainstCommercialPaperRoom  ):array 
{
		
			foreach($overdraftAgainstCommercialPaperIds as $overdraftAgainstCommercialPaperId){
				$overdraftAgainstCommercialPaperStatement = DB::table('overdraft_against_commercial_paper_bank_statements')
					->where('overdraft_against_commercial_paper_bank_statements.company_id', $company->id)
					->where('date', '<=', $date)
					->join('overdraft_against_commercial_papers', 'overdraft_against_commercial_paper_bank_statements.overdraft_against_commercial_paper_id', '=', 'overdraft_against_commercial_papers.id')
					->where('overdraft_against_commercial_papers.currency', '=', $currencyName)
					->where('overdraft_against_commercial_paper_id',$overdraftAgainstCommercialPaperId)
					->where('financial_institution_id',$financialInstitutionBankId)
					->orderByRaw('full_date desc , overdraft_against_commercial_paper_bank_statements.id desc')
					->first();
					
					$overdraftAgainstCommercialPaperRoom = $overdraftAgainstCommercialPaperStatement ? $overdraftAgainstCommercialPaperStatement->room : 0 ;
					$totalOverdraftAgainstCommercialPaperRoom += $overdraftAgainstCommercialPaperRoom ;
					$overdraftAgainstCommercialPaper = OverdraftAgainstCommercialPaper::find($overdraftAgainstCommercialPaperId);
					$financialInstitution = FinancialInstitution::find($financialInstitutionBankId);
					$financialInstitutionName = $financialInstitution->getName();
					if($overdraftAgainstCommercialPaper->financial_institution_id ==$financialInstitution->id ){
						$totalRoomForEachOverdraftAgainstCommercialPaperId[$currencyName][]  = [
							'item'=>$financialInstitutionName ,
							'available_room'=>$overdraftAgainstCommercialPaperRoom,
							'limit'=>$overdraftAgainstCommercialPaperStatement  ? $overdraftAgainstCommercialPaperStatement->limit : 0 ,
							'end_balance'=>$overdraftAgainstCommercialPaperStatement ?  $overdraftAgainstCommercialPaperStatement->end_balance : 0 
						] ;
					}
			}
			
			return $totalRoomForEachOverdraftAgainstCommercialPaperId ;
			
}

public static function getCashDashboardDataForYear(array &$overdraftAgainstCommercialPaperCardData,Builder $overdraftAgainstCommercialPaperCardCommonQuery , Company $company , array $overdraftAgainstCommercialPaperIds , string $currencyName , string $date , int $year ):array 
{
			$outstanding = 0 ;
			$room = 0 ;
			$interestAmount = 0 ;
			foreach($overdraftAgainstCommercialPaperIds as $overdraftAgainstCommercialPaperId){
					$totalRoomForOverdraftAgainstCommercialPaperId = DB::table('overdraft_against_commercial_paper_bank_statements')
					->where('overdraft_against_commercial_paper_bank_statements.company_id', $company->id)
					->where('date', '<=', $date)
					->join('overdraft_against_commercial_papers', 'overdraft_against_commercial_paper_bank_statements.overdraft_against_commercial_paper_id', '=', 'overdraft_against_commercial_papers.id')
					->where('overdraft_against_commercial_papers.currency', '=', $currencyName)
					->where('overdraft_against_commercial_paper_id',$overdraftAgainstCommercialPaperId)
					->orderByRaw('date desc , overdraft_against_commercial_paper_bank_statements.id desc')
					->first();
					$outstanding = $totalRoomForOverdraftAgainstCommercialPaperId ? $outstanding + $totalRoomForOverdraftAgainstCommercialPaperId->end_balance : $outstanding ;
					$room = $totalRoomForOverdraftAgainstCommercialPaperId ? $room + $totalRoomForOverdraftAgainstCommercialPaperId->room : $room ;
					$interestAmount = $interestAmount +  DB::table('overdraft_against_commercial_paper_bank_statements')
					->where('overdraft_against_commercial_paper_bank_statements.company_id', $company->id)
					->whereRaw('year(date) = '.$year)
					->join('overdraft_against_commercial_papers', 'overdraft_against_commercial_paper_bank_statements.overdraft_against_commercial_paper_id', '=', 'overdraft_against_commercial_papers.id')
					->where('overdraft_against_commercial_papers.currency', '=', $currencyName)
					->where('overdraft_against_commercial_paper_id',$overdraftAgainstCommercialPaperId)
					->orderByRaw('date desc , overdraft_against_commercial_paper_bank_statements.id desc')
					->sum('interest_amount');
			}
			$overdraftAgainstCommercialPaperCardData[$currencyName] = [
				'limit' =>  $overdraftAgainstCommercialPaperCardCommonQuery->sum('limit'),
				'outstanding' => $outstanding,
				'room' => $room ,
				'interest_amount'=>$interestAmount
			];
			return $overdraftAgainstCommercialPaperCardData;
}

}
