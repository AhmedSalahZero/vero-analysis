<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CurrentAccountBankStatement extends Model
{
    protected $guarded = [
        'id'
    ];

    protected static function booted(): void
    {
        // دي علشان نشغل التريجرز
        // mysql
        // علشان تروح تحدث كل الروز اللي تحتها
        static::updated(function (CurrentAccountBankStatement $model) {
            DB::table('current_account_bank_statements')->where('id', '>=', $model->id)->orderBy('id')->where('company_id', $model->company_id)->update([
                'updated_at' => now()
            ]);
        });

        static::deleting(function (CurrentAccountBankStatement $model) {
            $model->debit = 0;
            $model->credit = 0;
            $model->save();
        });
    }

    public function moneyReceived()
    {
        return $this->belongsTo(MoneyReceived::class, 'money_received_id', 'id');
    }
	public function moneyPayment()
    {
        return $this->belongsTo(MoneyPayment::class, 'money_payment_id', 'id');
    }
    public function getId()
    {
        return $this->id ;
    }
	
	public function getEndBalance()
	{
		return $this->end_balance ?: 0 ;
	}
	public function getEndBalanceFormatted()
	{
		return number_format($this->getEndBalance()) ;
	}

    public function setDateAttribute($value)
    {
        $date = explode('/', $value);
        if (count($date) != 3) {
            $this->attributes['date'] = $value ;

            return ;
        }
        $month = $date[0];
        $day = $date[1];
        $year = $date[2];

        $this->attributes['date'] = $year . '-' . $month . '-' . $day;
    }
	public function financialInstitutionAccount()
	{
		return $this->belongsTo(CurrentAccountBankStatement::class,'financial_institution_account_id','id');
	}
}
