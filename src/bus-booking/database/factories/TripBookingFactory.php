<?php

namespace Database\Factories;

use App\Models\BusSeat;
use App\Models\Station;
use App\Models\Trip;
use App\Models\TripBooking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripBookingFactory extends Factory
{
    protected $model = TripBooking::class;

    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::first()->id ?? User::factory()->create()->id;
            },
            'trip_id' => function () {
                return Trip::first()->id;
            },
            'bus_id' => Trip::first()->bus_id,
            'seat_id' => BusSeat::inRandomOrder()->first(),
            'from' => function () {
                return Station::first()->id;
            },
            'to' => function () {
                return Station::latest()->first()->id;
            },
        ];
    }
}
