<?php

namespace App\Models;

use App\Traits\HasBasicStoreRequest;
use App\Traits\HasCreatedAt;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Partner extends Model
{
	const CUSTOMERS = 'customers';
	const SUPPLIERS = 'suppliers';
	const EMPLOYEES = 'employees';
	const SHAREHOLDERS = 'shareholders';
	const SUBSIDIARY_COMPANIES = 'subsidiary-companies';
	use HasCreatedAt,HasBasicStoreRequest;
    protected $dates = [
    ];
	public function contracts()
	{
		return $this->hasMany(Contract::class,'partner_id','id');
	}

    protected $guarded = [];


    /**
     * The table associated with the model.
     *
     * @var string
     */
	public function getId(){
		return $this->id ;
	}
	public function getName()
	{
		return $this->name ;
	}
	public function getCustomerName()
	{
		return $this->getName();
	}
	public function scopeOnlyCompany(Builder $query,$companyId){
		return $query->where('company_id',$companyId);
	}
	public function scopeOnlyThatHaveContracts(Builder $query){
		return $query->has('contracts');
	}
	public function scopeOnlyHasInvoicesWithCurrency(Builder $query,string $currencyName){
		return $query->whereHas('SupplierInvoice',function(Builder $builder) use ($currencyName){
			$builder->where('currency',$currencyName);
		});
	}
	public function scopeOnlyForCompany(Builder $query,$companyId){
		return $query->where('company_id',$companyId);
	}
	public function scopeOnlyCustomers(Builder $query){
		return $query->where(function($q){
			$q->where('is_customer',1);
		});
	}
	public function scopeOnlySuppliers(Builder $query){
		return $query->where(function($q){
			$q->where('is_supplier',1);
		});
	}
	public function scopeOnlyEmployees(Builder $query){
		return $query->where(function($q){
			$q->where('is_employee',1);
		});
	}
	public function scopeOnlyShareholders(Builder $query){
		return $query->where(function($q){
			$q->where('is_shareholders',1);
		});
	}
	public function scopeOnlySubsidiaryCompanies(Builder $query){
		return $query->where(function($q){
			$q->where('is_subsidiary_company',1);
		});
	}
	public function unappliedAmounts()
	{
		return $this->hasMany(UnappliedAmount::class ,'partner_id','id');	
	}
	public function isCustomer()
	{
		return $this->is_customer == 1 ;
	}
	
	public function isSupplier()
	{
		return $this->is_supplier == 1 ;
	}
	public function isEmployee()
	{
		return $this->is_employee == 1 ;
	}
	public function isSubsidiaryCompany()
	{
		return $this->is_subsidiary_company == 1 ;
	}
	public function isShareholder()
	{
		return $this->is_shareholder == 1 ;
	}
	
	public function settlementForUnappliedAmounts()
	{
		if($this->isCustomer()){
			return $this->hasMany(Settlement::class,'customer_name','name')->whereNotNull('unapplied_amount_id');
		}
		if($this->isSupplier()){
			return $this->hasMany(PaymentSettlement::class,'supplier_name','name')->whereNotNull('unapplied_amount_id');
		}
	}
	public function getSettlementForUnappliedAmounts(string $startDate , string $endDate)
	{
		return $this->settlementForUnappliedAmounts()
		->whereHas('unappliedAmount',function(Builder $q) use ($startDate,$endDate){
			$q->where('settlement_date','>=',$startDate)->where('settlement_date','<=',$endDate);
		})
		->get();
	}
	public function CustomerInvoice()
	{
		return $this->hasMany(CustomerInvoice::class,'customer_id','id');
	}
	public function SupplierInvoice()
	{
		return $this->hasMany(SupplierInvoice::class,'supplier_id','id');
	}
	
	public function updateNamesInAllTables(string $columnName , string $oldPartnerName,string $newPartnerName, int $companyId )
	{
		// $columnName = 'customer_name' , 'supplier_name';
		$tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

		foreach($tables as $tableName){
			if(Schema::hasColumn($tableName,$columnName)){
				if($tableName == 'sales_gathering'){
					continue;
				}
				DB::table($tableName)->where('company_id',$companyId)
				->where($columnName,$oldPartnerName)
				->update([$columnName=>$newPartnerName])
				;
			}
		}
	}
	public static function getPartnerFromName(string $name , int $companyId):?self
	{
		return self::where('name',$name)->where('company_id',$companyId)->first();
	}
}
