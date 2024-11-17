<?php

namespace App\Models;

use App\Traits\HasBasicStoreRequest;
use App\Traits\HasCreatedAt;
use Illuminate\Database\Eloquent\Builder;
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
	const OTHER_PARTNERS = 'other-partners';
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
	public function scopeOnlyCustomersOrOtherPartners(Builder $query){
		return $query->where(function($q){
			$q->where('is_customer',1)->orWhere('is_other_partner',1);
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
	public function scopeOnlyOtherPartners(Builder $query){
		return $query->where(function($q){
			$q->where('is_other_partner',1);
		});
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
	public function isOtherPartner()
	{
		return $this->is_other_partner == 1 ;
	}
	public function CustomerInvoice()
	{
		return $this->hasMany(CustomerInvoice::class,'customer_id','id');
	}
	public function SupplierInvoice()
	{
		return $this->hasMany(SupplierInvoice::class,'supplier_id','id');
	}
	public function updateNamesInAllTables(array $columnNames , string $oldPartnerName,string $newPartnerName, int $companyId , array $additionalWhere = [])
	{
		$tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
		foreach($tables as $tableName){
			foreach($columnNames as $columnName){
				if(Schema::hasColumn($tableName,$columnName)){
					if($tableName == 'sales_gathering'){
						continue;
					}
					$query = DB::table($tableName)->where('company_id',$companyId)
					->where($columnName,$oldPartnerName);
			
					if($tableName == 'money_received' || $tableName == 'money_payments'){
						
						$query->where($additionalWhere[0] ,$additionalWhere[1]  , $additionalWhere[2] );
					}
					$query->update([$columnName=>$newPartnerName])
					;
				}
			}
			
		}
	}
	public static function getPartnerFromName(string $name , int $companyId):?self
	{
		return self::where('name',$name)->where('company_id',$companyId)->first();
	}
	public function getType()
	{
		foreach($this->toArray() as $columnName => $colValue){
			if(in_array($columnName,array_merge(array_keys(getAllPartnerTypesForSuppliers()),array_keys(getAllPartnerTypesForCustomers()))) && $colValue == 1){
				return $columnName;
			}
		}
		throw new \Exception('Custom Exception .. No Available Partner Type');
	}
	public static function getCustomersForCompany(int $companyId){
		return Partner::where('company_id',$companyId)
		->where('is_customer',1)->orderBy('name')->pluck('name','id');
	} 
	
	public static function getSuppliersForCompany(int $companyId){
		return Partner::where('company_id',$companyId)->where('is_supplier',1)->orderBy('name')->pluck('name','id');
	} 
	
}
