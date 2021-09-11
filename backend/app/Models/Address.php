<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'street',
        'neighborhood',
        'number',
        'city',	
        'state',
        'user_id',
        'deliverer_id'

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliverer()
    {
        return $this->belongsTo(Deliverer::class);
    }
}
