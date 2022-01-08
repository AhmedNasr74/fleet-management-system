<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripBooking extends Model
{
    use  HasFactory;
    protected $fillable = ['user_id', 'trip_id', 'bus_id', 'seat_id', 'from', 'to'];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'from');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'to');
    }
}
