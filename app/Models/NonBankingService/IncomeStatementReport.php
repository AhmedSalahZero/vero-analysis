<?php

namespace App\Models\NonBankingService;

use App\Models\Traits\Scopes\BelongsToCompany;
use App\Models\Traits\Scopes\NonBankingServices\BelongsToStudy;
use Illuminate\Database\Eloquent\Model;

class IncomeStatementReport extends Model
{
    
    use BelongsToStudy,BelongsToCompany;
    protected $connection =NON_BANKING_SERVICE_CONNECTION_NAME;
    protected $guarded = ['id'];
    protected $casts = [
                'existing_ecl_expenses'=>'array',
                'existing_interests_expense'=>'array',
                'existing_loans_interests_expense'=>'array',
                'fixed_asset_loan_interest_expenses'=>'array',
        // 'accumulated_retained_earnings'=>'array',
        // 'monthly_net_profit'=>'array',
    ];

}
