<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait IsBankStatement
{
	public function handleFullDateAfterDateEdit(string $date,$debit,$credit)
	{ 
			$date = Carbon::make($date)->format('Y-m-d');
			$modelName = get_class($this);
			$currentFullDate =$this->full_date ; 
			$time  = Carbon::make($currentFullDate)->format('H:i:s');
			$newFullDateTime = date('Y-m-d H:i:s', strtotime("$date $time")) ;
			$minDateTime = min($currentFullDate ,$newFullDateTime );
			DB::table($this->getTable())->where('id',$this->id)->update([
				'date'=>$date,
				'full_date'=>$newFullDateTime ,
				'credit'=>$credit , 
				'debit'=>$debit 
			]);
			$query = 
			$modelName::where('full_date','>=',$minDateTime);
			foreach($this->getForeignKeyNamesThatUsedInFilter() as $columnName){
				$query->where($columnName,$this->{$columnName});
			}
			$query->orderByRaw('full_date asc, id asc')
			->first()
			->update([
				'updated_at'=>now()
			]);
	}
}
