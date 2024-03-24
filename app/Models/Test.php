<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Test extends Model
{
    protected $guarded = ['id'];
	public $timestamps = false ;
	protected static function booted(): void
    {
        static::updated(function (Test $test) {
            DB::table('tests')->where('id','>',$test->id)->update([
				'updated_at'=>now()
			]);
        });
		
		static::deleted(function (Test $test) {
            DB::table('tests')->where('id','>',$test->id)->update([
				'updated_at'=>now()
			]);
        });
		
    }
	
}
