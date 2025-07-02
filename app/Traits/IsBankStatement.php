<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Schema;

trait IsBankStatement
{
	public function handleFullDateAfterDateEdit(string $date,$debit,$credit)
	{ 
			$date = Carbon::make($date)->format('Y-m-d');
			$modelName = get_class($this);
			$orderBy = Schema::hasColumn($this->getTable(),'priority') ? 'date asc , priority asc, id asc' : 'date asc, id asc';
			$currentFullDate =$this->full_date ;
			$currentDate =$this->date ;
			
			$time  = Carbon::make($currentFullDate)->format('H:i:s');
			$newFullDateTime = date('Y-m-d H:i:s', strtotime("$date $time")) ;
			// $minDateTime = min($currentFullDate ,$newFullDateTime );
			$minDate = min($currentDate , $date);
			DB::table($this->getTable())->where('id',$this->id)->update([
				'date'=>$date,
				'full_date'=>$newFullDateTime ,
				'credit'=>$credit , 
				'debit'=>$debit 
			]);
			$query = 
			$modelName::where('date','>=',$minDate);
			foreach($this->getForeignKeyNamesThatUsedInFilter() as $columnName){
				$query->where($columnName,$this->{$columnName});
			}
			$query->orderByRaw($orderBy)
			->first()
			->update([
				'updated_at'=>now()
			]);
			
	}
}
