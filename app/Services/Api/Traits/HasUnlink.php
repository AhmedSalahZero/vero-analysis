<?php 
namespace App\Services\Api\Traits;


trait HasUnlink 
{
	public function unlink(string $modelName,int $id) 
	{
		$this->models->execute_kw(
				$this->db,
				$this->uid,
				$this->password,
				$modelName,
				'unlink',
				[[$id]]
			);
	}
	
	
	
}
