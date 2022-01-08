<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bus extends Model
{
    protected $fillable = [
        'available_seats_number'
    ];


    public function trip(): HasOne
    {
        return $this->hasOne(Trip::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(BusSeat::class);
    }
}
