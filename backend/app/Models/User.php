<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $fillable = [
        'name', 
        'email',
        'password',
        'cpf',
        'image',
        'phone',
        
    ];

    protected $hidden = [
        'password',
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
