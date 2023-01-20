<?php

namespace App\Models\Traits\Relations;

use App\Models\BalanceSheet;
use App\Models\SharingLink;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BalanceSheetItemRelation
{
	//    use CommonRelations  ;
	use FinancialStatementAbleItemRelation;
}
