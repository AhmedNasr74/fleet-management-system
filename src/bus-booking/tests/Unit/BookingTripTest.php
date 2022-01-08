<?php

namespace Tests\Unit;

use App\Models\Station;
use App\Models\Trip;
use App\Models\TripBooking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BookingTripTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Artisan::call('app:install');
        $this->actingAs(User::first(), 'api');
    }

    private function insertSomeBookings($seats)
    {
        TripBooking::factory()->create([
            'seat_id' => $seats[0]->uuid ,
            'from' => Station::whereName('Cairo')->first()->id ,
            'to' => Station::whereName('AlFayyum')->first()->id
        ]);
        TripBooking::factory()->create([
            'seat_id' => $seats[1]->uuid ,
            'from' => Station::whereName('Cairo')->first()->id ,
            'to' => Station::whereName('AlMinya')->first()->id
        ]);
        TripBooking::factory()->create([
            'seat_id' => $seats[2]->uuid ,
            'from' => Station::whereName('AlFayyum')->first()->id ,
            'to' => Station::whereName('AlMinya')->first()->id
        ]);
        TripBooking::factory()->create([
            'seat_id' => $seats[3]->uuid ,
            'from' => Station::whereName('AlFayyum')->first()->id ,
            'to' => Station::whereName('Asyut')->first()->id
        ]);
    }

    public function test_show_available_seats_for_the_trip()
    {
        $trip_id = Trip::first()->id;
        $start = Station::whereName('Cairo')->first();
        $end = Station::whereName('Asyut')->first();
        $this->postJson(route('users.trips.show.available.seats'), [
            'trip_id' => $trip_id,
            'start_station_id' => $start->id,
            'end_station_id' => $end->id
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => [
                'available_seats_count', 'seats_numbers'
            ]])
            ->assertJson(['data' => ['available_seats_count' => 12]])
            ->assertJsonCount(12, 'data.seats_numbers');
    }

    public function test_book_available_seat_for_the_trip()
    {
        $trip = Trip::first();
        $from = Station::whereName('Cairo')->first();
        $to = Station::whereName('Asyut')->first();
        $seat = $trip->bus->seats()->inRandomOrder()->first()->uuid;
        $this->postJson(route('users.trips.book.available.seat'), TripBooking::factory()->make(['seat_id' => $seat,'from' => $from->id,'to'=>$to->id])->toArray())
            ->assertSuccessful()
            ->assertJsonStructure(['data' => [
                'seat_id', 'id', 'trip', 'bus', 'source', 'destination','user'
            ]])
            ->assertJson([
                'message' => "Congratulations!, Your seat is booked",
                'data' => [
                    'source' => ['id' => $from->id],
                    'destination' => ['id' => $to->id],
                    'trip' => ['id' => $trip->id],
                    'seat_id' => $seat
                ]
            ]);
    }

    public function test_book_not_available_seat_for_the_trip()
    {
        $trip = Trip::first();
        $seat = $trip->bus->seats()->inRandomOrder()->first()->uuid;
        TripBooking::factory()->create(['seat_id' => $seat]);
        $this->postJson(route('users.trips.book.available.seat'), TripBooking::factory()->make(['seat_id' => $seat])->toArray())
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'Sorry, This seat is booked for this trip slot pick anther seat',
            ]);
    }

    public function test_booked_seat_with_intersections_and_busy()
    {
        $trip = Trip::first();
        $seats = $trip->bus->seats;
        $this->insertSomeBookings($seats);
        $this->postJson(route('users.trips.book.available.seat'), TripBooking::factory()->make([
            'seat_id' => $seats[1]->uuid ,
            'from'=>Station::whereName('Cairo')->first()->id ,
            'to' => Station::whereName('AlMinya')->first()->id
        ])->toArray())
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'Sorry, This seat is booked for this trip slot pick anther seat',
            ]);
    }

    public function test_booked_seat_with_intersections_and_will_be_available_for_booking()
    {
        $trip = Trip::first();
        $seats = $trip->bus->seats;
        $this->insertSomeBookings($seats);
        $this->postJson(route('users.trips.book.available.seat'), TripBooking::factory()->make([
            'seat_id' => $seats[0]->uuid ,
            'from'=>Station::whereName('AlFayyum')->first()->id ,
            'to' => Station::whereName('AlMinya')->first()->id
        ])->toArray())
            ->assertSuccessful()
            ->assertJsonStructure(['data' => [
                'seat_id', 'id', 'trip', 'bus', 'source', 'destination','user'
            ]])
            ->assertJson([
                'message' => "Congratulations!, Your seat is booked",
                'data' => [
                    'source' => ['id' => Station::whereName('AlFayyum')->first()->id],
                    'destination' => ['id' => Station::whereName('AlMinya')->first()->id],
                    'trip' => ['id' => $trip->id],
                    'seat_id' => $seats[0]->uuid
                ]
            ]);
    }

}
