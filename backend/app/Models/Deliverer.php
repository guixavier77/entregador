<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Deliverer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'cpf',
        'name',
        'email',
        'image',
        'cnh_image',
        'phone',
        'password'
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function vehicles()
    {
        return $this->hasOne(Vehicle::class);
    }
}
