<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    protected $fillable = ['trip_name' , 'bus_id', 'source_station_id', 'destination_station_id'];

    public function source_station(): BelongsTo
    {
        return $this->belongsTo(Station::class, __FUNCTION__ . '_id');
    }

    public function destination_station(): BelongsTo
    {
        return $this->belongsTo(Station::class, __FUNCTION__ . '_id');
    }

    public function stops(): HasMany
    {
        return $this->hasMany(TripStop::class);
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(TripBooking::class);
    }

}
