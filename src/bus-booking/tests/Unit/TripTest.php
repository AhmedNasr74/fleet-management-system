<?php

namespace Tests\Unit;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TripTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Artisan::call('app:install');
        $this->actingAs(User::first(), 'api');
    }

    public function test_list_trips()
    {
        $this->getJson(route('users.trips.index'))
            ->assertJsonCount(Trip::count(), 'data')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'trip_name',
                ]
            ]]);
    }

    public function test_show_trip()
    {
        $trip= Trip::first();
        $this->getJson(route('users.trips.show',$trip->id))
            ->assertSuccessful()
            ->assertJson(['data' => [
                'id' =>$trip->id,
                'trip_name' =>$trip->trip_name,
            ]])
            ->assertJsonStructure(['data' => [
                'id',
                'trip_name',
                'source_station',
                'destination_station',
                'stops',
                'bus',
            ]]);
    }

    public function test_show_not_existing_trip()
    {
        $this->getJson(route('users.trips.show', 404))
            ->assertNotFound();
    }
}
