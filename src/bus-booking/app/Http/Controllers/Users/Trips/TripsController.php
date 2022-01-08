<?php

namespace App\Http\Controllers\Users\Trips;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trip\BookSeatRequest;
use App\Http\Requests\Trip\ShowAvailableSeatsRequest;
use App\Http\Resources\Trip\TripBookingResource;
use App\Http\Resources\Trip\TripResource;
use App\Models\Trip;
use App\Models\TripBooking;
use App\Services\Booking\AvailableSeatsForBooking;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TripsController extends Controller
{
    public function index(): JsonResponse
    {
        $trips = Trip::all();
        return $this->apiResponseService->send(TripResource::collection($trips), 'List Of Trips');
    }

    public function show(Trip $trip): JsonResponse
    {
        $trip->load(['bus', 'source_station', 'destination_station', 'stops' => function ($q) {
            $q->with('station')->orderBy('order');
        }]);

        return $this->apiResponseService->send(new TripResource($trip), 'Trip Details');
    }

    public function showAvailableSeats(ShowAvailableSeatsRequest $request, AvailableSeatsForBooking $service): JsonResponse
    {
        $seats = $service->all($request->start_station_id, $request->end_station_id, $request->trip_id);
        return $this->apiResponseService->send(['available_seats_count' => count($seats) ,'seats_numbers'=> $seats]);
    }

    public function bookSeat(BookSeatRequest $request, AvailableSeatsForBooking $service): JsonResponse
    {
        if (!$service->check($request->from, $request->to, $request->trip_id,$request->seat_id)) {
            return $this->apiResponseService->sendMessage('Sorry, This seat is booked for this trip slot pick anther seat', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $booking = TripBooking::create($request->getSanitized());
        return  $this->apiResponseService->send(new TripBookingResource($booking) , 'Congratulations!, Your seat is booked');
    }
}
