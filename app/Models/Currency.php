<?php

namespace App\Models;

use App\Models\Traits\Accessors\CurrencyAccessor;
use App\Models\Traits\Relations\CurrencyRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Currency extends Model
{
    use  CurrencyRelation , CurrencyAccessor;
	
	public static function getOdooId(string $currencyName):int 
	{
		return DB::table('currencies')->where('name',$currencyName)->first()->odoo_id;
	}
}
