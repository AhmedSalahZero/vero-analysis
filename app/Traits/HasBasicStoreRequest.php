<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait HasBasicStoreRequest
{
	public function storeBasicForm(Request $request , array $except = ['_token','save','_method'] ):self{
		foreach($request->except($except) as $name => $value){
			$columnExist = Schema::hasColumn($this->getTable(),$name);
			if(is_object($value)){
				static::addMediaFromRequest($name)->toMediaCollection($name);
			}
			elseif(!is_array($value)&& (Str::startsWith($value,'is_') || Str::startsWith($value,'can_')|| Str::startsWith($value,'has_')) ){
				if($columnExist){
					$this->{$name} = $request->boolean($name);
				}
			}
			elseif($columnExist ){
				$this->{$name} = $request->get($name);
			}
		}
		$this->save();
		// store relations

		foreach($request->except($except) as $name => $value){
			// in store case
			if(is_array($request->get($name)) && method_exists($this,$name) && ! $this->id ){
				// is relationship
				foreach($request->get($name) as $index => $values){
					if(key_exists('company_id',$values)){
						$values['company_id'] = $request->get('company_id');
					}
					$this->$name()->create($values);
				}
			}
			// in update case
			elseif(is_array($request->get($name)) && method_exists($this,$name) && $this->id ){
				// is relationship
				$this->updateRepeaterRelation($name,$this->$name()->getRelated()->getTable(),[
					'company_id'=>getCurrentCompanyId()
				]);
			}

		}

		return $this ;
	}
	public function updateRepeaterRelation(string $relationName,string $relationTableName , array $additionRelationData = [])
	{
        /**
         * * 	// for example
		 * * $relationName ='SalesOrder'
         * * وخلي اسم الريليشن هو نفسه الاسم اللي جي في الريكويست علشان هو اللي هيكون مبني عليه كل حاجه ;
         * * * $relationTableName = 'sales_orders';
         * * $additionRelationData لو حابب تضيف داتا اضافيه وليكن مثلا company_id
		 */

        $relationDataArray = Request()->get($relationName);
		$oldIdsFromDatabase = $this->{$relationName}->pluck('id')->toArray();
		$idsFromRequest =array_column($relationDataArray,'id') ;
		$elementsToDelete = array_diff($oldIdsFromDatabase,$idsFromRequest);
		$elementsToUpdate = array_intersect($idsFromRequest,$oldIdsFromDatabase);
		$this->$relationName()->whereIn($relationTableName.'.id',$elementsToDelete)->delete();
		foreach($elementsToUpdate as $id){
			$dataToUpdate = findByKey($relationDataArray,'id',$id);
			$this->$relationName()->where($relationTableName.'.id',$id)->first()->update($dataToUpdate);
		}
		foreach($relationDataArray as $data){
			if(!isset($data['id'])){
				unset($data['id']);
				$this->$relationName()->create($this->filterTableColumnThatExistsOnly($relationTableName,array_merge($data,$additionRelationData)));
			}
		}
	}
	/**
	 * * دي هنفلتر بيها الكولومز اللي موجوده بس هنرجعها الباقي هنشيله
	 */
	protected function filterTableColumnThatExistsOnly(string $relationTableName, array $items)
	{
		$newItems = [];
		foreach($items as $key => $value){
			if(Schema::hasColumn($relationTableName,$key)){
				$newItems[$key] = $value ;
			}
		}
		return $newItems;
	}
}
