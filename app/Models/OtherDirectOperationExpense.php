<?php

namespace App\Models;

use App\Models\Traits\Accessors\OtherDirectOperationExpenseAccessor;
use App\Models\Traits\Relations\OtherDirectOperationExpenseRelation;
use App\Traits\HasExpense;
use Illuminate\Database\Eloquent\Model;

class OtherDirectOperationExpense extends Model
{
    use   OtherDirectOperationExpenseRelation  , OtherDirectOperationExpenseAccessor,HasExpense;
    
}
