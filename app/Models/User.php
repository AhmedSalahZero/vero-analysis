<?php

namespace App\Models;

use App\Traits\StaticBoot;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Notifiable,HasRoles,InteractsWithMedia,
    // SoftDeletes,
    StaticBoot;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'companies_users');
    }
    public function canViewIncomeStatement()
    {
        return in_array($this->email , [
            'mahmoud.youssef@squadbcc.com',
            'samer.tawfik@squadbcc.com',
            'admin@admin.com'
        ]);
    }


}

