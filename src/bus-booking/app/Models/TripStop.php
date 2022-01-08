<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripStop extends Model
{
    protected $fillable = ['trip_id', 'station_id', 'order'];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class ,'station_id');
    }
}
