<?php
namespace App\Services\Booking;
use App\Models\Trip;
use App\Models\TripStop;

class AvailableSeatsForBooking
{
    /**
     * This Function Gets Bus Available Seats For The User Start and End Station
     * returns unbooked seats.
     * @param $start_station_id
     * @param $end_station_id
     * @param $trip_id
     * @return array
     */
    public function all($start_station_id, $end_station_id, $trip_id): array
    {
        $trip = Trip::with('bookings', 'stops', 'bus.seats')->find($trip_id);
        $stops = TripStop::whereIn('station_id', [$start_station_id, $end_station_id])->get();
        $start = $stops->where('station_id', $start_station_id)->first();
        $end = $stops->where('station_id', $end_station_id)->first();
        $unAvailableSeats = [];

        // close booked seats
        foreach ($trip->bookings as $booking) {
            $booking_source_station = $trip->stops->where('station_id', $booking->from)->first();
            $booking_destination_station = $trip->stops->where('station_id', $booking->to)->first();
            $has_intersection = ($start->order >= $booking_source_station->order && $start->order < $booking_destination_station->order)
                ||
                ($end->order > $booking_source_station->order && $end->order <= $booking_destination_station->order)
                ||
                ($start->order <= $booking_source_station->order && $end->order >= $booking_destination_station->order);

            if ($has_intersection) {
                $unAvailableSeats[] = $booking->seat_id;
            }
        }
        return $trip->bus->seats->whereNotIn('uuid', $unAvailableSeats)->pluck('uuid')->toArray();
    }

    /**
     * Checks if User Given Seat ID is Free for the required trip or not
     * @param $start_station_id
     * @param $end_station_id
     * @param $trip_id
     * @param $seat_id
     * @return bool
     */
    public function check($start_station_id, $end_station_id, $trip_id , $seat_id): bool
    {
        return collect($this->all($start_station_id, $end_station_id, $trip_id))->contains($seat_id);
    }
}
