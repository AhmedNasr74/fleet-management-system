<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Station;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run()
    {
        $source = Station::whereName('Cairo')->first();
        $destination = Station::whereName('Asyut')->first();
        $bus = Bus::first();
        $trip = Trip::updateOrCreate([
            'trip_name' => $source->name. ' - ' . $destination->name,
            'bus_id' => $bus->id,
            'source_station_id' => $source->id,
            'destination_station_id' => $destination->id,
        ]);
        $trip->stops()->delete();
        $order = 1;
        $trip->stops()->create([
            'order' => $order++,
            'station_id' =>$source->id,
        ]);
        $trip->stops()->create([
            'order' => $order++,
            'station_id' => Station::whereName('AlFayyum')->first()->id,
        ]);
        $trip->stops()->create([
            'order' => $order++,
            'station_id' => Station::whereName('AlMinya')->first()->id,
        ]);
        $trip->stops()->create([
            'order' => $order++,
            'station_id' =>$destination->id,
        ]);
    }
}
