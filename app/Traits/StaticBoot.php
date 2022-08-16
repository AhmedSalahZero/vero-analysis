<?php
    namespace App\Traits;
    use Illuminate\Support\Facades\Auth;
    // use trait App\Traits\StaticBoot;
trait StaticBoot
{
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {

            $model->updated_by = 1; 
        });

        static::creating(function ($model) {

            $model->created_by = 1;
        });


    }
}
