<?php

namespace App\Models;

use App\Models\Traits\Accessors\ServiceNatureAccessor;
use App\Models\Traits\Relations\ServiceNatureRelation;
use Illuminate\Database\Eloquent\Model;

class ServiceNature extends Model
{
    use  ServiceNatureRelation ,ServiceNatureAccessor ;
}
