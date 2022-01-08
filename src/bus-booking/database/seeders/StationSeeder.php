<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    public function run()
    {
        $stations = ['Cairo', 'Giza', 'AlFayyum', 'AlMinya', 'Asyut'];
        foreach ($stations as $station) {
            Station::updateOrCreate(['name' => $station]);
        }
    }
}
