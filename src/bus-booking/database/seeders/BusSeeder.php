<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    public function run()
    {
        $bus = Bus::updateOrCreate(['id' => 1]);
        for ($i = 1; $i <= 12; $i++) {
            $bus->seats()->updateOrCreate([
                'uuid' => 'BU-' . $bus->id . '-ST-' . $i
            ]);
        }
    }
}
