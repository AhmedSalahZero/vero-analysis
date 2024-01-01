<?php

namespace App\Models\Traits\Relations;

use App\Models\HospitalitySector;

trait SalesChannelRelation
{
	public function hospitalitySector()
	{
		return $this->belongsTo(HospitalitySector::class, 'hospitality_sector_id');
	}
}
