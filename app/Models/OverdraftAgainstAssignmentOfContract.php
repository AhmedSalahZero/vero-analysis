<?php

namespace App\Models;

use App\Interfaces\Models\Interfaces\IHaveStatement;
use App\Traits\HasLastStatementAmount;
use App\Traits\HasOutstandingBreakdown;
use App\Traits\IsOverdraft;
use App\Traits\Models\HasAccumulatedLimit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class OverdraftAgainstAssignmentOfContract extends Model implements IHaveStatement
{
    protected $guarded = ['id'];
	
	use HasOutstandingBreakdown , IsOverdraft , HasAccumulatedLimit,HasLastStatementAmount;
	public static function boot()
	{
		parent::boot();
		static::updated(function(OverdraftAgainstAssignmentOfContract $overdraftAgainstAssignmentOfContract){
			$overdraftAgainstAssignmentOfContract->triggerChangeOnContracts();
		});
		static::deleted(function(OverdraftAgainstAssignmentOfContract $overdraftAgainstAssignmentOfContract){
			$overdraftAgainstAssignmentOfContract->overdraftAgainstAssignmentOfContractBankStatements->each(function($overdraftAgainstAssignmentOfContractBankStatement){
				$overdraftAgainstAssignmentOfContractBankStatement->delete();
			});
			$overdraftAgainstAssignmentOfContract->overdraftAgainstAssignmentOfContractBankLimits->each(function($overdraftAgainstAssignmentOfContractBankLimit){
				$overdraftAgainstAssignmentOfContractBankLimit->delete();
			});
		});
	}
	public function overdraftAgainstAssignmentOfContractBankLimits()
	{
		return $this->hasMany(OverdraftAgainstAssignmentOfContractLimit::class,'overdraft_against_assignment_of_contract_id','id');
	}
	public function overdraftAgainstAssignmentOfContractBankStatements()
	{
		return $this->hasMany(OverdraftAgainstAssignmentOfContractBankStatement::class,'overdraft_against_assignment_of_contract_id','id');
	}
	public function bankStatements()
	{
		return $this->hasMany(OverdraftAgainstAssignmentOfContractBankStatement::class , 'overdraft_against_assignment_of_contract_id','id');
	}	
	public function lendingInformation():HasMany
	{
		return $this->hasMany(LendingInformationAgainstAssignmentOfContract::class , 'overdraft_against_assignment_of_contract_id','id');
	}
	public static function generateForeignKeyFormModelName():string 
	{
		return 'overdraft_against_assignment_of_contract_id';
	}	
	public static function getBankStatementTableName():string 
	{
		return 'overdraft_against_assignment_of_contract_bank_statements';
	}
	public static function getWithdrawalTableName():string 
	{
		return 'overdraft_against_assignment_of_contract_withdrawals';
	}
	public static function getBankStatementIdName():string 
	{
		return 'overdraft_against_assignment_of_contract_bank_statement_id';
	}
	public static function getTableNameFormatted()
	{
		return __('Overdraft Against Assignment Of Contract');
	}
	public static function getStatementTableName():string
	 {
		return 'overdraft_against_assignment_of_contract_bank_statements';	
	}
	public static function getForeignKeyInStatementTable()
	{
		 return 'overdraft_against_assignment_of_contract_id';
	}
	public function contracts():HasMany
	{
		return $this->hasMany(Contract::class , 'overdraft_against_assignment_of_contract_id','id');
	}
	
	
	public function triggerChangeOnContracts()
	{
		
		$this->contracts->each(function(Contract $contract){
			$contract->update([
				'updated_at'=>now()
			]);
		
	});
	}
	public static function getAllAccountNumberForCurrency($companyId , $currencyName,$financialInstitutionId):array
	{
		$accounts = [];
		$overdraftAgainstAssignmentOfContracts = self::where('company_id',$companyId)->where('currency',$currencyName)
		->where('financial_institution_id',$financialInstitutionId)->get();
		foreach($overdraftAgainstAssignmentOfContracts as $overdraftAgainstAssignmentOfContract){
			$limitStatement = $overdraftAgainstAssignmentOfContract->overdraftAgainstAssignmentOfContractBankLimits->sortByDesc('full_date')->first() ;
			if(($limitStatement && $limitStatement->accumulated_limit >0) || in_array('bank-statement',Request()->segments())){
				$accounts[$overdraftAgainstAssignmentOfContract->account_number] = $overdraftAgainstAssignmentOfContract->account_number;
			}
		}
		
		return  $accounts ;
	}	
	public function getType()
	{
		return __('Overdraft Against Contract Assignment');
	}	
	public function getCurrencyFormatted()
	{
		return Str::upper($this->getCurrency());
	}

}
