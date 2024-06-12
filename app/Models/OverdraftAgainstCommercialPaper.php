<?php

namespace App\Models;

use App\Interfaces\Models\Interfaces\IHaveStatement;
use App\Traits\HasOutstandingBreakdown;
use App\Traits\IsOverdraft;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
	
}
