<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliverer()
    {
        return $this->belongsTo(Deliverer::class);
    }

    public function signature()
    {
        return $this->hasOne(Signature::class);
    }
}
